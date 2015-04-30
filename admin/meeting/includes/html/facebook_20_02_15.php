
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<style>

	.ui-widget-overlay{
		opacity: 0.6 !important;
	}	
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}

</style>

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<body>

<script>
jQuery(document).ready(function() {
    
$("#opener").click(function() {
	jQuery("#dialog").dialog(opt).dialog("open");
});
});

function addtocrm(iduser) {
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 415,
        height:150,
        title: 'Add User'
       };
	 
	var divID =  ".adduser_"+iduser;
	jQuery(divID).dialog(opt).dialog("open");
	jQuery(divID).show();
	
}

function addtoexistingcrm(iduser) {
	
	var opt = {
        autoOpen: false,
        modal: true,
        width: 415,
        height:150,
        title: 'Add Existing User'
       };
	var divID =  ".addexistinguser_"+iduser;
	jQuery(divID).dialog(opt).dialog("open");
	jQuery(divID).show();
	   
}	   
</script>

<div class="had">Facebook</div>
<!--  start code for facebook login    -->
<script>

$(document).ready(function() {
     // alert("document ready occurred!");
	  //$(document).load(checkLoginState);
	  checkLoginState();
});
  $("#load_div").hide();
 
  // This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
	  
    //console.log('statusChangeCallback');
   // console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
	//var uid = response.authResponse.userID;
	//alert("connected");
    var accessToken = response.authResponse.accessToken;
	$("#token").val(accessToken);
	$("#login").fadeOut();
	$("#fblogut").fadeIn();
	
	if(accessToken){
		$("#searchfbbox").fadeIn();
		
	}else{
		$("#searchfbbox").fadeOut();
	}
//	console.log('Access Token' + accessToken);
      testAPI();
    } else if (response.status === 'not_authorized') {
		//alert("not_authorized");
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    } else {
		//alert("notconnected");
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
	$("#login").fadeIn();
	$("#fblogut").fadeOut();
      document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook. After that you can serach person in facebook';
    }
  }

  // This function is called when someone finishes with the Login
  // Button.  See the onlogin handler attached to it in the sample
  // code below.
  function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }

  window.fbAsyncInit = function() {
  FB.init({
     appId      : '211257059004768',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });

  // Now that we've initialized the JavaScript SDK, we call 
  // FB.getLoginStatus().  This function gets the state of the
  // person visiting this page and can return one of three states to
  // the callback you provide.  They can be:
  //
  // 1. Logged into your app ('connected')
  // 2. Logged into Facebook, but not your app ('not_authorized')
  // 3. Not logged into Facebook and can't tell if they are logged into
  //    your app or not.
  //
  // These three cases are handled in the callback function.

  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });

  };

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Here we run a very simple test of the Graph API after login is
  // successful.  See statusChangeCallback() for when this call is made.
  function testAPI() {
	  //alert("asdjasjdnakjn");
   // console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
	  
      
	   
      //console.log('Successful login for: ' + response.name);
      document.getElementById('status').innerHTML = 'Thanks for logging in, ' + response.name + '!';
    });
  }
  
function logout() {
FB.logout(function(response) {
// user is now logged out
});
$("#login").fadeIn();
$("#fblogut").fadeOut();
document.getElementById('status').innerHTML = 'Please log ' + 'into Facebook. After that you can serach person in facebook';
 //$("#load_div").hide();
 $("#searchfbbox").fadeOut();
}
  
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->

<div id="fb-root"></div>

<div id="login">
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
</div>

<div id="fblogut"> 
<button onclick="javascript:logout();" class="fblogout" ></button>
</div>

<div id="status"></div>
<!--  end code for facebook login    -->


<div id="Event" >
<? if($ModifyLabel==1){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right">		
			<a class="fancybox add_quick" href="viewFacebookContact.php">Existing Profile</a>
			  <a class="fancybox add_quick" href="viewFacebookPost.php">Post List</a>
			    <a class="fancybox add_quick" href="facebook-friends.php">Friends List</a>
		  
    	</td>
		</tr>



<tr>

    <td  align="center" valign="top" style="display:none;" id="searchfbbox">
			 <form action="" method="get">
				<div class="search-box"><label>Search User</label>
				<input type="text" name="q" value="<?php echo !empty($_GET['q'])?$_GET['q']:'';?>" />
				<input type="hidden" name="access_token" id="token" value="<?php echo !empty($_GET['access_token'])?$_GET['access_token']:'';?>" />
				<input type="submit" value="search" class="btn-search"></div>
			 </form>
			  <? if (!empty($_SESSION['mess_social'])) {?>
<div>
<span  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
</span>
</div>
<? } ?>
        <form name="form1" action="" id="socialfrom"  method="post"  enctype="multipart/form-data">
		<div>
		
		<?php if(!empty($search_user['userdata'])){
		
			
			
		echo '<h2 class="search-result">Search Results:</h2>';	
		echo '<ul class="paging">';
		
		if($search_user['paging']->previous){
		$pre_paging   = explode('search?',$search_user['paging']->previous);
		echo '<li class="prev-page"><a href="http://app01.eznetcrm.com/erp/admin/crm/facebook.php?'.$pre_paging[1].'"><< Prev</a></li>';
		}
		if($search_user['paging']->next){
			$next_paging   = explode('search?',$search_user['paging']->next);
			
		echo '<li class="next-page"><a href="http://app01.eznetcrm.com/erp/admin/crm/facebook.php?'.$next_paging[1].'">Next >></a></li>';
		}
		
		echo '</ul>';
		
			echo '<ul class="user-list">';
		$i=0;
			foreach($search_user['userdata'] as $result){
				if($result['id']){
					echo '<li>';
					echo '<div><img src="https://graph.facebook.com/'.$result['id'].'/picture">
					<span class="checkbox-user">
			<!--<a href="javascript:void(0);" onclick="jQuery(this).parents(\'li\').find(\'.add-dashboard\').toggleClass(\'active\')">Add To CRM</a> -->
			       <a href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')">Add New</a>|
			       <a href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')">Add Existing</a>';
				   
				     if(in_array($result['id'],$all_result)){
      		          echo  '<input type="checkbox" name="userid" onclick="return false" checked style="margin-left: 6px;">';
				     }
					 
					 
					echo '</span></div>';
					echo '<div><label>Id :</label>&nbsp;'.$result['id'].'</div>';
					echo '<div><label>Name :</label>&nbsp;'.$result['name'].'</div>';
					echo '<div><label>Screen Name :</label>&nbsp;'.$result['username'].'</div>';
					echo '<div><label>Location :</label>&nbsp;'.$result['locale'].'</div>';	
					echo '<div><label>Gender :</label>&nbsp;'.$result['gender'].'</div>';	
					echo '<div class="profile"><a href="'.$result['link'].'" target="_blank">Profile</a></div>';
		# start for Existing			
		echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
        if(in_array($result['id'],$contact_result)){	
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
        } else{ 
		echo '<a href="searchContact.php?type=facebook&sid='.$result['id'].'&FirstName='.$result['first_name'].'&LastName='.$result['last_name'].'&FullName='.$result['name'].'&Gender='.$result['gender'].'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
		}
		
		if(in_array($result['id'],$customer_result)){
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
		}else{	
		echo '<a href="searchCustomer.php?type=facebook&sid='.$result['id'].'&FirstName='.$result['first_name'].'&LastName='.$result['last_name'].'&FullName='.$result['name'].'&Gender='.$result['gender'].'" class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
		}
		echo'</div></div>';
		# start for new 		
			echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
			if(in_array($result['id'],$contact_result)){			  
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

			}else{
			echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
			}

			if(in_array($result['id'],$customer_result)){
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
			}else{

			echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
			}
			echo  '</div></div>';
			}
			 $i++;
			}
			echo '</ul>';
			echo '<div class="form-action">
				   <input type="hidden" class="userid-set" name="userid[]">
				   <input type="hidden" class="action-type" name="action-type">
				   <input type="submit" value="Add Contact" style="display:none;"/>
				  </div>';

		  }else {			
			 if(!empty($_GET['q']))
				echo 'No Results Found';
		  }?>

		
</td>
   </tr>
   </div>

   </form>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>


<script>
function SaveSocialData(obj,id,type){
	
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
	}

</script>




