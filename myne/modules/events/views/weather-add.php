<?php
	$this->load->helper('form');
?>
<hr>
<div class="control-group">
	<?php 
		$attributes = array(
			'class' => 'control-label'
		);
		echo form_label('Timer Typ', 'type',$attributes);
	?>
	<div class="controls">
	  <?php	
		$options = array(
			"recurring" => "Wiederholend",
			"single" => "Datum"
		);
		$data = 'id="timer_type"';
		echo form_dropdown('type', $options,"1",$data);
	  ?>
	</div>
</div>

<div id="timer_recurring">
	<div class="control-group">
		<?php 
			$attributes = array(
				'class' => 'control-label'
			);
			echo form_label('Intervall', 'iteration_period',$attributes);
		?>
		<div class="controls">
		  <?php	
			$options = array(
				"minute" => "Minütlich",
				"hour" => "Stündlich",
				"day" => "Täglich",
				"weekdays" => "Wöchentlich",
				"month" => "Monatlich",
				"year" => "Jährlich",
			);
			$data = 'id="timer_iteration_period"';
			echo form_dropdown('iteration_period', $options,"day",$data);
		  ?>
		</div>
	</div>
	<div id="interval_params">
		<div id="timer_recurring_month" class="hide timer-params">
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
					  'placeholder' => 'Tag des Monats'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
		</div>

		<div id="timer_recurring_hour" class="hide timer-params">
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
					  'placeholder' => 'Minute'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
		</div>

		<div id="timer_recurring_year" class="hide timer-params">
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
					  'placeholder' => 'Monat'
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
					  'placeholder' => 'Tag des Monats'
					);
					echo form_input($data);
				  ?>
				  <span class="validation_space"></span>
				</div>
			</div>
		</div>

		<div id="timer_recurring_weekdays" class="hide timer-params">
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
							echo '<button type="button" data-day="mon" class="btn btn-medium timer_day">M</button>';
							echo form_hidden('dow[mon]', '0');
						// Tue
							echo '<button type="button" data-day="tue" class="btn btn-medium timer_day">D</button>';
							echo form_hidden('dow[tue]', '0');
						// Wed
							echo '<button type="button" data-day="wed" class="btn btn-medium timer_day">M</button>';
							echo form_hidden('dow[wed]', '0');
						// Thu
							echo '<button type="button" data-day="thu" class="btn btn-medium timer_day">D</button>';
							echo form_hidden('dow[thu]', '0');
						// Fri
							echo '<button type="button" data-day="fri" class="btn btn-medium timer_day">F</button>';
							echo form_hidden('dow[fri]', '0');
						// Sat
							echo '<button type="button" data-day="sat" class="btn btn-medium timer_day">S</button>';
							echo form_hidden('dow[sat]', '0');
						// Sun
							echo form_hidden('dow[sun]', '0');
							echo '<button type="button" data-day="sun" class="btn btn-medium timer_day">S</button>';

					?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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
			  'placeholder' => 'Datum'
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
			  'placeholder' => 'Uhrzeit'
			);
			echo form_input($data);
		  ?>
		  <span class="validation_space"></span>
		</div>
	</div>
</div>
<hr>
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
	    todayBtn: true,
	    todayHighlight: true
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

	$('#timer_type').change(function() {
		var value = $('#timer_type').val();
		var response = "";

		if (value != "recurring") {
			$('#timer_recurring').addClass('hide');
			$('#timer_time_space').show();
			$('#timer_date_space').show();
		}
		else {
			$('#timer_recurring').removeClass('hide');
		}

		$('#timer_iteration_period').trigger('change');
	});

	$('#timer_iteration_period').on('change',function() {
		var value = $('#timer_iteration_period').val();
		var response = "";

		if (value == "minute") {
			$('#interval_params').hide();
			$('#timer_time_space').hide();
			$('#timer_date_space').hide();
		}
		else if (value == "hour") {
			$('#interval_params').show();
			$('.timer-params').not('#timer_recurring_hour').hide();
			$('#timer_recurring_hour').show();
		}
		else if (value == "day") {
			$('#interval_params').show();
			$('#timer_time_space').show();
			$('.timer-params').not('#timer_time_space').hide();
		}
		else if (value == "weekdays") {
			$('#interval_params').show();
			$('#timer_time_space').show();
			$('#timer_recurring_weekdays').show();
			$('.timer-params').not('#timer_recurring_weekdays, #timer_time_space').hide();
		}
		else if (value == "month") {
			$('#interval_params').show();
			$('#timer_time_space').show();
			$('#timer_recurring_month').show();
			$('.timer-params').not('#timer_recurring_month, #timer_time_space').hide();
		}
		else if (value == "year") {
			$('#interval_params').show();
			$('#timer_time_space').show();
			$('#timer_recurring_year').show();
			$('.timer-params').not('#timer_recurring_year, #timer_time_space').hide();
		}
	});
});
</script>