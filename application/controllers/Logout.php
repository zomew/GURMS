<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 用户登出控制器
* @author Jamers
* @since 2016.5.13
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Logout extends CI_Controller {
    public function index() {
        set_cookie('member_id',0);
        set_cookie('pass_hash','');
        set_cookie('session_id','');
        set_cookie('save',0);
        
        $this->load->database();
        $where = "session_id = '{$_SESSION['session_id']}' or session_member_id <= 0";
        $this->db->where($where);
        $this->db->delete('session');

        unset($_SESSION['session_id']);
        unset($_SESSION['ST']);
        $ref = config_item('base_url').config_item('index_page');
        header("Location: {$ref}\n");
    }
}

