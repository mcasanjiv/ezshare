

<link href='fullcalendar/socialfbtwlin.css' rel='stylesheet' />
<a class="back" href="Linkedin.php">Back</a>
<a href="viewLinkedinPost.php" class="fancybox add_quick">Post List</a>
<div class="had">Connection List </div>
<? if (!empty($_SESSION['mess_social'])) {?>
			<div>
			<span  align="center"  class="message"  >
				<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
			</span>
			</div>
			<? } ?>
<form name="form1" action=""  method="post" id="socialfrom" enctype="multipart/form-data">
<?php
if($response['success'] === TRUE) {

              $connections = new SimpleXMLElement($response['linkedin']); 
//echo "<pre>";print_r($connections->person);die;			  
            
              if((int)$connections['total'] > 0) {
                ?>
               <!--  <p>First <?php echo CONNECTION_COUNT;?> of <?php echo $connections['total'];?> total connections being displayed:</p>-->

                <form id="linkedin_cmessage_form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                  <input type="hidden" name="<?php echo LINKEDIN::_GET_TYPE;?>" id="<?php echo LINKEDIN::_GET_TYPE;?>" value="message" />
                  <?php
                  	echo '<ul class="user-list">';
                  	$i=0;
                  foreach($connections->person as $connection) {          
                    	echo '<li>';
                    	
		echo '<div class="box-header">';
		 if($connection->{'picture-url'}) {
			echo '<span><img src="'.$connection->{'picture-url'}.'"></span>';
		 }else{
		 echo '<span><img src="'._SiteUrl.'images/nouser.jpg" width="70"></span>';
		 }
		 
	echo '<span class="twitter-profile"><a href="'.$connection->{'site-standard-profile-request'}->url.'" target="_blank">Profile</a></span><span class="checkbox-user"><a href="javascript:void(0);" onclick="jQuery(this).parents(\'li\').find(\'.add-dashboard\').toggleClass(\'active\')">Add To CRM</a><!--<input type="checkbox" name="userid[]" value="'.$i.'">--></span></div>';
    echo '<div><label>Id :</label>'.$connection->id.'</div>';
	echo '<div><label>First Name :</label>'.$connection->{'first-name'}.'</div>';
	echo '<div><label>Last Name :</label>'.$connection->{'last-name'}.'</div>';
	if(!empty($connection->location->name)){
		echo '<div><label>Location :</label>'.$connection->location->name.'</div>';	
	}	
	echo '<div class="add-dashboard">
			<a href="searchContact.php?type=linkedin&sid='.$connection->id.'&uname=&url='.urlencode($connection->{'site-standard-profile-request'}->url).'" class="fancybox fancybox.iframe">Add Existing Contact</a>|
			<a href="searchContact.php?type=linkedin&sid='.$connection->id.'&uname=&url='.urlencode($connection->{'site-standard-profile-request'}->url).'" class="fancybox fancybox.iframe">Add Existing Customers</a>|
			<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_contact\')">Add New Contact</a>| 
			<a href="javascript:void(0)" onclick="SaveSocialData(this,\''.$i.'\',\'add_customer\')">Add New Customers</a>
			</div>';	
		
	echo '</li>';  $i++;}
	echo '</ul>';
	echo '<div class="form-action">
	       <input type="hidden" class="userid-set" name="userid[]">
		   <input type="hidden" class="action-type" name="action-type">
		   <input type="submit" value="Add Contact" style="display:none;" />
		   </div>';
	?>
                </form>
                <?php
              } else {
                // no connections
                echo '<div>You do not have any LinkedIn connections to display.</div>';
              }
            } else {
            // request failed
            echo "<div style='color: red;font-size: 18px;'>Please Connect to Linkedin</div>";
            }
            ?>
			   </form>
 <script>
function SaveSocialData(obj, id, type){
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	}

</script>         
