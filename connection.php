<?php
    header('Content-Type: application/json');
	error_reporting(0);
	
	$server		= "localhost"; 
	$user		= "root"; 
	$password	= ""; 
	$database	= "test"; 
	
	$connect = mysqli_connect($server, $user, $password, $database) or die ("Connection Failed !");

?>