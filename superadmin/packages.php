<?php 
include_once("includes/header.php");
require_once("../classes/superAdminCms.class.php");
require_once("../classes/class.validation.php");
	(!$_GET['curP'])?($_GET['curP']=1):(""); // current page number
                           if (class_exists(supercms)) {
	  	$supercms=new supercms();
	} else {
  		echo "Class Not Found Error !! supercms Class Not Found !";
		exit;
  	}
  	              //$packTpData=$supercms->getPackFeatureList();
  	               $currencies=$supercms->getCurrenct();
  	               $packl=$supercms->getPackTypeList();
  	               $packFeatureLt=$supercms->getPackFeatureList();
  	               
  	             //echo "<pre>"; print_r($currencies);
  	
                 $id = isset($_REQUEST['edit'])?$_REQUEST['edit']:"";
               
                  if ($id && !empty($id)) {$ModuleTitle = "Edit Page";}else{$ModuleTitle = "Add Page";}
                        $ModuleName = 'Package Feature&nbsp;';
                        $ListTitle  = 'Pages';
                        $ListUrl    = "managePackages.php?curP=".$_GET['curP'];
                       
               
                    if (!empty($id)) 
                    {
                      
                           $arryPage = $supercms->getpackageById($id);
                            // print_r($arryPage);
                           
                       
                           $arr = unserialize($arryPage[0]['features']);
                           // print_r($arr);
                         
                    }

			
		 	 
                  if(!empty($_GET['active_id'])){
		$_SESSION['mess_packages'] = PACKAGES_STATUS_CHANGED;
		$supercms->changePackstatus($_REQUEST['active_id']);
		header("location:".$ListUrl);
	 }
	

	                     if(!empty($_GET['del_id'])){
             
                                $_SESSION['mess_packages'] = PACKAGES_REMOVED;
                                $supercms->deletePack($_GET['del_id']);
                                header("location:".$ListUrl);
                                exit;
	                        }
	

 	if (is_object($supercms)) {	
		 
		 if (!empty($_POST)) {
		 	
     $data=array();
	$data=$_POST;
	//print_r($_POST);

    $str = serialize($_POST['feature']);
  
	$errors=array();
	$validatedata=array(	
	'name'=>array(array('rule'=>'notempty','message'=>'Please Enter The Name')),
	//'price'=>array(array('rule'=>'number','message'=>'Please Enter Number Only')),
	//'allow_users'=>array(array('rule'=>'number','message'=>'Please Enter Number Only')),
	//'space'=>array(array('rule'=>'number','message'=>'Please Enter Number Only')),
	//'additional_spaceprice'=>array(array('rule'=>'number','message'=>'Please Enter Number Only'))
	
	
	//'duration'=>array(array('rule'=>'notempty','message'=>'Please Enter The Duration')),


	

		)	;
		$objVali->requestvalue=$data;
		$errors  =	$objVali->validate($validatedata);
	
		 if(empty($errors)){
		 	
		 		 	       if (!empty($id)) {
echo 
		 		 	       	                  $_SESSION['mess_packages'] = PACKAGES_UPDATED;
                                                    $supercms->updatePackges($_POST,$str);
                                                  
                                                    header("location:".$ListUrl);
                                            } else {
                                            	
							   
                                                    $_SESSION['mess_packages'] = PACKAGES_ADDED;
                                                    $lastShipId = $supercms->addPackages($_POST,$str);	
                                                   
                                                   header("location:".$ListUrl);
                                                 
                                            }

                                            exit;
		}
	
		}

                
                              
}
	
		
	require_once("includes/footer.php"); 	 
?>


