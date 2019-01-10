<?php
class Test_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function hello($name) {
        return "Hello {$name}!";
    }
}

