<?php
	session_start();
	if(!isset($_SESSION['id'])) {
		header('location: index.php');
	}
?>
<!DOCTYPE>
<html>
<head>
<title>Rate | MoocDynasty</title>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>		
<link rel="stylesheet" type="text/css" href="css/style.css" />
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
		<?php
			include_once("connect.php");
			$error = "";
			if(isset($_GET["id"])) {
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
			} else if($_SERVER["REQUEST_METHOD"] == "POST") {
				$course = $_POST['course'];
				$rating = intval($_POST['rating']);
				$review = $_POST['review'];
				$star_rating = "";
				if(strlen($review) >= 9 && $rating != 0) { 
					$title = "";
					$query = "SELECT * FROM `course_data` where id = '".$course."'";
					$raw_results = $mysqli->query($query);
					while($row = mysqli_fetch_array($raw_results)) {
						$title = $row['title'];
					}
					switch($rating) {
						case 1:
							$star_rating.="<div name='rating' id='rating' class='rating'>";
							$star_rating.="<span></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="</div>";
							break;
						case 2:
							$star_rating.="<div name='rating' id='rating' class='rating'>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="</div>";
							break;
						case 3:
							$star_rating.="<div name='rating' id='rating' class='rating'>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="</div>";
							break;
						case 4:
							$star_rating.="<div name='rating' id='rating' class='rating'>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span class=\'nostar\'></span>";
							$star_rating.="</div>";
							break;
						case 5:
							$star_rating.="<div name='rating' id='rating' class='rating'>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="<span></span>";
							$star_rating.="</div>";
							break;
						default: 
							$star_rating = "error";
							break;
					}
					
					$sql = "INSERT INTO `course_ratings` VALUES ('". $course."','". $title ."','". $rating."','". str_replace("'","''",$review)."', '".$_SESSION['id']."', '".(new \DateTime())->format('Y-m-d H:i:s')."')";
					if($mysqli->query($sql)) {
					} else {
						echo "<script>console.log(failed to insert into course_ratings);</script>";
					}
					
					$sql = "SELECT * FROM `averagerating` where course_id=".$course;
					$results= $mysqli->query($sql);
					if(mysqli_num_rows($results) > 0) {
						while($row = mysqli_fetch_array($results)) {
							$current_rating = $row['rating']+$rating;
							$numvotes = $row['numvotes'] + 1;
							$sql = "UPDATE `averagerating` SET rating=".($current_rating).", numvotes=".($numvotes).", avgrate=".($current_rating)/($numvotes)." where course_id=".$course;
							if($mysqli->query($sql)) {
							echo "<script>console.log('UPDATED IN DATABASE ".$sql."');</script>";
							} else {
								echo "<script>console.log('failed to update averagerating ".$sql."');</script>";
							}
						}
					} else {
						$sql = "INSERT INTO `averagerating` VALUES(NULL,'".$course . "','". $rating ."','1','".($rating/1)."')";
						if($mysqli->query($sql)) {
							echo "<script>console.log('INSERTED INTO DATABASE');</script>";
						} else {
							echo "<script>console.log('failed to insert into averagerating');</script>";
						}
					}
					$script = "<script type=\"text/javascript\">$(\"#blocks>.inside\").html(\"<div style='text-align: center; margin-top: 50px;'><div><label>Thank you for rating the course:</label> <div>".$title."</div></div> <div><label>Rating:</label> ".$star_rating."</div><div><label>Review:</label> <div>".$review."</div></div></div>\");</script>";
				} else {
					$error = "<div class=\"error\">Please make sure have selected a rating and/or have a review of at least length 9.</div>";
				}
			} else {
				header('Location: index.php');
			}
		 ?>
		 <div id="blocks">
			<div class="inside">
					<form class="course-review" action="rate.php" method="POST">
						<div>
							<div><label for="course">Currently Rating Course:</label></div>
							<select style="width: 500px;" name="course" id="course" class="course">
							<?php 
								$query = "SELECT * FROM `course_data`";
								$raw_results = $mysqli->query($query);
								while($row = mysqli_fetch_array($raw_results)) {
									$option = "<option value=\"".$row['id']."\" ";
									if(isset($course_id) && $row['id']==$course_id){
										$option.="selected";
									}
									$option.=" >".$row['title']."</option>";
									echo $option;
								}
							?>
							</select>
						</div>
						<div>
							<label for="rating">Course Rating:</label>
							<div name="rating" id="rating" class="rating">
								<input type="radio" name="rating" value="0" checked /><span id="hide"></span>
								<input type="radio" name="rating" value="1" /><span></span>
								<input type="radio" name="rating" value="2" /><span></span>
								<input type="radio" name="rating" value="3" /><span></span>
								<input type="radio" name="rating" value="4" /><span></span>
								<input type="radio" name="rating" value="5" /><span></span>
							</div>
						</div>
						<div>
							<div><label for="review">Course Review:</label></div>
							<textarea name="review" id="review" class="review" rows="10" placeholder="9 characters minimum" cols="63"></textarea>
						</div>
						<input id="ratebtn" type="submit" value="Submit Course Review">
					</form>
					<?php echo $error; ?>
			</div>
			<?php if(isset($script)) echo $script; ?>
		 </div>
	 <div id="footer">
	 	<div class="inside">
			<p>MoocDynasty &copy; 2014   | SJSU CS160</p>
		</div>
	 </div>
</body>
</html>