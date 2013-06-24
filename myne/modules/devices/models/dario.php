<?php
Class dario extends CI_Model {
	/*
	system code: Combination of Master & Slave DIP, each 6 Digits
	011011 100000
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
		$sSpeed=1;
		$uSleep=800000;
		$HEAD="TXP:$sA,$sG,$sRepeat,$sPause,$sTune,$sBaud,";
		$TAIL="1,$sSpeed,;";
                $AN="2,1,1,2,1,2,2,1,1,2,1,2,2,1,2,1";
                $AUS="1,2,1,2,1,2,1,2,1,2,1,2,1,2,1,2";
                $bitLow=1;
                $bitHgh=2;
                $seqLow=$bitLow.",".$bitHgh.",";
                $seqHgh=$bitHgh.",".$bitLow.",";
		$bits=$device->masterdip;
		$msg="";
		for($i=0;$i<strlen($bits);$i++) {   
			$bit=substr($bits,$i,1);
			if($bit=="1") {
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
			if($bit=="1") {
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
	}
}
?>
