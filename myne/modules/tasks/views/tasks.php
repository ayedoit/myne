<?php
$this->load->model('tasks/task');
$tasks = $this->task->getTasksByTargetName($target_type,$target->name);

if (sizeof($tasks) != 0) {
?>
	<div class="span5">
		<h3>Tasks</h3>
		<table class="table table-striped">
			<tbody>
			<?php
				foreach($tasks as $task) {
					echo "<tr>";
						$this->load->model('events/event');

						// Get event item
						$event_item = $this->event->getEventByID($task->event_item_id);

						// Get Event type
						$event_type = $this->event->getEventTypeByID($event_item->event_id);

						// Get & parse event data
						$event_data = $this->event->decodeEvent($event_item->data);

						echo "<td><span class='label label-info'>".$event_type->clear_name."</span></td>";
						echo "<td>";
							// Load view
							$this->load->view('events/'.$event_type->name.'-tasklist',array('event_data' => $event_data));
						echo "</td>";
						echo "<td>Trololol</td>";
					echo "</tr>";
				}
			?>
			</tbody>
		</table>
	</div>
<?php
}
?>