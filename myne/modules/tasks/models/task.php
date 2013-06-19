<?php
Class task extends CI_Model {
	
	public function getTasks() {
		$query = $this->db->get('tasks');
		
		log_message('debug', 'Polling tasks from database');
		
		$tasks = array();
		foreach ($query->result() as $row)
		{
			$tasks[] = $row;
		}
		return $tasks;
	}
	 
	public function getTaskByID($id) {
		$query = $this->db->get_where('tasks', array('id' => $id));
		
		log_message('debug', 'Polling task with ID "'.$id.'" from database');
		
		$task = "";
		foreach ($query->result() as $row)
		{
			$task = $row;
		}
		return $task;
	}

	public function getTasksByEventItem($event_item_id) {
		$query = $this->db->get_where('tasks', array('event_item_id' => $event_item_id));
		
		log_message('debug', 'Polling task including event item with ID "'.$event_item_id.'" from database');
		
		$tasks = array();
		foreach ($query->result() as $row)
		{
			$tasks[] = $row;
		}
		return $tasks;
	}
	
	public function getTasksByTargetName($target_type,$target_name) {
		$query = $this->db->get_where('tasks', array('target_name' => $target_name,'target_type' => $target_type));
		
		log_message('debug', 'Polling tasks for target of type "'.$target_type.'" with name "'.$target_name.'" from database');
		
		$tasks = array();
		foreach ($query->result() as $row)
		{
			$tasks[] = $row;
		}
		return $tasks;
	}

	public function getTasksByTargetType($target_type) {
		$query = $this->db->get_where('tasks', array('target_type' => $target_type));
		
		log_message('debug', 'Polling tasks for target of type "'.$target_type.'" from database');
		
		$tasks = array();
		foreach ($query->result() as $row)
		{
			$tasks[] = $row;
		}
		return $tasks;
	}
	
	public function addTask($data) {
		$this->db->insert('tasks', $data); 
		
		log_message('debug', 'Adding new task to database');
		
		return $this->db->insert_id();
	}
	
	/*public function updateTask($name,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);
		
		$this->db->where('name', $name);
		try {
			$this->db->update('tasks', $data);
			log_message('debug', 'Updating task with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			log_message('debug', 'Updating task with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		} 
	}
	
	public function deleteTask($name) {
		// Delete task data to delete events
		$task = $this->getTaskByName($name);
		
		log_message('debug', 'Attempting to remove task with name "'.$task->clear_name.'" from database...');
		
		// What kind of event is the task bound to?
		log_message('debug', 'Determining event type of task');
		$this->load->model('event');
		$event = $this->event->getEventByID($task->event);	
		
		// Timer
		if ($event->name == 'timer') {
			log_message('debug', 'Event is of type "timer"');
			$this->load->model('timers/timer');
			
			// Get concrete timer to current task
			log_message('debug', 'Polling specific timer for task "'.$task->clear_name.'" from database');
			$timer = $this->timer->getTimerByID($task->event_opt);
			
			// Delete timer
			$this->timer->deleteTimer($timer->id);
		}
			
		// Delete task
		log_message('debug', 'Removing task with name "'.$task->clear_name.'" from database');
		$this->db->delete('tasks', array('name' => $name)); 
	}*/
}
?>
