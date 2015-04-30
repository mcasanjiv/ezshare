
<script>

jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
$( "#tpfrm" ).validate({
  rules: {
    field: {
      required: true,
      date: true
    }
  }
});
</script>
<div id="Convert_div" style="display:none;" >
    <h2>Convert Lead : <?=$arryLead[0]['FirstName']?></h2>
	<div id="info" style="color:red;" align="center"></div>
<form name="topForm"  id="tpfrm" action="" method="POST">

 <!-- <table width="500"   border="0" cellpadding="5" cellspacing="0" class="borderall">
       


 <tr>
	 <td colspan="2" class="head"><input type="checkbox" name="Contact" onclick="javascript:contact();" id="Contact" value="0"/>Create Contact  </td>
</tr>
</table>-->
   <!-- <div id="con" style="display:none;">
      <table width="500"   border="0" cellpadding="5" cellspacing="0" class="borderall">
       



      <tr>
        <td align="right"   > First Name  : </td>
        <td  align="left" >
         <input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryLead[0]['FirstName']); ?>"  maxlength="50" />            </td>
		 </tr>

	   <tr>
        <td align="right"   > Last Name  : </td>
        <td  align="left" >
<input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryLead[0]['LastName']); ?>"  maxlength="50" />            </td>
      </tr>
	  

 <tr>
        <td align="right"> Primary Email : </td>
        <td align="left">
<input name="Email" type="text" class="inputbox" id="Email" value="<?php echo stripslashes($arryLead[0]['primary_email']); ?>"  maxlength="50" />            </td>
      </tr>
	 

</table>
</div>-->
 
 <table width="500"   border="0" cellpadding="5" cellspacing="0" class="borderall">


  <tr>
	 <td colspan="2" class="head">Create Opportunity  </td>
</tr>
</table>

<div id="opp">
 <table width="500"   border="0" cellpadding="5" cellspacing="0" class="borderall">

 
<tr>
        <td  align="right"  > Opportunity Name  : <span class="red">*</span></td>
        <td  align="left" >
<input name="OpportunityName" type="text" class="inputbox" required id="OpportunityName" value=""  maxlength="50" />            </td>
      </tr>

	   <tr>
        <td  align="right"  > Expected Close Date :<span class="red">*</span></td>
        <td  align="left" >
<script type="text/javascript">
$(function() {


	$('#CloseDate').datepicker(
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


<input id="CloseDate" name="CloseDate"  class="disabled" required   size="15" value=""  type="date" >                </td>
      </tr>
	   <tr>
        <td  align="right"   > Sales Stage  :<span class="red">*</span> </td>
        <td align="left"  >

		  <select name="SalesStage" required class="inputbox" id="SalesStage" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arrySalesStage);$i++) {?>
			<option value="<?=$arrySalesStage[$i]['attribute_value']?>" <?  if($arrySalesStage[$i]['attribute_value']==$arryLead[0]['lead_source']){echo "selected";}?>>
			<?=$arrySalesStage[$i]['attribute_value']?>
			</option>
		<? } ?></select>           </td>
      </tr>
	   <tr>
        <td align="right"   > AssignTo  : <span class="red">*</span></td>
        <td align="left"  >


   <? if($HideSibmit!=1){?>
               <select name="AssignTo" required class="inputbox" id="AssignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryLead[0]['AssignTo']){echo "selected";}?>>
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
		
     
		
	
                
                </table>
				</div>
<br />
				 <div align="center">
                  <input name="Status" id="Status" type="hidden"   value="1"   />
				 <input name="lead_source" id="lead_source" type="hidden"   value="<?php echo $arryLead[0]['lead_source']; ?>"   />
				 <input name="LeadID" id="LeadID" type="hidden"   value="<?php echo $_GET['view']; ?>"   /> 
				 <input name="ContinueButton" type="submit" class="button" id="ContinueButton"  value="Continue &raquo;"   /></div>
	</form>
	
</div>	


