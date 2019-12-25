<?php


namespace app\admin\model;

use think\Log;

class AuthRule extends Base
{
    protected $autoWriteTimestamp = 'datetime';
    private static $arr = [];

    /***
     * 获取栏目列表
     */
    public function cate_tree($where = [])
    {
        self::$arr = []; //初始化
        $data = $this->order('sort asc')->where($where)->select();
        return  $this->tree($data);
    }

    public function tree($data, $pid = 0, $level = 0)
    {
         foreach ($data as $k => $v){
             //找顶级栏目  v是他的值
             if($v['pid'] == $pid){
                 //如果是顶级栏目就将其放进数组里
                 $v['level'] = $level;
                 self::$arr[] = $v;
                 $this->tree($data,$v['id'],$level+1);//找到顶级栏目后找其他栏目
             }
         }
         return self::$arr;
    }
}