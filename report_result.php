<?php require_once('../Connections/unique.php'); ?>
<?php require_once('../Connections/unique.php'); ?>
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

$MM_restrictGoTo = "../login.php";
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

$colname_user_id = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_user_id = $_SESSION['MM_Username'];
}
mysql_select_db($database_unique, $unique);
$query_user_id = sprintf("SELECT user_id FROM login WHERE user_name = %s", GetSQLValueString($colname_user_id, "text"));
$user_id = mysql_query($query_user_id, $unique) or die(mysql_error());
$row_user_id = mysql_fetch_assoc($user_id);
$totalRows_user_id = mysql_num_rows($user_id);

$user_id_Pinfo = "-1";
if (isset($_SESSION['id'])) {
  $user_id_Pinfo = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_Pinfo = sprintf("SELECT CONCAT_WS(' ',parent_fname, parent_lname) AS name, sex FROM parent WHERE parent.parent_id=%s", GetSQLValueString($user_id_Pinfo, "text"));
$Pinfo = mysql_query($query_Pinfo, $unique) or die(mysql_error());
$row_Pinfo = mysql_fetch_assoc($Pinfo);
$totalRows_Pinfo = mysql_num_rows($Pinfo);

$colname_result = "-1";
if (isset($_GET['id'])) {
  $colname_result = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_result = sprintf("SELECT result_id,(cat1+ cat2) AS CAT, exam, grade, ( `student_results`.cat1+`student_results`.cat2+ `student_results`.exam) AS total, `student_results`.term, `student_results`.`session`, subject.subject_name FROM `student_results`, subject WHERE student_id = %s AND `student_results`.subject = subject.subject_id ORDER BY subject ASC", GetSQLValueString($colname_result, "text"));
$result = mysql_query($query_result, $unique) or die(mysql_error());
$row_result = mysql_fetch_assoc($result);
$totalRows_result = mysql_num_rows($result);

$var1_student = "-1";
if (isset($_GET['id'])) {
  $var1_student = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_student = sprintf("SELECT CONCAT_WS(' ',student_info.student_Lname, student_info.student_Fname) AS SNAME, student_info.sex, student_info.`class`, `class`.class_name FROM student_info, `class` WHERE student_info.student_id=%s AND student_info.`class` =`class`.class_id", GetSQLValueString($var1_student, "text"));
$student = mysql_query($query_student, $unique) or die(mysql_error());
$row_student = mysql_fetch_assoc($student);
$totalRows_student = mysql_num_rows($student);

$var1_attendance = "-1";
if (isset($_GET['id'])) {
  $var1_attendance = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_attendance = sprintf("SELECT attendance.present, attendance.absent, attendance.school FROM attendance WHERE attendance.term=1 AND attendance.student_id=%s", GetSQLValueString($var1_attendance, "text"));
$attendance = mysql_query($query_attendance, $unique) or die(mysql_error());
$row_attendance = mysql_fetch_assoc($attendance);
$totalRows_attendance = mysql_num_rows($attendance);

$var1_comment = "-1";
if (isset($_GET['id'])) {
  $var1_comment = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_comment = sprintf("SELECT student_report.`comment`, student_report.report_id FROM student_report WHERE student_report.student_id=%s", GetSQLValueString($var1_comment, "text"));
$comment = mysql_query($query_comment, $unique) or die(mysql_error());
$row_comment = mysql_fetch_assoc($comment);
$totalRows_comment = mysql_num_rows($comment);

$colname_skills = "-1";
if (isset($_GET['id'])) {
  $colname_skills = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_skills = sprintf("SELECT skill_id, listen, direction, respect, playground, participate, solve_problem, begin_work_prompty, complete_task, work_independent, work_with_other, controls_talkin, use_time, work_neatly, sport FROM skills WHERE student_id = %s", GetSQLValueString($colname_skills, "text"));
$skills = mysql_query($query_skills, $unique) or die(mysql_error());
$row_skills = mysql_fetch_assoc($skills);
$totalRows_skills = mysql_num_rows($skills);
?>
 <?php $_SESSION['user_id']=$row_user_id['user_id']; ?>
 <?php $avg=0;
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Welcome to Unique Blossom Schools, Abuja.::.Student's Online Result.</title>
    <!-- Slider script -->
   <link rel="stylesheet" href="../nivo-slider.css" type="text/css" media="screen"  />
<!-- 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.nin.js"  type="text/javascript"></script> 
-->

<script type="text/javascript" src="../demo/scripts/jquery-1.6.1.min.js"></script>
<script src="../jquery.nivo.slider.pack.js" type="text/javascript"> </script>

 <link rel="stylesheet" href="../themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../themes/pascal/pascal.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../themes/orman/orman.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../nivo-slider.css" type="text/css" media="screen" />
    
    
    <!-- end of slider script -->
    
    
    
    
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Unique Blossom Schools, Abuja; Creche, Prenursery, Nursery, Primary" />
	<meta name="keywords" content="creche, Nursery, prenursery, reception, primary, schoool, school in abuja, primary school in abuja, nursery school, students, unique blossom" />
	<link rel="stylesheet" href="../style.css" type="text/css" />
<link rel="shortcut icon" href="../favicon.ico" />
<link href="../result.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="content">
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
  <div id="report">	
			<div id="form">
			  <table width="100%" border="0" align="center">
                <tr align="center">
                  <td align="left"><h1><img src="../images/logo_report.jpg" alt="" width="112" height="90" border="0" align="right" class="img_result" />UNIQUE BLOSSOM SCHOOLS</h1>
                    <p align="center">Plot  2251, Tangayika Street, Behind Indian High Commission,<br />
                      off  Ibrahim Babangida Boulevard, Maitama, Abuja.<br />
                  E-mail  :- <a href="mailto:info@uniqueblossomschools.com">info@uniqueblossomschools.com</a></p></td>
                </tr>
                <tr>
                  <td align="left"><h1>REPORT SHEET</h1></td>
                </tr>
                <tr>
                  <td><table width="100%" border="0" class="result_holder">
                    <tr>
                      <td colspan="4"><table width="100%" border="0">
                        <tr>
                          <td>TERM:<strong class="comment"> 1st TERM</strong></td>
                          <td width="34%">SESSION: <strong class="comment">2011/2012</strong></td>
                          <td width="33%">YEAR: <strong class="comment">2011</strong></td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td width="14%"><strong>NAME OF PUPIL</strong>:</td>
                      <td width="50" class="BIGFONT" colspan="2"><h2><?php echo $row_student['SNAME']; ?></h2></td>
                      <td width="17%" align="right" class="BIGFONT">Class:  <strong class="comment"><?php echo $row_student['class_name']; ?></strong></td>
                     
                    </tr>
                    <tr>
                      <td height="94" colspan="4" valign="top"><table width="36%" border="0" align="left">
                        <tr>
                          <td colspan="2" class="BIGFONT">1. ATTENDANCE RECORD</td>
                        </tr>
                        <tr>
                          <td width="57%">No. of    times Attended</td>
                          <td width="43%" class="comment"><strong><?php echo $row_attendance['present']; ?></strong></td>
                        </tr>
                        <tr>
                          <td>No. of    times Absent</td>
                          <td class="comment"><strong><?php echo $row_attendance['absent']; ?></strong></td>
                        </tr>
                        <tr>
                          <td>No. of    times School opened</td>
                          <td class="comment"><strong><?php echo $row_attendance['school']; ?></strong></td>
                        </tr>
                      </table>                        <table width="38%" border="0" align="right">
                        <tr>
                          <td width="52%" align="right">TERM ENDING:</td>
                          <td width="48%" class="comment">9th December, 2011</td>
                        </tr>
                        <tr>
                          <td align="right">NEXT TERM BEGINING:</td>
                          <td class="comment">9th January, 2012</td>
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="31" colspan="4"><strong class="BIGFONT">2. PERFORMANCE IN SUBJECT</strong></td>
                    </tr>
                    <tr>
                      <td colspan="4" valign="top"><div class="result_left">
                        <table width="98%" border="0">
                          <tr>
                            <td><h2>SUBJECT</h2></td>
                            <td><h2>TEST<br />
                            (40)</h2></td>
                            <td><h2>EXAM<br />
                            (60)</h2></td>
                            <td><h2>TOTAL<br />
                            (100)</h2></td>
                            <td><h2>GRADE</h2></td>
                          </tr>
                          <?php do { ?>
                          <tr <?php if($row_result['grade']=='F') {?> class="fail" <?php }?>>
                            <td><strong class="subject"><?php echo $row_result['subject_name']; ?></strong></td>
                            <td><strong><?php echo $row_result['CAT']; ?></strong></td>
                            <td><strong><?php echo $row_result['exam']; ?></strong></td>
                            <td><strong><?php echo $row_result['total']; ?></strong>
                              <?php $avg=$avg+$row_result['total'];  ?></td>
                            <td><strong><?php echo $row_result['grade']; ?></strong></td>
                          </tr>
                          <?php } while ($row_result = mysql_fetch_assoc($result)); ?>
                          <tr >
                            <td colspan="5">&nbsp;</td>
                          </tr>
                          <tr >
                            <td colspan="4" align="right"><strong>Total Score: <?php echo $avg ; ?> </strong></td>
                          </tr>
                          <tr >
                            <td colspan="4" align="right"><strong>Average Score: <span class="BIGFONT">
                              <?php $average=($totalRows_result<>0) ?   $avg/$totalRows_result :  0 ;
							  echo round($average) ;?>
                            </span></strong></td>
                          </tr>
                          <tr >
                            <td colspan="5" class="BIGFONT"> 3.	SKILLS FOR LEARNING IN A SOCIAL ENVIRONMENT </td>
                          </tr>
                          <tr >
                            <td colspan="5" class="subject"><table width="100%" border="0">
                              <tr>
                                <td width="55%"><strong>Listen    attentively</strong></td>
                                <td width="4%">&nbsp;</td>
                                <td width="37%"><span class="comment"><?php echo $row_skills['listen']; ?></span></td>
                                <td width="4%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Follow    Direction</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['direction']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Respects    peer and adults</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['respect']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Demonstrates    appropriate Playground behavior</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['playground']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Participates    Constructively</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['participate']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Solves    problems constructively</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['solve_problem']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Begins    work promptly</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['begin_work_prompty']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Stays on    task to appropriate closure and completion</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['complete_task']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Works    independently</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['work_independent']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Works    cooperatively with others</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['work_with_other']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Controls    unnecessary talking</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['controls_talkin']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Uses    time wisely</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['use_time']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Works    carefully and neatly</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['work_neatly']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td><strong>Sports</strong></td>
                                <td>&nbsp;</td>
                                <td><span class="comment"><?php echo $row_skills['sport']; ?></span></td>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
                          </tr>
                        </table>
                      </div>
                      <div id="result_right">
                        <table width="92%" border="0" class="grade">
                          <tr>
                            <td colspan="2" align="center"><strong>2. GRADING KEYS</strong></td>
                          </tr>
                          <tr>
                            <td>A+</td>
                            <td>95%-100%</td>
                          </tr>
                          <tr>
                            <td>A</td>
                            <td>90%-94%</td>
                          </tr>
                          <tr>
                            <td>B+</td>
                            <td>85%-89%</td>
                          </tr>
                          <tr>
                            <td>B</td>
                            <td>80%- 84%</td>
                          </tr>
                          <tr>
                            <td>C+</td>
                            <td>75%  – 79%</td>
                          </tr>
                          <tr>
                            <td>C</td>
                            <td>70%-74%</td>
                          </tr>
                          <tr>
                            <td>D+</td>
                            <td>65%-69%</td>
                          </tr>
                          <tr>
                            <td>D</td>
                            <td>60%-64%</td>
                          </tr>
                          <tr>
                            <td>P</td>
                            <td>50%-59%</td>
                          </tr>
                          <tr>
                            <td>F</td>
                            <td>BELOW 50%</td>
                          </tr>
                        </table>
                        <p>&nbsp;</p>
                        <table width="99%" border="0" class="grade">
                          <tr>
                            <td colspan="2" align="center"><strong>3. GRADING KEYS</strong></td>
                          </tr>
                          <tr>
                            <td>E</td>
                            <td>EXCELLENT</td>
                          </tr>
                          <tr>
                            <td>G</td>
                            <td>GOOD</td>
                          </tr>
                          <tr>
                            <td>S</td>
                            <td>SATISFACTORY</td>
                          </tr>
                          <tr>
                            <td>N</td>
                            <td>NEED IMPROVEMENT</td>
                          </tr>
                          <tr>
                            <td>U</td>
                            <td>UNSATISFACTORY</td>
                          </tr>
                        </table>
                      </div>
                      <div class="teacher_comment"><span class="teach"><strong>CLASS TEACHER'S COMMENT:</strong></span><span class="comment"> <?php echo nl2br($row_comment['comment']); ?></span></div>
<div id="line"></div>
                      <p>Head of School's Comment: _____________________________________________________________________________________________________________</p></td>
                    </tr>
                  </table></td>
                </tr>
                
              </table>
              <h2>&nbsp;</h2>
</div>
</div>
</div>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
</body>
</html>
<?php
mysql_free_result($user_id);

mysql_free_result($Pinfo);

mysql_free_result($result);

mysql_free_result($student);

mysql_free_result($attendance);

mysql_free_result($comment);

mysql_free_result($skills);
?>
