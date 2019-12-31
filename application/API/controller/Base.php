<?php


namespace app\API\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{

    public function __construct(Request $request)
    {
        // 指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');  //支持全域名访问
        header('Access-Control-Allow-Methods:POST,GET'); //支持的http动作
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 1000');
        header('Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept, Authorization, token, App-Id');  //响应头 请按照自己需求添加。
        if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
            exit;
        }
        // 请求方式检测
        $this->request = $request;
        $this->method = strtolower($request->method());
        $this->params = $this->request->param();
    }
}