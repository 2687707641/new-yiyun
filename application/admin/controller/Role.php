<?php


namespace app\admin\controller;
use app\admin\model\AuthGroup as AuthGroupModel;

class Role extends Base
{
    public function lists()
    {
        return $this->fetch();
    }

    /***
     * layui 数据表格接口
     */
    public function get_role_list()
    {
        $role = new AuthGroupModel();
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $data  = $role->get_data_list($this->_condition);
        $count = $role->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
    }


}