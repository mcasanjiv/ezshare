
<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>

<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />

 

<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateOpp(frm){

	

	if( ValidateForSimpleBlank(frm.OpportunityName, "Opportunity Name")
		&& ValidateForSelect(frm.CloseDate, "Expected Close Date")		
		){
		if(frm.CloseDate.value<=frm.TodayDate.value){
                    alert("Expected Close Date should be greater than Today Date.");
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

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateOpp(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Opprtunity Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"> Today Date : </td>
        <td   align="left" >
<? 
$TodayDateAarry = explode(" ", $Config['TodayDate']);
$TodayDate = $TodayDateAarry[0];
echo date($Config['DateFormat'], strtotime($TodayDate));  ?>
            
            <input type="hidden" name="TodayDate" id="TodayDate" value="<?=$TodayDate?>" />
</td>
      </tr>
<tr>
        <td  align="right"   class="blackbold" width="25%">Opportunity Name  :<span class="red">*</span> </td>
        <td width="20%"  align="left" >
<input name="OpportunityName" type="text" class="inputbox" id="OpportunityName" value="<?php echo stripslashes($arryOpportunity[0]['OpportunityName']); ?>"  maxlength="50" />            </td>
      
        <td  align="right"   class="blackbold" width="25%"> Organization Name : </td>
        <td   align="left" >
<input name="OrgName" type="text" class="inputbox" id="OrgName" value="<?php echo stripslashes($arryOpportunity[0]['OrgName']); ?>"  maxlength="50" />            </td>
      </tr>


	   <tr>
        <td  align="right"   class="blackbold"> Amount  :</td>
        <td   align="left" >
<input name="Amount" type="text" class="inputbox" id="Amount" onkeypress="return isDecimalKey(event);" value="<?php echo stripslashes($arryOpportunity[0]['Amount']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold">  Expected Close Date :<span class="red">*</span> </td>
        <td   align="left" >
				
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
<input name="CloseDate" type="text" readonly="" class="datebox"  placeholder="Close Date" size="13" id="CloseDate" value="<?php echo stripslashes($arryOpportunity[0]['CloseDate']); ?>"  maxlength="50" />  &nbsp;&nbsp; <input type="text" name="CloseTime" size="10" class="disabled time" id="CloseTime"  value="" placeholder="Close Time"/>        </td>
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
<input name="NextStep" type="text" class="inputbox" id="NextStep" value="<?php echo stripslashes($arryOpportunity[0]['NextStep']); ?>"  maxlength="50" />            </td></tr>
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
     
        <td  align="right"   class="blackbold">Forecast Amount  : </td>
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
<tr>
        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
                   <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($OpportunityStatus == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($OpportunityStatus == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          InActive </td>

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
<input name="assign" type="radio" id="assign1"  <?=($arryDocument[0]['AssignType'] == "User")?"checked":""?> checked  value="User"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" <?=($arryDocument[0]['AssignType'] == "Group")?"checked":""?> type="radio" id="assign2" value="Group"  maxlength="50" />&nbsp; Group       </td>
</tr>

	 
<tr >
  <td align="right"   class="blackbold"> &nbsp;&nbsp; </td>
        <td  align="left" colspan="3">

		<div id="group" <?=$classGroup?>>
               <select name="AssignToGroup" class="inputbox" id="AssignToGroup" >
		<option value="">--- Select ---</option>	   

<optgroup label="Groups">
		<? if(!empty($arryGroup)){?>
		
			<? for($i=0;$i<sizeof($arryGroup);$i++) {?>
			<option value="<?=$arryGroup[$i]['group_user']?>:<?=$arryGroup[$i]['GroupID']?>" <?  if($arryGroup[$i]['group_user']==$arryTicket[0]['AssignedTo']){echo "selected";}?>>
			<?=stripslashes($arryGroup[$i]['group_name']);?> 
		</option>
						<? }  }else{ ?>

						<div class="redmsg">No Group exist.</div>
					<? } ?>
</optgroup>
		</select>

	</div>
        
        <div id="user" <?=$classUser?>>
        <input type="text" class="inputbox" id="AssignToUser" name="AssignToUser" />
       <? if($_GET['edit']>0 && $json_response2!=''){ ?>
        <script type="text/javascript">
         $(document).ready(function() {
            $("#AssignToUser").tokenInput("multiSelect.php", {
                theme: "facebook",
				preventDuplicates: true,
				prePopulate: <?=$json_response2?>,
				
			propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " </div><div class='email'>" + item.department + "</div></div></li>" },

				
            });
        });
        </script>
        <? }else{?>
         <script type="text/javascript">
        $(document).ready(function() {
            $("#AssignToUser").tokenInput("multiSelect.php", {
                theme: "facebook",
				preventDuplicates: true,
				
					propertyToSearch: "name",
              resultsFormatter: function(item){ return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>" },
              //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
			  tokenFormatter: function(item){ return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>" },

				
            });
        });
        </script>
         <? }?>
        </div>
		
          </td>
      </tr>

	


           <tr>
       		 <td colspan="4" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" colspan="3">
            <Textarea name="description" id="description" class="inputbox"  ></Textarea>

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
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';
        
        
        ?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />



<input type="hidden" name="OpportunityID" id="OpportunityID"  value="<?=$_GET['edit']?>" />
<input type="hidden" name="Status" id="Status"  value="0" />	
<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryOpportunity[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryOpportunity[0]['city_id']; ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
	ShowPermission();
</SCRIPT>
