<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 当前页面访问链接
 */
if (isset($_SERVER['PHP_SELF'])){
    $config['php_self'] = $_SERVER['PHP_SELF'];
}else{
    $config['php_self'] = $_SERVER['SCRIPT_NAME'];
}

/**
 * 系统标题
 *
 * @var mixed
 */
$config['system_title'] = '通用权限控制系统';
/**
 * 登录密钥过期天数
 *
 * @var mixed
 */
$config['login_key_expire'] = 1;

/**
 * session失效时间，1800秒
 *
 * @var mixed
 */
$config['session_expiration'] = 1800;

/**
 * 模板名称，默认default
 *
 * @var string
 */
$config['themes'] = 'pixeladmin';