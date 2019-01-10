<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 附加辅助函数模块
* 
* @author Jamers
* @since 2016.5.14
* @license    http://opensource.org/licenses/MIT    MIT License
*/
if (! function_exists('get_current_url')) {
    /**
    * 获取当前链接
    * 
    * @param mixed $getfull 是否获取参数
    * @return string
    */
    function get_current_url($getfull=true) {
        return (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https')===false ? 'http' : 'https') . '://' . $_SERVER['HTTP_HOST'] . ($getfull ? $_SERVER['REQUEST_URI'] : $_SERVER['SCRIPT_NAME']);
    }
}

if (! function_exists('get_request_value')) {
    /**
    * 获取浏览器提交数据(含POST/GET/COOKIE)
    * 
    * @param mixed $name
    * @return mixed
    */
    function get_request_value($name='act') {
        if (isset($_REQUEST[$name])) {
            return $_REQUEST[$name];
        }
        return null;
    }
}
?>
