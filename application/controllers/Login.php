<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 用户登录控制器
* @author Jamers
* @since 2016.5.13
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Login extends CI_Controller {
    /**
     * @var Gurms
     */
    public $gurms;
    public function index() {
        $this->load->helper('url');
        $ref = base_url().config_item('index_page');

        if (isset($_SESSION['session_id']) && $_SESSION['session_id']) {
            header("Location: {$ref}\n");
            exit;
        }
        $msg = '';
        $act = strtolower($this->input->post('act'));
        if ($act == 'login') {
            //登录
            $msg = "帐号或密码错误，请重新登录！<br/>";
            $this->load->database();
            $user = $this->input->post('uuser');
            $pass = $this->input->post('pass');
            $query = $this->db->get_where('users',array('user'=>$user,'enable'=>1),1);
            $rs = $query->result_array();
            if ($rs) {
                $member = $rs[0];
                if ($pass == NULL) $pass = '';
                if (hash('sha256',$pass) === $member['pass']) {
                    //密码一致
                    $this->load->model('member');
                    
                    $_time = (config_item('login_key_expire')) ? (time() + 86400) : 0;
                    $_sticky = $_time ? 0 : 1;
                    $_days = $_time ? 1 : 365;
                    
                    if ((! $member['member_login_key']) || (time() > $member['member_login_key_expire'])) {
                        //生成新的登录键值
                        $member['member_login_key'] = $this->member->generate_auto_log_in_key();
                        $u = array('member_login_key'=>$member['member_login_key'],'member_login_key_expire'=>$_time);
                        $where = "UID = {$member['UID']}";
                        $this->db->update('users',$u,$where);
                    }
                    
                    $this->member->data = $member;
                    
                    $this->member->create_member_session();
                    $_SESSION['session_id'] = $this->member->session_id;
                    
                    $key_expire = 86400*config_item('login_key_expire');
                    if ($this->input->post('save')) {
                        $expire = 60*60*24*365;
                        set_cookie('save',1,$expire);
                        set_cookie('member_id', $member['UID'],$expire);
                        set_cookie('pass_hash', $member['member_login_key'],$key_expire);
                    }else{
                        set_cookie('save',0,$key_expire);
                    }
                    
                    //更新用户最后登录及活动时间
                    $this->member->update_member_last_login();
                    
                    $msg = '';
                    if (isset($_SESSION['ref'])) {
                      $ref = $_SESSION['ref'];
                      unset($_SESSION['ref']);
                    }
                    //TODO: 登录模块完成后把下面注释去掉
                    header("Location: {$ref}\n");
                    exit;
                }
            }
        }
        if (isset($_SESSION['msg'])) {
            $msg .= $_SESSION['msg'];
            unset($_SESSION['msg']);
        }

        $this->load->helper('form');
        $this->config->load('gurms.php',false,true);
        $data = array('title'=>config_item('system_title'),'msg'=>$msg);
        $this->load->model('gurms');
        $themes = $this->gurms->getThemes();
        $this->load->view($themes.'login',$data);
    }
    
}
