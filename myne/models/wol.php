<?php
Class wol extends CI_Model {
	// Weckt Computer über LAN auf (Diese Funktion muss im Bios aktiviert sein)
	public function WakeOnLan($addr, $mac, $socket_number) {
	  log_message('debug', 'Waking device with address "'.$addr.'" (MAC: "'.$mac.'", Socket: "'.$socket_number.'") over LAN');
	  
	  $addr_byte = explode(':', $mac);
	  $hw_addr = '';

	  for ($a=0; $a <6; $a++) {
		$hw_addr .= chr(hexdec($addr_byte[$a]));
	  }
	  $msg = chr(255).chr(255).chr(255).chr(255).chr(255).chr(255);
	  for ($a = 1; $a <= 16; $a++) {
		$msg .= $hw_addr;
	  }

	  // UDP Socket erstellen    
	  $s = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

	  if ($s == false) {
		$errorcode = socket_last_error($s);
		$errormsg = socket_strerror($errorcode);
		log_message('debug', 'WoL: Could not create socket: ['.$errorcode.']:'.$errormsg);
		throw new Exception("Could not create socket: [".$errorcode."]: ".$errormsg);
		return FALSE;
	  } else {
		// Socket Optionen setzen:
		$opt_ret = socket_set_option($s, SOL_SOCKET, SO_BROADCAST, TRUE);
		if($opt_ret <0) {
		  $errormsg = strerror($opt_ret);
		  log_message('debug', 'WoL: Could not set socket option: '.$errormsg);
		  throw new Exception("Could not set socket option: ".$errormsg);
		  return FALSE;
		}
		// Paket abschicken
		if(socket_sendto($s, $msg, strlen($msg), 0, $addr, $socket_number)) {
		  log_message('debug', 'WoL: message sent');
		  socket_close($s);
		  return TRUE;
		} else {
		  log_message('debug', 'WoL: Could not send message');
		  throw new Exception("WoL: Could not send message");
		  return FALSE;
		}
	  }
	}
	public function wakeup ($mac_addr, $broadcast) {
		if (!$fp = fsockopen('udp://' . $broadcast, 2304, $errno, $errstr, 2)) {
			log_message('debug', 'WoL: Could not send message');
			throw new Exception("WoL: Could not send message");
			return false;
		}
		$mac_hex = preg_replace('=[^a-f0-9]=i', '', $mac_addr);
		$mac_bin = pack('H12', $mac_hex);
		$data = str_repeat("\xFF", 6) . str_repeat($mac_bin, 16);
		log_message('debug', 'WoL: message sent');
		fputs($fp, $data);
		fclose($fp);
		return true;
	} 
}
?>
