<?php
class Gurms extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * 获取模板目录设置
     *
     * @return mixed|string
     */
    public function getThemes() {
        $this->config->load('gurms.php',false,true);
        $themes = config_item('themes');
        if ($themes && file_exists(APPPATH."views/{$themes}/login.php")) {
            $themes = $themes.'/';
        }else{
            if (!file_exists(APPPATH."views/{$themes}/login.php") && file_exists(APPPATH."views/login.php")) {
                $themes = '';
            }else{
                exit('模板文件未找到！');
            }
        }
        return $themes;
    }
}

