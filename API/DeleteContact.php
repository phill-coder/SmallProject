<?php
   
	$inData = getRequestInfo();
    $id = $inData["ID"];

	$conn = new mysqli("localhost", "root", "cop4331Team","contactmanager");
	if ($conn) 
	{
		$stmt = $conn->prepare("DELETE FROM Contacts WHERE ?");
		$stmt->bind_param("i", $id);
		$stmt->execute();

        if (mysqli_query($conn, $stmt)) {
            echo "Record deleted successfully";
          } else {
            echo "Error deleting record: " . mysqli_error($conn);
          }


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