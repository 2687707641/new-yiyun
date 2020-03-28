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
        if (!empty($data)) {
            $this->return_msg('00000', '查询成功', $data);
        } else {
            $this->return_msg('20004', '查询失败,暂无信息', []);
        }
    }

    /***
     * 获取商品信息
     */
    public function get_book()
    {
        $rules = [
            ['cate_id', 'require|number', '10001|10002']
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        $cate = new Cate();
        $cate_info = $cate->where('id',$this->params['cate_id'])->field('name')->find();
        $book  = new BookModel();
        $lists = $book->field('id,name,pid,remark,prince,number,author,picture')->where('pid', $this->params['cate_id'])->select();
        if (empty($lists)) $this->return_msg('20004', '该分类下暂无商品信息');
        $res_arr = [
            'cate_name' => $cate_info['name'],
            'book_lists' => $lists,
        ];
        $this->return_msg('00000', '查询成功', $res_arr);
    }

    /***
     * 获取热卖商品信息
     */
    public function hot_book()
    {
        $book  = new BookModel();
        $lists = $book->field('id,name,remark,prince,number,author,picture,sales')->order('sales desc')->limit(0, 8)->select();
        if (empty($lists)) $this->return_msg('20004', '该分类下暂无商品信息');
        $this->return_msg('00000', '查询成功', $lists);
    }

    /***
     * 获取导航栏信息
     */
    public function navigation_bar()
    {
        $cate      = new Cate();
        $book      = new BookModel();
        $where     = [
            'status'  => '1',
            'deleted' => '0'
        ];
        $res_arr   = [];
        $cate_info = $cate->where($where)->field('id,name,picture')->select();
        foreach ($cate_info as $k => $v) {
            $res_arr[$k]['id']      = $v['id'];
            $res_arr[$k]['name']    = $v['name'];
            $res_arr[$k]['picture'] = $v['picture'];
            //查询当前分类下的热门商品信息
            $where['pid']             = $v['id'];
            $res_arr[$k]['sum']       = $book->where($where)->count();
            $book_info                = $book->where($where)->field('id,name,prince,picture')->order('sales desc')->limit(1)->select();
            $res_arr[$k]['book_info'] = $book_info;
        }
        if(empty($res_arr)) $this->return_msg('20004', '暂无数据',[]);
        $this->return_msg('00000', '查询成功', $res_arr);
    }

    /***
     * 商品详情
     */
    public function book_details()
    {
        $rules = [
            ['book_id', 'require|number', '10001|10002'],
        ];
        $msg   = $this->validate($this->params, $rules);
        if ($msg !== true) $this->return_msg($msg, '参数错误');
        $book  = new BookModel();
        $where = [
            'b.id' => $this->params['book_id'],
        ];
        //排除某些字段
        $book_info = $book->alias('b')->join('cate c', 'b.pid = c.id')->where($where)
            ->field('b.id,b.name,b.remark,b.pid,b.prince,b.number,b.author,b.picture,b.sales,c.name cate_name')
            ->find();
        if (empty($book_info)) $this->return_msg('20004', '暂无信息', []);
        //查询该分类下的其他商品信息
        $where       = [
            'pid' => $book_info['pid'],
            'id'  => ['<>', $this->params['book_id']],
        ];
        $others_info = $book->where($where)->field('id,name,picture,prince')->select();
        $res_arr     = [
            'book_details' => $book_info,
            'others'       => $others_info,
        ];
        $this->return_msg('00000', '查询成功', $res_arr);
    }
}