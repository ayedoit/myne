<?php
Class dario extends CI_Model {
	/*
	system code: Combination of Master & Slave DIP, each 6 Digits
	011011 100000

	See: 	http://forum.power-switch.eu/viewtopic.php?f=12&t=29#p4070
		http://forum.power-switch.eu/viewtopic.php?f=12&t=100

		#1 EIN 00010001
		#1 AUS 00000000
		#1 HELL 00001010
		#1 DUNKEL 00011011
		#2 EIN 10010011
		#2 AUS 10000010
		#2 HELL 10001000
		#2 DUNKEL 10011001
		#3 EIN 11010010
		#3 AUS 11000011
		#3 HELL 11001001
		#3 DUNKEL 11011000
		#4 EIN 01010000
		#4 AUS 01000001
		#4 HELL 01001011
		#4 DUNKEL 01011010
		ALLE EIN 11110000
		ALLE AUS 11100001
	*/
	public function msg($device, $action) {
		if(empty($device->masterdip)) {
			log_message('debug', 'Master DIP for device "'.$device->clear_name.'" not set');
			throw new Exception('Kein Master DIP für '.$device->clear_name.' gesetzt.');
			die;
		}
		if(empty($device->slavedip)) {
			log_message('debug', 'Slave DIP for device "'.$device->clear_name.'" not set');
			throw new Exception('Kein Slave DIP für '.$device->clear_name.' gesetzt.');
			die;
		}
		$sA=0;
		$sG=0;
		$sRepeat=5;
		$sPause=65535;
		$sTune=667;
		$sBaud="21";
		$sSpeed=16;
		$uSleep=800000;
		$HEAD="TXP:$sA,$sG,$sRepeat,$sPause,$sTune,$sBaud,1,";
		$TAIL="1,$sSpeed,;";
        $AN="2,1,1,2,1,2,2,1,1,2,1,2,2,1,2,1,";
        $AUS="2,1,1,2,1,2,1,2,1,2,1,2,2,1,1,2,";
        $HELL="2,1,1,2,1,2,1,2,2,1,1,2,1,2,1,2,";
        $DUNKEL="2,1,1,2,1,2,2,1,2,1,1,2,1,2,2,1,";
        $bitLow=1;
        $bitHgh=2;
        $seqLow=$bitLow.",".$bitHgh.",";
        $seqHgh=$bitHgh.",".$bitLow.",";
		$bits=$device->masterdip;
		$msg="";
		for($i=0;$i<strlen($bits);$i++) {   
			$bit=substr($bits,$i,1);
			if($bit=="0") {
				$msg=$msg.$seqLow;
			} else {
				$msg=$msg.$seqHgh;
			}
		}
		$msgM=$msg;
		$bits=$device->slavedip;
		$msg="";
		for($i=0;$i<strlen($bits);$i++) {
			$bit=substr($bits,$i,1);
			if($bit=="0") {
				$msg=$msg.$seqLow;
			} else {
				$msg=$msg.$seqHgh;
			}
		}
		$msgS=$msg;
		if($action=="on") {
			return $HEAD.$msgM.$msgS.$AN.$TAIL;
		} elseif ($action == "off") {
			return $HEAD.$msgM.$msgS.$AUS.$TAIL;
		}
		elseif ($action == "incr") {
			return $HEAD.$msgM.$msgS.$HELL.$TAIL;
		}
		elseif ($action == "decr") {
			return $HEAD.$msgM.$msgS.$DUNKEL.$TAIL;
		}
	}
}
?>
