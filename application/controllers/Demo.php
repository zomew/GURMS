<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 用户登录控制器
* @author Jamers
* @since 2016.5.13
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Demo extends MY_Controller {
    /**
     * 主操作符
     *
     * @var mixed
     */
    public static $_list = __CLASS__;
    /**
     * 模块名称
     * 主的权限名称也用这个，如果只有主权限，将有所有分权限
     *
     * @var mixed
     */
    public static $_name = "控制器测试,权限001,权限002,权限003";
    /**
     * 对应模块分权限名称，
     * 用半角逗号将分别权限名称写上，便于权限管理，
     * 子权限字符限制为   “主操作符-分权限操作符” 后续会自动加上主操作符的
     *
     * @var mixed
     */
    public static $_perm = "test,abc,s3";
    /**
     * 管理员专用？
     *
     * @var mixed
     */
    public static $_admin = false;
    /**
     * 需要显示的子菜单
     *
     * @var mixed
     */
    public static $_submenu = array('Demo' => '控制器测试', 'Demo/test' => 'test1', 'Demo/s3' => '测试3',);
    /**
     * 子菜单页面target
     *
     * @var mixed
     */
    public static $_target = array('Demo/s3' => '_blank');
    public static $_order = 1; //排序!

    public function index() {
        $this->msg = __CLASS__.'自定义控制器测试';
        $this->load->view($this->themes.'index');
    }

    public function test() {
        $this->msg = __CLASS__.'自定义控制器测试'.$this->act;
        $this->load->view($this->themes.'index');
    }
    public function s3() {
        exit(date('Y-m-d H:i:s'));
    }
}

