<?php
	require_once("functions.inc");
		
	$user = new User();
	
	if(!$user->isLoggedIn){
		die(header("Location: signIn.php"));
	}
	
	if(isset($_SESSION['msg'])){
		unset($_SESSION['msg']);
	}
	
	$fileId = $_REQUEST['fileId'];
	
	$query = "SELECT file_name, url FROM tbl_user_upload WHERE file_id = '{$fileId}'";
	if(!$result = $mysqli->query($query)){
		error_log("Cannot retrieve the content of the table");
		return false;
	}
	$rows = $result->fetch_assoc();
	
	//Set the time out
	set_time_limit(0);
	
	
	//Delete the file details from the database and from the folder
	$query = "DELETE FROM tbl_user_upload where file_id = '{$fileId}'";
	if(!$result = $mysqli->query($query)){
		error_log("Cannot Delete the content of the table");
		return false;
	}else{
		unlink($rows['url']);
		error_log("User with ID: ".$user->user_id." has deleted the file: ".$rows['file_name']." with ID: ".$fileId);
		$_SESSION['msg'] = $rows['file_name']." is deleted Successfully.";
		die(header("Location: welcomePage.php"));
		
	}
	
?>