<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 密码管理控制器
* @author Jamers
* @since 2016.5.15
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Password extends MY_Controller {
    public function index() {
        if (strtolower($this->act) == 'pass-update') {
            //更新密码，完成后跳转至首页
            $this->load->database();
            $rs = $this->db->get_where('users',array('UID'=>$this->member->session_user_id,'enable'=>1),1)->result_array();
            if (! $rs) {
                //无此用户或被禁用了，直接退出
                $this->member->unload_member();
                $ref = base_url().config_item('index_page');
                header("Location: {$ref}\n");
                exit;
            }
            $rs = $rs[0];
            $msg = '';
            if ($rs['pass']!=hash('sha256',$this->input->post('opass'))) {
                $this->err = "原密码输入错误";
            }else{
                if ($this->input->post('pass1')!=$this->input->post('pass2')) {
                    $this->err = "输入的新密码不一致";
                }else{
                    $u = array('pass'=>hash('sha256',$this->input->post('pass1')));
                    $where = "UID = {$this->member->session_user_id}";
                    $this->db->update('users',$u,$where);
                    $this->msg = "密码已变更，请重新登录";
                }
            }
            $this->load->view($this->themes.'index');
        }else{
            $this->load->helper('form');

            $this->load->view($this->themes.'password');
        }
    }
}

