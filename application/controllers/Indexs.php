<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 首页控制器，无效模块均跳转至此模块
* @author Jamers
* @since 2016.5.17
* @license    http://opensource.org/licenses/MIT    MIT License
*/
class Indexs extends MY_Controller {

	public function index()
	{
        if (isset($_SESSION['msg'])) {
            $this->msg = "<br>{$_SESSION['msg']}";
            unset($_SESSION['msg']);
        }
        $is_output = true;

        if ($this->act != 'indexs') {
            //非正常入口，检查是否是有插件
            $a = explode('-',$this->act);
            $cls = "cls_{$a[0]}";
            if (class_exists($cls)) {
                $mod = new $cls;
                if (isset($mod->is_output)) {
                    $is_output = $mod->is_output;
                }
                $this->msg .= $mod->autorun();
                unset($mod);
            }else{
                $this->err = "无效操作！操作符：{$this->act}";
            }
            if ((! $is_output) || ($this->msg) || ($this->err)) {
                $this->load->view($this->themes.'index');
            }
        }else{
            $this->load->view($this->themes.'index');
        }
        
	}
}
