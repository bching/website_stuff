import os
import sys

from spacy.en import English

#INSTANTIATE SPACY PARSER
nlp = English()

def token_process(file_in):
	_tokens = nlp(unicode(file_in, encoding="utf-8"))
	return _tokens

def sent_process(file_in):
	_tokens = nlp(unicode(file_in, encoding="utf-8"))
	_sents = _tokens.sents
	return _sents

def pos_process(file_in):
	_pos_tagged = []
	_tokens = nlp(unicode(file_in, encoding="utf-8"))
	for sent in _tokens.sents:
		for token in sent:
			token_pos = '{}/{}'.format(token.orth_.encode('ascii', 'ignore'), token.pos_)
			_pos_tagged.extend(token_pos)
	return _pos_tagged

def lemma_process(file_in):
	_lemmas = []
	_tokens = nlp(unicode(file_in, encoding="utf-8"))
	for sent in _tokens.sents:
		for token in sent:
			token_lemma = '{}/{}/{}'.format(token.encode('ascii', 'ignore'), token.lemma_.encode('ascii', 'ignore'), token.pos_)
			_lemmas.extend(token_lemma)
	return _lemmas

def ner_process(file_in):
	_ner_tagged = []
	_tokens = nlp(unicode(file_in, encoding="utf-8"))
	for sent in _tokens.sents:
		for token in sent:
			if token.ent_type_ != "":
				token_ner = '{}/{}/{}/{}'.format(token.encode('ascii', 'ignore'), token.lemma_.encode('ascii', 'ignore'), token.pos_, '_')
			else:
				token_ner = '{}/{}/{}/{}'.format(token.encode('ascii', 'ignore'), token.lemma_.encode('ascii', 'ignore'), token.pos_, token.ent_type_)
			_ner_tagged.extend(token_ner)
	return _ner_tagged

def main():
	tokens = []
	sents = []
	pos_tagged = []
	lemmas = []
	ner_tagged = []
	stemmed = []

	file = ''
	#Read file without line breaks
	with open(sys.argv[1], 'r') as _file:
		file = _file.read().replace('\n', ' ')
	
	if file == '':
		print 'File not read properly'
		sys.exit()

	if sys.argv[-1] == 'tokenize':
		tokens = token_process(file)
		print tokens
		for token in tokens:
			print token

	elif sys.argv[-1] == 'sent_split':
		sents = sent_process(file)
		for sent in sents:
			print sent

	elif sys.argv[-1] == 'pos_tag':
		pos_tagged = pos_process(file)
		for pos in pos_tagged:
			print ' '.join(pos)
		
	elif sys.argv[-1] == 'lemmatize':
		lemmas = lemma_process(file)
		for lemma in lemmas:
			print ' '.join(lemma)

	elif sys.argv[-1] == 'ner_tag':
		ner_tagged = ner_process(file)
		for ner in ner_tagged:
			print ' '.join(ner)

#BEGIN PREPROCESSING EXECUTION
main()

#TO KEEP LINE BREAKS
#with open('/Users/stc1563/programming/research/test-cases/_raw/lemmaCase-v6.txt', 'r') as f:
#	strIn=f.read();
#	for line in f:
#		tokenSents = nlp(unicode(line,encoding="utf-8"))
#		for span in tokenSents.sents:
#			sent = ''.join(tokenSents[i].string for i in range(span.start, span.end)).strip()
#			sents.append(sent)

#spacy parser creates tokens objects with callable methods that return nlp component results
#tokens = nlp(unicode(strIn,encoding="utf-8"))

#Sents property returns spans
#Spans have indices into original string
#where each index value returns a token
#SENTENCE SPLITTING
#for span in tokens.sents:
##go from the start to the end of the span, returning each token in the sentence
##combine each token using join()
#	sent = ''.join(tokens[i].string for i in range(span.start, span.end)).strip()
#	sents.append(sent)
#for sentence in sents:
#	tokenCount+=1
#	print '{}'.format(sentence.encode('ascii', 'ignore'))
#END SENTENCE SPLITTING


