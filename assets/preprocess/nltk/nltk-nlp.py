import os
import sys

import nltk
from nltk.tree import ParentedTree
from nltk.stem import WordNetLemmatizer
from nltk.corpus import wordnet
'''
Preprocess function declarations
'''
'''
This function returns the correlating wordnet tag for each treebank
 pos tag in order to use the wordnet lemmatizer in NLTK.
'''
def get_wordnet_pos(treebank_tag):
	if treebank_tag.startswith('J'):
		return wordnet.ADJ
	elif treebank_tag.startswith('V'):
		return wordnet.VERB
	elif treebank_tag.startswith('N'):
		return wordnet.NOUN
	elif treebank_tag.startswith('R'):
		return wordnet.ADV
	else:
		return ''
'''
Accepts file as bytes and returns list of tokens
 from word_tokenize() method
'''
def token_process(file_in):
	_tokens = nltk.word_tokenize(file_in)
	return _tokens
'''
Accepts file as bytes and returns list of sentence
 tokens from sent_tokenize() method
'''
def sent_process(file_in):
	_sents = nltk.sent_tokenize(file_in)
	return _sents

'''
Accepts file as bytes and returns list of pos 
 tokens 
'''
def pos_process(file_in):
	#Declare empty list
	_pos = []
	#First get sentence tokens
	_sents = nltk.sent_tokenize(file_in)
	#For each sentence get the pos list 
	for sent in _sents:
		#Get the token list
		_tokens = nltk.word_tokenize(sent)
		#Get the pos token list
		_pos_tokens = nltk.pos_tag(_tokens)
		#For each token in pos list append the pos as a formatted string
		# to the empty _pos list
		for token in _pos_tokens:
			#'{}/{}' is the formatted string to append
			pos = '{}/{}'.format(token[0].encode("ascii", "ignore"),token[1])
			_pos.append(pos)
	return _pos
'''
This is the same process as the above method. But now with
 a WordNetLemmatizer class object to add in lemmatize step
'''
def lemma_process(file_in):
	_lemmas = []
	_sents = nltk.sent_tokenize(file_in)
	#Declare WordNetLemmatizer() object
	wordnet_lemmatizer = WordNetLemmatizer()
	for sent in _sents:
		#Get token list and get pos list in one line
		_pos = nltk.pos_tag(nltk.word_tokenize(sent))
		#For each pos in _pos list get the lemma
		for pos in _pos:
			#Get corresponding wordnet tag from treebank tag
			tag = get_wordnet_pos(pos[1])
			lem = ''
			#If the tag is not empty then pass in the tag variable into
			# the wordnet_lemmatizer.lemmatize() method
			if tag != '':
				lem = '{}/{}/{}'.format(pos[0].encode("ascii", "ignore"),
						pos[1],
						wordnet_lemmatizer.lemmatize(pos[0], tag).encode("ascii", "ignore"))
			#Else pass in only the pos word and return the default lemma
			else:
				lem = '{}/{}/{}'.format(pos[0].encode("ascii", "ignore"),
						pos[1],
						wordnet_lemmatizer.lemmatize(pos[0]).encode("ascii", "ignore"))
			_lemmas.append(lem)
	return _lemmas

#Chunked sentence tag
SENTENCE = 'S'
_ners = []
'''
first variable handles the very first use case where it is not
 a tree, it is not used once it is set to 0. I can't quite remember
 what it exactly was, but I was having issues traversing past the first word
'''
first = 1 
#We are saving the last appended word
current = ''
'''
NER tags are retrieved not from a specific method but from the
 chunked tree NLTK provides. In order to get only the NER tags with 
 consistent formatting and no word repeats this is parsing through the chunked tree
Parent is the first node of the tree
'''
def ner_process(parent):
	ner = ''
	#Global declarations so we can access within method
	global SENTENCE, _ners, first, current
	#every node is a tree of tokens which may have an ner tags
	for node in parent:
		#if a node is a type Tree then recursively recurse the tree
		if type(node) is nltk.Tree:
			#if a node label is of type 'S', don't stdout
			if node.label() == SENTENCE:
				sys.stdout.write('')
			#else for each leaf (word token), append the raw string/POS tag/NER tag
			# and set current to the current appending word
			else:
				for leaf in node.leaves():
					ner = '{}/{}/{}'.format(leaf[0].encode("ascii", "ignore"), leaf[1], node.label())
					current = leaf[0]
					_ners.append(ner)
			#recurse down the tree
			ner_process(node)
		#else node is not a tree
		else:
			if first == 1:
				ner = '{}/{}'.format(node[0].encode("ascii", "ignore"), node[1])
				first = 0 
				_ners.append(ner)
			elif node[0] != current:
				ner = '{}/{}'.format(node[0].encode("ascii", "ignore"), node[1])
				_ners.append(ner)
			else:
				pass
'''
End preprocess function declarations
'''

def main():
	doc = []
	sents = []
	pos_tagged = []
	lemmas = []
	ner_tagged = []

	file = ''
	
	with open(sys.argv[1], 'r') as _file:
		file = _file.read()

	if file == '':
		print 'File not read properly'
		sys.exit()

	uni_str = unicode(file, encoding="utf-8")

	if sys.argv[-1] == 'tokenize':
		doc = token_process(uni_str)
		sys.stdout.write(" ".join(doc).encode("ascii", "ignore"))
		#for token in doc:
		#	print token

	elif sys.argv[-1] == 'sent_split':
		sents = sent_process(uni_str)
		for sent in sents:
			print sent.encode("ascii", "ignore")

	elif sys.argv[-1] == 'pos_tag':
		pos_tagged = pos_process(uni_str)
		#print pos_tagged
		#for pos in pos_tagged:
		#	#print pos 
		#	sys.stdout.write(pos)
		sys.stdout.write(" ".join(pos_tagged))

	elif sys.argv[-1] == 'lemmatize':
		lemmas = lemma_process(uni_str)
		#for lemma in lemmas:
			#print lemma
		#	sys.stdout.write(lemma)
		sys.stdout.write(" ".join(lemmas))

	elif sys.argv[-1] == 'ner_tag':
		_sents = nltk.sent_tokenize(uni_str)
		_tokens = [nltk.word_tokenize(sent) for sent in _sents]
		_pos = [nltk.pos_tag(sent) for sent in _tokens]
		_chunked = nltk.ne_chunk_sents(_pos, binary=False)
		ner_process(_chunked)
		sys.stdout.write(" ".join(_ners))

main()
#
#inpt = ""
#tokenCount = 0
#
#with open('_raw/posCase-v5.txt', 'r') as f:
#	inpt=f.read().replace('\n', ' ')
#
#ustr = unicode(inpt,encoding="utf-8")
##only use sent_toknize_list for sent splitting
#sent_tokenize_list = nltk.sent_tokenize(ustr)
#
#word_tokenize_list = []
#pos_word_list = []
#for sent in sent_tokenize_list:
#	#TOKENIZE SENT INTO INDIVIDUAL TOKENS
#	word_tokenize_list = nltk.word_tokenize(sent)
#	#POS TAG WORD TOKENS
#	pos_word_list = nltk.pos_tag(word_tokenize_list)
#	for pos in pos_word_list:
#		tokenCount+=1
#		print '{} {}'.format(pos[0].encode('ascii', 'ignore'), pos[1])
#
