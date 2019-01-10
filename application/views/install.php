<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><html>
<head>
<title><?php echo config_item('system_title'); ?>安装</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo config_item('base_url'); ?>public/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<script type=text/javascript>
function check() {
    var p1=document.install1.password1.value;
    var p2=document.install1.password2.value;
    if ((p1=="") || (p2=="")) {
        alert('密码未输入');
        return;
    }
    if (p1 != p2) {
        alert('两次输入的密码不一致');
        return;
    }
    document.install1.submit();
    return true;
}
</script>
<form name="install1" id="install" action="<?php echo config_item('php_self'); ?>" method="post">
<input type="hidden" name="step" value="1">
<table class="dataintable">
<tr><th colspan="2">Mysql数据库连接信息<br></th></tr>
<tr><td>数据库IP：</td><td><input type='text' name='host' id='host' value='localhost'><br></td></tr>
<tr><td>用户名：</td><td><input type='text' name='user' id='user' value='gurms'><br></td></tr>
<tr><td>密码：</td><td><input type='password' name='pass' id='pass' value='gurms'><br></td></tr>
<tr><td>数据库名：</td><td><input type='text' name='name' id='name' value='gurms'><br></td></tr>
<tr><td>表前缀：</td><td><input type='text' name='prefix' id='prefix' value='gs_'><br></td></tr>
<tr><td colspan='2'><label><input type='checkbox' name='clean' value='1'>如果有数据先清空</label><br></td></tr>
<tr><th colspan='2'>管理员帐号<br></th></tr>
<tr><td>用户名：</td><td><input type='text' name='admin' value='admin'><br></td></tr>
<tr><td>密码：</td><td><input type='password' name='password1'><br></td></tr>
<tr><td>较验：</td><td><input type='password' name='password2'><br></td></tr>
<tr><td colspan='2'><input type='button' value='提交' onclick='check();'></td></tr>
</table>
</form>
</body>
</html>