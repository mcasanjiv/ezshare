<?php 
$HideNavigation=1;
include_once("../includes/header.php");

	require_once($Prefix."classes/employee.class.php"); 
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objEmployee=new employee();
	$objphone=new phone();
	$server_id=1;
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
	$empid=!empty($_GET['empId'])?$_GET['empId']:0;
	
	if(!empty($empid)){
	$url='acl_cdr.php';
			  $extesion=!empty($allagentdata[$AgentByEmp[$empid]][3])?$allagentdata[$AgentByEmp[$empid]][3]:0;
	if(!empty($extesion))
			 $allcalldetail=$objphone->api($url,array('extension'=>$extesion));				 
		$empQuota =	$objphone->getEmpQuota($server_id,$empid);	
		
	}
	require_once("../includes/footer.php"); 	 
?>


