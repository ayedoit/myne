<?php
    $curr_url = current_url();
?>
<div class="span3">
  <div class="well sidebar-nav">
    <ul class="nav nav-list">
      <li class="nav-header">Package Manager</li>
      <li <?php $class = ($curr_url == base_url()."index.php/pm/hostlist" || $curr_url == base_url()."index.php") ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>index.php/pm/hostlist">List Hosts</a></li>
      
      <li class="nav-header">Host Manager</li>
      <li <?php $class = ($curr_url == base_url()."index.php/hm/addHost") ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>index.php/hm/addHost"><i class="icon-plus"></i> Add Host</a></li>
      
      <li class="nav-header">User Manager</li>
      <li <?php $class = ($curr_url == base_url()."index.php/um/addUser") ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>index.php/um/addUser"><i class="icon-plus"></i> Add User</a></li>
      
      <li class="nav-header">Mail Manager</li>
      <li <?php $class = ($curr_url == base_url()."index.php/mm") ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>index.php/mm">Bounced Domains</a></li>
    </ul>
  </div>
</div>