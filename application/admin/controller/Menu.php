<?php


namespace app\admin\controller;

use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthGroup as AuthGroupModel;
use think\Log;

class Menu extends Base
{
    /***
     * 菜单列表
     * @return mixed
     */
    public function lists()
    {
        $role_id = $this->_user['role_id'];
        //获取管理员所属角色权限
        $auth_rule = new AuthRuleModel();
        $auth_group = new AuthGroupModel();
        $where = [
            'deleted' => 0,
        ];
        if($role_id != 0){
            $auth_rules = $auth_group->where('id',$role_id)->column('rules');
            $rules = explode(',',$auth_rules[0]);
            $where['id'] =['in',$rules];
            $tree_data = $auth_rule->where($where)->select();
            $lists = $auth_rule->tree($tree_data);
        }else {//超级管理员所有栏目
            $lists = $auth_rule->cate_tree();
        }
        $this->assign('lists',$lists);
        return $this->fetch();
    }


    public function change_status($id = '', $status = 0, $name ='')
    {
        $this->check_authority();
        if(empty($id) || empty($name))
            $this->error('参数错误','');
        $auth_rule = new AuthRuleModel();
        $res = $auth_rule->edit(['status' => $status], ['id' => $id]);
        if (!$res) {
            $this->error($status == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str . '菜单:' . $name, $auth_rule->getLastSql());
            $this->success($status == 0 ? '禁用成功' : '启用成功', 'lists');
        }
    }
    
}