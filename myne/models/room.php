<?php
Class room extends CI_Model {
	/*
	 * 
	 * Rooms
	 * 
	 */
	 
	public function getRooms() {
		$query = $this->db->get('rooms');
		
		log_message('debug', 'Polling rooms from database');
		
		$rooms = array();
		foreach ($query->result() as $row)
		{
			$rooms[] = $row;
		}
		return $rooms;
	}
	
	public function getRoomsByName($name) {
		$this->db->select('*');
		$this->db->from('rooms');
		$this->db->like('name',$name);
		$query = $this->db->get();
		
		log_message('debug', 'Polling rooms with name like "'.$name.'" from database');
		
		$rooms = array();
		foreach ($query->result() as $row)
		{
			$rooms[] = $row;
		}
		return $rooms;
	}
	
	public function getRoomByID($id) {
		$query = $this->db->get_where('rooms', array('id' => $id));
		
		$room = "";	
		foreach ($query->result() as $row) {
			$room = $row;
		}
		
		log_message('debug', 'Polling room with ID "'.$id.'" from database');
		
		return $room;
	}
	
	public function getRoomByName($name) {
		$query = $this->db->get_where('rooms', array('name' => $name));
		
		$room = "";
		foreach ($query->result() as $row) {
			$room = $row;
		}
		
		log_message('debug', 'Polling room with name "'.$name.'" from database');
		
		return $room;
	}
	
	public function getLatestRoom() {
		$this->db->select('*');
		$this->db->from('rooms');
		$this->db->limit('1');
		$this->db->order_by('id','DESC');
		$query = $this->db->get();
		
		$room = "";
		foreach ($query->result() as $row) {
			$room = $row;
		}
		
		log_message('debug', 'Polling latest room from database');
		
		return $room;
	}
	
	public function deleteRoom($room) {
		
		log_message('debug', 'Deleting room with ID "'.$room->id.'" from database');
		
		// Find devices with this room as room
		$this->load->model('devices/device');
		$devices = $this->device->getDevicesByRoom($room->id);
		
		log_message('debug', 'Polling devices in room with ID "'.$room->id.'"');
		
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
		
		log_message('debug', 'Searching gateways in room with ID "'.$room->id.'"');
		
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
		
		log_message('debug', 'Adding room to database');
		
		return $this->db->insert_id();
	}
}
?>
