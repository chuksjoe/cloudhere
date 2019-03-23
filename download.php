<?php
	require_once("functions.inc");
		
	$user = new User();
	
	if(!$user->isLoggedIn){
		die(header("Location: signIn.php"));
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

	//Call the download function with file path,file name and file type
	download_file($rows['url'], ''.$rows['file_name'].'', 'text/plain');
?>