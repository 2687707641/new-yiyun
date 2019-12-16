<?php


namespace app\admin\controller;

use app\admin\model\AuthRule;
use think\Controller;
use app\admin\model\AuthGroup as AuthGroupModel;
use app\admin\model\AuthRule as AuthRuleModel;
use app\admin\model\AuthCompetency as AuthComModel;
use think\Log;
use think\Session;

/**
 * 控制器基类
 * Class Base
 * @package app\admin\controller
 */
class Base extends Controller
{
    //定义公共参数
    protected $_user = []; //当前登录对象
    protected $_param = []; //post参数及get参数
    protected $_map = []; //get参数
    protected $_row = 10; //分页初始条数

    //初始化加载
    public function _initialize()
    {
        //检查session(用户是否处于登录状态)
        $this->_user = is_login();
        //读取菜单
        $this->get_menu();
        //获取参数
        $this->_param = $this->request->param();
        $this->_map = $this->request->get();
        //将公用数据分配至所有页面
        $this->assign('user',$this->_user); //当前登录用户
        $this->assign('_self_', $this->request->url()); //当前页面对应控制器
    }

    //读取左侧菜单列表
    public function get_menu()
    {
        //获取当前用户(管理员)信息
        $auth_info = Session::get('auth_info', 'think');
        if(empty($auth_info)){
            $this->redirect('Admin/login');
        }
        $group = new AuthGroupModel();
        $rule  = new AuthRuleModel();
//        Log::write('登录用户信息: ' . print_r($auth_info,true));
        if ($auth_info['id'] == 1 && $auth_info['username'] == 'admin') {
            //获取所有权限
            $menu = $rule->cate_tree();
        } else {
            //查询权限列表
            $rules = $group->where('id', $auth_info['role_id'])->column('rules');
            $arr   = explode(',', $rules[0]);
            $menu = $rule->where('id', 'in', $arr)->select();
        }
        if(empty($menu)){
            $this->redirect('Admin/login');
        }
        $this->assign('menu', $menu);
    }

    //读取权限
    public function get_rule()
    {
        //获取当前用户(管理员)信息
        $auth_info = Session::get('auth_info', 'think');
        if (empty($auth_info)) {
            //重定向至登录界面
            $this->redirect('Admin/login');
        }
        if ($auth_info['id'] == 1 && $auth_info['username'] == 'admin') {
            return true;
        } else {
            //检查权限

        }
    }
}