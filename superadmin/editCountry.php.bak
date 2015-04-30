<?php
	$ModuleID = 20;
	require_once("includes/header.php");

	require_once("../classes/region.class.php");
	
	$ModuleName = "Country";
	
	if (class_exists(region)) {
	  	$objRegion=new region();
	} else {
  		echo "Class Not Found Error !! Region Class Not Found !";
		exit;
  	}

	 $RedirectUrl = "viewCountries.php?ch=".$_GET['ch'];


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_country'] = $ModuleName.$MSG[103];
		$objRegion->deleteCountry($_REQUEST['del_id']);
		header("location: ".$RedirectUrl);
		exit;
	}


	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_country'] = $ModuleName.$MSG[104];
		$objRegion->changeCountryStatus($_REQUEST['active_id']);
		header("location: ".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
	
		 $_GET['ch'] = strtoupper(substr($_POST['name'],0,1));

		if (!empty($_POST['country_id'])) {
			$objRegion->updateCountry($_POST);
			$_SESSION['mess_country'] = $ModuleName.$MSG[102];
		} else {	
	
			$objRegion->addCountry($_POST);
			$_SESSION['mess_country'] = $ModuleName.$MSG[101];
		}
	
		$RedirectUrl = "viewCountries.php?ch=".$_GET['ch'];
		header("location: ".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryRegion = $objRegion->getCountry($_GET['edit'],'');
		extract($arryRegion[0]);
	}

	#$arryContinent = $objRegion->getContinent('');


	require_once("includes/footer.php");
 
 ?>
