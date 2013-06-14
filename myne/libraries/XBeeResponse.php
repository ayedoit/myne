require_once('XBeeFrameBase.php');
<?php
/**
 * XBeeResponse represents a response to a frame that has been sent.
 *
 * @package XBeeResponse
 */
class XBeeResponse extends _XBeeFrameBase {
	const REMOTE_RESPONSE_ID = '97', LOCAL_RESPONSE_ID = '88';
	protected $address16, $address64, $status, $cmd, $nodeId, $signalStrength;
	protected $status_bytes = array();
	
	/**
	 * Constructor.  Sets up an XBeeResponse
	 * 
	 * @param String $response A single frame of response from an XBee
	 */
	public function XBeeResponse($response) {
		parent::_XBeeFrameBase();
		
		$this->status_byte = array('00' => 'OK','01' => 'Error','02'=> 'Invalid Command', '03' => 'Invalid Parameter', '04' => 'No Response' );
		$this -> _parse($response);
		
		if ($this -> getApiId() === XBeeResponse::REMOTE_RESPONSE_ID) {
			$this -> _parseRemoteAt();
		} else if ($this -> getApiId() === XBeeResponse::LOCAL_RESPONSE_ID) {
			$this -> _parseLocalAt();
		} else {
			trigger_error('Could not determine response type or response type is not implemented.', E_USER_WARNING);
		}
		/* debug 
		echo '</br>';echo 'Response:';print_r($response);echo '</br>';
		echo ' apiId:';print_r($this->getApiId());echo '</br>';echo ' frameId:';print_r($this->getFrameId());echo '</br>';
		echo ' add64:';print_r($this->getAddress64());echo '</br>';echo ' add16:';print_r($this->getAddress16());echo '</br>';
		echo ' DB:';print_r($this->getSignalStrength());echo '</br>';echo ' NI:';print_r($this->getNodeId());echo '</br>';
		echo ' CMD:';print_r($this->getCmd());echo '</br>';echo ' Status:';print_r($this->getStatus());echo '</br>';
		echo ' isOk:';print_r($this->isOk());echo '</br>';*/
	}
	
	/**
	 * Parses the command data from the length and checksum
	 * 
	 * @param String $response A XBee frame response from an XBee
	 * @return void
	 */
	private function _parse($response) {
		$length = substr($response, 0, 4);
		$checksum = substr($response, -2);
		$cmdData = substr($response, 4, -2);
		$apiId = substr($cmdData, 0, 2);
		$frameId = substr($cmdData, 2, 2);
		$calculatedChecksum = $this -> _calcChecksum($this -> _packBytes($cmdData));
		$calculatedLength = $this -> _getFramelength($this -> _packBytes($cmdData));
		
		$packedChecksum = $this->_packBytes($checksum);	//pack for comparison
		$packedLength = $this->_packBytes($length);	//pack for comparison

		if ($packedChecksum === $calculatedChecksum && $packedLength === $calculatedLength) {
			$this -> setApiId($apiId);
			$cmdData = $this->_unpackBytes($cmdData);
			$cmdData=$cmdData[1];
			$this -> setCmdData($cmdData);
			$this -> setFrameId($frameId);
			$this -> setFrame($response);
		} else {
			trigger_error('Checksum or length check failed.', E_USER_WARNING);
		}
	}
	
	/**
	 * Parses remote At command
	 * 
	 * @return void
	 */
	private function _parseRemoteAt() {
		//A valid remote frame looks like this:
		//<apiId1> <frameId1> <address64,8> <address16,8> <command,2> <status,2>
		
		$cmdData = $this->getCmdData();
		
		$cmd = substr($cmdData, 24, 4);
		$cmd = $this->_hexstr($cmd);
		
		$frameId = substr($cmdData, 2, 2);
		$status = substr($cmdData, 4, 2);
		$address64 = substr($cmdData, 4, 16);
		$address16 = substr($cmdData, 20, 4);
		$signalStrength = substr($cmdData, 30, 2);
		
		$this->_setSignalStrength($signalStrength);
		$this->setAddress16($address16);
		$this->setAddress64($address64);
		$this->_setCmd($cmd);
		$this->_setStatus($status);
		$this->setFrameId($frameId);	
	}
	
	/**
	 * Parses a Local At Command response
	 * 
	 * @return void
	 */
	private function _parseLocalAt() {
		//A valid local frame looks like this:
		//<api_id1> <frameId1> <command2> <status2> <add16> <add64> <DB> <NI> <NULL>
		$cmdData = $this->getCmdData();
		
		$cmd = substr($cmdData, 4, 6);
		$cmd = $this->_hexstr($cmd);
		$frameId = substr($cmdData, 2, 2);
		$status = substr($cmdData, 8, 2);
		$address64 = substr($cmdData, 14, 16);
		$address16 = substr($cmdData, 10, 4);
		$signalStrength = substr($cmdData, 30, 2);
		$nodeId = $this->_hexstr(substr($cmdData, 32, -2));
		
		$this -> _setNodeId($nodeId);
		$this->_setSignalStrength($signalStrength);
		$this->setAddress16($address16);
		$this->setAddress64($address64);
		$this->_setCmd($cmd);
		$this->_setStatus($status);
		$this->setFrameId($frameId);
	}
	
	/**
	 * Gets signal strength in dB
	 * 
	 * @return String $signalStrength
	 */
	public function getSignalStrength() {
		return $this -> signalStrength;
	}
	
	/**
	 * Sets signal strength
	 * 
	 * @param String $strength
	 */
	private function _setSignalStrength($strength) {
		$this->signalStrength = $strength;
	}
	
	/**
	 * Gets Node ID aka NI
	 * 
	 * @return String $nodeId
	 */
	public function getNodeId() {
		return $this->nodeId;
	}
	
	/**
	 * Sets Node ID aka NI
	 * 
	 * @param String $nodeId
	 */
	private function _setNodeId($nodeId) {
		$this->nodeId = $nodeId;
	}
	
	/**
	 * Sets status
	 * 
	 * @param int $status
	 */
	private function _setStatus($status) {
		$this->status = $status;
	}
	
	/**
	 * Returns status. If you want boolean use isOk
	 * 
	 * 00 = OK
	 * 01 = Error
	 * 02 = Invalid Command
	 * 03 = Invalid Parameter
	 * 04 = No Response
	 * 
	 * @return int $status 
	 */
	public function getStatus() {
		return $this->status;
	}
	
	/**
	 * Checks if this resonse was positive
	 * 
	 * @return boolean
	 */
	public function isOk() {
		if ($this->getStatus()=='00') {
			return TRUE;
		} else {
			return FALSE;	
		}
	}
	
	/**
	 * Sets the command for this frame
	 * 
	 * @return void
	 * @param String $cmd The Xbee Command 
	 */
	private function _setCmd($cmd) {
		$this->cmd = $cmd;
	}
	
	/**
	 * Returns command. 
	 * 
	 * @return String $cmd
	 */
	public function getCmd() {
		return $this->cmd;
	}
}
?>