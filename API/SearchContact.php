<?php
   
	$inData = getRequestInfo();
	
	$ID = $inData["ID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
    $PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];
	$Search = $inData["Search"];


	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");

    if($conn){
        $stmt = $conn->prepare("SELECT FirstName, LastName, PhoneNumber, Email FROM Contact WHERE FirstName LIKE ? and ID =?");
    
    $ContactName = "% . $Search . %";
	$stmt->bind_param("si", $ContactName,$ID);
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
		//returnWithError( "No Records Found" );
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

	
	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}


    ?>