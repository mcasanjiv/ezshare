<?php

$FancyBox=1;
$ThisPageName = 'employeeConnect.php';
require_once("../../define.php");
require_once("../includes/header.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/dbfunction.class.php");
//ini_set('display_errors',1);
require_once($Prefix."classes/phone.class.php");
$objphone=new phone();

$callSetting = $objphone->GetcallSetting();

if($_POST){

		$addfolder_template = $objphone->CreateGroup($_POST['name']);
		//$_SESSION['mess_mass']='<div class="error">There is already a account. Please use another name.</div>';

}



require_once("../includes/footer.php"); 
?>






