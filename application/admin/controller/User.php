<?php


namespace app\admin\controller;

use app\admin\model\User as UserModel;

class User extends Base
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
    public function get_user_list()
    {
        $user = new UserModel();
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $data  = $user->get_data_list($this->_condition);
        $count = $user->get_data_count($this->_condition['where']);
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
        $user = new UserModel();
        $res     = $user->del(['id' => ['in', $this->_param['id']]]);
        if (!$res) {
            $this->error('删除失败!');
        } else {
            //写入操作日志
            if (is_array($this->_param['name']))
                $this->_param['name'] = implode(',', $this->_param['name']);
            log_write('删除用户:' . $this->_param['name'], $user->getLastSql());
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
        $user = new UserModel();
        $res     = $user->edit(['status' => $this->_param['status']], ['id' => $this->_param['id']]);
        if (!$res) {
            $this->error($this->_param['status'] == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str . '管理员:' . $this->_param['name'], $user->getLastSql());
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
     * 通用修改删除
     * @param string $id 无ID为新增,有ID为修改
     * @return mixed
     */
    public function _edit($id = '')
    {
        $user = new UserModel();
        if($this->request->isPost()){
            $this->check_authority();
            $rules = [
                ['nickname','require|length:2,10|unique:user','昵称不能为空|昵称长度应在2~10个字符之间|该昵称已存在'],
                ['phone','require|/^1[3-8]{1}[0-9]{9}$/|unique:user','手机号不能为空|手机号格式不正确|该手机号已被占用'],
                ['password', 'require|length:6,16', '密码不能为空|昵称长度应在6~16字符之间'],
            ];
            $msg = $this->validate($this->_param,$rules);
            if($msg !== true) $this->error($msg, '');
            $this->_param['password'] = md5($this->_param['password']);
            if($id){
                //查询信息
                $info = $user->where('id', $id)->find();
                //判断原密码
                if (md5($this->_param['used_pwd']) != $info['password']) {
                    $this->error('原密码不正确');
                }
                $res = $user->edit($this->_param,['id'=>$id]);
            }else{
                $res = $user->add($this->_param);
            }
            if($res !== false){
                $str = empty($id) ? '创建用户: ' : '编辑用户';
                log_write( $str . $this->_param['nickname'],$user->getLastSql());
                $this->success(empty($id) ? '创建用户成功!' : '编辑用户成功', url('lists'));
            }else{
                $this->error($user->getError(), '');
            }
        }
        if($id){
            $info = $user->where('id',$id)->find();
            $this->assign('info',$info);
        }
        return $this->fetch('edit');
    }

}