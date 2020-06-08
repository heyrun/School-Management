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

$var1_attendance = "-1";
if (isset($_GET['id'])) {
  $var1_attendance = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_attendance = sprintf("SELECT CONCAT_WS(' ',student_info.student_Lname, student_info.student_Fname) AS name, attendance.present, attendance.absent, attendance.school, attendance.id FROM student_info, attendance WHERE attendance.student_id =student_info.student_id AND attendance.id=%s", GetSQLValueString($var1_attendance, "text"));
$attendance = mysql_query($query_attendance, $unique) or die(mysql_error());
$row_attendance = mysql_fetch_assoc($attendance);
$totalRows_attendance = mysql_num_rows($attendance);$var1_attendance = "-1";
if (isset($_GET['id'])) {
  $var1_attendance = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_attendance = sprintf("SELECT CONCAT_WS(' ',student_info.student_Lname, student_info.student_Fname) AS name, attendance.present, attendance.absent, attendance.school, attendance.id FROM student_info, attendance WHERE attendance.student_id =student_info.student_id AND attendance.id=%s", GetSQLValueString($var1_attendance, "text"));
$attendance = mysql_query($query_attendance, $unique) or die(mysql_error());
$row_attendance = mysql_fetch_assoc($attendance);
$totalRows_attendance = mysql_num_rows($attendance);

$colname_results = "-1";
if (isset($_SESSION['id'])) {
  $colname_results = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_results = sprintf("SELECT CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name, student_results.cat1, student_results.cat2, student_results.exam, subject.subject_name, student_results.grade, student_results.result_id FROM student_info, student_results, subject WHERE student_results.teacher_id=%s AND student_results.student_id = student_info.student_id AND student_results.subject = subject.subject_id", GetSQLValueString($colname_results, "int"));
$results = mysql_query($query_results, $unique) or die(mysql_error());
$row_results = mysql_fetch_assoc($results);
$totalRows_results = "-1";
if (isset($_GET['id'])) {
  $totalRows_results = $_GET['id'];
}
$colname_results = "-1";
if (isset($_GET['id'])) {
  $colname_results = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_results = sprintf("SELECT CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name, student_results.cat1, student_results.cat2, student_results.exam, subject.subject_name, student_results.grade, student_results.result_id FROM student_info, student_results, subject WHERE student_results.teacher_id=%s AND student_results.student_id = student_info.student_id AND student_results.subject = subject.subject_id", GetSQLValueString($colname_results, "int"));
$results = mysql_query($query_results, $unique) or die(mysql_error());
$row_results = mysql_fetch_assoc($results);

$colname_users = "-1";
if (isset($_GET['id'])) {
  $colname_users = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_users = sprintf("SELECT login.login_id, login.user_id, login.user_name, login.access_level FROM login WHERE login.login_id=%s", GetSQLValueString($colname_users, "text"));
$users = mysql_query($query_users, $unique) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);

if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup']==1){
	header("location:parents.php");
	
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
<div id="line"></div>
		
		<div id="long_txt_pix">
		  <h1>&nbsp;</h1>
		  <form id="form1" method="get" action="delete_attendance_confirmed.php">
  <p>&nbsp;</p>
<table width="90%" border="0" align="center">
        <tr>
	            <td width="37%"><p><img src="images/roadsafety.jpg" alt="" width="191" height="117" /></p></td>
          <td width="63%" align="center"><h1>Are you Sure You want to delete<br />
          </h1>
            <h2> </h2>
            <h2><?php echo $row_attendance['name']; ?>'s Attendance </h2>
          <h1>From the database?</h1></td>
        </tr>
        <tr>
          <td align="center"><p>&nbsp;</p></td>
          <td align="center"><p>
            <input type="radio" name="delete" id="delete" value="yes" />
            Yes</p>
            <p>
              <input name="delete" type="radio" id="delete" value="no" checked="checked" />
              No
  <input name="id" type="hidden" id="id" value="<?php echo $row_attendance['id']; ?>" />
            </p></td>
        </tr>
	          <tr>
	            <td align="center">&nbsp;</td>
	            <td align="center"><input name="ansa" type="submit" class="searchbutton" id="ansa" value="Submit" /></td>
              </tr>
            </table>
		  </form>
		</div>

 <?php include('includes/side_admin.php'); ?>
					
<div id="right"></div>
  
  
			
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
mysql_free_result($attendance);
?>
