<?php
$HideNavigation = 1;
	require_once("includes/header.php");
	$objMeeting = new Meeting();
	
	if(!empty($_REQUEST['playVideo'])){
		$arryMeeting=$objMeeting->getAvailbeVideo($_REQUEST['playVideo']);
	}