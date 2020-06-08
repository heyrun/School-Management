<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Welcome to Unique Blossom Schools, Abuja</title>
    <!-- Slider script -->
   <link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen"  />
<!-- 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.nin.js"  type="text/javascript"></script> 
-->

<script type="text/javascript" src="demo/scripts/jquery-1.6.1.min.js"></script>
<script src="jquery.nivo.slider.pack.js" type="text/javascript"> </script>

 <link rel="stylesheet" href="themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="themes/pascal/pascal.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="themes/orman/orman.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen" />
    
    
    <!-- end of slider script -->
    
    
    
    
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Unique Blossom Schools, Abuja; Creche, Prenursery, Nursery, Primary" />
	<meta name="keywords" content="creche, Nursery, prenursery, reception, primary, schoool, school in abuja, primary school in abuja, nursery school, students, unique blossom" />
	<link rel="stylesheet" href="style.css" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<div id="content">
		<?php include("includes/header.php"); ?>

	
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
        
        
		
  <div id="main_home">
		<div class="slider-wrapper theme-default">
            <div class="ribbon"></div>
          <div id="slider" class="nivoSlider">
   <img src="images/Unique_blossom3.jpg" alt="" title="#imgtitle1" />
        <img src="images/Unique_blossom1.jpg" alt=""  title="#imgtitle3"/>
        <img src="images/Unique_blossom4.jpg" alt="" title="#imgtitle4" />
        <img src="images/unique_blossom7.jpg" alt="" title="#imgtitle6" />
        <img src="images/unque_8.jpg" alt="" title="#imgtitle5" />
        <img src="images/Unique_blossom6.jpg" alt="" title="#imgtitle7" />
        </div>
    
		<div id=imgtitle3 class="nivo-html-caption">
      All work and no play...*Spacious Playground and World class play items*
      </div>
      <div id=imgtitle1 class="nivo-html-caption">
      The Face of a Future Leader
      </div>
      <div id=imgtitle2 class="nivo-html-caption">Confident and Smart
       </div>
        <div id=imgtitle4 class="nivo-html-caption">
      State-of-the-Art Laboratories and Facilities
      </div>
   
    <div id=imgtitle5 class="nivo-html-caption">
      Leadership and Knowledge</div>
 
    <div id=imgtitle7 class="nivo-html-caption">
      At Unique Blossom, We make learning fun</div>

<div id=imgtitle6 class="nivo-html-caption">
  Whatever they aspire to be, we help build a solid foundation to achieve that </div>
 </div>
  </div>
  <div id="shortnews">
 <?php include("includes/side1.php"); ?></div>

		<div id="line"></div>
		
		<div id="left_home"><img src="images/construct1.jpg" alt="" width="230" height="240" /></div>
		<?php include('includes/side2.php'); ?>
		<div id="right">
<div id="rl">
            
              <h1>Under Construction</h1>
              <h1>&nbsp;</h1>
<p>&nbsp;</p>
              <h2>This page is still under construction. </h2>
              <h2>&nbsp;</h2>
              <h2>Please check back on a later date</h2>
              <p>&nbsp;</p></div><h2 class="border">&nbsp;</h2>
</div>
  
  
			
		<?php include("includes/footer.php"); ?>	
	</div>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
</body>
</html>