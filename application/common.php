<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/***
 * 写入操作日志
 */
function log_write($action,$details='')
{
    $user = is_login();
    $ip =  \think\Request::instance()->ip();
    $time = date('Y-m-d H-i-s', time());
    $res  = \app\admin\model\Logs::insert(['username' => $user['username'], 'action' => $action, 'ip_addr' => $ip, 'create_time' => $time,'details'=>$details]);
    if (!$res) return false;
}

/***
 * 检查登录状态
 */
function is_login()
{
    $user = session('auth_info');
    if (empty($user)) {
        redirect('index.php/admin/admin/login');
    } else {
        return $user;
    }
}

/***
 * LayUI数据表格接口输出
 * @param string $msg 提示信息
 * @param array $data 数据
 * @param int $count 数据长度
 * @param int $code 状态码
 */
function response_json($msg = '', $data = [], $count = 0, $code = 0)
{
    $result = array(
        'code' => $code,
        'msg'  => $msg,
        'count'  => $count,
        'data' => $data
    );
    echo json_encode($result);
}


