<?php

class User extends CI_Model{
	public $status;
	public $roles;
	
	public function __construct(){
		parent::__construct();
		$this->status = $this->config->item('status');
		$this->roles = $this->config->item('roles');
	}

	public function insertUser($dbIn){
		$string = array(
			'firstName' => $dbIn['firstName'],
			'lastName' => $dbIn['lastName'],
			'email' => $dbIn['email'],
			'role' => $this->roles[0],
			'status' => $this->status[0]
		);
		$userIn= $this->db->insert_string('users', $string);
		$this->db->query($userIn);
		return $this->db->insert_id();
	}

	public function isDuplicate($email){
		$this->db->get_where('users', array('email' => $email), 1);
		return $this->db->affected_rows() > 0 ? TRUE : FALSE;
	}

	public function insertToken($userId){
		//$token is just for validating a user
		//$date is used to fill in created column of 'tokens'
		//to perform a dateDiff to see validated in appropriate time frame
		$token = substr(sha1(rand()), 0, 30);
		$date = date('Y-m-d');

		$string = array(
			'token' => $token,
			'userId' => $userId,
			'created' => $date
		);
		$query = $this->db->insert_string('tokens', $string); 
		$this->db->query($query);
		return $token;
	}

	public function login($username, $password){
		$this->db->select('email, username, hash_pass');
		$this->db->from('Users');
		//TODO: SELECT directory path table for user here 
		$this->db->where('username', $username);
		$this->db->where('hash_pass', $password);
		$this->db->limit(1);

		$query = $this->db->get();

		if($query->num_rows() == 1) {
			return $query->result();
		}
		else{
			return false;
		}
	}
	
	

}	
?>
