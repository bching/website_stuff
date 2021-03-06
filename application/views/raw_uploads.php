<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<script type="text/javascript" src="<?php echo asset_url(); ?>js/active_preprocess.js"></script>
	<link rel="stylesheet" href="/website_stuff/assets/css/menuStyle.css" type="text/css" />
	<title>Raw Uploads</title>
</head>
<body>
<?php include 'navi.php'; ?>

<?php 
echo $error;
$message = $this->session->flashdata();
if(!empty($message['flash_message'])){
	$html = '<p id="warning">';
	$html .= $message['flash_message'];
	$html .= '</p>';
	echo $html;
}

echo validation_errors();
?>

<?php echo form_open_multipart('raw_uploads/upload_text'); ?>
<div id="upload_area">
	<div class="upload_form" id="upload_form">
		<input type="file" name="raw_files[]" id="raw_files[]" multiple="multiple"/>
		<input type="submit" value="Upload" name="submit"/>
	</div>
</div>
</form>

<?php 
	echo '<ul>';
	echo '<form id="checkbox_form" name="checkbox_form" method="post" action="raw_uploads/submit_files">';

	foreach($files as $file => $file_name){

		echo form_checkbox(array(
			'name' => 'checkbox[]',
			'id' => 'checkbox[]',
			'value' => $file_name,
			'checked' => FALSE
		));

		$url = site_url() . '/raw_uploads/display_file/' . $file_name;
		echo '<a href="'.$url.'">'.$file_name.'</a><br/>';
	}

	echo '<br/>';

	echo '<button name="file_action" value="batch_preprocess" type="submit">Preprocess</button>';

//	echo form_dropdown('stemming',
//		array(
//			'' => 'Stemming',
//			'porter' => 'Porter',
//			'porter2' => 'Porter2',
//			'lancaster' => 'Lancaster'),
//		'',
//		array(
//			'name' => 'stemming',
//			'id' => 'stemming',
//			'class' => 'stem',
//			'data-active' => 'true'));
	echo form_dropdown('stemming',
		array(
			'' => 'Stemming',
			'porter' => 'Porter',
			'porter2' => 'Porter2',
			'lancaster' => 'Lancaster'),
		'',
		array(
			'name' => 'stemming',
			'id' => 'stemming',
			'class' => 'stem'
			));
//	echo form_dropdown('tokenize',
//		array(
//			'' => 'Tokenize',
//			'corenlp' => 'CoreNLP',
//			'nltk' => 'NLTK',
//			'spacy' => 'spaCy'),
//		'',
//		array(
//			'name' => 'tokenize',
//			'id' => 'tokenize',
//			'class' => 'preprocess',
//			'data-active' => 'true'));
	echo form_dropdown('tokenize',
		array(
			'' => 'Tokenize',
			'corenlp' => 'CoreNLP',
			'nltk' => 'NLTK',
			'spacy' => 'spaCy'),
		'',
		array(
			'name' => 'tokenize',
			'id' => 'tokenize',
			'class' => 'preprocess'
			));
	echo form_dropdown('sent_split',
		array(
			'' => 'Sentence Split'),
		'',
		array(
			'name' => 'sent_split',
			'id' => 'sent_split',
			'class' => 'preprocess',
			'data-active' => 'false'));
	echo form_dropdown('pos_tag',
		array(
			'' => 'POS Tag'),
		'',
		array(
			'name' => 'pos_tag',
			'id' => 'pos_tag',
			'class' => 'preprocess',
			'data-active' => 'false'));
	echo form_dropdown('lemmatize',
		array(
			'' => 'Lemmatize'),
		'',
		array(
			'name' => 'lemmatize',
			'id' => 'lemmatize',
			'class' => 'preprocess',
			'data-active' => 'false'));
	echo form_dropdown('ner_tag',
		array(
			'' => 'NER Tag'),
		'',
		array(
			'name' => 'ner_tag',
			'id' => 'ner_tag',
			'class' => 'preprocess',
			'data-active' => 'false'));

	for($i = 0; $i < 5; $i++){
		echo '<br/>';
	}
	echo '<button name="file_action" value="delete" type="submit">Delete</button>';

	echo '</form>';
	echo '</ul>';
?>
</body>
</html>
