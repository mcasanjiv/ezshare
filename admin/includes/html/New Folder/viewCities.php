<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  {
			   location.href = 'viewCities.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewCities.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;*/
		}
</script>
<div class="had"><?php echo 'Manage Cities';?></div>
<div class="message"><? if(!empty($_SESSION['mess_city'])) {echo $_SESSION['mess_city']; unset($_SESSION['mess_city']); }?></div>
<TABLE WIDTH="95%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	 <tr>
		<td align="right"><a href="editCity.php">Add City</a></td>
	  </tr>
	  
	<tr>
	  <td valign="top">
	  
	
	<form action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
				  <table  border="0" cellpadding="0" cellspacing="3"  id="search_table">
                    <tr>
                      <td>
					  <select name="sortby" id="sortby" class="inputbox" >
						<option value="">All</option>
						<option value="ct.name" <? if($_GET['sortby']=='ct.name') echo 'selected';?>>City Name</option>
					    <option value="s.name" <? if($_GET['sortby']=='s.name') echo 'selected';?>>State Name</option>		
					    <option value="c.name" <? if($_GET['sortby']=='c.name') echo 'selected';?>>Country Name</option>		
					 </select>					  
					  </td>
					    <td  >				    
					 <select name="asc" id="asc" class="inputbox" >
						<option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						<option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
					 </select>
					 
					 </td>
                      <td><input type='text' name="key"  id="key" class="inputbox" value="<?=$_GET['key']?>"></td>
                      <td> 
                        <input name="search" type="submit" class="search_button" value="Go">
						<? if($_GET['key']!='') {?> <a href="viewCities.php">View All</a><? }?></td>
                 
				    </tr>
      </table></form>
<form action="" method="post" name="form1">
<table <?=$table_bg?>>
	
  
  <tr align="left"  >
    <td width="26%" class="head1" >City Name</td>
    <td width="28%" class="head1" >State Name</td>
    <td width="35%"  class="head1" >Country Name</td>
    <td width="11%"  align="center" class="head1" >Action</td>
  </tr>
 
  <?php 
  $pagerLink=$objPager->getPager($arryRegion,$RecordsPerPage,$_GET['curP']);
 (count($arryRegion)>0)?($arryRegion=$objPager->getPageRecords()):("");
  if(is_array($arryRegion) && $num>0){
  	$flag=true;
  	foreach($arryRegion as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?(""):("#F3F3F3");
  ?>
  <tr align="left"  bgcolor="<?=$bgcolor?>">
    <td ><strong>
      <?=stripslashes($values['name'])?>
    </strong></td>
    <td ><?=stripslashes($values['state_name'])?></td>
    <td  >
	<?=stripslashes($values['country_name'])?></td>
    <td  align="center"  >

	<a href="editCity.php?edit=<?php echo $values['city_id'];?>&curP=<?php echo $_GET['curP'];?>" class="edit"><?=$edit?></a>
	
	<a href="editCity.php?del_id=<?php echo $values['city_id'];?>&curP=<?php echo $_GET['curP'];?>" onClick="return confDel('City')" class="edit" ><?=$delete?></a>		</td>
  </tr>
  <?php } // foreach end //?>
 

 
  <?php }else{?>
  	<tr align="center" >
  	  <td  colspan="4" class="no_record">City Not Found.</td>
  </tr>

  <?php } ?>
    
  <tr >  <td  colspan="4" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryRegion)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
</table>
<input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
</form>
</td>
	</tr>
</table>
