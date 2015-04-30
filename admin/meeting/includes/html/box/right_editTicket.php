	
<? if (!empty($_GET['edit'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryTicket[0]['title'])?>
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
       <li  <?=($_GET['tab']=="Information")?("class='active'"):("");?>><a href="<?=$EditUrl?>Information">Edit  Information</a></li>
        <li <?=($_GET['tab']=="Description")?("class='active'"):("");?>><a href="<?=$EditUrl?>Description">Edit Description </a></li>
       
        <li <?=($_GET['tab']=="Resolution")?("class='active'"):("");?>><a href="<?=$EditUrl?>Resolution">Edit Resolution</a></li>
        <!--<li <?=($_GET['tab']=="Comment")?("class='active'"):("");?>><a href="<?=$EditUrl?>Comment">Comment</a></li>-->
	</ul>
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
