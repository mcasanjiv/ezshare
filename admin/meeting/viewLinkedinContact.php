<?php
$FancyBox=1;
$ThisPageName = 'Twitter.php';
$EditPage = 1;
require_once("../../define.php");
require_once("../includes/header.php");
require_once($Prefix."classes/crm.class.php");
require_once($Prefix . "classes/filter.class.php");
require_once(_ROOT."/lib/twitter/TwitterAPIExchange.php");
require_once($Prefix."classes/socialCrm.class.php");
/********************************** Start Twitter Api **************************/
	require_once(_ROOT.'/lib/twitter/twitteroauth.php');
	require_once(_ROOT.'/lib/twitter/Twitterconfig.php');
	$oauth_token_secret=$oauth_token='';
	$objsocialcrm=new socialcrm();
	$data=$twitterdata=$arrySocial=array();	
	$socialtype='twitter';
			/* ***********************End Twitter Api ****************************/
	$objCommon=new common();
	$objFilter = new filter();
	$twitterdata=$objsocialcrm->getSocialUserConnect($socialtype,array('id','social_id','name','user_name','location','image','user_token','user_token_secret'));
	$oauth_token=$twitterdata[0]['user_token'];
	$oauth_token_secret=$twitterdata[0]['user_token_secret'];
	$settings = array(
    'oauth_access_token' =>$oauth_token,
    'oauth_access_token_secret' => $oauth_token_secret,
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);
$RedirectUrl = "viewLead.php?curP=" . $_GET['curP'] . "&module=Socialcrm";
//$addedleadCrm=$objsocialcrm->getSocialLead('twitter',array('id'));
//print_r($addedleadCrm); 

if ($_POST) {
    if (sizeof($_POST['socialID'] > 0)) {
        $lead = implode(",", $_POST['socialID']);
        $_SESSION['mess_lead'] = LEAD_REMOVE_MULTIPLE;
       // $objsocialcrm->deleteLead($lead,'twitter');
        header("location:" . $RedirectUrl);
        exit;
    }
}

/* * ******************************************** */

if (!empty($_GET['del_id'])) {
    $objsocialcrm->deleteSocialLead($_GET['del_id'],$socialtype);
    header("location:viewTwitterContact.php");
    exit;
}

/*********************Set Defult ************/
$arrySocial = $objsocialcrm->SocialLeadList($socialtype,'', $_GET['key'], $_GET['sortby'], $_GET['asc']);
   


$num = $objsocialcrm->numRows();
$pagerLink = $objPager->getPager($arrySocial, $RecordsPerPage, $_GET['curP']);
(count($arrySocial) > 0) ? ($arrySocial = $objPager->getPageRecords()) : ("");
$_GET['Status']=1;$_GET['Division']=5;

require_once("../includes/footer.php"); 
?>






