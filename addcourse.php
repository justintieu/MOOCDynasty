<?php
session_start();
require 'connect.php';

if(isset($_SESSION['id'])){
    $userId = $_SESSION['id'];
    $class = $_GET['id'];
    $query=$mysqli->prepare("INSERT INTO student_courses VALUES(?,?)");
    $query->bind_param('ii', $userId, $class);
    $query->execute();
    header('Location: user.php?id='.$userId);
} else{
    echo 'Please Login';
}

?>
