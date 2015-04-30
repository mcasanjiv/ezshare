<body>
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {
    $('#selecctall').click(function(event) {  //on click
        if(this.checked) { // check select status
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.checkbox1').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });
   
});

</script>

<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>
<a href="viewchimpSegment.php" class="fancybox add_quick">List Segment</a>
<div class="had">Create Segment </div>

<div>
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
	
  
<tr>
<td align="left" valign="top">
 <form name="form1" action=""  method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

			<? if (!empty($_SESSION['message'])) {?>
			<tr>
			<td  align="center"  class="message"  >
			<? if(!empty($_SESSION['message'])) {echo $_SESSION['message']; unset($_SESSION['message']); }?>	
			</td>
			</tr>
			<? } ?>
  
		<tr>
			<td  align="center" valign="top" >
			<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
			<tr>
			<td colspan="2" align="left"  class="head" >Segment Information</td>
			</tr>
			<tr>
			<td  align="right" width="40%"   class="blackbold">Segment Name: </td>
			<td   align="left" >
			<input name="name" type="text" class="inputbox" id="title" value="<?php echo !empty($_POST['name'])?$_POST['name']:'';?>"/></td>
			</tr>
			
			<tr>
			<td  colspan="2" align="left" class="head"> Select User </td>
			</tr>
			<tr>
            <td  valign="top" colspan="2">
                <div id="prv_msg_div" style="display:none"><img src="images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">
                    <table <?= $table_bg ?>>
						<tr align="left"  >
						<td width="10%"  align="center" class="head1 head1_action" >
						   <input type="checkbox" id="selecctall" value=""></td>
							<td width="11%" class="head1">First Name</td>  
							<td width="9%" class="head1">Last Name</td>								
							<td width="9%" class="head1">Email</td> 
							<td width="11%" align="center" class="head1" >Created Date</td>
							<td width="11%" align="center" class="head1" >Status</td>
							
						</tr>
<?    //echo "<pre>";print_r($ChimpUserList);die;
                        if (is_array($ChimpUserList) && $num > 0) {
                            $flag = true;
                            $Line = 0;file:///home/linux1/Downloads/bsk-pdf-manager/js/bsk_pdf_manager_admin.js

                            $LeadNo = 0;
                            $LeadNo = ($_GET['curP'] - 1) * $RecordsPerPage;
                            foreach($ChimpUserList as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $LeadNo++;
                            ?>
							<tr align="left"  bgcolor="<?= $bgcolor ?>"> 
							<td width="10%"  align="center" >
							  <input type="checkbox"  value="<? echo $values['euid']; ?>" class="checkbox1" name="check[]"></td> 
							 <td><?= (!empty($values['fname'])) ? (stripslashes($values['fname'])) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($values['lname'])) ? (stripslashes($values['lname'])) : (NOT_SPECIFIED) ?> </td>
							 <td><?= (!empty($values['email'])) ? (stripslashes($values['email'])) : (NOT_SPECIFIED) ?> </td>		
							<td align="center">
							<?= (!empty($values['create_date'])) ? (date('m-d-Y h:i:s',strtotime(stripslashes($values['create_date'])))) : (NOT_SPECIFIED) ?>		
							</td>
							<td><?= (!empty($values['status'])) ? (stripslashes($values['status'])) : (NOT_SPECIFIED) ?> </td>	
							
							</tr>
                           <?php } // foreach end //?>

                          <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="11" class="no_record">No record found. </td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($ChimpUserList) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
		<? if (sizeof($ChimpUserList)) { ?>
                    <table width="100%" align="center" cellpadding="3" cellspacing="0" style="display:none">
                        <tr align="center" > 
                            <td height="30" align="left" ><input type="button" name="DeleteButton" class="button"  value="Delete" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'delete', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');">
                                <input type="button" name="ActiveButton" class="button"  value="Active" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'active', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" />
                                <input type="button" name="InActiveButton" class="button"  value="InActive" onclick="javascript: ValidateMultipleAction('<?= $ModuleName ?>', 'inactive', '<?= $Line ?>', 'leadID', 'editLead.php?curP=<?= $_GET[curP] ?>&opt=<?= $_GET[opt] ?>');" /></td>
                        </tr>
                    </table>
			<? } ?>  

                <input type="hidden" name="CurrentPage" id="CurrentPage" value="<?php echo $_GET['curP']; ?>">
                <input type="hidden" name="opt" id="opt" value="<?php echo $ModuleName; ?>">

                <input type="hidden" name="NumField" id="NumField" value="<?= sizeof($ChimpUserList) ?>">

            </td>
        </tr>
			</table>	
			</td>
		</tr>
		 

		<tr>
			<td  align="center" >
			<div id="SubmitDiv" style="display:none1">
			<input name="Submit" type="submit" class="button" id="SubmitButton" value="Submit" />
			</div>
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
</div>
