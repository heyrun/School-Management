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

$var1_Recordset1 = "UBS/M/008";
if (isset($_SESSION['id'])) {
  $var1_Recordset1 = $_SESSION['id'];
}
$var2_Recordset1 = "12";
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

$var1_Term1 = "23";
if (isset($_GET['class'])) {
  $var1_Term1 = $_GET['class'];
}
mysql_select_db($database_unique, $unique);
$query_Term1 = sprintf("SELECT student_results.result_id, student_results.cat1, student_results.cat2, student_results.exam, student_results.grade, subject.subject_name, CONCAT_WS(' ',student_info.student_Lname, student_info.student_Fname) as name FROM student_results, subject, student_info WHERE student_results.student_id = student_info.student_id AND student_results.term = 1 AND student_results.`session`= '2013/2014' AND student_info.`class` = %s AND student_results.subject = subject.subject_id", GetSQLValueString($var1_Term1, "int"));
$Term1 = mysql_query($query_Term1, $unique) or die(mysql_error());
$row_Term1 = mysql_fetch_assoc($Term1);
$totalRows_Term1 = mysql_num_rows($Term1);
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
    
    
    
    
  <?php $sn=0; ?>  
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
		            <option value="" <?php //if (!(strcmp("", $row_subject['subject_id']))) {echo "selected=\"selected\"";} ?>>select subject</option>
		            <?php
do {  
?>
<option value="<?php echo $row_Recordset1['subject_id']?>"><?php echo $row_Recordset1['subject_name']?></option>
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
		            <option value="2011/2012">2011/2012</option>
		            <option value="2012/2013" selected="selected">2012/2013</option>
		            <option value="2013/2014">2013/2014</option>
		            <option value="2014/2015">2014/2015</option>
	              </select>
		        </label></td>
	          </tr>
		      <tr>
		        <td>Term</td>
		        <td><label>
		          <input name="term" type="radio" id="term" value="1" checked="checked" />
		          1st Term
		          <input name="term" type="radio" id="term" value="2" />
		          2nd Term
		          
		          <input name="term" type="radio" id="term2" value="3" />
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
		    <input type="hidden" name="MM_insert" value="form1" />
		    <input type="hidden" name="MM_insert" value="form1" />
          </form>
          <?php if ($totalRows_Term1 > 0) { // Show if recordset not empty ?>
  <table width="100%" border="1"><?php $i = 1; ?>
    <tr>
      <td>S/N</td>
      <td>Name</td>
      <td>Subject</td>
      <td>CAT 1</td>
      <td>CAT 2</td>
      <td>EXAM</td>
      <td>TOTAL</td>
      <td>GRADE</td>
      <td>ACTION</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $row_Term1['name']; ?></td>
        <td><?php echo $row_Term1['subject_name']; ?></td>
        <td><?php echo $row_Term1['cat1']; ?></td>
        <td><?php echo $row_Term1['cat2']; ?></td>
        <td><?php echo $row_Term1['exam']; ?></td>
        <td><?php echo ($row_Term1['cat1']+$row_Term1['cat2']+$row_Term1['exam']);?></td>
        <td><?php echo $row_Term1['grade']; ?></td>
        <td><a href="delete_result.php?id=<?php echo $row_Term1['result_id']; ?>&amp;session=2012/2013&amp;class=<?php echo $_GET['class']; ?>">del</a></td>
      </tr>
      <?php } while ($row_Term1 = mysql_fetch_assoc($Term1)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
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

mysql_free_result($Recordset1);

mysql_free_result($focused_student);

mysql_free_result($Term1);

mysql_free_result($mainclass);
?>
