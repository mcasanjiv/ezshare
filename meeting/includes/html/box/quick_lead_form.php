

<script language="JavaScript1.2" type="text/javascript">
function validateLead(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}


	if(!ValidateForSelect(frm.type,"Lead Type")){
		return false;
	}


	if(frm.type.value == "Company" ){
			//alert("ok");
		if(frm.company.value == ''){
			alert("Please Enter Company Name.");
			document.getElementById('company').focus()
			//frm.company.focus();
			return false;
		}
	}


	if( ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		//&& ValidateForSimpleBlank(frm.primary_email, "Primary Email")
		&& isEmailOpt(frm.primary_email)
		&& ValidateForSelect(frm.lead_source,"Lead Source")
		&& ValidateForSelect(frm.lead_status,"Lead Status")
		&& ValidateForTextareaMand(frm.Address,"Street Address",10,300)
		&& ValidateOptPhoneNumber(frm.LandlineNumber,"Landline Number")
		){		
					
					
		/*		
                  var Url = "isRecordExists.php?primary_email="+escape(document.getElementById("primary_email").value)+"&editID="+document.getElementById("LeadID").value+"&Type=Lead";
					SendExistRequest(Url,"primary_email", "Primary Email Address");
		  	
		      return false;*/

				

					return true;	
					
			}else{
					return false;	
			}	

		
}


function ltype(){

	var opt = document.getElementById('type').value;

	if(opt=="Company"){
		document.getElementById('com').style.display = 'block';
		document.getElementById('com_title').style.display = 'block';
	}else{
		document.getElementById('com').style.display = 'none';
		document.getElementById('com_title').style.display = 'none';
		document.getElementById('company').value = '';
	}
    
    
}


</script>
<div id="prv_msg_div" style="display:none;margin-top:200px;"><img src="../images/ajaxloader.gif"></div>
<div id="preview_div">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateLead(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Lead Details</td>
</tr>

<tr>
        <td  align="right"   class="blackbold" > Lead Type  :<span class="red">*</span> </td>
        <td   align="left" >
		 <select name="type" class="inputbox" id="type" onchange="ltype();" >
		<option value="">--- Select ---</option>
		
			<option value="Individual" <?  if($arryLead[0]['type']=='Individual'){echo "selected";}?>>Individual</option>
			<option value="Company" <?  if($arryLead[0]['type']=='Company'){echo "selected";}?>>Company</option>
	

		 </select>
           </td>

 <td  align="right"   class="blackbold"> <div  id="com_title">Company Name : <span class="red">*</span> </div></td>
        <td   align="left" >
			<div  id="com">
		  <input name="company" type="text" class="inputbox" id="company"   value="<?php echo stripslashes($arryLead[0]['company']); ?>"  maxlength="50" />        
		  </div>

		  </td>



      </tr>
<tr>
        <td  align="right"   class="blackbold" width="20%"> First Name  :<span class="red">*</span> </td>
        <td   align="left" width="25%">
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryLead[0]['FirstName']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold" width="25%"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryLead[0]['LastName']); ?>"  maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Primary Email : </td>
        <td   align="left" >
<input name="primary_email" type="text" class="inputbox" id="primary_email" value="<?php echo stripslashes($arryLead[0]['primary_email']); ?>"  maxlength="50" />            </td>
          
      
        <td  align="right"   class="blackbold"> Lead Source  :<span class="red">*</span> </td>
        <td   align="left" >
		
     <select name="lead_source" class="inputbox" id="lead_source" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryLeadSource);$i++) {?>
			<option value="<?=$arryLeadSource[$i]['attribute_value']?>" <?  if($arryLeadSource[$i]['attribute_value']==$arryLead[0]['lead_source']){echo "selected";}?>>
			<?=$arryLeadSource[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select>

 </td>
     
</tr>
	  
 <tr>
        <td  align="right"   class="blackbold"> Lead Status  :<span class="red">*</span> </td>
        <td   align="left" >
		

		<select name="lead_status" class="inputbox" id="lead_status" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryLeadStatus);$i++) {?>
			<option value="<?=$arryLeadStatus[$i]['attribute_value']?>" <?  if($arryLeadStatus[$i]['attribute_value']==$arryLead[0]['lead_status']){echo "selected";}?>>
			<?=$arryLeadStatus[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select> 	  
             </td>
    
	  <td align="right"   class="blackbold" valign="top">Street Address :<span class="red">*</span></td>
          <td  align="left" >
            <input name="Address" type="text" class="inputbox" id="Address" value="<?=stripslashes($arryLead[0]['Address'])?>"     maxlength="200">


</tr>
<tr>

<td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
 <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?=stripslashes($arryLead[0]['LandlineNumber'])?>"     maxlength="30" />		</td>

        <td align="right"   class="blackbold" valign="top">Mobile  :</td>
        <td  align="left" valign="top" >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryLead[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

	   
	  
       <tr>
          		          </td>
       
 </tr>


        
         
	
</table>	
  




	
	  
	
	</td>
   </tr>

   
   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="LeadID" id="LeadID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryLead[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryLead[0]['city_id']; ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />

</div>

</td>
   </tr>
   </form>
</table>
</div>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	//ShowPermission();
</SCRIPT>
