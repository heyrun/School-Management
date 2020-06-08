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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "assign_subject")) {
  $updateSQL = sprintf("UPDATE subject_teacher SET staff_id=%s, subject_id=%s, class_id=%s WHERE id=%s",
                       GetSQLValueString($_POST['teacher'], "text"),
                       GetSQLValueString($_POST['subject'], "int"),
                       GetSQLValueString($_POST['class'], "int"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($updateSQL, $unique) or die(mysql_error());

  $updateGoTo = "assign-subjects.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_unique, $unique);
$query_subject = "SELECT * FROM subject ORDER BY subject.subject_name";
$subject = mysql_query($query_subject, $unique) or die(mysql_error());
$row_subject = mysql_fetch_assoc($subject);
$totalRows_subject = mysql_num_rows($subject);

mysql_select_db($database_unique, $unique);
$query_teachers = "SELECT staff_id, CONCAT_WS(' ',lname, fname) AS name FROM staff WHERE teach= '2'  ORDER BY lname ";
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

$var1_sub_tea = "-1";
if (isset($_GET['id'])) {
  $var1_sub_tea = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_sub_tea = sprintf("SELECT subject_teacher.id, subject_teacher.staff_id, subject_teacher.subject_id, subject_teacher.class_id FROM subject_teacher WHERE subject_teacher.id=%s", GetSQLValueString($var1_sub_tea, "int"));
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
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
            
              <h1>Assign Subjects to Teachers</h1>
              <form action="<?php echo $editFormAction; ?>" name="assign_subject" id="assign_subject" method="POST">
                <table width="95%" border="1">
                  <tr>
                    <td colspan="3" align="center"><?php if (isset($Result1) && true){?>
                      <span class="success">Assignment Successful Added</span>
                      <?php } ?></td>
                  </tr>
                  <tr>
                    <td width="27%" align="right"><h2>Subject</h2></td>
                    <td width="42%"><h2>Techer</h2></td>
                    <td><h2>Class</h2></td>
                  </tr>
                  <tr>
                    <td align="right"><select name="subject" id="subject">
                      <option value="" <?php if (!(strcmp("", $row_sub_tea['subject_id']))) {echo "selected=\"selected\"";} ?>>---Select Subject---</option>
                      <?php
do {  
?>
<option value="<?php echo $row_subject['subject_id']?>"<?php if (!(strcmp($row_subject['subject_id'], $row_sub_tea['subject_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_subject['subject_name']?></option>
                      <?php
} while ($row_subject = mysql_fetch_assoc($subject));
  $rows = mysql_num_rows($subject);
  if($rows > 0) {
      mysql_data_seek($subject, 0);
	  $row_subject = mysql_fetch_assoc($subject);
  }
?>
                    </select></td>
                    <td><span id="spryselect2"><span class="selectRequiredMsg">Please select an item.</span></span><span id="spryselect1">
                    <label>
                      <select name="teacher" id="teacher">
                        <option value="" <?php if (!(strcmp("", $row_sub_tea['staff_id']))) {echo "selected=\"selected\"";} ?>>---Select Teacher</option>
                        <?php
do {  
?>
<option value="<?php echo $row_teachers['staff_id']?>"<?php if (!(strcmp($row_teachers['staff_id'], $row_sub_tea['staff_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_teachers['name']?></option>
                        <?php
} while ($row_teachers = mysql_fetch_assoc($teachers));
  $rows = mysql_num_rows($teachers);
  if($rows > 0) {
      mysql_data_seek($teachers, 0);
	  $row_teachers = mysql_fetch_assoc($teachers);
  }
?>
                      </select>
                    </label>
                    <span class="selectRequiredMsg">Please select an item.</span></span></td>
                    <td><label>
                      <select name="class" id="class">
                        <option value="" <?php if (!(strcmp("", $row_sub_tea['class_id']))) {echo "selected=\"selected\"";} ?>>---Select Class---</option>
                        <?php
do {  
?>
<option value="<?php echo $row_class['class_id']?>"<?php if (!(strcmp($row_class['class_id'], $row_sub_tea['class_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_class['class_name']?></option>
                        <?php
} while ($row_class = mysql_fetch_assoc($class));
  $rows = mysql_num_rows($class);
  if($rows > 0) {
      mysql_data_seek($class, 0);
	  $row_class = mysql_fetch_assoc($class);
  }
?>
                      </select>
                    </label>
                    <span class="selectRequiredMsg">Please select an item.</span>
                    <input name="id" type="hidden" id="id" value="<?php echo $_GET['id']; ?>" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td colspan="2"><label>
                      <input name="update" type="submit" class="row1" id="update" value="Update Subject" />
                    </label></td>
                  </tr>
                </table>
                <p></p>
                <h1>&nbsp;</h1>
                <p>&nbsp;</p>
                <input type="hidden" name="MM_update" value="assign_subject" />
              </form>
<p>&nbsp;</p>
		  </div>
</div>
  
  
			
		<?php include("includes/footer.php"); ?>	
	</div>
<script type="text/javascript">
$(window).load(function() {
        $('#slider').nivoSlider();
    });
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
</script>
</body>
</html>
<?php
mysql_free_result($subject);

mysql_free_result($subject);

mysql_free_result($teachers);

mysql_free_result($class);

mysql_free_result($subject_teacher);

mysql_free_result($sub_tea);
?>
