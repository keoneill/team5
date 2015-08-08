<?php
 
	mysql_connect('host', 'username', 'password');
	$db = mysql_select_db('db_name');
	
  	mysql_select_db($db);  
  	
  	$task = $_POST["task"];
	$password = $_POST["password"];
	$username = $_POST["username"];


	if (!empty($_POST)) 
	{
		if (empty($_POST['username']) || empty($_POST['password'])) 
		{
			// Create some data that will be the JSON response 
			$response["success"] = 0;
			$response["message"] = "One or both of the fields are empty .";
	        die(json_encode($response));
		}
		
		if ($task == 'login')
		{
			$sql = "SELECT * FROM user_info WHERE username = '$username' AND password ='$password'";
      	
			$query = mysql_query($sql);
			$row = mysql_fetch_array($query);
			
			if (!empty($row)) 
			{
				$response["success"] = 1;
        		$response["message"] = "You have sucessfully logged in";
        	 	die(json_encode($response));
  			}
  			else
  			{
	   			$response["success"] = 0;
        	  	$response["message"] = "invalid username or password ";
  				die(json_encode($response));
  			}
  		}
  		if ($task == 'register')
  		{
  			// Check if username already exists
  			$sqlSearch = "SELECT * FROM user_info WHERE username = '$username'";
  			$querySearch = mysql_query($sqlSearch);
  			if (mysql_num_rows($querySearch))
  			{
  				$response["success"] = 0;
       		  	$response["message"] = "user name already exists ";
				die(json_encode($response));
			}
			else 
			{
  				// Add user to new row
  				$sqlInsert = "INSERT INTO user_info".  
  					"(username, password, dowGameChoice, prevChoice, currentScore, averageScore, numGamesPlayed, totalScore)".
  					"VALUES	('$username', '$password', '','',0,0,0,0)"; 
  				$retval = mysql_query($sqlInsert);
  				if(! $retval )
				{
 					$response["success"] = 0;
  					$response["message"] = "could not enter data ";
  					die(json_encode($response));
				}
  			
  				// Verify user row was created
  				$query3 = "SELECT * FROM user_info WHERE username = '$username' AND password ='$password'";
  				$sql3 = mysql_query($query3);
  				$row2 = mysql_fetch_array($sql3);
				
				if (!empty($row2)) 
				{
					$response["success"] = 1;
        			$response["message"] = "You have sucessfully registered";
        		 	die(json_encode($response));
  				}
  				else
  				{
	   				$response["success"] = 0;
        		  	$response["message"] = "error registering ";
  					die(json_encode($response));
  				}
  			}
  		}
    }
  	else
  	{
   		$response["success"] = 0;
        $response["message"] = " One or both of the fields are empty ";
  		die(json_encode($response));
  	}
    mysql_close();
?>



