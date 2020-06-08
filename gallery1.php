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
    
    
    <link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		
		<style type="text/css" media="screen">
			* {
	padding: 0;
	text-align: center;
}
			
			
		/*	
			body {
				background: #282828;
				font: 62.5%/1.2 Arial, Verdana, Sans-Serif;
				padding: 0 20px;
			}
			
		h1 { font-family: Georgia; font-style: italic; margin-bottom: 10px; }
			
			h2 {
				font-family: Georgia;
				font-style: italic;
				margin: 25px 0 5px 0;
			}
			
			p { font-size: 1.2em; }
			
			
			*/
			
			#main {
	background: #fff;
	width: 940px;
	margin-top: 0;
	margin-right: auto;
	margin-bottom: 0;
	margin-left: auto;
	padding-top: 40px;
	padding-right: 10px;
	padding-bottom: 30px;
	padding-left: 30px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
			}
			
			ul li {
	display: inline;
	margin-right: 0px;
	margin-left: 5px;
	margin-bottom: 3px;
	margin-top: 2px;
	float: left;
}
			
			.wide {
				border-bottom: 1px #000 solid;
				width: 4000px;
			}
			
			.fleft { float: left; margin: 0 20px 0 0; }
			
			.cboth { clear: both; }
			
			
		h2 {
	margin-top: 8px;
	margin-bottom: 8px;
}
        #main .gallery.clearfix li a img {
	float: left;
	margin: 2px;
	padding: 2px;
	border: 1px solid #CCC;
}
        #main .heading1 {
	margin-top: 20px;
	color: #600;
	margin-bottom: 10px;
}
        #main .heading2 {
	color: #F06;
	margin: 10px;
	font-size: 14px;
	font-style: italic;
	font-family: Georgia, "Times New Roman", Times, serif;
}
        </style>
    
    
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
        
        
	
			<h2 class="heading2">Cultural Day, 2014</h2>
			<ul class="gallery clearfix">
		
               
        
         <?php
					for ($z=1; $z<=4; $z++){
						
						if($z<10) $z="0".$z; 
						
					//	echo "images/gallery/output/cultural2013_".$z.".jpg";
						
									
					?>
                    <li><a href='<?php echo "images/gallery/cultural2013/cultural2013_".$z.".JPG"; ?>' rel="prettyPhoto[gallery1]" title="Cultural Day, 2013"><img src='<?php echo "images/gallery/cultural2013/thumbs/cultural2013_".$z.".JPG'"; ?>'alt="Cultural Day, 2013" /></a></li>
                    
                    <?php	
					}
					?>


			</ul>
            
            <p class="cboth">
			<h2 class="heading2">Random Images</h2>
			<ul class="gallery clearfix">
                  <?php
					for ($z=1; $z<=9; $z++){
						
					//	if($z<10) $z="0".$z; 
						
					//	echo "images/gallery/output/cultural2013_".$z.".jpg";
						
									
					?>
                    <li><a href='<?php echo "images/gallery/random/random".$z.".JPG"; ?>' rel="prettyPhoto[gallery1]" title="Random Picutres"><img src='<?php echo "images/gallery/random/thumbs/random".$z.".JPG'"; ?>'  alt="Random Pictures" /></a></li>
                    
                    <?php	
					}
					?>
				
        
       
		  </ul>
          
          <p class="cboth"></p>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				$("area[rel^='prettyPhoto']").prettyPhoto();
				
				$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
				$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:1000000, hideflash: true});
		
				$("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
					custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
					changepicturecallback: function(){ initialize(); }
				});

				$("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
					custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
					changepicturecallback: function(){ _bsap.exec(); }
				});
			});
			</script>
	
</body>
</html>