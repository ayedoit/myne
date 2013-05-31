<?php
Class tools extends CI_Model {
	/*
	 * 
	 * Tools
	 * 
	 */
	 
	public function idIsUnique($id,$id_type) {
		
		log_message('debug', 'Checking if identifier "'.$id.'" of type "'.$id_type.'" is unique');
		
		$query = $this->db->get_where($id_type,array('name' => $id));
		
		if ($query->num_rows != 0) {
			return "false";
		}
		return "true";
	}
	
	public function getSettings() {
		$query = $this->db->get('settings');
		
		log_message('debug', 'Polling settings from database');
		
		$settings = array();
		foreach ($query->result() as $row)
		{
			$settings[] = $row;
		}
		return $settings;
	}
	
	public function getSettingByName($name) {
		$query = $this->db->get_where('settings', array('name' => $name));
		
		log_message('debug', 'Polling setting "'.$name.'" from database');
		
		foreach ($query->result() as $row)
		{
			$setting[] = $row;
		}
		return $setting;
	}
	
	//~ $this->load->model('cron');
					//~ $cron = $this->cron->onDayOfWeek('sat,sun');
					//~ $this->cron->onHour(20);
					//~ $this->cron->onMinute(10);
					//~ $this->cron->onMonth('*');
					//~ $this->cron->ondayOfMonth('*');
					//~ $this->cron->doJob('echo "Hallo"');
					//~ $this->cron->listJobs();
					//~ 
					//~ $this->cron->activate();
					//~ $this->cron->listJobs();
					//~ var_dump($cron);
}
?>
