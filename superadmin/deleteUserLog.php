<?php 
	$HideNavigation = 1;
	include_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/user.class.php");
	$objCompany=new company();
	$objUser=new user();

	if($_GET['cmp']>0){
		$arryCompany = $objCompany->GetCompany($_GET['cmp'],'');
		$CmpID   = $arryCompany[0]['CmpID'];
		$RedirectUrl = 'viewUserLog.php?cmp='.$CmpID;	
		if($CmpID>0){
			/********Connecting to main database*********/
			$CmpDatabase = $Config['DbName']."_".$arryCompany[0]['DisplayName'];
			$Config['DbName2'] = $CmpDatabase;
			if(!$objConfig->connect_check()){
				$ErrorMsg = ERROR_NO_DB;
			}else{
				$Config['DbName'] = $CmpDatabase;
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
			
				/*******************************************/			
				if(!empty($_POST['DeleteBefore'])){				
					
					$objUser->RemoveUserLog($_POST);
					echo '<script>window.parent.location.href="'.$RedirectUrl.'";</script>';
					exit;
				}
				/*******************************************/		
				

			}			
		}
	}

	require_once("includes/footer.php"); 	 
?>


