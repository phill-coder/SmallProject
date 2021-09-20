<?php
   
	$inData = getRequestInfo();
    

	$NewFirstName = $inData["NewFirstName"];
    	$NewLastName = $inData["NewLastName"];
    	$NewPhoneNumber= $inData["NewPhoneNumber"];
	$NewEmail = $inData["NewEmail"];

	$FirstName = $inData["FirstName"];
   	$LastName = $inData["LastName"];
	$PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];
  


	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{

        $stmt = $conn->prepare("UPDATE Contacts SET FirstName = ? , LastName =?, PhoneNumber =?, Email =? WHERE FirstName = ? and LastName =? and PhoneNumber =? and Email =? ");
		$stmt->bind_param("ssssssss", $NewFirstName, $NewLastName,$NewPhoneNumber,$NewEmail, $FirstName, $LastName,$PhoneNumber,$Email);
		$stmt->execute();
		$stmt->close();
		$conn->close();

		returnwitherror("Sucess");
	} 
	else
	{
		returnwitherror("error not conn");
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