<?php 
	class base extends Controller{
    		public function __construct(){
        		$this->load->library('session');
			parent::__construct();
    		}

    		public function is_logged_in(){
        		$user = $this->session->userdata('loggedIn');
        		return isset($user);
    		}
	}
?>
