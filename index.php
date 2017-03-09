<?php
	for ($i=1; $i < 1030; $i++) 
	{ 
		$url = 'http://www.moviebuff.com/directory/people?page='.$i;
		echo $url;
		fetch($url);
	}
	function fetch($url)
	{
	$dom = new DOMDocument();
	$homepage = file_get_contents($url);
	libxml_use_internal_errors(true);
	$dom->loadHTML($homepage);
	libxml_clear_errors();
	$classname="person-entry";
	$classname1="name";
	$finder = new DomXPath($dom);
	$spaner = $finder->query("//*[contains(@class, '$classname')]");
	$spaner1 = $finder->query("//*[contains(@class, '$classname1')]");
	$Credentials = "mysql:host=localhost;dbname=moviebuff";
	$Options = array(PDO::ATTR_ERRMODE=> PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	$Connection = new PDO($Credentials,'allau','password', $Options);
    $Trigger = $Connection->prepare("INSERT INTO people (name, role, created_at, updated_at) VALUES (?, ?, ? , ?)");
	$Trigger->bindParam(1, $name);
	$Trigger->bindParam(2, $role);
	$Trigger->bindParam(3, $created_at);
	$Trigger->bindParam(4, $updated_at);
	for ($i=0; $i < 200; $i++) { 
		$node = $spaner->item($i);
		$node1 = $spaner1->item($i);
		if($node1->textContent)
		{
		$len =  strlen($node1->textContent);
		$roleStr = substr($node->textContent, $len+1, strlen($node->textContent));
		$name = $node1->textContent;
		$role = $roleStr;
		$created_at = date("Y-m-d H:i:s");
		$updated_at = date("Y-m-d H:i:s");
		$Trigger->execute();	
		
		}
		else
		{
			echo "Skipped".$url;
		}
	}
	$Connection = null;
	}
?>