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

			//$files = scandir($this->file_dir);
			//Current and parent directory entries filter
			//$files = array_diff($files, array('.', '..'));
			$files = array_filter(scandir($this->file_dir), function($item){
				return !is_dir($this->file_dir.'/' . $item);
			});

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

		$this->load->view('preprocess', $text_data);
	}

	public function build_command($framework, $post){
		$cmd = '';
		if($framework == 'corenlp'){
			return;
		}
		else if($framework == 'nltk'){
			return;
		}
		else if($framework == 'spacy'){
			if($post['tokenize'] != ''){
				$cmd .= ' tokenize';
			}
			if($post['sent_split'] != ''){
				$cmd .= ' sent_split';
			}
			if($post['pos_tag'] != ''){
				$cmd .= ' pos_tag';
			}
			if($post['lemmatize'] != ''){
				$cmd .= ' lemmatize';
			}
			if($post['ner_tag'] != ''){
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

			$file_path = $this->file_dir . '/'. $post['file_name'];
			//$file_path = '/Users/stc1563/users-uaa/' . $post['file_name'];
			$cmd = '';
			$output = '';

			if($post['tokenize'] == 'corenlp'){
				//TODO: Insert command for running CoreNLP file from cmd line
			}
			else if($post['tokenize'] == 'nltk'){
				//TODO: Insert command for running NLTK file from cmd line
			}
			else if($post['tokenize'] == 'spacy'){
				$cmd = 'python ' . $preprocess_path . 'spacy/spacyNlp.py ' . $this->file_dir;
				$cmd .= $this->build_command('spacy', $post);

				$output = shell_exec($cmd);
				if($output == ''){
					$output = "spacy preprocessing failed";
					//$output = $cmd;
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
		$file_dir = $data['file_dir'];

		$config['upload_path'] = $file_dir;
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

			if($this->upload->do_upload('raw_files')){
				$this->session->set_flashdata('flash_message', 'Upload was successful!');
			} else{
				$error = array('error' => $this->upload->display_errors());
				$this->load->view('raw_uploads', $error);
			}
		}
		redirect('raw_uploads', 'refresh');
	}

	public function submit_files(){
		if($this->input->post('file_action') == "delete"){
			$this->delete_files($this->input->post('checkbox'));
		} else{
			$this->batch_preprocess($this->input->post('checkbox'));
		}
	}

	public function batch_preprocess($files){
		$this->form_validation->set_rules('tokenize', 'Tokenize', 'required');
		if($this->form_validation->run() == FALSE){

			$this->session->set_flashdata('flash_message', 'Need at least Tokenization');
			$this->load->view('raw_uploads');

		} else{
			$post = $this->input->post();

			foreach($files as $file => $file_name){
				$preprocess_path = '/Applications/MAMP/htdocs/website_stuff/assets/preprocess/';
				$cmd = '';
				$output = '';

				$file_path = $this->file_dir . '/' . $file_name;

				if($post['tokenize'] == 'corenlp'){
					//TODO: Insert command for running CoreNLP file from cmd line
				}
				else if($post['tokenize'] == 'nltk'){
					//TODO: Insert command for running NLTK file from cmd line
				}
				else if($post['tokenize'] == 'spacy'){
					$cmd = 'python ' . $preprocess_path . 'spacy/spacyNlp.py ' . $file_path;
					$cmd .= $this->build_command('spacy', $post);

					$output = shell_exec($cmd);
					if($output == ''){
						$output = "spacy preprocessing failed";
					}

					if(!file_put_contents($this->file_dir . '/preprocessed/' . $file_name, $output)){
						$this->session->set_flashdata('flash_message', 'Could not write out file ' . $file_name);
						$this->load->view('raw_uploads');
					}

				}
			}
			$this->session->set_flashdata('flash_message', 'Saved to Preprocessed');
			$this->index();
		}
	}

	public function delete_files($files_to_delete){
		if(null != $this->input->post()){
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
