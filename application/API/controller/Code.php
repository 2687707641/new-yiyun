<?php


namespace app\api\controller;

use qcloudsms\SmsSingleSender;
use app\api\model\User;
use think\Session;

class Code extends Base
{
    protected $num = 6; // 验证码长度

    /***
     * 获取验证码
     */
    public function get_code()
    {
        //检查手机号是否存在
        $user = new User();
        $res  = $user->check_exist($this->params['phone'], $this->params['is_exist']);
        if ($res !== true)
            $this->return_msg('400', $res);
        //检查发送频率
        $last_send_time = Session::get($this->params['phone'] . '_last_send_time','think');
        if($last_send_time !== null && time()-$last_send_time<= 60)
            $this->return_msg('400','验证码60s发送一次');
        //发送验证码
        $code = $this->make_code($this->num);
        $this->send_code($this->params['phone'], $code);
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
            $this->return_msg(400, $result->errmsg);
        } else {
            //存储验证码及发送时间
            Session::set($phone . '_code', $code, 'think');
            Session::set($phone . '_last_send_time', time(), 'think');
            $this->return_msg(200, '验证码已发送,60秒内只能发送一次');
        }
    }
}