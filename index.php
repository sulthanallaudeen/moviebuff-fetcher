<?php
	$dom = new DOMDocument();
	$homepage = file_get_contents('http://www.moviebuff.com/directory/people');
	libxml_use_internal_errors(true);
	$dom->loadHTML($homepage);
	libxml_clear_errors();
	$classname="row";
	$finder = new DomXPath($dom);
	$spaner = $finder->query("//*[contains(@class, '$classname')]");
	#Added Credentials
	$Credentials = "mysql:host=localhost;dbname=moviebuff";
	#Added Exceptions
	$Options = array(PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	#Establishing Connection
	$Connection = new PDO($Credentials,'root','', $Options);
	#Declaring Table Name
	$TableName = 'sysaxiom';
    #Preparing Statement
    $Trigger = $Connection->prepare("INSERT INTO people (name, role, created_at, updated_at) VALUES (?, ?, ? , ?)");
    #Binding the Parameter
	$Trigger->bindParam(1, $name);
	$Trigger->bindParam(2, $role);
	$name = 'Sulthan';
	$role = 'sa@sysaxiom.com';
	foreach($spaner as $element ){
		print_r($element);
		echo $element->textContent;
		echo $element->textContent."<br>";
		//$Trigger->execute();
 	//echo $element->textContent."<br>";
		}
	#Executing the Trigger
	
	#Disconnecting the DB Connection
	$Connection = null;
?>