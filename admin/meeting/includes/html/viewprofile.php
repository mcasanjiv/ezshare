
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
		.Socialhad{background-color: #406697; color: #fff;}
		.profile-box{}
		.profile-box .pdata {
      
       
       }
    
     .profile-box .pdata .pcontent { font-size:15px !important; color:#005DBD; margin-left: 12px;}
     .profile-box .pdata .pcontentd{ font-size:15px !important; color:#000; margin-left: 12px;}
     
          .profile-box .image-ul {
            width:25%;
            margin-top: 5px;
            float: left;
            height: 150px;
             }



 .pcoln { }
 .plable{font-size:15px !important; color:#000; width:110px; display: inline-block;}
</style>

<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
</head>
<body style="width:400px">

<script>


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
<div class="Hwrap" style="min-height:150px; width: 100%;">
<?php if($_GET['type'] == "facebook"){ ?>
    <div class="had Socialhad">Facebook Profile</div>
<?php }elseif($_GET['type'] == "twitter"){ ?>
<div class="had Socialhad">Twitter Profile</div>
<?php }elseif($_GET['type'] == "linkedin") { ?>
<div class="had Socialhad">Linkedin Profile</div>
<?php }else { ?>
<div class="had Socialhad" style="display:none"></div>
<?php } ?>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="borderall">
<tr>
<td align="left" width="20%"><?php echo '<img style="border-radius: 35px !important; margin-left: 25px; margin-top: 10px;" src="'.$data['image'].'" alt="'.$data['first_name'].'" width="70">';?></td>

<td align="right">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td  align="right"   class="blackbold" >Name : </td>
<td   align="left" ><?php echo $data['name'];?></td>
</tr>
<tr>
<?php if(!empty($data['link'])){?>
<td  align="right"   class="blackbold" >Url : </td>

<td   align="left" ><a class="pcontentd" href="<?php echo $data['link']?>" target="_blank"><?php echo $data['link']?></a></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['gender'])){?>
<td  align="right"   class="blackbold" >Gender : </td>

<td   align="left" ><?php echo $data['gender'];?></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['location'])){?>
<td  align="right"   class="blackbold" >Location : </td>

<td   align="left" ><?php echo $data['location'];?></span></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['description'])){?>
<td  align="right"   class="blackbold" >Description : </td>

<td   align="left" ><?php echo $data['description'];?></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['followers_count'])){?>
<td  align="right"   class="blackbold" >Follower : </td>

<td   align="left" ><?php echo $data['followers_count'];?></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['friends_count'])){?>
<td  align="right"   class="blackbold" >Friends : </td>

<td   align="left" ><?php echo $data['friends_count'];?></td>
<?php }?>
</tr>
<tr>
<?php if(!empty($data['statuses_count'])){?>
<td  align="right"   class="blackbold" >Statuses Count : </td>

<td   align="left" ><?php echo $data['statuses_count'];?></td>
<?php }?>
</tr>

</table>
</td>
</tr>
</table>
</div>








<script>
function SaveSocialData(obj,id,type){
	
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
	}

</script>




