<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->load->view("{$this->themes}header"); ?>

<?php $this->load->view("{$this->themes}menu"); ?>


<form action="<?php echo config_item('php_self'); ?>" method="post">
<input type="hidden" name="act" value="group-permission">
<input type="hidden" name="id" value="<?php echo $this->id; ?>">
<table class='table table-striped'>
<tr><th>现在正在修改用户组 <?php echo "({$data['name']})"; ?> 的模块权限<br>备注：<?php echo $data['memo']; ?></th></tr>

<?php
if ($this->extary['NAME']) {
foreach ($this->extary['NAME'] as $k => $v): ?>
<tr><td class='perm'><input type="checkbox" name="check[]" value="<?php echo $this->extary['ACT'][$k]; ?>" <?php if ($checked[$this->extary['ACT'][$k]]) echo 'checked'; ?>><?php echo $v; ?> <br></td></tr>
<?php if (isset($this->extary['PERM'][$k])) { ?>
<tr><td class='perm'>&nbsp;&nbsp;&nbsp;&nbsp;
<?php foreach ($this->extary['PERM'][$k] as $x => $y): ?>
<input type="checkbox" name="check[]" value="<?php echo $x; ?>" <?php if ($checked[$x]) echo 'checked';?>><?php echo $y; ?>  
<?php endforeach; ?>
</td></tr>
<?php }
endforeach; ?>
<tr><td><input type="submit" value="提交"></td></tr>
<?php }else{ ?>
<tr><td>系统内暂无相应模块权限设置！</td></tr>
<?php } ?>
</table>
</form>


<?php $this->load->view("{$this->themes}footer"); ?>
