<?php 

include ('includes/header.php');

    $objMeeting = new Meeting();
    //$meeting = $objMeeting->GetMeeting();
    $RedirectUrl = "dashboard.php?curP=" . $_GET['curP'] . "&module=meeting";

$bbb = new BigBlueButton();

$presentation = $_REQUEST['presentation']; 

//echo $presentation; //die(tgdd);
   /* * **************************End Meeting Filter*************************************** */

	$arryMeeting=$objMeeting->GetMeeting('', false);
	//print_r($arryMeeting);
	$num=$objMeeting->numRows();
    //print_r($num);
	$pagerLink=$objPager->getPager($arryMeeting,$RecordsPerPage,$_GET['curP']);
	(count($arryMeeting)>0)?($arryMeeting=$objPager->getPageRecords()):("");

include ('includes/footer.php');
 ?>