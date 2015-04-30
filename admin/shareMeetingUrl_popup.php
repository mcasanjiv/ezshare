<?php  
$HideNavigation = 1;
require_once("includes/header.php");
$objMeeting=new Meeting();
	$ModuleName = "Meeting";
	
if (!empty($_GET['join'])) { 
    $arryMeeting = $objMeeting->GetMeeting($_GET['join'], '');
    $meetingId = $arryMeeting[0]['meetingId'];  
    if (empty($meetingId)) { 
    	$_SESSION['mess_meeting'] = 'This Meeting is not existed on server now!';
    }
     if ($_POST['Joinmeeting']) { 
     	
     	
     	$isMod = ($_POST['is_mod']=='on')? 1 : 0 ;
     	$password = ($isMod) ? $arryMeeting[0]['moderatorPw'] : $arryMeeting[0]['attendeePw'];
        $Name  = $_POST['userName']; 
        $meetingEmail  = $_POST['email'];
        $meetingName = $arryMeeting[0]['meetingName'];
		$url = $Config['url']."join-meeting.php?CName=$meetingName&Name=$Name&MeetingID=$meetingId&MType=".$isMod;

		$from = "sanjiv.singh@vstacks.in";
		$subject = 'meeting from ezShare!';
		$body = "Hi,\n\n Please click url for :"."<a href='.$url.'> join meeting $Name</a>";
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		if (mail("sanjivsingh80@gmail.com", "test", "testing")) {
			$objMeeting->joinMeeting($_POST,1);
			$_SESSION['mess_meeting'] = 'Message successfully sent!'; 
		}else{
			$_SESSION['mess_meeting'] = 'Mail sending Failed!'; 
		}
		$x = "dashboard.php";
		echo '<script language="javascript">window.parent.location.href="'.$x.'"</script>';
		exit;
  }
   		
}   
    
?>
			<div id='shareMeeting'  class="fancybox-outer">
				    
	   <form  method="post" id="sharemeeting-form" name="sharemeeting-form"  enctype="multipart/form-data">
	   <input  type="hidden" name="meetingId" value="<?=$arryMeeting[0]['meetingId']?>">
			<div class="had" align="center"> Invite People </div> 
			<div class="title" style="font-size:15px; text-align:center;"> 
                                  </div>
			   <table class="borderall" cellspacing="0" cellpadding="5" width="100%" border="0">
				    <tbody>
                     <tr>
                       <td class="blackbold" height="30" colspan="2">
                       <div id="msg_div" class="message"></div>
                       </td>
                     </tr>
                  
			    <tr>         
                <td class="blackbold" align="right" valign="top">Name : <span class="red">*</span></td>
                <td class="blacknormal" align="left" valign="top">
                <input  class="inputbox" name="userName" id="userName" value=""  required maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();">
                </td>
               </tr> 
               
                <tr>         
                <td class="blackbold" align="right" valign="top">Email : <span class="red">*</span></td>
                <td class="blacknormal" align="left" valign="top">
                <input  class="inputbox" name="email" id="email" value=""  required maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();">
                </td>
               </tr>  
               
               <tr>         
                <td class="blackbold" align="right" valign="top">IS Moderator :</td>
                <td class="blacknormal" align="left" valign="top">
                <input type="checkbox" name="is_mod" id="is_mod">
                <span>(Check if you want to send this for Moderator)</span>
                </td>
               </tr> 
               
                <tr>
              <td align="right" class="blackbold">&nbsp;</td>
              <td align="left">
              <input type="submit" class="button" value="Join Meeting"  name="Joinmeeting"></td>
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
    