<?php
	session_start();
	if(!isset($_GET['id']) && !isset($_SESSION['id'])) {
		header('location: index.php');
	}
	require_once('connect.php');
	$first = "";
	$id = "";
	if(isset($_SESSION['id'])) {
		$lookup_id = $_SESSION['id'];
	} 
	if(isset($_GET['id'])) {
		$lookup_id = $_GET['id'];
	} 
	
	
	$sql = "SELECT * FROM `users` where id=".$lookup_id." LIMIT 1";
	$results = $mysqli->query($sql);
	
	while($row = mysqli_fetch_array($results)) {
		$first = $row['first'];
		$last = $row['last'];
		$profileimage = ($row['image'] === "") ? "images/user.png" : $row['image'] ;
		$name = $first . " " . substr($last,0,1) . ".";
		$id = $row['id'];
		$bio = $row['bio'];
	}		
?>
 <!DOCTYPE HTML>
<html>
<head>
<title><?php echo $name;?> | MoocDynasty</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<style type="text/css">
.title {
	margin-bottom: 20px;
}
</style>
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
							echo "<li class=\"current_page_item\"><a href=\"user.php\">Profile</a></li>";
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
	 <div id="blocks">
		<?php
			if(isset($first) && $_SESSION['id'] == $lookup_id) {
				echo "<div style=\"width: 1000px; margin: 0 auto;\" class=\"title\">";
				echo "<h2>Welcome ".$name."</h2>";
				echo "<hr/>";
				echo "</div>";
			} else {
				echo "<div style=\"width: 1000px; margin: 0 auto;\" class=\"title\">";
				echo "<h2>Welcome to ".$name."'s Profile</h2>";
				echo "<hr/>";
				echo "</div>";
			}
		?>
		<div class="inside">
			<?php
				echo "<img style='border: 1px solid #000; border-radius: 75px; float: right; margin: 5px;' src='".$profileimage."' width=\"128\" height=\"128\" />";
				if(isset($first) && $_SESSION['id'] == $lookup_id) {
					echo "<div class=\"title\"><a href=\"settings.php\"><h1>Edit Profile</h1>Click here to edit your profile info.</a></div>";
				}
			?>
			
			<div class="title">
				<h1>Bio</h1>
				<?php 
					echo $bio;
				?>
			</div>
			<div style="clear:both;"></div>
			
			<div class="title">
				<h1>My Courses</h1>
				<?php
					$sql = "SELECT * FROM `course_data` as cd JOIN `student_courses` as sc WHERE cd.id = sc.courseid AND sc.userid=".$lookup_id;
					$results = $mysqli->query($sql);
					if(mysqli_num_rows($results) > 0 ) {
						$count = 0;
						while($row = mysqli_fetch_array($results)){
							echo    '<a href=course.php?id='.$row['id'].'><div title="'. $row['title'] .'" class="student_class" style="height: 175px; border: 1px solid #000; float:left; margin: 10px;">
									<div class="student_class_img">
									<img src="'.$row['course_image'].'" height="175px" width="175px"> </div></div></a>';
							$count++;
							if($count == 5){
								$count == 0;
								echo '<div style="clear:both;"></div>';
							}
						}			
					} else if($id == $_SESSION['id']) {
						echo "You currently have no courses. Go <a style='color:blue;' href='search.php'>search</a> a course and add it to your profile!";
					} else {
						echo $first . " currently no courses.";
					}
				?>
			</div>
		</div>
	 </div>
	 <div id="footer">
	 	<div class="inside">
			<p>MoocDynasty &copy; 2014   | SJSU CS160</p>
		</div>
	 </div>
</body>
</html>
