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
		<title>Welcome Page</title>
		<script type="text/javascript" src="javascript/jquery.js"></script>
		<link href = "css/general.css" rel = "stylesheet" type = "text/css"/>
		<link rel = "stylesheet" type = "text/css" href = "css/userSpace.css"/>
		
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
						<li><a href = "">Upgrade</a></li>
						<li id = "about-a"><a href = "about.php">About</a></li>
						<li><a href = "upload.php">Upload files</a></li>
						<li><a href = "logout.php">Logout</a></li>
					</ul>
				</div>
				<div class = "thead">
					<table>
						<thead>
							<tr class = "theader">
								<td class = "fname">File Name</td><td class = "fsize">Size</td><td class = "fupload">Upload Date</td><td class = "download">Download</td><td class = "del">Delete</td>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
		<div class = "container">
		<!--
		<div id="msgDiv">
			<?php
				if(isset($_SESSION['msg'])){
					print "<i>Update:</i><br/>";
					print $_SESSION['msg']."<br/>";
				}		
			?>
		</div>
		-->
			<table>
				<tbody oncontextMenu="return false">
				<?php
					$query = "SELECT file_id, file_name, size, url, upload_date FROM tbl_user_upload WHERE user_id = '{$user->user_id}' ORDER BY upload_date DESC";
					if(!$result = $mysqli->query($query)){
						error_log("Cannot retrieve the content of the table");
						return false;
					}
					$total = 0;
					$acc = 0;
					while($rows = $result->fetch_assoc()){
						$size = $rows['size']/1024;
						$fileN = $rows['file_name'];
						$url = $rows['url'];
						$file_id = $rows['file_id'];
						?>
						<tr onmousedown= "HideMenu('fileMenu');" onmouseup= "HideMenu('fileMenu');"
						oncontextMenu = "ShowMenu('fileMenu',event);" class = "detailItem" id = "<?php echo $rows['file_id']; ?>" >
							<td class = "fname"><?php echo $fileN ?></td>
							<td class = "fsize"><?php echo number_format($size, 2) ?>kb</td>
							<td class = "fupload"><?php echo $rows['upload_date'] ?></td>
							<td class = "download"><a href = "download.php?fileId=<?php echo $file_id;?>">Download</a></td>
							<td class = "del"><label  id = "del" class = "del-btn" onclick = "deleteItem(<?php echo $file_id;?>, '<?php echo $fileN ?>');">Delete</label></td>
						</tr>
						<?php
						$total += $size;
						$acc += 1;
					}
				?>
				</tbody>
				<tfoot>
				<?php
					$total /= 1024;
					
					echo "<tr><td colspan ='1'>Total number of files: ".$acc."</td><td colspan ='4'>Used Storage: ".number_format($total, 2)."mb/3000mb </td></tr>";
					$_SESSION['total_file_size'] = $total;
					
					$query = "UPDATE tbl_user SET total_storage_used = '{$total}', total_num_of_files = '{$acc}' WHERE user_id = '{$user->user_id}'";
					if(!$mysqli->query($query)){
						error_log("Update of total storage used and total number of files for ".$user->user_id." failed.");
						return false;
					}
				?>
				</tfoot>
			</table>
		</div><!--End of Container div-->
		<!--context menu for right click on the file rows --> 
		<div id = "fileMenu">
			<div class = "contextItem">
				<a id = "download" href = "" class = "contextA">Download</a>
			</div>
			<div class = "contextItem">
				<a id = "delete" href = "" class = "contextA">Delete</a>
			</div>
			<div class = "contextItem">
				<a href = "" class = "contextA">Rename</a>
			</div>
		</div>
		<!--Delete Dialog Box -->
		<div id = "deleteDialog" class = "hide-del-dialog">
			<p id = "del-msg"></p>
			<a id = "yes" class = "del-btn" href = "">Yes</a>
			<label id = "no" class = "del-btn" onclick = "no();">No</label>
		</div>
		<div id = "overlay" class = "hide-del-dialog"></div>
		<script language="javascript" type="text/javascript">
		$(document).ready( function(){
			//alert("am ready");
			/*$("#del").click(function() {
				$("#overlay").fadeTo(200, 1);
			});
			$(".del-btn").click(function() {
				$("#overlay").fadeOut(200);
			});*/
		});
		//to show the delete dialog box and make it interact with the users files
		function deleteItem(fileId, fileN){
			//alert(fileN);
			var newHref = "delete.php?fileId=" + fileId
			$("#del-msg").text("Do you really want to delete \"" + fileN + "\" ?");
			$("#yes").attr("href", newHref);
			showDialog();
		}
		function showDialog(){
			$("#overlay").addClass("show-del-dialog");
			$("#deleteDialog").addClass("show-del-dialog");
			
			$("#deleteDialog").removeClass("hide-del-dialog");
		}
		function no(){
			$("#deleteDialog").removeClass("show-del-dialog");
			$("#overlay").removeClass("show-del-dialog");
			$("#deleteDialog").addClass("hide-del-dialog");
			$("#del-msg").val("");
			$("#yes").attr("href", "");
		}
		
		//for the dropdown menu for a rightclick event on the users files... (Not yet functional)
        function ShowMenu(control, e) {
			alert($("#yes").attr("id"));
            var posx = e.clientX +window.pageXOffset +'px'; //Left Position of Mouse Pointer
            var posy = e.clientY + window.pageYOffset + 'px'; //Top Position of Mouse Pointer
            document.getElementById(control).style.position = 'absolute';
            document.getElementById(control).style.display = 'inline';
            document.getElementById(control).style.left = posx;
            document.getElementById(control).style.top = posy;
			
			addHrefForDownload();
			
        }
        function HideMenu(control) {
			
            document.getElementById(control).style.display = 'none';
			var id = String($(this).attr("id"));
			var newHref = "download.php?fileId =" + id;
			$("#download").attr("href", "newHref");
        }
		function confirmDelete(){
			var retVal = confirm("You are about Deleting a from your database,\nDo you want to continue?");
			if( retVal == true ){
				return true;
			}else{
				return false;
			}
		}
        function addHrefForDownload(){
        	var id = String($(this).attr("id"));
			var newHref = "download.php?fileId =" + id;
			$("#download").attr("href", "newHref");
        }
		</script>
	</body>
</html>