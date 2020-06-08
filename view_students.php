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

$maxRows_students = 30;
$pageNum_students = 0;
if (isset($_GET['pageNum_students'])) {
  $pageNum_students = $_GET['pageNum_students'];
}
$startRow_students = $pageNum_students * $maxRows_students;

mysql_select_db($database_unique, $unique);
$query_students = "SELECT student_info.student_id,CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name, `class`.class_name, student_info.sex FROM student_info, `class` WHERE student_info.`class` = `class`.class_id ORDER BY `class`.class_name, student_info.student_Lname";
$query_limit_students = sprintf("%s LIMIT %d, %d", $query_students, $startRow_students, $maxRows_students);
$students = mysql_query($query_limit_students, $unique) or die(mysql_error());
$row_students = mysql_fetch_assoc($students);

if (isset($_GET['totalRows_students'])) {
  $totalRows_students = $_GET['totalRows_students'];
} else {
  $all_students = mysql_query($query_students);
  $totalRows_students = mysql_num_rows($all_students);
}
$totalPages_students = ceil($totalRows_students/$maxRows_students)-1;

$queryString_students = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_students") == false && 
        stristr($param, "totalRows_students") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_students = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_students = sprintf("&totalRows_students=%d%s", $totalRows_students, $queryString_students);

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
            
              <h1>Students Data              </h1>
              <table width="95%" border="1">
                <tr>
                  <td align="right"><form id="form1" method="get" action="search_result_student.php">
                    <input name="name" type="text" class="searchfield" id="name" />
                    <input name="submit" type="submit" class="searchbutton" id="submit" value="Search Student" />
                  </form></td>
                </tr>
              </table>
              <p>&nbsp;</p>
              <form name="assign_subject" id="parent_data" method="POST">
                <table width="95%" border="0" cellpadding="6">
                <tr>
                <td colspan="5" align="left"><table width="100%" border="0">
                  <tr>
                    <td width="83%"><table width="99%" border="0" cellpadding="6">
                      <tr>
                        <td height="32" colspan="4" align="center"><p>
                          <?php if(isset($_GET['message'])){ switch ($_GET['message']){
				  case "update": ?>
                          <span class='success'>Data Successfully Update</span>
                          <?php 
				  break;
				  case "insert": ?>
                          <span class='success'>Data Successfully Inserted</span>. <strong><a href="enter_students.php">Add Another</a></strong>
                          <?php 
				  break;
				  }
			  }?>
                        </p></td>
                        <td height="32" align="center"><a href="reports/report_student.php" target="_blank">Print List</a></td>
                      </tr>
                      <tr>
                        <td colspan="5" align="left">&nbsp;<strong>Showing 
Records <?php echo ($startRow_students + 1) ?> to <?php echo min($startRow_students + $maxRows_students, $totalRows_students) ?> of <?php echo $totalRows_students ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="5" align="left"><table width="100%" border="0">
                          <tr>
                            <td width="6%"><?php if ($pageNum_students > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, 0, $queryString_students); ?>">First</a>
                              <?php } // Show if not first page ?></td>
                            <td width="83%"><?php if ($pageNum_students > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, max(0, $pageNum_students - 1), $queryString_students); ?>">Previous</a>
                              <?php } // Show if not first page ?></td>
                            <td width="6%"><?php if ($pageNum_students < $totalPages_students) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, min($totalPages_students, $pageNum_students + 1), $queryString_students); ?>">Next</a>
                              <?php } // Show if not last page ?></td>
                            <td width="5%"><?php if ($pageNum_students < $totalPages_students) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, $totalPages_students, $queryString_students); ?>">Last</a>
                              <?php } // Show if not last page ?></td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr class="hlite">
                        <td width="23%" align="left"><h2>Student's ID</h2></td>
                        <td width="25%" align="left"><h2>Student's Names</h2></td>
                        <td width="23%" align="left"><h2>CLASS</h2></td>
                        <td width="15%" align="left"><h2>SEX</h2></td>
                        <td width="14%" align="left"><h2>ACTION</h2></td>
                      </tr>
                      <?php $count=0; ?>
                      <?php do { ?>
                      <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                        <td><p><?php echo $row_students['student_id']; ?></p></td>
                        <td><p><?php echo $row_students['name']; ?></p></td>
                        <td><?php echo $row_students['class_name']; ?></td>
                        <td><?php echo ucwords($row_students['sex']); ?></td>
                        <td><p><a href="view_details.php?id=<?php echo $row_students['student_id']; ?>&amp;cat=student">Details</a>|<a href="edit_student_details.php?id=<?php echo $row_students['student_id']; ?>&amp;cat=student">Edit</a>|<a href="delete_student.php?cat=student&amp;id=<?php echo $row_students['student_id']; ?>">Delete</a>|</p></td>
                      </tr>
                      <?php } while ($row_students = mysql_fetch_assoc($students)); ?>
                      <tr>
                        <td height="73" colspan="5"><table width="100%" border="0">
                          <tr>
                            <td width="6%"><?php if ($pageNum_students > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, 0, $queryString_students); ?>">First</a>
                              <?php } // Show if not first page ?></td>
                            <td width="83%"><?php if ($pageNum_students > 0) { // Show if not first page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, max(0, $pageNum_students - 1), $queryString_students); ?>">Previous</a>
                              <?php } // Show if not first page ?></td>
                            <td width="6%"><?php if ($pageNum_students < $totalPages_students) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, min($totalPages_students, $pageNum_students + 1), $queryString_students); ?>">Next</a>
                              <?php } // Show if not last page ?></td>
                            <td width="5%"><?php if ($pageNum_students < $totalPages_students) { // Show if not last page ?>
                              <a href="<?php printf("%s?pageNum_students=%d%s", $currentPage, $totalPages_students, $queryString_students); ?>">Last</a>
                              <?php } // Show if not last page ?></td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
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
mysql_free_result($students);
?>
