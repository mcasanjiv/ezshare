<? if (!empty($_GET['view55'])) { ?>

<div class="right-search">
  <h4><span class="icon"></span>
    <?=stripslashes($arryContact[0]['FirstName']).' '.stripslashes($arryContact[0]['LastName'])?>
  </h4>
  <div class="right_box">
    <div id="imgGal">
      <? if($arryContact[0]['Image'] !='' && file_exists('upload/contact/'.$arryContact[0]['Image']) ){ 
	$ImageExist = 1;
?>
      <div  id="ImageDiv" align="center"><a class="fancybox" data-fancybox-group="gallery" href="upload/contact/<?=$arryContact[0]['Image']?>"  title="<?=$arryContact[0]['UserName']?>"><? echo '<img src="resizeimage.php?w=120&h=120&img=upload/contact/'.$arryContact[0]['Image'].'" border=0 >';?></a> <br />
      </div>
      <?	}else{ ?>
      <div  id="ImageDiv" align="center"><img src="../../resizeimage.php?w=120&h=120&img=images/nouser.gif" title="<?=stripslashes($arryContact[0]['FirstName']).' '.stripslashes($arryContact[0]['LastName'])?>" /></div>
      <? } ?>
      
    </div>
	
  </div>
</div>
<? }else{
	$SetInnerWidth=1;
} ?>
