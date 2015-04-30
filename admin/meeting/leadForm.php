<?php 
/**************************************************/
$EditPage = 1; $_GET['type']='lead';
/**************************************************/
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix . "classes/crm.class.php");
include_once("includes/FieldArray.php");
$RedirectURL = "viewLead.php?module=lead";
$objLead = new lead();
$objCommon = new common();


if(!empty($_POST['columnTo'])){
    
    $_POST['ActionUrl'] = $Config['Url'].'processLead.php';
    
    $arryLeadStatus = $objCommon->GetCrmAttribute('LeadStatus', '');
    $arryLeadSource = $objCommon->GetCrmAttribute('LeadSource', '');
    $arryIndustry = $objCommon->GetCrmAttribute('LeadIndustry', '');

    
    foreach($_POST['columnTo'] as $formvalue){
        $LeadColumn .= $formvalue.',';
        $valArry = explode(":", $formvalue);
        $title = $valArry[0];
        $val = $valArry[1];
        $mand = '';  $FieldBox = '<input name="'.$val.'" type="text" class="inputbox" id="'.$val.'"  maxlength="50" />';
        if($val=='FirstName' || $val=='LastName' || $val=='lead_source' || $val=='lead_status'){
            $mand = '<span class="red">*</span>';
        }
        if($val=='Address' || $val=='description' ){
            $FieldBox = '<textarea name="'.$val.'" id="'.$val.'" class="textarea"  ></textarea>';
        }
        
        if($val=='lead_source' || $val=='lead_status' || $val=='Industry' ){
                $FieldBox = '<select name="'.$val.'" class="inputbox" id="'.$val.'" >
                                <option value="">--- Select ---</option>';
                if($val=='lead_source'){
                    for ($i = 0; $i < sizeof($arryLeadSource); $i++) {
                        $FieldBox .= '<option value="'.$arryLeadSource[$i]['attribute_value'].'" >
                '.$arryLeadSource[$i]['attribute_value'].'</option>';
                    } 
                }else if($val=='lead_status'){
                    for ($i = 0; $i < sizeof($arryLeadStatus); $i++) {
                        $FieldBox .= '<option value="'.$arryLeadStatus[$i]['attribute_value'].'" >
                '.$arryLeadStatus[$i]['attribute_value'].'</option>';
                    } 
                }else if($val=='Industry'){
                    for ($i = 0; $i < sizeof($arryIndustry); $i++) {
                        $FieldBox .= '<option value="'.$arryIndustry[$i]['attribute_value'].'" >
                '.$arryIndustry[$i]['attribute_value'].'</option>';
                    } 
                }
                $FieldBox .= '</select>';
        }
        
        
        
        $opt .= ' <tr>
                        <td  align="right"   class="blackbold" width="25%" valign="top"> '.$title.' '.$mand.' : </td>
                        <td   align="left" valign="top">
                            '.$FieldBox.'
                         </td>

                    </tr>'; 
       
    }

    
    $HtmlForm = '
        <link href="'.$Config['Url'].$Config['AdminCSS'].'" rel="stylesheet" type="text/css">
        <script language="javascript" src="'.$Config['Url'].'includes/global.js"></script>

<script language="JavaScript1.2" type="text/javascript">
    function validateWebToLeadForm(frm) {
    
        if(document.getElementById("FirstName") != null) {
            if(!ValidateForSimpleBlank(frm.FirstName, "First Name")){
                return false;
            }            
        }
        if(document.getElementById("LastName") != null) {
            if(!ValidateForSimpleBlank(frm.LastName, "Last Name")){
                return false;
            }            
        }
        
         if(document.getElementById("primary_email") != null) {
            if(!isEmailOpt(frm.primary_email)){
                return false;
            }            
        }
        
        if(document.getElementById("lead_source") != null) {
            if(!ValidateForSelect(frm.lead_source, "Lead Source")){
                return false;
            }            
        }
        if(document.getElementById("lead_status") != null) {
            if(!ValidateForSelect(frm.lead_status, "Lead Status")){
                return false;
            }            
        }

      


    }
</script>


        <form name="leadactionform" id="leadactionform" action="'.$_POST['ActionUrl'].'" onSubmit="return validateWebToLeadForm(this);" method="post">
        <h4>'.$_POST['FormTitle'].'</h4>
        <strong>'.$_POST['Subtitle'].'</strong><br> 
        '.$_POST['Description'].'<br>
           <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall"> 
           '.$opt.'
           <tr>
           <td align="left"></td>
           <td align="left">
           <input name="Cmp" type="hidden" id="Cmp" value="'.md5($_SESSION['CmpID']).'"  />
           <input name="LeadSubmit" type="submit" class="button" id="LeadSubmit" value=" Submit "  />
           </td>
            </tr>
           </table>
           
           
       </form>
    ';
    #echo $HtmlForm;exit;
    $LeadColumn = rtrim($LeadColumn, ",");
    $_POST['LeadColumn'] = $LeadColumn;
    $objLead->UpdateLeadWebForm($_POST, $HtmlForm);
    $_SESSION['msg_lead_form'] = 'generated';
    header('location:leadForm.php');    
    exit;
    
}

$arryLeadForm = $objLead->GetLeadWebForm('1');

require_once("../includes/footer.php"); 
?>

