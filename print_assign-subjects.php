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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "assign_subject")) {
  $insertSQL = sprintf("INSERT INTO subject_teacher (staff_id, subject_id, class_id) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['teacher'], "text"),
                       GetSQLValueString($_POST['subject'], "int"),
                       GetSQLValueString($_POST['class'], "int"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());
}

mysql_select_db($database_unique, $unique);
$query_subject = "SELECT * FROM subject ORDER BY subject.subject_name";
$subject = mysql_query($query_subject, $unique) or die(mysql_error());
$row_subject = mysql_fetch_assoc($subject);
$totalRows_subject = mysql_num_rows($subject);

mysql_select_db($database_unique, $unique);
$query_teachers = "SELECT staff_id, CONCAT_WS(' ',lname, fname) AS name FROM staff WHERE teach= '2' ORDER BY lname ";
$teachers = mysql_query($query_teachers, $unique) or die(mysql_error());
$row_teachers = mysql_fetch_assoc($teachers);
$totalRows_teachers = mysql_num_rows($teachers);

mysql_select_db($database_unique, $unique);
$query_class = "SELECT class_id, class_name FROM `class` ORDER BY `class`.class_name";
$class = mysql_query($query_class, $unique) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);

mysql_select_db($database_unique, $unique);
$query_subject_teacher = "SELECT id, staff_id, subject_id, class_id FROM subject_teacher";
$subject_teacher = mysql_query($query_subject_teacher, $unique) or die(mysql_error());
$row_subject_teacher = mysql_fetch_assoc($subject_teacher);
$totalRows_subject_teacher = mysql_num_rows($subject_teacher);

mysql_select_db($database_unique, $unique);
$query_sub_tea = "SELECT CONCAT_WS(' ',staff.lname, staff.fname) AS staff_name, subject.subject_name, `class`.class_name, subject_teacher.id FROM staff, subject, `class`, subject_teacher WHERE subject_teacher.staff_id = staff.staff_id AND subject_teacher.subject_id = subject.subject_id AND subject_teacher.class_id =`class`.class_id ORDER BY staff.lname, `class`.class_name";
$sub_tea = mysql_query($query_sub_tea, $unique) or die(mysql_error());
$row_sub_tea = mysql_fetch_assoc($sub_tea);
$totalRows_sub_tea = mysql_num_rows($sub_tea);
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
<link rel="shortcut icon" href="favicon.ico" />
</head>
<body>
<div id="content">
  <div id="print">	
			<div id="long_txt_pix">
			  <form name="assign_subject" id="assign_subject" method="POST" action="<?php echo $editFormAction; ?>">
              <table width="95%" border="1">
                <tr>                  </tr>
                <tr>                  </tr>
                <tr>                  </tr>
                </table>
                <p>
                  <input type="hidden" name="MM_insert" value="assign_subject" />
                </p>
                <table width="95%" border="1" cellpadding="6">
                  <tr>
                    <td align="center">&nbsp;</td>
                    <td align="center"><img src="images/ubs-logo.gif" alt="" width="70" height="56" /></td>
                    <td align="center">&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" align="center"><h1>UNIQUE BLOSSOM SCHOOLS</h1>
                      <p>&nbsp;</p>
<h2>ASSIGNED SUBJECTS</h2></td>
                  </tr>
                  <tr>
                    <td width="32%" align="center"><h2>STAFF</h2></td>
                    <td width="36%" align="center"><h2>SUBJECT</h2></td>
                    <td width="32%" align="center"><h2>CLASS</h2></td>
                  </tr>
                  <?php $count=0; ?>
                  <?php do { ?>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><?php echo $row_sub_tea['staff_name']; ?></td>
                    <td><?php echo $row_sub_tea['subject_name']; ?></td>
                    <td><?php echo $row_sub_tea['class_name']; ?></td>
                  </tr>
                    <?php } while ($row_sub_tea = mysql_fetch_assoc($sub_tea)); ?>
                </table>
                <p>&nbsp;</p>
			  </form>
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
mysql_free_result($subject);

mysql_free_result($teachers);

mysql_free_result($class);

mysql_free_result($subject_teacher);

mysql_free_result($sub_tea);
?>
