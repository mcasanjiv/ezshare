<?php 
	require_once("includes/settings.php"); 
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

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.once.js"></script>
<script type="text/javascript" src="js/drupal.js"></script>
<script type="text/javascript" src="js/admin_devel.js"></script>
<script type="text/javascript" src="js/pre_payment.js"></script>
<script type="text/javascript" src="js/scroll_to_top.js"></script>
<script type="text/javascript" src="js/jquery.flexslider.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<script type="text/javascript" src="js/responsive_menus_simple.js"></script>
<script type="text/javascript" src="js/jquery.hoverIntent.minified.js"></script>
<script type="text/javascript" src="js/sfsmallscreen.js"></script>
<script type="text/javascript" src="js/supposition.js"></script>
<script type="text/javascript" src="js/modernizr.custom.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<link href="css/jquery.validate.css" rel="stylesheet" type="text/css">
<link href="css/responsive_menus_simple.css" rel="stylesheet" type="text/css">
<link href="css/scroll_to_top.css" rel="stylesheet" type="text/css">
<link href="css/search.css" rel="stylesheet" type="text/css">
<link href="css/simplenews.css" rel="stylesheet" type="text/css">
<link href="css/style.css" rel="stylesheet" type="text/css">
<link href="css/superfish.css" rel="stylesheet" type="text/css">
<link href="css/system.base.css" rel="stylesheet" type="text/css">
<link href="css/system.menus.css" rel="stylesheet" type="text/css">
<link href="css/system.messages.css" rel="stylesheet" type="text/css">
<link href="css/system.theme.css" rel="stylesheet" type="text/css">
<link href="css/user.css" rel="stylesheet" type="text/css">
<link href="css/views.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/owl.carousel.min.js"></script>
<script type="text/javascript" src="js/flexslider.load.js"></script>
<script type="text/javascript" src="js/owlcarousel.settings.js"></script>
<script type="text/javascript" src="js/clientside_validation.ie8.js"></script>
<script type="text/javascript" src="js/clientside_validation_html5.js"></script>
<script type="text/javascript" src="js/clientside_validation.js"></script>


<script language="javascript" src="../includes/validate.js"></script>
<script language="javascript" src="../includes/global.js"></script>
<script language="javascript" src="../includes/ajax.js"></script>

<script language="javascript" src="../includes/tooltip.js"></script>

<link rel="stylesheet" href="../fancybox/jquery_calender/jquery-ui.css" />

<script type="text/javascript" src="../fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="../fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
var GlobalSiteUrl = '<?php echo $Config['Url']?>';
	$(document).ready(function() { 
		$('.fancybox').fancybox({minHeight:300});
	});
</script>
<link rel="stylesheet" href="../fancybox/jquery_calender/jquery-ui_Backup.css" />

<script src="../fancybox/jquery_calender/jquery-ui.js"></script>
<link rel="stylesheet" href="../fancybox/timepicker/jquery.timepicker.css" />
<script src="../fancybox/timepicker/jquery.timepicker.js"></script>



<script language="javascript1.2" type="text/javascript">
function ShowHideLoader(opt,DivID){

}
</script>

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

</head>
<body class="html front not-logged-in no-sidebars page-node page-node- page-node-14 node-type-page responsive-menus-load-processed">
<div id="skip-link">
		<a href="#main-content" class="element-invisible element-focusable">Skip
			to main content</a>
	</div>
	<div id="wrapper">

		<div id="mainContainer">

<?php if(!$FancyBox){?>
			<header id="headerArea">

				<div class="wrap clearfix">

					<div class="logo">
					 <? 
				       /* if($arryCompany[0]['Image'] !='' && file_exists($Config['Url'].'upload/company/'.$arryCompany[0]['Image']) ){ die;
				                $SiteLogo = 'resizeimage.php?w=120&h=120&bg=f1f1f1&img=upload/company/'.$arryCompany[0]['Image'];
				        }else{
				                $SiteLogo = '../images/logo.png';
				                <img
							src="<?=$SiteLogo?>" alt="<?=$Config['SiteName']?>" title="<?=$Config['SiteName']?>" border="0">
				        }*/
						?>	
						<div class="site-branding">
                        <h1 class="site-title"><a href="index.php" title="EZWebshare" rel="home">EZWebshare</a></h1>
                        <h3 class="site-description">Meet and Talk to Friends!</h3>
               			</div>
					</div>
					<?php include('user_menu.php');?>
					<nav class="menuArea">
						<div class="region region-main-menu">
							<div id="block-superfish-1" class="block block-superfish">


								<div class="content">
									<ul id="superfish-1" class="menu sf-menu sf-main-menu sf-horizontal sf-style-none sf-total-items-5 sf-parent-items-0 sf-single-items-5 superfish-processed sf-js-enabled sf-shadow">
										
										<li id="menu-218-1" class=" middle even sf-item-2 sf-depth-1 sf-no-children "><a href="tour.php" class="sf-depth-1">Tour </a>
										</li>
										<li id="menu-218-1" class=" middle even sf-item-2 sf-depth-1 sf-no-children "><a href="plan.php" class="sf-depth-1">Plan </a>
										</li>
										<li id="menu-218-1" class=" middle even sf-item-2 sf-depth-1 sf-no-children "><a href="about.php" class="sf-depth-1">About </a>
										</li>
										<li id="menu-218-1" class=" middle even sf-item-2 sf-depth-1 sf-no-children "><a href="support.php" class="sf-depth-1">Support </a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</nav>

				</div>

			</header>

<div class="top-cont1"> </div>
<?php }?>
	