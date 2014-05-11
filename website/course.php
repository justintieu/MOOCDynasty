<?php
	session_start();
	
	require_once('includes/connect.php');
	if(isset($_GET["id"])) {
		$course_id = $_GET["id"];
	
		$query = "SELECT * FROM `course_data` where id='".$course_id."'";
		$raw_results = $mysqli->query($query);
		while($row = mysqli_fetch_array($raw_results)) {
			$title = $row['title'];
			$site = $row['site'];
			$course_link = $row['course_link'];
			$long_desc = $row['long_desc'];
			$image = $row['course_image'];
			$video_link = $row['video_link'];
			$university = $row['university'];
			$start_date = $row['start_date']=="0000-00-00" ? "Self Paced" : $row['start_date'];		
			$course_length = $row['course_length'];
			$category = $row['category'];
			$professors = array();
			$profname = "";
			$profimage = "";
			$rating = "";
			$star_rating = "";
			
			$sql = "SELECT * FROM averagerating WHERE course_id=".$row['id'];
			if($result = $mysqli->query($sql)) {
				while($r = mysqli_fetch_array($result)) {
					$rating = floor($r['avgrate']);
				}
			}
			$raw_results2 = $mysqli->query("SELECT * FROM `coursedetails` where `course_id`=".$row['id']);
			while($row2 = mysqli_fetch_array($raw_results2)) {
				$profimage = "";
				if(substr($row2['profimage'],0,4)=== "http") {
					$profimage = $row2['profimage'];
				} else {
					$profimage = "http://".$row2['profimage'];
				}
				$profname = $row2['profname'];
				
				$professors[] = array(
					'profname' => $profname,
					'profimage' => $profimage
				);
			}
			
			$title_sec = "<a href=\"".$course_link."\" target=\"_blank\">".strtoupper($title)."</a>";
			$video_sec = "";
			switch($row['site']) {
				case "EDX":
					$video_sec.= "<span class=\"label\">Video</span><hr/><iframe width=\"640\" height=\"360\" src=\"".str_replace('watch?v=',"embed/",$video_link)."\" frameborder=\"0\" allowfullscreen></iframe>";
					break;
				case "iversity.org":
					$video_sec.= "<span class=\"label\">Video</span><hr/><iframe width=\"640\" height=\"360\" src=\"".$video_link."\" frameborder=\"0\" allowfullscreen></iframe>";
					break;
				case "FutureLearn":
					$video_sec.="<span class=\"label\">Video</span><hr/><embed src=\"".$video_link."\" width=\"640\" height=\"360\"></embed>";
					break;
				case "coursera.org":
					$video_sec.="<span class=\"label\">Video</span><hr/><embed src=\"".$video_link."\" autostart=\"false\" width=\"640\" height=\"360\"></embed>";
					break;
				case "Canvas":
					break;
				case "Open2Study":
					$video_sec.= "<span class=\"label\">Video</span><hr/><iframe width=\"640\" height=\"360\" src=\"http:".str_replace('watch?v=',"embed/",$video_link)."\" frameborder=\"0\" allowfullscreen></iframe>";
					break;
				case "NovoEd":
					$video_sec.= "<span class=\"label\">Video</span><hr/><iframe width=\"640\" height=\"360\" src=\"".$video_link."\" frameborder=\"0\" allowfullscreen></iframe>";
					break;
				case "Udacity":
					$video_sec.= "<span class=\"label\">Video</span><hr/><iframe width=\"640\" height=\"360\" src=\"".str_replace('watch?v=',"embed/",$video_link)."\" frameborder=\"0\" allowfullscreen></iframe>";
					break;
				default:
					break;
			}
			if($video_link === "n/a" || $video_link == "") {
				$video_sec = "<img src=\"".$image."\" width=640px;/>";
			} else if (substr($video_link,0,17) == "http://vimeo.com/") {
				$video_sec = "<span class=\"label\">Video</span><hr/><iframe width=\"640\" height=\"360\" src=\"http://player.vimeo.com/video/".substr($video_link,18,strlen($video_link))."\" frameborder=\"0\" allowfullscreen></iframe>";
			}
		}
	} else {
		header("Location: courses.php");
	}
?>
<!DOCTYPE>
<html>
<head>
<title><?php echo $title; ?> | MoocDynasty</title>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<link rel="stylesheet" type="text/css" href="css/course.css" />
<link rel="stylesheet" type="text/css" href="css/rate.css" />
	</head>
	<body>
		<div id="header">
			<div class="inside">
				<a href="index.php" class="logo">MoocDynasty</a>																													
				<p class="slogan">Helping people find courses every day!</p>
			</div>
			<div id="menu">
				<ul>
					<li><a href="index.php">Homepage</a></li>
					<li><a href="courses.php">View All Courses</a></li>
					<li><a href="about.php">About Us</a></li>
					 <?php
						if(isset($_SESSION['id'])) {
							echo "<li><a href=\"user.php?id=".$_SESSION['id']."\">Profile</a></li>";
							echo "<li><a href=\"logout.php\">Log Out</a></li>";
						} else {
							echo "<li><a href=\"login.php\">Login</a></li>";
							echo "<li><a href=\"register.php\">Register</a></li>";
						}
					?>		
				</ul>
			</div>
		</div>
		<div id="course-block">
			<div class="course">
				<div class="title"><h2><?php echo $title_sec; ?></h2></div>
				<div class="course-info left">
					<ul class="list">
						<li><span class="label"><a href="<?php echo $course_link; ?>"><?php echo $site; ?> - course page</a></span> </li>
						<li><span class="label">University:</span> <?php echo $university; ?></li>
						<li><span class="label">Start Date:</span> <?php echo $start_date; ?></li>
						<li><span class="label">Course Length:</span> <?php if($course_length == '0') {echo "Self-paced";} else {echo $course_length." weeks"; } ?></li>
						<li><span class="label">Course Rating:</span> <div style="float: right; margin: 7px 135px 0px 0px;" class="rating" id="rating"><?php echo $rating ?></div></li>
						<?php if(strlen($category) > 1) echo "<li><span class=\"label\">Category:</span> ".$category."</li>"; ?>
						<li><span class="label">Educator:</span> 
							<table>
							 <?php
								for($i = 0; $i < count($professors); $i++) {
									echo "<tr>";
									echo "<td class=\"profname\">". $professors[$i]['profname'] ."</td>";
									echo "<td class=\"profimg\"><div><img style=\"border: 1px solid black; width: 100px; \" src=\"". $professors[$i]['profimage'] ."\" /></td>";
									echo "</tr>";
								}
							 ?>
							</table>
						</li>
					</ul>
					<?php
						if(isset($_SESSION['id'])) {
							echo "<div class=\"buttons\">";
							echo "<a href=\"rate.php?id=".$course_id."\" class=\"coursebutton\">rate this course</a> "; 
							echo "<a href=\"addcourse.php?id=".$course_id."\" target=\"_blank\" class=\"coursebutton\">add course to profile</a>";
							echo "</div>";
						}
					?>
					<div class="reviews">
						<div class="title"><h3>Student Reviews</h3><hr/></div>
					<?php
						$sql = "SELECT * FROM `course_ratings` where course_id=".$_GET['id']." ORDER BY `time_submitted` LIMIT 2";
						$results = $mysqli->query($sql);
						
						if(mysqli_num_rows($results) > 0) {
							$i = 0;
							while($row = mysqli_fetch_array($results)) {
								echo "<div class='review'>";
								$sql2 = "SELECT first, last from `users` where id=".$row['student_id'];
								$results2 = $mysqli->query($sql2);
								echo "<div style=\"float:right;\" class=\"rating\" id=\"rating\">" . $row['rating'] . "</div>";
								if($row2 = mysqli_fetch_array($results2)) {
									echo "by <label><a style='color: blue;' href=\"user.php?id=".$row['student_id']."\">".$row2['first']." ".substr($row2['last'],0,1).". </a></label>";
								}
								echo "<div>" .$row['time_submitted'] . "</div>";
								echo "<div>" . $row['review'] . "</div>";
								echo "</div>";
								$i = $i + 1;
							}
							if(mysqli_num_rows($results) > 2) {
								echo "<div class='title'><h3><a href='reviews.php?id=".$_GET['id']."' style='color: blue;'>View All Reviews</a></h3></div>";
							}	
						} else {
							echo "There are currently no reviews for this course.";
						}
					?>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
							for( var i = 0; i < $('.rating').length; i++) {						
								var star_rating = "";
								switch($('.rating')[i].innerHTML) {
									case "1":
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span class=\'nostar\'></span>";
										star_rating=star_rating+"<span class=\'nostar\'></span>";
										star_rating=star_rating+"<span class=\'nostar\'></span>";
										star_rating=star_rating+"<span class=\'nostar\'></span>";
										break;
									case "2":
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating+="<span class=\'nostar\'></span>";
										star_rating+="<span class=\'nostar\'></span>";
										star_rating+="<span class=\'nostar\'></span>";
										break;
									case "3":
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span class=\'nostar\'></span>";
										star_rating=star_rating+"<span class=\'nostar\'></span>";
										break;
									case "4":
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span class=\'nostar\'></span>";
										break;
									case "5":
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										break;
									default:
										star_rating = "unrated";
										break;
								}
								//$('.review .rating')[i].replaceWith(star_rating);
								if(star_rating == "unrated") {
									$('.rating').css("margin", "0px 206px 0px 0px");
									$('.rating').html(star_rating);
								} else {
									$('.rating')[i].innerHTML = star_rating;
								}
							}
						});	
					</script>
				</div>
				<div class="video right"><?php echo $video_sec; ?></div>
				<div class="description right"><span class="label">Course Description</span><hr/><?php echo $long_desc; ?></div>
			</div>
		</div>
		<div style="clear: both;"></div>
		<?php include('includes/footer'); ?>
	 </body>
 </html>