<?php 
	class app extends CI_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->library('session');
			$this->load->model('user_model');
		}

		public function login(){
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			$publickey = $this->input->post('publickey');
			$user = $this->user_model->login($username, $password, $publickey);
			if(!$user){
				echo 'unauthorised';
				header('Location: http://pclub.in/valentine/index.html#error');
			}
			else{
				$this->session->set_userdata('user_id', $user['rollno']);
				header('Location: http://pclub.in/valentine/home.html');
				echo 'loggedIn';
			}
		}
	
		public function typeahead($string){
			if( isset($this->session->userdata('user_id')))
				$matches = $this->user_model->searchString($string);
		}
		public function add($data){
			if(isset($this->session->userdata('user_id')))
				$this->user_model->addData($data);
		}

}
?>
