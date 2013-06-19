<?php
Class timer extends CI_Model {
	/*
	 * 
	 * Models
	 * 
	 */
	 
	public function getTimer() {
		$query = $this->db->get('timer');
		
		log_message('debug', 'Polling timers from database');
		
		$timer = array();
		foreach ($query->result() as $row)
		{
			$timer[] = $row;
		}
		return $timer;
	}
	 
	public function getTimerByID($id) {
		$query = $this->db->get_where('timer', array('id' => $id));
		
		log_message('debug', 'Polling timer with ID "'.$id.'" from database');
		
		$timer = "";
		foreach ($query->result() as $row)
		{
			$timer = $row;
		}
		return $timer;
	}
	
	public function addTimer($data) {
		$this->db->insert('timer', $data); 
		
		log_message('debug', 'Adding timer to database');
		
		return $this->db->insert_id();
	}
	
	public function updateTimer($id,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);
		
		$this->db->where('id', $id);
		try {
			$this->db->update('timer', $data); 
			log_message('debug', 'Updating timer with ID "'.$id.'", setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			log_message('debug', 'Updating timer with ID "'.$id.'", setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		}
	}
	
	public function deleteTimer($id) {
		// Delete timer
		log_message('debug', 'Removing timer with ID "'.$id.'" from database');
		$this->db->delete('timer', array('id' => $id)); 
	}

	public function parseEvent($data) {
		// Parse timer data and return "true" if the event occurs at the moment, "false" if not
		$this->load->model('events/event');
		$data = $this->event->decodeEvent($data);

		log_message('debug', '[Timer/parseEvent] Parsing event data');
		log_message('debug', print_r($data,true));

		// Either the timer is recurring...
		if ($data->params->type == 'recurring') {
			log_message('debug', '[Timer/parseEvent] Timer is "recurring"');
			/*
			 *	Recurring events can have the following iteration periods
			 * 	1. minute
			 *	2. hour
			 *	3. day
			 *	4. week
			 *	5. month
			 *	6. year
			 *	7. weekdays
			*/
			if ($data->params->iteration_period == 'minute') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "minute"');

			}
			elseif ($data->params->iteration_period == 'hour') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "hour"');

			}
			elseif ($data->params->iteration_period == 'day') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "day"');
			 
			}
			elseif ($data->params->iteration_period == 'week') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "week"');
				
			}
			elseif ($data->params->iteration_period == 'month') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "month"');
				
			}
			elseif ($data->params->iteration_period == 'year') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "year"');
				
			}
			elseif ($data->params->iteration_period == 'weekdays') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "weekdays"');
				/* 
					Set specific weekdays
				 	needed params
				 	
				 	dow = array(
						'mon' => 0,
						'tue' => 0,
						'wed' => 0,
						'thu' => 1,
						'fri' => 0,
						'sat' => 0,
						'sun' => 0 
				 	)
				*/
				
				// Determine current day of week
				// Get current weekday

				$today = date('w',time());
				switch($today) {
					case '1': $dow = 'mon'; break;
					case '2': $dow = 'tue'; break;
					case '3': $dow = 'wed'; break;
					case '4': $dow = 'thu'; break;
					case '5': $dow = 'fri'; break;
					case '6': $dow = 'sat'; break;
					case '0': $dow = 'sun'; break;
					default: return 0; break;
				}

				// Check if current day of week ($dow) is flagged in data-array
				if ($data->params->dow->{$dow} == '1') {
					log_message('debug', '[Timer/parseEvent] Weekday fits current day: '.$data->params->dow->{$dow});

					// Now check if it's the right time
					$now = date('H:i',time());
					log_message('debug', '[Timer/parseEvent] Time now: '.$now);

					if ($now == $data->params->time) {
						log_message('debug', '[Timer/parseEvent] Time now fits time set in timer: '.$data->params->time);
						log_message('debug', '[Timer/parseEvent] Event occurs!');
						// This is the right moment for the timer
						return true;
					} # Is the time right?
					log_message('debug', '[Timer/parseEvent] Time now unequal time set in timer: '.$data->params->time);
					return false;
				} # Is it the right weekday?
				log_message('debug', '[Timer/parseEvent] Weekday unequal current day: '.$data->params->dow->{$dow});
				return false;
			}
			return false;

		}
		// ...or targets a single date
		else {
			$today = date('d.m.Y',time());

			if ($today == $data->params->date) {

				// Now check if it's the right time
				$now = date('H:i',time());
				if ($now == $data->params->time) {
					// This is the right moment for the timer
					return true;
				} # Is the time right?
				return false;
			} # Is ist the right date?
		}
	}
}
?>
