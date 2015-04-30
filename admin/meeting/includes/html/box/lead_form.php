

<script language="JavaScript1.2" type="text/javascript">
    function validateLead(frm) {

        if (document.getElementById("state_id") != null) {
            document.getElementById("main_state_id").value = document.getElementById("state_id").value;
        }
        if (document.getElementById("city_id") != null) {
            document.getElementById("main_city_id").value = document.getElementById("city_id").value;
        }


        var main_state_id = $.trim($("#main_state_id").val());
        var main_city_id = $.trim($("#main_city_id").val());
        var OtherState = $.trim($("#OtherState").val());
        var OtherCity = $.trim($("#OtherCity").val());



        if (!ValidateForSelect(frm.type, "Lead Type")) {
            return false;
        }

        if (frm.type.value == "Company") {
            //alert("ok");
            if (frm.company.value == '') {
                alert("Please Enter Company Name.");
                document.getElementById('company').focus()
                //frm.company.focus();
                return false;
            }
        }



        if (ValidateForSimpleBlank(frm.FirstName, "First Name")
                && ValidateForSimpleBlank(frm.LastName, "Last Name")
                //&& ValidateForSimpleBlank(frm.primary_email, "Primary Email")
                && isEmailOpt(frm.primary_email)) {




            if (ValidateForSelect(frm.lead_source, "Lead Source")
                    //&& ValidateForSelect(frm.AssignTo,"Assign To")
                    && ValidateForSelect(frm.lead_status, "Lead Status")
                    && ValidateForSelect(frm.LeadDate, "Lead Date")
                    && ValidateForSimpleBlank(frm.Address, "Street Address")
                    && ValidateForSelect(frm.country_id, "Country")
                    ) {

                if ((main_state_id == "" || main_state_id == "0") && (OtherState == ""))
                {
                    alert("Please Enter State.");
                    $("#OtherState").focus();
                    return false;
                }

                if ((main_city_id == "" || main_city_id == "0") && (OtherCity == ""))
                {
                    alert("Please Enter City.");
                    $("#OtherCity").focus();
                    return false;
                }



                if (!isZipCode(frm.ZipCode)) {
                    return false;
                }
                if (!ValidateOptPhoneNumber(frm.LandlineNumber, "Landline Number")) {
                    return false;
                }



                /*var Url = "isRecordExists.php?primary_email="+escape(document.getElementById("primary_email").value)+"&editID="+document.getElementById("LeadID").value+"&Type=Lead";
                 SendExistRequest(Url,"primary_email", "Primary Email Address");
                 
                 return false;*/

                ShowHideLoader('1', 'S');
                return true;

            }



            return false;

        } else {
            return false;
        }


    }


    function ltype() {

        var opt = document.getElementById('type').value;

        if (opt == "Company") {
            document.getElementById('com').style.display = 'block';
            document.getElementById('com_title').style.display = 'block';
        } else {
            document.getElementById('com').style.display = 'none';
            document.getElementById('com_title').style.display = 'none';
            document.getElementById('company').value = '';
        }


    }


</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
    <form name="form1" action=""  method="post" onSubmit="return validateLead(this);" enctype="multipart/form-data">


        <tr>
            <td  align="center" valign="top" >


                <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
                    <tr>
                        <td colspan="4" align="left" class="head">Lead Details</td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold" > Lead Type  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <select name="type" class="inputbox" id="type" onchange="ltype();" >
                                <option value="">--- Select ---</option>

                                <option value="Individual" <?
                                if ($arryLead[0]['type'] == 'Individual') {
                                    echo "selected";
                                }
                                ?>>Individual</option>
                                <option value="Company" <?
                                if ($arryLead[0]['type'] == 'Company') {
                                    echo "selected";
                                }
                                ?>>Company</option>


                            </select>
                        </td>

                        <td  align="right"   class="blackbold"> <div  id="com_title">Company Name : <span class="red">*</span> </div></td>
                        <td   align="left" >
                            <div  id="com">
                                <input name="company" type="text" class="inputbox" id="company"   value="<?php echo stripslashes($arryLead[0]['company']); ?>"  maxlength="50" />        
                            </div>

                        </td>




                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold" width="25%"> First Name  :<span class="red">*</span> </td>
                        <td   align="left" width="25%">
                            <input name="FirstName" type="text" class="inputbox" id="FirstName" value="<?php echo stripslashes($arryLead[0]['FirstName']); ?>"  maxlength="50" />            </td>

                        <td  align="right"   class="blackbold" width="25%"> Last Name  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <input name="LastName" type="text" class="inputbox" id="LastName" value="<?php echo stripslashes($arryLead[0]['LastName']); ?>"  maxlength="50" />            </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> Primary Email : </td>
                        <td   align="left" >
                            <input name="primary_email" type="text" class="inputbox" id="primary_email" value="<?php echo stripslashes($arryLead[0]['primary_email']); ?>"  maxlength="50" />            </td>

                        <td  align="right"   class="blackbold"> Title : </td>
                        <td   align="left" >
                            <input name="designation" type="text" class="inputbox" id="designation" value="<?php echo stripslashes($arryLead[0]['designation']); ?>"  maxlength="50" />            </td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> Product : </td>
                        <td   align="left" >
                            <input name="ProductID" type="text" class="inputbox" id="ProductID" value="<?php echo stripslashes($arryLead[0]['ProductID']); ?>"  maxlength="50" />            </td>

                        <td  align="right"   class="blackbold">Product Price :</td>
                        <td   align="left" >
                            <input name="product_price" type="text" class="inputbox" id="product_price" value="<?php echo stripslashes($arryLead[0]['product_price']); ?>"  maxlength="50" />            </td>
                    </tr>




        <!--<table   id="com" style="display:none; margin-left: -70px;" width="100%"> <tr>
        <td  align="right" width="45.5%"   class="blackbold"> Company Name : <span class="red">*</span></td>
        <td   align="left" width="50%" >
<input name="company" type="text" class="inputbox" id="company"   value="<?php echo stripslashes($arryLead[0]['company']); ?>"  maxlength="50" />            </td>
      </tr></table>-->

                    <tr>
                        <td  align="right"   class="blackbold"> Website : </td>
                        <td   align="left" >
                            <input name="Website" type="text" class="inputbox" id="Website" value="<?php echo stripslashes($arryLead[0]['Website']); ?>"  maxlength="50" />            </td>

                        <td  align="right"   class="blackbold"> Industry  : </td>
                        <td   align="left" >

                            <select name="Industry" class="inputbox" id="Industry" >
                                <option value="">--- Select ---</option>
                                            <? for ($i = 0; $i < sizeof($arryIndustry); $i++) { ?>
                                    <option value="<?= $arryIndustry[$i]['attribute_value'] ?>" <?
                                    if ($arryIndustry[$i]['attribute_value'] == $arryLead[0]['Industry']) {
                                        echo "selected";
                                    }
                                    ?>>
    <?= $arryIndustry[$i]['attribute_value'] ?>
                                    </option>
<? } ?>

                            </select>
                        </td>
                    </tr>



                    <tr>
                        <td  align="right"   class="blackbold"> Annual Revenue : </td>
                        <td   align="left" >
                            <input name="AnnualRevenue" type="text" class="inputbox" id="AnnualRevenue" value="<?php echo stripslashes($arryLead[0]['AnnualRevenue']); ?>"  maxlength="20" />            </td>

                        <td  align="right"   class="blackbold"> Number of Employees : </td>
                        <td   align="left" >
                            <input name="NumEmployee" type="text" class="inputbox" id="NumEmployee" value="<?php echo stripslashes($arryLead[0]['NumEmployee']); ?>"  maxlength="10" onkeypress="return isNumberKey(event);" />            </td>

                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"> Lead Source  :<span class="red">*</span> </td>
                        <td   align="left" >

                            <select name="lead_source" class="inputbox" id="lead_source" >
                                <option value="">--- Select ---</option>
                                <? for ($i = 0; $i < sizeof($arryLeadSource); $i++) { ?>
                                    <option value="<?= $arryLeadSource[$i]['attribute_value'] ?>" <?
                                if ($arryLeadSource[$i]['attribute_value'] == $arryLead[0]['lead_source']) {
                                    echo "selected";
                                }
                                ?>>
    <?= $arryLeadSource[$i]['attribute_value'] ?>
                                    </option>
<? } ?>

                            </select>

                        </td>

                        <td  align="right"   class="blackbold"> Lead Status  :<span class="red">*</span> </td>
                        <td   align="left" >


                            <select name="lead_status" class="inputbox" id="lead_status" >
                                <option value="">--- Select ---</option>
<? for ($i = 0; $i < sizeof($arryLeadStatus); $i++) { ?>
                                    <option value="<?= $arryLeadStatus[$i]['attribute_value'] ?>" <?
    if ($arryLeadStatus[$i]['attribute_value'] == $arryLead[0]['lead_status']) {
        echo "selected";
    }
    ?>>
                                <?= $arryLeadStatus[$i]['attribute_value'] ?>
                                    </option>
<? } ?>

                            </select> 	  
                        </td>
                    </tr>
                    <tr>
                        <td  align="right"> Lead Date : <span class="red">*</span> </td>
                        <td   align="left">
<? if ($arryLead[0]['LeadDate'] > 0) $LeadDate = $arryLead[0]['LeadDate']; ?>		
                            <script>
    $(function() {
        $("#LeadDate").datepicker({
            showOn: "both",
            yearRange: '<?= date("Y") - 20 ?>:<?= date("Y") ?>',
            dateFormat: 'yy-mm-dd',
            maxDate: "+0D",
            changeMonth: true,
            changeYear: true
        });
    });
                            </script>
                            <input id="LeadDate" name="LeadDate" readonly="" class="datebox" value="<?= $LeadDate ?>"  type="text" >         </td>

                        <td  align="right"> Last Contact Date :  </td>
                        <td   align="left">
<? if ($arryLead[0]['LastContactDate'] > 0) $LastContactDate = $arryLead[0]['LastContactDate']; ?>		
                            <script>
                                $(function() {
                                    $("#LastContactDate").datepicker({
                                        showOn: "both",
                                        yearRange: '<?= date("Y") - 20 ?>:<?= date("Y") ?>',
                                        dateFormat: 'yy-mm-dd',
                                        maxDate: "+0D",
                                        changeMonth: true,
                                        changeYear: true
                                    });
                                });
                            </script>
                            <input id="LastContactDate" name="LastContactDate" readonly="" class="datebox" value="<?= $LastContactDate ?>"  type="text" >         </td>
                    </tr>  


 
<tr>
	<td  align="right"   class="blackbold" > Currency  : </td>
	<td   align="left" >
<?
//unset($arryCompany[0]['AdditionalCurrency']);
if(empty($arryCompany[0]['AdditionalCurrency']))$arryCompany[0]['AdditionalCurrency'] = $Config['Currency'];
$arrySelCurrency  = explode(",",$arryCompany[0]['AdditionalCurrency']);

if(!empty($arryLead[0]['Currency']) && !in_array($arryLead[0]['Currency'],$arrySelCurrency)){
	$arrySelCurrency[]=$arryLead[0]['Currency'];
}

 ?>
<select name="Currency" class="inputbox" id="Currency">
	<? for($i=0;$i<sizeof($arrySelCurrency);$i++) {?>
	<option value="<?=$arrySelCurrency[$i]?>" <?  if($arrySelCurrency[$i]==$arryLead[0]['Currency']){echo "selected";}?>>
	<?=$arrySelCurrency[$i]?>
	</option>
	<? } ?>
</select>


</td>
</tr>



                    <tr>
                        <td align="right"   class="blackbold"> Assigned To  :<span class="red">*</span> </td>
                        <td   align="left" >
                            <input name="assign" type="radio" id="assign1"  <?= ($arryLead[0]['AssignType'] == "User") ? "checked" : "" ?> checked  value="User"  maxlength="50" />&nbsp; Users &nbsp;&nbsp; <input name="assign" <?= ($arryDocument[0]['AssignType'] == "Group") ? "checked" : "" ?> type="radio" id="assign2" value="Group"  maxlength="50" />&nbsp; Group       </td>
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
                                            $("#AssignToUser").tokenInput("multiSelect.php", {
                                                theme: "facebook",
                                                preventDuplicates: true,
                                                prePopulate: <?= $json_response2 ?>,
                                                propertyToSearch: "name",
                                                resultsFormatter: function(item) {
                                                    return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>"
                                                },
                                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                tokenFormatter: function(item) {
                                                    return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " ' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + " </div><div class='email'>" + item.department + "</div></div></li>"
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
                                                    return "<li>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>"
                                                },
                                                //tokenFormatter: function(item) { return "<li><p>" + item.name + " <b style='color: red'>" + item.designation + "</b></p></li>" }
                                                tokenFormatter: function(item) {
                                                    return "<li><p>" + "<img src='" + item.url + "' title='" + item.name + " " + item.name + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div><div class='email'>" + item.department + "</div></div></li>"
                                                },
                                            });
                                        });
                                    </script>
<? } ?>
                            </div>

                        </td>
                    </tr>





                    <tr>
                        <td colspan="4" align="left"   class="head">Address Details</td>
                    </tr>




                    <tr>
                        <td align="right"   class="blackbold" valign="top">Street Address :<span class="red">*</span></td>
                        <td  align="left" colspan="3" >
                            <textarea name="Address" type="text" class="textarea" id="Address"><?= stripslashes($arryLead[0]['Address']) ?></textarea>			          </td>
                    </tr>

                    <tr <?= $Config['CountryDisplay'] ?>>
                        <td  align="right"   class="blackbold"> Country  :<span class="red">*</span></td>
                        <td   align="left" >
                                <?
                                if ($arryLead[0]['country_id'] != '') {
                                    $CountrySelected = $arryLead[0]['country_id'];
                                }
                                ?>
                            <select name="country_id" class="inputbox" id="country_id"  onChange="Javascript: StateListSend();">
                                <option value="" >-- Select Country --</option>
<? for ($i = 0; $i < sizeof($arryCountry); $i++) { ?>
                                    <option value="<?= $arryCountry[$i]['country_id'] ?>" <?
    if ($arryCountry[$i]['country_id'] == $CountrySelected) {
        echo "selected";
    }
    ?>>
    <?= $arryCountry[$i]['name'] ?>
                                    </option>
<? } ?>
                            </select>        </td>
                    </tr>
                    <tr>
                        <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State  :<span class="red">*</span></td>
                        <td  align="left" id="state_td" class="blacknormal">&nbsp;</td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"> <div id="StateTitleDiv">Other State  :<span class="red">*</span></div> </td>
                        <td   align="left" ><div id="StateValueDiv"><input name="OtherState" type="text" class="inputbox" id="OtherState" value="<?php echo $arryLead[0]['OtherState']; ?>"  maxlength="30" /> </div>           </td>
                    </tr>

                    <tr>
                        <td  align="right"   class="blackbold"><div id="MainCityTitleDiv"> City   :<span class="red">*</span></div></td>
                        <td  align="left"  ><div id="city_td"></div></td>
                    </tr>
                    <tr>
                        <td  align="right"   class="blackbold"><div id="CityTitleDiv"> Other City :<span class="red">*</span></div>  </td>
                        <td align="left" ><div id="CityValueDiv"><input name="OtherCity" type="text" class="inputbox" id="OtherCity" value="<?php echo $arryLead[0]['OtherCity']; ?>"  maxlength="30" />  </div>          </td>
                    </tr>

                    <tr>
                        <td align="right"   class="blackbold" >Zip Code  :<span class="red">*</span></td>
                        <td  align="left"  colspan="3">
                            <input name="ZipCode" type="text" class="inputbox" id="ZipCode" value="<?= stripslashes($arryLead[0]['ZipCode']) ?>" maxlength="15" />			</td>
                    </tr>  
                    <tr>
                        <td  align="right"   class="blackbold">Landline  :</td>
                        <td   align="left" >

                            <input name="LandlineNumber" type="text" class="inputbox" id="LandlineNumber" value="<?= stripslashes($arryLead[0]['LandlineNumber']) ?>"     maxlength="30" />


                        </td>
                    </tr>  
                    <tr>
                        <td align="right"   class="blackbold" >Mobile  :</td>
                        <td  align="left"  >
                            <input name="Mobile" type="text" onkeypress="return isNumberKey(event);" class="inputbox" id="Mobile" value="<?= stripslashes($arryLead[0]['Mobile']) ?>"     maxlength="20" />			</td>
                    </tr>







                    <tr>
                        <td colspan="4" align="left"   class="head">Description</td>
                    </tr>

                    <tr>
                        <td align="right"   class="blackbold" valign="top">Description :</td>
                        <td  align="left" colspan="3">
                            <Textarea name="description" id="description" class="inputbox"  ></Textarea>

<script type="text/javascript">

                                                                    var editorName = 'description';

                                                                    var editor = new ew_DHTMLEditor(editorName);

                                                                    editor.create = function() {
                                                                        var sBasePath = '../FCKeditor/';
                                                                        var oFCKeditor = new FCKeditor(editorName, '97%', 160, 'Basic');
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


<input type="hidden" name="LeadID" id="LeadID" value="<?= $_GET['edit'] ?>" />

<input type="hidden" name="main_state_id" id="main_state_id"  value="<?php echo $arryLead[0]['state_id']; ?>" />	
<input type="hidden" name="main_city_id" id="main_city_id"  value="<?php echo $arryLead[0]['city_id']; ?>" />
<input type="hidden" name="created_by" id="created_by"  value="<?= $_SESSION['AdminType'] ?>" />
<input type="hidden" name="created_id" id="created_id"  value="<?= $_SESSION['AdminID'] ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
    StateListSend();
    //ShowPermission();
</SCRIPT>
