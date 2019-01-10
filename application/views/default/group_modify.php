<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><html>
<head>
<?php $this->load->view("{$this->themes}header"); ?>
</head>
<body>
<?php $this->load->view("{$this->themes}menu"); ?>
<div class="container theme-showcase" role="main">
<form name="modify" action="<?php echo config_item('php_self'); ?>" method="post">
<input type="hidden" name="act" value="<?php if ($modify) {echo "group-modify";}else{echo "group-add";} ?>">
<?php if ($modify) { ?><input type="hidden" name="id" value="<?php echo $data['id']; ?>"><?php } ?>
<table class='table table-striped'>
<tr><td>用户组名：</td><td><input type="text" name="name" value="<?php if ($modify) echo $data['name']; ?>"><br></td></tr>
<tr><td>生效：</td><td><input name="status" type="checkbox" value="1" <?php if ($modify){ if ($data['status']) {echo 'checked';}}else{echo 'checked';}?>><br></td></tr>
<tr><td>备注：</td><td><input name="memo" type="text" value="<?php if ($modify) echo $data['memo'];?>"><br></td></tr>
<tr><td colspan='2'><input type="submit" value="提交"></td></tr></table>
</form>
</div>
<?php $this->load->view("{$this->themes}footer"); ?>
</body>
</html>