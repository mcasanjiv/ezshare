<?php 
/******************************/
/******************************/
require_once("includes/config.php");
if(!empty($_GET["c"])){
	$arrCmp = explode("/",$_GET["c"]);
	if($arrCmp[1]==$Config['AdminFolder']){
		$AdminUrl = $Config['Url'].$Config['AdminFolder']."/?c=".$arrCmp[0];
		header("location:".$AdminUrl);
		exit;
	}else if($arrCmp[1]==$Config['EmpFolder']){
		$AdminUrl = $Config['Url'].$Config['AdminFolder']."/?c=".$arrCmp[0]."&t=e";
		header("location:".$AdminUrl);
		exit;
	}
}
$IndexPage = 1;
/******************************/
/******************************/
 
require_once("includes/header.php");
 
include_once("includes/header_menu.php");

require_once("classes/company.class.php");
$objCompany=new company();

 $arryProductFeatured=$objProduct->GetFeaturedProducts($settings);
 
 $num=$objProduct->numRows();
 

require_once("includes/footer.php"); 
 ?>


