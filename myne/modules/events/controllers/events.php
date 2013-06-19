<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Events extends MY_Controller { 
	public function index(){
		echo "KEKSÖÖÖÖÖÖÖÖÖÖÖÖÖÖ";
	}

	public function makeData() {
		$this->load->model('events/event');

		$data = array(
			'model' => 'events/timer',
			'params' => array(
				'type' => 'recurring', // or 'single'
				'iteration_period' => 'weekdays',
				'dow' => array(
					'mon' => 0,
					'tue' => 1,
					'wed' => 0,
					'thu' => 0,
					'fri' => 0,
					'sat' => 0,
					'sun' => 0 
				),
				'time' => '21:55'
			)
		);

		echo "<pre>".print_r($data,true)."</pre>";

		$this->load->model('events/timer');

		$data = $this->event->encodeEvent($data);
		
		if ($this->event->parseEvent("",$data)) {
			echo "True";
		}
		else {
			echo "False";
		}
	}
}