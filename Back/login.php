<?php

// credentials for connecting to MySQL database
$user = "tat22";
$pass = "YhwiKlZf";
$host = "sql1.njit.edu";
$db = "tat22";
	
// MySQL db connection and error testing
$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
	die("Connection failed: " . $conn->connect_error);
}

// receiving data from middle cURL POST request	
$data = file_get_contents('php://input');
$json = json_decode($data);
$ucid = $json->{'ucid'};
$pass = $json->{'pass'};

// SQL statement string to find ucid
$cmd = "SELECT * FROM Users WHERE ucid='$ucid'";

// check whether the login is valid
$cursor = $conn->query($cmd);
if(mysqli_num_rows($cursor) > 0)
{
	$row = $cursor->fetch_assoc();
	$db_hash = $row['pass'];				// fetch hashed password from db
	$type = $row['type'];
	
	// compare hashed password from db to incoming hashed password 
	if($db_hash == hash('sha256', $pass))
	{	
		$resp_ar = array('back' => 'true', 'type' => $type,);
	}
	else
	{
		$resp_ar = array('back' => 'false', 'type' => "N",); // wrong pass
	}	
}
else{
	$resp_ar = array('back' => 'false', 'type' => "N",); // not in table
}	

// response
$return_array = json_encode($resp_ar);
echo $return_array;
$conn->close();

?>