<?php require_once('Connections/unique.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "2";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO student_comment (teacher_id, student_id, `comment`, comment_date) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['teacher_id'], "text"),
                       GetSQLValueString($_POST['students'], "text"),
                       GetSQLValueString($_POST['comments'], "text"),
                       GetSQLValueString($_POST['date'], "date"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());
}

$colname_mainclass = "-1";
if (isset($_SESSION['id'])) {
  $colname_mainclass = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_mainclass = sprintf("SELECT subject_teacher.subject_id, subject.subject_name, `class`.class_name, `class`.class_id FROM `class`, subject_teacher, subject WHERE subject_teacher.staff_id=%s AND subject_teacher.class_id = `class`.class_id AND subject_teacher.subject_id = subject.subject_id", GetSQLValueString($colname_mainclass, "text"));
$mainclass = mysql_query($query_mainclass, $unique) or die(mysql_error());
$row_mainclass = mysql_fetch_assoc($mainclass);
$totalRows_mainclass = mysql_num_rows($mainclass);
$_SESSION['class_id']=$row_mainclass['class_id'];




$colname_Sinfo = "-1";
if (isset($_SESSION['id'])) {
  $colname_Sinfo = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_Sinfo = sprintf("SELECT staff_id, fname, lname FROM staff WHERE staff_id = %s", GetSQLValueString($colname_Sinfo, "text"));
$Sinfo = mysql_query($query_Sinfo, $unique) or die(mysql_error());
$row_Sinfo = mysql_fetch_assoc($Sinfo);
$totalRows_Sinfo = mysql_num_rows($Sinfo);




$colname_students = "-1";
if (isset($_GET['class_id'])) {
  $colname_students = $_GET['class_id'];
}
mysql_select_db($database_unique, $unique);
$query_students = sprintf("SELECT student_id, CONCAT_WS(' ',student_Lname, student_Fname) AS names FROM student_info WHERE `class` = %s", GetSQLValueString($colname_students, "int"));
$students = mysql_query($query_students, $unique) or die(mysql_error());
$row_students = mysql_fetch_assoc($students);
$totalRows_students = mysql_num_rows($students);

$var1_subject = "-1";
if (isset($_SESSION['id'])) {
  $var1_subject = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_subject = sprintf("SELECT subject_teacher.subject_id, subject.subject_name FROM subject_teacher, subject WHERE subject_teacher.staff_id=%s  AND subject_teacher.subject_id = subject.subject_id", GetSQLValueString($var1_subject, "text"));
$subject = mysql_query($query_subject, $unique) or die(mysql_error());
$row_subject = mysql_fetch_assoc($subject);
$totalRows_subject = mysql_num_rows($subject);


 ?>
 <?php 
 
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
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
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
 <?php include('includes/side1.php'); ?>
<div id="line"></div>
		
		<div id="long_txt_pix">
		  <form name="form1" id="form1" method="POST" action="<?php echo $editFormAction; ?>">
		    <table width="100%" border="1">
		      <tr>
		        <td colspan="2" align="center"><?php if(isset($Result1) && ($Result1==true)){?>
                <span class="success">Your Comment has been successfully Uploaded<br />You can enter the comment of the next student</span><?php } ?></td>
	          </tr>
		      <tr>
		        <td>Select Class</td>
		        <td><label>
		          <select name="class" id="class" onchange="MM_jumpMenu('parent',this,0)">
		            <option value="">---Select Class---</option>
		            <?php
do {  
?>
		            <option value="enter_class.php?class_id=<?php echo $row_mainclass['class_id']; ?>" 
					
					<?php if(isset($_GET['id'])){ if (!(strcmp($row_students['student_id'], $_GET['id']))) {echo "selected=\"selected\"";} } ?>>
					
					<?php echo $row_mainclass['class_name']?></option>
		            <?php
} while ($row_mainclass = mysql_fetch_assoc($mainclass));
  $rows = mysql_num_rows($mainclass);
  if($rows > 0) {
      mysql_data_seek($mainclass, 0);
	  $row_mainclass = mysql_fetch_assoc($mainclass);
  }
?>
                  </select></label></td>
	          </tr>
		      <tr>
		        <td>Select Students</td>
		        <td><label>
		          <select name="students" id="students">
		            <option value=" " <?php if (!(strcmp(" ", $row_students['student_id']))) {echo "selected=\"selected\"";} ?>>---Select Student---</option>
		            <?php
do {  
?>
<option value="<?php echo $row_students['student_id']?>"<?php if (!(strcmp($row_students['student_id'], $row_students['student_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_students['names']?></option>
		            <?php
} while ($row_students = mysql_fetch_assoc($students));
  $rows = mysql_num_rows($students);
  if($rows > 0) {
      mysql_data_seek($students, 0);
	  $row_students = mysql_fetch_assoc($students);
  }
?>
                  </select>
	            </label></td>
	          </tr>
		      <tr>
		        <td>Subject</td>
		        <td><label>
		          <select name="subject" id="subject">
		            <option value="">select subject</option>
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
		        <td>1st CAT</td>
		        <td><label>
		          <input type="text" name="CAT1" id="CAT1" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>2nd CAT</td>
		        <td><label>
		          <input type="text" name="CAT2" id="CAT2" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>EXAMINATION</td>
		        <td><label>
		          <input type="text" name="textfield2" id="textfield2" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>&nbsp;</td>
		        <td>&nbsp;</td>
	          </tr>
		      <tr>
		        <td>&nbsp;</td>
		        <td><label>
		          <?php $day=date('Y-m-d');?>
		          <input name="date" type="hidden" id="date" value="<?php echo $day; ?>" />
		          <input name="teacher_id" type="hidden" id="teacher_id" value="<?php echo $_SESSION['id']; ?>" />
		        </label></td>
	          </tr>
		      <tr>
		        <td>&nbsp;</td>
		        <td><label>
		          <input type="submit" name="submit_comment" id="submit_comment" value="Submit" />
		        </label></td>
	          </tr>
	        </table>
		    <input type="hidden" name="MM_insert" value="form1" />
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
mysql_free_result($Sinfo);

mysql_free_result($students);

mysql_free_result($subject);

mysql_free_result($mainclass);
?>
