<?php
class Login extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('user', '', TRUE);
		$this->load->library('form_validation');
	}

	public function index(){
		//$this->session->sess_destroy();
		$this->load->helper(array('form'));
		$this->load->view('login');
	}

	public function verifyLogin(){
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$
			$this->form_validation->set_rules('password', 'Password', 'required');

		if($this->form_validation->run() == FALSE){
			$this->load->view('login');
		}
		else{
			$post = $this->input->post();
			$clean = $this->security->xss_clean($post);

			$user_info = $this->user->checkLogin($clean);

			if(!$user_info){
				$this->session->set_flashdata('flash_message', 'The login was unsuccessful');
				redirect(site_url() . 'login');
			}
			//save each column value for user row id in session
			foreach($user_info as $key => $val){
				$this->session->set_userdata($key, $val);
			}
			redirect(site_url() . 'home');
		}
	}

}
?>
