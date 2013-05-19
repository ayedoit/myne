<?php
Class tools extends CI_Model {
	/*
	 * 
	 * Tools
	 * 
	 */
	 
	public function idIsUnique($id,$id_type) {
		$query = $this->db->get_where($id_type,array('name' => $id));
		
		if ($query->num_rows != 0) {
			return "false";
		}
		return "true";
	}
}
?>
