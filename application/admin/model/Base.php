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

    //定义公共参数
    protected $_deleted = false; //是否从数据库中删除(不删除的情况下)

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
     * @param $delete 是否从数据库中删除(默认将状态改为被删除)
     * @return bool true|false
     */
    public function del($condition)
    {
        if($this->_deleted)
            return $this->where($condition)->delete();
        return $this->isUpdate(true)->allowField(true)->save(['deleted'=>1],$condition);
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

    /***
     * 获取数据列表
     * @param $conditon 过滤信息
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function get_data_list($conditon)
    {
        return $this->with($conditon['with'])
                ->where($conditon['where'])
                ->field('password', true)
                ->order($conditon['order'])
                ->limit($conditon['limit'])
                ->select();
    }

    /***
     * 获取数据条数
     * @param $where 过滤条件
     * @return int|string 数据条数
     * @throws \think\Exception
     */
    public function get_data_count($where)
    {
        return $this->where($where)->count();
    }

}