<?php


namespace app\admin\controller;

use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthGroup as AuthGroupModel;


class Menu extends Base
{
    /***
     * 菜单列表
     * @return mixed
     */
    public function lists()
    {
        $group = new AuthGroupModel();
        $rule  = new AuthRuleModel();
        $where = [
            'deleted' => 0,
        ];
        if ($this->_user['id'] == 1 && $this->_user['username'] == 'admin') {
            //获取所有权限
            $lists = $rule->cate_tree($where);
        } else {
            //查询权限列表
            $rules = $group->where('id', $this->_user['role_id'])->column('rules');
            if(empty($rules)){
                $this->redirect('Admin/login');
            }
            $arr   = explode(',', $rules[0]);
            $where['id'] = ['in',$arr];
            $lists = $rule->cate_tree($where);
        }
        $this->assign('lists',$lists);
        return $this->fetch();
    }

    /***
     * 修改菜单状态
     * @param string $id    菜单ID
     * @param int $status   状态
     * @param string $name  菜单名
     */
    public function change_status($id = '', $status = 0, $name ='')
    {
        $this->check_authority();
        if(empty($id) || empty($name))
            $this->error('参数错误','');
        $auth_rule = new AuthRuleModel();
        if($status == 0){
            $info = $auth_rule->where(['pid'=>$id,'deleted'=>0,'status'=>1])->find();
            if(!empty($info))
                $this->error('禁用失败!此栏目下还有子栏目~请选删除或禁用子栏目~!');
        }
        $res = $auth_rule->edit(['status' => $status], ['id' => $id]);
        if (!$res) {
            $this->error($status == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str . '菜单:' . $name, $auth_rule->getLastSql());
            $this->success($status == 0 ? '禁用成功' : '启用成功', 'lists');
        }
    }

    /***
     * 删除
     */
    public function del($id = '', $name = '')
    {
        $this->check_authority();
        if(empty($id) || empty($name))
            $this->error('参数错误');
        $auth_rule = new AuthRuleModel();
        $info = $auth_rule->where(['pid'=>$id,'deleted'=>0])->find();
        if(!empty($info))
            $this->error('删除失败!此栏目下还有子栏目~请选删除子栏目~!');
        $res = $auth_rule->del(['id'=>$id]);
        if(!$res){
            $this->error('删除失败');
        }else{
            log_write('删除菜单: ' . $name, $auth_rule->getLastSql());
            $this->success('删除菜单成功','lists');
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
        $auth_rule = new AuthRuleModel();
        if($id){
            $info = $auth_rule->where('id',$id)->find();
            $this->assign('info',$info);
        }
        if($this->request->isPost()){
            $rules = [
                ['name','require|length:2,10|chsAlphaNum','菜单名不能为空|菜单长度在2~10个字符之间|菜单名只能为数字,字母和汉字'],
            ];
            $msg   = $this->validate($this->_param, $rules);
            if ($msg !== true) $this->error($msg, '');
            if($id){
                $res = $auth_rule->edit($this->_param,['id'=>$id]);
            }else{
                $res = $auth_rule->add($this->_param);
            }
            if($res !== false){
                $str = $id ? '编辑菜单' : '新增菜单';
                log_write($str.': ' . $this->_param['name'],$auth_rule->getLastSql());
                $this->success($str . '成功','lists');
            }else{
                $this->error($auth_rule->getError());
            }
        }
        $where = [
            'pid' => 0,
            'deleted' => 0,
        ];
        $lists = $auth_rule->where($where)->select();
        $this->assign('lists',$lists);
        return $this->fetch('edit');
    }
}