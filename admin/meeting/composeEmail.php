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
	
	$RedirectURL = "viewImportEmailId.php?curP=".$_GET['curP']."&module=".$_GET["module"];
	//$RedirectURL = "viewContact.php?curP=".$_GET['curP'];
	

	$EditUrl = "editImportEmailId.php?edit=".$_GET["view"]."&module=".$_GET["module"]."&curP=".$_GET["curP"]."&tab="; 



	$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect(); 
        
         
        
        if(isset($_POST[Submit]))
        {
              
           // print_r($_POST); 
            
            
            $objImportEmail->sendEmailToUser($_POST);
            $_SESSION['mess_emailSent'] = 'Email has been sent successfully';
            unset($_SESSION['attcfile']);
        }
        
        if(!empty($_GET['ViewId'])){
        	$arryComposeItems = $objImportEmail->editComposeMail($_GET['ViewId']);
        }
		
 
	require_once("../includes/footer.php"); 	 
?>
