<?php


namespace app\api\controller;

use app\api\model\Cate;
use app\admin\model\Book as BookModel;
use think\Log;

/***
 * Class Book 商品接口相关
 * @package app\api\controller
 */
class Book extends Base
{
    /***
     * 获取商品分类
     */
    public function get_cate()
    {
        $cate = new Cate();
        $data = $cate->cate_tree();
        if(!empty($data)){
            $this->return_msg(200,'查询成功',$data);
        }else{
            $this->return_msg(400,'查询失败',$data);
        }
    }

    /***
     * 获取商品信息
     */
    public function get_book()
    {
        $rules = [
           ['cate_id','require|number','分类ID不能为空|参数格式错误']
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg(400,$msg);
        $book = new BookModel();
        $lists = $book->field('id,name,pid,remark,prince,number,author,picture')->where('pid',$this->params['cate_id'])->select();
        if(empty($lists)) $this->return_msg(400,'该分类下暂无商品信息');
        $this->return_msg(200,'查询成功',$lists);
    }

    /***
     * 获取热卖商品信息
     */
    public function hot_book()
    {
        $book = new BookModel();
        $lists = $book->field('id,name,remark,prince,number,author,picture,sales')->order('sales desc')->limit(0,8)->select();
        if(empty($lists)) $this->return_msg(400,'该分类下暂无商品信息');
        $this->return_msg(200,'查询成功',$lists);
    }

    /***
     * 获取导航栏信息
     */
    public function navigation_bar()
    {
        $cate = new Cate();
        $info = $cate->alias('c')->join('book b','c.id = b.pid', 'left')
                ->field('c.id cate_id,c.name cate_name,c.picture cate_picture, b.id book_id, count(*) sum b.pid')
                ->select();
        echo json_encode($info);
    }
}