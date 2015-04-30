<?php
$FancyBox=1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/event.class.php");
require_once($Prefix."classes/group.class.php");
require_once($Prefix."classes/crm.class.php");
require_once(_ROOT."/lib/twitter/TwitterAPIExchange.php");
require_once($Prefix."classes/socialCrm.class.php");
/********************************** Start Twitter Api **************************/
	require_once(_ROOT.'/lib/twitter/twitteroauth.php');
	require_once(_ROOT.'/lib/twitter/Twitterconfig.php');
	$oauth_token_secret=$oauth_token='';
	$objsocialcrm=new socialcrm();
	$data=$twitterdata=array();	

	
	if(!empty($_GET['action']) AND $_GET['action']=='disassociate' AND !empty($_GET['id'])){
		$objsocialcrm->deleteSocialConnect($_GET['id'],'twitter');
		 header('Location: ' . _SiteUrl.'admin/crm/Twitter.php'); 	
		 die;
	}
	if(!empty($_GET['action']) AND $_GET['action']=='redirect'){
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET); 
		$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
		$_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret']; 
		switch ($connection->http_code) {
		  case 200:
		    $url = $connection->getAuthorizeURL($token);
		    header('Location: ' . $url); 
		    break;
		  default:
		    echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
		}
	if(!empty($_GET['action']) AND $_GET['action']=='callback'){
	
		if (isset($_REQUEST['oauth_token']) && $_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
				  $_SESSION['oauth_status'] = 'oldtoken';
				  $oauth_token=$_SESSION['oauth_token'];
				   $oauth_token_secret=$_SESSION['oauth_token_secret'];
				 unset($_SESSION['oauth_token']);
				 unset($_SESSION['oauth_token_secret']);
			}
			
			$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
			
			$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
			//save new access tocken array in session
			$_SESSION['access_token'] = $access_token;
			$content = $connection->get('account/verify_credentials');			
			$data['social_type']='twitter';
			$data['social_id']=$content->id;
			$data['name']=$content->name;
			$data['user_name']=$content->screen_name;
			$data['location']=$content->location;
			$data['image']=$content->profile_image_url;
			$data['user_token']=$access_token['oauth_token'];
			$data['user_token_secret']=$access_token['oauth_token_secret'];
			$data['user_data']=serialize($content);
			$check=$objsocialcrm->getSocialUserConnect('twitter',array('id'));			
			if(empty($check[0]['id']))
			$objsocialcrm->SaveSocialConnect($data);
			else
			$objsocialcrm->UpdateSocialConnect($data,array('id'=>$check[0]['id']));
			unset($_SESSION['oauth_token']);
			unset($_SESSION['oauth_token_secret']);			
			if (200 == $connection->http_code) {
			  $_SESSION['status'] = 'verified';	
			  	  header('Location: ' . _SiteUrl.'admin/crm/Twitter.php'); 		
			} else {
			 unset($_SESSION['oauth_token']);
			 unset($_SESSION['oauth_token_secret']);
			}
	}
			/* ***********************End Twitter Api ****************************/
$objLead=new lead();
$objGroup=new group();
$objCommon=new common();
$objActivity=new activity();
$objRegion=new region();
$objEmployee=new employee();
$twitterdata=$objsocialcrm->getSocialUserConnect('twitter',array('id','social_id','name','user_name','location','image','user_token','user_token_secret'));
$oauth_token=$twitterdata[0]['user_token'];
$oauth_token_secret=$twitterdata[0]['user_token_secret'];
/*$settings = array(
    'oauth_access_token' => "2992271948-BW4tU4Tmx6bFaA7hCc3UB2ZCWocDi5QpihYpkYI",
    'oauth_access_token_secret' => "GW6FbHJh6Tu7sqr0Bs3GZZ3fmgV0dPxHJForLflXc6lze",
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);*/
	$settings = array(
    'oauth_access_token' =>$oauth_token,
    'oauth_access_token_secret' => $oauth_token_secret,
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);
$results=array();
$page=!empty($_GET['page'])?$_GET['page']:1;
if(!empty($_GET['q'])){
$url="https://api.twitter.com/1.1/users/search.json";
$getfield = '?q='.urlencode($_GET['q']).'&amp;page='.$page.'&amp;include_entities=true';
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$aaa= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
            
           $results=json_decode($aaa);
           
}
//echo '<pre>';


$savedata=$res=$addedleadCrm=$socialids=array();
if(!empty($_POST['userid']) AND !empty($results)){
	$addedleadCrm=$objsocialcrm->getSocialLead('twitter',array('id','social_id'));
	
	if(!empty($addedleadCrm)){
		foreach($addedleadCrm as $addedlead){		
			$socialids[]=$addedlead['social_id'];
		}
	}

	foreach($_POST['userid'] as $id){
			if(!in_array($results[$id]->id,$socialids)){
			$res['social_type']='twitter';
			$res['social_id']=$results[$id]->id;
			$res['name']=$results[$id]->name;
			$res['user_name']=$results[$id]->screen_name;
			$res['location']=$results[$id]->location;
			$res['image']=addslashes($results[$id]->profile_image_url);	
			$savedata[]=$res;
			}
	}
}

if(!empty($savedata)){

	$objsocialcrm->InsertMultiUserLead($savedata);
	$_SESSION['mess_social']='<div class="success">Add To CRM  Successfully</div>';
	  header('Location: ' ._SiteUrl.'admin/crm/Twitter.php?q='.$_GET['q'] ); 
	  die;
	  
}
//$addedleadCrm=$objsocialcrm->getSocialLead('twitter',array('id'));
//print_r($addedleadCrm); 
$_GET['Status']=1;$_GET['Division']=5;

require_once("../includes/footer.php"); 
?>






