<?php 
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/

ValidateCrmSession();
$FancyBox = 0;
include ('includes/header.php');

require_once("../classes/company.class.php");
require_once("../classes/admin.class.php");

	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../includes/browser_detection.php");
	require_once("../classes/meeting.class.php"); 
	
	/*$Config['DbName'] = $_SESSION['CmpDatabase'];
	$objConfig->dbName = $Config['DbName'];
	$objConfig->connect();*/
	
	$ModuleName = "Meeting";
    $objMeeting = new Meeting();
    //$meeting = $objMeeting->GetMeeting();
    $RedirectUrl = "dashboard.php?curP=" . $_GET['curP'] . "&module=meeting";
    //echo $RedirectUrl;
     
 /* * **********End Meeting from server and Delete from Database********************************** */

// Require the bbb-api file:
require_once('includes/bbb-api.php');

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
		echo 'Caught exception: ', $e->getMessage(), "\n";
		$itsAllGood = false;
	}

	if ($itsAllGood == true) {
		// If it's all good, then we've interfaced with our BBB php api OK:
		if ($result == null) {
			// If we get a null response, then we're not getting any XML back from BBB.
			echo "Failed to get any response. Maybe we can't contact the BBB server.";
		}	
		else { 
		// We got an XML response, so let's see what it says:
		print_r($result);
			if ($result['returncode'] == 'SUCCESS') {
				// Then do stuff ...
				echo "<p>Meeting succesfullly ended.</p>";
			}
			else {
				echo "<p>Failed to end meeting.</p>";
			}
		}
	}	
    $objMeeting->RemoveMeeting($_GET['del_id']);
    header("location:dashboard.php?module=meeting");
    exit;
}


   /* * **************************End Meeting Filter*************************************** */

	$arryMeeting=$objMeeting->GetMeeting('', false);
	//print_r($arryMeeting);
	$num=$objMeeting->numRows();
    //print_r($num);
	$pagerLink=$objPager->getPager($arryMeeting,$RecordsPerPage,$_GET['curP']);
	(count($arryMeeting)>0)?($arryMeeting=$objPager->getPageRecords()):("");

include ('includes/footer.php');
 ?>