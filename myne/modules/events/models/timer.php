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

	public function makeEvent($data) {
		$event_data = array();
		
		// Check type of timer
		$types = array(
			0 => 'recurring',
			1 => 'single'
		);
		if (isset($data['type']) && trim($data['type']) != '') {
			if (in_array($data['type'],$types)) {
				$event_data['type'] = $data['type'];
			}
			else {
				throw new Exception("Unknown timer type '".$data['type']."'");
			}
		}
		else {
			throw new Exception("'Timer type' not set.");
		}

		if ($event_data['type'] == 'single') {
			// Check for date + time
			if (isset($data['date']) && trim($data['date']) != '') {
				$event_data['date'] = $data['date'];
			}
			else {
				throw new Exception("'Date' not set.");
			}

			if (isset($data['time']) && trim($data['time']) != '') {
				$event_data['time'] = $data['time'];
			}
			else {
				throw new Exception("'Time' not set.");
			}

			return $event_data;
		}
		elseif ($event_data['type'] == 'recurring') {
			// Check iteration_period
			if (isset($data['iteration_period']) && trim($data['iteration_period']) != '') {
				$event_data['iteration_period'] = $data['iteration_period'];

				// Check intervals
				// Minute
				if ($event_data['iteration_period'] == 'minute') {
					// No further values needed
					return $event_data;
				} 
				// Hour
				elseif ($event_data['iteration_period'] == 'hour') {
					// Need at least the minute of the hour
					if (isset($data['minute']) && trim($data['minute']) != '') {
						$event_data['minute'] = $data['minute'];

						return $event_data;
					}
					else {
						throw new Exception("'Minute' not set.");
					}
				}
				// Day
				elseif ($event_data['iteration_period'] == 'day') {
					// Need at least a time
					if (isset($data['time']) && trim($data['time']) != '') {
						$event_data['time'] = $data['time'];

						return $event_data;
					}
					else {
						throw new Exception("'Time' not set.");
					}
				}
				// Weekdays
				elseif ($event_data['iteration_period'] == 'weekdays') {
					// Need the weekdays and the time
					// Check for array "dow"
					if (isset($data['dow']) && sizeof($data['dow']) != 0) {
						$event_data['dow'] = array();
						
						// Check each weekday

						// Mon
						if (isset($data['dow']['mon']) && trim($data['dow']['mon']) != '') {
							$event_data['dow']['mon'] = $data['dow']['mon'];
						}
						else {
							throw new Exception("'Monday' not set.");
						}

						// Tue
						if (isset($data['dow']['tue']) && trim($data['dow']['tue']) != '') {
							$event_data['dow']['tue'] = $data['dow']['tue'];
						}
						else {
							throw new Exception("'Tuesday' not set.");
						}

						// Wed
						if (isset($data['dow']['wed']) && trim($data['dow']['wed']) != '') {
							$event_data['dow']['wed'] = $data['dow']['wed'];
						}
						else {
							throw new Exception("'Wednesday' not set.");
						}

						// Thu
						if (isset($data['dow']['thu']) && trim($data['dow']['thu']) != '') {
							$event_data['dow']['thu'] = $data['dow']['thu'];
						}
						else {
							throw new Exception("'Thursday' not set.");
						}

						// Fri
						if (isset($data['dow']['fri']) && trim($data['dow']['fri']) != '') {
							$event_data['dow']['fri'] = $data['dow']['fri'];
						}
						else {
							throw new Exception("'Friday' not set.");
						}

						// Sat
						if (isset($data['dow']['sat']) && trim($data['dow']['sat']) != '') {
							$event_data['dow']['sat'] = $data['dow']['sat'];
						}
						else {
							throw new Exception("'Saturday' not set.");
						}

						// Sun
						if (isset($data['dow']['sun']) && trim($data['dow']['sun']) != '') {
							$event_data['dow']['sun'] = $data['dow']['sun'];
						}
						else {
							throw new Exception("'Sunday' not set.");
						}
					}
					else {
						throw new Exception("'Weekdays' not set.");
					}

					if (isset($data['time']) && trim($data['time']) != '') {
						$event_data['time'] = $data['time'];
					}
					else {
						throw new Exception("'Time' not set.");
					}

					return $event_data;
				}
				// Month
				elseif ($event_data['iteration_period'] == 'month') {
					// Need at least a day of month and time
					if (isset($data['dom']) && trim($data['dom']) != '') {
						$event_data['dom'] = $data['dom'];
					}
					else {
						throw new Exception("'Day of Month' not set.");
					}

					// Need at least a day of month and time
					if (isset($data['time']) && trim($data['time']) != '') {
						$event_data['time'] = $data['time'];
					}
					else {
						throw new Exception("'Time' not set.");
					}

					return $event_data;
				}
				// Year
				elseif ($event_data['iteration_period'] == 'year') {
					// Need at least month, day of month and time
					if (isset($data['mon']) && trim($data['mon']) != '') {
						$event_data['mon'] = $data['mon'];
					}
					else {
						throw new Exception("'Month' not set.");
					}

					if (isset($data['dom']) && trim($data['dom']) != '') {
						$event_data['dom'] = $data['dom'];
					}
					else {
						throw new Exception("'Day of Month' not set.");
					}

					// Need at least a day of month and time
					if (isset($data['time']) && trim($data['time']) != '') {
						$event_data['time'] = $data['time'];
					}
					else {
						throw new Exception("'Time' not set.");
					}

					return $event_data;
				}
			}
			else {
				throw new Exception("'Iteration period' not set.");
			}
		}
		else {
			throw new Exception("Unknown timer type '".$event_data['type']."'");
		}
	}

	public function parseEvent($data) {
		// Parse timer data and return "true" if the event occurs at the moment, "false" if not
		$this->load->model('events/event');
		$data = $this->event->decodeEvent($data);

		log_message('debug', '[Timer/parseEvent] Parsing event data');
		log_message('debug', print_r($data,true));

		$today = date('w',time());
		$now = date('H:i',time());

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
				return true;
			}
			elseif ($data->params->iteration_period == 'hour') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "hour"');
				// Minutes Needed
				$now_min = date('i',time());
				if ($data->params->minute == $now_min) {
					return true;
				}
			}
			elseif ($data->params->iteration_period == 'day') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "day"');
				// Time Needed
				if ($data->params->time == $now) {
					return true;
				}
			}
			elseif ($data->params->iteration_period == 'month') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "month"');
				// Day + Time Needed

				$dom = date('j',time());
				if ($data->params->dom == $dom) {
					log_message('debug', '[Timer/parseEvent] Day of month fits current day: '.$data->params->dom);

					// Now check time
					if ($now == $data->params->time) {
						log_message('debug', '[Timer/parseEvent] Time now fits time set in timer: '.$data->params->time);
						log_message('debug', '[Timer/parseEvent] Event occurs!');
						
						// This is the right moment for the timer
						return true;
					} # Is the time right?
					log_message('debug', '[Timer/parseEvent] Time now unequal time set in timer: '.$data->params->time);
					return false;
				} # Is it the right day of the month?
				log_message('debug', '[Timer/parseEvent] Day of month unequal current day: '.$data->params->dom);
				return false;
			}
			elseif ($data->params->iteration_period == 'year') {
				log_message('debug', '[Timer/parseEvent] Iteration period is "year"');
				// Month + Day + Time Needed
				$mon = date('n',time());
				if ($mon == $data->params->mon) {
					log_message('debug', '[Timer/parseEvent] Month fits current month: '.$data->params->mon);

					$dom = date('j',time());
					if ($data->params->dom == $dom) {
						log_message('debug', '[Timer/parseEvent] Day of month fits current day: '.$data->params->dom);

						// Now check time
						if ($now == $data->params->time) {
							log_message('debug', '[Timer/parseEvent] Time now fits time set in timer: '.$data->params->time);
							log_message('debug', '[Timer/parseEvent] Event occurs!');
							
							// This is the right moment for the timer
							return true;
						} # Is the time right?
						log_message('debug', '[Timer/parseEvent] Time now unequal time set in timer: '.$data->params->time);
						return false;
					} # Is it the right day of the month?
					log_message('debug', '[Timer/parseEvent] Day of month unequal current day: '.$data->params->dom);
					return false;
				}
				log_message('debug', '[Timer/parseEvent] Month unequal current month: '.$data->params->mon);
				return false;			
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
