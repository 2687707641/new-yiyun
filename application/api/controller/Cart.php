<?php


namespace app\api\controller;

use app\api\model\Cart as CartModel;
use app\admin\model\Book as BookModel;

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
            ['book_id', 'require|number', '商品ID不能为空|参数错误'],
            ['number', 'require|/^[+]{0,1}(\d+)$/', '商品数量不能为空|商品数量只能为正整数']
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg(400, $msg);
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
            $this->return_msg(200, '添加至购物车成功!');
        } else {
            $this->return_msg(500, '添加至购物车失败!');
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
        if(empty($cart_info)) $this->return_msg(400,'无购物车数据',[]);
        $res_arr   = [];
        $book      = new BookModel();
        foreach ($cart_info as $k => $v) {
            $res_arr[$k]['id']       = $v['id']; //商品ID
            $res_arr[$k]['number']   = $v['number'];//购物车中该商品数量
            $book_info               = $book->where('id', $v['id'])->field('name,picture,discount')->find();
            $res_arr[$k]['name']     = $book_info['name']; //商品名称
            $res_arr[$k]['picture']  = $book_info['picture']; //商品封面图
            $res_arr[$k]['discount'] = $book_info['discount']; //商品折扣
        }
        $this->return_msg(200, '查询成功', $res_arr);
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
            ['book_id', 'require|number', '商品ID不能为空|参数错误'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg(400, $msg);
        $cart = new CartModel();
        $where     = [
            'uid'     => $user_info['id'],
            'book_id' => $this->params['book_id'],
        ];
        $res = $cart->del($where);
        if($res !== false){
            $this->return_msg(200,'删除成功');
        }else{
            $this->return_msg(400,'删除失败');
        }
    }
}
