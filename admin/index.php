<?php 
	/***********************
	if(empty($_POST['LoginEmail'])) { 
		include("includes/license.php");

		if(!file_exists("../includes/config.php")){
			header('location:../install/index.php');
			exit;	
		}		
	}
	/***********************/

	$LoginPage=1;
	require_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/employee.class.php");
	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../includes/browser_detection.php");

	$objCompany=new company();
	$objEmployee=new employee();
	$objUser=new user();

	$objConfig = new admin();

	CleanGet();
	
	

	unset($_SESSION['CmpLogin']);
	/***********************/
	if($_POST['LoginEmail']!='') { 
		CleanPost();

		if(empty($_POST['LoginEmail'])) {
			$mess = INVALID_EMAIL_PASSWORD;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		}else{ 
			/************
			$arryMain = $objCompany->GetCompanyDetailDisplay($_GET["c"]);
			$DbName2 = $Config['DbName']."_".$arryMain[0]['DisplayName'];
			$CmpID = $arryMain[0]['CmpID'];
			/**********************************/
			//$UserType = mysql_real_escape_string($_POST['UserType']); 
			$LoginEmail = mysql_real_escape_string($_POST['LoginEmail']); 
			$LoginPassword = mysql_real_escape_string($_POST['LoginPassword']);

			$ArryUserEmail = $objConfig->CheckUserEmail($LoginEmail); 
			
			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
			$RefID = mysql_real_escape_string($ArryUserEmail[0]['RefID']);
			$DbName2 = $Config['DbName']."_".$ArryUserEmail[0]['DisplayName'];

			$Config['DbName2'] = $DbName2;
			if(!$objConfig->connect_check()){
				$mess = ERROR_NO_DB;
			}else if($ArryUserEmail[0]['ExpiryDate']>0){				
				if($ArryUserEmail[0]['ExpiryDate']<date('Y-m-d')){
					$mess = ERROR_PCKG_EXP;
				}
			}

			/*****************			
			$ValidateLicense=1;  $LicenseKey = $ArryUserEmail[0]['LicenseKey'];
			include("includes/license.php");
			/*****************/



			/**********************************/
			if(empty($mess) && $CmpID>0 && $RefID==0){ // Company Login Check

				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

				$ArryCompany = $objCompany->ValidateCompany($LoginEmail, $LoginPassword, $CmpID);	

				if($ArryCompany[0]['CmpID']>0){ // Company Login Check
					session_regenerate_id(); 
					$_SESSION['AdminID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['UserID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['CmpID'] = $CmpID; 
					$_SESSION['AdminType'] = "admin"; 
					$_SESSION['DisplayName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['UserName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['AdminEmail'] = $ArryCompany[0]['Email'];					
					$_SESSION['AdminPassword'] = $ArryCompany[0]['Password'];			
					$_SESSION['CmpDatabase'] = $DbName2;
					$_SESSION['CmpDepartment'] = $ArryUserEmail[0]['Department'];
					$UserType = "admin";
					$ValidLogin = 1;
					$arryMain = $objCompany->GetCompanyDetailDisplay($ArryCompany[0]['DisplayName']);
				}

			}else if(empty($mess) && $CmpID>0 && $RefID>0){ // User Login Check

				if($ValidLogin!=1){
				$UserType = "employee";


				$Config['DbName'] = $DbName2;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();  
				$ArryUser = $objUser->ValidateUser($LoginEmail, $LoginPassword, $UserType);
				if($ArryUser[0]['UserID']>0){


					
					if($UserType=="employee"){  /************ Employee *************/
						$ArryEmployee = $objEmployee->GetEmployeeUser($ArryUser[0]['UserID'], 1);
						if($ArryEmployee[0]['EmpID']>0){ 
							session_regenerate_id(true); 
							$_SESSION['AdminID'] = $ArryEmployee[0]['EmpID']; 
							$_SESSION['UserID'] = $ArryEmployee[0]['UserID']; 
							$_SESSION['CmpID'] = $CmpID; 
							$_SESSION['AdminType'] = "employee"; 
							$_SESSION['DisplayName'] = $ArryUserEmail[0]['DisplayName'];
							$_SESSION['UserName'] = $ArryEmployee[0]['UserName'];
							$_SESSION['AdminEmail'] = $ArryEmployee[0]['Email'];					
							$_SESSION['AdminPassword'] = $ArryEmployee[0]['Password'];			
							$_SESSION['CmpDatabase'] = $DbName2;
							$_SESSION['locationID'] = $ArryEmployee[0]['locationID'];	
							$_SESSION['CmpDepartment'] = $ArryUserEmail[0]['Department'];
							$ValidLogin = 1;
							
						}
					}else if($UserType=="supplier"){  /************ Supplier *************/
						#$ArrySupplier = $objSupplier->GetSupplierUser($ArryUser[0]['UserID'], 1);
						#$UserType = "supplier";
					}


					




				}
				
			    }



			}else{ // User Login Check

				/******Start Customer/Supplier*************/
				require_once("includes/customer_vendor_login.php");
				/******End Customer/Supplier***************/
				
			}


			
			/********************/  

			if($ValidLogin==1 && $_SESSION['UserID']>0){
				
				$_SESSION['CmpLogin'] = $_GET["crm"];

				$objConfig->RemoveBlock();
				setcookie("DisplayNameCookie", $_SESSION['DisplayName'], time()+(24*30*3600));

				if($_SESSION['AdminType']=="admin"){
					$Config['DbName'] = $DbName2;
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();  
				}

				$_SESSION['loginID'] = $objUser->AddUserLogin($_SESSION['UserID'],$UserType);
				
				$objConfigure=new configure();				
				$objConfigure->UpdatePrimaryLocation($arryMain[0]); // Update Primary Location of Company
	

				if(!empty($_POST['ContinueUrl'])){
					$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);
					echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
					exit;
				}else{
					echo '<script>location.href="dashboard.php";</script>';
					exit;
				}
			}else{
				if(empty($mess))
					$mess = INVALID_EMAIL_PASSWORD;

				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

				$_SESSION['login_attempt']++;
				if($_SESSION['login_attempt']>=5){
					$objConfig->AddBlockLogin();
				}

			}
			/********************/
			
		}

	}else{
		header("Location:".$Config['Url'].'meeting');
		session_destroy();	
		ob_end_flush();		
	}

	/***********************
	$Config['DbName'] = $Config['DbMain'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	if(!empty($_GET["c"])){
		$arryCompany = $objCompany->GetCompanyByDisplay($_GET["c"]);
		if(empty($arryCompany[0]["CmpID"])){
			$ErrorMsg = ERROR_INACTIVE_ADMIN;
		}else{

			if($arryCompany[0]['ExpiryDate']>0){				
				if($arryCompany[0]['ExpiryDate']<date('Y-m-d')){
					$ErrorMsg = ERROR_PCKG_EXP;
				}
			}

			$Config['DbName2'] = $Config['DbName']."_".$arryCompany[0]["DisplayName"];
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}
		}
	}else{
		$ErrorMsg = ERROR_INACTIVE_PAGE;
	}
	/***********************/

	if(empty($ErrorMsg)){
		if($objConfig->CheckBlockLogin()){
			$ErrorMsg = BLOCKED_MSG;
			unset($_SESSION['login_attempt']);
		}
	}


	

	require_once("includes/footer.php");
 ?>
