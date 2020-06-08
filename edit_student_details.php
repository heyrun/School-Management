<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php'); ?>
<?php
$i=0;
$error=array();
$message='';
$idsent=true;

?>
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "assign_subject")) {
  $updateSQL = sprintf("UPDATE student_info SET Parent1=%s, parent2=%s, student_Fname=%s, student_Lname=%s, sex=%s, dob=%s, `class`=%s, year_admitted=%s, picture=%s WHERE student_id=%s",
                       GetSQLValueString($_POST['parent1'], "text"),
                       GetSQLValueString($_POST['parent2'], "text"),
                       GetSQLValueString($_POST['student_fname'], "text"),
                       GetSQLValueString($_POST['student_lname'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['class'], "int"),
                       GetSQLValueString($_POST['year_admitted'], "int"),
                       GetSQLValueString($_POST['picture'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($updateSQL, $unique) or die(mysql_error());

  $updateGoTo = "view_students.php?message=update";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
if(isset($_POST['Add'])){
	foreach ($_POST as $item){
		$item=trim($item);
	}
}
if (empty($_POST['fname'])){
	array_push($error,'fname');
}
if (empty($_POST['lname'])){
	array_push($error,'lname');
}


if(empty($error)){

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "assign_subject")) {
  $insertSQL = sprintf("INSERT INTO parent (parent_id, parent_fname, parent_lname, profession, office_address, home_address, office_phone, home_phone, mobile_phone, sex, origin, religion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['profession'], "text"),
                       GetSQLValueString($_POST['o_address'], "text"),
                       GetSQLValueString($_POST['h_address'], "text"),
                       GetSQLValueString($_POST['o_number'], "text"),
                       GetSQLValueString($_POST['h_number'], "text"),
                       GetSQLValueString($_POST['m_number'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['origin'], "text"),
                       GetSQLValueString($_POST['religion'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique);
 
}
}
if(isset($_GET['cat'])){
switch($_GET['cat']){
	case "parent":

$colname_parent = "-1";
if (isset($_GET['id'])) {
  $colname_parent = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_parent = sprintf("SELECT * FROM parent WHERE parent_id = %s", GetSQLValueString($colname_parent, "text"));
$parent = mysql_query($query_parent, $unique) or die(mysql_error());
$row_parent = mysql_fetch_assoc($parent);
$totalRows_parent = mysql_num_rows($parent);
break;
case "student":

$colname_student = "-1";
if (isset($_GET['id'])) {
  $colname_student = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_student = sprintf("SELECT student_info.student_id, parent.parent_lname, parent.parent_fname, `class`.class_name, student_info.dob, student_info.year_admitted, student_info.picture, student_info.student_Lname, student_info.student_Fname, student_info.sex, parent.parent_id, `class`.class_id FROM student_info, parent, `class` WHERE student_id = %s AND student_info.student_id=%s AND (student_info.Parent1 = parent.parent_id OR student_info.parent2 = parent.parent_id) AND student_info.`class` = `class`.class_id ORDER BY student_Lname ASC", GetSQLValueString($colname_student, "text"),GetSQLValueString($colname_student, "text"));
$student = mysql_query($query_student, $unique) or die(mysql_error());
$row_student = mysql_fetch_assoc($student);
$totalRows_student = mysql_num_rows($student);

mysql_select_db($database_unique, $unique);
$query_class = "SELECT class_id, class_name FROM `class` ORDER BY `class`.class_name";
$class = mysql_query($query_class, $unique) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);

mysql_select_db($database_unique, $unique);
$query_mothers = "SELECT parent_id,CONCAT_WS(' ', parent_lname, parent_fname) AS name FROM parent WHERE parent.sex='f' ORDER BY parent_lname ASC";
$mothers = mysql_query($query_mothers, $unique) or die(mysql_error());
$row_mothers = mysql_fetch_assoc($mothers);
$totalRows_mothers = mysql_num_rows($mothers);

mysql_select_db($database_unique, $unique);
$query_father = "SELECT parent_id, CONCAT_WS(' ',parent_fname, parent_lname) AS name FROM parent WHERE sex = 'm' ORDER BY parent_lname ASC";
$father = mysql_query($query_father, $unique) or die(mysql_error());
$row_father = mysql_fetch_assoc($father);
$totalRows_father = mysql_num_rows($father);

$colname_parents = "UBS/2011/0002";
if (isset($_GET['id'])) {
  $colname_parents = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_parents = sprintf("SELECT student_info.student_id, student_info.Parent1, student_info.parent2 FROM student_info WHERE student_info.student_id=%s", GetSQLValueString($colname_parents, "text"));
$parents = mysql_query($query_parents, $unique) or die(mysql_error());
$row_parents = mysql_fetch_assoc($parents);
$totalRows_parents = mysql_num_rows($parents);
break;
}
			   }
			   else $idsent=false;
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
       <div id="line"></div>
  <?php include('includes/side_admin.php'); ?>

					
<div id="right">	
			<div id="long_txt_pix">
                
             
              <form action="<?php echo $editFormAction; ?>" name="assign_subject" id="parent_data" method="POST">
                
                <?php if(isset($totalRows_student)){ 
				 ?>
                <h1>Data of <?php echo $row_student['student_Lname']; ?> <?php echo $row_student['student_Fname']; ?></h1>
                <table width="80%" border="0" align="center" cellpadding="6">
                  <?php $count=0; ?>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td width="31%"><h3>STUDENT ID</h3></td>
                    <td width="69%"><h3>
                      <input name="id" type="text" id="id" value="<?php echo $row_student['student_id']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>FIRST NAME</h3></td>
                    <td><h3>
                      <input name="student_fname" type="text" id="student_fname" tabindex="2" value="<?php echo $row_student['student_Fname']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>LAST NAME</h3></td>
                    <td><h3>
                      <input name="student_lname" type="text" id="student_lname" tabindex="3" value="<?php echo $row_student['student_Lname']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>CLASS</h3></td>
                    <td><h3>
                      <select name="class" id="class">
                        <option value="" <?php if (!(strcmp("", $row_student['class_id']))) {echo "selected=\"selected\"";} ?>>--Select Class--</option>
                        <?php
do {  
?>
<option value="<?php echo $row_class['class_id']?>"<?php if (!(strcmp($row_class['class_id'], $row_student['class_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_class['class_name']?></option>
                        <?php
} while ($row_class = mysql_fetch_assoc($class));
  $rows = mysql_num_rows($class);
  if($rows > 0) {
      mysql_data_seek($class, 0);
	  $row_class = mysql_fetch_assoc($class);
  }
?>
                      </select>
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>MOTHER'S NAME</h3></td>
                    <td><h3>
                      <select name="parent2" id="parent2">
                        <option value="" <?php if (!(strcmp("", $row_parents['parent2']))) {echo "selected=\"selected\"";} ?>>---Select Mother's Name---</option>
                        <?php
do {  
?>
<option value="<?php echo $row_mothers['parent_id']?>"<?php if (!(strcmp($row_mothers['parent_id'], $row_parents['parent2']))) {echo "selected=\"selected\"";} ?>><?php echo $row_mothers['name']?></option>
                        <?php
} while ($row_mothers = mysql_fetch_assoc($mothers));
  $rows = mysql_num_rows($mothers);
  if($rows > 0) {
      mysql_data_seek($mothers, 0);
	  $row_mothers = mysql_fetch_assoc($mothers);
  }
?>
                      </select>
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>FATHER'S NAME</h3></td>
                    <td><select name="parent1" id="parent1">
                      <option value="" <?php if (!(strcmp("", $row_parents['Parent1']))) {echo "selected=\"selected\"";} ?>>--Select Father's Name---</option>
                      <?php
do {  
?>
<option value="<?php echo $row_father['parent_id']?>"<?php if (!(strcmp($row_father['parent_id'], $row_parents['Parent1']))) {echo "selected=\"selected\"";} ?>><?php echo $row_father['name']?></option>
                      <?php
} while ($row_father = mysql_fetch_assoc($father));
  $rows = mysql_num_rows($father);
  if($rows > 0) {
      mysql_data_seek($father, 0);
	  $row_father = mysql_fetch_assoc($father);
  }
?>
                    </select></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>DATE OF BIRTH</h3></td>
                    <td><input name="dob" type="text" id="dob" value="<?php echo $row_student['dob']; ?>" /> 
                      (yyyy-mm-dd)</td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>SEX</h3></td>
                    <td><h3> 
                      <input <?php if (!(strcmp($row_student['sex'],"m"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="sex2" value="m" />
                      Male 
                      <input <?php if (!(strcmp($row_student['sex'],"f"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="sex" value="f" />
                       
                      Famale
                      
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Picture</h3></td>
                    <td><label>
                      <input name="picture" type="text" id="picture" value="<?php echo $row_student['picture']; ?>" />
                    </label></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>YEAR ADMITTED</h3></td>
                    <td><h3>
                      <input name="year_admitted" type="text" id="year_admitted" value="<?php echo $row_student['year_admitted']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td>&nbsp;</td>
                    <td><input name="update" type="submit" class="searchbutton" id="update" value="UPDATE" /></td>
                  </tr>
                </table>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <p>
                  <?php }?>
                  <input type="hidden" name="MM_update" value="assign_subject" />
                </p>
              </form>

  <?php if(!$idsent) {?> <h1> No ID sent. Please click on a student or parents name to view details </h1><?php } ?></div>
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

mysql_free_result($mothers);

if(isset($parent)){
mysql_free_result($parent);
}
if(isset($student)){
mysql_free_result($student);

mysql_free_result($class);
if(isset($mother)){
mysql_free_result($mothers);
}
mysql_free_result($father);

mysql_free_result($parents);
}
?>
