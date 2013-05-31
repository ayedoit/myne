<?php
Class model extends CI_Model {
	/*
	 * 
	 * Models
	 * 
	 */
	 
	public function getModels() {
		$query = $this->db->get('models');
		
		log_message('debug', 'Polling models from database');
		
		$models = array();
		foreach ($query->result() as $row)
		{
			$models[] = $row;
		}
		return $models;
	}
	 
	public function getModelByID($id) {
		$query = $this->db->get_where('models', array('id' => $id));
		
		log_message('debug', 'Polling model with ID "'.$id.'" from database');
		
		foreach ($query->result() as $row)
		{
			$model = $row;
		}
		return $model;
	}
	
	public function getModelsByVendor($vendor) {
		$query = $this->db->get_where('models',array("vendor_id" => $vendor));
		
		log_message('debug', 'Polling models from vendor with ID "'.$vendor.'" from database');
		
		$models = array();
		foreach ($query->result() as $row)
		{
			$models[] = $row;
		}
		return $models;
	}
	
	public function addModel($data) {
		$this->db->insert('models', $data); 
		
		log_message('debug', 'Adding model with name "'.$data['clear_name'].'" to database');
		return $this->db->insert_id();
	}
}
?>
