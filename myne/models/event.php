<?php
Class event extends CI_Model {
	/*
	 * 
	 * Models
	 * 
	 */
	 
	public function getEvents() {
		$query = $this->db->get('events');
		
		$events = array();
		foreach ($query->result() as $row)
		{
			$events[] = $row;
		}
		log_message('debug', 'Polling events from database');
		return $events;
	}
	 
	public function getEventByName($name) {
		$query = $this->db->get_where('events', array('name' => $name));
		
		$event = "";
		foreach ($query->result() as $row)
		{
			$event = $row;
		}
		log_message('debug', 'Polling event "'.$name.'" from database');
		return $event;
	}
	public function getEventByID($id) {
		$query = $this->db->get_where('events', array('id' => $id));
		
		$event = "";
		foreach ($query->result() as $row)
		{
			$event = $row;
		}
		log_message('debug', 'Polling event with id "'.$id.'" from database');
		return $event;
	}
	
	public function addEvent($data) {
		$this->db->insert('events', $data); 
		log_message('debug', 'Add event to Database');
		return $this->db->insert_id();
	}
}
?>
