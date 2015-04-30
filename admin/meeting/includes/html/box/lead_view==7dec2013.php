
<script type="text/javascript">
function setTable(what){
if(document.getElementById(what).style.display=="none"){
document.getElementById(what).style.display="block";
}
else if(document.getElementById(what).style.display=="block"){
document.getElementById(what).style.display="none";
}
}
</script>


<? if($arryLead[0]['type']=='Company'){?> 

<script>
document.getElementById('com').style.display = 'block';
</script>

<? }?>	




<div class="right_box">
<table width="100%" id="table1"  border="0" cellpadding="0" cellspacing="0">
<form name="form1" action="<?=$ActionUrl?>"  method="post">
  
  <? if (!empty($_SESSION['mess_lead'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_lead'])) {echo $_SESSION['mess_lead']; unset($_SESSION['mess_lead']); }?>	
</td>
</tr>
<? } ?>


   <tr>
    <td  align="center" valign="top" >


<table width="100%" id="table4"   border="0" cellpadding="5" cellspacing="0" class="borderall">


  

<? if($_GET["tab"]=="Lead"){ ?>

<tr>
	 <td  colspan="2" align="left" class="head">Lead Details</td>
	 
</tr>

<tr>
        <td  align="right"   class="blackbold" width="40%">Lead Type  : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['type']); ?>           </td>
      </tr>
<tr>
        <td  align="right"   class="blackbold"> First Name  : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['FirstName']); ?>           </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Last Name  :</td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['LastName']); ?>           </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Primary Email : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['primary_email']); ?>            </td>
      </tr>

	  <tr>
        <td  align="right"   class="blackbold"> Product  : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['ProductID']); ?>           </td>
      </tr>
	    <tr>
        <td  align="right"   class="blackbold"> Price ($)  : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['product_price']); ?>           </td>
      </tr>
      
       <tr>
        <td  align="center"  colspan="2"  class="blackbold"><table   id="com" style="display:none; margin-left: -70px;"> <tr>
        <td  align="right"   class="blackbold"> Company Name : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['company']); ?>             </td>
      </tr></table> </td>
       
      </tr>
	   <tr>
        <td  align="right"   class="blackbold"> Company Name : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['company']); ?>           </td>
      </tr>


	  
	   <tr>
        <td  align="right"   class="blackbold"> Website : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['Website']); ?>            </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Designation : </td>
        <td   align="left" >
<?php echo stripslashes($arryLead[0]['designation']); ?>           </td>
      </tr>
	  
	 <!--  <tr>
        <td  align="right"   > Date of Birth : <span class="red">*</span> </td>
        <td   align="left" >
		
<script type="text/javascript">
$(function() {
	$('#date_of_birth').datepick(
		{
		dateFormat: 'yyyy-mm-dd', 
		yearRange: '1950:<?=date("Y")?>', 
		defaultDate: '<?=$arryLead[0]['date_of_birth']?>'
		}
	);
});
</script>
<input id="date_of_birth" name="date_of_birth" readonly="" class="disabled" size="10" value="<?=$arryLead[0]['date_of_birth']?>"  type="text" >         </td>
      </tr> -->

  <tr>
        <td  align="right"   class="blackbold"> Industry  : </td>
        <td   align="left" >
		<?php echo stripslashes($arryLead[0]['Industry']); ?>
            </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold"> Annual Revenue : </td>
        <td   align="left" ><?php echo stripslashes($arryLead[0]['AnnualRevenue']); ?>
            </td>
      </tr>

 <tr>
        <td  align="right"   class="blackbold"> Lead Source  : </td>
        <td   align="left" >
		<?=stripslashes($arryLead[0]['lead_source'])?>
           </td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">  Assigned To  : </td>
        <td   align="left" ><?=stripslashes($arrySupervisor[0]['UserName'])?>
		 </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Lead Status  : </td>
        <td   align="left" >
		
           <?=stripslashes($arryLead[0]['lead_status'])?> </td>
      </tr>
	  
 <tr>



	
	<tr>
       		 <td colspan="2" align="left"   class="head">Address Details</td>
        </tr>
   
	  
	  
	
	  
        <tr>
          <td align="right"   class="blackbold" valign="top">Street Address  :</td>
          <td  align="left" >
            <?=stripslashes($arryLead[0]['Address'])?>		          </td>
        </tr>
         
	<tr>
        <td  align="right"   class="blackbold"> Country  :</td>
        <td   align="left" >
		<?=$CountryName?>      </td>
      </tr>
     <tr>
	  <td  align="right" valign="middle"   class="blackbold"> State  :</td>
	  <td  align="left"  class="blacknormal"><?=$StateName?> </td>
	</tr>
	    
     
	   <tr>
        <td  align="right"   class="blackbold"> City   :</td>
        <td  align="left"  ><?=$CityName?> </td>
      </tr> 
	    
	 
	    <tr>
        <td align="right"   class="blackbold" >Zip Code  :</td>
        <td  align="left"  >
	 <?=stripslashes($arryLead[0]['ZipCode'])?>			</td>
      </tr>
	  
       <tr>
        <td align="right"   class="blackbold" >Mobile  :</td>
        <td  align="left"  >
	<?=stripslashes($arryLead[0]['Mobile'])?>			</td>
      </tr>

	   <tr>
        <td  align="right"   class="blackbold">Landline  :</td>
        <td   align="left" >
		<?
		if(!empty($arryLead[0]['LandlineNumber'])){
			$LandArray = explode(" ",$arryLead[0]['LandlineNumber']);
	    }
		?>
		<? echo $arryLead[0]['LandlineNumber'];?>	</td>
      </tr>







	<tr>
       		 <td colspan="2" align="left"   class="head">Description Details</td>
        </tr>	
	
	
	  
	 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" >
           <? echo stripslashes($arryLead[0]['description']); ?>         </td>
        </tr>
 


 
<? }?>
</table>	
  




	
	  
	
	</td>
   </tr>

   

   </form>
</table></div>
<? if($_GET['tab']=="Event"){?>


        
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
           <a class="add" href="editActivity.php?module=event&parent_type=<?=$_GET['module']?>&parentID=<?=$_GET['view']?>" >Add Event</a>
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','eventID','<?=sizeof($arryActivity)?>');" /></td>-->
  <td width="6%"  class="head1" >ID</td>
      <td width="15%"  class="head1" >Title</td>
	  <td width="13%" class="head1"> Activity Type </td>
	  <td width="12%" class="head1" >Priority</td>
      <td width="12%" class="head1" >Assign To</td>
	  <td width="19%" class="head1" > Add Date</td>
      <td width="11%"  align="center" class="head1" >  Status</td>
      <td width="12%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryActivity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryActivity as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="eventID[]" id="eventID<?=$Line?>" value="<?=$values['eventID']?>" /></td>-->
      <td ><?=$values["eventID"]?></td>
      <td height="22" > 
	  <?
		  echo  stripslashes($values["subject"]); 
		  
		  
		  ?>		       </td>
		   <td><?=$values['activityType']?></td>
      <td><?  echo $values['priority'];?> </td>
	  <td><?=$values['AssignTo']?> (<?=$values['Department']?>)</td>
      <td>
      <?php  
	   $stdate= $values["startDate"]." ".$values["startTime"];
	 echo date($Config['DateFormat']." H:i A" , strtotime($stdate));?>
      </td>
       
    <td align="center"><? $status = $values['event_status']; echo $status;?></td>
	<td  align="center" ><a href="vActivity.php?view=<?php echo $values['eventID'];?>&amp;curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['module'];?>"><?=$view?></a>
	<a href="editActivity.php?edit=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Activity" ><?=$edit?></a>
	<a href="editActivity.php?del_id=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryActivity)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table> 
  </td>
  </tr>  
 </TABLE>
        
        <? }?>
        
        
        <? 
		
if($_GET['tab']=="Task"){?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="add" href="<?=$AddRef?>" >Add Task</a>
        
         
      
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    <tr align="left"  >
     <!-- <td width="5%" class="head1" >
<input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','eventID','<?=sizeof($arryActivity)?>');" /></td>-->
  <td width="6%"  class="head1" >ID</td>
      <td width="15%"  class="head1" >Title</td>
	  <td width="13%" class="head1"> Activity Type </td>
	  <td width="12%" class="head1" >Priority</td>
      <td width="12%" class="head1" >Assign To</td>
	  <td width="19%" class="head1" > Add Date</td>
      <td width="11%"  align="center" class="head1" >  Status</td>
      <td width="12%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryActivity) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryActivity as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
      <!--<td ><input type="checkbox" name="eventID[]" id="eventID<?=$Line?>" value="<?=$values['eventID']?>" /></td>-->
      <td ><?=$values["eventID"]?></td>
      <td height="22" > 
	  <?
		  echo  stripslashes($values["subject"]); 
		  
		  
		  ?>		       </td>
		   <td><?=$values['activityType']?></td>
      <td><?  echo $values['priority'];?> </td>
	  <td><?=$values['AssignTo']?> (<?=$values['Department']?>)</td>
      <td>
      <?php  
	   $stdate= $values["startDate"]." ".$values["startTime"];
	 echo date($Config['DateFormat']." H:i A" , strtotime($stdate));?>
      </td>
       
    <td align="center"><? $status = $values['event_status']; echo $status;?></td>
	<td  align="center" ><a href="vActivity.php?view=<?php echo $values['eventID'];?>&amp;curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['module'];?>"><?=$view?></a>
	<a href="editActivity.php?edit=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>&tab=Activity" ><?=$edit?></a>
	<a href="editActivity.php?del_id=<?php echo $values['eventID'];?>&module=<?php echo $_GET['module'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a> </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="9" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
 <tr>  
 <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryActivity)>0){?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink; }?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
        
        
       <?  if($_GET['tab']=="Campaign"){?>

	<div id="preview_div">
          
  <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        <a class="button" style="font-size:12px; color:#FFFFFF;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Campaign</b></a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">
    <table <?=$table_bg?>>
   
    

	 <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?=sizeof($arryCampaign)?>');" /></td>-->
      <td width="18%"  class="head1" >Campaign Name</td>
      <td width="14%"  class="head1" >Campaign Type</td>
      <td width="12%"  class="head1" >Campaign Status</td>
       <td width="12%" class="head1" >Expected Revenue</td>
     <td width="13%" class="head1" >Expected Close Date</td>
     
      <td width="16%"  align="center" class="head1" >Assign To</td>
      <td width="15%"  align="center" class="head1" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryCampaign) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryCampaign as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?=$Line?>" value="<?=$values['campaignID']?>" /></td>-->
      <td ><?=stripslashes($values["campaignname"])?></td>
      <td height="20" > <?=stripslashes($values["campaigntype"])?>	 </td>
	    <td height="20" > <?=stripslashes($values["campaignstatus"])?>	 </td>
			
		<td><?=$values['expectedrevenue']?> <?=$Config['Currency']?></td>
        <td height="20" > 
	<?  	if($values["closingdate"]!="0000-00-00"){//echo $Config['DateFormat'];
		echo date($Config['DateFormat'] , strtotime($values["closingdate"])); }?> </td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
	  
   
      <td  align="center"  >
	   <a href="vCampaign.php?view=<?=$values['campaignID']?>&module=Campaign&curP=<?=$_GET['curP']?>" ><?=$view?></a>
	 
	  <a href="editCampaign.php?edit=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>&tab=Edit" ><?=$edit?></a>
	  
	<a href="editCampaign.php?del_id=<?php echo $values['campaignID'];?>&module=Campaign&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryCampaign)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>      </td>
        </tr>
        
        </TABLE>
        
      </div> 
        <? }?>
     <? if($_GET['tab']=='Comments'){ include("comment.php");  }?>
	
<? if($_GET['tab']=='Ticket'){?>
 

<div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
<div id="preview_div">
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
	<tr>
        <td align="right">
        
        <a href="editTicket.php?module=Ticket&parent_type=<?=$_GET['module']?>&parentID=<?=$arryLead[0]['leadID']?>&mode_type=<?=$_GET['module']?>" class="add" >Add  Ticket</a>
        <a class="button" style="font-size:12px; color:#FFFFFF; padding: 3px 5px 4px 20px;font-size: 12px;line-height: normal;border-radius: 2px 2px 2px 2px;" href="#" onclick="return window.open('leadCompaign.php?module=<?=$_GET['tab']?>&amp;return_module=<?=$_GET['module']?>&amp;parent_type=<?=$_GET['module']?>&amp;parentID=<?=$_GET['view']?>','test','width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Ticket</b></a>
        
         
     
        
        </td>
      </tr>
      
      
      
	<tr>
	  <td  valign="top">

<table <?=$table_bg?>>
   
    <tr align="left"  >
      <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?=sizeof($arryTicket)?>');" /></td>-->
      <td width="13%"  class="head1" >Ticket ID</td>
      <td width="25%"  class="head1" >Title</td>
      <td width="14%" class="head1" > Add Date</td>
	  <td width="16%" class="head1" > Assign To</td>
    
      <td width="12%"  align="center" class="head1" >Status</td>
      <td width="20%"  align="center" class="head1 head1_action" >Action</td>
    </tr>
   
    <?php 
  if(is_array($arryTicket) && $num>0){
  	$flag=true;
	$Line=0;
  	foreach($arryTicket as $key=>$values){
	$flag=!$flag;
	#$bgcolor=($flag)?("#FDFBFB"):("");
	$Line++;
	
	//if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
  ?>
    <tr align="left"  bgcolor="<?=$bgcolor?>">
     <!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?=$Line?>" value="<?=$values['TicketID']?>" /></td>-->
      <td ><?=$values["TicketID"]?></td>
      <td > 
	  <?
		  echo stripslashes($values['title']);
		  
		  
		  ?>		       </td>
        <td> <? echo date($Config['DateFormat']  , strtotime($values["ticketDate"]));?></td>
     
	  <td><?=$values['AssignTo']?>(<?=$values['Department']?>)</td>
       
    <td align="center">
	
	 

	<? echo $values['Status'];
		
	 ?></td>
      <td  align="center"  ><a href=" vTicket.php?view=<? echo $values['TicketID']?>&module=<?php echo $_GET['tab'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$view?></a>&nbsp;
	 &nbsp;&nbsp; <a href="editTicket.php?edit=<?php echo $values['TicketID'];?>&curP=<?php echo $_GET['curP'];?>&module=<?php echo $_GET['tab'];?>&tab=Information" ><?=$edit?></a>
	  
	&nbsp;&nbsp;<a href="vLead.php?view=<?php echo $_GET["view"];?>&select_del_id=<?php echo $values['sid'];?>&module=<?=$_GET['module']?>&amp;curP=<?php echo $_GET['curP'];?>&tab=<?=$_GET['tab']?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
    </tr>
    <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="8" class="no_record">No record found. </td>
    </tr>
    <?php } ?>
  
	 <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num;?>      <?php if(count($arryTicket)>0){?>
&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}?></td>
  </tr>
  </table>
  </td>
  </tr>
  </TABLE>
  
  </div> 

<? }?>



