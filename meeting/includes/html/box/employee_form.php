<script language="JavaScript1.2" type="text/javascript">
function validateEmployee(frm){


	var DataExist=0;
	/**********************/
	var EmpCode = Trim(document.getElementById("EmpCode")).value;
	if(EmpCode!=''){
		if(!ValidateMandRange(document.getElementById("EmpCode"), "Employee Code",3,20)){
			return false;
		}
	}
	/**********************/

	/*if(document.getElementById("depID") != null){
		document.getElementById("Department").value = document.getElementById("depID").value;
	}*/

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}

	if( ValidateRadioButtons(frm.Gender, "Gender")
		&& ValidateForSimpleBlank(frm.FirstName, "First Name")
		&& ValidateForSimpleBlank(frm.LastName, "Last Name")
		&& ValidateForSelect(frm.date_of_birth,"Date of Birth")
		&& ValidateOptionalUpload(frm.Image, "Image")
		&& ValidateForSimpleBlank(frm.PersonalEmail, "Personal Email")
		&& isEmail(frm.PersonalEmail)
		&& ValidateForTextareaMand(frm.Address,"Contact Address",10,200)
		&& ValidateForSelect(frm.country_id,"Country")
		&& isZipCode(frm.ZipCode)
		&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		&& ValidateForSelect(frm.UnderGraduate,"Under Graduate")
		&& ValidateForSelect(frm.Graduation,"Graduation")
		&& ValidateForSelect(frm.JoiningDate,"Joining Date")
		&& ValidateForSelect(frm.catID,"Category")
		//&& ValidateForSelect(frm.Division,"Division")
		&& ValidateForSelect(frm.Department,"Department")
		&& ValidateForSelect(frm.JobTitle,"Designation")
		&& ValidateForSelect(frm.JobType,"Job Type")
		&& ValidateForSelect(frm.ExperienceYear,"Total Years of Experience")
		&& ValidateForSelect(frm.ExperienceMonth,"Total Months of Experience")
		//&& ValidateMandDecimalField(frm.Salary,"Salary")
		&& ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
		){
		
					if(Trim(frm.Landline1).value == '' && Trim(frm.Landline2).value == '' && Trim(frm.Landline3).value == ''){
						//alert("ok");
					}else if(Trim(frm.Landline1).value == '' || Trim(frm.Landline2).value == '' || Trim(frm.Landline3).value == ''){
						alert("Please Enter Complete Landline Number.");
						return false;
					}
		
					if(document.getElementById("UnderGraduateSpan").style.display!='none'){
						if(!ValidateForSimpleBlank(frm.OtherUnderGraduate,"Under Graduate")){
							return false;
						}
					}				
		
					if(document.getElementById("GraduationSpan").style.display!='none'){
						if(!ValidateForSimpleBlank(frm.OtherGraduation,"Graduation")){
							return false;
						}
					}				
		
					if(document.getElementById("EmpID").value<=0){
						if(!ValidateForSimpleBlank(frm.Password, "Password")){
							return false;
						}
						/*
						if(!isPassword(frm.Password)){
							return false;
						}*/
						if(!ValidateMandRange(frm.Password, "Password",5,15)){
							return false;
						}
						if(!ValidateForPasswordConfirm(frm.Password,frm.ConfirmPassword)){
							return false;
						}
					
					}					
					
				


					if(EmpCode!=''){
						DataExist = CheckExistingData("isRecordExists.php","&EmpCode="+escape(EmpCode), "EmpCode","Employee Code");
						if(DataExist==1)return false;
					}

					/**********************/
					DataExist = CheckExistingData("isRecordExists.php", "&Type=Employee&Email="+escape(document.getElementById("Email").value), "Email","Email Address");
					if(DataExist==1)return false;
					/**********************/

					/*
					var Url = "isRecordExists.php?Email="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("EmpID").value+"&Type=Employee";
					SendExistRequest(Url,"Email", "Email Address");*/



					ShowHideLoader('1','S');

					return true;	
					
			}else{
					return false;	
			}	

		
}
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateEmployee(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head">Personal Details</td>
</tr>


 <tr>
        <td  align="right"   class="blackbold"> Employee Code : </td>
        <td   align="left" >

	<input name="EmpCode" type="text" class="datebox" id="EmpCode" value=""  maxlength="20" onKeyPress="Javascript:ClearAvail('MsgSpan_EmpCode');return isUniqueKey(event);" onBlur="Javascript:CheckAvailField('MsgSpan_EmpCode','EmpCode','<?=$_GET['edit']?>');" onMouseover="ddrivetip('<?=BLANK_ASSIGN_AUTO?>', 220,'')"; onMouseout="hideddrivetip()"/>
	<span id="MsgSpan_EmpCode"></span>

</td>
      </tr>


	<tr>
	     <td  align="right"  class="blackbold" >Gender :<span class="red">*</span> </td>
	     <td   align="left" >
		 
		 
          <input type="radio" name="Gender" id="Gender" value="Male" <?=($arryEmployee[0]['Gender']=="Male")?("checked"):("");?>/>
          Male&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Gender" id="Gender" value="Female"  <?=($arryEmployee[0]['Gender']=="Female")?("checked"):("");?>  />
          Female		 </td>
	     </tr>

<tr>
        <td  align="right"   class="blackbold"> First Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryEmployee[0]['FirstName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryEmployee[0]['LastName']); ?>"  maxlength="50" onkeypress="return isCharKey(event);"/>            </td>
      </tr>
	   
	   <tr>
        <td  align="right"   > Date of Birth : <span class="red">*</span> </td>
        <td   align="left" >
		
<script>
$(function() {
$( "#date_of_birth" ).datepicker({ 
		showOn: "both",
	yearRange: '1930:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	maxDate: "-1D", 
	changeMonth: true,
	changeYear: true
	});
});
</script>

<input id="date_of_birth" name="date_of_birth" readonly="" class="datebox" value="<?=$arryEmployee[0]['date_of_birth']?>"  type="text" >         </td>
      </tr>

  <tr>
        <td  align="right"   class="blackbold"> Nationality  : </td>
        <td   align="left" >
		
            <select name="Nationality" class="inputbox" id="Nationality" >
			<option value="">--- Select ---</option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['name']?>" <?  if($arryCountry[$i]['name']==$arryEmployee[0]['Nationality']){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select> </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> Marital Status  : </td>
        <td   align="left" >
		
            <select name="MaritalStatus" class="inputbox" id="MaritalStatus" >
			<option value="">--- Select ---</option>
              <option value="Single" <?  if($arryEmployee[0]['MaritalStatus']=="Single"){echo "selected";}?>> Single </option>
              <option value="Married" <?  if($arryEmployee[0]['MaritalStatus']=="Married"){echo "selected";}?>> Married </option>
              <option value="Other" <?  if($arryEmployee[0]['MaritalStatus']=="Other"){echo "selected";}?>> Other </option>
            </select> </td>
      </tr>

<? if($arryCurrentLocation[0]['country_id']!=106){?>
<tr>
        <td align="right"   class="blackbold">Social Security Number  : </td>
        <td  align="left" >
		<input name="SSN" type="text" class="inputbox" id="SSN" value="<?=stripslashes($arryEmployee[0]['SSN'])?>"  maxlength="30" /> </td>
      </tr> 
<? } ?>
<tr>
    <td  align="right"    class="blackbold" valign="top"> Upload Photo  :</td>
    <td  align="left"  >
	
	<input name="Image" type="file" class="inputbox" id="Image" onkeypress="javascript: return false;" onkeydown="javascript: return false;" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">&nbsp;	

<? 
$MainDir = "upload/employee/".$_SESSION['CmpID']."/";
if($arryEmployee[0]['Image'] !='' && file_exists($MainDir.$arryEmployee[0]['Image']) ){ ?>
				
	<div  id="ImageDiv"><a href="<?=$MainDir.$arryEmployee[0]['Image']?>" class="fancybox" data-fancybox-group="gallery"  title="<?=$arryEmployee[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=150&h=150&img='.$MainDir.$arryEmployee[0]['Image'].'" border=0 >';?></a>
	
	&nbsp;<a href="Javascript:void(0);" onclick="Javascript:DeleteFile('<?=$MainDir.$arryEmployee[0]['Image']?>','ImageDiv')"><?=$delete?></a>	</div>
<?	} ?>
	
		</td>
  </tr>	  
 <tr>
        <td  align="right"   class="blackbold"> Blood Group  : </td>
        <td   align="left" >
 <select name="BloodGroup" class="textbox" id="BloodGroup" >
				<option value="">--- Select ---</option>
				<? for($i=0;$i<sizeof($arryBloodGroup);$i++) {?>
				<option value="<?=$arryBloodGroup[$i]['attribute_value']?>" <?  if($arryBloodGroup[$i]['attribute_value']==$arryEmployee[0]['BloodGroup']){echo "selected";}?>>
				<?=$arryBloodGroup[$i]['attribute_value']?>
				</option>
				<? } ?>         
            </select>            </td>
      </tr>



	<tr>
       		 <td colspan="2" align="left"   class="head">Contact Details</td>
        </tr>
   
	  
	    <tr>
        <td align="right"   class="blackbold">Personal Email  :<span class="red">*</span> </td>
        <td  align="left" ><input name="PersonalEmail" type="text" class="inputbox" id="PersonalEmail" value="<?php echo $arryEmployee[0]['PersonalEmail']; ?>"  maxlength="70" /> </td>
      </tr> 
	 
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Contact Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryEmployee[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryEmployee[0]['country_id'] != ''){
		$CountrySelected = $arryEmployee[0]['country_id']; 
	}else{
		$CountrySelected = $arryCurrentLocation[0]['country_id'];
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
			 <!--option value="">--- Select ---</option-->
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
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryEmployee[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :</div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :</div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryEmployee[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryEmployee[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="Mobile" type="text" class="inputbox" id="Mobile" value="<?=stripslashes($arryEmployee[0]['Mobile'])?>"     maxlength="20" />			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
		<?
		if(!empty($arryEmployee[0]['LandlineNumber'])){
			$LandArray = explode(" ",$arryEmployee[0]['LandlineNumber']);
	    }
		?>
		<input name="Landline1" type="text" class="textbox" id="Landline1" value="<?=$LandArray[0]?>" size="3" maxlength="4" />&nbsp;&nbsp;
		<input name="Landline2" type="text" class="textbox" id="Landline2" value="<?=$LandArray[1]?>" size="3" maxlength="4" />&nbsp;&nbsp;
		<input name="Landline3" type="text" class="textbox" id="Landline3" value="<?=$LandArray[2]?>" size="8" maxlength="8" />		</td>
      </tr>

	<tr>
       		 <td colspan="2" align="left"   class="head">Education Details</td>
        </tr>	
	
	 <tr>
          <td align="right"   class="blackbold" valign="top"> Under Graduate  :<span class="red">*</span></td>
          <td height="30" align="left" >
		<select name="UnderGraduate" class="inputbox" id="UnderGraduate"  onchange="Javascript:ShowOther('UnderGraduate');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryUnderGraduate);$i++) {?>
			<option value="<?=$arryUnderGraduate[$i]['attribute_value']?>" <?  if($arryUnderGraduate[$i]['attribute_value']==$arryEmployee[0]['UnderGraduate']){echo "selected";}?>>
			<?=$arryUnderGraduate[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['UnderGraduate']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="UnderGraduateSpan">&nbsp;&nbsp;<input  name="OtherUnderGraduate" id="OtherUnderGraduate" value="<?=stripslashes($arryEmployee[0]['OtherUnderGraduate'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('UnderGraduate');</script>
		  
		  
		  </td>
  </tr>  	
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top"> Graduation  :<span class="red">*</span></td>
          <td height="30" align="left" >
		<select name="Graduation" class="inputbox" id="Graduation"  onchange="Javascript:ShowOther('Graduation');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryGraduation);$i++) {?>
			<option value="<?=$arryGraduation[$i]['attribute_value']?>" <?  if($arryGraduation[$i]['attribute_value']==$arryEmployee[0]['Graduation']){echo "selected";}?>>
			<?=$arryGraduation[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['Graduation']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="GraduationSpan">&nbsp;&nbsp;<input  name="OtherGraduation" id="OtherGraduation" value="<?=stripslashes($arryEmployee[0]['OtherGraduation'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('Graduation');</script>
		  
		  
		  </td>
  </tr>  
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top">Post Graduation  :</td>
          <td height="30" align="left" >
		  
			<select name="PostGraduation" class="inputbox" id="PostGraduation"  onchange="Javascript:ShowOther('PostGraduation');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryPostGraduation);$i++) {?>
			<option value="<?=$arryPostGraduation[$i]['attribute_value']?>" <?  if($arryPostGraduation[$i]['attribute_value']==$arryEmployee[0]['PostGraduation']){echo "selected";}?>>
			<?=$arryPostGraduation[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['PostGraduation']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="PostGraduationSpan">&nbsp;&nbsp;<input  name="OtherPostGraduation" id="OtherPostGraduation" value="<?=stripslashes($arryEmployee[0]['OtherPostGraduation'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('PostGraduation');</script>
		  
		  </td>
  </tr>  
	  
	
	
	    	
     <tr>
       <td height="30" align="right" valign="top"   class="blackbold"> Doctorate/Phd  : </td>
       <td  align="left" valign="top" >
		<select name="Doctorate" class="inputbox" id="Doctorate"  onchange="Javascript:ShowOther('Doctorate');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryDoctorate);$i++) {?>
			<option value="<?=$arryDoctorate[$i]['attribute_value']?>" <?  if($arryDoctorate[$i]['attribute_value']==$arryEmployee[0]['Doctorate']){echo "selected";}?>>
			<?=$arryDoctorate[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['Doctorate']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="DoctorateSpan">&nbsp;&nbsp;<input  name="OtherDoctorate" id="OtherDoctorate" value="<?=stripslashes($arryEmployee[0]['OtherDoctorate'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('Doctorate');</script>
	   </td>
     </tr>
	 
	 <tr>
          <td align="right"   class="blackbold" valign="top">Professional Course  :</td>
          <td height="30" align="left" >
		  
			<select name="ProfessionalCourse" class="inputbox" id="ProfessionalCourse"  onchange="Javascript:ShowOther('ProfessionalCourse');">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryProfessionalCourse);$i++) {?>
			<option value="<?=$arryProfessionalCourse[$i]['attribute_value']?>" <?  if($arryProfessionalCourse[$i]['attribute_value']==$arryEmployee[0]['ProfessionalCourse']){echo "selected";}?>>
			<?=$arryProfessionalCourse[$i]['attribute_value']?>
			</option>
		<? } ?>
			<option value="Other" <?  if($arryEmployee[0]['ProfessionalCourse']=="Other"){echo "selected";}?>>Other</option>
	</select> 	  
		  <span id="ProfessionalCourseSpan">&nbsp;&nbsp;<input  name="OtherProfessionalCourse" id="OtherProfessionalCourse" value="<?=stripslashes($arryEmployee[0]['OtherProfessionalCourse'])?>" type="text" class="inputbox" style="width: 120px;" maxlength="30" /></span>
		  <script language="javascript1.2">ShowOther('ProfessionalCourse');</script>
		  
		  </td>
  </tr> 
	 
	 
	 
	<tr>
        <td align="right"   class="blackbold" valign="top">
		Certification Course  :</td>
    <td height="30" align="left" valign="top" >
	
	 <textarea name="Certification" type="text" class="textarea" id="Certification"><?=stripslashes($arryEmployee[0]['Certification'])?></textarea>
	
	</td>
  </tr>	 
	<tr>
       		 <td colspan="2" align="left" class="head">Job Details</td>
        </tr>
		<? if(!empty($arryEmployee[0]['EmpCode'])){ ?>
      <tr>
        <td  align="right"   class="blackbold">
    Emp Code :</td>
        <td   align="left" ><?=stripslashes($arryEmployee[0]['EmpCode'])?>	</td>
      </tr>
	  <? } ?>
	  
<tr>
        <td align="right"   class="blackbold">Joining Date  :<span class="red">*</span></td>
        <td  align="left" >	
		
<script>
$(function() {
$( "#JoiningDate" ).datepicker({ 
		showOn: "both",
	yearRange: '1950:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});
});
</script>


<input id="JoiningDate" name="JoiningDate" readonly="" class="datebox" value="<?=$arryEmployee[0]['JoiningDate']?>"  type="text" >		</td>
      </tr>
 <? if($arryEmployee[0]['JoiningDate'] > 0){?>
     <tr>
        <td align="right"   class="blackbold">Termination Date  :</td>
        <td  align="left">
	<? if($arryEmployee[0]['ExpiryDate']<=0) $arryEmployee[0]['ExpiryDate']=''; ?>	
		
<script>
$(function() {
$( "#ExpiryDate" ).datepicker({ 
		showOn: "both",
	yearRange: '1950:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	changeMonth: true,
	changeYear: true
	});
});
</script>

<input id="ExpiryDate" name="ExpiryDate" readonly="" class="datebox" value="<?=$arryEmployee[0]['ExpiryDate']?>"  type="text" >						</td>
      </tr>
<? } ?>	  
	  
	  
	   <tr>
        <td  align="right"   class="blackbold"> Category  :<span class="red">*</span> </td>
        <td   align="left" >
		
            <select name="catID" class="inputbox" id="catID" >
			<option value="">--- Select ---</option>
              <? for($i=0;$i<sizeof($arryEmpCategory);$i++) {?>
              <option value="<?=$arryEmpCategory[$i]['catID']?>" <?  if($arryEmpCategory[$i]['catID']==$arryEmployee[0]['catID']){echo "selected";}?>>
              <?=$arryEmpCategory[$i]['catName']?>
              </option>
              <? } ?>
            </select> </td>
      </tr>

<!--tr>
        <td  align="right"   class="blackbold"> Division  :<span class="red">*</span> </td>
        <td   align="left" >

<select name="Division" class="inputbox" id="Division" onChange="Javascript:DeptListSend('','');">
  <option value="">--- Select ---</option>
  <? for($i=0;$i<sizeof($arryDepartment);$i++) {?>
  <option value="<?=$arryDepartment[$i]['depID']?>" <?  if($arryDepartment[$i]['depID']==$arryEmployee[0]['Division']){echo "selected";}?>>
  <?=$arryDepartment[$i]['Department']?>
  </option>
  <? } ?>
</select></td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> <div id="DeptTitle">Department  :<span class="red">*</span></div> </td>
        <td   align="left" >
		<div id="DeptValue"></div>
<input type="hidden" name="OldDeptID" id="OldDeptID" value="<?=$arryEmployee[0]['Department']?>" />	
<input type="hidden" name="Department" id="Department" value="<?=$arryVacancy[0]['Department']?>" />


	<script language="javascript">
	//DeptListSend('','');
	</script>

	</td>
      </tr-->	  


<tr >
	<td  align="right"   class="blackbold">Department :<span class="red">*</span></td>
	<td align="left">

	<select name="Department" class="inputbox" id="Department">
	  <option value="">--- Select ---</option>
	  <? for($i=0;$i<sizeof($arrySubDepartment);$i++) {?>
	  <option value="<?=$arrySubDepartment[$i]['depID']?>" <?  if($arrySubDepartment[$i]['depID']==$arryEmployee[0]['Department']){echo "selected";}?>>
	 <?=stripslashes($arrySubDepartment[$i]['Department'])?>
	  </option>
	  <? } ?>
	</select>

	 	</td>
  </tr>



	<tr>
        <td  align="right"  class="blackbold"> Designation  :<span class="red">*</span> </td>
        <td   align="left" ><select name="JobTitle" class="inputbox" id="JobTitle">
          <option value="">--- Select ---</option>
          <? for($i=0;$i<sizeof($arryJobTitle);$i++) {?>
          <option value="<?=$arryJobTitle[$i]['attribute_value']?>" <?  if($arryJobTitle[$i]['attribute_value']==$arryEmployee[0]['JobTitle']){echo "selected";}?>>
          <?=$arryJobTitle[$i]['attribute_value']?>
          </option>
          <? } ?>
        </select></td>
      </tr>
	
	<tr >
    <td  align="right"   class="blackbold">Job Type :<span class="red">*</span></td>
    <td align="left">

	<select name="JobType" class="inputbox" id="JobType">
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryJobType);$i++) {?>
			<option value="<?=$arryJobType[$i]['attribute_value']?>" <?  if($arryJobType[$i]['attribute_value']==$arryEmployee[0]['JobType']){echo "selected";}?>>
			<?=$arryJobType[$i]['attribute_value']?>
			</option>
		<? } ?>
	</select> 	</td>
  </tr>
	
<tr>
        <td align="right"   class="blackbold" >
		Total Experience  :<span class="red">*</span></td>
        <td height="30" align="left" >
		
	<select name="ExperienceYear" class="textbox" id="ExperienceYear" style="width:70px;">
		<option value="">--Select--</option>
		<option value="Fresher">Fresher</option>
		<? for($i=0;$i<=30;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryEmployee[0]['ExperienceYear']!=''  && $arryEmployee[0]['ExperienceYear'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
		<option value="30+" <? if($arryEmployee[0]['ExperienceYear'] == '30+') echo 'selected';?>> 30+ </option>	 
     </select> Years &nbsp;&nbsp; 	
		
	<select name="ExperienceMonth" class="textbox" id="ExperienceMonth" style="width:70px;">
		<option value="">--Select--</option>
		<? for($i=0;$i<=11;$i++){ ?>
		 <option value="<?=$i?>" <? if($arryEmployee[0]['ExperienceMonth']!=''  && $arryEmployee[0]['ExperienceMonth'] == $i) echo 'selected';?>> <?=$i?> </option>
		<? } ?>	
     </select> Months	
		
		</td>
	  </tr>	
	  
<? if(sizeof($arrySkill)>0){ ?>
	 <tr>
        <td align="right" class="blackbold" valign="top">Skill  :</td>
        <td  align="left" >
	 <!--input name="Skill" type="text" class="inputbox" id="Skill" value="<?=stripslashes($arryEmployee[0]['Skill'])?>" maxlength="50" -->			
	<?  if(!empty($arryEmployee[0]['Skill'])){
			$SkillArray = explode(", ", $arryEmployee[0]['Skill']);
		}else{
			$SkillArray[] = '';
		}
		
	?>
	<select name="Skill[]" class="inputbox" id="Skill" multiple style="height:120px;" >
		<option value="">--- None ---</option>
		<? for($i=0;$i<sizeof($arrySkill);$i++) {?>
			<option value="<?=$arrySkill[$i]['attribute_value']?>" <?  if(in_array($arrySkill[$i]['attribute_value'],$SkillArray)){echo "selected";}?>>
			<?=$arrySkill[$i]['attribute_value']?>
			</option>
		<? } ?>
	</select>	 
	 </td>
     </tr>  
	 <? } ?>
	  
	  <!--
	  <tr>
        <td align="right"   class="blackbold" >
		 Salary  :<span class="red">*</span></td>
        <td height="30" align="left" ><input name="Salary" type="text" class="textbox" size="10" id="Salary" value="<?php echo stripslashes($arryEmployee[0]['Salary']); ?>"  maxlength="15" />          &nbsp;<?=$Config['Currency']?>&nbsp;</td>
	  </tr>	  
	<tr >
    <td  align="right"   class="blackbold">Pay Frequency :<span class="red">*</span></td>
    <td align="left"><select name="SalaryFrequency" class="textbox" id="SalaryFrequency">
      <? for($i=0;$i<sizeof($arrySalaryFrequency);$i++) {?>
      <option value="<?=$arrySalaryFrequency[$i]['attribute_value']?>" <?  if($arrySalaryFrequency[$i]['attribute_value']==$arryEmployee[0]['SalaryFrequency']){echo "selected";}?>>
      <?=$arrySalaryFrequency[$i]['attribute_value']?>
      </option>
      <? } ?>
    </select></td>
  </tr>  -->	
	 
	<!--tr>
		 <td colspan="2" align="left" class="head">Role/Permissions</td>
	</tr>	

<tr>
        <td  align="right"   class="blackbold"> Role  : </td>
        <td   align="left" >
	
		<select name="Role" class="textbox" id="Role" onchange="Javascript:ShowPermission();" >
			<option value="">--- Select ---</option>
              <option value="Admin" <?  if($arryEmployee[0]['Role']=="Admin"){echo "selected";}?>> Admin </option>
              <option value="Other" <?  if($arryEmployee[0]['Role']=="Other"){echo "selected";}?>> Other </option>
            </select>
	
			
			          </td>
      </tr>  
	  
     <tr >
					       <td align="right" valign="top"  class="blackbold"><div id="PermissionTitle">Allow Permissions :</div></td>
					       <td align="left">
						   <div id="PermissionValue" >
						   
							  	<table width="100%" cellspacing=0 cellpadding=2 style="background-color:#EFEFEF"><tr>
								<td width="60%"><strong>Module Name</strong></td>
								<td width="20%"><input type="checkbox" name="ViewAll" id="ViewAll" onclick="javascript:SelectDeselect('ViewAll','ViewLabel');"  /><strong>View</strong></td>
								<td><input type="checkbox" name="ModifyAll" id="ModifyAll" onclick="javascript:SelectDeselect('ModifyAll','ModifyLabel');"  /><strong>Modify</strong></td>
								</tr></table>
 <? 
								$Line=0;
							  	foreach($arryDepartment as $key=>$valuesDept){

									$arrayMainModules = $objConfig->getMainModulesUser($_GET['edit'],0,$valuesDept['depID']);
									

									if(sizeof($arrayMainModules)>0){
										

										
										echo '<h2>'.$valuesDept['Department'].'</h2>';
										
										echo '<table width="100%" cellspacing=0 cellpadding=2><tr>';
										foreach($arrayMainModules as $key=>$valuesMod){
											$Line++; 
											echo '<tr><td width="60%" height="30">'.stripslashes($valuesMod['Module']).'</td> <td width="20%">';
											?>
		<input type="checkbox" name="ViewLabel<?=$Line?>" id="ViewLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['ViewLabel']) && !empty($_GET['edit'])) echo " checked"; ?> />								
											
											
											<?	echo '</td><td>'; ?>
											
		<input type="checkbox" name="ModifyLabel<?=$Line?>" id="ModifyLabel<?=$Line?>" value="<?=$valuesMod['ModuleID']?>" <? if(!empty($valuesMod['ModifyLabel']) && !empty($_GET['edit'])) echo " checked"; ?> />											
											
											<?
											echo '</td></tr>';
											/*if ($Line % 2 == 0) {
												echo "</tr><tr>";
											}*/
									

										} //end arrayAllModules
										 
										//echo '</tr></table>';
										echo '</table>';

									  }  //end if arrayAllModules
								   
								 }  //end arryDepartment 
								   
							
							  ?>
								
						   
						   
						   

	<input type="hidden" name="Line" id="Line" value="<?=$Line?>" />
	

						   
						   </div>
						   </td>
			          </tr--> 


	
	<tr>
       		 <td colspan="2" align="left" class="head">Account / Login Details</td>
        </tr>
		
      <tr>
        <td  align="right"   class="blackbold" width="35%"> Email :<span class="red">*</span> </td>
        <td   align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo $arryEmployee[0]['Email']; ?>"  maxlength="80" onKeyPress="Javascript:ClearAvail('MsgSpan_Email');" onBlur="Javascript:CheckAvail('MsgSpan_Email','Employee','<?=$_GET['edit']?>');"/>
		
	 <span id="MsgSpan_Email"></span>		</td>
      </tr>
	  
	  <? if(empty($_GET['edit'])){ ?>
        <tr>
        <td  align="right"   class="blackbold">Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="Password" type="Password" class="inputbox" id="Password" value="<?php echo stripslashes($arryEmployee[0]['Password']); ?>"  maxlength="15" autocomplete="off"/>          <span><?=PASSWORD_LIMIT?></span></td>
      </tr>		 
	  <tr>
        <td  align="right"   class="blackbold">Confirm Password :<span class="red">*</span> </td>
        <td   align="left" ><input name="ConfirmPassword" type="Password" class="inputbox" id="ConfirmPassword" value="<?php echo stripslashes($arryEmployee[0]['Password']); ?>"  maxlength="15" autocomplete="off"/> </td>
      </tr>	
	 <? } ?>
	 
      
	  
	

<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryEmployee[0]['Status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryEmployee[0]['Status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>
      </tr>
	
</table>	
  




	
	  
	
	</td>
   </tr>

  

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryEmployee[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryEmployee[0]['city_id']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	ShowPermission();
</SCRIPT>
