<?php
   
	$inData = getRequestInfo();
	$Search = $inData["Search"];
	$UserID = $inData["UserID"];
  	 $FirstNameList = "";
 	$LastNameList ="";
    	 $PhoneList ="";
     	$EmailList = "";


	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");

    if($conn){
        $stmt = $conn->prepare("SELECT FirstName, LastName, PhoneNumber, Email,ID FROM Contacts WHERE FirstName LIKE ? and UserID = ?");
    
    $ContactName = '%' . $Search . '%';
	$stmt->bind_param("si", $ContactName,$UserID);
	$stmt->execute();
		
	$result = $stmt->get_result();

	
	while($row = $result->fetch_assoc())
	{
		if( $searchCount > 0 )
		{
			   $FirstNameList .=",";
           		 $LastNameList .=",";
           		 $PhoneList .=",";
            		$EmailList .= ",";

		}
		$searchCount++;
		$FirstNameList .= '"' .$row["FirstName"].'"';
		$LastNameList .= '"' .$row["LastName"]. '"';
		$PhoneList .= '"' .$row["PhoneNumber"]. '"';
		$EmailList .= '"' .$row["Email"]. '"';	}
	
	if( $searchCount == 0 )
	{
		returnWithError( "No Records Found" );
	}
	else
	{
		returnWithInfo( $FirstNameList, $LastNameList,$PhoneList,$EmailList );
	}
	
	$stmt->close();
	$conn->close();
	}
	function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function returnWithInfo( $FirstNameList, $LastNameList,$PhoneList,$EmailList  )
	{
		$retValue = '{
            "FirstNameList":[' . $FirstNameList . '],
            "LastNameList":[' . $LastNameList . '],
            "PhoneList":[' . $PhoneList . '],
            "EmailList":[' . $EmailList . '],
            "error":""
       			 }';

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