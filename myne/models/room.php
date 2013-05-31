<?php
Class room extends CI_Model {
	/*
	 * 
	 * Rooms
	 * 
	 */
	 
	public function getRooms() {
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
	
	public function deleteRoom($room) {
		// Find devices with this room as room
		$this->load->model('devices/device');
		$devices = $this->device->getDevicesByRoom($room->id);
		
		if (sizeof($devices) != 0) {
			foreach ($devices as $device) {
				$data = array(
					'room' => 0
				);
				
				// Set new gateway to "0"
				$this->db->where('id',$device->id);
				$this->db->update('devices',$data);
			}
		}
		
		// Find gateways with this room as room
		$this->load->model('gateways/gateway');
		$gateways = $this->gateway->getGatewaysByRoom($room->id);
		
		if (sizeof($gateways) != 0) {
			foreach ($gateways as $gateways) {
				$data = array(
					'room' => 0
				);
				
				// Set new gateway to "0"
				$this->db->where('id',$gateways->id);
				$this->db->update('gateways',$data);
			}
		}
		
		// Delete Room
		$this->db->delete('rooms', array('name' => $room->name)); 
	}
	
	public function addRoom($data) {
		$this->db->insert('rooms', $data); 
		return $this->db->insert_id();
	}
}
?>
