<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateOpp(frm){

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	if(document.getElementById("city_id") != null){
		document.getElementById("main_city_id").value = document.getElementById("city_id").value;
	}
	

	if( ValidateForSimpleBlank(frm.OpportunityName, "Opportunity Name")
		&& ValidateForSelect(frm.CloseDate, "Expected Close Date")		
		){

                if(frm.CloseDate.value<=frm.CreatedDate.value){
                    alert("Expected Close Date should be greater than Created Date.");
                    return false;	
                }
                
                if(!ValidateForSelect(frm.CloseTime, "Close Time")){
                    return false;
                }
                if(!ValidateForSelect(frm.SalesStage, "Sales Stage")){
                    return false;
                }
                if(!ValidateForSelect(frm.lead_source,"Lead Source")){
                    return false;
                }
                if(!ValidateForSelect(frm.AssignTo,"Assign To")){
                    return false;
                }








			if(document.getElementById("primary_email") != null){
				if(!isEmailOpt(frm.primary_email)){
					return false;
				}
			}

			if(document.getElementById("ZipCode") != null){

				if(!ValidateForSimpleBlank(frm.Address,"Street Address")){
					return false;
				}
				if(!ValidateForSelect(frm.country_id,"Country")){
					return false;
				}



				var main_state_id = $.trim($("#main_state_id").val());
				var main_city_id = $.trim($("#main_city_id").val());
				var OtherState = $.trim($("#OtherState").val());
				var OtherCity = $.trim($("#OtherCity").val());

				if((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
				{
					alert("Please Enter State.");
					$("#OtherState").focus();
					return false;
				}

				if((main_city_id == "" || main_city_id== "0") && (OtherCity == ""))
				{
					alert("Please Enter City.");
					$("#OtherCity").focus();
					return false;
				}


				if(!isZipCode(frm.ZipCode)){
					return false;
				}
			}





		   var Url = "isRecordExists.php?OpportunityName="+escape(document.getElementById("OpportunityName").value)+"&editID="+document.getElementById("OpportunityID").value+"&Type=Opportunity";
					SendExistRequest(Url,"OpportunityName", "Opportunity Name");

					return false;		
					
		}else{
				return false;	
		}	

		
}




//$('#timepicker_start').timepicker({ 'timeFormat': 'H:i:s' });

 $(function() {
			$('#CloseTime').timepicker({ 'timeFormat': 'H:i:s' });
			$('#timeformatExample2').timepicker({ 'timeFormat': 'h:i A' });
		  });

</script>


<div class="left_box">&nbsp;</div>



<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validateOpp(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_opp'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_opp'])) {echo $_SESSION['mess_opp']; unset($_SESSION['mess_opp']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="4" align="left" class="head">Opprtunity Details</td>
</tr>


 <tr>
        <td  align="right"   class="blackbold"> Created Date : </td>
        <td   align="left" >
<?

$CreatedDateAarry = explode(" ", $arryOpportunity[0]['AddedDate']);
$CreatedDate = $CreatedDateAarry[0];

 if($arryOpportunity[0]['AddedDate']>0) 
		   echo date($Config['DateFormat'], strtotime($arryOpportunity[0]['AddedDate']));
		   else echo NOT_SPECIFIED;
	   
	   ?>
            
     <input type="hidden" name="CreatedDate" id="CreatedDate" value="<?=$CreatedDate?>" />       
            
</td>
      </tr>

<tr>
        <td  align="right"   class="blackbold" width="25%">Opportunity Name  :<span class="red">*</span> </td>
        <td   align="left" width="20%">
<input name="OpportunityName" type="text" class="inputbox" id="OpportunityName" value="<?php echo stripslashes($arryOpportunity[0]['OpportunityName']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold" width="25%"> Organization Name : </td>
        <td   align="left" >
<input name="OrgName" type="text" class="inputbox" id="OrgName" value="<?php echo stripslashes($arryOpportunity[0]['OrgName']); ?>"  maxlength="50" />            </td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> Amount :</td>
        <td   align="left" >
<input name="Amount" type="text" class="inputbox" id="Amount" onkeypress="return isDecimalKey(event);" value="<?php echo stripslashes($arryOpportunity[0]['Amount']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold">  Expected Close Date :<span class="red">*</span> </td>
        <td   align="left" >
		<? $date_time= explode(" ",$arryOpportunity[0]['CloseDate']);	?>		
<script type="text/javascript">
$(function() {
	$('#CloseDate').datepicker(
		{
		showOn: "both",
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>', 
        changeMonth: true,
       changeYear: true
		}
	);
});
</script>
<input name="CloseDate" type="text" readonly="" class="datebox" size="13" id="CloseDate" value="<?php echo stripslashes($date_time[0]); ?>"  maxlength="50" />     <input type="text" name="CloseTime" size="10" class="disabled time" id="CloseTime" value="<?php echo stripslashes($date_time[1]); ?>" placeholder="Close Time"/>          </td>
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold"> Sales Stage : <span class="red">*</span></td>
        <td   align="left" >
 <select name="SalesStage" class="inputbox" id="SalesStage" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arrySalesStage);$i++) {?>
			<option value="<?=$arrySalesStage[$i]['attribute_value']?>" <?  if($arrySalesStage[$i]['attribute_value']==$arryOpportunity[0]['SalesStage']){echo "selected";}?>>
			<?=$arrySalesStage[$i]['attribute_value']?>
			</option>
		<? } ?></select>            </td>
     
       
	
        <td  align="right"   class="blackbold">  Customer  : </td>
        <td   align="left" >
		
	<? if(sizeof($arryCustomer)>0){?>
	<select name="CustID" class="inputbox" id="CustID" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			<option value="<?=$arryCustomer[$i]['Cid']?>" <?  if($arryCustomer[$i]['Cid']==$arryOpportunity[0]['CustID']){echo "selected";}?>>
			<?=stripslashes($arryCustomer[$i]['FullName']);?> 
			</option>
		<? } ?>
	</select>

	<? }else{ 
		echo NO_CUSTOMER_EXIST;
	}
	?>
	
            </td>
</tr>

	 <tr>

        <td  align="right"   class="blackbold"> Lead Source  :<span class="red">*</span> </td>
        <td   align="left" >
		
     <select name="lead_source" class="inputbox" id="lead_source" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryLeadSource);$i++) {?>
			<option value="<?=$arryLeadSource[$i]['attribute_value']?>" <?  if($arryLeadSource[$i]['attribute_value']==$arryOpportunity[0]['lead_source']){echo "selected";}?>>
			<?=$arryLeadSource[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select>

 </td>

        <td  align="right"   class="blackbold"> Next Step : </td>
        <td   align="left" >
<input name="NextStep" type="text" class="inputbox" id="NextStep" value="<?php echo stripslashes($arryOpportunity[0]['NextStep']); ?>"  maxlength="50" />            </td>
</tr>

	 <tr>
        <td  align="right"   class="blackbold">Opportunity Type  : </td>
        <td   align="left" >
		

		<select name="OpportunityType" class="inputbox" id="OpportunityType" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryOppType);$i++) {?>
			<option value="<?=$arryOppType[$i]['attribute_value']?>" <?  if($arryOppType[$i]['attribute_value']==$arryOpportunity[0]['OpportunityType']){echo "selected";}?>>
			<?=$arryOppType[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select> 	  
             </td>
      
        <td  align="right"   class="blackbold">Probability (%): </td>
        <td   align="left" >
<input name="Probability" type="text" class="inputbox" onkeypress="return isDecimalKey(event);" id="Probability" value="<?php echo stripslashes($arryOpportunity[0]['Probability']); ?>"  maxlength="15" />            </td>
 </tr>

	 <tr>
        <td  align="right"   class="blackbold">Campaign Source : </td>
        <td   align="left" >
<input name="Campaign_Source" type="text" class="inputbox" id="Campaign_Source" value="<?php echo stripslashes($arryOpportunity[0]['Campaign_Source']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold">Forecast Amount : </td>
        <td   align="left" >
<input name="forecast_amount" type="text" class="inputbox" onkeypress="return isDecimalKey(event);" size="15" id="forecast_amount" value="<?php echo stripslashes($arryOpportunity[0]['forecast_amount']); ?>"  maxlength="50" />            </td>
</tr>

	 <tr>
        <td  align="right"   class="blackbold">Contact Name : </td>
        <td   align="left" >
<input name="ContactName" type="text" class="inputbox" size="15" id="ContactName" value="<?php echo stripslashes($arryOpportunity[0]['ContactName']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold">Website : </td>
        <td   align="left" >
<input name="oppsite" type="text" class="inputbox" size="15" id="oppsite" value="<?php echo stripslashes($arryOpportunity[0]['oppsite']); ?>"  maxlength="50" />            </td>



   </tr>

  </tr>
 <tr>
        <td  align="right"   class="blackbold" >Status  : </td>
    <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($OpportunityStatus == 1) {$ActiveChecked = 'checked'; $InActiveChecked ='';}
				 if($OpportunityStatus == 0) {$ActiveChecked = ''; $InActiveChecked = 'checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive 
</td>
<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<?
//unset($arryCompany[0]['AdditionalCurrency']);
if(empty($arryCompany[0]['AdditionalCurrency']))$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryOpportunity[0]['Currency']) && !in_array($arryOpportunity[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryOpportunity[0]['Currency'];
}

 ?>
<select name="Currency" class="inputbox" id="Currency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryOpportunity[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>


    </tr> 

 <tr>
                            <td align="right"   class="blackbold"> Assigned To  :<span class="red">*</span> </td>
                            <td   align="left" >
                                <input name="assign" type="radio" id="assign1"  <?= ($arryOpportunity[0]['AssignType'] == "User") ? "checked" : "" ?> checked  value="User"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" <?= ($arryOpportunity[0]['AssignType'] == "Group") ? "checked" : "" ?> type="radio" id="assign2" value="Group"  maxlength="50" />&nbsp; Group       </td>
                        </tr>
                       

                        <tr >
                            <td align="right"   class="blackbold"> &nbsp;&nbsp; </td>
                            <td  align="left" colspan="3">

                                <div id="group" <?= $classGroup ?>>
                                    <select name="AssignToGroup" class="inputbox" id="AssignToGroup" >
                                        <option value="">--- Select ---</option>	   

                                        <optgroup label="Groups">
                                            <? if (!empty($arryGroup)) { ?>

                                                <? for ($i = 0; $i < sizeof($arryGroup); $i++) { ?>
                                                      <option value="<?= $arryGroup[$i]['group_user'] ?>:<?= $arryGroup[$i]['GroupID'] ?>" <? if ($arryGroup[$i]['group_user'] == $arryOpportunity[0]['AssignTo']) {
                                                        echo "selected";
                                                    } ?>>
                                                    <?= stripslashes($arryGroup[$i]['group_name']); ?> 
                                                      </option>
                                                <? }
                                            } else { ?>

                                                  <div class="redmsg">No Group exist.</div>
                                            <? } ?>
                                         </optgroup>
                                    </select>

                                </div>

                                <div id="user" <?= $classUser ?>>
                                    <input type="text" class="inputbox" id="AssignToUser" name="AssignToUser" />
<? if ($_GET['edit'] > 0 && $json_response2 != '') { ?>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $("#AssignToUser").tokenInput("multiSelect.php", {
                                                    theme: "facebook",
                                                    preventDuplicates: true,
                                                    prePopulate: <?= $json_response2 ?>,
                                                    propertyToSearch: "name",
                                                    resultsFormatter: function(item) {
                                                        return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                                    },
                                                    //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                    tokenFormatter: function(item) {
                                                        return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                                    },
                                                });
                                            });
                                        </script>
<? } else { ?>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $("#AssignToUser").tokenInput("multiSelect.php", {
                                                    theme: "facebook",
                                                    preventDuplicates: true,
                                                    propertyToSearch: "name",
                                                    resultsFormatter: function(item) {
                                                        return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                                    },
                                                    //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                    tokenFormatter: function(item) {
                                                        return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                                    },
                                                });
                                            });
                                        </script>
                                <? } ?>
                                </div>

                            </td>
        </tr>	


<? if($arryLead[0]['leadID']>0){ ?>
 <tr>
        <td  align="right"   class="blackbold"> Lead Email : </td>
        <td   align="left" >
<input name="primary_email" type="text" class="inputbox" id="primary_email" value="<?php echo stripslashes($arryLead[0]['primary_email']); ?>"  maxlength="50" />            </td>

 <td  align="right"> Last Contact Date :  </td>
        <td   align="left">
<? if($arryLead[0]['LastContactDate']>0)$LastContactDate = $arryLead[0]['LastContactDate'];?>		
<script>
$(function() {
$( "#LastContactDate" ).datepicker({ 
	showOn: "both",
	yearRange: '<?=date("Y")-20?>:<?=date("Y")?>', 
	dateFormat: 'yy-mm-dd',
	maxDate: "+0D", 
	changeMonth: true,
	changeYear: true
	});
});
</script>
<input id="LastContactDate" name="LastContactDate" readonly="" class="datebox" value="<?=$LastContactDate?>"  type="text" >         </td>




    
      <tr>
       <? if($arryLead[0]['leadID']>0){ ?>
     
     <td  align="right"   class="blackbold"> Industry  : </td>
        <td   align="left" >
		
        <select name="Industry" class="inputbox" id="Industry" >
            <option value="">--- Select ---</option>
            <? for($i=0;$i<sizeof($arryIndustry);$i++) {?>
            <option value="<?=$arryIndustry[$i]['attribute_value']?>" <?  if($arryIndustry[$i]['attribute_value']==$arryOpportunity[0]['Industry']){echo "selected";}?>>
            <?=$arryIndustry[$i]['attribute_value']?>
            </option>
           <? } ?>
        </select>
       </td>
       
    <? }?>
     
     </tr>
     
     
    
    
	<tr>
	 <td colspan="4" align="left" class="head">Address Details</td>
</tr>
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Street Address  :<span class="red">*</span></td>
          <td  align="left" >
            <textarea name="Address" type="text" class="textarea" id="Address"><?=stripslashes($arryLead[0]['Address'])?></textarea>			          </td>
        </tr>
         
	<tr <?=$Config['CountryDisplay']?>>
        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
        <td   align="left" >
		<?
	if($arryLead[0]['country_id'] != ''){
		$CountrySelected = $arryLead[0]['country_id']; 
	}
	?>
            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
             <option value="" >--Select Country--</option>
              <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
              <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$CountrySelected){echo "selected";}?>>
              <?=$arryCountry[$i]['name']?>
              </option>
              <? } ?>
            </select>        </td>
      </tr>
    <tr>
	  <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :<span class="red">*</span></td>
	  <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
	</tr>
	    <tr>
        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :<span class="red">*</span></div> </td>
        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryLead[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
      </tr>
     
	   <tr>
        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :<span class="red">*</span></div></td>
        <td  align="left"  ><div id="city_td"></div></td>
      </tr> 
	     <tr>
        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :<span class="red">*</span></div>  </td>
        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryLead[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
      </tr>
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
        <td  align="left"  >
	 <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?=stripslashes($arryLead[0]['ZipCode'])?>" maxlength="15" />			</td>
      </tr>
	
	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
 <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?=stripslashes($arryLead[0]['LandlineNumber'])?>"     maxlength="30" />		</td>
      </tr>  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	 <input name="Mobile" type="text" onkeypress="return isNumberKey(event);" class="inputbox" id="Mobile" value="<?=stripslashes($arryLead[0]['Mobile'])?>"     maxlength="20" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryLead[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryLead[0]['city_id']; ?>" />

			</td>
      </tr>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>
<? } ?>

           <tr>
       		 <td colspan="4" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" colspan="3">
            <Textarea name="description" id="description" class="inputbox"  ><? echo stripslashes($arryOpportunity[0]['description']); ?></Textarea>

<script type="text/javascript">

var editorName = 'description';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '97%', 200, 'Basic');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor(); 


</script>			          </td>
        </tr>

 

	

	

		
	

</table>	



<script type="text/javascript">
$('#piGal table').bxGallery({
  maxwidth: 300,
  maxheight: 200,
  thumbwidth: 75,
  thumbcontainer: 300,
  load_image: 'ext/jquery/bxGallery/spinner.gif'
});
</script>


<script type="text/javascript">
$("#piGal a[rel^='fancybox']").fancybox({
  cyclic: true
});
</script>



	
	  
	
	</td>
   </tr>

   

   <tr>
    <td  align="center" >
	
	<div id="SubmitDiv" <?=$dis?>>
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />




</div>
<input type="hidden" name="OpportunityID" id="OpportunityID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="leadID" id="leadID" value="<?=$arryLead[0]['leadID']?>" />

<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />





</td>
   </tr>
   </form>
</table>
</div>
<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="Edit"){ ?>
	StateListSend();
<? } ?>
<? if($_GET["tab"]=="account"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>



