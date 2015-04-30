<?php 
/**************************************************/
$ThisPageName = 'leadForm.php'; $HideNavigation = 1;
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
$objLead = new lead();

$arryLeadForm = $objLead->GetLeadWebForm('1');

require_once("../includes/footer.php"); 
?>

