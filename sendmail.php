<?php
//require_once "Mail.php";
$sentmessage=false;

/* INSTRUCTIONS:
(1) Change username@YourDomain.com to your valid email address that is hosted on our server. Our Email server requiries SMTP Authentication and will not send emails on behalf of random people, so this is why the Sender of the email must match EXACTLY the email address that is used for SMTP authentication.
(2) Put the password for your email in the specified location below.  Modify only the following 4 lines of code.  
(3) For $host replace "smtp.YourDomain.com" with your own domain's SMTP address.
(4) That is all. Upload it to your website and enjoy! */

$from = "CONTACT FORM <info@uniqueblossomschools.com>";
$to = "CEO UNIQUEBLOSSOM <uniqueblossom2007@yahoo.co.uk>";
$username = "uniquebl@uniqueblossomschools.com";
$password = "A1234?5";
$host = "smtp.uniqueblossomschools.com";  // replace this with your domain's SMTP address.

/*
$email = $_POST['email'] ;
$name = $_POST['name'] ;
$number=$_POST['number'];
$message = $_POST['message'];
$message .= "\n\n ";
$message .= $name;
$subject = $_POST['Subject'];

The message is assembled for sending */
if(isset($_POST['send']) && in_array('send',$_POST)){
	
	
		
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
	

$message = "\n\n ";
$message .= "Name ".$name . "\n";
$message .= "Email: ". $email."\n";
$message .= "Number: ".$number. "\n";
$message .= "Message: ".$comment. "\n";

if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$missing = "Captcha";
	}
	

if(isset($missing) && $missing=false){


$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $message);

if (PEAR::isError($mail)) 
{
  echo("<p>" . $mail->getMessage() . "</p>");
} 
else 
{
	/*This is were you redirect your customers after he/she feels out the form.*/
	$sentmessage=true;
	unset($missing);
 }
}
}

?>

