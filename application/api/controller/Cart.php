<?php


namespace app\api\controller;

use app\api\model\Cart as CartModel;
use app\admin\model\Book as BookModel;
use think\Session;

/***
 * 购物车相关
 * Class Cart
 * @package app\api\controller
 */
class Cart extends Base
{
    /***
     * 添加商品到购物车
     */
    public function add_to_cart()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        //参数验证
        $rules = [
            ['book_id', 'require|number', '10001|10002'],
            ['number', 'require|/^[+]{0,1}(\d+)$/', '10001|10002']
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        //查询购物车列表
        $cart      = new CartModel();
        $where     = [
            'uid'     => $user_info['id'],
            'book_id' => $this->params['book_id'],
        ];
        $cart_info = $cart->where($where)->find();
        //无该商品就新增,有就只是数量增加
        if (empty($cart_info)) {
            $this->params['uid'] = $user_info['id'];
            $res                 = $cart->add($this->params);
        } else {
            $num = $cart_info['number'] + $this->params['number'];
            $res = $cart->edit(['number' => $num], $where);
        }
        if ($res !== false) {
            $this->return_msg('00000', '添加至购物车成功!');
        } else {
            $this->return_msg('20001', '添加至购物车失败!');
        }
    }

    /***
     * 查看购物车详情
     */
    public function cart_details()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        //查询
        $cart      = new CartModel();
        $where     = [
            'uid' => $user_info['id'],
        ];
        $cart_info = $cart->field('id,book_id,number')->where($where)->select();
        if (empty($cart_info)) $this->return_msg('20004', '无购物车数据', []);
        $res_arr = [];
        $book    = new BookModel();
        //计算总价
        $totol = 0;
        foreach ($cart_info as $k => $v) {
            $res_arr[$k]['id']       = $v['book_id']; //商品ID
            $res_arr[$k]['number']   = $v['number'];//购物车中该商品数量
            $book_info               = $book->where('id', $v['book_id'])->field('name,picture,discount,prince')->find();
            $res_arr[$k]['name']     = $book_info['name']; //商品名称
            $res_arr[$k]['prince']   = $book_info['prince']; //商品单价
            $res_arr[$k]['picture']  = $book_info['picture']; //商品封面图
            $res_arr[$k]['discount'] = $book_info['discount']; //商品折扣
            $totol +=  $res_arr[$k]['prince'] * $res_arr[$k]['discount'] * 0.1 * $res_arr[$k]['number'];
        }
        $res_arr['totol'] = number_format($totol,2);//保留2位小数
        $this->return_msg('00000', '查询成功', $res_arr);
    }

    /***
     * 删除购物车商品
     */
    public function clear_cart()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        //检查参数
        $rules = [
            ['book_id', 'require|number', '10001|10002'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        $cart  = new CartModel();
        $where = [
            'uid'     => $user_info['id'],
            'book_id' => $this->params['book_id'],
        ];
        $res   = $cart->del($where);
        if ($res !== false) {
            $this->return_msg('00000', '删除购物车成功');
        } else {
            $this->return_msg('20003', '删除购物车失败');
        }
    }

    /***
     * 查询购物车商品数量
     */
    public function get_cart_items()
    {
        //获取登录用户信息
        $num        = 0;
        $arr['num'] = $num;
        $user_info  = Session::get('user');
        if (empty($user_info)) $this->return_msg('00000', '用户未登录', $arr);
        $cart = new CartModel();
        $arr['num']  = $cart->where('uid', $user_info['id'])->sum('number');
        $this->return_msg('00000', '查询成功', $arr);
    }
}
