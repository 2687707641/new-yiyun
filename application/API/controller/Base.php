<?php


namespace app\API\controller;

use think\Controller;
use think\Log;
use think\Request;


class Base extends Controller
{
    //定义公用参数
    protected $validater; //用来验证参数
    protected $params; //过滤后符合要求的参数

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
//        $this->method  = strtolower($request->method());
        Log::info('------',print_r($request->getInput(),true));
        $this->params = $this->check_params($request->param());
    }

    /***
     *返回信息
     * @param $code 状态码
     * @param string $msg 提示语
     * @param array $data 返回数据
     */
    public function return_msg($code, $msg = '', $data = [])
    {
        //组合数据
        $result['code'] = $code;
        $result['msg']  = $msg;
        $result['data'] = $data;
        //返回数据,并终止脚本
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
        die;
    }

    /***
     * @param $arr 接收参数
     * @return mixed 验证后的参数
     */
    public function check_params($arr)
    {
        //获取验证场景(验证器.控制器/方法)
        $sence  = 'Base.' . $this->request->controller() . '/' . $this->request->action();
        if($sence == 'Base.User/look_session')
            return $arr;
        $this->validater = $this->validate($arr, $sence);
        if (true !== $this->validater) {
            $this->return_msg('400', $this->validater);
        }
        return $arr;
    }
}