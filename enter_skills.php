<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
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



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$error=array();

 if ((isset($_POST['submit_comment'])) && (empty($_POST['students']))){
													   array_push($error, 'students');
													   }
if((isset($_POST['submit_comment'])) &&  empty($_POST['listen'])){
	array_push($error,'listen');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['directions'])){
	array_push($error,'directions');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['respect'])){
	array_push($error,'respect');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['playground'])){
	array_push($error,'playground');
}

if((isset($_POST['submit_comment'])) &&  empty($_POST['participate'])){
	array_push($error,'participate');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['solve_problem'])){
	array_push($error,'solve_problem');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['begin_work_promptly'])){
	array_push($error,'begin_work_promptly');
}


if((isset($_POST['submit_comment'])) &&  empty($_POST['complete_task'])){
	array_push($error,'complete_task');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['work_independent'])){
	array_push($error,'work_independent');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['work_with_other'])){
	array_push($error,'work_with_other');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['controls_talking'])){
	array_push($error,'controls_talking');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['use_time'])){
	array_push($error,'use_time');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['work_neatly'])){
	array_push($error,'work_neatly');
}
if((isset($_POST['submit_comment'])) &&  empty($_POST['sport'])){
	array_push($error,'sport');
}

if(empty($error)){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO skills (teacher_id, student_id, `session`, term, listen, direction, respect, playground, participate, solve_problem, begin_work_prompty, complete_task, work_independent, work_with_other, controls_talkin, use_time, work_neatly, sport) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['teacher_id'], "text"),
                       GetSQLValueString($_POST['students'], "text"),
                       GetSQLValueString($_POST['session'], "text"),
                       GetSQLValueString($_POST['term'], "int"),
                       GetSQLValueString($_POST['listen'], "text"),
                       GetSQLValueString($_POST['directions'], "text"),
                       GetSQLValueString($_POST['respect'], "text"),
                       GetSQLValueString($_POST['playground'], "text"),
                       GetSQLValueString($_POST['participate'], "text"),
                       GetSQLValueString($_POST['solve_problem'], "text"),
                       GetSQLValueString($_POST['begin_work_promptly'], "text"),
                       GetSQLValueString($_POST['complete_task'], "text"),
                       GetSQLValueString($_POST['work_independent'], "text"),
                       GetSQLValueString($_POST['work_with_other'], "text"),
                       GetSQLValueString($_POST['controls_talking'], "text"),
                       GetSQLValueString($_POST['use_time'], "text"),
                       GetSQLValueString($_POST['work_neatly'], "text"),
                       GetSQLValueString($_POST['sport'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());
}
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


$colname_class = "-1";
if (isset($_SESSION['id'])) {
  $colname_class = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_class = sprintf("SELECT class_id, class_name FROM `class` WHERE staff_id = %s", GetSQLValueString($colname_class, "text"));
$class = mysql_query($query_class, $unique) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);

$class_id=$row_class['class_id'];




$colname_students = "-1";
if (isset($class_id)) {
  $colname_students = $class_id;
}
mysql_select_db($database_unique, $unique);
$query_students = sprintf("SELECT student_id, CONCAT_WS(' ',student_Lname, student_Fname) AS names FROM student_info WHERE `class` = %s ORDER BY student_info.student_Lname", GetSQLValueString($colname_students, "int"));
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

$colname_S = "-1";
if (isset($_SESSION['id'])) {
  $colname_S = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_S = sprintf("SELECT student_info.student_Fname, skills.skill_id, skills.teacher_id, skills.student_id, skills.direction, skills.respect, skills.playground, skills.participate, skills.solve_problem, skills.begin_work_prompty, skills.complete_task, skills.work_independent, skills.work_with_other, skills.controls_talkin, skills.use_time, skills.work_neatly, skills.sport, skills.listen FROM skills, student_info WHERE teacher_id = %s AND skills.student_id = student_info.student_id AND skills.term=0  AND skills.`session` = '2013/2014'", GetSQLValueString($colname_S, "text"));
$S = mysql_query($query_S, $unique) or die(mysql_error());
$row_S = mysql_fetch_assoc($S);
$totalRows_S = mysql_num_rows($S);

$colname_s2 = "-1";
if (isset($_SESSION['id'])) {
  $colname_s2 = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_s2 = sprintf("SELECT student_info.student_Fname, skills.skill_id, skills.teacher_id, skills.student_id, skills.direction, skills.respect, skills.playground, skills.participate, skills.solve_problem, skills.begin_work_prompty, skills.complete_task, skills.work_independent, skills.work_with_other, skills.controls_talkin, skills.use_time, skills.work_neatly, skills.sport, skills.listen FROM skills, student_info WHERE teacher_id = %s AND skills.student_id = student_info.student_id AND skills.term=2  AND skills.`session` = '2013/2014'", GetSQLValueString($colname_s2, "text"));
$s2 = mysql_query($query_s2, $unique) or die(mysql_error());
$row_s2 = mysql_fetch_assoc($s2);
$totalRows_s2 = mysql_num_rows($s2);

$colname_s3 = "-1";
if (isset($_SESSION['id'])) {
  $colname_s3 = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_s3 = sprintf("SELECT student_info.student_Fname, skills.skill_id, skills.teacher_id, skills.student_id, skills.direction, skills.respect, skills.playground, skills.participate, skills.solve_problem, skills.begin_work_prompty, skills.complete_task, skills.work_independent, skills.work_with_other, skills.controls_talkin, skills.use_time, skills.work_neatly, skills.sport, skills.listen FROM skills, student_info WHERE teacher_id = %s AND skills.student_id = student_info.student_id AND skills.term=3   AND skills.`session` = '2013/2014'", GetSQLValueString($colname_s3, "int"));
$s3 = mysql_query($query_s3, $unique) or die(mysql_error());
$row_s3 = mysql_fetch_assoc($s3);
$totalRows_s3 = mysql_num_rows($s3);
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
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
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
        <td colspan="2" align="center"><?php if(isset($Result1) && ($Result1==true)){?>
          <p><span class="success"> Skills for </span><span class="BIGFONT"><?php echo $row_focused_student['name']; ?></span><span class="success"> Successfully entered<br />
              You can enter the Attendance of the next student </span>
            <?php } ?>
            <br />
            <?php if($_POST &&(isset($error)) && (!empty($error))){ ?>
            <span class="warning">Result not entered <br />
            Please correct the fields marked **</span><span class="warning"> </span></p>
          <?php } ?></td>
      </tr>
      <tr>
        <td width="65%" class="BIGFONT">Select Students</td>
        <td width="35%"><label> <span class="BIGFONT">
          <input name="teacher_id" type="hidden" id="teacher_id" value="<?php echo $_SESSION['id']; ?>" />
          </span>
          <select name="students" id="students">
            <option value="">---Select Student---</option>
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
          <span class="warning">**</span>
          <?php } ?>
        </label></td>
      </tr>
      <tr>
        <td class="BIGFONT">Session</td>
        <td><label>
          <select name="session" id="session">
            <option value="2010/2011">2010/2011</option>
            <option value="2011/2012">2011/2012</option>
            <option value="2012/2013" selected="selected">2012/2013</option>
            <option value="2013/2014">2013/2014</option>
            <option value="2014/2015">2014/2015</option>
          </select>
        </label></td>
      </tr>
      <tr>
        <td class="BIGFONT">Term</td>
        <td><label>
          <input name="term" type="radio" id="term" value="0" checked="checked" />
          1st Term
          <input name="term" type="radio" id="term" value="2" />
          2nd Term
          <input name="term" type="radio" id="term2" value="3" />
          3rd Term </label></td>
      </tr>
      <tr>
        <td class="BIGFONT">Listen    attentively</td>
        <td><label>
          <select name="listen" id="listen">
            <option value="">--SELECT SCORE--</option>
            <option value="E">EXCELLENT</option>
            <option value="G">GOOD</option>
            <option value="S">SATISFACTORY</option>
            <option value="N">NEEDS IMPROVEMENT</option>
            <option value="U">UNSATISFACTORY</option>
          </select>
          <?php if(in_array('listen',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?>
        </label></td>
      </tr>
      <tr>
        <td class="BIGFONT">Follow    Direction</td>
        <td><label>
          <select name="directions" id="directions">
            <option value="">--SELECT SCORE--</option>
            <option value="E">EXCELLENT</option>
            <option value="G">GOOD</option>
            <option value="S">SATISFACTORY</option>
            <option value="N">NEEDS IMPROVEMENT</option>
            <option value="U">UNSATISFACTORY</option>
          </select>
          <?php if(in_array('directions',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?>
        </label></td>
      </tr>
      <tr>
        <td class="BIGFONT">Respects    peer and adults</td>
        <td><label>
          <select name="respect" id="respect">
            <option value="">--SELECT SCORE--</option>
            <option value="E">EXCELLENT</option>
            <option value="G">GOOD</option>
            <option value="S">SATISFACTORY</option>
            <option value="N">NEEDS IMPROVEMENT</option>
            <option value="U">UNSATISFACTORY</option>
          </select>
          <?php if(in_array('respect',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?>
        </label></td>
      </tr>
      <tr>
        <td class="BIGFONT">Demonstrates    appropriate Playground behavior</td>
        <td><select name="playground" id="playground">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('playground',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Participates    Constructively</td>
        <td><select name="participate" id="participate">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('participate',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Solves    problems constructively</td>
        <td><select name="solve_problem" id="solve_problem">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('solve_problem',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Begins    work promptly</td>
        <td><select name="begin_work_promptly" id="begin_work_promptly">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('begin_work_promptly',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Stays on    task to appropriate closure and completion</td>
        <td><select name="complete_task" id="complete_task">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('complete_task',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Works    independently</td>
        <td><select name="work_independent" id="work_independent">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('work_independent',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Works    cooperatively with others</td>
        <td><select name="work_with_other" id="work_with_other">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('work_with_other',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Controls    unnecessary talking</td>
        <td><select name="controls_talking" id="controls_talking">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('controls_talking',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Uses    time wisely</td>
        <td><select name="use_time" id="use_time">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('use_time',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Works    carefully and neatly</td>
        <td><select name="work_neatly" id="work_neatly">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('work_neatly',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td class="BIGFONT">Sports</td>
        <td><select name="sport" id="sport">
          <option value="">--SELECT SCORE--</option>
          <option value="E">EXCELLENT</option>
          <option value="G">GOOD</option>
          <option value="S">SATISFACTORY</option>
          <option value="N">NEEDS IMPROVEMENT</option>
          <option value="U">UNSATISFACTORY</option>
        </select>
          <?php if(in_array('sport',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><label>
          <input name="submit_comment" type="submit" class="searchbutton" id="submit_comment" value="Submit" />
        </label></td>
      </tr>
    </table>
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_insert" value="form1" />
    <input type="hidden" name="MM_insert" value="form1" />
  </form>
  <div id="CollapsiblePanel2" class="CollapsiblePanel">
        <div class="CollapsiblePanelTab" tabindex="0">
          <h1><span class="clr">THIRD TERM</span></h1>
        </div>
        <div class="CollapsiblePanelContent">
          <?php if ($totalRows_s3 > 0) { // Show if recordset not empty ?>
          <table width="100%" border="0" class="hlite">
            <tr>
              <td>NAME</td>
              <td>LA</td>
              <td>FD</td>
              <td>RP</td>
              <td>DA</td>
              <td>PC</td>
              <td>SP</td>
              <td>BW</td>
              <td>SO</td>
              <td>WI</td>
              <td>WC</td>
              <td>CU</td>
              <td>UT</td>
              <td>WC</td>
              <td>S</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
            <tr>
              <td><?php echo $row_s3['student_Fname']; ?></td>
              <td><?php echo $row_s3['listen']; ?></td>
              <td><?php echo $row_s3['direction']; ?></td>
              <td><?php echo $row_s3['respect']; ?></td>
              <td><?php echo $row_s3['playground']; ?></td>
              <td><?php echo $row_s3['participate']; ?></td>
              <td><?php echo $row_s3['solve_problem']; ?></td>
              <td><?php echo $row_s3['begin_work_prompty']; ?></td>
              <td><?php echo $row_s3['complete_task']; ?></td>
              <td><?php echo $row_s3['work_independent']; ?></td>
              <td><?php echo $row_s3['work_with_other']; ?></td>
              <td><?php echo $row_s3['controls_talkin']; ?></td>
              <td><?php echo $row_s3['use_time']; ?></td>
              <td><?php echo $row_s3['work_neatly']; ?></td>
              <td><?php echo $row_s3['sport']; ?></td>
              <td><a href="delete_skills.php?id=<?php echo $row_s3['skill_id']; ?>">Del</a></td>
            </tr>
            <?php } while ($row_s3 = mysql_fetch_assoc($s3)); ?>
          </table>
          <?php } // Show if recordset not empty ?>
        </div>
      </div>
    <p>&nbsp;</p>
    <div id="CollapsiblePanel3" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">
        <h1>SECOND TERM</h1>
      </div>
      <div class="CollapsiblePanelContent">
        <?php if ($totalRows_s2 > 0) { // Show if recordset not empty ?>
        <h2 class="clr"><br />
        </h2>
        <table width="100%" border="0" class="hlite">
          <tr>
            <td>NAME</td>
            <td>LA</td>
            <td>FD</td>
            <td>RP</td>
            <td>DA</td>
            <td>PC</td>
            <td>SP</td>
            <td>BW</td>
            <td>SO</td>
            <td>WI</td>
            <td>WC</td>
            <td>CU</td>
            <td>UT</td>
            <td>WC</td>
            <td>S</td>
            <td>&nbsp;</td>
          </tr>
          <?php do { ?>
          <tr>
            <td><?php echo $row_s2['student_Fname']; ?></td>
            <td><?php echo $row_s2['listen']; ?></td>
            <td><?php echo $row_s2['direction']; ?></td>
            <td><?php echo $row_s2['respect']; ?></td>
            <td><?php echo $row_s2['playground']; ?></td>
            <td><?php echo $row_s2['participate']; ?></td>
            <td><?php echo $row_s2['solve_problem']; ?></td>
            <td><?php echo $row_s2['begin_work_prompty']; ?></td>
            <td><?php echo $row_s2['complete_task']; ?></td>
            <td><?php echo $row_s2['work_independent']; ?></td>
            <td><?php echo $row_s2['work_with_other']; ?></td>
            <td><?php echo $row_s2['controls_talkin']; ?></td>
            <td><?php echo $row_s2['use_time']; ?></td>
            <td><?php echo $row_s2['work_neatly']; ?></td>
            <td><?php echo $row_s2['sport']; ?></td>
            <td><a href="delete_skills.php?id=<?php echo $row_s2['skill_id']; ?>">Del</a></td>
          </tr>
          <?php } while ($row_s2 = mysql_fetch_assoc($s2)); ?>
        </table>
        <?php } // Show if recordset not empty ?>
      </div>
    </div>
    <p><br />
    </p>
    <div id="CollapsiblePanel1" class="CollapsiblePanel">
      <div class="CollapsiblePanelTab" tabindex="0">
        <h1><span class="clr">FIRST TERM</span></h1>
      </div>
      <div class="CollapsiblePanelContent">
        <?php if ($totalRows_S > 0) { // Show if recordset not empty ?>
          <table width="100%" border="1" class="hlite">
            <tr>
              <td>NAME</td>
              <td>LA</td>
              <td>FD</td>
              <td>RP</td>
              <td>DA</td>
              <td>PC</td>
              <td>SP</td>
              <td>BW</td>
              <td>SO</td>
              <td>WI</td>
              <td>WC</td>
              <td>CU</td>
              <td>UT</td>
              <td>WC</td>
              <td>S</td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_S['student_Fname']; ?></td>
                <td><?php echo $row_S['listen']; ?></td>
                <td><?php echo $row_S['direction']; ?></td>
                <td><?php echo $row_S['respect']; ?></td>
                <td><?php echo $row_S['playground']; ?></td>
                <td><?php echo $row_S['participate']; ?></td>
                <td><?php echo $row_S['solve_problem']; ?></td>
                <td><?php echo $row_S['begin_work_prompty']; ?></td>
                <td><?php echo $row_S['complete_task']; ?></td>
                <td><?php echo $row_S['work_independent']; ?></td>
                <td><?php echo $row_S['work_with_other']; ?></td>
                <td><?php echo $row_S['controls_talkin']; ?></td>
                <td><?php echo $row_S['use_time']; ?></td>
                <td><?php echo $row_S['work_neatly']; ?></td>
                <td><?php echo $row_S['sport']; ?></td>
                <td><a href="delete_skills.php?id=<?php echo $row_S['skill_id']; ?>">Del</a></td>
              </tr>
              <?php } while ($row_S = mysql_fetch_assoc($S)); ?>
          </table>
          <?php } // Show if recordset not empty ?>
      </div>
    </div>
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
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel2");
var CollapsiblePanel3 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel3", {contentIsOpen:false});
</script>
</body>
</html>
<?php
mysql_free_result($Sinfo);

mysql_free_result($class);



mysql_free_result($students);

mysql_free_result($focused_student);

mysql_free_result($S);

mysql_free_result($s2);

mysql_free_result($s3);


?>
