<?php
Class pollin extends CI_Model {
	/*
	system code : First 5 digits ())e.g. 10000)
	unit code (probably chars, convert to "binary"):
	A 10000
	B 01000
	...
	E 00001 

	Is almost the same model as Elro AB 440SC
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
		$sRepeat=10;
		$sPause=5600;
		$sTune=350;
		$sBaud="25";
		$sSpeed=14;
		$uSleep=800000;
		$HEAD="TXP:$sA,$sG,$sRepeat,$sPause,$sTune,$sBaud,";
		$TAIL="1,$sSpeed,;";
		$AN="1,3,1,3,1,3,3,1,";
		$AUS="1,3,3,1,1,3,1,3,";
		$bitLow=1;
		$bitHgh=3;
		$seqLow=$bitLow.",".$bitHgh.",".$bitLow.",".$bitHgh.",";
		$seqHgh=$bitLow.",".$bitHgh.",".$bitHgh.",".$bitLow.",";
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
