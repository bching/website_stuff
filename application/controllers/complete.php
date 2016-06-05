<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Complete extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->model('user', '', TRUE);
		$this->load->library('form_validation');
	}

	public function index(){
		$this->load->helper(array('form'));
		$this->load->view('complete');
	}

	public function completeReg(){
		//uri->segment() returns the vector value contained in the url at position indicated
		//this can differ depending on if showing index.php in url or not
		$token = base64_decode($this->uri->segment(5));
		$cleanToken = $this->security->xss_clean($token);

		//return false or user value array from corresponding token value
		$user_info = $this->user->isTokenValid($cleanToken);

		$if(!$user_info){
			$this->session->set_flashdata('flash_message', 'Token is invalid or expired');
			redirect(site_url());
		}
		$data = array(
			'firstName' => $user_info->firstName,
			'email' => $user_info->email,
			'user_id' => $user_info->user_id,
			'token' => base64_encode($token)
		);

		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');

		if($this->form_validation->run() == FALSE){
			$this->load->view('complete', $data);
		}
		else{
			$post = $this->input->post(NULL, TRUE);

			$cleanPost = $this->security->xss_clean($post);

			$hashed = password_hash($cleanPost['password']);
			$cleanPost['password'] = $hashed;
			unset($cleanPost['passconf']);
			$userInfo = $this->user->updateUserInfo($cleanPost);
			if(!$userInfo){
				$this->session->set_flashdata('flash_message', 'There was a problem updating your user info');
				redirect(site_url() . 'login');
			}

			unset($userInfo->password);

			foreach($userInfo as $key=>$val){
				$this->session->set_userdata($key, $val);
			}
			
		}
	}

}
