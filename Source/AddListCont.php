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
				echo "<form action=\"AddListConfirm.php\" method=\"post\">";
				echo "<table class=table>";
			 		$product_name = $_POST["product_name"];
					echo "<tr><td class=td1>" . "<b>" . "Name" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"product_name\" maxlength=\"50\" value=\"$product_name\"/> (Max characters: 50)" . "</td></tr>";
					$description = $_POST["description"];
					echo "<tr><td class=td1>" . "<b>" . "Description" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"description\" maxlength=\"500\" value=\"$description\"/> (Max characters: 500)" . "</td></tr>";
					$product_condition = $_POST["product_condition"];
					echo "<tr><td class=td1>" . "<b>" . "Condition" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"product_condition\" value=\"$product_condition\"/>". "</td></tr>";
					$quantity = $_POST["quantity"];
					echo "<tr><td class=td1>" . "<b>" . "Quantity" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"quantity\" maxlength=\"2\" value=\"$quantity\"/> (Max digits: 2)" . "</td></tr>";
					$price = $_POST["price"];
					echo "<tr><td class=td1>" . "<b>" . "Price" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"price\" maxlength=\"5\" value=\"$price\"/> (Max digits: 5)" . "</td></tr>";
					$sale = $_POST["sale"];
					echo "<tr><td class=td1>" . "<b>" . "Sale %" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"sale\" maxlength=\"3\" value=\"$sale\"/> (Max digits: 3)" . "</td></tr>";
					$language = $_POST["language"];
					echo "<tr><td class=td1>" . "<b>" . "Language" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"language\" maxlength=\"25\" value=\"$language\" /> (Max character: 25)" . "</td></tr>";
					$format = $_POST["format"];
					echo "<tr><td class=td1>" . "<b>" . "Format" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"format\" maxlength=\"20\" value=\"$format\"/> (Max character: 20, i.e. Hardcover, CD)" . "</td></tr>";
					$category = $_POST["category"];
					echo "<tr><td class=td1>" . "<b>" . "Category" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"category\" value=\"$category\" />" . "</td></tr>";
					if($category == 'book')
					{
						echo "<tr><td class=td1>" . "<b>" . "Subcategory" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"subcategory\" maxlength=\"15\"/> (Max digits: 15, i.e. Textbooks, Nonfiction...)" . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "Publication year" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"year\" maxlength=\"4\"/> (Max digits: 4, i.e. 2012)" . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "Author" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"author\" maxlength=\"100\"/> (Max characters: 100)" . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "ISBN13" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"UPC\" maxlength=\"13\"/> (Max digits: 13)" . "</td></tr>";
					}
					else if($category == 'music')
					{
						echo "<tr><td class=td1>" . "<b>" . "Subcategory" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"subcategory\" maxlength=\"15\"/> (Max digits: 15, i.e. Pop, Classical...)". "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "Release year" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"year\" maxlength=\"4\"/> (Max digits: 4, i.e. 2012)" . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "Artist" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"author\" maxlength=\"100\"/> (Max characters: 100)" . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "UPC" . "</b></td>" . "<td>" . "<input type=\"text\" name=\"UPC\" maxlength=\"12\"/> (Max digits: 12)" . "</td></tr>";
					}
					
				echo "</table>";
				if(trim(getEmail($IP)) != '')
				{
					if(getEmail($IP) != $info[6])
					{
						
			    		echo "<p>" . "<input type=\"text\" name=\"name\" value=\"$ID\" style=\"display:none\" />" . "<input type=\"submit\" class=Button value=\"Confirm Add Item\" />" . "</p>";
		    			echo "</form>";
	    			}
	    		}
				echo "<BR>";


				
				echo "<BR>";
			?>

		</div>
	</body>
</html> 
