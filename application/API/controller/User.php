<?php


namespace app\api\controller;

use app\api\model\User as UserModel;
use think\Log;
use think\Session;

class User extends Base
{
    /***
     * 用户注册
     */
    public function register()
    {
        //检查用户(手机号)是否存在
        $user = new UserModel();
        $res = $user->check_exist($this->params['phone'],0);
        if($res !== true)
            $this->return_msg('400',$res);
        //检查验证码
        $this->check_code($this->params['phone'],$this->params['code']);
        $this->params['password'] = md5($this->params['password']);
        //写入数据库
        $res = $user->add($this->params);
        if($res !== false){
            $this->return_msg(200,'用户注册成功!');
        }else{
            $this->return_msg(400,'用户注册失败!');
        }
    }

    /***
     * 检查验证码
     * @param $phone 用户手机号
     * @param $code 收到的验证码
     */
    public function check_code($phone, $code)
    {
        //检查是否超时
        $last_time = Session::get($phone . '_last_send_time','think');
        if($last_time == null || time()-$last_time > 300)
            $this->return_msg('400','验证码错误');
        //检查验证码是否正确(一个验证码只使用一次)
        $session_code = Session::pull($phone . '_code','think');
        if($session_code != $code)
            $this->return_msg('400','验证码错误');
    }

    /***
     * 用户登录
     */
    public function login()
    {
        $user = new UserModel();
        $info = $user->field('id,phone,password,nickname')->where('phone',$this->params['phone'])->find();
        if($info['password'] !== md5($this->params['password'])){
            $this->return_msg(400,'用户名或密码不正确!');
        }else{
            unset($info['password']);
            Session::set('user',$info);
            $this->return_msg(200,'登录成功!',$info);
        }
    }

    /***
     * 用户修改密码
     */
    public function change_pwd()
    {
        $user = new UserModel();
        //获取登录用户
        $session_user = Session::get('user');
        if(empty($session_user))
            $this->return_msg(400,'请登录后操作');
        //查询用户信息
        $info = $user->field('id,password')->where('phone',$session_user['phone'])->find();
        //校对信息
        if(md5($this->params['user_pwd']) !== $info['password'])
            $this->return_msg(400,'原密码错误');
        //更新用户信息
        $res = $user->edit(['password'=>$this->params['new_password']],['phone'=>$session_user['phone']]);
        if($res !== false){
            $this->return_msg(200,'修改密码成功!');
        }else{
            $this->return_msg(400,'修改密码失败!');
        }
    }

    public function look_session()
    {
        $info = Session::get('user');
        Log::info('----',print_r($info,true));
        $this->return_msg(200,'查看成功!',$info);
    }
}