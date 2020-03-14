<?php


namespace app\admin\model;


class Book extends Base
{
    protected $autoWriteTimestamp = 'datetime';

    /***
     * 关联分类名
     */
    public function cate()
    {
        $where = [
            'deleted' => 0,
        ];
        return $this->belongsTo('Cate','pid','id')->where($where)->bind(['cate_name'=>'name']);
    }
}