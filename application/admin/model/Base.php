<?php


namespace app\admin\model;

use think\Model;

/***
 * 模型基类
 * Class Base
 * @package app\admin\model
 */
class Base extends Model
{
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
    public function edit($update,$condition)
    {
        return $this->isUpdate(true)->allowField(true)->save($update,$condition);
    }

    /***
     * 删除
     * @param $condition 删除条件
     * @return bool true|false
     */
    public function del($condition)
    {
        return $this->destory($condition);
    }

    /***
     * @param $data 新增数组
     * @return array|false
     * @throws \Exception
     */
    public function add_all($data)
    {
        return $this->isUpdate(false)->allowField(true)->saveAll($data,false);
    }


}