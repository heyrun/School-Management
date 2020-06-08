<?php session_start(); ?>
<?php require_once('Connections/unique.php'); 
ini_set('date.timezone','Africa/Lagos');?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "admission") ) {
	
	
	$error=array();
$_POST['name']=trim($_POST['name']);
$_POST['number']=trim($_POST['number']);
$_POST['opinion']=trim($_POST['opinion']);
$_POST['curricullum']=trim($_POST['curricullum']);
$_POST['customer_service']=trim($_POST['customer_service']);
$_POST['children_teacher']=trim($_POST['children_teacher']);
$_POST['environment']=trim($_POST['environment']);
$_POST['security']=trim($_POST['security']);
$_POST['your_like']=trim($_POST['your_like']);
$_POST['improvement']=trim($_POST['improvement']);

foreach ($_POST as $key=>$value){
	$tmp=is_array($value)? $value : trim($value);
	if(empty($tmp)){
		array_push($error, $key);
	}
}
		
if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		array_push($error,'captcha');
	}
	
/*
if(empty($_POST['name'])){
	$error="Please enter your name";
}
$numberpattern='(0|1|3|4|5|6|7|08|9){11}';
if(empty($_POST['number'])==''){
	$error="Please enter your name";
}
if(empty($_POST['name'])){
	$error="Please enter your name";
}
if(empty($_POST['opinion'])){
	$error="Please Select an Opinion";
}
if(empty($_POST['curricullum'])){
	$error="Please Let us know what you think of our curricullum";
}
if(empty($_POST['customer_service'])){
	$error="Please enter your opinion on customer service";
}
if(empty($_POST['name'])){
	$error="Please enter your name";
}
*/
	
if (isset($error) && ($error==false)){
	
	
  $insertSQL = sprintf("INSERT INTO poll (parent_name, parent_number, opinion, curriculum, customer_service, children_teacher, environment, security, your_like, improvement, `Date`) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['number'], "text"),
                       GetSQLValueString($_POST['opinion'], "text"),
                       GetSQLValueString($_POST['curricullum'], "text"),
                       GetSQLValueString($_POST['customer_service'], "text"),
                       GetSQLValueString($_POST['children_teacher'], "text"),
                       GetSQLValueString($_POST['environment'], "text"),
                       GetSQLValueString($_POST['security'], "text"),
                       GetSQLValueString($_POST['your_like'], "text"),
                       GetSQLValueString($_POST['improvement'], "text"),
                       GetSQLValueString($_POST['date'], "date"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());
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
  <div id="form"><form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="admission" id="poll">
    <h1>Parents Online Survey Form
      </h1>
    <p>&nbsp;</p>
    <p>In order to serve you better, we would like to know what you think about our services? Please kindly give your objectiv opinion.</p>
    
    <?php if(isset($_POST) && isset($error) && ($error!=false)) { ?>
		<span class='warning'>Please kindly fill all the fields marked **</span> <?php } 
		else if(isset($Result1) && ($Result1)){?><span class="success">Thank you! your Opinions have been documented and will be reviewed by our Team</span><?php unset($_POST);} ?>
    <table width="100%" border="0">
      <tr class="row1">
        <td width="51%" align="right">Parent's Name*</td>
        <td width="49%"><label>
          <input value="<?php if (isset($_POST['name'] )){
echo htmlentities($_POST['name'],ENT_COMPAT,'UTF-8');
}
?>" name="name" type="text" class="input" id="name" />
          <?php if(isset($_POST) && isset($error) && in_array('name',$error)){ ?> 
          <span class="warning">**</span> <?php } ?>
        </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Phone Number*</td>
        <td><input value="<?php if (isset($_POST['number'] )){
echo htmlentities($_POST['number'],ENT_COMPAT,'UTF-8');
}
?>" name="number" type="text" class="input" id="number" />
          <?php if(isset($_POST) && isset($error) && in_array('number',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
        </tr>
      <tr class="row1">
        <td align="right">What is your opinion about our school*</td>
        <td><select name="opinion" class="input" id="opinion">
          <option value="">--Select an option--</option>
          <option value="Outstanding">Outstanding</option>
          <option value="Excellent">Excellent</option>
          <option value="Very Good">Very Good</option>
          <option value="Fair">Fair</option>
          <option value="Poor">Poor</option>
        </select>
          <?php if(isset($_POST) && isset($error) && in_array('opinion',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
        </tr>
      <tr class="row2">
        <td align="right">Curriculum/Extra Curricular Activities *</td>
        <td><label>
          <select name="curricullum" class="input" id="curricullum">
            <option value="">--Select an option--</option>
            <option value="Outstanding">Outstanding</option>
            <option value="Excellent">Excellent</option>
            <option value="Very Good">Very Good</option>
            <option value="Fair">Fair</option>
            <option value="Poor">Poor</option>
          </select>
        
          <?php if(isset($_POST) && isset($error) && in_array('curricullum',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?>
        </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Admin/Customer Service*</td>
        <td><select name="customer_service" class="input" id="customer_service">
          <option value="">--Select an option--</option>
          <option value="Outstanding">Outstanding</option>
          <option value="Excellent">Excellent</option>
          <option value="Very Good">Very Good</option>
          <option value="Fair">Fair</option>
          <option value="Poor">Poor</option>
        </select>
          <?php if(isset($_POST) && isset($error) && in_array('customer_service',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
        </tr>
      <tr class="row2">
        <td align="right">What can you say about your child/children teachers*</td>
        <td><select name="children_teacher" class="input" id="children_teacher">
          <option value="">--Select an option--</option>
          <option value="outstanding">Outstanding</option>
          <option value="excellent">Excellent</option>
          <option value="very good">Very Good</option>
          <option value="fair">Fair</option>
          <option value="poor">Poor</option>
        </select>
          <?php if(isset($_POST) && isset($error) && in_array('children_teacher',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
        </tr>
      <tr class="row1">
        <td align="right">What is your opinion on our school environment*</td>
        <td><select name="environment" class="input" id="environment">
          <option value="" selected="selected">--Select an option--</option>
          <option value="outstanding">Outstanding</option>
          <option value="excellent">Excellent</option>
          <option value="very good">Very Good</option>
          <option value="fair">Fair</option>
          <option value="poor">Poor</option>
        </select>
          <?php if(isset($_POST) && isset($error) && in_array('environment',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
        </tr>
      <tr class="row2">
        <td align="right">What is your opionion on our sercurity*</td>
        <td><select name="security" class="input" id="security">
		  <option value="">--Select an option---</option>
          <option value="outstanding">Outstanding</option>
          <option value="excellent">Excellent</option>
          <option value="very good">Very Good</option>
          <option value="fair">Fair</option>
          <option value="poor">Poor</option>
        </select>
          <?php if(isset($_POST) && isset($error) && in_array('security',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr class="row1">
        <td align="right">What would you like us to offer that we are not offering yet* </td>
        <td><textarea name="your_like" cols="30" rows="5" class="txt" id="your_like"><?php 
if(isset($_POST['your_like'])){
echo htmlentities($_POST['your_like'],ENT_COMPAT,'UTF-8');
}

 ?>
        </textarea>
          <?php if(isset($_POST) && isset($error) && in_array('your_like',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
        </tr>
      <tr class="row2">
        <td align="right">Which area of our activities needs improvement*</td>
        <td><textarea name="improvement" cols="30" rows="5" class="txt" id="improvement"><?php 
if(isset($_POST['improvement'])){
echo htmlentities($_POST['improvement'],ENT_COMPAT,'UTF-8');
}

 ?>
        </textarea>
          <?php if(isset($_POST) && isset($error) && in_array('improvement',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr class="row2">
        <td align="right">&nbsp;</td>
        <td><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' >
          <?php if(isset($_POST) && isset($error) && in_array('captcha',$error)){ ?>
          <span class="warning">**</span>
          <?php } ?></td>
      </tr>
      <tr class="row2">
        <td align="right">&nbsp;</td>
        <td><label for='message'>Enter the code above here :</label><br>
<input id="6_letters_code" name="6_letters_code" type="text">
<br>
<small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small></td>
      </tr>
      <tr class="row2">
        <td align="right">&nbsp;</td>
        <td><label>
          <input type="hidden" name="date" id="date" value="<?php echo date('d-m-Y h:m:s'); ?>"/>
          <input name="submit" type="submit" class="row1" id="submit" value="Submit" />
          </label></td>
      </tr>
      </table>
    <input type="hidden" name="MM_insert" value="admission" />
  </form></div>
</div>
  
  
			
		<?php unset($error); include("includes/footer.php"); ?>	
	</div>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
    <script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</body>
</html>