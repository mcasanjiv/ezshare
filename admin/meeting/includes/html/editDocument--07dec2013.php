
<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>
<script language="JavaScript1.2" type="text/javascript">
function SelectAllRecord()
{	
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=true;
	}

}

function SelectNoneRecords()
{
	for(i=1; i<=document.form1.Line.value; i++){
		document.getElementById("Modules"+i).checked=false;
	}
}

function ShowOther(FieldId){
	if(document.getElementById(FieldId).value=='Other'){
		document.getElementById(FieldId+'Span').style.display = 'inline'; 
	}else{
		document.getElementById(FieldId+'Span').style.display = 'none'; 
	}
}


function validate(frm){
		if( ValidateForSimpleBlank(frm.title, "Document Title")
		//&& ValidateForSelect(frm.AssignTo,"Assign To")
		    && ValidateOptionalDoc(frm.FileName, "Document")
		){
		
		
		var chks = document.getElementsByName('EmpID[]');
				var hasChecked = false;
				for (var i = 0; i < chks.length; i++)
				{
					if (chks[i].checked)
					{
					hasChecked = true;
					break;
					}
				}
				
				if (hasChecked == false)
					{
					alert("Please select at least one Assign User.");
					return false;
					}

			var Url = "isRecordExists.php?DocumentTitle="+escape(document.getElementById("title").value)+"&editID="+document.getElementById("documentID").value;
			SendExistRequest(Url,"title","Document Title");
			return false;
		}else{
			return false;	
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

<a class="back" href="<?=$RedirectURL?>">Back</a>


<div class="had">
Manage <?=$_GET["parent_type"]?> Document   &raquo; 
	<? 	echo (!empty($_GET['edit']))?("Edit ".ucfirst($_GET["parent_type"])." Details") :("Add ".$_GET["parent_type"]." ".$ModuleName); ?>
		
		
</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <td height="2" align="center"  class="red" ><?php echo $errMsg;?></td>
    </tr>
  <? } ?>
  
	<tr>
	<td align="left" valign="top">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
  
  <? if (!empty($_SESSION['mess_contact'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?>	
</td>
</tr>
<? } ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">


  


<tr>
	 <td colspan="2" align="left" class="head">Basic Information</td>
</tr>
<tr>
        <td  align="right" width="43%"   class="blackbold"> Title  :<span class="red">*</span> </td>
        <td   align="left" >
<input name="title" type="text" class="inputbox" id="title" value="<?php echo stripslashes($arryDocument[0]['title']); ?>"  maxlength="50" />            </td>
</tr>

 <tr <?=$none?>>
                      <td  align="right" valign="top" class="blackbold"> 
					  Assigned To  :<span class="red">*</span>  </td>
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

	 
<tr style="display:none;">
  <td  align="right"   class="blackbold"> Assigned To  :<span class="red">*</span> </td>
        <td   align="left" >
		 <? if($HideSibmit!=1){?>
   <select name="AssignTo" class="inputbox" id="AssignTo" >
						<option value="">--- Select ---</option>
						<? for($i=0;$i<sizeof($arryEmployee);$i++) {?>
							<option value="<?=$arryEmployee[$i]['EmpID']?>" <?  if($arryEmployee[$i]['EmpID']==$arryDocument[0]['AssignTo']){echo "selected";}?>>
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

	     <td align="right"  valign="middle"  class="blackbold">Status :</td>
                      <td align="left" class="blacknormal">
       <input name="Status" type="radio" value="1" <?=($DocumentStatus==1)?"checked":""?> />Active &nbsp;&nbsp;&nbsp;&nbsp;<input name="Status" type="radio" <?=($DocumentStatus==0)?"checked":""?> value="0" />Inactive</td>
           
                      
		
	
	  </tr>
      
	  <tr>
	 <td colspan="2" align="left" class="head">File Details</td>
</tr>

	 
	   <tr style="display:none;">
        <td  align="right"   class="blackbold"> Download Type  : </td>
        <td   align="left" >
        <select name="DownloadType" id="DownloadType" class="inputbox">
		<option value="">--Select--</option>
		<option value="Internal" <? if($arryDocument[0]['DownloadType']=="Internal"){ echo "Selected"; }?>>Internal</option>
		<option value="External" <? if($arryDocument[0]['DownloadType']=="External"){ echo "Selected"; }?>>External</option>
		</select>
           </td>
           </tr>
           <tr>
<td  align="right"   class="blackbold"> Document : </td>
        <td   align="left" >
<input name="FileName" type="File" class="inputbox" id="FileName" value="<?php echo stripslashes($arryDocument[0]['FileName']); ?>"  />    <br />  <br />
<?php if($arryDocument[0]['FileName']!=''){?>
File -: <?=stripslashes($arryDocument[0]['FileName'])?><a  class="grey_bt" target="_blank" href="upload/Document/<?=stripslashes($arryDocument[0]['FileName'])?>">View Document</a> 
<? }?>    </td>
      </tr>
  <tr>
	 <td colspan="2" align="left" class="head">Description</td>
</tr>
 
	  
	   <tr>

	      <td  align="right"   class="blackbold"> Description :</td>
        <td   align="left" > <Textarea name="description" id="description" class="inputbox"  ><? echo stripslashes($arryDocument[0]['description']); ?></Textarea>
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


</script>	
           </td>
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
	<br />
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />




</div>
<input type="hidden" name="documentID" id="documentID" value="<?=$_GET['edit']?>" />
<input type="hidden" name="linkID" id="linkID"  value="<?=$_GET['linkID']?>" />
<input type="hidden" name="parent_type" id="parent_type"  value="<?=$_GET['parent_type']?>" />	
<input type="hidden" name="parentID" id="parentID"  value="<?=$_GET['parentID']?>" />
<input type="hidden" name="module" id="module"  value="<?=$_GET['module']?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminID']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />	


</td>
   </tr>
   </form>
</table>

	
	</td>
    </tr>
 
</table>
