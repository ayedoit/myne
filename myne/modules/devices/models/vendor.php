<?php
Class vendor extends CI_Model {
	/*
	 * 
	 * Vendors
	 * 
	 */
	 
	public function getVendors() {
		$this->load->database();
		$query = $this->db->get('vendors');
		
		$vendors = array();
		foreach ($query->result() as $row)
		{
			$vendors[] = $row;
		}
		return $vendors;
	}
	 
	public function getVendorByID($id) {
		$this->load->database();
		$query = $this->db->get_where('vendors', array('id' => $id));
		
		foreach ($query->result() as $row)
		{
			$vendor = $row;
		}
		return $vendor;
	}
	
	public function getVendorsByType($type) {
		$this->db->select('*');
		$this->db->from('vendors');
		$this->db->join('vendor_types','vendor_types.vendor_id = vendors.id AND vendor_types.type_id = '.$type);
		$query = $this->db->get();
		
		$vendors = array();
		foreach ($query->result() as $row)
		{
			$vendors[] = $row;
		}
		return $vendors;
	}
	
	public function addVendor($data) {
		$this->db->insert('vendors', $data); 
		return $this->db->insert_id();
	}
}
?>
