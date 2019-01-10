<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><html>
<head>
<title><?php if ($title) echo $title; ?>系统登录</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo config_item('base_url'); ?>public/css/style.css" rel="stylesheet" type="text/css" />
</head>
<BODY BACKGROUND="<?php echo config_item('base_url'); ?>public/images/body_bg.jpg" BGCOLOR="#CCCCFF">

<P>
<form name="loginform" action="<?php echo config_item('php_self'); ?>" method="post" />
<?php echo form_hidden(array('act'=>'login')); ?>

<span class="ln" >用户名：</span>
<span class="lp" >密&nbsp;&nbsp;码：</span>
<span >&nbsp;<?php if ($msg) echo $msg; ?></span>
<?php echo form_input('uuser','',array('class'=>'user')); ?>
<?php echo form_password('pass','',array('class'=>'pwd')); ?>
<label class='Lb'>
<?php echo form_checkbox('save','1'); ?>
自动登录
</label><br/>
<input type="submit" name="submit" value="登录" class='Sub'>
<?php echo form_close(); ?>

</BODY>
</html>