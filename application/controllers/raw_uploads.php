<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Raw_uploads extends CI_Controller{
	public $data;
	public $file_dir;

	public function __construct(){
		parent::__construct();
		$this->load->helper(array('form'));
		$this->load->library('form_validation');
		
		$this->data = $this->session->userdata;
		$this->file_dir = $this->data['file_dir'];
	}

	public function index(){
		if($this->session->userdata('logged_in')){
			//$session_data = $this->session->userdata('logged_in');
			//$data = $this->session->userdata;
			//array_push($data, array('error' => ''));

			$files = scandir($this->file_dir);
			//Current and parent directory entries filter
			$files = array_diff($files, array('.', '..'));

			/*
			 * I want to encode the file_dir and decode it from the uri read in 
			 * display_file so we don't expose directory structure to user 
			 */
			//$file_dir_token = base64_encode($file_dir);
			//$file_dir_token = rtrim($file_dir_token, '=');
			//$user_info = array('files' => $files, 
			//	'file_dir_token' => $file_dir_token);

			$error = '';
			$user_info = array('files' => $files, 'error' => $error);

			$this->load->view('raw_uploads', $user_info);
		}
	}

	public function display_file(){
		$file = $this->uri->segment(3);
		$file_path = $this->file_dir ."/". $file;

		$file_handle = fopen($file_path, "r");
		$file_contents = fread($file_handle, filesize($file_path));
		fclose($file_handle);

		$text_data = array('raw_text' => $file_contents,
			'output' => '',
			'file_name' => $file);

		//Pass token containing path to file once more for processing
		//$url = site_url() . '/raw_uploads/preprocess/' . $file_dir_token;
		//$method_token = 'preprocess/' . $file_dir_token;
		$this->load->view('preprocess', $text_data);
	}

	//TODO: The file needs to be passed in as an argument for the spacyNlp.py file to read as a sysarg
	public function build_command($framework, $post){
		$cmd = '';
		if($framework == 'corenlp'){
			return;
		}
		else if($framework == 'nltk'){
			return;
		}
		else if($framework == 'spacy'){
			if(isset($post['tokenize']) == true){
				$cmd .= ' tokenize';
			}
			if(isset($post['sent_split']) == true){
				$cmd .= ' sent_split';
			}
			if(isset($post['pos_tag']) == true){
				$cmd .= ' pos_tag';
			}
			if(isset($post['lemmatize']) == true){
				$cmd .= ' lemmatize';
			}
			if(isset($post['ner_tag']) == true){
				$cmd .= ' ner_tag';
			}
			return $cmd;
		}
	}

	/*
	 * The string command executed by shell_exec() is of the form 
	 * "<framework> <script> <file_path> <space delimited preprocessing commands>
	 */
	public function preprocess(){
		//Always need to tokenize for any framework
		$this->form_validation->set_rules('tokenize', 'Tokenize', 'required');
		//This path can differ depending on the local environment
		$path_to_preprocess = '/Applications/MAMP/htdocs/website_stuff/assets/preprocess/';

		if($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('flash_message', 'Validation error');
			$this->load->view('preprocess');
		} else {
			$post = $this->input->post();

			$file_path = $this->file_dir .'/'. $post['file_name'];
			$cmd = '';
			$output = '';

			if($post['tokenize'] == 'corenlp'){
				//TODO: Insert command for running CoreNLP file from cmd line
			}
			else if($post['tokenize'] == 'nltk'){
				//TODO: Insert command for running NLTK file from cmd line
			}
			else if($post['tokenize'] == 'spacy'){
				$cmd = 'python ' . $path_to_preprocess . 'spacy/spacyNlp.py ' . $file_path;
				//TODO: Before attaching commandline arguments need to append local file location
				$cmd .= $this->build_command('spacy', $post);

				$output = shell_exec($cmd);
				if($output == ''){
					$output = "spacy preprocessing failed";
				}

				$data = array('output' => $output, 'raw_text' => $post['raw_textbox'], 'file_name' => $post['file_name']);
				$this->load->view('preprocess', $data);
				
			}
		}
	}

	//Load userdata to provide email in upload_path
	//Set $config parameters to restrict possible file uploads
	//Iterate over all uploaded files posted from $_FILES
	public function upload_text(){
		$data = $this->session->userdata;
		$email = $data['email'];

		//Change upload path specific to local environment
		$config['upload_path'] = '/Users/jessgrunblatt/users-uaa/' . $email;
		$config['allowed_types'] = 'txt';
		$config['max_size'] = '1000000';

		$files = $_FILES;
		$file_count = count($_FILES['raw_files']['name']);

		$this->load->library('upload');
		$this->upload->initialize($config);

		for($i = 0; $i < $file_count; $i++){
			$_FILES['raw_files']['name'] = $files['raw_files']['name'][$i];
			$_FILES['raw_files']['type'] = $files['raw_files']['type'][$i];
			$_FILES['raw_files']['tmp_name'] = $files['raw_files']['tmp_name'][$i];
			$_FILES['raw_files']['size'] = $files['raw_files']['size'][$i];
			$_FILES['raw_files']['error'] = $files['raw_files']['error'][$i];

			$this->upload->do_upload('raw_files');
		}
		redirect('raw_uploads', 'refresh');
		//	if($this->upload->do_upload('raw_files')){
		//		$this->session->set_flashdata('flash_message', 'Upload was successful!');
		//		redirect('raw_uploads', 'refresh');
		//	} else {
		//		$error = array('error' => $this->upload->display_errors());
		//		$this->load->view('raw_uploads', $error);
		//	}
	}


	public function submit_files(){
		if($this->input->post('file_action') == "delete"){
			$this->delete_files($this->input->post('checkbox'));
		} else{
			$this->batch_preprocess($this->input->post('checkbox'));
		}
	}

	public function batch_preprocess($files_to_process){
	}

	public function delete_files($files_to_delete){
		if(null != $this->input->post()){

			//$files_to_delete = $this->input->post('checkbox');
			$file_path = $this->file_dir;
			
			foreach($files_to_delete as $file => $file_name){
				unlink($file_path . '/' . $file_name);
			}

			redirect('raw_uploads', 'refresh');
		}
	}

}
/* End of file raw_uploads.php */
/* Location: ./application/controllers/raw_uploads.php */
