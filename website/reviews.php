<?php
	session_start();
	
	include_once("connect.php");
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
			
			$raw_results2 = $mysqli->query("SELECT * FROM `coursedetails` where `course_id`=".$row['id']);
			while($row2 = mysqli_fetch_array($raw_results2)) {
				$profname = $row2['profname'];
				$profimage = $row2['profimage'];
				
				$professors[] = array(
					'profname' => $row2['profname'] ,
					'profimage' => $row2['profimage']
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
<title><?php echo $title; ?>'s Reviews | MoocDynasty</title>
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
							echo "<li><a href=\"settings.php\">Settings</a></li>";
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
				<div class="course-info ">
					<?php
						if(isset($_SESSION['id'])) {
							echo "<div class=\"buttons\">";
							echo "<a href=\"rate.php?id=".$course_id."\" class=\"coursebutton\">rate this course</a> "; 
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
								echo "<div class=\"rating\" id=\"rating-".$i."\">" . $row['rating'] . "</div>";
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
								var star_rating = "<div style='float: right;' name='rating' id='rating' class='rating'>";
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
										star_rating=star_rating+"<div name='rating' id='rating' class='rating'>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										star_rating=star_rating+"<span></span>";
										break;
									default:
										console.log("error");
										break;
								}
								star_rating=star_rating+"</div>";
								$('#rating-'+i).replaceWith(star_rating);
								//console.log("replacing #rating-" + i + " " + star_rating);
							}
						});	
					</script>
				</div>
			</div>
		</div>
		<div style="clear: both;"></div>
		<div id="footer">
			<div class="inside">
				<p>MoocDynasty &copy; 2014   | SJSU CS160</p>
			</div>
		</div>
	 </body>
 </html>