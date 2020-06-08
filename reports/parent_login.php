<?php require_once('../Connections/unique.php'); ?>
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

$MM_restrictGoTo = "../admin.php";
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

mysql_select_db($database_unique, $unique);
$query_parent = "SELECT parent_id,CONCAT_WS(' ', parent_lname, parent_fname) AS name, login.user_id, login.user_name FROM parent, login WHERE login.access_level=1 AND parent.parent_id = login.user_id ORDER BY parent_lname ASC";
$parent = mysql_query($query_parent, $unique) or die(mysql_error());
$row_parent = mysql_fetch_assoc($parent);
$totalRows_parent = mysql_num_rows($parent);

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
   <link rel="stylesheet" href="../nivo-slider.css" type="text/css" media="screen"  />
<!-- 
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.nin.js"  type="text/javascript"></script> 
-->

<script type="text/javascript" src="../demo/scripts/jquery-1.6.1.min.js"></script>
<script src="../jquery.nivo.slider.pack.js" type="text/javascript"> </script>

 <link rel="stylesheet" href="../themes/default/default.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../themes/pascal/pascal.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="../themes/orman/orman.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="../nivo-slider.css" type="text/css" media="screen" />
    
    
    <!-- end of slider script -->
    
    
    
    
    
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="Unique Blossom Schools, Abuja; Creche, Prenursery, Nursery, Primary" />
	<meta name="keywords" content="creche, Nursery, prenursery, reception, primary, schoool, school in abuja, primary school in abuja, nursery school, students, unique blossom" />
	<link rel="stylesheet" href="../style.css" type="text/css" />
<link rel="shortcut icon" href="../favicon.ico" />
</head>
<body>
<div id="content">
  <div id="full_width">
    <form action="../search_result.php" name="assign_subject" id="parent_data" method="get">
      <table width="80%" border="0" align="center" cellpadding="6">
        <?php $count=0; ?>
        <?php do { ?>
            <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
              <td colspan="3" align="center"><h1>Parents Login Details </h1></td>
            </tr>
            <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                <td width="50%"><h2>Parent Name</h2></td>
              <td width="25%"><h2>Username</h2></td>
              <td width="25%"><h2>Password</h2></td>
          </tr>
            <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
              <td colspan="3"><hr /></td>
            </tr>
            <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
              <td><strong class="BIGFONT"><?php echo $row_parent['name']; ?></strong></td>
              <td><strong><?php echo $row_parent['user_name']; ?></strong></td>
              <td><strong><?php echo $row_parent['user_name']; ?></strong></td>
            </tr>
            <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
              <td colspan="3"><hr />
                <p>                INSTRUCTIONS:</p>
                <p><strong>step1: </strong>log on to <a href="http://www.uniqueblossomschoools.com">http://www.uniqueblossomschools.com. </a></p>
                <p><strong>Step 2:</strong> Click on &quot;parent home&quot; at the top right corner of the screen.</p>
                <p><strong>Step 3:</strong> Enter username and password.</p>
                <p><strong>Step 4</strong>: Click &quot;1st term&quot; in front of child's name to view child's result.</p>
              <p><strong>Step 5:</strong> Click &quot;view Teacher's Comment&quot; to view your child's class teacher's comments.</p></td>
            </tr>
            <?php } while ($row_parent = mysql_fetch_assoc($parent)); ?>
      </table>
    </form>
  </div>
  
  
			
		<?php include("../includes/footer.php"); ?>	
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
