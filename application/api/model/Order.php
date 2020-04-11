<?php


namespace app\api\model;


class Order extends Base
{
    protected $autoWriteTimestamp = 'datetime';

    //订单状态读取器
    public function getStatusAttr($value)
    {
        $status = [
            '1' => '待发货',
            '2' => '已发货',
            '3' => '确认收货',
        ];
        return $status[$value];
    }
}