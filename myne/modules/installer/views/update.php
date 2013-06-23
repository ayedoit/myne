<?php
	$curr_version = $this->tools->getMyneData('version');

	if ($curr_version != $update_version) {
	?>
	<div class="span6">
		<div class="alert alert-info">
			<h4>Software- und Datenbankversion stimmen nicht überein!</h4>
			<br>
			<ul>
				<li>Deine Version: <b><?= $curr_version; ?></b></li>
				<li>Neue Version: <b><?= $update_version; ?></b></li>
			</ul>
		</div>

		<h3>Anleitung für ein Update von <b>myne</b></h3>

		<ul>
			<li>Update zuerst die Sourcen. Download / Pull von <a href="https://github.com/ayedoit/myne" title="myne auf GitHub">GitHub</a>.</li>
			<li>Wenn die Sourcen auf dem aktuellsten Stand sind, drücke "Jetzt updaten", damit das Datenbank-Layout angepasst und die neue Versionsnummer gesetzt werden kann.</li>
		</ul>
		<hr>
		<a href="<?= base_url('installer/update/do_update'); ?>" title="myne Updaten" class="btn btn-success">Jetzt updaten</a>
	</div>
<?php
	}
	else {
?>
	<div class="span6">
		<div class="alert alert-success">
			<h4>myne ist aktuell. <a href="<?= base_url('devices'); ?>" title="Home">Zur Startseite</a></h4>
		</div>
	</div>
<?php
	}
?>