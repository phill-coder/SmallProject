<?php
   
	$inData = getRequestInfo();
	
	$ID = $inData["ID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
    $PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];
    $Username = $inData["Username"];
    $Password = $inData["Password"];

	$conn = new mysqli("localhost", $Username , $Password,"contactmanager");
	if ($conn) 
	{
		
		//id is contact's number
		$stmt = $conn->prepare("INSERT into Contacts ID,FirstName, LastName,PhoneNumber,Email, Username, Password  VALUES(?,?,?,?,?,?,?)");
		$stmt->bind_param("ississ", $ID, $FirstName,$LastName,$UserID,$PhoneNumber,$Email,$Username, $Password    );
		$stmt->execute();
		$stmt->close();
		$conn->close();

		header('Content-type: application/json');
		echo $obj;
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