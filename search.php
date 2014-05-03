<?php	
	require_once("connect.php");
	session_start();
	$results = array();
	if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['searchfield']) && strlen($_GET['searchfield']) > 0) {
		$searchfield = $_GET['searchfield'];
		
		$sql = "SELECT id,title,short_desc,course_image FROM course_data WHERE title LIKE '%" . str_replace("'","''",$searchfield) . "%' LIMIT 3";
		$raw_results = $mysqli->query($sql);
		while($row = mysqli_fetch_array($raw_results)) {
			$results[] = array($row['id'], $row['course_image'], $row['title'], $row['short_desc']);
		}
	} 
?>
<!DOCTYPE HTML>
<html>
	<head>
	<title>MoocDynasty</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="rate.css" />
	<script type="text/javascript">
	$(document).ready(function(){
		$('.searchfield').autocomplete({source:'suggestcourse.php', minLength:2});
	});
	</script>
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
			<div class="banner">
				<div class="title">
					<h2>Search for your course now!</h2>
					<form action="search.php" action="GET" class="searchform" id="searchform">
						<input name="searchfield" id="searchfield" class="searchfield" type="text" placeholder="Search..." value="<?php if(isset($_GET['searchfield']) && strlen($_GET['searchfield']) > 0) { echo $_GET['searchfield']; }?>"/>
						<input class="searchbutton" type="submit" value="Go"/>
					</form>
				</div>
			</div>
		</div>
		<div id="blocks">
			<?php 
				if(count($results) > 0 ) {
					if(count($results) == 1) {
						echo "<div class='title'><h2>HERE IS YOUR TOP RESULT";
					} else {
						echo "<div class='title'><h2>HERE ARE YOUR TOP " . count($results) . " RESULTS";
					}
					echo "</h2></div>";
					for($i = 0; $i < count($results); $i++) {
						echo "<a href='course.php?id=".$results[$i][0]."'>";
						echo "<div style='width: 700px; height: 200px; margin: 0 auto; border: 1px solid black;'>";
						echo "<div style='float:left; padding: 20px;'>";
						echo "<img src='".$results[$i][1]."' width='150px' height='150px' />.";
						echo "";
						echo "</div>";
						echo "<div style='float:right; width: 460px; padding: 20px;'>";
						echo "<h3>".$results[$i][2]."</h3>";
						echo $results[$i][3];
						echo "</div>";
						echo "</div>";
						echo "</a>";
						echo "<div style='clear:both;'></div>";
					}
				}
				if(isset($_GET['searchfield'])) {
					echo "<h3 style='margin-top: 20px; text-align: center;'><a href='courses.php'>Want to search for more results? Click here</a></h3>";
				}
			?>
		</div>
		<div id="footer">
			<div class="inside">
				<p>MoocDynasty &copy; 2014   | SJSU CS160</p>
			</div>
		</div>
	</body>
</html>
