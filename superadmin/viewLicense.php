<?php 
	include_once("includes/header.php");
	require_once("../classes/license.class.php");
	$ModuleName = "License Key";
	$objLicense=new license();

	$arryLicense=$objLicense->ListLicense('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
	$num=$objLicense->numRows();

	$pagerLink=$objPager->getPager($arryLicense,$RecordsPerPage,$_GET['curP']);
	(count($arryLicense)>0)?($arryLicense=$objPager->getPageRecords()):("");


	require_once("includes/footer.php"); 	 
?>


