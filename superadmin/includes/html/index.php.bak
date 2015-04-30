<SCRIPT LANGUAGE=JAVASCRIPT>
function validate(frm)
{	
	ClearMsg();
	if( ValidateLoginEmail(frm.LoginEmail, '<?=ENTER_EMAIL?>', '<?=VALID_EMAIL?>')
	   && ValidateForLogin(frm.LoginPassword, '<?=ENTER_PASSWORD?>')
	){
		document.getElementById("msg_div").innerHTML = '<?=PLEASE_WAIT?>';
		return true;	
	}else{
		return false;	
	}
}
</SCRIPT>
<?
if($arrayConfig[0]['SiteLogo'] !='' && file_exists('../images/'.$arrayConfig[0]['SiteLogo']) ){
	$SiteLogo = '../resizeimage.php?w=80&h=80&img=images/'.$arrayConfig[0]['SiteLogo'];
}else{
	$SiteLogo = '../images/logo.png';
}
?>
<div class="main_login">
	<div class="login_box">
      
					<div class="logo">
				
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td align="center" height="80"><img src="<?=$SiteLogo?>" border="0" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>"/></td>
					</tr> 
					</table>

					
					</div>
					<div style="height:20px;padding-top:20px;" id="msg_div" align="center" class="redmsg"><?=$mess?></div>
                      <form action="" class="admin_login_form" method="post" name="form1" id="form1" onsubmit="return validate(this);">                      
                      	
					 <fieldset>
								<label>Email</label>
								<input name="LoginEmail" type="text" class="usname_icon" id="LoginEmail"  maxlength="60" onkeypress="ClearMsg();" onmousedown="ClearMsg();"  /> 
							</fieldset>

						<fieldset>
							<label>Password</label>
							<input name="LoginPassword" type="password" class="usname_icon" id="LoginPassword"  maxlength="25" onkeypress="ClearMsg();" onmousedown="ClearMsg();" />
						</fieldset>

						 <fieldset>
							<input class="button_btn" type="submit" value=" Sign In" />
							<input type="hidden" name="ContinueUrl" id="ContinueUrl" value="<?=$_GET['ref']?>" />	
						</fieldset>
                             
                             
                            
                      </form>
                 
                 
      </div>
     
      </div>