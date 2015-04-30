<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCompany.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>
<div class="had">Blocked IP</div>


<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
	  <td  valign="top">
<?=BLOCKED_INFO?>
	 </td>
	
	</tr>
	<tr>
	  <td  valign="top">
<div class="message" align="center"><? if(!empty($_SESSION['mess_block'])) {echo $_SESSION['mess_block']; unset($_SESSION['mess_block']); }?></div>
	 </td>
	
	</tr>

	<tr>
	  <td  valign="top">
	  
	
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">

<table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','blockID','<?=sizeof($arryIP)?>');" /></td>-->
      <td width="30%"  class="head1" >IP Address</td>
      <td  class="head1" >Login Time</td>
      <td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 

  if(is_array($arryIP) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryIP as $key=>$values){
	$flag=!$flag;
	$Line++;
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="blockID[]" id="blockID<?=$Line?>" value="<?=$values['blockID']?>" /></td>-->
     
	<td ><?=$values["LoginIP"]?></td>
	<td><?=date("Y-m-d H:i:s",$values["LoginTime"])?></td>   

     
      <td  align="center"  class="head1_inner">
	  
	<a href="blockedIP.php?del_id=<?php echo $values['blockID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confDel('<?=$ModuleName?>')"  ><?=$delete?></a>   


</td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="7" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="7" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryIP)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>

  </div> 
 <? if(sizeof($arryIP)){ ?>
 <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
   <tr align="center" > 
    <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','delete','<?=$Line?>','blockID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');">
      <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','active','<?=$Line?>','blockID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" />
      <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?=$ModuleName?>','inactive','<?=$Line?>','blockID','editCompany.php?curP=<?=$_GET[curP]?>&opt=<?=$_GET[opt]?>');" /></td>
  </tr>
  </table>
  <? } ?>  
  
  <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
   <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
</form>
</td>
	</tr>
</table>
