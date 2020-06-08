<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1,2,3";
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

$colname_child_info = "-1";
if (isset($_GET['id'])) {
  $colname_child_info = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_child_info = sprintf("SELECT CONCAT_WS(' ', student_Fname, student_Lname) AS Name, `class`.class_name, student_info.student_id FROM student_info, `class` WHERE student_id = %s  AND `class`.class_id = student_info.`class`", GetSQLValueString($colname_child_info, "text"));
$child_info = mysql_query($query_child_info, $unique) or die(mysql_error());
$row_child_info = mysql_fetch_assoc($child_info);
$totalRows_child_info = mysql_num_rows($child_info);
$child=$row_child_info['student_id'];

$colname_result = "-1";
if (isset($_GET['id'])) {
  $colname_result = $_GET['id'];
}
$colname3_result = "-1";
if (isset($_GET['session'])) {
  $colname3_result = $_GET['session'];
}
$colname2_result = "-1";
if (isset($_GET['term'])) {
  $colname2_result = $_GET['term'];
}
mysql_select_db($database_unique, $unique);
$query_result = sprintf("SELECT result_id, cat1, cat2, exam, grade, ( `student_results`.cat1+`student_results`.cat2+ `student_results`.exam) AS total, `student_results`.term, `student_results`.`session`, subject.subject_name FROM `student_results`, subject WHERE student_id = %s AND `student_results`.subject = subject.subject_id AND `student_results`.term=%s AND `student_results`.session=%s ORDER BY subject ASC", GetSQLValueString($colname_result, "text"),GetSQLValueString($colname2_result, "int"),GetSQLValueString($colname3_result, "int"));
$result = mysql_query($query_result, $unique) or die(mysql_error());
$row_result = mysql_fetch_assoc($result);
$totalRows_result = mysql_num_rows($result);
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

	<!--	<ul id="menu">
			<li><a class="current" href="#">Home</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">Products</a></li>
			<li><a href="#">Client Testimonials</a></li>
			<li><a href="#">Services</a></li>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Contact Us</a></li>
			<li><a href="#">Help</a></li>
		</ul>
        -->
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
       <?php include('includes/side_parent.php'); ?>
					
<div id="right">
  <div id="long_txt_pix">
    <h2><?php if(!isset($_GET['id'])){ echo "No result to display"; } else {?></h2>
    <h2>Results Summary of <?php echo $row_child_info['Name']; ?> </h2>
  
    <h3>Class: <?php echo $row_child_info['class_name']; ?></h3>
    <h3>Term: <?php switch($row_result['term']) {
		case 1:
		echo "1st" ;
		break;
		case 2:
		echo "2nd"; 
		break;
		case 3: 
		echo "3rd"; 
		break;
	}?></h3>
    <h3>Session: <?php echo $row_result['session']; ?></h3>
    <h1><a href="reports/report_result.php?id=<?php echo $child; ?>&amp;term=<?php echo $_GET['term']; ?>" target="_blank">View Report Sheet</a></h1>
    <table width="90%" border="1">
      <tr>
        <td><h2>SUBJECT</h2></td>
        <td><h2>1ST CAT</h2></td>
        <td><h2>2ND CAT</h2></td>
        <td><h2>EXAMINATION</h2></td>
        <td><h2>TOTAL</h2></td>
        </tr>
      <?php do { ?>
        <tr>
          <td><?php echo $row_result['subject_name']; ?></td>
          <td><strong><?php echo $row_result['cat1']; ?></strong></td>
          <td><strong><?php echo $row_result['cat2']; ?></strong></td>
          <td><strong><?php echo $row_result['exam']; ?></strong></td>
          <td><strong><?php echo $row_result['total']; ?></strong></td>
          </tr>
        <?php } while ($row_result = mysql_fetch_assoc($result)); ?>
    </table>
    <p>
      <?php } ?>
    </p>
    <h1><a href="reports/parent_login.php?id=<?php echo $child; ?>&amp;term=<?php echo $_GET['term']; ?>&amp;session=<?php echo $_GET['session']; ?>" target="_blank">View Result Sheet</a></h1>
  </div>
  <p ></div>
  
  
			
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
mysql_free_result($child_info);

mysql_free_result($result);

// mysql_free_result($result);

// mysql_free_result($child_info);
?>
