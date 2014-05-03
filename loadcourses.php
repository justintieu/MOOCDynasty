<?php	
	require_once("connect.php");
	
	$raw_results1 = $mysqli->query("SELECT * FROM course_data ORDER BY id ASC");	
	$results = "";
	$course_data = array();
	while($row = mysqli_fetch_array($raw_results1)) 
	{	
		$raw_results2 = $mysqli->query("SELECT * FROM `coursedetails` where `course_id`=".$row['id']." LIMIT 1");
		$course_link = $row['course_link'];
		$id = $row['id'];
		$start_date = $row['start_date']=="0000-00-00" ? "Self Paced" : $row['start_date'];		
		$course_length = $row['course_length']=="0" ? "Self Paced" : $row['course_length']." weeks";		
		$course_image = "";
		$prof_image = "";
		$prof_name = "";
		if(substr($row['course_image'],0,2 === "//")) {
			$course_image = "http:".$row['course_image'];
		} else if(substr($row['course_image'],0,4) === "http") {
			$course_image = $row['course_image'];
		} else {
			$course_image = "http://".$row['course_image'];
		}
		/*$results .="<tr><td class='course_image'><a href=\"course.php?id=".$row['id']."\" target=\"_blank\"><img src='".$course_image."'/></a></td><td>".$row['id']."</td><td><a href=\"course.php?id=".
		$row['id']."\" target=\"_blank\">".
		$row['title']."</a></td><td>".$row['category']."</td><td>".$startDate."</td><td>".
		$courseLength."</td>";		*/
		while($row2 = mysqli_fetch_array($raw_results2)) 
		{								
			$prof_image = "";
			if(substr($row2['profimage'],0,4)=== "http") {
				$prof_image = $row2['profimage'];
			} else {
				$prof_image = "http://".$row2['profimage'];
			}
			$prof_name = $row2['profname'];
			//$results .="<td>".$row2['profname']."</td><td class=\"profimg\"><img src='".$prof_image."'/></td>";		
		}		
		//$results .= "<td>".$row['site']."</td></tr>";	
		
		$course = array (
            '<a class="course_img" href="course.php?id=' . $id . '"><img src="' . $course_image . '" width="200px" height="150px" /></a>',  
            '<a class="course_img" href="course.php?id=' . $id . '">'.$row['title'].'</a>',
            $row['category'],
            $start_date,
            $course_length,
            $prof_name,
			"<img style='border: 1px solid black;' src='" . $prof_image . "' width='100px' height='100px' />",
            $row['site']
        );
		$course_data[] = $course;
	}	
    echo json_encode($course_data);
?>