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
<script src="../SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="../favicon.ico" />
</head>
<body>
<div id="content">
		<?php include("../includes/header.php"); ?>
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

mysql_select_db($database_unique, $unique);
$query_parent = "SELECT CONCAT_WS(' ',parent.parent_lname, parent.parent_fname) AS name, parent.office_phone, parent.home_phone, parent.mobile_phone FROM parent ORDER BY parent.parent_lname";
$parent = mysql_query($query_parent, $unique) or die(mysql_error());
$row_parent = mysql_fetch_assoc($parent);
$totalRows_parent = mysql_num_rows($parent);
?>

	
       <div class="clearnav" >
         <?php include("../includes/nav.php"); ?>
       </div>
  <div id="report">	
			<div>
            
              <h1>Parent's Data         </h1><span id="line"></span>
              <form id="search" method="get" action="../search_result.php">
                <table width="95%" border="0">
                  <tr>
                    <td width="57%"><strong>Search Parents by Name</strong></td>
                    <td width="43%"><input name="name" type="text" class="searchfield" id="name" />                      <input name="submit" type="submit" class="searchbutton" id="submit" value="Submit" /></td>
                  </tr>
                </table>
              </form>
              <form action="../search_result.php" name="assign_subject" id="parent_data" method="get">
                <table width="56%" border="0" cellpadding="6">
                  <tr class="hlite">
                    <td colspan="2" align="left"><strong>Showing&nbsp;
                    Records  to  of  <a href="report_parents.php" target="_blank"></a></strong></td>
                  </tr>
                  <tr class="hlite">
                    <td width="36%" align="left"><h2>Parents Names</h2></td>
                    <td width="64%" align="left"><h2>Numbers</h2></td>
                  </tr>
                  
                  <?php $count=0; ?>
                 
                  <tr <?php if ($count++ %2) echo 'class="hlite"'; ?>>
                      
                    <td height="41" colspan="2"><p>
					 <?php do { ?>
					<?php echo $row_parent['name']; echo "  "; ?>
                      <?php 
					$phone1 = trim($row_parent['office_phone']);
					$phone2= trim($row_parent['home_phone']);
					$phone3= trim($row_parent['mobile_phone']);
					
					
					if(!empty($phone1)){
							$phone1=substr($phone1,1);
							$number="234".$phone1;
					}
					elseif(!empty($phone2)){
						$phone2=substr($phone2,1);
						$nummber="234".$phone2;
					}
					elseif(!empty($phone3)){
						$phone3=substr($phone3,1);
						$number="234".$phone3;
					}
					else {
						$number="";
					}
					
					echo $number;	
					echo "</p>"
					?>
                    </p>
                      <?php } while ($row_parent = mysql_fetch_assoc($parent)); ?>
                      </td>
                  </tr>
                  
                </table>
                <p>&nbsp;</p>
              </form>
<p>&nbsp;</p>
		  </div>
</div>
</div>
<script type="text/javascript">
$(window).load(function() {
        $('#slider').nivoSlider();
    });
</script>
</body>
</html><?php
mysql_free_result($parent);
?>
