<?php
	session_start(); /* Starts the session for the user */
	if(isset($_SESSION['id'])) {
		header("location: user.php?id".$_SESSION['id']);
	}
	$first = "";
	$last = "";
	$email = "";
	$redirect = "";
	
	$firsterror = "";
	$lasterror = "";
	$emailerror = "";
	$pass1error = "";
	$pass2error = "";
	$error = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$first = $_POST['firstname'];
		$last = $_POST['lastname'];
		$email = $_POST['email'];
		
		if (strlen($_POST['firstname']) == 0){
			$firsterror = "*";
		} 
		if (strlen($_POST['lastname']) == 0){
			$lasterror = "*";
		} 
		if (strlen($_POST['email']) == 0){
			$emailerror = "*";
		} 
		if (strlen($_POST['pass1']) == 0){
			$pass1error = "*";
		} 
		if (strlen($_POST['pass2']) == 0){
			$pass2error = "*";
		} 
		if($_POST['pass1'] !== $_POST['pass2']) {
			$error .= "Your passwords do not match. ";
		}
		
		if(strlen($_POST['pass1']) > 0 && strlen($_POST['pass2']) > 0 && $_POST['pass1'] === $_POST['pass2']) {
			$pass = $_POST['pass1'];
			
			require_once("connect.php");
			$stmt = $mysqli->prepare("INSERT INTO users VALUES(?,?,?,?,?)");
			$stmt->bind_param('issss', $id, $first, $last, $email, $pass); 
			$stmt->execute();
						
			$results = mysqli_stmt_affected_rows($stmt);
			if($results == 1) {
				$sql = "SELECT * from `users` where email='".$email."' LIMIT 1";
				$raw_results = $mysqli->query($sql);		
				if($row = mysqli_fetch_array($raw_results)) {
					$_SESSION['id']=$row['id'];
					$_SESSION['email'] = $row['email'];
					$redirect = "<script>$(document).ready(function() {document.location = 'user.php?id=".$row['id']."'	});</script>";
					//header('Location: user.php?id='.$row['id']);header("location: user.php?id=");
					//$error = "You have successfully registered! Login <a href=\"login.php\">here</a>";
					//$error = "Login successful";
				}
			} else {
				$error = "Someone has already registered with this email.";
			}
			
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>MoocDynasty</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>		
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
				<li><a href="index.php">Homepage</a></li>
				<li><a href="courses.php">View All Courses</a></li>
				<li><a href="about.php">About Us</a></li>
				<li><a href="login.php">Login</a></li>
				<li class="current_page_item"><a href="register.php">Register</a></li>
			</ul>
		</div>
	</div>
	<div id="blocks">
		<div class="inside">
			<form action="register.php" method="post">
				<div><input type="text" placeholder="First Name" id="firstname" name="firstname" value="<?php echo $first;?>"/><span id="error"><?php echo $firsterror; ?></span></div>
				<div><input type="text" placeholder="Last Name" name="lastname" value="<?php echo $last;?>"/><span id="error"><?php echo $lasterror; ?></span></div>
				<div><input type="text" placeholder="Email" name="email" value="<?php echo $email;?>"/><span id="error"><?php echo $emailerror; ?></span></div>
				<div><input type="password" placeholder="Password" name="pass1"/><span id="error"><?php echo $pass1error; ?></span></div>
				<div><input type="password" placeholder="Confirm Password" name="pass2"/><span id="error"><?php echo $pass2error; ?></span></div>
				<div><input id="register" type="submit" value="Register" /></div>
				<div id="error"><?php echo $error; ?></div>
			</form>
		</div>
		<?php echo $redirect; ?>
	</div>
	<div id="footer">
		<div class="inside">
			<p>MoocDynasty &copy; 2014   | SJSU CS160</p>
		</div>
	</div>
</body>
</html>
