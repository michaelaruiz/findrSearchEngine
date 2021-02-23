<?php
class DomDocumentParser {

	private $doc;

	public function __construct($url) {

		$options = array(
			'http'=>array('method'=>"GET", 'header'=>"User-Agent: doodleBot/0.1\n")
			);
		$context = stream_context_create($options);

		$this->doc = new DomDocument();
		@$this->doc->loadHTML(file_get_contents($url, false, $context));
	}

	public function getlinks() {
		return $this->doc->getElementsByTagName("a");
	}

	public function getTitletags() {
		return $this->doc->getElementsByTagName("title");
	}

	public function getMetatags() {
		return $this->doc->getElementsByTagName("meta");
	}

	public function getImages() {
		return $this->doc->getElementsByTagName("img");
	}

}
?>

    
<!--//    passing in url; make requests to go to url and passing in website contents into DomDocument Object and $doc contains the HTML of the website-->

<!--get links gets the links from a website-->
    

