<?php  
$HideNavigation = 1;
require_once("includes/header.php");
$objMeeting=new Meeting();

/*    edit the meetings * ************** */
if (!empty($_GET['join'])) { 
    $arryMeetingDetail = $objMeeting->GetMeeting($_GET['join']);
    $meeting_Id = $_REQUEST['join']; 
    /*if (empty($arryMeeting[0]['meeting_Id'])) {
        header('location:' . $RedirectURL);
        exit;
    }*/
                $meetingName  = $arryMeetingDetail[0]['meetingName']; 
                
   				$_POST['userName'] = $_SESSION['UserName'];
   				$_POST['email'] = $_SESSION['AdminEmail'];
                $meetingId  = $_POST['meetingId'] = $arryMeetingDetail[0]['meetingId'];  
                $password    = $_POST['password'] = $arryMeetingDetail[0]['moderatorPw']; 
               $lastInsertId= $objMeeting->joinMeeting($_POST,1); 
              
              
				                // Instatiate the BBB class:
				$bbb = new BigBlueButton();
				
				/* ___________ JOIN MEETING w/ OPTIONS ______ */
				/* Determine the meeting to join via meetingId and join it.
				*/
				
				$joinParams = array(
					'meetingId' => $meetingId, 		    // REQUIRED - We have to know which meeting to join.
					'username' => $meetingName,		    // REQUIRED - The user display name that will show in the BBB meeting.
					'password' => $password,					// REQUIRED - Must match either attendee or moderator pass for meeting.
					'createTime' => '',					// OPTIONAL - string
					'userId' => '',						// OPTIONAL - string
					'webVoiceConf' => ''				// OPTIONAL - string
				);
				
				// Get the URL to join meeting:
				$itsAllGood = true;
				try {
					$result = $bbb->getJoinMeetingURL($joinParams);
				}
				catch (Exception $e) {
						echo 'Caught exception: ', $e->getMessage(), "\n";
						$itsAllGood = false;
				}
				
				if ($itsAllGood == true) {
					$objMeeting->updateMeetingStatus($lastInsertId);
					//Output results to see what we're getting:
					//print_r($result);
					$x = "dashboard.php";
					//header('Location: '.$result);
						//echo '<script language="javascript">window.open("' . $result . '","_blank");</script>';
						echo '<script language="javascript">window.parent.location.href="'.$result.'"</script>';
						exit;
				}	
}
   exit; 
    
?>

   	<div id='editMeeting'  class="fancybox-outer">
		      <form  method="post" id="schedulemeeting-form" name="schedulemeeting-form" class=""  enctype="multipart/form-data">
                        <div class="had">Join Meeting As A Moderator</div> 
                           
                       <table class="borderall" cellspacing="0" cellpadding="5" width="100%" border="0">
				    <tbody>
							 
                     <tr>
                       <td class="blackbold" height="30" colspan="2">
                       <div id="msg_div" class="message"></div>
                       </td>
                     </tr> 
                     
               <tr>         
              <td class="blackbold" align="right" valign="top">MeetingId : </td>
              <td class="blacknormal" align="left" valign="top">
              <input type="hidden"" name="Email" value="<?=$_SESSION['AdminEmail']?>">
              <input  class="inputbox" name="meetingId" id="meetingId" value="<?php echo stripslashes($arryMeetingDetail[0]['meetingId']); ?>" readonly>
               </td>
              </tr>
              
              <tr>         
              <td class="blackbold" align="right" valign="top">MeetingName : </td>
              <td class="blacknormal" align="left" valign="top">
              <input  class="inputbox" name="meetingName" id="meetingName" value="<?php echo stripslashes($arryMeetingDetail[0]['meetingName']); ?>" readonly>
               </td>
              </tr>
              
              <tr>         
              <td class="blackbold" align="right" valign="top">Password : </td>
              <td class="blacknormal" align="left" valign="top">
              <input  class="inputbox" name="password" id="password" value="<?php echo stripslashes($arryMeetingDetail[0]['moderatorPw']); ?>" readonly>
              </td>
              </tr>
              
               <tr>
              <td align="right" class="blackbold">&nbsp;</td>
              <td align="left">
              <input type="hidden" name="meetingId" value="<?=5000+time();?>">
	                         <? if ($_GET['join'] > 0) $ButtonTitle = 'Joinmeeting ';     
                              else $ButtonTitle = ' Submit '; ?>
                 <input type="hidden" name="meeting_Id" id="meeting_Id" value="<?= $_GET['join'] ?>" />                 
              <input type="submit" class="button" value=<?=$ButtonTitle?>  name="Joinmeeting"></td>
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
    