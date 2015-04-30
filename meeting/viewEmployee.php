<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');
	require_once("../classes/employee.class.php");
	require_once("../classes/user.class.php");
	$ModuleName = "Employee";
	$objEmployee=new employee();
	$objUser=new user();
	
	$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();

	//$objEmployee->UpdateEmpEmail();

	/*************************/
	$arryEmployee=$objEmployee->ListEmployee($_GET);
	$num=$objEmployee->numRows();

	$pagerLink=$objPager->getPager($arryEmployee,$RecordsPerPage,$_GET['curP']);
	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	/*************************/
 
	require_once("includes/footer.php"); 	
?>


