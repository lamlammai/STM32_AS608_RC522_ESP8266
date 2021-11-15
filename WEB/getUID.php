<?php
	$UIDresult=$_POST["UIDresult"];
	$Write="<?php $" . "UIDresult='" . $UIDresult . "'; " . "echo $" . "UIDresult;" . " ?>";
	file_put_contents('UIDContainer.php',$Write);
	include 'config.php';
	$sosanh = true;

	$sql ="SELECT * from user";					// Select all data in table "status"
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) 
	{
		if(  $row["id"] == $UIDresult)
		{
			echo $row["name"];
			
			$sosanh = true;
			break;
		}

	}


	
	



    
		
	
?>