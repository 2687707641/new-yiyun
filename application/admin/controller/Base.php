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
    //筛选条件(LayUI表格用)
    protected $_condition = [];
    
    //初始化加载
    public function _initialize()
    {
        //检查session(用户是否处于登录状态)
        $this->_user = is_login();
        //读取菜单
        $this->get_menu();
        //获取参数
        $this->_param = $this->request->param();
        $this->_map   = $this->request->get();
        $this->_condition = $this->get_condition();
        //将公用数据分配至所有页面
        $this->assign('user', $this->_user); //当前登录用户
        $this->assign('_self_', $this->request->url()); //当前页面对应控制器
    }

    //读取左侧菜单列表
    public function get_menu()
    {
        //获取当前用户(管理员)信息
        $auth_info = Session::get('auth_info', 'think');
        if (empty($auth_info)) {
            $this->redirect('Admin/login');
        }
        $group = new AuthGroupModel();
        $rule  = new AuthRuleModel();
        $where = [
            'deleted' => 0,
            'status' => 1,
        ];
        if ($auth_info['id'] == 1 && $auth_info['username'] == 'admin') {
            //获取所有权限
            $menu = $rule->cate_tree($where);
        } else {
            //查询权限列表
            $rules = $group->where('id', $auth_info['role_id'])->column('rules');
            if(empty($rules)){
                $this->redirect('Admin/login');
            }
            $arr   = explode(',', $rules[0]);
            $where['id'] = ['in',$arr];
            $menu = $rule->cate_tree($where);
        }
        if (empty($menu)) {
            $this->redirect('Admin/login');
        }
        $this->assign('menu', $menu);
    }

    /***
     * @return bool 权限检查结果
     */
    public function check_authority()
    {
        $url = $this->request->controller() . '/' . $this->request->action(); //请求方法
        //获取当前用户(管理员)信息
        $auth_info = Session::get('auth_info', 'think');
        if (empty($auth_info)) {
            //重定向至登录界面
            $this->redirect('Admin/login');
        }
        if ($auth_info['id'] == 1 && $auth_info['username'] == 'admin') {
            return true;
        }
        //查询规则信息
        $competency      = new AuthComModel();
        $where = [
            'url' => $url,
            'status' => 1,
            'deleted' => 0,
        ];
        $competency_info = $competency->where($where)->find();
        if (empty($competency_info)) $this->error('权限不足,操作失败');
        //查询当前角色信息
        $role      = new AuthGroupModel();
        $role_info = $role->where('id', $auth_info['role_id'])->find();
        $arr       = explode(',', $role_info->competency);
        //判断是否拥有权限
        foreach ($arr as $k => $v) {
            if ($v == $competency_info->id)
                return true;
        }
        $this->error('权限不足,操作失败');
    }

    /***
     * 获取过滤条件
     * @return array 过滤条件
     */
    public function get_condition()
    {
        $where  = array();
        $page   = 1;
        $offset = 10;
        $order = 'id desc';
        $between_time = ['1970-01-01','9999-12-30'];
        foreach ($this->_map as $k => $v) {
            switch ($k) {
                case 'page' :
                    $page = $v;
                    break;
                case 'limit' :
                    $offset = $v;
                    break;
                case 'order':
                    $order = $v;
                    break;
                case 'start':
                   if (!empty($v)) $between_time[0] = $v;
                    break;
                case 'end':
                    if (!empty($v)) $between_time[1] = $v;
                    break;
                case 'username':
                    $where['username'] = ['like','%' . $v . '%'];
                    break;
                case 'role_name':
                    $where['role_name'] = ['like','%' . $v . '%'];
                    break;
                case 'name':
                    if(is_array($v)) break;
                    $where['name'] = ['like','%' . $v . '%'];
                    break;
            }
        }
        $where['create_time'] = ['between time',$between_time];
        $limit = ($page - 1) * $offset . ',' . $offset;
        $condition = array(
            'where' => $where, //过滤条件
            'order' => $order, //排序
            'limit' => $limit, //分页参数
            'with'  => '',     //关联
        );
        return $condition;
    }

}