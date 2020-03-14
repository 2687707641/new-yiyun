<?php


namespace app\admin\controller;

use app\admin\model\Book as BookModel;
use app\admin\model\Cate as CateModel;

class Book extends Base
{
    /***
     * 展示页面
     */
    public function lists()
    {
        return $this->fetch();
    }

    /***
     * layui 数据表格接口
     */
    public function get_book_list()
    {
        $book = new BookModel();
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $this->_condition['with'] = 'cate';
        $data  = $book->get_data_list($this->_condition);
        $count = $book->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
    }

    /***
     * 删除
     */
    public function del()
    {
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['name']))
            $this->error('参数错误');
        $book = new BookModel();
        $res     = $book->del(['id' => ['in', $this->_param['id']]]);
        if (!$res) {
            $this->error('删除失败!');
        } else {
            //写入操作日志
            if (is_array($this->_param['name']))
                $this->_param['name'] = implode(',', $this->_param['name']);
            log_write('删除商品:' . $this->_param['name'], $book->getLastSql());
            $this->success('删除成功!', 'lists');
        }
    }

    /***
     * 修改状态
     */
    public function change_status()
    {
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['status']))
            $this->error('参数错误');
        $book = new BookModel();
        $res     = $book->edit(['status' => $this->_param['status']], ['id' => $this->_param['id']]);
        if (!$res) {
            $this->error($this->_param['status'] == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str . '商品:' . $this->_param['name'], $book->getLastSql());
            $this->success($this->_param['status'] == 0 ? '禁用成功' : '启用成功', 'lists');
        }
    }

    public function add()
    {
        return $this->_edit();
    }

    public function edit($id)
    {
        return $this->_edit($id);
    }

    /***
     * 通用新增修改
     * @param string $id 无ID为新增,有ID为修改
     * @return mixed
     */
    public function _edit($id = '')
    {
        $book = new BookModel();
        if($id){
            $info = $book->where('id',$id)->find();
            $this->assign('info',$info);
        }
        if($this->request->isPost()){
            $this->check_authority();
            $rules = [
                ['name','require|length:2,25|unique:book','商品名不能为空|商品名称长度在2~25个字符之间|该商品已存在'],
                ['prince','require|float|between:0,999999999','商品价格不能为空|商品价格错误|商品价格不能为负数'],
                ['number','require|/^[+]{0,1}(\d+)$/','商品数量不能为空|商品数量只能为正整数'],
            ];
            $msg   = $this->validate($this->_param, $rules);
            if ($msg !== true) $this->error($msg, '');
            if($id){
                $res = $book->edit($this->_param,['id'=>$id]);
            }else{
                $res = $book->add($this->_param);
            }
            if($res !== false){
                $str = $id ? '编辑商品信息' : '新增商品信息';
                log_write($str.': ' . $this->_param['name'],$book->getLastSql());
                $this->success($str . '成功','lists');
            }else{
                $this->error($book->getError());
            }
        }
        $cate = new CateModel();
        $where = [
            'pid' => 0,
            'deleted' => 0,
        ];
        $lists = $cate->where($where)->select();
        $this->assign('lists',$lists);
        return $this->fetch('edit');
    }
}