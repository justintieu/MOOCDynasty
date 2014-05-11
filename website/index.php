<?php	
	session_start();
	require_once('includes/connect.php');
	$sql = "SELECT * FROM `averagerating` ORDER BY avgrate DESC LIMIT 7";
	$raw_results = $mysqli->query($sql);
	$topseven = array();
	$id = 1;
	while($row = mysqli_fetch_array($raw_results)) 
	{	
		
		$sql = "SELECT * FROM `course_data` WHERE id='".$row['course_id']."'";
		$raw_results2 = $mysqli->query($sql);
		while($row2 = mysqli_fetch_array($raw_results2)) {
			$topseven[$id]['title'] = (strlen($row2['title']) > 32) ? substr($row2['title'],0,32)."..." : $row2['title'];
			if(substr($row2['course_image'],0,4)=== "http") {
				$topseven[$id]['image'] = $row2['course_image'];
			} else {
				$topseven[$id]['image'] = "http://".$row2['course_image'];
			}
		}
		$topseven[$id]['course_id'] = $row['course_id'];
		$star_rating = "";
		switch(floor($row['rating']/$row['numvotes'])) {
			case 0:
				$star_rating.="<div name='rating' id='rating' class='rating'>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="</div>";
				break;
			case 1:
				$star_rating.="<div name='rating' id='rating' class='rating'>";
				$star_rating.="<span></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="</div>";
				break;
			case 2:
				$star_rating.="<div name='rating' id='rating' class='rating'>";
				$star_rating.="<span></span>";
				$star_rating.="<span></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="</div>";
				break;
			case 3:
				$star_rating.="<div name='rating' id='rating' class='rating'>";
				$star_rating.="<span></span>";
				$star_rating.="<span></span>";
				$star_rating.="<span></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="<span class='nostar'></span>";
				$star_rating.="</div>";
				break;
			case 4:
				$star_rating.="<div name='rating' id='rating' class='rating'>";
				$star_rating.="<span></span>";
				$star_rating.="<span></span>";
				$star_rating.="<span></span>";
				$star_rating.="<span></span>";
				$star_rating.="<span class='nostar'></span>";
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
		$topseven[$id]['rating'] = $star_rating;
		$id++;
	}	
?>
<!DOCTYPE HTML>
<html>
	<head>
	<title>Home | MoocDynasty</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/rate.css" />
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
					<li class="current_page_item"><a href="index.php">Homepage</a></li>
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
			<div class="banner">
				<div class="title">
					<h2>Search for your course now!</h2>
					<form action="search.php" action="GET" class="searchform" id="searchform">
						<input name="searchfield" id="searchfield" class="searchfield" type="text" placeholder="Search..." />
						<input class="searchbutton" type="submit" value="Go"/>
					</form>
				</div>
			</div>
		 </div>
		 <div id="blocks">
			<div class="title">
				<h2>Top 7 Courses</h2>
			</div>
			<div class="inside">
				<a href="course.php?id=<?php echo $topseven[1]['course_id']; ?>">
					<div class="numone">
						<h3>1. <?php echo $topseven[1]['title']; ?></h3>
						<?php echo $topseven[1]['rating']; ?>
						<img src="<?php echo $topseven[1]['image']; ?>" alt="" width="500px" height="325px"/>
					</div>
				</a>
				<?php 
					for($i = 2; $i <= 7; $i++) {
						echo "<a href=\"course.php?id=".$topseven[$i]['course_id']."\"><div class=\"block1\">";
						echo "<h3>".$i.". ".$topseven[$i]['title']."</h3><br/>";
						echo $topseven[$i]['rating'];
						echo "<img src=\"".$topseven[$i]['image']."\" alt=\"\" width=\"250px\" height=\"75px\"/>";
						echo "</div></a>";
					}
				?>
			</div>
		 </div>
		 <?php include('includes/footer.php'); ?>
	</body>
</html>
