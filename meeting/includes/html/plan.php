<section id="mainContent"> <?php //echo $datah['Content'];?>

<div class="InfoText">
<div class="wrap clearfix"><article id="leftPart">
<div class="detailedContent">
<div id="content" class="column">
<div class="section">
<h1 class="title" id="page-title">PLANS & PRICING</h1>
<div class="tabs">&nbsp;</div>
<div id="banner">
<div class="region region-slider">
<div id="block-views-inner-slider-block" class="block block-views">
<div class="content">
<div
	class="view view-inner-slider view-id-inner_slider view-display-id-block view-dom-id-5a5b298d5c2896f876c2f50db1084d66">
<div class="view-content">
<div
	class="views-row views-row-1 views-row-odd views-row-first views-row-last">
<div class="views-field views-field-field-inner-slider-image">
<div class="field-content">&nbsp;</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="region region-content">
<div id="block-system-main" class="block block-system">
<div class="content">
<div id="node-71" class="node node-page clearfix"
	about="/pricing-signup" typeof="foaf:Document">
<div class="content clearfix">
<div
	class="field field-name-body field-type-text-with-summary field-label-hidden">
<div class="field-items">
<div class="field-item even" property="content:encoded">
<div class="toptitle">
<p>Get a 30 Day Free Trial! No Credit Card Required.</p>
</div>
<div class="planWrap clearfix"><!--.....plan-03 start......--> <?php
$pricePackage=getPackAndPriceById();

//echo "<pre>";print_r($pricePackage);
//die;

if(!empty($pricePackage)){
	foreach($pricePackage as $pricePackg){?>

<div class="plan">
<div class="head">
<h3><?php echo $pricePackg['name'];?></h3>
<p><?php echo $pricePackg['short_description'];?></p>
</div>
<div class="price">US <span>$<?php echo $pricePackg['price'];?> </span>
<p><?php echo $pricePackg['duration'];?></p>
</div>
<div class="feature"><?php echo $pricePackg['edition_features'];?> <span>plus</span>
</div>
<div class="des">
<p><?php echo $pricePackg['description'];?></p>
</div>

<?php 
if($pricePackg['id']==14){?>

<div class="more">
<a href=""></a>
</div>

<div class="tryNow">
<a href="index.php?slug=privateCloud">TRY NOW</a>
</div>


	
<?php } else { ?>

<div class="more"><a
	href="meeting-comparison.php">Plan
Details</a>
</div>



<div class="tryNow"><?php if(!empty($_SESSION['CrmDisplayName'])){?> <a
	href="meeting-comparison.php&pack_id=<?php echo $pricePackg['id'];?>">TRY
NOW</a> <?php } else{ ?> <a href="meeting-comparison.php">TRY NOW</a> <?php } ?>
</div>



</div>
	<?php } }

}

?>

</div>


</div>

<div class="get-quote"><a
	href="<?php echo $_SERVER['PHP_SELF']; ?>?slug=price-quote">GET QUOTE</a>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</article></div>
</div>
</section>