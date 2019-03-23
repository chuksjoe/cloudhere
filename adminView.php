<?php
	require_once("functions.inc");
	require_once("fusioncharts.php");
	
	if(!$_SESSION['adminLogin']){
		die(header("Location: signIn.php"));
	}
?>
<html>
	<head>
		<title>CloudHere Admin View</title>
		<link href = "css/general.css" rel = "stylesheet" type = "text/css"/>
		<link rel = "stylesheet" type = "text/css" href = "css/adminSpace.css"/>
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<script src="javascript/jquery-2.1.4.js"></script>
		<script src="javascript/fusioncharts.js"></script>
		<script src="javascript/fusioncharts.charts.js"></script>
		<script src="javascript/themes/fusionchartstheme.zune.js"></script>

	</head>
	<body>
		<div class = "header" id = "">
			<div class = "insideHeader">
				<div class = "logo">
					<a href = "index.php">
						<img id = "siteLogo" src = "images/chLogo.png" alt = "Cloud here Logo"></a>
				</div>
				<div id = "filter-div" class = "hidden">
					<form method = "post" action = "" id = "filter">
						<p>Select Date Range:</p>
						<label for = "from">From:</label>
						<input type = "text" name = "from" id = "from">
						<label for = "to">To:</label>
						<input type = "text" name = "to" id = "to">
						<input type = "submit" value = "filter" name = "filter">
					</form>
				</div>
				<div class = "headerAnchors">
					<div class = "userinfo">
						<h2>Admin's space</h2>
					</div>
					<ul class = "rightAnchors">
						<li id = "about-a"><a href = "about.php">About</a></li>
						<li><a href = "logout.php">Logout</a></li>
					</ul>
				</div>
				
			</div>
		</div>
		<nav>
			<div class = "btn-container">
				<label id = "users-list-btn" onClick = "usersList();">List of Users</label>
				<label id = "upload-analysis-btn" onClick = "uploadAnalysis();">Analysis of all Uploads</label>
			</div>
		</nav>
		<div class = "container">
		<div id = "users-list" class = "">
			<table>
				<thead>
					<tr>
						<th>User Id</th><th>User Full Name</th><th>Location</th><th>Date Registered</th>
						<th>Date Last Online</th><th>Total Storage Used</th><th>Total Number of files</th>
					</tr>
				</thead>
				<tbody>
					
				<?php
					$query = "SELECT user_id, first_name, last_name, state, country, date_reg, date_last_online, total_storage_used, total_num_of_files FROM tbl_user";
					if(!$result = $mysqli->query($query)){
						error_log("Cannot retrieve the content of the table");
						return false;
					}else{
						$total = 0;
						$acc = 0;
						while($rows = $result->fetch_assoc()){
							$user_id = $rows['user_id'];
							$full_n = $rows['first_name']." ".$rows['last_name'];
							$location = $rows['state']." ".$rows['country'];
							$d_reg = $rows['date_reg'];
							$d_l_o = $rows['date_last_online'];
							$t_s_u = $rows['total_storage_used'];
							$t_n_o_f = $rows['total_num_of_files'];
							?>
								<tr class = "userDetails" >
									<td class = "user-id"><?php echo $user_id; ?></td>
									<td class = "full-name" onClick=window.open("userAnalysis.php?user_id=<?php echo $user_id; ?>&fname=<?php echo $rows['first_name']; ?>","Testing","width=935,height=500,left=100,top=100,toolbar=0,resizable=0,location=no,status=0,scrollbars=1");><?php echo $full_n; ?></td>
									<td class = "location"><?php echo $location; ?></td>
									<td class = "date-reg"><?php echo $d_reg; ?></td>
									<td class = "date-l-o"><?php echo $d_l_o; ?></td>
									<td class = "t-s-u"><?php echo $t_s_u;?>mb</td>
									<td class = "t-n-o-f"><?php echo $t_n_o_f;?></td>
								</tr>
							<?php
							$total += $t_s_u;
							$acc += 1;
						}
					}
				?>
				</tbody>
				<tfoot>
				<?php
					echo "<tr><td colspan ='3'>Total number of Users: ".$acc."</td><td colspan ='4'>Total Storage Used: ".number_format($total, 2)."mb</td></tr>";
				?>
				</tfoot>
			</table>
			<?php
				$query = "SELECT * FROM tbl_user";
				$result = $mysqli->query($query);

				/* `$arrData` is the associative array that is initialized to store the chart attributes. */
				$arrData = array(
					"chart" => array(
						"caption"=> "Chart for Total Storage used by the Users",
						"subCaption"=> "",
						"xAxisName"=> "Users (Users ID)",
                		"yAxisName"=> "Total storage used (MB)",
						"enableSmartLabels"=> "1",
						"showPercentValues"=> "1",
						"showLegend"=> "1",
						"decimals"=> "1",
						"theme"=> "zune"
					)
				);

				//check if there is any data returned by the SQL Query
				if ($result->num_rows > 0) {
					$arrData['data'] = array();
            
					//Converting the results into an associative array
					while($row = $result->fetch_assoc()) {
						array_push($arrData['data'],
							array(
								'label' => $row['user_id'],
								'value' => $row['total_storage_used']
							)
						);
					}
				}
				//Closing the connection to DB
				//$mysqli->close();            

				//JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
				$jsonEncodedData = json_encode($arrData);
				//echo $jsonEncodedData;
            
				$chart1 = new FusionCharts("column2D", "totalStorage" , 1050, 500, "storage-used", "json", $jsonEncodedData);
				// Render the chart
				$chart1->render();
        	?>
			<div id = "storage-used">Chart for Users Storage Usage</div>
			
			<?php
				$query = "SELECT * FROM tbl_user";
				$result = $mysqli->query($query);

				/* `$arrData` is the associative array that is initialized to store the chart attributes. */
				$arrData = array(
					"chart" => array(
						"caption"=> "Chart for Total number of uploaded files by users",
						"subCaption"=> "",
						"xAxisName"=> "Users (Users First Name)",
                		"yAxisName"=> "Total number of files uploaded",
						"enableSmartLabels"=> "0",
						"showPercentValues"=> "1",
						"showLegend"=> "1",
						"decimals"=> "1",
						"theme"=> "zune"
					)
				);

				//check if there is any data returned by the SQL Query
				if ($result->num_rows > 0) {
					$arrData['data'] = array();
            
					//Converting the results into an associative array
					while($row = $result->fetch_assoc()) {
						array_push($arrData['data'],
							array(
								'label' => $row['first_name'],
								'value' => $row['total_num_of_files']
							)
						);
					}
				}
				//Closing the connection to DB
				//$mysqli->close();            

				//JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
				$jsonEncodedData = json_encode($arrData);
				//echo $jsonEncodedData;
            
				$chart2 = new FusionCharts("column2D", "totalNumFiles" , 1050, 500, "total-num-of-files", "json", $jsonEncodedData);
				// Render the chart
				$chart2->render();
        	?>
			<div id = "total-num-of-files">Chart for Total number of uploaded files by users</div>
		</div>
		<div id = "upload-analysis" class = "">
			<table>
				<thead>
					<tr>
						<th>Days</th><th>Upload Count</th><th>Storage Used</th>
					</tr>
				</thead>
				<tbody>
					
				<?php
					$query = "SELECT DATE_FORMAT(upload_date, '%Y-%m-%d') AS upload_date, COUNT(file_id) AS total_num_of_files, SUM(size) AS total_storage FROM tbl_user_upload GROUP BY DATE_FORMAT(upload_date, '%Y%m%d')";
					if(!$result = $mysqli->query($query)){
						error_log("Cannot retrieve the content of the table");
						return false;
					}else{
						$total = 0;
						$acc = 0;
						while($rows = $result->fetch_assoc()){
							$days = $rows['upload_date'];
							$file_count = $rows['total_num_of_files'];
							$t_s = $rows['total_storage']/1024/1024;
							?>
								<tr class = "" >
									<td class = "days"><?php echo $days; ?></td>
									<td class = "file_count"><?php echo $file_count; ?></td>
									<td class = "t-s"><?php echo $t_s;?>mb</td>
								</tr>
							<?php
							$total += $t_s;
							$acc += $file_count;
						}
					}
				?>
				</tbody>
				<tfoot>
				<?php
					echo "<tr><td colspan ='2'>Total Number of files Uploaded by all Users: ".$acc." </td><td colspan ='1'>Total Storage Used: ".number_format($total, 2)."mb</td></tr>";
				?>
				</tfoot>
			</table>
			<?php
				//$query = "SELECT * FROM tbl_user";
				//$query = "SELECT DATE_FORMAT(upload_date, '%Y-%m-%d') AS upload_date, COUNT(file_id) AS total_num_of_files, SUM(size) AS total_storage FROM tbl_user_upload GROUP BY DATE_FORMAT(upload_date, '%Y%m%d')";
					
				$result = $mysqli->query($query);

				/* `$arrData` is the associative array that is initialized to store the chart attributes. */
				$arrData = array(
					"chart" => array(
						"caption"=> "Chart for Total Storage used on Daily basis",
						"subCaption"=> "",
						"xAxisName"=> "Days",
                		"yAxisName"=> "Total storage used (MB)",
						"enableSmartLabels"=> "0",
						"showPercentValues"=> "1",
						"showLegend"=> "1",
						"decimals"=> "1",
						"theme"=> "zune"
					)
				);

				//check if there is any data returned by the SQL Query
				if ($result->num_rows > 0) {
					$arrData['data'] = array();
            
					//Converting the results into an associative array
					while($row = $result->fetch_assoc()) {
						array_push($arrData['data'],
							array(
								'label' => $row['upload_date'],
								'value' => $row['total_storage']
							)
						);
					}
				}
				//Closing the connection to DB
				//$mysqli->close();            

				//JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
				$jsonEncodedData = json_encode($arrData);
				//echo $jsonEncodedData;
            
				$chart3 = new FusionCharts("column2D", "dailyTotalStorage" , 1050, 500, "daily-storage-used", "json", $jsonEncodedData);
				// Render the chart
				$chart3->render();
        	?>
			<div id = "daily-storage-used">Chart for Storage Usage on Daily Basis</div>
			
			<?php
				//$query = "SELECT DATE_FORMAT(upload_date, '%Y-%m-%d') AS upload_date, COUNT(file_id) AS total_num_of_files, SUM(size) AS total_storage FROM tbl_user_upload GROUP BY DATE_FORMAT(upload_date, '%Y%m%d')";
					
				$result = $mysqli->query($query);

				/* `$arrData` is the associative array that is initialized to store the chart attributes. */
				$arrData = array(
					"chart" => array(
						"caption"=> "Chart for Total number of uploaded files on Daily Basis",
						"subCaption"=> "",
						"xAxisName"=> "Days",
                		"yAxisName"=> "Total number of files uploaded",
						"enableSmartLabels"=> "0",
						"showPercentValues"=> "1",
						"showLegend"=> "1",
						"decimals"=> "1",
						"theme"=> "zune"
					)
				);

				//check if there is any data returned by the SQL Query
				if ($result->num_rows > 0) {
					$arrData['data'] = array();
            
					//Converting the results into an associative array
					while($row = $result->fetch_assoc()) {
						array_push($arrData['data'],
							array(
								'label' => $row['upload_date'],
								'value' => $row['total_num_of_files']
							)
						);
					}
				}
				//Closing the connection to DB
				$mysqli->close();            

				//JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
				$jsonEncodedData = json_encode($arrData);
				//echo $jsonEncodedData;
            
				$chart4 = new FusionCharts("column2D", "totalNumFilesOnDailyBasis" , 1050, 500, "total-num-of-files-daily", "json", $jsonEncodedData);
				// Render the chart
				$chart4->render();
        	?>
			<div id = "total-num-of-files-daily">Chart for Total number of uploaded files on Daily basis</div>
		</div>
		</div><!--End of Container div-->
		
		<script language="javascript" type="text/javascript">
		$(document).ready( function(){
			//FusionCharts.options.SVGDefinitionURL = 'absolute';
		});
		
		function usersList(){
			$("#filter-div").removeClass("visible");
			$("#filter-div").addClass("hidden");
			$("#upload-analysis").removeClass("show-div");
			$("#upload-analysis").addClass("hide-div");
			$("#users-list").removeClass("hide-div");
			$("#users-list").addClass("show-div");
		}
		function uploadAnalysis(){
			$("#filter-div").removeClass("hidden");
			$("#filter-div").addClass("visible");
			$("#upload-analysis").removeClass("hide-div");
			$("#upload-analysis").addClass("show-div");
			$("#users-list").removeClass("show-div");
			$("#users-list").addClass("hide-div");
		}
		//to show the User Chart dialog box
		/*
		function userChart(fileId, fileN){
			//alert(fileN);
			//var newHref = "delete.php?fileId=" + fileId
			$("#user-info").text(fileN + " Usage Analysis");
			//$("#yes").attr("href", newHref);
			showDialog();
		}
		function showDialog(){
			//$("#overlay").addClass("show-del-dialog");
			$("#user-chart").addClass("show-div");
			
			$("#user-chart").removeClass("hide-div");
		}
		function no(){
			$("#user-chart").removeClass("show-del-dialog");
			//$("#overlay").removeClass("show-del-dialog");
			$("#user-chart").addClass("hide-del-dialog");
			$("#user-info").val("");
			//$("#yes").attr("href", "");
		}
		*/
		</script>
	</body>
</html>