<?php

$FancyBox=1;
require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");


$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);

//ini_set('display_errors',1);

if($_POST){
	
$name =  trim($_POST['name']);

  $list_floder = $Mailchimp_Folders->getList('template');
   // $Mailchimp_Folders->del('109','template');
   // $Mailchimp_Folders->del('110','template');
   //echo "<pre>";print_r($list_floder);die;
#add folder under template
try{
$addfolder_template = $Mailchimp_Folders->add($name,'template');
$addfolder_template_id =  $addfolder_template['folder_id'];
} catch(Exception $e) {
  $_SESSION['mess_mass']='<div class="error">There is already a account. Please use another name.</div>';
   
}

#add folder under Campaigns
try{
$addfolder_campaign = $Mailchimp_Folders->add($name,'campaign');
$addfolder_campaign_id =  $addfolder_campaign['folder_id'];
} catch(Exception $e) {
  $_SESSION['mess_mass']='<div class="error">There is already a account. Please use another name.</div>';

}

#add group

try{
$addgroup =  $Mailchimp_Lists->interestGroupAdd($cmpId, $name);
}catch(Exception $e) {
$_SESSION['mess_mass']='<div class="error">There is already a account. Please use another name.</div>';

}


if(!empty($addfolder_template_id) && !empty($addfolder_campaign_id) && $addgroup['complete']==1){
	  $data['name'] = $name;
	  $data['template_foder_id'] = $addfolder_template_id;
	  $data['campaign_folder_id'] = $addfolder_campaign_id;
	  $data['group_id'] = $addgroup['complete'];
	  $data['list_id'] =  $cmpId;
	  
	  $result = $massmail->CreateAccountMailChimp($data);
	  $MailchimSetting = $massmail->GetMailchimSetting();
	  $_SESSION['mess_mass']='<div class="success">Account create successfully.</div>';
	  header('Location: ' . _SiteUrl.'admin/crm/mailchimp.php'); die;
}else{
	$_SESSION['mess_mass']='<div class="error">Something wrong. Please try to letter.</div>';
   
}


}else{
	 $MailchimSetting = $massmail->GetMailchimSetting();
}	



require_once("../includes/footer.php"); 
?>






