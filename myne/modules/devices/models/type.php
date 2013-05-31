<?php
Class type extends CI_Model {
	/*
	 * 
	 * Types
	 * 
	 */
	 
	public function getTypes() {
		$query = $this->db->get('device_types');
		
		log_message('debug', 'Polling device types from database');
		
		$types = array();
		foreach ($query->result() as $row)
		{
			$types[] = $row;
		}
		return $types;
	}
	 
	public function getTypeByID($id) {
		$query = $this->db->get_where('device_types', array('id' => $id));
		
		log_message('debug', 'Polling device type with ID "'.$id.'" from database');
		
		foreach ($query->result() as $row)
		{
			$type = $row;
		}
		return $type;
	}
}
?>
