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
	    	<h2>Login</h2>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<?php
					echo "<script type=\"text/javascript\">";
					echo "var url ='Homepage.php';";
					echo "var delay = 0;";
					echo "var d = delay * 1000;";
					echo "window.setTimeout ('parent.location.replace(url)', d);";
					echo "</script>";
			    ?>  
			</form>
		</div>
	</body>
</html> 
