<?php include('Connections/unique.php'); ?>
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

$colname_oldpwd = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_oldpwd = $_SESSION['MM_Username'];
}
mysql_select_db($database_unique, $unique);
$query_oldpwd = sprintf("SELECT user_password FROM login WHERE user_name = %s", GetSQLValueString($colname_oldpwd, "text"));
$oldpwd = mysql_query($query_oldpwd, $unique) or die(mysql_error());
$row_oldpwd = mysql_fetch_assoc($oldpwd);
$totalRows_oldpwd = mysql_num_rows($oldpwd);
?>
<?php require_once('Connections/unique.php'); ?>
<?php
if(isset($_POST['submit'])){
	$_POST['oldpwd']=sha1($_POST['oldpwd']);
	$error=true;
	if(trim($_POST['newpwd1'])!=trim($_POST['newpwd2'])){
		$error=false;
		$message="Password Mismatch";
	}
	elseif (trim($_POST['oldpwd'])!=$row_oldpwd['user_password']){
		$error=false;
		$message="please type your correct former password";
	} 
	if($error==true && !isset($message)){
	$newpwd="'".sha1($_POST['newpwd1'])."'";
	$user=$_SESSION['MM_Username'];
	$sql="UPDATE login SET `user_password`=`$newpwd` WHERE `user_name`=`$user`";
	$sql_query=mysql_query($sql) or die("Could not update table ".mysql_error());
	if($sql_query) $success=true;
	
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
        
        
		
  <div id="main_home">
		<div class="slider-wrapper theme-default">
            <div class="ribbon"></div>
          <div id="slider" class="nivoSlider">
   <img src="images/Unique_blossom3.jpg" alt="" title="#imgtitle1" />
        <img src="images/Unique_blossom1.jpg" alt=""  title="#imgtitle3"/>
        <img src="images/Unique_blossom4.jpg" alt="" title="#imgtitle4" />
        <img src="images/unique_blossom7.jpg" alt="" title="#imgtitle6" />
        <img src="images/unque_8.jpg" alt="" title="#imgtitle5" />
        <img src="images/Unique_blossom6.jpg" alt="" title="#imgtitle7" />
        </div>
    
		<div id=imgtitle3 class="nivo-html-caption">
      All work and no play...*Spacious Playground and World class play items*
      </div>
      <div id=imgtitle1 class="nivo-html-caption">
      The Face of a Future Leader
      </div>
      <div id=imgtitle2 class="nivo-html-caption">Confident and Smart
       </div>
        <div id=imgtitle4 class="nivo-html-caption">
      State-of-the-Art Laboratories and Facilities
      </div>
   
    <div id=imgtitle5 class="nivo-html-caption">
      Leadership and Knowledge</div>
 
    <div id=imgtitle7 class="nivo-html-caption">
      At Unique Blossom, We make learning fun</div>

<div id=imgtitle6 class="nivo-html-caption">
  Whatever they aspire to be, we help build a solid foundation to achieve that </div>
 </div>
  </div>
  <?php include("includes/side1.php"); ?>

		<div id="line"></div>
		<?php include('includes/side2.php'); ?>
		<div id="right">
  <div id="form"><form method="POST" enctype="multipart/form-data" name="admission" id="poll">
    <h1>Parents Online Survey Form
      </h1>
    <p>&nbsp;</p>
    <p>In order to serve you better, we would like to know what you think about our services? Please kindly give your objectiv opinion.</p>
    
    <?php if(isset($_POST) && isset($error) && ($error!=false)) echo "111"; {?><span class="warning">Please kindly fill all the fields marked *</span><?php } ?>
    <table width="100%" border="0">
    <tr align="center" class="row1">
      <td colspan="2"><table width="100%" border="0">
        <tr class="row1">
          <td width="53%" align="right">Old Password</td>
          <td width="47%"><label>
            <input name="name" type="text" class="input" id="name" />
          </label></td>
        </tr>
        <tr class="row2">
          <td align="right">New Password</td>
          <td><input name="number" type="text" class="input" id="number" /></td>
        </tr>
        <tr class="row1">
          <td align="right">Re-type New Password</td>
          <td><input name="number2" type="text" class="input" id="number2" /></td>
        </tr>
        <tr class="row2">
          <td align="right">&nbsp;</td>
          <td><label>
            <input type="hidden" name="date" id="date" value="<?php echo date('d-m-Y h:m:s'); ?>"/>
            <input name="change" type="submit" class="searchbutton" id="change" value="Change Password" />
            </label></td>
        </tr>
      </table>        <label></label></td>
    </tr>
    </table>
    <input type="hidden" name="MM_insert" value="admission" />
  </form></div>
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