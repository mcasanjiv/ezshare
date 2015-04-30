<?php 
	require_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/region.class.php");
	require_once("../classes/configure.class.php");
	$objConfigure=new configure();
	$ModuleName = "Company";
	$RedirectURL = "viewCompany.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="company";

	$EditUrl = "editCompany.php?edit=".$_GET["edit"]."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];


	$objCompany=new company();
	$objRegion=new region();
	
		

	/*if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_company'] = COMPANY_REMOVED;
		$objCompany->RemoveCompany($_REQUEST['del_id']);
		header("Location:".$RedirectURL);
	}*/
	

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_company'] = COMPANY_STATUS_CHANGED;
		$objCompany->changeCompanyStatus($_REQUEST['active_id']);
		header("Location:".$RedirectURL);
	}
	

	
	 if ($_POST){	
			
			$_POST['Department'] = implode(",",$_POST['Department']);
			

			 if (empty($_POST['Email']) && empty($_POST['CmpID'])) {
				$errMsg = ENTER_EMAIL;
			 } else {
				if (!empty($_POST['CmpID'])) {
					$ImageId = $_POST['CmpID'];
					/*
					$objCompany->UpdateCompany($_POST);
					$_SESSION['mess_company'] = COMPANY_UPDATED;
					*/
					/***************************/
					switch($_GET['tab']){
						case 'company':
							$objCompany->UpdateCompanyProfile($_POST);
							$_SESSION['mess_company'] = COMPANY_PROFILE_UPDATED;
							break;
						case 'account':
							$objCompany->UpdateAccount($_POST);
							$_SESSION['mess_company'] = ACCOUNT_UPDATED;
							break;
						case 'permission':
							$objCompany->UpdatePermission($_POST);
							$UpdateAdminMenu = 1;
							$_SESSION['mess_company'] = PERMISSION_UPDATED;
							break;
						case 'currency':
							$ArrayCompany=$objCompany->GetCompany($_POST['CmpID'],1);
							$DbName2 = $Config['DbName']."_".$ArrayCompany[0]['DisplayName'];	
							$objCompany->UpdateCurrency($_POST);
							$objConfig->dbName = $DbName2;
							$objConfig->connect();											
							$objConfigure->UpdateLocationCurrency($_POST);
							$_SESSION['mess_company'] = CURRENCY_UPDATED;
							break;
						case 'DateTime':
							$objCompany->UpdateDateTime($_POST);
							$UpdateAdminDateTime = 1;
							$_SESSION['mess_company'] = DATETIME_UPDATED;
							break;
					}
					/***************************/
				} else {	
					if($objConfig->isCmpEmailExists($_POST['Email'],'')){
						$_SESSION['mess_company'] = EMAIL_ALREADY_REGISTERED;
					}else if($objCompany->isDisplayNameExists($_POST['DisplayName'],'')){
						$_SESSION['mess_company'] = DISPLAY_ALREADY_REGISTERED;
					}else{	
						$ImageId = $objCompany->AddCompany($_POST); 
						$_SESSION['mess_company'] = COMPANY_ADDED;	
						$AddDatabase = 1; 
						$UpdateAdminMenu = 1;
					}
				}
				
				$_POST['CmpID'] = $ImageId;
				
				/************************/
				if($_FILES['Image']['name'] != ''){
					$ImageExtension = GetExtension($_FILES['Image']['name']); 
					$imageName = $ImageId.".".$ImageExtension;	
					$ImageDestination = "../upload/company/".$imageName;
					if(@move_uploaded_file($_FILES['Image']['tmp_name'], $ImageDestination)){
						$objCompany->UpdateImage($imageName,$ImageId);
					}
				}

				/************************/
				if($AddDatabase == 1){
					$DbName = $objCompany->AddDatabse($_POST['DisplayName']); 
					if(!empty($DbName)){
						ImportDatabase($Config['DbHost'],$DbName,$Config['DbUser'],$Config['DbPassword'],'sql/erp_company.sql');
					}
				}   
				
				/************************/
				if($UpdateAdminMenu == 1){
					if(empty($DbName)){
						$arryCmp = $objCompany->GetCompanyDisplayName($_POST['CmpID']);
					
						$DbName = $Config['DbName']."_".$arryCmp[0]['DisplayName'];
					}
					$Config['DbName'] = $DbName;
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
								
					$objCompany->UpdateAdminModules($_POST['CmpID'],$_POST['Department']);		

					
					#$objCompany->UpdateAdminSubModules($_POST['CmpID'],$_POST['Department'],$PaymentPlan);	//Temporary For CRM Frontend Integration


					$objCompany->UpdateInventoryModules($_POST['CmpID'],$_POST['TrackInventory']);		
	
		
				}
				/************************/

				/************************/
				if($UpdateAdminDateTime == 1){
					if(empty($DbName)){
						$arryCmp = $objCompany->GetCompanyDisplayName($_POST['CmpID']);
					
						$DbName = $Config['DbName']."_".$arryCmp[0]['DisplayName'];
					}
					$Config['DbName'] = $DbName;
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
								
					$objCompany->UpdateLocationDateTime($_POST);				
				}
				/************************/






				if (!empty($_GET['edit'])) {
					header("Location:".$ActionUrl);
					exit;
				}else{
					header("Location:".$RedirectURL);
					exit;
				}


				
			}
		}
		

	if (!empty($_GET['edit'])) {
		$arryCompany = $objCompany->GetCompany($_GET['edit'],'');
		$CmpID   = $_REQUEST['edit'];	
			
	}
				
	if($arryCompany[0]['Status'] != ''){
		$CompanyStatus = $arryCompany[0]['Status'];
	}else{
		$CompanyStatus = 1;
	}
		
	$arrayDateFormat = $objConfig->GetDateFormat();
	$arryDepartment = $objConfig->GetDepartment();
	$arryCountry = $objRegion->getCountry('','');
	$arryCurrency = $objRegion->getCurrency('',1);

	//$HideModule = 'Style="display:none"';
	require_once("includes/footer.php"); 
?>


