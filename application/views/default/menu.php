<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav class="navbar navbar-default">
<div class='container'>
<div class="navbar-header">
    <button class="navbar-toggle collapsed" aria-expanded="false" aria-controls="bs-navbar" data-target="#bs-navbar" data-toggle="collapse" type="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <p class="navbar-brand"><?php if (isset($this->name)) echo $this->name; ?></p>
</div>
<div id="bs-navbar" class="navbar-collapse collapse">
<ul class="nav navbar-nav">
<li<?php if ($this->act == 'index') echo ' class="active"'; ?>><a href='/'>首页</a></li>

<?php
if ($this->extary) {
foreach ($this->extary['ORDER'] as $k => $v) {
if ($this->extary['VISIBLE'][$k]) { ?>
<li<?php if (strpos($k,$this->actt)>0) echo ' class="active"'; ?>>
<?php if ($this->extary['SUB'][$k]) { ?>
<a class="dropdown-toggle" aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" href="#"><?php echo $this->extary['NAME'][$k]; ?><span class="caret"></span></a>
<ul class="dropdown-menu">
<?php foreach ($this->extary['SUB'][$k] as $m => $n) {
if ($this->extary['EXECUTE'][$m]) { ?>
    <li><a href='<?php echo $this->index; ?>/<?php echo $m; ?>' <?php if (isset($this->target[$m])) echo " target=\"{$this->target[$m]}\"";?>><?php echo $n; ?></a></li>
<?php }else{
    if (! $this->hideit) { ?>
        <li class="disabled"><a href='#'><?php echo $n; ?></a></li>
<?php }
}
}?>
</ul>
<?php }else{ ?>
<a href='<?php echo $this->index; ?>/<?php echo $this->extary['ACT'][$k]; ?>'><?php echo $this->extary['NAME'][$k]; ?></a>
<?php } ?>
</li>
<?php }
}} ?>

<li<?php if ($this->act == 'password') echo ' class="active"'; ?>>
<a href='<?php echo $this->index; ?>/password'>密码修改</a>
</li>
<?php if ($this->admin) { ?>
<li<?php if (in_array($this->actt,array('users','group'))) echo ' class="active"'; ?>>
    <a class="dropdown-toggle" aria-expanded="false" aria-haspopup="true" role="button" data-toggle="dropdown" href="#" style="color:#ee0000;font-weight: 600;">系统管理<span class="caret"></span></a>
    <ul class="dropdown-menu">
        <li><a  href='<?php echo $this->index; ?>/users'>用户管理</a></li>
        <li><a  href='<?php echo $this->index; ?>/group'>用户组管理</a></li>
    </ul>
</li>
<?php } ?>
<li><a href='<?php echo $this->index; ?>/logout'>安全退出</a></li>
</ul>
</div></div>
</nav>
<div class="container theme-showcase" role="main">
<?php if (isset($this->msg) && $this->msg) { ?><div class="alert alert-success" role="alert"><?php echo $this->msg; ?></div><?php } ?>
<?php if (isset($this->err) && $this->err) { ?><div class="alert alert-danger" role="alert"><?php echo $this->err; ?></div><?php } ?>
</div>
