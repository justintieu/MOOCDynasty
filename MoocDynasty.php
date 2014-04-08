<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<style type="text/css">
			body {
				background: #E5E5E5;
				margin: 30px auto;
				font: 100%/140% Arial, Helvetica, sans-serif;
			}
			
			.container {
				width: 1200px;
				margin: auto;
			}
			
			/* logo
			-------------------------------------- */
			#logo {
				float: left; 
				font-size: 30px; 
				margin-left: 30px;
				width: 30%;
			}
			
			
			/* search form 
			-------------------------------------- */
			.searchform {
				display: inline-block;
				zoom: 1; /* ie7 hack for display:inline-block */
				*display: inline;
				border: solid 1px #d2d2d2;
				padding: 3px 5px;
				margin: -10px 0 20px 0;

				-webkit-border-radius: 2em;
				-moz-border-radius: 2em;
				border-radius: 2em;

				-webkit-box-shadow: 0 1px 0px rgba(0,0,0,.1);
				-moz-box-shadow: 0 1px 0px rgba(0,0,0,.1);
				box-shadow: 0 1px 0px rgba(0,0,0,.1);

				background: #f1f1f1;
				background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ededed));
				background: -moz-linear-gradient(top,  #fff,  #ededed);
				filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed'); /* ie7 */
				-ms-filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed'); /* ie8 */
			}
			.searchform input {
				font: normal 12px/100% Arial, Helvetica, sans-serif;
			}
			.searchform .searchfield {
				background: #fff;
				padding: 6px 6px 6px 8px;
				width: 202px;
				border: solid 1px #bcbbbb;
				outline: none;

				-webkit-border-radius: 2em;
				-moz-border-radius: 2em;
				border-radius: 2em;

				-moz-box-shadow: inset 0 1px 2px rgba(0,0,0,.2);
				-webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,.2);
				box-shadow: inset 0 1px 2px rgba(0,0,0,.2);
			}
			.searchform .searchbutton {
				color: #fff;
				border: solid 1px #494949;
				font-size: 11px;
				height: 27px;
				width: 27px;
				text-shadow: 0 1px 1px rgba(0,0,0,.6);

				-webkit-border-radius: 2em;
				-moz-border-radius: 2em;
				border-radius: 2em;

				background: #5f5f5f;
				background: -webkit-gradient(linear, left top, left bottom, from(#9e9e9e), to(#454545));
				background: -moz-linear-gradient(top,  #9e9e9e,  #454545);
				filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#9e9e9e', endColorstr='#454545'); /* ie7 */
				-ms-filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#9e9e9e', endColorstr='#454545'); /* ie8 */
			}
			
			
			/* table 
			-------------------------------------- */
			thead {
				color: white;
				background-color: #1b1b1b;
				background-image: -moz-linear-gradient(top, #222222, #111111);
				background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#222222), to(#111111));
				background-image: -webkit-linear-gradient(top, #222222, #111111);
				background-image: -o-linear-gradient(top, #222222, #111111);
				background-image: linear-gradient(to bottom, #222222, #111111);
				background-repeat: repeat-x;
				filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff222222', endColorstr='#ff111111', GradientType=0);
				border-color: #252525;
			}
			tbody tr:nth-child(odd) {
			   background-color: #ccc;
			}
			tbody tr:nth-child(even) {
			   background-color: white;
			}
			th, td {
				width: 10%;
			}
			th {
				height: 50px;
			}
			td {
				text-align: center;
			}
			a {
				color: black;
				text-decoration: none;
			}
			.course_image img {
				width: 200px;
				height: 150px;
			}
			.profimg img {
				border: 1px black solid;
				width: 100px;
				height: 100px;
			}
			
		</style>
	</head>
	<body id="dt_example">
		<div class="container" id="container">
		<div class="header">
			<div id="logo" style="">MOOC Dynasty</div>
			<form class="searchform">
				<input class="searchfield" type="text" value="Search..." onfocus="if (this.value == 'Search...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search...';}">
				<input class="searchbutton" type="button" value="Go">
			</form>
		</div>
			<?php
				$mysqli = mysqli_connect("localhost", "root", "", "scrapedcourse");
				$raw_results1 = $mysqli->query("SELECT * FROM course_data order by rand()");

				$results = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"searchTable\"><thead>
								<tr>
									<th>Image</th>
									<th>Course Name</th>
									<!--th>Category</th-->
									<th>Start Date</th>
									<th>Course Length(Weeks)</th>
									<th>Professor(s)</th>
									<th>Instructor Image</th>
									<th>Site</th>
								</tr>
							</thead>
							<tbody>";
				while($row = mysqli_fetch_array($raw_results1)) {
					$raw_results2 = $mysqli->query("SELECT * FROM `coursedetails` where `course_id`=".$row['id']);
					$startDate = $row['start_date']=="0000-00-00" ? "Self Paced" : $row['start_date'];
					$courseLength = $row['course_length']=="0" ? "Self Paced" : $row['course_length'];
					$results .="<tr>
									<td class='course_image'><a href=\"".$row['course_link']."\" target=\"_blank\"><img src='".$row['course_image']."'/></a></td>
									<td><a href=\"".$row['course_link']."\" target=\"_blank\">".$row['title']."</a></td>
									<!--td>".$row['category']."</td-->
									<td>".$startDate."</td>
									<td>".$courseLength."</td>";
					while($row2 = mysqli_fetch_array($raw_results2)) {
						$results .="<td>".$row2['profname']."</td>
									<td class=\"profimg\"><img src='".$row2['profimage']."'/></td>";
				 	}
					$results .= "<td>".$row['site']."</td>
								</tr>";
				}
				
				$results.="</tbody></table>";
				echo $results;
			?>
		</div>
	</body>
</html>
