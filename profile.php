<?php
	require_once("functions.inc");
	$user = new User();
	
	if(!$user->isLoggedIn){
		die(header("Location: signIn.php"));
	}
	$lastLogin = (string)$user->dateLastLogin;
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="javascript/jquery.js"></script>
		<script type="text/javascript" src="javascript/register.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "css/general.css"/>
		<link rel="stylesheet" type="text/css" href="css/register.css"/>
		<link rel="stylesheet" type="text/css" href="css/profile.css"/>
		
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title><?php echo $_SESSION['firstname'];?>'s profile</title>
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
						
						<li><a href = "upload.php">Upload files</a></li>
						<li><a href = "welcomePage.php">My space</a></li>
						<li><a href = "logout.php">Logout</a></li>
					</ul>
				</div>
				
			</div>
		</div>
		<div id = "" class = "container">
			<!--<img src = "images/sunnyCloud.png" alt = "Sunny cloud" width = "500px"/>-->
			<h1>My Profile</h1>
			<div class = "insideContainer">
		
				<form id="userForm" method="POST" action="userDetailsUpdate.php">
					<div class = "form-content">
						<div id="errorDiv">
						<?php
							if(isset($_SESSION['error'])&& isset($_SESSION['formAttempt'])){
								unset($_SESSION['formAttempt']);
								print "<i>Errors encountered:</i><br/>";
								foreach($_SESSION['error'] as $error){
									print $error."<br/>";
								}
							}
							if(isset($_SESSION['success'])){
								foreach($_SESSION['success'] as $msg){
									print $msg."<br/>";
								}
							}
						?>
						</div>
						<div class = "input">
							<div class = "subInput">
								<label for="fname">First Name: </label><br/>
								<input class = "style-input inputs" type="text" id="fname" name="fname" value = "<?php echo $_SESSION['firstname'];?>">
							</div>
							<div class = "subInput">
								<label for="lname">Last Name: </label><br/>
								<input class = "style-input inputs" type="text" id="lname" name="lname" value = "<?php echo $_SESSION['lastname'];?>">
							</div>
						</div>
						<div class = "input">
							<label for="email">E-mail: </label><br/>
							<input class = "style-input inputs" type="email" id="email" name="email" value = "<?php echo $_SESSION['email'];?>">
						</div>
						<div class = "input">
							<div class = "subInput">
								<label for="city">Gender: </label><br/>
								<input class = "style-input inputs" type="text" name="gender" id="gender" value = "<?php echo $_SESSION['gender'];?>">
							</div>
							<div class = "subInput">
								<label for="state">Date of Birth: </label><br/>
								<input class = "style-input inputs" type = "text" id="dob" name="dob" value = "<?php echo $_SESSION['dob'];?>"/>
							</div>
						</div>
						
						<div class = "input">
							<label for="street">Street: </label><br/>
							<input class = "style-input editable inputs edit" type="text" id="street" name="street" value = "<?php echo $_SESSION['street'];?>">
						</div>
						<div class = "input">
							<div class = "subInput">
								<label for="city">City: </label><br/>
								<input class = "style-input editable inputs edit" type="text" id="city" name="city" value = "<?php echo $_SESSION['city'];?>">
							</div>
							<div class = "subInput">
								<label for="state">State: </label><br/>
								<input class = "style-input editable inputs edit" type = "text" id = "state" name = "state" value = "<?php echo $_SESSION['state'];?>"/>
							</div>
						</div>
						<div class = "input">
							<div class = "subInput">
								<label for="country">Country: </label><br/>
								<input class = "style-input editable inputs edit" type = "text" id = "country" name = "country" value = "<?php echo $_SESSION['country'];?>"/>
							</div>
							<div class = "subInput">
								<label for="zip">ZIP code: </label><br/>
								<input class = "style-input editable inputs edit" type="text" id="zip" name="zip" value = "<?php echo $_SESSION['zip'];?>">
							</div>
						</div>
						<div class = "input">
							<label for="phone">Telephone Number: </label><br/>
							<input class = "style-input editable inputs edit" type="text" id="phone" name="phone" value = "<?php echo $_SESSION['phone'];?>">
							<div class="errorFeedback errorSpan" id="phoneError">Phone number should be at least 10 digits</div>
						</div>
						<div class = "edit-button-container">
							<label class = "edit-button">Edit</label>
						</div>
						<input type="submit" id="submit" name="submit" value = "Save">
						
					</div>
				</form>
			</div><!--end of class insideContainer-->
		</div>
		<script type = "text/javascript">
			$(document).ready( function(){
				$(".inputs").attr("disabled","disabled");
				$("input[type = 'submit']").hide();
				
				$(".edit-button").click( function(e){
					$(".editable").attr("disabled",false);
					$(this).hide();
					$("input[type = 'submit']").show();
				});
			});
		</script>
	</body>
</html>