<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 用户组管理控制器
* @author Jamers
* @since 2018.06.23
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Group extends MY_Controller {
    /**
    * 用户组管理标题数组
    * 
    * @var mixed
    */
    private $list = array('id' => '序号',
                    'name' => '组名',
                    'status' => '状态',
                    'memo' => '备注',
                    'manage' => '操作',
                    );
    /**
    * 用户组管理标题宽度数组
    * 
    * @var mixed
    */
    private $width = array( 'id' => '40px',
                        'name'=> '90px',
                        'status' => '50px',
                        'memo' => '80px',
                        'manage' => '120px',
                        );

    /**
    * 用户组管理列表模块
    * 
    */
    public function index() {
        if ($this->admin) {
            $this->load->database();
            $rs = $this->db->get('group')->result_array();
            $data = array('data'=>$rs,
                'width' => $this->width,
                'list'  => $this->list,
            );
            $this->load->view($this->themes.'group_list',$data);
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 用户组添加操作模块
    * 
    */
    public function add() {
        if ($this->admin) {
            if ($this->input->post('act')=='group-add') {
                //提交数据
                $this->load->database();
                $name = trim($this->input->post('name'));
                $this->msg = "用户组‘{$name}’已成功添加！";
                
                if ($this->db->get_where('group',"name='{$name}'")->num_rows()>0) {
                    $this->err = "用户组名‘{$name}’已经使用，请使用其它名称！";
                }else{
                    $u = array( 'name'  =>  $name,
                                'status'=>  intval($this->input->post('status')),
                                'memo'  =>  $this->input->post('memo'),
                    );
                    $this->db->insert('group',$u);
                }
                $this->index();
            }else{
                $data = array('modify'=>false);
                $this->load->view($this->themes.'group_modify',$data);
            }
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 用户组信息修改模块
    * 
    */
    public function modify() {
        if ($this->admin) {
            if ($this->input->post('act')=='group-modify') {
                //提交数据
                $id = intval($this->input->post('id'));
                $name = trim($this->input->post('name'));
                //较验ID
                if ($id) {
                    $this->load->database();
                    $whr = array('name' => $name, 'id !=' => $id,);
                    if ($this->db->get_where('group',$whr)->num_rows()>0) {
                        $this->err = "修改的用户组名已存在！";
                    }else{
                        $u = array(
                            'name'  =>  $name,
                            'status'=>  intval($this->input->post('status')),
                            'memo'  =>  $this->input->post('memo'),
                        );
                        $where = "id = {$id}";
                        $this->db->update('group',$u,$where);
                        $this->msg = "用户组数据已经成功更新！";
                    }
                }else{
                    $this->err = '捕获非法数据提交，请使用正常方式操作';
                }
                $this->index();
            }else{
                $this->load->database();
                $id = intval($this->id);
                $rs = $this->db->get_where('group',"id={$id}")->result_array();
                $data = array('modify'=>true,'data'=>$rs[0]);
                $this->load->view($this->themes.'group_modify',$data);
            }
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 用户组删除模块
    * 
    */
    public function del() {
        if ($this->admin) {
            $id = intval($this->id);

            $this->db->delete('group',array('id'=>$id));
            $this->db->update('users',array('mgroup' => 0,),"mgroup = {$id}");
            $this->msg = "指定用户组及相关信息已删除！";

            $this->index();
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 用户权限设置模块
    * 
    */
    public function permission() {
        if ($this->admin) {
            $id = intval($this->id);
            $this->load->database();
            if ($this->input->post('act')=='group-permission') {
                //提交数据
                $checked = $this->input->post('check');
                $perm = $this->core->build_str($checked);
                $u = array('perm'=>$perm);
                $this->db->update('group',$u,"id = {$id}");
                $this->msg = "用户组权限已修改完毕！";
                $this->index();
            }else{

                $r = $this->db->get_where('group',"id={$id}",1)->result_array();
                if ($r) {
                    $perm = trim($r[0]['perm']);
                }else{
                    $perm = '';
                }
                $checked = $this->core->get_checked($this->extary,$perm);
                $data = array(
                    'data'  =>  $r[0],
                    'perm'  =>  $perm,
                    'checked'=> $checked,
                );

                $this->load->view($this->themes.'group_permission',$data);

            }
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 无权限访问信息显示
    * 
    */
    public function denyinfo() {
            $this->err = '你没有使用此模块的权限！';
            $this->load->view($this->themes.'index');
    }
    
}

