<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 用户登录控制器
* @author Jamers
* @since 2016.5.13
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Hello extends MY_Controller {
    public function index() {
        echo get_current_url();
    }
}

