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
    $(document).ready(function(){
		$(".to-block").hover(
		function() { 
			$(this).find("a").show(300);
		  },
		  function() {
			 // if($(this).attr('class')!='add-edit-email')
				$(this).find("a").hide();
		
		});
     });
</script>
<style>
<!--
.evenbg:HOVER,.oddbg:HOVER{  background-color: #efefef;}
.to-block a{
  display: none;
  position: absolute;
  background: #e9e9e9;
  padding: 5px 24px;
    margin-left: -1px;
    margin-top: -5px;
    color:#005dbd;
      border: 1px solid gray;
  border-radius: 5px;
  }
-->
</style>
<div class="had">Sent Emails</div>

<TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >


    
    <tr>
        <td  valign="top">



            <form action="" method="post" name="form1">
                <div id="prv_msg_div" style="display:none"><img src="<?= $MainPrefix ?>images/loading.gif">&nbsp;Searching..............</div>
                <div id="preview_div">

                    <table <?= $table_bg ?>>

                            <tr align="left"  >
                             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','AddID','<?= sizeof($arryContact) ?>');" /></td>-->
                                <!--td width="10%"  class="head1" >Contact ID</td-->
                                <td width="8%"  class="head1" >To</td>
                                <td width="26%"  align="center" class="head1" >Subject</td>
                                <td width="2%"  align="center" class="head1" ></td>
                                <td width="4%"  align="center"  class="head1 head1_action" >Date</td>
                            </tr>

                        <?php
                       
                        if (is_array($arrySentItems) && $num > 0) {
                            $flag = true;
                            $Line = 0;
                            foreach ($arrySentItems as $key => $values) {
                                $flag = !$flag;
                                $bgcolor = ($flag) ? ("#FAFAFA") : ("#FFFFFF");
                                $Line++;
                                $boldtext ='';
								if($values['Status']) $boldtext = "font-weight:bold;";
                                //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                                ?>
                                <tr align="left">
                                        
                                      <td style="<?=$boldtext?>"><?php 
                                      
                                      $total_recipient=explode(',',$values["Recipient"]);
                                      if(count($total_recipient) > 2)
                                      {
                                        echo "<span class=to-block>".$total_recipient[0]."</span>,<span class=to-block>".$total_recipient[1]."</span>...";  
                                      } 
                                      else{
                                      	$x = explode(",", $values["Recipient"]);
                                      	$i = 0;
                                      	foreach ($x as $emails){
                                      		if($i>0) echo ", ";
                                        	echo "<span class=to-block>".$emails."<a href='editImportContactList.php?pop=1&edit=".urlencode($emails)."' target='_blank' class='fancybox fancybox.iframe add'>Add/Edit Contact</a></span>";
                                      		$i++;
                                      	}
                                       
                                      }
                                       ?>
                                      
                                       </td>
                                      
                                      

                                      <td align="center" >
                                          <a href="viewEmail.php?ViewId=<?php echo $values["autoId"] ?>">
                                      <?php echo "<font style='font-weight:bold'>".stripslashes($values["Subject"])."</font> :-";
                                              if($countt_data=str_word_count($values["EmailContent"]) > 10)
                                              {    
                                               //echo (substr(stripslashes($values["EmailContent"]),0,10)).'....';
                                                  
                                                  for($j=0;$j>=5;$j++)
                                                  {
                                                     echo $content.=$countt_data[$j].' ';   
                                                  }
                                              }
                                              else {
                                                  
                                                  echo stripslashes($values["EmailContent"]);
                                              }
                                              
                                              ?>
                                          
                                          </a>   
                                      </td>
                                      <td align="center">
                                            
                                        <?php
                                        
                                          $select_attach="select count(AutoId) as CountAttach from importemailattachments where EmailRefId='".$values['autoId']."'";
                                          $data=mysql_fetch_array(mysql_query($select_attach));
                                          if($data[CountAttach] > 0)
                                          {
                                           echo "<img src='".$MainPrefix."../images/attachment_icon.png'>";
                                          }
                                         ?>
                                      </td>
                                        
        
                                <td  align="center" class="head1_inner" >
                                     <?php $values["ImportedDate"]; 
                                    
                                    echo date("F j, Y, g:i a",strtotime($values["ImportedDate"]));
                                     ?>
                                  </td>
                                </tr>
                            <?php } // foreach end //?>

<?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record"><?= NO_RECORD ?></td>
                            </tr>
<?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryContact) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
}
?></td>
                        </tr>
                    </table>

                </div> 
                <? if (sizeof($arrySentItems)) { ?>
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
