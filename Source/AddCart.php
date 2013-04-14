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
		    		echo "<p align=\"right\">" . "You are logged in as: " . "<b>" . getEmail($IP) . "</b>" . "</p>";
		    		echo "<form action=\"Logout.php\">";
		    		echo "<p align=\"right\">" . "<button>" . "Logout" . "</button>" . "</p>";
		    		echo "</form>";
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

			<h3>Cart</h3>
			<?php 
				$ID = $_POST["name"];
				// echo $ID . "<BR>";

				$cat = getProductCategory($ID);
				$info = getProductInfo($ID, $cat);


				echo "<table class=table>";
					$info[0][0] = strtoupper($info[0][0]);
					echo "<tr><td class=td1>" . "<b>" . "Name" . "</b></td>" . "<td>" . $info[0] . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Description" . "</b></td>" . "<td>" . $info[1] . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Condition" . "</b></td>" . "<td>" . $info[2] . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Quantity" . "</b></td>" . "<td>" . $info[3] . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Price" . "</b></td>" . "<td>" . $info[4] . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Seller information" . "</b></td>" . "<td>" . $info[5] . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Language" . "</b></td>" . "<td>" . $info[6] . "</td></tr>";
					echo "<tr><td class=td1>" . "<b>" . "Format" . "</b></td>" . "<td>" . $info[7] . "</td></tr>";
					$cat[0][0] = strtolower($cat[0][0]);
					if($cat[0] == 'book')
					{
						echo "<tr><td class=td1>" . "<b>" . "Publication year" . "</b></td>" . "<td>" . $info[8] . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "Author" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "ISBN13" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
					}
					else if($cat[0] == 'music')
					{
						echo "<tr><td class=td1>" . "<b>" . "Release year" . "</b></td>" . "<td>" . $info[8] . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "Artist" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
						echo "<tr><td class=td1>" . "<b>" . "UPC" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
					}

					$email = getEmail($IP);
					// echo $email . "<BR>";

					$cart_id = getCartID($email);

					addToCart($cart_id, $ID, '1', date(Y), date(m), date(j));
				
				echo "</table>";
				echo "<BR>";
				if(trim(getEmail($IP)) != '')
				{
					echo "<table>";
					echo "<tr><td>";
					echo "<form action=\"Cart.php\" method=\"post\">";
		    		echo "<input type=\"text\" name=\"name\" value=\"$ID\" style=\"display:none\" />" . "<input type=\"submit\" class=Button value=\"Edit your Cart\" />";
		    		echo "</form>";
		    		echo "</tr><tr>";
		    		echo "</td>";
		    		echo "<td>";
					echo "<form action=\"Checkout.php\" method=\"post\">";
		    		echo "<input type=\"text\" name=\"name\" value=\"$ID\" style=\"display:none\" />" . "<input type=\"submit\" class=Button value=\"Checkout\" />";
		    		echo "</form>";
		    		echo "</td></tr>";
		    		echo "</table>";
	    		}
				echo "<BR>";

			?>

		</div>
	</body>
</html>
