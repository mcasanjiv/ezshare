<script language="JavaScript1.2" type="text/javascript">
 function validateLeadForm(frm){
   
    var listbox = document.getElementById("columnTo");
    
    var len = listbox.options.length;
    if(len>0){
        for(var count=0; count < len; count++) {
                listbox.options[count].selected = true;
        }
    }else{
        alert('Please Move Fields to Lead Form Fields.');
         return false;
    }
    
    if(!ValidateForSimpleBlank(frm.FormTitle, "Form Title")) {
        return false;
    }
    if(!ValidateForSimpleBlank(frm.Subtitle, "Subtitle")) {
        return false;
    }
    /*if(!ValidateForSimpleBlank(frm.ActionUrl, "Form Action Url")) {
        return false;
    }*/
    
   ShowHideLoader('1', 'S');
   return true;
        
}
   
function MoveFields() {
     $("#first_div").hide();
     $("#add_all_div").hide();
     $("#move_div").show();
     $("#cancel").show();
     $("#submit").show();
     $("#other_info").show();
     $("#entry_all").val("0");
 }

</script>

 <script type="text/javascript">  
  $().ready(function() { 
      
   $('#fromall').click(function() { 
    return !$('#columnFrom option').remove().appendTo('#columnTo');  
   });  
   $('#add').click(function() { 
    return !$('#columnFrom option:selected').remove().appendTo('#columnTo');  
   });  
   $('#remove').click(function() {  
    return !$('#columnTo option:selected').remove().appendTo('#columnFrom');  
   });  
   $('#removeall').click(function() { 
    return !$('#columnTo option').remove().appendTo('#columnFrom');  
   });
  });  
 </script> 




<div id="preview_div">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    
 <?  if($arryLeadForm[0]['formID']>0){ ?>
   
    <tr>
       <td align="right" >
    <a href="vLeadForm.php?opt=preview" class="fancybox grey_bt fancybox.iframe">View Preview</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="vLeadForm.php?opt=code" class="fancybox grey_bt  fancybox.iframe">View HTML Code</a>
       </td>
       
</tr> 
    
    
<? }

 
if(!empty($_SESSION['msg_lead_form'])){
    
    unset($_SESSION['msg_lead_form']);
    
    ?> 
 <tr>
       <td align="right" >
   <a href="leadForm.php">Back to Create Lead Form</a>
       </td>
       
</tr> 

   <tr>
       <td align="left" class="head">
    HTML Code for Lead Form
       </td>
       
</tr>
    <tr>
       <td align="center" ><br>
     <textarea name="Description" type="text" class="textarea" id="Description" style="width:90%;height:800px;" readonly  ><?php echo htmlentities(stripslashes($arryLeadForm[0]['HtmlForm'])) ?></textarea>    
      
       <br>
       </td>
       
</tr>
    
 <? }else{ ?>
<form name="form1" action=""  method="post" onSubmit="return validateLeadForm(this);" enctype="multipart/form-data">
  <tr>
    <td  align="center" valign="top" >

<div id="move_div">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
       <td align="center" class="head" width="40%">
    Available Fields
       </td>
       <td class="head"></td>
       <td align="center" class="head" width="40%">
    Lead Form Fields
       </td>
</tr>
<tr>
       <td align="center" >
    <? 
echo '<select name="columnFrom[]" id="columnFrom"  class="inputbox" style="width:300px;height:300px;" multiple>';
for ($j = 1; $j <= sizeof($column); $j++) {
   
    $columnHead = $column[$j - 1]["colum_name"] . ':' .  $column[$j - 1]["colum_value"] . '';

    $sel = ($column[$j - 1]["colum_value"] == $arryColVal[$i - 1]['colvalue']) ? ('selected') : ('');
    echo '<option value="' . $columnHead . '" ' . $sel . '>' . $column[$j - 1]["colum_name"] . '</option>';
}
echo '</select>';   
    
    
    ?>
       </td>
       <td align="center" valign="top">
           <br><br> <br> <br> 
            <input type="button" value=" &raquo; &raquo; " name="fromall" id="fromall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Move All</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 
           <input type="button" value=" &raquo;  " name="frombt" id="add" class="grey_bt" style="padding:5px;width:40px;"  onMouseover="ddrivetip('<center>Move Selected</center>', 100,'')"; onMouseout="hideddrivetip()">  <br> <br>
           <input type="button" value=" &laquo;  " name="tobt" id="remove" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove Selected</center>', 100,'')"; onMouseout="hideddrivetip()"> <br><br> 
           
           <input type="button" value=" &laquo; &laquo; " name="tobt" id="removeall" class="grey_bt" style="padding:5px;width:40px;" onMouseover="ddrivetip('<center>Remove All</center>', 100,'')"; onMouseout="hideddrivetip()"> 
       </td>
       <td align="center">
      <? 
echo '<select name="columnTo[]" id="columnTo"  class="inputbox" style="width:300px;height:300px;" multiple>';

echo '</select>';   
    
    
    ?>
       </td>
</tr>

</table>	
</div> 

 
 <br>
<div id="other_div">
<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
    
<tr>
<td  align="right"   class="blackbold" width="20%"> Form Title : <span class="red">*</span> </td>
        <td   align="left" >          
                <input name="FormTitle" type="text" class="inputbox" id="FormTitle"   value="<?php echo stripslashes($arryLeadForm[0]['FormTitle5']); ?>"  maxlength="100" />        
           </td>
</tr>

<tr>
<td  align="right"   class="blackbold"> Subtitle : <span class="red">*</span> </td>
        <td   align="left" >          
                    <input name="Subtitle" type="text" class="inputbox" id="Subtitle"   value="<?php echo stripslashes($arryLeadForm[0]['Subtitle5']); ?>"  maxlength="100" />        
           </td>
</tr>

<tr>
<td  align="right"   class="blackbold" valign="top"> Description :  </td>
        <td   align="left" >          
                <textarea name="Description" type="text" class="textarea" id="Description" maxlength="500" ><?php echo stripslashes($arryLeadForm[0]['Description5']); ?></textarea>    
           </td>
</tr>

<!--tr>
<td  align="right"   class="blackbold"> Assign To : <span class="red">*</span> </td>
        <td   align="left" >          
                <input name="AssignTo" type="text" class="inputbox" id="AssignTo"   value="<?php echo stripslashes($arryLeadForm[0]['AssignTo']); ?>"  maxlength="100" />        
           </td>
</tr>

<tr>
<td  align="right"   class="blackbold"> Extra Info :  </td>
        <td   align="left" >          
                <input name="ExtraInfo" type="text" class="inputbox" id="ExtraInfo"   value="<?php echo stripslashes($arryLeadForm[0]['ExtraInfo']); ?>"  maxlength="100" />        
           </td>
</tr>

<tr>
<td  align="right"   class="blackbold"> Campaign :  </td>
        <td   align="left" >          
                <input name="Campaign" type="text" class="inputbox" id="Campaign"   value="<?php echo stripslashes($arryLeadForm[0]['Campaign']); ?>"  maxlength="100" />        
           </td>
</tr>

<tr>
<td  align="right"   class="blackbold"> Form Action Url : <span class="red">*</span> </td>
        <td   align="left" >          
                <input name="ActionUrl" type="text" class="textbox" id="ActionUrl"   value="<?php echo stripslashes($arryLeadForm[0]['ActionUrl']); ?>" size="50"  maxlength="200" />        
           </td>
</tr-->

</table>
</div>
        

	
        <br>
   
	
	</td>
   </tr>

   
   <tr>
    <td  align="center">
	
<input type="submit" name="submit" id="submit" value="Submit" class="button" >        



</td>
   </tr>
   </form>
 <? }?>
</table>
</div>

