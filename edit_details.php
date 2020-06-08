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
$MM_authorizedUsers = "1,3";
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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update_parents")) {
  $updateSQL = sprintf("UPDATE parent SET parent_fname=%s, parent_lname=%s, profession=%s, office_address=%s, home_address=%s, office_phone=%s, home_phone=%s, mobile_phone=%s, sex=%s, email=%s, origin=%s, religion=%s WHERE parent_id=%s",
                       GetSQLValueString($_POST['parent_fname'], "text"),
                       GetSQLValueString($_POST['parent_lname'], "text"),
                       GetSQLValueString($_POST['prefession'], "text"),
                       GetSQLValueString($_POST['office_address'], "text"),
                       GetSQLValueString($_POST['home_address'], "text"),
                       GetSQLValueString($_POST['office_phone'], "text"),
                       GetSQLValueString($_POST['home_phone'], "text"),
                       GetSQLValueString($_POST['mobile_phone'], "text"),
                       GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['origin'], "text"),
                       GetSQLValueString($_POST['religion'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($updateSQL, $unique) or die(mysql_error());

  $updateGoTo = "view_parents.php?message=update";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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
/*
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
*/
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
$query_student = sprintf("SELECT student_info.student_id, parent.parent_lname, parent.parent_fname, `class`.class_name, student_info.dob, student_info.year_admitted, student_info.picture, student_info.student_Lname, student_info.student_Fname, student_info.sex, parent.parent_id FROM student_info, parent, `class` WHERE student_id = %s AND student_info.student_id=%s AND (student_info.Parent1 = parent.parent_id OR student_info.parent2 = parent.parent_id) AND student_info.`class` = `class`.class_id ORDER BY student_Lname ASC", GetSQLValueString($colname_student, "text"),GetSQLValueString($colname_student, "text"));
$student = mysql_query($query_student, $unique) or die(mysql_error());
$row_student = mysql_fetch_assoc($student);
$totalRows_student = mysql_num_rows($student);
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
    
    
    
    
    
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="description" content="Unique Blossom Schools, Abuja; Creche, Prenursery, Nursery, Primary" />
	<meta name="keywords" content="creche, Nursery, prenursery, reception, primary, schoool, school in abuja, primary school in abuja, nursery school, students, unique blossom" />
	<link rel="stylesheet" href="style.css" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style></head>
<body>
<div id="content">
		<?php include("includes/header.php"); ?>

	
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
  <?php include('includes/side_admin.php'); ?>

					
<div id="right">	
			<div id="long_txt_pix">
            <?php if(isset($totalRows_parent)){  ?>
<h1> Data of <?php echo ucfirst($row_parent['parent_lname']); ?> <?php echo ucfirst($row_parent['parent_fname']); ?></h1>
              <form action="<?php echo $editFormAction; ?>" name="update_parents" id="parent_data" method="POST">
                <table width="80%" border="0" align="center" cellpadding="6">
                  <?php $count=0; ?>
                 <?php if($_SESSION['MM_UserGroup']==3) { ?>
                 
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td width="32%"><h3>Parent ID</h3></td>
                    <td width="68%"><h3>
                      <label>
                        <input name="id" type="text" id="id" value="<?php echo $row_parent['parent_id']; ?>" />
                      </label>
                    </h3></td>
                  </tr>
                  <?php  } else { ?> <input name="id" type="hidden" value="<?php echo $row_parent['parent_id']; ?> " /> <?php } ?>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>First Name</h3></td>
                    <td><h3>
                      <input name="parent_fname" type="text" id="parent_fname" tabindex="2" value="<?php echo $row_parent['parent_fname']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Last Name</h3></td>
                    <td><h3>
                      <input name="parent_lname" type="text" id="parent_lname" tabindex="3" value="<?php echo $row_parent['parent_lname']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Sex</h3></td>
                    <td><input <?php if (!(strcmp($row_parent['sex'],"m"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="sex" value="m" tabindex="4" />
                    Male 
                    <input <?php if (!(strcmp($row_parent['sex'],"f"))) {echo "checked=\"checked\"";} ?> type="radio" name="sex" id="sex" value="f" tabindex="5" />
                    Famale</td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Profession</h3></td>
                    <td><h3>
                      <input name="prefession" type="text" id="prefession" value="<?php echo $row_parent['profession']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Home Address</h3></td>
                    <td><h3>
                      <input name="home_address" type="text" id="home_address" value="<?php echo $row_parent['home_address']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Office Address</h3></td>
                    <td><h3>
                      <input name="office_address" type="text" id="office_address" value="<?php echo $row_parent['office_address']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Mobile Number</h3></td>
                    <td><h3>
                      <input name="mobile_phone" type="text" id="mobile_phone" tabindex="8" value="<?php echo $row_parent['mobile_phone']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Office Number</h3></td>
                    <td><h3>
                      <input name="office_phone" type="text" id="office_phone" value="<?php echo $row_parent['office_phone']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Home Number</h3></td>
                    <td><h3>
                      <input name="home_phone" type="text" id="home_phone" value="<?php echo $row_parent['home_phone']; ?>" />
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Email</h3></td>
                    <td><h3>
                      <label>
                        <input name="email" type="text" id="email" value="<?php echo $row_parent['email']; ?>" />
                      </label>
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>State of Origin</h3></td>
                    <td><h3>
                      <select name="origin" id="origin">
                        <option value="" <?php if (!(strcmp("", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>--Select State--</option>
                        <option value="Abia" <?php if (!(strcmp("Abia", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>Abia</option>
                        <option value="Adamawa" <?php if (!(strcmp("Adamawa", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>Adamawa</option>
                        <option value="Akwa Ibom" <?php if (!(strcmp("Akwa Ibom", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>Akwa Ibom</option>
                        <option value="anambra" <?php if (!(strcmp("anambra", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>anambra</option>
                        <option value="Bauchi" <?php if (!(strcmp("Bauchi", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>Bauchi</option>
                        <option value="Bayelsa" <?php if (!(strcmp("Bayelsa", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>Bayelsa</option>
                        <option value="Benue" <?php if (!(strcmp("Benue", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>Benue</option>
                        <option value="Borno" <?php if (!(strcmp("Borno", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>Borno</option>
                        <option value="cross river" <?php if (!(strcmp("cross river", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>cross river</option>
<option value="delta" <?php if (!(strcmp("delta", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>delta</option>
                        <option value="ebonyi" <?php if (!(strcmp("ebonyi", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>ebonyi</option>
                        <option value="edo" <?php if (!(strcmp("edo", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>edo</option>
                        <option value="ekiti" <?php if (!(strcmp("ekiti", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>ekiti</option>
<option value="enugu" <?php if (!(strcmp("enugu", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>enugu</option>
                        <option value="gombe" <?php if (!(strcmp("gombe", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>gombe</option>
                        <option value="imo" <?php if (!(strcmp("imo", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>imo</option>
                        <option value="jigawa" <?php if (!(strcmp("jigawa", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>jigawa</option>
                        <option value="kaduna" <?php if (!(strcmp("kaduna", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>kaduna</option>
                        <option value="kano" <?php if (!(strcmp("kano", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>kano</option>
                        <option value="kastina" <?php if (!(strcmp("kastina", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>kastina</option>
                        <option value="kebbi" <?php if (!(strcmp("kebbi", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>kebbi</option>
                        <option value="kogi" <?php if (!(strcmp("kogi", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>kogi</option>
                        <option value="kwara" <?php if (!(strcmp("kwara", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>kwara</option>
                        <option value="lagos" <?php if (!(strcmp("lagos", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>lagos</option>
                        <option value="nasarawa" <?php if (!(strcmp("nasarawa", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>nasarawa</option>
                        <option value="niger" <?php if (!(strcmp("niger", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>niger</option>
                        <option value="ogun" <?php if (!(strcmp("ogun", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>ogun</option>
                        <option value="ondo" <?php if (!(strcmp("ondo", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>ondo</option>
                        <option value="oyo" <?php if (!(strcmp("oyo", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>oyo</option>
                        <option value="plateu" <?php if (!(strcmp("plateu", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>plateau</option>
                        <option value="rivers" <?php if (!(strcmp("rivers", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>rivers</option>
                        <option value="sokoto" <?php if (!(strcmp("sokoto", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>sokoto</option>
                        <option value="taraba" <?php if (!(strcmp("taraba", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>taraba</option>
                        <option value="yobe" <?php if (!(strcmp("yobe", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>yobe</option>
                        <option value="zamfara" <?php if (!(strcmp("zamfara", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>zamfara</option>
                        <option value="fct" <?php if (!(strcmp("fct", $row_parent['origin']))) {echo "selected=\"selected\"";} ?>>fct</option>
                      </select>
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Religion</h3></td>
                    <td><h3>
                      <select name="religion" id="religion">
                        <option value="" <?php if (!(strcmp("", $row_parent['religion']))) {echo "selected=\"selected\"";} ?>>--select religion--</option>
                        <option value="christain" <?php if (!(strcmp("christain", $row_parent['religion']))) {echo "selected=\"selected\"";} ?>>Christain</option>
                        <option value="muslim" <?php if (!(strcmp("muslim", $row_parent['religion']))) {echo "selected=\"selected\"";} ?>>Muslim</option>
                        <option value="other" <?php if (!(strcmp("other", $row_parent['religion']))) {echo "selected=\"selected\"";} ?>>Other</option>
                      </select>
                    </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td>&nbsp;</td>
                    <td><input name="update_parent" type="submit" class="searchbutton" id="update_parent" value="UPDATE" /></td>
                  </tr>
                </table>
                <p><?php }  ?></p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
                <input type="hidden" name="MM_update" value="update_parents" />
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
if(isset($parent)){
mysql_free_result($parent);
}
if(isset($student)){
mysql_free_result($student);
}
?>
