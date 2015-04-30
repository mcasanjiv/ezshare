<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

$FancyBox = 0;
include ('includes/header.php');

IsCrmSession();
require_once("../classes/region.class.php");
require_once("../classes/company.class.php");
require_once("../classes/cmp.class.php");
require_once("../classes/admin.class.php");
$objConfig=new admin();
$objCompany=new company();
$objRegion=new region();
$objCmp=new cmp();
$arryCountry = $objRegion->getCountry('','');


if ($_POST){
	
	if($objConfig->isCmpEmailExists($_POST['Email'],'')){
		$_SESSION['mess_company'] = EMAIL_ALREADY_REGISTERED;
	}else if($objCompany->isDisplayNameExists($_POST['DisplayName'],'')){
		$_SESSION['mess_company'] = DISPLAY_ALREADY_REGISTERED;
	}else{
		$_POST['Status']=1;
		$_POST['Department'] = 5;
		$_POST["Timezone"]= '-04:00';
		$_POST["DateFormat"]= 'j M, Y';
		$_POST["currency_id"]= '9';
		
		// need to get from packages
		$arrayPkj=$objCmp->getPackagesByName('TRIAL');
		
		/*****************/
		$packDataUnserialize=unserialize($arrayPkj[0]['features']);
        $packageFeatureId = implode(",", $packDataUnserialize);		
		/*****************/
				
		//$_POST["MaxUser"]= $arrayPkj[0]['allow_users'];
		$_POST['PaymentPlan'] = $arrayPkj[0]['name'];
		$_POST['StorageLimit'] = $arrayPkj[0]['space'];
		$_POST['StorageLimitUnit'] = 'GB';
		/**************************/
		$NumMonth = 1;
		$arryDate = explode("-",date('Y-m-d'));
		list($year, $month, $day) = $arryDate;
		$TempDate  = mktime(0, 0, 0, $month+$NumMonth , $day, $year);
		$ExpiryDate = date("Y-m-d",$TempDate);
	    $_POST["ExpiryDate"]= $ExpiryDate;
		/***********************/
	   
		$CmpID = $objCompany->AddCompany($_POST);
		$objCmp->SendActivationMail($CmpID);
		
		
		/*************************/
		$_SESSION['mess_company'] = COMPANY_REG;
		$AddDatabase = 1;
		$UpdateAdminMenu = 1;
		
		/************************/
		if($AddDatabase == 1){
			$DbName = $objCompany->AddDatabse($_POST['DisplayName']); 
			if(!empty($DbName)){
				ImportDatabase($Config['DbHost'],$DbName,$Config['DbUser'],$Config['DbPassword'],'../superadmin/sql/erp_company.sql');
			}
		}   
		
		/************************/
		if($UpdateAdminMenu == 1){	
			
			$Config['DbName'] = $DbName;
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
						
			$objCompany->UpdateAdminModules($CmpID,$_POST['Department']);	

			//$objCompany->UpdateAdminSubModules($CmpID,$_POST['Department'],strtolower($_POST['PaymentPlan']));
			$objCmp->UpdateAdminSubModules($CmpID,5,strtolower($_POST['PaymentPlan']),$packageFeatureId);				
		}
		/************************/
		
		
		
		
	}
		
	header("Location:register.php");
		exit;
}

include ('includes/footer.php');
?>

