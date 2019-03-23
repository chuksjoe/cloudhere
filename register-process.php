<?php
	require_once("functions.inc");
	
	//error_reporting(E_ALL & ~E_NOTICE);
	//this prevents access to this script if the form has not been submitted by the user
	if(!isset($_POST['submit'])){
		die(header("Location: register.php"));
	}
		
	$_SESSION['formAttempt'] = true;
	
	if(isset($_SESSION['error'])){
		unset($_SESSION['error']);
	}
	
	$requiredFields = array("fname" => "First Name", "lname" => "Last Name", "email" => "E-mail", "password1" => "Password", "password2" => "Verify Password", "gender" => "Gender", "dob" => "Date of birth");
	
	$_SESSION['error'] = array();
	//checking the required fields
	foreach($requiredFields as $keys => $required){
		if(!isset($_POST[$keys]) || $_POST[$keys] == ""){
			$_SESSION['error'][] = $required." is required.";
		}
	}
	//checking for valid text in the name field
	if(!preg_match('/^[\w \'.]+$/', $_POST['fname'])){
		$_SESSION['error'][] = "first name must be letters and numbers only.";
	}
	if(!preg_match('/^[\w \'.]+$/', $_POST['lname'])){
		$_SESSION['error'][] = "last name must be letters and numbers only.";
	}
	//checking for valid email address
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		$_SESSION['error'][] = "Please, enter a valid email address.";
	}
	//check if the passwords match
	if($_POST['password2'] != $_POST['password1']){
		$_SESSION['error'][] = "Password mismatch.";
	}
	//checking if a valid Address variables is selected
	if(isset($_POST['street']) && $_POST['street'] != ""){
		if(!preg_match('/^[\w ,.]+$/', $_POST['street'])){
			$_SESSION['error'][] = "Street must be letters and numbers only.";
		}
	}
	if(isset($_POST['city']) && $_POST['city'] != ""){
		if(!preg_match('/^[\w ,.]+$/', $_POST['city'])){
			$_SESSION['error'][] = "City must be letters and numbers only.";
		}
	}
	if(isset($_POST['state']) && $_POST['state'] != ""){
		if(!preg_match('/^[\w ,.]+$/', $_POST['state'])){
			$_SESSION['error'][] = "State must be letters and numbers only.";
		}
	}
	if(isset($_POST['country']) && $_POST['country'] != ""){
		if(!preg_match('/^[\w ,.]+$/', $_POST['country'])){
			$_SESSION['error'][] = "Country must be letters and numbers only.";
		}
	}
	//checking for the date of birth format
	if(!preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', $_POST['dob'])){
		$_SESSION['error'][] = "Date of birth must follow the specified format.";
	}
	//checking for the ZIP code status
	$zip = $_POST['zip'];
	if(isset($_POST['zip']) && $zip != ""){
		if(!preg_match('/^[\d]+$/', $zip)){
			$_SESSION['error'][] = "ZIP should be digits only.";
		}else if(strlen($zip) < 5 || strlen($zip) > 9){
			$_SESSION['error'][] = "ZIP should be between 5 and 9 digits.";
		}
	}
	//checking for the pnone number validity
	$phone = $_POST['phone'];
	if(isset($_POST['phone']) && $phone != ""){
		if(!preg_match('/^[\d]+$/', $phone)){
			$_SESSION['error'][] = "Phone Number should be digits only.";
		}else if(strlen($phone) < 10){
			$_SESSION['error'][] = "Phone number must be at least 10 digits.";
		}
	}
	
	//final disposition
	if(isset($_SESSION['error']) && count($_SESSION['error']) > 0){
		die(header("Location: register.php"));
	}else{
		if(registerUser($_POST)){
			unset($_SESSION['formAttempt']);
			die(header("Location: successPage.php"));
		}else{
			error_log("Error registering user: {$_POST['email']}");
			$_SESSION['error'][] = "Problem registering new account.";
			die(header("Location: register.php"));
		}
	}
	
	//Registration function
	function registerUser($userData){
		//Database connection establishment done in functions.inc
		$mysqli = new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
		if($mysqli->connect_errno){
			error_log("Cannot connect to MYSQL: ".$mysqli->connect_error);
			return false;
		}

		$email = $mysqli->real_escape_string($_POST['email']);
		//checking for existinf user with the entered email
		$findUser = "SELECT user_id from tbl_user where email = '{$email}'";
		$findResult = $mysqli->query($findUser);
		$findRow = $findResult->fetch_assoc();
		if(isset($findRow['user_id']) && $findRow['user_id'] != ""){
			$_SESSION['error'][] = "A user with that Email address already exists.";
			return false;
		}
		//scrutinizing the other entries
		$fname = $mysqli->real_escape_string($_POST['fname']);
		$lname = $mysqli->real_escape_string($_POST['lname']);
		
		//encrypting password1
		$cryptedPass = crypt($_POST['password1']);
		$pass = $mysqli->real_escape_string($cryptedPass);
		
		if(isset($_POST['street'])){
			$street = $mysqli->real_escape_string($_POST['street']);
		}else{
			$street = "";
		}
		if(isset($_POST['city'])){
			$city = $mysqli->real_escape_string($_POST['city']);
		}else{
			$city = "";
		}
		if(isset($_POST['state'])){
			$state = $mysqli->real_escape_string($_POST['state']);
		}else{
			$state = "";
		}
		if(isset($_POST['country'])){
			$country = $mysqli->real_escape_string($_POST['country']);
		}else{
			$country = "";
		}
		if(isset($_POST['zip'])){
			$zip = $mysqli->real_escape_string($_POST['zip']);
		}else{
			$zip = "";
		}
		if(isset($_POST['phone'])){
			$phone = $mysqli->real_escape_string($_POST['phone']);
		}else{
			$phone = "";
		}
		if(isset($_POST['gender'])){
			$gender = $mysqli->real_escape_string($_POST['gender']);
		}else{
			$gender = "";
		}if(isset($_POST['dob'])){
			$dob = $mysqli->real_escape_string($_POST['dob']);
		}else{
			$dob = "";
		}
		$query = "INSERT INTO tbl_user(first_name, last_name, email, password, street, city, state, country, zip, phone, gender, date_reg, dob) VALUES ('{$fname}', '{$lname}', '{$email}', '{$pass}', '{$street}', '{$city}', '{$state}', '{$country}', '{$zip}', '{$phone}', '{$gender}', NOW(), '{$dob}')";
		if($mysqli->query($query)){
			$user_id = $mysqli->insert_id;
			error_log("Inserted {$email} as ID {$user_id}");
			return true;
		}else{
			error_log("Problem inserting {$query}");
			return false;
		}
	}//End of registerUser function
?>