<?php
/**
 * XbeeFrameBase represents common functions for all types of frames
 * 
 * @package XBeeFrameBase
 * @subpackage XBeeFrame
 * @subpackage XBeeResponse
 */
abstract class _XBeeFrameBase {
	const DEFAULT_START_BYTE = '7E', DEFAULT_FRAME_ID = '01', 
		REMOTE_API_ID = '17', LOCAL_API_ID = '08',
		QUEUED_API_ID = '09', TX_API_ID = '10', TX_EXPLICIT_API_ID = '11';
		
	protected $frame, $frameId, $apiId, $cmdData, $startByte, $address16, $address64, $options, $cmd, $val;
	
	/**
	 * Contructor for abstract class XbeeFrameBase.
	 *
	 */
	protected function _XBeeFrameBase() {
		$this -> setStartByte(_XBeeFrameBase::DEFAULT_START_BYTE);
		$this -> setFrameId(_XBeeFrameBase::DEFAULT_FRAME_ID);
	}
	
	/**
	 * Assembles frame after all values are set
	 *
	 * @return void
	 */
	protected function _assembleFrame() {
		$this -> setFrame(
					$this -> getStartByte() . 
					$this -> _getFramelength($this -> getCmdData()) . 
					$this -> getCmdData() . 
					$this -> _calcChecksum($this -> getCmdData())
					);
		//echo 'Assembled: ';print_r($this -> _unpackBytes($this -> getFrame()));	//debug
	}
	
	/**
	 * Calculates checksum for cmdData. Leave off start byte, length and checksum
	 * 
	 * @param String $data Should be a binary string
	 * @return String $checksum Should be a binary string
	 */
	protected function _calcChecksum($data) {
		$checksum = 0;
		for ($i = 0; $i < strlen($data); $i++) {
			$checksum += ord($data[$i]);
		}
		$checksum = $checksum & 0xFF;
		$checksum = 0xFF - $checksum;
		$checksum = chr($checksum);
		return $checksum;
	}
	
	/**
	 * Calculates lenth for cmdData. Leave off start byte, length and checksum
	 * 
	 * @param String $data Should be a binary string
	 * @return String $length Should be a binary string
	 */
	protected function _getFramelength($data) {
		$length = strlen($data);
		$length = sprintf("%04x", $length);
		$length = $this -> _packBytes($length);
		return $length;
	}
	
	/**
	 * Transforms hex into a string
	 * 
	 * @param String $hex
	 * @return String $string Should be a binary string
	 */
	protected function _hexstr($hex) {
		$string = '';
		for ($i=0; $i < strlen($hex); $i+=2) {
			$string .= chr(hexdec($hex[$i] . $hex[$i+1]));
		}
		return $string;
	}
	
	/**
	 * Transforms string into hex
	 * 
	 * @param String $str Should be a binary string
	 * @return String $hex Sould be a hex string
	 */
	protected function _strhex($str) {
		$hex = '';
	    for ($i=0; $i < strlen($str); $i+=2) {
	        $hex .= dechex(ord($str[$i])) . dechex(ord($str[$i+1]));
	    }
	    return $hex;
	}
	
	/**
	 * Packs a string into binary for sending
	 * 
	 * @param String $data
	 * @return String $data Should be a binary string
	 */
	protected function _packBytes($data) {
		return pack('H*', $data);
	}

	/**
	 * Unpacks bytes into an array
	 * 
	 * @param String $data Should be a binary string
	 * @return Array $data
	 */
	protected function _unpackBytes($data) {
		return unpack('H*', $data);
	}
	
	/**
	 * Sets raw frame, including start byte etc
	 * 
	 * @param String $frame
	 * @return void
	 */
	public function setFrame($frame) {
		$this -> frame = $frame;
	}
	
	/**
	 * Gets raw frame data
	 * 
	 * @return String $FrameData
	 */
	public function getFrame() {
		return $this -> frame;
	}

	/**
	 * Sets FrameId according to XBee API
	 * 
	 * @param String $frameId
	 * @return void
	 */
	public function setFrameId($frameId) {
		$this -> frameId = $frameId;
	}

	/**
	 * Gets frame ID according to XBee API
	 * 
	 * @return String $frameId
	 */
	public function getFrameId() {
		return $this -> frameId;
	}

	/**
	 * Sets ApiId according to XBee API
	 * 
	 * @param String $apiId
	 */
	public function setApiId($apiId) {
		$this -> apiId = $apiId;
	}
	
	/**
	 * Gets API ID
	 * 
	 * @return String $apiId
	 */
	public function getApiId() {
		return $this -> apiId;
	}

	/**
	 * Sets raw command data, without start byte etc
	 * 
	 * @param String $cmdData
	 * @return void
	 */
	public function setCmdData($cmdData) {
		$this -> cmdData = $this -> _packBytes($cmdData);
	}

	/**
	 * Gets raw command data, without start byte etc
	 * 
	 * @return String $cmdData
	 */
	public function getCmdData() {
		return $this -> cmdData;
	}

	/**
	 * Sets Start Byte according to XBee API, defaults to 7E
	 * 
	 * @param String $startByte
	 */
	public function setStartByte($startByte) {
		$this -> startByte = $this -> _packBytes($startByte);
	}
	 
	 /**
	 * Gets Start Byte according to XBee API, default is 7E
	  * 
	 * @return String $startByte
	 */
	public function getStartByte() {
		return $this -> startByte;
	}
	
	/**
	 * Sets the 16 bit address
	 * 
	 * @param String $address16
	 */
	public function setAddress16($address16) {
		$this->address16 = $address16;
	}
	
	/**
	 * Gets the 16 bit address
	 * 
	 * @return String $address16
	 */
	public function getAddress16() {
		return $this->address16;
	}
	
	/**
	 * Sets the 64 bit address
	 * 
	 * @param String $address64
	 */
	public function setAddress64($address64) {
		$this->address64 = $address64;
	}
	
	/**
	 * Gets the 64 bit address
	 * 
	 * @param String $address64
	 */
	public function getAddress64() {
		return $this->address64;
	}
	
	/**
	 * Sets the options of the frame
	 * 
	 * @param String $options
	 */
	public function setOptions($options) {
		$this->options = $options;
	}
	
	/**
	 * Gets the options of the frame
	 * 
	 * @return String $options
	 */
	public function getOptions() {
		return $this->options;
	}
	
	/**
	 * Sets the command
	 * 
	 * @param String $cmd
	 */
	public function setCmd($cmd) {
		$this -> cmd = $cmd;		
	}
	
	/**
	 * Gets the command
	 * 
	 * @return String $cmd
	 */
	public function getCmd() {
		return $this -> cmd;
	}
	
	/**
	 * Sets the value of a packet
	 * 
	 * @param String $val
	 */
	public function setValue($val) {
		$this -> val = $val;
	}
	
	/**
	 * Gets value of value
	 * 
	 * @return String $val
	 */
	public function getValue() {
		return $this -> val;
	}
}
?>