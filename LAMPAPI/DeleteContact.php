<?php
   
	$inData = getRequestInfo();

	$FirstName = $inData["FirstName"];
   	 $LastName = $inData["LastName"];
	$PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];
  


	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE FirstName = ? AND LastName = ? AND PhoneNumber = ? AND Email = ?");
		$stmt->bind_param("ssss", $FirstName,$LastName, $PhoneNumber,$Email);
		$stmt->execute();


 		 returnWithError("");

		

		$stmt->close();
		$conn->close();
	} 
	else
	{
		returnWithError("FAILED TO CONNECT");
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