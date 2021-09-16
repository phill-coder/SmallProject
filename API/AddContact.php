<?php
   
	$inData = getRequestInfo();
	
	$ID = $inData["ID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
    $PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];
  

	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{
		$stmt = $conn->prepare("INSERT into Contacts (ID,FirstName, LastName,PhoneNumber,Email) VALUES(?,?,?,?,?,?)");
		$stmt->bind_param("ississ", $ID, $FirstName,$LastName,$UserID,$PhoneNumber,$Email);
		$stmt->execute();
		$stmt->close();
		$conn->close();

		//header('Content-type: application/json');
		//echo $obj;
	} 
	else
	{
		echo "database failed to connect";
	}

    function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}


?>