<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "login.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<div id="shortnews">
  <h2><a href="pwd.php">Change Log in Password</a></h2>

    <?php
	if ($_SESSION['MM_UserGroup']==2){ ?>

  <h2><a href="enter_class.php">Enter Students' Results</a></h2>
  <h2><a href="enter_skills.php">Enter Students' Skills</a></h2>
  <h2><a href="enter_report_comment.php">Enter Result Comments</a></h2>
  <h2><a href="view_class_student.php">View Students's Report</a></h2>
  <h2><a href="enter_attendance.php">Enter Attendance<br />
  </a>
 
    <?php }
	
	if ($_SESSION['MM_UserGroup']==3){ ?>
  </h2>
  <h2><a href="add_user.php">Add User Login details</a></h2>
  <h2><a href="assign-subjects.php">Assign Subjects</a></h2>
  <h2><a href="#">View Contact Messages </a></h2>
  <h2><a href="enter_students.php">Enter Student Info</a></h2>
  <h2><a href="enter_parents_details.php">Enter Parents Info</a></h2>
  <h2><a href="Assign-class.php">Assign class teachers</a></h2>
   <h2><a href="enter_staff.php">Enter Staff Details</a></h2>
  <h2><a href="view_parents.php">View Parents Info</a></h2>
   <h2><a href="view_students.php">View Students Info</a></h2>
  <h2> <a href="view_class_ADMIN.php">View Pupils Results</a></h2>
  <h2><a href="view_class_ADMIN.php">Enter Students' Comments</a></h2>
  <h2> <a href="reports/father.php">Father</a></h2>
 <h2> <a href="reports/students by class.php">students</a></h2>
    <?php }
	?>


</div>
