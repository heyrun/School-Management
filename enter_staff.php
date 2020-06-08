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

if(empty($error)){

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO staff (staff_id, fname, lname, `position`, teach, dob, Address, qualification, `number`, date_employed, management) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['teach'], "int"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['qualification'], "text"),
                       GetSQLValueString($_POST['number'], "text"),
                       GetSQLValueString($_POST['dob2'], "date"),
                       GetSQLValueString($_POST['management'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());

  $insertGoTo = "enter_staff.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="favicon.ico" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
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
		        <td colspan="2"><h2>Data Entered Successfully</h2></td>
	          </tr><?php } ?>
		      <tr>
		        <td align="right"><h3>Staff ID</h3></td>
		        <td><span id="sprytextfield1">
		          <label>
		            <input type="text" name="id" id="id" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td width="39%" align="right"><h3>First Name</h3></td>
		        <td width="61%"><span id="sprytextfield2">
		          <label>
		            <input type="text" name="fname" id="fname" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Last Name</h3></td>
		        <td><span id="sprytextfield3">
		          <label>
		            <input type="text" name="lname" id="lname" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Position</h3></td>
		        <td><span id="sprytextfield4">
		          <label>
		            <input type="text" name="position" id="position" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Address</h3></td>
		        <td><span id="sprytextarea1">
		          <label>
		            <textarea name="address" id="address" cols="45" rows="5"></textarea>
	            </label>
	            <span class="textareaRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Clearance Level</h3></td>
		        <td><span id="spryselect1">
		          <label>
		            <select name="teach" id="teach">
		              <option>Select Level</option>
		              <option value="0">Cleaner</option>
		              <option value="1">Class Assistants</option>
		              <option value="2">Teacher</option>
		              <option value="3">Non-Teaching Staff</option>
		              <option value="4">Management</option>
	                </select>
	            </label>
	            <span class="selectRequiredMsg">Please select an item.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Is Management</h3></td>
		        <td><label>
		          <input type="radio" name="management" id="management" value="1" />
	            </label>
		        Yes 
		        <label>
		          <input name="managemnet" type="radio" id="managemnet" value="0" checked="checked" />
	            </label>
		        No</td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Date of Birth</h3></td>
		        <td><span id="spryselect2">
		          <select name="day" id="day">
		            <option value="">Day</option>
		            <?php for ($k=1;$k<=31;$k++){ ?>
		            <option value="<?php if($k<10){ echo '0'.$k;} else echo $k; ?> ">
		              <?php if($k<10){ echo '0'.$k; }else echo $k; ?>
	                </option>
		            <?php } ?>
	            </select>
		          <span class="selectRequiredMsg">Please select an item.</span></span>
		          /
		          <span id="spryselect3">
		          <select name="month" id="month">
		            <option>Month</option>
		            <option value="01">Jan</option>
		            <option value="02">Feb</option>
		            <option value="03">Mar</option>
		            <option value="04">Apr</option>
		            <option value="05">May</option>
		            <option value="06">Jun</option>
		            <option value="07">July</option>
		            <option value="08">Aug</option>
		            <option value="09">Sep</option>
		            <option value="10">Oct</option>
		            <option value="11">Nov</option>
		            <option value="12">Dec</option>
	              </select>
		          <span class="selectRequiredMsg">Please select an item.</span></span> /
                  <span id="spryselect4">
                  <select name="yr" id="yr">
                    <option value="">year</option>
                    <?php for($yr=1965;$yr<=date('Y');$yr++)
					{ ?>
                    <option value="<?php echo $yr; ?>"><?php echo $yr; ?></option>
                    <?php } ?>
                  </select>
                  <span class="selectRequiredMsg">Please select an item.</span></span>
                  <input type="hidden" name="dob" id="dob" /></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Qualification</h3></td>
		        <td><span id="sprytextfield5">
		          <label>
		            <input type="text" name="qualification" id="qualification" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Phone Number</h3></td>
		        <td><span id="sprytextfield6">
		          <label>
		            <input type="text" name="number" id="number" />
	            </label>
	            <span class="textfieldRequiredMsg">A value is required.</span></span></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>Date Employed</h3></td>
		        <td><span id="spryselect5">
	            <select name="day2" id="day2">
		            <option value="">Day</option>
		            <?php for ($k=1;$k<=31;$k++){ ?>
		            <option value="<?php if($k<10){ echo '0'.$k;} else echo $k; ?> ">
		              <?php if($k<10){ echo '0'.$k; }else echo $k; ?>
	                </option>
		            <?php } ?>
	            </select>
		          <span class="selectRequiredMsg">Please select an item.</span></span>
/
<span id="spryselect6">
<select name="month2" id="month2">
  <option>Month</option>
  <option value="01">Jan</option>
  <option value="02">Feb</option>
  <option value="03">Mar</option>
  <option value="04">Apr</option>
  <option value="05">May</option>
  <option value="06">Jun</option>
  <option value="07">July</option>
  <option value="08">Aug</option>
  <option value="09">Sep</option>
  <option value="10">Oct</option>
  <option value="11">Nov</option>
  <option value="12">Dec</option>
</select>
<span class="selectRequiredMsg">Please select an item.</span></span> /
<span id="spryselect7">
<select name="yr2" id="yr2">
  <option value="">year</option>
  <?php for($yr=1985;$yr<=date('Y');$yr++)
					{ ?>
  <option value="<?php echo $yr; ?>"><?php echo $yr; ?></option>
  <?php } ?>
</select>
<span class="selectRequiredMsg">Please select an item.</span></span>
<input type="hidden" name="dob2" id="dob2" /></td>
	          </tr>
		      <tr>
		        <td align="right"><h3>&nbsp;</h3></td>
		        <td><label>
		          <input name="update" type="submit" class="row1" id="update" value="Enter Data" />
	            </label></td>
	          </tr>
	        </table>
		    <input type="hidden" name="MM_insert" value="form1" />
          </form>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
var spryselect4 = new Spry.Widget.ValidationSelect("spryselect4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var spryselect5 = new Spry.Widget.ValidationSelect("spryselect5");
var spryselect6 = new Spry.Widget.ValidationSelect("spryselect6");
var spryselect7 = new Spry.Widget.ValidationSelect("spryselect7");
</script>
</body>
</html>