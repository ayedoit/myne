<?php
	$this->load->helper('form');
	$attributes = array('class' => 'form-horizontal', 'id' => 'task_edit');
	echo form_open('tasks/updateTask/'.$task_id,$attributes);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
	<h3 id="myModalLabel">Task ändern</h3>
</div>
<div class="modal-body">
	<?php
	$this->load->helper('form');

	$event_data = $event_data->params;

	// Determine timer type
	if ($event_data->type == 'single') {
		$data = array(
		  'type' => 'single'
		);		
		echo form_hidden($data);
		// Load Date + Time
		?>
			<div id="timer_date_space" class="hide timer-params">
				<div class="control-group">
					<?php 
						$attributes = array(
							'class' => 'control-label'
						);
						echo form_label('Datum', 'date',$attributes);
					?>
					<div class="controls">
					  <?php
						$data = array(
						  'name'        => 'date',
						  'id'          => 'timer_date',
						  'value' => $event_data->date,
						);
						echo form_input($data);
					  ?>
					  <span class="validation_space"></span>
					</div>
				</div>
			</div>

			<div id="timer_time_space" class="timer-params">
				<div class="control-group">
					<?php 
						$attributes = array(
							'class' => 'control-label'
						);
						echo form_label('Uhrzeit', 'time',$attributes);
					?>
					<div class="controls">
					  <?php
						$data = array(
						  'name'        => 'time',
						  'id'          => 'timer_time',
						  'value' => $event_data->time,
						);
						echo form_input($data);
					  ?>
					  <span class="validation_space"></span>
					</div>
				</div>
			</div>
		<?php
	}
	elseif ($event_data->type == 'recurring') {
		$data = array(
		  'type' => 'recurring'
		);		
		echo form_hidden($data);

		// Determine iteration period
		if ($event_data->iteration_period == 'hour') {
			$data = array(
			  'iteration_period' => 'hour'
			);		
			echo form_hidden($data);
			?>
				<div id="timer_recurring_hour">
					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Minute', 'minute',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'minute',
							  'id'          => 'timer_minute',
							  'value' => $event_data->minute
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>
				</div>
			<?php
		}
		elseif ($event_data->iteration_period == 'day') {
			$data = array(
			  'iteration_period' => 'day'
			);		
			echo form_hidden($data);
			?>
				<div id="timer_time_space">
					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Uhrzeit', 'time',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'time',
							  'id'          => 'timer_time',
							  'value' => $event_data->time,
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>
				</div>
			<?php
		}
		elseif ($event_data->iteration_period == 'weekdays') {
			$data = array(
			  'iteration_period' => 'weekdays'
			);		
			echo form_hidden($data);
			?>
				<div id="timer_recurring_weekdays">
					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Tage', 'dow',$attributes);
						?>
						<div class="controls">
							<div class="btn-group" data-toggle="buttons-checkbox">
							<?php
								// Mon
								if ($event_data->dow['mon'] == "1") {
									echo '<button type="button" data-day="mon" class="btn btn-medium timer_day active">M</button>';
									echo form_hidden('dow[mon]', '1');
								}
								else {
									echo '<button type="button" data-day="mon" class="btn btn-medium timer_day">M</button>';
									echo form_hidden('dow[mon]', '0');
								}

								// Tue
								if ($event_data->dow['tue'] == "1") {
									echo '<button type="button" data-day="tue" class="btn btn-medium timer_day active">D</button>';
									echo form_hidden('dow[tue]', '1');
								}
								else {
									echo '<button type="button" data-day="tue" class="btn btn-medium timer_day">D</button>';
									echo form_hidden('dow[tue]', '0');
								}

								// Wed
								if ($event_data->dow['wed'] == "1") {
									echo '<button type="button" data-day="wed" class="btn btn-medium timer_day active">M</button>';
									echo form_hidden('dow[wed]', '1');
								}
								else {
									echo '<button type="button" data-day="wed" class="btn btn-medium timer_day">M</button>';
									echo form_hidden('dow[wed]', '0');
								}

								// Thu
								if ($event_data->dow['thu'] == "1") {
									echo '<button type="button" data-day="thu" class="btn btn-medium timer_day active">D</button>';
									echo form_hidden('dow[thu]', '1');
								}
								else {
									echo '<button type="button" data-day="thu" class="btn btn-medium timer_day">D</button>';
									echo form_hidden('dow[thu]', '0');
								}

								// Fri
								if ($event_data->dow['fri'] == "1") {
									echo '<button type="button" data-day="fri" class="btn btn-medium timer_day active">F</button>';
									echo form_hidden('dow[fri]', '1');
								}
								else {
									echo '<button type="button" data-day="fri" class="btn btn-medium timer_day">F</button>';
									echo form_hidden('dow[fri]', '0');
								}

								// Sat
								if ($event_data->dow['sat'] == "1") {
									echo '<button type="button" data-day="sat" class="btn btn-medium timer_day active">S</button>';
									echo form_hidden('dow[sat]', '1');
								}
								else {
									echo '<button type="button" data-day="sat" class="btn btn-medium timer_day">S</button>';
									echo form_hidden('dow[sat]', '0');
								}

								// Sun
								if ($event_data->dow['sun'] == "1") {
									echo '<button type="button" data-day="sun" class="btn btn-medium timer_day active">S</button>';
									echo form_hidden('dow[sun]', '1');
								}
								else {
									echo '<button type="button" data-day="sun" class="btn btn-medium timer_day">S</button>';
									echo form_hidden('dow[sun]', '0');
								}
							?>
							</div>
						</div>
					</div>

					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Uhrzeit', 'time',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'time',
							  'id'          => 'timer_time',
							  'value' => $event_data->time,
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>
				</div>
			<?php
		}
		elseif ($event_data->iteration_period == 'month') {
			$data = array(
			  'iteration_period' => 'month'
			);		
			echo form_hidden($data);
			?>
				<div id="timer_recurring_month">
					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Tag des Monats', 'dom',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'dom',
							  'id'          => 'timer_rec_mon_dom',
							  'value' => $event_data->dom
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>

					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Uhrzeit', 'time',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'time',
							  'id'          => 'timer_time',
							  'value' => $event_data->time,
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>
				</div>
			<?php
		}
		elseif ($event_data->iteration_period == 'year') {
			$data = array(
			  'iteration_period' => 'year'
			);		
			echo form_hidden($data);
			?>
				<div id="timer_recurring_year">
					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Monat', 'mon',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'mon',
							  'id'          => 'timer_rec_year_mon',
							  'value' => $event_data->mon
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>

					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Tag des Monats', 'dom',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'dom',
							  'id'          => 'timer_rec_year_dom',
							  'value' => $event_data->dom
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>

					<div class="control-group">
						<?php 
							$attributes = array(
								'class' => 'control-label'
							);
							echo form_label('Uhrzeit', 'time',$attributes);
						?>
						<div class="controls">
						  <?php
							$data = array(
							  'name'        => 'time',
							  'id'          => 'timer_time',
							  'value' => $event_data->time,
							);
							echo form_input($data);
						  ?>
						  <span class="validation_space"></span>
						</div>
					</div>
				</div>
			<?php
		}
		else {
			// Minute
			echo "Hier gibt es nichts einzustellen.";
		}
	}
?>	
	</div>
	<div class="modal-footer">
		<?php 
			$data = array(
			  'form' => '1'
			);		
			echo form_hidden($data);		
		?>
		<button class="btn" data-dismiss="modal" aria-hidden="true">Abbrechen</button>
		<?php
			$submit = array(
				"class" => "btn btn-primary",
				"name" => "edit_task_submit",
				"value" => "Speichern"
			);
			
			echo form_submit($submit);
		?>
	</div>
</fieldset>
<?php form_close(); ?>
<script>
$(document).ready(function() {
	$('#timer_rec_year_mon').datetimepicker({
	    format: 'm',
	    startView: 3,
	    minView: 3,
	    maxView: 3,
	    language: 'de',
	    autoclose: true,
	    weekStart: "1"
	});
	$('#timer_rec_year_dom').datetimepicker({
	    format: 'd',
	    startView: 2,
	    minView: 2,
	    maxView: 2,
	    language: 'de',
	    autoclose: true,
	    weekStart: "1"
	});
	$('#timer_rec_mon_dom').datetimepicker({
	    format: 'd',
	    startView: 2,
	    minView: 2,
	    maxView: 2,
	    language: 'de',
	    autoclose: true,
	    weekStart: "1"
	});
	$('#timer_time').datetimepicker({
	    format: 'hh:ii',	
	    startView: 1,
	    maxView: 1,
	    language: 'de',
	    autoclose: true,
	});
	$('#timer_date').datetimepicker({
	    format: 'dd.mm.yyyy',	
	    minView: 2,
	    language: 'de',
	    autoclose: true,
	});
	$('.timer_day').click(function() {				
		var day = $(this).data('day');
		if ($('input[name="dow['+day+']"]').val() == "0") {
			$('input[name="dow['+day+']"]').val("1");
		}
		else {
			$('input[name="dow['+day+']"]').val("0");
		}
	});
});
</script>