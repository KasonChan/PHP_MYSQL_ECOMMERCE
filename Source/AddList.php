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
	    			echo "<form action=\"Login.php\">";
		    		echo "<p align=\"right\">" . "<button>" . "Login" . "</button>" . "</p>";
		    		echo "</form>";
		    	}
		    	else
		    	{
		    		echo "<p align=\"right\">" . "You are logged in as: " . "<b>" . getEmail($IP) . "</b>" . "</p>";
		    		// echo "<form action=\"EditItems.php\">";
		    		// echo "<p align=\"right\">" . "<button>" . "Edit selling items" . "</button>" . "</p>";
		    		// echo "</form>";
		    		echo "<form action=\"Logout.php\">";
		    		echo "<p align=\"right\">" . "<button>" . "Logout" . "</button>" . "</p>";
		    		echo "</form>";
		    		echo "<form action=\"Cart.php\">";
		    		echo "<p align=\"right\">" . "<input type=\"image\" src=\"shoppingcart.jpg\" width=\"30\" height=\"30\" >" . "</p>";
		    		echo "</form>";
				}
			?>
	    	<form action="Homepage.php" method="get">
				<?php
					echo "<p>" . "<input type=\"text\" name=\"name\" onkeyup=\"showHint(this.value)\" />" . "<input type=\"submit\" class=Button value=\"Search\" />" . "</p>";
					echo "<p>" . "Suggestions: " . "<span id=\"txtHint\">" . "</span>" . "</p>";
				?>
			</form>

			<h3>Add items</h3>
			<?php 
				$email = getEmail($IP);
				
				echo "<form action=\"AddListCont.php\" method=\"post\">";
				echo "<table class=table>";
			 		$info[0][0] = strtoupper($info[0][0]);
					echo "<tr><td class=td1>" . "<b>" . "Name" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"product_name\" maxlength=\"50\"/> (Max characters: 50)" . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Description" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"description\" maxlength=\"500\"/> (Max characters: 500)" . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Condition" . "</b></td>" . "<td>" . "<input type=\"radio\" name=\"product_condition\" value=\"new\"/>" . "New" . "<BR>" . "<input type=\"radio\" name=\"product_condition\" value=\"used\"/>" . "Used" . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Quantity" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"quantity\" maxlength=\"2\"/> (Max digits: 2)" . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Price" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"price\" maxlength=\"5\"/> (Max digits: 5)" . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Sale" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"sale\" maxlength=\"3\"/> (Max digits: 3, i.e. 100)" . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Language" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"language\" maxlength=\"25\"/> (Max character: 25)" . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Format" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"format\" maxlength=\"20\"/> (Max character: 20, i.e. Hardcover, CD)" . "</td></tr>";
						// echo "<tr><td class=td1>" . "<b>" . "Publication year/Release year" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"year\" maxlength=\"4\"/> (Max digits: 4, i.e. 2012)" . "</td></tr>";
						// echo "<tr><td class=td1>" . "<b>" . "Author/Artist" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"author\" maxlength=\"100\"/> (Max characters: 100)" . "</td></tr>";
						// echo "<tr><td class=td1>" . "<b>" . "ISBN13/UPC" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"UPC\" maxlength=\"13\"/> (Max digits: 13)" . "</td></tr>";
					
					echo "<tr><td class=td1>" . "<b>" . "Category" . "</b></td>" . "<td>" . "<input type=\"radio\" name=\"category\" value=\"book\"/>" . "Book" . "<BR>" . "<input type=\"radio\" name=\"category\" value=\"music\"/>" . "Music" . "</td></tr>";
					
					// echo "<tr><td class=td1>" . "<b>" . "Subcategory" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"subcategory\" maxlength=\"15\"/>" . "</td></tr>";
					// echo "<td>";
				echo "</table>";
				if(trim(getEmail($IP)) != '')
				{
					if(getEmail($IP) != $info[6])
					{
						
			    		echo "<p>" . "<input type=\"text\" name=\"name\" value=\"$ID\" style=\"display:none\" />" . "<input type=\"submit\" class=Button value=\"Add Item\" />" . "</p>";
		    			echo "</form>";
	    			}
	    		}
	    		echo "</form>";
				echo "<BR>";


				
				echo "<BR>";
			?>

		</div>
	</body>
</html> 
