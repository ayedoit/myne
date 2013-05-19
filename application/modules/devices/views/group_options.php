<div class="row-fluid">
	<?php
	echo "<ul class='inline'>";
		echo "<li><a class='btn btn-warning' href='".base_url('devices/edit/'.$group->name)."/on' title='Edit'><i class='icon-pencil icon-white'></i> Edit</a></li>";

		echo "<li>";
			echo '<div class="btn-group">';
			  echo "<a class='btn btn-success' href='".base_url('devices/toggle/'.$group_type.'/'.$group->name)."/on' title='On'>On</a>";
			  echo "<a class='btn btn-danger' href='".base_url('devices/toggle/'.$group_type.'/'.$group->name)."/off' title='Off'>Off</a>";
			echo '</div>';
		echo "</li>";

	echo "</ul>";
	?>
</div>
