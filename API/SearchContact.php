<?php
   
	$inData = getRequestInfo();
	
	$ID = $inData["ID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
	$UserID = $inData["UserID"];
    $PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];

	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");

    if($conn){
        $stmt = $conn->prepare("select FirstName from Contact where FirstName like ? and LastName like ?");
    
    $ContactName = "%" . $inData["search"] . "%";
	$stmt->bind_param("ss", $ContactName, $inData["LastName"]);
	$stmt->execute();
		
	$result = $stmt->get_result();

	
	while($row = $result->fetch_assoc())
	{
		if( $searchCount > 0 )
		{
			$searchResults .= ",";
		}
		$searchCount++;
		$searchResults .= '"' . $row["FirstName"] . '"';
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


    ?>