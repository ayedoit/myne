<?php
Class User extends CI_Model
{
 public function login($username, $password)
 {
	
	log_message('debug', 'Logging in user "'.$username.'" with password "'.$password.'"'); 
	
   $this -> db -> select('id, username, password');
   $this -> db -> from('users');
   $this -> db -> where('username', $username);
   $this -> db -> where('password', MD5($password));
   $this -> db -> limit(1);

   $query = $this -> db -> get();

   if($query -> num_rows() == 1)
   {
     return $query->result();
   }
   else
   {
     return false;
   }
 }
 
 public function is_logged_in(){
	return (bool)$this->session->userdata('logged_in');
 }
}


?>
