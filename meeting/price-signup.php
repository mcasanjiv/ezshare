<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

$FancyBox = 0;
include ('includes/header.php');

require_once("../classes/company.class.php");
	require_once("../classes/admin.class.php");

	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../includes/browser_detection.php");
	$objConfig=new admin();
	$objCompany=new company();
	$objUser=new user();
	
				

include ('includes/footer.php');
 ?>