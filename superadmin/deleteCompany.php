<?php 
	require_once("includes/header.php");
	require_once("../classes/company.class.php");
	require_once("../classes/configure.class.php");

	$RedirectURL = "viewCompany.php?curP=".$_GET['curP'];

	$objCompany=new company();
		
	if(!empty($_POST['CmpID'])) {
		$_SESSION['mess_company'] = COMPANY_REMOVED;
		$objCompany->RemoveCompany($_POST['CmpID']);
		header("Location:".$RedirectURL);
		exit;			
	}
		
	if (!empty($_GET['del_id'])) {
		$arryCompany = $objCompany->GetCompany($_GET['del_id'],'');
		$CmpID   = $_GET['del_id'];				
	}


	/********Connecting to main database*********/
	$CmpDatabase = $Config['DbName']."_".$arryCompany[0]['DisplayName'];

	$Config['DbName2'] = $CmpDatabase;
	if(!$objConfig->connect_check()){
		$ErrorMsg = ERROR_NO_DB;
	}else{
		$Config['DbName'] = $CmpDatabase;
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
	}
	/*******************************************/

	$objConfigure=new configure();
	
	require_once("includes/footer.php"); 
?>
