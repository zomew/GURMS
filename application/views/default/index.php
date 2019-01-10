<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><html>
<head>
<?php $this->load->view("{$this->themes}header"); ?>
</head>
<body>
<?php $this->load->view("{$this->themes}menu"); ?>
<div class="container theme-showcase" role="main">
<br><br>欢迎使用<?php echo $this->title; ?>，请根据您的需求选择相应功能。
</div>
<?php $this->load->view("{$this->themes}footer"); ?>
</body>
</html>
