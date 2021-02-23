<?php
ob_start();
//output buffering

try{
	$con = new PDO("mysql:dbname=searchEngine;host=localhost", "root", "");
	//connect to database
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	//set error mode to error mode warning
	//pdo - php data object
}
catch(PDOException $e){
	echo "Connection failed: " . $e->getMessage();
}





?>