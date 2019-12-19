<?php


namespace app\admin\controller;
use app\admin\model\Logs as LogsModel;

class Logs extends Base
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
    public function get_log_list()
    {
        $logs = new LogsModel();
        $data  = $logs->get_data_list($this->_condition);
        $count = $logs->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
    }
}