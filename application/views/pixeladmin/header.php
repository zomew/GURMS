<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--

TABLE OF CONTENTS.

Use search to find needed section.

===================================================================

|  1. $BODY                        |  Body                        |
|  2. $MAIN_NAVIGATION             |  Main navigation             |
|  3. $NAVBAR_ICON_BUTTONS         |  Navbar Icon Buttons         |
|  4. $MAIN_MENU                   |  Main menu                   |
|  5. $UPLOADS_CHART               |  Uploads chart               |
|  6. $EASY_PIE_CHARTS             |  Easy Pie charts             |
|  7. $EARNED_TODAY_STAT_PANEL     |  Earned today stat panel     |
|  8. $RETWEETS_GRAPH_STAT_PANEL   |  Retweets graph stat panel   |
|  9. $UNIQUE_VISITORS_STAT_PANEL  |  Unique visitors stat panel  |
|  10. $SUPPORT_TICKETS            |  Support tickets             |
|  11. $RECENT_ACTIVITY            |  Recent activity             |
|  12. $NEW_USERS_TABLE            |  New users table             |
|  13. $RECENT_TASKS               |  Recent tasks                |

===================================================================

-->


<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $this->title; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

    <!-- Open Sans font from Google CDN -->
    <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">-->

    <!-- Pixel Admin's stylesheets -->
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
    <script src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/javascripts/ie.min.js"></script>
    <![endif]-->
</head>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'      - Sets text direction to right-to-left
	* 'main-menu-right'    - Places the main menu on the right side
	* 'no-main-menu'       - Hides the main menu
	* 'main-navbar-fixed'  - Fixes the main navigation
	* 'main-menu-fixed'    - Fixes the main menu
	* 'main-menu-animated' - Animate main menu
-->
<body class="theme-default main-menu-animated main-navbar-fixed main-menu-fixed">





<script>var init = [];</script>
<!-- Demo script -->
<!--<script src="<?php /*echo config_item('base_url'); */?>public/pixeladmin/assets/demo/demo.js"></script> -->
<!-- / Demo script -->

<div id="main-wrapper">


    <!-- 2. $MAIN_NAVIGATION ===========================================================================
    
        Main navigation
    -->
    <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
        <!-- Main menu toggle -->
        <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>

        <div class="navbar-inner">
            <!-- Main navbar header -->
            <div class="navbar-header">

                <!-- Logo -->
                <a href="<?php echo config_item('base_url'); ?>" class="navbar-brand">
                    <div><img alt="Pixel Admin" src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/images/pixel-admin/main-navbar-logo.png"></div>
                    PixelAdmin
                </a>

                <!-- Main navbar toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

            </div> <!-- / .navbar-header -->

            <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
                <div>
                    <ul class="nav navbar-nav">
                        <li>
                            <a href="/">首页</a>
                        </li>
                        <?php if ($this->admin) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:red;font-weight:600;">系统管理</a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo $this->index; ?>/users">用户管理</a></li>
                                <li><a href="<?php echo $this->index; ?>/group">用户组管理</a></li>
                                <!--<li class="divider"></li>
                                <li><a href="#">Third item</a></li>-->
                            </ul>
                        </li>
                        <?php } ?>
                    </ul> <!-- / .navbar-nav -->

                    <div class="right clearfix">
                        <ul class="nav navbar-nav pull-right right-navbar-nav">

                            <!-- 3. $NAVBAR_ICON_BUTTONS =======================================================================
                            
                                                        Navbar Icon Buttons
                            
                                                        NOTE: .nav-icon-btn triggers a dropdown menu on desktop screens only. On small screens .nav-icon-btn acts like a hyperlink.
                            
                                                        Classes:
                                                        * 'nav-icon-btn-info'
                                                        * 'nav-icon-btn-success'
                                                        * 'nav-icon-btn-warning'
                                                        * 'nav-icon-btn-danger' 
                            -->
                            <li class="nav-icon-btn nav-icon-btn-danger dropdown">
                                <a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="label">0</span>
                                    <i class="nav-icon fa fa-bullhorn"></i>
                                    <span class="small-screen-text">提醒通知</span>
                                </a>

                                <!-- NOTIFICATIONS -->

                                <!-- Javascript -->
                                <script>
                                    init.push(function () {
                                        $('#main-navbar-notifications').slimScroll({ height: 250 });
                                    });
                                </script>
                                <!-- / Javascript -->

                                <div class="dropdown-menu widget-notifications no-padding" style="width: 300px">
                                    <div class="notifications-list" id="main-navbar-notifications">
                                        <!--
                                        <div class="notification">
                                            <div class="notification-title text-danger">SYSTEM</div>
                                            <div class="notification-description"><strong>Error 500</strong>: Syntax error in index.php at line <strong>461</strong>.</div>
                                            <div class="notification-ago">12h ago</div>
                                            <div class="notification-icon fa fa-hdd-o bg-danger"></div>
                                        </div>
                                        -->
                                    </div> <!-- / .notifications-list -->
                                    <a href="#" class="notifications-link">更多提醒……</a>
                                </div> <!-- / .dropdown-menu -->
                            </li>
                            <li class="nav-icon-btn nav-icon-btn-success dropdown">
                                <a href="#messages" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="label">0</span>
                                    <i class="nav-icon fa fa-envelope"></i>
                                    <span class="small-screen-text">收到信息</span>
                                </a>

                                <!-- MESSAGES -->

                                <!-- Javascript -->
                                <script>
                                    init.push(function () {
                                        $('#main-navbar-messages').slimScroll({ height: 250 });
                                    });
                                </script>
                                <!-- / Javascript -->

                                <div class="dropdown-menu widget-messages-alt no-padding" style="width: 300px;">
                                    <div class="messages-list" id="main-navbar-messages">
                                        <!--
                                        <div class="message">
                                            <img src="<?php /*echo config_item('base_url'); */?>public/pixeladmin/assets/demo/avatars/2.jpg" alt="" class="message-avatar">
                                            <a href="#" class="message-subject">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</a>
                                            <div class="message-description">
                                                from <a href="#">Robert Jang</a>
                                                &nbsp;&nbsp;·&nbsp;&nbsp;
                                                2h ago
                                            </div>
                                        </div>
                                        -->
                                    </div> <!-- / .messages-list -->
                                    <a href="#" class="messages-link">更多信息……</a>
                                </div> <!-- / .dropdown-menu -->
                            </li>
                            <!-- /3. $END_NAVBAR_ICON_BUTTONS -->
                            <!--
                            <li>
                                <form class="navbar-form pull-left">
                                    <input type="text" class="form-control" placeholder="Search">
                                </form>
                            </li>
                            -->
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                    <img src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/demo/avatars/1.jpg" alt="">
                                    <span><?php if (isset($this->name)) echo $this->name; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="<?php echo $this->index; ?>/password">修改密码</a></li>
                                    <!--<li><a href="#"><span class="badge badge-primary pull-right">New</span>Account</a></li>
                                    <li><a href="#"><i class="dropdown-icon fa fa-cog"></i>&nbsp;&nbsp;Settings</a></li>-->
                                    <li class="divider"></li>
                                    <li><a href="<?php echo $this->index; ?>/logout"><i class="dropdown-icon fa fa-power-off"></i>退出登录</a></li>
                                </ul>
                            </li>
                        </ul> <!-- / .navbar-nav -->
                    </div> <!-- / .right -->
                </div>
            </div> <!-- / #main-navbar-collapse -->
        </div> <!-- / .navbar-inner -->
    </div> <!-- / #main-navbar -->
    <!-- /2. $END_MAIN_NAVIGATION -->
