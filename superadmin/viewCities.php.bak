<?php 
 	include_once("includes/header.php");
	require_once("../classes/region.class.php");


	if (class_exists(region)) {
	  	$objRegion=new region();
	} else {
  		echo "Class Not Found Error !! Region Class Not Found !";
		exit;
  	}

	
	(!$_GET['country_id'])?($_GET['country_id']=1):(""); 


	if($_GET['state_id']>0){	
		#$arryRegion=$objRegion->ListCity('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
		$arryRegion=$objRegion->getCityByState($_GET['state_id']);
		$num=$objRegion->numRows();
	}
	 
	 $arryCountry = $objRegion->getCountry('','');	

	 $arryStateIndia = $objRegion->getStateByCountry(1);

	 
	 require_once("includes/footer.php");
	 
?>
