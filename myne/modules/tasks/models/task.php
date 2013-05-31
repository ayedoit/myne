<?php
Class task extends CI_Model {
	
	public function getTasks() {
		$this->load->database();
		$query = $this->db->get('tasks');
		
		$tasks = array();
		foreach ($query->result() as $row)
		{
			$tasks[] = $row;
		}
		return $tasks;
	}
	 
	public function getTaskByID($id) {
		$this->load->database();
		$query = $this->db->get_where('tasks', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$task = $row;
		}
		return $task;
	}
	
	public function getTaskByName($name) {
		$this->load->database();
		$query = $this->db->get_where('tasks', array('name' => $name));
		
		foreach ($query->result() as $row)
		{
			$task = $row;
		}
		return $task;
	}
	
	public function getTasksByDevice($device_name,$device_type) {
		$this->load->database();
		$query = $this->db->get_where('tasks', array('target_name' => $device_name,'target_type' => $device_type));
		
		$tasks = array();
		foreach ($query->result() as $row)
		{
			$tasks[] = $row;
		}
		return $tasks;
	}
	
	public function addTask($data) {
		$this->db->insert('tasks', $data); 
		return $this->db->insert_id();
	}
	
	public function updateTask($name,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);

		$this->db->where('name', $name);
		try {
			$this->db->update('tasks', $data);
			return true;
		}  catch (Exception $e) {
			throw new Exception($e->getMessage());
		} 
	}
	
	public function deleteTask($name) {
		// Delete task data to delete events
		$task = $this->getTaskByName($name);
		
		// What kind of event is the task bound to?
		$this->load->model('event');
		$event = $this->event->getEventByID($task->event);
		
		// Timer
		if ($event->name == 'timer') {
			$this->load->model('timer');
			
			// Get concrete timer to current task
			$timer = $this->timer->getTimerByID($task->event_opt);
			
			// Delete timer
			$this->timer->deleteTimer($timer->id);
		}
			
		// Delete task
		$this->db->delete('tasks', array('name' => $name)); 
	}
}
?>
