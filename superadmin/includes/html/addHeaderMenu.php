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
<div class="had">Header Menu</div>

<?php include('siteManagementMenu.php');?>
<div class="clear"></div>
<br>
<div class="message" align="center">
<? if(!empty($_SESSION['mess_header_menu'])) {echo $_SESSION['mess_header_menu']; unset($_SESSION['mess_header_menu']); }?>
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
												<td align="right" valign="middle" class="blackbold">
													 Page Name :</td>
												<td align="left" valign="middle"><select
													name="page_id[]" id="RecordsPerPage" class="textbox" multiple="multiple">
													
													<?php foreach($pageDta as $pageData){?>
														<option value="<?php echo $pageData['id'];?>"
														<? if( $pageData['id'] == $pageData['id']) echo 'selected';?>>
															<?php echo $pageData['Name'];?></option>
													<?php } ?>
													
														
												</select>
												</td>
											</tr>
											
											<tr>
												<td width="30%" align="right" valign="top" class="blackbold">
													Slug:<span class="red">*</span>
												</td>
												<td width="56%" align="left" valign="top"><input name="slug"
													id="slug" value="<?= stripslashes($arryPage[0]['slug']) ?>"
													type="text" class="inputbox" size="50" <?php if($_GET['edit']!=''){?> readonly <?php }?> /> <?php if(!empty($errors['slug'])){echo $errors['slug'];}?>
												</td>
											</tr>

                                         


											<tr style="float:right;width:2%;">
												<td align="center"  height="135" valign="top"><br> <? if ($_GET['edit']!='') {
													$ButtonTitle = 'Update';
												} else {
													$ButtonTitle = 'Submit';
												} ?> <input type="hidden" name="id" id="id"
													value="<?= $id; ?>" /> <input name="Submit" type="submit"
													class="button" id="SubmitPage"
													value=" <?= $ButtonTitle ?> " />&nbsp;</td>
											</tr>

										</table>
									</td>
								</tr>
							</table>

</form>
