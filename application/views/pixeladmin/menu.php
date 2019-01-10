<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- 4. $MAIN_MENU =================================================================================

		Main menu
		
		Notes:
		* to make the menu item active, add a class 'active' to the <li>
		  example: <li class="active">...</li>
		* multilevel submenu example:
			<li class="mm-dropdown">
			  <a href="#"><span class="mm-text">Submenu item text 1</span></a>
			  <ul>
				<li>...</li>
				<li class="mm-dropdown">
				  <a href="#"><span class="mm-text">Submenu item text 2</span></a>
				  <ul>
					<li>...</li>
					...
				  </ul>
				</li>
				...
			  </ul>
			</li>
-->
<div id="main-menu" role="navigation">
    <div id="main-menu-inner">
        <div class="menu-content top" id="menu-content-demo">
            <!-- Menu custom content demo
                 CSS:        styles/pixel-admin-less/demo.less or styles/pixel-admin-scss/_demo.scss
                 Javascript: html/assets/demo/demo.js
             -->
            <div>
                <div class="text-bg"><span class="text-slim">Welcome,</span> <span class="text-semibold"><?php if (isset($this->name)) echo $this->name; ?></span></div>

                <img src="<?php echo config_item('base_url'); ?>public/pixeladmin/assets/demo/avatars/1.jpg" alt="" class="">
                <div class="btn-group">
                    <!--<a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a>-->
                    <!--<a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>-->
                    <a href="<?php echo $this->index; ?>/password" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
                    <a href="<?php echo $this->index; ?>/logout" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
                </div>
                <a href="#" class="close">&times;</a>
            </div>
        </div>
        <ul class="navigation">
            <?php
            if ($this->extary) {
                foreach ($this->extary['ORDER'] as $k => $v) {
                    if ($this->extary['VISIBLE'][$k]) { ?>
                        <li class="mm-dropdown">
                            <?php if ($this->extary['SUB'][$k]) { ?>
                                <a href="#"><i class="menu-icon fa fa-tasks"></i><span class="mm-text"><?php echo $this->extary['NAME'][$k]; ?></span></a>
                                <ul>
                                    <?php foreach ($this->extary['SUB'][$k] as $m => $n) {
                                        if ($this->extary['EXECUTE'][$m]) { ?>
                                            <li<?php if (strpos($m,$this->actt)!==false) echo ' class="active"'; ?>><a tabindex="-1" href='<?php echo $this->index; ?>/<?php echo $m; ?>' <?php if (isset($this->target[$m])) echo " target=\"{$this->target[$m]}\"";?>><span class="mm-text"><?php echo $n; ?></span></a></li>
                                        <?php }else{
                                            if (! $this->hideit) { ?>
                                                <li class="disabled"><a tabindex="-1" href='#'><?php echo $n; ?></a></li>
                                            <?php }
                                        }
                                    }?>
                                </ul>
                            <?php }else{ ?>
                                <a href='<?php echo $this->index; ?>/<?php echo $this->extary['ACT'][$k]; ?>'><i class="menu-icon fa fa-tasks"></i><span class="mm-text"><?php echo $this->extary['NAME'][$k]; ?></span></a>
                            <?php } ?>
                        </li>
                    <?php }
                }} ?>

        </ul> <!-- / .navigation -->
        <!--<div class="menu-content">
            <a href="pages-invoice.html" class="btn btn-primary btn-block btn-outline dark">Create Invoice</a>
        </div>-->
    </div> <!-- / #main-menu-inner -->
</div> <!-- / #main-menu -->
<!-- /4. $MAIN_MENU -->

<div id="content-wrapper">
    <?php if (isset($this->msg) && $this->msg) { ?>
    <div class="alert alert-info alert-dark">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>提示信息：</strong> <?php echo $this->msg; ?>
    </div>
    <?php } ?>
    <?php if (isset($this->err) && $this->err) { ?>
    <div class="alert alert-danger alert-dark">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>错误信息：</strong> <?php echo $this->err; ?>
    </div>
    <?php } ?>