<?php


namespace app\admin\controller;

use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthCompetency as CompetencyModel;
use think\Log;

class Role extends Base
{
    public function lists()
    {
        return $this->fetch();
    }

    /***
     * layui 数据表格接口
     */
    public function get_role_list()
    {
        $auth_group = new AuthGroupModel();
        $this->_condition['where']['deleted'] = 0;
        $this->_condition['with'] = 'manager';
        $data  = $auth_group->get_data_list($this->_condition);
        $count = $auth_group->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
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
     * @param string $id 要修改的ID,不传为新增
     * @return mixed
     */
    public function _edit($id = '')
    {
        $auth_group = new AuthGroupModel();
        $auth_rule = new AuthRuleModel();
        if($this->request->isPost()){
            $this->check_authority();
            $rules = [
                ['role_name','require|length:2,10|unique:auth_group','名称不能为空|名称长度在2~10字符之间|该角色已存在'],
            ];
            $msg = $this->validate($this->_param,$rules);
            if($msg !== true) $this->error($msg,'');
            if (!empty($this->_param['rules'])) {
                $this->_param['rules'] = ',' . implode(',', $this->_param['rules']) . ',';
            }
            if($id){
                $res = $auth_group->edit($this->_param,['id'=>$id]);
            }else{
                $res = $auth_group->add($this->_param);
            }
            if($res !== false){
                $str = $id ? '编辑角色' : '新增角色';
                log_write( $str . ': '. $this->_param['role_name'],$auth_group->getLastSql());
                $this->success($str.'成功','lists');
            }else{
                $this->error($auth_group->getError(),'');
            }
        }
        //获取当前角色菜单栏列表
        $role_id = $this->_user['role_id'];
        if($role_id != 0){
            $rules = $auth_group->where('id',$role_id)->column('rules');
            $rules = explode(',',$rules[0]);
            $lists = $auth_rule->where('id','in',$rules)->select();
        }else{
            $lists = $auth_rule->select();
        }
        $this->assign('lists',$lists);

        if($id){
            $info = AuthGroupModel::get($id)->toArray();
            $info['rules'] = explode(',',$info['rules'] );
            $this->assign('info',$info);
        }
        return $this->fetch('edit');
    }

    /***
     * 删除
     */
    public function del()
    {
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['name']))
            $this->error('参数错误');
        $auth_group = new AuthGroupModel();
        $res     = $auth_group->del(['id' => ['in', $this->_param['id']]]);
        if (!$res) {
            $this->error('删除失败!');
        } else {
            //写入操作日志
            if(is_array($this->_param['name']))
                $this->_param['name'] = implode(',',$this->_param['name']);
            log_write('删除角色:' . $this->_param['name'],$auth_group->getLastSql());
            $this->success('删除成功!', 'lists');
        }
    }

    /***
     * 修改角色状态
     * @param string $id 角色ID
     */
    public function change_status()
    {
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['status']))
            $this->error('参数错误');
        $auth_group = new AuthGroupModel();
        $res     = $auth_group->edit(['status' => $this->_param['status']], ['id' => $this->_param['id']]);
        if (!$res) {
            $this->error($this->_param['status'] == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str .'角色:'. $this->_param['name'],$auth_group->getLastSql());
            $this->success($this->_param['status'] == 0 ? '禁用成功' : '启用成功', 'lists');
        }
    }

    /***
     * 分配权限
     * @param string $id 角色ID
     */
    public function assign_authority()
    {
        if (!isset($this->_param['id']))
            $this->error('参数错误');
        $competency_info = new CompetencyModel();
        $auth_group = new AuthGroupModel();
        if($this->request->isPost()){
            $this->check_authority();
            $rules = [
                ['role_name','require|length:2,10|unique:auth_group','名称不能为空|名称长度在2~10字符之间|该角色已存在'],
            ];
            $msg = $this->validate($this->_param,$rules);
            if($msg !== true) $this->error($msg,'');
            if (!empty($this->_param['competency'])) {
                $this->_param['competency'] = ',' . implode(',', $this->_param['competency']) . ',';
            }
            $res = $auth_group->edit(['competency'=>$this->_param['competency']],['id'=>$this->_param['id']]);
            if($res !== false){
                log_write('更改角色权限:' . $this->_param['role_name'] ,$auth_group->getLastSql());
                $this->success('分配权限成功','lists');
            }else{
                $this->error($auth_group->getError(),'');
            }
        }
        $role_id = $this->_user['role_id'];
        //获取当前登录角色权限
        if($role_id != 0){
            $competency = $auth_group->where('id',$role_id)->column('competency');
            $competency = explode(',',$competency[0]);
            $lists = $competency_info->where('id','in',$competency)->select();
        }else{
            $lists = $competency_info->select();
        }
        //获取编辑角色信息
        $info = AuthGroupModel::get($this->_param['id'])->toArray();
        $info['competency'] = explode(',',$info['competency']);
        $this->assign('info',$info);
        $this->assign('lists',$lists);
        return $this->fetch();
    }
}