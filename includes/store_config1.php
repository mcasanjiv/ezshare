<? 
	$arrayStore = $objMember->GetStoreByUserName($_SESSION['StoreUserName']);

	$_SESSION['StoreID'] = $arrayStore[0]['MemberID'];


	if(!empty($arrayStore[0]['MemberID'])){
		/***** Expired ******/
		if(strtotime($arrayStore[0]['ExpiryDate'])<strtotime(date('Y-m-d H:i:s'))){
			//$objMember->DisableStore($arrayStore[0]['MemberID']);
			unset($_SESSION['StoreID']);
			unset($arrayStore[0]['MemberID']);
			unset($_SESSION['VatPercentage']);
		}else{
			 if($WebsiteVisit==1){
				 if($arrayStore[0]['WebsiteStoreOption']!='w' && $arrayStore[0]['WebsiteStoreOption']!='ws' ){
					unset($_SESSION['StoreID']);
					unset($arrayStore[0]['MemberID']);
					unset($_SESSION['VatPercentage']);
				 }
			 }else{
				 if($arrayStore[0]['WebsiteStoreOption']!='s' && $arrayStore[0]['WebsiteStoreOption']!='ws' ){
					unset($_SESSION['StoreID']);
					unset($arrayStore[0]['MemberID']);
					unset($_SESSION['VatPercentage']);
				 }

			 }


		}
		/***********/
	}


	/*********************************/
		// Now Start Buliding Store
	/*********************************/

	if(!empty($_SESSION['StoreID'])){

		$arrySite = $objMember->GetMemberSite($_SESSION['StoreID']);

		$arrayConfig[0]['Tax'] = $arrySite[0]['Tax'];
		$arrayConfig[0]['Shipping'] = $arrySite[0]['Shipping'];

		if(!empty($arrayStore[0]['VatNumber'])){
			$_SESSION['VatPercentage'] = $arrayStore[0]['VatPercentage'];
			$VatPriceMsg = ($arrayStore[0]['VatPercentage']>0)?(VAT_EXC_MSG):(VAT_INC_MSG);
		}else{
			unset($_SESSION['VatPercentage']);
		}


		/**********Buliding up the categories ***************/
		$arrayStoreCategory= $objCategory->GetStoreCategories($_SESSION['StoreID']);
		
		if(sizeof($arrayStoreCategory)>0){
			$CatIDs = '';
			 foreach($arrayStoreCategory as $key=>$values){
			 	if($values['ParentID']>0) $CatIDs .= $values['ParentID'].',';
				else $CatIDs .= $values['CategoryID'].',';
			 }
			 
			$CatIDs = rtrim($CatIDs,",");
			$arrayMainCategory = $objCategory->GetParentCategories($CatIDs);
		}
		
			
		/************  Calculate Rating ***************/
		$arryTotalRanking = $objMember->GetMemberRanking('','Seller');
		$RatingHTML = getRatingHTMLBig($arrayStore[0]['Ranking'],$arryTotalRanking[0]['TotalRanks']);
		/************  Calculate Rating ***************/
		
		$arryContactContent = $objMember->GetMemberSite($_SESSION['StoreID']);
	}

	$SrchKeyTop = $_GET['topkey'];
    if(empty($SrchKeyTop)) {$SrchKeyTop='Enter Keyword'; }




	$CheckoutUrl = (!empty($_SESSION['MemberID']))?("javascript:location.href='checkout.php'"):("Javascript:LoginPrompt();");  

	$MemberID = (!empty($_SESSION['MemberID']))?($_SESSION['MemberID']):(session_id());			
	
	$arryNumCart = $objOrder->GetNumItemCart($MemberID);	


	if(!empty($arrayStore[0]['templateID'])){
		
		$TemplateFolder = $Config['Url'].'templates/'.$arrayStore[0]['templateID'].'/';
		
		$NoImageUrl = '<img src="'.$Config['Url'].'store_images/no-image.jpg" border="0"  />';

		/* Links */
		$LinkHome = 'store.php';
		$LinkAbout = 'storeAbout.php';
		$LinkShipping = 'storeShipping.php';
		$LinkPolicy = 'storePolicy.php';
		$LinkAuctions = 'storeAuctions.php';
		$LinkContact = 'storeContact.php';
		$LinkWebsite = 'home.php';
		
		$FlowUrls = '<a href="'.$LinkHome.'">'.HOME.'</a>';

		$LinkWebHome = 'home.php';
		$LinkWebAbout = 'webAbout.php';
		$LinkWebContact = 'webContact.php';
		$LinkWebBlog = 'webBlog.php';


		if($_GET['action'] == 'edit'){
			$DisableBody = 'onclick="return false" oncontextmenu="return false" ondragstart="return false" onselectstart="return false"';

		}


		/********* Dyanamic Template ***********/
		/***************************************/

		if(empty($_GET['preview'])){

			/*if(!empty($arrySite[0]['BodyWidth'])){
				 $_GET['BodyWidth'] = $arrySite[0]['BodyWidth'];
			}*/


			if(!empty($arrySite[0]['BodyBgOption'])){
				 $_GET['BodyBgOption'] = $arrySite[0]['BodyBgOption'];
			}

			if(!empty($arrySite[0]['BodyBgImage'])){
				 $_GET['BodyBgImage'] = $arrySite[0]['BodyBgImage'];
			}


			if(!empty($arrySite[0]['BodyBgColor'])){
				$_GET['BodyBgColor'] = $arrySite[0]['BodyBgColor'];
			}

			if(!empty($arrySite[0]['TemplatePanel'])){
				$_GET['TemplatePanel'] = $arrySite[0]['TemplatePanel'];
			}

			if(!empty($arrySite[0]['BannerOption'])){
				$_GET['BannerOption'] = $arrySite[0]['BannerOption'];

				if(!empty($arrySite[0]['BannerBgImage'])){
					$_GET['BannerBgImage'] = $arrySite[0]['BannerBgImage'];
				}
				if(!empty($arrySite[0]['BannerTextOption'])){
					$_GET['BannerTextOption'] = $arrySite[0]['BannerTextOption'];
				}
				if(!empty($arrySite[0]['BannerText'])){
					$_GET['BannerText'] = $arrySite[0]['BannerText'];
				}
				if(!empty($arrySite[0]['BannerFontColor'])){
					$_GET['BannerFontColor'] = $arrySite[0]['BannerFontColor'];
				}			
				if(!empty($arrySite[0]['BannerFontSize'])){
					$_GET['BannerFontSize'] = $arrySite[0]['BannerFontSize'];
				}			
				if(!empty($arrySite[0]['BannerFontType'])){
					$_GET['BannerFontType'] = $arrySite[0]['BannerFontType'];
				}			
				if(!empty($arrySite[0]['BannerTextAlign'])){
					$_GET['BannerTextAlign'] = $arrySite[0]['BannerTextAlign'];
				}			
				if(!empty($arrySite[0]['BannerWidth'])){
					$_GET['BannerWidth'] = $arrySite[0]['BannerWidth'];
				}			
				if(!empty($arrySite[0]['BannerHeight'])){
					$_GET['BannerHeight'] = $arrySite[0]['BannerHeight'];
				}			
		
			}



			if(!empty($arrySite[0]['HeaderBgOption'])){
				 $_GET['HeaderBgOption'] = $arrySite[0]['HeaderBgOption'];
			}

			if(!empty($arrySite[0]['HeaderBgImage'])){
				$_GET['HeaderBgImage'] = $arrySite[0]['HeaderBgImage'];
			}
			if(!empty($arrySite[0]['HeaderBgColor'])){
				$_GET['HeaderBgColor'] = $arrySite[0]['HeaderBgColor'];
			}

			if(!empty($arrySite[0]['HeaderTitleOption'])){
				$_GET['HeaderTitleOption'] = $arrySite[0]['HeaderTitleOption'];
			}

			if(!empty($arrySite[0]['HeaderLogoOption'])){
				$_GET['HeaderLogoOption'] = $arrySite[0]['HeaderLogoOption'];
			}




			if(!empty($arrySite[0]['HeaderLogo'])){
					
					$_GET['HeaderLogo'] = $arrySite[0]['HeaderLogo'];

					if(!empty($arrySite[0]['LogoHeight'])){
						$_GET['LogoHeight'] = $arrySite[0]['LogoHeight'];
					}
					if(!empty($arrySite[0]['LogoWidth'])){
						$_GET['LogoWidth'] = $arrySite[0]['LogoWidth'];
					}

					if(!empty($arrySite[0]['LogoAlign'])){
						$_GET['LogoAlign'] = $arrySite[0]['LogoAlign'];
					}

			
			}


			$_GET['HeaderTitle'] = (!empty($arrySite[0]['HeaderTitle']))?(stripslashes($arrySite[0]['HeaderTitle'])):(stripslashes($arrayStore[0]['CompanyName']));

			if(!empty($arrySite[0]['HeaderTextAlign'])){
				$_GET['HeaderTextAlign'] = $arrySite[0]['HeaderTextAlign'];
			}
			if(!empty($arrySite[0]['HeaderFontType'])){
				$_GET['HeaderFontType'] = $arrySite[0]['HeaderFontType'];
			}


			if(!empty($arrySite[0]['HeaderFontColor'])){
				$_GET['HeaderFontColor'] = $arrySite[0]['HeaderFontColor'];
			}

			if(!empty($arrySite[0]['HeaderFontSize'])){
				$_GET['HeaderFontSize'] = $arrySite[0]['HeaderFontSize'];
			}



		}

		/***************************************/
		/***************************************/
		/***************************************/
		/***************************************/
			
			/*if(!empty($_GET['BodyWidth'])){
				 $BodyWidthStyle = 'style="width:'.$_GET['BodyWidth'].'px;"';
			}*/


			if($_GET['BodyBgOption'] == 'image'){
					if(!empty($_GET['BodyBgImage']) && file_exists("templates/bodybg/".$_GET['BodyBgImage'])){
						$BodyStyle = 'style="background-image:url(templates/bodybg/'.$_GET['BodyBgImage'].')"';
					}
					
					if(!empty($_GET['BodyBgImage']) && file_exists("templates/temp/".$_GET['BodyBgImage'])){
						$BodyStyle = 'style="background-image:url(templates/temp/'.$_GET['BodyBgImage'].')"';
					}
			
			}else{
					if(!empty($_GET['BodyBgColor'])){
						$BodyStyle = 'style="background-color:#'.$_GET['BodyBgColor'].'"';
					}
			}


			/************* Header BG Option Section *************/

			if($_GET['HeaderBgOption'] == 'image'){
				if($_GET['HeaderBgImage'] !='' && file_exists("templates/headerbg/".$_GET['HeaderBgImage']) ){
					$HeaderBgStyle = 'style="background-image:url('.$Config['Url'].'templates/headerbg/'.$_GET['HeaderBgImage'].')"';
				}
				if($_GET['HeaderBgImage'] !='' && file_exists("templates/temp/".$_GET['HeaderBgImage']) ){
					$HeaderBgStyle = 'style="background-image:url('.$Config['Url'].'templates/temp/'.$_GET['HeaderBgImage'].')"';
				}
			}else{
					if(!empty($_GET['HeaderBgColor'])){
						$HeaderBgStyle = 'style="background-color:#'.$_GET['HeaderBgColor'].';background-image:url()"';
					}
			}
			


			/************* Header Logo Section *************/


			if($_GET['HeaderLogoOption'] == 1){

					if($_GET['HeaderLogo'] !='' && file_exists("templates/logo/".$_GET['HeaderLogo']) ){
						$HeaderLogoImage = '<img src="'.$Config['Url'].'templates/logo/'.$_GET['HeaderLogo'].'" width="'.$_GET['LogoWidth'].'" height="'.$_GET['LogoHeight'].'">';
					}
					if($_GET['HeaderLogo'] !='' && file_exists("templates/temp/".$_GET['HeaderLogo']) ){
						$HeaderLogoImage = '<img src="'.$Config['Url'].'templates/temp/'.$_GET['HeaderLogo'].'" width="'.$_GET['LogoWidth'].'" height="'.$_GET['LogoHeight'].'">';
					}


					if(!empty($HeaderLogoImage)){
						if($_GET['LogoAlign']=='center') $LogoALign = 'padding-top:4px;text-align:center';
						else $LogoALign = 'padding-left:4px;padding-right:4px;padding-top:4px;float:'.$_GET['LogoAlign'];

						$HeaderLogo = "<div style='". $LogoALign."'>".$HeaderLogoImage."</div>";
					}

			}

			/************* Header Title Section *************/

			if($_GET['HeaderTitleOption'] == 1){
					
					if(!empty($_GET['HeaderTitle'])){

						$HeaderTitleSpan = stripslashes($_GET['HeaderTitle']);
						
						$HeaderTitleStyle = '';

						if(!empty($_GET['HeaderFontType'])){
							$HeaderTitleStyle .= "font-family:".$_GET['HeaderFontType'].";";
						}
						if(!empty($_GET['HeaderFontColor'])){
							$HeaderTitleStyle .= "color:#".$_GET['HeaderFontColor'].";";
						}
						if(!empty($_GET['HeaderFontSize'])){
							$HeaderTitleStyle .= "font-size:".$_GET['HeaderFontSize'].";";
						}
						if(!empty($_GET['HeaderTextAlign'])){

							if($_GET['HeaderTextAlign']=='center') 
								$_GET['HeaderTextAlign'] = 'text-align:center';
							else $_GET['HeaderTextAlign'] = 'margin-left:5px;margin-right:5px;float:'.$_GET['HeaderTextAlign'];


							$HeaderTitleStyle .= $_GET['HeaderTextAlign'];

						}

					}

			}


			$HeaderTitleSpan = "<div style='".$HeaderTitleStyle."' class='StoreTitle'>".$HeaderTitleSpan."</div>";
			
			
			if($_GET['LogoAlign']=='center' && $_GET['HeaderTextAlign']=='center' && $_GET['HeaderLogoOption'] == 1 && $_GET['HeaderTitleOption'] == 1 && $HeaderLogo!=''){

				$LogoALign = 'padding-top:4px;float:left';
				$HeaderLogo = "<div style='". $LogoALign."'>".$HeaderLogoImage."</div>";

				$HeaderLogo = "<table align=center><tr><td>".$HeaderLogo.'</td><td>'.$HeaderTitleSpan."</td></tr></table>";
				$HeaderTitleSpan = '';

			}
		
		/********* Banner Section *********/
		
		if($_GET['BannerOption'] == 1){

				if($_GET['BannerBgImage'] !='' && file_exists("templates/banner/".$_GET['BannerBgImage']) ){
					 $BannerBgImage = $Config['Url'].'templates/banner/'.$_GET['BannerBgImage'];
				}
				if($_GET['BannerBgImage'] !='' && file_exists("templates/temp/".$_GET['BannerBgImage']) ){
					 $BannerBgImage = $Config['Url'].'templates/temp/'.$_GET['BannerBgImage'];
				}

			if(!empty($BannerBgImage)){

				if($_GET['BannerTextOption'] == 1){
					if(!empty($_GET['BannerText'])){
						
						$BannerTextStyle = 'padding:10px;';
						if(!empty($_GET['BannerFontType'])){
							$BannerTextStyle .= "font-family:".$_GET['BannerFontType'].";";
						}
						if(!empty($_GET['BannerFontColor'])){
							$BannerTextStyle .= "color:#".$_GET['BannerFontColor'].";";
						}
						if(!empty($_GET['BannerFontSize'])){
							$BannerTextStyle .= "font-size:".$_GET['BannerFontSize'].";";
						}
						if(!empty($_GET['BannerTextAlign'])){
							$BannerTextStyle .= "text-align:".$_GET['BannerTextAlign'].";";
						}



						$BannerTextDiv = '<Div style="'.$BannerTextStyle.'">' .nl2br(stripslashes($_GET['BannerText'])) .'</Div>';
					}

				}

				list($BannerWidth, $BannerHeight) = getimagesize($BannerBgImage);

				if(!empty($_GET['BannerWidth'])){
					$BannerWidth = $_GET['BannerWidth'];
				}
				if(!empty($_GET['BannerHeight'])){
					$BannerHeight = $_GET['BannerHeight'];
				}
				
		
				$StoreBanner = '<div class="Banner" style="margin-bottom:10px;background-image:url('.$BannerBgImage.');width:'.$BannerWidth.'px;height:'.$BannerHeight.'px">&nbsp;'.$BannerTextDiv.'&nbsp;</div>';


			}

		}





		/*********** End MOdification ***************/
		
		if($WebsiteVisit==1){

				if($arrySite[0]['HeaderMenuButton']=='image'){
					$BodyOnload = 'onload="MM_preloadImages(\''.$TemplateFolder.'images/website_home_hover.gif\',\''.$TemplateFolder.'images/website_aboutus_hover.gif\',\''.$TemplateFolder.'images/website_contactus_hover.gif\',\''.$TemplateFolder.'images/website_blog_hover.gif\',\''.$TemplateFolder.'images/website_visit_store_hover.gif\')"';	

					$TopMenuBars = '<a href="'.$LinkWebHome.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image2\',\'\',\''.$TemplateFolder.'images/website_home_hover.gif\',1)"><img src="'.$TemplateFolder.'images/website_home.gif" name="Image2" border="0" id="Image2" /></a><a href="'.$LinkWebAbout.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image3\',\'\',\''.$TemplateFolder.'images/website_aboutus_hover.gif\',1)"><img src="'.$TemplateFolder.'images/website_aboutus.gif" name="Image3"  border="0" id="Image3" /></a><a href="'.$LinkWebContact.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image7\',\'\',\''.$TemplateFolder.'images/website_contactus_hover.gif\',1)"><img src="'.$TemplateFolder.'images/website_contactus.gif" name="Image7" border="0" id="Image7" /></a><a href="'.$LinkWebBlog.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image6\',\'\',\''.$TemplateFolder.'images/website_blog_hover.gif\',1)"><img src="'.$TemplateFolder.'images/website_blog.gif" name="Image6" border="0" id="Image6" /></a>';

					if($arrayStore[0]['WebsiteStoreOption']=='ws' ){
						$TopMenuBars .= '<a href="'.$LinkHome.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image8\',\'\',\''.$TemplateFolder.'images/website_visit_store_hover.gif\',1)" ><img src="'.$TemplateFolder.'images/website_visit_store.gif" name="Image8"  border="0" id="Image8" /></a>';
					}


				}else{

					$TopMenuBars = '<a href="'.$LinkWebHome.'" class="menu_link">'.HOME.'</a><a href="'.$LinkWebAbout.'" class="menu_link">'.ABOUT_US.'</a><a href="'.$LinkWebContact.'" class="menu_link">'.CONTACT_US.'</a><a href="'.$LinkWebBlog.'"   class="menu_link">'.WEBSITES_BLOG.'</a>';

					if($arrayStore[0]['WebsiteStoreOption']=='ws' ){
						$TopMenuBars .= '<a href="'.$LinkHome.'"   class="menu_link">'.VIEW_STORE.'</a>';
					}

				}


		}else{

				if($arrySite[0]['HeaderMenuButton']=='image'){
					$BodyOnload = 'onload="MM_preloadImages(\''.$TemplateFolder.'images/button_home_hover.gif\',\''.$TemplateFolder.'images/button_aboutus_hover.gif\',\''.$TemplateFolder.'images/button_shipping_hover.gif\',\''.$TemplateFolder.'images/button_shipping_hover.gif\',\''.$TemplateFolder.'images/button_auctions_hover.gif\',\''.$TemplateFolder.'images/button_contactus_hover.gif\',\''.$TemplateFolder.'images/button_website_hover.gif\')"';	

					$TopMenuBars = '<a href="'.$LinkHome.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image2\',\'\',\''.$TemplateFolder.'images/button_home_hover.gif\',1)"><img src="'.$TemplateFolder.'images/button_home.gif" name="Image2" border="0" id="Image2" /></a><a href="'.$LinkAbout.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image3\',\'\',\''.$TemplateFolder.'images/button_aboutus_hover.gif\',1)"><img src="'.$TemplateFolder.'images/button_aboutus.gif" name="Image3"  border="0" id="Image3" /></a><a href="'.$LinkShipping.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image4\',\'\',\''.$TemplateFolder.'images/button_shipping_hover.gif\',1)"><img src="'.$TemplateFolder.'images/button_shipping.gif" name="Image4" border="0" id="Image4" /></a><a href="'.$LinkPolicy.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image5\',\'\',\''.$TemplateFolder.'images/button_policy_hover.gif\',1)"><img src="'.$TemplateFolder.'images/button_policy.gif" name="Image5" border="0" id="Image5" /></a><a href="'.$LinkAuctions.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image6\',\'\',\''.$TemplateFolder.'images/button_auctions_hover.gif\',1)"><img src="'.$TemplateFolder.'images/button_auctions.gif" name="Image6" border="0" id="Image6" /></a><a href="'.$LinkContact.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image7\',\'\',\''.$TemplateFolder.'images/button_contactus_hover.gif\',1)"><img src="'.$TemplateFolder.'images/button_contactus.gif" name="Image7" border="0" id="Image7" /></a>';


					if($arrayStore[0]['WebsiteStoreOption']=='ws' ){
						$TopMenuBars .= '<a href="'.$LinkWebsite.'" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage(\'Image8\',\'\',\''.$TemplateFolder.'images/button_website_hover.gif\',1)" ><img src="'.$TemplateFolder.'images/button_website.gif" name="Image8"  border="0" id="Image8" /></a>';
					}



				}else{

					$TopMenuBars = '<a href="'.$LinkHome.'" class="menu_link">'.STORE_HOME.'</a><a href="'.$LinkAbout.'" class="menu_link">'.STORE_ABOUT_US.'</a><a href="'.$LinkShipping.'" class="menu_link">'.STORE_SHIPPING_INFORMATION.'</a><a href="'.$LinkPolicy.'"class="menu_link" >'.STORE_COMPANY_POLICIES.'</a><a href="'.$LinkAuctions.'" class="menu_link">'.STORE_VIEW_AUCTIONS.'</a><a href="'.$LinkContact.'" class="menu_link">'.STORE_CONTACT_US.'</a>';

					if($arrayStore[0]['WebsiteStoreOption']=='ws' ){
						$TopMenuBars .= '<a href="'.$LinkWebsite.'"   class="menu_link">'.STORE_VISIT_WEBSITE.'</a>';
					}


				}

		}



	$TopMenuBars = '<Div class="TopMenuDiv" style="clear:both">
						<table cellspacing="0" cellpadding="0" border=0 width="100%" class="menu_bg">
						  <tr>
							<td align="left" nowarp >'.$TopMenuBars.'</td>
						  </tr>
						</table></Div>';

		



	}
?>