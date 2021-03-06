<?php
	session_start();
	
	header('Content-Type:text/html; charset=UTF-8');
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Courses | MoocDynasty</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/style.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css" />
	<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>		
	<script src="http://datatables.net/download/build/nightly/jquery.dataTables.js"></script>		
	<script type="text/javascript">			
		$(document).ready(function (){			
			var table = $('#dataTable').dataTable({
				"language": {
			          "emptyTable": "Loading data into table...",
			    },
				"sPaginationType": "full_numbers",
				"aoColumns": [
				  { "bSortable": false, "bSearchable": false },
				  null,
				  null,
				  null,
				  null,
				  null,
				  null,
				  null
				]
			});
			$('#dataTable_wrapper').css("width", "1200px");
		});		
		$.get("loadcourses.php", function(result) {
			$("#dataTable").dataTable().fnAddData(JSON.parse(result));
		});
	</script>        
	<?php
		if(isset($_GET['search'])) {
			echo "<script>$(document).ready(function (){	$('#dataTable_filter > label > input').val('".$_GET['search'] ."'); });</script>";
		}
	?>
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
				<li class="current_page_item"><a href="courses.php">View All Courses</a></li>
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
	<div id="table-blocks">
		<table cellpadding="0" cellspacing=0" border="0" class="display" id="dataTable">
			<thead>
				<th>Sort By: </th>
				<th>Course Name</th>
				<th>Category</th>
				<th>Start Date</th>
				<th>Course Length(Weeks)</th>
				<th>Professor(s)</th>
				<th>Instructor Image</th>
				<th>Site</th>
			</thead>
			<tbody>
			</body>
		</table>
	</div>
	<?php include('includes/footer.php'); ?>
</body>
</html>
