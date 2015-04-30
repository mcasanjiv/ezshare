<script type="text/javascript" src="FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
	
function validateTicket(frm){
	if(ValidateForSimpleBlank(frm.title, "Ticket Title")
		&& ValidateRadioButtons(frm.assign,"Assign To")){






var AssignUser =  document.getElementById('assign1').checked;
var AssignGroup =  document.getElementById('assign2').checked;
//alert(AssignUser);
if(AssignUser == true){


if(document.getElementById('AssignToUser').value == ''){

alert("Please Enter Assign User Name.");
document.getElementById('AssignToUser').focus();
return false;	
}
}else if(AssignGroup == true){
if(document.getElementById('AssignToGroup').value == ''){

alert("Please Select Assign Group.");
document.getElementById('AssignToGroup').focus();
return false;	
}


}

	


		if(ValidateForSelect(frm.Status,"Ticket Status")
		&& ValidateForSelect(frm.priority,"Ticket Priority")
		&& ValidateForSelect(frm.category,"Ticket Category")
		&& ValidateForTextareaMand(frm.description,"Description")
		//&& isZipCode(frm.ZipCode)
		//&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)
		
		
		){
		
var Url = "isRecordExists.php?TicketTitle="+escape(document.getElementById("title").value)+"&editID="+document.getElementById("TicketID").value+"&Type=Ticket";
					SendExistRequest(Url,"title", "Ticket Title");

					return false;	
}	
return false;	
					
			}else{
					return false;	
			}	

		
}
</script>


<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateTicket(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Ticket Information</td>
</tr>
<tr>
    <td  align="right"   class="blackbold" valign="top"> Title  :<span class="red">*</span> </td>
    <td   align="left" >
<textarea name="title" maxlength="200" class="textarea" id="title"><?php echo stripslashes($arryTicket[0]['title']); ?></textarea>           </td>
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
        <td  align="right"   class="blackbold" width="20%"> Ticket Status  : <span class="red">*</span></td>
        <td   align="left" width="30%">
		
            <select name="Status" class="inputbox" id="Status" >
            
            <option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryTicketStatus);$i++) {?>
			<option value="<?=$arryTicketStatus[$i]['attribute_value']?>" <?  if($arryTicketStatus[$i]['attribute_value']==$arryTicket[0]['Status']){echo "selected";}?>>
			<?=$arryTicketStatus[$i]['attribute_value']?>
			</option>
		<? } ?>
        </select>
            </td>
     
        <td  align="right"   class="blackbold" width="25%"> Priority : <span class="red">*</span></td>
        <td   align="left" >
	<select name="priority" class="inputbox" id="priority" >
	  <option value="">--- Select ---</option>
	  <? for($i=0;$i<sizeof($arryPriority);$i++) {?>
	   <option value="<?=$arryPriority[$i]['attribute_value']?>" <?  if($arryPriority[$i]['attribute_value']==$arryTicket[0]['priority']){echo "selected";}?>>
		<?=$arryPriority[$i]['attribute_value']?>
		</option>
		<? } ?>
	</select>
       </td>
      </tr>

	  <tr>
        <td  align="right"   class="blackbold">Ticket Category : <span class="red">*</span></td>
        <td   align="left" >
           <select name="category" class="inputbox" id="category" >
			<option value="">--- Select ---</option>
             <? for($i=0;$i<sizeof($arryTicketCategory);$i++) {?>
			<option value="<?=$arryTicketCategory[$i]['attribute_value']?>" <?  if($arryTicketCategory[$i]['attribute_value']==$arryTicket[0]['category']){echo "selected";}?>>
			<?=$arryTicketCategory[$i]['attribute_value']?>
			</option>
		<? } ?>
            
			
            </select>            </td>
     
		<td  align="right"   class="blackbold"> Days : </td>
		<td   align="left" >
		<input name="day" type="text" class="inputbox" id="day" value="<?php echo stripslashes($arryTicket[0]['day']); ?>"  maxlength="50" />            </td>
	</tr>
	<tr>
        <td  align="right"   class="blackbold"> Hours : </td>
        <td   align="left" >
<input name="Hours" type="text" class="inputbox" id="Hours" value="<?php echo stripslashes($arryTicket[0]['hours']); ?>"  maxlength="50" />            </td>
     
        <td  align="right"   class="blackbold">  Customer  : </td>
        <td   align="left" >
		
	<? if(sizeof($arryCustomer)>0){?>
	<select name="CustID" class="inputbox" id="CustID" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			<option value="<?=$arryCustomer[$i]['Cid']?>" <?  if($arryCustomer[$i]['Cid']==$arryTicket[0]['CustID']){echo "selected";}?>>
			<?=stripslashes($arryCustomer[$i]['FullName']);?> 
			</option>
		<? } ?>
	</select>

	<? }else{ 
		echo NO_CUSTOMER_EXIST;
	} ?>


            </td>
 </tr>
  

	
           <tr>
       		 <td colspan="4" align="left"   class="head">Description Details</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :<span class="red">*</span></td>
          <td  align="left" colspan="3">
            <Textarea name="description" style="width:400px;" id="description" class="inputbox" maxlength="500" ><? echo stripslashes($arryTicket[0]['description']); ?></Textarea>

	          </td>
        </tr>

		<tr>
       		 <td colspan="4" align="left"   class="head">Ticket Resolution</td>
        </tr>
   
	  
	  
	  
       <tr>
          <td align="right"   class="blackbold" valign="top">Solution :</td>
          <td  align="left" colspan="3">
            <textarea name="solution" style="width:400px;" type="text" class="textarea" id="solution"><?=stripslashes($arryTicket[0]['solution'])?></textarea>			          </td>
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
    
    <? //echo "<pre>"; print_r($_SESSION);?>
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
      
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />	
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />

<input type="hidden" name="parent_type" id="parent_type"  value="<?=$_GET['parent_type']?>" />	
<input type="hidden" name="parentID" id="parentID"  value="<?=$_GET['parentID']?>" />
<input type="hidden" name="module" id="module"  value="<?=$_GET['module']?>" />

<input type="hidden" name="TicketID" id="TicketID" value="<?=$_GET['edit']?>" />


</div>

</td>
   </tr>
   </form>
</table>

