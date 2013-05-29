<div class="row-fluid">
	<?php
		echo "<ul class='inline'>";
		echo "<li><a class='btn btn-primary' href='".base_url('devices/delete/group/'.$group->name.'/execute')."' title='Endgültig Löschen'><i class='icon-remove-circle icon-white'></i> Endgültig Löschen</a></li>";
		echo "<li><a class='btn' href='".base_url('devices/showgroup/'.$group->name)."' title='Abbrechen'>Abbrechen</a></li>";
		echo "</ul>";
	?>
</div>
