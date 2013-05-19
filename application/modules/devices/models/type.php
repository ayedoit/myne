<?php
Class type extends CI_Model {
	/*
	 * 
	 * Types
	 * 
	 */
	 
	public function getTypes() {
		$this->load->database();
		$query = $this->db->get('device_types');
		
		$types = array();
		foreach ($query->result() as $row)
		{
			$types[] = $row;
		}
		return $types;
	}
	 
	public function getTypeByID($id) {
		$this->load->database();
		$query = $this->db->get_where('device_types', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$type = $row;
		}
		return $type;
	}
}
?>
