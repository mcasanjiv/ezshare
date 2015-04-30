<?php
 $TaxRateOption = "<option value='0'>None</option>";
 for($i=0;$i<sizeof($arrySaleTax);$i++) {
	$TaxRateOption .= "<option value='".$arrySaleTax[$i]['RateId'].":".$arrySaleTax[$i]['TaxRate']."'>
	".$arrySaleTax[$i]['RateDescription']." : ".$arrySaleTax[$i]['TaxRate']."</option>";
 } 

?>	
<input type="hidden" name="TaxRateOption" id="TaxRateOption" value="<?=$TaxRateOption?>" readonly />

<script language="JavaScript1.2" type="text/javascript">

	$(document).ready(function () {
	var counter = 2;
	var TaxRateOption = $("#TaxRateOption").val();

	$("#addrow").on("click", function () { 
		/*var counter = $('#myTable tr').length - 2;*/

		counter = parseInt($("#NumLine").val()) + 1;

		var newRow = $("<tr class='itembg'>");
		var cols = "";


		//var Taxable = $("#Taxable").val();
		var Taxable = $("#tax_auths").val();
		var TaxShowHide = 'none';
		if(Taxable=='Yes'){
			TaxShowHide = 'inline';
		}



		/*cols += '<td><input type="text" class="textbox" name="sku' + counter + '"/></td>';
		cols += '<td><input type="text" class="textbox" name="price' + counter + '"/></td>';*/
		
        cols += '<td><img src="../images/delete.png" id="ibtnDel" title="Delete">&nbsp;<input type="text" name="sku' + counter + '" id="sku' + counter + '" class="disabled" readonly size="10" maxlength="10"  />&nbsp;<a class="fancybox fancybox.iframe" href="../inventory/SelectItem.php?proc=Sale&id=' + counter + '" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox fancybox.iframe" id="req_link' + counter + '" href="reqItem.php?id=' + counter + '" style="display:none"><img src="../images/tab-new.png" border="0" title="Additional Items" ></a><input type="hidden" name="item_id' + counter + '" id="item_id' + counter + '" readonly maxlength="20"  /><input type="hidden" name="req_item' + counter + '" id="req_item' + counter + '" readonly /></td><td><input type="text" name="description' + counter + '" id="description' + counter + '" class="textbox" style="width:110px;"  maxlength="50" onkeypress="return isAlphaKey(event);" /></td><td><input type="text" name="on_hand_qty' + counter + '" id="on_hand_qty' + counter + '" class="disabled" readonly size="5"/></td><td><input type="text" name="qty' + counter + '"  id="qty' + counter + '"  class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" /></td><td><input type="text" name="price' + counter + '"  id="price' + counter + '" class="textbox" size="8" maxlength="10" onkeypress="return isDecimalKey(event);"/></td><td><input type="text" name="discount' +counter+ '" id="discount' +counter+ '" class="textbox" size="6" maxlength="10" onkeypress="return isDecimalKey(event);" /></td><td><input type="text" class="normal" name="item_taxable' + counter + '" id="item_taxable' + counter + '" readonly size="2" maxlength="20"  /><!--select name="tax' + counter + '" id="tax' + counter + '" class="textbox" style="width:120px;display:'+TaxShowHide+'">' + TaxRateOption + '</select---></td><td align="right"><input type="text" name="amount' + counter + '" id="amount' + counter + '" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;"/></td>';



		newRow.append(cols);
		//if (counter == 4) $('#addrow').attr('disabled', true).prop('value', "You've reached the limit");
		$("table.order-list").append(newRow);
		$("#NumLine").val(counter);
		counter++;
	});

	$("table.order-list").on("blur", 'input[name^="price"],input[name^="qty"],input[name^="discount"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});

	/*$("table.order-list").on("change", 'select[name^="tax"]', function (event) {
		calculateRow($(this).closest("tr"));
		calculateGrandTotal();
	});*/


	$("table.order-list").on("click", "#ibtnDel", function (event) {

		/********Edited by pk **********/
		var row = $(this).closest("tr");
		var id = row.find('input[name^="id"]').val(); 
		if(id>0){
			var DelItemVal = $("#DelItem").val();
			if(DelItemVal!='') DelItemVal = DelItemVal+',';
			$("#DelItem").val(DelItemVal+id);
		}
		/*****************************/
		$(this).closest("tr").remove();
		calculateGrandTotal();

	});

	});

	function calculateRow(row) {
		var taxRate = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		//var taxRate = row.find('select[name^="tax"]').val();

		var price = +row.find('input[name^="price"]').val();
		var qty = +row.find('input[name^="qty"]').val();
		var item_taxable = row.find('input[name^="item_taxable"]').val();
		var discount = +row.find('input[name^="discount"]').val();
		var TotalDisCount = discount*qty;
	
	    if(discount>0 && discount>=price)
		{
		   alert("Discount Should be Less Than Unit Price!");
		   return false;
		}
		var SubTotal = price*qty;
			if(TotalDisCount > 0){
				SubTotal = SubTotal-TotalDisCount;
			}
		var tax_add = 0;

		if(taxRate!=0 && item_taxable=="Yes"){
			var arrField = taxRate.split(":");
			var tax = arrField[2];
			tax_add = (SubTotal*tax)/100;
			//SubTotal += tax_add;
		}

		row.find('input[name^="amount"]').val(SubTotal.toFixed(2));
	}

	function calculateGrandTotal() {		
		var subtotal=0, TotalAmount=0 , taxAmnt=0;		
		var item_taxable = ''; 		
		var taxRate = 0; var tax = 0; var amount = 0;
		if(document.getElementById("TaxRate") != null){
			taxRate = document.getElementById("TaxRate").value;
		}
		if(taxRate!=0){
			var arrField = taxRate.split(":");
			tax = arrField[2];			
		}


		$("table.order-list").find('input[name^="amount"]').each(function () {
			amount = $(this).val();
			subtotal += +amount;			
			item_taxable = $(this).closest("tr").find('input[name^="item_taxable"]').val();
			if(tax>0 && item_taxable=="Yes"){
				taxAmnt += (amount*tax)/100;	
			}
			
		});

		$("#subtotal").val(subtotal.toFixed(2));
		$("#taxAmnt").val(taxAmnt.toFixed(2));

		subtotal += +$("#Freight").val();
		subtotal += +$("#taxAmnt").val();

		$("#TotalAmount").val(subtotal.toFixed(2));
	}




	function ProcessTotal() {
		var Taxable = $("#Taxable").val();
		var NumLine = document.getElementById("NumLine").value;
		
		var tax_auths='';
		if(document.getElementById("tax_auths").value=="Yes"){
			tax_auths='Yes';
		}


		/*for(var i=1;i<=NumLine;i++){
			var TaxElement = document.getElementById("tax"+i);
			var ItemTaxableElement = document.getElementById("item_taxable"+i);
			if(TaxElement != null){
				var ShowHideTax = 'none';
				if(tax_auths=="Yes" && ItemTaxableElement.value=="Yes"){
					TaxElement.style.display = 'inline';
				}else{
					TaxElement.style.display = 'none';
					TaxElement.value = '0';
				}							
				
			}
		}*/

		/*********************/
		$("table.order-list").find('input[name^="amount"]').each(function () {
			calculateRow($(this).closest("tr"));
			
		});
		calculateGrandTotal();
	}


</script>



 <table width="100%" id="myTable" class="order-list"  cellpadding="0" cellspacing="1">
<thead>
    <tr align="left" >
		<td class="heading">&nbsp;&nbsp;&nbsp;SKU</td>
		<td width="15%" class="heading">Description</td>
		<td width="8%" class="heading">Qty on Hand</td>
		<td width="8%" class="heading">Qty</td>
		<td width="8%" class="heading">Unit Price</td>
		<td width="10%" class="heading">Discount</td>
		<td width="8%" class="heading">Taxable</td>
		<td width="12%" class="heading" align="right">Amount</td>
    </tr>
</thead>
<tbody>
	<? $subtotal=0;
	for($Line=1;$Line<=$NumLine;$Line++) { 
		$Count=$Line-1;	
		
	#if($arryQuote[0]['Taxable']=='Yes' && $arryQuote[0]['Reseller']!='Yes' && $arryQuoteProduct[$Count]['Taxable']=='Yes'){
	if($arryQuote[0]['tax_auths']=='Yes' && $arryQuoteProduct[$Count]['Taxable']=='Yes'){
		$TaxShowHide = 'inline';
	}else{
		$TaxShowHide = 'none';
	}

	$ReqDisplay = !empty($arryQuoteProduct[$Count]['req_item'])?(''):('style="display:none"');
	if(empty($arryQuoteProduct[$Count]['Taxable'])) $arryQuoteProduct[$Count]['Taxable']='No';
	?>
     <tr class='itembg'>
		<td><?=($Line>1)?('<img src="../images/delete.png" id="ibtnDel" title="Delete">'):("&nbsp;&nbsp;&nbsp;")?>
		<input type="text" name="sku<?=$Line?>" id="sku<?=$Line?>" class="disabled" readonly size="10" maxlength="10"  value="<?=stripslashes($arryQuoteProduct[$Count]["sku"])?>"/>&nbsp;<a class="fancybox fancybox.iframe" href="../inventory/SelectItem.php?proc=Sale&id=<?=$Line?>" ><img src="../images/view.gif" border="0" title="Search"></a>&nbsp;&nbsp;<a class="fancybox reqbox  fancybox.iframe" href="reqItem.php?id=<?=$Line?>&oid=<?=$arryQuoteProduct[$Count]['id']?>" id="req_link<?=$Line?>" <?=$ReqDisplay?>><img src="../images/tab-new.png" border="0" title="Additional Items"></a>

		<input type="hidden" name="item_id<?=$Line?>" id="item_id<?=$Line?>" value="<?=stripslashes($arryQuoteProduct[$Count]["item_id"])?>" readonly maxlength="20"  />
		<input type="hidden" name="id<?=$Line?>" id="id<?=$Line?>" value="<?=stripslashes($arryQuoteProduct[$Count]["id"])?>" readonly maxlength="20"  />


<input type="hidden" name="req_item<?=$Line?>" id="req_item<?=$Line?>" value="<?=stripslashes($arryQuoteProduct[$Count]['req_item'])?>" readonly />

		</td>
        <td><input type="text" name="description<?=$Line?>" id="description<?=$Line?>" class="textbox" style="width:110px;"  maxlength="50" onkeypress="return isAlphaKey(event);" value="<?=stripslashes($arryQuoteProduct[$Count]["description"])?>"/></td>
        <td><input type="text" name="on_hand_qty<?=$Line?>" id="on_hand_qty<?=$Line?>" class="disabled" readonly size="5"  value="<?=stripslashes($arryQuoteProduct[$Count]["on_hand_qty"])?>"/></td>
        <td><input type="text" name="qty<?=$Line?>" id="qty<?=$Line?>" class="textbox" size="5" maxlength="6" onkeypress="return isNumberKey(event);" value="<?=stripslashes($arryQuoteProduct[$Count]["qty"])?>"/></td>
       <td><input type="text" name="price<?=$Line?>" id="price<?=$Line?>" class="textbox" size="8" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryQuoteProduct[$Count]["price"])?>"/></td>
	   <td><input type="text" name="discount<?=$Line?>" id="discount<?=$Line?>" class="textbox" size="6" maxlength="10" onkeypress="return isDecimalKey(event);" value="<?=stripslashes($arryQuoteProduct[$Count]["discount"])?>"/></td>
       <td>
<input type="text" class="normal" name="item_taxable<?=$Line?>" id="item_taxable<?=$Line?>" value="<?=stripslashes($arryQuoteProduct[$Count]['Taxable'])?>" readonly size="2" maxlength="20"  />
	   <!--select name="tax<?=$Line?>" id="tax<?=$Line?>" class="textbox" style="width:120px;display:<?=$TaxShowHide?>">
			<option value="0">None</option>
			<? for($i=0;$i<sizeof($arrySaleTax);$i++) {?>
			<option value="<?=$arrySaleTax[$i]['RateId'].':'.$arrySaleTax[$i]['TaxRate']?>" <? if($arrySaleTax[$i]['RateId']==$arryQuoteProduct[$Count]['tax_id']){echo "selected";}?>>
			<?=$arrySaleTax[$i]['RateDescription'].' : '.$arrySaleTax[$i]['TaxRate']?>
			</option>
			<? } ?>			
		</select-->
	   </td>
       <td align="right"><input type="text" align="right" name="amount<?=$Line?>" id="amount<?=$Line?>" class="disabled" readonly size="13" maxlength="10" onkeypress="return isDecimalKey(event);" style="text-align:right;" value="<?=stripslashes($arryQuoteProduct[$Count]["amount"])?>"/></td>
       
    </tr>
	<? 
		$subtotal += $arryQuoteProduct[$Count]["amount"];
	} ?>
</tbody>
<tfoot>

    <tr class='itembg'>
        <td colspan="8" align="right">

		 <a href="Javascript:void(0);"  id="addrow" class="add_row" style="float:left">Add Item</a>
         <input type="hidden" name="NumLine" id="NumLine" value="<?=$NumLine?>" readonly maxlength="20"  />
         <input type="hidden" name="DelItem" id="DelItem" value="" class="inputbox" readonly />


		<?	
		//$subtotal = number_format($subtotal,2);
		$taxAmnt = $arryQuote[0]['taxAmnt'];
		$Freight = $arryQuote[0]['Freight']; // number_format($arryQuote[0]['Freight'],2);
		$TotalAmount = $arryQuote[0]['TotalAmount']; //number_format($arryQuote[0]['TotalAmount'],2);
		?>
		<br>
		Sub Total : <input type="text" align="right" name="subtotal" id="subtotal" class="disabled" readonly value="<?=$subtotal?>" size="13" style="text-align:right;"/>
		<br><br>

		Tax : <input type="text" align="right" name="taxAmnt" id="taxAmnt" class="disabled" readonly value="<?=$taxAmnt?>" size="13" style="text-align:right;"/><br><br>


		Freight : <input type="text" align="right" name="Freight" id="Freight" class="textbox" value="<?=$Freight?>" size="13" maxlength="10" onkeypress="return isDecimalKey(event);" onblur="calculateGrandTotal();" style="text-align:right;"/>
		<br><br>
		Grand Total : <input type="text" align="right" name="TotalAmount" id="TotalAmount" class="disabled" readonly value="<?=$TotalAmount?>" size="13" style="text-align:right;"/>
		<br><br>
        </td>
    </tr>
</tfoot>
</table>

<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".reqbox").fancybox({
			'width'         : 500
		 });

});

</script>

<? //echo '<script>SetInnerWidth();</script>'; ?>
