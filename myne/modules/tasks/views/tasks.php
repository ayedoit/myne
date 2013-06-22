<?php
$this->load->model('tasks/task');
$tasks = $this->task->getTasksByTargetName($target_type,$target->name);

if (sizeof($tasks) != 0) {
?>
	<div class="span5">
		<h3>Tasks</h3>
		<table class="table table-striped" id="task-list">
			<tbody>
			<?php
				foreach($tasks as $task) {
					echo "<tr id='".$task->id."'>";
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
						echo "<td>";
							// Action
							$this->load->model('action');
							$action_item = $this->action->getActionItemByID($task->action_item_id);
							$action_data = $this->action->decodeAction($action_item->data);
							
							// Get action by data
							$action = $this->action->getActionByName($action_data->method);

							echo "<span class='label label-info'>".$action->clear_name."</span> ";

							echo "<span class='label'>";
								echo $action_data->params->opts["2"];
							echo "</span>";
						echo "</td>";

						echo "<td class='task-controls'>";
							echo "<div class='control_wrapper hide'>";
								echo "<a class='edit_task btn btn-mini btn-warning' data-id='".$task->id."'><i class='icon-edit icon-white'></i> Ändern</a> ";
								echo "<a class='delete_task btn btn-mini btn-danger' data-id='".$task->id."'><i class='icon-remove-circle icon-white'></i> Löschen</a>";
							echo "</div>";
						echo "</td>";
					echo "</tr>";
				}
			?>
			</tbody>
		</table>
	</div>
<?php
}
?>
<div id="edit_task" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>
<script>
	$(document).ready(function() {
		// Delete task
	  	$('.delete_task').on('click',function() {
		    var response = $(this).myne_api({
		      method: "deleteTask",
		      params: {"model": "tasks/task", "api_key":"<?= $this->tools->getSettingByName('api_key'); ?>", "opts":[$(this).data('id')]}
		    });

		    var r_value = jQuery.parseJSON(response.responseText);

		    if (r_value.hasOwnProperty('error')) {
		      $(this).myne_notify({
		        "text":r_value.error.message,
		        "class":"error"
		      });
		    }
		    else {
		      $(this).myne_notify({
		        "text": "Task mit ID "+$(this).data('id')+" gelöscht",
		        "class":"success"
		      });
		    }

		    $('tr#'+$(this).data('id')).remove();
	  	});
	});
</script>