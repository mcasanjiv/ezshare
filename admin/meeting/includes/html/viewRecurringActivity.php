<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        ShowHideLoader('1');
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
   
</script>

<div class="had"><?= $MainModuleName ?></div>
<div class="message" align="center"><?
    if (!empty($_SESSION['mess_rec_act'])) {
        echo $_SESSION['mess_rec_act'];
        unset($_SESSION['mess_rec_act']);
    }
    ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td align="right" valign="top">
            <? if ($num > 0) { ?>
                <!--input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_so.php?<?= $QueryString ?>&EntryType=<?=$_GET['EntryType']?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();" -->

            <? } ?>



            <!--a href="<?= $AddUrl ?>" class="add">Add Recurring <?= $ModuleName ?></a-->

            <? if ($_GET['search'] != '') { ?>
                <a href="<?= $RedirectURL ?>" class="grey_bt">View All</a>
            <? } ?>


        </td>
    </tr>

    <tr>
        <td  valign="top">


            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>
                       
                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','OrderID','<?= sizeof($arryActivity) ?>');" /></td>-->
				
                                <td  class="head1" >Title</td>
                                <td width="12%" class="head1"> Activity Type </td>

                                <td width="12%" class="head1">Interval</td>
				
				<td width="10%"  class="head1" >Entry Date</td>
				
				<td width="10%" class="head1">Every</td>

                                <td width="14%" class="head1">Entry From</td>

                                <td width="15%" width="8%"  class="head1" >Entry To</td>
                               
                    
                                <td width="7%"  align="center" class="head1 head1_action" >Action</td>
                            </tr>
                       
                        <?php

$cancel = '<img src="'.$Config['Url'].'admin/images/delete.png" border="0"  onMouseover="ddrivetip(\'<center>Cancel</center>\', 40,\'\')"; onMouseout="hideddrivetip()" >';


                        if (is_array($arryActivity) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            $OrderType = '';
                            foreach ($arryActivity as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                
                                if ($values['activityType'] == "Task") {
                                        $mode = "Task";
                                    } else {
                                        $mode = "Event";
                                    }
                             
                                
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">

                                  
                                                <!--<td ><input type="checkbox" name="OrderID[]" id="OrderID<?= $Line ?>" value="<?= $values['OrderID'] ?>" /></td>-->

                   
<td height="22" >

<a class="fancybox fancybox.iframe" href="vActivity.php?view=<?php echo $values['activityID']; ?>&curP=<?php echo $_GET['curP']; ?>&module=Activity&mode=<?=$mode?>&pop=1"><?=stripslashes($values["subject"])?></a>
 
</td>

<td><?= $values['activityType'] ?></td>
                    
 <td>

	<?php
	if(!empty($values['EntryInterval'])){
		$EntryInterval = $values['EntryInterval'];
	}else{
		$EntryInterval = "Monthly";
	}
	if($EntryInterval == "semi_monthly"){ $EntryInterval = "Semi Monthly";  }

	echo ucfirst($EntryInterval);
	?>




</td>

<td>

 <? if($values['EntryInterval'] != 'weekly' && $values['EntryInterval'] != 'biweekly' && $values['EntryInterval'] != 'daily' && $values['EntryInterval'] != 'semi_monthly'){
	echo $values['EntryDate'];

 }?> 

</td>

<td>



<? if($values['EntryInterval'] == "yearly"){ 
                        $monthNum  = $values['EntryMonth'];
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('F'); 
	echo $monthName;
  } else if($values['EntryInterval'] == "weekly" || $values['EntryInterval'] == "biweekly"){ 
	echo $values['EntryWeekly'];
  }
?>



</td>
 
<td>
<?php  if($values['EntryFrom']>0)echo date($Config['DateFormat'], strtotime($values['EntryFrom']));?>
</td>

<td>
<?php  if($values['EntryTo']>0)echo date($Config['DateFormat'], strtotime($values['EntryTo']));?>

</td>




                                       

                                    
                                    <td  align="center" class="head1_inner">

 <? if($ModifyLabel == 1){ ?>                                 
 <a class="fancybox fancybox.iframe" href="<?= $EditUrl . '&pop=1&edit=' . $values['activityID'] ?>" ><?= $edit ?></a>
                                                                           
 <a href="viewRecurringActivity.php?cancel_id=<?=$values['activityID']?>" onclick="return confirmAction(this, '<?= $ModuleName ?>','Are you sure you want to cancel this <?= $ModuleName ?>?')"><?= $cancel ?></a>                                      

<? } ?>


                                    </td>
                                </tr>
                            <?php 
$CustCode = $values['CustCode'];
} // foreach end // ?>

<?php }else { ?>
                            <tr align="center" >
                                <td  colspan="10" class="no_record"><?= NO_RECORD ?> </td>
                            </tr>
<?php } ?>

                        <tr>  <td  colspan="10"  id="td_pager">Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryActivity) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php
                                    echo $pagerLink;
                                }
                                ?></td>
                        </tr>
                    </table>

                </div> 


                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>

