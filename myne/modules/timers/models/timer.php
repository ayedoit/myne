<?php
Class timer extends CI_Model {
	/*
	 * 
	 * Models
	 * 
	 */
	 
	public function getTimer() {
		$query = $this->db->get('timer');
		
		log_message('debug', 'Polling timers from database');
		
		$timer = array();
		foreach ($query->result() as $row)
		{
			$timer[] = $row;
		}
		return $timer;
	}
	 
	public function getTimerByID($id) {
		$query = $this->db->get_where('timer', array('id' => $id));
		
		log_message('debug', 'Polling timer with ID "'.$id.'" from database');
		
		foreach ($query->result() as $row)
		{
			$timer = $row;
		}
		return $timer;
	}
	
	public function addTimer($data) {
		$this->db->insert('timer', $data); 
		
		log_message('debug', 'Adding timer to database');
		
		return $this->db->insert_id();
	}
	
	public function updateTimer($id,$what,$new_value) {
		$data = array(
		   $what => $new_value
		);
		
		$this->db->where('id', $id);
		try {
			$this->db->update('timer', $data); 
			log_message('debug', 'Updating timer with ID "'.$id.'", setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			log_message('debug', 'Updating timer with ID "'.$id.'", setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		}
	}
	
	public function deleteTimer($id) {
		// Delete timer
		log_message('debug', 'Removing timer with ID "'.$id.'" from database');
		$this->db->delete('timer', array('id' => $id)); 
	}
}
?>
