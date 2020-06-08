<?php 

$your_email ='uniqueblossom007@yahoo.co.uk';// <<=== update to your email address

session_start();
$errors = '';
$name = '';
$visitor_email = '';
$user_message = '';



include("submit_comment.php");

/*
if(isset($_POST['submit']))
{
	
	$name = trim($_POST['name']);
	$visitor_email = trim($_POST['email']);
	$user_message = trim($_POST['message']);
	///------------Do Validations-------------
	if(empty($name)||empty($visitor_email))
	{
		$errors .= "\n Name and Email are required fields. ";	
	}
	if(empty($user_message)){
		$error.="Please enter your Message";
	}
	if(IsInjected($visitor_email))
	{
		$errors .= "\n Bad email value!";
	}
	if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$errors .= "\n The captcha code does not match!";
	}
	
	if(empty($errors))
	{
		
		

  $insertSQL = sprintf("INSERT INTO contact (contact_name, contact_email, contact_text) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['message'], "text"));

  mysql_select_db($database_unique, $unique);
  $Result1 = mysql_query($insertSQL, $unique) or die(mysql_error());

		//send the email
	/*	$to = $your_email;
		$subject="New form submission";
		$from = $your_email;
		$ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
		
		$body = "A user  $name submitted the contact form:\n".
		"Name: $name\n".
		"Email: $visitor_email \n".
		"Message: \n ".
		"$user_message\n".
		"IP: $ip\n";	
		
		$headers = "From: $from \r\n";
		$headers .= "Reply-To: $visitor_email \r\n";
		
		mail($to, $subject, $body,$headers);
		
		//header('Location: thank-you.html');

		
		}
}
*/
// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
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
<script language="JavaScript" src="scripts/gen_validatorv31.js" type="text/javascript"></script>	
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
  <div id="form"><form action="" method="post" enctype="multipart/form-data" name="admission" id="admission">
    <div id="left_home"><img src="images/ubs,-abuja.jpg" alt="" width="230" height="243" /></div>
    <div id="rl">
      <h1>School Address</h1>
      <blockquote>
        <p><span class="open">&nbsp;</span>Plot 2251, Tangayika Street, Behind Indian High Commission, Off Ibrahim Babagida Boulevard, Maitama, Abuja.</p>
        <p>Telephones:</p>
        <p>+234-803-376-8898, +234-704-211-3897<br />
          +234-703-3958687, +234-803-599-6272</p>
        <p>Emails:<br />
          info@uniqueblossomschools.com<br />
          admission@uniqueblossomschools.com <span class="close"></span> <br />
        </p>
      </blockquote>
    </div>

   <p class="clr"></p>
    

<form 
action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name="contact_form" id="contact_form"> 
<p>
<span class="clr"></span>
<p>.
<table width="70%" border="0" align="center">
  <tr class="row1">
    <td colspan="2" align="center">
    <h1> Contact Form</h1>
  
    <p>Please ensure that field marked * must be filled.</p>
    <?php if(!empty($error)){ 
			echo "<span class=warning>Please ".$error."</span>" ;}
			else if ($success){
			echo "<span clas=success>Thank you! Your comment has been received</span>" ;
			}?>
<div id='contact_form_errorloc' class='warning'></div>
<div id='contact_form_errorloc' class='err'></div></td>
    </tr>
  <tr class="row1">
    <td width="29%" align="right"><label for='name'>Name: </label></td>
    <td width="71%"><input name="name" type="text" class="input" value='<?php echo htmlentities($name) ?>' /></td>
  </tr>
  <tr class="row2">
    <td align="right"><p>
      <label for='email2'>Email: </label>
    </p></td>
    <td><input name="email" type="text" class="input" value='<?php echo htmlentities($visitor_email) ?>' /></td>
  </tr>
  <tr class="row1">
    <td align="right"><label for='message2'>Message:</label></td>
    <td><textarea name="comment" cols=30 rows=8 class="row1" id="comment"><?php echo htmlentities($user_message) ?></textarea></td>
  </tr>
  <tr class="row2">
    <td align="right">&nbsp;</td>
    <td><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' /></td>
  </tr>
  <tr class="row1">
    <td align="right">&nbsp;</td>
    <td><label for='message3'>Enter the code above here :</label>
      <br />
      <input name="6_letters_code" type="text" class="input" id="6_letters_code" />
      <br />
      <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small></td>
  </tr>
  <tr class="row2">
    <td align="right">&nbsp;</td>
    <td><input name='submit' type="submit" class="input" id="submit" value="Submit" /></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
<script language="JavaScript">
// Code for validating the form
// Visit http://www.javascript-coder.com/html-form/javascript-form-validation.phtml
// for details
var frmvalidator  = new Validator("contact_form");
//remove the following two lines if you like error message box popups
frmvalidator.EnableOnPageErrorDisplaySingleBox();
frmvalidator.EnableMsgsTogether();

frmvalidator.addValidation("name","req","Please provide your name"); 
frmvalidator.addValidation("email","req","Please provide your email"); 
frmvalidator.addValidation("email","email","Please enter a valid email address"); 
</script>
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
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