<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<nav class="navbar navbar-default navbar-fixed-bottom">
<div class="container">
<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds. <?php echo  (ENVIRONMENT === 'development') ?  'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?> <i>Authored by Jamers</i></p>
</div></nav>
<script type="text/javascript" src="<?php echo config_item('base_url'); ?>public/css/bootstrap/js/bootstrap.min.js"></script>
