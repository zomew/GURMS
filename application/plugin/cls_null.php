<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once('base.php');
/**
 * 插件模板示例
 * @author Jamers
 * @since 2016.5.14
 */
class cls_null extends base {
    /**
     * CI类
     *
     * @var mixed
     */
    public $CI;
    /**
     * 主操作符
     *
     * @var mixed
     */
    public $list = "null";
    /**
     * 模块名称
     * 主的权限名称也用这个，如果只有主权限，将有所有分权限
     *
     * @var mixed
     */
    public $name = "插件测试,权限001,权限002,权限003";
    /**
     * 对应模块分权限名称，
     * 用半角逗号将分别权限名称写上，便于权限管理，
     * 子权限字符限制为   “主操作符-分权限操作符” 后续会自动加上主操作符的
     *
     * @var mixed
     */
    public $perm = "001,002,003";
    /**
     * 管理员专用？
     *
     * @var mixed
     */
    public $admin = false;
    //以上4个值为必须，否则系统中将不会使用，还有autorun()函数也是必须的
    /**
    * 是否自定义输入，如果没输出将自动调用默认页面
    * 
    * @var mixed
    */
    public $is_output = false;
    
    /**
     * 是否自动加载信息
     *
     * @var mixed
     */
    public $auto_msg = false;
    /**
     * 需要显示的子菜单
     *
     * @var mixed
     */
    public $submenu = array('null' => '插件测试', 'null-001' => 'test1', 'null-003' => '测试3',);
    /**
     * 子菜单页面target
     *
     * @var mixed
     */
    public $target = array('null-003' => '_blank');
    public $order = 9999; //排序!
    /**
    * 此函数返回的字符串将会自动被默认控制器接管，如果需要自定义输出请将此返回值置空
    * 
    */
    function autorun() {
        //自动调用函数
        //这里也可以调用CORE中的任何过程或者变量，有权限控制时可以用下面的语句
        //这条语句的意思就是如果发现没有权限执行此应用直接返回FALSE
        if (!$this->CI->core->check_perm($this->CI->act,-1)) return false;
        $msg = "\$act:{$this->CI->act},此模块仅仅是个简单的示例，看如何扩展功能，详见 plugin/cls_null.php";
        return $msg;
    }
    function __construct() {
        $this->CI =& get_instance();
    }
    function auto_msg($ary) {
        //如果有这个函数，自动获取信息 返回值为PHP语句，返回后会EVAL执行的。所以，注意了！
        return "\$tmp = '';";
    }
}
?>
