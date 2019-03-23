<?php
	require_once("functions.inc");
?>
<!doctype html>
<html>
	<head>
		<script type="text/javascript" src="javascript/jquery.js"></script>
		<script type="text/javascript" src="javascript/register.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/register.css" />
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<title>Register new account</title>
	</head>
	<body>
		<div id = "" class = "header">
			<div class = "insideHeader">
				<div class = "logo">
					<a href = "index.php">
						<img id = "siteLogo" src = "images/chLogo.png" alt = "Cloud here Logo"></a>
				</div>
				<div class = "headerAnchors">
					
					<ul class = "rightAnchors">
						<li><a href = "signIn.php">Sign In</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div id = "" class = "container">
			<h1>Sign Up</h1>
			<div class = "insideContainer">
		
				<form id="userForm" method="POST" action="register-process.php">
					<div>
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
							<div class = "subInput">
								<label for="fname">First Name:* </label><br/>
								<input type="text" id="fname" name="fname" autofocus = "">
								<div class="errorFeedback errorSpan" id="fnameError">First name is required</div>
							</div>
							<div class = "subInput">
								<label for="lname">Last Name:* </label><br/>
								<input type="text" id="lname" name="lname">
								<div class="errorFeedback errorSpan" id="lnameError">Last name is required</div>
							</div>
						</div>
						<div class = "input">
							<label for="email">E-mail:* </label><br/>
							<input type="email" id="email" name="email">
							<div class="errorFeedback errorSpan" id="emailError">E-mail is required</div>
						</div>
						<div class = "input">
							<label for="password1">Password:* </label><br/>
							<input type="password" id="password1" name="password1">
							<div class="errorFeedback errorSpan" id="password1Error">Password required</div>
						</div>
						<div class = "input">
							<label class = "label" for="password2">Verify Password:* </label><br/>
							<input type="password" id="password2" name="password2">
							<div class="errorFeedback errorSpan" id="password2Error">Passwords don't match</div>
							<div class="errorFeedback errorSpan" id="password22Error">Verify password required</div>
						</div>
						<div class = "input">
							<div class = "subInput">
								<label for="gender">Gender*: </label><br/>
								<select name="gender" id="gender">
									<option></option>
									<option>Male</option>
									<option>Female</option>	
								</select>
								<div class="errorFeedback errorSpan" id="genderError">Gender is required</div>
							</div>
							<div class = "subInput">
								<label for="dob">Date of Birth(yyyy-mm-dd)*: </label><br/>
								<input type="date" id="dob" name="dob" placeholder = "yyyy-mm-dd">
								<div class="errorFeedback errorSpan" id="dobError">Date of birth is required</div>
							</div>
						</div>
						<div class = "input">
							<label for="street">Street: </label><br/>
							<input type="text" id="street" name="street">
						</div>
						<div class = "input">
							<div class = "subInput">
								<label for="city">City: </label><br/>
								<input type="text" id="city" name="city">
							</div>
							<div class = "subInput">
								<label for="state">State: </label><br/>
								<input type = "text" id = "state" name = "state" />
							</div>
						</div>
						<div class = "input">
							<div class = "subInput">
								<label for="country">Country: </label><br/>
								<input type = "text" id = "country" name = "country" />
							</div>
							<div class = "subInput">
								<label for="zip">ZIP code: </label><br/>
								<input type="text" id="zip" name="zip">
							</div>
						</div>
						<div class = "input">
							<label for="phone">Telephone Number: </label><br/>
							<input type="text" id="phone" name="phone">
							<div class="errorFeedback errorSpan" id="phoneError">Phone number should be at least 10 digits</div>
						</div>
						
						<p class = "note">Note: The feilds with astherisk(*) are <b>compulsory</b>.</p>
						<input type="submit" id="submit" name="submit" value = "Sign up for Cloudhere">
						<p class = "note">By clicking <b>"Sign up for Cloudhere"</b>, you agree to our terms of service and privacy policy.</p>
					</div>
				</form>
			</div><!--end of class insideContainer-->
		</div>
	</body>
</html>