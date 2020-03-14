<?php


namespace app\admin\controller;

use app\admin\model\Cate as CateModel;

class Cate extends Base
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
    public function get_cate_list()
    {
        $cate = new CateModel();
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $data  = $cate->get_data_list($this->_condition);
        $count = $cate->get_data_count($this->_condition['where']);
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
        $cate = new CateModel();
        $res     = $cate->del(['id' => ['in', $this->_param['id']]]);
        if (!$res) {
            $this->error('删除失败!');
        } else {
            //写入操作日志
            if (is_array($this->_param['name']))
                $this->_param['name'] = implode(',', $this->_param['name']);
            log_write('删除分类:' . $this->_param['name'], $cate->getLastSql());
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
        $cate = new CateModel();
        $res     = $cate->edit(['status' => $this->_param['status']], ['id' => $this->_param['id']]);
        if (!$res) {
            $this->error($this->_param['status'] == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str . '商品分类:' . $this->_param['name'], $cate->getLastSql());
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
        $cate = new CateModel();
        if($id){
            $info = $cate->where('id',$id)->find();
            $this->assign('info',$info);
        }
        if($this->request->isPost()){
            $this->check_authority();
            $rules = [
                ['name','require|length:2,10|chsAlphaNum','菜单名不能为空|菜单长度在2~10个字符之间|菜单名只能为数字,字母和汉字'],
            ];
            $msg   = $this->validate($this->_param, $rules);
            if ($msg !== true) $this->error($msg, '');
            if($id){
                $res = $cate->edit($this->_param,['id'=>$id]);
            }else{
                $res = $cate->add($this->_param);
            }
            if($res !== false){
                $str = $id ? '编辑商品分类' : '新增商品分类';
                log_write($str.': ' . $this->_param['name'],$cate->getLastSql());
                $this->success($str . '成功','lists');
            }else{
                $this->error($cate->getError());
            }
        }
        return $this->fetch('edit');
    }
}