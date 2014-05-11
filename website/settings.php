<?php
	session_start();
	if(!isset($_SESSION['id'])) {
		header('location: index.php');
	}
	require_once('includes/connect.php');
	$sql = "SELECT * FROM `users` where id=".$_SESSION['id']." LIMIT 1";
	$first = "";
	$last = "";
	$email = "";
	$password = "";
	$bio = "";
	$profileimage = "";
	$error = "";
	$results = $mysqli->query($sql);
	
	while($row = mysqli_fetch_array($results)) {
		$first = $row['first'];
		$last = $row['last'];
		$email = $row['email'];
		$bio = $row['bio'];
		$profileimage = $row['image'];
		$password = $row['password'];
	}		
	
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$first = $_POST['first'];
		$last = $_POST['last'];
		$email = $_POST['email'];
		$bio = $_POST['bio'];
		$profileimage = $_POST['image'];
		if($_POST['pass'] == $password) {
			$error = "";
			$sql = "";
			if(strlen($_POST['newpass']) > 0) {
				if(strlen($_POST['confpass']) == 0) {
					$error = "Please confirm your new password.";
				} else if($_POST['newpass'] !== $_POST['confpass']) {
					$error = "Your new password did not match the confirm box.";
				} else {
				$sql = "UPDATE `users` SET first='".$first."', last='".$last."', email='".$email."', bio='".$bio."', image='".$profileimage."' password='".$_SESSION['newpass']."' where id=".$_SESSION['id'];
				}
			} else {
				$sql = "UPDATE `users` SET first='".$first."', last='".$last."', email='".$email."', bio='".$bio."', image='".$profileimage."' where id=".$_SESSION['id'];
			}
			if($results = $mysqli->query($sql)) {
				$error = "Account has been updated.";
			} else {
				$error = "Another account is using this email. ";
			}
			
		} else {
			$error = "Please enter your current password to update settings.";
		}
		
	}
?>
 <!DOCTYPE HTML>
<html>
<head>
<title>Settings | MoocDynasty</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
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
				<li><a href="about.php">About Us</a></li>
					 <?php
						if(isset($_SESSION['id'])) {
							echo "<li><a href=\"user.php?id=".$_SESSION['id']."\">Profile</a></li>";
							echo "<li class=\"current_page_item\"><a href=\"settings.php\">Settings</a></li>";
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
		<div class="title"><h2>Settings</h2></div>
		<div class="inside">
			<form action="settings.php" method="POST" style="width: 600px; margin: 0 auto;">
			<div style="color: red;"><?php echo $error;?></div>
				<div>
					<label for="first" style="float:left;" >First name</label>
					<input name="first" id="first" style="float: right;" value="<?php if(isset($first)) {echo $first;}?>"/>
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="last" style="float:left;" >Last name</label>
					<input name="last" id="last" style="float: right;"  value="<?php if(isset($last)) {echo $last;}?>"/>
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="email" style="float:left;" >Email</label>
					<input name="email" id="email" style="float: right;" value="<?php if(isset($email)) {echo $email;}?>" />
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="image" style="float:left;" >Bio</label>
					<textarea name="bio" id="bio" style="float: right;" cols="50" rows="10"><?php if(isset($bio)) {echo $bio;}?></textarea>
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="image" style="float:left;" >Profile Image</label>
					<input name="image" id="image" style="float: right;" value="<?php if(isset($profileimage)) {echo $profileimage;}?>" />
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="pass" style="float:left;" >Current Password</label>
					<input name="pass" id="pass" type="password" style="float: right;" />
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="newpass" style="float:left;" >New Password</label>
					<input name="newpass" id="newpass" type="password" style="float: right;" />
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="confpass" style="float:left;" >Confirm New Password</label>
					<input name="confpass" id="confpass" type="password" style="float: right;" />
				</div>
				<div style="clear:both;"></div>
				<div>
					<label for="submit"></label>
					<input id="update" type="submit" value="Update Account" />
				</div>
			</form>
		</div>
	 </div>
	 <?php include('includes/footer.php'); ?>
</body>
</html>
