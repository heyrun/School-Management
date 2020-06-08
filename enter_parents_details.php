<?php require_once('Connections/unique.php'); ?>
<?php
$i=0;
$error=array();
$message='';
$user=true;
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

mysql_select_db($database_unique, $unique);
$query_number = "SELECT COUNT(*) AS number FROM parent";
$number = mysql_query($query_number, $unique) or die(mysql_error());
$row_number = mysql_fetch_assoc($number);
$totalRows_number = mysql_num_rows($number);

if(isset($_POST['Add'])){
	foreach ($_POST as $item){
		$item=trim($item);
	}

if (empty($_POST['sex'])){
	array_push($error,'sex');
}

if (empty($_POST['fname'])){
	array_push($error,'fname');
}
if (empty($_POST['lname'])){
	array_push($error,'lname');
}
if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		array_push($error,'captcha');
	}
			
}





$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


if(empty($error)){
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "parent_data")) {
  $insertSQL = sprintf("INSERT INTO parent (parent_id, parent_fname, parent_lname, profession, office_address, home_address, office_phone, home_phone, mobile_phone, sex, email, origin, religion) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
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
					    GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['origin'], "text"),
                       GetSQLValueString($_POST['religion'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique);

if(!$Result1 && mysql_errno()==1062){
	  array_push($error,'id');
	  $message.="ID taken";
	  $user=false;
  }
  elseif(mysql_error()){
	  $message.="There was an error enter the data. Please try again later or contact the DB Administrator";
  }
  else{

  $insertGoTo = "view_parents.php?message=insert";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}

}
?>
<?php
$zeros="000";
if($row_number['number']>=10 && $row_number['number']<1000) $zeros="00"; elseif($row_number['number']>=1000) $zeros="0";

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
<script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>	
</head>
<body OnLoad="document.enter_parent.fname.focus()">
<div id="content">
		<?php include("includes/header.php"); ?>

	
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
  <?php include('includes/side_admin.php'); ?>

					
<div id="right">	
			<div id="long_txt_pix">
            
              <h1>Enter Parent's Data</h1><form action="<?php echo $editFormAction; ?>" method="POST" name=parent_data id="enter_parent">
<table width="93%" border="1">
        <tr>
          <td height="30" colspan="2" align="center"><?php if (isset($Result1) && ($user)){?>
            <span class="success">Assignment Successful Added</span>
            <?php } elseif(!empty($error)) {?><span class='warning'>Problems completing your request. please corect the fields in red</span><?php  } ?></td>
        </tr>
        <tr>
          <td width="21%" align="right">Parent's ID</td>
          <td width="79%" style="text-align: left"><label>
              <input type="text" name="id" id="id" value="<?php if(!empty($error)) echo $_POST['id']; else echo "UBS/P/".$zeros.++$row_number['number']; ?>" />
              <?php if(!empty($error) && in_array('id',$error)){ ?>
              <span class="warning"><?php if(isset($_POST['id']) && (!empty($_POST['id']))){ echo $_POST['id']; }?> 
              ID already in Use or ID field empty</span>
              <?php } ?>
          </label></td>
        </tr>
        <tr>
          <td align="right">Parents Firstname</td>
          <td style="text-align: left"><label>
              <input type="text" name="fname" id="fname" value="<?php if(!empty($error)) echo $_POST['fname']; ?>" />
              <?php if(!empty($error) && in_array('fname',$error)){ ?>
              <span class="warning">Please Enter Parent's first name</span>
              <?php } ?>
          </label></td>
        </tr>
        <tr>
          <td align="right">Parent's Lastname</td>
          <td style="text-align: left"><label>
              <input type="text" name="lname" id="lname" value="<?php if(!empty($error)) echo $_POST['lname']; ?>"/>
              <?php if(!empty($error) && in_array('lname',$error)){ ?>
              <span class="warning">Please Enter Last Name of Parent</span>
              <?php } ?>
          </label></td>
        </tr>
        <tr>
          <td align="right">profession</td>
          <td style="text-align: left"><label>
              <input type="text" name="profession" id="profession" value="<?php if(!empty($error)) echo $_POST['profession']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td align="right">Home address</td>
          <td style="text-align: left"><label>
              <input type="text" name="h_address" id="h_address" value="<?php if(!empty($error)) echo $_POST['h_address']; ?>" />
          </label></td>
        </tr>
        <tr>
          <td align="right">Office Address</td>
          <td style="text-align: left"><label>
              <input type="text" name="o_address" id="o_address" value="<?php if(!empty($error)) echo $_POST['o_address']; ?>"/>
          </label></td>
        </tr>
        <tr>
          <td align="right">Office Number</td>
          <td style="text-align: left"><label>
              <input type="text" name="o_number" id="o_number" value="<?php if(!empty($error)) echo $_POST['o_number']; ?>"/>
          </label></td>
        </tr>
        <tr>
          <td align="right">Home Number</td>
          <td style="text-align: left"><label>
              <input type="text" name="h_number" id="h_number" value="<?php if(!empty($error)) echo $_POST['h_number']; ?>"/>
          </label></td>
        </tr>
        <tr>
          <td align="right">Mobile Number</td>
          <td style="text-align: left"><label>
              <input type="text" name="m_number" id="m_number" value="<?php if(!empty($error)) echo $_POST['m_number']; ?>"/>
          </label></td>
        </tr>
        <tr>
          <td align="right">Sex</td>
          <td style="text-align: left"><label>
              Male
              <input type="radio" name="sex" id="sex" value="m" />
              Female
            </label>
            <label>
              <input type="radio" name="sex" id="sex" value="f" />
              <?php if(!empty($error) && in_array('sex',$error)){ ?>
              <span class="warning">Please Select your Sex</span>
              <?php } ?>
            </label></td>
        </tr>
        <tr>
          <td align="right">Email</td>
          <td style="text-align: left"><label>
            <input type="text" name="email" id="email" />
          </label></td>
        </tr>
        <tr>
          <td align="right">State of Origin</td>
          <td style="text-align: left"><label>
              <select name="origin" id="origin">
                <option value="">--Select State--</option>
                <option value="Abia">Abia</option>
                <option value="Adamawa">Adamawa</option>
                <option value="Akwa Ibom">Akwa Ibom</option>
                <option value="Bauchi">Bauchi</option>
                <option value="Bayelsa">Bayelsa</option>
                <option value="Benue">Benue</option>
                <option value="Borno">Borno</option>
                <option value="cross river">cross river</option>
                <option value="delta">delta</option>
                <option value="ebonyi">ebonyi</option>
                <option value="edo">edo</option>
                <option value="enugu">enugu</option>
                <option value="gombe">gombe</option>
                <option value="imo">imo</option>
                <option value="jigawa">jigawa</option>
                <option value="kaduna">kaduna</option>
                <option value="kano">kano</option>
                <option value="kastina">kastina</option>
                <option value="kebbi">kebbi</option>
                <option value="kogi">kogi</option>
                <option value="kwara">kwara</option>
                <option value="lagos">lagos</option>
                <option value="nasarawa">nasarawa</option>
                <option value="niger">niger</option>
                <option value="ogun">ogun</option>
                <option value="ondo">ondo</option>
                <option value="oyo">oyo</option>
                <option value="plateu">plateau</option>
                <option value="rivers">rivers</option>
                <option value="sokoto">sokoto</option>
                <option value="taraba">taraba</option>
                <option value="yobe">yobe</option>
                <option>zamfara</option>
                <option value="fct">fct</option>
              </select>
          </label></td>
        </tr>
        <tr>
          <td align="right">Religion</td>
          <td style="text-align: left"><label>
            <select name="religion" id="religion">
              <option value="">--select religion--</option>
              <option value="christain">Christain</option>
              <option value="muslim">Muslim</option>
              <option value="other">Other</option>
              </select>
            </label></td>
        </tr>
        <tr class="row2">
          <td align="right">&nbsp;</td>
          <td style="text-align: left"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" alt="Captcha image" id='captchaimg' /> <?php if(!empty($error) && in_array('captcha', $error)){?><span class="warning">Captcha data doesn't match</span><?php } ?></td>
        </tr>
        <tr class="row1">
          <td align="right">&nbsp;</td>
          <td style="text-align: left"><label for='message3'>Enter the code above here :</label>
            <br />
            <input name="6_letters_code" type="text" class="input" id="6_letters_code" />
            <br />
            <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small></td>
        </tr>
        <tr>
          <td align="right">&nbsp;</td>
          <td style="text-align: left"><label>
            <input name="Add" type="submit" class="searchbutton" id="Add" value="Submit" />
            </label></td>
        </tr>
        </table>
<input type="hidden" name="MM_insert" value="parent_data" />
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
mysql_free_result($number);
?>
