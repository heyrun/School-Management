<?php session_start(); ?>
<?php require_once('Connections/unique.php'); ?>
<?php
include('sendmail.php');

if (array_key_exists('submit',$_POST)){
	
// remove escape characters from POST array
if (PHP_VERSION < 6 && get_magic_quotes_gpc()) {
  function stripslashes_deep($value) {
    $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    return $value;
    }
  $_POST = array_map('stripslashes_deep', $_POST);
  }// remove escape characters from POST array
if (PHP_VERSION < 6 && get_magic_quotes_gpc()) {
  function stripslashes_deep($value) {
    $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    return $value;
    }
  $_POST = array_map('stripslashes_deep', $_POST);
  }
  
  //list of expected fields
  $expected=array('name','number','email','subject','comment');
  $required=array('name','email','subject','comment');
  $missing=array();
	
	
	
$to="amaxo4u@yahoo.com";
$subject="Feedback from UBS' website";

// process the $_POST variables
foreach ($_POST as $key=>$value){
	// assign temporary variable and strip whitespce if not an array
	$temp=is_array($value)? $value: trim($value);
	// if empty and required, add to $missing array
	if(empty($temp) && in_array($key,$required)){
		array_push($missing, $key);
	}
	elseif (in_array($key, $expected)){
		//otherwise assign to a variable of the same name as $key
		${$key}=$temp;
		}}
if (empty($missing)){
		  //build message



$message="Name: $name\r\n\r\n";
if (!empty($_POST['number'])){
$message.="Phone Number: $number\r\n\r\n";
}
$message.="Email: $email\r\n\r\n";
$message.="Subject: $subject\r\n\r\n";
$message.="Message: $message\r\n\r\n";


$message=wordwrap($message, 70);
}}// remember to unset the $missing array
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
  <?php include("includes/side1.php") ?>

  <div id="line"></div>
		
		<div id="left_home"><img src="images/ubs,-abuja.jpg" alt="" width="230" height="243" /></div>
		<?php include('includes/side2.php'); ?>
		<div id="right">	
			<div id="rl">
            
              <h1>School Address</h1>
          
				<blockquote>
          <p><span class="open">&nbsp;</span>Plot 2251, Tangayika Street, Behind Indian High Commission, Off Ibrahim Babagida Boulevard, Maitama, Abuja.</p>
          <p>Telephones:</p>
          <p>+234-803-376-8898, +234-704-211-3897<br />
            +234-703-3958687, +234-803-599-6272</p>
          <p>Emails:<br />
            info@uniqueblossomschools.com<br />
            admission@uniqueblossomschools.com
          <span class="close"></span>  <br />
          </p>
</blockquote>
		  </div>
			<div id="form">
			  <h1>Enquiry/Contact Form		      </h1>
			  <p>Do you have a question, comment, suggestion or news tip to pass along to our school? If so, fill out the form below: We will be glad to answer any of your questions or suggestions. Thanks.
			  </p>
              <?php if (isset($sentmessage) && (!$sentmessage)){ ?>
			  <span class="warning">Sorry, But there was an error sending your mail </span> <?php } else { ?> <span>Your Message has been received. Thank you</span><?php } ?>
			  <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data" name="contact">
			  <table width="100%" border="0" align="center">
			    <tr>
			      <td width="34%" height="18" align="right">Name*</td>
			      <td width="66%"><label>
			        <input type="text" name="name" id="name" />
			        <?php if (isset($missing) && in_array('name',$missing)){
					  ?>
			        <span class="warning">Please enter your Name</span>
			        <?php } ?>
			      </label></td>
		        </tr>
			    <tr>
			      <td align="right">Number</td>
			      <td><label>
			        <input type="text" name="number" id="number" />
		          </label></td>
		        </tr>
			    <tr>
			      <td align="right">Email*</td>
			      <td><label>
			        <input type="text" name="email" id="email" />
			        <?php if (isset($missing) && in_array('email',$missing)){
					  ?>
                    <span class="warning">Please enter your Email Address</span>
                    <?php } ?>
                  </label></td>
		        </tr>
			    <tr>
			      <td align="right">Subject*</td>
			      <td><label>
			        <select name="subject" id="subject">
			          <option value="">Select a subject</option>
			          <option value="enquiry">Enquiry</option>
			          <option value="comments">Comments</option>
			          <option value="suggestion">Suggestions</option>
		            </select>
			        <?php if (isset($missing) && in_array('subject',$missing)){
					  ?>
			        <span class="warning">Please Select a Subject</span>
                    <?php } ?>
                  </label></td>
		        </tr>
			    <tr>
			      <td align="right">Message*</td>
			      <td><label>
			        <textarea name="message" cols="45" rows="5" class="searchfield" id="message"></textarea>
			        <br />
			        <?php if (isset($missing) && in_array('message',$missing)){
					  ?>
                    <span class="warning">Please enter your Comment</span>
                    <?php } ?>
                  </label></td>
		        </tr>
			    <tr>
			      <td align="right">&nbsp;</td>
			      <td><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' />
                  <?php if (isset($error) && array_key_exists('captcha', $error)){ ?> <span class="warning"> Captcha do no match</span><?php } ?></td>
		        </tr>
			    <tr>
			      <td align="right">&nbsp;</td>
			      <td><p>
			        <label for='message'>
  Enter the code above here :</label><br>
<input id="6_letters_code" name="6_letters_code" type="text"><br>
<small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small></p></td>
		        </tr>
			    <tr>
			      <td align="right">&nbsp;</td>
			      <td><label>
			        <input name="submit" type="submit" class="searchbutton" id="submit" value="Submit" />
		          </label></td>
		        </tr>
		      </table>
			  <input type="hidden" name="MM_insert" value="contact" />
              
              </form>
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
<script language='JavaScript' type='text/javascript'>
function refreshCaptcha()
{
	var img = document.images['captchaimg'];
	img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
}
</script>
</html>