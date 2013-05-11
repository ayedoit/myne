<!DOCTYPE html>
<html>
  <head>
        <title>Infrastructure Management Centre</title>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>css/bootstrap.DataTable.css">
        <script src="http://yui.yahooapis.com/2.9.0/build/yuiloader/yuiloader-min.js"></script>
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.0.min.js"></script>
        <script src="<?= base_url() ?>js/imc.js"></script>
        <script src="<?= base_url() ?>js/jquery.validate.js"></script>
        <script src="<?= base_url() ?>js/bootstrap.js"></script>
        <script src="<?= base_url() ?>js/jquery.dataTables.js"></script>
        <script src="<?= base_url() ?>js/jquery.dataTables.plugins.js"></script>


        <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="<?= base_url() ?>">Infrastructure Management Center</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              <!-- Logged in as <a href="#" class="navbar-link">Username</a>-->
            </p>
            <ul class="nav">
              <li <?php $class = (current_url() == base_url()."index.php/pm/hostlist" || current_url() == base_url()."index.php") ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>"><i class="icon-home"></i> Home</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>