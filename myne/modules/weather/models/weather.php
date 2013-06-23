<?php
Class weather extends CI_Model {
	public function get_city($city) {
		// Check if curl is available
		if (!function_exists('curl_init')){
	        throw new Exception('Sorry, cURL is not installed! On linux hosts, install "curl" & "php5-curl"');
	    }

		// Get City from API
		// jSON URL which should be requested
		$url = 'http://api.openweathermap.org/data/2.1/find/name?q='.urlencode($city).'&lang=de&type=like';
		 
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
		    foreach($data->list as $city) {
		    	$cities[] = $city->name;
		    }
		}

		return json_encode($cities);
	    curl_close($curl);
	}
}
?>
