<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

$FancyBox = 0;
include ('includes/header.php');

IsCrmSession();
	require_once("../classes/company.class.php");

	$objCompany=new company();

	if($_POST) { 

		if (empty($_POST['Email'])) {
			$_SESSION['mess_forgot'] = ENTER_EMAIL;
		} else{
			$Email = mysql_real_escape_string($_POST['Email']); 

			$ArryUserEmail = $objConfig->CheckUserEmail($Email); 

			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
	

			if(empty($mess) && $CmpID>0){  // Admin 

				/********Connecting to main database*********/
				$UserType = "admin";				
				/*******************************************/
				if($objCompany->ForgotPassword($Email,$CmpID)){
					$_SESSION['mess_forgot'] = FORGOT_SUCC;
					$ValidLogin = 1;
				} else{
					$_SESSION['mess_forgot'] = INVALID_EMAIL; 
				}	
			}else{
				$_SESSION['mess_forgot'] = INVALID_EMAIL; 
			}

		}

		
	}

include ('includes/footer.php');


 ?>