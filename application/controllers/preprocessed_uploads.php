<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Preprocessed_uploads extends CI_Controller{
	public $data;
	public $file_dir;

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form'));
		$this->load->library('form_validation');

		$this->data = $this->session->userdata;
		$this->file_dir = $this->data['file_dir']. '/preprocessed';
	}

	public function index(){
		if($this->session->userdata('logged_in')){

			$files = array_filter(scandir($this->file_dir), function($item){
				return !is_dir($this->file_dir.'/' . $item);
			});

			$error = '';
			$user_info = array('files' => $files, 'error' => $error);

			$this->load->view('preprocessed_uploads', $user_info);
		}
	}

	public function display_file(){
		$file = $this->uri->segment(3);
		$file_path = $this->file_dir . "/" . $file;

		echo nl2br(file_get_contents($file_path));
		exit;
	}

	public function submit_files(){
		if($this->input->post('file_action') == "delete"){
			$this->delete_files($this->input->post('checkbox'));
		} else{
			$this->index();
		}
	}

	public function delete_files($files_to_delete){
		if(null != $this->input->post()){
			$file_path = $this->file_dir;
			
			foreach($files_to_delete as $file => $file_name){
				unlink($file_path . '/' . $file_name);
			}

			$this->index();
		}
	}
}

/* End of file preprocessed_uploads.php */
/* Location: ./application/controllers/preprocessed_uploads.php */
