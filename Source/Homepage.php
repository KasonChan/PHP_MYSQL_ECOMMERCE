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
		    		echo "<form action=\"EditItems.php\">";
		    		echo "<p align=\"right\">" . "<button>" . "Edit selling items" . "</button>" . "</p>";
		    		echo "</form>";
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
					echo "<p>" . "Suggestions (Category, Subcategory, Product Name): " . "<span id=\"txtHint\">" . "</span>" . "</p>";
				?>
			</form>

			<h3>Search Result</h3>
			<?php 
				$error = 0;
				$search = $_GET["name"];
				
				if(trim($search=$_GET['name']) == '')
				{
					$error = 1;
				}

				$search = strtolower($search);
				// echo $search . "<BR>";

				foreach (getCategories() as $cat)
				{
					// $cat = strtolower($cat);
					if($cat == $search)
					{
						$cat[0] = strtoupper($cat[0]);
						
						echo $cat . "<BR><BR>";

						$printUniqueItem = 1;

						$cat[0] = strtolower($cat[0]);

						$IDFromCat = getProductIDFromCat($cat);
						
						foreach ($IDFromCat as $ID)
						{
							$info = getProductInfo($ID, $cat);

							if($info[3] > 0)
							{
							 	echo "<table class=table>";
							 		$info[0][0] = strtoupper($info[0][0]);
									echo "<tr><td class=td1>" . "<b>" . "Name" . "</b></td>" . "<td>" . $info[0] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Description" . "</b></td>" . "<td>" . $info[1] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Condition" . "</b></td>" . "<td>" . $info[2] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Quantity" . "</b></td>" . "<td>" . $info[3] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Price" . "</b></td>" . "<td>" . $info[4] * ($info[5] / 100) . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Seller information" . "</b></td>" . "<td>" . $info[6] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Language" . "</b></td>" . "<td>" . $info[7] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Format" . "</b></td>" . "<td>" . $info[8] . "</td></tr>";
									if($cat == 'book')
									{
										echo "<tr><td class=td1>" . "<b>" . "Publication year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
										echo "<tr><td class=td1>" . "<b>" . "Author" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
										echo "<tr><td class=td1>" . "<b>" . "ISBN13" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
									}
									else if($cat == 'music')
									{
										echo "<tr><td class=td1>" . "<b>" . "Release year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
										echo "<tr><td class=td1>" . "<b>" . "Artist" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
										echo "<tr><td class=td1>" . "<b>" . "UPC" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
									}
									echo "<tr><td class=td1>" . "<b>" . "Category" . "</b></td>" . "<td>" . $info[12] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Subcategory" . "</b></td>" . "<td>" . $info[13] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Reviews" . "</b></td>";
									echo "<td>";
									$reviews = getProductReviews($ID);
									if(empty($reviews))
									{
										echo "None";
									}
									else
									{
										foreach ($reviews as $review)
										{
											echo $review . "<BR>";
										}
									}
									echo "</td>";
									echo "</tr>";
								echo "</table>";
								if(trim(getEmail($IP)) != '')
								{
									if(getEmail($IP) != $info[6])
									{
										echo "<form action=\"AddCart.php\" method=\"post\">";
							    		echo "<p>" . "<input type=\"text\" name=\"name\" value=\"$ID\" style=\"display:none\" />" . "<input type=\"submit\" class=Button value=\"Add to Cart\" />" . "</p>";
						    			echo "</form>";
					    			}
					    		}
					    		echo "</form>";
								echo "<BR>";
							}
						}
					}
					else if($cat != search)
					{
						foreach (getSubcategories($cat) as $subcat)
						{
							if($subcat == $search)
							{
								$cat[0] = strtoupper($cat[0]);
								$subcat[0] = strtoupper($subcat[0]);
								echo $cat . " < ";
								echo $subcat . "<BR><BR>";

								$printUniqueItem = 1;

								$cat[0] = strtolower($cat[0]);
								$subcat[0] = strtolower($subcat[0]);

								$IDFromSubcat = getProductIDFromSubcat($subcat);
						
								foreach ($IDFromSubcat as $ID)
								{
									$info = getProductInfo($ID, $cat);
									if($info[3] > 0)
									{
									 	echo "<table class=table>";
									 		$info[0][0] = strtoupper($info[0][0]);
											echo "<tr><td class=td1>" . "<b>" . "Name" . "</b></td>" . "<td>" . $info[0] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Description" . "</b></td>" . "<td>" . $info[1] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Condition" . "</b></td>" . "<td>" . $info[2] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Quantity" . "</b></td>" . "<td>" . $info[3] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Price" . "</b></td>" . "<td>" . $info[4] * ($info[5] / 100) . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Seller information" . "</b></td>" . "<td>" . $info[6] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Language" . "</b></td>" . "<td>" . $info[7] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Format" . "</b></td>" . "<td>" . $info[8] . "</td></tr>";
											if($cat == 'book')
											{
												echo "<tr><td class=td1>" . "<b>" . "Publication year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
												echo "<tr><td class=td1>" . "<b>" . "Author" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
												echo "<tr><td class=td1>" . "<b>" . "ISBN13" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
											}
											else if($cat == 'music')
											{
												echo "<tr><td class=td1>" . "<b>" . "Release year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
												echo "<tr><td class=td1>" . "<b>" . "Artist" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
												echo "<tr><td class=td1>" . "<b>" . "UPC" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
											}
											echo "<tr><td class=td1>" . "<b>" . "Category" . "</b></td>" . "<td>" . $info[12] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Subcategory" . "</b></td>" . "<td>" . $info[13] . "</td></tr>";
											echo "<tr><td class=td1>" . "<b>" . "Reviews" . "</b></td>";
											echo "<td>";
											$reviews = getProductReviews($ID);
											if(empty($reviews))
											{
												echo "None";
											}
											else
											{
												foreach ($reviews as $review)
												{
													echo $review . "<BR>";
												}
											}
											echo "</td>";
											echo "</tr>";
										echo "</table>";
										if(trim(getEmail($IP)) != '')
										{
											if(getEmail($IP) != $info[6])
											{
												echo "<form action=\"AddCart.php\" method=\"post\">";
									    		echo "<p>" . "<input type=\"text\" name=\"name\" value=\"$ID\" style=\"display:none\" />" . "<input type=\"submit\" class=Button value=\"Add to Cart\" />" . "</p>";
								    			echo "</form>";
							    			}
							    		}
										echo "<BR>";
									}
								}
							}
						}
					}
				}

				foreach (getProductName() as $name)
				{
					if($name == $search)
					{
						// echo $search;
						$product_id = getProductID($name);
						// echo $product_id . "<BR>";

						foreach (getProductCategory($product_id[0]) as $cat)
						{
							$cat[0] = strtoupper($cat[0]);
							
							echo $cat . " < ";
						}
						foreach (getProductSubcategory($product_id[0]) as $subcat)
						{
							$subcat[0] = strtoupper($subcat[0]);
							echo $subcat . " < ";
						}
						$name[0] = strtoupper($name[0]);
						echo $name;
					}
				}

				$cat[0] = strtolower($cat[0]);
				$subcat[0] = strtolower($subcat[0]);
				echo "<BR><BR>";

				foreach (getProductID($search) as $ID)
				{
					if($printUniqueItem == 0 AND $error == 0)
					{
						$info = getProductInfo($ID, $cat);
						if($info[3] > 0)
						{
							echo "<table class=table>";
								$info[0][0] = strtoupper($info[0][0]);
								echo "<tr><td class=td1>" . "<b>" . "Name" . "</b></td>" . "<td>" . $info[0] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Description" . "</b></td>" . "<td>" . $info[1] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Condition" . "</b></td>" . "<td>" . $info[2] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Quantity" . "</b></td>" . "<td>" . $info[3] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Price" . "</b></td>" . "<td>" . $info[4] * ($info[5] / 100) . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Seller information" . "</b></td>" . "<td>" . $info[6] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Language" . "</b></td>" . "<td>" . $info[7] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Format" . "</b></td>" . "<td>" . $info[8] . "</td></tr>";
								if($cat == 'book')
								{
									echo "<tr><td class=td1>" . "<b>" . "Publication year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Author" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "ISBN13" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
								}
								else if($cat == 'music')
								{
									echo "<tr><td class=td1>" . "<b>" . "Release year" . "</b></td>" . "<td>" . $info[9] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "Artist" . "</b></td>" . "<td>" . $info[10] . "</td></tr>";
									echo "<tr><td class=td1>" . "<b>" . "UPC" . "</b></td>" . "<td>" . $info[11] . "</td></tr>";
								}
								echo "<tr><td class=td1>" . "<b>" . "Category" . "</b></td>" . "<td>" . $info[12] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Subcategory" . "</b></td>" . "<td>" . $info[13] . "</td></tr>";
								echo "<tr><td class=td1>" . "<b>" . "Reviews" . "</b></td>";
								echo "<td>";
								$reviews = getProductReviews($ID);
								if(empty($reviews))
								{
									echo "None";
								}
								else
								{
									foreach ($reviews as $review)
									{
										echo $review . "<BR>";
									}
								}
								echo "</td>";
								echo "</tr>";
							echo "</table>";
							if(trim(getEmail($IP)) != '')
							{
								if(getEmail($IP) != $info[6])
								{
									echo "<form action=\"AddCart.php\" method=\"post\">";
						    		echo "<p>" . "<input type=\"text\" name=\"name\" value=\"$ID\" style=\"display:none\" />" . "<input type=\"submit\" class=Button value=\"Add to Cart\" />" . "</p>";
					    			echo "</form>";
				    			}
				    		}
							echo "<BR>";
						}
					}
				}

				// foreach (getProductInfo($product_id, $cat) as $info)
				// {
				// 	echo $info[0] . "<BR>";
				// }
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
