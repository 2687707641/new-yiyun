<?php


namespace app\admin\controller;

use app\admin\model\Order as OrderModel;
use app\admin\model\OrderDetails;
use app\admin\model\User;

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
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $data                                 = $order->get_data_list($this->_condition);
        $count                                = $order->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
    }

    /***
     * 删除
     */
    public function del()
    {
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['name']))
            $this->error('参数错误');
        $order = new OrderModel();
        $res   = $order->del(['id' => ['in', $this->_param['id']]]);
        if (!$res) {
            $this->error('删除失败!');
        } else {
            //写入操作日志
            if (is_array($this->_param['name']))
                $this->_param['name'] = implode(',', $this->_param['name']);
            log_write('删除订单:' . $this->_param['name'], $order->getLastSql());
            $this->success('删除成功!', 'lists');
        }
    }

    /***
     * 修改状态
     */
    public function change_status()
    {
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['status']))
            $this->error('参数错误');
        $order = new OrderModel();
        $res   = $order->edit(['status' => $this->_param['status']], ['id' => $this->_param['id']]);
        if (!$res) {
            $this->error('订单状态修改失败');
        } else {
            $str = $this->_param['status'] == 1 ? '待发货' : '已发货';
            log_write('将订单状态改为: ' . $str . ' 订单号:' . $this->_param['name'], $order->getLastSql());
            $this->success('修改订单状态成功', 'lists');
        }
    }

    public function details()
    {
        $this->check_authority();
        if (!isset($this->_param['uuid'])) $this->error('参数错误');
        $details    = new OrderDetails();
        $order_info = $details->where('uuid', $this->_param['uuid'])->select();
        if (empty($order_info)) $this->error('暂无该订单详细数据');
        $user      = new User();
        $user_info = $user->where('id', $order_info[0]['user_id'])->find();
        $res_data  = [
            'name' => '',
            'number' => '',
            'price' => '',
        ];
        foreach ($order_info as $k => $v) {
            $res_data['name']   .= ' ' . $v['name']; //商品名
            $res_data['number'] .= ' ' .$v['number'];//商品数量
            $res_data['price']  = ' ' . $v['price'];//商品数量
        }
        $res_data['user_phone'] = $user_info['phone'];
        $this->success('查看成功!', '', $res_data);
    }
}