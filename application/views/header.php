<?php
 header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
  <head>
        <title>myne</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap-editable.css">
<!--
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.DataTable.css">
        
-->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>
        
        <script src="<?= base_url() ?>js/myne.js"></script>
        <script src="<?= base_url() ?>js/jquery.validate.js"></script>
        <script src="<?= base_url() ?>js/bootstrap.js"></script>
        <script src="<?= base_url() ?>js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?= base_url() ?>js/bootstrap-editable.js"></script>
<!--
        <script src="<?= base_url() ?>js/jquery.dataTables.js"></script>
        <script src="<?= base_url() ?>js/jquery.dataTables.plugins.js"></script>
-->

        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=<?php echo config_item('charset');?>" />
        <link rel="icon" href="<?=base_url()?>/img/favicon.ico">
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner-myne">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="nav-collapse collapse">
			<ul class="nav">
				<li><a class="brand logo" href="<?= base_url('devices') ?>"><img src="<?= base_url('img/myne_logo_h40.png'); ?>" alt="myne" /></a></li>
				<!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
				<li class="dropdown <?php $class = (current_url() == base_url('devices/grouped')) ? 'active': ""; echo $class; ?>">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class='icon-list icon-white'></i> Geräte <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="<?= base_url('devices/grouped') ?>"><i class='icon-th'></i> Alle Geräte</a></li>
					<li class="divider"></li>
					<li class="nav-header">Verwaltung</li>
					<li><a href="<?= base_url('devices/add/new') ?>"><i class='icon-plus'></i> Gerät anlegen</a></li>
					<li><a href="<?= base_url('tasks/add/new') ?>"><i class='icon-plus'></i> Task anlegen</a></li>
				  </ul>
				</li>
				
				<li class="dropdown <?php $class = (current_url() == base_url('gateways')) ? 'active': ""; echo $class; ?>">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class='icon-signal icon-white'></i> Gateways <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="<?= base_url('gateways') ?>"><i class='icon-th'></i> Alle Gateways</a></li>
					<li class="divider"></li>
					<?php
						$this->load->model('gateways/gateway');
						$gateways = $this->gateway->getGateways();
						if (sizeof($gateways) != 0) {
							foreach ($gateways as $gateway) {
								echo '<li><a href="'.base_url("gateways/show/".$gateway->name).'">'.$gateway->clear_name.'</a></li>';
							}
						}
					?>
					<li class="divider"></li>
					<li class="nav-header">Verwaltung</li>
					<li><a href="<?= base_url('gateways/add/new') ?>"><i class='icon-plus'></i> Gateway anlegen</a></li>
				  </ul>
				</li>
				
				<li class="dropdown <?php $class = (current_url() == base_url('rooms')) ? 'active': ""; echo $class; ?>">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class='icon-home icon-white'></i> Räume <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="<?= base_url('rooms') ?>"><i class='icon-th'></i> Alle Räume</a></li>
					<li class="divider"></li>
					<?php
						$this->load->model('room');
						$rooms = $this->room->getRooms();
						if (sizeof($rooms) != 0) {
							foreach ($rooms as $room) {
								echo '<li><a href="'.base_url("rooms/show/".$room->name).'">'.$room->clear_name.'</a></li>';
							}
						}
					?>
					<li class="divider"></li>
					<li class="nav-header">Verwaltung</li>
					<li><a href="<?= base_url('rooms/add/new') ?>"><i class='icon-plus'></i> Raum anlegen</a></li>
				  </ul>
				</li>
				
				<li class="dropdown <?php $class = (current_url() == base_url('devices/groups')) ? 'active': ""; echo $class; ?>">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class='icon-th-large icon-white'></i> Gruppen <b class="caret"></b></a>
				  <ul class="dropdown-menu">
					<li><a href="<?= base_url('devices/groups') ?>"><i class='icon-th'></i> Alle Gruppen</a></li>
					<li class="divider"></li>
					<?php
						$this->load->model('devices/device');
						$groups = $this->device->getGroups();
						if (sizeof($groups) != 0) {
							foreach ($groups as $group) {
								echo '<li><a href="'.base_url("devices/showgroup/".$group->name).'">'.$group->clear_name.'</a></li>';
							}
						}
					?>
					<li class="divider"></li>
					<li class="nav-header">Verwaltung</li>
					<li><a href="<?= base_url('devices/addgroup/new') ?>"><i class='icon-plus'></i> Gruppe anlegen</a></li>
				  </ul>
				</li>
			</ul>
<!--
            <p class="navbar-text pull-right">
              <a href="#" class="navbar-link">Username</a>
            </p>
-->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
