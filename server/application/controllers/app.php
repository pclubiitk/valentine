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
				$this->session->set_userdata('gender', $user['gender']);
				header('Location: http://pclub.in/valentine/home.html');
				//echo $user;
			}
		}
			
		public function typeahead(){
			$term = $this->input->get('term');
			if($this->session->userdata('user_id')){
				$matches = $this->user_model->searchString($term);
				for($row=0; $row<sizeof($matches); $row++){
					if($matches[$row]->publickey == '')
						$matches[$row]->publickey = 'AAAAB3NzaC1yc2EAAAADAQABAAAAgQC9mdefault+LxWdtRRsz3KXxIlhxbyqTR3onWoLzu2+Ka2ThUMFV5WZC9nxGmjKAmB81KY5vOmRSEzTHESxCZckgDqdzXeYqOynnxXxFN8kd0Voqep2kUu/Q8t5ENCDftYjRt63QY6JU0KB9jhQLaIyGctNrU5/5BlgmZgfTS5olood24Nw==';
				}
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode($matches);
			}		
		}

		public function crushes(){
			if($this->session->userdata('user_id')){
				$rollno = $this->session->userdata('user_id');
				$list = $this->user_model->getCrushes($rollno);
				$this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode($list);
			}
		}
		public function details(){
				$rollno = $this->input->get('rollno');
                $res = $this->user_model->details($rollno);
                if($res[0]->publickey == '')
					$res[0]->publickey = 'AAAAB3NzaC1yc2EAAAADAQABAAAAgQC9mdefault+LxWdtRRsz3KXxIlhxbyqTR3onWoLzu2+Ka2ThUMFV5WZC9nxGmjKAmB81KY5vOmRSEzTHESxCZckgDqdzXeYqOynnxXxFN8kd0Voqep2kUu/Q8t5ENCDftYjRt63QY6JU0KB9jhQLaIyGctNrU5/5BlgmZgfTS5olood24Nw==';
                $this->output->set_header('Content-Type: application/json; charset=utf-8');
				echo json_encode($res);

        }
        public function mydetails(){
        	if($this->session->userdata('user_id')){
        		$rollno = $this->session->userdata('user_id');
        		$res = $this->user_model->details($rollno);
        		$this->output->set_header('Content-Type: application/json; charset=utf-8');
					echo json_encode($res);
        	}
        }
        public function logout(){
        	$this->session->sess_destroy();
        	header('Location: http://pclub.in/valentine/index.html');
        }
		public function addto(){
			$rollno[1] = $this->input->post('rollno1');
			$rollno[2] = $this->input->post('rollno2');
			$rollno[3] = $this->input->post('rollno3');
			$rollno[4] = $this->input->post('rollno4');
			$data[1] = $this->input->post('data1');
			$data[2] = $this->input->post('data2');
			$data[3] = $this->input->post('data3');
			$data[4] = $this->input->post('data4');
			if($this->session->userdata('user_id')){
				if($this->user_model->checkfrom($this->session->userdata('user_id')))
					$this->user_model->addto($rollno, $data);
			}
		}
		public function addfrom(){
			if($this->session->userdata('user_id')){
				$rollno = $this->session->userdata('user_id');
				if($this->user_model->checkfrom($rollno)){
					$data = $this->input->post('data');
					$this->user_model->addfrom($rollno, $data);
				}
			}
		}

		public function count(){
			if($this->session->userdata('user_id')){
				$res = $this->user_model->getCount($this->session->userdata('user_id'));
				echo $res;
			}
		}

		public function loggedin(){
			if($this->session->userdata('user_id'))
				echo "TRUE";
			else
				echo "FALSE";
		}

}
?>
