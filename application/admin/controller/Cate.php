<?php


namespace app\admin\controller;

use app\admin\model\Cate as CateModel;

class Cate extends Base
{
    /***
     * @return mixed 商品分类页面
     */
    public function lists()
    {
        $cate = new CateModel();
        $where = [
            'deleted' => 0,
        ];
        $lists = $cate->cate_tree($where);
        $this->assign('lists',$lists);
        return $this->fetch();
    }

    /***
     * 修改分类状态
     * @param string $id    分类ID
     * @param int $status   状态
     * @param string $name  分类名
     */
    public function change_status($id = '', $status = 0, $name ='')
    {
        $this->check_authority();
        if(empty($id) || empty($name))
            $this->error('参数错误','');
        $cate = new CateModel();
        if($status == 0){
            $info = $cate->where(['pid'=>$id,'deleted'=>0,'status'=>1])->find();
            if(!empty($info))
                $this->error('禁用失败!此栏目下还有子栏目~请选删除或禁用子栏目~!');
        }
        $res = $cate->edit(['status' => $status], ['id' => $id]);
        if (!$res) {
            $this->error($status == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str . '商品分类:' . $name, $cate->getLastSql());
            $this->success($status == 0 ? '禁用成功' : '启用成功', 'lists');
        }
    }

    /***
     * 删除商品分类
     * @param string $id 分类ID
     * @param string $name 分类名称
     */
    public function del($id = '', $name = '')
    {
        $this->check_authority();
        if(empty($id) || empty($name))
            $this->error('参数错误');
        $cate = new CateModel();
        $info = $cate->where(['pid'=>$id,'deleted'=>0])->find();
        if(!empty($info))
            $this->error('删除失败!此栏目下还有子栏目~请选删除子栏目~!');
        $res = $cate->del(['id'=>$id]);
        if(!$res){
            $this->error('删除失败');
        }else{
            log_write('删除商品分类: ' . $name, $cate->getLastSql());
            $this->success('删除商品分类成功','lists');
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
     * 通用新增删除
     * @param string $id
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
            $rules = [
                ['name','require|length:2,10|chsAlphaNum','分类名不能为空|分类长度在2~10个字符之间|分类名只能为数字,字母和汉字'],
            ];
            $msg   = $this->validate($this->_param, $rules);
            if ($msg !== true) $this->error($msg, '');
            if($id){
                $res = $cate->edit($this->_param,['id'=>$id]);
            }else{
                $res = $cate->add($this->_param);
            }
            if($res !== false){
                $str = $id ? '编辑分类' : '新增分类';
                log_write($str.': ' . $this->_param['name'],$cate->getLastSql());
                $this->success($str . '成功','lists');
            }else{
                $this->error($cate->getError());
            }
        }
        $where = [
            'pid' => 0,
            'deleted' => 0,
        ];
        $lists = $cate->where($where)->select();
        $this->assign('lists',$lists);
        return $this->fetch('edit');
    }
}