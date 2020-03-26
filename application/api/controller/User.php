<?php


namespace app\api\controller;

use app\api\model\User as UserModel;
use think\Log;
use think\Session;

/***
 * Class User 用户相关
 * @package app\api\controller
 */
class User extends Base
{
    /***
     * 用户注册
     */
    public function register()
    {
        //检查参数
        $rules = [
            ['phone', 'require|/^1[34578]\d{9}$/', '手机号不能为空|手机号格式不正确'],
            ['nickname', 'require|chsAlphaNum|length:4,10|unique:user', '昵称不能为空|昵称只能为汉字,字母数字的组合|昵称长度在4~10之间|该昵称已存在'],
            ['password', 'require|length:6,20|confirm', '密码不能为空|密码长度在6~20之间|两次密码不一致'],
            ['code', 'require|number|length:6', '验证码不能为空|验证码格式不正确|验证码格式不正确'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg(400,$msg);
        //检查用户(手机号)是否存在
        $user = new UserModel();
        $res  = $user->check_exist($this->params['phone'], 0);
        if ($res !== true)
            $this->return_msg('400', $res);
        //检查验证码
        $this->check_code($this->params['phone'], $this->params['code']);
        $this->params['password'] = md5($this->params['password']);
        //写入数据库
        $res = $user->add($this->params);
        if ($res !== false) {
            $this->return_msg(200, '用户注册成功!');
        } else {
            $this->return_msg(400, '用户注册失败!');
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
        $last_time = Session::get($phone . '_last_send_time', 'think');
        if ($last_time == null || time() - $last_time > 300)
            $this->return_msg('400', '验证码错误');
        //检查验证码是否正确(一个验证码只使用一次)
        $session_code = Session::pull($phone . '_code', 'think');
        if ($session_code != $code)
            $this->return_msg('400', '验证码错误');
    }

    /***
     * 用户登录
     */
    public function login()
    {
        //检查参数
        $rules = [
            ['phone', 'require|/^1[34578]\d{9}$/', '手机号不能为空|手机号格式不正确'],
            ['password', 'require|length:6,20', '密码不能为空|密码长度在6~20之间'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg(400,$msg);
        $user = new UserModel();
        $info = $user->field('id,phone,password,nickname,address')->where('phone', $this->params['phone'])->find();
        if ($info['password'] !== md5($this->params['password'])) {
            $this->return_msg(400, '用户名或密码不正确!');
        } else {
            unset($info['password']);
            Session::set('user', $info);
            $this->return_msg(200, '登录成功!', $info);
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
        if (empty($session_user))
            $this->return_msg(400, '请登录后操作');
        //检查参数
        $rules = [
            ['used_password', 'require', '原密码不能为空'],
            ['new_password', 'require|length:6,20|confirm', '密码不能为空|密码长度在6~20之间|2次密码不一致'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg(400,$msg);
        //查询用户信息
        $info = $user->field('id,password')->where('phone', $session_user['phone'])->find();
        //校对信息
        if (md5($this->params['used_password']) !== $info['password'])
            $this->return_msg(400, '原密码错误');
        //更新用户信息
        $res = $user->edit(['password' => $this->params['new_password']], ['phone' => $session_user['phone']]);
        if ($res !== false) {
            $this->return_msg(200, '修改密码成功!');
        } else {
            $this->return_msg(400, '修改密码失败!');
        }
    }

    /***
     * 获取登录用户信息
     */
    public function user_info()
    {
        $info = $this->get_user_info();
        $this->return_msg(200, '查看成功!', $info);
    }

    /***
     * 编辑收货地址
     */
    public function receiving_address()
    {
        //获取登录用户
        $info = $this->get_user_info();
//        $info = Session::get('user');
//        if(empty($info)) $this->return_msg(400,'未获取到登录信息,请登录后重试');
        //检查参数
        $rules = [
            ['address', 'require|chsDash', '收货地址不能为空|收货地址只能为为汉字,字母和数字,下划线_及破折号-'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg(400,$msg);
        $user = new UserModel();
        $res = $user->edit(['address'=>$this->params['address']],['id'=>$info['id']]);
        if ($res !== false) {
            $this->return_msg(200, '编辑收货地址成功!');
        } else {
            $this->return_msg(500, '编辑收货地址失败!');
        }
    }

}