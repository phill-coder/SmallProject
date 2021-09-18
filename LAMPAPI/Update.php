<?php
   
	$inData = getRequestInfo();
    

	$NewFirstName = $inData["NewFirstName"];
    	$NewLastName = $inData["NewLastName"];
    	$NewPhoneNumber= $inData["NewPhoneNumber"];
	$NewEmail = $inData["NewEmail"];
	$ID = $inData["ID"];
	$UserID = $inData["UserID"];


	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{

        $stmt = $conn->prepare("UPDATE Contacts SET FirstName = ? , LastName =?, PhoneNumber =?, Email =? WHERE UserID = ? and ID = ?");
		$stmt->bind_param("ssssii", $NewFirstName, $NewLastName,$NewPhoneNumber,$NewEmail, $UserID, $ID);
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