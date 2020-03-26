<?php


namespace app\api\model;

use think\Model;

class Base extends Model
{

    //定义公共参数
    protected $_deleted = true; //是否从数据库中删除(不删除的情况下)

    /***
     * 单个添加
     * @param $data 新增数据
     * @return false|int 成功返回影响条数,失败返回false
     */
    public function add($data)
    {
        return $this->allowField(true)->save($data);
    }

    /***
     * 单个更新
     * @param $update 更新数据
     * @param $condition 更新条件
     * @return false|int 成功返回影响条数,失败返回false
     */
    public function edit($update, $condition)
    {
        return $this->isUpdate(true)->allowField(true)->save($update, $condition);
    }

    /***
     * 删除
     * @param $condition 删除条件
     * @param $delete 是否从数据库中删除(默认将状态改为被删除)
     * @return bool true|false
     */
    public function del($condition)
    {
        if ($this->_deleted)
            return $this->where($condition)->delete();
        return $this->isUpdate(true)->allowField(true)->save(['deleted' => 1], $condition);
    }
}