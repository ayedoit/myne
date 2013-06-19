<?php
	// Determine Type
	switch ($event_data->params->type) {
		case 'recurring': $type = 'Wiederholend'; break;
		case 'single': $type = 'Einmalig'; break;
		default: $type = 'Datum'; break;
	}
	echo "<span class='label label-success'>".$type."</span> ";

	if ($event_data->params->type == 'recurring') {
		switch ($event_data->params->iteration_period) {
			case 'minute': $iteration_period = 'Minütlich'; break;
			case 'hour': $iteration_period = 'Stündlich'; break;
			case 'day': $iteration_period = 'Täglich'; break;
			case 'month': $iteration_period = 'Monatlich'; break;
			case 'year': $iteration_period = 'Jährlich'; break;
			case 'weekdays': $iteration_period = 'Wöchentlich'; break;
			default: $iteration_period = 'Stündlich'; break;
		}

		echo "<span class='label label-info'>".$iteration_period."</span> ";

		// Recurring: Weekdays (which also accounts for weekly recurrance)
		if ($event_data->params->iteration_period == 'weekdays') {
			$days = array();
			foreach ($event_data->params->dow as $dow => $value) {
				switch ($dow) {
					case 'mon': $day = 'Mo'; break;
					case 'tue': $day = 'Di'; break;
					case 'wed': $day = 'Mi'; break;
					case 'thu': $day = 'Do'; break;
					case 'fri': $day = 'Fr'; break;
					case 'sat': $day = 'Sa'; break;
					case 'sun': $day = 'So'; break;
				}

				if ($value == 1) {
					$days[]=$day;
				}
			}
			echo "<span class='label'>".implode(", ",$days)."</span> ";
			echo "<span class='label label-info'>".$event_data->params->time."</span> ";
		}
		// Recurring: Hour
		elseif ($event_data->params->iteration_period == 'hour') {
			echo "<span class='label'>T +".$event_data->params->minute." Minuten</span> ";
		}
		// Recurring: Month
		elseif ($event_data->params->iteration_period == 'month') {
			echo "<span class='label'>".$event_data->params->dom.". Tag des Monats</span> ";
			echo "<span class='label label-info'>".$event_data->params->time."</span> ";
		}
		// Recurring: Year
		elseif ($event_data->params->iteration_period == 'year') {
			echo "<span class='label'>am ".$event_data->params->dom.".".$event_data->params->mon."</span> ";
			echo "<span class='label label-info'>".$event_data->params->time."</span> ";
		}
	}
	elseif ($event_data->params->type == 'single') {
		echo "<span class='label label-info'>".$event_data->params->date."</span> ";
		echo "<span class='label label-info'>".$event_data->params->time."</span> ";
	}

?>