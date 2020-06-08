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

mysql_select_db($database_unique, $unique);
$query_Recordset1 = "SELECT CONCAT_WS(' ', student_info.student_Lname, student_info.student_Fname) AS name, student_info.`class`, `class`.class_id, `class`.class_name FROM student_info, `class` WHERE student_info.`class` = `class`.class_id ORDER BY student_info.`class`, student_info.student_Lname";
$Recordset1 = mysql_query($query_Recordset1, $unique) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
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
  <table width="100%" border="1">
    <tr>
      <td width="12%">S/NO</td>
      <td width="61%">NAMES</td>
      <td width="27%">CLASS</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php 
	
	echo ++$si;
		
	
	?></td>
<td><?php echo $row_Recordset1['name']; ?></td>
<td><?php echo $row_Recordset1['class_name']; ?></td>
      </tr>
     
<?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>

  </table>
  <p>&nbsp;</p>
</div>
</body>
</html>
<?php
mysql_free_result($parent);

mysql_free_result($Recordset1);
?>
