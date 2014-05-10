<?php 
	require_once('connect.php');
	$sql = "SELECT * FROM `averagerating`";
	echo $sql."<br/>";
	$results = $mysqli->query($sql);
	while($row = mysqli_fetch_array($results)) {
		print_r($row);
		$sql2 = "UPDATE `averagerating` SET avgrate=".$row['rating']/$row['numvotes']. " where id=".$row['id'];
		if($results2 = $mysqli->query($sql2)) {
			echo "success: "; 
		} else {
			echo "fail: ";
		}
		echo $sql2."<br/>";
	}
	echo "exiting while loop";
?>