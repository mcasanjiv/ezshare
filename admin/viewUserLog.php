<?php 
	include_once("includes/header.php");
	require_once("../classes/user.class.php");

	$objUser=new user();
	/****************************/
	function time_diff_total($s){
		$m=0;$hr=0;$d=0; $td=$s." sec";

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			//$td = "$d day"; 
			if($d>1) $td .= "s";
			if($d<3){
				//if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		//if($s>0) $td .=  " $s sec";

		return $td;
	} 
	/****************************/
	$CmpID   = $_SESSION['CmpID'];
	$RedirectUrl = 'viewUserLog.php?curP='.$_GET['curP'].'&mode='.$_GET['mode'];
	/*******************************************/			
	if(sizeof($_POST['loginID'])>0){
		$loginIDs = implode(",",$_POST['loginID']);
		$_SESSION['mess_log'] = USER_KICKED;
		$objUser->KickUser($loginIDs);
		header("location:".$RedirectUrl);
		exit;
	}
	/*******************************************/		
	$arryUserLog=$objUser->GetUserLog($_GET);
	$num=$objUser->numRows();
	$RecordsPerPage = 100;
	$pagerLink=$objPager->getPager($arryUserLog,$RecordsPerPage,$_GET['curP']);
	(count($arryUserLog)>0)?($arryUserLog=$objPager->getPageRecords()):("");

	
	$viewAll = 'viewUserLog.php?curP='.$_GET['curP'];
	require_once("includes/footer.php"); 	 
?>


