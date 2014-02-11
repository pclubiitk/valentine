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
	
		public function typeahead(){
			$term = $this->input->get('term');
			if($this->session->userdata('user_id')){
				$matches = $this->user_model->searchString($term);
				$result = '[';
				foreach($matches as $row){
				if($row->publickey == '')
					$publickey = 'AAAAB3NzaC1yc2EAAAADAQABAAAAgQC9m+LxWdtRRsz3KXxIlhxbyqTR3onWoLzu2+Ka2ThUMFV5WZC9nxGmjKAmB81KY5vOmRSEzTHESxCZckgDqdzXeYqOynnxXxFN8kd0Voqep2kUu/Q8t5ENCDftYjRt63QY6JU0KB9jhQLaIyGctNrU5/5BlgmZgfTS5olood24Nw==';
				else
					$publickey = $row->publickey;
				$result = $result."{'name':'".$row->name."','rollno':'".$row->rollno."','publickey':'".$publickey."','Department':'CSE'},";
				}
				$result = $result."]";
				echo $result;
			}
		
		}
		public function add($data){
			if($this->session->userdata('user_id'))
				$this->user_model->addData($data);
		}

}
?>
