<?php


namespace app\admin\controller;

use app\admin\model\Order as OrderModel;

class Order extends Base
{
    /***
     * 展示页面
     */
    public function lists()
    {
        return $this->fetch();
    }

    /***
     * layui 数据表格接口
     */
    public function get_order_list()
    {
        $order = new OrderModel();
        $data  = $order->get_data_list($this->_condition);
        $count = $order->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
    }
}