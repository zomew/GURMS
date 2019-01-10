<?php
abstract class base {
    var $core;
    var $list = '';
    var $name = '';
    var $perm = '';
    var $admin = 0;
    var $auto_msg = false;
    
    abstract function autorun();
    abstract function auto_msg($ary);
}