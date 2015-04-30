<?php $HideNavigation = 1;
	require_once("includes/header.php");
$objMeeting=new Meeting();
	
	/*$objConfig=new admin();
	$objCompany=new company();
	$objUser=new user();
	$ModuleName = "Meeting";
	$objMeeting=new Meeting();
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();*/
				
if(!empty($_POST))
{ 
$meetingId    = $_POST['meetingId']; 
$meetingName  = $_POST['meetingName']; 
if (!empty($_POST['attendeePw'])) $attendeePw = $_POST['attendeePw']; 
else {$attendeePw = $_POST['attendeePw'] = Meeting::DEFAULT_ATD_PWD;} 
if (!empty($_POST['moderatorPw'])) $moderatorPw = $_POST['moderatorPw']; 
else { $moderatorPw = $_POST['moderatorPw'] = Meeting::DEFAULT_MOD_PWD;} 
$createdate   = $_POST['createdate']; 
$createtime   = $_POST['createtime']; 
$duration     = $_POST['duration']; 
$record    = $_POST['record']; 

$MeetingId = $objMeeting->addMeeting($_POST);



// Instatiate the BBB class:
$bbb = new BigBlueButton();

/* ___________ CREATE MEETING w/ OPTIONS ______ */
/* 
*/
$creationParams = array(
	'meetingId' => $meetingId, 				// REQUIRED
	'meetingName' => $meetingName, 	        // REQUIRED
	'attendeePw' => $attendeePw, 			// Match this value in getJoinMeetingURL() to join as attendee.
	'moderatorPw' => $moderatorPw, 			// Match this value in getJoinMeetingURL() to join as moderator.
	'welcomeMsg' => '', 					// ''= use default. Change to customize.
	'dialNumber' => '', 					// The main number to call into. Optional.
	'voiceBridge' => '', 					// PIN to join voice. Optional.
	'webVoice' => '', 						// Alphanumeric to join voice. Optional.
	'logoutUrl' => 'http://207.201.237.111:8888/ezshare/admin/dashboard.php', 						// Default in bigbluebutton.properties. Optional.
	'maxParticipants' => '-1', 				// Optional. -1 = unlimitted. Not supported in BBB. [number]
	'record' => $record , 					// New. 'true' will tell BBB to record the meeting.
	'duration' => $duration, 				// Default = 0 which means no set duration in minutes. [number]
	//'meta_category' => '', 				// Use to pass additional info to BBB server. See API docs.
);
//print_r($creationParams);
// Create the meeting and get back a response:
$itsAllGood = true;
try {$result = $bbb->createMeetingWithXmlResponseArray($creationParams);}
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
	//print_r($result);
		if ($result['returncode'] == 'SUCCESS') {
			// Then do stuff ...
			$x = "dashboard.php";
			$_SESSION['mess_meeting'] = "Meeting succesfullly created.";
			echo '<script language="javascript">window.parent.location.href="'.$x.'"</script>';
			exit;
		}
		
		else {
			echo "<p>Meeting creation failed.</p>";
		}
	}
}

}
  
?>
<script language="JavaScript">
/* enable the text box when checkbox checked
 */
function enableDisable(bEnable, textBoxID)
{
	alert(document.getElementById(textBoxID));
    document.getElementById(textBoxID).disabled = !bEnable
}
</script>


                                      
			<div id='inline_createMeeting' class="fancybox-outer" >
					        <form  name="form1" action=""  method="post"  class="" enctype="multipart/form-data">
					       <div class="had"> 
									Schedule New Meeting
                                  </div> 
				<table class="borderall" cellspacing="0" cellpadding="5" width="100%" border="0">
				    <tbody>
							 
                     <tr>
                       <td class="blackbold" height="30" colspan="2">
                       <div id="msg_div" class="message"></div>
                       </td>
                     </tr>
                                 
                   <tr>
                    <td width="45%" align="right" class="blackbold">MeetingName :<span class="red">*</span> </td>
                    <td align="left"><input type="text" class="inputbox" name="meetingName" id="meetingName" placeholder="Please Enter Meeting Name"  autocomplete="off" onmousedown="ClearMsg();" onkeypress="ClearMsg();" maxlength="20" value="" required>          
                    </td>
                   </tr>
               
               <tr>         
              <td class="blackbold" align="right" valign="top"> If Required Please checked. : </td>
              <td class="blacknormal" align="left" valign="top">
              <input type="checkbox" name=ischekedMod id="ischekedMod" onchange="document.getElementById('moderatorPw').disabled=!this.checked;"  >
               </td>
              </tr>  
                    
                         
              <tr>         
              <td class="blackbold" align="right" valign="top">Moderator Pw : </td>
              <td class="blacknormal" align="left" valign="top">
              <input type="text" style="
  border: 1px solid #DAE1E8;
  font-size: 12px;
  color: #232323;
  width: 187px;
  border-radius: 2px;
  padding: 4px;" name="moderatorPw" id="moderatorPw" disabled="" value="" placeholder="Please Enter moderatorPw.." maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();">
               </td>
              </tr>  
              
               <tr>         
              <td class="blackbold" align="right" valign="top"> If Required Please checked. : </td>
              <td class="blacknormal" align="left" valign="top">
              <input type="checkbox"  name=ischekedAttendee id="ischekedAttendee" onchange="document.getElementById('attendeePw').disabled=!this.checked;"  >
               </td>
              </tr>  
                    
                         
              <tr>         
              <td class="blackbold" align="right" valign="top">Attendee Password : </td>
              <td class="blacknormal" align="left" valign="top">
              <input type="text" style="
  border: 1px solid #DAE1E8;
  font-size: 12px;
  color: #232323;
  width: 187px;
  border-radius: 2px;
  padding: 4px;"  name="attendeePw" id="attendeePw" disabled="" value="" placeholder="Please Enter attendeePw.." maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();">
               </td>
              </tr>
              <tr>         
              <td class="blackbold" align="right" valign="top">Date of creating : </td>
              <td class="blacknormal" align="left" valign="top">
               <? if ($arryMeeting[0]['createdate'] > 0) $MeetingDate = $arryMeeting[0]['createdate']; ?>	
                                               <script type="text/javascript">                   
                                                     $(function() {
	                                                  $("#createdate").datepicker({
                                                        showOn: "both",
                                                        yearRange: '<?= date("Y") - 20 ?>:<?= date("Y") ?>',
                                                        dateFormat: 'yy-mm-dd',
                                                        minDate: "-0D",
                                                        maxDate: null,
                                                        changeMonth: true,
                                                        changeYear: true
                                                                });
                                                              });
                                                  </script>	
              <input type="text" id="createdate" name="createdate" class="datebox" value="<?= $LeadDate ?>">
               </td>
              </tr>  
                   
              <tr>         
              <td class="blackbold" align="right" valign="top">Time : </td>
              <td class="blacknormal" align="left" valign="top">
              <input  class="inputbox" name="createtime" id="createtime" value="<?= date("h:i:sa");?>" placeholder="Please Enter Created Time.." maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();">
               </td>
              </tr>
              
              <tr>         
              <td class="blackbold" align="right" valign="top">Time Duration : </td>
              <td class="blacknormal" align="left" valign="top">
               <select class="inputbox" name="duration" id="duration">
                                               <option value="20">20 min</option>
                                               <option value="30">30 min</option>
                                               <option value="60">60 min</option>
                                               <option value="120">120 min</option>
                                               <option value="180">180 min</option>
                                               </select>
               </td>
               </tr>
               
               <tr>         
              <td class="blackbold" align="right" valign="top">Meeting Type : </td>
              <td class="blacknormal" align="left" valign="top">
                <select class="inputbox" name="record" id="record">
                                               <option value="false">Normal Meeting</option>
                                               <option value="true">Recorded Meeting</option>
                                               </select>
               </td>
               </tr>
                  
										   
										 
			<tr>
              <td align="right" class="blackbold">&nbsp;</td>
              <td align="left">
              <input type="hidden" name="meetingId" value="<?=5000+time();?>">
	                           <? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle ='saveMeeting ';?>
              <input type="submit" class="button" value=<?=$ButtonTitle?>  name="saveMeeting"></td>
            </tr> 
             
             <tr>
              <td class="blackbold" colspan="2">&nbsp;</td>
            </tr>               
                 </tbody>         
                              </table>
							  </form>
                           </div>
                           
<script language="javascript1.2" type="text/javascript">
if(document.getElementById("load_div") != null){
	document.getElementById("load_div").style.display = 'none';
}
</script>      
  