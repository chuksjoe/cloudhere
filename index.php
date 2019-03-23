<?php
	require_once("functions.inc");
	$user = new User();
	$user->logout();
?>
<!doctype html>
<html>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="HandheldFriendly" content="true">
		<title>Cloud Here</title>
	</head>
	<body>
		<div class = "header" id = "">
			<div class = "insideHeader">
				<div class = "logo">
					<a href = "index.php">
						<img id = "siteLogo" src = "images/chLogo.png" alt = "Cloud here Logo"></a>
				</div>
				<div class = "headerAnchors">
					
					<ul class = "rightAnchors">
						<li id = "about-a"><a href = "about.php">About</a></li>
						<li id = "aboutUs-a"><a href = "aboutUs.php">About Us</a></li>
						<li id = "aboutPro-a"><a href = "aboutOurPro.php">About Our Project</a></li>
						<li id = "signUp-a"><a href = "register.php">Sign Up</a></li>
						<li id = "signIn-a"><a href = "signIn.php">Sign In</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class = "container" id ="">
			<div class = "containerLeft">
				<p>
					<b>CloudHere</b> where we do our best to give you the best in terms of file access flexibility, file storage and optimized security at no cost.<br>Also access your cloud space from any device of your choice.
					<!--<img src = "images/cloudComp.jpg" alt = "cloud computing" />-->
				</p>
			</div>
			<div class = "containerLogin">
				<form id="loginForm" method="POST" action="login-process.php">
					<div class = "loginDetails">
						
						<p style = "text-align: center">Sign in</p>
						<div id="errorDiv">
						<?php
							if(isset($_SESSION['error'])&& isset($_SESSION['formAttempt'])){
								unset($_SESSION['formAttempt']);
								print "<i>Errors encountered:</i><br/>";
								foreach($_SESSION['error'] as $error){
									print $error."<br/>";
								}
							}
						?>
						</div>
						<div class = "input">
							<label for="email">E-mail:</label></br>
							<input type="email" id="email" name="email" autofocus = "">
							<div class="errorFeedback errorSpan" id="emailError">Valid E-mail is required</div>
						</div>
						<div class = "input">
							<label for="password1">Password:</label></br>
							<input type="password" id="password" name="password">
							<div class="errorFeedback errorSpan" id="passwordError">Password required</div>
						</div>
						<div class = "input">	
							<a href = "">Forget Password?</a>
							<input type="submit" id="submit" name="submit" value = "Sign in">
						</div>
						<div class = "register">
							<p> If you are new, <a href = "register.php" style = "color: blue">click here</a> to Sign Up</p>
						</div>
					</div>
				</form>
			</div>
		</div><!--End of container Div -->
		<script type="text/javascript" src="javascript/jquery.js"></script>
		<script type="text/javascript" src="javascript/login.js"></script>
	</body>
</html>