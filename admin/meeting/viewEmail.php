<?php 
/**************************************************************/
$ThisPageName = "sentEmails.php";
if(isset($_GET['type']) && $_GET['type']=="Draft"){
$ThisPageName = "draftList.php";	
} 
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
	if(isset($_GET['type']) && $_GET['type']=="Draft"){
		$RedirectURL = "draftList.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	}
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	


	$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 
        
       
        
        if(isset($_GET['ViewId']) && !empty($_GET['ViewId']))
        {
              
           $arrySentItems = $objImportEmail->SentItems($_SESSION['AdminEmail'],$_GET['ViewId']);
          	if($arrySentItems[0]['Status']){
          		$objImportEmail->updateSendMailStatus($_GET['ViewId']);
          	}
          	$arrySentItems = $objImportEmail->SentItems($_SESSION['AdminEmail'],$_GET['ViewId']);
           $num=$objImportEmail->numRows();
        }
		
 
	require_once("../includes/footer.php"); 	 
?>
