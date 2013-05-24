<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Tasks extends CI_Controller {
	function __construct(){
        parent::__construct();
        
        // Check Login
        if($this->tools->getSettingByName('login') == 'true') {
			$this->load->model('user');
			if(!$this->user->is_logged_in()) redirect('login', 'refresh');
		}
    }
    
	public function index() {  
		$this->load->model('task');
		$tasks = $this->task->getTasks();
		
	    $this->load->library('page');
	    $html = $this->load->view('title',array('title' => "Tasks"),true);
	    $html .= $this->load->view('dash',array('tasks' => $tasks),true);
	    $this->page->show($html);
    }
    
    public function run() {
		$this->load->model('task');
		$tasks = $this->task->getTasks();
		
		foreach ($tasks as $task) {					
			$this->load->model('event');
			$event = $this->event->getEventByID($task->event);
			if ($event->name == 'timer') {
				// Get timer
				$this->load->model('timer');
				$timer = $this->timer->getTimerByID($task->event_opt);
					
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
				if ($timer->{$dow} == '1') {
					// Check time
					$now = date('H:i',time());
					if ($now == $timer->time) {
						// Get action
						$this->load->model('devices/device');
						$option = $this->device->getOptionByID($task->action);
						
						if ($option->name == 'toggle') {
							$this->device->toggle($task->target_type,$task->target_name,$task->action_opt);
						}
					}
				}
			}
		}
		
	}
	
	public function add($status,$device_type='',$device_name='') {
		if (empty($status) || trim($status) == '') {
			redirect(base_url('tasks/add/new'), 'refresh');
		}
		else {
			if ($status == 'validate') {
				$this->load->model('task');
				if (isset($_POST['form']) && $_POST['form']=='1') {
					// Take form input and validate
					$task_data = array(
						'name' => $_POST['tasks_name'],
						'clear_name' => $_POST['tasks_clear_name'],
						'description' => $_POST['tasks_description'],
						'active' => $_POST['tasks_active'],
						'event' => $_POST['tasks_event'],
						'action' => $_POST['tasks_action'],
						'action_opt' => $_POST['tasks_action_opt'],
						'target_type' => $_POST['tasks_target_type'],
						'target_name' => $_POST['tasks_target_name']
					);
					
					// Event
					if (isset($_POST['add_event']) && $_POST['add_event'] == '1') {
						// Check if it's a timer
						if (isset($_POST['add_timer']) && $_POST['add_timer'] == '1') {
							// Add timer
							// Add Vendor
							$timer_data = array(
								'mon' => $_POST['timer_mon'],
								'tue' => $_POST['timer_tue'],
								'wed' => $_POST['timer_wed'],
								'thu' => $_POST['timer_thu'],
								'fri' => $_POST['timer_fri'],
								'sat' => $_POST['timer_sat'],
								'sun' => $_POST['timer_sun'],
								'time' => $_POST['timer_time']
							);
							
							// Add timer to DB
							$this->load->model('timer');
							$timer_id = $this->timer->addTimer($timer_data);
							
							// Add timer ID to task Data
							$task_data['event_opt'] = $timer_id;
						}
					}
					// Insert!
					$task_id = $this->task->addTask($task_data);
					
					// Done!
					redirect(base_url('devices/show/'.$task_data['target_name']), 'refresh');
				}
				else {
					redirect(base_url('tasks/add/new'), 'refresh');
				}
			}
			elseif ($status == 'new') {
				$this->load->library('page');
				$html = $this->load->view('title',array('title' => "Neuen Task anlegen"),true);
				
				$submit_data =array(
					'status' => $status
				);
				
				if (isset($device_type) && trim($device_type) != '') {
					$submit_data['device_type']=$device_type;
				}
				if (isset($device_name) && trim($device_name) != '') {
					$submit_data['device_name']=$device_name;
				}
				$html .= $this->load->view('add_task', $submit_data,true);

				$this->page->show($html);
			}
		}

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
