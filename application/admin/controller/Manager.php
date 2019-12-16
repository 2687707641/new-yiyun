<?php


namespace app\admin\controller;

use app\admin\model\Manager as ManagerModel;

class Manager extends Base
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
    public function get_manager_list()
    {
        $manager = new ManagerModel();
        if(!isset($this->_map['page']) || !isset($this->_map['limit']))
            response_json('参数错误');
        $data = $manager->get_data_list($this->_map);
        $count = $manager->get_data_count($this->_map);
        response_json('',$data,$count);
    }

    public function del()
    {
        $this->success('操作成功!','lists');
    }

}