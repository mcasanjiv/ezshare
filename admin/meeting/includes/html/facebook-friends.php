<script>
function SaveSocialData(obj, id, type){
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	}

</script>
<style>
    .fblogout {margin-top: 0px !important;}
    #fblogut {margin-bottom: 65px; margin-right: 1px; margin-top: 2px;}
   
</style>
<body>
<link href='fullcalendar/facebook-page.css' rel='stylesheet' />
<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

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
		$("#postinfo").fadeIn();
		
	}else{
		$("#postinfo").fadeOut();
	}
//	console.log('Access Token' + accessToken);
      testAPI();
    } else if (response.status === 'not_authorized') {
		//alert("not_authorized");
      // The person is logged into Facebook, but not your app.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
		$("#postinfo").fadeOut();
    } else {
		//alert("notconnected");
      // The person is not logged into Facebook, so we're not sure if
      // they are logged into this app or not.
	$("#login").fadeIn();
	$("#fblogut").fadeOut();
      document.getElementById('status').innerHTML = '';
	  $("#postinfo").fadeOut();
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
      document.getElementById('status').innerHTML = ' ' + response.name + '!';
    });
  }
  
function logout() {
FB.logout(function(response) {
// user is now logged out
});
$("#login").fadeIn();
$("#fblogut").fadeOut();
document.getElementById('status').innerHTML = '';
 //$("#load_div").hide();
 $("#postinfo").fadeOut();
}
  
</script>

<!--
  Below we include the Login Button social plugin. This button uses
  the JavaScript SDK to present a graphical Login button that triggers
  the FB.login() function when clicked.
-->



<div id="login">
    <div class="had" style="float:left;">Friends List </div>
 <!--
<fb:login-button scope="public_profile,email,user_friends,user_birthday,user_hometown,user_location,read_friendlists" onlogin="checkLoginState();"></fb:login-button>
 -->
</div>
 


<div id="fblogut">
 <div class="had" style="float:left;">Friends List </div>
<button onclick="javascript:logout();" class="fblogout" ></button>
</div>
<a class="back" href="javascript:void(0)" onclick="window.history.back();">Back</a>


<div id="status"></div>
<div id="login" style="text-align: center; margin-top: 76px;">

<button onclick="checkLoginState();" class="fblogin" style="float:none;" ></button>

<!--
<fb:login-button scope="public_profile,email,user_friends,user_birthday,user_hometown,user_location,read_friendlists" onlogin="checkLoginState();"></fb:login-button>
-->
</div> 
<!--  end code for facebook login    -->

<div id ="postinfo">
<TABLE WIDTH="100%"   BORDER=0 align="center"  >
  
<tr>
<td align="left" valign="top">
 <form name="form1" action=""  method="post" id="socialfrom" enctype="multipart/form-data">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">

   <? if (!empty($_SESSION['mess_social'])) {?>
<tr>
<td  align="center"  class="message"  >
	<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
</td>
</tr>
<? } ?>
  
		<tr>
		<td>
		<div class="user-container social">
		<?php 
		 if(!empty($user_profile['data'])){
		echo '<ul class="user-list">';
		$i=0;
		
		 foreach($user_profile['data'] as $userid){
		 unset($result);
			 $result = $facebook->api('/'.$userid['id']);
				if($result['id']){
					echo '<li>';
					echo '<div class="top"><div class="image-set"><span class="pimg"><img src="https://graph.facebook.com/'.$result['id'].'/picture"></span>';
                                        echo '</span></div>';
						echo '<div class="detail-box"><div class="pfname"><a href="'.$result['link'].'" target="_blank">'.$result['name'].'</a></div><div class="pbtn">
                                                <span class="view-profile"><a href="'.$result['link'].'" target="_blank" title="View Facebook Profile"></a></span>
						<span class="add-profile"><a title="Add New" href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')"></a></span>
			                        <span class="exiting-profile"><a title="Add Existing" href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')"></a></sapn>';
				   
					if(in_array($result['id'],$all_result)){
      		          echo  '<input type="checkbox" name="userid" onclick="return false" checked style="margin-left: 6px;">';
				     }
					 
					echo '</div></div></div>';
					echo '<div class="down"><div class="plable-data"><div class="pdata"><label>Id :</label>&nbsp;'.$result['id'].'</div>';
					
					echo '<div><label>Screen Name :</label>&nbsp;'.$result['username'].'</div>';
					
					echo '<div><label>Gender :</label>&nbsp;'.$result['gender'].'</div></div></div>';	
					
					
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
					echo '</li>';
			  }
			 $i++;
			}
			echo '</ul>';
			echo '<div class="form-action">
					<input type="hidden" class="userid-set" name="userid[]">
					<input type="hidden" class="action-type" name="action-type">
					<input style="display:none;" type="submit" value="Add Contact" style="display:none;"/></div>';
		 }
			?>
			</div>
			</td>
		</tr>

		<tr>
			<td  align="center" >
			
			<!-- <div id="SubmitDiv" style="display:none1">
			<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
			<input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />
			</div>-->
			</td>
		</tr>
   
   
</table></form>
	</td>
    </tr>
 
</table>
</div>

