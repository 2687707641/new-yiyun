<?php


namespace app\api\controller;

use app\api\model\Message as MessageModel;
use app\api\model\User;
use app\api\model\OrderDetails;
/***
 * 商品留言相关
 * Class Message
 * @package app\api\controller
 */
class Message extends Base
{
    //定义敏感词
    private $sensitive_words = [
        'fuck', '艹', 'cao', '操', 'ma', '妈', 'si', '死'
    ];

    /***
     * 敏感词替换
     * @param $list 敏感词组
     * @param $string 检查字符串
     * @return string 替换后的字符串
     */
    private function replace_words($list, $string)
    {
        $count         = 0; //违规词的个数
        $sensitiveWord = ''; //违规词
        $stringAfter   = $string; //替换后的内容
        $pattern       = "/" . implode("|", $list) . "/i"; //定义正则表达式
        if (preg_match_all($pattern, $string, $matches)) { //匹配到了结果
            $patternList   = $matches[0]; //匹配到的数组
            $count         = count($patternList);
            $sensitiveWord = implode(',', $patternList); //敏感词数组转字符串
            $replaceArray  = array_combine($patternList, array_fill(0, count($patternList), '*')); //把匹配到的数组进行合并，替换使用
            $stringAfter   = strtr($string, $replaceArray); //结果替换
        }
        return $stringAfter;
    }

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
            ['message', 'require|max:200', '10001|10002'],
            ['stars', 'require|number|between:1,5', '10001|10002|10002'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        //购物后才能评论
        $order_details = new OrderDetails();
        $where = [
            'book_id' => $this->params['book_id'],
            'user_id' => $user_info['id'],
        ];
        $wheter_to_buy = $order_details->where($where)->find();
        if(empty($wheter_to_buy)) $this->return_msg('10000','未购买不能评论');
        $this->params['message'] = $this->replace_words($this->sensitive_words, $this->params['message']);
        $message                 = new MessageModel();
        $this->params['uid']     = $user_info['id'];
        $res                     = $message->add($this->params);
        if ($res !== false) {
            $this->return_msg('00000', '评论成功!');
        } else {
            $this->return_msg('20001', '评论失败!');
        }
    }

    /***
     * 查看商品评论
     */
    public function view_message()
    {
        //检查参数
        $rules = [
            ['book_id', 'require|number', '10001|10002'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        $order = 'create_time desc';
        if(isset($this->params['order'])){
            if($this->params['order']!= 'desc' && $this->params['order']!= 'asc') $this->return_msg('10002', '参数错误');
            $order = 'create_time ' . $this->params['order'];
        }
        $message = new MessageModel();
        $message_info = $message->where('book_id',$this->params['book_id'])->order($order)->select();
        if (empty($message_info)) $this->return_msg('20004', '无相关评论', []);
        $res_arr = [];
        $user =new User();
        foreach ($message_info as $k => $v) {
            $res_arr[$k]['id'] = $v['id'];//评论ID
            $res_arr[$k]['message'] = $v['message'];//评论ID
            $res_arr[$k]['create_time'] = $v['create_time'];//评论时间
            $res_arr[$k]['stars'] = $v['stars'];//评论星级
            $user_info = $user->where('id',$v['uid'])->find();
            $res_arr[$k]['user_name'] = $user_info['nickname']; //评论用户昵称
        }
        $this->return_msg('00000','查询成功',$res_arr);
    }

}