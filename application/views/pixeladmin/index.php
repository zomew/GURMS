<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view("{$this->themes}header"); ?>

<?php $this->load->view("{$this->themes}menu"); ?>

欢迎使用<?php echo $this->title; ?>，请根据您的需求选择相应功能。

<?php $this->load->view("{$this->themes}footer"); ?>

