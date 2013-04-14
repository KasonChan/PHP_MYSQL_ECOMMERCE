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

			<h3>Payment</h3>
			<?php
				echo "<form action=\"PaymentConfirm.php\" method=\"post\">";
				$total = 0.0;

				$email = getEmail($IP);
				// echo $email . "<BR>";
				$cart_id = getCartID($email);
				// echo $cart_id . "<BR>";

				mysql_query("BEGIN");

				$IDs = getProductIDFromCart($cart_id);

				foreach($IDs as $ID)
				{
					$cat = getProductCategory($ID);
					$info = getProductInfo($ID, $cat);

					if($info[3] > 0)
					{
						echo "<table class=table>";
							$info[0][0] = strtoupper($info[0][0]);
							echo "<tr><td class=td1>" . "<b>" . "Name" . "</b></td>" . "<td>" . $info[0] . "</td></tr>";
							echo "<tr><td class=td1>" . "<b>" . "Description" . "</b></td>" . "<td>" . $info[1] . "</td></tr>";
							echo "<tr><td class=td1>" . "<b>" . "Condition" . "</b></td>" . "<td>" . $info[2] . "</td></tr>";
							echo "<tr><td class=td1>" . "<b>" . "Quantity" . "</b></td>" . "<td>" . "1" . "</td></tr>";
							echo "<tr><td class=td1>" . "<b>" . "Price" . "</b></td>" . "<td>" . $info[4] * ($info[5] / 100) . "</td></tr>";
							$total = $total + ($info[4] * ($info[5] / 100));
							echo "<tr><td class=td1>" . "<b>" . "Seller information" . "</b></td>" . "<td>" . $info[6] . "</td></tr>";
							echo "<tr><td class=td1>" . "<b>" . "Language" . "</b></td>" . "<td>" . $info[7] . "</td></tr>";
							echo "<tr><td class=td1>" . "<b>" . "Format" . "</b></td>" . "<td>" . $info[8] . "</td></tr>";
							$cat[0][0] = strtolower($cat[0][0]);
							if($cat[0] == 'book')
							{
								echo "<tr><td class=td1>" . "<b>" . "Publication year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Author" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "ISBN13" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
							}
							else if($cat[0] == 'music')
							{
								echo "<tr><td class=td1>" . "<b>" . "Release year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Artist" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "UPC" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
							}
						echo "</table>";
						echo "<BR>";



						$cart_id = getCartID($email);
						$priceNow = $info[4] * ($info[5] / 100);
						$info[0][0] = strtolower($info[0][0]);
						setBuyHistory($ID, $info[0], $info[1], $info[2], 1, $priceNow, $info[6], $info[7], $info[8], $info[9], $info[10], $info[11], date(Y), date(m), date(j), $cart_id);
						setSellHistory($ID, $info[0], $info[1], $info[2], 1, $priceNow, $info[6], $info[7], $info[8], $info[9], $info[10], $info[11], date(Y), date(m), date(j), $cart_id);
						removeFromCart($ID);

						updateQuantity($ID);

						mysql_query("COMMIT");
					}
					else
					{
						$email = getEmail($IP);
						// echo $email . "<BR>";
						$cart_id = getCartID($email);
						// echo $cart_id . "<BR>";

						$product_id = $ID;
						$product_name = getProductNameFromID($product_id);
						$product_name[0] = strtoupper($product_name[0]);

						echo "<b>" . $product_name . "</b>" . " is sold out and removed from your cart." . "</p>";
						removeFromCart($product_id);

					}
				}

				if(trim(getEmail($IP)) != '')
				{	
					echo "<table class=table>";
					echo "<tr>" . "<td class=td1>" . "<B>" . "Total" . "</B>" . "</td>" . "<td>" . $total . "</td></tr>";

					echo "<tr>" . "<td class=td1>" . "<B>" . "Shipping" . "</B>" . "</td>" . "<td>";
					$price = $_POST["price"];
					
					$method = $_POST["method"];
					
					echo $method . " " . $price;
					echo "</td></tr>";
					echo "<tr>" . "<td class=td1>" . "<B>" . "Payment" . "</B>" . "</td>";
					echo "<td>";

					$payment = $_POST["payment"];
					echo $payment;
					echo "</td></tr>";
					$FinalAmount = $total + $price;

					echo "<tr>" . "<td class=td1>" . "<B>" . "Total + Shipping" . "</B>" . "</td>" . "<td>" . $FinalAmount . "</td></tr>";

		    		
		    		echo "</table>";
	    		}

	    		echo "<BR>";

	    		$url = 'http://students.csci.unt.edu/~kc0284/CSCE4350Project/Homepage.php';
    			echo '<META HTTP-EQUIV=Refresh CONTENT="5; URL='.$url.'">'; 

				
			?>

		</div>
	</body>
</html>
