<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><html>
<head>
<?php $this->load->view("{$this->themes}header"); ?>
</head>
<body>
<?php $this->load->view("{$this->themes}menu"); ?>
<div class="container theme-showcase" role="main">
<table class='table table-striped'>
<tr>
<?php foreach ($list as $k => $v): ?>
<th width="<?php echo $width[$k]; ?>"><?php echo $v; ?></th>
<?php endforeach; ?>
</tr>

<?php
if ($data) {
foreach ($data as $rs): ?>
<tr>
<?php foreach ($list as $k=>$x):
if ($k == 'manage') continue;
if (isset($rs[$k])) {
    $v = $rs[$k];
}else{
    $v = '';
}
if ($k == 'id') {$id=$v;}?>
<td><?php
if (($v === NULL) || ($v == '')) {
    echo "&nbsp;";
}else{
    if ($k == 'status') {
        echo $v?'有效':'禁用';
    }else{
        echo $v;
    }
}?>
</td>
<?php endforeach; ?>
<td><a href='<?php echo $this->index; ?>/group/modify/<?php echo $id; ?>'>编辑</a> <a href='#' onclick="javascript:if(confirm('你确定需要删除用户组吗？\r\n')) { window.location.href='<?php echo $this->index; ?>/group/del/<?php echo $id; ?>'; } else { return false; }">删除</a> <a href='<?php echo $this->index; ?>/group/permission/<?php echo $id; ?>'>权限</a></td>
</tr>
<?php endforeach;
}else{ ?>
    <tr><td colspan='<?php echo count($list); ?>'>none data</td></tr>
<?php } ?>
<tr><td colspan='<?php echo count($list); ?>'><a href='<?php echo $this->index; ?>/group/add'>新增</a></td></tr>
</table>
</div>
<?php $this->load->view("{$this->themes}footer"); ?>
</body>
</html>