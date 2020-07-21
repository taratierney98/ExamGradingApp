<?php

session_start();
$ucid=$_POST["ucid"]; 
$pass=$_POST["pass"]; 
$_SESSION["ucid"] = $ucid;
$_SESSION["pass"] = $pass;

$ucidpass = "{\"ucid\":\"$ucid\" , \"pass\":\"$pass\"}";

$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/CS490/Final/login.php");
curl_setopt($ch, CURLOPT_URL, "https://web.njit.edu/~tat22/CS490/New/Middle/login.php");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $ucidpass);
$login_response = curl_exec($ch);
curl_close($ch);

$response = JSON_decode($login_response); 
$status = $response -> {'type'}; 

$login_array = array('login' => $status);
$login_return = json_encode($login_array);
print $login_return;

?>