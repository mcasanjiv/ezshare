<?php
$FancyBox=1;
$ThisPageName = 'Twitter.php';

require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once($Prefix."classes/lead.class.php");
require_once($Prefix."classes/region.class.php");
require_once($Prefix."classes/employee.class.php");
require_once($Prefix."classes/event.class.php");
require_once($Prefix."classes/group.class.php");
require_once($Prefix."classes/crm.class.php");
require_once(_ROOT."/lib/twitter/TwitterAPIExchange.php");
require_once($Prefix."classes/socialCrm.class.php");
require_once($Prefix."classes/sales.customer.class.php");

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
/*$settings = array(
    'oauth_access_token' => "91994325-OAubhTHOazHdFt8TSawnaXLbR1aiJlRuw952XtSOC",
    'oauth_access_token_secret' => "AgL3Tpw5ikJbY87T1Y1ent8kGCuxCs56rUkrjrCb5dBaD",
    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
);*/

$results=array();
$page=!empty($_GET['page'])?$_GET['page']:1;

$url="https://api.twitter.com/1.1/followers/list.json";
$getfield = '?screen_name='.$twitterdata[0]['user_name'].'&count=200';
 
$requestMethod = 'GET';
$twitter = new TwitterAPIExchange($settings);
$aaa= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();
            
           $results=json_decode($aaa);
        

	
	//echo "<pre>";print_r($results);die;


if($_POST){
	
	//echo "<pre>";print_r($results);
	//echo "<pre>";print_r($_POST);
	$type = $_POST['action-type'];
	//echo 'ppp'.$_POST['userid'][0];
	$post_data = $results->users[$_POST['userid'][0]];
	///echo "<pre>";print_r($post_data);
	//echo "111111111";
	$userexist =  $objsocialcrm->checkUserexist($post_data->id);
	//echo "22222222222";
	//die;
	if($userexist==true){
		//echo "33333333333";die;
	$fLname = explode(' ',$post_data->name);
	$data['FirstName'] = $fLname[0];
	$data['LastName'] = $fLname[1];
	
	$data['FullName'] = $post_data->name;
	//$data['Gender'] =  ucfirst($post_data['gender']);
	$data['RigisterType'] =  'twitter';
	$data['RigisterTypeID'] =  $post_data->id;
	$addCustId =   $objsocialcrm->SaveSocialData($data,$type);
		if($addCustId){
			
			
		  $_SESSION['mess_social']='<div class="success">Added Successfully</div>';
		  header('Location: ' ._SiteUrl.'admin/crm/twitter-follower.php' );
		die;
		}
	}else{
		
		$_SESSION['mess_social']='<div class="errors">User already exist.</div>';
		  header('Location: ' ._SiteUrl.'admin/crm/twitter-follower.php' );
		die;
		
	}
	
}	
	
			
/*
$savedata=$res=$addedleadCrm=$socialids=array();

if(!empty($_POST['userid']) AND !empty($results->users)){


	$addedleadCrm=$objsocialcrm->getSocialLead('twitter',array('id','social_id'));
	
	if(!empty($addedleadCrm)){
		foreach($addedleadCrm as $addedlead){		
			$socialids[]=$addedlead['social_id'];
		}
	}

	foreach($_POST['userid'] as $id){
			if(!in_array($results->users[$id]->id,$socialids)){
			$res['social_type']='twitter';
			$res['social_id']=$results->users[$id]->id;
			$res['name']=$results->users[$id]->name;
			$res['user_name']=$results->users[$id]->screen_name;
			$res['location']=$results->users[$id]->location;
			$res['image']=addslashes($results->users[$id]->profile_image_url);	
			$savedata[]=$res;
			}else{
			$_SESSION['mess_social']='<div class="error">Already Added</div>';
			}
			
	}
	
}


if(!empty($savedata)){

	$objsocialcrm->InsertMultiUserLead($savedata);
	$_SESSION['mess_social']='<div class="success">Add To CRM  Successfully</div>';
	  header('Location: ' ._SiteUrl.'admin/crm/twitter-follower.php' ); 
	  die;
	  
}
*/

require_once("../includes/footer.php"); 
?>






