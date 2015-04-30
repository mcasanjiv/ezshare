<?php  
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/
IsCrmSession();
$FancyBox = 0;
include ('includes/header.php');

	require_once("../classes/company.class.php");
        require_once("../classes/cmp.class.php");

	$objCompany=new company();
        $objCmp=new cmp();
        
	if($_POST) { 

		if (empty($_POST['Email'])) {
			$_SESSION['mess_reset'] = ENTER_EMAIL;
		} else{
			$Email = mysql_real_escape_string($_POST['Email']); 

			$ArryUserEmail = $objConfig->CheckUserEmail($Email); 

			$CmpID = mysql_real_escape_string($ArryUserEmail[0]['CmpID']); 
	                

			if(empty($mess) && $CmpID>0){  // Admin 
                            
                              $status=$objCmp->IsActive($CmpID);
                              if($status[0]['status']==0)
                              {
                                 $objCmp->SendActivationMail($CmpID);
                                 $_SESSION['mess_reset']='Email sent, Please check your email';
                                  
                              }else {
                                  
                                  $_SESSION['mess_reset']='You are already activated';
                              }
                              

					
			}else{
				$_SESSION['mess_reset'] = INVALID_EMAIL; 
			}

		}

		
	}

include ('includes/footer.php');
 ?>
