<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if IE 8]> <html class="ie8"> <![endif]-->
<!--[if IE 9]> <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php if ($title) echo $title; ?>系统登录</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Open Sans font from Google CDN -->
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">-->

    <!-- Pixel Admin's stylesheets -->
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
    <script src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/javascripts/ie.min.js"></script>
    <![endif]-->


    <!-- $DEMO =========================================================================================
    
        Remove this section on production
    -->
    <style>
        #signin-demo {
            position: fixed;
            right: 0;
            bottom: 0;
            z-index: 10000;
            background: rgba(0,0,0,.6);
            padding: 6px;
            border-radius: 3px;
        }
        #signin-demo img { cursor: pointer; height: 40px; }
        #signin-demo img:hover { opacity: .5; }
        #signin-demo div {
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding-bottom: 6px;
        }
        .form-actions {
            text-align: center;
        }
    </style>
    <!-- / $DEMO -->

</head>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-default page-signin">

<script>
    var init = [];
    init.push(function () {
        var $div = $('<div id="signin-demo" class="hidden-xs"></div>'),
            bgs  = [ 'assets/demo/signin-bg-1.jpg', 'assets/demo/signin-bg-2.jpg', 'assets/demo/signin-bg-3.jpg',
                'assets/demo/signin-bg-4.jpg', 'assets/demo/signin-bg-5.jpg', 'assets/demo/signin-bg-6.jpg',
                'assets/demo/signin-bg-7.jpg', 'assets/demo/signin-bg-8.jpg', 'assets/demo/signin-bg-9.jpg' ];
        for (var i=0, l=bgs.length; i < l; i++) $div.append($('<img src="' + "<?php echo config_item('base_url'); ?>public/pixeladmin/"+bgs[i] + '">'));
        $div.find('img').click(function () {
            var img = new Image();
            img.onload = function () {
                $('#page-signin-bg > img').attr('src', img.src);
                $(window).resize();
            }
            img.src = $(this).attr('src');
        });
        $('body').append($div);
    });
</script>

<!-- Page background -->
<div id="page-signin-bg">
    <!-- Background overlay -->
    <div class="overlay"></div>
    <!-- Replace this with your bg image -->
    <img src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/demo/signin-bg-1.jpg" alt="">
</div>
<!-- / Page background -->

<!-- Container -->
<div class="signin-container">

    <!-- Left side -->
    <div class="signin-info">
        <!--<a href="index.html" class="logo">-->
        <span class="logo">
            <img src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/demo/logo-big.png" alt="" style="margin-top: -5px;">&nbsp;
            PixelAdmin
        </span>
        <!--</a> --><!-- / .logo -->
        <div class="slogan">
            Simple. Flexible. Powerful.
        </div> <!-- / .slogan -->
        <ul>
            <li><i class="fa fa-sitemap signin-icon"></i> Flexible modular structure</li>
            <li><i class="fa fa-file-text-o signin-icon"></i> LESS &amp; SCSS source files</li>
            <li><i class="fa fa-outdent signin-icon"></i> RTL direction support</li>
            <li><i class="fa fa-heart signin-icon"></i> Crafted with love</li>
        </ul> <!-- / Info list -->
    </div>
    <!-- / Left side -->

    <!-- Right side -->
    <div class="signin-form">

        <!-- Form -->
        <form action="<?php echo config_item('php_self'); ?>" id="signin-form_id" method="post">
            <?php echo form_hidden(array('act'=>'login')); ?>
            <div class="signin-text">
                <span>轻松开启后台管理新方式</span>
            </div> <!-- / .signin-text -->

            <div class="form-group w-icon">
                <input type="text" name="uuser" id="username_id" class="form-control input-lg" placeholder="请输入用户名">
                <span class="fa fa-user signin-form-icon"></span>
            </div> <!-- / Username -->

            <div class="form-group w-icon">
                <input type="password" name="pass" id="password_id" class="form-control input-lg" placeholder="请输入密码">
                <span class="fa fa-lock signin-form-icon"></span>
            </div> <!-- / Password -->

            <div class="form-group w-icon input-group">
                <span class="input-group-addon" style="background-color: transparent;">
                    <label class="px-single"><input type="checkbox" name="save" value="1" class="px" id="save"><span class="lbl"></span></label>
                </span>
                <label class="form-control" for="save" style="font-weight:100;color:#666;padding-left:15px;">自动登录？</label>
            </div>

            <div class="form-actions">
                <input type="submit" value="登录" class="signin-btn bg-primary">
            </div> <!-- / .form-actions -->
        </form>
        <!-- / Form -->

        <!-- Password reset form -->
        <div class="password-reset-form" id="password-reset-form">
            <div class="header">
                <div class="signin-text">
                    <span>Password reset</span>
                    <div class="close">&times;</div>
                </div> <!-- / .signin-text -->
            </div> <!-- / .header -->

            <!-- Form -->
            <form action="index.html" id="password-reset-form_id">
                <div class="form-group w-icon">
                    <input type="text" name="password_reset_email" id="p_email_id" class="form-control input-lg" placeholder="Enter your email">
                    <span class="fa fa-envelope signin-form-icon"></span>
                </div> <!-- / Email -->

                <div class="form-actions">
                    <input type="submit" value="SEND PASSWORD RESET LINK" class="signin-btn bg-primary">
                </div> <!-- / .form-actions -->
            </form>
            <!-- / Form -->
        </div>
        <!-- / Password reset form -->
    </div>
    <!-- Right side -->
</div>
<!-- / Container -->

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
<script type="text/javascript"> window.jQuery || document.write('<script src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/javascripts/jquery-1.8.3.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
<script type="text/javascript"> window.jQuery || document.write('<script src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/javascripts/jquery-1.8.3.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/javascripts/bootstrap.min.js"></script>
<script src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/javascripts/pixel-admin.min.js"></script>

<script type="text/javascript">
    // Resize BG
    init.push(function () {
        var $ph  = $('#page-signin-bg'),
            $img = $ph.find('> img');

        $(window).on('resize', function () {
            $img.attr('style', '');
            if ($img.height() < $ph.height()) {
                $img.css({
                    height: '100%',
                    width: 'auto'
                });
            }
        });
    });

    // Show/Hide password reset form on click
    init.push(function () {
        $('#forgot-password-link').click(function () {
            $('#password-reset-form').fadeIn(400);
            return false;
        });
        $('#password-reset-form .close').click(function () {
            $('#password-reset-form').fadeOut(400);
            return false;
        });
    });

    // Setup Sign In form validation
    init.push(function () {
        $("#signin-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

        // Validate username
        $("#username_id").rules("add", {
            required: true,
            minlength: 3
        });

        // Validate password
        $("#password_id").rules("add", {
            required: true,
            minlength: 4
        });
    });

    // Setup Password Reset form validation
    init.push(function () {
        $("#password-reset-form_id").validate({ focusInvalid: true, errorPlacement: function () {} });

        // Validate email
        $("#p_email_id").rules("add", {
            required: true,
            email: true
        });
    });
    <?php if ($msg) { ?>
    init.push(function() {
        $(function(){
            $.growl({ title:"错误消息：", style:"error", message: "<?php echo $msg; ?>", duration: 20*1000, size: 'large' });
        });
    });
    <?php } ?>
    window.PixelAdmin.start(init);
</script>

</body>
</html>