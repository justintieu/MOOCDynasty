<?php
	session_start(); 
	if(isset($_SESSION['id'])) {
		header("location: user.php?id".$_SESSION['id']);
	}
	$email = "";
	$error = "";
	$redirect = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		$email = $_POST['email'];
		if(strlen($_POST['pass']) > 0) {
			require_once('includes/connect.php');
			$sql = "SELECT * from `users` where email='".$email."' LIMIT 1";
			$raw_results = $mysqli->query($sql);
			if(mysqli_num_rows($raw_results) == 0) {
				$error = "Email does not exist in database. You can register <a href=\"register.php\">here</a>!";
			} else {
				while($row = mysqli_fetch_array($raw_results)) {
					if($_POST['pass'] === $row['password']) {
						$_SESSION['id']=$row['id'];
						$_SESSION['email'] = $row['email'];
						$redirect = "<script>$(document).ready(function() {document.location = 'user.php?id=".$row['id']."'	});</script>";
					} else {
						$error = "Incorrect password.";
					}
				}
			}
		} else {
			$error = "Don't forget to type your password!";
		}
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Login | MoocDynasty</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="css/style.css" />
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
				<li class="current_page_item"><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
			</ul>
		</div>
	</div>
	<div id="blocks">
		<div class="inside">
			<form action="login.php" method="post"><div><input type="text" placeholder="Email" name="email" value="<?php echo $email;?>"/></span></div>
				<div><input type="password" placeholder="Password" name="pass"/></div>
				<div><input id="login" type="submit" value="Login" /></div>
				<div id="error"><?php echo $error; ?></div>
			</form>
		</div>
		<?php echo $redirect; ?>
	</div>
	<?php include('includes/footer.php'); ?>
</body>
</html>
