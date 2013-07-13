<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Weather extends MY_Controller { 
	public function index(){
		
	}

	public function get_city() {
		// Check if curl is available
		if (!function_exists('curl_init')){
	        show_error('Sorry, cURL is not installed! On linux hosts, install "curl" & "php5-curl"');
	    }

	    if (sizeof($_POST) != 0) {
	    	if (isset($_POST['q'])) {

	    		$q = $_POST['q'];
	    		// Get City from API
				// jSON URL which should be requested
				$url = 'http://api.openweathermap.org/data/2.1/find/name?q='.urlencode($q).'&lang=de&type=like';
				 
				$curl = curl_init();

			    $headers = array();

			    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			    curl_setopt($curl, CURLOPT_HEADER, 0);
			    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			    curl_setopt($curl, CURLOPT_URL, $url);
			    curl_setopt($curl, CURLOPT_TIMEOUT, 30);

			    $json = curl_exec($curl);

			    $data = json_decode($json);

			    $cities = array();
			    if (!empty($data)) {
			    	if (isset($data->list) && sizeof($data->list) != 0) {
				    	foreach($data->list as $city) {
				    		$cities[] = $city->name;
				    	}
				    }
				}
				echo json_encode($cities);

			    curl_close($curl);
	    	}
	    	else {
	    		echo json_encode(array(""));
	    	}
		}
		else {
			echo json_encode(array(""));
		}
	}
}