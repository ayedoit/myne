<?php
    $curr_url = current_url();
?>
<div class="span3">
  <div class="well sidebar-nav">
    <ul class="nav nav-list">
      <li class="nav-header">Connair</li>
      <li <?php $class = ($curr_url == base_url()."connair") ? "class='active'": ""; echo $class; ?>><a href="<?= base_url() ?>connair">Connair</a></li>
    </ul>
  </div>
</div>
