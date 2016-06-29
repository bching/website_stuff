import java.io.*;
import java.util.*;

import edu.stanford.nlp.simple.*;

public class SimpleCoreNLPDemo{
	public static void main(String[] args) throws IOException {
		//Create a document, no computation done yet
		Document doc = new Document("This is testing text. Let's see what CoreNLP can do!");
		for(Sentence sent: doc.sentences()){
			System.out.println("Second word of the sentence '" + sent + "' is " + sent.word(1));
			System.out.println("The third lemma of the sentence '" + sent + "' is " + sent.lemma(2));
		//	System.out.println("The pase of the sentence '" + sent + "' is " + sent.parse());
		}
	}
}
