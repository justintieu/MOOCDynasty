<!DOCTYPE HTML>
<head>
		<style>
			#ErrorMessage
			{
				color: red;
			}
			
			#acc
			{
				font-size: 15pt;
			}
			
			#container
			{
				margin-left:20px;
			}
			
			#f, #l, #u, #pw, #n, #e
			{
				color: red;
			}
		</style>
		<script type="text/javascript">
			function validateEmail()
			{
				ErrorMessage="";
				ErrorMessage += email();
					
				if(ErrorMessage.length>0)
				{
					document.getElementById("ErrorMessage").innerHTML = ErrorMessage;
					document.getElementById("ErrorMessage").style.display = "block";
				}
				
				return false;
			}
			
			function validatePassword()
			{
				ErrorMessage="";
				ErrorMessage += pw();
					
				if(ErrorMessage.length>0)
				{
					document.getElementById("ErrorMessage").innerHTML = ErrorMessage;
					document.getElementById("ErrorMessage").style.display = "block";
				}
				
				return false;
			}
			
			function pw()
			{
				var Error="";
				var Char = /^(\w*(\d+[a-zA-Z]|[a-zA-Z]+\d)\w*)+$/;
				if(document.getElementById("pw").value.length<8 || document.getElementById("pw").value.match(Char)==null)
				{
					document.getElementById("pw").innerHTML = "* Invalid password.";
				}
				else
				{
					document.getElementById("pw").innerHTML = "";
					Error = "";
				}
				return Error;
			}
			
			function email()
			{
				var Error="";
				var Char = /^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/;
				if(document.getElementById("email").value.match(Char)==null || document.getElementById("email").value.length==0)
				{
					document.getElementById("e").innerHTML = "* Invalid e-mail address.";
				}
				else
				{
					document.getElementById("e").innerHTML = "";
					Error = "";
				}
				return Error;
			}		
		</script>
		
		<?php
			$ErrorMessage2 = "";
			$firstError="";
			$lastError="";
			$emailError="";
			$pwError="";
			$ErrorCount = 0;

			$mysqli = mysqli_connect("localhost", "root", "", "test");
			
			if($_SERVER["REQUEST_METHOD"] == "POST") {				
				if(!preg_match("/^[A-Za-z]+/", $_POST["first"]) || strlen($_POST["first"])==0){
					$firstError .= "* Invalid first name. ";
					$ErrorCount++;
				}
				if(!preg_match("/^[A-Za-z]+/", $_POST["last"]) || strlen($_POST["last"])==0){
					$lastError .= "* Invalid last name. ";
					$ErrorCount++;
				}
				if(!preg_match("/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/", $_POST["email"]) || strlen($_POST["email"])==0){
					$emailError .= "* Invalid e-mail. ";
					$ErrorCount++;
				}
				if(!preg_match("/^(\w*(\d+[a-zA-Z]|[a-zA-Z]+\d)\w*)+$/", $_POST["pw"]) || strlen($_POST["pw"])<8){
					$pwError .= "* Invalid password. ";
					$ErrorCount++;
				}
			
				if($ErrorCount==0)
				{
					//prepared statements!
					$sql = "SELECT * FROM Users WHERE Email = '".$_POST["email"]."'"; //searches whatever is put in the form in the products database
					$res = $mysqli->query($sql);
					
					if($res->num_rows > 0)
					{
						$ErrorMessage2 = "Account already exists";
					}
					else
					{
						$stmt = $mysqli->prepare("INSERT INTO users VALUES(?,?,?,?,?)");
						$stmt->bind_param('dssss', NULL, $_POST["first"], $_POST["last"], $_POST["email"], $_POST["pw"]); //put it in the parameters
						$stmt->execute();
						
						$results = mysqli_stmt_affected_rows($stmt); //check if it is in the database
						
						if($results>0) //results>0 means added
						{
							$ErrorMessage2 = header("Location: UpdateProfile.php");
						}
						else if($results<0)//results<0 did not add row
						{
							$ErrorMessage2 = "Account already exists";
						}
					}		
				} 
			}			
		?>
</head>
<body>	
	<span id="acc">Create an account.</span>
	<span id="ErrorMessage"></span><span id="acc"><?php echo $ErrorMessage2; ?></span>
	<div id="container">
	<form action="CreateAccount.php" method="POST">
		<label for="first">First Name:</label>
		<input type="text" name="first" id="first" value="<?php if(isset($_POST["first"])) print $_POST["first"]; ?>"/>
		<span id="f"><?php print $firstError; ?></span>
		<br/>
		
		<label for="last">Last Name:</label>
		<input type="text" name="last" id="last" value="<?php if(isset($_POST["last"])) print $_POST["last"]; ?>"/>
		<span id="l"><?php print $lastError; ?></span>
		<br/>
		
		<label for="email">E-Mail:</label>
		<input type="text" name="email" id="email" onblur="validateEmail()" value="<?php if(isset($_POST["email"])) print $_POST["email"]; ?>"/>
		<span id="e"><?php print $emailError; ?></span>
		<br/>
		
		<label for="pw">Password:</label>
		<input type="password" name="pw" onblur="validatePassword()" value=""/>
		<span id="pw"><?php print $pwError; ?></span>
		<br/>
		
		<br/>
					

  <script type="text/javascript"
     src="http://www.google.com/recaptcha/api/challenge?k=6LfKR-sSAAAAANFck-mHPeyU5mw0je6SwkqCtPZg">
  </script>
  <noscript>
     <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LfKR-sSAAAAANFck-mHPeyU5mw0je6SwkqCtPZg"
         height="300" width="500" frameborder="0"></iframe><br>
     <textarea name="recaptcha_challenge_field" rows="3" cols="40">
     </textarea>
     <input type="hidden" name="recaptcha_response_field"
         value="manual_challenge">
  </noscript>
  
  		<input type="submit" value="Submit">
	</form>
	</div>
</body>
