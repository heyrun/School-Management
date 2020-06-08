<?php require_once('Connections/unique.php'); ?>
<?php require_once('Connections/unique.php');
if(isset($_POST['cancel'])){
	header("location:assign-subjects.php");
}?>
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
//Beging the condition to delete record
if (isset($_POST['delete'])){

//end of the condition to delete record
}
$var1_sub_tea = "-1";
if (isset($_GET['id'])) {
  $var1_sub_tea = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_sub_tea = sprintf("SELECT CONCAT_WS(' ',staff.lname, staff.fname) AS staff_name, subject.subject_name, `class`.class_name, subject_teacher.id FROM award, staff, subject, `class`, subject_teacher WHERE subject_teacher.staff_id = staff.staff_id AND subject_teacher.class_id = `class`.class_id AND subject_teacher.subject_id = subject.subject_id AND subject_teacher.id=%s", GetSQLValueString($var1_sub_tea, "int"));
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
            
              <h1>You are about to DELETE the below Subject Assignment</h1>
              <form name="assign_subject" id="assign_subject" method="POST">
                <table width="95%" border="1">
                  <tr>
                    <td colspan="2" align="center"><?php if (isset($Result1) && true){?>
                      <span class="success">Assignment Successful Added</span>
                      <?php } ?></td>
                  </tr>
                  <tr>
                    <td align="right">Subject</td>
                    <td><label>
                      <?php echo $row_sub_tea['subject_name']; ?>
<input type="text" name="subject" id="subject" />
                    </label></td>
                  </tr>
                  <tr>
                    <td align="right">Teacher</td>
                    <td><?php echo $row_sub_tea['staff_name']; ?>
                    <input type="text" name="teacher" id="teacher" /></td>
                  </tr>
                  <tr>
                    <td align="right">class</td>
                    <td><?php echo $row_sub_tea['class_name']; ?>
                    <input name="id" type="hidden" id="id" value="<?php echo $row_sub_tea['id']; ?>" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><label>
                      <input name="delete" type="submit" class="row1" id="delete" value="Delete Subject" />
                       <input name="cancel" type="submit" class="row1" id="cancel" value="No" />
                    </label></td>
                  </tr>
                </table>
                <p></p>
                <p>&nbsp;</p>
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
</script>
</body>
</html>
<?php
mysql_free_result($sub_tea);
?>
