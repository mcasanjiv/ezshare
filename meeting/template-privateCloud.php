<?php

?>

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
<div id="skip-link"><a href="#main-content"
	class="element-invisible element-focusable">Skip to main content</a></div>
<style>
.tabs {
	display: block;
}

#page-title {
	color: #333;
	font-size: 32px;
	font-weight: 300;
	margin: 50px 0 0;
	padding: 0 0 30px;
	text-align: left;
}
</style>

<div id="wrapper">

<div id="mainContainer"><header id="headerArea">

<div class="wrap clearfix">

<div class="logo"><a href="index.php" title="Home" rel="home" id="logo">
<img src="img/eZnetLogo.png" alt="Home"> </a></div>
<?php include('includes/user_menu.php');?> <nav class="menuArea">
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
		class="sf-depth-1"><?php echo $meData['Title'];?> </a></li>


		<?php } ?>

</ul>
</div>
</div>
</div>
</nav></div>

</header>

<div class="top-cont1"></div>

<section id="mainContent"> 

		<?php echo $datah['Content'];?>

<a href="index.php?slug=privateCloudUser" class="continue-cl">Buy Now</a>

</section></div>


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


<br>
<br>
<br>
<br>
<br>
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
<form novalidate="novalidate" class="simplenews-subscribe" id="srform"
	name="form" accept-charset="UTF-8">
<div>
<div class="form-item form-type-textfield form-item-mail"><label
	for="edit-mail">E-mail <span class="form-required"
	title="This field is required.">*</span> </label> <input
	placeholder="Your Email" id="email" name="email" size="20"
	maxlength="128" class="form-text required" type="text"></div>
<a href="javascript:void(0)" id="submit" onclick="subcription()">Subscribe</a>
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
<div id="block-system-main-menu" class="block block-system block-menu">

<h2>Main menu</h2>

<div class="content">
<ul class="menu">
<?php
$bannerDt=showBanner();
foreach($mData as $meData){ //echo "<pre>";print_r($meData);?>

	<li id="menu-218-1" class="leaf"><a
		href="index.php?slug=<?php echo $meData['UrlCustom'];?>"
		class="sf-depth-1"><?php echo $meData['Title'];?> </a></li>


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
&#169; <?php echo date("Y"); ?> , EZnet CRM. All Rights Reserved</p>
</div>
</div>
</div>

</div>

<div class="newsLetter logedout">

<div class="region region-footer-thirdcolumn">
<div id="block-block-15" class="block block-block">


<div class="content">
<p style="line-height: 175%;">&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;<img
	src="img/eZnetLogo_0_1.png"></p>
<!-- <p><p><span style="font-size:15px; font-weight: 400; font-family:'Open Sans', sans-serif; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; 650 Technology Park</span></p>
<p><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; Lake Mary, FL 32746</span></p>
<p><span style="font-family:'Open Sans', sans-serif; font-size:15px; font-weight: 400; line-height: 150%;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 1-877-368-4446</span></p>
<p> -->
<p><img width="30px" height="30px"
	style="display: inline; vertical-align: text-bottom;"
	src="img/headphones-icon-customer-support_1.png"><span
	style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;&nbsp;407-544-3201
| 1-877-368-4446</span></p>
<p><img width="30px" height="30px"
	style="display: inline; vertical-align: text-bottom;"
	src="img/edit-icon_0.png"><span
	style="font-family: 'Open Sans', sans-serif; font-size: 15px; font-weight: 400; line-height: 150%;">&nbsp;
<a href="mailto:info@eznetcrm.com">info@eznetcrm.com</a></span></p>
</div>


</div>
</div>

</div>

</div>

</footer></div>


<p style="display: none;" id="back-top"><a href="#top"><span id="button"></span><span
	id="link">Back to top</span> </a></p>
</body>
</html>
