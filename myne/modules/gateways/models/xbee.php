<?php
/**
 * XBee represents an XBee connection
 * 
 * Be sure to configure the serial connection first.
 * If on linux run these commands at the shell first:
 * 
 * Add apache user to dialout group:
 * sudo adduser www-data dialout
 * 
 * Restart Apache:
 * sudo /etc/init.d/apache2 restart
 * 
 * THIS PROGRAM COMES WITH ABSOLUTELY NO WARANTIES !
 * USE IT AT YOUR OWN RISKS !
 * @author Chris Barnes
 * @thanks Rémy Sanchez, Aurélien Derouineau and Alec Avedisyan for the original serial class
 * @copyright GPL 2 licence
 * @package phpXBee
 */
Class XBee extends CI_Model {
	/**
	 * Constructor. Parent is phpSerial
	 *
	 * @return Xbee
	 */
	function XBee() {
		parent::phpSerial();
	}

	/**
	 * Sets up typical Connection 9600 8-N-1
	 * 
	 * @param String $device is the path to the xbee, defaults to /dev/ttyUSB0
	 * @return void
	 */
	public function confDefaults($device = '/dev/ttyUSB0') {
		$this -> deviceSet($device);
		$this -> confBaudRate(9600);
		$this -> confParity('none');
		$this -> confCharacterLength(8);
		$this -> confStopBits(1);
		$this -> confFlowControl('none');
	}
	
	/**
	 * Opens this XBee connection. 
	 * 
	 * Note that you can send raw serial with sendMessage from phpSerial
	 * @return void
          * @param $waitForOpened int amount to sleep after openeing in seconds. Defaults to 0.1
	 */
	public function open($waitForOpened=0.1) {
		$this -> deviceOpen();
                  usleep((int) ($waitForOpened * 1000000));
	}

	/**
	 * Closes this XBee connection
	 * @return void
	 */
	public function close() {
		$this -> deviceClose();
	}
	
	/**
	 * Sends an XBee frame. $waitForReply is how long to wait on recieving
	 * 
	 * @param XBeeFrame $frame
	 * @param int $waitForRply
	 * @return void
	 */
	public function send($frame , $waitForReply=0.1) {
		$this -> sendMessage($frame -> getFrame(), $waitForReply);		
		//echo 'Sent: ';print_r(unpack('H*', $frame -> getFrame()));	//debug
	}

	/**
	 * Reads the XBee until no new data is availible, then returns the content.
	 * Note that the return is an array of XBeeResponses
	 *
	 * @param int $count number of characters to be read (will stop before
	 * 	if less characters are in the buffer)
	 * @return Array $XBeeResponse
	 */
	public function recieve($count = 0) {
		$rawResponse = $this -> readPort($count);
		$rawResponse = unpack('H*', $rawResponse);
		$response = explode('7e', $rawResponse[1]);
		//echo ' responseArr:';print_r($response);	//debug

		for ($i=1; $i < count($response); $i++) { 
			$response[$i] = new XBeeResponse($response[$i]);
		}
		return $response;
	}
}
?>
