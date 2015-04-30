<div id="main_menu" class="nav-container">
    <ul>
    	<li <?php if($ThisPageName=='dashboard.php' && !isset($_GET['MeetingHistory'])) echo "class=active"?>><a href="<?=$Config['Url']?>/admin/dashboard.php">Meeting List</a></li>
    	<li <?php if(!empty($_GET['MeetingHistory'])) echo "class=active"?>><a href="<?=$Config['Url']?>/admin/dashboard.php?MeetingHistory=All">Meeting History</a></li>
    	<li <?php if($ThisPageName=='recordmeeting.php') echo "class=active"?>><a href="<?=$Config['Url']?>/admin/recordmeeting.php">Recording List</a></li>
    	<?php if($_SESSION['AdminType'] == "admin") { ?>
		  <li><a href="<?=$Config['Url']?>/admin/editCompany.php">Company Settings</a></li>
		  <li class=""><a href="<?=$Config['Url']?>/admin/meeting/viewUser.php">Users</a></li>
		  <?php }?>	
	</ul>
</div>