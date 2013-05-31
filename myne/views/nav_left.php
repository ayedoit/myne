<?php
    $curr_url = current_url();
?>
<div class="span3">
  <div class="well sidebar-nav">
    <ul class="nav nav-list">
      <li class="nav-header">Geräte</li>
      <li <?php $class = ($curr_url == base_url()."devices") ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>devices">Geräte</a></li>
    </ul>
  </div>
</div>
