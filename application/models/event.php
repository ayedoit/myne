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
		return $events;
	}
	 
	public function getEventByName($name) {
		$query = $this->db->get_where('events', array('name' => $name));
		
		foreach ($query->result() as $row)
		{
			$event = $row;
		}
		return $event;
	}
	public function getEventByID($id) {
		$query = $this->db->get_where('events', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$event = $row;
		}
		return $event;
	}
	
	public function addEvent($data) {
		$this->db->insert('events', $data); 
		return $this->db->insert_id();
	}
}
?>
