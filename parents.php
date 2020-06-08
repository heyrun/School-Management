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

$maxRows_child = 10;
$pageNum_child = 0;
if (isset($_GET['pageNum_child'])) {
  $pageNum_child = $_GET['pageNum_child'];
}
$startRow_child = $pageNum_child * $maxRows_child;

$var1_child = "-1";
if (isset($_SESSION['id'])) {
  $var1_child = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_child = sprintf("SELECT student_info.student_id, CONCAT_WS(' ',student_info.student_Fname, student_info.student_Lname) AS name, student_info.`class`, student_info.picture FROM student_info WHERE student_info.Parent1=%s OR student_info.parent2=%s", GetSQLValueString($var1_child, "text"),GetSQLValueString($var1_child, "text"));
$query_limit_child = sprintf("%s LIMIT %d, %d", $query_child, $startRow_child, $maxRows_child);
$child = mysql_query($query_limit_child, $unique) or die(mysql_error());
$row_child = mysql_fetch_assoc($child);

if (isset($_GET['totalRows_child'])) {
  $totalRows_child = $_GET['totalRows_child'];
} else {
  $all_child = mysql_query($query_child);
  $totalRows_child = mysql_num_rows($all_child);
}
$totalPages_child = ceil($totalRows_child/$maxRows_child)-1;
?>
 <?php $_SESSION['user_id']=$row_user_id['user_id']; ?>
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
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
  <div id="line"></div>
<?php include('includes/side_parent.php'); ?>
					
<div id="right">	
			<div id="form">
            
              <h2>
                Welcome 
              <?php echo $row_Pinfo['name']; ?></h2>
              <p>This is the control panel where you can follow the progress of your child(ren).</p>
              <p>Please endeavour to mail us at <a href="admin@uniqueblossomschools.com">admin@uniqueblossomschoools.com</a> if you encounter any difficulty while using our site.</p>
              <p class="sponsor">Note: Some links e.g. Authorized pick-up are still under contruction.</p>
              <p>You have <?php echo $totalRows_child ?>
<?php if ($totalRows_child==1) {?> child<?php } else {?> children <?php } ?> in our schools.</p>
              <p><?php if (isset($_GET['message']) ){
				  switch ($_GET['message']){
				  case "update":
				  echo "<span class=success>your Data has been successfully Updated</span>";
				  break;
				  default:
				  break;
				  }
			  }
				  
				  ?>&nbsp;</p>
              <?php if ($totalRows_child <>0) { // Show if recordset not empty ?>
  <table width="100%" border="0">
    <tr>
      <td align="left"><h3>&nbsp;</h3></td>
      <td align="left"><h3>Name of Child</h3></td>
      <td align="left"><h3>Result</h3></td>
      <td align="left"><h3>Comments</h3></td>
    </tr>
    <?php do { ?>
      <tr>
        <td width="14%"><img src="<?php if(empty($row_child['picture']))echo "images/dummy.jpg"; else echo "images/students/". $pix=str_replace("/","_",$row_child['picture']).".JPG"; ?>" alt="" /></td>
        <td width="28%" align="left"><a href="view_details.php?cat=student&amp;id=<?php echo $row_child['student_id']; ?>"><?php echo $row_child['name']; ?></a></td>
        <td width="32%"><a href="result.php?id=<?php echo $row_child['student_id']; ?>&amp;term=1&amp;session=2013/2014">1st Term</a> | <a href="result.php?id=<?php echo $row_child['student_id']; ?>&amp;term=2&amp;session=2013/2014">2nd Term</a> | <a href="result.php?id=<?php echo $row_child['student_id']; ?>&amp;term=3&amp;session=2013/2014">3rd Term</a></td>
        <td width="26%" align="left"><a href="teachers_comments.php?id=<?php echo $row_child['student_id']; ?>">View Teacher's Comments</a></td>
      </tr>
      <?php } while ($row_child = mysql_fetch_assoc($child)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
              <?php if ($totalRows_child<1) { // Show if recordset empty ?>
                <h2>CHILD(REN) INFORMATION NOT AVAILABLE. <a href="mailto:info@uniqueblossomschools.com">CONTACT ADMIN</a></h2>
                <?php } // Show if recordset empty ?>
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
mysql_free_result($user_id);

mysql_free_result($Pinfo);

mysql_free_result($child);
?>
