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
			    <h1>Willkommen bei <a href="http://myne.ayedo.de" title=" myne - a Home Automation Gateway">myne</a></h1>
			    <p class="lead"><b>myne</b> ist ein <b>Home Automation Gateway</b> und versteht sich als einfach bedienbare Schnittstelle zwischen dir - dem User -  und verschiedenen steuerbaren Elementen des modernen Zuhauses.</p>
			  </div>
        <hr>
        <div class="row-fluid">
          <h3 style="text-align: center;">Leg noch einen User für dich an.</h3>
          <p class="lead" style="text-align: center;">Ob du <b>myne</b> mit oder ohne Login nutzen willst, kannst du später entscheiden.</p>
            
          <form class="form-horizontal installer_form" method="post" action="<?= base_url('installer/install'); ?>">
            <div class="control-group">
              <label class="control-label" for="username">Username</label>
              <div class="controls">
                <input type="text" id="username" name="username" placeholder="Username" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="password">Passwort</label>
              <div class="controls">
                <input type="password" id="password" name="password" placeholder="Passwort" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="givenname">Vorname</label>
              <div class="controls">
                <input type="text" id="givenname" name="givenname" placeholder="Vorname" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="surename">Nachname</label>
              <div class="controls">
                <input type="text" id="surename" name="surename" placeholder="Nachname" required>
              </div>
            </div>
            <div class="control-group">
              <label class="control-label" for="weather_location">Stadt (für Wetter)</label>
              <div class="controls">
                <input type="text" name="weather_location" id="weather_location" data-provide="typeahead" placeholder="z.B. Saarlouis" />
              </div>
            </div>
            <div class="control-group">
              <div class="controls">
                <input type="submit" class="btn btn-large btn-success" value="Installieren" />
              </div>
            </div>
          </form>

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
&(document).ready(function() {
  $('#weather_location').typeahead({
    minLength: 3,
    source: function(query, process) {
            $.post('/weather/get_city', { q: query }, function(data) {
                process(JSON.parse(data));
            });
        }
  });
});