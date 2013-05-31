<?php
Class intertechno extends CI_Model {
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
		$sRepeat=12;
		$sPause=11125;
		$sTune=89;
		$sBaud="25";
		$sSpeed=4;
		$uSleep=800000;
		$HEAD="TXP:$sA,$sG,$sRepeat,$sPause,$sTune,$sBaud,";
		$TAIL=",1,$sSpeed,;";
		$AN="12,4,4,12,12,4";
		$AUS="12,4,4,12,4,12";
		$bitLow=4;
		$bitHgh=12;
		$seqLow=$bitHgh.",".$bitHgh.",".$bitLow.",".$bitLow.",";
		$seqHgh=$bitHgh.",".$bitLow.",".$bitHgh.",".$bitLow.",";
		$msgM="";
		switch (strtoupper($device->masterdip)) {
			case "A":
				$msgM=$seqHgh.$seqHgh.$seqHgh.$seqHgh;
				break;
			case "B":
				$msgM=$seqLow.$seqHgh.$seqHgh.$seqHgh;
				break;   
			case "C":
				$msgM=$seqHgh.$seqLow.$seqHgh.$seqHgh;
				break; 
			case "D":
				$msgM=$seqLow.$seqLow.$seqHgh.$seqHgh;
				break;
			case "E":
				$msgM=$seqHgh.$seqHgh.$seqLow.$seqHgh;
				break;
			case "F":
				$msgM=$seqLow.$seqHgh.$seqLow.$seqHgh;
				break;
			case "G":
				$msgM=$seqHgh.$seqLow.$seqLow.$seqHgh;
				break;
			case "H":
				$msgM=$seqLow.$seqLow.$seqLow.$seqHgh;
				break;
			case "I":
				$msgM=$seqHgh.$seqHgh.$seqHgh.$seqLow;
				break;
			case "J":
				$msgM=$seqLow.$seqHgh.$seqHgh.$seqLow;
				break;
			case "K":
				$msgM=$seqHgh.$seqLow.$seqHgh.$seqLow;
				break;
			case "L":
				$msgM=$seqLow.$seqLow.$seqHgh.$seqLow;
				break;
			case "M":
				$msgM=$seqHgh.$seqHgh.$seqLow.$seqLow;
				break;
			case "N":
				$msgM=$seqLow.$seqHgh.$seqLow.$seqLow;
				break;
			case "O":
				$msgM=$seqHgh.$seqLow.$seqLow.$seqLow;
				break;
			case "P":
				$msgM=$seqLow.$seqLow.$seqLow.$seqLow;
				break;
		}
		$msgS="";   
		switch ($device->slavedip){
			case "1":
				$msgS=$seqHgh.$seqHgh.$seqHgh.$seqHgh;
				break;
			case "2":
				$msgS=$seqLow.$seqHgh.$seqHgh.$seqHgh;
				break;   
			case "3":
				$msgS=$seqHgh.$seqLow.$seqHgh.$seqHgh;
				break; 
			case "4":
				$msgS=$seqLow.$seqLow.$seqHgh.$seqHgh;
				break;
			case "5":
				$msgS=$seqHgh.$seqHgh.$seqLow.$seqHgh;
				break;
			case "6":
				$msgS=$seqLow.$seqHgh.$seqLow.$seqHgh;
				break;
			case "7":
				$msgS=$seqHgh.$seqLow.$seqLow.$seqHgh;
				break;
			case "8":
				$msgS=$seqLow.$seqLow.$seqLow.$seqHgh;
				break;
			case "9":
				$msgS=$seqHgh.$seqHgh.$seqHgh.$seqLow;
				break;
			case "10":
				$msgS=$seqLow.$seqHgh.$seqHgh.$seqLow;
				break;
			case "11":
				$msgS=$seqHgh.$seqLow.$seqHgh.$seqLow;
				break;
			case "12":
				$msgS=$seqLow.$seqLow.$seqHgh.$seqLow;
				break;
			case "13":
				$msgS=$seqHgh.$seqHgh.$seqLow.$seqLow;
				break;
			case "14":
				$msgS=$seqLow.$seqHgh.$seqLow.$seqLow;
				break;
			case "15":
				$msgS=$seqHgh.$seqLow.$seqLow.$seqLow;
				break;
			case "16":
				$msgS=$seqLow.$seqLow.$seqLow.$seqLow;
				break;
		}
		if($action=="on") {
			return $HEAD.$bitLow.",".$msgM.$msgS.$seqHgh.$seqLow.$bitHgh.",".$AN.$TAIL;
		} elseif ($action=="off") {
			return $HEAD.$bitLow.",".$msgM.$msgS.$seqHgh.$seqLow.$bitHgh.",".$AUS.$TAIL;
		}
	}
}
?>
