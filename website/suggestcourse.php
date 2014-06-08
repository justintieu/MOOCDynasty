<?php
	if ( !isset($_REQUEST['term']) ) {
		exit;
	}
	require_once('includes/connect.php');
	$sql = 'SELECT * FROM course_data where title like "'. $_REQUEST['term'] .'%" order by title asc, start_date desc limit 10';
	$results = $mysqli->query($sql);
	$data = array();
	if ( $results && mysqli_num_rows($results) ) {
		while( $row = mysqli_fetch_array($results) ) {
			$start_date = $row['start_date'] === "0000-00-00" ? "Self Paced" : $row['start_date'];
			$data[] = array(
				'label' => $row['title'] . ' (Start Date: ' . $start_date . ')',
				'value' => $row['title'],
			);
		}
	}

	echo json_encode($data);
	flush();
?>