
<div class="right_box">
    <table width="100%"  border="0" cellpadding="0" cellspacing="0">
        <form name="form1" action="<?= $ActionUrl ?>"  method="post">

            <? if (!empty($_SESSION['mess_opp'])) { ?>
                <tr>
                    <td  align="center"  class="message"  >
                        <? if (!empty($_SESSION['mess_opp'])) {
                            echo $_SESSION['mess_opp'];
                            unset($_SESSION['mess_opp']);
                        } ?>	
                    </td>
                </tr>
<? } ?>

            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">




<? if ($_GET["tab"] == "Opportunity") { ?>
                            <tr>
                                <td colspan="4" align="left" class="head">Opprtunity Details</td>
                            </tr>


                            <tr>
                                <td  align="right"   class="blackbold"> Created Date : </td>
                                <td   align="left" >
                                    <?
                                    if ($arryOpportunity[0]['AddedDate'] > 0)
                                        echo date($Config['DateFormat'], strtotime($arryOpportunity[0]['AddedDate']));
                                    else
                                        echo NOT_SPECIFIED;
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td  align="right"   class="blackbold" width="25%">Opportunity Name  : </td>
                                <td   align="left" width="20%">
    <?= (!empty($arryOpportunity[0]['OpportunityName'])) ? ($arryOpportunity[0]['OpportunityName']) : (NOT_SPECIFIED) ?>
                                </td>

                                <td  align="right"   class="blackbold" width="25%"> Organization Name : </td>
                                <td   align="left" >
    <?= (!empty($arryOpportunity[0]['OrgName'])) ? ($arryOpportunity[0]['OrgName']) : (NOT_SPECIFIED) ?>
                                </td>
                            </tr>


                </tr>

                <tr>
                    <td  align="right"   class="blackbold"> Amount (<?=$arryOpportunity[0]['Currency']?>) :</td>
                    <td   align="left" >
<?= (!empty($arryOpportunity[0]['Amount'])) ? ($arryOpportunity[0]['Amount']) : (NOT_SPECIFIED) ?>

                    </td>

                    <td  align="right"   class="blackbold">  Expected Close Date : </td>
                    <td   align="left" >
                        <?php //echo date($Config['DateFormat'] , strtotime($arryOpportunity[0]["CloseDate"])); ?>   
    <?= (!empty($arryOpportunity[0]['CloseDate'])) ? (date($Config['DateFormat'], strtotime($arryOpportunity[0]["CloseDate"]))) : (NOT_SPECIFIED) ?></td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold"> Sales Stage : </td>
                    <td   align="left" >

    <?= (!empty($arryOpportunity[0]['SalesStage'])) ? ($arryOpportunity[0]['SalesStage']) : (NOT_SPECIFIED) ?>
                    </td>

                     <td  align="right"   class="blackbold"> Assigned To  : </td>
            <td   align="left" > <? if ($arryTicket[0]['AssignType'] == 'Group') { ?>
                        <?= $AssignName ?> <br>
                    <? } ?>
                <div> <? foreach ($arryAssignee as $values) {
                    ?>
                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values['EmpID'] ?>" ><?= $values['UserName'] ?></a>,
    <? } ?>
            </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">  Customer : </td>
                    <td   align="left" >
    <? if (!empty($arryCustomer[0]['FullName'])) { ?><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?= $arryCustomer[0]['CustCode'] ?>"><?= (stripslashes($arryCustomer[0]['FullName'])) ?> </a> <? } else {
        echo NOT_SPECIFIED; ?> <? } ?>	     

                    </td>

                    <td  align="right"   class="blackbold"> Lead Source  : </td>
                    <td   align="left" >
    <?= (!empty($arryOpportunity[0]['lead_source'])) ? ($arryOpportunity[0]['lead_source']) : (NOT_SPECIFIED) ?>


                    </td>
                </tr>
                <tr>
                    <td  align="right"   class="blackbold"> Next Step : </td>
                    <td   align="left" >
    <?= (!empty($arryOpportunity[0]['NextStep'])) ? ($arryOpportunity[0]['NextStep']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold">Opportunity Type  : </td>
                    <td   align="left" >
    <?= (!empty($arryOpportunity[0]['OpportunityType'])) ? ($arryOpportunity[0]['OpportunityType']) : (NOT_SPECIFIED) ?>

                    </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">Probability (%): </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['Probability'])) ? ($arryOpportunity[0]['Probability']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold">Campaign Source : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['Campaign_Source'])) ? ($arryOpportunity[0]['Campaign_Source']) : (NOT_SPECIFIED) ?>
                    </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">Forecast Amount (<?=$arryOpportunity[0]['Currency']?>) : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['forecast_amount'])) ? ($arryOpportunity[0]['forecast_amount']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold">Contact Name : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['ContactName'])) ? ($arryOpportunity[0]['ContactName']) : (NOT_SPECIFIED) ?>
                    </td>
                </tr>

                <tr>
                    <td  align="right"   class="blackbold">Website : </td>
                    <td   align="left" ><?= (!empty($arryOpportunity[0]['oppsite'])) ? ($arryOpportunity[0]['oppsite']) : (NOT_SPECIFIED) ?>
                    </td>

                    <td  align="right"   class="blackbold" 
                         >Status  : </td>
                    <td   align="left"  >
                        <?
                        if ($_REQUEST['view'] > 0) {
                            if ($arryOpportunity[0]['Status'] == 1) {
                                $ActiveChecked = ' Active';
                                $InActiveChecked = '';
                            }
                            if ($arryOpportunity[0]['Status'] == 0) {
                                $ActiveChecked = '';
                                $InActiveChecked = ' Inactive';
                            }
                        }
                        ?>
                <?= $ActiveChecked ?>

    <?= $InActiveChecked ?> 

                </tr>

                        <?
                        if (sizeof($arryLead) > 0) {

                            include_once("language/en_lead.php");
                            ?>


                    <tr>
                        <td  align="right"   class="blackbold"> Lead Date : </td>
                        <td   align="left" >
                            <?
                            if ($arryLead[0]['LeadDate'] > 0)
                                echo date($Config['DateFormat'], strtotime($arryLead[0]['LeadDate']));
                            else
                                echo NOT_SPECIFIED;
                            ?>
                        </td>
                        <td  align="right"   class="blackbold"> Last Contact Date : </td>
                        <td   align="left" >
        <?
        if ($arryLead[0]['LastContactDate'] > 0)
            echo date($Config['DateFormat'], strtotime($arryLead[0]['LastContactDate']));
        else
            echo NOT_SPECIFIED;
        ?>
                        </td>

                    </tr>
<tr>
                        <td  align="right"   class="blackbold"> Industry : </td>
                        <td   align="left" >
                            
                            <?= (!empty($arryLead[0]['Industry'])) ? (stripslashes($arryLead[0]['Industry'])) : (NOT_SPECIFIED) ?>
                            
                        </td>
</tr>

                    <tr>
                        <td colspan="4" align="left"   class="head"><?= LEAD_ADDRESS_DETAILS ?></td>
                    </tr>

                    <tr>
                        <td align="right"   class="blackbold" valign="top"><?= LEAD_STREET_ADDRESS ?> :</td>
                        <td  align="left" > <?= (!empty($arryLead[0]['Address'])) ? (stripslashes($arryLead[0]['Address'])) : (NOT_SPECIFIED) ?> </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> <?= LEAD_COUNTRY ?>   :</td>
                        <td   align="left" > <?= (!empty($CountryName)) ? (stripslashes($CountryName)) : (NOT_SPECIFIED) ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right" valign="middle"   class="blackbold"> <?= LEAD_STATE ?> :</td>
                        <td  align="left"  class="blacknormal"> <?= (!empty($StateName)) ? (stripslashes($StateName)) : (NOT_SPECIFIED) ?> </td>
                    </tr>


                    <tr>
                        <td  align="right"   class="blackbold"><?= LEAD_CITY ?>   :</td>
                        <td  align="left"  > <?= (!empty($CityName)) ? (stripslashes($CityName)) : (NOT_SPECIFIED) ?>  </td>
                    </tr> 


                    <tr>
                        <td align="right"   class="blackbold" ><?= LEAD_ZIP_CODE ?>  :</td>
                        <td  align="left"  > <?= (!empty($arryLead[0]['ZipCode'])) ? (stripslashes($arryLead[0]['ZipCode'])) : (NOT_SPECIFIED) ?>
                        </td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"><?= LEAD_LANDLINE ?>   :</td>
                        <td   align="left" >

        <?= (!empty($arryLead[0]['LandlineNumber'])) ? (stripslashes($arryLead[0]['LandlineNumber'])) : (NOT_SPECIFIED) ?>
                        </td>
                    </tr> 
                    <tr>
                        <td align="right"   class="blackbold" ><?= LEAD_MOBILE ?>  :</td>
                        <td  align="left"  > <?= (!empty($arryLead[0]['Mobile'])) ? (stripslashes($arryLead[0]['Mobile'])) : (NOT_SPECIFIED) ?>
                        </td>
                    </tr>

    <? } ?>


                <tr>
                    <td colspan="4" align="left"   class="head">Description</td>
                </tr>

                <tr>
                    <td align="right"   class="blackbold" valign="top">Description :</td>
                    <td  align="left" colspan="3" ><?= (!empty($arryOpportunity[0]['description'])) ? ($arryOpportunity[0]['description']) : (NOT_SPECIFIED) ?>


                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="left"   ><?php if ($_GET['pop'] != 1) {
        include("comment.php");
    } ?></td>
                </tr>	


<? } ?>





    </table>	








</td>
</tr>



</form>
</table>
</div>
<? if ($_GET['tab'] == "Event") { ?>



    <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >

    <? if (!empty($_SESSION['mess_Event'])) { ?>
            <tr>
                <td  align="center"  class="message"  >
        <? if (!empty($_SESSION['mess_Event'])) {
            echo $_SESSION['mess_Event'];
            unset($_SESSION['mess_Event']);
        } ?>	
                </td>
            </tr>
    <? } ?>
        <tr>
            <td align="right">

                <a class="fancybox fancybox.iframe add"  href="addActivity.php?module=Lead&parent_type=<?= $_GET['module'] ?>&parentID=<?= $_GET['view'] ?>" >Add Event</a>


            </td>
        </tr>



        <tr>
            <td  valign="top">
                <table <?= $table_bg ?>>

                    <tr align="left"  >
                     <!-- <td width="5%" class="head1" >
                <input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','activityID','<?= sizeof($arryActivity) ?>');" /></td>-->

                        <td width="15%"  class="head1" >Title</td>
                        <td width="13%" class="head1"> Activity Type </td>
                        <td width="12%" class="head1" >Priority</td>
                        <td width="19%" class="head1" > Start Date</td>
                        <td width="19%" class="head1" > Close Date</td>
                        <td width="11%"  align="center" class="head1" >  Status</td>
                        <td width="12%"  align="center" class="head1" >Action</td>
                    </tr>

    <?php
    if (is_array($arryActivity) && $num > 0) {
        $flag = true;
        $Line = 0;
        foreach ($arryActivity as $key => $values) {
            $flag = !$flag;
            #$bgcolor=($flag)?("#FDFBFB"):("");
            $Line++;

            //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
            ?>
                            <tr align="left"  bgcolor="<?= $bgcolor ?>">
                              <!--<td ><input type="checkbox" name="activityID[]" id="activityID<?= $Line ?>" value="<?= $values['activityID'] ?>" /></td>-->

                                <td height="22" > 
                                    <a class="fancybox fancybox.iframe" href="vActivity.php?view=<?= $values['activityID'] ?>&pop=1"> <? echo stripslashes($values["subject"]); ?></a> 	       </td>
                                <td><?= $values['activityType'] ?></td>
                                <td>
                            <?= (!empty($values['priority'])) ? (stripslashes($values['priority'])) : (NOT_SPECIFIED) ?>
                                </td>

                                <td>
            <?php
            $stdate = $values["startDate"] . " " . $values["startTime"];
            echo date($Config['DateFormat'] . " H:i A", strtotime($stdate));
            ?>
                                </td>
                                <td>
            <?php
            $cldate = $values["closeDate"] . " " . $values["closeTime"];
            echo date($Config['DateFormat'] . " H:i A", strtotime($cldate));
            ?>
                                </td>
                                <td align="center"><? $status = $values['status'];
            echo $status; ?></td>
                                <td  align="center" >
                                    <a href="vOpportunity.php?act_id=<?php echo $values['activityID']; ?>&view=<?= $_GET['view'] ?>&module=<?php echo $_GET['module']; ?>&amp;curP=<?php echo $_GET['curP']; ?>&tab=Event" onclick="return confirmDialog(this, 'Event')"  ><?= $delete ?></a> </td>
                            </tr>
        <?php } // foreach end // ?>

    <?php } else { ?>
                        <tr align="center" >
                            <td  colspan="9" class="no_record">No record found. </td>
                        </tr>
    <?php } ?>

                    <tr>  
                        <td  colspan="9" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryActivity) > 0) { ?>&nbsp;&nbsp;&nbsp; Page(s) :&nbsp; <?php echo $pagerLink;
    } ?></td>
                    </tr>
                </table> 
            </td>
        </tr>  
    </TABLE>

<? } ?>










<? if ($_GET['tab'] == "Campaign") { ?>

    <div id="preview_div">

        <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
            <tr>
                <td align="right">
                    <a class="button" style="font-size:12px; color:#FFFFFF;" href="#" onclick="return window.open('leadCompaign.php?module=<?= $_GET['tab'] ?>&amp;return_module=<?= $_GET['module'] ?>&amp;parent_type=<?= $_GET['module'] ?>&amp;parentID=<?= $_GET['view'] ?>', 'test', 'width=640,height=602,resizable=0,scrollbars=0');" ><b>Select Campaign</b></a>




                </td>
            </tr>



            <tr>
                <td  valign="top">
                    <table <?= $table_bg ?>>



             <!-- <td width="0%" class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','CampaignID','<?= sizeof($arryCampaign) ?>');" /></td>-->
                        <td width="18%"  class="head1" >Campaign Name</td>
                        <td width="14%"  class="head1" >Campaign Type</td>
                        <td width="12%"  class="head1" >Campaign Status</td>
                        <td width="12%" class="head1" >Expected Revenue</td>
                        <td width="13%" class="head1" >Expected Close Date</td>

                        <td width="16%"  align="center" class="head1" >Assign To</td>
                        <td width="15%"  align="center" class="head1" >Action</td>
            </tr>

                    <?php
                    if (is_array($arryCampaign) && $num > 0) {
                        $flag = true;
                        $Line = 0;
                        foreach ($arryCampaign as $key => $values) {
                            $flag = !$flag;
                            #$bgcolor=($flag)?("#FDFBFB"):("");
                            $Line++;

                            //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
                            ?>
                    <tr align="left"  bgcolor="<?= $bgcolor ?>">
                     <!-- <td ><input type="checkbox" name="CampaignID[]" id="CampaignID<?= $Line ?>" value="<?= $values['campaignID'] ?>" /></td>-->
                        <td ><?= stripslashes($values["campaignname"]) ?></td>
                        <td height="20" > <?= stripslashes($values["campaigntype"]) ?>	 </td>
                        <td height="20" > <?= stripslashes($values["campaignstatus"]) ?>	 </td>

                        <td><?= $values['expectedrevenue'] ?> <?= $Config['Currency'] ?></td>
                        <td height="20" > 
                    <? if ($values["closingdate"] != "0000-00-00") {//echo $Config['DateFormat'];
                        echo date($Config['DateFormat'], strtotime($values["closingdate"]));
                    }
                    ?> </td>

                        <td><a class="fancybox fancybox.iframe" href="../hrms/empInfo.php?view=<?= $values["EmpID"] ?>">

            <?= $values['AssignTo'] ?></a></td>


                        <td  align="center"  >
                            <a href="vCampaign.php?view=<?= $values['campaignID'] ?>&module=Campaign&curP=<?= $_GET['curP'] ?>" ><?= $view ?></a>

                            <a href="editCampaign.php?edit=<?php echo $values['campaignID']; ?>&module=Campaign&amp;curP=<?php echo $_GET['curP']; ?>&tab=Edit" ><?= $edit ?></a>

                            <a href="vOpportunity.php?view=<?= $_GET['view'] ?>&select_del_id=<?php echo $values['sid']; ?>&module=<?= $_GET['module'] ?>&amp;curP=<?php echo $_GET['curP']; ?>&tab=<?= $_GET['tab'] ?>" onclick="return confirmDialog(this, '<?= stripslashes($values["campaignname"]) ?>')"  ><?= $delete ?></a>   </td>
                    </tr>
        <?php } // foreach end //?>

    <?php } else { ?>
                <tr align="center" >
                    <td  colspan="8" class="no_record">No record found. </td>
                </tr>
    <?php } ?>

            <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryCampaign) > 0) { ?>
                        &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
    }
    ?></td>
            </tr>
        </table>      </td>
    </tr>

    </TABLE>

    </div> 
<? } ?>

<? if ($_GET['tab'] == 'Comments') {
    include("comment.php");
} ?>

<? if ($_GET['tab'] == 'Ticket') { ?>


    <div id="prv_msg_div" style="display:none"><img src="images/loading.gif"> Searching..............</div>
    <div id="preview_div">
        <TABLE WIDTH="100%"   BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
            <tr>
                <td align="right">

                    <a href="editTicket.php?module=Ticket&parent_type=<?= $_GET['module'] ?>&parentID=<?= $arryOpportunity[0]['OpportunityID'] ?>&mode_type=<?= $_GET['module'] ?>" class="add" >Add  Ticket</a>
                    <a class="red_bt" style="display: inline-block;" href="#" onclick="return window.open('leadCompaign.php?module=<?= $_GET['tab'] ?>&amp;return_module=<?= $_GET['module'] ?>&amp;parent_type=<?= $_GET['module'] ?>&amp;parentID=<?= $_GET['view'] ?>', 'test', 'width=640,height=602,resizable=0,scrollbars=0');" >Select Ticket</a>




                </td>
            </tr>



            <tr>
                <td  valign="top">

                    <table <?= $table_bg ?>>

                        <tr align="left"  >
                          <!--<td width="0%"  class="head1" ><input type="checkbox" name="SelectAll" id="SelectAll" onclick="Javascript:SelectCheckBoxes('SelectAll','TicketID','<?= sizeof($arryTicket) ?>');" /></td>-->
                            <td width="13%"  class="head1" >Ticket ID</td>
                            <td width="25%"  class="head1" >Title</td>
                            <td width="14%" class="head1" > Add Date</td>
                            <td width="16%" class="head1" > Assign To</td>

                            <td width="12%"  align="center" class="head1" >Status</td>
                            <td width="20%"  align="center" class="head1 head1_action" >Action</td>
                        </tr>

    <?php
    if (is_array($arryTicket) && $num > 0) {
        $flag = true;
        $Line = 0;
        foreach ($arryTicket as $key => $values) {
            $flag = !$flag;
            #$bgcolor=($flag)?("#FDFBFB"):("");
            $Line++;

            //if($values['ExpiryDate']<=0 || $values['Status']<=0){ $bgcolor="#000000"; }
            ?>
                                <tr align="left"  bgcolor="<?= $bgcolor ?>">
                                 <!-- <td ><input type="checkbox" name="TicketID[]" id="TicketID<?= $Line ?>" value="<?= $values['TicketID'] ?>" /></td>-->
                                    <td ><?= $values["TicketID"] ?></td>
                                    <td > 
                                <?
                                echo stripslashes($values['title']);
                                ?>		       </td>
                                    <td> <? echo date($Config['DateFormat'], strtotime($values["ticketDate"])); ?></td>

                                    <td>
                                        <a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $values["EmpID"] ?>"><?= $values['AssignTo'] ?></a>


                                    </td>

                                    <td align="center">



            <? echo $values['Status'];
            ?></td>
                                    <td  align="center"  ><a href=" vTicket.php?view=<? echo $values['TicketID'] ?>&module=<?php echo $_GET['tab']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information" ><?= $view ?></a>&nbsp;   
                                        &nbsp;&nbsp; <a href="editTicket.php?module=Ticket&edit=<?php echo $values['TicketID']; ?>&curP=<?php echo $_GET['curP']; ?>&tab=Information" ><?= $edit ?></a>

                                        &nbsp;&nbsp;<a href="vOpportunity.php?view=<?php echo $_GET["view"]; ?>&select_del_id=<?php echo $values['sid']; ?>&module=<?= $_GET['module'] ?>&amp;curP=<?php echo $_GET['curP']; ?>&tab=<?= $_GET['tab'] ?>" onclick="return confirmDialog(this, '<?= $ModuleName ?>')"  ><?= $delete ?></a>   </td>
                                </tr>
        <?php } // foreach end // ?>

    <?php } else { ?>
                            <tr align="center" >
                                <td  colspan="8" class="no_record">No record found. </td>
                            </tr>
    <?php } ?>

                        <tr >  <td  colspan="8" >Total Record(s) : &nbsp;<?php echo $num; ?>      <?php if (count($arryTicket) > 0) { ?>
                                    &nbsp;&nbsp;&nbsp;     Page(s) :&nbsp; <?php echo $pagerLink;
    }
    ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </TABLE>

    </div> 

            <? } ?>



<?
if ($_GET["tab"] == "Lead") {

    if (!empty($arryOpportunity[0]["LeadID"])) {

        include_once("language/en_lead.php");
        ?>

        <table width="100%" id="table4"   border="0" cellpadding="5" cellspacing="0" class="borderall">
            <tr>
                <td  colspan="4" align="left" class="head"><?= LEAD_DETAIL ?></td>

            </tr>

            <tr>
                <td  align="right"   class="blackbold"> Created Date : </td>
                <td   align="left" >
        <?
        if ($arryLead[0]['UpdatedDate'] > 0)
            echo date($Config['DateFormat'], strtotime($arryLead[0]['UpdatedDate']));
        else
            echo NOT_SPECIFIED;
        ?>
                </td>
            </tr>
            <tr>
                <td  align="right"   class="blackbold" ><?= LEAD_TYPE ?> : </td>
                <td   align="left" > <?= (!empty($arryLead[0]['type'])) ? (stripslashes($arryLead[0]['type'])) : (NOT_SPECIFIED) ?> </td>

        <? if ($arryLead[0]['type'] != 'Individual') { ?>

                    <td  align="right"   class="blackbold"> <?= LEAD_COMPANY ?>: </td>
                    <td   align="left" > <?= (!empty($arryLead[0]['company'])) ? (stripslashes($arryLead[0]['company'])) : (NOT_SPECIFIED) ?>
                    </td>


        <? } ?>



            </tr>
            <tr>
                <td  align="right"   class="blackbold" width="25%"> <?= LEAD_FIRST_NAME ?>   : </td>
                <td   align="left" width="20%"> <?= (!empty($arryLead[0]['FirstName'])) ? (stripslashes($arryLead[0]['FirstName'])) : (NOT_SPECIFIED) ?></td>

                <td  align="right"   class="blackbold" width="25%"> <?= LEAD_LAST_NAME ?>   :</td>
                <td   align="left" > <?= (!empty($arryLead[0]['LastName'])) ? (stripslashes($arryLead[0]['LastName'])) : (NOT_SPECIFIED) ?> </td>
            </tr>

            <tr>
                <td  align="right"   class="blackbold"> <?= LEAD_PRIMARY_EMAIL ?> : </td>
                <td   align="left" > <?= (!empty($arryLead[0]['primary_email'])) ? ($arryLead[0]['primary_email']) : (NOT_SPECIFIED) ?> </td>

                <td  align="right"   class="blackbold"> Title  : </td>
                <td   align="left" > <?= (!empty($arryLead[0]['designation'])) ? (stripslashes($arryLead[0]['designation'])) : (NOT_SPECIFIED) ?> </td>
            </tr>

            <tr>
                <td  align="right"   class="blackbold"> <?= LEAD_PRODUCT ?> : </td>
                <td   align="left" > <?= (!empty($arryLead[0]['ProductID'])) ? (stripslashes($arryLead[0]['ProductID'])) : (NOT_SPECIFIED) ?>
                </td>

                <td  align="right"   class="blackbold">  <?= LEAD_PRODUCT ?> <?= LEAD_PRICE ?>  (<?=$arryLead[0]['Currency']?>)  : </td>
                <td   align="left" > <?= (!empty($arryLead[0]['product_price'])) ? ($arryLead[0]['product_price']) : (NOT_SPECIFIED) ?>
                </td>
            </tr>

            <tr>
                <td  align="right"   class="blackbold"> <?= LEAD_WEBSITE ?> : </td>
                <td   align="left" > <?= (!empty($arryLead[0]['Website'])) ? ($arryLead[0]['Website']) : (NOT_SPECIFIED) ?>
                </td>

                <td  align="right"   class="blackbold"> <?= LEAD_INDUSTRY ?> : </td>
                <td   align="left" ><?= (!empty($arryLead[0]['Industry'])) ? ($arryLead[0]['Industry']) : (NOT_SPECIFIED) ?>

                </td>
            </tr>

            <tr>
                <td  align="right"   class="blackbold"> <?= LEAD_ANNUAL_REVENUE ?> (<?=$arryLead[0]['Currency']?>) : </td>
                <td   align="left" ><?= (!empty($arryLead[0]['AnnualRevenue'])) ? ($arryLead[0]['AnnualRevenue']) : (NOT_SPECIFIED) ?>

                </td>

                <td  align="right"   class="blackbold"> Number of Employees : </td>
                <td   align="left" >
        <?= (!empty($arryLead[0]['NumEmployee'])) ? ($arryLead[0]['NumEmployee']) : (NOT_SPECIFIED) ?>
                </td>
            </tr>



            <tr>
                <td  align="right"   class="blackbold"> <?= LEAD_SOURCE ?>  : </td>
                <td   align="left" ><?= (!empty($arryLead[0]['lead_source'])) ? (stripslashes($arryLead[0]['lead_source'])) : (NOT_SPECIFIED) ?>

                </td>

                <td  align="right"   class="blackbold"> <?= LEADSTATUS ?> : </td>
                <td   align="left" ><?= (!empty($arryLead[0]['lead_status'])) ? ($arryLead[0]['lead_status']) : (NOT_SPECIFIED) ?> </td>
            </tr>

            <tr>

                <!--tr style="display:none1;">
                       <td  align="right"   class="blackbold">  <?= LEAD_ASSIGN_TO ?>  : </td>
                       <td   align="left" >
                               
        <? if (!empty($arrySupervisor[0]['UserName'])) { ?><a class="fancybox fancybox.iframe" href="../userInfo.php?view=<?= $arrySupervisor[0]['EmpID'] ?>"><?= stripslashes($arrySupervisor[0]['UserName']) ?> </a> <? } else {
            echo NOT_SPECIFIED; ?> <? } ?>
                               
                                </td>
                     </tr-->


            <tr>
                <td  align="right"   class="blackbold"> Lead Date : </td>
                <td   align="left" >
        <?
        if ($arryLead[0]['LeadDate'] > 0)
            echo date($Config['DateFormat'], strtotime($arryLead[0]['LeadDate']));
        else
            echo NOT_SPECIFIED;
        ?>
                </td>
                <td  align="right"   class="blackbold"> Last Contact Date : </td>
                <td   align="left" >
        <?
        if ($arryLead[0]['LastContactDate'] > 0)
            echo date($Config['DateFormat'], strtotime($arryLead[0]['LastContactDate']));
        else
            echo NOT_SPECIFIED;
        ?>
                </td>

            </tr>



            <tr>


            <tr>
                <td colspan="4" align="left"   class="head"><?= LEAD_ADDRESS_DETAILS ?></td>
            </tr>

            <tr>
                <td align="right"   class="blackbold" valign="top"><?= LEAD_STREET_ADDRESS ?> :</td>
                <td  align="left" > <?= (!empty($arryLead[0]['Address'])) ? (stripslashes($arryLead[0]['Address'])) : (NOT_SPECIFIED) ?> </td>
            </tr>

            <tr>
                <td  align="right"   class="blackbold"> <?= LEAD_COUNTRY ?>   :</td>
                <td   align="left" > <?= (!empty($CountryName)) ? (stripslashes($CountryName)) : (NOT_SPECIFIED) ?>
                </td>
            </tr>
            <tr>
                <td  align="right" valign="middle"   class="blackbold"> <?= LEAD_STATE ?> :</td>
                <td  align="left"  class="blacknormal"> <?= (!empty($StateName)) ? (stripslashes($StateName)) : (NOT_SPECIFIED) ?> </td>
            </tr>


            <tr>
                <td  align="right"   class="blackbold"><?= LEAD_CITY ?>   :</td>
                <td  align="left"  > <?= (!empty($CityName)) ? (stripslashes($CityName)) : (NOT_SPECIFIED) ?>  </td>
            </tr> 


            <tr>
                <td align="right"   class="blackbold" ><?= LEAD_ZIP_CODE ?>  :</td>
                <td  align="left"  > <?= (!empty($arryLead[0]['ZipCode'])) ? (stripslashes($arryLead[0]['ZipCode'])) : (NOT_SPECIFIED) ?>
                </td>
            </tr>
            <tr>
                <td  align="right"   class="blackbold"><?= LEAD_LANDLINE ?>   :</td>
                <td   align="left" >

        <?= (!empty($arryLead[0]['LandlineNumber'])) ? (stripslashes($arryLead[0]['LandlineNumber'])) : (NOT_SPECIFIED) ?>
                </td>
            </tr> 
            <tr>
                <td align="right"   class="blackbold" ><?= LEAD_MOBILE ?>  :</td>
                <td  align="left"  > <?= (!empty($arryLead[0]['Mobile'])) ? (stripslashes($arryLead[0]['Mobile'])) : (NOT_SPECIFIED) ?>
                </td>
            </tr>









            <tr>
                <td colspan="4" align="left"   class="head"><?= LEAD_DESCRIPTION ?></td>
            </tr>	



            <tr>
                <td align="right"   class="blackbold" valign="top"><?= LEAD_DESCRIPTION ?> :</td>
                <td  align="left" colspan="3"> <?= (!empty($arryLead[0]['description'])) ? (stripslashes($arryLead[0]['description'])) : (NOT_SPECIFIED) ?>
                </td>
            </tr>




        </table>
    <? }else { ?>
        <table width="100%" id="table4"   border="0" cellpadding="5" cellspacing="0" class="borderall">
            <tr>
                <td align="left" colspan="4"   class="blackbold" valign="top"><font color="#990000">There is no Lead related with Opportunity.</font></td>

            </tr>
        </table>

    <? }
} ?> 

<?
if ($_GET['tab'] == "Document") {
    include("document.php");
}
?>











