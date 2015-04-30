<?php ob_start();
	session_start();
	//error_reporting(0);
    require_once("../includes/config.php");
	require_once("../includes/language.php");
    require_once("../includes/function.php");
    require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");	
	require_once("../classes/pager.cls.php");
	require_once("../classes/MyMailer.php");	
	require_once("language/english.php");
	require_once("../classes/company.class.php");
	require_once("../classes/region.class.php");

	////////////////////////////////
	////////////////////////////////
	(!$_GET['curP'])?($_GET['curP']=1):(""); 
	(!$_GET['sortby'])?($_GET['sortby']=""):(""); 
	(!$_GET['key'])?($_GET['key']=""):(""); 

	$objConfig=new admin();	 
	$objPager=new pager();
	$objCompany=new company();

	////////////////////////////////
	////////////////////////////////
	$ThisPage = GetAdminPage();
	$SelfPage = $ThisPage;
	$ThisPageName = $ThisPage;
	if($_SESSION['AdminID']  == '') {
		if (isset($_SERVER['QUERY_STRING'])){
			$ThisPage .= "?" . htmlentities($_SERVER['QUERY_STRING']);
			$ThisPage = str_replace("&amp;",",",$ThisPage);
		}
	}	


	if (is_object($objConfig)){
		$arrayConfig = $objConfig->GetSiteSettings(1);	
		$arrayAdmin = $objConfig->GetAdmin(1);
		#$arraySignature = $objConfig->GetSignature(10,1);
		
		$RecordsPerPage = $arrayConfig[0]['RecordsPerPage'];	
		$Config['SiteName']  = stripslashes($arrayConfig[0]['SiteName']);	
		$Config['SiteTitle'] = stripslashes($arrayConfig[0]['SiteTitle']);
		$Config['AdminEmail'] = $arrayAdmin[0]['AdminEmail'];
		$Config['RecieveSignEmail']  = $arrayConfig[0]['RecieveSignEmail'];	
		$Config['MailFooter'] = '['.stripslashes($arrayConfig[0]['SiteName']).']';
		
		#if(!empty($arraySignature[0]['PageContent'])) $Config['MailFooter'] = stripslashes($arraySignature[0]['PageContent']);
		
	}
	
	////////////////////////////////////////////////////////////
	(!$_GET['curP'])?($_GET['curP']=1):(""); 
	
	$objPager = new pager();
          
	$objConfig = new admin();	
        
	$objCompany = new company(); 
	$objRegion = new region();
         
	$arrayConfig = $objConfig->GetSiteSettings(1);	
	$arrayAdmin = $objConfig->GetAdmin(1);
	//$arraySignature = $objConfig->GetSignature(10,1);
	$arryCountry = $objRegion->getCountry('','');
	$RecordsPerPage = $arrayConfig[0]['RecordsPerPage'];
	
	//if(!empty($arraySignature[0]['PageContent'])) $Config['MailFooter'] = stripslashes($arraySignature[0]['PageContent']);


	/**** Currency Area ****/
            $arryTopCurrency = $objRegion->getCurrency('',1);
            $arryCurrency = $objRegion->getUpdatedCurrency($_SESSION['currency_id'],'');

	//$Config['CurrencyValue'] = $arryCurrency[0]['currency_value'];
	/************************************************/



	/************************************/
	//Company Database Connection Start
	/************************************/
      
                
	if(!empty($_SESSION["DisplayName"])){
		$arryCompany = $objCompany->GetCompanyByDisplay($_SESSION["DisplayName"]);
                
                if(empty($arryCompany[0]['Department'])) $arryCompany[0]['Department']=2;
   
		if(empty($arryCompany[0]["CmpID"]) || substr_count($arryCompany[0]['Department'],2)==0){
			$ErrorMsg = ERROR_INACTIVE_PAGE;
		}else{
			$Config['DisplayName'] = $arryCompany[0]["DisplayName"];
			$Config['TodayDate'] = getLocalTime($arryCompany[0]['Timezone']);

			$Config['homeCompleteUrl'] = $Config['Url'].$Config['DisplayName'];
			$Config['DateFormat'] = $arryCompany[0]['DateFormat'];

			$Config['SiteName']  = stripslashes($arryCompany[0]['DisplayName']);        
			$Config['SiteTitle'] = stripslashes($arryCompany[0]['CompanyName']);
			$Config['CmpID'] = stripslashes($arryCompany[0]['CmpID']);

			$Config['CompanyEmail'] = $arryCompany[0]["Email"];;
			$Config['PaypalID'] = $arryCompany[0]['PaypalID'];
			$Config['country_id'] = $arryCompany[0]['country_id'];
			$Config['MailFooter'] = '['.stripslashes($arryCompany[0]['CompanyName']).']';
                                                
			/******************************/
                         
                          
		if(!empty($_GET['curr_id'])){
			$_SESSION['currency_id']=$_GET['curr_id'];
		}else if(empty($_SESSION['currency_id'])){
			$_SESSION['currency_id']=$arryCompany[0]['currency_id'];

		}

		if($arryCompany[0]['currency_id']>0){
		$arryDbCurrency = $objRegion->getCurrency($arryCompany[0]['currency_id'],'');

		}
                         
			if($_SESSION['currency_id']>0){
				$arrySelCurrency = $objRegion->getCurrency($_SESSION['currency_id'],'');
				$Config['Currency'] = $arrySelCurrency[0]['code'];
				$Config['CurrencySymbol'] = $arrySelCurrency[0]['symbol_left'];
				$Config['CurrencySymbolRight'] = $arrySelCurrency[0]['symbol_right'];
                                $Config['CurrencyCompanyVal'] = $arrySelCurrency[0]['currency_value'];
                                
			       $Config['CurrencyValue'] = $arrySelCurrency[0]['currency_value']/$arryDbCurrency[0]['currency_value'];
			}
			/******************************/
			$Config['DbName2'] = $Config['DbName']."_".$arryCompany[0]["DisplayName"];
                       
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}else{
				$Config['DbName'] = $Config['DbName2'];
                                $_SESSION['CmpDatabase'] = $Config['DbName'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
			}
		}
	}else{
		$ErrorMsg = ERROR_INACTIVE_PAGE;
	}
	/************************************/
	//Company Database Connection End
	/************************************/
	
?>

