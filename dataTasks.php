<?php
 
	mysql_connect('host', 'username', 'password');
	$db = mysql_select_db('stocksim_db');
	
  	mysql_select_db($db);  
  	
  	$task = $_POST["task"];
	$username = $_POST["username"];
	$stockPick = $_POST["dowGameChoice"];


	if (!empty($_POST)) 
	{
		if (empty($_POST['username'])) 
		{
			// Create some data that will be the JSON response 
			$response["success"] = 0;
			$response["message"] = "Error. No Information sent to the server.";
	        die(json_encode($response));
		}
		
		// Update Users Stock Pick for next trading session
		if ($task == 'updateDowChoice')
		{
			$sqlUpdate = "UPDATE user_info SET dowGameChoice = '$stockPick' WHERE username = '$username'";
			mysql_query($sqlUpdate);
			
			$sqlVerify = "SELECT * FROM user_info WHERE username = '$username'";
      	
			$query = mysql_query($sqlVerify);
			$row = mysql_fetch_array($query);
			
			if (!empty($row))
  			{
  				$response["success"] = 1;
       		  	$response["message"] = "Your stock pick has been confirmed.";
       		  	$response["dowGameChoice"] = $row[2];
				die(json_encode($response));
			}
			else 
			{
   				$response["success"] = 0;
        	  	$response["message"] = "Could not confirm pick. Please try again. ";
  				die(json_encode($response));
  			}
  		}
			
  		
  		
  		// view Stats task
  		if ($task == 'viewStats')
  		{
  			// Check if username already exists
  			$sqlSearch = "SELECT * FROM user_info WHERE username = '$username'";
  			$query = mysql_query($sqlSearch);
  			$row = mysql_fetch_array($query);
  						
			if (!empty($row))
  			{
       		  	$response["success"] = 1;
       		  	$response["message"] = "success";
       		  	$response["currentScore"] = $row[4];
       		  	$response["averageScore"] = $row[5];
       		  	$response["numGamesPlayed"] = $row[6];
       		  	$response["totalScore"] = $row[7];
				die(json_encode($response));
			}
			else 
			{
   				$response["success"] = 0;
        	  	$response["message"] = "Could not gather data. ";
  				die(json_encode($response));
  			}
  		}
  	}
  	else
  	{
   		$response["success"] = 0;
        $response["message"] = " Error sending data ";
  		die(json_encode($response));
  	}
    mysql_close();
?>



