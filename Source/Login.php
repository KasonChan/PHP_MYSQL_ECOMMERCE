<!-- 
-- 
-- // *************************************************************
-- // Project
-- // CSCE 4350, Fall 2012
-- // Programmer: Ka Son Chan KaSonChan@my.unt.edu
-- // Instructor: Dr. Yan Huang
-- // Date: December 2, 2012
-- // *************************************************************
-- 
 -->

<html>
	<head>
    	<title>B&M</title>
    	<link rel = "stylesheet" type = "text/css" href = "style.css"/>
    </head>
    <body>
    	<div class=PageContainer>
	    	<h2>Welcome to B&M</h2>
			<?php
				require_once("DatabaseFunctions.php");

				$con = ConnectDatabase();

				// getCategories();

			?>
			<iframe class=frame src="http://students.cse.unt.edu/~kc0284/CSCE4350Project/LoginMain.php" scrolling="auto" height="200px"> </iframe>
		</div>
	</body>
</html> 
