
<script language="JavaScript1.2" type="text/javascript">
function GoState(){	

	if(document.getElementById("state_id") != null){
		document.getElementById("main_state_id").value = document.getElementById("state_id").value;
	}
	
	if(!ValidateForSelect(document.getElementById("main_state_id"), "State")){
		return false;
	}

	document.getElementById("prv_msg_div").style.display = 'block';
	document.getElementById("preview_div").style.display = 'none';

	location.href = 'viewCities.php?country_id='+document.getElementById("country_id").value+'&state_id='+document.getElementById("main_state_id").value;
	return false;
}
function AddCity(){	
	location.href = 'editCity.php?country_id='+document.getElementById("country_id").value+'&state_id='+document.getElementById("main_state_id").value;
}

	function ValidateSearch(SearchBy){	
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewCities.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCities.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
		}
</script>

<div class="had"><?php echo 'Manage Cities';?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	

<tr>
	  <td  valign="top" align="left">
<!--	
<form name="topForm" action="viewCities.php" method="get">	
	<?  if(sizeof($arryStateIndia)>0){ ?>		  
	 <strong>State :</strong>&nbsp;&nbsp;&nbsp;
	 <select name="main_state_id"  id="main_state_id" class="inputbox" onChange="Javascript:GoState();">
	 <option value="">---Select State---</option>
	  <? for($i=0;$i<sizeof($arryStateIndia);$i++) {?>
      <option value="<?=$arryStateIndia[$i]['state_id']?>" <?  if($arryStateIndia[$i]['state_id']==$_GET['state_id']){echo "selected";}?>>
      <?=$arryStateIndia[$i]['name']?>
      </option>
      <? } ?>
    </select>
	 <? } ?>
	 <input type="hidden" name="country_id" id="country_id" value="106" />
</form>	
	-->
	
	<form name="topForm" action="viewCities.php" method="get" onSubmit="return GoState();">	
	<table width="300" border="0" cellspacing="0" cellpadding="2" style="margin:0;">
  <tr >
    <td height="25" ><strong>Country&nbsp;:</strong></td>
    <td><select name="country_id"  id="country_id" class="inputbox"  onchange="Javascript: StateListSend(1);" >
      <? for($i=0;$i<sizeof($arryCountry);$i++) {?>
      <option value="<?=$arryCountry[$i]['country_id']?>" <?  if($arryCountry[$i]['country_id']==$_GET['country_id']){echo "selected";}?>>
      <?=$arryCountry[$i]['name']?>
      </option>
      <? } ?>
    </select></td>
  </tr>
  <tr>
    <td height="25"><strong>State :</strong></td>
    <td id="state_td">&nbsp;</td>
  </tr>
  <tr>
    <td><input type="hidden" name="main_state_id" id="main_state_id"  value="<?=$_GET['state_id']?>" /></td>
    <td>
	
	
<input name="Submit" type="submit" id="SubmitButton" value="Go" class="search_button" <? //if(sizeof($arryState)<=0) { echo 'disabled';} ?>>

<SCRIPT LANGUAGE=JAVASCRIPT>
		StateListSend();
</SCRIPT>
</td>
  </tr>
</table>
	 
	  </form>
	  
	  
	</td>
              </tr>	
	
	


	<tr>
	  <td  valign="top">
	  


<div class="message"><? if(!empty($_SESSION['mess_city'])) {echo $_SESSION['mess_city']; unset($_SESSION['mess_city']); }?></div>

<div id="ListingRecords">

<? if($_GET['state_id']>0){ ?>	  


	<table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
	  <tr>
		<td align="right" ><a href="editCity.php?country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>" class="add" >Add City</a></td>
		</tr>
	</table>
<!--
	<form action="" method="post" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				<table width="81%" height="38" border="0" cellpadding="2" cellspacing="4" align="center">
                    <tr valign="bottom">
                      <td width="16%">&nbsp;</td>
                      <td width="55%" align="right" class="field">Enter the keyword to search :</td>
                      <td align="left" nowrap><input type='text' name="Keyword"  id="Keyword" class="inputbox" value="<?=$_GET['key']?>"> 
                        <input name="search" type="submit" class="inputbox" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewCities.php">View all</a><? }?></td>
                   <td width="21%" nowrap class="field">&nbsp;Search in :
				    <select name="SortBy" id="SortBy" class="inputbox" onChange="return ValidateSearch(1);">
						<option value="">All</option>
						<option value="ct.name" <? if($_GET['sortby']=='ct.name') echo 'selected';?>>City Name</option>
					    <option value="s.name" <? if($_GET['sortby']=='s.name') echo 'selected';?>>State Name</option>		
					    <option value="c.name" <? if($_GET['sortby']=='c.name') echo 'selected';?>>Country Name</option>		
					 </select>
					 <select name="Asc" id="Asc" class="inputbox" onChange="return ValidateSearch(1);">
						<option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						<option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					 </select>
					 
					 </td>
				    </tr>
      </table></form>
	  -->
<form action="" method="post" name="form1">
<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<table <?=$table_bg?>>
  <tr align="left" >
    <td class="head1" >City Name</td>
    <td width="10%" align="center" class="head1" >Action</td>
  </tr>

  <?php 
  $pagerLink=$objPager->getPager($arryRegion,$RecordsPerPage,$_GET['curP']);
 (count($arryRegion)>0)?($arryRegion=$objPager->getPageRecords()):("");
  if(is_array($arryRegion) && $num>0){
  	$flag=true;
  	foreach($arryRegion as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#f7f6ef"):("");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td class="blacknormal">
      <?=stripslashes($values['name'])?>    </td>
    <td height="20" align="center" >

	<a href="editCity.php?edit=<?php echo $values['city_id'];?>&curP=<?php echo $_GET['curP'];?>&country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>" ><?=$edit?></a>
	
	<a href="editCity.php?del_id=<?php echo $values['city_id'];?>&curP=<?php echo $_GET['curP'];?>&country_id=<?=$_GET['country_id']?>&state_id=<?=$_GET['state_id']?>" onClick="return confDel('City')"  ><?=$delete?></a>		</td>
  </tr>
  <?php } // foreach end //?>
 


  <?php }else{?>
  	<tr align="center" >
  	  <td height="20" colspan="2"  class="no_record">No city found.</td>
  </tr>

  <?php } ?>
    
  <tr>  <td height="20" colspan="2">Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryRegion)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</div>
</form>



<? } ?>
</div>

</td>
	</tr>
</table>
