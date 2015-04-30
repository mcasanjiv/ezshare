<script>
function SaveSocialData(obj, id, type){
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	}

</script>
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">
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
<body>
<div class="had">Twitter</div>
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

<div id="Event" >
<div class="had">Twitter</div>
<? if($ModifyLabel==1){?>
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<tr>
 
        <td align="right">		
       	 <a class="fancybox add_quick" href="postTwitter.php">Tweet</a>
	      <a class="fancybox add_quick" href="viewTwitterPost.php">Tweet List</a>
	      <a class="add" href="viewTwitterContact.php">Contact List</a>
	          <a class="add" href="twitter-follower.php">Follower List</a>
	 	 </td>
 </tr>
 <tr>
  <td align="left">		
	  <?php    echo '</ul>';
	echo '<ul class="header-user-board">';
	$i=0;
	
	if(!empty($twitterdata[0]['user_token']) AND !empty($twitterdata[0]['user_token_secret'])){	
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

if(!empty($results)){
	echo '<h2 class="search-result">Search Results:</h2>';
echo '<ul class="paging">';
if($page>1){
echo '<li class="prev-page"><a href="?q='.$_GET['q'].'&page='.($page+1).'"><< Prev</a></li>';
}
if(count($results)>=20 ){
echo '<li class="next-page"><a href="?q='.$_GET['q'].'&page='.($page+1).'">Next >></a></li>';
}
echo '</ul>';
	echo '<ul class="user-list">';
	$i=0;
	foreach($results as $result){	
		echo '<li>';
		echo '<div class="box-header"><span><img src="'.$result->profile_image_url.'"></span>
		<span class="twitter-profile"><a href="https://twitter.com/'.$result->screen_name.'" target="_blank">Profile</a></span>
		<span class="checkbox-user">
		<a href="javascript:void(0);" onclick="addtocrm(\''.$i.'\')">Add New</a>|
		<a href="javascript:void(0);" onclick="addtoexistingcrm(\''.$i.'\')">Add Existing</a>';
		
		if(in_array($result->id,$all_result)){
		echo  '<input type="checkbox" name="userid" onclick="return false" checked style="margin-left: 6px;">';
		}
		
		echo '</span></div>';	
		echo '<div><label>Id :</label>&nbsp;'.$result->id.'</div>';
		echo '<div><label>Name :</label>&nbsp;'.$result->name.'</div>';
		echo '<div><label>Screen Name :</label>&nbsp;'.$result->screen_name.'</div>';
		echo '<div><label>Location :</label>&nbsp;'.$result->location.'</div>';
		echo '<div><label>followers count :</label>&nbsp;'.$result->followers_count.'</div>';	
		echo '<div><label>friends count :</label>&nbsp;'.$result->friends_count.'</div>';
	
	# start for Existing			
		echo '<div class="addexistinguser_'.$i.'" style="display:none;"><div style="margin-top: 37px; text-align: center;"">';
		if(in_array($result->id,$contact_result)){	
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Contact</a>';  
		} else{ 
		echo '<a href="searchContact.php?type=twitter&sid='.$result->id.'&FullName='.$result->name.'&Location='.$result->location.'" class="fancybox fancybox.iframe btn-social">Existing Contact</a>';
		}

		if(in_array($result->id,$customer_result)){
		echo '<a href="javascript:void(0)" class="btn-social noactive">Already Existing Customer</a>';  
		}else{	
		echo '<a href="searchCustomer.php?type=twitter&sid='.$result->id.'&FullName='.$result->name.'&Location='.$result->location.'"  class="fancybox fancybox.iframe btn-social">Existing Customer</a>';
		}
		echo'</div></div>';
# start for new 		
			echo '<div class="adduser_'.$i.'" style="display:none; "><div style="margin-top: 37px; text-align: center;">';
			if(in_array($result->id,$contact_result)){			  
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Contact</a>';  

			}else{
			echo  '<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_contact\')" class="btn-social">Add New Contact</a>';
			}

			if(in_array($result->id,$customer_result)){
			echo '<a href="javascript:void(0)" class="btn-social noactive">Already Added Customer</a>';  
			}else{

			echo' <a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_customer\')" class="btn-social">Add New Customer</a>';
			}
			echo  '</div></div>';			
	echo '</li>';
	$i++;
	
	}
	echo '</ul>';
	echo '<div class="form-action">
	       <input type="hidden" class="userid-set" name="userid[]">
		   <input type="hidden" class="action-type" name="action-type">
	       <input type="submit" value="Add Contact" style="display:none;"/></div>';
	

}else{
	if(!empty($_GET['q']))
	echo 'No Results Found';
}?>

</div>
<?php }else{

echo '<div class="twitter-login-button"><div class="social-login-box">
<a href="'._SiteUrl.'admin/crm/Twitter.php?action=redirect"><img src="images/LoginTwitter.png"></a></div></div>';

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


