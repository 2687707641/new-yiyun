<?php


namespace app\admin\controller;

use app\admin\model\Book as BookModel;

class Book extends Base
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
    public function get_book_list()
    {
        $book = new BookModel();
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $data  = $book->get_data_list($this->_condition);
        $count = $book->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
    }
}