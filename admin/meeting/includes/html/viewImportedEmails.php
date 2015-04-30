<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function filterLead(id)
    {
        location.href = "viewImportEmailId.php?module=email&customview=" + id;
        LoaderSearch();
    }
</script>
<div class="had">Manage Email Id</div>
<div class="message" align="center"><? if (!empty($_SESSION['mess_contact'])) {
    echo $_SESSION['mess_contact'];
    unset($_SESSION['mess_contact']);
} ?></div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


    <tr>
        <td align="right">

            <? if ($num > 0) { ?>
                <input type="button" class="export_button"  name="exp" value="Export To Excel" onclick="Javascript:window.location = 'export_contact.php?<?= $QueryString ?>';" />
                <input type="button" class="print_button"  name="exp" value="Print" onclick="Javascript:window.print();"/>
<? } ?>



            <a href="editImportEmailId.php" class="add">Add Email ID</a>


                <!--a href="viewImportEmailId.php?module=<?= $_GET['module'] ?>" class="grey_bt">View All</a-->


        </td>
    </tr>

    <tr>
        <td  valign="top">



            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <!--td width="10%"  class="head1" >Contact ID</td-->
                                <td width="15%"  class="head1" >Subject</td>
                                
                                <td width="6%"  align="center" class="head1" >Status</td>
                                
                            </tr>

                        <?php
                        if (is_array($arryEmailsList) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryEmailsList as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                        
                                      <td><?= stripslashes($values["Subject"]) ?></td>
                                      <td><?
                                          if($values["Status"]=='1')
                                           {
                                             echo "UNREAD";
                                           }
                                           else{
                                             echo "READ";
                                           }
                                          
                                          ?></td>
                  
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryEmailsList) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arryContact)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'AddID', 'editContact.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">
            </form>
        </td>
    </tr>
</table>
