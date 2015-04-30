<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>
<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function validateCampaign(frm){

	

	if( ValidateForSimpleBlank(frm.campaignname, "Campaign Name")
		//&& ValidateForSelect(frm.assignedTo, "Assigned To")
		&& ValidateForSelect(frm.campaignstatus, "Campaign Status")
		&& ValidateForSelect(frm.campaigntype, "Campaign Type")
		&& ValidateForSelect(frm.product, "Product")
		//&& ValidateForSimpleBlank(frm.targetaudience, "Target Audience")
		&& ValidateForSelect(frm.closingdate, "Expected closing date")
		&& ValidateForSimpleBlank(frm.targetsize, "Target Size")
		&& ValidateForSimpleBlank(frm.numsent, "Num Sent")
		&& ValidateForSimpleBlank(frm.budgetcost, "Budget Cost")
		&& ValidateForSimpleBlank(frm.actualcost, "Actual Cost")
		&& ValidateForSimpleBlank(frm.expectedrevenue, "Expected Revenue")
		&& ValidateForSimpleBlank(frm.expectedsalescount, "Expected Sales Count")
		&& ValidateForSimpleBlank(frm.actualresponsecount, "Actual Response Count")
		&& ValidateForSimpleBlank(frm.expectedroi, "Expected Roi")
		&& ValidateForSimpleBlank(frm.actualroi, "Actual Roi")
		
		
		
		){
		
				ShowHideLoader('1','S');
					return true;	
					
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
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validateCampaign(this);" enctype="multipart/form-data">
  
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
	 <td colspan="4" align="left" class="head">Campaign Information</td>
</tr>
<tr>
        <td  align="right" class="blackbold">Campaign Name  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="campaignname" type="text" class="inputbox" id="campaignname" value="<?php echo stripslashes($arryCampaign[0]['campaignname']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold"> Assigned To  : </td>
        <td   align="left" >
		
      <? if($HideSibmit!=1){?>
               <select name="assignedTo" class="inputbox" id="assignedTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryCampaign[0]['assignedTo']){echo "selected";}?>>
							<?=stripslashes($arryEmployee[$i]['UserName']);?>
							</option>
						<? } ?>
					</select>
					
					<? }else{ 
						$HideSibmit = 1;
						echo NO_EMP_EXIST;
					   }
					?>
					
				


            </td>
            </tr>
             <tr>
        <td  align="right"   class="blackbold" width="25%"> Campaign Status :<span class="red">*</span> </td>
        <td   align="left" width="25%">
 <select name="campaignstatus" class="inputbox" id="campaignstatus" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCampaignStatus);$i++) {?>
			<option value="<?=$arryCampaignStatus[$i]['attribute_value']?>" <?  if($arryCampaignStatus[$i]['attribute_value']==$arryCampaign[0]['campaignstatus']){echo "selected";}?>>
			<?=$arryCampaignStatus[$i]['attribute_value']?>
			</option>
		<? } ?></select>            </td>
     
        <td  align="right"   class="blackbold" width="25%"> Campaign Type :<span class="red">*</span> </td>
        <td   align="left" >
 <select name="campaigntype" class="inputbox" id="campaigntype" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCampaignType);$i++) {?>
			<option value="<?=$arryCampaignType[$i]['attribute_value']?>" <?  if($arryCampaignType[$i]['attribute_value']==$arryCampaign[0]['campaigntype']){echo "selected";}?>>
			<?=$arryCampaignType[$i]['attribute_value']?>
			</option>
		<? } ?></select>            </td>
      </tr>
      
      <tr>
        <td  align="right"   class="blackbold"> Product  : <span class="red">*</span></td>
        <td   align="left" >
		
      <? if($HideSibmit!=1){?>
               <select name="product" class="inputbox" id="product" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryProduct);$i++) {?>
							<option value="<?=$arryProduct[$i]['ItemID']?>" <?  if($arryProduct[$i]['ItemID']==$arryCampaign[0]['product']){echo "selected";}?>>
							<?=stripslashes($arryProduct[$i]['description'])?> [Sku: <?=stripslashes($arryProduct[$i]['Sku'])?>] 
							</option>
						<? } ?>
					</select>
					
					<? }else{ 
						$HideSibmit = 1;
					?>
					<div class="redmsg">No Product exist.</div>
					<? } ?>


            </td>
          
        <td  align="right"   class="blackbold"> Target Audience : </td>
        <td   align="left" >
<input name="targetaudience" type="text" class="inputbox" id="targetaudience" value="<?php echo stripslashes($arryCampaign[0]['targetaudience']); ?>"  maxlength="50" />            </td>
      </tr>
            
            <tr>
        <td  align="right"   class="blackbold">  Expected Close Date :<span class="red">*</span> </td>
        <td   align="left" >
		
<script type="text/javascript">
$(function() {
	$('#closingdate').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")?>:<?=date("Y")+20?>', 
		minDate: "-D", 
        changeMonth: true,
		changeYear: true
		}
	);
});
</script>
<input type="text" value="<?php echo stripslashes($arryCampaign[0]['closingdate']); ?>" size="10" class="disabled" readonly="" name="closingdate" id="closingdate">
             </td>
     
        <td  align="right"   class="blackbold"> Target Size :<span class="red">*</span> </td>
        <td   align="left" >
<input name="targetsize" type="text" class="inputbox" id="targetsize" value="<?php echo stripslashes($arryCampaign[0]['targetsize']); ?>"  maxlength="50" />            </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Sponsor : </td>
        <td   align="left" >
<input name="sponsor" type="text" class="inputbox" id="sponsor" value="<?php echo stripslashes($arryCampaign[0]['sponsor']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold"> Num Sent (%)  : <span class="red">*</span></td>
        <td   align="left" >
<input name="numsent" type="text" class="inputbox" onkeypress="return isDecimalKey(event);" id="numsent" value="<?php echo stripslashes($arryCampaign[0]['numsent']); ?>" number  maxlength="50" />            </td>
      </tr>
	  
	  

	<tr>
       		 <td colspan="4" align="left"   class="head">Expectations & Actuals</td>
        </tr>


     

	  
			
 <tr>
        <td  align="right"   class="blackbold"> Budget Cost: (<?=$Config['Currency']?>)  :<span class="red">*</span> </td>
        <td   align="left" >
		
    <input name="budgetcost" type="text" class="inputbox" onkeypress="return isDecimalKey(event);" id="budgetcost" value="<?php echo stripslashes($arryCampaign[0]['budgetcost']); ?>"  maxlength="50" />   

 </td>
 
        <td  align="right"   class="blackbold"> Actual Cost: (<?=$Config['Currency']?>)  :<span class="red">*</span> </td>
        <td   align="left" >
		
    <input name="actualcost" type="text" class="inputbox" onkeypress="return isDecimalKey(event);" id="actualcost" value="<?php echo stripslashes($arryCampaign[0]['actualcost']); ?>"  maxlength="50" />   

 </td>
 </tr>
 
     
 <tr >
        <td  align="right"   class="blackbold"> Expected Response  : </td>
        <td   align="left" >
		

		<select name="expectedresponse" class="inputbox" id="expectedresponse" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryExpectedResponse);$i++) {?>
			<option value="<?=$arryExpectedResponse[$i]['attribute_value']?>" <?  if($arryExpectedResponse[$i]['attribute_value']==$arryCampaign[0]['expectedresponse']){echo "selected";}?>>
			<?=$arryExpectedResponse[$i]['attribute_value']?>
			</option>
		<? } ?>
			
	</select> 	  
             </td>
      
        <td  align="right"   class="blackbold"> Expected Revenue: (<?=$Config['Currency']?>)  : <span class="red">*</span></td>
        <td   align="left" >
		
    <input name="expectedrevenue" type="text" class="inputbox" id="expectedrevenue" value="<?php echo stripslashes($arryCampaign[0]['expectedrevenue']); ?>" number  maxlength="50" />   

 </td>
 </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold">Expected Sales Count : <span class="red">*</span></td>
        <td   align="left" >
<input name="expectedsalescount" type="text" class="inputbox" id="expectedsalescount" value="<?php echo stripslashes($arryCampaign[0]['expectedsalescount']); ?>" onkeypress="return isNumberKey(event);"  maxlength="15" />            </td>
     
        <td  align="right"   class="blackbold">Actual Sales Count   : </td>
        <td   align="left" >
<input name="actualsalescount" type="text" class="inputbox" size="15" id="actualsalescount" value="<?php echo stripslashes($arryCampaign[0]['actualsalescount']); ?>" onkeypress="return isNumberKey(event);"   maxlength="50" />            </td>
      </tr>

	
	  <tr>
        <td  align="right"   class="blackbold">Expected Response Count  : </td>
        <td   align="left" >
<input name="expectedresponsecount" type="text" class="inputbox" size="15" id="expectedresponsecount" value="<?php echo stripslashes($arryCampaign[0]['expectedresponsecount']); ?>" onkeypress="return isNumberKey(event);"   maxlength="50" />            </td>
      
        <td  align="right"   class="blackbold">Actual Response Count : <span class="red">*</span></td>
        <td   align="left" >
<input name="actualresponsecount" type="text" class="inputbox" size="15" id="actualresponsecount" value="<?php echo stripslashes($arryCampaign[0]['actualresponsecount']); ?>" onkeypress="return isNumberKey(event);"   maxlength="50" />            </td>
      </tr>
	<tr>
        <td  align="right"   class="blackbold"> Expected ROI: (<?=$Config['Currency']?>)  : <span class="red">*</span></td>
        <td   align="left" >
		
    <input name="expectedroi" type="text" class="inputbox" onkeypress="return isDecimalKey(event);" id="expectedroi" value="<?php echo stripslashes($arryCampaign[0]['expectedroi']); ?>"  maxlength="50" />   

 </td>

        <td  align="right"   class="blackbold"> Actual ROI: (<?=$Config['Currency']?>)  : <span class="red">*</span></td>
        <td   align="left" >
		
    <input name="actualroi" type="text" class="inputbox" onkeypress="return isDecimalKey(event);" id="actualroi" value="<?php echo stripslashes($arryCampaign[0]['actualroi']); ?>"   maxlength="50" />   

 </td>
 </tr>



           <tr>
       		 <td colspan="4" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" colspan="3">
            <Textarea name="description" id="description" class="inputbox"  ><? echo stripslashes($arryCampaign[0]['description']); ?></Textarea>

<script type="text/javascript">

var editorName = 'description';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '98%', 200, 'Basic');
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
<input type="hidden" name="campaignID" id="campaignID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />



</td>
   </tr>
   </form>
</table>
</div>




