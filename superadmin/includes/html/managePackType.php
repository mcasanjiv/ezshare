<script language="JavaScript1.2" type="text/javascript">

	function ValidateSearch(SearchBy){	
		document.getElementById("prv_msg_div").style.display = 'block';
		document.getElementById("preview_div").style.display = 'none';
		/*
		  var frm  = document.form1;
		  var frm2 = document.form2;
		   if(SearchBy==1)  { 
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
		   } else	if(ValidateForBlank(frm2.Keyword, "keyword")){		
			   location.href = 'viewLicense.php?curP='+frm.CurrentPage.value+'&sortby='+frm2.SortBy.value+'&asc='+frm2.Asc.value+'&key='+escape(frm2.Keyword.value);
			}
			return false;
			*/
	}
</script>

<div class="message" align="center"><? if(!empty($_SESSION['mess_license'])) {echo $_SESSION['mess_license']; unset($_SESSION['mess_license']); }?></div>

 <?php include('siteManagementMenu.php');?>

    <div class="clear"></div> 

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <div class="message"><? if (!empty($_SESSION['mess_Page'])) {
    echo stripslashes($_SESSION['mess_Page']);
    unset($_SESSION['mess_Page']);
} ?></div>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" align="center">
                <tr>
                    <td width="61%" height="32">&nbsp;</td>
                    <td width="39%" align="right"> <a href="addPackType.php" class="add">Add Package Type</a>      </td>
                </tr>

            </table>

            <table <?= $table_bg ?>>
                <tr align="left" >
                    <td width="20%" height="20"  class="head1">Name</td> 
                    
                    <td  width="10%" height="20"  class="head1" align="center">Status</td>
                    <td width="5%"   height="20" align="right" class="head1">Action&nbsp;&nbsp;</td>
                </tr>
                <?php
                $pagerLink = $objPager->getPager($arryPages, $RecordsPerPage, $_GET['curP']);
                (count($arryShipingMethod) > 0) ? ($arryPages = $objPager->getPageRecords()) : ("");
                if (is_array($arryPages) && $num > 0) {
                    $flag = true;

                    foreach ($arryPages as $key => $values) {
                    	//echo "<pre>";print_r($values);
                        ?>
                        <tr align="left"  bgcolor="<?= $bgcolor ?>">
                            <td height="26"><?= $values['name']; ?>     </td>
                         
                          
                            <td align="center" ><?
                        if ($values['Status'] == "Yes") {
                            $status = 'Active';
                        } else {
                            $status = 'InActive';
                        }


                        echo '<a href="addPackType.php?active_id=' . $values["id"] . '&curP=' . $_GET["curP"] . '" class="' . $status . '">' . $status . '</a>';
                        ?>
                            </td>
                            <td height="26" align="right"  valign="top">
                                <a href="addPackType.php?edit=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" class="Blue"><?= $edit ?></a>
                                <a href="addPackType.php?del_id=<?php echo $values['id']; ?>&curP=<?php echo $_GET['curP']; ?>" onclick="return confDel('<?= $cat_title ?>')" class="Blue" ><?= $delete ?></a>              
                                &nbsp;
                            </td>
                        </tr>
                    <?php } // foreach end //?>
<?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="4"  class="no_record">No Pages found. </td>
                    </tr>
<?php } ?>

                <tr>  
                    <td height="20" colspan="4" >Total Record(s) : &nbsp;<?php echo $num; ?>    
<?php if (count($arryShipingMethod) > 0) { ?>&nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
} ?>       
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
        

  