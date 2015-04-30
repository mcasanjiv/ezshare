<?php //print_r($MeetingData);?>
	
	<SCRIPT LANGUAGE=JAVASCRIPT>
function validateForm(frm)
{	
	if( ValidateLoginEmail(frm.Email, '<?=ENTER_EMAIL?>', '<?=VALID_EMAIL?>')
	){
		document.getElementById("msg_div").innerHTML = 'Processing...';
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>


			<section id="mainContent">
			<?php //echo $datah['Content'];?>
				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title">Join a Meeting</h1>
										

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">

											<div class="message_success"  id="msg_div" >
											<? if(!empty($_SESSION['mess_reset'])) {
												echo $_SESSION['mess_reset']; 
												unset($_SESSION['mess_reset']); 
											}?>
											</div>
											
												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-pass-errors"
														style="display: none;">
														<ul></ul>
													</div>
													<form accept-charset="UTF-8" id="user-pass" method="post"
														action="" novalidate="novalidate" onSubmit="return validateForm(this);">
														<div>
														<?php if(!$MeetingData){ ?>
														<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Organization Name <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="" name="OrgName"
																	id="OrgName">
															</div>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Meeting Code <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="" name="MCode"
																	id="MCode">
															</div>
															
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Join Type <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="" name="MType"
																	id="MType">
															</div>
														<?php }?>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Name <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="" name="Name"
																	id="Name">
															</div>
															<?php  if(($_REQUEST['MType']==Meeting::MEETING_MOD && $MeetingData['moderatorPw']!=Meeting::DEFAULT_MOD_PWD) ||
																	 ($_REQUEST['MType']==Meeting::MEETING_ATTENDEE && $MeetingData['attendeePw']!=Meeting::DEFAULT_ATD_PWD)
															){ ?>
															<div class="form-item form-type-textfield form-item-name">
																<label for="edit-name">Password <span
																	title="This field is required." class="form-required">*</span>
																</label> <input type="text" class="form-text required"
																	maxlength="254" size="60" value="" name="Password"
																	id="Password">
															</div>
															<?php }?>
															<div id="edit-actions" class="form-actions form-wrapper">
																<input type="submit" class="form-submit"
																	value="submit" name="submit" id="submit">
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

