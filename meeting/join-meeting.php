<?php  
include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'dashboard.php'; $EditPage = 1;
/**************************************************************/
$FancyBox = 0;
include ('includes/header.php');

	require_once("../classes/admin.class.php");
	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../classes/meeting.class.php"); 
	
	$ModuleName = "Meeting";
    $objMeeting = new Meeting();
    /*echo $Config['DbName'] = $_SESSION['CmpDatabase'];
	echo $objConfig->dbName = $Config['DbName']; die;
	$_SESSION['mess_reset'] = ENTER_EMAIL;
	$objConfig->connect();*/
	if($_REQUEST) { 
		$CmpName = mysql_real_escape_string($_REQUEST['CName']);
		$MeetingID = mysql_real_escape_string($_REQUEST['MeetingID']);
		$MType = mysql_real_escape_string($_REQUEST['MType']); 
		$MeetingData = '';
		if(!empty($MeetingID) && !empty($CmpName)){  
			// Connect
			 $objConfig->dbName = $Config['DbName'].'_'.$CmpName; 
			 $objConfig->connect();
			 
              $MeetingData=$objMeeting->getMeetingId($MeetingID);
              if($MeetingData)
              {
              	$status = false;
              	if($_POST['submit']=='submit'){ 
	              	if($_REQUEST['MType']== Meeting::MEETING_MOD && $MeetingData['moderatorPw']!=Meeting::DEFAULT_MOD_PWD && $_POST['Password']==$MeetingData['moderatorPw']){
	              		//$joinmeetingId= $objMeeting->joinMeeting($_POST); 
	              		$status = $objMeeting->attendMeeting($MeetingID,$MeetingData['meetingName'],$_POST['Password']);
	              	}elseif($_REQUEST['MType']==Meeting::MEETING_ATTENDEE && $MeetingData['attendeePw']!=Meeting::DEFAULT_ATD_PWD && $_POST['Password']==$MeetingData['attendeePw']){
	              		$status = $objMeeting->attendMeeting($MeetingID,$MeetingData['meetingName'],$_POST['Password']);
	              	}else{ 
	              		$status = $objMeeting->attendMeeting($MeetingID,$MeetingData['meetingName'],$MeetingData['attendeePw']);
	              	}
	              	
              		if(!empty($status)){
	              		header("Location: ".$status);	
	              	}else{
	              		$_SESSION['mess_reset']='Not able to connect.';
	              	}
	              }
              }else {
	              	$_SESSION['mess_reset']='No Meeting is created for this organisation.';
	              }
              
              
		}else{
			$_SESSION['mess_reset'] = INVALID_EMAIL; 
		}
	}

include ('includes/footer.php');
 ?>
