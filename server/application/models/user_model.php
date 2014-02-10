<?php
class user_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->library('session');
        }
        public function login($username, $password, $publickey){
                $ftp_server="webhome.cc.iitk.ac.in";
                // set up basic connection
                $conn_id = ftp_connect($ftp_server);

                // login with username and password
                $login_result = ftp_login($conn_id, $username, $password);
                ftp_close($conn_id);
                if($login_result){
			$this->db->where('email',$username.'@iitk.ac.in');
			$this->db->update('publickey', $publickey);
                        $query = $this->db->get_where('users',array('email'=>$username.'@iitk.ac.in'));
                        $row = $query->row_array();
			if($row['visitflag'] == 0){
				$this->db->where('email',$username.'@iitk.ac.in');
				$this->db->update('visitflag', 1);
			}
			return $row;
                }
                else{
                        return FALSE;
                }
        }

        public function addData($data){
                $this->db->insert('to', array('rollno'=>$this->session->userdata('user_id'),'data'=>$data));
        }
}

?>










