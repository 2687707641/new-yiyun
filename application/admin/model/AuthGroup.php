<?php


namespace app\admin\model;


class AuthGroup extends Base
{
    protected $autoWriteTimestamp = 'datetime';

    /***
     * 关联管理员名称
     * @return \think\model\relation\HasMany
     */
    public function manager()
    {
        $where = [
            'deleted' => 0,
        ];
        return $this->hasMany('Manager','role_id','id')->where($where)->field('role_id,username');
    }
}