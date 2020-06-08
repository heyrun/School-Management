<?php require_once('../Connections/unique.php'); ?>
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
$query_parent = "SELECT parent.parent_id,CONCAT_WS(' ', parent.parent_lname, parent.parent_fname) AS p_name FROM parent WHERE parent.sex='m' ORDER BY parent.parent_lname";
$parent = mysql_query($query_parent, $unique) or die(mysql_error());
$row_parent = mysql_fetch_assoc($parent);
$totalRows_parent = mysql_num_rows($parent);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php $si=0; ?>
<style type="text/css">
<!--
.head1 {
	color: #003;
	font-size: 24px;
	margin-left: 100px;
	margin-right: auto;
}
#wrapper table {
	padding-left: 10px;
	margin-left: 5px;
}
#wrapper {
	width: 600px;
	margin-right: auto;
	margin-left: auto;
	border: thin solid #333;
}
-->
</style>
</head>

<body>
<div id="wrapper"><span class="head1">UNIQUE BLOSSOM SCHOOLS MAITAMA</span>
  <p>
  NAME OF FATHERS</p>
  <table width="100%" border="0">
    <tr>
      <td>S/NO</td>
      <td>NAMES</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php 
	
	echo ++$si;
		
	
	?></td>
        <td><?php echo $row_parent['p_name']; ?></td>
      </tr>
      <?php } while ($row_parent = mysql_fetch_assoc($parent)); ?>
  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($parent);
?>
