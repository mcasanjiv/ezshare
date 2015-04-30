<? if (!empty($_GET['view'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryLead[0]['FirstName'])?> &nbsp; <?=stripslashes($arryLead[0]['LastName'])?>
  </h4>
  <div class="right_box">
   <ul class="rightlink">	
       <li <?=($_GET['tab']=="Lead")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Lead"><b>Lead Details</b></a></li>
       <!-- <li <?=($_GET['tab']=="Event")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Event"><b>Event</b></a></li>-->
        <!--<li <?=($_GET['tab']=="Task")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Task"><b>Task</b></a></li>-->
        <!--<li <?=($_GET['tab']=="Ticket")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Ticket"><b>Ticket</b></a></li>-->
         <li <?=($_GET['tab']=="Campaign")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Campaign"><b>Campaigns</b></a></li>  
         <li <?=($_GET['tab']=="Comments ")?("class='active'"):("");?>><a href="<?=$ViewUrl?>Comments "><b>Comments </b></a></li>  
        <li <?=($_GET['tab']=="ConvertLead")?("class='active'"):("");?>><a class="fancybox" href="#Convert_div"><b>Convert Lead</b></a></li>
        <li <?=($_GET['tab']=="Document")?("class='active'"):("");?>><a href="<?=$docUrl?>Document&parent_type=<?=$Module?>&parentID=<?=$_GET['view']?>"><b>Add Document</b></a></li>
	</ul>
  </div>
 <h4> <font color="darkred" style="font-size:11px;">
    <?  if($createdEMP[0]['CmpID']>0){ ?>
    
    					
								<?php echo "Created By : Administrator on ".date($Config['DateFormat'],strtotime($arryLead[0]['UpdatedDate'])).""; ?>
								
							
    <? } else{
	 echo "Created By : ".$createdEMP[0]['UserName']." [".$createdEMP[0]['Department']."] on ".date($Config['DateFormat'],strtotime($arryLead[0]['UpdatedDate'])).""; 
	/*echo "<pre>";
	print_r($arryLead);*/
	}?>
    </font><h4>
  
  
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
