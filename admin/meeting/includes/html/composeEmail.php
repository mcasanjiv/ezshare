<div >
<a href="<?=$RedirectURL?>" class="back">Back</a>
  <a href="editImportContactList.php?pop=1" target="_blank" class="fancybox fancybox.iframe add">Add Contact</a>
   <div class="loading-image" style="margin-right: 15px;display: none;text-align: center;width: 755px; float: right;" ><img src="../images/loader.gif">Saving</div>
</div>


<div class="had">
Compose New Message
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>

<script language="JavaScript1.2" type="text/javascript">
function validateCompose(frm){

        	
           if((frm.recipients.value=='') && (frm.Cc.value=='') && (frm.Bcc.value==''))
               
          {
              
              alert('Please insert alteast one recipient'); 
              frm.recipients.focus();
              return false;
          }
          
         else if((frm.Subject.value==''))
              
        {
            
            var Result=confirm('Are you sure ?? That you want to send message without subject');
            
           
            if (Result == false) {
                    
                    frm.Subject.focus();
                    return false;
                }
                else {
                    
                    ShowHideLoader('1','S');
                }
                       
        }
              
        
		
}


function Cc()
{
    
     document.getElementById('CCC').style.display='block';
}
function Bcc()
{
    
   document.getElementById('BCC').style.display='block';   
}


</script>

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

<form name="form1" action="<?=$_SERVER['PHP_SELF']?>"  method="post" onSubmit="return validateCompose(this);" enctype="multipart/form-data" id="composeform1">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">New Message</td>
</tr>


<tr>
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> To :<span class="red">*</span> </td>
              <td   align="left" width="15%">
              <input name="recipients" type="text" class="inputbox" style="width:402px;" id="recipients" value="" />
             <input type="hidden" name="action" value="composeMail" />
             <input type="hidden" name="draftId" id="draftId" value="<?=$_GET['ViewId']?>" />
              <script type="text/javascript">
             
                                        $(document).ready(function() {
                                             //var url= 'emailContacts.php';
                                             
                                            $("#recipients,#Cc,#Bcc").tokenInput("autoselectContactList.php?AdminID=<?php echo $_SESSION['AdminID']?>", {
                                                theme: "facebook",
                                                preventDuplicates: true,
                                                hintText: "Search Contact Email",
                                                propertyToSearch: "email",
                                                tokenValue: "email",
                                                crossDomain: true,
                                                resultsFormatter: function(item) {
                                                		console.log(item);
                                                		if(typeof item.name == "undefined") 
                                                			return "<li>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.email + "</div><div class='email'></div></div></li>"
                                                		else
                                                    		return "<li>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name +  " &nbsp;&nbsp; (" + item.email + ")</div><div class='email'></div></div></li>"
                                                },
                                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                tokenFormatter: function(item) {
                                                    return "<li><p>" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.email +    "</div><div class='email'></div></div></li>"
                                                }
                                            });
                                        });
                                    </script>
                                    
              </td>
              
             
              
       
</tr>

<tr id="CCC"  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Cc :<span class="red">*</span> </td>
              <td   align="left" width="15%">
              <input name="Cc" type="text" class="inputbox" style="width:402px;" id="Cc" value="" />
              
                 
              </td>
              
             
              
       
</tr>
<tr id=""  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Bcc :<span class="red">*</span> </td>
              <td   align="left" width="15%">
              <input name="Bcc" type="text" class="inputbox" style="width:402px;" id="Bcc" value="" />
              
                 
              </td>
             
              
       
</tr>

<tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;"> Subject :<span class="red">*</span> </td>
              <td   align="left" width="15%">
              <input name="Subject" type="text" class="inputbox" style="width:402px;" id="Subject" value="<? echo stripslashes($arryComposeItems[0]['Subject']); ?>" />
              
              </td>
              
             
              
       
</tr>

<tr>
                            
                            <td  align="left" colspan="4">
                                <Textarea name="mailcontent" id="mailcontent" class="inputbox"  ><? echo stripslashes($arryComposeItems[0]['EmailContent']); ?></Textarea>

				<script type="text/javascript">

             var editorName = 'mailcontent';
             
             

             var editor = new ew_DHTMLEditor(editorName);

             editor.create = function() {
                 var sBasePath = '../FCKeditor/';
                 var oFCKeditor = new FCKeditor(editorName, '67%', 460, 'custom');
                 oFCKeditor.BasePath = sBasePath;
                 oFCKeditor.ReplaceTextarea();
                 this.active = true;
             }
             ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

             ew_CreateEditor();

                  
                                </script>			          </td>
        </tr>

 <tr  >
    <td  align="" width="6%"   class="blackbold" style="padding-left:10px;">Attachment :<span class="red">*</span> </td>
              <td   align="left" width="15%">


<div id="mulitplefileuploader">Upload</div>
<?php 
if(!empty($_GET['ViewId'])){
	$select_attach="select * from importemailattachments where EmailRefId='".$_GET['ViewId']."'";
	$attachdatas=mysql_query($select_attach);
	 while($row=mysql_fetch_array($attachdatas)) { ?>
		<div class="ajax-file-upload-statusbar">
			<div class="ajax-file-upload-filename"><?=$row['FileName']?></div>
			<span class="ajax-file-upload-red" style="" onclick="attachDelete('<?=$row['FileName']?>',this);">Delete</span>
		</div>
	<?php }
}
?>

<div id="status"></div>
<script>
    
  var nC=jQuery.noConflict();  
nC(document).ready(function()
{
    
   
   
    var settings = {
    url: "uploadAttachment.php", 
    dragDrop:true,
    fileName: "myfile",
    showFileCounter : false,
    //allowedTypes:"jpg,png,gif,doc,pdf,zip",	
  
	 onSuccess:function(files,data,xhr)
    {
        //alert(data);
    	saveDraft();
    },
    showDelete:true,
    showDone: false,
    deleteCallback: function(data,pd)
	{
     
      
    for(var i=0;i<1;i++)
    {  
        nC.post("deleteAttachment.php",{op:"delete",name:data},
        function(resp, textStatus, jqXHR)
        {
            nC("#status").append("");      
        });
     }      
     pd.statusbar.hide(); //You choice to hide/not.

}
}
var uploadObj = nC("#mulitplefileuploader").uploadFile(settings);


});


</script>
              
              </td>
              
             
              
       
</tr>

</table>	
  
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
 	 <span class="loading-image" style="margin-right: 15px;display:none;" ><img src="../images/loader.gif">Saving</span>
	  <input type="button"" class="button" id="SubmitButton" value="Save as Draft" onclick="saveDraft();" />
      <input name="Submit" type="submit" class="button" id="SubmitButton" value="Send"  />
	

</div>

</td>
   </tr>
</table>
   </form>

<script>

function saveDraft(){
	var inst = FCKeditorAPI.GetInstance("mailcontent");
	var sValue = inst.GetHTML();
	$("#mailcontent").val(sValue);

	$('.loading-image').show();
       var SendParam = $("#composeform1").serializeArray();
       $.ajax({
			type: "POST",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
				if(responseText>0){
					$("#draftId").val(responseText);
					$('.loading-image').text('Saved');
				}else if(responseText=='null') {
					$('.loading-image').hide();
				}else{
					$('.loading-image').html('Error! Try again.');
				}
			}
      });
}

function attachDelete(attachname,curr){
	$.ajax({
		type: "POST",
		async:false,
		url: 'deleteAttachment.php',
		data: {op:'delete',name: attachname,type: 'Draft'},
		success: function (responseText) {
			if(responseText!='' && responseText!='null'){
				$(curr).parent(".ajax-file-upload-statusbar").remove();
			}
		}
  });
}

function FCKeditor_OnComplete( editorInstance )
{
	editorInstance.Events.AttachEvent( 'OnBlur', saveDraft ) ;
}

$(document).on('blur','#token-input-recipients,#token-input-Cc,#token-input-Bcc,#Subject', function(){
	 saveDraft();
});


window.onload=function(){
	<?php if(!empty($arryComposeItems[0]['Recipient'])){
	$reciepts = explode(",", $arryComposeItems[0]['Recipient']);
	$i=50;foreach ($reciepts as $reciept){ $i++;?>
	 $("#recipients").tokenInput("add",{id: <?=$i?>, email: "<?=$reciept?>" });
		<?php } } ?>

		<?php if(!empty($arryComposeItems[0]['Bcc'])){ 
		$bcc = explode(",", $arryComposeItems[0]['Bcc']);
		$i=50;foreach ($bcc as $reciept){ $i++;?>
		 $("#Bcc").tokenInput("add",{id: <?=$i?>, email: "<?=$reciept?>" });
		<?php } } ?>
			
		<?php if(!empty($arryComposeItems[0]['Cc'])){ 
		$cc = explode(",", $arryComposeItems[0]['Cc']);
		 $i=50;foreach ($cc as $reciept){ $i++;?>
		 $("#Cc").tokenInput("add",{id: <?=$i?>, email: "<?=$reciept?>" });
		 <?php } } ?>
};

</script>





