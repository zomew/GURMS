<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(SYSDIR.'/core/Model.php');
/**
* 用户SESSION处理模型
* @author Jamers
* @since 2016.5.14
* @license    http://opensource.org/licenses/MIT    MIT License
*/

class Member extends CI_Model {
    /**
    * 用户记录数组
    * 
    * @var mixed
    */
    public $data = array('UID'=>0,'user'=>'','name'=>'','mgroup'=>0);
    public $session_id = '';
    public $session_type = '';
    public $session_user_id = 0;
    private $do_update = 1;
    public $user_agent,$ip_address;
    private $last_click = 0;
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        //$this->load->helper('cookie');
        $this->ip_address = $this->getip();
        $this->user_agent = $this->my_getenv('HTTP_USER_AGENT');
        $this->last_click = time();

    }
    
    public function generate_auto_log_in_key($len = 60) {
        $pass = $this->generate_password_salt($len);
        return md5($pass);
    }
    private function generate_password_salt($len = 5) {
        $salt = '';
        //srand( (double)microtime() * 1000000 );
        // PHP 4.3 is now required ^ not needed
        for ($i = 0;$i < $len;$i++) {
            $num = rand(33, 126);
            if ($num == '92') {
                $num = 93;
            }
            $salt.= chr($num);
        }
        return $salt;
    }
    
    /**
    * 建立用户session记录
    * 
    */
    public function create_member_session() {
        if ($this->data['UID']) {
            $this->db->delete('session',array('session_member_id'=>$this->data['UID']));
            
            $this->session_id = md5( uniqid(microtime()));
            
            //if (! $this->do_update) return;
            
            if ($this->data['lastlogin'] == null) {
                $this->data['lastlogin'] = 0;
            }
            $u = array(
                'session_id' => $this->session_id,
                'session_ip'   =>  $this->ip_address,
                'session_member_name'  =>  $this->data['name'],
                'session_member_id'    =>  $this->data['UID'],
                'session_member_key'   =>  $this->data['member_login_key'],
                'session_login_time'   =>  $this->data['lastlogin'],
                'session_running_time' =>  time(),
                'session_member_group' =>  $this->data['mgroup'],
                'session_login_type'   =>  $this->session_type,
                'session_browser'      =>  substr($this->user_agent,0,200),
            );
            $this->db->insert('session',$u);
            
            $expire = 86400*config_item('login_key_expire');
            $key_expire = time() + $expire;
            set_cookie('pass_hash',$this->data['member_login_key'],$expire);
            $u = array('member_login_key_expire'=>$key_expire,'last_activity'=>time());
            $where = "UID = {$this->data['UID']}";
            $this->db->update('users',$u,$where);
            //更新密钥过期时间
            $this->data['member_login_key_expire'] = $key_expire;
        }
    }
    
    /**
    * 更新用户最后活动时间
    * 
    */
    public function update_member_last_login() {
        if ($this->data['UID']) {
            $t = time();
            $u = array('lastlogin'=>$t,'last_activity'=>$t);
            $where = "UID = {$this->data['UID']}";
            $this->db->update('users',$u,$where);
        }
    }

    /**
    * 取服务器变量，优先查找$_SERVER不存在查找环境变量
    * 
    * @param mixed $key
    */
    private function my_getenv($key) {
        $ret = '';
        if (is_array($_SERVER) and count($_SERVER)) {
            if (isset($_SERVER[$key])) {
                $ret = $_SERVER[$key];
            }
        }
        if (!$ret) {
            $ret = getenv($key);
        }
        return $ret;
    }
    /**
    * 取用户IP地址
    */
    public function getip() {
        $ip = $this->my_getenv("HTTP_X_REAL_IP");
        if (!$ip){
            $ip = $this->my_getenv("HTTP_X_FORWARDED_FOR");
            if (!$ip) {
                $ip = $this->my_getenv("HTTP_CLIENT_IP");
                if (!$ip) {
                    $ip = $this->my_getenv("REMOTE_ADDR");
                }else{
                    $ip = 'Unknown';
                }
            }
        }
        return $ip;
    }
    
    /**
    * 获取Session数据
    * 
    * @param mixed $session_id
    */
    public function get_session($session_id='') {
        $session_id = preg_replace("/([^a-zA-Z0-9])/", "", $session_id);
        
        if ($session_id) {
            $where = "session_id='{$session_id}' and session_browser='".substr($this->user_agent,0,200)."' and session_ip='{$this->ip_address}'";
            $this->db->select('session_id,session_member_id,session_running_time');
            $query = $this->db->get_where('session',$where);
            $rs = $query->result_array();
            if (count($rs)>0) {
                $this->session_id = $rs[0]['session_id'];
                $this->session_user_id = $rs[0]['session_member_id'];
                $this->last_click = $rs[0]['session_running_time'];
            }else{
                $this->session_id = '';
                $this->session_user_id = 0;
            }
        }
    }
    
    /**
    * 删除用户登录记录
    * 
    */
    public function unload_member() {
        set_cookie('member_id',0);
        set_cookie('pass_hash','');
        
        $this->data = array('UID'=>0,'user'=>'','name'=>'','mgroup'=>0);
        $this->session_id = '';
        $this->session_user_id = 0;
    }
    
    /**
    * 加载用户资料至$this->data
    * 
    * @param mixed $member_id   用户ID
    */
    public function load_member($member_id=0) {
        if ($member_id>0) {
            $where = "UID = {$member_id} and enable=1";
            $rs = $this->db->get_where('users',$where)->result_array();
            if ($rs) {
                $this->data = $rs[0];
                
                $where = "id={$member_id}";
                $rs = $this->db->get_where('perm',$where)->result_array();
                if (count($rs)>0) {
                    $perm = $rs[0]['perm'];
                }else{
                    $perm = '';
                }
                if ($this->data['mgroup']) {
                    $gs = $this->db->select('perm')->get_where('group', array('id' => $this->data['mgroup']))->result_array();
                    if (count($gs)>0) {
                        $perm = $this->MergePerm($perm,$gs[0]['perm']);
                    }
                }
                $this->data['perm'] = $perm;
            }
        }
    }

    /**
     * 将多个权限字符串去重后返回新的
     * @since 20180623
     *
     * @return string
     */
    public function MergePerm() {
        $num = func_num_args();
        $args = func_get_args();
        $ret = '';
        if ($num>0) {
            if ($num>1) {
                $tmp = array();
                foreach($args as $v) {
                    if (is_string($v)) {
                        if ($v != '') {
                            $tmp = array_merge($tmp, explode(',', ltrim(trim($v), ',')));
                        }
                    }else if (is_array($v)){
                        foreach($v as $n) {
                            if (is_string($n)) {
                                $tmp = array_merge($tmp, explode(',', ltrim($n, ',')));
                            }
                        }
                    }
                }
                asort($tmp);
                $tmp = array_unique($tmp);
                $ret = ','.implode(',',$tmp);
            }else{
                $ret = $args[0];
            }
        }
        return $ret;
    }
    /**
    * 验证用户SESSION
    * 
    */
    public function auth() {
        $cookies = array();
        $list = array('session_id','member_id','pass_hash','save');
        foreach($list as $v) {
            $cookies[$v] = get_cookie($v);
        }
        $this->session_type = 'cookies';

        if (isset($_SESSION['session_id']) && ($_SESSION['session_id']<>'')) {
            $cookies['session_id'] = $_SESSION['session_id'];
        }else{
            $s = $this->input->get('s');
            if ($s) {
                $cookies['session_id'] = $s;
                $this->session_type = 'url';
            }else{
                $this->session_id = '';
            }           
        }

        if ($cookies['session_id']) {
            $this->get_session($cookies['session_id']);
        }
        
        if ($this->session_id && $this->session_user_id) {
            $this->load_member($this->session_user_id);

            if ($this->data['UID']<=0) {
                $this->unload_member();
                $this->session_user_id = 0;
                $this->session_id = '';
            }else{
                $this->update_member_session();
            }
        }else{
            unset($_SESSION['session_id']);
        }
        set_cookie('session_id',$this->session_id,86400);
        return $this->data;
    }
    
    /**
    * 更新用户session
    * 
    */
    public function update_member_session() {
        if (! $this->session_id) {
            $this->create_member_session();
            return;
        }
        if (!$this->data['UID']) {
            $this->unload_member();
            return;
        }
        $session_expiration = config_item('session_expiration');
        if (!$session_expiration) $session_expiration = 1800;
        if ((time()-$this->last_click > $session_expiration) && (get_cookie('save')<>'1')) {
            $this->unload_member();
            return;
        }

        $login_key_expire = config_item('login_key_expire');
        if (!$login_key_expire) $login_key_expire = 1;
        $expire = 86400*$login_key_expire;
        $key_expire = time() + $expire;
        set_cookie('pass_hash',$this->data['member_login_key'],$expire);
        
        $u = array('session_ip'=>$this->ip_address,
            'session_member_name' => $this->data['name'],
            'session_login_type' => $this->session_type,
            'session_running_time' => time(),
            'session_member_group' => $this->data['mgroup'],
        );
        $where = "session_id = '{$this->session_id}'";
        $this->db->update('session',$u,$where);
        
        $u = array('member_login_key_expire'=>$key_expire,
            'last_activity' => time(),
        );
        $where = "UID = {$this->data['UID']}";
        $this->db->update('users',$u,$where);
        
        $this->data['member_login_key_expire'] = $key_expire;
    }
}
