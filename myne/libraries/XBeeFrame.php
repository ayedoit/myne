<?php
/**
 * XbeeFrame represents a frame to be sent.
 *
 * @package XBeeFrame
 */
class XBeeFrame extends _XBeeFrameBase {
	public function XBeeFrame() {
		parent::_XBeeFrameBase();
	}

	/**
	 * Represesnts a remote AT Command according to XBee API. 
	 * 64 bit address defaults to eight 00 bytes and $options defaults to 02 immediate
	 * Assembles frame for sending.
	 * 
	 * @param $address16, $cmd, $val, $address64, $options
	 * @return void
	 */
	public function remoteAtCommand($address16, $cmd, $val, $address64 = '0000000000000000', $options = '02') {
		$this -> setApiId(_XBeeFrameBase::REMOTE_API_ID);
		$this -> setAddress16($address16);
		$this -> setAddress64($address64);
		$this -> setOptions($options);
		$this -> setCmd($this -> _strhex($cmd));
		$this -> setValue($val);
		
		$this -> setCmdData(
					$this -> getApiId() . 
					$this -> getFrameId() . 
					$this -> getAddress64() .
					$this ->getAddress16() . 
					$this -> getOptions() .
					$this -> getCmd() .
					$this -> getValue()
					);
		$this -> _assembleFrame();
	}
	
	/**
	 * Represesnts a local AT Command according to XBee API. 
	 *  Takes command and value, value defaults to nothing
	 * 
	 * @param String $cmd, String $val
	 * @return void
	 */
	public function localAtCommand($cmd, $val = '') {
		$this -> setApiId(_XBeeFrameBase::LOCAL_API_ID);
		$this -> setCmd($this ->_strhex($cmd));
		$this -> setCmdData(
						$this -> getApiId() . 
						$this -> getFrameId() .
						$this -> getCmd() .
						$this -> getValue()
						);
		$this -> _assembleFrame();
	}

	/**
	 *  Not Implemented, do not use
	 */
	public function queuedAtCommand() {
		$this -> setApiId(_XBeeFrameBase::QUEUED_API_ID);
		trigger_error('queued_at not implemented', E_USER_ERROR);
	}

	/**
	 *  Not Implemented, do not use
	 */
	public function txCommand() {
		$this -> setApiId(_XBeeFrameBase::TX_API_ID);
		trigger_error('tx not implemented', E_USER_ERROR);
	}

	/**
	 *  Not Implemented, do not use
	 */
	public function txExplicityCommand() {
		$this -> setApiId(_XBeeFrameBase::TX_EXPLICIT_API_ID);
		trigger_error('tx_explicit not implemented', E_USER_ERROR);
	}

}
?>