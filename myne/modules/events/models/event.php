<?php
Class event extends CI_Model {
	/*
	 * 
	 * Events
	 * 
	 */
	 
	public function getEventTypes() {
		$query = $this->db->get('events');
		
		$events = array();
		foreach ($query->result() as $row)
		{
			$events[] = $row;
		}
		log_message('debug', 'Polling events from database');
		return $events;
	}
	 
	public function getEventTypeByName($name) {
		$query = $this->db->get_where('events', array('name' => $name));
		
		$event = "";
		foreach ($query->result() as $row)
		{
			$event = $row;
		}
		log_message('debug', 'Polling event "'.$name.'" from database');
		return $event;
	}
	public function getEventTypeByID($id) {
		$query = $this->db->get_where('events', array('id' => $id));
		
		$event = "";
		foreach ($query->result() as $row)
		{
			$event = $row;
		}
		log_message('debug', 'Polling event with id "'.$id.'" from database');
		return $event;
	}

	public function getEvents() {
		$query = $this->db->get('event_list');
		
		$event_list = array();
		foreach ($query->result() as $row)
		{
			$event_list[] = $row;
		}
		log_message('debug', 'Polling eventlist from database');
		return $event_list;
	}

	public function getEventByID($id) {
		$query = $this->db->get_where('event_list', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$event_list = $row;
		}
		log_message('debug', 'Polling event with id "'.$id.'" from eventlist');
		return $event_list;
	}
	
	public function addEvent($data) {
		$this->db->insert('events', $data); 
		log_message('debug', 'Add event to Database');
		return $this->db->insert_id();
	}

	/*
	 * This function parses and validates an event either by ID or the submitted data
	 */
	public function parseEvent($id="",$data="") {
		if (isset($id) && trim($id)!='') {
			// $id is set, so pull event from database
			$event = $this->getEventByID($id);

			// Determine event type
			$event_type = $this->getEventTypeByID($event->event_id);

			// Get event model so specific parser can be loaded
			$event_model = $event_type->model;

			// Load model, parse event
			$this->load->model($event_model,'e_model');

			// Parse event data
			if ($this->e_model->parseEvent($event->data)) {
				return true;
			}
			return false;
		}
		else {
			// Parse data
			$parsed_data = json_decode($data);

			// Get model from data
			$event_model = $parsed_data->model;

			// Load model, parse event
			$this->load->model($event_model,'e_model');

			// Parse event data
			if ($this->e_model->parseEvent($data)) {
				return true;
			}
			return false;
		}
		return false;
	}

	public function encodeEvent($data) {
		return json_encode($data);
	}

	public function decodeEvent($data) {
		return json_decode($data);
	}
}
?>
