<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 用户身份及权限验证钩子
* 
* @package Core
* @author Jamers
* @since 2016.5.12
* @deprecated 2016.5.15 由于无法继承至源控制器，改为扩展CI_Control方式处理，本模块弃用
*/
class Acl {
    private $CI;
    /**
    * 调用模块名
    * 
    * @var mixed
    */
    private $module;
    /**
    * 调用函数名
    * 
    * @var mixed
    */
    private $func;
    private $id;
    public $act;

    /**
    * 不需要进行身份验证的模块
    * 
    * @var mixed
    */
    private $exclude = array(
        'login','logout',
    );
    
    private $data = array('UID'=>0,'user'=>'','name'=>'','mgroup'=>0);
    
    function __construct() {
        $this->CI =& get_instance();
        //$this->CI =& MY_Controller::get_instance();
        
        //已自动加载，可以取消
        //$this->CI->load->library('session');
        //$this->CI->load->model('member');
        
        $this->module = strtolower($this->CI->uri->segment(1));
        $this->func = strtolower($this->CI->uri->segment(2));
        $this->id = strtolower($this->CI->uri->segment(3));
    }
    function auth() {
        if (! in_array($this->module,$this->exclude)) {
            $this->data = $this->CI->member->auth();
            var_dump($this->CI);
            //如果无身份ID，跳转至登录页面，记录当前链接，完成后跳转
            if (! $this->CI->member->session_id) {
                $_SESSION['ref'] = $_SERVER['REQUEST_URI'];
                $url = "/index.php/login";
                header("Location: {$url}\n");
                exit;
            }
            $this->CI->load->library('core',$this->data);
        }
    }
}
?>
