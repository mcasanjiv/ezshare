<?php 
	include_once("includes/header.php");
		
	 if($_GET['att']>0){	
		$arryAtt=$objConfig->getAttribute('',$_GET['att'],'');
		$num=sizeof($arryAtt);
	 }	 
	$arryAttribute=$objConfig->AllAttributes($_GET['att']);  
	$ModuleName = $arryAttribute[0]["attribute"];
	 require_once("includes/footer.php");
?>

