<?php


namespace app\admin\controller;

use app\admin\model\Manager as ManagerModel;
use think\Controller;
use think\Session;

class Admin extends Controller
{
    /***
     * 清空session
     */
    public function clear_session()
    {
        Session::clear();
    }
    

    //登录页面
    public function login($msg = '')
    {
        if(!empty($msg)){
            echo "<script>".chr(10);
            echo "alert(\"{$msg}\");".chr(10);
            echo "</script>".chr(10);
        }
        if($this->request->isPost()){
            $rules = [
                ['username','require|length:5,12','登录名不能为空|登录名在5~12字符之间'],
                ['password','require|length:6,16','密码不能为空|密码长度为6~16字符之间']
            ];
            $msg = $this->validate($this->request->post(),$rules);
            if($msg !== true) $this->error($msg);
            $manager = new ManagerModel();
            $res = $manager->login($this->request->post('username'),$this->request->post('password'));
            if($res === false){
                $this->error($manager->getError(),'');
            }else{
                $this->success('登录成功','');
            }
        }else{
            return $this->fetch();
        }
    }
}