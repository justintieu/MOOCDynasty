<!DOCTYPE>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
	</head>
	<body>
		<?php
		include_once("connect.php");
		$course_id = $_GET["id"];
			
			$query = "SELECT * FROM `course_data` where id='".$course_id."'";
			$raw_results = $mysqli->query($query);
			while($row = mysqli_fetch_array($raw_results)) {
				$title = $row['title'];
				$course_link = $row['course_link'];
				$long_desc = $row['long_desc'];
				$video_link = $row['video_link'];
				$university = $row['university'];
				$start_date = $row['start_date'];
				$course_length = $row['course_length'];
				$category = $row['category'];
				$profname = "";
				$profimage = "";
				
			}
		 ?>
		 <div class="container">
			<div class="header">
				<div id="logo"><a href="index.php">MOOC Dynasty</a></div>
			</div>
			<div class="rate">
				<div class="left">
					<span class="label">Currently Rating Course:</span> 
					<select>
					<?php 
						$query = "SELECT * FROM `course_data`";
						$raw_results = $mysqli->query($query);
						while($row = mysqli_fetch_array($raw_results)) {
							$option = "<option value=\"".$row['id']."\" ";
							if($row['id']==$course_id){
								$option.="selected";
							}
							$option.=" >".$row['title']."</option>";
							echo $option;
						}
					?>
				</div>
				</select>
			</div>
		 </div>
	 </body>
 </html>