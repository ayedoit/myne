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

	public function getHash($input) {
		return md5($input);
	}

	public function addUser($username,$password,$givenname,$surename) {
		$data = array(
			"username" => $username,
			"password" => $this->getHash($password),
			"surename" => $surename,
			"givenname" => $givenname
		);
		$this->db->insert('users',$data);
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
			$setting = $row;
		}
		log_message('debug','Setting "'.$name.'" has value "'.$setting->value.'"');
		return $setting->value;
	}

	public function updateSettings($what,$new_value) {
		$data = array(
		   "value" => $new_value
		);
		
		$this->db->where('name', $what);
		try {
			$this->db->update('settings', $data);
			log_message('debug', 'Updating Settings, setting "'.$what.'" to "'.$new_value.'" in database');
			return true;
		}  catch (Exception $e) {
			log_message('debug', 'Updating Settings, setting "'.$what.'" to "'.$new_value.'" in database NOT successful: "'.$e->getMessage().'"');
			throw new Exception($e->getMessage());
		}
	}

	public function generateAPIKey() {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	    for ($i = 0; $i < 24; $i++) {
	        $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
	    return $randomString;
	}

	public function setupMysql()
	{
		try {
			$queries = $this->getQueriesFromSQLFile('data/myne.sql');
		} catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
	    
	    foreach($queries as $query)
	    {
	        try
	        {
	            $this->db->query($query);
	        }
	        catch (Exception $e)
	        {
	            throw new Exception($e->getMessage());
	        }
	    }
	    return true;
	}
	 
	/**
	 * getQueriesFromSQLFile parses a sql file and extracts all queries
	 * for further processing with pdo execute.
	 *
	 * - strips off all comments, sql notes, empty lines from an sql file
	 * - trims white-spaces
	 * - filters the sql-string for sql-keywords
	 * - replaces the db_prefix
	 *
	 * @param $file sqlfile
	 * @return array Trimmed array of sql queries, ready for insertion into db.
	 */
	public function getQueriesFromSQLFile($sqlfile)
	{
	    if(is_readable($sqlfile) === false)
	    {
	        throw new Exception($sqlfile . 'does not exist or is not readable.');
	    }
	 
	    # read file into array
	    $file = file($sqlfile);
	 
	    # import file line by line
	    # and filter (remove) those lines, beginning with an sql comment token
	    $file = array_filter($file,
	                    create_function('$line',
	                            'return strpos(ltrim($line), "--") !== 0;'));
	 
	    # and filter (remove) those lines, beginning with an sql notes token
	    $file = array_filter($file,
	                    create_function('$line',
	                            'return strpos(ltrim($line), "/*") !== 0;'));
	 
	    # this is a whitelist of SQL commands, which are allowed to follow a semicolon
	    $keywords = array(
	        'ALTER', 'CREATE', 'DELETE', 'DROP', 'INSERT',
	        'REPLACE', 'SELECT', 'SET', 'TRUNCATE', 'UPDATE', 'USE'
	    );
	 
	    # create the regular expression for matching the whitelisted keywords
	    $regexp = sprintf('/\s*;\s*(?=(%s)\b)/s', implode('|', $keywords));
	 
	    # split there
	    $splitter = preg_split($regexp, implode("\r\n", $file));
	 
	    # remove trailing semicolon or whitespaces
	    $splitter = array_map(create_function('$line',
	                            'return preg_replace("/[\s;]*$/", "", $line);'),
	                          $splitter);
	 
	    # remove empty lines
	    return array_filter($splitter, create_function('$line', 'return !empty($line);'));
	}

	public function getIcons() {
		if ($handle = opendir('img/type_icons')) {
			$icons = array();
		    while (false !== ($file = readdir($handle))) {
		        if ($file != "." && $file != "..") {
		            $icons[] = $file;
		        }
		    }
		    closedir($handle);
		}
		return $icons;
	}

	public function getIconsByType() {
		if ($handle = opendir('img/type_icons')) {

			$icons = array();
		    while (false !== ($file = readdir($handle))) {
		        if ($file != "." && $file != "..") {
		            echo explode('_',$file);
		            $icons[] = $file;
		        }
		    }
		    closedir($handle);
		}
		return $icons;
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
