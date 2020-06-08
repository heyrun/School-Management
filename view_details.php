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

$colname_mum = "-1";
if (isset($_GET['id'])) {
  $colname_mum = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_mum = sprintf("SELECT parent.parent_lname, parent.parent_fname, student_info.student_id, parent.parent_id FROM parent, student_info WHERE (student_info.student_id=%s) AND (parent.parent_id =student_info.Parent1 OR parent.parent_id = student_info.parent2) AND parent.sex='f'", GetSQLValueString($colname_mum, "text"));
$mum = mysql_query($query_mum, $unique) or die(mysql_error());
$row_mum = mysql_fetch_assoc($mum);
$totalRows_mum = mysql_num_rows($mum);

$colname_pops = "-1";
if (isset($_GET['id'])) {
  $colname_pops = $_GET['id'];
}
mysql_select_db($database_unique, $unique);
$query_pops = sprintf("SELECT parent.parent_lname, parent.parent_fname, student_info.student_id, parent.parent_id FROM parent, student_info WHERE (student_info.student_id=%s) AND (parent.parent_id =student_info.Parent1 OR parent.parent_id = student_info.parent2) AND parent.sex='m'", GetSQLValueString($colname_pops, "text"));
$pops = mysql_query($query_pops, $unique) or die(mysql_error());
$row_pops = mysql_fetch_assoc($pops);
$totalRows_pops = mysql_num_rows($pops);
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
            <?php if(isset($totalRows_parent)){ if ($totalRows_parent > 0) { // Show if recordset not empty ?>
            
            
              <h2> Data of <?php echo ucfirst($row_parent['parent_lname']); ?> <?php echo ucfirst($row_parent['parent_fname']); ?></h2>
              <h1>[<a href="edit_details.php?id=<?php echo $row_parent['parent_id']; ?>&amp;cat=parent">EDIT</a>]</h1>
              <form name="assign_subject" id="parent_data" method="POST">
                <table width="80%" border="0" align="center" cellpadding="6">
                  <?php $count=0; ?>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td width="32%"><h3>Parent ID</h3></td>
                    <td width="68%"><h3><?php echo $row_parent['parent_id']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>First Name</h3></td>
                    <td><h3><?php echo ucfirst($row_parent['parent_fname']); ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Last Name</h3></td>
                    <td><h3><?php echo ucfirst($row_parent['parent_lname']); ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Sex</h3></td>
                    <td><h3><?php echo strtoupper($row_parent['sex']); ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Profession</h3></td>
                    <td><h3><?php echo $row_parent['profession']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Home Address</h3></td>
                    <td><h3><?php echo $row_parent['home_address']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Office Address</h3></td>
                    <td><h3><?php echo $row_parent['office_address']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Mobile Number</h3></td>
                    <td><h3><?php echo $row_parent['mobile_phone']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Office Number</h3></td>
                    <td><h3><?php echo $row_parent['office_phone']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Home Number</h3></td>
                    <td><h3><?php echo $row_parent['home_phone']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Emails</h3></td>
                    <td><h3><?php echo $row_parent['email']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>State of Origin</h3></td>
                    <td><h3><?php echo ucfirst($row_parent['origin']); ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>Religion</h3></td>
                    <td><h3><?php echo ucfirst($row_parent['religion']); ?></h3></td>
                  </tr>
                </table>
                <p><?php }  }?></p>
                <?php if(isset($totalRows_student)){ 
				if ($totalRows_student > 0) { // Show if recordset not empty ?>
  <h1>Data of  <?php echo $row_student['student_Lname']; ?> <?php echo $row_student['student_Fname']; ?></h1>
                <table width="80%" border="0" align="center" cellpadding="6">
                  <?php $count=0; ?>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td>&nbsp;</td>
                    <td align="right" valign="top"><img src="<?php 
					
					$pix="images/students/". $pix_url=str_replace("/","_",$row_student['student_id']).".JPG";
					if(!file_exists($pix)) echo "images/dummy.jpg"; else echo $pix;?>" alt="" /></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td width="31%"><h3>STUDENT ID</h3></td>
                    <td width="69%"><h3><?php echo ucwords($row_student['student_id']); ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>FIRST NAME</h3></td>
                    <td><h3><?php echo ucfirst($row_student['student_Fname']); ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>LAST NAME</h3></td>
                    <td><h3><?php echo ucfirst($row_student['student_Lname']); ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>CLASS</h3></td>
                    <td><h3><?php echo $row_student['class_name']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>MOTHER'S NAME</h3></td>
                    <td><h3><a href="view_details.php?id=<?php echo $row_mum['parent_id']; ?>&amp;cat=parent"><?php echo $row_mum['parent_lname']; ?> <?php echo $row_mum['parent_fname']; ?></a></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>FATHER'S NAME</h3></td>
                    <td><h3><a href="view_details.php?id=<?php echo $row_pops['parent_id']; ?>&amp;cat=parent"><?php echo $row_pops['parent_lname']; ?> <?php echo $row_pops['parent_fname']; ?></a></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>DATE OF BIRTH</h3></td>
                    <td><h3><?php echo $row_student['dob']; ?></h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>SEX</h3></td>
                    <td><h3><?php echo ucwords($row_student['sex']); ?> </h3></td>
                  </tr>
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                    <td><h3>YEAR ADMITTED</h3></td>
                    <td><h3><?php echo $row_student['year_admitted']; ?></h3></td>
                  </tr>
                </table>
                  <?php } // Show if recordset not empty 
				  }?>
<p>&nbsp;</p>
                <p>&nbsp;</p>
              </form>
<?php if ((isset($totalRows_parent) && $totalRows_parent == 0) or(isset($totalRows_student) && $totalRows_student==0))  { // Show if recordset empty ?>
  <h1>NO RECORD FOUND</h1>
  <?php } // Show if recordset empty ?>
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

mysql_free_result($mum);

mysql_free_result($pops);
}
?>
