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

    public function update($name){
		$this->load->model('room');
		try {
			$this->gateway->updateRoom($name,$_POST['pk'],$_POST['value']);
			return true;
		} catch (Exception $e) {
			show_error($e->getMessage(), 500);
		}
	}
    
    public function show($room){
		// Get room
		$this->load->model('room');
		$room = $this->room->getRoomByName($room);
		
		if (empty($room) || sizeof($room) == 0) {
			show_404();
			die;
		}

		$this->load->library('page');
		$html = $this->load->view('title',array('title' => $room->clear_name),true);
		$html .= $this->load->view('room',array('room' => $room),true);
		$this->page->show($html);
	}
	
	public function add($status) {
		if (empty($status) || trim($status) == '') {
			log_message('debug', '[Rooms/Add]: No status given (should be "new" for new rooms or "validate" for validation)');
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
					log_message('debug', '[Rooms/Add]: Validation requested but no data submitted');
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
	
	public function delete($name,$status) {
		$this->load->model('room');
		$room = $this->room->getRoomByName($name);
		
		if (empty($status) || trim($status) == '') {
			redirect(base_url('rooms/show/'.$room->name), 'refresh');
			log_message('debug', '[Rooms/Delete]: No status given (should be "confirm" or "execute" after successful confirmation)');
		}
		else {
			if ($status == 'confirm') {
				$this->load->library('page');
				$html = $this->load->view('title',array('title' => $room->clear_name),true);
				$html .= $this->load->view('confirm_room_delete',array('room' => $room),true);
				$html .= $this->load->view('room_delete', array('room' => $room),true);
				$this->page->show($html);
			}
			elseif($status == 'execute') {
				 $referer = $this->agent->referrer();
				 if ($referer == base_url('rooms/delete/'.$name.'/confirm')) {
					 $this->room->deleteRoom($room);
					 redirect(base_url('rooms/'), 'refresh');
				 }
			}
			else {
				redirect(base_url('rooms/'), 'refresh');
				log_message('debug', '[Rooms/Delete]: Wrong status given (should be "confirm" or "execute" after successful confirmation)');
			}
		}

	}
	
	public function view($view) {
		$this->load->view($view,"");
	}
}
