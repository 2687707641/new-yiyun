<?php


namespace app\admin\model;

use think\Session;

class Manager extends Base
{
    protected $autoWriteTimestamp = 'datetime';

    /***
     * 登录
     * @param $username 登录名
     * @param $passoword 密码
     * @return bool 校验当前用户信息结果
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($username, $passoword)
    {
        $info = $this->get(['username' => $username]);
        if (empty($info) || $info->status == 0 || $info->deleted == 1) {
            $this->error = '该用户不存在或被禁用!';
            return false;
        }
        if ($info['password'] !== md5($passoword)) {
            $this->error = '用户名或密码错误,请确认!';
            return false;
        }
        $info = $info->toArray();
        $info['login_times']++;
        $ip   = request()->ip();
        $time = date('Y-m-d,H-i-s', time());
        $this->edit(['login_times' => $info['login_times'], 'login_ip' => $ip, 'last_login_time' => $time], ['id' => $info['id']]);
        $this->remember_login_info($info);
        log_write('登录后台管理系统',$this->getLastSql());
        return true;
    }

    /***
     * @param $info 用户信息
     */
    public function remember_login_info($info)
    {
        unset($info['password']);
        Session::set('auth_info', $info);
    }

    /***
     * 关联角色名
     * @return \think\model\relation\BelongsTo
     */
    public function role()
    {
        $where = [
            'deleted' => 0,
        ];
        return $this->belongsTo('AuthGroup','role_id','id')->where($where)->bind('role_name');
    }

}