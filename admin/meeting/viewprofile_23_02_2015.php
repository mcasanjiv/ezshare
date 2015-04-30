<?php
$FancyBox=1;
$HideNavigation=1;
//require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once($Prefix."classes/socialCrm.class.php");

// start facebook library
$type=!empty($_GET['type'])?$_GET['type']:'';
$userid=!empty($_GET['id'])?$_GET['id']:'';
	if($type=='facebook'){
	require_once(_ROOT."/lib/facebook/src/facebookSearcher.class.php");
	require_once(_ROOT."/lib/facebook/src/facebook.php");
	// end facebook library
	$objsocialcrm=new socialcrm();
	
	// Create our Application instance (replace this with your appId and secret).
	
	$facebook = new Facebook(array(
	  'appId'  => '211257059004768',
	  'secret' => '665bfd2c2b00202414ee26933d839756',
	));
	$data=$facebook->api('/'.$userid.'?fields=id,name,first_name,last_name,picture,link');
	if(!empty($data))
	$data['image']=$data['picture']['data']['url'];
	}elseif($type=='twitter'){
		require_once(_ROOT."/lib/twitter/TwitterAPIExchange.php");	
			/********************************** Start Twitter Api **************************/
		require_once(_ROOT.'/lib/twitter/twitteroauth.php');
		require_once(_ROOT.'/lib/twitter/Twitterconfig.php');
		$oauth_token_secret=$oauth_token='';
		$objsocialcrm=new socialcrm();
		$data=$twitterdata=array();	
		$twitterdata=$objsocialcrm->getSocialUserConnect('twitter',array('id','social_id','name','user_name','location','image','user_token','user_token_secret'));
		$oauth_token=$twitterdata[0]['user_token'];
		$oauth_token_secret=$twitterdata[0]['user_token_secret'];
		$settings = array(
	    'oauth_access_token' =>$oauth_token,
	    'oauth_access_token_secret' => $oauth_token_secret,
	    'consumer_key' => "JYGTiQSb5113Ii1mWjUEaeWwp",
	    'consumer_secret' => "opxQhMghRlzDHetREWiwkt45tTbVQHd02LEaCcoNzE8de9gt8E"
		);		
		$url="https://api.twitter.com/1.1/users/show.json";
		$getfield = '?user_id='.$userid;
		$requestMethod = 'GET';
		$twitter = new TwitterAPIExchange($settings);
		$aaa= $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();           
           $results=json_decode($aaa);
        $data = (array) $results;
     
      $data['image']=$data['profile_image_url'];
	}elseif($type=='linkedin'){
	$objsocialcrm=new socialcrm();
	
		 require_once(_ROOT.'/lib/linkedin/linkedin_3.2.0.class.php');
		  $API_CONFIG = array(
	      'appKey'       => '75pnp6i91ecr8l',
		  'appSecret'    => 'rW8BgG9sPpQvaEvi',
		  'callbackUrl'  => NULL 
  			);
		$Linkedindata=array();
		$oauth_token_linkedin=$oauth_token_linkedin='';
		$Linkedindata=$objsocialcrm->getSocialUserConnect('linkedin',array('id','social_id','name','user_name','location','image','user_token','user_token_secret'));
		
		$oauth_token_linkedin=$Linkedindata[0]['user_token'];
		$oauth_token_secret_linkedin=$Linkedindata[0]['user_token_secret'];
		$OBJ_linkedin = new LinkedIn($API_CONFIG);
	  //echo $_SESSION['oauth']['linkedin']['access'];
	  $access['oauth_token']=$oauth_token_linkedin;
	  $access['oauth_token_secret']=$oauth_token_secret_linkedin;
	  $access['oauth_expires_in']='5183999';
	  $access['oauth_authorization_expires_in']='5183999';	 	 
      $OBJ_linkedin->setTokenAccess($access);
      $response = $OBJ_linkedin->connections('people/id='.$userid);
      $connections = new SimpleXMLElement($response['linkedin']);   
    
	}












require_once("../includes/footer.php"); 
?>






