<?php require_once('Connections/unique.php'); ?>
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

$colname_login_id = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_login_id = $_SESSION['MM_Username'];
}
mysql_select_db($database_unique, $unique);
$query_login_id = sprintf("SELECT login_id, user_id, user_name, user_password FROM login WHERE user_name = %s", GetSQLValueString($colname_login_id, "text"));
$login_id = mysql_query($query_login_id, $unique) or die(mysql_error());
$row_login_id = mysql_fetch_assoc($login_id);
$totalRows_login_id = mysql_num_rows($login_id);
?>
<?php
$_SESSION['login_id']=$row_login_id['login_id'];
$check=false;
	$message='';
?>

<?php 
if (isset($_POST['change'])){
	
	//Check if old password is correct
	if(isset($_POST['oldpwd']) and (sha1($_POST['oldpwd'])==$row_login_id['user_password'])){
																  
		
		 $check=true;
	}
	else {
		 $message.= "<br> Please Enter your old Password correctly";
		 $check=false;
	}
	// check if the two password match
	if($_POST['newpwd1']<>$_POST['newpwd2']){
		
	$message="Password Mismatch";
	$checkl=false;
		
	}
	else {
		$_POST['newpwd1']=sha1($_POST['newpwd1']);
		$check=true;
	}
		 
		 // change password
		 if($check && $message==''){
						
		$sql="UPDATE login SET user_password='".$_POST['newpwd1']."' WHERE login_id=".$_SESSION['login_id'];
		$update=mysql_query($sql,$unique) or die(mysql_error());
		if($update) echo "true";
				 }
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
		<?php 
		if($_SESSION['MM_UserGroup']==1) {
					 include('includes/side_parent.php');
		}
					 else		
		include('includes/side_admin.php'); ?>
		<div id="right">
<form action="" method="post">
  <table width="100%" border="1">
    <tr>
      <td colspan="2" align="center">
	  <?php if($check==true && $message==''){?>
      <span class="success">Password changed Successfully</span>
	  <?php }
	  
	  if(!$check or $message!=''){
      echo "<span class=warning> ".$message;
	  }
	  ?>
      </td>
      </tr>
    <tr>
      <td align="right">Old Password</td>
      <td><label>
        <input type="password" name="oldpwd" id="oldpwd" />
      </label></td>
    </tr>
    <tr>
      <td align="right">New Password</td>
      <td><label>
        <input type="password" name="newpwd1" id="newpwd1" />
        </label></td>
    </tr>
    <tr>
      <td align="right">Retype New Password</td>
      <td><label>
        <input type="password" name="newpwd2" id="newpwd2" />
      </label></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><label>
        <input name="change" type="submit" class="searchbutton" id="change" value="Change Password" />
      </label></td>
    </tr>
  </table>
  </form>
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
mysql_free_result($login_id);
?>
