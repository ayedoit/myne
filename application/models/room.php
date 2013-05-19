<?php
Class room extends CI_Model {
	/*
	 * 
	 * Rooms
	 * 
	 */
	 
	public function getRooms() {
		$this->load->database();
		$query = $this->db->get('rooms');
		
		$rooms = array();
		foreach ($query->result() as $row)
		{
			$rooms[] = $row;
		}
		return $rooms;
	}
	
	public function getRoomsByName($name) {
		$this->load->database();
		$this->db->select('*');
		$this->db->from('rooms');
		$this->db->like('name',$name);
		$query = $this->db->get();
		
		$rooms = array();
		foreach ($query->result() as $row)
		{
			$rooms[] = $row;
		}
		return $rooms;
	}
	
	public function getRoomByID($id) {
		$query = $this->db->get_where('rooms', array('id' => $id));
				
		foreach ($query->result() as $row)
		{
			$room = $row;
		}
		return $room;
	}
	
	public function getRoomByName($name) {
		$query = $this->db->get_where('rooms', array('name' => $name));
				
		foreach ($query->result() as $row)
		{
			$room = $row;
		}
		return $room;
	}
	
	public function getLatestRoom() {
		$this->db->select('*');
		$this->db->from('rooms');
		$this->db->limit('1');
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		
		foreach ($query->result() as $row)
		{
			$room = $row;
		}
		return $room;
	}
	
	public function addRoom($data) {
		$this->db->insert('rooms', $data); 
		return $this->db->insert_id();
	}
}
?>
