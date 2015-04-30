<?  ob_start();
	session_start();
	//error_reporting(0);

	$Config['AdminDir']  = 'admin';
	////////////////////////////////
	$Prefix = "../";  $MainPrefix = ""; $DeptFolder = "";
	$PageArry = explode("/",$_SERVER['PHP_SELF']);
	$revPageArray = array_reverse($PageArry);
	
	/*if(!empty($PageArry[4])){
		$Prefix = "../../"; $MainPrefix = "../"; $Config['DeptFolder'] = $PageArry[3];
		require_once("../language/english.php");
	}*/

		
	if($revPageArray[1]!=$Config['AdminDir']){
		$Prefix = "../../"; $MainPrefix = "../"; $Config['DeptFolder'] = $revPageArray[1];
		require_once("../language/english.php");		
	}

	//////////////////////////////// 
	require_once($Prefix."includes/config.php");
	require_once($Prefix."includes/language.php");
	require_once($Prefix."includes/function.php");
	require_once($Prefix."classes/dbClass.php");
	require_once($Prefix."classes/cms.class.php");	
	require_once($Prefix."classes/admin.class.php");	
	require_once($Prefix."classes/company.class.php");
	require_once($Prefix."classes/region.class.php");
	require_once($Prefix."classes/configure.class.php");
	require_once($Prefix."classes/pager.cls.php");
	require_once($Prefix."classes/MyMailer.php");	
	require_once("language/english.php");
	
	require_once($Prefix."includes/bbb_config.php");
    require_once($Prefix."includes/bbb-api.php");
    require_once($Prefix."classes/meeting.class.php");

	////////////////////////////////
	////////////////////////////////
	

	(!$_GET['curP'])?($_GET['curP']=1):(""); 
	(!$_GET['sortby'])?($_GET['sortby']=""):(""); 
	(!$_GET['key'])?($_GET['key']=""):(""); 



	(!empty($_GET['locationID']))?($_SESSION['locationID']=$_GET['locationID']):(""); 
	(!$_SESSION['locationID'])?($_SESSION['locationID']=1):(""); 

	
	
	$objConfig=new admin();	
	$objPager=new pager();
	$arrayConfig = $objConfig->GetSiteSettings(1);	

	
	if($arrayConfig[0]['IpBlock']=='1'){
		if(!$objConfig->CheckDet()){
			header('location:http://www.google.com');
			exit;
		}
	}


	if(!empty($_SESSION['AdminID'])){
		CleanGet();

		// Geting data from main database
		$objCompany=new company(); 
		$objRegion=new region();
		

		$arryCompany = $objCompany->GetCompanyBrief($_SESSION['CmpID']);
		$arryCountry = $objRegion->getCountry('','');

		$Config['SiteName']  = stripslashes($arryCompany[0]['CompanyName']);	
		$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
		$Config['CmpDepartment'] = $arryCompany[0]['Department'];

		//$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']);
		$Config['DateFormat'] = $arryCompany[0]['DateFormat'];  $_SESSION['DateFormat']= $Config['DateFormat'];
		$Config['TimeFormat'] = ($arryCompany[0]['TimeFormat']!='')?($arryCompany[0]['TimeFormat']):("H:i:s");  
		$_SESSION['TimeFormat']= $Config['TimeFormat'];


		
		if(!empty($_SESSION['MaxAllowedUser'])){ //coming from license key
			$MaxAllowedUser = $_SESSION['MaxAllowedUser'];
		}else{
			$MaxAllowedUser = ($arryCompany[0]['MaxUser']>0)?($arryCompany[0]['MaxUser']):(1000);
		}
		$Config['TrackInventory'] = $arryCompany[0]['TrackInventory'];
		/*********StorageLimit************/
		if($arryCompany[0]['StorageLimit']>0){ //GB

			if($arryCompany[0]['StorageLimitUnit']=="TB"){
				$StorageLimit = ($arryCompany[0]['StorageLimit']*1024*1024*1024); //KB
			}else{
				$StorageLimit = ($arryCompany[0]['StorageLimit']*1024*1024); //KB
			}

			if($arryCompany[0]['Storage']>=$StorageLimit){ //KB Check
		 		$Config['StorageLimitError'] = str_replace("[StorageLimit]",$arryCompany[0]['StorageLimit']." ".$arryCompany[0]['StorageLimitUnit'],UPLOAD_ERROR_STORAGE_LIMIT);	
			}
		}
		/***********By Comapnay*************
		if($arryCompany[0]['currency_id']>0){
			$arrySelCurrency = $objRegion->getCurrency($arryCompany[0]['currency_id'],'');
			$Config['Currency'] = $arrySelCurrency[0]['code'];
			$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
			$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
			$Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value'];
		}
		/*********By Location**************/
		if($_SESSION['currency_id']>0){
			$arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'],'');
			$Config['Currency'] = $arrySelCurrency[0]['code'];
			$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
			$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
			$Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value'];
		}
		/******************************/
		if(!empty($_SESSION['CmpDatabase'])){
			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
		}else{
			echo '<div align="center"><br><br>'.ERROR_OTHER_BROWSER.'</div>';
			exit;
		}

	}else{
		$Config['SiteName']  = stripslashes($arrayConfig[0]['SiteName']);	
		$Config['SiteTitle'] = stripslashes($arrayConfig[0]['SiteTitle']);
	}

	$objMenu=new cms();	
	$objConfigure=new configure();
	

	////////////////////////////////
	////////////////////////////////

	$ThisPage = $revPageArray[0]; //GetAdminPage();
	$SelfPage = $ThisPage;
	if(empty($ThisPageName)) $ThisPageName = $ThisPage;
	if($_SESSION['AdminID']  == '') {
		if (isset($_SERVER['QUERY_STRING']))
		{
			$ThisPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
			$ThisPage = str_replace("&amp;",",",$ThisPage);

		}
		
	}

	$QueryString = $ThisPage.'?export=1&'.$_SERVER['QUERY_STRING'];
	$QueryString = str_replace("&export=1","",$QueryString);


	/***************************************/
	/*******Check Admin Session ************/
	//if($SelfPage!='index.php' && $PopupPage!=1){
	if($LoginPage!=1){
		ValidateAdminSession($ThisPage);
	}
	/***************************************/
	/***************************************/

	if(!empty($_SESSION['AdminID'])){	

		if(!empty($_GET['att'])){
			$ThisPageName = $ThisPageName.'?att='.$_GET['att'];
		}
		if(!empty($_GET['module'])){
			$ThisPageName = $ThisPageName.'?module='.$_GET['module'];
		}
		if($ThisPageName=='viewProductCategory.php') $ThisPageName = 'viewProducts.php';
		/****************************/

		$arryCurrentLocation = $objConfigure->GetLocation($_SESSION['locationID'],'');

		$arryDepartment = $objConfigure->GetDepartment();

		$arrySubDepartment = $objConfigure->GetSubDepartment('');
		$arryCurrentDepartment = $objConfigure->GetCurrentDepartment($ThisPageName);

		$CurrentDepartment = stripslashes($arryCurrentDepartment[0]["Department"]);
		$CurrentDepID = stripslashes($arryCurrentDepartment[0]["depID"]);
		$Config['CurrentDepID'] = $CurrentDepID;
		if(empty($Config['DeptFolder'])) $DeptFolder = strtolower($CurrentDepartment).'/';
		$arryDepartmentInfo = $objConfigure->GetDepartmentInfo($CurrentDepID); 
		$Config['DeptHeadEmail'] = $arryDepartmentInfo[0]["Email"];

		$Config['TodayDate'] = getLocalTime($arryCurrentLocation[0]['Timezone']);
		$_SESSION['TodayDate'] = $Config['TodayDate'];
		if((!empty($_GET['locationID']))){
			$_SESSION['currency_id']=$arryCurrentLocation[0]['currency_id']; //setting curreny id in session
		}else if(empty($_SESSION['currency_id'])){
			$_SESSION['currency_id']=$arryCurrentLocation[0]['currency_id'];
		}
         
		/****************************/
		$RecordsPerPage = ($arryCompany[0]['RecordsPerPage']>0)?($arryCompany[0]['RecordsPerPage']):('20');	
		$Config['AdminEmail'] = $arryCompany[0]['Email'];
		$_SESSION['AdminEmail'] = $Config['AdminEmail'];
		$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
		/****************************/		
		$arrayModuleID = $objConfig->getModuleID($_SESSION['AdminID'],$ThisPageName,$CurrentDepID,'');	
		$MainModuleID = $arrayModuleID[0]['ModuleID'];
		$ModuleParentID = $arrayModuleID[0]['Parent'];
		$MainModuleName = $arrayModuleID[0]['Module'];
		$DefaultModule = $arrayModuleID[0]['DefaultParent'];
		/*if($arrayModuleID[0]['EditPage']==1){
			$arrayModuleID2 = $objConfig->getParentModuleID($arrayModuleID[0]['Parent'],'');	
			$MainModuleID = $arrayModuleID2[0]['ModuleID'];
			$ModuleParentID = $arrayModuleID2[0]['Parent'];
		}*/
		/****************************/		
		$arrayDefaultMenu = $objConfig->GetDefaultMenus();
		foreach($arrayDefaultMenu as $key=>$values){
			$Config['DefaultMenu'] .= $values['ModuleID'].',';
		}
		$Config['DefaultMenu'] = rtrim($Config['DefaultMenu'],",");
		$AllowedModules = explode(",",$Config['DefaultMenu']);
		/****************************/	
		if($_SESSION['AdminType'] == "employee"){
			$arryEmpSetting = $objConfigure->GetEmpSetting($_SESSION['AdminID']); 
			$Config['vUserInfo'] = $arryEmpSetting[0]['vUserInfo'];	
			$Config['vAllRecord'] = $arryEmpSetting[0]['vAllRecord'];	
		}else{
			$Config['vUserInfo'] = '1';	
			$Config['vAllRecord'] = '1';	
		}
		/****************************/	
		if($objConfigure->isUserKicked($_SESSION['loginID']) && $SelfPage != 'logout.php'){			
			header("location: ".$MainPrefix."logout.php");
			exit;
		}
		/****************************/	


	}

	/*****************************/	


?>
