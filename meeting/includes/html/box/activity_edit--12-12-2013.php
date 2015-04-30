
<script type="text/javascript" src="javascript/jquery.timepicker.js"></script>

<link rel="stylesheet" type="text/css" href="javascript/jquery.timepicker.css" />
<script language="JavaScript1.2" type="text/javascript">
function validateEvent(frm){


	if( ValidateForSimpleBlank(frm.subject, "Subject")
		&& ValidateForSelect(frm.assignedTo,"Assign To")
		&& ValidateForSimpleBlank(frm.startDate, " Event Start Date")		
		&& ValidateForSimpleBlank(frm.startTime, " Event Start time")
		&& ValidateForSimpleBlank(frm.closeDate, " Event Close Date")
		&& ValidateForSimpleBlank(frm.closeTime, " Event Close time")
		&& ValidateForSelect(frm.event_status,"Event Status")
		&& ValidateForSelect(frm.activityType,"Activity Type")
		
		
		//&& ValidateForTextareaMand(frm.street_address,"Street Address",10,300)bs
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		
		
		){
		
				if(frm.closeDate.value<=frm.startDate.value){
			alert("Close Date should be greater than Start Date.");
			return false;
		}
		
		if(frm.closeTime.value<=frm.startTime.value){
			alert("Close Time should be greater than Start Time.");
			return false;
		}	

					
					return true;	
					
			}else{
					return false;	
			}	

		
}


function validateTask(frm){

	

	if( ValidateForSimpleBlank(frm.subject, "Subject")
		&& ValidateForSelect(frm.assignedTo,"Assign To")
		&& ValidateForSimpleBlank(frm.startDate, " Event Start Date")		
		&& ValidateForSimpleBlank(frm.startTime, " Event Start time")
		&& ValidateForSimpleBlank(frm.closeDate, " Event Close Date")
		&& ValidateForSimpleBlank(frm.closeTime, " Event Close time")
		&& ValidateForSelect(frm.event_status,"Event Status")
		//&& ValidateForSelect(frm.activityType,"Activity Type")
		
		
		//&& ValidateForTextareaMand(frm.street_address,"Street Address",10,300)bs
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		
		
		){
		
					if(frm.closeDate.value<=frm.startDate.value){
			alert("Close Date should be greater than Start Date.");
			return false;
		}
		
		if(frm.closeTime.value<=frm.startTime.value){
			alert("Close Time should be greater than Start Time.");
			return false;
		}

					
					return true;	
					
			}else{
					return false;	
			}	

		
}
function getval(sel) {
 
       //alert(sel.value);
	   document.getElementById("activity_type").value = sel.value;
    }

 $(function() {
			$('#startTime').timepicker({ 'timeFormat': 'H:i A' });
			$('#closeTime').timepicker({ 'timeFormat': 'H:i A' });
		  });

function selModule(){
//alert("AAAAAAAAAAA");
 var option = document.getElementById("RelatedType").value;
 
 
            if(option == "Opportunity")
                  {
                        document.getElementById("Opportunity").style.display="block";
						document.getElementById("Lead").style.display="none";
						document.getElementById("Campaigns").style.display="none";
						
                  }
            if(option == "Lead")
                  {
                        document.getElementById("Lead").style.display="block";
						document.getElementById("Opportunity").style.display="none";
						 document.getElementById("Campaigns").style.display="none";
						
						
						
                  }
				  
				   if(option == "Campaigns")
                  {
                        document.getElementById("Campaigns").style.display="block";
						document.getElementById("Lead").style.display="none";
							document.getElementById("Opportunity").style.display="none";
						
                  }
           
				  
		}



</script>
<SCRIPT LANGUAGE=JAVASCRIPT>

function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("EmpID"+i).checked=false;
	}
}
</SCRIPT>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validate<?=$_GET['mode']?>(this);" enctype="multipart/form-data">
<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head"><?=$_GET['mode'] ?>Details</td>
</tr>


      <tr>

        <td  align="right"   class="blackbold" width="40%">Subject  :<span class="red">*</span> </td>
         <td   align="left" >
          <input name="subject" type="text" class="inputbox" id="subject" value="<?php echo stripslashes($arryActivity[0]['subject']); ?>"  maxlength="50" />            </td>
      </tr>

	
	   <tr>
        <td  align="right"   class="blackbold">  Assigned To  :<span class="red">*</span> </td>
        <td   align="left" >
		
      <? if($HideSibmit!=1){?>
               <select name="assignedTo" class="inputbox" id="assignedTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryActivity[0]['assignedTo']){echo "selected";}?>>
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
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Start Date & Time  : <span class="red">*</span></td>
        <td   align="left" >
		<script type="text/javascript">
$(function() {
	
	$('#startDate').datepicker(
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


<input id="startDate" name="startDate" readonly="" class="disabled" size="12" value="<?php echo stripslashes($arryActivity[0]['startDate']); ?>" placeholder="Start Date"   type="text" />   
<input type="text" name="startTime" size="10" class="disabled time" id="startTime"  value="<?php echo stripslashes($arryActivity[0]['startTime']); ?>" placeholder="Start Time"/>
		  
             </td>
      </tr>
	  
 <tr>

 <tr>
        <td  align="right"   class="blackbold"> End Date & Time  : <span class="red">*</span></td>
        <td   align="left" >

		
<script type="text/javascript">
$(function() {
	$('#closeDate').datepicker(
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


<input id="closeDate" name="closeDate" readonly="" class="disabled" size="12" value="<?php echo stripslashes($arryActivity[0]['closeDate']); ?>" placeholder="Close Date"  type="text" > 
<input type="text" name="closeTime" size="10" class="disabled time" id="closeTime"  value="<?php echo stripslashes($arryActivity[0]['closeTime']); ?>" placeholder="Close Time"/>
		  
             </td>
      </tr>
	  
 <tr>


 <tr>
        <td  align="right"   class="blackbold"> Status  :<span class="red">*</span> </td>
        <td   align="left" >
		
              <select name="event_status" class="inputbox" id="event_status" >
		<option value="">--- Select ---</option>
		
			<option value="Planned"<?  if($arryActivity[0]['status']=="Planned"){echo "selected";}?>>Planned</option>
            <option value="Held" <?  if($arryActivity[0]['status']=="Held"){echo "selected";}?>>Held</option>
            <option value="Not Held" <?  if(stripslashes($arryActivityStatus[0]['event_status'])=="Not Held"){echo "selected";}?>>Not Held</option>
		</select>
		</td>
      </tr>
	   <tr <?=$none?>>
        <td  align="right"   class="blackbold"> Activity Type  :<span class="red">*</span> </td>
        <td   align="left" >
		
              <select name="activityType" class="inputbox" onchange="getval(this);" id="activityType" >
		<option value="">--- Select ---</option>
		<option value="Call"<?  if($arryActivity[0]['activityType']=="Call"){echo "selected";}?>>Call</option>
            <option value="Meeting" <?  if($arryActivity[0]['activityType']=="Meeting"){echo "selected";}?>>Meeting</option>
           </select>
		</td>
      </tr>
	  <tr <?=$none?>>
        <td  align="right"   class="blackbold"> Send Notification  : </td>
        <td   align="left" >
		
<input id="Notification" name="Notification" <? if($arryActivity[0]['Notification']==1){ echo "Checked"; }?>  size="15" value="1"  type="checkbox" > 
		  
             </td>
      </tr>
	  

	  <tr <?=$none?>>
        <td  align="right"   class="blackbold"> Location  : </td>
        <td   align="left" >
		
<input id="location" name="location"   size="15" value="<?=$arryActivity[0]['location']?>" class="inputbox"  type="text" > 
		  
             </td>
      </tr>  

 <tr>
        <td  align="right"   class="blackbold"> Priority  : </td>
        <td   align="left" >
		
       <select name="priority" class="inputbox" id="priority" >
		<option value="">--- Select ---</option>
		<option value="High"<?  if($arryActivity[0]['priority']=="High"){echo "selected";}?>>High</option>
         <option value="Medium" <?  if($arryActivity[0]['priority']=="Medium"){echo "selected";}?>>Medium</option>
         <option value="Low" <?  if(stripslashes($arryActivityStatus[0]['priority'])=="Low"){echo "selected";}?>>Low</option>
         </select>
		</td>
      </tr>
	     
 <tr <?=$none?>>
        <td  align="right"   class="blackbold"> Visibility  : </td>
        <td   align="left" >
		<select name="visibility" class="inputbox" id="visibility" >
			<option value="">--- Select ---</option>		
			<option value="Private" <?  if($arryActivity[0]['visibility']=="Private"){echo "selected";}?>>Private</option>
			<option value="Private" <?  if($arryActivity[0]['visibility']=="Public"){echo "selected";}?>>Public</option>
		</select>
		</td>
      </tr>

         <tr>
       		 <td colspan="2" align="left"   class="head">Reminder Details</td>
        </tr>
	   <tr>
        <td  align="right"   class="blackbold"> Send Reminder  : </td>
        <td   align="left" >
		
<input id="reminder" name="reminder" <? if($arryActivity[0]['reminder']==1){ echo "Checked"; }?>  size="15" value="1"  type="checkbox" > 
		  
             </td>
      </tr>
      
       <tr <?=$none?>>
                      <td  align="right" valign="top" class="blackbold"> 
					  Invite Employee : </td>
                      <td   align="left" valign="top">
					<? 
					$Width="45%";
					
					//if($_GET['edit'] >0){	?>
						<? //$arryEmp[0]['UserName']?> <? //$arryEmp[0]['Department']?>
						<!--<input type="hidden" name="EmpID" id="EmpID" value="<?=$arryEmp[0]['EmpID']?>">-->
					<? //}else 
					
					if(sizeof($arryEmployee)>0){ 
							$Width="20%";
							if(sizeof($arryEmployee)>1) { $DivStyle = 'style="height:20px;overflow-y:auto "';} 
					 ?>
				
<div id="PermissionValue" style="width:580px; height:180px; overflow:auto">  
<table width="100%"  border="0" cellspacing=0 cellpadding=2>
				  <tr> 
				  	<?   
				  		$flag = 0;
					   if(sizeof($arryEmployee)>0) {					   
					  for($i=0;$i<sizeof($arryEmployee);$i++) { 
					  
					  	if ($flag % 2 == 0) {
							echo "</tr><tr>";
						}
						
						$Line = $flag+1;
						
					   ?>
                      
 <td align="left"  valign="top" width="320" height="20">
 
	 <input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" <? for($j=0;$j<sizeof($arryEmp);$j++) { if($arryEmployee[$i]['EmpID']==$arryEmp[$j]['EmpID']){ echo "checked";}}?> value="<?=$arryEmployee[$i]['EmpID'];?>">&nbsp;<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)</a>
     <? //echo $arryEmployee[$i]['EmpID'];?>		  <? //print_r($arryEmp);?>						</td>
						 <?
						
						  $flag++;
						  } 
						  ?>
                        </tr>
						
                        <? }  ?>
                     
</table>
<input type="hidden" name="Line" id="Line" value="<? echo sizeof($arryEmployee);?>">
</Div>	
<?  if(sizeof($arryEmployee)>1) {	?>
    <div align="right">
	<a class="button" style="color:#FFFFFF;" href="javascript:SelectAllRecord();">Select All</a> | <a class="button" style="color:#FFFFFF;"  href="javascript:SelectNoneRecords();" > Select None</a>
	</div>	
<? } ?>					
					
					
					
					<? }else{ 
						$HideSibmit = 1;
					?>
					<div class="redmsg">No employee exist.</div>
					<? } ?>
					  </td>
                    </tr>

	    <tr <?=$none?>>
       		 <td colspan="2" align="left"   class="head">Related To</td>
        </tr>

 <tr <?=$none?>>
       
        <td   align="left" >
        <span>Related Type:</span>
		<select name="RelatedType" class="inputbox" onchange="selModule();" id="RelatedType" >
			<option value="">--- Select ---</option>	
			<option value="Lead" <?  if($arryActivity[0]['RelatedType']=="Lead"){echo "selected";}?>>Lead</option>
			<option value="Opportunity" <?  if($arryActivity[0]['RelatedType']=="Opportunity"){echo "selected";}?>>Opportunity</option>
			<option value="Campaigns" <?  if($arryActivity[0]['RelatedType']=="Campaigns"){echo "selected";}?>>Campaigns</option>
			
		</select>
		</td>
		   <td   align="" >
					

					<div id="Lead" style="display:none; ">
                  
                    <span>Lead:  </span>
						<select id="LeadID" class="inputbox"  name ="LeadID" >  
                          <option value="0" >--Select Lead--</option>
						<? 
						
						 for($i=0;$i<sizeof($arrySerch);$i++) {
						?>
							 
							<option value="<?=$arrySerch[$i]['leadID']?> " <?php  if($arrySerch[$i]['leadID']==$arryActivity[0]['LeadID']){echo "selected";}?>> <? echo $arrySerch[$i]['FirstName']; ?> <? echo $arrySerch[$i]['LastName'];?></option>
						<?  }
							 ?>
							
						</select>
                     </div>	
                     
                     <div id="Opportunity" style="display:none; ">
                     <span>Opprtunity:  </span>
						<select id="OpprtunityID" class="inputbox"  name ="OpprtunityID" >  
                          <option value="0" >--Select Opprtunity--</option>
						<?  for($i=0;$i<sizeof($arryOpportunity);$i++) {?>
							<option value="<?=$arryOpportunity[$i]['OpportunityID']?>" <?  if($arryOpportunity[$i]['OpportunityID']==$arryActivity[0]['OpprtunityID']){echo "selected";}?>> <? echo $arryOpportunity[$i]['OpportunityName']; ?> </option>
							<?
						 }
							 ?>
							
						</select>
                     </div>	
                     
                      <div id="Campaigns" style="display:none; ">
                      <span>Campaigns:  </span>
						<select id="CampaignID"  class="inputbox" name ="CampaignID" >  
                          <option value="0" >--Select Campaigns--</option>
                          
                          <? //$arrySerch=$objLead->ListLead($id=0,$SearchKey,$SortBy,$AscDesc);
						
						 for($i=0;$i<sizeof($arryCampaign);$i++) {?>
						 
							<option value="<?=$arryCampaign[$i]['campaignID']?>" <?  if($arryCampaign[$i]['campaignID']==$arryActivity[0]['CampaignID']){echo "selected";}?>> <? echo $arryCampaign[$i]['campaignname']; ?> </option>
							<?
						 }
							 ?>
						
							
						</select>
                     </div>	
						
				

		</td>
      </tr>

           <tr>
       		 <td colspan="2" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
            <Textarea name="description" id="description" class="inputbox"  ><? echo stripslashes($arryActivity[0]['description']); ?></Textarea>

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

<input type="hidden" name="activity_type" id="activity_type" value="<?=$arryActivity[0]['activityType']?>" />
<input type="hidden" name="activityID" id="activityID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />



</div>

</td>
   </tr>
   </form>
</table>


<SCRIPT LANGUAGE=JAVASCRIPT>
	
	
	
	selModule();

</SCRIPT>




