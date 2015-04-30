<script language="JavaScript1.2" type="text/javascript">
function validate_company(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateForSimpleBlank(frm.CompanyName, "Company Name")
		&& ValidateForTextareaMand(frm.Description,"Description",10,1000)
		&& ValidateOptionalUpload(frm.Image, "Image")
		&& ValidateForSimpleBlank(frm.ContactPerson, "Contact Person")
		&& ValidateForTextareaMand(frm.Address,"Address",10,200)
		&& isZipCode(frm.ZipCode)
		&& isEmailOpt(frm.AlternateEmail)
		&& ValidateOptPhoneNumber(frm.Mobile,"Mobile Number")
		&& ValidatePhoneNumber(frm.LandlineNumber,"Landline Number",10,20)
		&& ValidateOptFax(frm.Fax,"Fax Number")
		&& isValidLinkOpt(frm.Website,"Website URL")
		){

			return true;	
		}else{
			return false;	
		}	
}

function validate_DateTime(frm){

	if( ValidateForSelect(frm.Timezone, "Timezone")
		&& ValidateRadioButtons(frm.DateFormat, "Date Format")
		){

			return true;	
		}else{
			return false;	
		}	
}


function validate_permission(frm){
	if( ValidateMandNumField(frm.MaxUser, "Allowed Number Of Users")
		){
			return true;	
		}else{
			return false;	
		}	
}


function validate_account(frm){
	if( //ValidateMandRange(frm.DisplayName, "Display Name",3,30)
		//&& isDisplayName(frm.DisplayName)
		ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){
		

			if(document.getElementById("Password").value!=""){
				if(!ValidateForSimpleBlank(frm.Password, "Password")){
					return false;
				}
				/*if(!isPassword(frm.Password)){
					return false;
				}*/
				if(!ValidateMandRange(frm.Password, "Password",5,15)){
					return false;
				}
				if(!ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)){
					return false;
				}
			}	
							
			var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("CmpID").value+"&DisplayName="+escape(document.getElementById("DisplayName").value)+"&Type=Company";

			SendMultipleExistRequest(Url,"Email", "Email Address","DisplayName", "Display Name")
			
			return false;	
		}else{
			return false;	
		}	
}




</script>




<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_company'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_company'])) {echo $_SESSION['mess_company']; unset($_SESSION['mess_company']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Company Admin Details</td>
</tr>
<tr>
	 <td  align="right" valign="top" width="45%">Admin Url : </td>
 <td  align="left" valign="top">
<?
echo $AdminUrl = $Config['Url'].$arryCompany[0]["DisplayName"].'/'.$Config['AdminFolder']."/";
?>
<br><b class=red><?=ADMIN_URL_MSG?></b><br>
</td>
</tr>
  <tr>
	 <td  align="right">Login Type : </td>
 <td  align="left">
Administrator
</td>
</tr>
  <tr>
	 <td  align="right">Login Email : </td>
 <td  align="left">
<?php echo $arryCompany[0]['Email']; ?>
</td>
</tr>
  <tr>
	 <td  align="right">Login Password : </td>
 <td  align="left">
****************
</td>
</tr>


  <tr>
	 <td  align="right">Package : </td>
 <td  align="left">
<?=(!empty($arryCompany[0]['PaymentPlan']))?(ucfirst($arryCompany[0]['PaymentPlan'])):('None')?>
</td>
</tr>



 <tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		

<?=date("jS F, Y",strtotime($arryCompany[0]['JoiningDate']))?>

</td>
      </tr>

<? if($arryCompany[0]['ExpiryDate'] > 0){?>
<tr>
	<td align="right"   class="blackbold">Expiry Date  :</td>
	<td  align="left" >		

	<?=date("jS F, Y",strtotime($arryCompany[0]['ExpiryDate']))?>

	</td>
</tr>
<? } ?>




<? if($_GET["tab"]=="company"){ ?>
<tr>
	 <td colspan="2" align="left" class="head">Company Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" > Company Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="CompanyName" type="text" class="inputbox" id="CompanyName" value="<?php echo stripslashes($arryCompany[0]['CompanyName']); ?>"  maxlength="50" />            </td>
      </tr>

	
 <tr>
          <td align="right"   class="blackbold" valign="top">Description  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Description" type="text" class="bigbox" id="Description"><?=stripslashes($arryCompany[0]['Description'])?></textarea>			          </td>
        </tr>		  
	   


<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Logo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	
	
	
		</td>
  </tr>	  

	
	<tr>
        <td  align="right"   class="blackbold"> Contact Person  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="ContactPerson" type="text" class="inputbox" id="ContactPerson" value="<?php echo stripslashes($arryCompany[0]['ContactPerson']); ?>"  maxlength="30" />            </td>
      </tr>	 
  
        <tr>
          <td align="right"   class="blackbold" valign="top"> Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryCompany[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryCompany[0]['country_id'] != ''){
		$CountrySelected = $arryCompany[0]['country_id']; 
	}else{
		$CountrySelected = 1;
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :</td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :</div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryCompany[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryCompany[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" valign="top">Zip Code  :<span class="red">*</span></td>
        <td  align="left" >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryCompany[0]['ZipCode'])?>" maxlength="15"   />	
		</td>
      </tr>
	  
 <tr>
        <td align="right"   class="blackbold" >Email  : </td>
        <td  align="left" ><input name="AlternateEmail" type="text" class="inputbox" id="AlternateEmail" value="<?php echo $arryCompany[0]['AlternateEmail']; ?>"  maxlength="70" /> </td>
      </tr> 
	 

       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryCompany[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold">Landline  :<span class="red">*</span></td>
        <td   align="left" >
	 <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?=stripslashes($arryCompany[0]['LandlineNumber'])?>"     maxlength="30" />			
	</td>
      </tr>


<tr>
        <td align="right"   class="blackbold" >Fax  :</td>
        <td  align="left"  >
	 <input name="Fax" type="text" class="inputbox" id="Fax" value="<?=stripslashes($arryCompany[0]['Fax'])?>"     maxlength="30" />			</td>
      </tr>

 <tr>
        <td align="right"   class="blackbold" >Website URL :</td>
        <td align="left"><input name="Website" type="text" class="inputbox" id="Website" value="<?=(!empty($arryCompany[0]['Website']))?($arryCompany[0]['Website']):("")?>"  maxlength="100" /> <?=$MSG[205]?></td>
      </tr>

<? } ?>
 

<? if($_GET["tab"]=="permission"){ ?>

<tr>
	 <td colspan="2" align="left" class="head">Permission Details</td>

</tr>
<tr>
	<td align="right"   class="blackbold" valign="top" width="45%">Allowed Number Of Users  :<span class="red">*</span></td>
	<td  align="left"  >
	<input name="MaxUser" type="text" class="textbox" size="7" id="MaxUser" value="<?=stripslashes($arryCompany[0]['MaxUser'])?>" maxlength="15" onkeypress="return isNumberKey(event);"/>	
	
 
 
 </td>
  </tr>

<tr>
	<td align="right"   class="blackbold" valign="top">Data Storage Limit   :</td>
	<td  align="left"  >
		<input name="StorageLimit" type="text" class="textbox" size="7" id="StorageLimit" value="<?=stripslashes($arryCompany[0]['StorageLimit'])?>" maxlength="15"/>
<!--<select name="StorageLimit" id="StorageLimit" class="textbox" onChange="Javascript: StorageUnit();">
	<?
	/*echo '<option value=""> Unlimited </option>';
	for($i=0;$i<=100;$i=$i+5){	
		$val = $i;	
		if($val==0) $val=1;
		$sel = ($arryCompany[0]['StorageLimit']==$val)?('selected'):('');
		echo '<option value="'.$val.'" '.$sel.'>'.$val.'</option>';
	} */
	?>
</select--> 

<select name="StorageLimitUnit" id="StorageLimitUnit" class="textbox">
<option value="GB" <?=($arryCompany[0]['StorageLimitUnit']=="GB")?('selected'):('')?>> GB </option>
<option value="TB" <?=($arryCompany[0]['StorageLimitUnit']=="TB")?('selected'):('')?>> TB </option>
</select> 

<SCRIPT LANGUAGE=JAVASCRIPT>
StorageUnit();
</SCRIPT>

 </td>

<tr>
        <td  align="right"   class="blackbold"  valign="top" > Allowed Module  : </td>
        <td   align="left" style="line-height:26px;" >
		
<!--input type="radio" name="Department" id="Department" value="" <?=($arryCompany[0]['Department']=="")?("checked"):("")?> /> ERP <br>
<input type="radio" name="Department" id="Department" value="1" <?=($arryCompany[0]['Department']=="1")?("checked"):("")?> /> HRMS<br-->



<label><input type="checkbox" name="Department[]" id="Department0" value="" <?=($arryCompany[0]['Department']=="")?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_ERP?> <br></label>

<label><input type="checkbox" name="Department[]" id="Department1" value="1" <?=substr_count($arryCompany[0]['Department'],"1")?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_HRMS?> <br></label>
		
<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department2" value="5" <?=substr_count($arryCompany[0]['Department'],"5")?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_CRM?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department3" value="2" <?=substr_count($arryCompany[0]['Department'],"2")?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_ECOMMERCE?> <br></label>

<label <?=$HideModule?>><input type="checkbox" name="Department[]" id="Department4" value="3,4,6,7,8" <?=substr_count($arryCompany[0]['Department'],"3,4,6,7,8")?("checked"):("")?> onclick="Javascript:SetModuleOff();" /> <?=MOD_INVENTORY?> <br></label>
	
	
	

</td>
 </tr>


<tr>
        <td  align="right"   class="blackbold" 
		>Track Inventory  : </td>
        <td   align="left"  >
          <? 
		$TrackChecked = ' checked';
		if($_REQUEST['edit'] > 0){
		 if($arryCompany[0]['TrackInventory'] == 1) {$TrackChecked = ' checked'; $InTrackChecked ='';}
		 if($arryCompany[0]['TrackInventory'] == 0) {$TrackChecked = ''; $InTrackChecked = ' checked';}
		}
	  ?>
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="1" <?=$TrackChecked?> />
          Yes</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="TrackInventory" id="TrackInventory" value="0" <?=$InTrackChecked?> />
          No</label> </td>
      </tr>



 <? } ?>

<? if($_GET["tab"]=="currency"){ ?>
<tr>
       		 <td colspan="2" align="left" class="head">Currency Details</td>
        </tr>
		<tr>
       		 <td colspan="2" height="10"></td>
        </tr>
	  <tr>
        <td  align="right"   class="blackbold" width="45%">Base Currency  :</td>
        <td   align="left" >
		<?
		if($arryCompany[0]['currency_id'] != ''){
			$CurrencySelected = $arryCompany[0]['currency_id']; 
		}else{
			$CurrencySelected = 9;
		}
		?>
            <select name="currency_id" class="inputbox" id="currency_id">
              <? for($i=0;$i<sizeof($arryCurrency);$i++) {?>
              <option value="<?=$arryCurrency[$i]['currency_id']?>" <?  if($arryCurrency[$i]['currency_id']==$CurrencySelected){echo "selected";}?>>
              <?=$arryCurrency[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
	  
	  	  
<tr>
       		 <td colspan="2" height="10"></td>
        </tr>

	  <tr>
        <td  align="right"   class="blackbold" valign="top">Additional Currency :</td>
        <td   align="left" >
<div id="PermissionValue" style="width:600px; height:300px; overflow:auto">
	<? 
	$arryAddCurrency = explode(",", $arryCompany[0]['AdditionalCurrency']);
	for($i=0;$i<sizeof($arryCurrency);$i++) {?>
	<div style="float:left;width:180px;"><label><input type="checkbox" name="AdditionalCurrency[]" id="AdditionalCurrency" value="<?=$arryCurrency[$i]['code']?>" <?=in_array($arryCurrency[$i]['code'],$arryAddCurrency)?("checked"):("")?>  /> <?=$arryCurrency[$i]['name']?> </label></div>
	<? } ?>
 </div>           



       </td>
      </tr>
	<tr>
       		 <td colspan="2" height="10"></td>
        </tr>

 <? } ?>

<? if($_GET["tab"]=="DateTime"){ ?>

		<tr>
       		 <td colspan="2" align="left" class="head">DateTime Settings</td>
        </tr>
  <tr>
        <td align="right"   class="blackbold" valign="top" width="45%">Timezone  :<span class="red">*</span></td>
        <td  align="left"  valign="top" >

<div style="position:relative;"><?  
$arryCurrentLocation[0]['Timezone'] = $arryCompany[0]['Timezone'];
$SupPrefx = '../admin/';
include("../admin/includes/html/box/clock.php"); ?></div>


<script>
  $(function() {
	$('#Timezone').timepicker({ 
		'timeFormat': 'H:i',
		'step': '5'
		});
  });
</script>

<?=getTimeZone($arryCompany[0]['Timezone'])?>

<script>
GetLocalTime();
</script>
		</td>
      </tr>
	<tr>
       		 <td colspan="2" height="20"></td>
        </tr>	


 <tr>
        <td align="right"   class="blackbold"  >Session Timeout  :</td>
        <td  align="left"   > 
<select name="SessionTimeout" id="SessionTimeout" class="textbox">
	<?
	echo '<option value=""> None </option>';
	for($i=5;$i<=60;$i=$i+5){
		$val = $i*60;
		$sel = ($arryCompany[0]['SessionTimeout']==$val)?('selected'):('');
		echo '<option value="'.$val.'" '.$sel.'>'.$i.'</option>';
	}
	?>
</select> &nbsp;Minutes
	  	</td>
      </tr>
<tr>
       		 <td colspan="2" height="20"></td>
        </tr>


	  <tr>
        <td align="right"   class="blackbold" valign="top" >Date Format  :<span class="red">*</span></td>
        <td  align="left"  valign="top" > 
		
<?
	$Today = date("Y-m-d");
	if(empty($arryCompany[0]['DateFormat'])) $arryCompany[0]['DateFormat'] = "Y-m-d";
	for($i=0;$i<sizeof($arrayDateFormat);$i++) {?>
<div style="float:left; width:250px; height:30px;">
 <label><input type="radio" name="DateFormat" value="<?=$arrayDateFormat[$i]['DateFormat']?>" <?  if($arrayDateFormat[$i]['DateFormat']==$arryCompany[0]['DateFormat']){echo "checked";}?>/> <?=date($arrayDateFormat[$i]['DateFormat'], strtotime($Today))?></label>
</div>
<? } ?>	
		



	  	</td>
      </tr>


 <tr>
        <td align="right"   class="blackbold"  >Time Format  :</td>
        <td  align="left"   > 
<select name="TimeFormat" id="TimeFormat" class="textbox">
<option value="H:i:s" <?=($arryCompany[0]['TimeFormat']=='H:i:s')?('selected'):('')?> > 24 Hour </option>
<option value="h:i:s a" <?=($arryCompany[0]['TimeFormat']=='h:i:s a')?('selected'):('')?> > am / pm </option>
</select> 
	  	</td>
      </tr>



<? } ?>

	  
<? if($_GET["tab"]=="account"){ ?>
	
	<tr>
       		 <td colspan="2" align="left" class="head">Account Details</td>
        </tr>
		
   <tr>
        <td  align="right"   class="blackbold"> Display Name  : </td>
        <td   align="left" >
<!--
<input name="DisplayName" type="text" class="inputbox" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  maxlength="30" onKeyPress="Javascript:ClearAvail('MsgSpan_Display');" onBlur="Javascript:CheckAvailField('MsgSpan_Display','DisplayName','<?=$_GET['edit']?>');"/>

<span id="MsgSpan_Display"></span>
-->
<?=stripslashes($arryCompany[0]['DisplayName'])?>
<input name="DisplayName" type="hidden" id="DisplayName" value="<?php echo stripslashes($arryCompany[0]['DisplayName']); ?>"  />



</td>
      </tr>

      <tr>
        <td  align="right"   class="blackbold" >Login Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryCompany[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Company','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  
	 
        <tr>
        <td  align="right"   class="blackbold">New Password : </td>
        <td   align="left" ><input name="Password" type="Password" class="inputbox" id="Password" value=""  maxlength="15" /> 
		<span>(Leave it blank, if do not want to change password.)</span>
		

		
		</td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password : </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value=""  maxlength="15" /> </td>
      </tr>	
	
 <? if($arryCompany[0]['JoiningDate'] > 0){?>

   <tr>
        <td align="right"   class="blackbold">Joining Date  :</td>
        <td  align="left" >		

<?=date("jS F, Y",strtotime($arryCompany[0]['JoiningDate']))?>

</td>
      </tr>


<tr>
        <td  align="right"   > Expiry Date :  </td>
        <td   align="left" >
<? if($arryCompany[0]['ExpiryDate']>0)$ExpiryDate = $arryCompany[0]['ExpiryDate'];?>		
<script>
$(function() {
$( "#ExpiryDate" ).datepicker({ 
		showOn: "both",
	yearRange: '<?=date("Y")-10?>:<?=date("Y")+20?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});

	$("#expNone").on("click", function () { 
		$("#ExpiryDate").val("");
	}
	);	

});
</script>
<input id="ExpiryDate" name="ExpiryDate" readonly="" class="datebox" value="<?=$ExpiryDate?>"  type="text" >         

&nbsp;&nbsp;&nbsp;&nbsp;<a href="Javascript:void(0);" id="expNone">None</a>


</td>
      </tr>

     
	  
<? } ?>	  
	     
	  
	


<? if($_GET['edit']!=1){ ?>
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryCompany[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryCompany[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <label><input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active</label>&nbsp;&nbsp;&nbsp;&nbsp;
          <label><input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive</label> </td>
      </tr>
<? } ?>
	
 <? } ?>	
	
	
</table>	
  





	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	<br />
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />

&nbsp;&nbsp;<input name="Reset" type="reset" class="button" id="ResetButton" value=" Reset "  />

<input type="hidden" name="CmpID" id="CmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryCompany[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryCompany[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>
</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="company"){ ?>
	StateListSend();
<? } ?>

</SCRIPT>



