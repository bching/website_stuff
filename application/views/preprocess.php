<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event){
	console.log("DOM fully loaded and parsed");

	var active_dropdowns = document.getElementsByClassName("dropdown");

	for(var i = 0; i < active_dropdowns.length; i++){
		active_dropdowns[i].addEventListener("change", checkDropdowns, false);
	}
});

//var active_dropdowns = document.querySelectorAll('[data-active="true"]');

function checkDropdowns(){
	var sent_dropdown = document.getElementById('sent_split');
	var pos_dropdown = document.getElementById('pos_tag');

	switch(this.id){

	case 'tokenize':
		if(sent_dropdown.dataset.active == "false" && this.value != ''){
			var values = ['', 'corenlp', 'nltk', 'spacy'];
			var options = ['Sentence Split', 'CoreNLP', 'NLTK', 'spaCy'];

			for(var i = 0; i < options.length; i++){
				var option = options[i];
				var value = values[i];
				var el = document.createElement("option");
				el.textContent = option;
				el.value = value;
				sent_dropdown.appendChild(el);
			}
			sent_dropdown.dataset.active = "true";
			break;
		} else {
			sent_dropdown.dataset.active = "false";
			sent_dropdown.innerHTML = "";
			break;
		}

		case 'sent_split':
			if(pos_dropdown.dataset.active == "false" && 
				sent_dropdown.dataset.active == "true" && 
				this.value != ''){
				var values = ['', 'corenlp', 'nltk', 'spacy'];
				var options = ['POS Tag', 'CoreNLP', 'NLTK', 'spaCy'];

				for(var i = 0; i < options.length; i++){
					var option = options[i];
					var value = values[i];
					var el = document.createElement("option");
					el.textContent = option;
					el.value = value;
					pos_dropdown.appendChild(el);
				}
				pos_dropdown.dataset.active = "true";
				break;
			} else {
				pos_dropdown.dataset.active = "false";
				pos_dropdown.innerHTML = "";
				break;
			}

		case 'pos_tag':
			var pos_dropdown = document.getElementById('pos_tag');
			break;
	}
}
</script>

	<link rel="stylesheet" href="/website_stuff/assets/css/menuStyle.css" type="text/css" />
	<!--<style type="text/javascript" src="<?php echo asset_url() ?>js/preprocess_dropdowns.js"></script>; !-->
<style>
.right{
	position: absolute;
	right: 200px;
	border: 3px solid #73AD21;
}
</style>
</head>
<body>
<?php include 'navi.php'; ?>
<?php 
	echo form_open('raw_uploads/preprocess');
	$fattr = array(
		'name' => 'raw_textbox',
		'value' => $raw_text,
		'rows' => '30',
		'cols' => '50');
	echo form_textarea($fattr);
?>
<textarea class="right" name="preprocessed_text" value='' rows='30' cols='50'></textarea>
<br/>
<?php

//	echo form_dropdown('pos_tag',
//		array(
//		'value' => 'POS Tagging',
//		'corenlp' => 'CoreNLP',
//		'nltk' => 'NLTK',
//		'spacy' => 'spaCy',));
//	
//	echo form_dropdown('lemma',
//		array(
//		'value' => 'Lemmatization',
//		'corenlp' => 'CoreNLP',
//		'nltk' => 'NLTK',
//		'spacy' => 'spaCy',));
//
//TODO: Insert the appropriate stemming algorithms
//	echo form_dropdown('stemming',
//		array(
//		'id' => 'sent_split',
//		'value' => 'Word Stem',
//		'corenlp' => 'CoreNLP',
//		'nltk' => 'NLTK',
//		'spacy' => 'spaCy',));
?>
	<form>
		<select id="tokenize" class="dropdown" data-active="true" >
		<option value="" selected="selected">Tokenization</option>
		<option value="corenlp">CoreNLP</option>
		<option value="nltk">NLTK</option>
		<option value="spacy">spaCy</option>
		</select>
	</form>
	<form>
		<select id="sent_split" class="dropdown" data-active="false" >
		</select>
	</form>
	<form>
		<select id="pos_tag" class="dropdown" data-active="false" >
		</select>
	</form>
	<form>
		<select id="lemmatize" class="dropdown" data-active="false" >
		</select>
	</form>
	<form>
		<select id="stemming" class="dropdown" data-active="false" >
		</select>
	</form>
<?php echo form_submit(array('value' => 'Preprocess Text')); ?>
<?php echo form_close(); ?>
</body>
</html>
