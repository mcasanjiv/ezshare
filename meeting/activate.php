<?php
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

$FancyBox = 0;
include ('includes/header.php');

IsCrmSession();
require_once("../classes/cmp.class.php");
	require_once("../classes/admin.class.php");	
    $objCmp=new cmp();
    $objConfig=new admin();	
	 if(!empty($_GET['cmp'])) {
		//print_r($arryCompany);exit;
	    $arryCompany['Email'] = base64_decode($_GET['cmp']);
		$Password = substr(md5(rand(100,10000)),0,8);
	    $arryCompany['Password'] = $Password;
		if($objConfig->isCmpEmailExists($arryCompany['Email'],'')){
			
			$ReturnFlag = $objCmp->ActiveCompany($arryCompany); 
		}else{				
			$_SESSION['mess_act'] = 'Invalid Email';			
		}				
				
	
		header("Location:activate.php?activated=".$ReturnFlag);
		exit;
			
			
	}else{
		$_SESSION['mess_act'] = 'Invalid Email';
	}
	

include ('includes/footer.php');