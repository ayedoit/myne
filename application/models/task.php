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
	
	public function buildTaskLink($id) {
		$query = $this->db->get_where('tasks', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$task = $row;
			
			$this->load->model('devices/device');
			
			// Get option
			$option = $this->device->getOptionByID($task->option);
			
			// Map target_type
			$target_url = $this->map_target_type($task->target_type);
			
			$url = base_url($target_url."/".$option->name."/".$task->target_name."/".$task->msg);
		}
		return $url;
	}
	
	public function map_target_type($target_type) {
		switch ($target_type) {
			case "device" : $url_prefix='devices'; break;
			case "group" : $url_prefix='devices'; break;
			default : $url_prefix='devices';
		}
		return $url_prefix;
	}
}
?>
