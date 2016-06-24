document.addEventListener("DOMContentLoaded", function(event){
	console.log("DOM fully loaded and parsed");

	var preprocesses = document.getElementsByClassName("preprocess");

	for(var i = 0; i < preprocesses.length; i++){
		preprocesses[i].addEventListener("change", checkProcesses, false);
	}
	var hidden = document.getElementsByClassName("initial-hide");
	for(var i = 0; i < hidden.length; i++){
		hidden[i].style.visibility = 'hidden';
	}
});

//TODO: need to do more checks to ensure conflicting processes can't occur
//the passed values are validated once more on the server side in the php code,
//this is mainly for user's ease of use
function checkProcesses(){
	var sent = document.getElementById('sent_split');
	var pos = document.getElementById('pos_tag');
	var lemma = document.getElementById('lemmatize');
	var stem = document.getElementById('stemming');
	var ner = document.getElementById('ner_tag');

	switch(this.id){

		case 'tokenize':
			if(sent.dataset.active == 'false'){ 
				if(this.value == 'corenlp'){
					sent.value = 'corenlp';
				}
				else if(this.value == 'nltk'){
					sent.value = 'nltk';
				}
				else if(this.value == 'spacy'){
					sent.value = 'spacy';
				}
				document.getElementById('sent_para').style.visibility = 'visible';
			}
			break;

		case 'sent_split':
			if(pos.dataset.active == 'false' && stem.dataset.active == 'false'){ 
				var options = ['Stemming', 'Porter', 'Lancaster', 'Porter2'];
				var values = ['', 'porter', 'lancaster', 'porter2'];
				
				for(var i = 0; i < options.length; i++){
					var option = options[i];
					var value = values[i];
					var el = document.createElement("option");
					el.textContent = option;
					el.value = value;
					stem.appendChild(el);
				}
				
				if(this.value == 'corenlp'){
					pos.value = 'corenlp';
				}
				else if(this.value == 'nltk'){
					pos.value = 'nltk';
				}
				else if(this.value == 'spacy'){
					pos.value = 'spacy';
				}
				document.getElementById('pos_stem_para').style.visibility = 'visible';
			}
			break;

		case 'pos_tag':
			if(lemma.dataset.active == 'false'){
				if(this.value == 'corenlp'){
					lemma.value = 'corenlp';
				}
				else if(this.value == 'nltk'){
					lemma.value = 'nltk';
				}
				else if(this.value == 'spacy'){
					lemma.value = 'spacy';
				}
				document.getElementById('lemma_para').style.visibility = 'visible';
			}
			break;

		case 'lemmatize':
			if(ner.dataset.active == 'false'){
				if(this.value == 'corenlp'){
					ner.value = 'corenlp';
				}
				else if(this.value == 'nltk'){
					ner.value = 'nltk';
				}
				else if(this.value == 'spacy'){
					ner.value = 'spacy';
				}
				document.getElementById('ner_para').style.visibility = 'visible';
			}
			break;
/* 
 * Below is older code for implementing the preprocesses as a dropdown selection
 * That brought up issues with mix and matching acceptable framework input and outputs
 * which may be more trouble than it is worth
 */
//
//	case 'tokenize':
//		if(sent_dropdown.dataset.active == "false" && this.value != ''){
//			var values = ['', 'corenlp', 'nltk', 'spacy'];
//			var options = ['Sentence Split', 'CoreNLP', 'NLTK', 'spaCy'];
//
//			for(var i = 0; i < options.length; i++){
//				var option = options[i];
//				var value = values[i];
//				var el = document.createElement("option");
//				el.textContent = option;
//				el.value = value;
//				sent_dropdown.appendChild(el);
//			}
//			sent_dropdown.dataset.active = "true";
//			break;
//		} else {
//			sent_dropdown.dataset.active = "false";
//			sent_dropdown.innerHTML = "";
//			break;
//		}
//
//		case 'sent_split':
//			if(pos_dropdown.dataset.active == "false" && 
//				sent_dropdown.dataset.active == "true" && 
//				this.value != ''){
//				var values = ['', 'corenlp', 'nltk', 'spacy'];
//				var options = ['POS Tag', 'CoreNLP', 'NLTK', 'spaCy'];
//
//				for(var i = 0; i < options.length; i++){
//					var option = options[i];
//					var value = values[i];
//					var el = document.createElement("option");
//					el.textContent = option;
//					el.value = value;
//					pos_dropdown.appendChild(el);
//				}
//				pos_dropdown.dataset.active = "true";
//				break;
//			} else {
//				pos_dropdown.dataset.active = "false";
//				pos_dropdown.innerHTML = "";
//				break;
//			}
//
//		case 'pos_tag':
//			var pos_dropdown = document.getElementById('pos_tag');
//			break;
	}
}
