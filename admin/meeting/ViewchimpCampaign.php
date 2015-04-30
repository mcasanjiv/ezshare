<?php

$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Folders = new Mailchimp_Folders($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);

//ini_set('display_errors',1);

$Campaignfolder = $MailchimSetting['0']['campaign_folder_id'];
//print_r($Campaignfolder);die;

if($_POST){
  header("location:ViewchimpCampaign.php");
  exit;
}else{
	//list Campaigns
   $filter = array('folder_id'=>401);
   $listCampaign = $Mailchimp_Campaigns->getList($filter);
   //echo "<pre>";print_r($listCampaign);die;
   
	 $ChimpCampaignList = $massmail->GetchimpCampaign();
	 //echo '<pre>';print_r($ChimpCampaignList);die;
	 $num = $massmail->numRows();
     $pagerLink = $objPager->getPager($ChimpCampaignList, $RecordsPerPage, $_GET['curP']);
     (count($ChimpCampaignList) > 0) ? ($ChimpCampaignList = $objPager->getPageRecords()) : ("");
}	


if (!empty($_GET['del_id'])) {
   $massmail->deleteMailchimCampaign($_GET['del_id']);
	$CampaignId = array('campaignId' =>$_GET['del_campaign']);
	//print_r($CampaignId);die;
	$Mailchimp_Campaigns->delete($CampaignId['campaignId']);
    header("location:ViewchimpCampaign.php");
    exit;
}

if (!empty($_GET['Camp_id'])) {
    $massmail->UpdateStatusMailchimCampaign($_GET['S_id']);
	 $SCampaignId = array('ScampaignId' =>$_GET['Camp_id']);
	 //print_r($CampaignId);die;
    header("location:ViewchimpCampaign.php");
    exit;
}



require_once("../includes/footer.php"); 
?>






