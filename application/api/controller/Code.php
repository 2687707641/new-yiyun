<?php


namespace app\api\controller;

use qcloudsms\SmsSingleSender;
use app\api\model\User;
use think\Session;

/***
 * Class Code 验证码相关
 * @package app\api\controller
 */
class Code extends Base
{
    protected $num = 6; // 验证码长度

    /***
     * 获取验证码
     */
    public function get_code()
    {
        $data = $this->request->param();
        //验证参数
        $rules = [
            ['phone', 'require|/^1[34578]\d{9}$/', '10001|10002'],
            ['is_exist', 'require|in:0,1','10001|10002'],
        ];
        $msg   = $this->validate($data, $rules);
        if ($msg !== true) $this->return_msg($msg,'参数错误');
        //检查手机号是否存在
        $user = new User();
        $res  = $user->check_exist($data['phone'], $data['is_exist']);
        if ($res !== true)
            $this->return_msg('10000', $res);
        //检查发送频率
        $last_send_time = Session::get($data['phone'] . '_last_send_time','think');
        if($last_send_time !== null && time()-$last_send_time<= 60)
            $this->return_msg('10000','验证码60s发送一次');
        //发送验证码
        $code = $this->make_code($this->num);
        $this->send_code($data['phone'], $code);
    }

    /***
     * 生成验证码
     * @param $num 验证码长度
     * @return int 生成的验证码
     */
    public function make_code($num)
    {
        $max = pow(10, $num) - 1; //999999
        $min = pow(10, $num - 1); //100000
        return rand($min, $max);
    }

    /***
     * 发送验证码
     * @param $phone 手机号
     * @param $code 验证码
     * @return 返回的json信息串
     */
    public function send_code($phone, $code)
    {
        /*使用腾讯云SDK发送手机验证码*/
        $message = new SmsSingleSender();
        $msg     = $code . '为您此次的验证码，请于5分钟内填写。如非本人操作，请忽略本短信。';
        $result  = json_decode($message->send(0, '86', $phone, $msg));
        if ($result->result != 0) {
            $this->return_msg('10000', $result->errmsg);
        } else {
            //存储验证码及发送时间
            Session::set($phone . '_code', $code, 'think');
            Session::set($phone . '_last_send_time', time(), 'think');
            $this->return_msg('00000', '验证码已发送,60秒内只能发送一次');
        }
    }
}