<!DOCTYPE>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="main.css">
		<style type="text/css">
		.header {
			position: fixed;
		}
		</style>
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
				$image = $row['course_image'];
				$video_link = $row['video_link'];
				$university = $row['university'];
				$start_date = $row['start_date'];
				$course_length = $row['course_length'];
				$category = $row['category'];
				$profname = "";
				$profimage = "";
				
				$raw_results2 = $mysqli->query("SELECT * FROM `coursedetails` where `course_id`=".$row['id']);
				while($row2 = mysqli_fetch_array($raw_results2)) {
					$profname = $row2['profname'];
					$profimage = $row2['profimage'];
				}
				
				$title_sec = "<a href=\"".$course_link."\" target=\"_blank\">".strtoupper($title)."</a>";
				$video_sec = "";
				switch($row['site']) {
					case "EDX":
						$video_sec.= "<span class=\"label\">Video</span><hr/><iframe width=\"640\" height=\"360\" src=\"".str_replace('watch?v=',"embed/",$video_link)."\" frameborder=\"0\" allowfullscreen></iframe>";
						break;
					case "FutureLearn":
						$video_sec.="<span class=\"label\">Video</span><hr/><embed src=\"".$video_link."\" width=\"640\" height=\"360\"></embed>";
						break;
					default:
						break;
				}
				if($video_link === "n/a") {
					$video_sec = "<img src=\"".$image."\" width=640px;/>";
				}
			}
		 ?>
		 <div class="container">
			<div class="header">
				<div id="logo"><a href="index.php">MOOC Dynasty</a></div>
			</div>
			<div class="course">
				<div class="course-info left">
					<ul class="list">
					<li><span class="label">University:</span> <?php echo $university; ?></li>
					<li><span class="label">Start Date:</span> <?php echo $start_date; ?></li>
					<li><span class="label">Course Length:</span> <?php echo $course_length; ?> weeks</li>
					<?php if(strlen($category) > 1) echo "<li><span class=\"label\">Category:</span> ".$category."</li>"; ?>
					<li><span class="label">Head Educator:</span> <span class="profname"><?php echo $profname; ?></span><div class="profimg"><img src="<?php echo $profimage; ?>" /></div></li>
					<li><a href="rate.php?id=<?php echo $course_id;?>">Rate This Course</a></li>
					</ul>
				</div>
				<div class="title right"><?php echo $title_sec; ?></div>
				<div class="video right"><?php echo $video_sec; ?></div>
				<div class="description right"><span class="label">Course Description</span><hr/><?php echo $long_desc; ?></div>
			</div>
		 </div>
	 </body>
 </html>