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

<?php

	function ConnectDatabase() 
	{
		$con = mysql_connect("student-db.cse.unt.edu","kc0284","WHO55amikason");
		if (!$con)
		{
	  		die('Could not connect: ' . mysql_error());
			echo 'Could not connect!\n';
		}
		mysql_select_db("kc0284", $con);
		return $con;
	}

	function getSubcategories($category)
	{
		$getSubcategories = "SELECT distinct subcategory FROM categories WHERE category = '$category'";
		$getSubcategoriesResult = mysql_query($getSubcategories);

		$array[] = " ";
		array_pop($array);

		while($row = mysql_fetch_row($getSubcategoriesResult))
		{
	      	foreach ($row as $value)
			{
				// echo $value . "<BR>";
				array_push($array, $value);
			}
		}

		return $array;
	}

	function getCategories()
	{
		$getCategories = "SELECT distinct category FROM categories";
		$getCategoriesResult = mysql_query($getCategories);
		
		$array[] = " ";
		array_pop($array);
		
		while($row=mysql_fetch_row($getCategoriesResult))
		{
	      	foreach($row as $value)
			{
				// echo $value . "<BR>";
				array_push($array, $value);
			}
		}

		return $array;
	}

	function getProductName()
	{
		$getProductName = "SELECT distinct product_name FROM product";
		$getProductNameResult = mysql_query($getProductName);
		
		$array[] = " ";
		array_pop($array);
		
		while($row=mysql_fetch_row($getProductNameResult))
		{
	      	foreach($row as $value)
			{
				// echo $value . "<BR>";
				array_push($array, $value);
			}
		}

		return $array;
	}

	function setIP($email, $IP)
	{
		$setIP = "UPDATE person SET IP = '$IP' WHERE email = '$email'";
		$setIPResult = mysql_query($setIP);
	}

	function removeIP($email)
	{
		$removeIP = "UPDATE person SET IP = '0' WHERE email = '$email'";
		$removeIPResult = mysql_query($removeIP);
	}

	function getEmail($IP)
	{
		$getEmail = "SELECT email FROM person WHERE IP = '$IP'";
		$getEmailResult = mysql_query($getEmail);

		while($row=mysql_fetch_row($getEmailResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function getProductID($product_name)
	{
		$getProductID = "SELECT distinct product_id FROM product WHERE product_name = '$product_name' ORDER BY product_name ASC";
		$getProductIDResult = mysql_query($getProductID);

		$array[] = " ";
		array_pop($array);

		while($row = mysql_fetch_row($getProductIDResult))
		{
			foreach($row as $value)
			{
				array_push($array, $value);
			}
		}

		return $array;
	}

	function getProductIDFromCat($cat)
	{
		$getProductID = "SELECT distinct product_id FROM product WHERE category = '$cat' ORDER BY product_name ASC";
		$getProductIDResult = mysql_query($getProductID);

		$array[] = 0;
		array_pop($array);

		while($row = mysql_fetch_row($getProductIDResult))
		{
			foreach($row as $value)
			{
				$array[] = $value;
			}
		}

		return $array;
	}

	function getProductIDFromSubcat($subcat)
	{
		$getProductID = "SELECT distinct product_id FROM product WHERE subcategory = '$subcat' ORDER BY product_name ASC";
		$getProductIDResult = mysql_query($getProductID);

		$array[] = 0;
		array_pop($array);

		while($row = mysql_fetch_row($getProductIDResult))
		{
			foreach($row as $value)
			{
				$array[] = $value;
			}
		}

		return $array;
	}


	function getProductSubcategory($product_id)
	{
		$getProductSubcategory = "SELECT distinct subcategory FROM product WHERE product_id = '$product_id'";
		$getProductSubcategoryResult = mysql_query($getProductSubcategory);

		$array[] = 0;
		array_pop($array);

		while($row = mysql_fetch_row($getProductSubcategoryResult))
		{
	      	foreach ($row as $value)
			{
				// echo $value . "<BR>";
				array_push($array, $value);
			}
		}

		return $array;
	}

	function getProductCategory($product_id)
	{
		$getProductCategory = "SELECT distinct category FROM product WHERE product_id = '$product_id'";
		$getProductCategoryResult = mysql_query($getProductCategory);

		$array[] = 0;
		array_pop($array);
		
		while($row=mysql_fetch_row($getProductCategoryResult))
		{
	      	foreach($row as $value)
			{
				// echo $value . "<BR>";
				array_push($array, $value);
			}
		}

		return $array;
	}


	function getProductInfo($product_id, $cat)
	{
		$getProductInfo = "SELECT product_name, description, product_condition, quantity, price, sale, seller_email, language, format, publication_release_year FROM product WHERE product_id = '$product_id'";
		$getProductInfoResult = mysql_query($getProductInfo);

		$array[] = 0;
		array_pop($array);

		while($row = mysql_fetch_row($getProductInfoResult))
		{
			foreach($row as $value)
			{
				// echo $value . "<BR>";
				$array[] = $value;
			}
		}

		$getProductInfo = "SELECT author, ISBN13 FROM book WHERE product_id = '$product_id'";
		$getProductInfoResult = mysql_query($getProductInfo);

		while($row = mysql_fetch_row($getProductInfoResult))
		{
			foreach($row as $value)
			{
				// echo $value . "<BR>";
				$array[] = $value;
			}
		}

		$getProductInfo = "SELECT artist, UPC FROM music WHERE product_id = '$product_id'";
		$getProductInfoResult = mysql_query($getProductInfo);

		while($row = mysql_fetch_row($getProductInfoResult))
		{
			foreach($row as $value)
			{
				// echo $value . "<BR>";
				$array[] = $value;
			}
		}

		$getProductInfo = "SELECT category, subcategory FROM product WHERE product_id = '$product_id'";
		$getProductInfoResult = mysql_query($getProductInfo);

		while($row = mysql_fetch_row($getProductInfoResult))
		{
			foreach($row as $value)
			{
				// echo $value . "<BR>";
				$array[] = $value;
			}
		}

		return $array;
	}

	function getProductReviews($product_id)
	{
		$getProductReviews = "SELECT person_email, review FROM reviews WHERE product_id = '$product_id'";
		$getProductReviewsResult = mysql_query($getProductReviews);

		$array[] = 0;
		array_pop($array);
		
		while($row=mysql_fetch_row($getProductReviewsResult))
		{
	      	foreach($row as $value)
			{
				array_push($array, $value);
			}
		}

		return $array;
	}

	function getQuantity($product_id)
	{
		$getQuantity = "SELECT quantity FROM product WHERE product_id = '$product_id'";
		$getQuantityResult = mysql_query($getQuantity);
	
		while($row=mysql_fetch_row($getQuantityResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function getCartID($email)
	{
		$getCartID = "SELECT cart_id FROM person WHERE email = '$email'";
		$getCartIDResult = mysql_query($getCartID);

		while($row=mysql_fetch_row($getCartIDResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function getProductIDFromCart($cart_id)
	{
		$getProductIDFromCart = "SELECT product_id FROM cart WHERE cart_id = '$cart_id'";
		$getProductIDFromCartResult = mysql_query($getProductIDFromCart);

		$array[] = 0;
		array_pop($array);

		while($row=mysql_fetch_row($getProductIDFromCartResult))
		{
	      	foreach($row as $value)
			{
				array_push($array, $value);
			}
		}
		return $array;
	}

	function addToCart($cart_id, $product_id, $quantity, $year, $month, $day)
	{
		$addToCart = "INSERT INTO cart VALUES('$cart_id', '$product_id', '$quantity', '$year', '$month', '$day')";
		$addToCartResult = mysql_query($addToCart);
	}

	function removeFromCart($product_id)
	{
		$removeFromCart = "DELETE FROM cart WHERE product_id ='$product_id'";
		$removeFromCartResult = mysql_query($removeFromCart);
	}

	function getProductNameFromID($product_id)
	{
		$getProductNameFromID = "SELECT product_name FROM product WHERE product_id = '$product_id'";
		$getProductNameFromIDResult = mysql_query($getProductNameFromID);

		while($row=mysql_fetch_row($getProductNameFromIDResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function getProductNum($cart_id)
	{
		$getProductNum = "SELECT COUNT(product_id) FROM cart WHERE cart_id = '$cart_id'";
		$getProductNumResult = mysql_query($getProductNum);

		while($row=mysql_fetch_row($getProductNumResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function getQuantityFromProductName($product_name)
	{
		$getQuantityFromProductName = "SELECT quantity FROM product WHERE product_name = '$product_name'";
		$getQuantityFromProductNameResult = mysql_query($getQuantityFromProductName);

		while($row=mysql_fetch_row($getQuantityFromProductNameResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function setBuyHistory($product_id, $product_name, $description, $product_condition, $quantity, $price, $seller_email, $language, $format, $publication_release_year, $category, $subcategory, $year, $month, $day, $buy_history_id)
	{
		$setBuyHistory = "INSERT INTO buy_history VALUES('$product_id', '$product_name', '$description', '$product_condition', '$quantity', '$price', '$seller_email', '$language', '$format', '$publication_release_year', '$category', '$subcategory', '$year', '$month', '$day', '$buy_history_id')";
		$setBuyHistoryResult = mysql_query($setBuyHistory);
	}


	function setSellHistory($product_id, $product_name, $description, $product_condition, $quantity, $price, $seller_email, $language, $format, $publication_release_year, $category, $subcategory, $year, $month, $day, $sell_history_id)
	{
		$setSellHistory = "INSERT INTO sell_history VALUES('$product_id', '$product_name', '$description', '$product_condition', '$quantity', '$price', '$seller_email', '$language', '$format', '$publication_release_year', '$category', '$subcategory', '$year', '$month', '$day', '$sell_history_id')";
		$setSellHistoryResult = mysql_query($setSellHistory);
	}

	function getBuyHistoryID($email)
	{
		$getBuyHistoryID = "SELECT email FROM person WHERE email = '$email'";
		$getBuyHistoryIDResult = mysql_query($getBuyHistoryID);

		while($row=mysql_fetch_row($getBuyHistoryIDResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function getSellHistoryID($email)
	{
		$getSellHistoryID = "SELECT email FROM person WHERE email = '$email'";
		$getSellHistoryIDResult = mysql_query($getSellHistoryID);

		while($row=mysql_fetch_row($getSellHistoryIDResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}
	function getShippingMethod()
	{
		$getShippingMethod = "SELECT method FROM shipping";
		$getShippingMethodResult = mysql_query($getShippingMethod);

		$array[] = 0;
		array_pop($array);

		while($row=mysql_fetch_row($getShippingMethodResult))
		{
	      	foreach($row as $value)
			{
				array_push($array, $value);
			}
		}
		return $array;

	}

	function getShippingPrice()
	{
		$getShippingPrice = "SELECT price FROM shipping";
		$getShippingPriceResult = mysql_query($getShippingPrice);

		$array[] = 0;
		array_pop($array);

		while($row=mysql_fetch_row($getShippingPriceResult))
		{
	      	foreach($row as $value)
			{
				array_push($array, $value);
			}
		}
		return $array;
	}

	function getPaymentMethod()
	{
		$getPaymentMethod = "SELECT method FROM payment";
		$getPaymentMethodResult = mysql_query($getPaymentMethod);

		$array[] = 0;
		array_pop($array);

		while($row=mysql_fetch_row($getPaymentMethodResult))
		{
	      	foreach($row as $value)
			{
				array_push($array, $value);
			}
		}

		return $array;
	}

	function getMethod($price)
	{
		$getMethod = "SELECT method FROM shipping WHERE price = '$price'";
		$getMethodResult = mysql_query($getMethod);

		while($row=mysql_fetch_row($getMethodResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function updateQuantity($product_id)
	{
		$quantity = getQuantity($product_id);

		$quantity = $quantity - 1;

		$updateQuantity = "UPDATE product SET quantity = '$quantity' WHERE product_id = '$product_id'";
		$updateQuantityResult = mysql_query($updateQuantity);
	}

	function getProductIDFromEmail($email)
	{
		$getProductIDFromEmail = "SELECT product_id FROM product WHERE seller_email = '$email'";
		$getProductIDFromEmailResult = mysql_query($getProductIDFromEmail);

		$array[] = 0;
		array_pop($array);

		while($row=mysql_fetch_row($getProductIDFromEmailResult))
		{
	      	foreach($row as $value)
			{
				array_push($array, $value);
			}
		}
		
		return $array;
	}

	function removeFromList($product_id)
	{
		$removeFromList = "DELETE FROM product WHERE product_id ='$product_id'";
		$removeFromListResult = mysql_query($removeFromList);
	}

	function getMaxProductID()
	{
		$getMaxProductID = "SELECT MAX(product_id) FROM product";
		$getMaxProductIDResult = mysql_query($getMaxProductID);

		while($row=mysql_fetch_row($getMaxProductIDResult))
		{
	      	foreach($row as $value)
			{
				return $value;
			}
		}
	}

	function insertProduct($product_id, $product_name, $description, $product_condition, $quantity, $price, $sale, $seller_email, $language, $format, $publication_release_year, $category, $subcategory)
	{
		$insertProduct = "INSERT INTO product VALUES('$product_id', '$product_name', '$description', '$product_condition', '$quantity', '$price', '$sale', '$seller_email', '$language', '$format', '$publication_release_year', '$category', '$subcategory')";
		$insertProductResult = mysql_query($insertProduct);
	}

	function insertMusic($product_id, $artist, $UPC)
	{
		$insertMusic = "INSERT INTO music VALUES('$product_id', '$artist', '$UPC')";
		$insertMusicResult = mysql_query($insertMusic);
	}

	function insertBook($product_id, $artist, $UPC)
	{
		$insertBook = "INSERT INTO book VALUES('$product_id', '$artist', '$UPC')";
		$insertBookResult = mysql_query($inserBook);
	}

?>

