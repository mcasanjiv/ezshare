<?php 
$FancyBox = 1;
$HideNavigation = 1;
/**************************************************************/
$ThisPageName = 'composeEmail.php'; $EditPage = 1;
/**************************************************************/
      
	include_once("../includes/header.php");
	#require_once($Prefix."classes/contact.class.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/crm.class.php");
	require_once($Prefix."classes/sales.customer.class.php");
    require_once($Prefix."classes/email.class.php");
	$objCommon=new common();
        $objImportEmail=new email();

	//$objContact=new contact();
	$objEmployee=new employee();
	$objCustomer=new Customer();  
	$ModuleName = "Contact";
	$RedirectURL = $_SERVER['PHP_SELF']."?module=".$_GET['module']."&curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="basic";

	$EditUrl = "editImportContactList.php?edit=".$_GET["edit"]."&module=".$_GET['module']."&curP=".$_GET["curP"]."&tab="; 
	$ActionUrl = $EditUrl.$_GET["tab"];
        
	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_contact'] = 'Contact has been deleted successfully';
                
		$objImportEmail->RemoveContactId($_GET['del_id']);
		header("Location:".$RedirectURL);
	}

	
	 if ($_POST) {
            	  if(empty($_POST['AddID']))
                  {
                    $_POST['CrmContact']=1;
					$datar = $objCustomer->addCustomerAddressViaEmail($_POST,$CustID); 
                    if($datar=='AlreadyExist')
                    {
                       $_SESSION['mess_contact'] = 'Email already exist.'; 
                    }
                    else {
                         $_SESSION['mess_contact'] = 'Added Successfully. '; 
                    }
                  }else {
                  	$_POST['CrmContact']=1;
                       $datar=$objCustomer->editCustomerAddressViaEmail($_POST); 
                       if($datar=='AlreadyExist')
                    {
                       $_SESSION['mess_contact'] = 'Updated Successfully'; 
                    }
                    else {
                         $_SESSION['mess_contact'] = 'Added Successfully'; 
                    }    
                  }
                  
				echo '<script> $.fancybox.close();</script>';
		}
		
	
	if (!empty($_GET['edit'])) {
		 $arryEmailId = $objCustomer->GetContactId(urldecode($_GET['edit']));
		/* print_r($arryEmailId);
		$AddID   = $_REQUEST['edit'];	
		if(empty($arryEmailId [0]['conId'])) {
                        echo "dfdfdf"; exit;
			header('location:'.$RedirectURL);
			exit;
		}*/
	}
		
	if($arryEmailId [0]['status'] != ''){
		$ContactStatus = $arryEmailId [0]['status'];
	}else{
		$ContactStatus = 1;
	}				
	
	$_GET['Status']=1;$_GET['Division']=5;

	require_once("../includes/footer.php"); 	 
?>
