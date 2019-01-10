<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view("{$this->themes}header"); ?>

<?php $this->load->view("{$this->themes}menu"); ?>


<script type=text/javascript>
function check() {
    var op=document.modify.opass.value;
    var p1=document.modify.pass1.value;
    var p2=document.modify.pass2.value;
    if (op == "") {
        alert('原密码未输入');
        return;
    }
    if ((p1=="") || (p2=="")) {
        alert('新密码未输入');
        return;
    }
    if (p1 != p2) {
        alert('两次输入的新密码不一致');
        return;
    }
    if (op == p1) {
        alert('新旧密码一致，不需要修改');
        return;
    }
    document.modify.submit();
}
</script>
<form name="modify" action="<?php echo config_item('php_self'); ?>" method="post">
<?php echo form_hidden(array('act'=>'pass-update')); ?>
<table class='dataintable'>
<tr><td>原密码：</td><td><input type="password" name="opass" value=""><br></td></tr>
<tr><td>新密码：</td><td><input type="password" name="pass1" value=""><br></td></tr>
<tr><td>确&nbsp;&nbsp;认：</td><td><input type="password" name="pass2" value=""><br></td></tr>
<tr><td colspan='2'><input type="button" onclick="check()" value="提交"></td></tr></table>
</form>

<?php $this->load->view("{$this->themes}footer"); ?>
