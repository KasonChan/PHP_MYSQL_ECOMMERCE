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
	    	<h3>Login</h3>
			<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<?php
				$error = false;
				$showLogIn = false;
				require_once("DatabaseFunctions.php");

				// ****************************************************************************
				// Form Validation
				// ****************************************************************************
				// Sample Form's Processing Script
				if (count($_POST) > 0) 
				{ 
					// ****************************************
					// Connect database
					// ****************************************
					$con = ConnectDatabase();

					// Process the submitted form
				  	// Do some simple field checking first...

					$inputEmailResult = $_POST['inputEmail'];
					$inputPasswordResult = $_POST['inputPassword'];

					// echo $inputEmailResult . "<BR>";
					// echo $inputPasswordResult . "<BR>";
					
					$getCustomerName = "SELECT distinct name FROM person WHERE email='$inputEmailResult' AND password='$inputPasswordResult'";
					$getCustomerNameResult = mysql_query($getCustomerName);

				  	if( (trim($Email=$_POST['inputEmail']) == '') OR (trim($Password=$_POST['inputPassword']) == '') )
				  	{
				    	echo "<div style=\"color:red;\">Invalid email and/or password. </div>\n";
				    	$error = true;
					}
					else
					{	
						if(!$getCustomerNameResult)
						{
							echo "<div style=\"color:red;\">Invalid email and/or password. </div>\n";
							$error = true;
						}
						else if($getCustomerNameResult)
						{
							if (!mysql_fetch_row($getCustomerNameResult))
							{
								$error = true;
								echo "<div style=\"color:red;\">Invalid email and/or password. </div>\n";
							}
						}
				  	}

					if(!$error)
					{
						$showLogIn = true;
					}
				}

				// ****************************************************************************
				// End of form validation
				// ****************************************************************************
				// If there was an error, or the form wasn't submitted,
				// ****************************************************************************
				// Form input
				// ****************************************************************************
				if ($error OR count($_POST) == 0)
				  echo <<< EOT
				  <table>
				    <tr><td>  
				 	*Email: <input type="text" name="inputEmail" size="30" maxlength="30" value="$Email" /><br />
					*Password: <input type="password" name="inputPassword" size="20" maxlength="20" value="$Password" /><br />
				    <i>*Required field</i>
				    </td></tr>
				  </table>
				  <p><input type="submit" name="Submit" class=Button value="Check" /></p>
				</form>
EOT;
				// ****************************************************************************
				// End of form input
				// ****************************************************************************
				?>
				</form>


				<form method="post" action="LoginConfirm.php">
				<?php
					if($showLogIn == false)
						echo "<input type=\"submit\" name=\"Submit\" value=\"Log in\"  style=\"display:none;\" />";
					else if($showLogIn == true)
					{
						echo "<table>";
						echo "<tr><td>";  
					 	echo "*Email: " . "<input type=\"text\" name=\"inputEmail\" value=$Email disabled=\"disabled\" />" . "<br />";
						echo "*Password: " . "<input type=\"password\" name=\"inputPassword\" value=$Password disabled=\"disabled\" />" . "<br />";
					    echo "<i>" . "*Required field " . "</i>";
					    echo "</td></tr>";
						echo "</table>";
						echo "<p>" . "<input type=\"submit\" name=\"Submit\" value=\"Log In\" class=\"Button\" />";
						echo "<input type=\"button\" class=Button value=\"Back\" onClick=\"history.go(-1)\" >" . "</p>";
					
						$IP = $_SERVER['REMOTE_ADDR'];
						// echo $IP . "<BR>";
						setIP($Email, $IP);
					}
				?>
				      
			</form>
		</div>
	</body>
</html> 
