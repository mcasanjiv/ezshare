
<script language="JavaScript1.2" type="text/javascript">
    function ValidateSearch() {
        document.getElementById("prv_msg_div").style.display = 'block';
        document.getElementById("preview_div").style.display = 'none';
    }
    function filterLead(id)
    {
        location.href = "viewContact.php?module=contact&customview=" + id;
        LoaderSearch();
    }
</script>
<div class="had">Call Detail</div>
<div class="message" align="center">
<? if (!empty($_SESSION['mess_social'])) {
    echo $_SESSION['mess_social']; ?>
	<script>
	
    parent.jQuery.fancybox.close();
    parent.location.reload(true);
	</script>
<? } ?>

</div>
<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
    <tr>
        <td  valign="top">
            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >                            
                                <td width="15%"  class="head1" >Date</td>
                                <td width="15%"  class="head1" >Destination</td>
                                <td width="20%"  class="head1" >Src. Channel</td>   
                                <td width="10%"  align="center"  class="head1 head1_action" >Status</td>
                            </tr>
                        <?php
                        if (is_object($allcalldetail) AND !empty($allcalldetail->total)) {
                            $flag = true;
                            $Line = 0;
                            foreach ($allcalldetail->cdrs as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;

                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">                                    
                                <td  ><?php echo $values[0];?></td>
                                <td  ><?php echo $values[2];?></td>
                                <td  ><?php echo !empty($values[7])?$values[7].' Sec':'';?></td>  
                                <td ><?php echo $values[5];?></td>

                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?> </table>

                </div> 
            </form>
        </td>
    </tr>
</table>
