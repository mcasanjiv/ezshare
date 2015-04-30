<body>
<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<div class="had">Create Post </div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<? if (!empty($errMsg)) {?>
  <tr>
    <!--<td height="2" align="center"  class="red" ><?php echo $errMsg;?></td> -->
    </tr>
  <? } ?>
  
<tr>
<td align="left" valign="top">
 <form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

   <? if (!empty($_SESSION['mess_social'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
</td>
</tr>
<? } ?>
  
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
			<td colspan="2" align="left"  class="head" >Post Information</td>
			</tr>
			<tr>
			<td  align="right" width="40%"   class="blackbold"> Message  :<span class="red">*</span> </td>
			<td   align="left" >
			<Textarea name="message" class="inputbox" style="height: 65px;"><?php echo !empty($_POST['message'])?$_POST['message']:'';?></Textarea>       </td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold"> Link  : </td>
			<td   align="left" >
			<input name="link" type="text" class="inputbox" id="title" value="<?php echo !empty($_POST['link'])?$_POST['link']:'';?>"/></td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold"> Picture  : </td>
			<td   align="left" >
			<input name="picture_one" type="file" class="inputbox" /></td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold">Name  :<span class="red">*</span> </td>
			<td   align="left" >
			<input name="name" type="text" class="inputbox" id="title" value="<?php echo !empty($_POST['name'])?$_POST['name']:'';?>" /></td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold">Caption  :<span class="red">*</span> </td>
			<td   align="left" >
			<input name="caption" type="text" class="inputbox"  value="<?php echo !empty($_POST['caption'])?$_POST['caption']:'';?>" /></td>
			</tr>
			
			<tr>
			<td  align="right" width="40%"   class="blackbold">Description  :<span class="red">*</span> </td>
			<td   align="left" >
		    <Textarea name="description" id="description" class="inputbox" style="height: 65px;"><?php echo !empty($_POST['description'])?$_POST['description']:'';?></Textarea>
            </td>
			</tr>
			</table>	
			</td>
		</tr>

		<tr>
			<td  align="center" >
			<div id="SubmitDiv" style="display:none1">
			<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
			</div>
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
