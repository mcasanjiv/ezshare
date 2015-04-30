<div class="main-container clearfix">
    <div class="main">
	
      <div class="my-dashboard-nav clearfix">
	  <h4 class="had">My <?=$ModuleName?></h4>

<? include("../includes/html/box/clock.php");
   include("../includes/html/box/icon.php");
                $WidthRow1 = 'width:270px;'; 
		$WidthRow2 = 'width:270px;'; 
		$WidthRow3 = 'width:380px;';
?>
       
      </div>
      <style>
	  
      .my-dashboard .new_lead tbody tr td a{ font-size:11px}
      </style>
      <div class="my-dashboard clearfix">
        <div class="rows clearfix">
<? /****************************************First Row *********************/ ?>
          <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block p_l_request">            
              <h3>New Lead</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                <tr class="head"> 	
                  <td class="darkcolor">Lead Name</td>
                  <td class="darkcolor">Lead Type</td>
                </tr>
                </thead>
            <?php  if(is_array($arryMyLead) && $num1>0){
						$flag=true;
						$Line=0;
						foreach($arryMyLead as $key=>$lead){
						$flag=!$flag;
						#$bgcolor=($flag)?("#FDFBFB"):("");
						$Line++;
						?>
                            <tbody>
                           <? echo '<tr class="even">
                              <td><a href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead">'.$lead['FirstName'].' '.$lead['LastName'].'</a></td>
                              <td ><a href="vLead.php?view='.$lead['leadID'].'&curP=1&module=lead">'.$lead['type'].'</a></td>
                            </tr>'; ?>
                          
                           <? } ?> 

                             <tr>
                           <td  colspan="2">
                           <a href="viewLead.php?module=lead">More..</a>
                           </td>
                           </tr> 
						   
                         
                     <? } else{?>
                           <tr>
                                <td  colspan="2">
                           <font color="darkred" >No Data Found.</font>
                           </td>
                           </tr>
                           <? }?>
                           
              </table>
             
            </div>
            </div>
          </div>
          <div class="second_col" style="<?=$WidthRow2?>">
             <div class="block p_l_request">            
              <h3>Top Opportunities</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <thead>
                <tr class="head"> 	
                  <td class="darkcolor">Opportunity Name</td>
                  <td class="darkcolor">Amount</td>
                </tr>
                </thead>
            <?php  if(is_array($arryTopOpp) && $num2>0){
						$flag=true;
						$Line=0;
						foreach($arryTopOpp as $key=>$opportunity){
						$flag=!$flag;
						#$bgcolor=($flag)?("#FDFBFB"):("");
						$Line++;
						?>
                            <tbody>
                           <? echo '<tr class="even">
                              <td><a href="vOpportunity.php?view='.$opportunity['OpportunityID'].'&module=Opportunity&curP=1">'.$opportunity['OpportunityName'].' </a></td>
                              <td ><a href="vOpportunity.php?view='.$opportunity['OpportunityID'].'&module=Opportunity&curP=1">'.$Config['Currency'].' '.$opportunity['Amount'].'</a></td>
                            </tr>'; ?>
                      
                           <? } ?>
 <tr>
                                <td  colspan="2">
                           <a href="viewOpportunity.php?module=Opportunity">More..</a>
                           </td>
                           </tr>
						      <? } else{?>
                               <tr>
                                <td  colspan="2">
                           <font color="darkred" >No Data Found.</font>
                           </td>
                           </tr>
                           <? }?>
                           
              </table>

            </div>
            </div>
          </div>
 <? if($_SESSION['AdminType'] == "admin"){ ?>
          <div class="third_col" style="<?=$WidthRow3?>">
           
            <div class="block alerts">
              <h3   <tr> # of Task and Activities</h3>
			<div style="border: 1px solid #E1E1E1;padding:10px;width:360px;background:#fff;"><img src="barE.php" ></div>
            </div>
          </div>
<?   }else{
		$StyleCom = 'style="width:380px;margin-right:10px;"';
		require_once("../includes/html/box/commission_dashboard.php"); 
	     }	
	?>

</div>
<? /****************************************First Row Close*********************/ ?>
		<? /****************************************Second Row *********************/ ?> 
 <div class="rows clearfix" style="display:block;"> 
	<div class="first_col" style="display:block;<?=$WidthRow1?>">
            <div class="block status_updates">
              <h3>Task and Activities</h3>
              <div class="bgwhite" >
		
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              
			<?php  if(is_array($arryActivity) && $num6>0){
			$flag=true;
			$Line=0;
			foreach($arryActivity as $key=>$Activity){
			$flag=!$flag;
			#$bgcolor=($flag)?("#FDFBFB"):("");
			$Line++;
			?>
                           
                           <? echo '<tr>
                              <td><a href="vActivity.php?view='.$Activity['activityID'].'&curP=1&module=Activity&mode='.$Activity['activityType'].'">'.$Activity['subject'].' </a></td>
                             
                            </tr>'; ?>
                           
                           <? } ?>

<tr>
                    <td>
                         <a href="viewActivity.php?module=Activity">More..</a>
                           </td>
                           </tr>
						       <? } else{?>
                           <tr>
                                <td  colspan="2">
                           <font color="darkred" >No Activity Found.</font>
                           </td>
                           </tr>
                           <? }?>
                          
              </table>

            </div>
            </div>
          </div> 
          <div class="second_col" style="<?=$WidthRow2?>">
            <div class="block p_l_request">

              <h3>Open and In progress Ticket</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <?php  if(is_array($arryTicket) && $num2>0){
		$flag=true;
		$Line=0;
		foreach($arryTicket as $key=>$Ticket){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td ><a href="vTicket.php?module=Ticket&view=<?=$Ticket['TicketID']?>"><?=stripslashes($Ticket['title'])?></a></td>
                </tr>
<? } ?>

<tr>
                  <td><font color="darkred" ><a href="viewTicket.php?module=Ticket">More..</a></font></td>
                </tr>

<? } else{?>
                <tr>
                  <td><font color="darkred" >No Ticket Found</font></td>
                </tr>

<? }?>
                
                
              </table>

              </div>
            </div>
          </div>
          <div class="third_col" style="<?=$WidthRow3?>">
           
              <div class="block alerts">
		<? if($_SESSION['AdminType'] == "admin"){ ?>
              <h3> # of Ticket by Priority</h3>
			<div style="border: 1px solid #E1E1E1;padding:10px;width:360px;background:#fff;"><img src="barTicketPriority.php" ></div>
		<? } else{?>
		<h3>Sales Commission Report</h3>
			<div style="border: 1px solid #E1E1E1;padding:5px;width:380px;background:#fff;"><img src="../barComm.php" ></div>
		<? } ?>



            </div>
          </div>
        </div>
<? /****************************************Second Row Close*********************/ ?>

<? /****************************************Third Row *********************/ ?>

        <div class="rows clearfix" style="display:block;">
          <div class="first_col" style="<?=$WidthRow1?>">
            <div class="block p_l_request">
              <h3>Created Quotes</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
<?php  if(is_array($arryQuote) && $num5>0){
		$flag=true;
		$Line=0;
		foreach($arryQuote as $key=>$Quote){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td><a href="vQuote.php?view=<?=$Quote['quoteid']?>&module=Quote"><?=stripslashes($Quote['subject'])?></a></td>
                </tr>
<? } ?>
<tr>
                  <td><a href="viewQuote.php?module=Quote">More..</a></td>
                </tr>

<? } else{?>
                <tr>
                  <td><font color="darkred" >No Quote Found.</font></td>
                </tr>
<? }?>
               
              </table>
            
              </div>
            </div>
          </div>
          <div class="second_col" style="<?=$WidthRow2?>">
            <div class="block p_timesheets">
              <h3>Active Campaign</h3>
              <div class="bgwhite">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
 <?php  if(is_array($arryCompaign) && $num4>0){
		$flag=true;
		$Line=0;
		foreach($arryCompaign as $key=>$Compaign){
		$flag=!$flag;
		#$bgcolor=($flag)?("#FDFBFB"):("");
		$Line++;
		?>
                <tr>
                  <td><a href="vCampaign.php?view=<?=$Compaign['campaignID']?>&module=Campaign"><?=$Compaign['campaignname']?></a></td>
                </tr>
<? }?>

<tr>
                  <td><a href="viewCampaign.php?module=Campaign">More..</a></td>
                </tr>

<?}else{?>
                <tr>
                  <td><font color="darkred" >No Compaign Found.</font></td>
                </tr>
<? }?>
          
                
              </table>

              </div>
            </div>
          </div>
           <div class="third_col" style="<?=$WidthRow3?>">
           
            <div class="block alerts">
              <h3> # of Quotes</h3>
			<div style="border: 1px solid #E1E1E1;padding:10px;width:360px;background:#fff;"><img src="barQuote.php" ></div>
            </div>
          </div>
          </div>
<? /****************************************Third Row close *********************/ ?>
        </div>
      </div>
    </div>
  </div>


