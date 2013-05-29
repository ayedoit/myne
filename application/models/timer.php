<?php
Class timer extends CI_Model {
	/*
	 * 
	 * Models
	 * 
	 */
	 
	public function getTimer() {
		$query = $this->db->get('timer');
		
		$timer = array();
		foreach ($query->result() as $row)
		{
			$timer[] = $row;
		}
		return $timer;
	}
	 
	public function getTimerByID($id) {
		$query = $this->db->get_where('timer', array('id' => $id));
		foreach ($query->result() as $row)
		{
			$timer = $row;
		}
		return $timer;
	}
	
	public function addTimer($data) {
		$this->db->insert('timer', $data); 
		return $this->db->insert_id();
	}
	
	public function updateTimer($id,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);

		$this->db->where('id', $id);
		try {
			$this->db->update('timer', $data); 
			return true;
		}  catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	public function deleteTimer($id) {
		// Delete timer
		$this->db->delete('timer', array('id' => $id)); 
	}
}
?>
