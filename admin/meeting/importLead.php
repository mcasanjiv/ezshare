<?php
	/**************************************************/
	$module = "Lead"; $EditPage = 1;
	$ThisPageName = 'viewLead.php?module=lead'; 		
	/**************************************************/
	require_once("../includes/header.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/territory.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/function.class.php");
	require_once('../php-excel-reader/excel_reader2.php');
	require_once('../php-excel-reader/SpreadsheetReader.php');
	require_once('../php-excel-reader/SpreadsheetReader_XLSX.php');


	$objLead=new lead();
	$objTerritory=new territory();
	$objEmployee=new employee();
	$objFunction=new functions();
       	$RedirectURL = $ThisPageName;
	
	
	if($_SESSION['AdminType'] == "employee") {	
		$AssignTo = $_SESSION['AdminID'];
	}


	$Config['Online']=0;  //To stop email

	$DbColumnArray = array(
		"FirstName" => "First Name",
		"LastName" => "Last Name",
		"company" => "Company Name",
		"primary_email" => "Primary Email",
		"LandlineNumber" => "Landline Number",
		"designation" => "Title",		
		//"type" => "Lead Type",
		"ProductID" => "Product",
		"product_price" => "Product Price",
		"Website" => "Website",
		"Address" => "Address",
		"ZipCode" => "Zip Code",
		"OtherCity" => "City",	
		"OtherState" => "State",
		"Country" => "Country",
		"Mobile" => "Mobile",		
		"Industry" => "Industry",
		"AnnualRevenue" => "Annual Revenue",
		"NumEmployee" => "Number of Employee",
		"lead_source" => "Lead Source",
		"lead_status" => "Lead Status",
		"description" => "Description",
		"lead_source" => "Lead Source"

	);
	$DbColumn = sizeof($DbColumnArray);

	$DbUniqueArray = array(
		"FirstName,LastName,company" => "First Name, Last Name & Company Name",
		"FirstName,LastName" => "First Name & Last Name",		
		"company" => "Company Name",
		"primary_email" => "Primary Email",
		"LandlineNumber" => "Landline Number"
	);

	



	if($_POST){
		/*******************************/
		/*******************************/
		if($_POST['FileDestination'] != ''){
			if($_POST['AssignTo']>0) {	
				$AssignTo = $_POST['AssignTo'];
			}
			/********Connecting to main database*********/
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/*******************************************/

			$MainDir = "upload/Excel/".$_SESSION['CmpID']."/";			
			if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){
			

			$Filepath = $MainDir.$_SESSION['ExcelFile'];
			#echo '<pre>';print_r($_POST);exit;
			$Spreadsheet = new SpreadsheetReader($Filepath);
			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
			$LeadAddedCount = 0;
			$LeadCount = 0;
			foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayLead=array();
				foreach ($Spreadsheet as $Key => $Row){
					//echo "<pre>";	print_r($Row);echo "</pre>";exit;
					unset($arrayLead[$Count]);	
					foreach($DbColumnArray as $Key => $Heading){ 
						$i = $_POST[$Key];
						$arrayLead[$Count][$Key]=$Row[$i];
					}
					$arrayLead[$Count]["AssignTo"]=$AssignTo; 
					$arrayLead[$Count]["AssignType"]='User'; 

/************************/
if(!empty($arrayLead[$Count]["Country"])){
	unset($arryCountry); unset($arryState); unset($arryCity);
	$arryCountry = $objRegion->GetCountryID($arrayLead[$Count]["Country"]);  
	$arrayLead[$Count]["country_id"]=$arryCountry[0]['country_id']; //set	
	if($arryCountry[0]['country_id']>0 && !empty($arrayLead[$Count]["OtherState"])){		
		$arryState = $objRegion->GetStateID($arrayLead[$Count]["OtherState"], $arryCountry[0]['country_id']); 
		$arrayLead[$Count]["main_state_id"]=$arryState[0]['state_id'];//set
	}
	if($arryCountry[0]['country_id']>0 && $arryState[0]['state_id']>0 && !empty($arrayLead[$Count]["OtherCity"])){		
		$arryCity = $objRegion->GetCityIDSt($arrayLead[$Count]["OtherCity"], $arryState[0]['state_id'], $arryCountry[0]['country_id']); 
		$arrayLead[$Count]["main_city_id"]=$arryCity[0]['city_id'];//set
	}
	////////
	$arrayLead[$Count]["State"] = $arrayLead[$Count]["OtherState"];
	$arrayLead[$Count]["City"] = $arrayLead[$Count]["OtherCity"];
	
	
}
/************************/


					$Count++;
				}
					
			}


			//echo "<pre>";print_r($arrayLead);echo "</pre>";exit;
			$NumLead=sizeof($arrayLead);
			if($NumLead>0){	
				/******Connecting to company database*******/
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/*******************************************/		
				 for($i=1;$i<$NumLead;$i++){


			
			if(empty($arrayLead[$i]["FirstName"]) && empty($arrayLead[$i]["LastName"])){
				$arrayLead[$i]["FirstName"]='Unknown';$arrayLead[$i]["LastName"]='Unknown';
			}


					if(!empty($arrayLead[$i]["FirstName"]) || !empty($arrayLead[$i]["LastName"])){
	/*
	$primary_email = $arrayLead[$i]["primary_email"];
	$ValidEmail = 0;				
	if(!empty($primary_email)){
		if (preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$primary_email))
		{
		    if(!$objLead->isprimary_emailExists($primary_email,'')){
			$ValidEmail = 1;	
		    }

		}
	}
	$ValidLead = 0;
	if(!$objLead->isLeadExist($arrayLead[$i]["FirstName"],$arrayLead[$i]["LastName"],$arrayLead[$i]["company"],'')){
		$ValidLead = 1;	
	} 
	*/
$ValidLead = 0;


if($_SESSION['DuplicayColumn'] == 'FirstName,LastName,company'){
	if(!$objLead->isLeadNameCompanyExist($arrayLead[$i]["FirstName"],$arrayLead[$i]["LastName"],$arrayLead[$i]["company"])){
		$ValidLead = 1;	
	}
}else if($_SESSION['DuplicayColumn'] == 'FirstName,LastName'){
	if(!$objLead->isLeadNameExist($arrayLead[$i]["FirstName"],$arrayLead[$i]["LastName"],'')){
		$ValidLead = 1;	
	}
}else if($_SESSION['DuplicayColumn'] == 'company'){
	if(!$objLead->isLeadCompanyExist($arrayLead[$i]["company"],'')){
		$ValidLead = 1;	
	}
}else if($_SESSION['DuplicayColumn'] == 'primary_email'){
	if(!$objLead->isLeadEmailExist($arrayLead[$i]["primary_email"],'')){
		$ValidLead = 1;	
	}
}else if($_SESSION['DuplicayColumn'] == 'LandlineNumber'){
	if(!$objLead->isLeadLandlineExist($arrayLead[$i]["LandlineNumber"],'')){
		$ValidLead = 1;	
	}
}



if($ValidLead==1){
/*********************/
if($arrayLead[$i]["country_id"]>0){ //territory
	$arryTerritoryAssign = $objTerritory->TerritoryRuleLocation($arrayLead[$i]["country_id"],$arrayLead[$i]["main_state_id"],$arrayLead[$i]["main_city_id"]);
	$arrayLead[$i]["TerritoryAssign"] = $arryTerritoryAssign;
}
/*********************/

						$leadId=$objLead->AddLead($arrayLead[$i]);	
						$LeadAddedCount++;
						$objLead->UpdateCountyStateCity($arrayLead[$i],$leadId);


					   }

					}


				 }
			}		
			/**********************************/
			
				unlink($MainDir.$_SESSION['ExcelFile']);
			}
			
			unset($_SESSION['ExcelFile']);

			$mess_lead = "Total lead to import from excel sheet : ".$Count;
			$mess_lead .= "<br>Total lead imported into database : ".$LeadAddedCount;
			$mess_lead .= "<br>Lead already exist in database : ".($Count-$LeadAddedCount);


			if(!empty($leadId)){								
				$_SESSION['mess_lead']= $mess_lead;				
				header("Location:".$RedirectURL);
				exit;
			}else{
				$ErrorMsg = $mess_lead;			
			}
		
		/*******************************/
		/*******************************/
		}else if($_FILES['excel_file']['name'] != ''){
			
	               $FileArray = $objFunction->CheckUploadedFile($_FILES['excel_file'],"Excel");
			
                       if(empty($FileArray['ErrorMsg'])){
				$fileExt = $FileArray['Extension']; 
				$fileName = rand(1,100).".".$fileExt;	
		                $MainDir = "upload/Excel/".$_SESSION['CmpID']."/";						
				 if (!is_dir($MainDir)) {
					mkdir($MainDir);
					chmod($MainDir,0777);
				 }
		            	$FileDestination = $MainDir.$fileName;
			if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){		$Uploaded = 1;
				$FileDestination = $MainDir.$_SESSION['ExcelFile'];
	
			}else if(@move_uploaded_file($_FILES['excel_file']['tmp_name'], $FileDestination)){
					$Uploaded = 1;
					chmod($FileDestination,0777);
					$_SESSION['ExcelFile']=$fileName;
			}
		       }else{
			     $ErrorMsg = $FileArray['ErrorMsg'];
			}
		 }
		

		if($fileName!="" && file_exists($FileDestination)){	
			$_SESSION['DuplicayColumn']=$_POST['DuplicayColumn'];	
			
  	
                	$Filepath = $FileDestination;			
			$mimeType=mime_content_type($Filepath);
		  
			$Spreadsheet = new SpreadsheetReader($Filepath);			
			$Sheets = $Spreadsheet -> Sheets();
			$Count = 0;
		        foreach ($Sheets as $Index => $Name){
				$Time = microtime(true);
				$Spreadsheet -> ChangeSheet($Index);
				$arrayLead=array();
				foreach ($Spreadsheet as $Key => $Row){
	
				if(!empty($Row[0]) && !empty($Row[1]) && !empty($Row[2])){	
					foreach ($Row as $val){
						$arrayHeader[]=$val;
					}
					$Count++;
					break;		
				}
	
		
		if($Count==1) break;
      }////end of for loop


		
		/**********************************/		
		//echo '<pre>';print_r($arrayHeader);exit; 
		$NumHeader=sizeof($arrayHeader);		
		/**********************************/


		if($NumHeader>0){
			//Ready for selection		
			
		}else{
			
			$ErrorMsg=SHEET_NOT_UPLOADED;
		}
		

       
      
      }

}else{
	unset($_SESSION['ExcelFile']);
	//unset($_SESSION['DuplicayColumn']);
	
}

/*******************************/
/*******************************/	


}else{

	$MainDir = "upload/Excel/".$_SESSION['CmpID']."/";			
	if(!empty($_SESSION['ExcelFile']) && file_exists($MainDir.$_SESSION['ExcelFile'])){
		unlink($MainDir.$_SESSION['ExcelFile']);
	}
	unset($_SESSION['ExcelFile']);
	//unset($_SESSION['DuplicayColumn']);
	
}	






$_GET['Status']=1;$_GET['Division']='5,7';
$arryEmployee = $objEmployee->GetEmployeeList($_GET);


//echo 'Excel file: '.$_SESSION['ExcelFile'];



$DownloadFile = 'upload/Excel/LeadTemplate.xls';
$NumMandatory = 2;


include("../includes/html/box/import_lead_form.php");
include_once("../includes/footer.php"); 
?>
