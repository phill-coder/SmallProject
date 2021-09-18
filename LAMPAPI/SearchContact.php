<?php
   
	$inData = getRequestInfo();
	
	$ID = $inData["ID"];
	$UserID = $inData["UserID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
    $PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];
	$Search = $inData["Search"];


	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");

    if($conn){
        $stmt = $conn->prepare("SELECT FirstName, LastName, PhoneNumber, Email,UserID FROM Contacts WHERE FirstName LIKE ?");
    
    $ContactName = '%' . $Search . '%';
	$stmt->bind_param("s", $ContactName);
	$stmt->execute();
		
	$result = $stmt->get_result();

	
	while($row = $result->fetch_assoc())
	{
		if( $searchCount > 0 )
		{
			$searchResults .= ",";
		}
		$searchCount++;
		$searchResults .= $row["FirstName"]. " ";
		$searchResults .= $row["LastName"]. " ";
		$searchResults .= $row["PhoneNumber"]. " ";
		$searchResults .= $row["Email"]. " ";
	}
	
	if( $searchCount == 0 )
	{
		returnWithError( "No Records Found" );
	}
	else
	{
		returnWithInfo( $searchResults );
	}
	
	$stmt->close();
	$conn->close();
	}
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	
	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}


    ?>