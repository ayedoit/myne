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
	
	public function updateTask($id,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);
		
		$this->db->where('id', $id);
		try {
			$this->db->update('tasks', $data);
			log_message('debug', 'Updating task with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			log_message('debug', 'Updating task with name "'.$name.'", setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		} 
	}

	public function deleteTask($task_id) {
		// Delete task data to delete events
		$task = $this->getTaskByID($task_id);

		log_message('debug', 'Attempting to remove task with ID "'.$task->id.'" from database...');

		// Delete action item
		$this->load->model('action');
		$this->action->deleteActionItem($task->action_item_id);

		//Delete event item
		$this->load->model('events/event');
		$this->event->deleteEvent($task->event_item_id);
			
		// Delete task
		log_message('debug', 'Removing task with ID "'.$task->id.'" from database');
		$this->db->delete('tasks', array('id' => $task_id)); 
	}
}
?>
