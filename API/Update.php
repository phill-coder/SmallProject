<?php
   
	$inData = getRequestInfo();
    
    $ID = $inData["ID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];
    $PhoneNumber= $inData["PhoneNumber"];
	$Email = $inData["Email"];


	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{

        $stmt = $conn->prepare("UPDATE Contacts SET FirstName, LastName , PhoneNumber , Email WHERE FirstName, LastName  VALUE(?,?,?,?,?,?)");
		$stmt->bind_param("ssssis", $FirstName, $LastName,$PhoneNumber,$Email, $FirstName,$LastName);
		$stmt->execute();
		$stmt->close();
		$conn->close();
	} 
	else
	{
		echo "database failed to connect";
	}

    function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}


?>