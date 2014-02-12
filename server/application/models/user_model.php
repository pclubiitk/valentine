<?php
class user_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
                $this->load->library('session');
        }
        public function login($username, $password, $publickey){
                $ftp_server="webhome.cc.iitk.ac.in";
                //set up basic connection
                $conn_id = ftp_connect($ftp_server);

                // login with username and password
                $login_result = ftp_login($conn_id, $username, $password);
                ftp_close($conn_id);
                if($login_result){
			$query = $this->db->where('email',$username.'@iitk.ac.in')->get('users');
                        $row = $query->row_array();
			$this->db->set('publickey', $publickey);
                        $this->db->where('email',$username.'@iitk.ac.in');
                        $this->db->update('users');
                        return $row;
			}
                else{
                        return FALSE;
                }
        }
	
	public function searchString($term){
                $oppositeGender = $this->session->userdata['gender'] == 'F' ? 'M' : 'F';
                $this->db->where('gender', $oppositeGender);
		$this->db->like('name',$term,'both');
		$query = $this->db->get('users', 20);
		return $query->result();
	}
        public function addfrom($rollno, $data){
                $this->db->insert('from', array('rollno'=>$rollno,'data'=>$data));
        }

        public function details($rollno){
                $res = $this->db->where('rollno', $rollno)->get('users');
                return $res->result();
        }
        public function getCrushes($rollno){
                $res = $this->db->where('rollno', $rollno)->get('from');
                return $res->result();
        }
        public function addto($rollno, $data){
                if($data[1] != null)
                        $this->db->insert('to', array('rollno' => $rollno[1], 'data' => $data[1]));
                if($data[2] != null)
                        $this->db->insert('to', array('rollno' => $rollno[2], 'data' => $data[2]));
                if($data[3] != null)
                        $this->db->insert('to', array('rollno' => $rollno[3], 'data' => $data[3]));
                if($data[4] != null)
                        $this->db->insert('to', array('rollno' => $rollno[4], 'data' => $data[4]));
        }

        public function checkfrom($rollno){
                $result = $this->db->where('rollno', $rollno)->get('from')->result();
                if(sizeof($result) == 0)
                        return TRUE;
                else
                        return FALSE;
        }

        public function getCount($rollno){
                $this->db->where('rollno', $rollno);
                $this->db->from('to');
                return $this->db->count_all_results();
        }


}

?>










