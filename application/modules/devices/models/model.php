<?php
Class model extends CI_Model {
	/*
	 * 
	 * Models
	 * 
	 */
	 
	public function getModels() {
		$this->load->database();
		$query = $this->db->get('models');
		
		$models = array();
		foreach ($query->result() as $row)
		{
			$models[] = $row;
		}
		return $models;
	}
	 
	public function getModelByID($id) {
		$this->load->database();
		$query = $this->db->get_where('models', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$model = $row;
		}
		return $model;
	}
	
	public function getModelsByVendor($vendor) {
		$query = $this->db->get_where('models',array("vendor_id" => $vendor));
		
		$models = array();
		foreach ($query->result() as $row)
		{
			$models[] = $row;
		}
		return $models;
	}
	
	public function addModel($data) {
		$this->db->insert('models', $data); 
		return $this->db->insert_id();
	}
}
?>
