<?php
Class wol extends CI_Model {
	// Weckt Computer über LAN auf (Diese Funktion muss im Bios aktiviert sein)
	public function WakeOnLan($addr, $mac, $socket_number) {
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
		echo "Fehler bei socket_create!\n";
		echo "Fehlercode ist '".socket_last_error($s)."' - " . socket_strerror(socket_last_error($s));
		return FALSE;
	  } else {
		// Socket Optionen setzen:
		$opt_ret = socket_set_option($s, SOL_SOCKET, SO_BROADCAST, TRUE);
		if($opt_ret <0) {
		  echo "setsockopt() fehlgeschlagen, Fehler: " . strerror($opt_ret) . "\n";
		  return FALSE;
		}
		// Paket abschicken
		if(socket_sendto($s, $msg, strlen($msg), 0, $addr, $socket_number)) {
		  echo "WOL erfolgreich gesendet!";
		  socket_close($s);
		  return TRUE;
		} else {
		  echo "WOL fehlerhaft! \n";
		  return FALSE;
		}
	  }
	}
	public function wakeup ($mac_addr, $broadcast) {
		if (!$fp = fsockopen('udp://' . $broadcast, 2304, $errno, $errstr, 2))
			return false;
		$mac_hex = preg_replace('=[^a-f0-9]=i', '', $mac_addr);
		$mac_bin = pack('H12', $mac_hex);
		$data = str_repeat("\xFF", 6) . str_repeat($mac_bin, 16);
		fputs($fp, $data);
		fclose($fp);
		return true;
	} 
}
?>
