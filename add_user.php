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
<?php require_once('Connections/unique.php'); ?>
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
$query_staff = "SELECT CONCAT_WS(' ',lname, fname) AS s_name, staff.staff_id FROM staff WHERE staff.teach>1 ORDER BY lname ASC";
$staff = mysql_query($query_staff, $unique) or die(mysql_error());
$row_staff = mysql_fetch_assoc($staff);
$totalRows_staff = mysql_num_rows($staff);

mysql_select_db($database_unique, $unique);
$query_parent = "SELECT parent.parent_id,CONCAT_WS(' ', parent.parent_lname, parent.parent_fname) AS p_name FROM parent WHERE parent.sex='m' ORDER BY parent.parent_lname";
$parent = mysql_query($query_parent, $unique) or die(mysql_error());
$row_parent = mysql_fetch_assoc($parent);
$totalRows_parent = mysql_num_rows($parent);





$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
	$_POST['password']=sha1($_POST['password']);
  $insertSQL = sprintf("INSERT INTO login (user_id, user_name, user_password, access_level) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['select2'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());
}


mysql_select_db($database_unique, $unique);
$query_staff_user = "SELECT CONCAT_WS(' ',staff.lname, staff.fname) AS name, login.user_name, login.access_level, login.login_id FROM login, staff WHERE login.user_id = staff.staff_id AND login.access_level>1 ORDER BY login.access_level DESC, staff.lname, staff.fname";
$staff_user = mysql_query($query_staff_user, $unique) or die(mysql_error());
$row_staff_user = mysql_fetch_assoc($staff_user);
$totalRows_staff_user = mysql_num_rows($staff_user);



mysql_select_db($database_unique, $unique);
$query_parent_user = "SELECT CONCAT_WS(' ', parent.parent_lname, parent.parent_fname) AS name, login.user_name, login.login_id FROM parent, login WHERE login.user_id = parent.parent_id  ORDER BY parent.parent_lname";
$parent_user = mysql_query($query_parent_user, $unique) or die(mysql_error());
$row_parent_user = mysql_fetch_assoc($parent_user);
$totalRows_parent_user = mysql_num_rows($parent_user);
?>
<?php 
$sn=1;
$count=0;
$pn=1;
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
<script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
</head>
<body>
<div id="content">
		<?php include("includes/header.php"); ?>

	
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
 <div id="line"></div>
		
		<div id="left_home"><img src="images/ubs,-abuja.jpg" alt="" width="230" height="243" /></div>

<?php include('includes/side_admin.php'); ?>
<div id="right">	
			<div id="rl">
            
              <h1>Add User</h1>
              <p><?php if (isset($Result1) && true){?><span class="success">User Successfully Added</span><?php } ?></p>
              <h2>
                <?php if (isset($_GET['message']) && true){?>
                <span class="success">Password Reset Successfully,<br />New password is </span><span class="fail"><strong><?php echo $_GET['pw']; ?></strong></span>
                <?php } ?>
              </h2>
          
				
          <form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
            <table width="100%" border="1">
              <tr>
      <td colspan="2" align="center"><h2><strong>Please Select a Category:</strong></h2></td>
      </tr>
    <tr>
      <td width="16%">&nbsp;</td>
      <td width="84%"><select name="cat" id="cat" onchange="MM_jumpMenu('parent',this,0)">
        <option>--Select a Category---</option>
        <option value="add_user.php?cat=parent">Parent</option>
        <option value="add_user.php?cat=staff">Staff</option>
      </select></td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <?php if (isset($_GET['cat'])){
	  switch ($_GET['cat']){
		  case "staff": ?>
  <table width="100%" border="1">
    <tr>
      <td align="right">ID</td>
      <td><select name="id" id="id">
        <option value="">---select name---</option>
        <?php
do {  
?>
        <option value="<?php echo $row_staff['staff_id']?>"><?php echo $row_staff['s_name']?></option>
        <?php
} while ($row_staff = mysql_fetch_assoc($staff));
  $rows = mysql_num_rows($staff);
  if($rows > 0) {
      mysql_data_seek($staff, 0);
	  $row_staff = mysql_fetch_assoc($staff);
  }
?>
        </select></td>
    </tr>
    <tr>
      <td align="right">Username</td>
      <td><input type="text" name="username" id="username" /></td>
    </tr>
    <tr>
      <td align="right">password</td>
      <td><input type="text" name="password" id="password" /></td>
    </tr>
    <tr>
      <td align="right">Level</td>
      <td><select name="select2" id="select2">
<option value="2">Staff</option>
<option value="3">Administrator</option>
      </select></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="signin" type="submit" class="searchbutton" id="signin" value="Add User" /></td>
    </tr>
  </table>
  <?php 
  break;
  case "parent": ?>
  <table width="100%" border="1">
    <tr>
      <td align="right">ID</td>
      <td><select name="id" id="id">
        <option value="">---select name---</option>
        <?php
do {  
?>
        <option value="<?php echo $row_parent['parent_id']?>"><?php echo $row_parent['p_name']?></option>
        <?php
} while ($row_parent = mysql_fetch_assoc($parent));
  $rows = mysql_num_rows($parent);
  if($rows > 0) {
      mysql_data_seek($parent, 0);
	  $row_parent = mysql_fetch_assoc($parent);
  }
?>
      </select></td>
    </tr>
    <tr>
      <td align="right">Username</td>
      <td><input type="text" name="username" id="username" /></td>
    </tr>
    <tr>
      <td align="right">password</td>
      <td><input type="text" name="password" id="password" /></td>
    </tr>
    <tr>
      <td align="right">Level</td>
      <td><select name="select2" id="select2">
<option value="1">Parents</option>
      </select></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input name="signin" type="submit" class="searchbutton" id="signin" value="Add User" /></td>
    </tr>
  </table>
  <?php 
  break;
	  }
  }
	  ?>
  
  <p>
    <label for="signin"></label>
    <input type="hidden" name="MM_insert" value="form1">
  </p></form></div>
	<table width="90%" border="1" align="left">
  <tr>
    <td colspan="3"><h1>STAFF</h1></td>
    <td align="left"><a href="reports/staff_login.php" target="_blank">PRINT STAFF LOGIN</a></td>
    </tr>
  <tr>
    <td width="8%">S/NO</td>
    <td width="33%">NAMES</td>
    <td width="34%">USERNAME</td>
    <td width="25%" align="left">PRIVILEDGE</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><strong><?php echo $sn++; ?></strong></td>
      <td><strong><?php echo $row_staff_user['name']; ?></strong></td>
      <td><strong><?php echo $row_staff_user['user_name']; ?></strong></td>
      <td align="left"><strong>
        <?php if($row_staff_user['access_level']==2) echo "Staff"; elseif($row_staff_user['access_level']==3) echo "Admin"; else echo "Parent"; ?>
        <?php
		// check to make sure user can not delete his own account
		if($row_staff_user['user_name']<>$_SESSION['MM_Username']){ ?>
        
|<a href="delete_user.php?id=<?php echo $row_staff_user['login_id']; ?>">Delete</a> | <a href="reset_user.php?id=<?php echo $row_staff_user['login_id']; ?>&amp;action=reset">Reset</a></strong></td> 
      <?php } ?>
    </tr>
    <?php } while ($row_staff_user = mysql_fetch_assoc($staff_user)); ?>
    </table>
  <p class="clr">&nbsp;</p>
  <p class="clr">&nbsp;</p>
  <p class="clr">&nbsp;</p>
  <p class="clr">&nbsp;</p>
  <p class="clr">&nbsp; </p>
<table width="90%" border="1" align="left">
  <tr>
    <td colspan="3"><h1>PARENTS</h1></td>
    <td><a href="reports/parent_login.php">PRINT</a></td>
    </tr>
  <tr>
    <td><strong>S/NO</strong></td>
    <td><strong>NAMES</strong></td>
    <td colspan="2"><strong>USERNAME</strong></td>
    </tr>
  <?php if ($totalRows_parent_user > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <tr>
      <td><strong><?php echo $pn++; ?></strong></td>
      <td><strong><?php echo $row_parent_user['name']; ?></strong></td>
      <td><strong><?php echo $row_parent_user['user_name']; ?></strong></td>
      <td><a href="delete_user.php?id=<?php echo $row_parent_user['login_id']; ?>">Delete</a></td>
    </tr>
    <?php } while ($row_parent_user = mysql_fetch_assoc($parent_user)); ?>
    <?php } // Show if recordset not empty ?>
</table>


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
mysql_free_result($staff);

mysql_free_result($parent);

mysql_free_result($staff_user);

mysql_free_result($parent_user);
?>
