<?php
 header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html class="ui-mobile">
  <head>
        <title>myne</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.css">
<!--
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.DataTable.css">
-->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>
        <script src="http://code.jquery.com/mobile/1.3.1/jquery.mobile-1.3.1.js"></script>

        <script src="<?= base_url() ?>js/myne.js"></script>
        <script src="<?= base_url() ?>js/jquery.validate.js"></script>
        <script src="<?= base_url() ?>js/bootstrap.js"></script>
<!--
        <script src="<?= base_url() ?>js/jquery.dataTables.js"></script>
        <script src="<?= base_url() ?>js/jquery.dataTables.plugins.js"></script>
-->
		
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
  </head>
  <body class="ui-mobile-viewport ui-overlay-a">
	 <div data-role="header" data-theme="c">
		 <div data-role="navbar"> 
			<ul>  
				<li><a href="<?= base_url('devices') ?>" data-role="button" data-iconpos="right" data-icon="home">myne</a></li>
				<li><a href="<?= base_url('devices') ?>" data-iconpos="left" data-icon="gear">Geräte</a></li>
				<li><a href="<?= base_url('devices/groups') ?>" data-iconpos="left" data-icon="grid">Gruppen</a></li>
			</ul>
		</div>
	</div>
