              
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
											<li><a href="dashboard.php">Dashboard</a></li>
												<li><a href="index.php?slug=my-profile">My Profile</a></li>
												<li><a  href="index.php?slug=payment-history">Payment History<span class="element-invisible">(active tab)</span> </a></li>
												<li><a href="index.php?slug=change-password">Change Password</a></li>
												<li><a href="meeting_popup.php?pop=1" target="_blank" class="fancybox fancybox.iframe">Schedule Meeting</a></li>
												<li class="active"><a href="recordmeeting.php" target="" >Recorded Meeting</a></li>
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
			</section> 
			
		</div>
      </div><!-- dashboard-container -->
    </div><!-- container-fluid -->
		<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
  
    <tr>
        <td  valign="top">
            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
<? //if ($_GET["customview"] == 'All') { echo "hii";?>
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <td width="10%"  class="head1" >S.No.</td>
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
                                        <?php if($values["record"]=='true'){?>
                                        <!--<td ><input type="checkbox" name="AddID[]" id="AddID<?= $Line ?>" value="<?= $values['AddID'] ?>" /></td>-->
                                         <td ><?= $Line ?></td>
                                         <td ><a><?= stripslashes($values["createtime"]) ?></a></td>
                                         <td><?php echo stripslashes($values["meetingName"]) ?>
                                         	<?php// echo $_SESSION['CrmDisplayName']; ?></td>
                                         <td><?= stripslashes($values["duration"]) ?></td>
                                         <td><?= stripslashes($values["moderatorPw"]) ?></td>
                                         <td><?= stripslashes($values["attendeePw"]) ?></td>
     <td  align="center" class="head1_inner" >
     <!-- <a href="vContact.php?view=<?= $values['AddID'] ?>&module=<?= $_GET['module'] ?>&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>
        <a title="edit meeting" href="editmeeting_popup.php?edit=<?= $values['meeting_Id'] ?>&curP=<?= $_GET['curP'] ?>pop=1" target="_blank" class="fancybox fancybox.iframe"><?= $edit ?></a>--> 
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
        <a title="Publish" href="publishRecordings.php?meetingId=<?= $values['meetingId']?>&publish=true" ><?= $view ?>Publish</a> 
        <a title="Unpublish" href="publishRecordings.php?meetingId=<?= $values['meetingId']?>&publish=false"><?= $move ?>Unpublish</a> 
        <a title="presentation" href="<?=$presentation;?>" target="_blank" ><?= $view ?>Playback</a>  
      </td>
      </tr>
                            <?php } }// foreach end //?>

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
		
			
			