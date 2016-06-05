<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('user', '', TRUE);
		$this->load->library('form_validation');
	}

	public function index(){
		$this->load->helper(array('form'));
		$this->load->view('register');
		$this->form_validation->set_rules('firstName', 'Firstname', 'required');
		$this->form_validation->set_rules('lastName', 'Lastname', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
	}

	public function registerUser(){

		if($this->form_validation == FALSE){
			$this->load->view('register');
		}
		//FOrm is filled out properly
		else{
			if($this->user->isDuplicate($this->input->post('email'))){
				$this->session->set_flashdata('flash_message', 'User email already exists');
				redirect(site_url().'/register');
			}
			else{
				//Insert user into tempUser table
				//Returns all post items with xss filter
				$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
				$id = $this->user->insertUser($clean);
				$token = $this->user->insertToken($id);

				$qstring = base64_encode($token);
				$url = site_url() . 'complete/token/' . $qstring;
				$link = '<a href="' . $url . '">' . $url . '</a>';

				$message = '';
				$message .= '<strong>Click the link below to finish registration</strong><br/>';
				$message .= $link;

				echo $message; //send in email function
				exit;
			}
		}
	}


}
