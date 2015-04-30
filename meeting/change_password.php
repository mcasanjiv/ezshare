<?php
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');

require_once("../classes/company.class.php");
require_once("../classes/user.class.php");
$objUser=new user();
$objCompany=new company();

if ($_POST) {
	//CleanPost();

	if (empty($_POST['OldPassword'])) {
		$_SESSION['mess_conf'] = ENTER_OLD_PASSWORD;
	}else if(empty($_POST['Password'])) {
		$_SESSION['mess_conf'] = ENTER_NEW_PASSWORD;
	} else if (empty($_POST['ConfirmPassword'])) {
		$_SESSION['mess_conf'] = ENTER_CONFIRM_PASSWORD;
	} else if ($_POST['Password'] != $_POST['ConfirmPassword']) {
		$_SESSION['mess_conf'] = CONFIRM_PASSWORD_NOT_MATCH;
	} else if (md5($_POST['OldPassword']) != $_SESSION['CrmAdminPassword']) {
		$_SESSION['mess_conf'] = WRONG_OLD_PASSWORD;
	} else{

		if($objCompany->ChangePassword($_SESSION['CrmUserID'],$_POST['Password'])){
			$_SESSION['CrmAdminPassword'] = md5($_POST['Password']);
			$_SESSION['mess_conf'] = PASSWORD_CHANGED;
		} else{
			$_SESSION['mess_conf'] = PASSWORD_NOT_UPDATED;
		}



	}

	header("location: change_password.php");
	exit;

}
include ('includes/footer.php');
?>



	