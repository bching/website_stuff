<?php

class User_Model extends CI_Model{

	function login($username, $password){
		$this->db->select('email, username, hash_pass');
		$this->db->select->from('Users');
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
