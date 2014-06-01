<?php
	require_once('../includes/connect.php');
	$sql = "SELECT * FROM `averagerating`";
	$results = $mysqli->query($sql);
	while($row = mysqli_fetch_array($results)) {
		$sql2 = "SELECT * FROM `course_ratings` where course_id=".$row['course_id'];
		$rating = 0;
		$results2 = $mysqli->query($sql2);
		while($row2 = mysqli_fetch_array($results2)) {
			$rating = $rating + $row2['rating'];
		} 
		$numvotes = mysqli_num_rows($results2);
		$sql3 = "UPDATE `averagerating` SET rating=".$rating.", numvotes=".($numvotes).", avgrate=".($rating)/($numvotes)." where course_id=".$row['course_id'];
		echo $sql3."<br/>";
		$results3 = $mysqli->query($sql3);
	}
?>