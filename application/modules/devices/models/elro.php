<?php
Class elro extends CI_Model {
	/*
	system code 10111
	Dann in Reihenfolge unit code
	A 10000
	B 01000
	E 00001   

	Elro AB440D 200W       TXP:0,0,10,5600,350,25   ,16:
	Elro AB440D 300W       TXP:0,0,10,5600,350,25   ,16:
	Elro AB440ID           TXP:0,0,10,5600,350,25   ,16:
	Elro AB440IS           TXP:0,0,10,5600,350,25   ,16:
	Elro AB440L            TXP:0,0,10,5600,350,25   ,16:
	Elro AB440WD           TXP:0,0,10,5600,350,25   ,16:
	*/
	public function msg($device, $action) {
		if(empty($device->masterdip)) {
			echo "ERROR: masterdip ist ungültig für device id ".$device->id;
			return;
		}
		if(empty($device->slavedip)) {
			echo "ERROR: slavedip ist ungültig für device id ".$device->id;
			return;
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
