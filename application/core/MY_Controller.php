<?php
include_once(APPPATH.'/models/Member.php');

/**
* 需要身份验证的扩展控制器
* 
* @author Jamers
* @since 2016.5.15
*/

class MY_Controller extends CI_Controller {
    /**
    * 调用模块名
    * 
    * @var mixed
    */
    public $module;
    /**
    * 调用函数名
    * 
    * @var mixed
    */
    public $func;
    /**
     * 核心扩展类
     * @var Core
     */
    public $core;
    public $id;
    public $act,$msg,$err,$admin = false,$extary = array(),$name,$hideit = true,$target = array();
    public $member,$title,$index;
    public $themes = 'default';

    /**
    * 不需要进行身份验证的模块
    * 
    * @var mixed
    */
    private $exclude = array(
        'login','logout',
    );
    public $data = array('UID'=>0,'user'=>'','name'=>'','mgroup'=>0);
    
    public function __construct() {
        parent::__construct();
        $this->config->load('gurms.php',false,true);
        $this->load->model('gurms');
        $this->themes = $this->gurms->getThemes();

        date_default_timezone_set('Asia/Shanghai');
        $index = config_item('base_url').config_item('index_page');
        if (($index) && (substr(trim($index),0,1)!='/')) {
            $index = '/'.$index;
        }
        $this->index = $index;
        if (!file_exists(APPPATH."/config/installed.php")) {
            header("Location: {$this->index}/install\n");
            exit();
        }
        $this->title = config_item('system_title');
        $act = $this->input->post('act');
        $act = ($act ? $act : $this->input->get('act'));

        $this->module = strtolower($this->uri->segment(1));
        $this->func = strtolower($this->uri->segment(2));
        $this->id = strtolower($this->uri->segment(3));
        
        if (! $act) {
            if ($this->module) {
                $act = $this->module;
                if (($this->func != '') && (strtolower($this->func) != 'index')) {
                    $act .= "-{$this->func}";
                }
            }else{
                $act = 'indexs';
            }
        }
        
        $t = strpos($act,'-');
        if ($t) {
            $this->actt = substr($act,0,$t);
        }else{
            $this->actt = $act;
        }
        $this->act = $act;

        $this->member = new Member();
        //exit($this->member->ip_address);
        $this->auth();
    }
    
    public function auth() {
        if (! in_array($this->module,$this->exclude)) {
            $this->data = $this->member->auth();
            
            //如果无身份ID，跳转至登录页面，记录当前链接，完成后跳转
            if (! $this->member->session_id) {
                $_SESSION['ref'] = $_SERVER['REQUEST_URI'];
                unset($_SESSION['session_id']);
                $this->member->unload_member();
                $url = "{$this->index}/login";
                header("Location: {$url}\n");
                exit;
            }
            if ($this->data['isadmin']) {
                $this->admin = true;
            }
            $this->name = $this->data['name'];
            $this->load->library('core',$this->data);
            $this->extary = $this->core->get_ext_list();
            $this->target = $this->core->target;
        }
    }

    public function display($template = '', $data = array()) {
        $this->load->view($this->themes.$template, $data);
    }
}
