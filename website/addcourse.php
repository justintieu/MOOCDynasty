<?php
session_start();
require_once('includes/connect.php');

if(isset($_SESSION['id'])){
    $userId = $_SESSION['id'];
    $class = $_GET['id'];
	$result = $mysqli->query("SELECT * FROM student_courses where userid=".$userId." AND courseid=".$class);
	if(mysqli_num_rows($result) == 0) {
		$query=$mysqli->prepare("INSERT INTO student_courses VALUES(?,?)");
		$query->bind_param('ii', $userId, $class);
		$query->execute();
	}
    header('Location: user.php?id='.$userId);
} else{
    //echo 'Please Login';
	header('Location: login.php');
}

?>
