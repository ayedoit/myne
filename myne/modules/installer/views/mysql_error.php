<?php
 header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
  <head>
        <title>myne</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css">

        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>
        
        <script src="<?= base_url() ?>js/myne.js"></script>
        <script src="<?= base_url() ?>js/jquery.validate.js"></script>
        <script src="<?= base_url() ?>js/bootstrap.js"></script>

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
				<li><a class="brand logo" href="<?= base_url('installer') ?>"><img src="<?= base_url('img/myne_logo_h40.png'); ?>" alt="myne" /></a></li>
			</ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    

	<div class="container-narrow">
	    <div class="row-fluid">
	      	<div class="span12" data-role="content">
				<div class="jumbotron">
			    <h1>Oh :(</a></h1>
			    <p class="lead"><b>myne</b> kann sich nicht mit deinem MySQL-Server verbinden. Überprüfe nochmal deine Einstellungen.</p>
			  </div>
        <hr>
        <div class="row-fluid">
          <p>Wenn du hier bist, hast du vermutlich schon das meiste richtig gemacht. Trage jetzt noch die Zugangsdaten für deinen MySQL-Server in <code>myne/config/database.php</code> ein und klick auf "Installieren".</p>
<pre>
$db['default']['hostname'] = '127.0.0.1';
$db['default']['username'] = 'DB-USER'; 
$db['default']['password'] = 'DB-PASSWORD';
$db['default']['database'] = 'DATABASE-NAME';
$db['default']['dbdriver'] = 'mysql';
$db['default']['dbprefix'] = '';
</pre>
          <p style="text-align: center;"><a class="btn btn-large btn-success" href="<?= base_url('installer/install'); ?>">Installieren</a></p>
        </div>
		    <hr>
		    <a class="pull-left" href="https://github.com/ayedoit/myne" title="myne auf GitHub"><img heigth="43" width="100" src="<?= base_url('img/github.png'); ?>" /></a>&nbsp;
        <a class="pull-right" href="http://www.ayedo.de" title="Maintained by ayedo IT Soultions"><img heigth="43" width="100" src="<?= base_url('img/ayedo.png'); ?>" /></a>
			</div><!-- #panel_content -->
	    </div>
	</div><!-- container-fluid -->
   </body>
</html>
<script>
