<ul class="userlink">
<?php if(!empty($_SESSION['CrmDisplayName'])){?>

	<li class="login">Welcome : <i><?php echo $_SESSION['CrmDisplayName']; ?>
	
	</li>
	
	<li class="login"><a href="logout.php">Log Out</a>
	</li>
	<li class="login"><a href="dashboard.php">Manage Account</a>
	</li>
	<?php }else{?>

	<!--<li class="login"><a href="../admin/dashboard.php" target="_blank">Application
			Login</a>
	</li>
	-->
	<li class="login"><a href="join-meeting.php">JOIN MEETING</a></li>
	<li class="login"><a href="register.php">Sign Up</a>
	<li class="login"><a href="user.php">Account Login</a></li>
	<?php }?>




</ul>
