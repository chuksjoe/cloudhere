<?php
	require_once("functions.inc");
	$user = new User();
?>
<!doctype html>
<html>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "css/general.css" />
		<link rel="stylesheet" type="text/css" href="css/register.css">
		<link rel="stylesheet" type="text/css" href="css/index.css">
		<link rel="stylesheet" type="text/css" href="css/about.css">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="HandheldFriendly" content="true">
		<title>CloudHere - About our Project</title>
		<style type = "text/css">
			
		</style>
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
						<?php
							if($user->isLoggedIn){
								echo "<li><a href = 'welcomePage.php'>My space</a></li>";
								echo "<li id = 'aboutUs-a'><a href = 'aboutUs.php'>About Us</a></li>";
								echo "<li id = 'aboutPro-a'><a href = 'aboutOurPro.php'>About Our Project</a></li>";
							}else{
								echo "<li id = 'about-a'><a href = 'about.php'>About</a></li>";
								echo "<li id = 'aboutUs-a'><a href = 'aboutUs.php'>About Us</a></li>";
								echo "<li id = 'aboutPro-a'><a href = 'aboutOurPro.php'>About Our Project</a></li>";
								echo "<li id = 'signUp-a'><a href = 'register.php'>Sign Up</a></li>";
								echo "<li id = 'signIn-a'><a href = 'signIn.php'>Sign In</a></li>";
							}
						?>
					</ul>
				</div>
			</div>
		</div>
		<div class = "container" id ="">
			<h1>About Our Project</h1>
			<table class = "innerContainer">
				<tr>
					<td class = "picture">
						<img src = "images/cloudComp.jpg" alt = "Cloud computing"/>
					</td>
					<td class = "details">
						<p>Our AUTOMATED VIRTUAL STORAGE SYSTEM which is fired up by Cloud Computing makes it possible for our users to store up the files from any device of their choice that supports a browser and retrieve them from anywhere in the world that has internet coverage. </p>
					</td>
				</tr>
				
			</table>
			<div class = "innerContainer">
				<h2>AIMS AND OBJECTIVES</h2>
				<p>The major aim of this study is to eliminate the problems associated with local storage systems, thereby producing an automated virtual storage system using cloud computing that will grant us seamless access to our files from any location, with any readily available device, by any authorized persons and also take full advantages of cloud storage.</p>
				<p>The objective of this project is to design and develop an automated virtual storage system that:</p>
				<ol>
					<li>Enables the users to backup their files to the cloud</li>
					<li>Enables easy retrieval of these backed up files from any location</li>
					<li>Enables sharing of files</li>
					<li>Guarantee good security of files</li>
					<li>Will enable easy access to the files from any device</li>
				</ol>
				<h2>PURPOSE OF THE PROJECT</h2>
				<p>This project work is for the partial fulfilment for our Higher National Diploma (HND) in Yaba College of Technology, Yaba Lagos. </p>
			</div>
		</div><!--End of container Div -->
	</body>
</html>