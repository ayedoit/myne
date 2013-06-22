<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Tasks extends MY_Controller {    
	public function index() {  
		$this->load->model('tasks/task');
		$tasks = $this->task->getTasks();
		
	    $this->load->library('page');
	    $html = $this->load->view('title',array('title' => "Tasks"),true);
	    $html .= $this->load->view('dash',array('tasks' => $tasks),true);
	    $this->page->show($html);
    }
    
    public function update($type,$id){
		if ($type == 'timer') {
			$this->load->model('timers/timer');
			try {
				$update = $this->timer->updateTimer($id,$_POST['pk'],$_POST['value']);
				return true;
			} catch (Exception $e) {
				show_error($e->getMessage(), 500);
			}			
		}
	}
    
    public function run() {
    	// Get current event items and loop over them
    	// Parse every event to see if it occurs
    	// If yes, check if there's a tasked mapped to the event
    	// If yes, trigger the action

    	$this->load->model('events/event');
    	$events = $this->event->getEvents();

    	log_message('debug', 'Starting Cron, checking for occuring events');

    	foreach($events as $event_item) {
    		if($this->event->parseEvent($event_item->id)) {
    			log_message('debug', 'Event with ID "'.$event_item->id.'" occurs. Checking if there is a task associated to this event');

    			// Check if there's a task with that event
    			$this->load->model('tasks/task');
    			$tasks = $this->task->getTasksByEventItem($event_item->id);

    			if (sizeof($tasks) != 0) {
    				log_message('debug', 'Found '.sizeof($tasks).' tasks associated with event item with ID "'.$event_item->id.'"');

    				// Trigger the action
    				$this->load->model('action');

    				foreach ($tasks as $task) {	
    					log_message('debug', 'Triggering action with ID "'.$task->action_item_id.'" for event item with ID "'.$event_item->id.'"');
    					$this->action->triggerAction($task->action_item_id);
    				}
    			}
    			else {
    				log_message('debug', 'No tasks associated with event item with ID "'.$event_item->id.'" found');
    				return false;
    			}
    		}
    		else {
    			log_message('debug', 'Event item with ID "'.$event_item->id.'" is not occuring right now');
    		}
    	}
	}
	
	public function add($status="",$device_type='',$device_name='') {
		if (empty($status) || trim($status) == '') {
			log_message('debug', '[Tasks/Add]: No status given (should be "new" for new rooms or "validate" for validation)');
			redirect(base_url('tasks/add/new'), 'refresh');
		}
		else {
			if ($status == 'validate') {
				$this->load->model('tasks/task');
				if (isset($_POST['form']) && $_POST['form']=='1') {

					// Resolve device data
					$this->load->model('devices/device');
					$device = $this->device->getDeviceByID($_POST['tasks_target_name']);

					// Overall task data
					$task_data = array(
						'target_type' => $_POST['tasks_target_type'],
						'target_name' => $device->name
					);

					// Event data
					// What type of event is it?
					$this->load->model('events/event');
					$event_type = $this->event->getEventTypeByID($_POST['tasks_event']);

					// Load event model
					$this->load->model($event_type->model,'e_model');

					// Make an event from the given data
					try {
						$params = $this->e_model->makeEvent($_POST);
						$event_data = array(
							'model' => $event_type->model,
							'params' => $params
						);

						// Add event to database event_items
						$task_data['event_item_id'] = $this->event->addEvent($event_type->id,$this->event->encodeEvent($event_data));
					} catch (Exception $e) {
						show_error($e->getMessage(), 500);
					}
					
					// Action Data
					$this->load->model('action');
					$action = $this->action->getActionByID($_POST['tasks_action']);

					// Currently, "set_status" is called toggle; in the future, this will be arranged like the timer model for more flexibility
					// For now, here's a hardcoded switch
					if ($action->name == 'set_status') {
						$method = 'toggle';
					}

					$data = array(
						'method' => $method,
						'params' => array(
							'model' => $action->model,
							'opts' => array(
								0 => $task_data['target_type'],
								1 => $device->name,
								2 => $_POST['tasks_action_opt']
							)
						)
					);

					$action_data = $this->action->encodeAction($data);
					$task_data['action_item_id'] = $this->action->addActionItem($action->id,$action_data);

					// Insert!
					$task_id = $this->task->addTask($task_data);
					
					// Done!
					switch ($task_data['target_type']) {
						case 'device': $url = 'devices/show/'.$task_data['target_name']; break;
						case 'group': $url = 'devices/showgroup/'.$task_data['target_name']; break;
						case 'gateway': $url = 'gatways/show/'.$task_data['target_name']; break;
						case 'room': $url = 'rooms/show/'.$task_data['target_name']; break;
						default: $url = 'devices'; break;
					}
					redirect(base_url($url), 'refresh');
				}
				else {
					log_message('debug', '[Tasks/Add]: Validation requested but no data submitted');
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
}
