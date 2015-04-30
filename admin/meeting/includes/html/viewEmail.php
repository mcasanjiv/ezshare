

<div ><a href="<?=$RedirectURL?>" class="back">Back</a>
<?php if($_GET['type']=="Draft"){?>
<a href="composeEmail.php?ViewId=<?=$_GET['ViewId']?>&type=<?=$_GET['type']?>" class="edit">Edit</a>
<?php }?>
</div>


<div class="had">
View Message
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  

  




<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>

<link href="multiSelect/uploadfile.css" rel="stylesheet">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="../js/jquery.uploadfile.min.js"></script>


<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="return validateCompose(this);" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head"></td>
</tr>
<?php
if (is_array($arrySentItems) && $num > 0) {
    
    
    
?>
<tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> To : </td>
              <td   align="left" width="15%">
             
                
                  <input name="recipients" readonly="" type="text" class="inputbox" style="width:402px;" id="recipients" value="<?php echo $arrySentItems[0][Recipient]?>" /> 
                                    
              </td>
              
             
              
       
</tr>
<?php if(!empty($arrySentItems[0][Cc]))
{ ?>
<tr id="CCC"  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Cc : </td>
              <td   align="left" width="15%">
                  
                  <input name="Cc" readonly="" type="text" class="inputbox" style="width:402px;" id="Cc" value="<?php echo $arrySentItems[0][Cc]?>" /> 
                  
              </td>
              
             
              
       
</tr>
<?php } ?>
<?php if(!empty($arrySentItems[0][Bcc]))
{ ?>
<tr id=""  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Bcc : </td>
              <td   align="left" width="15%">
              
                  
                  <input name="Bcc" readonly="" type="text" class="inputbox" style="width:402px;" id="Bcc" value="<?php echo $arrySentItems[0][Bcc]?> " />
              </td>
             
              
       
</tr>

<?php } ?>

<tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Subject : </td>
              <td   align="left" width="15%">
                  <input name="Subject" readonly="" type="text" class="inputbox" style="width:402px;" value="<?php echo stripcslashes($arrySentItems[0][Subject])?>" />
                    
              </td>
              
             
              
       
</tr>

<tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> &nbsp; </td>      
                            <td  align="left" >
                                <?php echo trim(stripslashes(str_replace('<br type="_moz" />', '', $arrySentItems[0]['EmailContent']))); ?>
		               </td>
        </tr>
        
        <tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> &nbsp; </td>      
                            <td  align="left" >
                                

		               </td>
        </tr>

        <?php $arryAttachment = $objImportEmail->GetAttachmentFileName($_GET['ViewId']); 
        
             
            if(count($arryAttachment) > 0 )
            {
        ?>
 <tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;">Attachment :<span class="red">*</span> </td>
              <td   align="left" width="15%">
                 
                 <?php
   
                                          
                                          foreach($arryAttachment as $key=>$values)
                                          {
                                              
                                             echo $values[FileName]; 
                                           ?>  
                                             
                                       <a href="dwn.php?file=upload/emailattachment/<?php echo $_SESSION[AdminEmail].'/'.$values[FileName]?>" class="download">Download</a><br> <br>
	

</div>
                                        <?php  }
                                          
                                         ?>
              </td>
              
             
              
       
</tr>

<?php } ?>
<?php } else { ?>


<tr id=""  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;">
   No Email Found </td>
              
             
              
       
</tr>


<?php } ?>

</table>	
  
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	
      


</div>

</td>
   </tr>
   </form>
</table>







