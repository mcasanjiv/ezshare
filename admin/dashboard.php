<?php 

	$ThisPageName = 'dashboard.php'; $NavText=1;  
	require_once("includes/header.php");

	if($_SESSION['AdminType']!="admin"){
		$arryDepartment= $objConfig->GetAllowedDepartmentUser($_SESSION['UserID']);
		$NumAllowedDepartment = sizeof($arryDepartment);
	}
print_r($_SESSION);
 $objMeeting = new Meeting();
	/****************************/
	
	$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();
	$ModuleName = "Meeting";
   
    //$meeting = $objMeeting->GetMeeting();
    $RedirectUrl = "dashboard.php?curP=" . $_GET['curP'] . "&module=meeting";
    
	// Instatiate the BBB class:
$bbb = new BigBlueButton();

if (!empty($_GET['del_id'])) { 
	$arryMeetingDetail = $objMeeting->GetMeeting($_GET['del_id'], '');
	$meetingId=$arryMeetingDetail[0]['meetingId'];  
	$moderatorPw=$arryMeetingDetail[0]['moderatorPw'];  
	/* ___________ END A MEETING ______ */
/* Determine the meeting to end via meetingId and end it.
*/

$endParams = array(
	'meetingId' => $meetingId, 			// REQUIRED - We have to know which meeting to end.
	'password' => $moderatorPw,				// REQUIRED - Must match moderator pass for meeting.

);

// Get the URL to end a meeting:
$itsAllGood = true;
try {$result = $bbb->endMeetingWithXmlResponseArray($endParams);}
	catch (Exception $e) {
		$_SESSION['mess_meeting'] = 'Caught exception: '. $e->getMessage(). "\n";
		$itsAllGood = false;
	}

	if ($itsAllGood == true) {
		// If it's all good, then we've interfaced with our BBB php api OK:
		if ($result == null) {
			// If we get a null response, then we're not getting any XML back from BBB.
			$_SESSION['mess_meeting'] = "Failed to get any response. Maybe we can't contact the BBB server.";
		}	
		else { 
		// We got an XML response, so let's see what it says:
		print_r($result);
			if ($result['returncode'] == 'SUCCESS') {
				// Then do stuff ...
				$_SESSION['mess_meeting'] =  ">Meeting succesfullly ended.";
			}
			else {
				$_SESSION['mess_meeting'] = "Failed to end meeting.";
			}
		}
	}	
    $objMeeting->RemoveMeeting($_GET['del_id']);
    header("location:dashboard.php?module=meeting");
    exit;
}


   /* * **************************End Meeting Filter*************************************** */

	if(!empty($_GET['MeetingHistory'])){
		$arryMeeting=$objMeeting->getMeetingHistory();
	}else{
		$arryMeeting=$objMeeting->GetMeeting('', false);
	}
	//print_r($arryMeeting);
	$num=$objMeeting->numRows();
    //print_r($num);
	$pagerLink=$objPager->getPager($arryMeeting,$RecordsPerPage,$_GET['curP']);
	(count($arryMeeting)>0)?($arryMeeting=$objPager->getPageRecords()):("");

	
	$arryLocationMenu = $objConfigure->getLocation('',1); 
	$NumLocation = sizeof($arryLocationMenu); 

	require_once("includes/footer.php"); 
?>
