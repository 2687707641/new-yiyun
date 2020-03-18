<?php


namespace app\admin\controller;

use org\Baksql;
use think\Log;

class Backup extends Base
{
    /***
     * @return mixed 展示页面
     */
    public function lists()
    {
        return $this->fetch();
    }

    /***
     * 获取文件列表
     */
    public function get_file_list()
    {
        $backup = new Baksql(\think\Config::get("database"));
        $data = $backup->get_filelist();
        $count = count($data);
        response_json('',$data,$count);
    }

    public function manipulate_data()
    {
        $data = $this->request->param();
        if(!isset($data['type']))
            $this->error('参数错误!','lists');
        $backup = new Baksql(\think\Config::get("database"));
        switch ($data['type']){
            case 'download':
                $info = $backup->downloadFile($data['name']);
                break;
            case 'delete':
                $info = $backup->delfilename($data['name']);
                $this->success($info, 'lists');
                break;
            case 'backup':
                $info = $backup->backup();
                $this->success($info, 'lists');
                break;
            case 'restore':
                $info = $backup->restore($data['name']);
                $this->success($info, 'lists');
                break;
        }
       $this->error('发生错误,请重试!');
    }


}