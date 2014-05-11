<?php
	if ( !isset($_REQUEST['term']) ) {
		exit;
	}
	require_once('includes/connect.php');
	$sql = 'SELECT * FROM course_data where title like "'. $_REQUEST['term'] .'%" order by title asc limit 10';
	$results = $mysqli->query($sql);
	$data = array();
	if ( $results && mysqli_num_rows($results) ) {
		while( $row = mysqli_fetch_array($results) ) {
			$data[] = array(
				'label' => $row['title'] ,
				'value' => $row['title']
			);
		}
	}

	echo json_encode($data);
	flush();
?>