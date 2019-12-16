<?php


namespace app\admin\controller;


class Index extends Base
{
    /***
     * 主页
     */
    public function index()
    {
        return $this->fetch();
    }

    /***
     * 桌面
     */
    public function welcome()
    {
        return $this->fetch();
    }

}