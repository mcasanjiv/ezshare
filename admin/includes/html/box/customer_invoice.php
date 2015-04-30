<? 
if($arryCustomer[0]['CustCode']!=''){
	$_GET['module']='Invoice'; $module = $_GET['module'];
	$ModuleIDTitle = "Invoice Number"; $ModuleID = "InvoiceID";
	$ViewDetailUrl = "../finance/vInvoice.php?pop=1";

	$_GET['CustCode'] = $arryCustomer[0]['CustCode'];		
	$arrySale=$objSale->ListSale($_GET);
?>
<table width="100%" border="0" cellpadding="5" cellspacing="5">
	<tr>
		 <td colspan="2" align="left" >
		 
<div id="preview_div" >
<table id="myTable" cellspacing="1" cellpadding="5" width="100%" align="center">
<? if(sizeof($arrySale)>0){ ?>
<tr align="left"  >
	<td width="15%" class="head1" ><?=$module?> Date</td>
	<td width="15%"  class="head1" ><?=$module?> Number</td>
	<td width="12%" class="head1" >SO Number</td>
	<td class="head1">Sales Person</td>
	<td width="15%" align="center" class="head1" >Amount</td>
	<td width="10%" align="center" class="head1" >Currency</td>
	<td width="12%"  align="center" class="head1" >Status</td>
</tr>
<?
  	$flag=true;
	$Line=0;
  	foreach($arrySale as $key=>$values){
	$flag=!$flag;
	$class=($flag)?("oddbg"):("evenbg");
	$Line++;	
  ?>
<tr align="left"  class="<?=$class?>">
 
<td height="20">
		<? 
		  $ddate = $module.'Date';
		if($values[$ddate]>0) 
		echo date($Config['DateFormat'], strtotime($values[$ddate]));
		?>

		</td>
		<td >
<a class="fancybox fancybig fancybox.iframe" href="<?=$ViewDetailUrl.'&view='.$values['OrderID']?>" ><?=$values[$ModuleID]?></a>

</td>
<td>		 
<a href="../sales/vSalesQuoteOrder.php?module=Order&pop=1&so=<?=$values['SaleID']?>" class="fancybox fancybig fancybox.iframe"><?=$values['SaleID']?></a>
</td>


<td><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?=$values['SalesPersonID']?>"><?=stripslashes($values["SalesPerson"])?></a> </td>
		<td align="center"><?=$values['TotalAmount']?></td>
		<td align="center"><?=$values['CustomerCurrency']?></td>
		
		<td align="center">
	  <? 
		 if($values['InvoicePaid'] =='Paid'){
			 $StatusCls = 'green';
		 }else{
			 $StatusCls = 'red';
		 }

		echo '<span class="'.$StatusCls.'">'.$values['InvoicePaid'].'</span>';
		
	 ?>
	 
	</td>


 
</tr>

 <?
} // foreach end //

?>
  
    <?php }else{?>
    <tr align="center" >
      <td  class="no_record"><?=NO_RECORD?></td>
    </tr>
    <?php } ?>
  </table>
</div>
	 
		 </td>
	</tr>	
	

</table>
<? } ?>
