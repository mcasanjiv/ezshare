<?php
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');

require_once("../classes/region.class.php");
require_once("../classes/cmp.class.php");
		
		$Config['DbName'] = $Config['DbMain'];
        $objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		
$objRegion=new region();
$objCmp=new cmp();
$arryCountry = $objRegion->getCountry('','');
$CmpID=$_SESSION['CrmAdminID'];
$arryCompany= $objCmp->getCompanyById($CmpID);

//print_r($arryCompany);
if(isset($_POST['submit'])){

	$cidMsg=$objCmp->UpdateProfile($_POST,$CmpID);
	
		$_SESSION['mess_company_success']=PROFILE_UPDATED;
		header("location: myprofile.php");
	    exit;
	
}

include ('includes/footer.php');
?>
