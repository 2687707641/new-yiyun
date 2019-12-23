<?php


namespace app\admin\controller;

use app\admin\model\AuthCompetency as CompetencyModel;
use think\Log;

class Competency extends Base
{
    /***
     * 展示页面
     */
    public function lists()
    {
        return $this->fetch();
    }

    /***
     * layui 数据表格接口
     */
    public function get_competency_list()
    {
        $competency = new CompetencyModel();
        //排除被删除的
        $this->_condition['where']['deleted'] = 0;
        $data  = $competency->get_data_list($this->_condition);
        $count = $competency->get_data_count($this->_condition['where']);
        response_json('', $data, $count);
    }

    public function add()
    {
        return $this->_edit();
    }

    public function edit($id)
    {
        return $this->_edit($id);
    }

    /***
     * 通用修改删除
     * @param string $id 无ID为新增,有ID为修改
     * @return mixed
     */
    public function _edit($id = '')
    {
        $competency = new CompetencyModel();
        if($this->request->isPost()){
            $this->check_authority();
            $rules = [
                ['name','require|length:2,10|chsAlphaNum|unique:auth_competency','规则名称不能为空|规则名称长度应在2~10个字符之间|规则名称只能包含汉字,字母和数字|该规则名称已存在'],
                ['url','require|length:2,30|unique:auth_competency','方法路由不能为空|方法路由长度应在2~30个字符之间|该方法路由已存在'],
            ];
            $msg = $this->validate($this->_param,$rules);
            if($msg !== true) $this->error($msg, '');
            if($id){
                $res = $competency->edit($this->_param,['id'=>$id]);
            }else{
                $res = $competency->add($this->_param);
            }
            if($res !== false){
                $str = empty($id) ? '创建权限规则: ' : '编辑权限规则' ;
                log_write( $str . $this->_param['url'],$competency->getLastSql());
                $this->success(empty($id) ? '创建权限规则成功!' : '编辑权限规则成功', url('lists'));
            }else{
                $this->error($competency->getError(), '');
            }
        }
        if($id){
            $info = $competency->where('id',$id)->find();
            $this->assign('info',$info);
        }
        return $this->fetch('edit');
    }


    /***
     * 删除
     */
    public function del()
    {
        //判断权限
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['name']))
            $this->error('参数错误');
        $competency = new CompetencyModel();
        $res     = $competency->del(['id' => ['in', $this->_param['id']]]);
        if (!$res) {
            $this->error('删除失败!');
        } else {
            //写入操作日志
            log_write('删除权限规则:'. $this->_param['name'],$competency->getLastSql());
            $this->success('删除成功!', 'lists');
        }

    }

    /***
     * 修改状态
     */
    public function change_status()
    {
        $this->check_authority();
        if (!isset($this->_param['id']) || !isset($this->_param['status']))
            $this->error('参数错误');
        $competency = new CompetencyModel();
        $res     = $competency->edit(['status' => $this->_param['status']], ['id' => $this->_param['id']]);
        if (!$res) {
            $this->error($this->_param['status'] == 0 ? '禁用失败' : '启用失败');
        } else {
            $str = $this->_param['status'] == 0 ? '禁用' : '启用';
            log_write($str .'权限规则:'. $this->_param['name'],$competency->getLastSql());
            $this->success($this->_param['status'] == 0 ? '禁用成功' : '启用成功', 'lists');
        }
    }
}