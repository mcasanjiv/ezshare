<script type="text/javascript" src="../admin/FCKeditor/fckeditor.js"></script>
<script
	type="text/javascript" src="../admin/js/ewp50.js"></script>

<script type="text/javascript">
    var ew_DHTMLEditors = [];
</script>

<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>


<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_pg'])) {echo $_SESSION['mess_pg']; unset($_SESSION['mess_pg']); }?>
</div>
<form name="form1" action="" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="0">
		<tr>
			<td align="center" valign="top">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" valign="middle">
							<div align="right">
								<a href="<?= $ListUrl ?>" class="back">Back</a>&nbsp;
							</div> <br>
							<table width="100%" border="0" cellpadding="0" cellspacing="0"
								class="borderall">


								<tr>
									<td align="center" valign="top"><table width="100%" border="0"
											cellpadding="5" cellspacing="1">
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Page Name (for Menu) :<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><input name="Name"
													id="Name" value="<?= stripslashes($arryPage[0]['Name']) ?>"
													type="text" class="inputbox" size="50" />
													<?php if(!empty($errors['Name'])){echo $errors['Name'];}?>
												</td>
											</tr>
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Page Title :<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><input
													name="Title" id="Title"
													value="<?= stripslashes($arryPage[0]['Title']) ?>"
													type="text" class="inputbox" />
													<?php if(!empty($errors['Title'])){echo $errors['Title'];}?>
												</td>
											</tr>
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Priority (used for sorting) :</td>
												<td width="56%" align="left" valign="top"><input
													name="Priority" id="Priority"
													value="<?= stripslashes($arryPage[0]['Priority']) ?>"
													type="text" class="inputbox" />
												</td>
											</tr>
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Page Slug:<span class="red">*</span></td>
												<td width="56%" align="left" valign="top"><input
													name="UrlCustom" id="UrlCustom"
													value="<?= stripslashes($arryPage[0]['UrlCustom']) ?>"
													type="text" class="inputbox" />
														<?php if(!empty($errors['UrlCustom'])){echo $errors['UrlCustom'];}?>
												</td>
											</tr>
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Meta Keywords :</td>
												<td width="56%" align="left" valign="top"><input
													name="MetaKeywords" id="MetaKeywords"
													value="<?= stripslashes($arryPage[0]['MetaKeywords']) ?>"
													type="text" class="inputbox" />
												</td>
											</tr>
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Meta Title :</td>
												<td width="56%" align="left" valign="top"><input
													name="MetaTitle" id="MetaTitle"
													value="<?= stripslashes($arryPage[0]['MetaTitle']) ?>"
													type="text" class="inputbox" />
												</td>
											</tr>
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Meta Description :</td>
												<td width="56%" align="left" valign="top"><input
													name="MetaDescription" id="MetaDescription"
													value="<?= stripslashes($arryPage[0]['MetaDescription']) ?>"
													type="text" class="inputbox" />
												</td>
											</tr>

											<tr>
												<td align="right" valign="middle" class="blackbold">Status :</td>
												<td align="left" class="blacknormal">
													<table width="151" border="0" cellpadding="0"
														cellspacing="0" class="blacknormal margin-left">
														<tr>
															<td width="20" align="left" valign="middle"><input
																name="Status" type="radio" value="1"
																<?= ($PageStatus == "Yes") ? "checked" : "" ?> /></td>
															<td width="48" align="left" valign="middle">Active</td>
															<td width="20" align="left" valign="middle"><input
																name="Status" type="radio"
																<?= ($PageStatus == "No") ? "checked" : "" ?> value="0" />
															</td>
															<td width="63" align="left" valign="middle">Inactive</td>
														</tr>
													</table>
												</td>
											</tr>
											
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Page Template:</td>
												<td width="56%" align="left" valign="top">
												<select name="template">
												<option value="">Select Template</option>
												<?php foreach($files as $fkey=>$fvalue){?>
													<option value="<?php echo $fkey;?>" <?php if($arryPage[0]['template']==$fkey){echo 'selected="selected"';}?>>
												<?php echo $fvalue;?>
												<?php }?></option>
												</select>
												</td>
											</tr>
											
											
											<tr>
												<td width="30%" colspan="2" align="left" valign="top"
													class="blackbold">Page Content :</td>

											</tr>
											<tr>

												<td colspan="2" align="left" valign="top" class="editor_box">

													<textarea name="page_content" id="page_content">
													<?= stripslashes($arryPage[0]['Content']) ?>
													</textarea> <script type="text/javascript">

                                                        var editorName = 'page_content';

                                                        var editor = new ew_DHTMLEditor(editorName);

                                                        editor.create = function() {
                                                            var sBasePath = '../admin/FCKeditor/';
                                                            var oFCKeditor = new FCKeditor(editorName, '1170', 300, 'custom');
                                                            oFCKeditor.BasePath = sBasePath;
                                                            oFCKeditor.ReplaceTextarea();
                                                            this.active = true;
                                                        }
                                                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                                                        ew_CreateEditor(); 


                                                    </script>
												</td>
											</tr>

										</table>
									</td>
								</tr>


							</table></td>
					</tr>
					<tr>
						<td align="center" height="135" valign="top"><br> <? if ($_GET['edit'] > 0) {
							$ButtonTitle = 'Update';
						} else {
							$ButtonTitle = 'Submit';
						} ?> <input type="hidden" name="id" id="id"
							value="<?= $id; ?>" /> <input name="Submit" type="submit"
							class="button" id="SubmitPage" value=" <?= $ButtonTitle ?> " />&nbsp;
						</td>
					</tr>

				</table>
			</td>
		</tr>
	</table>
</form>
