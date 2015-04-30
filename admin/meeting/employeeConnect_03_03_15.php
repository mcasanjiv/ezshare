<?php 	
	/**************************************************/
	$ThisPageName = 'employeeConnect.php'; 
	/**************************************************/
	include_once("../includes/header.php");
	require_once($Prefix."classes/employee.class.php");
	require_once($Prefix."classes/dbfunction.class.php");
	require_once($Prefix."classes/phone.class.php");
	$objEmployee=new employee();
	$objphone=new phone();
	$server_id=1;

	/*if($_GET["dv"]=='7'){
		$_GET["dv"] .= ',5,6';
	}*/
	
	$agents=$saveagents=$AgentByEmp=$AnameByAid=$allagentdata=$allemployeedata=array();
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
	$PageHeading = 'CRM Employee';
	if(!empty($_GET['del_id'])){
		$delId=base64_decode($_GET['del_id']);	
		$objphone->delete('c_callUsers',array('id'=>$delId));
		header('Location: employeeConnect.php');
		exit;
	}
	
	if(!empty($_POST))
	{		
	
			if(!empty($_POST['empdata'][0]['EmpID']) AND !empty($_POST['empdata'][0]['agentID'])){
				$savesdetail=	$objphone->connectCallServer($_POST['empdata'],$server_id);
				$_SESSION['mess_phone']='Save Successfully';
			}else{
					$_SESSION['mess_phone']='Please Select Requried Fields';
			}
			header('Location: employeeConnect.php');
			exit;
		
	}
	unset($arryInDepartment);
	$arryInDepartment = $objConfigure->GetSubDepartment($_GET["dv"]);
	$numInDept = sizeof($arryInDepartment);
	if($_GET["dv"]>0){
		$arryDepartmentRec = $objConfigure->GetDepartmentInfo($_GET["dv"]);
		//$PageHeading .= ' from '.$arryDepartmentRec[0]['Department'];
	}



	/*************************/
	if($numInDept>0){
		if($_GET["d"]>0) $_GET["Department"] = $_GET["d"];
		if($_GET["dv"]>0) $_GET["Division"] = $_GET["dv"];
		$arryEmployee = $objEmployee->GetEmployeeList($_GET);
		$num=$objEmployee->numRows();
		if(!empty($arryEmployee)){
		foreach($arryEmployee as $k=>$value)
				$allemployeedata[$value['EmpID']]=$value;
		}
		
	}else{
		$ErrorMSG = NO_DEPARTMENT;
	}

	
	/*************************/
 
	
	require_once("../includes/footer.php"); 	
?>


