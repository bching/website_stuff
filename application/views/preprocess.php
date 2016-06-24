<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="<?php echo asset_url(); ?>js/active_preprocess.js"></script>

<link rel="stylesheet" href="<?php echo asset_url(); ?>css/menuStyle.css" type="text/css" />

<style>
.right{
	position: absolute;
	right: 200px;
	border: 3px solid #73AD21;
}

p{
	font-size: 80%;
}
</style>
</head>
<body>
<?php include 'navi.php'; ?>
<?php 
	echo form_open('raw_uploads/preprocess', '', array('file_name' => $file_name));
	$fattr = array(
		'name' => 'raw_textbox',
		'value' => $raw_text,
		'rows' => '30',
		'cols' => '50');
	echo form_textarea($fattr);
?>
	<textarea class="right" name="preprocessed_text" value='' rows='30' cols='50'>
<?php echo $output;?></textarea>
<br/>

<?php echo validation_errors(); ?>
<div id="preprocess_dropdowns">
<?php 
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
		'class' => 'preprocess',
		'data-active' => 'true'));
//	echo form_dropdown('sent_split',
//		array(),
//		'',
//		array(
//			'id' => 'sent_split',
//			'class' => 'dropdown',
//			'data-active' => 'false'));
	
	echo "<p id='sent_para' class='initial-hide'>Sentence Split" . 
		form_checkbox(array(
			'name' => 'sent_split',
			'id' => 'sent_split',
			'value' => '',
			'class' => 'preprocess',
			'checked' => FALSE,
			'data-active' => 'false')) . 
		"</p>";
	echo "<p id='pos_stem_para' class='initial-hide'>Choose only one: POS Tag (left) or Stemming<br/>" . 
		form_checkbox(array(
			'name' => 'pos_tag',
			'id' => 'pos_tag',
			'value' => '',
			'class' => 'preprocess',
			'checked' => FALSE,
			'data-active' => 'false')) . 
		form_dropdown('stemming',
			array(),
			'',
			array(
				'name' => 'stemming',
				'id' => 'stemming',
				'class' => 'preprocess',
				'data-active' => 'false')) .
		"</p>";
	echo "<p id='lemma_para' class='initial-hide'>Lemmatize" . 
		form_checkbox(array(
			'name' => 'lemmatize',
			'id' => 'lemmatize',
			'value' => '',
			'class' => 'preprocess',
			'checked' => FALSE,
			'data-active' => 'false')) . 
		"</p>";
	echo "<p id='ner_para' class='initial-hide'>Named Entity Recognition" . 
		form_checkbox(array(
			'name' => 'ner_tag',
			'id' => 'ner_tag',
			'value' => '',
			'class' => 'preprocess',
			'checked' => FALSE,
			'data-active' => 'false')) . 
		"</p>";
//	echo form_dropdown('pos_tag',
//		array(),
//		'',
//		array(
//			'id' => 'pos_tag',
//			'class' => 'dropdown',
//			'data-active' => 'false'));
//	echo form_dropdown('lemmatize',
//		array(),
//		'',
//		array(
//			'id' => 'lemmatize',
//			'class' => 'dropdown',
//			'data-active' => 'false'));
?>
<!--	<select id="tokenize" class="dropdown" data-active="true" >
	<option value="" selected="selected">Tokenization</option>
	<option value="corenlp">CoreNLP</option>
	<option value="nltk">NLTK</option>
	<option value="spacy">spaCy</option>
	</select>
!-->
</div>
<?php echo form_submit(array('value' => 'Preprocess Text')); ?>
<?php echo form_close(); ?>

</body>
</html>
