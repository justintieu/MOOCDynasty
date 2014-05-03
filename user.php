<?php
	session_start();
	if(!isset($_GET['id'])) {
		header('location: index.php');
	}
	require_once('connect.php');
	$first = "";
	$id = "";
	if(isset($_GET['id'])) {
		$sql = "SELECT * FROM `users` where id=".$_GET['id']." LIMIT 1";
		$results = $mysqli->query($sql);
		
		while($row = mysqli_fetch_array($results)) {
			$first = $row['first'];
			$id = $row['id'];
		}		
	}
?>
 <!DOCTYPE HTML>
<html>
<head>
<title>MoocDynasty</title>
<link rel="stylesheet" type="text/css" href="style.css" />
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
							echo "<li class=\"current_page_item\"><a href=\"user.php?id=".$_SESSION['id']."\">Profile</a></li>";
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
			if(isset($first) && $_GET['id'] == $_SESSION['id']) {
				echo "<div class=\"title\">";
				echo "<h2>Welcome ".$first."</h2>";
				echo "</div>";
				
				//create edit profile code here
				echo "<form>";
				echo "edit profile to be implemented";
				echo "</form>";
			} else {
				echo "<div class=\"title\">";
				echo "<h2>Welcome to ".$first."'s Profile</h2>";
				echo "</div>";
			}
		?>
		<div class="inside">
			<div class="title"><h1>Courses</h1></div>
			<?php
				$sql = "SELECT * FROM `course_data` as cd JOIN `student_courses` as sc WHERE cd.id = sc.courseid AND sc.userid=".$_GET['id'];
				$results = $mysqli->query($sql);
				if(mysqli_num_rows($results) > 0 ) {
					while($row = mysqli_fetch_array($results)){
						echo $row['title'].'<br />';
					}					
				} else if($id == $_SESSION['id']) {
					echo "You currently have no courses.";
				} else {
					echo $first . " currently no courses.";
				}
			?>
		</div>
	 </div>
	 <div id="footer">
	 	<div class="inside">
			<p>MoocDynasty &copy; 2014   | SJSU CS160</p>
		</div>
	 </div>
</body>
</html>
