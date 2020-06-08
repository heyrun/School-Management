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
  <div id="right">
    <div id="form"><form action="" method="post" enctype="multipart/form-data" name="admission" id="admission">
    <h1>Online Admission Form
      </h1>
    <p>&nbsp;</p>
    <p>Please ensure that field marked * must be filled.</p>
    <table width="100%" border="0">
      <tr class="row1">
        <td width="31%" align="right">Pupil's Full Name (Surname First)*</td>
        <td width="69%"><label>
          <input name="student_name" type="text" class="input" id="student_name" />
        </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Sex*</td>
        <td><label>
          <input type="radio" name="sex" id="sex" value="male" />
          </label>
          Male 
          <label>
            <input type="radio" name="sex" id="sex" value="female" />
            </label>
          Female</td>
        </tr>
      <tr class="row1">
        <td align="right">Home Address*</td>
        <td><label>
          <input name="address" type="text" class="input" id="address" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Father's Full Name *</td>
        <td><label>
          <input name="f_name" type="text" class="input" id="f_name" />
          (Surname First)</label></td>
        </tr>
      <tr class="row1">
        <td align="right">Father's Profession*</td>
        <td><label>
          <input name="f_profession" type="text" class="input" id="f_profession" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Father's Office Address*</td>
        <td><label>
          <input name="f_Office_Address" type="text" class="input" id="f_Office_Address" />
          </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Father's Phone Numbers </td>
        <td><label>
          <input name="f_office_number" type="text" class="input" id="f_office_number" value="Office Number"
          onfocus="document.forms['admission'].f_office_number.value='';" onblur="if (document.forms['admission'].f_office_number.value == '') document.forms['admission'].f_office_number.value='Office Number';"/>
          
          <input name="f_home_number" type="text" class="input" id="f_home_number" 
          value="Home Number"
          onfocus="document.forms['admission'].f_home_number.value='';" onblur="if (document.forms['admission'].f_home_number.value == '') document.forms['admission'].f_home_number.value='Home Number';" />
          
          <input name="f_mobile_number" type="text" class="input" id="f_mobile_number"  value="Mobile Number"
          onfocus="document.forms['admission'].f_mobile_number.value='';" onblur="if (document.forms['admission'].f_mobile_number.value == '') document.forms['admission'].f_mobile_number.value='Mobile Number';"/>
        </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Mother's Full Name *</td>
        <td><label>
          <input name="M_name" type="text" class="input" id="M_name" />
          (Surname First)</label></td>
      </tr>
      <tr class="row1">
        <td align="right">Mother's Profession* </td>
        <td><label>
          <input name="m_profession" type="text" class="input" id="m_profession" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Mother's Office Address*</td>
        <td><label>
          <input name="m_office_address" type="text" class="input" id="m_office_address" />
          </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Mother's Phone Number (Office)</td>
        <td><input name="m_office_number" type="text" class="input" id="m_office_number" value="Office Number"
          onfocus="document.forms['admission'].m_office_number.value='';" onblur="if (document.forms['admission'].m_office_number.value == '') document.forms['admission'].m_office_number.value='Office Number';"/>
          <input name="m_home_number" type="text" class="input" id="m_home_number" 
          value="Home Number"
          onfocus="document.forms['admission'].m_home_number.value='';" onblur="if (document.forms['admission'].m_home_number.value == '') document.forms['admission'].m_home_number.value='Home Number';" />
          <input name="m_mobile_number" type="text" class="input" id="m_mobile_number"  value="Mobile Number"
          onfocus="document.forms['admission'].m_mobile_number.value='';" onblur="if (document.forms['admission'].m_mobile_number.value == '') document.forms['admission'].m_mobile_number.value='Mobile Number';"/></td>
        </tr>
      <tr class="row2">
        <td align="right">Pupil's state of origin*</td>
        <td><label>
          <input name="state_of_origin" type="text" class="input" id="state_of_origin" />
          </label></td>
      </tr>
      <tr class="row1">
        <td align="right">Pupil's Previous School</td>
        <td><label>
          <input name="previous_school" type="text" class="input" id="previous_school" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Pupil's previous class </td>
        <td><label>
          <input name="previous_class" type="text" class="input" id="previous_class" />
          </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Pupil's present class* </td>
        <td><label>
          <input name="present_class" type="text" class="input" id="present_class" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Religion*</td>
        <td><label>
          <input name="religion" type="text" class="input" id="religion" />
          </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Pupil's physician</td>
        <td><label>
          <input name="physician_name" type="text" class="input" id="physician_name" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right" class="row2">Address of Physician</td>
        <td><label>
          <input name="physician_address" type="text" class="input" id="physician_address" />
          </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Phone Number of Physician</td>
        <td><input name="physician_number" type="text" class="input" id="physician_number" /></td>
        </tr>
      <tr class="row2">
        <td align="right">Any known Allergy or Special Needs*</td>
        <td><label>
          <input name="allergy" type="text" class="input" id="allergy" />
        </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Pupil's favourite game</td>
        <td><label>
          <input name="fav_game" type="text" class="input" id="fav_game" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Favourite Toys</td>
        <td><label>
          <input name="fav_toy" type="text" class="input" id="fav_toy" />
          </label></td>
        </tr>
      <tr class="row1">
        <td align="right">Blood group*</td>
        <td><label>
          <input name="blood_group" type="text" class="input" id="blood_group" />
          </label></td>
        </tr>
      <tr class="row2">
        <td align="right">Genotype*</td>
        <td><label>
          <input name="genotype" type="text" class="input" id="genotype" />
          </label></td>
        </tr>
      <tr align="center" class="row1">
        <td>&nbsp;</td>
        <td align="left"><img src="captcha_code_file.php?rand=<?php echo rand(); ?>" id='captchaimg' /></td>
      </tr>
      <tr align="center" class="row1">
        <td>&nbsp;</td>
        <td align="left"><label for='message3'>Enter the code above here :</label>
          <br />
          <input name="6_letters_code" type="text" class="input" id="6_letters_code" />
          <br />
          <small>Can't read the image? click <a href='javascript: refreshCaptcha();'>here</a> to refresh</small></td>
      </tr>
      <tr align="center" class="row1">
        <td colspan="2"><label>
          <input type="checkbox" name="checkbox" id="checkbox" />
          I agree to the school's <a href="terms.php">terms and services</a> </label></td>
        </tr>
      <tr class="row2">
        <td align="right">&nbsp;</td>
        <td><label>
          <input name="button" type="submit" class="searchbutton" id="button" value="Submit" />
          </label></td>
        </tr>
      </table>
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