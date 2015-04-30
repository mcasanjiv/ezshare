<?php  
$HideNavigation = 1;
require_once("includes/header.php");
$objMeeting=new Meeting();
	$ModuleName = "Meeting";
	
if (!empty($_GET['view'])) { 
	$arryAttendee = $objMeeting->getAttendees($_GET['view']);
	
	$num=$objMeeting->numRows();
	$pagerLink=$objPager->getPager($arryAttendee,$RecordsPerPage,$_GET['curP']);
    if (empty($arryAttendee[0]['meetingId'])) {
    	$_SESSION['mess_meeting'] = "Meeting Detail Does Not exist for this meeting!";
       $x = "dashboard.php";
		echo '<script language="javascript">window.parent.location.href="'.$x.'"</script>';
		exit;
    }
}   
    
?>
                                              

			<div id="preview_div">
			       <div class="had">Meeting Details</div> 
                    <table width="100%" align="center" cellpadding="3" cellspacing="1" id="list_table">
                            <tbody>
                            <tr align="left">
                                <td width="10%"  class="head1" >S.No</td-->
                                <td class="head1" width="30%">Name</td>
                                <td width="30%" class="head1">Email</td>
                                <td width="30%" align="center" class="head1"> Time</td>
                            </tr>
                             <?php 
	                       if (is_array($arryAttendee) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arryAttendee as $key => $values) {
                                $flag = !$flag;
                                $Line++; 
	                         ?> 
                                <tr align="left" bgcolor="#FFFFFF" class="evenbg">     
           
                                        <td><?= $Line ?></td>
                                        <td><?= stripslashes($values["Name"]) ?> </td>
                                        <td><?= stripslashes($values["Email"]) ?></td>
                                        <td><span class="red"><?= stripslashes($values["createTime"]) ?></span></td>
                                </tr>
                                     
                                
                                  <?php } // foreach end //?>
                                 <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
                          <?php } ?>

                        <tr >
                        <td  colspan="11" >Total Record(s) : &nbsp;<?php echo $num; ?>    
                          <?php if (count($arryAttendee) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; 
                                   <span class="pagenumber"><b> <?php echo $pagerLink;}?></b></span></td>
                        </tr>
                    </tbody></table>

                </div>
 <script language="javascript1.2" type="text/javascript">
if(document.getElementById("load_div") != null){
	document.getElementById("load_div").style.display = 'none';
}
</script>	   