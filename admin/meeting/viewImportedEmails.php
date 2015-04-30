<?php 
	include_once("../includes/header.php");
	//require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
        require_once($Prefix . "classes/filter.class.php");
        require_once($Prefix . "classes/email.class.php");
        $objFilter = new filter();
        //(empty($_GET['module'])) ? ($_GET['module'] = "Email") : ("");
	$ModuleName = "Email;";
	$objImportEmail=new email();
	$objCustomer=new Customer(); 
        
       

/* * **************************End Custom Filter*************************************** */
        $Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
	$objConfig->connect();       
        
        if(isset($_REQUEST['ownerId']) && !empty($_REQUEST['ownerId']))
        {  
	 $arryEmailsList=$objImportEmail->ListImportEmails($_REQUEST['ownerId']);
        }
        else{
            
            header("Location:viewImportEmailId.php");
            exit;
        }
         
	$num=$objImportEmail->numRows();

	$pagerLink=$objPager->getPager($arryEmailsList,$RecordsPerPage,$_GET['curP']);
	(count($arryEmailList)>0)?($arryEmailsList=$objPager->getPageRecords()):("");

	require_once("../includes/footer.php"); 	 
?>


