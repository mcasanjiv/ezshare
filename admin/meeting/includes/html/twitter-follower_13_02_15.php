
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<style>

		
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

<div id="Event" >
<? if($ModifyLabel==1){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
 
        <td align="right">		
	      <a class="fancybox add_quick" href="viewTwitterPost.php">Tweet List</a>
	      <a class="add" href="viewTwitterContact.php">Contact List</a>
	   
	      
	 	 </td>
 </tr>
 <tr>
  <td align="left">		
	  <?php    echo '</ul>';
	echo '<ul class="header-user-board">';
	$i=0;
	if(!empty($twitterdata[0])){	
	echo '<li>';
	echo '<div class="image-box"><img src="'.$twitterdata[0]['image'].'"></div>';

	echo '<div class="name">'.$twitterdata[0]['name'].'</div>';
	echo '<div class="logout"><a href="'._SiteUrl.'admin/crm/Twitter.php?action=disassociate&id='.$twitterdata[0]['id'].'">Logout</a></div>';				
	echo '</li>';
	}
	echo '</ul>';?>
	      
	 	 </td>
 </tr>



<tr>
    <td  align="center" valign="top" >
    
    <?php if(!empty($settings['oauth_access_token']) AND !empty($settings['oauth_access_token_secret'])){?>
			<form action="" method="get">
				<div class="search-box"><label>Search User</label><input type="text" name="q" value="<?php echo !empty($_GET['q'])?$_GET['q']:'';?>" /><input type="submit" value="search" class="btn-search"></div>
			</form>
			<? if (!empty($_SESSION['mess_social'])) {?>
			<div>
			<span  align="center"  class="message"  >
				<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
			</span>
			</div>
			<? } ?>
<form name="form1" action=""  method="post" id="socialfrom" enctype="multipart/form-data">
<div> 

<?php 

if(!empty($results->users)){
	echo '<h2 class="search-result">Follower List:</h2>';
	echo '<ul class="user-list">';
	$i=0;
	foreach($results->users as $result){	
	echo '<li>';
	echo '<div class="box-header"><span><img src="'.$result->profile_image_url.'"></span><span class="twitter-profile"><a href="https://twitter.com/'.$result->screen_name.'" target="_blank">Profile</a></span><span class="checkbox-user"><a href="javascript:void(0);" onclick="jQuery(this).parents(\'li\').find(\'.add-dashboard\').toggleClass(\'active\')">Add To CRM</a><!--<input type="checkbox" name="userid[]" value="'.$i.'">--></span></div>';
	echo '<div><label>Id :</label>&nbsp;'.$result->id.'</div>';
	echo '<div><label>Name :</label>&nbsp;'.$result->name.'</div>';
	echo '<div><label>Screen Name :</label>&nbsp;'.$result->screen_name.'</div>';
	echo '<div><label>Location :</label>&nbsp;'.$result->location.'</div>';
	echo '<div><label>followers count :</label>&nbsp;'.$result->followers_count.'</div>';	
	echo '<div><label>friends count :</label>&nbsp;'.$result->friends_count.'</div>';
	echo '<div class="add-dashboard">
			<a href="searchContact.php?type=twitter&sid='.$result->id.'&uname='.urlencode($result->screen_name).'&url='.urlencode('https://twitter.com/'.$result->screen_name).'" class="fancybox fancybox.iframe">Existing Contact</a>|<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\')">Add New</a>
			<input type="text" onkeyup="searchContact(this)" class="contact-sear">
			</div>';			
	echo '</li>';
	$i++;
	
	}
	echo '</ul>';
	echo '<div class="form-action"><input type="hidden" class="userid-set" name="userid[]"><input style="display:none;" type="submit" value="Add Contact" /></div>';
	

}?>

</div>
<?php }else{

echo '<div class="twitter-login-button"><div class="social-login-box"><a href="'._SiteUrl.'admin/crm/Twitter.php?action=redirect"><img src="images/LoginTwitter.png"></a></div></div>';

}

?>
</td>
   </tr>

   </form>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>
<script>
function SaveSocialData(obj,id){
	jQuery('.userid-set').val(id);
	jQuery('#socialfrom').submit();
	}

</script>
