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
<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
$error=array();
if ((isset($_POST['submit_comment'])) && (empty($_POST['subject']))){
													   array_push($error, 'subject');
													   }
 if (isset($_POST['submit_comment'])){
	 $_POST['students']=trim($_POST['students']);
	 
	 if (empty($_POST['students'])){
													   array_push($error, 'students');
													   }
 }
if(isset($_POST['submit_comment']) && ($_POST['CAT1']>20)) {
	array_push($error,'CAT1');
}
if(isset($_POST['submit_comment']) && ($_POST['CAT2']>20)){
	array_push($error,'CAT2');
}
if((isset($_POST['submit_comment'])) && ((($_POST['EXAM']>60)) )){
	array_push($error,'EXAM');
}
if((isset($_POST['submit_comment']))){
	
	if(empty($error)){
	$total=$_POST['CAT1']+$_POST['CAT2']+$_POST['EXAM'];
	if ($total<50) $_POST['GRADE']='F';
	elseif($total>=50.0 && $total<=59.9) $_POST['GRADE']='P';
	elseif($total>=60.0 && $total<=64.9) $_POST['GRADE']='D';
	elseif($total>=65.0 && $total<=69.9) $_POST['GRADE']='D+';
	elseif($total>=70.0 && $total<=74.9) $_POST['GRADE']='C';
	elseif($total>=75.0 && $total<=79.9) $_POST['GRADE']='C+';
	elseif($total>=80.0 && $total<=84.9) $_POST['GRADE']='B';
	elseif($total>=85.0 && $total<=89.9) $_POST['GRADE']='B+';
	elseif($total>=90.0 && $total<=94.9) $_POST['GRADE']='A';
	elseif($total>=95.0 && $total<=100) $_POST['GRADE']='A+';
	
	
	
	}
				 
				 if(empty($_POST['GRADE']) || empty($_POST['GRADE'])){
	array_push($error,'GRADE');
}
				 }

if(empty($error)){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO student_results (teacher_id, student_id, subject, cat1, cat2, exam, grade, term, `session`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['teacher_id'], "text"),
                       GetSQLValueString($_POST['students'], "text"),
                       GetSQLValueString($_POST['subject'], "int"),
                       GetSQLValueString($_POST['CAT1'], "double"),
                       GetSQLValueString($_POST['CAT2'], "double"),
                       GetSQLValueString($_POST['EXAM'], "double"),
                       GetSQLValueString($_POST['GRADE'], "text"),
                       GetSQLValueString($_POST['term'], "text"),
                       GetSQLValueString($_POST['session'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());
}
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
if (isset($_GET['class'])) {
  $colname_students = $_GET['class'];
}
mysql_select_db($database_unique, $unique);
$query_students = sprintf("SELECT student_id, CONCAT_WS(' ',student_Lname, student_Fname) AS names FROM student_info WHERE `class` = %s ORDER BY student_info.student_Lname", GetSQLValueString($colname_students, "int"));
$students = mysql_query($query_students, $unique) or die(mysql_error());
$row_students = mysql_fetch_assoc($students);
$totalRows_students = mysql_num_rows($students);

$var1_subject = "-1";
if (isset($_SESSION['id'])) {
  $var1_subject = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_subject = sprintf("SELECT DISTINCT subject_teacher.subject_id, subject.subject_name FROM subject_teacher, subject WHERE subject_teacher.staff_id=%s  AND subject_teacher.subject_id = subject.subject_id", GetSQLValueString($var1_subject, "text"));
$subject = mysql_query($query_subject, $unique) or die(mysql_error());
$row_subject = mysql_fetch_assoc($subject);
$totalRows_subject = mysql_num_rows($subject);

$colname_results = "-1";
if (isset($_SESSION['id'])) {
  $colname_results = $_SESSION['id'];
}
$var1_results = "-1";
if (isset($_GET['class'])) {
  $var1_results = $_GET['class'];
}
mysql_select_db($database_unique, $unique);
$query_results = sprintf("SELECT CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name, student_results.cat1, student_results.cat2, student_results.exam, subject.subject_name, student_results.grade, student_results.result_id FROM student_info, student_results, subject WHERE student_results.teacher_id=%s AND student_results.student_id = student_info.student_id AND student_results.subject = subject.subject_id AND student_info.`class`=%s AND student_results.term =2 ORDER BY  subject.subject_name, student_info.student_Lname", GetSQLValueString($colname_results, "text"),GetSQLValueString($var1_results, "int"));
$results = mysql_query($query_results, $unique) or die(mysql_error());
$row_results = mysql_fetch_assoc($results);
$totalRows_results = mysql_num_rows($results);

$var1_Recordset1 = "-1";
if (isset($_SESSION['id'])) {
  $var1_Recordset1 = $_SESSION['id'];
}
$var2_Recordset1 = "-1";
if (isset($_GET['class'])) {
  $var2_Recordset1 = $_GET['class'];
}
mysql_select_db($database_unique, $unique);
$query_Recordset1 = sprintf("SELECT DISTINCT subject_teacher.subject_id, subject.subject_name FROM subject_teacher, subject WHERE subject_teacher.staff_id=%s  AND subject_teacher.subject_id = subject.subject_id AND subject_teacher.class_id=%s", GetSQLValueString($var1_Recordset1, "text"),GetSQLValueString($var2_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $unique) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$var1_focused_student = "-1";
if (isset($_POST['students'])) {
  $var1_focused_student = $_POST['students'];
}
mysql_select_db($database_unique, $unique);
$query_focused_student = sprintf("SELECT student_info.student_id, CONCAT_WS(' ',student_info.student_Lname, student_info.student_Fname) as name FROM student_info WHERE student_info.student_id=%s", GetSQLValueString($var1_focused_student, "text"));
$focused_student = mysql_query($query_focused_student, $unique) or die(mysql_error());
$row_focused_student = mysql_fetch_assoc($focused_student);
$totalRows_focused_student = mysql_num_rows($focused_student);

$colname_Result1stTerm = "-1";
if (isset($_SESSION['id'])) {
  $colname_Result1stTerm = $_SESSION['id'];
}
$var1_Result1stTerm = "-1";
if (isset($_GET['class'])) {
  $var1_Result1stTerm = $_GET['class'];
}
mysql_select_db($database_unique, $unique);
$query_Result1stTerm = sprintf("SELECT CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name, student_results.cat1, student_results.cat2, student_results.exam, subject.subject_name, student_results.grade, student_results.result_id FROM student_info, student_results, subject WHERE student_results.teacher_id=%s AND student_results.student_id = student_info.student_id AND student_results.subject = subject.subject_id AND student_info.`class`=%s AND student_results.term =1 ORDER BY student_info.student_Lname", GetSQLValueString($colname_Result1stTerm, "int"),GetSQLValueString($var1_Result1stTerm, "int"));
$Result1stTerm = mysql_query($query_Result1stTerm, $unique) or die(mysql_error());
$row_Result1stTerm = mysql_fetch_assoc($Result1stTerm);
$totalRows_Result1stTerm = mysql_num_rows($Result1stTerm);

$colname_result3 = "-1";
if (isset($_SESSION['id'])) {
  $colname_result3 = $_SESSION['id'];
}
$var1_result3 = "-1";
if (isset($_GET['class'])) {
  $var1_result3 = $_GET['class'];
}
mysql_select_db($database_unique, $unique);
$query_result3 = sprintf("SELECT CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name, student_results.cat1, student_results.cat2, student_results.exam, subject.subject_name, student_results.grade, student_results.result_id FROM student_info, student_results, subject WHERE student_results.teacher_id=%s AND student_results.student_id = student_info.student_id AND student_results.subject = subject.subject_id AND student_info.`class`=%s AND student_results.term =3 ORDER BY subject.subject_name, student_info.student_Lname", GetSQLValueString($colname_result3, "text"),GetSQLValueString($var1_result3, "int"));
$result3 = mysql_query($query_result3, $unique) or die(mysql_error());
$row_result3 = mysql_fetch_assoc($result3);
$totalRows_result3 = mysql_num_rows($result3);
?>
 <?php 
 
 if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup']==1){
	header("location:parents.php");
	
}
 ?>
 <?php $count=0; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:spry="http://ns.adobe.com/spry">
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
    
    
    
    
  <?php $sn=0; ?>  
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Unique Blossom Schools, Abuja; Creche, Prenursery, Nursery, Primary" />
	<meta name="keywords" content="creche, Nursery, prenursery, reception, primary, schoool, school in abuja, primary school in abuja, nursery school, students, unique blossom" />
	<link rel="stylesheet" href="style.css" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryData.js" type="text/javascript"></script>
<script src="SpryAssets/SpryHTMLDataSet.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript">
<!--
var ds1 = new Spry.Data.HTMLDataSet(null, "Term3", {sortOnLoad: "STUDENT'S_NAME", sortOrderOnLoad: "ascending"});
var ds2 = new Spry.Data.HTMLDataSet(null, "term2nd", {sortOnLoad: "STUDENT'S_NAME", sortOrderOnLoad: "ascending"});
ds2.setColumnType("S/NO", "number");
ds2.setColumnType("1ST_CAT", "number");
ds2.setColumnType("2ND_CAT", "number");
ds2.setColumnType("EXAM", "number");
ds2.setColumnType("TOTAL", "number");
var ds3 = new Spry.Data.HTMLDataSet(null, "term1");
ds3.setColumnType("S/NO", "number");
ds3.setColumnType("1ST_CAT", "number");
ds3.setColumnType("2ND_CAT", "number");
ds3.setColumnType("EXAM", "number");
ds3.setColumnType("TOTAL", "number");
ds3.setColumnType("GRADE", "number");
//-->
</script>
</head>
<body>
<div id="content">
	<div spry:region="ds3"></div>
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
                  <p><span class="success"> Result of  </span><span class="BIGFONT"><?php echo $row_focused_student['name']; ?></span><span class="success"> has been entered Successfully<br />
                  You can enter the result of the next student </span>
                    <?php } ?>
  <br />
  <?php if($_POST &&(isset($error)) && (!empty($error))){ ?>
  <span class="warning">Result not entered <br />
  Please correct the fields marked **</span><span class="warning"> </span></p>                  <?php } ?></td>
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
                  <span class="warning">*Please Select a name*</span>
                  <?php } ?>
		        </label></td>
	          </tr>
		      <tr>
		        <td>Subject</td>
		        <td><label>
		          <select name="subject" id="subject">
		            <option value="" <?php if (!(strcmp("", $row_subject['subject_id']))) {echo "selected=\"selected\"";} ?>>select subject</option>
		            <?php
do {  
?>
		            <option value="<?php echo $row_Recordset1['subject_id']?>"<?php if (!(strcmp($row_Recordset1['subject_id'], $row_subject['subject_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_Recordset1['subject_name']?></option>
		            <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
                  </select>
	              <?php if(in_array('subject',$error)){ ?>
                  <span class="warning">**</span>
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
		          <input name="term" type="radio" id="term" value="1" />
		          1st Term
		          <input name="term" type="radio" id="term" value="2" checked="checked" />
		          2nd Term
		          
		          <input type="radio" name="term" id="term2" value="3" />
	            3rd Term </label></td>
	          </tr>
		      <tr>
		        <td>1st CAT</td>
		        <td><label>
		          <input type="text" name="CAT1" id="CAT1" />
	            <?php if(in_array('CAT1',$error)){ ?> <span class="warning">*Score must not be greater than 20*</span><?php } ?></label></td>
	          </tr>
		      <tr>
		        <td>2nd CAT</td>
		        <td><label>
		          <input type="text" name="CAT2" id="CAT2" />
		          <?php if(in_array('CAT2',$error)){ ?>
                  <span class="warning">*Score must not be greater than 20*</span>
                  <?php } ?>
		        </label></td>
	          </tr>
		      <tr>
		        <td>Examination</td>
		        <td><label>
		          <input type="text" name="EXAM" id="EXAM" />
	              <?php if(in_array('EXAM',$error)){ ?>
                  <span class="warning">*Score must not be greater than 60*</span>
                  <?php } ?>
		        </label></td>
	          </tr>
		      <tr>
		        <td>&nbsp;</td>
		        <td><label>
		          <input type="hidden" name="GRADE" id="GRADE" />
		          <?php if(in_array('GRADE',$error)){ ?><span class="warning">*Grade not computed, Contact admin*</span>
                  <?php } ?>
                  <?php $day=date('Y-m-d');?>
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
		    <p>
		      <input type="hidden" name="MM_insert" value="form1" />
		      <input type="hidden" name="MM_insert" value="form1" />
	        </p>
		    <table width="98%" border="1" id="Term3">
		      <tr class="hlite">
		        <td>S/NO</td>
		        <td><strong>STUDENT'S NAME</strong></td>
		        <td><strong>SUBJECT</strong></td>
		        <td align="center"><strong>1ST CAT</strong></td>
		        <td align="center"><strong>2ND CAT</strong></td>
		        <td align="center"><strong>EXAM</strong></td>
		        <td align="center"><strong>TOTAL</strong></td>
		        <td align="center">GRADE</td>
		        <td align="center">ACTION</td>
	          </tr>
		      <?php do { ?>
		      <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
		        <td><?php echo ++$sn; ?></td>
		        <td><?php echo $row_result3['name']; ?></td>
		        <td><?php echo $row_result3['subject_name']; ?></td>
		        <td align="center"><?php echo $row_result3['cat1']; ?></td>
		        <td align="center"><?php echo $row_result3['cat2']; ?></td>
		        <td align="center"><?php echo $row_result3['exam']; ?></td>
		        <td align="center"><?php $total=$row_results['cat1']+$row_results['cat2']+$row_results['exam'];
		echo $total; ?></td>
		        <td align="center"><strong>
		          <?php
							
						
							if ($total<50) $grade='F';
	elseif($total>=50 && $total<=59) $grade='P';
	elseif($total>=60 && $total<=64)$grade='D';
	elseif($total>=65 && $total<=69) $grade='D+';
	elseif($total>=70 && $total<=74) $grade='C';
	elseif($total>=75 && $total<=79) $grade='C+';
	elseif($total>=80 && $total<=84) $grade='B';
	elseif($total>=85 && $total<=89) $grade='B+';
	elseif($total>=90 && $total<=94) $grade='A';
	elseif($total>=95 && $total<=100) $grade='A+';
	echo $grade;
					
							
							?>
		          </strong></td>
		        <td align="center"><a href="delete_result.php?id=<?php echo $row_results['result_id']; ?>&amp;class=<?php echo $_GET['class']; ?>">DEL</a></td>
	          </tr>
		      <?php } while ($row_result3 = mysql_fetch_assoc($result3)); ?>
	        </table>
		    <p>&nbsp;</p>
		    <table>
		      <tr>
		        <th spry:sort="S/NO"><h2>S/NO</h2></th>
		        <th spry:sort="STUDENT'S_NAME"><h2>STUDENT'S_NAME</h2></th>
		        <th spry:sort="SUBJECT"><h2>SUBJECT</h2></th>
		        <th spry:sort="1ST_CAT"><h2>1ST_CAT</h2></th>
		        <th spry:sort="2ND_CAT"><h2>2ND_CAT</h2></th>
		        <th spry:sort="EXAM"><h2>EXAM</h2></th>
		        <th spry:sort="TOTAL"><h2>TOTAL</h2></th>
		        <th spry:sort="GRADE"><h2>GRADE</h2></th>
		        <th spry:sort="ACTION"><h2>ACTION</h2></th>
	          </tr>
		      <tr spry:repeat="ds3" spry:odd="row1" spry:even="row2" spry:hover="hlite">
		        <td>{ds1::S/NO}</td>
		        <td>{ds3::STUDENT'S_NAME}</td>
		        <td>{ds1::SUBJECT}</td>
		        <td>{ds1::1ST_CAT}</td>
		        <td>{ds1::2ND_CAT}</td>
		        <td>{ds1::EXAM}</td>
		        <td>{ds1::TOTAL}</td>
		        <td>{ds1::GRADE}</td>
		        <td>{ds1::ACTION}</td>
	          </tr>
	        </table>
		    <p>&nbsp;</p>
		    <table width="98%" border="1" id="term2nd">
		      <tr class="hlite">
		        <td>S/NO</td>
		        <td><strong>STUDENT'S NAME</strong></td>
		        <td><strong>SUBJ</strong><strong>ECT</strong></td>
		        <td align="center"><strong>1ST CAT</strong></td>
		        <td align="center"><strong>2ND CAT</strong></td>
		        <td align="center"><strong>EXAM</strong></td>
		        <td align="center"><strong>TOTAL</strong></td>
		        <td align="center">GRADE</td>
		        <td align="center">ACTION</td>
	          </tr>
		      <?php do { ?>
		      <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
		        <td><?php echo ++$sn; ?></td>
		        <td><?php echo $row_results['name']; ?></td>
		        <td><?php echo $row_results['subject_name']; ?></td>
		        <td align="center"><?php echo $row_results['cat1']; ?></td>
		        <td align="center"><?php echo $row_results['cat2']; ?></td>
		        <td align="center"><?php echo $row_results['exam']; ?></td>
		        <td align="center"><?php $total=$row_results['cat1']+$row_results['cat2']+$row_results['exam'];
		echo $total; ?></td>
		        <td align="center"><strong>
		          <?php
							
						
							if ($total<50) $grade='F';
	elseif($total>=50 && $total<=59) $grade='P';
	elseif($total>=60 && $total<=64)$grade='D';
	elseif($total>=65 && $total<=69) $grade='D+';
	elseif($total>=70 && $total<=74) $grade='C';
	elseif($total>=75 && $total<=79) $grade='C+';
	elseif($total>=80 && $total<=84) $grade='B';
	elseif($total>=85 && $total<=89) $grade='B+';
	elseif($total>=90 && $total<=94) $grade='A';
	elseif($total>=95 && $total<=100) $grade='A+';
	echo $grade;
					
							
							?>
		          </strong></td>
		        <td align="center"><a href="delete_result.php?id=<?php echo $row_results['result_id']; ?>&amp;class=<?php echo $_GET['class']; ?>">DEL</a></td>
	          </tr>
		      <?php } while ($row_results = mysql_fetch_assoc($results)); ?>
	        </table>
		    <p>&nbsp;</p>
		    <div spry:region="ds2 ds1">
		      <table>
		        <tr>
		          <th spry:sort="S/NO"><h2>S/NO</h2></th>
		          <th spry:sort="STUDENT'S_NAME"><h2>STUDENT'S_NAME</h2></th>
		          <th spry:sort="SUBJECT"><h2>SUBJECT</h2></th>
		          <th spry:sort="1ST_CAT"><h2>1ST_CAT</h2></th>
		          <th spry:sort="2ND_CAT"><h2>2ND_CAT</h2></th>
		          <th spry:sort="EXAM"><h2>EXAM</h2></th>
		          <th spry:sort="TOTAL"><h2>TOTAL</h2></th>
		          <th spry:sort="GRADE"><h2>GRADE</h2></th>
		          <th spry:sort="ACTION"><h2>ACTION</h2></th>
	            </tr>
		        <tr spry:repeat="ds2" spry:odd="row1" spry:even="row2" spry:hover="BIGFONT">
		          <td>{ds1::S/NO}</td>
		          <td>{ds2::STUDENT'S_NAME}</td>
		          <td>{ds1::SUBJECT}</td>
		          <td>{ds1::1ST_CAT}</td>
		          <td>{ds1::2ND_CAT}</td>
		          <td>{ds1::EXAM}</td>
		          <td>{ds1::TOTAL}</td>
		          <td>{ds1::GRADE}</td>
		          <td>{ds1::ACTION}</td>
	            </tr>
	          </table>
	        </div>
		    <p>&nbsp;</p>
		    <table width="98%" border="1" id="term1">
		      <tr class="hlite">
		        <td>S/NO</td>
		        <td><strong>STUDENT'S NAME</strong></td>
		        <td><strong>SUBJECT</strong></td>
		        <td align="center"><strong>1ST CAT</strong></td>
		        <td align="center"><strong>2ND CAT</strong></td>
		        <td align="center"><strong>EXAM</strong></td>
		        <td align="center"><strong>TOTAL</strong></td>
		        <td align="center">GRADE</td>
		        <td align="center">ACTION</td>
	          </tr>
		      <?php $pn=0; $style=0; ?>
		      <?php do { ?>
		      <tr <?php if ($style++ %2) echo 'class="hlite"'; ?>>
		        <td><?php echo ++$pn; ?></td>
		        <td><?php echo $row_Result1stTerm['name']; ?></td>
		        <td><?php echo $row_Result1stTerm['subject_name']; ?></td>
		        <td align="center"><?php echo $row_Result1stTerm['cat1']; ?></td>
		        <td align="center"><?php echo $row_Result1stTerm['cat2']; ?></td>
		        <td align="center"><?php echo $row_Result1stTerm['exam']; ?></td>
		        <td align="center"><?php $total=$row_Result1stTerm['cat1']+$row_Result1stTerm['cat2']+$row_Result1stTerm['exam'];
		echo $total; ?></td>
		        <td align="center"><strong>
		          <?php
							
						
							if ($total<50) $grade='F';
	elseif($total>=50 && $total<=59) $grade='P';
	elseif($total>=60 && $total<=64)$grade='D';
	elseif($total>=65 && $total<=69) $grade='D+';
	elseif($total>=70 && $total<=74) $grade='C';
	elseif($total>=75 && $total<=79) $grade='C+';
	elseif($total>=80 && $total<=84) $grade='B';
	elseif($total>=85 && $total<=89) $grade='B+';
	elseif($total>=90 && $total<=94) $grade='A';
	elseif($total>=95 && $total<=100) $grade='A+';
	echo $grade;
					
							
							?>
		          </strong></td>
		        <td align="center">DEL</td>
	          </tr>
		      <?php } while ($row_Result1stTerm = mysql_fetch_assoc($Result1stTerm)); ?>
	        </table>
		    <div spry:region="ds1">
		      <table>
		        <tr>
		          <th spry:sort="S/NO"><h2>S/NO</h2></th>
		          <th spry:sort="STUDENT'S_NAME"><h2>STUDENT'S_NAME</h2></th>
		          <th spry:sort="SUBJECT"><h2>SUBJECT</h2></th>
		          <th spry:sort="1ST_CAT"><h2>1ST_CAT</h2></th>
		          <th spry:sort="2ND_CAT"><h2>2ND_CAT</h2></th>
		          <th spry:sort="EXAM"><h2>EXAM</h2></th>
		          <th spry:sort="TOTAL"><h2>TOTAL</h2></th>
		          <th spry:sort="GRADE"><h2>GRADE</h2></th>
		          <th spry:sort="ACTION"><h2>ACTION</h2></th>
	            </tr>
		        <tr spry:repeat="ds1" spry:setrow="ds1" spry:odd="row1" spry:even="BIGFONT" spry:hover="BIGFONT" spry:select="BIGFONT">
		          <td>{S/NO}</td>
		          <td>{ds1::STUDENT'S_NAME}</td>
		          <td>{SUBJECT}</td>
		          <td>{1ST_CAT}</td>
		          <td>{2ND_CAT}</td>
		          <td>{EXAM}</td>
		          <td>{TOTAL}</td>
		          <td>{GRADE}</td>
		          <td>{ACTION}</td>
	            </tr>
	          </table>
	        </div>
<p>&nbsp;</p>
		  </form>
<br />
<h2><br />
          </h2>
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

mysql_free_result($subject);

mysql_free_result($results);

mysql_free_result($Recordset1);

mysql_free_result($focused_student);

mysql_free_result($Result1stTerm);

mysql_free_result($result3);

mysql_free_result($mainclass);
?>
