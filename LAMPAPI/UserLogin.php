<?php

	$inData = getRequestInfo();
	$Login = $inData["Login"];
	$Pass = $inData["Password"];


	$conn = new mysqli("localhost", "root", "cop4331Team", "contactmanager");	
	if( $conn)
	{
		$stmt = $conn->prepare("SELECT ID FROM Users WHERE Login=? AND Password =? ");
		$stmt->bind_param("ss", $Login, $Pass);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['ID']);
		}
		else
		{
			returnWithError("No user found");
		}

		$stmt->close();
		$conn->close();
	}
	else
	{
		returnWithError( $conn->connect_error );
	}
	
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{
				"ID":0 ,
				"error": "' . $err . '"
			    }';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $ID)
	{
		$retValue = '{ 
				"ID" :' . $ID .'}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
