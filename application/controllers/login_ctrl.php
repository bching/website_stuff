<?php
class Login_ctrl extends CI_Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->load->helper(array('form'));
		$this->load->view('login_view');
	}

}
?>
