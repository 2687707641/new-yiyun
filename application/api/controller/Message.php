<?php


namespace app\api\controller;

/***
 * 商品留言相关
 * Class Message
 * @package app\api\controller
 */
class Message extends Base
{
    /***
     * 发表评论
     */
    public function leave_message()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        //检查参数
        $rules = [
            ['book_id', 'require|number', '10001|10002'],
            ['pid', 'require|number', '10001|10002'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
    }
    
}