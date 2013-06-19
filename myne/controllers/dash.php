<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Dash extends MY_Controller {
   
	public function index() {  
		$this->load->model('task');
		$tasks = $this->task->getTasks();
		
	    $this->load->library('page');
	    $html = $this->load->view('title',array('title' => "Tasks"),true);
	    $html .= $this->load->view('dash',array('tasks' => $tasks),true);
	    $this->page->show($html);
    }
    
    public function cron() {
    	$this->load->model('cron');

    	$should = '* * * * * curl http://192.168.0.107/tasks/run > /dev/null 2>&1';
    	$cronjobs = $this->cron->listJobs();

    	if (in_array($should,$cronjobs)) {
    		echo "YAY";
    	}
	
	}

	public function action() {
		$data = array(
			'method' => 'toggle',
			'params' => array(
				'model' => 'devices/device',
				'opts' => array(
					0 => 'device',
					1 => 'test1',
					2 => 'on'
				)
			)
		);

		$this->load->model('action');
		$action_data = $this->action->encodeAction($data);
		echo $action_data;

		// $this->action->addActionItem('1',$action_data);

		// var_dump($this->action->triggerAction('',$action_data));

		$this->load->model('events/event');

		$event_data1 = array(
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

		$event_data2 = array(
			'model' => 'events/timer',
			'params' => array(
				'type' => 'recurring', // or 'single'
				'iteration_period' => 'minute'
			)
		);

		$event_data3 = array(
			'model' => 'events/timer',
			'params' => array(
				'type' => 'recurring', // or 'single'
				'iteration_period' => 'month',
				'dom' => '3',
				'time' => '12:55'
			)
		);

		$event_data4 = array(
			'model' => 'events/timer',
			'params' => array(
				'type' => 'recurring', // or 'single'
				'iteration_period' => 'day',
				'time' => '00:04'
			)
		);

		$event_data5 = array(
			'model' => 'events/timer',
			'params' => array(
				'type' => 'recurring', // or 'single'
				'iteration_period' => 'hour',
				'minute' => '4'
			)
		);

		$event_data6 = array(
			'model' => 'events/timer',
			'params' => array(
				'type' => 'single', // or 'single'
				'date' => '19.02.2013',
				'time' => '14:33'
			)
		);

		// $parsed_data = $this->event->encodeEvent($event_data);
		$id2 = $this->event->addEvent('1',$this->event->encodeEvent($event_data2));
		$id3 = $this->event->addEvent('1',$this->event->encodeEvent($event_data3));
		$id4 = $this->event->addEvent('1',$this->event->encodeEvent($event_data4));
		$id5 = $this->event->addEvent('1',$this->event->encodeEvent($event_data5));
		$id6 = $this->event->addEvent('1',$this->event->encodeEvent($event_data6));

		$this->load->model('tasks/task');
		$this->task->addTask(array(
			'event_item_id' => $id2,
			'action_item_id' => "1",
			'target_type' => 'device',
			'target_name' => 'test1'
		));

		$this->task->addTask(array(
			'event_item_id' => $id3,
			'action_item_id' => "1",
			'target_type' => 'device',
			'target_name' => 'test1'
		));
		$this->task->addTask(array(
			'event_item_id' => $id4,
			'action_item_id' => "1",
			'target_type' => 'device',
			'target_name' => 'test1'
		));
		$this->task->addTask(array(
			'event_item_id' => $id5,
			'action_item_id' => "1",
			'target_type' => 'device',
			'target_name' => 'test1'
		));
		$this->task->addTask(array(
			'event_item_id' => $id6,
			'action_item_id' => "1",
			'target_type' => 'device',
			'target_name' => 'test1'
		));
	}

	public function setCron() {
		$this->load->model('cron');
        $this->cron->onDayOfWeek('*');
        $this->cron->onHour('*');
        $this->cron->onMinute('*');
        $this->cron->onMonth('*');
        $this->cron->ondayOfMonth('*');
        $this->cron->doJob('curl http://192.168.0.107/tasks/run > /dev/null 2>&1');        
        $this->cron->activate(true);
	}
	
	public function view($view) {
		$this->load->view($view,"");
	}
        
    function logout()
	{
	  $this->session->unset_userdata('logged_in');
	  session_destroy();
	  redirect('dash', 'refresh');
	}
}
