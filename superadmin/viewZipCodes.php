<?php 
	include_once("includes/header.php");
	require_once("../classes/region.class.php");
	$objRegion=new region();
	(!$_GET['country_id'])?($_GET['country_id']=1):(""); 
	$ModuleName = "Zip Code";

	$RedirectUrl = "viewZipCodes.php?country_id=".$_GET['country_id']."&state_id=".$_GET['state_id']."&city_id=".$_GET['city_id']."&curP=".$_GET['curP'];

	if($_POST){
		if(sizeof($_POST['zipcode_id']>0)){
			$zip = implode(",",$_POST['zipcode_id']);				
			$_SESSION['mess_zipcode'] = $ModuleName.$MSG[103];
			$objRegion->deleteMultiZipCode($zip);			
			header("location:".$RedirectUrl);
			exit;
		}
	}




	if($_GET['city_id']>0){	
		$arryRegion=$objRegion->getZipCodeByCity($_GET['city_id']);	
		$num=$objRegion->numRows();
	}	 
	$arryCountry = $objRegion->getCountry('','');	
	require_once("includes/footer.php"); 
?>
