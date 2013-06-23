<?php
	$curr_version = $this->tools->getMyneData('version');

	if ($curr_version != $update_version) {
	?>
	<div class="well">
		<h3>Anleitung für ein Update von <b>myne</b></h3>
		<p>Deine Version: <b><?= $curr_version; ?></b></p>
		<p>Neue Version: <b><?= $update_version; ?></b></p>
		<ul>
			<li>Update zuerst die Sourcen. Download / Pull von <a href="https://github.com/ayedoit/myne" title="myne auf GitHub">GitHub</a>.</li>
			<li>Wenn die Sourcen auf dem aktuellsten Stand sind, drücke "Jetzt updaten", damit das Datenbank-Layout angepasst und die neue Versionsnummer gesetzt werden kann.</li>
		</ul>
	</div>
<?php
	}
	else {
?>
	<div class="well">
		<h3><b>myne</b> ist schon aktuell!</h3>
		<p>Nothing to do here :)</p>
	</div>
<?php
	}
?>