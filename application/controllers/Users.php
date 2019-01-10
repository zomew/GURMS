<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 用户管理控制器
* @author Jamers
* @since 2016.5.16
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Users extends MY_Controller {
    /**
    * 用户管理标题数组
    * 
    * @var mixed
    */
    private $list = array('UID' => '序号',
                    'user' => '用户名',
                    'name' => '姓名',
                    'mgroup' => '用户组',
                    'lastlogin' => '最后登录',
                    'enable' => '有效',
                    'isadmin' => '管理员',
                    'manage' => '操作',
                    );
    /**
    * 用户管理标题宽度数组
    * 
    * @var mixed
    */
    private $width = array( 'UID' => '40px',
                        'user'=> '90px',
                        'name'=> '90px',
                        'mgroup'=> '100px',
                        'lastlogin' => '170px',
                        'enable' => '50px',
                        'isadmin' => '60px',
                        'manage' => '120px',
                        );

    /**
    * 用户管理列表模块
    * 
    */
    public function index() {
        if ($this->admin) {
            $this->load->database();
            $rs = $this->db->get('users')->result_array();
            $group = $this->getgrouplist();
            $data = array('data'=>$rs,
                'width' => $this->width,
                'list'  => $this->list,
                'group' => $group,
            );
            $this->load->view($this->themes.'users_list',$data);
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 用户添加操作模块
    * 
    */
    public function add() {
        if ($this->admin) {
            if ($this->input->post('act')=='users-add') {
                //提交数据
                $this->load->database();
                $uname = $this->input->post('uname');
                $epass = hash('sha256',$this->input->post('pass'));
                $this->msg = "用户‘{$uname}’已成功添加！";
                
                if ($this->db->get_where('users',"user='{$uname}'")->num_rows()>0) {
                    $this->err = "用户名‘{$uname}’已经使用，请使用其它用户名！";
                }else{
                    $u = array( 'user'  =>  $uname,
                                'pass'  =>  $epass,
                                'name'  =>  $this->input->post('name'),
                                'enable'=>  intval($this->input->post('enable')),
                                'isadmin'=> intval($this->input->post('isadmin')),
                                'wtid'  =>  $this->input->post('wtid'),
                                'mgroup' => $this->input->post('mgroup'),
                    );
                    $this->db->insert('users',$u);
                }
                $this->index();
            }else{
                $data = array('modify'=>false,'group' => $this->getgrouplist(),);
                $this->load->view($this->themes.'users_modify',$data);
            }
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 用户信息修改模块
    * 
    */
    public function modify() {
        if ($this->admin) {
            if ($this->input->post('act')=='users-modify') {
                //提交数据
                $id = intval($this->input->post('uid'));
                //较验ID
                if ($id == $this->id) {
                    $this->load->database();
                    $isadmin = intval($this->input->post('isadmin'));
                    $uid = intval($this->input->post('uid'));
                    if (($isadmin==0) && ($uid == $this->data['UID'])) {
                        $this->err = "无法将自身管理员权限取消！取消更新！";
                    }else{
                        $pass = $this->input->post('pass');
                        $u = array( 'user'  =>  $this->input->post('uname'),
                                    'name'  =>  $this->input->post('name'),
                                    'enable'=>  intval($this->input->post('enable')),
                                    'isadmin'=> intval($this->input->post('isadmin')),
                                    'wtid'  =>  $this->input->post('wtid'),
                                    'mgroup' => intval($this->input->post('mgroup')),
                        );
                        if ($pass) {
                            if ($uid != $this->data['UID']) {
                                $u['pass'] = hash('sha256',$pass);
                            }else{
                                $this->err = "您的密码未修改，如果要修改自己的密码请在密码修改中完成！";
                            }
                        }
                        $where = "UID = {$uid}";
                        $this->db->update('users',$u,$where);
                        $this->msg = "用户数据已经成功更新！";
                    }
                }else{
                    $this->err = '捕获非法数据提交，请使用正常方式操作';
                }
                $this->index();
            }else{
                $this->load->database();
                $id = intval($this->id);
                $rs = $this->db->get_where('users',"UID={$id}")->result_array();
                $data = array('modify'=>true,'data'=>$rs[0],'group'=>$this->getgrouplist(),);
                $this->load->view($this->themes.'users_modify',$data);
            }
        }else{
            $this->denyinfo();
        }
    }
    
    /**
    * 用户删除模块
    * 
    */
    public function del() {
        if ($this->admin) {
            $id = intval($this->id);
            if ($id == intval($this->data['UID'])) {
                $this->err = "您无法删除自身帐号，取消操作";
            }else{
                $this->db->delete('perm',array('id'=>$id));
                $this->db->delete('session',array('session_member_id'=>$id));
                $this->db->delete('users',array('UID'=>$id));
                $this->msg = "指定帐号及相关资料已删除！";
            }
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
            if ($this->input->post('act')=='users-permission') {
                //提交数据
                $this->db->delete('perm',array('id'=>$id));
                $checked = $this->input->post('check');
                $perm = $this->core->build_str($checked);
                $u = array('id'=>$id,'perm'=>$perm);
                $this->db->insert('perm',$u);
                $this->msg = "权限已修改完毕！";
                $this->index();
            }else{
                $rs = $this->db->get_where('users',"UID={$id}")->result_array();
                if ($rs) {
                    $rs = $rs[0];
                    if ($rs['isadmin']==1) {
                        $this->err = "管理员默认具有所有权限，不能修改";
                        $this->index();
                    }else{
                        $r = $this->db->get_where('perm',"id={$id}",1)->result_array();
                        if ($r) {
                            $perm = trim($r[0]['perm']);
                        }else{
                            $perm = '';
                        }
                        $checked = $this->core->get_checked($this->extary,$perm);
                        $data = array(
                            'user'  =>  $rs['user'],
                            'name'  =>  $this->data['name'],
                            'nname' =>  $rs['name'],
                            'perm'  =>  $perm,
                            'checked'=> $checked,
                        );
                        
                        $this->load->view($this->themes.'permission',$data);
                    }
                }else{
                    $this->err = "无法找到相应记录，请查实后操作";
                    $this->load->view($this->themes.'index');
                }
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

    private function getgrouplist() {
        $r1 = $this->db->select(array('id','name'))->get('group')->result_array();
        $group = array();
        if ($r1) {
            foreach($r1 as $v) {
                $group[$v['id']] = $v['name'];
            }
        }
        return $group;
    }
    
}

