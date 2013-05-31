<?php
Class vendor extends CI_Model {
	/*
	 * 
	 * Vendors
	 * 
	 */
	 
	public function getVendors() {
		$query = $this->db->get('vendors');
		
		log_message('debug', 'Polling vendors from database');
		
		$vendors = array();
		foreach ($query->result() as $row)
		{
			$vendors[] = $row;
		}
		return $vendors;
	}
	 
	public function getVendorByID($id) {
		$query = $this->db->get_where('vendors', array('id' => $id));
		
		log_message('debug', 'Polling vendor with ID "'.$id.'" from database');
		
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
		
		log_message('debug', 'Polling vendors of type "'.$type.'" from database');
		
		$vendors = array();
		foreach ($query->result() as $row)
		{
			$vendors[] = $row;
		}
		return $vendors;
	}
	
	public function addVendor($data) {
		$this->db->insert('vendors', $data); 
		
		log_message('debug', 'Adding vendor with name "'.$data['clear_name'].'" to database');
		
		return $this->db->insert_id();
	}
}
?>
