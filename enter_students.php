<?php require_once('Connections/unique.php'); ?>
<?php
$i=0;
$error=array();
$message='';
$user=true;


if (isset($_POST['Add'])){
	$_POST['day']=trim($_POST['day']);
	$_POST['month']=trim($_POST['month']);
	$_POST['yr']=trim($_POST['yr']);
	if(!empty($_POST['day']) && !empty($_POST['month']) && !empty($_POST['yr'])){
		          $date_of_birth=$_POST['yr'].'-'.$_POST['month'].'-'.$_POST['day'];
		
		$_POST['dob']=$date_of_birth;
	}
}
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

if(isset($_POST['Add'])){
	foreach ($_POST as $item){
		$item=trim($item);
	}
	if (empty($_POST['id'])){
					 array_push($error,'id');
					 }

if (empty($_POST['fname'])){
	array_push($error,'fname');
}
if (empty($_POST['lname'])){
	array_push($error,'lname');
}
if (empty($_POST['class'])){
	array_push($error,'class');
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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "assign_subject")) {
  $insertSQL = sprintf("INSERT INTO student_info (student_id, Parent1, parent2, student_Fname, student_Lname,sex, dob, `class`, year_admitted) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['parent1'], "text"),
                       GetSQLValueString($_POST['parent2'], "text"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
					   GetSQLValueString($_POST['sex'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['class'], "int"),
                       GetSQLValueString($_POST['year_admitted'], "int"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) ;
  
  
   if(!$Result1 && mysql_errno()==1062){
	  array_push($error,'id');
	  $message.="ID taken";
	  $user=false;
  }
  elseif(mysql_error()){
	  $message.="There was an error enter the data. Please try again later or contact the DB Administrator";
  }
  else{

  $insertGoTo = "view_students.php?message=insert";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
}
}
mysql_select_db($database_unique, $unique);
$query_class = "SELECT class_id, class_name FROM `class` ORDER BY `class`.class_name";
$class = mysql_query($query_class, $unique) or die(mysql_error());
$row_class = mysql_fetch_assoc($class);
$totalRows_class = mysql_num_rows($class);

mysql_select_db($database_unique, $unique);
$query_parent = "SELECT parent_id,CONCAT_WS(' ', parent_lname, parent_fname) AS name FROM parent WHERE parent.sex='m' ORDER BY parent_lname ASC";
$parent = mysql_query($query_parent, $unique) or die(mysql_error());
$row_parent = mysql_fetch_assoc($parent);
$totalRows_parent = mysql_num_rows($parent);

mysql_select_db($database_unique, $unique);
$query_mothers = "SELECT parent_id,CONCAT_WS(' ', parent_lname, parent_fname) AS name FROM parent WHERE parent.sex='f' ORDER BY parent_lname ASC";
$mothers = mysql_query($query_mothers, $unique) or die(mysql_error());
$row_mothers = mysql_fetch_assoc($mothers);
$totalRows_mothers = mysql_num_rows($mothers);

mysql_select_db($database_unique, $unique);
$query_number = "SELECT COUNT(*) AS no FROM student_info";
$number = mysql_query($query_number, $unique) or die(mysql_error());
$row_number = mysql_fetch_assoc($number);
$totalRows_number = mysql_num_rows($number);
?>
<?php
$zeros="0";
if($row_number['no']<10) $zeros="000"; elseif($row_number['no']>10) $zeros= "00";

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
<body OnLoad="document.assign_subject.fname.focus()">
<div id="content">
		<?php include("includes/header.php"); ?>

	
       <div class="clearnav" >
         <?php include("includes/nav.php"); ?>
       </div>
  <?php include('includes/side_admin.php'); ?>

					
<div id="right">	
			<div id="long_txt_pix">
            
              <h1>Enter Student's information</h1>
              <form action="<?php echo $editFormAction; ?>" name="assign_subject" id="assign_subject" method="POST">
                <table width="95%" border="1">
                  <tr>
                    <td colspan="2" align="center">
					
					<?php // initial code:  if (isset($Result1) && $user)

					if (empty($error))
						$errormessage='';
						else $errormessage=1;
					
					if (isset($Result1) && $errormessage){?>
                      <span class="success">DATA Successful Added</span>
                      <?php }elseif(!empty($error)){ ?><span class="warning">Please correct the errors on the page</span><?php } ?></td>
                  </tr>
                  <tr class="row1">
                    <td align="right">Student's ID</td>
                    <td><label>
                      <input type="text" name="id" id="id" value="<?php if(!empty($error)) echo $_POST['id']; else echo "UBS/2011/".$zeros.($row_number['no']+1); ?>" />
                      <?php if(!empty($error) && in_array('id',$error)){ ?>
                      <span class="warning">ID '
                      <?php if(isset($_POST['id']) && (!empty($_POST['id']))){ echo $_POST['id']; }?>
                      '
 already in Use or ID field empty</span>
                      <?php } ?>
                    </label></td>
                  </tr>
                  <tr class="row2">
                    <td align="right">Student Firstname</td>
                    <td><label>
                      <input type="text" name="fname" id="fname"  value="<?php if(!empty($error)) echo $_POST['fname']; ?>"/>
                      <?php if(!empty($error) && in_array('fname',$error)){ ?>
                      <span class="warning">Enter student's first name</span>
                      <?php } ?>
                    </label></td>
                  </tr>
                  <tr class="row1">
                    <td align="right">Student's Lastname</td>
                    <td><label>
                      <input type="text" name="lname" id="lname" value="<?php if(!empty($error)) echo $_POST['lname']; ?>"/>
                      <?php if(!empty($error) && in_array('lname',$error)){ ?>
                      <span class="warning">
                      Enter student's last name</span>
                      <?php } ?>
                    </label></td>
                  </tr>
                  <tr class="row2">
                    <td align="right">Father's Name</td>
                    <td><label>
                      <select name="parent1" id="parent1">
                        <option value="">--Select Father's Name---</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_parent['parent_id']?>"><?php echo $row_parent['name']?></option>
<?php
} while ($row_parent = mysql_fetch_assoc($parent));
  $rows = mysql_num_rows($parent);
  if($rows > 0) {
      mysql_data_seek($parent, 0);
	  $row_parent = mysql_fetch_assoc($parent);
  }
?>
                      </select>
                    </label></td>
                  </tr>
                  <tr class="row1">
                    <td align="right">Mother's Name</td>
                    <td><select name="parent2" id="parent2">
                      <option value="">---Select Mother's Name---</option>
                      <?php
do {  
?>
                      <option value="<?php echo $row_mothers['parent_id']?>"><?php echo $row_mothers['name']?></option>
                      <?php
} while ($row_mothers = mysql_fetch_assoc($mothers));
  $rows = mysql_num_rows($mothers);
  if($rows > 0) {
      mysql_data_seek($mothers, 0);
	  $row_mothers = mysql_fetch_assoc($mothers);
  }
?>
                    </select></td>
                  </tr>
                  <tr class="row2">
                    <td align="right">Sex</td>
                    <td><label>
                      <input type="radio" name="sex" id="sex" value="m" />
                      Male
                      <input type="radio" name="sex" id="sex" value="f" />
                      Female
                    </label></td>
                  </tr>
                  <tr class="row1">
                    <td align="right">Date of Birth</td>
                    <td><label>
                      <select name="day" id="day"><option value="">Day</option>
					  <?php for ($k=1;$k<=31;$k++){ ?>
                      <option value="<?php if($k<10){ echo '0'.$k;} else echo $k; ?> "><?php if($k<10){ echo '0'.$k; }else echo $k; ?></option> <?php } ?>
                      </select>
                    </label>
                      /
                      <label>
                        <select name="month" id="month">
                          <option>Month</option>
                          <option value="01">Jan</option>
                          <option value="02">Feb</option>
                          <option value="03">Mar</option>
                          <option value="04">Apr</option>
                          <option value="05">May</option>
                          <option value="06">Jun</option>
                          <option value="07">July</option>
                          <option value="08">Aug</option>
                          <option value="09">Sep</option>
                          <option value="10">Oct</option>
                          <option value="11">Nov</option>
                          <option value="12">Dec</option>
                        </select>
                      </label>
                      /
                      <label>
                        <select name="yr" id="yr"><option value="">year</option><?php for($yr=1985;$yr<=date('Y');$yr++)
					{ ?><option value="<?php echo $yr; ?>"><?php echo $yr; ?></option><?php } ?>
                        </select>
<input name="dob" type="hidden" id="dob" value="" />
                      </label></td>
                  </tr>
                  <tr class="row2">
                    <td align="right">Class</td>
                    <td><label>
                      <select name="class" id="class">
                        <option value="">--Select Class--</option>
                        <?php
do {  
?>
                        <option value="<?php echo $row_class['class_id']?>"><?php echo $row_class['class_name']?></option>
                        <?php
} while ($row_class = mysql_fetch_assoc($class));
  $rows = mysql_num_rows($class);
  if($rows > 0) {
      mysql_data_seek($class, 0);
	  $row_class = mysql_fetch_assoc($class);
  }
?>
                      </select>
                      <?php if(!empty($error) && in_array('class',$error)){ ?>
                      <span class="warning">Please Select the student's class</span>
                      <?php } ?>
                    </label></td>
                  </tr>
                  <tr class="row1">
                    <td align="right">year admitted</td>
                    <td><select name="year_admitted" id="year_admitted"><option value="">year Admitted</option><?php for($yr=1985;$yr<=date('Y');$yr++)
					{ ?><option value="<?php echo $yr; ?>"><?php echo $yr; ?></option><?php } ?>
                        </select>
                    </label></td>
                  </tr>
                  <tr class="row2">
                    <td align="right">&nbsp;</td>
                    <td><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" alt="Captcha image" id='captchaimg' />
                      <?php if(!empty($error) && in_array('captcha', $error)){?>
                      <span class="warning">Captcha data doesn't match</span>
                      <?php } ?></td>
                  </tr>
                  <tr class="row1">
                    <td align="right">&nbsp;</td>
                    <td><label for='message3'>Enter the code above here :</label>
                      <br />
                      <input name="6_letters_code" type="text" class="input" id="6_letters_code" />
                      <br />
                      <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small></td>
                  </tr>
                  <tr>
                    <td align="right">&nbsp;</td>
                    <td><label>
                      <input name="Add" type="submit" class="searchbutton" id="Add" value="Submit" />
                    </label></td>
                  </tr>
                </table>
                <input type="hidden" name="MM_insert" value="assign_subject" />
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
mysql_free_result($class);

mysql_free_result($parent);

mysql_free_result($mothers);

mysql_free_result($number);
?>
