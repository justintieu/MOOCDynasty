**Table of Contents**  *generated with [DocToc](http://doctoc.herokuapp.com/)*

- [MOOCDynasty](#user-content-moocdynasty)
	- [Aggregated Websites](#user-content-aggregated-websites)
	- [Features](#user-content-features)
		- [One Common Search/Browse, One Common Filter/Sort Results](#user-content-one-common-searchbrowse-one-common-filtersort-results)
		- [Auto-complete](#user-content-auto-complete)
		- [User Profiles](#user-content-user-profiles)
		- [5-Star Rating System](#user-content-5-star-rating-system)
		- [Top 7 Courses](#user-content-top-7-courses)

##MOOCDynasty
Massive open online courses have become a key part of people’s lives in society today. As the cost of education increases, there are people, such as professionals and students, trying to find additional resources either to learn new skills, supplement what they are doing in their jobs, or help with further understanding of a specific subject.
 
With a new website that aggregates different popular massive open online course websites within a single search, students and professionals will be able to find a particular course more efficiently with additional innovative features such as user profiles, five star rating system, top seven courses, and auto-complete.

----------
##Aggregated Websites
1. Canvas
2. Coursera
3. EdX
4. FutureLearn
5. Iversity
6. NovoEd
7. Open2Study
8. Udacity

##Features
1. One Common Search/Browse
2. One Common Filter/Sort Results
3. Auto-complete
4. User Profiles
5. 5-Star Rating System
6. Top 7 Courses

###One Common Search/Browse, One Common Filter/Sort Results
The common search/browse and filter/sort results was done by using a jQuery plug-in, DataTables (https://datatables.net/). In order to have the plugin work, we had the following lines of code in our page and adjusted the class/ids of the different tags based on the CSS file.
```
<link rel="stylesheet" href="http://cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
<script type="text/javascript">
$(document).ready(
    $('#table-id').dataTable();
});
</script>
```

###Auto-complete
Autocomplete was created by using jQuery UI. 
```
<script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.searchfield').autocomplete({source:'suggestcourse.php', minLength:2});
});
</script>
```
Within the first parameter, the autocomplete function accepts JSON (which was created by the suggestcourse.php file) and in the second parameter, minLength dictates the minimum length that much be in the search form before autocomplete begins.

###User Profiles
Here is the SQL table used for Users. 
Field  | Type
------------- | -------------
id  | int(11)
first | varchar(30)
last | varchar(30)
email | varchar(128)
password | varchar(30)
bio | text
image | text

During registration, there will be different default values set for values not asked. The form will simply be inserted and updated if necessary after the user is logged in.


###5-Star Rating System
Here is the SQL table used for the 5 star rating system. 
Field  | Type
------------- | -------------
course_id | int(4)
title | text
rating | double
review | text
student_id | int(4)
time_submitted | datetime

The 5-star rating system isn't very complex. It uses a form that takes in the necessary information and inserts itself into the table. 

###Top 7 Courses
Here is the SQL table used for Top 7 Courses. 
Field  | Type
------------- | -------------
id  | int(11)
course_id | int(11)
rating | int(11)
numvotes | int(11)
avgrate | double

The Top 7 Courses features checks if the course already exists in this table. If the course already exists, there will be an update, else there will be an insert. 






