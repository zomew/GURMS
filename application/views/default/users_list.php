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
if ($k == 'UID') {$id=$v;}?>
<td><?php
if (($v === NULL) || ($v == '')) {
    echo "&nbsp;";
}else{
    switch ($k) {
        case 'lastlogin':
            echo date('Y-m-d H:i:s',$v);
            break;
        case 'mgroup':
            echo $v && isset($group[$v])?$group[$v]:'---';
            break;
        default:
            echo $v;
            break;
    }
}?>
</td>
<?php endforeach; ?>
<td><a href='<?php echo $this->index; ?>/users/modify/<?php echo $id; ?>'>编辑</a> <a href='#' onclick="javascript:if(confirm('你确定需要执行删除帐号吗？\r\n')) { window.location.href='<?php echo $this->index; ?>/users/del/<?php echo $id; ?>'; } else { return false; }">删除</a> <a href='<?php echo $this->index; ?>/users/permission/<?php echo $id; ?>'>权限</a></td>
</tr>
<?php endforeach;
}else{ ?>
    <tr><td colspan='<?php echo count($list); ?>'>none data</td></tr>
<?php } ?>
<tr><td colspan='<?php echo count($list); ?>'><a href='<?php echo $this->index; ?>/users/add'>新增</a></td></tr>
</table>
</div>
<?php $this->load->view("{$this->themes}footer"); ?>
</body>
</html>