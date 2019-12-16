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
     * @return bool 校验改用户信息结果
     * @throws \think\Exception
     * @throws \think\exception\DbException
     */
    public function login($username, $passoword)
    {
        $info = $this->get(['username' => $username]);
        if (empty($info) || $info->status == 0) {
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
        log_write($username, '登录后台管理系统', $ip);
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

    public function get_data_list($condition)
    {
        $where = '';
        if(isset($condition['username']))
            $where = 'username like \'%' . $condition['username'] . '%\'';
        $order = isset($condition['order']) ? $condition['order'] : 'id asc';
        $page  = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = isset($_GET['limit']) ? $_GET['limit'] : 10;
        $limit = ($page-1) * $offset . ',' .$offset;
        return $this->where($where)->field('password',true)->order($order)->limit($limit)->select();
    }

    public function get_data_count($condition)
    {
        $where = '';
        if(isset($condition['username']))
            $where = 'username like \'%' . $condition['username'] . '%\'';
        return  $this->where($where)->count();
    }
}