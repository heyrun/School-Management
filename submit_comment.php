<?PHP
/* $host="XpertProCombined";
$user="heyrun";
$password="Journey-45";
$db="uniqueblossom";
$connect=mysql_connect($host,$user,$password) or die("could not connect to database".mysql_error());
$use_db=mysql_select_db($db,$connect);
*/ ?>
<?php
session_start();
$error="";
$success=false;
$location=$_SERVER['PHP_SELF'];


if (isset($_POST['submit'])){
	$name=trim($_POST['name']);
	$email=trim($_POST['email']);
	$comment=trim($_POST['comment']);
	
	
	
		if(empty($name)){
			$error.="Enter your Name <br>";
							   }
		if (empty($email) || (!ereg("^.+@.+\.com$",$email))){
				$error.="Enter your correct Email <br>";
																   }
		if (empty($comment)){
		$error.="Type in your comment <br>";
										}
			
			if(empty($_SESSION['6_letters_code'] ) ||
	  strcasecmp($_SESSION['6_letters_code'], $_POST['6_letters_code']) != 0)
	{
	//Note: the captcha code is compared case insensitively.
	//if you want case sensitive match, update the check above to
	// strcmp()
		$error.= "The captcha code does not match!";
	}
			
										
				if(empty($error)){
					
						$name="'".$name."'";
						$email="'".$email."'";
						$comment="'".addslashes($comment)."'";
						$day=date("d");
						$month=date("m");
						$year=date("Y");
						$today="'".$year."-".$month."-".$day."'";
						
					$query="insert into contact (contact_name,contact_email,contact_text,date) values($name,$email,$comment,$today)";
					$insert=mysql_query($query) or die("could not submit comment".mysql_error());
						$success=true;
					}
}
?>