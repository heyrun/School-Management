<?php require_once('Connections/unique.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "3";
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
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_unique, $unique);
$query_subject = "SELECT * FROM subject";
$subject = mysql_query($query_subject, $unique) or die(mysql_error());
$row_subject = mysql_fetch_assoc($subject);
$totalRows_subject = mysql_num_rows($subject);

mysql_select_db($database_unique, $unique);
$query_teachers = "SELECT staff_id, CONCAT_WS(' ',lname, fname) AS name FROM staff WHERE management = '0' ORDER BY lname ASC";
$teachers = mysql_query($query_teachers, $unique) or die(mysql_error());
$row_teachers = mysql_fetch_assoc($teachers);
$totalRows_teachers = mysql_num_rows($teachers);

mysql_select_db($database_unique, $unique);
$query_class = "SELECT class_id, class_name FROM `class`";
$class = mysql_query($query_class, $unique) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);
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
  <div id="shortnews">
<h3><a href="#">Neatest Student for the Week</a></h3>
			<p><img src="" alt="" name="" width="57" height="71" />Mr Boyejo Temitayo, was voted as the neatest student in the school for week five. He is in Primary 5A.</p>
			<h3><a href="#">Most Hardworking Student for the Week</a></h3>
<img name="" src="" width="60" height="82" alt="" />Miss Catherine Thomas was voted the most hardworking student for week 5. She is in primary 4B 



<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<div class="fb-like" data-href="http://www.uniqueblossomschools.com" data-send="true" data-width="250" data-show-faces="true"></div>
</div>

					
<div id="right">	
			<div id="long_txt_pix">
            
              <h1>Assign Subjects to Teachers</h1>
              <table width="95%" border="1">
                <tr>
                  <td colspan="2" align="center"><?php if (isset($Result1) && true){?>
                    <span class="success">User Successfully Added</span>
                    <?php } ?></td>
                </tr>
                <tr>
                  <td align="right">Subject</td>
                  <td><label>
                    <select name="subject" id="subject">
                      <?php
do {  
?>
                      <option value="<?php echo $row_subject['subject_id']?>"><?php echo $row_subject['subject_name']?></option>
                      <?php
} while ($row_subject = mysql_fetch_assoc($subject));
  $rows = mysql_num_rows($subject);
  if($rows > 0) {
      mysql_data_seek($subject, 0);
	  $row_subject = mysql_fetch_assoc($subject);
  }
?>
                    </select>
                  </label></td>
                </tr>
                <tr>
                  <td align="right">Teacher</td>
                  <td><label>
                    <select name="teacher" id="teacher">
                      <?php
do {  
?>
                      <option value="<?php echo $row_teachers['staff_id']?>"><?php echo $row_teachers['name']?></option>
                      <?php
} while ($row_teachers = mysql_fetch_assoc($teachers));
  $rows = mysql_num_rows($teachers);
  if($rows > 0) {
      mysql_data_seek($teachers, 0);
	  $row_teachers = mysql_fetch_assoc($teachers);
  }
?>
                    </select>
                  </label></td>
                </tr>
                <tr>
                  <td align="right">class</td>
                  <td><label>
                    <select name="class" id="class">
                      <?php
do {  
?>
                      <option value="<?php echo $row_class['class_id']?>"><?php echo $row_class['class_name']?></option>
                      <?php
} while ($row_class = mysql_fetch_assoc($class));
  $rows = mysql_num_rows($class);
  if($rows > 0) {
      mysql_data_seek($class, 0);
	  $row_class = mysql_fetch_assoc($class);
  }
?>
                    </select>
                  </label></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><label>
                    <input name="assign" type="submit" class="row1" id="assign" value="Assign Subject" />
                  </label></td>
                </tr>
              </table>
              <p><br />
              </p>
		  </div>
	<h2 class="border">Welcome to the official website of Unique Blossom Schools, Abuja. </h2>
			<p class="border">			  Unique Blossom schools is an institution built upon a passion to build children that have the relevant foundation to drive our nation to the promise land. We have created a curriculum that encourages the growth and development the various skills and abilities innate in a child. We have classes for children with age ranging from 0 to 12 years old. <a href="school.php">Click here for m<span class="links">ore</span></a>.</p>
			<p class="border">Feel fre to browse through our various pages to find out more about our school and what we have to offer.</p>
			<p class="border">Please feel free to <a href="contact.php">send us a mail or give us a call.</a> Parents should please endeavour to fill our <a href="opinion.php">online opinion poll</a> in order to serve you better.</p>
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
<?php
mysql_free_result($subject);

mysql_free_result($teachers);

mysql_free_result($class);
?>
