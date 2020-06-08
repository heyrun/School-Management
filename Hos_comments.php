<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
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

$MM_restrictGoTo = "admin.php";
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

$colname_class = "-1";
if (isset($_GET['class_id'])) {
  $colname_class = $_GET['class_id'];
}
mysql_select_db($database_unique, $unique);
$query_class = sprintf("SELECT class_id, class_name FROM `class` WHERE class_id = %s", GetSQLValueString($colname_class, "text"));
$class = mysql_query($query_class, $unique) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);

$class_id=$row_class['class_id'];






$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO admin_comments (student_id, admin_id, class_id, term, `session`, comments) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['students'], "text"),
                       GetSQLValueString($_POST['teacher_id'], "text"),
                       GetSQLValueString($_POST['class_id'], "int"),
                       GetSQLValueString($_POST['term'], "int"),
                       GetSQLValueString($_POST['session'], "text"),
                       GetSQLValueString($_POST['comment'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());
}
$error=array();
if (isset($_POST['submit_comment'])){
$_POST['students']=trim($_POST['students']);
$_POST['comment']=trim($_POST['comment']);							   
}
 if ((isset($_POST['submit_comment'])) && (empty($_POST['students']))){
													   array_push($error, 'students');
													   }
if((isset($_POST['submit_comment'])) && (empty($_POST['comment']))){
	array_push($error,'comment');
}








if(empty($error)){









}






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

$var1_focused_student = "-1";
if (isset($_POST['students'])) {
  $var1_focused_student = $_POST['students'];
}
mysql_select_db($database_unique, $unique);
$query_focused_student = sprintf("SELECT student_info.student_id, CONCAT_WS(' ',student_info.student_Lname, student_info.student_Fname) as name FROM student_info WHERE student_info.student_id=%s", GetSQLValueString($var1_focused_student, "text"));
$focused_student = mysql_query($query_focused_student, $unique) or die(mysql_error());
$row_focused_student = mysql_fetch_assoc($focused_student);
$totalRows_focused_student = mysql_num_rows($focused_student);

$var1_comment = "-1";
if (isset($_SESSION['id'])) {
  $var1_comment = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_comment = sprintf("SELECT student_report.`comment`, student_report.report_id, CONCAT_WS(' ',student_info.student_Lname, student_info.student_Fname) AS name FROM student_report, student_info WHERE student_report.teacher_id=%s AND student_report.student_id = student_info.student_id", GetSQLValueString($var1_comment, "text"));
$comment = mysql_query($query_comment, $unique) or die(mysql_error());
$row_comment = mysql_fetch_assoc($comment);
$totalRows_comment = mysql_num_rows($comment);

mysql_select_db($database_unique, $unique);
$query_comment_admin = "SELECT admin_comments.sno, admin_comments.comments, `class`.class_name AS class,CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name FROM admin_comments, `class`, student_info WHERE admin_comments.student_id =student_info.student_id AND admin_comments.class_id =`class`.class_id";
$comment_admin = mysql_query($query_comment_admin, $unique) or die(mysql_error());
$row_comment_admin = mysql_fetch_assoc($comment_admin);
$totalRows_comment_admin = mysql_num_rows($comment_admin);
?>
 <?php 
 
 if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup']==1){
	header("location:parents.php");
	
}
 ?>
 <?php $count=0; ?>

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
		  <form action="<?php echo $editFormAction; ?>" name="form1" id="form1" method="POST">
		    <table width="100%" border="1">
		      <tr>
		        <td colspan="2" align="center"><p>
		          <?php 
				  if(isset($Result1) ){?>
                </p>
		          <p><span class="success"> Comments for </span><span class="BIGFONT"><?php echo $row_focused_student['name']; ?></span><span class="success"> has been entered Successfully<br />
		            You can enter the result of the next student </span>
		            <?php } ?>
	              </p>
		          <p>
		            <?php if($_POST &&(isset($error)) && (!empty($error))){ ?>
		            <span class="warning">Result not entered <br />
                Please correct the fields marked **</span><span class="warning"> </span></p>		          <?php } ?></td>
	          </tr>
		      <tr>
		        <td><strong>CLASS</strong></td>
		        <td class="BIGFONT"><?php echo $row_class['class_name']; ?></td>
	          </tr>
		      <tr>
		        <td>Select Students</td>
		        <td><label>
		          <select name="students" id="students">
		            <option value=" ">---Select Student---</option>
		            <?php
do {  
?>
		            <option value="<?php echo $row_students['student_id']?>"><?php echo $row_students['names']?></option>
		            <?php
} while ($row_students = mysql_fetch_assoc($students));
  $rows = mysql_num_rows($students);
  if($rows > 0) {
      mysql_data_seek($students, 0);
	  $row_students = mysql_fetch_assoc($students);
  }
?>
                  </select>
	              <?php if(in_array('students',$error)){ ?>
                  <span class="warning">*Please select a student*</span>
                  <?php } ?>
		        </label></td>
	          </tr>
		      <tr>
		        <td>Session</td>
		        <td><label>
		          <select name="session" id="session">
		            <option value="2010/2011">2010/2011</option>
		            <option value="2011/2012" selected="selected">2011/2012</option>
		            <option value="2012/2013">2012/2013</option>
	              </select>
		        </label></td>
	          </tr>
		      <tr>
		        <td>Term</td>
		        <td><label>
		          <input name="term" type="radio" id="term" value="1" checked="checked" />
		          1st Term
		          <input type="radio" name="term" id="term" value="2" />
		          2nd Term
		          
		          <input type="radio" name="term" id="term2" value="3" />
	            3rd Term </label></td>
	          </tr>
		      <tr>
		        <td>Result Comments</td>
		        <td><label>
		          <textarea name="comment" id="comment" cols="45" rows="5"></textarea>
		          <?php if(in_array('comment',$error)){ ?>
                  <span class="warning">*Please enter comment*</span>
                  <?php } ?>
		        </label></td>
	          </tr>
		      <tr>
		        <td>&nbsp;</td>
		        <td><label>
		          <input name="submit_comment" type="submit" class="searchbutton" id="submit_comment" value="Submit" />
		          <input name="class_id" type="hidden" id="class_id" value="<?php echo $_GET['class_id'] ; ?>" />
		          <input name="teacher_id" type="hidden" id="teacher_id" value="<?php echo $_SESSION['id']; ?>" />
		        </label></td>
	          </tr>
	        </table>
		    <input type="hidden" name="MM_insert" value="form1" />
		    <input type="hidden" name="MM_insert" value="form1" />
          </form>
		  <p class="clr"></p>
          <?php if ($totalRows_comment_admin > 0) { // Show if recordset not empty ?>
  <table width="97%" border="0">
    <tr>
      <td width="7%" class="BIGFONT">S/NO</td>
      <td width="25%" class="BIGFONT">NAMES</td>
      <td width="48%" class="BIGFONT">COMMENT</td>
      <td width="13%">Class</td>
      <td width="7%">Action</td>
    </tr>
    <?php $color=0; ?>
    <?php do { ?>
      <tr <?php if($color++ %2) { ?> class="hlite" <?php } ?>>
        <td><?php echo ++$count; ?></td>
        <td><?php echo $row_comment_admin['name']; ?></td>
        <td><?php echo $row_comment_admin['comments']; ?></td>
        <td><?php echo $row_comment_admin['class']; ?></td>
        <td><a href="delete_HOS_comment.php?id=<?php echo $row_comment_admin['sno']; ?>">Del</a></td>
      </tr>
      <?php } while ($row_comment_admin = mysql_fetch_assoc($comment_admin)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
<p class="clr"> </p>
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

mysql_free_result($focused_student);

mysql_free_result($comment);

mysql_free_result($comment_admin);
if(isset($class))
mysql_free_result($class);
?>
