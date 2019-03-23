<?php
	require_once("functions.inc");
	$user = new User();
	//$user->logout();
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="javascript/jquery.js"></script>
		<script type="text/javascript" src="javascript/login.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/index.css">
		
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<title>CloudHere - Sign In</title>
	</head>
	<body>
		<div class = " header signinHeader">
			<div class = "insideHeader">
				<div class = "logo">
					<a href = "index.php">
						<img id = "siteLogo" src = "images/chLogo.png" alt = "Cloud here Logo"></a>
				</div>
				<div class = "headerAnchors">
					<ul class = "rightAnchors">
						<li><a href = "register.php">Sign Up</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class = "container signinContainer">
			<h1 style = "text-align: center">Sign in</h1>
			<div class = "containerLogin signin">
				<form id="loginForm" method="POST" action="login-process.php">
					<div class = "loginDetails">
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
							<div class="errorFeedback errorSpan" id="emailError">E-mail is required</div>
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
	</body>
</html>