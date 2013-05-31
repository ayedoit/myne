<div class="row-fluid">
	<ul class="thumbnails">
	<?php
		$this->load->model('task');
		foreach ($tasks as $task) {
			if ($task->active == 1) {			
				echo "<li class='span3'>";
					echo '<div class="thumbnail">';
						echo '<div class="caption">';
							echo '<h3>'.$task->clear_name.'</h3>';
							echo '<p>'.$task->description.'</p>';
							echo "<p><a class='btn btn-primary' href='".$this->task->buildTaskLink($task->id)."'>Ausführen</a></p>";
						echo '</div>';				
				echo "</li>";
			}	
		}
	?>
	</ul>
</div>
