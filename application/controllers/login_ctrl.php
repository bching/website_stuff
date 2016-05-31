<?php
class Login_Ctrl extends CI_Controller{

	public function __contruct(){
		parent::__contruct();
	}

	public function index(){
		$this->load->helper(array('form'));
		$this->load->view('login_view');
	}

}
?>
