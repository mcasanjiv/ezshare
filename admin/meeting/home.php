<?php
	require_once("../includes/header.php");
    require_once($Prefix."classes/lead.class.php");
 	require_once($Prefix."classes/quote.class.php");
 	require_once($Prefix."classes/employee.class.php");        
    require_once($Prefix."classes/event.class.php"); 
    require_once($Prefix."classes/dbfunction.class.php");
    require_once($Prefix."classes/phone.class.php");
    $objphone=new phone();
 	$objEmployee=new employee();

	$ModuleName = "Dashboard";
$server_id=1;
	$objLead=new lead();
$objQuote=new quote();
$objActivity=new activity();



/**************My New Lead*************/

      $arryMyLead=$objLead->GetDashboardLead();
	  $num1=$objLead->numRows();

 /**************End New Ticket*************/
$arryTicket=$objLead->GetDashboardTicket();

	  $num2=$objLead->numRows();
 /**************Top Opportunities*************/

      $arryTopOpp=$objLead->GetDashboardOpportunity();
     
	  $num3=$objLead->numRows();

 /**************End New Opportunities*************/
$arryCompaign=$objLead->GetDashboardCompaign();


	  $num4=$objLead->numRows();

$arryQuote=$objQuote->GetDashboardQuote();


	  $num5=$objQuote->numRows();

 /************************************/

$arryActivity=$objActivity->GetActivityDeshboard();


	  $num6=$objActivity->numRows();
	  
	
	  /******************For Call******************/
	  $agents=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=$allcalldetail=$empQuota=array();
	$agents=$objphone->api('acl_users.php',array());	
	$saveagents=$objphone->getCallRegiUserid($server_id,true);	
	$saveemp=$objphone->getCallRegiUserid($server_id);	
	$regisData=$objphone->getCallRegisData($server_id);
	
	if(!empty($regisData)){
		foreach($regisData as $regisDat){
			$AgentByEmp[$regisDat->user_id]=$regisDat->agent_id;
		}
	}
	
	if(!empty($agents)){
		foreach($agents as $agen){	
			$AnameByAid[$agen[0]]=$agen[2];
			$allagentdata[$agen[0]]=$agen;
		}	
	}
	  
	  $arryEmployee=$objEmployee->ListEmployee($_GET);
	  $num6=$objEmployee->numRows();

	$pagerLink=$objPager->getPager($arryEmployee,10,$_GET['curP']);
	(count($arryEmployee)>0)?($arryEmployee=$objPager->getPageRecords()):("");
	$empid=0;
	print_R($Config);
	if($_SESSION['AdminType'] == "admin")
	$empid=$_GET['empId'];
	else
	$empid=$_SESSION['AdminID'];
	if(!empty($empid)){
	$url='acl_cdr.php';
			  $extesion=!empty($allagentdata[$AgentByEmp[$empid]][3])?$allagentdata[$AgentByEmp[$empid]][3]:0;
	if(!empty($extesion))
			 $allcalldetail=$objphone->api($url,array('extension'=>$extesion));		

			 
		$empQuota =	$objphone->getEmpQuota($server_id,$empid);	
		
	}
 	 


	 

	require_once("../includes/footer.php"); 
?>
