<?php
	require_once("functions.inc");
		
	//error_reporting(E_ALL & ~E_NOTICE);
	//this prevents access to this script if the form has not been submitted by the user
	if(!isset($_POST['submit'])){
		die(header("Location: index.php"));
	}
	
	$_SESSION['formAttempt'] = true;
	
	if(isset($_SESSION['error'])){
		unset($_SESSION['error']);
	}
	$requiredFields = array("email" => "E-mail", "password" => "Password");
	
	$_SESSION['error'] = array();
	//checking the required fields
	foreach($requiredFields as $keys => $required){
		if(!isset($_POST[$keys]) || $_POST[$keys] == ""){
			$_SESSION['error'][] = $required." is required.";
		}
	}
	//checking for valid email address
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$_SESSION['error'][] = "Please, enter a valid email address.";
	}
	
	if(count($_SESSION['error']) > 0){
		die(header("Location: signIn.php"));
	}else{
		//for Admin Login... to be finetuned later
		if($_POST['email']=="admin@cloudhere.com" && $_POST['password'] == "admin"){
			$_SESSION['adminLogin'] = true;
			die(header("Location: adminview.php"));
		}
		$user = new User();
		if($user->authenticate($_POST['email'], $_POST['password'])){
			unset($_SESSION['formAttempt']);
			$user->lastLogin($_POST['email']);
			die(header("Location: welcomePage.php"));
		}else{
			$_SESSION['error'][] = "Incorrect Username or Password!";
			die(header("Location: signIn.php"));
		}
	}
	
?>