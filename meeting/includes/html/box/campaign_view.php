
<div class="left_box">&nbsp;</div>



<div class="right_box">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

<?php if($_GET['tab']=="Document"){?>
    <tr>
    <td  align="center" valign="top" > 
     
    <? include("document.php"); ?>
    </td></tr>
     
 <? } else{ ?>
  
   <tr>
    <td  align="center" valign="top" >


<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">



<tr>
	 <td colspan="4" align="left" class="head" >Campaign Information</td>
</tr>
<tr>
        <td  align="right"   class="blackbold"  width="25%">Campaign Name  : </td>
        <td   align="left"  width="25%">
<?php echo stripslashes($arryCampaign[0]['campaignname']); ?>           </td>
 
        <td  align="right"   class="blackbold"  width="25%"> Assigned To  : </td>
        <td   align="left" > <? if(!empty($arryEmp[0]['UserName'])){?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$arryEmp[0]['EmpID']?>"><?=stripslashes($arryEmp[0]['UserName'])?> </a> <?} else { echo NOT_ASSIGNED;?> <? }?>
     </td>
      </tr>
        

             <tr>
        <td  align="right"   class="blackbold"> Campaign Status : </td>
        <td   align="left" >
        <?=(!empty($arryCampaign[0]['campaignstatus']))?($arryCampaign[0]['campaignstatus']):(NOT_SPECIFIED)?>
       
            </td>
     
        <td  align="right"   class="blackbold"> Campaign Type : </td>
        <td   align="left" >
         <?=(!empty($arryCampaign[0]['campaigntype']))?($arryCampaign[0]['campaigntype']):(NOT_SPECIFIED)?>
         
            </td>
      </tr>
      
      <tr>
        <td  align="right"   class="blackbold"> Product  : </td>
        <td   align="left" >
        <?=(!empty($arryProduct[0]['description']))?(stripslashes($arryProduct[0]['description']).' [Sku: '.stripslashes($arryProduct[0]['Sku']).']'):(NOT_SPECIFIED)?>
        
	

            </td>
          
        <td  align="right"   class="blackbold"> Target Audience :</td>
        <td   align="left" ><?=(!empty($arryCampaign[0]['targetaudience']))?($arryCampaign[0]['targetaudience']):(NOT_SPECIFIED)?>
         </td>
      </tr>
            
            <tr>
        <td  align="right"   class="blackbold">  Expected Close Date : </td>
        <td   align="left" >
		

<?php echo date($Config['DateFormat'],strtotime($arryCampaign[0]['closingdate'])) ?>             </td>
     
        <td  align="right"   class="blackbold"> Target Size : </td>
        <td   align="left" >
		<?=(!empty($arryCampaign[0]['targetsize']))?($arryCampaign[0]['targetsize']):(NOT_SPECIFIED)?>
       </td>
      </tr>
 <tr>
        <td  align="right"   class="blackbold"> Sponsor : </td>
        <td   align="left" >
<?=(!empty($arryCampaign[0]['sponsor']))?($arryCampaign[0]['sponsor']):(NOT_SPECIFIED)?>
        </td>
      
        <td  align="right"   class="blackbold"> Num Sent (%)  : </td>
        <td   align="left" >
<?=(!empty($arryCampaign[0]['numsent']))?($arryCampaign[0]['numsent']):(NOT_SPECIFIED)?>

      </td>
      </tr>
	  
	  

	<tr>
       		 <td colspan="4" align="left"   class="head">Expectations & Actuals</td>
        </tr>


     

	  
			
 <tr>
        <td  align="right"   class="blackbold"> Budget Cost: (<?=$Config['Currency']?>)  : </td>
        <td   align="left" >
		<?=(!empty($arryCampaign[0]['budgetcost']))?($arryCampaign[0]['budgetcost']):(NOT_SPECIFIED)?>  
  

 </td>

        <td  align="right"   class="blackbold"> Actual Cost: (<?=$Config['Currency']?>)  : </td>
        <td   align="left" >
		<?=(!empty($arryCampaign[0]['actualcost']))?($arryCampaign[0]['actualcost']):(NOT_SPECIFIED)?>
   

 </td>
 </tr>
 
     
 <tr >
        <td  align="right"   class="blackbold"> Expected Response  : </td>
        <td   align="left" >
		<?=(!empty($arryCampaign[0]['expectedresponse']))?($arryCampaign[0]['expectedresponse']):(NOT_SPECIFIED)?>
 
		
             </td>

        <td  align="right"   class="blackbold"> Expected Revenue: (<?=$Config['Currency']?>)  : </td>
        <td   align="left" >
		<?=(!empty($arryCampaign[0]['expectedrevenue']))?($arryCampaign[0]['expectedrevenue']):(NOT_SPECIFIED)?>
  

 </td>
 </tr>
	  
	   <tr>
        <td  align="right"   class="blackbold">Expected Sales Count : </td>
        <td   align="left" > <?=(!empty($arryCampaign[0]['expectedsalescount']))?($arryCampaign[0]['expectedsalescount']):(NOT_SPECIFIED)?>
           </td>
     
        <td  align="right"   class="blackbold">Actual Sales Count   : </td>
        <td   align="left" ><?=(!empty($arryCampaign[0]['actualsalescount']))?($arryCampaign[0]['actualsalescount']):(NOT_SPECIFIED)?>
           </td>
      </tr>

	
	  <tr>
        <td  align="right"   class="blackbold">Expected Response Count  : </td>
        <td   align="left" ><?=(!empty($arryCampaign[0]['expectedresponsecount']))?($arryCampaign[0]['expectedresponsecount']):(NOT_SPECIFIED)?>
           </td>
    
        <td  align="right"   class="blackbold">Actual Response Count : </td>
        <td   align="left" ><?=(!empty($arryCampaign[0]['actualresponsecount']))?($arryCampaign[0]['actualresponsecount']):(NOT_SPECIFIED)?>
          </td>
      </tr>
	<tr>
        <td  align="right"   class="blackbold"> Expected ROI: (<?=$Config['Currency']?>)  : </td>
        <td   align="left" ><?=(!empty($arryCampaign[0]['expectedroi']))?($arryCampaign[0]['expectedroi']):(NOT_SPECIFIED)?>
		
 

 </td>

        <td  align="right"   class="blackbold"> Actual ROI: (<?=$Config['Currency']?>)  : </td>
        <td   align="left" >
		<?=(!empty($arryCampaign[0]['actualroi']))?($arryCampaign[0]['actualroi']):(NOT_SPECIFIED)?>
   

 </td>
 </tr>



           <tr>
       		 <td colspan="4" align="left"   class="head">Description</td>
        </tr>

		 <tr>
          <td align="right"   class="blackbold" valign="top">Description :</td>
          <td  align="left" colspan="3"><?=(!empty($arryCampaign[0]['description']))?(stripslashes($arryCampaign[0]['description'])):(NOT_SPECIFIED)?>
          
	          </td>
        </tr>

 
<tr>
       		 <td colspan="4" align="left"   ><?php if($_GET['pop']!=1){include("includes/html/box/comment.php");}?></td>
        </tr>

	

	

		
	

</table>	


	
	  
	
	</td>
   </tr>

 <? }?> 

   <tr>
    <td  align="center" >
	







<input type="hidden" name="created_by" id="created_by"  value="<?=$_SESSION['AdminType']?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?=$_SESSION['AdminID']?>" />



</td>
   </tr>
   
</table>
</div>




