 
 <SCRIPT LANGUAGE=JAVASCRIPT>

function checkMeetingId(){
	
	$('.loading-image').show();
       var SendParam = $("#formMeeting").serializeArray();
       $.ajax({
			type: "POST",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
				if('Meeting not started Yet!'==$.trim(responseText)){
					$(".error").text(responseText);
           		}else if($.trim(responseText) != 'null' && responseText!=2){ 
					window.location.href = responseText;
				}else if(responseText=='null') {
					$('.loading-image').hide();
				}else{
					$('.loading-image').html('Error! Try again.');
				}

			}
      });
       return false;
}
</SCRIPT>
                     
<div>
			<section id="mainContent">
			<?php //echo $datah['Content'];?>
				<div class="InfoText">
					<div class="wrap clearfix">
						<article id="leftPart">
							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>
										<h1 id="page-title" class="title">My Dashboard</h1>
										
		<div class="message_success"  id="msg_div" align="center"><?// if(!empty($_SESSION['mess_dash'])) {echo $_SESSION['mess_dash']; unset($_SESSION['mess_dash']); }?></div>								
										
										<div class="tabs">
											<h2 class="element-invisible">Primary tabs</h2>
											<ul class="tabs primary">
											<li class="active"><a href="dashboard.php">Dashboard</a></li>
												<li><a href="myprofile.php">My Profile</a></li>
												<li><a  href="payment-history.php">Payment History<span
														class="element-invisible">(active tab)</span> </a></li>
												<li><a href="change_password.php">Change Password</a></li>
												<li><a href="meeting_popup.php?pop=1" target="_blank" class="fancybox fancybox.iframe">Schedule Meeting</a></li>
											</ul>
										</div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">
                                            <div id="msg_div" class="message"><?=$mess?></div>

												<div class="content">
													<div class="error">
													<?php echo $error;?>
														
													</div>
													<form accept-charset="UTF-8" id="user-login" method="post"
														action="" novalidate="novalidate" name="form1" id="form1" onsubmit="return validateLogin(this);" style="display:none;">
														<div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name" class="in-field-labels-processed">
																	User E-mail address <span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="text" class="form-text required" maxlength="80"
																	size="60" value="" name="LoginEmail" id="LoginEmail">
																<div class="description">You may login with either your
																	assigned username or your e-mail address.</div>
															</div>
															<div class="form-item form-type-password form-item-pass">
																<label for="edit-pass" class="in-field-labels-processed">Password
																	<span title="This field is required."
																	class="form-required">*</span> </label> <input
																	type="password" class="form-text required"
																	maxlength="30" size="60" name="LoginPassword" id="LoginPassword">
																<div class="description">The password field is case
																	sensitive.</div>
															</div>
															
															<div id="edit-actions" class="form-actions form-wrapper">
																<input type="submit" class="form-submit" value="Log in"
																	name="submit" id="submit">
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</article>
					</div>
				</div>
				
<!--  join a meeting button -->            
	            <div class="content jointameet wrap">
					
					<form name="form1" action="" id="formMeeting" method="post" onsubmit="return checkMeetingId();">
						<div>
	
							<div class="form-item form-type-password form-item-pass">
								<label for="edit-pass" class="in-field-labels-processed">
								<input name="action" type="hidden" value="JoinMeeting" />
									 <input name="meetingId" type="text" placeholder="Enter a 9-digit Meeting Id" class="inputbox" id="meetingIdInput"  maxlength="10">
									 <input type="submit" class="form-submit" value="Join" name="JoinMeeting" id="submit">
							</div>
						</div>
					</form>
				</div>
<!--  join a meeting button -->	            
            
            
            
				<table WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
  
    <tr>
        <td  valign="top">
            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
<? //if ($_GET["customview"] == 'All') { echo "hii";?>
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                              <td width="0%"  class="head1" >S.No.</td>
                                 <td width="10%"  class="head1" >MeetinId</td>
                                <td width="15%"  class="head1" >Create Time</td>
                                <td width="20%"  class="head1" >MeetingName</td>
                                <td width="10%"  class="head1" >Time Duration</td>
                                <td width="10%"  class="head1" >Moderator Pwd</td>
                                <td  width="10%"  class="head1" >Attendee Pwd</td>
                              <!--<td width="6%"  align="center" class="head1" >Status</td> -->
                                <td width="20%"  align="center"  class="head1 head1_action" >Action</td>
                            </tr>
<? //} else { ?>
                         <!--    <tr align="left"  >
                                <? //foreach ($arryColVal as $key => $values) { ?>
                                    <td width=""  class="head1" ><?= $values['colname'] ?></td>

                            <? //} ?>
                                <!-- <td width="10%"  align="center"  class="head1 head1_action" >Action</td> 
                            </tr> -->

                        <?// } ?>
                        <?php 
	                       if (is_array($arryMeeting) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryMeeting as $key => $values) {
                                $flag = !$flag;
                                $Line++; 
	                         ?> 
                                <tr align="left"  bgcolor="<?//= $bgcolor ?>">
                                        <?// if ($_GET["customview"] == 'All') { ?> 
                                        <!--<td ><input type="checkbox" name="AddID[]" id="AddID<?= $Line ?>" value="<?= $values['AddID'] ?>" /></td>-->
                                         <td ><?= $Line ?></td>
                                         <td ><a><?= stripslashes($values["meetingId"]) ?></a></td>
                                         <td ><a><?= stripslashes($values["createtime"]) ?></a></td>
                                         <td><?php if(@$values["record"]=='true'){ 
                                         	echo '<a href="getRecordings.php?meetingId='.$values['meetingId'].'" title="Get Recording">'.$values["meetingName"].'</a>';} 
                                         	else echo stripslashes($values["meetingName"]) ?>
                                         	<?php // echo $_SESSION['CrmDisplayName']; ?></td>
                                         <td><?= stripslashes($values["duration"]) ?></td>
                                         <td><?= stripslashes($values["moderatorPw"]) ?></td>
                                         <td><?= stripslashes($values["attendeePw"]) ?></td>
                                        
                                        <!--<td><? //echo '<a href="mailto:' . $values['Email'] . '">' . $values['Email'] . '</a>'; ?></td>

                                        <td ><?//= (!empty($values['Title'])) ? (stripslashes($values['Title'])) : (NOT_SPECIFIED) ?></td>
                                        <td ><? //if (!empty($values['AssignTo'])) { ?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?//= $values['EmpID'] ?>"><?//= stripslashes($values['AssignTo']) ?></a><? //} else {
                                //echo NOT_ASSIGNED;
                          //  } ?>
                            </td>

                                        <td align="center" >
                                            <?
                                            if ($values['Status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'InActive';
                                            }

                                            echo '<a href="editContact.php?active_id=' . $values["AddID"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            ?></td> -->
                                        <?
                                  /*  } else {

                                        foreach ($arryColVal as $key => $cusValue) {
                                            echo '<td>';
                                            if ($cusValue['colvalue'] == 'DepositDate') {

                                                if ($values[$cusValue['colvalue']] > 0) {
                                                    echo date($Config['DateFormat'], strtotime($values[$cusValue['colvalue']]));
                                                } else {
                                                    echo NOT_SPECIFIED;
                                                }
                                            } else if ($cusValue['colvalue'] == 'Status') {

                                                if ($values[$cusValue['colvalue']] == 1) {
                                                    $status = 'Active';
                                                } else {
                                                    $status = 'InActive';
                                                }

                                                echo '<a href="editContact.php?active_id=' . $values["AddID"] . '&module=' . $_GET["module"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '"    onclick="Javascript:ShowHideLoader(\'1\',\'P\');">' . $status . '</a>';
                                            }else if($cusValue['colvalue'] == 'CustID'){ 
                                               
                                                if(!empty($values['CustID'])){ echo $values['CustomerName'];}else{ echo NOT_SPECIFIED;}
                                                
                                            } else if ($cusValue['colvalue'] == 'AssignTo') {
                                                if (!empty($values['AssignTo'])) {
                                                    ?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>"><?= stripslashes($values['AssignTo']) ?></a><? } else {
                                                echo NOT_ASSIGNED;
                                           } ?>


                                        <? } else { ?>

                                            <?= (!empty($values[$cusValue['colvalue']])) ? (stripslashes($values[$cusValue['colvalue']])) : (NOT_SPECIFIED) ?> 
                <?
                }
                echo '</td>';
            }
        }*/
        ?>
     <td  align="center" class="head1_inner" >
     <!-- <a href="vContact.php?view=<?= $values['AddID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>--> 
        <a title="edit meeting" href="editmeeting_popup.php?edit=<?= $values['meeting_Id'] ?>&curP=<?= $_GET['curP'] ?>pop=1" target="_blank" class="fancybox fancybox.iframe"><?= $edit ?></a>
        <a title="delete meeting" href="dashboard.php?del_id=<?php echo $values['meeting_Id']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>
       <?php 
       if(!empty($values['loginUrl'])){
       				$url = $values['loginUrl']; 
       				$fancy1 = '';
       		 }else{
       		 	$url = "getJoinMeetingUrlModerator_popup.php?join=".$values['meeting_Id']."&view=".$values['meeting_Id']."&pop=1";
       		 	$fancy1 = 'fancybox fancybox.iframe';
       		 }
       
       ?>
        <a title="join meeting" href="<?=$url?>" target="_blank" class="<?=$fancy1?>"><?= $view ?>Joinmeeting</a> 
        <a title="join meeting" href="getJoinMeetingUrlAttendee_popup.php?join=<?= $values['meeting_Id'] ?>&curP=<?= $_GET['curP'] ?>pop=1" target="_blank" class="fancybox fancybox.iframe"><?= $view ?>GetUrlAttendee</a>   
      </td>
      </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryMeeting) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryMeeting)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>


</section> 
		
		
		
			
			