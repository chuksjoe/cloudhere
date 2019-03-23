<?php
	require_once("functions.inc");
	$user = new User();
	
	if(!$user->isLoggedIn){
		die(header("Location: signIn.php"));
	}
	//error_reporting(E_ALL & ~E_NOTICE);
	
	//this prevents access to this script if the form has not been submitted by the user
	if(!isset($_POST['submit'])){
		die(header("Location: profile.php"));
	}
	
	$_SESSION['formAttempt'] = true;
	//unset the previous error and success messages
	if(isset($_SESSION['error'])){
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['success'])){
		unset($_SESSION['success']);
	}
	//Session Array to store possible errors while updating user's record
	$_SESSION['error'] = array();
	
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
	//checking for the ZIP code status
	$zip = $_POST['zip'];
	if(isset($_POST['zip']) && $zip != ""){
		if(!preg_match('/^[\d]+$/', $zip)){
			$_SESSION['error'][] = "ZIP should be digits only.";
		}else if(strlen($zip) < 5 || strlen($zip) > 9){
			$_SESSION['error'][] = "ZIP code should be between 5 and 9 digits.";
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
		die(header("Location: profile.php"));
	}else{
		if(userDetailsUpdate($_POST)){
			$_SESSION['success'][] = "<p class = 'success'>You have successfully updated your profile.</p>";
			unset($_SESSION['formAttempt']);
			
			$user->updateUserDetails();
			die(header("Location: profile.php"));
		}else{
			error_log("Error Updating user: {$_POST['email']} profile");
			$_SESSION['error'][] = "Problem updating your profile.";
			die(header("Location: register.php"));
		}
	}
	
	//Update function
	function userDetailsUpdate($userData){
		$mysqli = new mysqli(SERVER, DBUSER, DBPASS, DATABASE);
		if($mysqli->connect_errno){
			error_log("Cannot connect to MYSQL: ".$mysqli->connect_error);
			return false;
		}
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
		//SQL Query to Update the edited fields
		$query = "UPDATE tbl_user SET street = '{$street}', city = '{$city}', state = '{$state}', country = '{$country}', zip = '{$zip}', phone = '{$phone}' WHERE email = '{$_SESSION['email']}'";
		if($mysqli->query($query)){
			$sex = ($_SESSION['gender'] == "Male") ? "his" : "her";
			error_log("{$_SESSION['user_id']} has updated some of {$sex} details successfully");
			return true;
		}else{
			error_log("Problem updating {$query}");
			return false;
		}
	}//End of registerUser function
?>