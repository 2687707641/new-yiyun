<?php


namespace app\api\validate;

use think\Validate;

/***
 * Class Base 验证器基类
 * @package app\api\validate
 */
class Base extends Validate
{
    //定义验证规则
    protected $rule = [
        ['phone', 'require|/^1[34578]\d{9}$/', '手机号不能为空|手机号格式不正确'],
        ['is_exist', 'require|in:0,1'],
        ['password', 'require|length:6,20|confirm', '密码不能为空|密码长度在6~20之间|两次密码不一致'],
        ['code', 'require|number|length:6','验证码不能为空|验证码格式不正确|验证码格式不正确'],
        ['nickname','require|chsAlphaNum|length:4,10|unqiue:user','昵称不能为空|昵称只能为汉字,字母数字的组合|昵称长度在4~10之间|该昵称已存在']
    ];

    //定义验证场景
    protected $scene  = [
        'Code/get_code' => ['phone', 'is_exist'], //获取验证码
        'User/register' => ['phone', 'nickname','password', 'code'], //用户注册
        'User/login' => ['phone','password'=>'require|length:6,20'], //用户登录
    ];

}