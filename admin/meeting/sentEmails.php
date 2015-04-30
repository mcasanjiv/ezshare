<?php 
/**************************************************************/
$ThisPageName = ''; 
/**************************************************************/

	include_once("../includes/header.php");
	require_once($Prefix."classes/region.class.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix."classes/email.class.php");
	$objCommon=new common();
        $objImportEmail=new email();

	
	

	#$objContact=new contact();
	$objRegion=new region();
	$objEmployee=new employee();
	$objCustomer=new Customer(); 
	$ModuleName = "Email";
	
	$RedirectURL = "sentEmails.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	

	$EditUrl = "sentEmails.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 



	$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 
        
        
        
        $arrySentItems = $objImportEmail->SentItems($_SESSION['AdminEmail'],'');

        
        $num=$objImportEmail->numRows();

	$pagerLink=$objPager->getPager($arrySentItems,$RecordsPerPage,$_GET['curP']);
	(count($arrySentItems)>0)?($arrySentItems=$objPager->getPageRecords()):("");
		
 
	require_once("../includes/footer.php"); 	 
?>
