<?php
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>About | MoocDynasty</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
<style type="text/css">
 #blocks .inside {
	margin-bottom: 20px;
 }
 #row1, #row2 {
	text-align: center;
 }
 #row1 img, #row2 img {
	max-width: 200px;
	padding: 5px;
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
				<li class="current_page_item"><a href="about.php">About Us</a></li>
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
	 <div id="blocks" style="background-image:url();">
		<div class="title">
			<h2>Meet The Team Behind MoocDynasty</h2>
		</div>
	 	<div class="inside about" style="width: 750px;">
			<div style="margin: 10px auto; text-align: center;">
				We are GUI Productions from Spring 2014's CS 160 Section 5. This is our aggregated MOOC website, MoocDynasty, created with HTML, CSS, JavaScript, JQuery and PHP.
			</div>
		    <div class="block1">
				<h3>Andrés Chorro</h3>
			    <div class="crop"><img id="andres" src="https://scontent-a-sjc.xx.fbcdn.net/hphotos-frc3/t1.0-9/1380320_10151752470477424_669731635_n.jpg" alt="" ></div>
			</div>
		    <div class="block1">
				<h3>Gerald Xie</h3>
			    <div class="crop"><img id="gerald" src="https://scontent-a-sjc.xx.fbcdn.net/hphotos-ash3/t1.0-9/945165_1385688808331062_1377571274_n.jpg" alt="" ></div>
			</div>
		    <div class="block1">
				<h3>Jannette Pham-Le</h3>
			    <div class="crop"><img id="jannette" src="https://scontent-a-sjc.xx.fbcdn.net/hphotos-frc3/t1.0-9/1017021_10151647202817424_1511883668_n.jpg" alt="" ></div>
			</div>
		    <div class="block1">
				<h3 >Jonathan Vaccaro</h3>
			    <div class="crop"><img id="jonathan" src="https://fbcdn-sphotos-c-a.akamaihd.net/hphotos-ak-prn1/t1.0-9/485644_10151390117848263_1596454903_n.jpg" alt="" ></div>
			</div>
		    <div class="block1">
				<h3>Justin Tieu</h3>	
			    <div class="crop"><img id="justin" src="https://fbcdn-sphotos-d-a.akamaihd.net/hphotos-ak-prn1/t1.0-9/994521_10151609625320889_1015188757_n.jpg" alt="" ></div>
			</div>
		    <div class="block1">
				<h3>Romin Oushana</h3>
			    <div class="crop"><img id="romin" src="https://scontent-b-sjc.xx.fbcdn.net/hphotos-frc3/t1.0-9/1384081_728057637207686_1197954403_n.jpg" alt="" ></div>
			</div>
		</div>
		
		<div class="title">
			<h2>List of aggregated websites</h2>
		</div>
	 	<div class="inside">
			<div id="row1">
				<img src="images/canvas.jpg" title="Canvas" alt="Canvas" /> 
				<img src="images/coursera.jpg" title="Coursera" alt="Coursera" /> 
				<img src="images/edx.png" title="EDX" alt="EDX" /> 
				<img src="images/futurelearn.png" title="FutureLearn" alt="FutureLearn" />
			</div>
			<div id="row2">
				<img src="images/iversity.jpg" title="iversity" alt="iversity" /> 
				<img src="images/novoed.jpg" title="NovoEd" alt="NovoEd" /> 
				<img src="images/open2study.png" title="Open2Study" alt="Open2Study" /> 
				<img src="images/udacity.jpg" title="Udacity" alt="Udacity" />
			</div>
		</div>
	 </div>
	 <?php include('includes/footer.php'); ?>
</body>
</html>
