<?php
	require_once("functions.inc");
	$user = new User();
	
	if(!$user->isLoggedIn){
		die(header("Location: signIn.php"));
	}
	$lastLogin = (string)$user->dateLastLogin;
	
?>
<html>
	<head>
		<title>CloudHere - Upload Files</title>
		<link rel = "stylesheet" type = "text/css" href = "css/general.css" />
		<link rel = "stylesheet" type = "text/css" href = "css/userSpace.css" />
		
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
	</head>
	<body>
		<div class = "header" id = "">
			<div class = "insideHeader">
				<div class = "logo">
					<a href = "index.php">
						<img id = "siteLogo" src = "images/chLogo.png" alt = "Cloud here Logo"></a>
				</div>
				<div class = "headerAnchors">
					<div class = "userinfo">
						<h2><?php echo $_SESSION['firstname'];?>'s space</h2>
							<a href = "profile.php">(profile)</a>
						<p>Last online: <?php echo $lastLogin;?></p>
					</div>
					<ul class = "rightAnchors">
						<li id = "about-a"><a href = "about.php">About</a></li>
						<li><a href = "welcomePage.php">My Space</a></li>
						<!--<li><a href = "">Setting</a></li>-->
						<li><a href = "logout.php">Logout</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class = "container">
			<h1>Upload Your Files</h1>
			<p>Select one or more that you want to upload to your cloud space:</p>
<?php
	if(isset($_POST['submit'])){
		
		if(count($_FILES['upload']['name']) > 0){
			$ext_str = array("gif","jpg","jpeg","mp3","tiff","bmp","doc","docx","ppt","pptx","txt","pdf","xls","mpp","zip");
			
			$max_file_size = 10485760;//10 mb remember 1024bytes =1kbytes /* check allowed extensions here */
			$size = $max_file_size/1024/1024;
			$uploadMsg = array();
			//Loop through each file
			for($i=0; $i<count($_FILES['upload']['name']); $i++) {
				$chk_size = ($_FILES['upload']['size'][$i])/1024/1024;
				if(($_SESSION['total_file_size']+ $chk_size) >= 3000){
					$uploadMsg[] = "<li>You have exceeded your maximum allocated space!</li>";
					break;
				}
				$tmpFilePath = $_FILES['upload']['tmp_name'][$i];
				//Make sure we have a filepath
				if($tmpFilePath != ""){
					//save the filename
					$filename = $_FILES['upload']['name'][$i];
				
					//Check the file extension and size
					/*$ext = substr($filename, strrpos($filename, '.') + 1); //get file extension from last sub string from last . 	character
					if (!in_array($ext, $ext_str) ) {
						$uploadMsg[] = "<li class ='error'>".$filename." is not uploaded!: file type, (.".$ext.") is not supported.</li>"; // exit the script by warning
						continue;
					} */
					/* check file size of the file if it exceeds the specified size warn user */
					if($_FILES['upload']['size'][$i]>=$max_file_size){
						$uploadMsg[] = "<li class ='error'>".$filename." is not uploaded!: only file less than ".$size."mb  is allowed to upload.</li>"; // exit the script by warning
						continue;
					}
					//save the url and the file
					$filePath = "../../usersUpload/" . date('Ymd_His').'_'.$user->user_id.'_'.$_FILES['upload']['name'][$i];

					//Upload the file from the temp dir into the upload dir
					if(move_uploaded_file($tmpFilePath, $filePath)) {
						$uploadMsg[] = "<li class ='success'>".$filename." uploaded Successfully!</li>";
						$type = $_FILES['upload']['type'][$i];
						$size = $_FILES['upload']['size'][$i];
						
						$query = "INSERT into tbl_user_upload (user_id, file_name, url, size, type, upload_date) VALUES('{$user->user_id}', '{$filename}', '{$filePath}', '{$size}', '{$type}', NOW())";
						if($mysqli->query($query)){
							$file_id = $mysqli->insert_id;
							error_log("User:".$_SESSION['user_id']." has uploaded {$filename} with File-ID:{$file_id}");
							//return true;
						}else{
							error_log("Problem inserting {$query}");
							return false;
						}
					}
				}
			}
		}
		//show success/error messages
		echo "<h2>Uploaded:</h2>";    
		if(is_array($uploadMsg)){
			echo "<ul>";
			foreach($uploadMsg as $msg){
				echo $msg;
			}
			echo "</ul>";
		}
	}
?>
			<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype  ="multipart/form-data" method = "post">
				<div>
					<label for = 'upload'>Add Attachments:</label>
					<input id = "upload" name = "upload[]" type = "file" multiple = "multiple" />
				</div>

				<p><input type = "submit" name = "submit" value = "Upload"></p>

			</form>
		</div>
	</body>
</html>