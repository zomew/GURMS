<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
    </div>
    <div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->
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
    init.push(function () {
        // Javascript code here
    })
    window.PixelAdmin.start(init);
</script>

</body>
</html>