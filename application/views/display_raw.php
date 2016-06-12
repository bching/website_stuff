<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" href="/website_stuff/assets/css/menuStyle.css" type="text/css" />
	<!-- <title></title> --!>
</head>
<body>
<?php include 'navi.php'; ?>
<?php 
	echo form_open('raw_uploads/preprocess_text');
	$fattr = array(
		'name' => 'raw_textbox',
		'value' => $raw_text,
		'rows' => '30',
		'cols' => '50');
	echo form_textarea($fattr);
?>
<br/>
<?php
	$default = set_value('default');
	echo form_dropdown('tokenize',
		array(
		'value' => 'Tokenization',
		'corenlp' => 'CoreNLP',
		'nltk' => 'NLTK',
		'spacy' => 'spaCy',));
	echo form_dropdown('sent_split',
		array(
		'value' => 'Sentence Split',
		'corenlp' => 'CoreNLP',
		'nltk' => 'NLTK',
		'spacy' => 'spaCy',));
	echo form_dropdown('stemming',
		array(
		'value' => 'Word Stem',
		'corenlp' => 'CoreNLP',
		'nltk' => 'NLTK',
		'spacy' => 'spaCy',));
?>
<?php echo form_submit(array('value' => 'Preprocess Text')); ?>
<?php echo form_close(); ?>
</body>
</html>
