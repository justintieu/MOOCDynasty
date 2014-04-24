<!DOCTYPE HTML>
<head>
		<style>
			#ErrorMessage
			{
				color: red;
			}
			
			#h
			{
				font-size: 15pt;
			}
			
			#container
			{
				margin-left:20px;
			}
			
			#gender, #file, #description, #bday, #courses
			{
				color: red;
			}
		</style>

</head>
<body>	
	<div id="h">Update Profile</div>
	<div id="container">
	<form action="UpdateProfile.php" method="POST">
		
		<!-- Remember to check for stupid errorrsrssrsr. -->
		
		<p>
		Name: grab from database
		</p>
		
		<p>
		E-Mail: grab from database
		</p>
		
		<p>
		<label for="gender">Gender: </label>
		<label for="female">Female: </label>
		<input type="radio" name="gender" id="female" value="<?php ?>"/>
		<label for="rdomale">Male: </label>
		<input type="radio" name="gender" id="male" value="<?php ?>"/><br/>
		<span id="gender"></span>
		</p>
		
		<p>
		<label for="file">Profile Picture:</label>
		<input type="file" name="file" value="<?php ?>">
		<span id="file"></span>
		</p>
		
		<p>
		<label for="birthday">Date of Birth: </label>
		<input type="date" name="bday" value="<?php ?>">
		</p>
		
		<p>
		<label for="field">Field of Interest:</label>
		<input type="text" name="field" id="field" onblur="validateForm()" value="<?php if(isset($_POST["field"])) print $_POST["field"]; ?>"/>
		<span id="field"></span>
		</p>
		
		<p>
		<label for="description">Description :</label><br/>
		<textarea rows="15" cols="60" name="description"></textarea>
		<span id="description"></span>
		</p>
		
		<p>
		<label for="courses">Course History:</label>
		<input type="courses" name="courses" id="courses" onblur="validateForm()" value=""/>
		<span id="courses"></span>
		</p>
		 
		<input type="submit" value="Submit">
	</form>
</body>
