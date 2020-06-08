<?php require_once('Connections/unique.php'); ?>
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

$currentPage = $_SERVER["PHP_SELF"];

$colname_Sinfo = "-1";
if (isset($_SESSION['id'])) {
  $colname_Sinfo = $_SESSION['id'];
}
mysql_select_db($database_unique, $unique);
$query_Sinfo = sprintf("SELECT staff_id, fname, lname FROM staff WHERE staff_id = %s", GetSQLValueString($colname_Sinfo, "text"));
$Sinfo = mysql_query($query_Sinfo, $unique) or die(mysql_error());
$row_Sinfo = mysql_fetch_assoc($Sinfo);
$totalRows_Sinfo = mysql_num_rows($Sinfo);

$maxRows_search = 20;
$pageNum_search = 0;
if (isset($_GET['pageNum_search'])) {
  $pageNum_search = $_GET['pageNum_search'];
}
$startRow_search = $pageNum_search * $maxRows_search;

$var1_search = "-1";
if (isset($_GET['name'])) {
  $var1_search = trim($_GET['name']);
}
mysql_select_db($database_unique, $unique);
$query_search = sprintf("SELECT student_info.student_id, student_info.student_Fname, student_info.student_Lname FROM student_info WHERE student_info.student_Fname LIKE %s  OR student_info.student_Lname LIKE %s OR student_info.student_id LIKE %s", GetSQLValueString("%" . $var1_search . "%", "text"),GetSQLValueString("%" . $var1_search . "%", "text"),GetSQLValueString("%" . $var1_search . "%", "text"));
$query_limit_search = sprintf("%s LIMIT %d, %d", $query_search, $startRow_search, $maxRows_search);
$search = mysql_query($query_limit_search, $unique) or die(mysql_error());
$row_search = mysql_fetch_assoc($search);

if (isset($_GET['totalRows_search'])) {
  $totalRows_search = $_GET['totalRows_search'];
} else {
  $all_search = mysql_query($query_search);
  $totalRows_search = mysql_num_rows($all_search);
}
$totalPages_search = ceil($totalRows_search/$maxRows_search)-1;

$queryString_search = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_search") == false && 
        stristr($param, "totalRows_search") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_search = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_search = sprintf("&totalRows_search=%d%s", $totalRows_search, $queryString_search);
 ?>
 <?php 
 
 if (isset($_SESSION['MM_UserGroup']) && $_SESSION['MM_UserGroup']==1){
	header("location:parents.php");
	
}
 ?>
<?php $k=0; ?>
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
		
		<div id="long_txt_pix">
		  <table width="95%" border="0">
		    <tr>
		      <td colspan="3"><strong>Showing&nbsp;
Records <?php echo ($startRow_search + 1) ?> to <?php echo min($startRow_search + $maxRows_search, $totalRows_search) ?> of <?php echo $totalRows_search ?></strong></td>
	        </tr>
		    <tr>
		      <td colspan="3">&nbsp;</td>
	        </tr>
		    <tr>
		      <td width="65%"><h2><strong>Student's Names Results</strong></h2></td>
		      <td colspan="2">&nbsp;</td>
	        </tr>
            <?php do { ?>
              <tr <?php if ($k++%2==0) echo "class=hlite"; ?>>
                <td><?php echo $row_search['student_Lname']; ?> <?php echo $row_search['student_Fname']; ?></td>
                <td width="14%"><a href="view_details.php?id=<?php echo $row_search['student_id']; ?>&amp;cat=student">View Details, </a></td>
                <td width="21%"><a href="edit_student_details.php?cat=student&amp;id=<?php echo $row_search['student_id']; ?>">edit</a></td>
              </tr>
              <?php } while ($row_search = mysql_fetch_assoc($search)); ?>
<tr>
              <td colspan="3">&nbsp;
                <table width="98%" border="0">
                  <tr>
                    <td width="37"><?php if ($pageNum_search > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_search=%d%s", $currentPage, 0, $queryString_search); ?>"><img src="First.gif" /></a>
                    <?php } // Show if not first page ?></td>
                    <td width="490"><?php if ($pageNum_search > 0) { // Show if not first page ?>
                        <a href="<?php printf("%s?pageNum_search=%d%s", $currentPage, max(0, $pageNum_search - 1), $queryString_search); ?>"><img src="Previous.gif" /></a>
                    <?php } // Show if not first page ?></td>
                    <td width="33"><?php if ($pageNum_search < $totalPages_search) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_search=%d%s", $currentPage, min($totalPages_search, $pageNum_search + 1), $queryString_search); ?>"><img src="Next.gif" /></a>
                    <?php } // Show if not last page ?></td>
                    <td width="37"><?php if ($pageNum_search < $totalPages_search) { // Show if not last page ?>
                        <a href="<?php printf("%s?pageNum_search=%d%s", $currentPage, $totalPages_search, $queryString_search); ?>"><img src="Last.gif" /></a>
                    <?php } // Show if not last page ?></td>
                  </tr>
              </table></td>
            </tr>
          </table>
		</div>

 <?php include('includes/side_admin.php'); ?>
					
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
mysql_free_result($Sinfo);

mysql_free_result($search);

mysql_free_result($Sinfo);

mysql_free_result($search);
?>
