<!DOCTYPE html>
<html style="" class="js js no-touch csstransforms csstransitions"
	lang="en-US">
<head profile="http://www.w3.org/1999/xhtml/vocab">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="shortcut icon"
	href="http://www.eznetcrm.com/misc/favicon.ico"
	type="image/vnd.microsoft.icon">
<link rel="shortlink" href="http://www.eznetcrm.com/node/14">

<link rel="canonical" href="http://www.eznetcrm.com/home">
<meta name="<?php echo $datah['Title'];?>" content="">
<title><?php echo $datah['MetaTitle'];?></title>

<meta name="viewport"
	content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body
	class="html front not-logged-in no-sidebars page-node page-node- page-node-14 node-type-page responsive-menus-load-processed">
	<div id="skip-link">
		<a href="#main-content" class="element-invisible element-focusable">Skip
			to main content</a>
	</div>
	<div id="wrapper">

		<div id="mainContainer">

			<header id="headerArea">

				<div class="wrap clearfix">

					<div class="logo">
						<a href="index.php" title="Home" rel="home" id="logo"> <img
							src="img/eZnetLogo.png" alt="Home"> </a>
					</div>
					<?php include('includes/user_menu.php');?>
					<nav class="menuArea">
						<div class="region region-main-menu">
							<div id="block-superfish-1" class="block block-superfish">


								<div class="content">
									<ul id="superfish-1"
										class="menu sf-menu sf-main-menu sf-horizontal sf-style-none sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow">
										<?php
										$bannerDt=showBanner();
										foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

										<li id="menu-218-1"
											class=" middle even sf-item-2 sf-depth-1 sf-no-children <?php if($_GET['slug']==$meData['UrlCustom']){echo 'active-trail first odd sf-item-1 sf-depth-1 sf-no-children';}?>"><a
											href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
											class="sf-depth-1"><?php echo $meData['Title'];?> </a>
										</li>


										<?php } ?>

									</ul>
								</div>
							</div>
						</div>
					</nav>

				</div>

			</header>
<script type="text/javascript">
$(document).ready(function() {
	// Change CAPTCHA on each click or on refreshing page.
	$("#reload").click(function() {
	$("#img").remove();
	$('<img id="img" src="captcha.php" />').appendTo("#imgdiv");
	});
	// Validation Function
	$('#button2').click(function() {
	var name = $("#Name").val();
	var email = $("#Email").val();
	var phone = $("#Phone").val();
	var company = $("#Company").val();
	var country = $("#Country").val();
	var editon = $("#Editon").val();
	var user = $("#numbers_of_crm_users").val();
	var comments = $("#Comments").val();
	var captcha = $("#captcha1").val();
	var dataString = 'name=' + name + '&email=' + email + '&phone=' + phone + '&company='  + company + '&country=' + country + '&editon=' + editon +  '&user=' + user +  '&comments=' + comments + '&captcha=' + captcha ;
	if(name =='' ){
		alert("Please Fill Required Fields");
	}else{

		$.ajax({
		type: "POST",
		url: "ajax.php",
		data: dataString,
		success: function(html) {
		alert(html);
		}
		});
	}


	});
	});
</script>

			<div class="top-cont1"></div>
			<section id="mainContent">
			<?php //echo $datah['Content'];?>
<?php 


?>
				<div class="InfoText">

					<div class="wrap clearfix">


						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title">eZnet CRM Price Quote</h1>
										<div class="tabs"></div>

										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">


												<div class="content">
													<div typeof="sioc:Item foaf:Document"
														about="/eznet-crm-price-quote"
														class="node node-webform node-promoted clearfix"
														id="node-37">



														<div class="content clearfix">
															<div
																class="field field-name-body field-type-text-with-summary field-label-hidden">
																<div class="field-items">
																	<div property="content:encoded" class="field-item even">
																		<div
																			style="text-align: right; width: 100%; padding-bottom: 30px; padding-top: 10px;">
																			<span style="font-size: 15px;"><a
																				href="index.php?slug=pricing-signup">Pricing
																					&amp; Signup</a>&nbsp;&gt;&gt;&nbsp;Get Quote</span>
																		</div>
																		<p>Thank you for your interest in eZnet CRM. Please
																			fill the below form. We will get back to you shortly
																			with a price quote.</p>
																	</div>
																</div>
															</div>
															<div class="messages error clientside-error"
																id="clientsidevalidation-webform-client-form-37-errors"
																style="display: none;">
																<ul></ul>
															</div>
															<form accept-charset="UTF-8" id="webform-client-form-37"
																method="post" action="#"
																enctype="multipart/form-data"
																class="webform-client-form" novalidate="novalidate">
																<div>
																	<div id="webform-component-name"
																		class="form-item webform-component webform-component-textfield webform-container-inline">
																		<label for="edit-submitted-name">Name <span
																			title="This field is required." class="form-required">*</span>
																		</label> <input type="text" class="form-text required"
																			maxlength="128" size="60" value=""
																			name="Name" id="Name">
																	</div>
																	<div id="webform-component-email"
																		class="form-item webform-component webform-component-email webform-container-inline">
																		<label for="edit-submitted-email">Email <span
																			title="This field is required." class="form-required">*</span>
																		</label> <input type="email" size="60"
																			name="Email" id="Email"
																			class="email form-text form-email required">
																	</div>
																	<div id="webform-component-phone-no"
																		class="form-item webform-component webform-component-textfield webform-container-inline">
																		<label for="edit-submitted-phone-no">Phone No <span
																			title="This field is required." class="form-required">*</span>
																		</label> <input type="text" class="form-text required"
																			maxlength="128" size="60" value=""
																			name="Phone"
																			id="Phone">
																	</div>
																	<div id="webform-component-company"
																		class="form-item webform-component webform-component-textfield webform-container-inline">
																		<label for="edit-submitted-company">Company <span
																			title="This field is required." class="form-required">*</span>
																		</label> <input type="text" class="form-text required"
																			maxlength="128" size="60" value=""
																			name="Company" id="Company">
																	</div>
																	<div id="webform-component-country"
																		class="form-item webform-component webform-component-select webform-container-inline">
																		<label for="edit-submitted-country">Country <span
																			title="This field is required." class="form-required">*</span>
																		</label> <select class="form-select required"
																			name="Country" id="Country"><option
																				selected="selected" value="">- Select -</option>
																			<option value="AF">Afghanistan</option>
																			<option value="AX">Aland Islands</option>
																			<option value="AL">Albania</option>
																			<option value="DZ">Algeria</option>
																			<option value="AS">American Samoa</option>
																			<option value="AD">Andorra</option>
																			<option value="AO">Angola</option>
																			<option value="AI">Anguilla</option>
																			<option value="AQ">Antarctica</option>
																			<option value="AG">Antigua and Barbuda</option>
																			<option value="AR">Argentina</option>
																			<option value="AM">Armenia</option>
																			<option value="AW">Aruba</option>
																			<option value="AU">Australia</option>
																			<option value="AT">Austria</option>
																			<option value="AZ">Azerbaijan</option>
																			<option value="BS">Bahamas</option>
																			<option value="BH">Bahrain</option>
																			<option value="BD">Bangladesh</option>
																			<option value="BB">Barbados</option>
																			<option value="BY">Belarus</option>
																			<option value="BE">Belgium</option>
																			<option value="BZ">Belize</option>
																			<option value="BJ">Benin</option>
																			<option value="BM">Bermuda</option>
																			<option value="BT">Bhutan</option>
																			<option value="BO">Bolivia</option>
																			<option value="BA">Bosnia and Herzegovina</option>
																			<option value="BW">Botswana</option>
																			<option value="BV">Bouvet Island</option>
																			<option value="BR">Brazil</option>
																			<option value="IO">British Indian Ocean Territory</option>
																			<option value="VG">British Virgin Islands</option>
																			<option value="BN">Brunei</option>
																			<option value="BG">Bulgaria</option>
																			<option value="BF">Burkina Faso</option>
																			<option value="BI">Burundi</option>
																			<option value="KH">Cambodia</option>
																			<option value="CM">Cameroon</option>
																			<option value="CA">Canada</option>
																			<option value="CV">Cape Verde</option>
																			<option value="BQ">Caribbean Netherlands</option>
																			<option value="KY">Cayman Islands</option>
																			<option value="CF">Central African Republic</option>
																			<option value="TD">Chad</option>
																			<option value="CL">Chile</option>
																			<option value="CN">China</option>
																			<option value="CX">Christmas Island</option>
																			<option value="CC">Cocos (Keeling) Islands</option>
																			<option value="CO">Colombia</option>
																			<option value="KM">Comoros</option>
																			<option value="CG">Congo (Brazzaville)</option>
																			<option value="CD">Congo (Kinshasa)</option>
																			<option value="CK">Cook Islands</option>
																			<option value="CR">Costa Rica</option>
																			<option value="HR">Croatia</option>
																			<option value="CU">Cuba</option>
																			<option value="CW">Curaçao</option>
																			<option value="CY">Cyprus</option>
																			<option value="CZ">Czech Republic</option>
																			<option value="DK">Denmark</option>
																			<option value="DJ">Djibouti</option>
																			<option value="DM">Dominica</option>
																			<option value="DO">Dominican Republic</option>
																			<option value="EC">Ecuador</option>
																			<option value="EG">Egypt</option>
																			<option value="SV">El Salvador</option>
																			<option value="GQ">Equatorial Guinea</option>
																			<option value="ER">Eritrea</option>
																			<option value="EE">Estonia</option>
																			<option value="ET">Ethiopia</option>
																			<option value="FK">Falkland Islands</option>
																			<option value="FO">Faroe Islands</option>
																			<option value="FJ">Fiji</option>
																			<option value="FI">Finland</option>
																			<option value="FR">France</option>
																			<option value="GF">French Guiana</option>
																			<option value="PF">French Polynesia</option>
																			<option value="TF">French Southern Territories</option>
																			<option value="GA">Gabon</option>
																			<option value="GM">Gambia</option>
																			<option value="GE">Georgia</option>
																			<option value="DE">Germany</option>
																			<option value="GH">Ghana</option>
																			<option value="GI">Gibraltar</option>
																			<option value="GR">Greece</option>
																			<option value="GL">Greenland</option>
																			<option value="GD">Grenada</option>
																			<option value="GP">Guadeloupe</option>
																			<option value="GU">Guam</option>
																			<option value="GT">Guatemala</option>
																			<option value="GG">Guernsey</option>
																			<option value="GN">Guinea</option>
																			<option value="GW">Guinea-Bissau</option>
																			<option value="GY">Guyana</option>
																			<option value="HT">Haiti</option>
																			<option value="HM">Heard Island and McDonald Islands</option>
																			<option value="HN">Honduras</option>
																			<option value="HK">Hong Kong S.A.R., China</option>
																			<option value="HU">Hungary</option>
																			<option value="IS">Iceland</option>
																			<option value="IN">India</option>
																			<option value="ID">Indonesia</option>
																			<option value="IR">Iran</option>
																			<option value="IQ">Iraq</option>
																			<option value="IE">Ireland</option>
																			<option value="IM">Isle of Man</option>
																			<option value="IL">Israel</option>
																			<option value="IT">Italy</option>
																			<option value="CI">Ivory Coast</option>
																			<option value="JM">Jamaica</option>
																			<option value="JP">Japan</option>
																			<option value="JE">Jersey</option>
																			<option value="JO">Jordan</option>
																			<option value="KZ">Kazakhstan</option>
																			<option value="KE">Kenya</option>
																			<option value="KI">Kiribati</option>
																			<option value="KW">Kuwait</option>
																			<option value="KG">Kyrgyzstan</option>
																			<option value="LA">Laos</option>
																			<option value="LV">Latvia</option>
																			<option value="LB">Lebanon</option>
																			<option value="LS">Lesotho</option>
																			<option value="LR">Liberia</option>
																			<option value="LY">Libya</option>
																			<option value="LI">Liechtenstein</option>
																			<option value="LT">Lithuania</option>
																			<option value="LU">Luxembourg</option>
																			<option value="MO">Macao S.A.R., China</option>
																			<option value="MK">Macedonia</option>
																			<option value="MG">Madagascar</option>
																			<option value="MW">Malawi</option>
																			<option value="MY">Malaysia</option>
																			<option value="MV">Maldives</option>
																			<option value="ML">Mali</option>
																			<option value="MT">Malta</option>
																			<option value="MH">Marshall Islands</option>
																			<option value="MQ">Martinique</option>
																			<option value="MR">Mauritania</option>
																			<option value="MU">Mauritius</option>
																			<option value="YT">Mayotte</option>
																			<option value="MX">Mexico</option>
																			<option value="FM">Micronesia</option>
																			<option value="MD">Moldova</option>
																			<option value="MC">Monaco</option>
																			<option value="MN">Mongolia</option>
																			<option value="ME">Montenegro</option>
																			<option value="MS">Montserrat</option>
																			<option value="MA">Morocco</option>
																			<option value="MZ">Mozambique</option>
																			<option value="MM">Myanmar</option>
																			<option value="NA">Namibia</option>
																			<option value="NR">Nauru</option>
																			<option value="NP">Nepal</option>
																			<option value="NL">Netherlands</option>
																			<option value="AN">Netherlands Antilles</option>
																			<option value="NC">New Caledonia</option>
																			<option value="NZ">New Zealand</option>
																			<option value="NI">Nicaragua</option>
																			<option value="NE">Niger</option>
																			<option value="NG">Nigeria</option>
																			<option value="NU">Niue</option>
																			<option value="NF">Norfolk Island</option>
																			<option value="MP">Northern Mariana Islands</option>
																			<option value="KP">North Korea</option>
																			<option value="NO">Norway</option>
																			<option value="OM">Oman</option>
																			<option value="PK">Pakistan</option>
																			<option value="PW">Palau</option>
																			<option value="PS">Palestinian Territory</option>
																			<option value="PA">Panama</option>
																			<option value="PG">Papua New Guinea</option>
																			<option value="PY">Paraguay</option>
																			<option value="PE">Peru</option>
																			<option value="PH">Philippines</option>
																			<option value="PN">Pitcairn</option>
																			<option value="PL">Poland</option>
																			<option value="PT">Portugal</option>
																			<option value="PR">Puerto Rico</option>
																			<option value="QA">Qatar</option>
																			<option value="RE">Reunion</option>
																			<option value="RO">Romania</option>
																			<option value="RU">Russia</option>
																			<option value="RW">Rwanda</option>
																			<option value="BL">Saint Barthélemy</option>
																			<option value="SH">Saint Helena</option>
																			<option value="KN">Saint Kitts and Nevis</option>
																			<option value="LC">Saint Lucia</option>
																			<option value="MF">Saint Martin (French part)</option>
																			<option value="PM">Saint Pierre and Miquelon</option>
																			<option value="VC">Saint Vincent and the Grenadines</option>
																			<option value="WS">Samoa</option>
																			<option value="SM">San Marino</option>
																			<option value="ST">Sao Tome and Principe</option>
																			<option value="SA">Saudi Arabia</option>
																			<option value="SN">Senegal</option>
																			<option value="RS">Serbia</option>
																			<option value="SC">Seychelles</option>
																			<option value="SL">Sierra Leone</option>
																			<option value="SG">Singapore</option>
																			<option value="SX">Sint Maarten</option>
																			<option value="SK">Slovakia</option>
																			<option value="SI">Slovenia</option>
																			<option value="SB">Solomon Islands</option>
																			<option value="SO">Somalia</option>
																			<option value="ZA">South Africa</option>
																			<option value="GS">South Georgia and the South
																				Sandwich Islands</option>
																			<option value="KR">South Korea</option>
																			<option value="SS">South Sudan</option>
																			<option value="ES">Spain</option>
																			<option value="LK">Sri Lanka</option>
																			<option value="SD">Sudan</option>
																			<option value="SR">Suriname</option>
																			<option value="SJ">Svalbard and Jan Mayen</option>
																			<option value="SZ">Swaziland</option>
																			<option value="SE">Sweden</option>
																			<option value="CH">Switzerland</option>
																			<option value="SY">Syria</option>
																			<option value="TW">Taiwan</option>
																			<option value="TJ">Tajikistan</option>
																			<option value="TZ">Tanzania</option>
																			<option value="TH">Thailand</option>
																			<option value="TL">Timor-Leste</option>
																			<option value="TG">Togo</option>
																			<option value="TK">Tokelau</option>
																			<option value="TO">Tonga</option>
																			<option value="TT">Trinidad and Tobago</option>
																			<option value="TN">Tunisia</option>
																			<option value="TR">Turkey</option>
																			<option value="TM">Turkmenistan</option>
																			<option value="TC">Turks and Caicos Islands</option>
																			<option value="TV">Tuvalu</option>
																			<option value="VI">U.S. Virgin Islands</option>
																			<option value="UG">Uganda</option>
																			<option value="UA">Ukraine</option>
																			<option value="AE">United Arab Emirates</option>
																			<option value="GB">United Kingdom</option>
																			<option value="US">United States</option>
																			<option value="UM">United States Minor Outlying
																				Islands</option>
																			<option value="UY">Uruguay</option>
																			<option value="UZ">Uzbekistan</option>
																			<option value="VU">Vanuatu</option>
																			<option value="VA">Vatican</option>
																			<option value="VE">Venezuela</option>
																			<option value="VN">Vietnam</option>
																			<option value="WF">Wallis and Futuna</option>
																			<option value="EH">Western Sahara</option>
																			<option value="YE">Yemen</option>
																			<option value="ZM">Zambia</option>
																			<option value="ZW">Zimbabwe</option>
																		</select>
																	</div>
																	<div id="webform-component-select-editon"
																		class="form-item webform-component webform-component-select webform-container-inline">
																		<label for="edit-submitted-select-editon">Select
																			Editon <span title="This field is required."
																			class="form-required">*</span> </label> <select
																			class="form-select required"
																			name="Editon"
																			id="Editon"><option
																				selected="selected" value="">- Select -</option>
																			<option value="7">STANDARD</option>
																			<option value="8">PROFESSIONAL</option>
																			<option value="9">ENTERPRISE</option>
																		</select>
																	</div>
																	<div id="webform-component-numbers-of-crm-users"
																		class="form-item webform-component webform-component-textfield webform-container-inline">
																		<label for="edit-submitted-numbers-of-crm-users">Numbers
																			of CRM Users <span title="This field is required."
																			class="form-required">*</span> </label> <input
																			type="text" class="form-text required"
																			maxlength="128" size="60" value=""
																			name="numbers_of_crm_users"
																			id="numbers_of_crm_users">
																	</div>
																	<div id="webform-component-comments"
																		class="form-item webform-component webform-component-textarea">
																		<label for="edit-submitted-comments">Comments <span
																			title="This field is required." class="form-required">*</span>
																		</label>
																		<div
																			class="form-textarea-wrapper resizable textarea-processed resizable-textarea">
																			<textarea class="form-textarea required" rows="5"
																				cols="60" name="Comments"
																				id="Comments"></textarea>
																			<div class="grippie"></div>
																		</div>
																	</div>
			
																			<div class="form-item webform-component webform-component-textfield" id="webform-component-phone-no-contactus">
																			  <label for="edit-submitted-phone-no-contactus">CAPTCHA</label>
																			  <div id="imgdiv"><img id="img" src="captcha.php" />
																			 <div class="cerror3"></div>
																			<div class="form-item form-type-textfield form-item-captcha-response">
																			  <label for="edit-captcha-response">What code is in the image? <span title="This field is required." class="form-required">*</span></label>
																			 <input id="captcha1" name="captcha" type="text">
																			
																			</div>
																			
																			</div>
																	<div id="edit-actions"
																		class="form-actions form-wrapper">
                                                                      <input type='button' class="form-submit" id="button2" value='Submit'>
																	</div>
																</div>
															</form>
														</div>


													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</article>

					</div>

				</div>


			</section>

		</div>


		<footer id="footer">

			<div class="wrap clearfix">

				<div class="followUs">
					<h2>Follow Us</h2>
					<div class="region region-footer-firstcolumn">
						<div id="block-block-1" class="block block-block">


							<div class="content">
								<ul>
									<?php
								$socialDat=getSocialLinks();
								foreach($socialDat as $socialData){?>
									<li><a href="<?php echo $socialData['URI'];?>" target="_blank"><img
											src="../images/<?php echo $socialData['Icon'];?>"> </a></li>
									<?php } ?>


								</ul>


								<br> <br> <br> <br> <br>
								<h2>Subscribe to our Newsletter</h2>
							</div>
						</div>
						<div id="block-simplenews-1" class="block block-simplenews">


							<div class="content">

								<div style="display: none;"
									id="clientsidevalidation-simplenews-block-form-1-errors"
									class="messages error clientside-error">
									<ul></ul>
								</div>
								<form novalidate="novalidate" class="simplenews-subscribe"
									id="srform" name="form" accept-charset="UTF-8">
									<div>
										<div class="form-item form-type-textfield form-item-mail">
											<label for="edit-mail">E-mail <span class="form-required"
												title="This field is required.">*</span> </label> <input
												placeholder="Your Email" id="email" name="email" size="20"
												maxlength="128" class="form-text required" type="text">
										</div>
										<a href="javascript:void(0)" id="submit"
											onclick="subcription()">Subscribe</a>
										<!-- <input id="submit" onclick="subcription()" name="submit" value="Subscribe" type="submit"> -->
										<div class="msg"></div>
									</div>
								</form>


							</div>
						</div>
					</div>

				</div>

				<div class="quickLinks">

					<div class="region region-footer-secondcolumn">
						<div id="block-system-main-menu"
							class="block block-system block-menu">

							<h2>Main menu</h2>

							<div class="content">
								<ul class="menu">
									<?php
								$bannerDt=showBanner();
								foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

									<li id="menu-218-1" class="leaf"><a
										href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
										class="sf-depth-1"><?php echo $meData['Title'];?> </a>
									</li>


									<?php } ?>

								</ul>

							</div>
						</div>
					</div>
					<div class="region region-footer">
						<div id="block-block-17" class="block block-block">


							<div class="content">
								<p
									style="font-size: 14px; font-family: 'Open Sans', sans-serif; text-align: center; font-weight: 400;">
									&#169;
									<?php echo date("Y"); ?>
									, EZnet CRM. All Rights Reserved
								</p>
							</div>
						</div>
					</div>

				</div>

				<div class="newsLetter logedout">

					<div class="region region-footer-thirdcolumn">
						<div id="block-block-15" class="block block-block">


							<div class="content">
								<p style="line-height: 175%;">
									&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<img
										src="img/eZnetLogo_0_1.png">
								</p>
								<!-- <p><p><span style="font-size:15px; font-weight: 400; font-family:'Open Sans', sans-serif; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; 650 Technology Park</span></p>
<p><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; Lake Mary, FL 32746</span></p>
<p><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1-877-368-4446</span></p>
<p> -->
								<p>
									<img width="30px" height="30px"
										style="display: inline; vertical-align: text-bottom;"
										src="img/headphones-icon-customer-support_1.png"><span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;&nbsp;407-544-3201
										| 1-877-368-4446</span>
								</p>
								<p>
									<img width="30px" height="30px"
										style="display: inline; vertical-align: text-bottom;"
										src="img/edit-icon_0.png"><span
										style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
										<a href="mailto:info@eznetcrm.com">info@eznetcrm.com</a> </span>
								</p>
							</div>


						</div>
					</div>

				</div>

			</div>

		</footer>


	</div>


	<p style="display: none;" id="back-top">
		<a href="#top"><span id="button"></span><span id="link">Back to top</span>
		</a>
	</p>
</body>
</html>
