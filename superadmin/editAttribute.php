<?php
	require_once("includes/header.php");
	

	$RedirectUrl ="viewAttribute.php?att=".$_GET['att'];

	if(empty($_GET['att'])){
		header("location: viewAttribute.php?att=1");
		exit;
	}

	$arryAttribute=$objConfig->AllAttributes($_GET['att']);  
	$ModuleName = $arryAttribute[0]["attribute"];
	

	if(!empty($_GET['del_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[103];
		$objConfig->deleteAttribute($_REQUEST['del_id']);
		header("location:".$RedirectUrl);
		exit;
	}


	 if(!empty($_GET['active_id'])){
		$_SESSION['mess_att'] = $ModuleName.$MSG[104];
		$objConfig->changeAttributeStatus($_REQUEST['active_id']);
		header("location:".$RedirectUrl);
		exit;
	}
	
	

	if ($_POST) {
	
		if (!empty($_POST['value_id'])) {
			$objConfig->updateAttribute($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[102];
		} else {		
			$objConfig->addAttributes($_POST);
			$_SESSION['mess_att'] = $ModuleName.$MSG[101];
		}
	
		$RedirectUrl ="viewAttribute.php?att=".$_POST['attribute_id'];
		header("location:".$RedirectUrl);
		exit;
		
	}
	
	$Status = 1;
	if(isset($_GET['edit']) && $_GET['edit'] >0)
	{
		$arryAtt = $objConfig->getAttribute($_GET['edit'],'','');
		
		$attribute_value = stripslashes($arryAtt[0]['attribute_value']);
		$Status   = $arryAtt[0]['Status'];
	}




	 require_once("includes/footer.php"); 
 
?>
