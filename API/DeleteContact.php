<?php
   
	$inData = getRequestInfo();
    $id = $inData["ID"];
	$FirstName = $inData["FirstName"];
    $LastName = $inData["LastName"];

	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE FirstName = ? and LastName = ?");
		$stmt->bind_param("s", $FirstName,$LastName);
		$stmt->execute();

        // if (mysqli_query($conn, $stmt)) {
        //     echo "Record deleted successfully";
        //   } else {
        //     echo "Error deleting record: " . mysqli_error($conn);
        //   }


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