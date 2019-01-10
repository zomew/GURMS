<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php $this->load->view("{$this->themes}header"); ?>

<?php $this->load->view("{$this->themes}menu"); ?>

<form name="modify" action="<?php echo config_item('php_self'); ?>" method="post">
<input type="hidden" name="act" value="<?php if ($modify) {echo "users-modify";}else{echo "users-add";} ?>">
<?php if ($modify) { ?><input type="hidden" name="uid" value="<?php echo $data['UID']; ?>"><?php } ?>
<table class='table table-striped'>
<tr><td>用户名：</td><td><input type="text" name="uname" value="<?php if ($modify) echo $data['user']; ?>"><br></td></tr>
<tr><td>密码：</td><td><input type="password" name="pass" value=""><br></td></tr>
<tr><td>姓名：</td><td><input type="text" name="name" value="<?php if ($modify) echo $data['name']; ?>"><br></td></tr>
<tr><td>生效：</td><td><input name="enable" type="checkbox" value="1" <?php if ($modify){ if ($data['enable']) {echo 'checked';}}else{echo 'checked';}?>><br></td></tr>
<tr><td>管理员：</td><td><input name="isadmin" type="checkbox" value="1" <?php if ($modify) {if ($data['isadmin']) echo 'checked';}?>><br></td></tr>
<tr><td>WTID：</td><td><input name="wtid" type="text" value="<?php if ($modify) echo $data['wtid'];?>"><br></td></tr>
<tr><td>用户组：</td><td>
        <select name="mgroup">
            <option value="">请选择用户组</option>
            <?php foreach($group as $k => $v) { ?>
            <option value="<?php echo $k; ?>" <?php if ($modify && $data['mgroup']== $k) echo 'selected'; ?>><?php echo $v; ?></option>
            <?php } ?>
        </select>
    </td></tr>
<tr><td colspan='2'><input type="submit" value="提交"></td></tr></table>
</form>

<?php $this->load->view("{$this->themes}footer"); ?>
