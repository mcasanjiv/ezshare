<script>
$(document).ready(function(){ 
$("a.facebookview").fancybox().hover(function() {
   $(this).click();
});

$("a.linkedinview").fancybox().hover(function() {
   $(this).click();
});

$("a.twitterview").fancybox().hover(function() {
   $(this).click();
});

});
</script>
<style type="text/css">
      
      div#container {
        width: 580px;
        margin: 100px auto 0 auto;
        padding: 20px;
        background: #000;
        border: 1px solid #1a1a1a;
      }
      
      /* HOVER STYLES */
      div.pop-up {
        display: none;
        position: absolute;
        width: 100%;
        min-height: 150px;
        padding: 10px;
        background: #eeeeee;
        color: #000000;
        border: 1px solid #1a1a1a;
        font-size: 90%;
      }
    </style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.0/jquery.min.js"></script>
<script type="text/javascript">
      $(function() {
        var moveLeft = 20;
        var moveDown = 10;
        
        $('a.trigger').hover(function(e) {
            $(this).parents('td').find('div.pop-up').show();
        //  $('div.pop-up').show();
          //.css('top', e.pageY + moveDown)
          //.css('left', e.pageX + moveLeft)
          //.appendTo('body');
        }, function() {
            $(this).parents('td').find('div.pop-up').hide();
        });
        
        $('a.trigger').mousemove(function(e) {
          $(this).parents('td').find('div.pop-up').css('top', e.pageY + moveDown).css('left', e.pageX + moveLeft);
        });
        
      });
      jQuery("#iframe" ).fancybox({
        'width'             : '100%',
        'min-height'            : 150,
       
    });
    </script>

<?php 

	require_once($Prefix."classes/sales.customer.class.php");
	require_once($Prefix."classes/lead.class.php");
	require_once($Prefix."classes/group.class.php");
	require_once($Prefix."classes/event.class.php");
	require_once($Prefix."classes/sales.quote.order.class.php");
	require_once($Prefix."classes/quote.class.php");
	$objCustomer=new Customer();  
	$objLead=new lead();
	$objGroup=new group();
	$objActivity=new activity();
	$objSale = new sale();
	$objQuote=new quote();
	$ModuleName = "Customer";
	$RedirectURL = "viewCustomer.php?curP=".$_GET['curP'];
	if(empty($_GET['tab'])) $_GET['tab']="contact";

	$EditUrl = "editCustomer.php?edit=".$_GET["view"]."&curP=".$_GET["curP"]."&tab=".$_GET['tab']; 
	$ViewUrl = "vCustomer.php?view=".$_GET["view"]."&curP=".$_GET["curP"]."&tab="; 


	if (!empty($_GET['view'])) {
		$CustID   = $_GET['view'];
		$_GET['CustID'] = $_GET['view'];	
		//$arryCustomer = $objCustomer->GetCustomer($_GET['view'],'','');	
		$arryCustomer = $objCustomer->getCustomerById($_GET['view']);
		
                $arryBillShipp = $objCustomer->GetShippingBilling($_GET['view'],$_GET['tab'],null,' Status DESC , AddID DESC');	
		if(empty($arryCustomer[0]['Cid'])){
			$ErrorMSG = CUSTOMER_NOT_EXIST;
		}

	}


	if(empty($arryCustomer[0]['Cid'])) {
		header('location:'.$RedirectURL);
		exit;
	}		
	/*****************/
	if($Config['vAllRecord']!=1){
		if($arryCustomer[0]['AdminID'] == $_SESSION['AdminID'] or $arryCustomer[0]['SalesID'] == $_SESSION['AdminID']){
			//continue
		}else{
			header('location:'.$RedirectURL);
			exit;
		}
	}
	/*****************/




      
	if($_GET['tab']=='shipping'){
		$SubHeading = 'Shipping Address';
	}else if($_GET['tab']=='billing'){
		$SubHead426ing = 'Billing Address';	
  	}else if($_GET['tab']=='bank'){
		$SubHeading = 'Bank Details';	
  	}else if($_GET['tab']=='slaesPerson'){
		$SubHeading = 'Sales Person';	
  	}else if($_GET['tab']=='contacts'){
		$SubHeading = 'Contacts'; 
		$IncludePage = 'customer_contacts.php';	
	}else if($_GET['tab']=='ticket'){
		$SubHeading = 'Tickets'; $HideEdit=1; 
		$IncludePage = 'customer_tickets.php';
	}else if($_GET['tab']=='event'){
		$SubHeading = 'Event / Task'; $HideEdit=1; 
		$IncludePage = 'customer_activity.php';
	}else if($_GET['tab']=='document'){
		$SubHeading = 'Documents'; $HideEdit=1; 
		$IncludePage = 'customer_documents.php';
	}else if($_GET['tab']=='quote'){
		$SubHeading = 'Quotes'; $HideEdit=1;
		$IncludePage = 'customer_quote.php';
	}else if($_GET['tab']=='so'){
		$SubHeading = 'Sales Orders'; $HideEdit=1;
		$IncludePage = 'customer_orders.php';
	}else if($_GET['tab']=='invoice'){
		$SubHeading = 'Invoices'; $HideEdit=1;	
		$IncludePage = 'customer_invoice.php';
	}else if($_GET['tab']=='purchase'){
		$SubHeading = 'Purchase History'; $HideEdit=1;
		$IncludePage = 'customer_purchases.php';	
	}else if($_GET['tab']=='comment'){
		$_GET['module'] = 'Customer';
		$SubHeading = 'Comments'; $HideEdit=1;
		$IncludeOtherPage = 'includes/html/box/comment_cust.php';
	}else{
		$SubHeading = ucfirst($_GET["tab"])." Information";
	}
?>


<?
	/*********************/
	/*********************/
	$_GET["module"] = $ModuleName;
	$FullName = stripslashes($arryCustomer[0]['FullName']);
   	$NextID = $objCustomer->NextPrevCustomer($_GET['view'],$FullName,1);
	$PrevID = $objCustomer->NextPrevCustomer($_GET['view'],$FullName,2);
	$NextPrevUrl = "vCustomer.php?tab=general&curP=".$_GET["curP"];
	include("../includes/html/box/next_prev.php");
	/*********************/
	/*********************/
?>


<a class="back" href="<?=$RedirectURL?>">Back</a> 
<?php
if(!empty($ErrorMSG)){
	 echo '<div class="redmsg" align="center">'.$ErrorMSG.'</div>';
}else{
?>

		<? if($HideEdit!=1){?><a href="<?=$EditUrl?>" class="edit">Edit</a><?}?>


		<div class="had"><?=$MainModuleName?>  <span> &raquo;	<?php 	echo $SubHeading; ?>	</span>
		</div>




<? 
if(!empty($IncludePage)){
	$Config['vAllRecord']=1;	
	include("../includes/html/box/".$IncludePage);
}else if(!empty($IncludeOtherPage)){
	$Config['vAllRecord']=1;	
	include($IncludeOtherPage);
}else{
?>

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
	<tr>
	 <td colspan="4" align="left" class="head"><?=$SubHeading?></td>
	</tr>			
			

				
		<?php if($_GET['tab'] == "general"){?>  
		 <tr>
		<td   align="right" valign="top"  class="blackbold"> 
		Customer Code : </td>
		<td   align="left" valign="top">
		<?=stripslashes($arryCustomer[0]['CustCode'])?>
		</td>
		</tr>
		<tr>
		<td align="right" class="blackbold"> Customer Type  : </td>
		<td align="left"><?=$arryCustomer[0]['CustomerType']?></td>
		

<? if($arryCustomer[0]['CustomerType']=='Company'){ ?>  
		
		<td  align="right" valign="top"   class="blackbold"> 
		Company : </td>
		<td  align="left">
		<?=(!empty($arryCustomer[0]['Company']))?($arryCustomer[0]['Company']):(NOT_SPECIFIED)?>
		</td>
		
<? } ?>
		</tr>

 <tr>
                <td width="25%" align="right" valign="top"  class="blackbold"> 
                    First Name :  </td>
                 <td align="left" width="25%"><?=stripslashes($arryCustomer[0]['FirstName'])?></td>
                
          
                <td width="25%" align="right" valign="top"   class="blackbold"> 
                    Last Name : </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['LastName'])?></td>
               
            </tr>
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Gender : </td>
               
                 <td align="left"><?=$arryCustomer[0]['Gender'];?></td>
          
                <td align="right" valign="top" class="blackbold"> 
                    Email :  </td>
               
                <td align="left"><?=stripslashes($arryCustomer[0]['Email'])?></td>
            </tr>
<tr>
                <td align="right" valign="top" class="blackbold"> 
                    Mobile :  </td>
                
                 <td  align="left">

  <?=(!empty($arryCustomer[0]['Mobile']))?(stripslashes($arryCustomer[0]['Mobile'])):(NOT_SPECIFIED)?>

</td>
            
                <td  align="right" valign="top"   class="blackbold"> 
                    Landline  : </td>
                <td  align="left"  class="blacknormal">
                    <?=(!empty($arryCustomer[0]['Landline']))?(stripslashes($arryCustomer[0]['Landline'])):(NOT_SPECIFIED)?>
                </td>
            </tr>
                                            
                                      
            <tr style="display:none">
	<td  align="right"   class="blackbold" > Currency :</td>
	<td   align="left" >
	<?=$arryCustomer[0]['Currency']?>
	  </td>
  </tr>
           
           
            <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Website :  </td>
               <td  align="left"><?=(!empty($arryCustomer[0]['Website']))?($arryCustomer[0]['Website']):(NOT_SPECIFIED)?></td>
            
		<td align="right"   class="blackbold" >Customer Since :</td>
		<td  align="left"  >
 <?=($arryCustomer[0]['CustomerSince']>0)?(date($Config['DateFormat'], strtotime($arryCustomer[0]['CustomerSince']))):(NOT_SPECIFIED)?>

				</td>
	  </tr>
	<tr>
			<td  align="right"   class="blackbold" > Payment Term  : </td>
			<td   align="left" >
	<?=(!empty($arryCustomer[0]['PaymentTerm']))?(stripslashes($arryCustomer[0]['PaymentTerm'])):(NOT_SPECIFIED)?>

		</td>
	
			<td  align="right"   class="blackbold" > Payment Method  : </td>
			<td   align="left" >
	<?=(!empty($arryCustomer[0]['PaymentMethod']))?(stripslashes($arryCustomer[0]['PaymentMethod'])):(NOT_SPECIFIED)?>

		</td>
	</tr>

	<tr>
			<td  align="right"   class="blackbold" > Shipping Method  : </td>
			<td   align="left" >
	<?=(!empty($arryCustomer[0]['ShippingMethod']))?(stripslashes($arryCustomer[0]['ShippingMethod'])):(NOT_SPECIFIED)?>

		</td>

			<td  align="right"   class="blackbold" > Taxable : </td>
			<td   align="left" >
	<?=($arryCustomer[0]['Taxable']=='Yes')?("Yes"):("No")?>

		</td>
	</tr>

	<tr>
		<td  align="right"   class="blackbold" >Status  : </td>
		<td   align="left"  >
		<?  echo ($arryCustomer[0]['Status'] == "Yes")?("Active"):(" InActive");
		?>
		</td>
	</tr>
	
<?php }?>
        


	


 
  <?php if($_GET['tab'] == "contact"){ ?>  
                                       
            <tr>
                <td colspan="4" align="left" class="head">Contact Information </td>
            </tr>
           
            <tr>
                <td align="right" valign="top"  class="blackbold"> 
                    First Name :  </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['FirstName'])?></td>
                
            </tr>

            <tr>
                <td  align="right" valign="top"   class="blackbold"> 
                    Last Name : </td>
                 <td align="left"><?=stripslashes($arryCustomer[0]['LastName'])?></td>
               
            </tr>
             <tr>
                <td  align="right" valign="top"   class="blackbold"> 
                    Gender : </td>
               
                 <td align="left"><?=$arryCustomer[0]['Gender'];?></td>
            </tr>
             <tr>
                <td align="right" valign="top" class="blackbold"> 
                    Email :  </td>
               
                <td align="left"><?=stripslashes($arryCustomer[0]['Email'])?></td>
            </tr>
             <tr>
                <td valign="top" align="right" class="blackbold">Address  :</td>

                 <td align="left"><?=stripslashes($arryCustomer[0]['Address'])?></td>
             </tr>
              <tr>
                <td  align="right"   class="blackbold"> Country : </td>
                <td   align="left" >
                  <?=stripslashes($arryCustomer[0]['CountryName'])?>
                </td>
            </tr>
            <tr>
                <td  align="right" valign="middle"  class="blackbold"> State : </td>
             <td  align="left" class="blacknormal"><?=stripslashes($arryCustomer[0]['StateName'])?></td>
            </tr>
            
            <tr>
                <td  align="right" class="blackbold"> City : </td>
                <td  align="left"><?=stripslashes($arryCustomer[0]['CityName'])?></td>
            </tr> 
             
            <tr>
                <td align="right" valign="top" class="blackbold">Zip Code :  </td>
                 
                 <td  align="left"><?=stripslashes($arryCustomer[0]['ZipCode'])?></td>
            </tr>
             <tr>
                <td align="right" valign="top" class="blackbold"> 
                    Mobile :  </td>
                
                 <td  align="left"><?=stripslashes($arryCustomer[0]['Mobile'])?></td>
            </tr>
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Landline  : </td>
                <td  align="left"  class="blacknormal">
                    <?=(!empty($arryCustomer[0]['Landline']))?(stripslashes($arryCustomer[0]['Landline'])):(NOT_SPECIFIED)?>
                </td>
            </tr>
                                            
                                      
             <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Fax :</td>
               <td  align="left">
                <?=(!empty($arryCustomer[0]['Fax']))?(stripslashes($arryCustomer[0]['Fax'])):(NOT_SPECIFIED)?>
               </td>
            </tr>
           
           
            <tr>
                <td align="right" valign="top"   class="blackbold"> 
                    Website :  </td>
               <td  align="left"><?=(!empty($arryCustomer[0]['Website']))?($arryCustomer[0]['Website']):(NOT_SPECIFIED)?></td>
            </tr>
            <?php }?>  
         <?php if($_GET['tab'] == "billing" || $_GET['tab'] == "shipping"){                                          
                                            $BillShipp = ucfirst($_GET["tab"]);
                                            $NumBillShipp = sizeof($arryBillShipp);
                                          
                                            /********Connecting to main database*********/
                                                $Config['DbName'] = $Config['DbMain'];
                                                $objConfig->dbName = $Config['DbName'];
                                                $objConfig->connect();
                                             if($arryBillShipp[0]['country_id']>0){
                                                        $arryCountryName = $objRegion->GetCountryName($arryBillShipp[0]['country_id']);
                                                        $CountryName = stripslashes($arryCountryName[0]["name"]);
                                                }

                                                if(!empty($arryBillShipp[0]['state_id'])) {
                                                        $arryState = $objRegion->getStateName($arryBillShipp[0]['state_id']);
                                                        $StateName = stripslashes($arryState[0]["name"]);
                                                }else if(!empty($arryBillShipp[0]['OtherState'])){
                                                         $StateName = stripslashes($arryBillShipp[0]['OtherState']);
                                                }

                                                if(!empty($arryBillShipp[0]['city_id'])) {
                                                        $arryCity = $objRegion->getCityName($arryBillShipp[0]['city_id']);
                                                        $CityName = stripslashes($arryCity[0]["name"]);
                                                }else if(!empty($arryBillShipp[0]['OtherCity'])){
                                                         $CityName = stripslashes($arryBillShipp[0]['OtherCity']);
                                                }
                                            ?>    
                                          
                                            <?php 
                                            
                                            if($NumBillShipp>0){
                                            echo '<tr><td>';
                                            $i=0;
                                            foreach($arryBillShipp as $v){
                                             ?>
                                             <table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall <?php echo empty($arryBillShipp[$i]['Status'])?'no-active':'';?>">
                                            <tr>
                                                <td width="45%" align="right" valign="top" class="blackbold"> <?=$BillShipp?> Name : </td>
                                                <td align="left" valign="top">
                                                   <?= stripslashes($arryBillShipp[$i]['FullName']) ?>
                                                </td>
                                            </tr>
                                           <tr>
                                            <td align="right"   class="blackbold"><?=$BillShipp;?> Email  : </td>
                                            <td  align="left" ><?=stripslashes($arryBillShipp[$i]['Email'])?> </td>
                                           </tr> 
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">  Address : </td>
                                                <td  align="left" valign="top">
                                                   <?=stripslashes($arryBillShipp[$i]['Address']) ?>
                                                </td>
                                            </tr>
                                           

                                            <tr>
                                                <td  align="right"   class="blackbold"> Country : </td>
                                                <td   align="left" >
                                                  <?= stripslashes($arryBillShipp[$i]['CountryName']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                              <td  align="right" valign="middle" nowrap="nowrap"  class="blackbold"> State : </td>
                                             <td  align="left"  class="blacknormal"> <?= stripslashes($arryBillShipp[$i]['StateName']) ?></td>
                                            </tr>
                                           
                                            <tr>
                                                <td  align="right" class="blackbold"> City : </td>
                                                <td  align="left"> <?= stripslashes($arryBillShipp[$i]['CityName']) ?></td>
                                            </tr> 
                                          
                                            <tr>
                                                <td  align="right" valign="top" class="blackbold">Zip Code : </td>
                                                <td   align="left" valign="top">
                                                    <?= stripslashes($arryBillShipp[$i]['ZipCode']) ?>
                                                </td>
                                            </tr>
                                            <tr>
                                            <td align="right"   class="blackbold" >Mobile  :</td>
                                            <td  align="left"  >
                                            <?=stripslashes($arryBillShipp[$i]['Mobile'])?>

                                             </td>
                                          </tr>

                                               <tr>
                                            <td  align="right"   class="blackbold">Landline  :</td>
                                            <td   align="left" >
                                              <?=(!empty($arryBillShipp[$i]['Landline']))?($arryBillShipp[$i]['Landline']):(NOT_SPECIFIED)?>
                                             </td>
                                          </tr>

                                          <tr>
                                            <td align="right"   class="blackbold">Fax  : </td>
                                            <td  align="left" > <?=(!empty($arryBillShipp[$i]['Fax']))?($arryBillShipp[$i]['Fax']):(NOT_SPECIFIED)?></td>
                                          </tr> 
                                          </table>
                                          <?php $i++;} echo '</tr></td>';} else{ ?>
                                            <tr>
                                                 <td colspan="4" height="300" align="center"><?=NOT_SPECIFIED?></td>
                                             </tr>
                                            <?php } ?>
                                            

                                         
                                        <?php }?>
										
  <? if($_REQUEST["tab"]=="bank"){ ?>  

			
		 <tr>
				 <td colspan="4">&nbsp;</td>
			</tr>	
			
		<tr>
			<td  align="right"   class="blackbold"  width="45%"> Bank Name : </td>
			<td   align="left" >
			 
			 <?=(!empty($arryCustomer[0]['BankName']))?(stripslashes($arryCustomer[0]['BankName'])):(NOT_SPECIFIED)?>
				</td>
		  </tr>	
		 <tr>
			<td  align="right"   class="blackbold"> Account Name  :</td>
			<td   align="left" >
				
				 <?=(!empty($arryCustomer[0]['AccountName']))?(stripslashes($arryCustomer[0]['AccountName'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	  
		  <tr>
			<td  align="right"   class="blackbold"> Account Number  : </td>
			<td   align="left" >
				
				<?=(!empty($arryCustomer[0]['AccountNumber']))?(stripslashes($arryCustomer[0]['AccountNumber'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	
		   <tr>
			<td  align="right"   class="blackbold">Routing Number : </td>
			<td   align="left" >
				
				<?=(!empty($arryCustomer[0]['IFSCCode']))?(stripslashes($arryCustomer[0]['IFSCCode'])):(NOT_SPECIFIED)?>
				 </td>
		  </tr>	
		  
		  <tr>
				 <td colspan="4">&nbsp;</td>
			</tr>
			
	  <? } ?>

	  
	   <? if($_REQUEST["tab"]=="slaesPerson"){ ?>  

			
		 <tr>
				 <td colspan="4">&nbsp;</td>
			</tr>	
			
		<tr>
			<td  align="right"   class="blackbold"  width="45%"> Sales Person : </td>
			<td   align="left" >
			 
			 <?php echo stripslashes($arryCustomer[0]['sales_person']); ?>
				</td>
		  </tr>	
		
			
	  <? } ?>
	   <? if($_REQUEST["tab"]=="social"){ ?>
           
		 	<tr>
       		   <td align="right"   class="blackbold" valign="top">Facebook :</td>
          		<td  align="left" colspan="3" > 
                            <?php if(!empty($arryCustomer[0]['FacebookID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['FacebookID']));
           			$socialdata = unserialize($socialdata);
           				echo '<a href="viewprofile.php?id='.$arryCustomer[0]['FacebookID'].'&type=facebook" class="facebookview trigger fancybox fancybox.iframe">View Profile</a>';
           			 }else{echo (NOT_SPECIFIED);}?>                                
                             <div class="pop-up" style="width: 400px">
                               <?php echo '<iframe  src="viewprofile.php?id='.$arryCustomer[0]['FacebookID'].'&type=facebook" style="min-height:150px; width: 400px">
</iframe>';?>
                            </div>
                             
           			 </td>
           		</tr>
           		<tr>
           		<td align="right"   class="blackbold" valign="top">Twitter :</td>
          		<td  align="left" colspan="3" >
           			  <?php if(!empty($arryCustomer[0]['TwitterID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['TwitterID']));
           			$socialdata = unserialize($socialdata);
           				echo '<a href="viewprofile.php?id='.$arryCustomer[0]['TwitterID'].'&type=twitter" class="twitterview trigger fancybox fancybox.iframe">View Profile</a>';
           			 }else{echo (NOT_SPECIFIED);}?>
                            <div class="pop-up" style="width: 400px">
                                <?php echo '<iframe  src="viewprofile.php?id='.$arryCustomer[0]['TwitterID'].'&type=twitter" style="min-height:150px; width: 100%;">
</iframe>';?>
                            </div>
                        
                        </td>
           		</tr>
           		<tr>
           		<td align="right"   class="blackbold" valign="top">Linkedin :</td>
          		<td  align="left" colspan="3" >
           			  <?php if(!empty($arryCustomer[0]['LinkedinID'])){$socialdata=stripslashes(nl2br($arryCustomer[0]['LinkedinID']));
           			$socialdata = unserialize($socialdata);
           			$id='';
           			$t='';
           			if(!empty($arryCustomer[0]['LinkedinID'])){
           			$id=$arryCustomer[0]['LinkedinID'];
           			$t='linkedin';
           			}
           				echo '<a href="viewprofile.php?id='.$id.'&type='.$t.'" class="linkedinview trigger fancybox fancybox.iframe">View Profile</a>';
           			 }else{echo (NOT_SPECIFIED);}?>
                        <div class="pop-up" style="width: 400px">
                                <?php echo '<iframe  src="viewprofile.php?id='.$id.'&type='.$t.'" style="min-height:210px; width: 100%;">
</iframe>';?>
                            </div>
                        </td>
				</tr>
		
			
	  <? } ?>
	  
	  
	  
</table>
                                  
           

<?php } } ?>	  
	
<script language="JavaScript1.2" type="text/javascript">

$(document).ready(function() {
		$(".fancybig").fancybox({
			'width'         : 900
		 });

});

</script>
