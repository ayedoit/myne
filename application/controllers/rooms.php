<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start(); //we need to call PHP's session object to access it through CI
class Rooms extends CI_Controller {
	function __construct(){
        parent::__construct();
        
        // Check Login
        if($this->tools->getSettingByName('login') == 'true') {
			$this->load->model('user');
			if(!$this->user->is_logged_in()) redirect('login', 'refresh');
		}
    }
    
	public function index() {  
	    $this->load->library('page');
	    $html = $this->load->view('rooms',"",true);
	    $this->page->show($html);
    }
    
    public function show($room){
		// Get room
		$this->load->model('room');
		$room = $this->room->getRoomByName($room);
			    
		$this->load->library('page');
		$html = $this->load->view('title',array('title' => $room->clear_name),true);
		$html .= $this->load->view('room',array('room' => $room),true);
		$this->page->show($html);
	}
	
	public function add($status) {
		if (empty($status) || trim($status) == '') {
			redirect(base_url('rooms/add/new'), 'refresh');
		}
		else {
			if ($status == 'validate') {
				$this->load->model('room');
				if (isset($_POST['form']) && $_POST['form']=='1') {
					// Take form input and validate
					$room_data = array(
						'name' => $_POST['rooms_name'],
						'clear_name' => $_POST['rooms_clear_name'],
						'description' => $_POST['rooms_description']
					);
					
					// Insert!
					$task_id = $this->room->addRoom($room_data);
					
					// Done!
					redirect(base_url('rooms/show/'.$room_data['name']), 'refresh');
				}
				else {
					redirect(base_url('rooms/add/new'), 'refresh');
				}
			}
			elseif ($status == 'new') {
				$this->load->library('page');
				$html = $this->load->view('title',array('title' => "Neuen Raum anlegen"),true);
				$html .= $this->load->view('room_add', array('status' => $status),true);
				$this->page->show($html);
			}
		}
	}
	
	public function view($view) {
		$this->load->view($view,"");
	}
}
