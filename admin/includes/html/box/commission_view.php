<? 

if($Config['SalesCommission']==1){	
	$arrySalesCommission = $objEmployee->GetSalesCommission($EmpID); 



	
?>


<style>
.progress {
    height: 20px; 
    overflow: hidden;
    border-radius: 4px;
    box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.1) inset;
    background-color: #F5F5F5;
}

.progress-bar-success {
    background-color: #5CB85C;
}
.progress-bar {
    float: left;
    width: 0px;
    height: 100%;
    font-size: 12px;
    line-height: 20px;
    color: #000;
    text-align: center;
    background-color: #337AB7;
    box-shadow: 0px -1px 0px rgba(0, 0, 0, 0.15) inset;
    transition: width 0.6s ease 0s;
}
</style>	

<table width="100%" border="0" cellpadding="5" cellspacing="0" 
<? if($Dashboard!=1) echo 'class="borderall"'; ?>  class="normal">
<? if(!empty($SubHeading)){ ?> 
<tr>
       		 <td colspan="2" align="left" class="head"><?=$SubHeading?></td>
        </tr>
<? } ?>



<tr>
	<td  align="right"  width="45%" valign="top"  >&nbsp;&nbsp;Sales Structure :</td>
	<td align="left" valign="top">
<?=(!empty($arrySalesCommission[0]['CommType']))?($arrySalesCommission[0]['CommType']):(NOT_DEFINED)?> 
	</td>
  </tr>	 


<tr>     
    <td colspan="2">
<? if($arrySalesCommission[0]['CommType']=="Commision" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //start commission ?>
<div id="CommDiv">	
<table width="100%" border="0" cellpadding="0" cellspacing="0">

<tr>
        <td align="right"   valign="top"   width="45%">
		Sales Person Type  :</td>
    <td align="left" valign="top" >

<?=$arrySalesCommission[0]['SalesPersonType']?> 	

	
	</td>
  </tr>	 	


	  <tr>
		<td  align="right"   valign="top" >Commission On :</td>
		<td align="left" valign="top">
<?=($arrySalesCommission[0]['CommOn'] == "0")?("Total Amount"):("Per Invoice Payment");?>			

		</td>
	</tr>
        <tr>
		<td  align="right"   valign="top" >Commission Type :</td>
		<td align="left" valign="top">

<? if(!empty($arrySalesCommission[0]['CommissionType'])){ ?>
<?=$arrySalesCommission[0]['CommissionType']?>
<? }else {echo "Monthly"; } ?>
			

		</td>
	</tr>

	  <tr>
		<td  align="right"   valign="top" >Commission Tier :</td>
		<td align="left" valign="top">

<? if($arrySalesCommission[0]['Percentage']>0){ ?>
<?=$arrySalesCommission[0]['Percentage']." %  on Range : ".$arrySalesCommission[0]['RangeFrom']." - ".$arrySalesCommission[0]['RangeTo'].""?>
<? }else {echo "None"; } ?>
			

		</td>
	</tr>


<tr>
	<td align="right" class="blackbold" valign="top" >
	Commission  Percentage :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['CommPercentage'])?> % &nbsp;&nbsp;&nbsp;&nbsp;	

<?
if($arrySalesCommission[0]['TargetFrom']!='' && $arrySalesCommission[0]['TargetTo']!='')
{
	$TargetFrom = $arrySalesCommission[0]['TargetFrom'];
	$TargetTo = $arrySalesCommission[0]['TargetTo'];
	#if($TargetTo==0) $TargetTo=$arrySalesCommission[0]['RangeFrom'];
	echo '[ Range: '.$TargetFrom.' - '.$TargetTo.' ]';
}
?>


	</td>
</tr>

	
	
<?if($arrySalesCommission[0]['Percentage']>0){ ?>
<tr>
        <td align="right"  valign="top" >
		Accelerator  :</td>
    <td align="left" valign="top" >
<?=$arrySalesCommission[0]['Accelerator']?>	

	</td>
  </tr>	

	<? if($arrySalesCommission[0]['Accelerator']=="Yes"){?>
	<tr>
		<td align="right"  valign="top" >
			Accelerator  Percentage :</td>
	    <td align="left" valign="top" >
	<?=$arrySalesCommission[0]['AcceleratorPer']?> % 	

		</td>
	  </tr>	
	<? } ?>

<tr>
        <td colspan="2" height=2>

	</td>
  </tr>	

<? } ?>
</table>
</div>


<? } // end commission ?>



<? if($arrySalesCommission[0]['CommType']=="Spiff" || $arrySalesCommission[0]['CommType']=="Commision & Spiff"){  //start spiff ?>
<div id="SpiffDiv">	
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
		<td  align="right"   valign="top"  width="45%">Spiff Tier :</td>
		<td align="left" valign="top">

<? if($arrySalesCommission[0]['SpiffAmount']>0){ ?>
<?=$arrySalesCommission[0]['SpiffAmount']." ".$Config['Currency']."  on sale of : ".$arrySalesCommission[0]['SalesTarget']." ".$Config['Currency'].""?>
<? }else {echo "None"; } ?>
			

		</td>
	</tr>


<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Target :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['SpiffTarget'])?>  <?=$Config['Currency']?>	
	</td>
</tr>

<tr>
	<td align="right" class="blackbold" valign="top" >
	Spiff Amount :
	</td>
	<td align="left" valign="top" >
	<?=stripslashes($arrySalesCommission[0]['SpiffEmp'])?> 	<?=$Config['Currency']?>	
	</td>
</tr>




</table>
</div>
<? } // end spiff ?>


	
	</td>
  </tr>	 





<? if($ShowSalesReport==1 && $arrySalesCommission[0]['CommType']!=''){ // to view sales calculation ?>
<tr>  
	<td align="right"  >&nbsp;&nbsp;Total Sales Amount : </td>
	<td align="left"><b><?=round($TotalSales,2).' '.$Config["Currency"]?></b></td>
  </tr>
 <!--tr>  
	<td align="right">&nbsp;&nbsp;Sales Amount for Commission : </td>
	<td align="left"><b><?=round($TotalSalesComm,2).' '.$Config["Currency"]?></b></td>
  </tr>	
 <tr>  
	<td align="right">&nbsp;&nbsp;Sales Amount for Spiff : </td>
	<td align="left"><b><?=round($TotalSalesSpiff,2).' '.$Config["Currency"]?></b></td>
  </tr-->
 <tr>  
	<td align="right">&nbsp;&nbsp;Sales Commission : </td>
	<td align="left"><b><?=round($TotalCommission,2).' '.$Config["Currency"]?></b></td>
  </tr>
  <?php if($arrySalesCommission[0]['CommPercentage'] > 0 )
  {

 ?>
  <tr style="display:">  
	<td align="right">&nbsp;&nbsp;Target Achieved: </td>
	<td align="left"><div class="progress"  style="background-color:">
              <?php
              
                $mintarget_amt=$arrySalesCommission[0]['TargetFrom'];
                $target_amt=$arrySalesCommission[0]['TargetTo'];
                $achieved_target=round($TotalSales,2);
   
              
                /*
                if($achieved_target >= $target_amt)
                {
                  $percent_val=100;   
                }*/
                
                if($achieved_target < $mintarget_amt)
                {
                  $percent_val=0;   
                }
                
                if(($achieved_target >=$mintarget_amt))
                {
                  $percent_val= round(($achieved_target/$target_amt)*100);
                  if($percent_val >=100)
                  {
                    $per_width='100';  
                  } 
                }
                
                /*
                if(($achieved_target >=$mintarget_amt) && ($achieved_target < $target_amt))
                {
                  $percent_val= round(($achieved_target/$target_amt)*100);
                }*/
                
                
              
              ?>
          <div class="progress-bar progress-bar-success"  style="width:<?=$per_width;?>%" role="progressbar" aria-valuenow="<?=$percent_val;?>"
  aria-valuemin="0" aria-valuemax="100" >
    <?=$percent_val;?>%
  </div>
</div></td>
  </tr>
  <?php } ?>
			
<? } ?>	

	

	
</table>	
  




	
	
<? } ?>

