
<div id="top">
			<p><a href="index.php">Home</a><a href="admin.php">Admin</a><a href="parents.php">Parents Home</a>
            <?php if(isset($_SESSION['MM_Username']) && ($_SESSION['MM_Username'])){?>
            <a href="logout.php">Logout</a>
            <?php } else { ?>
 <a href="login.php">Sign in </a> 
<?php } ?></p>
			<form id="search_engine" method="post" action="." accept-charset="UTF-8">
				<p><input class="searchfield" name="search_query" type="text" id="keywords" value="Search Keywords" onfocus="document.forms['search_engine'].keywords.value='';" onblur="if (document.forms['search_engine'].keywords.value == '') document.forms['search_engine'].keywords.value='Search Keywords';" />
				<input class="searchbutton" name="submit" type="submit" value="Search" /></p>
			</form>
		</div>
	
  <div id="logo">
			<h1><a href="#">Unique Blossom Schools, Maitama, Abuja.</a></h1>
			<p>Leadership and Knowledge</p>
</div>
