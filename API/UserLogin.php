<?php

	$inData = getRequestInfo();
	
	$ID = $inData["ID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
	$UserID = $inData["UserID"];
    $PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];

	$conn = new mysqli("localhost", "root", "cop4331Team", "contactmanager");	
	if( $conn)
	{
		$stmt = $conn->prepare("SELECT ID,FirstName, LastName,UserID,PhoneNumber,Email FROM Users WHERE Login = ? AND Password = ?");
		$stmt->bind_param("ss", $inData["Login"], $inData["Password"]);
		$stmt->execute();
		$result = $stmt->get_result();

		if( $row = $result->fetch_assoc()  )
		{
			returnWithInfo( $row['ID'], $row['FirstName'], $row['LastName'],$row['PhoneNumber'],$row['Email'] );
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
		$retValue = '{"id":0,"firstName":"","lastName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}
	
	function returnWithInfo( $ID, $FirstName, $LastName, $PhoneNumber, $Email  )
	{
		$retValue = '{ "id" :' . $ID . ', "FirstName" :" '  . $FirstName . ' ", "LastName" :" ' . $LastName .' , "Email" :" ' . $Email . ' " , "PhoneNumber" :" ' . $PhoneNumber . ' " , "error" : ""}';
		sendResultInfoAsJson( $retValue );
	}
	
?>
