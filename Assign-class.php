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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE `class` SET staff_id=%s, class_size_boys=%s, class_size_girls=%s WHERE class_id=%s",
                       GetSQLValueString($_POST['staff'], "text"),
                       GetSQLValueString($_POST['boys'], "int"),
                       GetSQLValueString($_POST['girls'], "int"),
                       GetSQLValueString($_POST['class'], "int"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($updateSQL, $unique) or die(mysql_error());
}

mysql_select_db($database_unique, $unique);
$query_staff = "SELECT staff.staff_id, CONCAT_WS(' ', staff.lname, staff.fname) AS name FROM staff WHERE staff.teach=2 AND staff.Active=1 ORDER BY staff.lname, staff.fname";
$staff = mysql_query($query_staff, $unique) or die(mysql_error());
$row_staff = mysql_fetch_assoc($staff);
$totalRows_staff = mysql_num_rows($staff);

mysql_select_db($database_unique, $unique);
$query_class = "SELECT * FROM `class` ORDER BY `class`.class_name";
$class = mysql_query($query_class, $unique) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);

mysql_select_db($database_unique, $unique);
$query_class_record = "SELECT `class`.class_name, `class`.class_size_boys, `class`.class_size_girls, CONCAT_WS(' ',staff.lname, staff.fname,'  ') as staff FROM `class`, staff WHERE staff.staff_id =`class`.staff_id ORDER BY `class`.class_name";
$class_record = mysql_query($query_class_record, $unique) or die(mysql_error());
$row_class_record = mysql_fetch_assoc($class_record);
$totalRows_class_record = mysql_num_rows($class_record);

function check_error($key){
foreach ($key as $value=>$id) {	
$key=trim($value);
if(empty($value)){
	$error=array_push($errror, $id);
	return $error;
}
}
}

if(isset($_POST)){
	$error=check_error($_POST);
	echo $error;
}
?>
<?php
if(empty($error)){

}
else echo $error;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Welcome to Unique Blossom Schools:- Update Profile</title>
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="content">
		<?php include("includes/header.php"); ?>

	
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
<div id="line"></div>
		
		<div id="long_txt_pix">
		  <form action="<?php echo $editFormAction; ?>" name="form1" id="form1" method="POST">
		    <table width="100%" border="1">
<?php if(isset($Result1) && $Result1==1){ ?><tr>
		        <td colspan="2"><h2>Data Updated Successfully</h2></td>
	          </tr><?php } ?>
		      <tr>
		        <td align="right"><h3>Staff </h3></td>
		        <td><span id="spryselect1">
		          <label>
		            <select name="staff" id="staff">
		              <option value=""></option>
		              <?php
do {  
?>
		              <option value="<?php echo $row_staff['staff_id']?>"><?php echo $row_staff['name']?></option>
		              <?php
} while ($row_staff = mysql_fetch_assoc($staff));
  $rows = mysql_num_rows($staff);
  if($rows > 0) {
      mysql_data_seek($staff, 0);
	  $row_staff = mysql_fetch_assoc($staff);
  }
?>
                    </select>
	            </label>
	            <span class="selectRequiredMsg">Please select an item.</span></span></td>
	          </tr>
		      <tr>
		        <td width="39%" align="right"><h3>Class</h3></td>
		        <td width="61%"><span id="spryselect2">
		          <label>
		            <select name="class" id="class">
		              <?php
do {  
?>
		              <option value="<?php echo $row_class['class_id']?>"><?php echo $row_class['class_name']?></option>
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
	            <span class="selectRequiredMsg">Please select an item.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right">Number of Boys</td>
		        <td><span id="sprytextfield1">
		          <label>
		            <input type="text" name="boys" id="boys" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right">Number of girls</td>
		        <td><span id="sprytextfield2">
		          <label>
		            <input type="text" name="girls" id="girls" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>&nbsp;</h3></td>
		        <td><label>
		          <input name="update" type="submit" class="row1" id="update" value="Update Information" />
	            </label></td>
	          </tr>
	        </table>
		    <input type="hidden" name="MM_update" value="form1" />
          </form>
          <table width="100%" border="1">
            <tr>
              <td width="4%">S/N</td>
              <td>Class</td>
              <td>Class Teacher</td>
              <td>Boys</td>
              <td>Girls</td>
            </tr>
            <?php $k =1; ?>
            <?php do { ?>
            <tr>
              <td><?php echo $k++;?></td>
              <td><?php echo $row_class_record['class_name']; ?></td>
              <td><?php echo $row_class_record['staff']; ?></td>
              <td><?php echo $row_class_record['class_size_boys']; ?></td>
              <td><?php echo $row_class_record['class_size_girls']; ?></td>
              
            </tr>
              <?php } while ($row_class_record = mysql_fetch_assoc($class_record)); ?>
          </table>
          <p>&nbsp;</p>
</div>
		<?php include('includes/side_admin.php'); ?>
<div id="right"></div>
  
  
			
		<?php include("includes/footer.php"); ?>	
	</div>
<script type="text/javascript">
$(window).load(function() {
        $('#slider').nivoSlider();
    });
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
</html>
<?php
mysql_free_result($staff);

mysql_free_result($class);

mysql_free_result($class_record);
?>
