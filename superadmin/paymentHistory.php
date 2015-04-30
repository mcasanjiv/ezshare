<?php 
	include_once("includes/header.php");
	require_once("../classes/superAdminCms.class.php");
        
	  $supercmsObj=new supercms();
	  
	 if (is_object($supercmsObj)) {
	 	$arryOrderHistory=$supercmsObj->getPaymentHistory($_GET['key'],$_GET['sortby'],$_GET['asc']);
		$num=$supercmsObj->numRows();

}
 require_once("includes/footer.php"); 	 
?>
