
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
		&& ValidateForSelect(frm.SalesStage, "Sales Stage")
		&& ValidateForSelect(frm.AssignTo,"Assign To")
		&& ValidateForSelect(frm.lead_source,"Lead Source")
		
		
		
		){
		
		
					
				
	
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
	 <td colspan="2" align="left" class="head">Opprtunity Details</td>
</tr>
<tr>
        <td  align="right"   class="blackbold" width="41%">Opportunity Name  :<span class="red">*</span> </td>
        <td width="59%"   align="left" >
<input name="OpportunityName" type="text" class="inputbox" id="OpportunityName" value="<?php echo stripslashes($arryOpportunity[0]['OpportunityName']); ?>"  maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Amount (<?=$Config['Currency']?>) :</td>
        <td   align="left" >
<input name="Amount" type="text" class="inputbox" id="Amount" value="<?php echo stripslashes($arryOpportunity[0]['Amount']); ?>"  maxlength="50" />            </td>
      </tr>
	   <tr>
        <td  align="right"   class="blackbold"> Organization Name : </td>
        <td   align="left" >
<input name="OrgName" type="text" class="inputbox" id="OrgName" value="<?php echo stripslashes($arryOpportunity[0]['OrgName']); ?>"  maxlength="50" />            </td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold">  Expected Close Date :<span class="red">*</span> </td>
        <td   align="left" >
				
<script type="text/javascript">
$(function() {
	$('#CloseDate').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '2013:<?=date("Y")?>', 
        changeMonth: true,
       changeYear: true
		}
	);
});
</script>
<input name="CloseDate" type="text" readonly="" class="disabled"  placeholder="Close Date" size="13" id="CloseDate" value="<?php echo stripslashes($arryOpportunity[0]['CloseDate']); ?>"  maxlength="50" />   <input type="text" name="CloseTime" size="10" class="disabled time" id="CloseTime"  value="" placeholder="Close Time"/>        </td>
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
      </tr>

	


     

	   <tr>
        <td  align="right"   class="blackbold">  Assigned To  :<span class="red">*</span> </td>
        <td   align="left" >
		
      <? if($HideSibmit!=1){?>
               <select name="AssignTo" class="inputbox" id="AssignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryOpportunity[0]['AssignTo']){echo "selected";}?>>
							<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)
							</option>
						<? } ?>
					</select>
					
					<? }else{ 
						$HideSibmit = 1;
					?>
					<div class="redmsg">No employee exist.</div>
					<? } ?>


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
 </tr>
  <tr>
        <td  align="right"   class="blackbold"> Next Step : </td>
        <td   align="left" >
<input name="NextStep" type="text" class="inputbox" id="NextStep" value="<?php echo stripslashes($arryOpportunity[0]['NextStep']); ?>"  maxlength="50" />            </td>
      </tr>
     
 <tr >
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
      </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold">Probability (%): </td>
        <td   align="left" >
<input name="Probability" type="text" class="inputbox" id="Probability" value="<?php echo stripslashes($arryOpportunity[0]['Probability']); ?>"  maxlength="15" />            </td>
      </tr>
 
   <tr>
        <td  align="right"   class="blackbold">Campaign Source : </td>
        <td   align="left" >
<input name="Campaign_Source" type="text" class="inputbox" id="Campaign_Source" value="<?php echo stripslashes($arryOpportunity[0]['Campaign_Source']); ?>"  maxlength="50" />            </td>
      </tr>

<tr>
        <td  align="right"   class="blackbold">Forecast Amount (<?=$Config['Currency']?>) : </td>
        <td   align="left" >
<input name="forecast_amount" type="text" class="inputbox" size="15" id="forecast_amount" value="<?php echo stripslashes($arryOpportunity[0]['forecast_amount']); ?>"  maxlength="50" />            </td>
      </tr>

	
	  <tr>
        <td  align="right"   class="blackbold">Contact Name : </td>
        <td   align="left" >
<input name="ContactName" type="text" class="inputbox" size="15" id="ContactName" value="<?php echo stripslashes($arryOpportunity[0]['ContactName']); ?>"  maxlength="50" />            </td>
      </tr>
	  
     <tr>
        <td  align="right"   class="blackbold">opp site : </td>
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
      </tr>



           <tr>
       		 <td colspan="2" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
            <Textarea name="description" id="description" class="inputbox"  ></Textarea>

<script type="text/javascript">

var editorName = 'description';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '410', 200, 'Basic');
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
	<td align="left" valign="top">&nbsp;
	
</td>
   </tr>

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
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