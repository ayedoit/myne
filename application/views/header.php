<?php
 header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
  <head>
        <title>myne</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.css">
<!--
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.DataTable.css">
-->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>

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
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="<?= base_url() ?>">myne</a>
          <div class="nav-collapse collapse">
			<ul class="nav">
				<li <?php $class = (current_url() == base_url()) ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>">Home</a></li>
				<!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
				<li class="dropdown <?php $class = (current_url() == base_url('devices')) ? 'active': ""; echo $class; ?>">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Geräte <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="<?= base_url('devices') ?>">Alle Geräte</a></li>
					<li><a href="<?= base_url('devices/groups') ?>">Gruppen</a></li>
					<li class="divider"></li>
					<li class="nav-header">Verwaltung</li>
					<li><a href="<?= base_url('devices/add/new') ?>">Gerät anlegen</a></li>
				  </ul>
				</li>
			</ul>
            <p class="navbar-text pull-right">
              <a href="#" class="navbar-link">Username</a>
            </p>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
