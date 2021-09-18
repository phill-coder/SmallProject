<?php
   
	$inData = getRequestInfo();

	$FirstName = $inData["FirstName"];
   	 $LastName = $inData["LastName"];

	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE FirstName = ? and LastName = ?");
		$stmt->bind_param("ss", $FirstName,$LastName);
		$stmt->execute();

		returnWithError("");

		$stmt->close();
		$conn->close();
	} 
	else
	{
		echo "database failed to connect";
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