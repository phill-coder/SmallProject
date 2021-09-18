<?php
   
	$inData = getRequestInfo();
	
   	 $Login = $inData["Login"];
   	 $Pass = $inData["Password"];


	$conn = new mysqli("localhost", "root" , "cop4331Team" ,"contactmanager");
	if ($conn) 
	{
		
		$stmt = $conn->prepare("INSERT into Users (Login, Password) VALUES(?,?)");
		$stmt->bind_param("ss",$Login, $Pass);
		$stmt->execute();
		$stmt->close();
		$conn->close();
		
		returnWithError(""); 

	} 
	else
	{
		returnWithError( $conn->connect_error );	}

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