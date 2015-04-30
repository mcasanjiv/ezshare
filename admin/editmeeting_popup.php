<?php
$HideNavigation = 1;
require_once("includes/header.php");
$objMeeting=new Meeting();

/*    edit the meetings * ************** */
if (!empty($_GET['edit'])) { 
    $arryMeeting = $objMeeting->GetMeeting($_GET['edit'], '');
    $arryMeetingDetail = $objMeeting->GetMeeting($_GET['edit'], '');
   //print_r($arryMeeting) ; die('JI');
    $meeting_Id = $_REQUEST['edit']; 
    if (empty($arryMeeting[0]['meeting_Id'])) {
        header('location:' . $RedirectURL);
        exit;
    }
     if ($_POST['SubmitButton']) { 
                $createDate  = $_GET['createDate']; 
                $createtime  = $_GET['createtime']; 
                $duration    = $_GET['duration']; 
                $objMeeting->UpdateMeeting($_POST);
               
              //  $_SESSION['mess_lead'] = LEAD_UPDATED;
    } 
    
   
} 
?>

	<div id='editMeeting'  class="fancybox-outer">
			<form  method="post" id="schedulemeeting-form" name="schedulemeeting-form" class=""  enctype="multipart/form-data">
                          <div class="had"> Update Meeting  </div> 
			   <table class="borderall" cellspacing="0" cellpadding="5" width="100%" border="0">
				    <tbody>
                     <tr>
                       <td class="blackbold" height="30" colspan="2">
                       <div id="msg_div" class="message"></div>
                       </td>
                     </tr>
                            
              <tr>         
              <td class="blackbold" align="right" valign="top">Date of creating : </td>
              <td class="blacknormal" align="left" valign="top">
               <? if ($arryMeeting[0]['createDate'] > 0) $MeetingDate = $arryMeeting[0]['createDate']; ?>	
                                               <script type="text/javascript">                   
                                                     $(function() {
	                                                  $("#createDate").datepicker({
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
              <input type="text" id="createDate" name="createDate" class="datebox" value="<?= $MeetingDate ?>">
               </td>
              </tr>       
					    
			  <tr>         
              <td class="blackbold" align="right" valign="top">Time : </td>
              <td class="blacknormal" align="left" valign="top">
              <input  class="inputbox" name="createtime" id="createtime" value="<?php echo stripslashes($arryMeeting[0]['createtime']); ?>"  maxlength="20" onkeypress="ClearMsg();" onmousedown="ClearMsg();">
               </td>
              </tr>
              
              <tr>         
              <td class="blackbold" align="right" valign="top">Time Duration : </td>
              <td class="blacknormal" align="left" valign="top">
              <select class="inputbox" name="duration" id="duration" value="<?php echo stripslashes($arryMeeting[0]['duration']); ?>" style="width:240px">
                  <option value="<?php echo stripslashes($arryMeeting[0]['duration']); ?>"><?php echo stripslashes($arryMeeting[0]['duration']); ?> min</option>
                  <option value="20">20 min</option>
                  <option value="30">30 min</option>
                  <option value="60">60 min</option>
                  <option value="120">120 min</option>
                 <option value="180">180 min</option>
              </select>
               </td>
              </tr>
              
              <tr>
              <td align="right" class="blackbold">&nbsp;</td>
              <td align="left">
              <input type="hidden" name="meetingId" value="<?=5000+time();?>">
	                          <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update ';     
                                  else $ButtonTitle = ' Submit '; ?>
                <input type="hidden" name="meeting_Id" id="meeting_Id" value="<?= $_GET['edit'] ?>" />                   
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