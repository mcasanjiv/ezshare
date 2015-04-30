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
	
				if($_POST) { 

		if(empty($_POST['LoginEmail'])) {
			$mess = INVALID_EMAIL_PASSWORD;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		}else{ 
			$LoginEmail = mysql_real_escape_string($_POST['LoginEmail']); 
			$LoginPassword = mysql_real_escape_string($_POST['LoginPassword']);

			$ArryUserEmail = $objConfig->CheckUserEmail($LoginEmail); 
			
			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
			if(empty($mess) && $CmpID>0){ // Company Login Check


				$ArryCompany = $objCompany->ValidateCompany($LoginEmail, $LoginPassword, $CmpID);	

				if($ArryCompany[0]['CmpID']>0){ // Company Login Check
					session_regenerate_id(); 
					
					//plz do not change these sessions
					$_SESSION['CrmAdminID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['CrmUserID'] = $ArryCompany[0]['CmpID']; 
					$_SESSION['CrmCmpID'] = $CmpID;  
					$_SESSION['CrmDisplayName'] = $ArryCompany[0]['DisplayName'];
					$_SESSION['CrmAdminEmail'] = $ArryCompany[0]['Email'];					
					$_SESSION['CrmAdminPassword'] = $ArryCompany[0]['Password'];								
					$ValidLogin = 1;
					
					/* session value for admin start here */
					
					$arryMain = $objCompany->GetCompanyDetailDisplay($ArryCompany[0]['DisplayName']);
					
					$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
					$RefID = mysql_real_escape_string($ArryUserEmail[0]['RefID']);
					$DbName2 = $Config['DbName']."_".$ArryUserEmail[0]['DisplayName'];
			
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

					
				$Config['DbName'] = $DbName2;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();  					

				$objUser->AddUserLogin($_SESSION['UserID'],$_SESSION['AdminType']);
				
				$objConfigure=new configure();				
				$objConfigure->UpdatePrimaryLocation($arryMain[0]); // Update Primary Location of Company
					/* end here */
					
				}

			}
			
			
			
			/********************/  

			if($ValidLogin==1 && $_SESSION['CrmUserID']>0){

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
			}
			/********************/
			
			
			
			
			
			
			
		}
		
	}else{
		session_destroy();	
		ob_end_flush();		
	}

include ('includes/footer.php');
?>