 
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>

<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script language="JavaScript1.2" type="text/javascript">

    function SendEventExistRequest(Url) {
        var SendUrl = Url + "&r=" + Math.random();
        httpObj.open("GET", SendUrl, true);
        httpObj.onreadystatechange = function RecieveEventRequest() {
            if (httpObj.readyState == 4) {


                if (httpObj.responseText == 1) {
                    alert("Subject already exists in database. Please enter another.");
                    document.getElementById("subject").select();
                    return false;
                } else if (httpObj.responseText == 2) {
                    alert("event date already exists in database. Please enter another.");
                    return false;
                } else if (httpObj.responseText == 0) {
                    document.forms[0].submit();
                } else {
                    alert("Error occur : " + httpObj.responseText);
                    return false;
                }
            }
        };
        httpObj.send(null);
    }



    function validateEvent(frm) {

        var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;	
        
          if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                    
                     if(EntryFrom >= EntryTo) {
                      document.getElementById("EntryFrom").focus();   
                      alert("End Date Should be Greater Than Start Date.");
                      return false;
                     }
                }

        if (ValidateForSimpleBlank(frm.subject, "Subject") 
                //&& ValidateRadioButtons(frm.assign, "Assign To")
            && ValidateForSimpleBlank(frm.startDate, "Start Date")) {
        /*    var AssignUser = document.getElementById('assign1').checked;
            var AssignGroup = document.getElementById('assign2').checked;

            if (AssignUser == true) {


                if (document.getElementById('AssignToUser').value == '') {

                    alert("Please Enter Assign User Name.");
                    document.getElementById('AssignToUser').focus();
                    return false;
                }
            } else if (AssignGroup == true) {
                if (document.getElementById('AssignToGroup').value == '') {

                    alert("Please Select Assign Group.");
                    document.getElementById('AssignToGroup').focus();
                    return false;
                }


            }*/


            if (ValidateForSimpleBlank(frm.startTime, "Start time")
                    && ValidateForSimpleBlank(frm.closeDate, "Close Date")
                    && ValidateForSimpleBlank(frm.closeTime, "Close time")
                    && ValidateForSelect(frm.status, "Status")
                    && ValidateForSelect(frm.activityType, "Activity Type")
                    //&& ValidateForSelect(frm.EmpID,"Invite Users")


                    //&& ValidateForTextareaMand(frm.street_address,"Street Address",10,300)bs
                    //&& isZipCode(frm.ZipCode)
                    //&& ValidatePhoneNumber(frm.Mobile,"Mobile Number",10,20)


                    ) {




                if (frm.closeDate.value < frm.startDate.value) {
                    alert("Close Date should be greater than Start Date.");
                    return false;
                }

              


                var Url = "isRecordExists.php?EventSubject=" + escape(document.getElementById("subject").value) + "&editID=" + document.getElementById("activityID").value + "&startDate=" + document.getElementById("startDate").value + "&closeDate=" + document.getElementById("closeDate").value + "&startTime=" + document.getElementById("startTime").value + "&closeTime=" + document.getElementById("closeTime").value + "&Type=" + document.getElementById("activity_type").value;


                //SendEventExistRequest(Url);
                //alert(Url);

                return true;

            } else {
                return false;
            }
            return false;
        } else {
            return false;
        }

    }


    function validateTask(frm) {


        var EntryType = Trim(document.getElementById("EntryType")).value;
        var EntryFrom = Trim(document.getElementById("EntryFrom")).value;
        var EntryTo = Trim(document.getElementById("EntryTo")).value;	
        
          if(EntryType == "recurring")
		{
                    if(!ValidateForSelect(frm.EntryFrom, "Entry From")){        
                      return false;
                    }

                    if(!ValidateForSelect(frm.EntryTo, "Entry To")){        
                        return false;
                    }
                    
                     if(EntryFrom >= EntryTo) {
                      document.getElementById("EntryFrom").focus();   
                      alert("End Date Should be Greather Than Start Date.");
                      return false;
                     }
                }
        if (ValidateForSimpleBlank(frm.subject, "Subject")
                //&& ValidateRadioButtons(frm.assign, "Assign To")
         && ValidateForSimpleBlank(frm.startDate, "Start Date")) {

          /*   var AssignUser = document.getElementById('assign1').checked;
            var AssignGroup = document.getElementById('assign2').checked;

           if (AssignUser == true) {


                if (document.getElementById('AssignToUser').value == '') {

                    alert("Please Enter Assign User Name.");
                    document.getElementById('AssignToUser').focus();
                    return false;
                }
            } else if (AssignGroup == true) {
                if (document.getElementById('AssignToGroup').value == '') {

                    alert("Please Select Assign Group.");
                    document.getElementById('AssignToGroup').focus();
                    return false;
                }


            }*/




            if (ValidateForSimpleBlank(frm.startTime,"Start time") 
&& ValidateForSimpleBlank(frm.closeDate, " Close Date")
                    && ValidateForSimpleBlank(frm.closeTime, " Close time")
                    && ValidateForSelect(frm.status, "Status")



                    ) {
                if (frm.closeDate.value < frm.startDate.value) {
                    alert("Start Date should not be greater than Closed Date.");
                    frm.startDate.focus();
                    return false;
                }

               

                var Url = "isRecordExists.php?EventSubject=" + escape(document.getElementById("subject").value) + "&editID=" + document.getElementById("activityID").value + "&Type=" + document.getElementById("activity_type").value;


                //SendExistRequest(Url, "subject", "Task");

                return true;

            } else {
                return false;
            }
            return false;
        } else {
            return false;
        }

    }

    $(function() {
        $('#startTime').timepicker({'timeFormat': 'H:i:s'});
        $('#closeTime').timepicker({'timeFormat': 'H:i:s'});
    });


    function activity2(ref) {

        //alert("aaaaaaaaaa");

        if (ref == 'Task') {
            window.location.href = "editActivity.php?module=Activity&mode=" + ref;
        } else {
            window.location.href = "editActivity.php?module=Activity&mode=" + ref;
            ;
        }




        //document.getElementById("Task").style.display = "bolck";



    }
    


</script>

<SCRIPT LANGUAGE=JAVASCRIPT>

    function SelectAllRecord()
    {
        for (i = 1; i <= document.form1.Line.value; i++) {
            document.getElementById("EmpID" + i).checked = true;
        }

    }

    function SelectNoneRecords()
    {
        for (i = 1; i <= document.form1.Line.value; i++) {
            document.getElementById("EmpID" + i).checked = false;
        }
    }

    function getval(sel) {

        //alert(sel.value);
        document.getElementById("activity_type").value = sel.value;
    }
</SCRIPT>

<?
if ($_GET['mode'] == "Task") {

    $detail_head = $_GET['mode'];

    $none = "style='display:none';";
} else {
    $detail_head = "Event";
    $none = "";
}
?>
<div><a href="javascript:;" style="color:#FFFFFF;" class="button" onclick="activity2('Event');">Event</a> &nbsp;&nbsp;&nbsp;<a style="color:#FFFFFF;" href="javascript:;" class="button" onclick="activity2('Task');">Task</a></div>

<div id="Event">
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">


        <form name="form1" action=""  method="post" onSubmit="return validate<?= $_GET['mode'] ?>(this);" enctype="multipart/form-data">

            <tr>
                <td  align="center" valign="top" >


                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                        <tr>
                            <td colspan="4" align="left" class="head"><?= $_GET['mode'] ?> Details</td>
                        </tr>

                    <!---Recurring Start-->
                            <?php   
                            //$arryRecurr = $arryQuote;
                            include("../includes/html/box/recurring_2column_daily.php");?>

                            <!--Recurring End-->
                        <tr>

                            <td  align="right"   class="blackbold" >Subject  :<span class="red">*</span> </td>
                            <td   align="left" colspan="3">
                                <input name="subject" type="text" class="inputbox" id="subject" value="<?php echo stripslashes($arryEvent[0]['subject']); ?>"  maxlength="50" />            </td>
                        </tr>


                        <tr>
                            <td align="right"   class="blackbold"> Assigned To  :</td>
                            <td   align="left" colspan="3">
                                <input name="assign" type="radio" id="assign1"  <?= ($arryDocument[0]['AssignType'] == "User") ? "checked" : "" ?> checked  value="User"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" <?= ($arryDocument[0]['AssignType'] == "Group") ? "checked" : "" ?> type="radio" id="assign2" value="Group"  maxlength="50" />&nbsp; Group       </td>
                        </tr>


                        <tr >
                            <td align="right"   class="blackbold"> &nbsp;&nbsp; </td>
                            <td  align="left" colspan="3">

                                <div id="group" <?= $classGroup ?>>
                                    <select name="AssignToGroup" class="inputbox" id="AssignToGroup" >
                                        <option value="">--- Select ---</option>	   

                                        <optgroup label="Groups">
                                            <? if (!empty($arryGroup)) { ?>

                                                <? for ($i = 0; $i < sizeof($arryGroup); $i++) { ?>
                                                    <option value="<?= $arryGroup[$i]['group_user'] ?>:<?= $arryGroup[$i]['GroupID'] ?>" <?
                                                    if ($arryGroup[$i]['group_user'] == $arryTicket[0]['AssignedTo']) {
                                                        echo "selected";
                                                    }
                                                    ?>>
                                                    <?= stripslashes($arryGroup[$i]['group_name']); ?> 
                                                    </option>
    <? }
} else {
    ?>

                                            <div class="redmsg">No Group exist.</div>
<? } ?>
                                        </optgroup>
                                    </select>

                                </div>

                                <div id="user" <?= $classUser ?>>
                                    <input type="text" class="inputbox" id="AssignToUser" name="AssignToUser" />
<? if ($_GET['edit'] > 0 && $json_response2 != '') { ?>
                                        <script type="text/javascript">
        $(document).ready(function() {
            $("#AssignToUser").tokenInput("multiSelectAll.php", {
                theme: "facebook",
                preventDuplicates: true,
                prePopulate: <?= $json_response2 ?>,
                propertyToSearch: "name",
                resultsFormatter: function(item) {
                    return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                },
                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                tokenFormatter: function(item) {
                    return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                },
            });
        });
                                        </script>
<? } else { ?>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $("#AssignToUser").tokenInput("multiSelect.php", {
                                                    theme: "facebook",
                                                    preventDuplicates: true,
                                                    propertyToSearch: "name",
                                                    resultsFormatter: function(item) {
                                                        return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                                    },
                                                    //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                    tokenFormatter: function(item) {
                                                        return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                                    },
                                                });
                                            });
                                        </script>
<? } ?>
                                </div>

                            </td>
                        </tr>


                </td>
            </tr>
            <tr>
                <td  align="right"   class="blackbold" width="20%"> Start Date & Time  : <span class="red">*</span></td>
                <td   align="left" width="25%">
                    <script type="text/javascript">
                        $(function() {

                            $('#startDate').datepicker(
                                    {
                                        showOn: "both",
                                        dateFormat: 'yy-mm-dd',
                                        yearRange: '<?= date("Y") ?>:<?= date("Y") + 20 ?>',
                                        minDate: "-D",
                                        changeMonth: true,
                                        changeYear: true
                                    }
                            );
                        });
                    </script>


                    <input id="startDate" name="startDate" readonly="" class="datebox" size="12" value="" placeholder="Start Date"  type="text" />   
                    <input type="text" name="startTime" size="10" class="disabled time" id="startTime"  value="<?php echo stripslashes($arryEvent['startTime']); ?>" placeholder="Start Time"/>

                </td>
 
                <td  align="right"   class="blackbold" width="25%"> End Date & Time  : <span class="red">*</span></td>
                <td   align="left" >


                    <script type="text/javascript">
                        $(function() {



                            $('#closeDate').datepicker(
                                    {
                                        showOn: "both",
                                        dateFormat: 'yy-mm-dd',
                                        yearRange: '<?= date("Y") ?>:<?= date("Y") + 20 ?>',
                                        minDate: "-D",
                                        changeMonth: true,
                                        changeYear: true
                                    }
                            );

                        });
                    </script>


                    <input id="closeDate" name="closeDate" readonly="" class="datebox" size="12" value="<?php echo stripslashes($arryEvent['closeDate']); ?>" placeholder="Close Date"  type="text" > 
                    <input type="text" name="closeTime" size="10" class="disabled time" id="closeTime"  value="<?php echo stripslashes($arryEvent['closeTime']); ?>" placeholder="Close Time"/>

                </td>
            </tr>

            <tr>


            <tr>
                <td  align="right"   class="blackbold"> Status  :<span class="red">*</span> </td>
                <td   align="left" >

                    <select name="status" class="inputbox" id="status" >
                        <option value="">--- Select ---</option>
   
                      <? for($i=0;$i<sizeof($arryActivityStatus);$i++) {?>
			<option value="<?=$arryActivityStatus[$i]['attribute_value']?>" <?  if($arryActivityStatus[$i]['attribute_value']==$arryEvent[0]['event_status']){echo "selected";}?>>
			<?=$arryActivityStatus[$i]['attribute_value']?>
			</option>
		<? } ?>  
                        
                    </select>
                </td>

		<td  align="right"   class="blackbold"> Priority  : </td>
                <td   align="left" >

                    <select name="priority" class="inputbox" id="priority" >
                        <option value="">--- Select ---</option>
                        <option value="High"<?
                        if ($arryEvent[0]['priority'] == "High") {
                            echo "selected";
                        }
                           ?>>High</option>
                        <option value="Medium" <?
                        if ($arryEvent[0]['priority'] == "Medium") {
                            echo "selected";
                        }
                           ?>>Medium</option>
                        <option value="Low" <?
                                if (stripslashes($arryEventStatus[0]['priority']) == "Low") {
                                    echo "selected";
                                }
                           ?>>Low</option>
                    </select>
                </td>



            </tr>
            <tr <?= $none ?>>
                <td  align="right"   class="blackbold"> Activity Type  :<span class="red">*</span> </td>
                <td   align="left" >

                    <select name="activityType" class="inputbox" onchange="getval(this);" id="activityType" >
                        <option value="">--- Select ---</option>
                       <? for($i=0;$i<sizeof($arryActivityType);$i++) {?>
                                        <option value="<?=$arryActivityType[$i]['attribute_value']?>" <?  if($arryActivityType[$i]['attribute_value']==$arryActivity[0]['activityType']){echo "selected";}?>>
                                        <?=$arryActivityType[$i]['attribute_value']?>
                                        </option>
                                <? } ?>  
                    </select>
                </td>
            
                <td  align="right"   class="blackbold"> Send Notification  : </td>
                <td   align="left" >

                    <input id="Notification" name="Notification" <?
                           if ($arryEvent['Notification'] == 1) {
                               echo "Checked";
                           }
                           ?>  size="15" value="1"  type="checkbox" > 

                </td>
            </tr>


            <tr <?= $none ?>>
                <td  align="right"    class="blackbold"> Location  : </td>
                <td   align="left" >

                    <input id="location" name="location"   size="15" value="<?= $arryEvent['location'] ?>" class="inputbox"  type="text" > 

                </td>
            
                <td  align="right"    class="blackbold"> Visibility  : </td>
                <td   align="left" >
                    <select name="visibility" class="inputbox" id="visibility" >
                        <option value="">--- Select ---</option>		
                        <option value="Private" <?
                                if ($arryEvent['visibility'] == "Private") {
                                    echo "selected";
                                }
                           ?>>Private</option>
                        <option value="Private" <?
                                if ($arryEvent['visibility'] == "Public") {
                                    echo "selected";
                                }
                           ?>>Public</option>
                    </select>
                </td>
            </tr>



            <tr>
                
          
        <td  align="right"   class="blackbold">  Customer  : </td>
        <td   align="left" >
		
	<? if(sizeof($arryCustomer)>0){?>
	<select name="CustID" class="inputbox" id="CustID" >
		<option value="">--- Select ---</option>
		<? for($i=0;$i<sizeof($arryCustomer);$i++) {?>
			<option value="<?=$arryCustomer[$i]['Cid']?>" <?  if($arryCustomer[$i]['Cid']==$arryActivity[0]['CustID']){echo "selected";}?>>
			<?=stripslashes($arryCustomer[$i]['FullName']);?> 
			</option>
		<? } ?>
	</select>

	<? }else{ 
		echo NO_CUSTOMER_EXIST;
	} ?>


            </td>
 </tr>




            <tr>
                <td colspan="4" align="left"   class="head">Reminder Details</td>
            </tr>
            <tr >
                <td  align="right"   class="blackbold"> Send Reminder  : </td>
                <td   align="left" colspan="3">

                    <input id="reminder" name="reminder" <?
                                if ($arryEvent['reminder'] == 1) {
                                    echo "Checked";
                                }
                           ?>  size="15" value="1"  type="checkbox" > 

                </td>
            </tr>

            <tr <?= $none ?> >
                <td  align="right"   class="blackbold"> Invite Employee  : </td>
                <td   align="left" colspan="3">

                    <div>
                        <input type="text" class="inputbox" id="demo-input-facebook-theme" name="EmpID" />

                        <script type="text/javascript">
                        $(document).ready(function() {
                            $("#demo-input-facebook-theme").tokenInput("multiSelectAll.php", {
                                theme: "facebook",
                                preventDuplicates: true,
                                propertyToSearch: "name",
                                resultsFormatter: function(item) {
                                    return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                },
                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                tokenFormatter: function(item) {
                                    return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " (" + item.designation + ")</div><div class='email'>" + item.department + "</div></div></li>"
                                },
                            });
                        });
                        </script>
                    </div>

                </td>
            </tr>

<? if($_GET['parent_type'] == ''){?>
            <tr <?= $none ?>>
                <td colspan="4" align="left"   class="head">Related To</td>
            </tr>

            <tr <?= $none ?>>
		<td   align="right" >Related Type :</td>
                <td   align="left" >
                    
                    <select name="RelatedType" class="inputbox" onchange="selModule();" id="RelatedType" >
                        <option value="">--- Select ---</option>	
                        <option value="Lead" <?
                            if ($arryEvent['RelatedType'] == "Lead" || $_GET['parent_type']== "lead") {
                                echo "selected";
                            }
                           ?>>Lead</option>
                        <option value="Opportunity" <?
                            if ($arryEvent['RelatedType'] == "Opportunity" || $_GET['parent_type']== "Opportunity") {
                                echo "selected";
                            }
                           ?>>Opportunity</option>
                        <option value="Campaign" <?
                            if ($arryEvent['RelatedType'] == "Campaign" || $_GET['parent_type']== "Campaign") {
                                echo "selected";
                            }
                            ?>>Campaign</option>

			 <option value="Ticket" <?
                            if ($arryEvent['RelatedType'] == "Ticket" || $_GET['parent_type']== "Ticket") {
                                echo "selected";
                            }
                            ?>>Ticket</option>
			 <option value="Quote" <?
                            if ($arryEvent['RelatedType'] == "Quote" || $_GET['parent_type']== "Quote") {
                                echo "selected";
                            }
                            ?>>Quote</option>

                    </select>
                </td>
<?}?>
                <td colspan="2" style="padding-left:160px;">


                    <div id="Lead" style="display:none; ">
                        <span>Lead :  </span>
                        <select id="LeadID" class="inputbox"  name ="LeadID" >  
                            <option value="" >--Select Lead--</option>
                            <?
                            $arryLead = $objLead->ListLead($id = 0, $SearchKey, $SortBy, $AscDesc);

                            for ($i = 0; $i < sizeof($arryLead); $i++) {
if($arryLead[$i]['LeadID'] == $_GET['parentID']){ $Selected = "selected"; }

                                echo '<option value="' . $arryLead[$i]['LeadID'] . '" '.$Selected.'>' . $arryLead[$i]['FirstName'] . ' ' . $arryLead[$i]['LastName'] . '</option>';
                            }
                            ?>

                        </select>
                    </div>	

                    <div id="Opportunity" style="display:none; ">
                        <span>Opportunity :  </span>
                        <select id="OpprtunityID" class="inputbox"  name ="OpprtunityID" >  
                            <option value="" >--Select Opportunity--</option>
<?
for ($i = 0; $i < sizeof($arryOpportunity); $i++) {

    echo '<option value="' . $arryOpportunity[$i]['OpportunityID'] . '">' . $arryOpportunity[$i]['OpportunityName'] . '</option>';
}
?>

                        </select>
                    </div>	

                    <div id="Campaign" style="display:none; ">
                        <span>Campaign :  </span>
                        <select id="CampaignID"  class="inputbox" name ="CampaignID" >  
                            <option value="" >--Select Campaign--</option>
<?
for ($i = 0; $i < sizeof($arryCampaign); $i++) {

    echo '<option value="' . $arryCampaign[$i]['campaignID'] . '">' . $arryCampaign[$i]['campaignname'] . '</option>';
}
?>

                        </select>
                    </div>	


<div id="Ticket" style="display:none; ">
                        <span>Ticket :  </span>
                        <select id="TicketID"  class="inputbox" name ="TicketID" >  
                            <option value="" >--Select Ticket--</option>
<?
for ($i = 0; $i < sizeof($arryTicket); $i++) {
    echo '<option value="' . $arryTicket[$i]['TicketID'] . '">' . stripslashes($arryTicket[$i]['title']) . '</option>';
}
?>

                        </select>
                    </div>


<div id="Quote" style="display:none; ">
                        <span>Quote :  </span>
                        <select id="QuoteID"  class="inputbox" name ="QuoteID" >  
                            <option value="" >--Select Quote--</option>
<?
for ($i = 0; $i < sizeof($arryQuote); $i++) {

    echo '<option value="' . $arryQuote[$i]['quoteid'] . '">' . stripslashes($arryQuote[$i]['subject']) . '</option>';
}
?>

                        </select>
                    </div>









                </td>
            </tr>



            <tr>
                <td colspan="4" align="left"   class="head">Description</td>
            </tr>

            <tr>
                <td align="right"   class="blackbold" valign="top">Description :</td>
                <td  align="left" colspan="3" >
                    <Textarea name="description" id="description" class="inputbox"  ></Textarea>

<script type="text/javascript">

                        var editorName = 'description';

                        var editor = new ew_DHTMLEditor(editorName);

                        editor.create = function() {
                            var sBasePath = '../FCKeditor/';
                            var oFCKeditor = new FCKeditor(editorName, '98%', 200, 'Basic');
                            oFCKeditor.BasePath = sBasePath;
                            oFCKeditor.ReplaceTextarea();
                            this.active = true;
                        }
                        ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

                        ew_CreateEditor();


                                        </script>			          </td>
        </tr>
         
	
</table>	






	
	  
	
	</td>
   </tr>



   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
<? if ($_GET['edit'] > 0)
    $ButtonTitle = 'Update ';
else
    $ButtonTitle = ' Submit ';
?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?= $ButtonTitle ?> "  />


<input type="hidden" name="activityID" id="activityID" value="<?= $_GET['edit'] ?>" />
<input type="hidden" name="activity_type" id="activity_type" value="<?= $_GET['mode'] ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />
<input type="hidden" name="parent_type" id="parent_type"  value="<?= $_GET['parent_type'] ?>" />
<input type="hidden" name="parentID" id="parentID"  value="<?= $_GET['parentID'] ?>" />



</div>

</td>
   </tr>
   </form>
</table>
</div>

  

  
  





