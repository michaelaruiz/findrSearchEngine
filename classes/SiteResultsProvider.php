<?php
class SiteResultsProvider{

	private $con;

	public function __construct($con){
		$this->con = $con;
	}

	public function getNumResults($term){
		$query = $this->con->prepare("SELECT COUNT(*) as total 
										from sites WHERE title LIKE :term
										or url LIKE :term
										OR keywords LIKE :term
										or description LIKE :term");

		$searchTerm = "%" . $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->execute();

		$row = $query->fetch(PDO::FETCH_ASSOC);
		// store results in key value array
		return $row["total"];
	}

	public function getResultsHtml($page, $pageSize, $term){
		$fromLimit = ($page - 1) * $pageSize;
		// page 1 : (1 -1) * 20 = 0
		// page 1 : (2 -1) * 20 = 20

		$query = $this->con->prepare("SELECT *
										from sites WHERE title LIKE :term
										or url LIKE :term
										OR keywords LIKE :term
										or description LIKE :term
										ORDER BY clicks DESC
										LIMIT :fromLimit, :pageSize");
		$searchTerm = "%" . $term . "%";
		$query->bindParam(":term", $searchTerm);
		$query->bindParam(":fromLimit", $fromLimit, PDO::PARAM_INT);
		$query->bindParam(":pageSize", $pageSize, PDO::PARAM_INT);
		$query->execute();

		$resultsHtml = "<div class='siteResults'>";

		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			$id = $row["id"];
			$url = $row["url"];
			$title = $row["title"];
			$description = $row["description"];

			$title = $this->trimField($title, 55);
			$description = $this->trimField($description, 230);

			$resultsHtml .= "<div class='resultContainer'>
							<h3 class='title'>
								<a class='result' href='$url' data-linkId='$id'>
									$title
								</a>
							</h3>
							<span class='url'>$url</span>
							<span class='description'>$description</span>
							</div>";
		}

		$resultsHtml .= "</div>";
		// append the string
		return $resultsHtml;

}

	private function trimField($string, $characterLimit){
		$dots = strlen($string) > $characterLimit ? "..." : "";
		// if $string too long set to ... otherwise to empty string/
		return substr($string, 0, $characterLimit) . $dots;
	}
}
?>