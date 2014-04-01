
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<style type="text/css">
body {
	background: #E5E5E5;
	margin: 30px auto;
	font: 100%/140% Arial, Helvetica, sans-serif;
}
.credits {
	margin-bottom: 80px;
	padding-bottom: 30px;
	border-bottom: solid 1px #ccc;
}

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

/* search form 
-------------------------------------- */
.searchform {
	display: inline-block;
	zoom: 1; /* ie7 hack for display:inline-block */
	*display: inline;
	border: solid 1px #d2d2d2;
	padding: 3px 5px;
	
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
			.course_image img {
				width: 200px;
				height: 150px;
			}
			.profimg img {
				border: 1px black solid;
			}
			th, td {
				width: 200px;
			}
			th {
				height: 50px;
			}
			td {
				text-align: center;
			}
			tbody tr:nth-child(odd) {
			   background-color: #ccc;
			}
			tbody tr:nth-child(even) {
			   background-color: white;
			}
		</style>
	</head>
	<body id="dt_example">
		<div class="container" id="container">
		<div style="float: left; font-size: 30px; margin-left: 30px;">MOOC Dynasty</div>
		<div class="container2" style="width: 300px; margin: 0 auto;">
		<form class="searchform" style="margin-bottom: 20px;">
			<input class="searchfield" type="text" value="Search..." onfocus="if (this.value == 'Search...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search...';}">
			<input class="searchbutton" type="button" value="Go">
		</form>
		</div>
<?php
	$mysqli = mysqli_connect("localhost", "root", "", "scrapedcourse");
	$raw_results = $mysqli->query("SELECT * FROM data");
	
	$results = "<table cellpadding=\"0\" cellspacing=\"0\" border=\"0\" class=\"display\" id=\"searchTable\"><thead>
					<tr>
						<th>Image</th>
						<th>Course Name</th>
						<th>Category</th>
						<th>Start Date</th>
						<th>Course Length(Weeks)</th>
						<th>Professor(s)</th>
						<th>Instructor Image</th>
						<th>Site</th>
					</tr>
				</thead>
				<tbody>";
	while($row = mysqli_fetch_array($raw_results)) {
		$results .=("<tr>
						<td class='course_image'><img src='".$row['course_image']."'/></td>
						<td>".$row['title']."</td>
						<td>".$row['category']."</td>
						<td>".$row['start_date']."</td>
						<td>".$row['course_length']."</td>
						<td>".$row['profname']."</td>
						<td class=\"profimg\"><img src='".$row['profimage']."'/></td>
						<td>".$row['site']."</td>
					</tr>");
	}
	$results.="</tbody></table>";
	echo $results;
?>
		</div>
	</body>
</html>