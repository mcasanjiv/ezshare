<?php
	$ModuleID = 21;
	require_once("includes/header.php");
	require_once("../classes/region.class.php");
	
	$ModuleName = "State";
	
	$RedirectUrl = "viewStates.php?country=".$_GET['country']."&curP=".$_GET['curP'];

	if (class_exists(region)) {
	  	$objRegion=new region();
	} else {
  		echo "Class Not Found Error !! Region Class Not Found !";
		exit;
  	}


	 if($_GET['del_id'] && !empty($_GET['del_id'])){
		$_SESSION['mess_state'] = $ModuleName.$MSG[103];
		$objRegion->deleteState($_REQUEST['del_id']);
		header("location: ".$RedirectUrl);
		exit;
	}

	 if($_GET['active_id'] && !empty($_GET['active_id'])){
		$_SESSION['mess_state'] = $ModuleName.$MSG[104];
		$objRegion->changeStateStatus($_REQUEST['active_id']);
		header("location: ".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
	
		if (!empty($_POST['state_id'])) {
			$objRegion->updateState($_POST);
			$_SESSION['mess_state'] = $ModuleName.$MSG[102];
		} else {		
			$objRegion->addState($_POST);
			$_SESSION['mess_state'] = $ModuleName.$MSG[101];
		}
	
		$RedirectUrl = "viewStates.php?country=".$_POST['country_id']."&curP=".$_GET['curP'];
		header("location: ".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if($_GET['edit']>0)
	{
		$arryRegion = $objRegion->getState($_GET['edit'],'');
		extract($arryRegion[0]);
	}

	if($_GET['country']>0){
		$CountrySelected = $_GET['country'] ; 
	}else{
		$CountrySelected = 106;
	}

	$arryCountry = $objRegion->getCountry('','');

	 require_once("includes/footer.php"); 
	 
 ?>
