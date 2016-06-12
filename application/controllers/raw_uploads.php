<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Raw_uploads extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form'));
	}

	public function index(){
		if($this->session->userdata('logged_in')){
			//$session_data = $this->session->userdata('logged_in');
			$data = $this->session->userdata;
			//array_push($data, array('error' => ''));

			$file_dir = $data['file_dir'];
			$files = scandir($file_dir);

			/*
			 * I want to encode the file_dir and decode it from the uri read in 
			 * display_file so we don't expose directory structure to user 
			 */
			$file_dir_token = base64_encode($file_dir);
			$file_dir_token = rtrim($file_dir_token, '=');
			$user_info = array('files' => $files, 
				'file_dir_token' => $file_dir_token);
			//
			//$this->load->view('raw_uploads', $data);
			//
			$this->load->view('raw_uploads', $user_info);
			//
		}
	}

	public function display_file(){
		$file_dir_token = $this->uri->segment(3);
		$file = $this->uri->segment(4);
		$file_dir = base64_decode($file_dir_token);
		$file_path = $file_dir ."/". $file;

		$file_handle = fopen($file_path, "r");
		$file_contents = fread($file_handle, filesize($file_path));
		fclose($file_handle);

		$text_data = array('raw_text' => $file_contents);
		$this->load->view('display_raw', $text_data);
		//echo '<textarea name="raw_file"> $file_contents;
	}

	public function preprocess_text(){
	}

	public function do_upload(){
		$config['upload_path'] = '/Users/stc1563/users-uaa/';
	}
}
/* End of file raw_uploads.php */
/* Location: ./application/controllers/raw_uploads.php */
