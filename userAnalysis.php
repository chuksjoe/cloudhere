<?php
	require_once("functions.inc");
	require_once("fusioncharts.php");
	
	if(!$_SESSION['adminLogin']){
		die(header("Location: signIn.php"));
	}
	
	$user_id = $_GET['user_id'];
	$fname = $_GET["fname"];
	//$d_l_o = $_GET["dlo"];
?>
<html>
	<head>
		<title>CloudHere Users Analysis</title>
		<link href = "css/general.css" rel = "stylesheet" type = "text/css"/>
		<link rel = "stylesheet" type = "text/css" href = "css/adminSpace.css"/>
		<link rel="icon" href="favicon.ico" type="image/x-icon">
		
		<script src="javascript/jquery-2.1.4.js"></script>
		<script src="javascript/fusioncharts.js"></script>
		<script src="javascript/fusioncharts.charts.js"></script>
		<script src="javascript/themes/fusionchartstheme.zune.js"></script>
	</head>
	<body>
		<div id = "user-chart">
			<div id = "dialog-header">
				<div id = "info-div" class = "dlg-header-content">
					<h1 id = "user-info"><?php echo $fname; ?>'s Consumption Analysis</h1>
					<!--<p>Date last online: <?php echo $d_l_o; ?></p>-->
				</div>
			</div>
			<div id = "dialog-content">
				<div id = "user-table">
					<table>
						<thead>
							<tr>
								<th>Days</th><th>Upload Count</th><th>Storage Used</th>
							</tr>
						</thead>
						<tbody>
							
						<?php
							$query = "SELECT DATE_FORMAT(upload_date, '%Y-%m-%d') AS upload_date, COUNT(file_id) AS total_num_of_files, SUM(size) AS total_storage FROM tbl_user_upload WHERE user_id = '{$user_id}' GROUP BY DATE_FORMAT(upload_date, '%Y%m%d')";
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
							echo "<tr><td colspan ='2'>Total Number of files Uploaded: ".$acc." </td><td colspan ='1'>Total Storage Used: ".number_format($total, 2)."mb</td></tr>";
						?>
						</tfoot>
					</table>
				</div>
				<div id = "user-consumption-chart">
					<?php	
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
					
						$chart1 = new FusionCharts("column2D", "DailyTotalStorage" , 900, 400, "daily-storage-used", "json", $jsonEncodedData);
						// Render the chart
						$chart1->render();
					?>
					<div id = "daily-storage-used">Chart for Storage Usage on Daily Basis</div>
					
					<?php	
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
					
						$pieChart = new FusionCharts("column2D", "totalNumFilesOnDailyBasis" , 900, 400, "total-num-of-files-daily", "json", $jsonEncodedData);
						// Render the chart
						$pieChart->render();
					?>
					<div id = "total-num-of-files-daily">Chart for Total number of uploaded files on Daily basis</div>
				</div>
			</div>
		</div>
		
		<script type = "text/javascript">
			
		</script>
	</body>
</html>