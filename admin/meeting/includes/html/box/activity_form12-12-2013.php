
<script language="JavaScript1.2" type="text/javascript">
function validateEvent(frm){


	if( ValidateForSimpleBlank(frm.subject, "Subject")
		&& ValidateForSelect(frm.assignedTo,"Assign To")
		&& ValidateForSimpleBlank(frm.startDate, "  Start Date")		
		&& ValidateForSimpleBlank(frm.startTime, "  Start time")
		&& ValidateForSimpleBlank(frm.closeDate, " Close Date")
		&& ValidateForSimpleBlank(frm.closeTime, " Close time")
		&& ValidateForSelect(frm.status,"Status")
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
		
		
		 var Url = "isRecordExists.php?EventSubject="+escape(document.getElementById("subject").value)+"&editID="+document.getElementById("activityID").value+"&Type="+document.getElementById("activity_type").value;
		 
		 
					SendExistRequest(Url,"subject", "Event Subject");

					return false;
					
			}else{
					return false;	
			}	

		
}


function validateTask(frm){


	if( ValidateForSimpleBlank(frm.subject, "Subject")
		&& ValidateForSelect(frm.assignedTo,"Assign To")
		&& ValidateForSimpleBlank(frm.startDate, "  Start Date")		
		&& ValidateForSimpleBlank(frm.startTime, "  Start time")
		&& ValidateForSimpleBlank(frm.closeDate, " Close Date")
		&& ValidateForSimpleBlank(frm.closeTime, " Close time")
		&& ValidateForSelect(frm.status,"Status")
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
		
				 var Url = "isRecordExists.php?EventSubject="+escape(document.getElementById("subject").value)+"&editID="+document.getElementById("activityID").value+"&Type="+document.getElementById("activity_type").value;
		 
		 
					SendExistRequest(Url,"subject", "Task");

					return false;
					
			}else{
					return false;	
			}	

		
}

 $(function() {
			$('#startTime').timepicker({ 'timeFormat': 'H:i A' });
			$('#closeTime').timepicker({ 'timeFormat': 'H:i A' });
		  });


function activity2(ref){
		
	//alert("aaaaaaaaaa");
	
	if(ref=='Task'){
	window.location.href="editActivity.php?module=Activity&mode="+ref;
	}else{
	window.location.href="editActivity.php?module=Activity&mode="+ref;;
	}
	
	
		
		
		//document.getElementById("Task").style.display = "bolck";
		
		
		
}
function selModule(){
 var option = document.getElementById("RelatedType").value;
 
 //alert(option);
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

 function getval(sel) {
 
       //alert(sel.value);
	   document.getElementById("activity_type").value = sel.value;
    }
</SCRIPT>

<? if($_GET['mode']=="Task"){

$detail_head=$_GET['mode'];

$none="style='display:none';";
}else{
$detail_head="Event";
$none="";
}


?>
<div><a href="javascript:;" style="color:#FFFFFF;" class="button" onclick="activity2('Event');">Event</a> &nbsp;&nbsp;&nbsp;<a style="color:#FFFFFF;" href="javascript:;" class="button" onclick="activity2('Task');">Task</a></div>

<div id="Event">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


<form name="form1" action=""  method="post" onSubmit="return validate<?=$_GET['mode']?>(this);" enctype="multipart/form-data">

<tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="2" align="left" class="head"><?=$_GET['mode']?> Details</td>
</tr>


      <tr>

        <td  align="right"   class="blackbold" width="40%">Subject  :<span class="red">*</span> </td>
         <td   align="left" >
          <input name="subject" type="text" class="inputbox" id="subject" value="<?php echo stripslashes($arryEvent[0]['subject']); ?>"  maxlength="50" />            </td>
      </tr>

	
	   <tr>
        <td  align="right"   class="blackbold">  Assigned To  :<span class="red">*</span> </td>
        <td   align="left" >
		
      <? if($HideSibmit!=1){?>
               <select name="assignedTo" class="inputbox" id="assignedTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryEvent[0]['assignedTo']){echo "selected";}?>>
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


<input id="startDate" name="startDate" readonly="" class="disabled" size="12" value="" placeholder="Start Date"  type="text" />   
<input type="text" name="startTime" size="10" class="disabled time" id="startTime"  value="<?php echo stripslashes($arryEvent['startTime']); ?>" placeholder="Start Time"/>
		  
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


<input id="closeDate" name="closeDate" readonly="" class="disabled" size="12" value="<?php echo stripslashes($arryEvent['closeDate']); ?>" placeholder="Close Date"  type="text" > 
<input type="text" name="closeTime" size="10" class="disabled time" id="closeTime"  value="<?php echo stripslashes($arryEvent['closeTime']); ?>" placeholder="Close Time"/>
		  
             </td>
      </tr>
	  
 <tr>


 <tr>
        <td  align="right"   class="blackbold"> Status  :<span class="red">*</span> </td>
        <td   align="left" >
		
              <select name="status" class="inputbox" id="status" >
		<option value="">--- Select ---</option>
		
			<option value="Planned"<?  if($arryEvent[0]['event_status']=="Planned"){echo "selected";}?>>Planned</option>
            <option value="Held" <?  if($arryEvent[0]['status']=="Held"){echo "selected";}?>>Held</option>
            <option value="Not Held" <?  if(stripslashes($arryEventStatus[0]['event_status'])=="Not Held"){echo "selected";}?>>Not Held</option>
		</select>
		</td>
      </tr>
	   <tr <?=$none?>>
        <td  align="right"   class="blackbold"> Activity Type  :<span class="red">*</span> </td>
        <td   align="left" >
		
              <select name="activityType" class="inputbox" onchange="getval(this);" id="activityType" >
		<option value="">--- Select ---</option>
		<option value="Call"<?  if($arryEvent[0]['event_status']=="Call"){echo "selected";}?>>Call</option>
            <option value="Meeting" <?  if($arryEvent[0]['event_status']=="Meeting"){echo "selected";}?>>Meeting</option>
           </select>
		</td>
      </tr>
	  <tr <?=$none?>>
        <td  align="right"   class="blackbold"> Send Notification  : </td>
        <td   align="left" >
		
<input id="Notification" name="Notification" <? if($arryEvent['Notification']==1){ echo "Checked"; }?>  size="15" value="1"  type="checkbox" > 
		  
             </td>
      </tr>
	  

	  <tr <?=$none?>>
        <td  align="right"    class="blackbold"> Location  : </td>
        <td   align="left" >
		
<input id="location" name="location"   size="15" value="<?=$arryEvent['location']?>" class="inputbox"  type="text" > 
		  
             </td>
      </tr>  

 <tr>
        <td  align="right"   class="blackbold"> Priority  : </td>
        <td   align="left" >
		
       <select name="priority" class="inputbox" id="priority" >
		<option value="">--- Select ---</option>
		<option value="High"<?  if($arryEvent[0]['priority']=="High"){echo "selected";}?>>High</option>
         <option value="Medium" <?  if($arryEvent[0]['priority']=="Medium"){echo "selected";}?>>Medium</option>
         <option value="Low" <?  if(stripslashes($arryEventStatus[0]['priority'])=="Low"){echo "selected";}?>>Low</option>
         </select>
		</td>
      </tr>
	     
 <tr <?=$none?>>
        <td  align="right"    class="blackbold"> Visibility  : </td>
        <td   align="left" >
		<select name="visibility" class="inputbox" id="visibility" >
			<option value="">--- Select ---</option>		
			<option value="Private" <?  if($arryEvent['visibility']=="Private"){echo "selected";}?>>Private</option>
			<option value="Private" <?  if($arryEvent['visibility']=="Public"){echo "selected";}?>>Public</option>
		</select>
		</td>
      </tr>

         <tr>
       		 <td colspan="2" align="left"   class="head">Reminder Details</td>
        </tr>
	   <tr >
        <td  align="right"   class="blackbold"> Send Reminder  : </td>
        <td   align="left" >
		
<input id="reminder" name="reminder" <? if($arryEvent['reminder']==1){ echo "Checked"; }?>  size="15" value="1"  type="checkbox" > 
		  
             </td>
      </tr>
      
       <tr <?=$none?>>
                      <td  align="right" valign="top" class="blackbold"> 
					  Invite Employee : </td>
                      <td   align="left" valign="top">
					<? 
					$Width="45%";
					
					if($_GET['edit'] >0){	?>
						<?=$arryEntitlement[0]['UserName']?> (<?=$arryEntitlement[0]['Department']?>)
						<input type="hidden" name="EmpID" id="EmpID" value="<?=$arryEntitlement[0]['EmpID']?>">
					<? }else if(sizeof($arryEmployee)>0){ 
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
	 <input type="checkbox" name="EmpID[]" id="EmpID<?=$Line?>" value="<?=$arryEmployee[$i]['EmpID'];?>">&nbsp;<?=stripslashes($arryEmployee[$i]['UserName']);?> (<?=stripslashes($arryEmployee[$i]['Department']);?>)</a>							</td>
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
			<option value="Lead" <?  if($arryEvent['RelatedType']=="Lead"){echo "selected";}?>>Lead</option>
			<option value="Opportunity" <?  if($arryEvent['RelatedType']=="Opportunity"){echo "selected";}?>>Opportunity</option>
			<option value="Campaigns" <?  if($arryEvent['RelatedType']=="Campaigns"){echo "selected";}?>>Campaigns</option>
			
		</select>
		</td>
		   <td   align="" >
					

					<div id="Lead" style="display:none; ">
                    <span>Lead:  </span>
						<select id="LeadID" class="inputbox"  name ="LeadID" >  
                          <option ="" >--Select Lead--</option>
						<? $arrySerch=$objLead->ListLead($id=0,$SearchKey,$SortBy,$AscDesc);
						
						 for($i=0;$i<sizeof($arrySerch);$i++) {
							 
							echo '<option value="'.$arrySerch[$i]['LeadID'].'">'. $arrySerch[$i]['FirstName'].' '. $arrySerch[$i]['LastName'].'</option>'; 
						 }
							 ?>
							
						</select>
                     </div>	
                     
                     <div id="Opportunity" style="display:none; ">
                     <span>Opprtunity:  </span>
						<select id="OpprtunityID" class="inputbox"  name ="OpprtunityID" >  
                          <option ="" >--Select Opprtunity--</option>
						<? //$arrySerch=$objLead->ListLead($id=0,$SearchKey,$SortBy,$AscDesc);
						
						 for($i=0;$i<sizeof($arryOpportunity);$i++) {
							 
							echo '<option value="'.$arryOpportunity[$i]['OpportunityID'].'">'. $arryOpportunity[$i]['OpportunityName'].'</option>'; 
						 }
							 ?>
							
						</select>
                     </div>	
                     
                      <div id="Campaigns" style="display:none; ">
                       <span>Campaigns:  </span>
						<select id="CampaignID"  class="inputbox" name ="CampaignID" >  
                          <option ="" >--Select Campaigns--</option>
						<? 
						
						 for($i=0;$i<sizeof($arryCampaign);$i++) {
							 
							echo '<option value="'.$arryCampaign[$i]['campaignID'].'">'. $arryCampaign[$i]['campaignname'].'</option>'; 
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


<input type="hidden" name="activityID" id="activityID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="activity_type" id="activity_type" value="<?=$_GET['mode']?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />



</div>

</td>
   </tr>
   </form>
</table>
</div>

  

  
  





