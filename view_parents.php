<?php require_once('Connections/unique.php'); ?>
<?php
$i=0;
$error=array();
$message='';

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

$currentPage = $_SERVER["PHP_SELF"];
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

$maxRows_parent = 30;
$pageNum_parent = 0;
if (isset($_GET['pageNum_parent'])) {
  $pageNum_parent = $_GET['pageNum_parent'];
}
$startRow_parent = $pageNum_parent * $maxRows_parent;

mysql_select_db($database_unique, $unique);
$query_parent = "SELECT parent_id,CONCAT_WS(' ', parent_lname, parent_fname) AS name FROM parent ORDER BY parent_lname ASC";
$query_limit_parent = sprintf("%s LIMIT %d, %d", $query_parent, $startRow_parent, $maxRows_parent);
$parent = mysql_query($query_limit_parent, $unique) or die(mysql_error());
$row_parent = mysql_fetch_assoc($parent);

if (isset($_GET['totalRows_parent'])) {
  $totalRows_parent = $_GET['totalRows_parent'];
} else {
  $all_parent = mysql_query($query_parent);
  $totalRows_parent = mysql_num_rows($all_parent);
}
$totalPages_parent = ceil($totalRows_parent/$maxRows_parent)-1;

$queryString_parent = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_parent") == false && 
        stristr($param, "totalRows_parent") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_parent = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_parent = sprintf("&totalRows_parent=%d%s", $totalRows_parent, $queryString_parent);
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
  <?php include('includes/side_admin.php'); ?>

					
<div id="right">	
			<div id="long_txt_pix">
            
              <h1>Parent's Data         </h1><span id="line"></span>
              <form id="search" method="get" action="search_result.php">
                <table width="95%" border="0">
                  <tr>
                    <td width="57%"><strong>Search Parents by Name</strong></td>
                    <td width="43%"><input name="name" type="text" class="searchfield" id="name" />                      <input name="submit" type="submit" class="searchbutton" id="submit" value="Submit" /></td>
                  </tr>
                </table>
              </form>
              <form action="search_result.php" name="assign_subject" id="parent_data" method="get">
                <table width="95%" border="0" cellpadding="6">
                  <tr>
                    <td colspan="2" align="center"><?php if(isset($_GET['message'])){
						switch ($_GET['message']){
							case "update": ?>
                      <span class="success">Data Updated Successfully</span>
                      <?php  break;
				  	case "insert": ?>
                      <span class="success">Data Entered Successfully</span>. <strong><a href="enter_parents_details.php">Add Another</a></strong>
                      <?php break; 
						}
					}?>
                      <strong><a href="enter_parents_details.php"></a></strong></td>
                    <td align="center"><strong><a href="reports/report_parents.php" target="_blank">PRINT LIST</a></strong></td>
                  </tr>
                  <tr class="hlite">
                    <td height="26" colspan="3" align="left"><strong>Showing&nbsp;
                      Records <?php echo ($startRow_parent + 1) ?> to <?php echo min($startRow_parent + $maxRows_parent, $totalRows_parent) ?> of <?php echo $totalRows_parent ?> <a href="reports/report_parents.php" target="_blank"></a></strong></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left"><table width="100%" border="0">
                      <tr>
                        <td width="6%" height="39"><?php if ($pageNum_parent > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, 0, $queryString_parent); ?>">First</a>
                        <?php } // Show if not first page ?></td>
                        <td width="83%"><?php if ($pageNum_parent > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, max(0, $pageNum_parent - 1), $queryString_parent); ?>">Previous</a>
                        <?php } // Show if not first page ?></td>
                        <td width="6%"><?php if ($pageNum_parent < $totalPages_parent) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, min($totalPages_parent, $pageNum_parent + 1), $queryString_parent); ?>">Next</a>
                        <?php } // Show if not last page ?></td>
                        <td width="5%"><?php if ($pageNum_parent < $totalPages_parent) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, $totalPages_parent, $queryString_parent); ?>">Last</a>
                        <?php } // Show if not last page ?></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr class="hlite">
                    <td width="21%" align="left"><h2>Parent ID</h2></td>
                    <td width="49%" align="left"><h2>Parent's Names</h2></td>
                    <td width="30%" align="left"><h2>ACTION</h2></td>
                  </tr>
                  <?php $count=0; ?>
                  <?php do { ?>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><p><strong><?php echo $row_parent['parent_id']; ?></strong></p></td>
                    <td><p><strong><?php echo $row_parent['name']; ?></strong> </p></td>
                    <td><p><a href="view_details.php?id=<?php echo $row_parent['parent_id']; ?>&amp;cat=parent">Details</a> | <a href="edit_details.php?id=<?php echo $row_parent['parent_id']; ?>&amp;cat=parent">Edit</a> |<a href="delete_parent.php?cat=parent&amp;id=<?php echo $row_parent['parent_id']; ?>">Delete</a></p></td>
                  </tr>
                  <?php } while ($row_parent = mysql_fetch_assoc($parent)); ?>
                  <tr>
                    <td colspan="3"><table width="100%" border="0">
                      <tr>
                        <td width="37"><?php if ($pageNum_parent > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, 0, $queryString_parent); ?>">First</a>
                        <?php } // Show if not first page ?></td>
                        <td width="468"><?php if ($pageNum_parent > 0) { // Show if not first page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, max(0, $pageNum_parent - 1), $queryString_parent); ?>">Previous</a>
                        <?php } // Show if not first page ?></td>
                        <td width="34"><?php if ($pageNum_parent < $totalPages_parent) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, min($totalPages_parent, $pageNum_parent + 1), $queryString_parent); ?>">Next</a>
                        <?php } // Show if not last page ?></td>
                        <td width="41"><?php if ($pageNum_parent < $totalPages_parent) { // Show if not last page ?>
                          <a href="<?php printf("%s?pageNum_parent=%d%s", $currentPage, $totalPages_parent, $queryString_parent); ?>">Last</a>
                        <?php } // Show if not last page ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table>
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
mysql_free_result($parent);
?>
