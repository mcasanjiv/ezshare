
<SCRIPT LANGUAGE=JAVASCRIPT>

function ValidateForm(frm)
{
	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}

	if(  ValidateForBlank(frm.name, "City Name") 
	     && ValidateForSelect(frm.main_state_id, "State")
	){

		var Url = "isRecordExists.php?City="+document.getElementById("name").value+"&StateID="+ document.getElementById("main_state_id").value+"&editID="+document.getElementById("city_id").value;
		
		SendExistRequest(Url,"name","City Name");
		return false;
	}else{
		return false;	
	}
	
}


</SCRIPT>

<a href="<?=$RedirectUrl?>"  class="back">Back</a>
<div class="had">
Manage Cities   <span>  &raquo;
  <? 
			$MemberTitle = (!empty($_GET['edit']))?("Edit ") :("Add ");
			echo $MemberTitle.$ModuleName;
			 ?>
			 </span>
</div>

<TABLE WIDTH=600   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<TR>
	  <TD align="center" valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td  align="center" valign="middle" >
		
		    <table width="100%"   border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action="" method="post" onSubmit="return ValidateForm(this);">
                <tr>
                  <td height="60">
				  </td>
				  </tr>
                <tr>
                  <td align="center" valign="bottom" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
                    <tr>
                      <td width="43%" align="right" valign="middle"   class="blackbold"> City Name : </td>
                      <td width="57%" align="left"><input value="<?=stripslashes($name)?>" name="name" type="text" class="inputbox" id="name"  maxlength="31" /> <span class="red">*</span></td>
                    </tr>
                     <tr <?=$Config['CountryDisplay']?>>
                       <td align="right" valign="middle" nowrap="nowrap"  class="blackbold"> Country : </td>
                       <td align="left">
                           <select name="country_id" class="inputbox" id="country_id" onchange="Javascript: StateListSend(1);">
                             <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
                             <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
                             <?=$arryCountry[$i]['name']?>
                             </option>
                             <? } ?>
                           </select> 
                       </td>
                     </tr>
					 
                     <tr>
                      <td align="right" valign="middle" class="blackbold"> State : </td>
                      <td  align="left" id="state_td" class="blacknormal">
					  </td>
                    </tr>  
                     <tr style="display:none">
                      <td align="right" valign="middle" class="blackbold"> Major City : </td>
                      <td  align="left" class="blacknormal">
					  	<input type="checkbox" name="major_city" value="1" <?=($major_city==1)?("checked"):("")?>/>
					  </td>
                    </tr>  
					
					
					
                  </table></td>
                </tr>
				
		 <tr>
                  <td align="center" colspan="2" height="50" ><input name="Submit" type="submit" id="SubmitButton" class="button" value="<? if($_GET['edit'] >0) echo 'Update'; else echo 'Submit'; ?>" <? if(sizeof($arryState)<=0) { echo 'disabled';} ?>/>
                          <input type="hidden" name="city_id" id="city_id"  value="<?=$_GET['edit']?>" />                      <input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$state_id?>" />
                        
						  
						  </td>
                    </tr>		
				
				
              </form>
          </table></td>
        </tr>
      </table></TD>
  </TR>
	
</TABLE>
<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
