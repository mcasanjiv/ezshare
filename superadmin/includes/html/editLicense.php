<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage License Key    <span> &raquo;
	<? 
	if(!empty($_GET['edit'])){
		echo "Edit ".$ModuleName;
	}else{
		echo "Add ".$ModuleName;
	}
	 ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div height="2" align="center"  class="red" ><?php echo $errMsg;?></div>

  <? } 

	include("includes/html/box/license_form.php");
?>

