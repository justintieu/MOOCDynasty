<?php
	session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
<title>MoocDynasty</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
				<li class="current_page_item"><a href="about.php">About Us</a></li>
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
	 <div id="blocks">
		<div class="title">
			<h2>Meet The Team Behind MoocDynasty</h2>
		</div>
	 	<div class="inside about">
			<div style="width: 800px; margin: 10px auto; text-align: center;">
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
	 </div>
	 <div id="footer">
	 	<div class="inside">
			<p>MoocDynasty &copy; 2014   | SJSU CS160</p>
		</div>
	 </div>
</body>
</html>
