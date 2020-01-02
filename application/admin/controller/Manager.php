<?php


namespace app\admin\controller;

use app\admin\model\Manager as ManagerModel;
use app\admin\model\AuthGroup as AuthGroupModel;


class Manager extends Base
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
    public function get_manager_list()
    {
        $manager = new ManagerModel();
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $this->_condition['with'] = 'role';
//        //非超级管理员只能看到自己
//        if($this->_user['id'] != 1 || $this->_user['username'] != 'admin'){
//            $this->_condition['where']['id'] = $this->_user['id'];
//        }
        $data  = $manager->get_data_list($this->_condition);
        $count = $manager->get_data_count($this->_condition['where']);
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
        $manager = new ManagerModel();
        $res     = $manager->del(['id' => ['in', $this->_param['id']]]);
        if (!$res) {
            $this->error('删除失败!');
        } else {
            //写入操作日志
            if (is_array($this->_param['name']))
                $this->_param['name'] = implode(',', $this->_param['name']);
            log_write('删除管理员:' . $this->_param['name'], $manager->getLastSql());
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
        $manager = new ManagerModel();
        $res     = $manager->edit(['status' => $this->_param['status']], ['id' => $this->_param['id']]);
        if (!$res) {
            $this->error($this->_param['status'] == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str . '管理员:' . $this->_param['name'], $manager->getLastSql());
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

        $manager = new ManagerModel();
        if ($this->request->isPost()) {
            //验证权限
            $this->check_authority();
            $rules = [
                ['username', 'require|length:5,10|alphaNum|unique:manager', '登录名不能为空|登录名长度应在5~10字符之间|登录名只能包含字母数字|该用户已存在'],
                ['nickname', 'require|length:3,8|chsAlphaNum|unique:manager', '昵称不能为空|昵称长度应在2~5字符之间|昵称只能包含汉字、字母和数字|该昵称已被占用'],
                ['password', 'require|length:6,16', '密码不能为空|昵称长度应在6~16字符之间'],
            ];
            $msg   = $this->validate($this->_param, $rules);
            if ($msg !== true) $this->error($msg, '');
            $this->_param['password'] = md5($this->_param['password']);
            if ($id) {
                //查询信息
                $info = $manager->where('id', $id)->find();
                //判断原密码
                if (md5($this->_param['used_pwd']) != $info['password']) {
                    $this->error('原密码不正确');
                }
                $res = $manager->edit($this->_param, ['id' => $id]);
            } else {
                $res = $manager->add($this->_param);
            }
            if ($res !== false) {
                //生成操作记录
                $str = empty($id) ? '创建管理员: ' : '编辑管理员';
                log_write($str . $this->_param['username'], $manager->getLastSql());
                $this->success(empty($id) ? '创建管理员成功!' : '编辑管理员成功', url('lists'));
            } else {
                $this->error($manager->getError(), '');
            }
        }
        $auth_group = new AuthGroupModel();
        $role_list  = $auth_group->where(['status' => 1, 'deleted' => 0])->field('id,role_name')->select();
        $this->assign('role_list', $role_list);
        if ($id) {
            $info = $manager->where('id', $id)->find();
            $this->assign('info', $info);
        }
        return $this->fetch('edit');
    }

}