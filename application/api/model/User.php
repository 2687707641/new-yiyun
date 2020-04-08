<?php


namespace app\api\model;


class User extends Base
{
    protected $autoWriteTimestamp = 'datetime';

    public function check_exist($phone,$is_exist)
    {
        $res = $this->where('phone',$phone)->find();//存在返回1,不存在返回0
        switch ($is_exist){
            /*         手机号不应该在数据库中        */
            case '0':
                if($res)
                    return '此手机号已被占用!';
                return true;
                break;
            /*        手机号应该在数据库中    */
            case '1' :
                if(!$res)
                    return '此手机号不存在或未注册!';
                return true;
                break;
        }
    }
}