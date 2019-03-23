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
		<title>CloudHere - About Us</title>
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
			<h1>About Us</h1>
			<table class = "innerContainer">
				<tr>
					<td class = "picture">
						<img src = "images/chuks.jpg" alt = "Orjiakor Chuks"/>
					</td>
					<td class = "details">
						<p><b>Name: </b>Orjiakor Chukwunonso Joseph</p>
						<p><b>Matric No.: </b>P/HD/14/3210003</p>
						<p><b>E-mail: </b><a href = "mailto:chuksjoe@live.com">Chuksjoe at live dot com</a></p>
						<p><b>Phone No.: </b>+234-8131-1726-17</p>
					</td>
				</tr>
				<tr>
					<td class = "picture">
						<img src = "images/collins.jpg" alt = "Opara Collins"/>
					</td>
					<td class = "details">
						<p><b>Name: </b>Opara Chukwuemeka Collins</p>
						<p><b>Matric No.: </b>P/HD/14/3210012</p>
						<p><b>E-mail: </b><a href = "mailto:chuksjoe@live.com">collinsneolife@gmail.com</a></p>
						<p><b>Phone No.: </b>+234-7030-5566-79</p>
					</td>
				</tr>
				<tr>
					<td class = "picture">
						<img src = "images/bola.jpg" alt = "Salami Adebola"/>
					</td>
					<td class = "details">
						<p><b>Name: </b>Salami Adebola O.</p>
						<p><b>Matric No.: </b>P/HD/14/3210031</p>
						<p><b>E-mail: </b><a href = "mailto:chuksjoe@live.com">salamiadebola@yahoo.com</a></p>
						<p><b>Phone No.: </b>+234-8180-0589-35</p>
					</td>
				</tr>
				<tr>
					<td class = "picture">
						<img src = "images/vicky.jpg" alt = "Okonkwo Vicky"/>
					</td>
					<td class = "details">
						<p><b>Name: </b>Okonkwo Victoria Nneka</p>
						<p><b>Matric No.: </b>P/HD/14/3210049</p>
						<p><b>E-mail: </b><a href = "mailto:chuksjoe@live.com">okonkwovictoria13@gmail.com</a></p>
						<p><b>Phone No.: </b>+234-7062-3469-63</p>
					</td>
				</tr>
				<tr>
					<td colspan = "2">
						<p>Many thanks to our supervisor Mr. Aigbokhan Edwin E. for his guidience and directions in the course of our project work and for his fatherly affection towards us. Without his pivotal role, our work wouldn't have been this successful.</p>
					</td>
				</tr>
			</table>
		</div><!--End of container Div -->
	</body>
</html>