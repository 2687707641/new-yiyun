<?php


namespace app\api\controller;

use app\admin\model\Book;
use app\api\model\Order as OrderModel;
use app\api\model\Cart;
use app\api\model\OrderDetails;
use think\Db;
use think\Log;

/***
 * 订单相关
 * Class Order
 * @package app\api\controller
 */
class Order extends Base
{
    /***
     * 直接购买商品,生成订单
     */
    public function generate_order()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        if (empty($user_info['address']))
            $this->return_msg('10000', '无收货地址信息,请填写收货地址');
        //参数验证
        $rules = [
            ['book_id', 'require|number', '10001|10002'],
            ['number', 'require|/^[+]{0,1}(\d+)$/|notIn:0', '10001|10002|10002'],
            ['price', 'require|float|between:0,999999999', '10001|10002|10002']
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        //生成订单
        $book      = new Book();
        $book_info = $book->where('id', $this->params['book_id'])->field('id,create_time,update_time', true)->find();
        if (empty($book_info)) $this->return_msg('20004', '暂无该商品数据');
        $num   = $book_info['number'] - $this->params['number'];//计算库存
        $sales = $book_info['sales'] + $this->params['number'];//计算销量
        if ($num < 0) $this->return_msg('10000', '库存不足,无法购买');
        $uuid          = $this->get_uuid(); //生成订单号
        $order         = new OrderModel();
        $data          = [
            'uuid'    => $uuid,
            'user_id' => $user_info['id'],
            'price'   => $this->params['price'],
            'status'  => '2',
            'address' => $user_info['address'],
        ];
        $order_details = new OrderDetails();
        $details       = [
            'uuid'     => $uuid,
            'number'   => $this->params['number'],
            'name'     => $book_info['name'],
            'price'    => $book_info['prince'],
            'discount' => $book_info['discount'],
            'author'   => $book_info['author'],
            'remark'   => $book_info['remark'],
            'picture'  => $book_info['picture'],
        ];
        //启动事务
        Db::startTrans();
        try {
            //修改商品库存及销量
            $book->edit(['number' => $num, 'sales' => $sales], ['id' => $this->params['book_id']]);
            //添加订单
            $order->add($data);
            //添加订单详情
            $order_details->add($details);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->return_msg('20005', '事务提交失败,数据进行回滚', $e);
        }
        $this->return_msg('00000', '订单生成成功!');
    }

    /***
     * 查询订单列表
     */
    public function get_order_list()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        $order     = new OrderModel();
        $list      = $order->where('user_id', $user_info['id'])->select();
        if (empty($list)) $this->return_msg('20004', '暂无数据');
        $this->return_msg('00000', '查询成功', $list);
    }

    /***
     * 订单详情
     */
    public function order_details()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        //参数验证
        $rules = [
            ['uuid', 'require|length:36', '10001|10002'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        $details    = new OrderDetails();
        $order_info = $details->where('uuid', $this->params['uuid'])->select();
        if (empty($order_info)) $this->return_msg('20004', '暂无数据');
        $this->return_msg('00000', '查询成功', $order_info);
    }

    /***
     * 购物车购买
     */
    public function cart_purchase()
    {
        //获取登录用户信息
        $user_info = $this->get_user_info();
        //获取购物车信息
        $cart      = new Cart();
        $cart_info = $cart->where('uid', $user_info['id'])->select();
        if(empty($cart_info)) $this->return_msg('20004','购物车无信息');
        $book      = new Book();
        $totol     = 0; //合计价格
        $cart_arr  = [];
        foreach ($cart_info as $k => $v) {
            $cart_arr[$k]['id']     = $v['book_id'];
            $cart_arr[$k]['number'] = $v['number'];//购物车中该商品数量
            $book_info              = $book->where('id', $v['book_id'])->find();
            if (empty($book_info)) $this->return_msg('20004', '暂无该商品数据', ['book_id' => $v['book_id']]);
            $cart_arr[$k]['name']     = $book_info['name']; //商品名称
            $cart_arr[$k]['prince']   = $book_info['prince']; //商品单价
            $cart_arr[$k]['picture']  = $book_info['picture']; //商品封面图
            $cart_arr[$k]['discount'] = $book_info['discount']; //商品折扣
            $cart_arr[$k]['author']   = $book_info['author']; //商品作者
            $cart_arr[$k]['remark']   = $book_info['remark']; //商品描述
            $cart_arr[$k]['sales']    = $book_info['sales']; //商品销量
            $cart_arr[$k]['stock']    = $book_info['number']; //商品库存
            $totol                    += $cart_arr[$k]['prince'] * $cart_arr[$k]['discount'] * 0.1 * $cart_arr[$k]['number'];//计算价格
        }
        $totol = number_format($totol, 2);//保留2位小数
        $uuid  = $this->get_uuid(); //生成订单号
        $order_details = new OrderDetails();
        $order         = new OrderModel();
        //启动事务
        Db::startTrans();
        try {
            //对购物车商品进行处理
            foreach ($cart_arr as $k => $v) {
                $num   = $v['stock'] - $v['number'];//计算库存
                if ($num < 0) $this->return_msg('10000', '库存不足,无法购买', ['book_id' => $v['book_id']]);
                $sales = $v['sales'] + $v['number'];//计算销量
                $book->edit(['number' => $num, 'sales' => $sales], ['id' => $v['id']]);
                $v['uuid'] = $uuid;
                //添加订单详情
                $order_details::create([
                    'uuid'     => $uuid,
                    'number'   => $v['number'],
                    'name'     => $v['name'],
                    'price'    => $v['prince'],
                    'discount' => $v['discount'],
                    'author'   => $v['author'],
                    'remark'   => $v['remark'],
                    'picture'  => $v['picture'],
                ]);
            }
            //生成订单
            $data = [
                'uuid'    => $uuid,
                'user_id' => $user_info['id'],
                'price'   => $totol,
                'status'  => '2',
                'address' => $user_info['address'],
            ];
            $order->add($data);
            //清空该用户购物车
            $cart->del(['uid'=>$user_info['id']]);
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            $this->return_msg('20005', '事务提交失败,数据进行回滚', $e);
        }
        $this->return_msg('00000', '订单生成成功!');
    }

    /***
     * 购物车购买(废弃)
     */
//    public function cart_purchase()
//    {
//        //获取登录用户信息
//        $user_info = $this->get_user_info();
//        //参数验证
//        $rules = [
//            ['orders', 'require', '10001'],
//            ['price', 'require|float|between:0,999999999', '10001|10002|10002']
//        ];
//        $msg   = $this->validate($this->params, $rules);
//        if ($msg !== true) $this->return_msg($msg, '参数错误');
//        if (!is_array($this->params['orders'])) $this->return_msg('10002', '参数错误');
//        $book          = new Book();
//        $order         = new OrderModel();
//        $order_details = new OrderDetails();
//        $uuid          = $this->get_uuid(); //生成订单号
//        //启动事务
//        Db::startTrans();
//        try {
//            //对购物车商品进行处理
//            foreach ($this->params['orders'] as $k => $v) {
//                //修改商品库存及销量
//                $book_info = $book->where('id', $v['book_id'])->field('id,create_time,update_time', true)->find();
//                if (empty($book_info)) $this->return_msg('20004', '暂无该商品数据', ['book_id' => $v['book_id']]);
//                $num   = $book_info['number'] - $v['number'];//计算库存
//                $sales = $book_info['sales'] + $v['number'];//计算销量
//                if ($num < 0) $this->return_msg('10000', '库存不足,无法购买', ['book_id' => $v['book_id']]);
//                $book->edit(['number' => $num, 'sales' => $sales], ['id' => $v['book_id']]);
//                //添加订单详情
//                $order_details::create([
//                    'uuid'     => $uuid,
//                    'number'   => $v['number'],
//                    'name'     => $book_info['name'],
//                    'price'    => $book_info['prince'],
//                    'discount' => $book_info['discount'],
//                    'author'   => $book_info['author'],
//                    'remark'   => $book_info['remark'],
//                    'picture'  => $book_info['picture'],
//                ]);
//            }
//            //生成订单
//            $data = [
//                'uuid'    => $uuid,
//                'user_id' => $user_info['id'],
//                'price'   => $this->params['price'],
//                'status'  => '2',
//                'address' => $user_info['address'],
//            ];
//            $order->add($data);
//            // 提交事务
//            Db::commit();
//        } catch (\Exception $e) {
//            // 回滚事务
//            Db::rollback();
//            $this->return_msg('20005', '事务提交失败,数据进行回滚', $e);
//        }
//        $this->return_msg('00000', '订单生成成功!');
//    }
}