<?php
    // Fill up array with names

    require_once("DatabaseFunctions.php");
    $con = ConnectDatabase();

    $getProductName = "SELECT distinct product_name FROM product";
    $getProductNameResult = mysql_query($getProductName);

    while($row=mysql_fetch_row($getProductNameResult))
    {
      foreach ($row as $value)
      {
        if(getQuantityFromProductName($value) > 0)
        { 
          $value[0] = strtoupper($value[0]);
          $a[] = $value;
        }
      }
    }

    foreach(getCategories() as $cat)
    {
      // echo "<h4>" . $cat . "</h4>" . "<BR>";
      $cat[0] = strtoupper($cat[0]);
      $a[] = $cat;
      foreach(getSubcategories($cat) as $subcat)
      {
          $subcat[0] = strtoupper($subcat[0]);
          $a[] = $subcat;
          // echo $subcat . "<BR>";
      }
    }

    //get the q parameter from URL
    $q=$_GET["q"];

    //lookup all hints from array if length of q>0
    if (strlen($q) > 0)
      {
      $hint="";
      for($i=0; $i<count($a); $i++)
        {
        if (strtolower($q)==strtolower(substr($a[$i],0,strlen($q))))
          {
          if ($hint=="")
            {
              $hint=$a[$i];
            }
          else
            {
              $hint=$hint.", ".$a[$i];
            }
          }
        }
      }

    // Set output to "no suggestion" if no hint were found
    // or to the correct values
    if ($hint == "")
    {
        $response="No suggestion.";
    }
    else
    {
        $response=$hint;
    }

    //output the response
    echo $response;
?>