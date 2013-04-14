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
    	<script>
			function showHint(str)
			{
			var xmlhttp;
			if (str.length==0)
			  { 
			  document.getElementById("txtHint").innerHTML="";
			  return;
			  }
			if (window.XMLHttpRequest)
			  {// code for IE7+, Firefox, Chrome, Opera, Safari
			  xmlhttp=new XMLHttpRequest();
			  }
			else
			  {// code for IE6, IE5
			  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			  }
			xmlhttp.onreadystatechange=function()
			  {
			  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			    {
			    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
			    }
			  }
			xmlhttp.open("GET","gethint.php?q="+str,true);
			xmlhttp.send();
			}
		</script>
		<script src="jquery.js"></script>
		<script>
			$(document).ready(function()
			{
				$("button").click(function()
				{
			    	$(".td1").toggle();
			  	});
			});
		</script>
    </head>

    <body>
    	<div class=PageContainer>
	    	<h2>Welcome to B&M</h2>
	    	<?php
	    		require_once("DatabaseFunctions.php");

				$con = ConnectDatabase();

	    		$IP = $_SERVER['REMOTE_ADDR'];
	    		if(trim(getEmail($IP)) == '')
	    		{
	    			echo "<form action=\"Homepage.php\">";
		    		echo "<p /*align=\"right\"*/>" . "<button>" . "Login" . "</button>" . "</p>";
		    		echo "</form>";
		    	}
		    	else
		    	{
		    		// echo "<p align=\"right\">" . "You are logged in as: " . "<b>" . getEmail($IP) . "</b>" . "</p>";
		    		// echo "<form action=\"Logout.php\">";
		    		// echo "<p align=\"right\">" . "<button>" . "Logout" . "</button>" . "</p>";
		    		// echo "</form>";
		    		// echo "<form action=\"Cart.php\">";
		    		// echo "<p align=\"right\">" . "<input type=\"image\" src=\"shoppingcart.jpg\" width=\"30\" height=\"30\" >" . "</p>";
		    		// echo "</form>";
				}
			?>
	    	<form action="Homepage.php" method="get">
				<?php
					echo "<p>" . "<input type=\"text\" name=\"name\" onkeyup=\"showHint(this.value)\" />" . "<input type=\"submit\" class=Button value=\"Search\" />" . "</p>";
					echo "<p>" . "Suggestions: " . "<span id=\"txtHint\">" . "</span>" . "</p>";
				?>
			</form>

			<h3>Logout</h3>
			<?php 
				echo "You are logged out from " . "<b>" . getEmail($IP) . "</b>" . "." . "</p>";
				
				removeIP(getEmail($IP));

				// echo "<script type=\"text/javascript\">";
				// echo "var url ='Homepage.php';";
				// echo "var delay = 5;";
				// echo "var d = delay * 1000;";
				// echo "window.setTimeout ('parent.location.replace(url)', d);";
				// echo "</script>";

				$url = 'http://students.csci.unt.edu/~kc0284/CSCE4350Project/Homepage.php';
    			echo '<META HTTP-EQUIV=Refresh CONTENT="5; URL='.$url.'">';
			?>

		</div>
	</body>
</html> 
				<!-- // foreach(getCategories() as $cat)
				// {
				// 	echo "<h4>" . $cat . "</h4>" . "<BR>";
				// 	foreach(getSubcategories($cat) as $subcat)
				// 	{
				// 		echo $subcat . "<BR>";
				// 	}
				// } -->
