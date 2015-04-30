<? if($_GET['tab']="contact"){?>

<div class="right_box">
  <table width="100%"  border="0" cellpadding="0" cellspacing="0">
    <form name="form1" action="<?=$ActionUrl?>"  method="post" onSubmit="return validate_<?=$_GET['tab']?>(this);" enctype="multipart/form-data">
      <? if (!empty($_SESSION['mess_contact'])) {?>
      <tr>
        <td  align="center"  class="message"  ><? if(!empty($_SESSION['mess_contact'])) {echo $_SESSION['mess_contact']; unset($_SESSION['mess_contact']); }?>
        </td>
      </tr>
      <? } ?>
      <tr>
        <td  align="center" valign="top" >
        <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
            
            <tr>
              <td colspan="4" align="left" class="head">Basic Information</td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold"  width="25%"> First Name  : </td>
              <td   align="left" width="25%"><?php echo stripslashes($arryContact[0]['FirstName']); ?>
              </td>
            
              <td  align="right"   class="blackbold" width="25%"> Last Name  : </td>
              <td   align="left" ><?php echo stripslashes($arryContact[0]['LastName']); ?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Email  : </td>
              <td  align="left" ><?php echo stripslashes($arryContact[0]['Email']); ?>
              </td>
          
              <td align="right"   class="blackbold">Personal Email  :</td>
              <td  align="left" >
<?=(!empty($arryContact[0]['PersonalEmail']))?($arryContact[0]['PersonalEmail']):(NOT_SPECIFIED)?>




              </td>
            </tr>
           
            <tr style="display:none;">
              <td align="right"   class="blackbold">Organization  : </td>
              <td  align="left" >
<?php echo stripslashes($arryContact[0]['Organization']); ?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Title  : </td>
              <td  align="left" >

<? if(!empty($arryContact[0]['Title'])){  echo stripslashes($arryContact[0]['Title']); } else { echo NOT_SPECIFIED;?> <? }?>

              </td>
           
              <td align="right"   class="blackbold">Department  : </td>
              <td  align="left" >
<? if(!empty($arryContact[0]['Department'])){  echo $arryContact[0]['Department']; } else { echo NOT_SPECIFIED;?> <? }?>


              </td>
            </tr>
          
           
            <tr>
              <td  align="right"   class="blackbold"> Lead Source  : </td>
              <td   align="left" ><? if(!empty($arryContact[0]['LeadSource'])){  echo $arryContact[0]['LeadSource']; } else { echo NOT_SPECIFIED;?> <? }?>


              </td>
          
              <td  align="right"   class="blackbold"> Assigned To  : </td>
              <td   align="left" >
<? if(!empty($arryContact[0]['AssignTo'])){?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryEmployee[0]['EmpID']?>"><?=(stripslashes($arryEmployee[0]['UserName']))?></a> <?} else { echo NOT_ASSIGNED;?> <? }?>
              </td>
            </tr>


  <tr>
              <td align="right"   class="blackbold">Reference  : </td>
              <td  align="left" > <?php if($arryContact[0]['Reference']=="Yes"){ echo"Yes";}else{ echo "No";} ?>
              </td>
           
              <td align="right"   class="blackbold">Do Not Call  : </td>
              <td  align="left" ><?php if($arryContact[0]['DoNotCall']=="Yes"){ echo"Yes";}else{ echo"No"; }?>
              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold">Notify Owner  : </td>
              <td  align="left" > <?php if($arryContact[0]['NotifyOwner']=="Yes"){ echo"Yes";}else{ echo"No"; }?>
			  
              </td>
           
              <td align="right"   class="blackbold">Email Opt Out : </td>
              <td  align="left" ><?php if($arryContact[0]['EmailOptOut']=="Yes"){ echo"Yes";}else{ echo"No"; }?>
              
             
              </td>
            </tr>
            
        
 	<tr>
        <td  align="right"   class="blackbold">  Customer : </td>
        <td   align="left" >
<? if(!empty($arryCustomer[0]['FullName'])){?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$arryCustomer[0]['CustCode']?>"><?=(stripslashes($arryCustomer[0]['FullName']))?> </a> <?} else { echo NOT_SPECIFIED;?> <? }?>	    

            </td>

<td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
         
 <?  echo ($arryContact[0]['Status'] == 1)?("Active"):(" InActive");
		  ?>

</td>



            </tr>


            <tr style="display:none;">
              <td  align="right"   > Portal User : </td>
              <td   align="left" > <?php if($arryContact[0]['PortalUser']=="Yes"){ echo"Yes";}else{ echo "No";} ?> </td>
            </tr>
            <tr style="display:none;">
              <td  align="right"   > Support Start Date : </td>
              <td   align="left" ><? if($arryContact[0]['Supp_start_date']>0) echo date($Config['DateFormat'],strtotime($arryContact[0]['Supp_start_date']));?>
                
              </td>
            </tr>
            <tr style="display:none;">
              <td  align="right"   > Support End Date : </td>
              <td   align="left" ><? if($arryContact[0]['Supp_end_date']>0) echo date($Config['DateFormat'],strtotime($arryContact[0]['Supp_end_date']));?>
               
              </td>
            </tr>
          
            <tr>
              <td colspan="4" align="left"   class="head">Address Details</td>
            </tr>
            <tr>
              <td align="right"   class="blackbold" valign="top">Address  :</td>
              <td  align="left" ><?=nl2br(stripslashes($arryContact[0]['Address']))?>

              </td>
            </tr>
            <tr >
              <td  align="right"   class="blackbold"> Country  :</td>
              <td   align="left" >
<?=(!empty($arryContact[0]['CountryName']))?(stripslashes($arryContact[0]['CountryName'])):(NOT_SPECIFIED)?>


              </td>
            </tr>
            <tr>
              <td  align="right" valign="middle"  class="blackbold"> State  :</td>
              <td  align="left"  >
<?=(!empty($arryContact[0]['StateName']))?(stripslashes($arryContact[0]['StateName'])):(NOT_SPECIFIED)?>

</td>
            </tr>
           
            <tr>
              <td  align="right"   class="blackbold">City   :</td>
              <td  align="left"  >
<?=(!empty($arryContact[0]['CityName']))?(htmlentities($arryContact[0]['CityName'], ENT_IGNORE)):(NOT_SPECIFIED)?>
</td>
            </tr>
           
            <tr>
              <td align="right"   class="blackbold" >Zip Code  :</td>
              <td  align="left"  >
<?=(!empty($arryContact[0]['ZipCode']))?(stripslashes($arryContact[0]['ZipCode'])):(NOT_SPECIFIED)?>

              </td>
            </tr>
            <tr>
              <td align="right"   class="blackbold" >Mobile  :</td>
              <td  align="left"  >
<?=(!empty($arryContact[0]['Mobile']))?(stripslashes($arryContact[0]['Mobile'])):(NOT_SPECIFIED)?>


              </td>
            </tr>
            <tr style="display:none;">
              <td align="right"   class="blackbold">Fax  : </td>
              <td  align="left" >
<?=(!empty($arryContact[0]['Fax']))?(stripslashes($arryContact[0]['Fax'])):(NOT_SPECIFIED)?>


              </td>
            </tr>
            <tr>
              <td  align="right"   class="blackbold">Landline  :</td>
              <td   align="left" >
<?=(!empty($arryContact[0]['Landline']))?(stripslashes($arryContact[0]['Landline'])):(NOT_SPECIFIED)?>


              </td>
            </tr>
           <tr>
       		 <td colspan="4" align="left"   class="head">Description Details</td>
        </tr>

		

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" colspan="3" >
            <?=(!empty($arryContact[0]['Description']))?(stripslashes(nl2br($arryContact[0]['Description']))):(NOT_SPECIFIED)?></td>
			</tr>
            <tr>
              <td colspan="4" align="left" class="head">Social Information</td>
            </tr>
           
		 	<tr>
       		   <td align="right"   class="blackbold" valign="top">Facebook :</td>
          		<td  align="left" colspan="3" >          	
           			 <?php if(!empty($arryContact[0]['FacebookID'])){$socialdata=stripslashes(nl2br($arryContact[0]['FacebookID']));
           			$socialdata = unserialize($socialdata);
           				echo '<a href="viewprofile.php?id='.$arryContact[0]['FacebookID'].'&type=facebook" class="fancybox fancybox.iframe">View Profile</a>';
           			 }else{echo (NOT_SPECIFIED);}?></td>
           		</tr>
           		<tr>
           		<td align="right"   class="blackbold" valign="top">Twitter :</td>
          		<td  align="left" colspan="3" >
           			  <?php if(!empty($arryContact[0]['TwitterID'])){$socialdata=stripslashes(nl2br($arryContact[0]['TwitterID']));
           			$socialdata = unserialize($socialdata);
           				echo '<a href="viewprofile.php?id='.$arryContact[0]['TwitterID'].'&type=twitter" class="fancybox fancybox.iframe">View Profile</a>';
           			 }else{echo (NOT_SPECIFIED);}?></td>
           		</tr>
           		<tr>
           		<td align="right"   class="blackbold" valign="top">Linkedin :</td>
          		<td  align="left" colspan="3" >
           			  <?php if(!empty($arryContact[0]['LinkedinID'])){$socialdata=stripslashes(nl2br($arryContact[0]['LinkedinID']));
           			$socialdata = unserialize($socialdata);
           			$id='';
           			$t='';
           			if(!empty($arryContact[0]['FacebookID'])){
           			$id=$arryContact[0]['FacebookID'];
           			$t='facebook';
           			}elseif(!empty($arryContact[0]['TwitterID'])){
           			$id=$arryContact[0]['TwitterID'];
           			$t='twitter';
           			
           			}
           				echo '<a href="viewprofile.php?id='.$id.'&type='.$t.'" class="fancybox fancybox.iframe">View Profile</a>';
           			 }else{echo (NOT_SPECIFIED);}?></td>
				</tr>
          </table></td>
      </tr>
     
    </form>
  </table><? }?>



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
        
        <a href="<?=$AddUrl?>" class="add" >Add  Ticket</a>
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
	 &nbsp;&nbsp; <a href="<?=$editTicket?><?php echo $values['TicketID'];?>&curP=<?php echo $_GET['curP'];?>&tab=Information" ><?=$edit?></a>
	  
	&nbsp;&nbsp;<a href="<?=$DelTicket?><?php echo $values['TicketID'];?>&amp;curP=<?php echo $_GET['curP'];?>" onclick="return confirmDialog(this, '<?=$ModuleName?>')"  ><?=$delete?></a>   </td>
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

</div>


<SCRIPT LANGUAGE=JAVASCRIPT>
<? if($_GET["tab"]=="contact"){ ?>
	StateListSend();
<? } ?>
<? if($_GET["tab"]=="account"){ ?>
	ShowPermission();
<? } ?>
</SCRIPT>
