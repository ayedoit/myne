<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Application Controller Class
 *
 * This class object is the super class that every library in
 * CodeIgniter will be assigned to.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/general/controllers.html
 */
class MY_Controller extends CI_Controller {

	private static $instance;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		// Check if "myne" has already been installed
		// myne is considered installed when a) table "myne_data" exists
		if (!$this->db->table_exists('myne_data')) {
			// If not installed, redirect to installer
			redirect(base_url('installer'), 'refresh');
		}
		else {
			// If installed, second install condition kicks in: b) is data-key "installed" true?
			echo $this->tools->getMyneData('installed'); die;
			if ($this->tools->getMyneData('installed') != 'true') {
				// if not true, redirect to installer
				// Maybe someone wants a clean re-start and set the key to "false"
				redirect(base_url('installer'), 'refresh');
			}
			else {
				// if "myne" is correctly installed, check other settings

				// A. Check Login
		        if($this->tools->getSettingByName('login') == 'true') {
					$this->load->model('user');
					if(!$this->user->is_logged_in()) redirect('login', 'refresh');
				}
			}
		}
	}
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */