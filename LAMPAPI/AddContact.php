<?php
   
	$inData = getRequestInfo();
	
	$UserID = $inData["UserID"];
	$FirstName = $inData["FirstName"];
   	$LastName = $inData["LastName"];
    	$PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];
  

	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{
		$stmt = $conn->prepare("INSERT into Contacts (FirstName, LastName,PhoneNumber,Email,UserID) VALUES(?,?,?,?,?)");
		$stmt->bind_param("ssssi", $FirstName,$LastName,$PhoneNumber,$Email, $UserID);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		
		returnWithError(""); 

	} 
	else
	{
		returnWithError( $conn->connect_error );
	}

     function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
  	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
    function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}



?>