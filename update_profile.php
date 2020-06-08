<?php require_once('Connections/unique.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE parent SET parent_fname=%s, parent_lname=%s, profession=%s, office_address=%s, home_address=%s, office_phone=%s, home_phone=%s, mobile_phone=%s, origin=%s, religion=%s WHERE parent_id=%s",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['profession'], "text"),
                       GetSQLValueString($_POST['office_address'], "text"),
                       GetSQLValueString($_POST['home_address'], "text"),
                       GetSQLValueString($_POST['o_number'], "text"),
                       GetSQLValueString($_POST['textfield'], "text"),
                       GetSQLValueString($_POST['m_number'], "text"),
                       GetSQLValueString($_POST['origin'], "text"),
                       GetSQLValueString($_POST['religion'], "text"),
                       GetSQLValueString($_POST['parent_id'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($updateSQL, $unique) or die(mysql_error());

  $updateGoTo = "parents.php?message=update";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_profile = "-1";
if (isset($_SESSION['id'])) {
  $colname_profile = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_profile = sprintf("SELECT * FROM parent WHERE parent_id = %s", GetSQLValueString($colname_profile, "text"));
$profile = mysql_query($query_profile, $unique) or die(mysql_error());
$row_profile = mysql_fetch_assoc($profile);
$totalRows_profile = mysql_num_rows($profile);
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
		
		<div id="long_txt_pix">
		  <form name="form1" id="form1" method="POST" action="<?php echo $editFormAction; ?>">
		    <table width="100%" border="1">
		      <tr>
		        <td>First Name</td>
		        <td><label>
		          <input name="fname" type="text" id="fname" value="<?php echo $row_profile['parent_fname']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Last Name</td>
		        <td><label>
		          <input name="lname" type="text" id="lname" value="<?php echo $row_profile['parent_lname']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Profession</td>
		        <td><label>
		          <input name="profession" type="text" id="profession" value="<?php echo $row_profile['profession']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td><p>Office Address</p></td>
		        <td><label>
		          <input name="office_address" type="text" id="office_address" value="<?php echo $row_profile['office_address']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Home Address</td>
		        <td><label>
		          <input name="home_address" type="text" id="home_address" value="<?php echo $row_profile['home_address']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Office Number</td>
		        <td><label>
		          <input name="o_number" type="text" id="o_number" value="<?php echo $row_profile['office_phone']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Home Number</td>
		        <td><label>
		          <input name="textfield" type="text" id="textfield" value="<?php echo $row_profile['home_phone']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Mobile Number</td>
		        <td><label>
		          <input name="m_number" type="text" id="m_number" value="<?php echo $row_profile['mobile_phone']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Sex</td>
		        <td><label>
		          <input type="radio" name="sex" id="sex" value="m" />
	            </label>
		          Male 
		          <label>
		            <input type="radio" name="sex" id="sex" value="f" />
	              </label>
		          Female</td>
	          </tr>
		      <tr>
		        <td>Origin</td>
		        <td><label>
		          <input name="origin" type="text" id="origin" value="<?php echo $row_profile['origin']; ?>" />
	            </label></td>
	          </tr>
		      <tr>
		        <td>Religion</td>
		        <td><label>
		          <input name="religion" type="text" id="religion" value="<?php echo $row_profile['religion']; ?>" />
	              <input name="parent_id" type="hidden" id="parent_id" value="<?php echo $row_profile['parent_id']; ?>" />
		        </label></td>
	          </tr>
		      <tr>
		        <td>&nbsp;</td>
		        <td><label>
		          <input name="update" type="submit" class="row1" id="update" value="Update" />
	            </label></td>
	          </tr>
	        </table>
		    <input type="hidden" name="MM_update" value="form1" />
          </form>
<p>&nbsp;</p>
</div>

<?php include('includes/side_parent.php'); ?>
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
mysql_free_result($profile);
?>
