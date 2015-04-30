<div class="had">Manage <?= ucfirst($_GET['type']) ?>   <span> &raquo; 
        <? echo (!empty($_GET['edit'])) ? ("Edit Custom view ") : ("New " . $_GET["parent_type"] . " " . $ModuleName); ?></span>
</div>
<? if (!empty($errMsg)) { ?>
    <div align="center"  class="red" ><?php echo $errMsg; ?></div>
    <?
}

if ($HideForm != 1) {
    include("includes/html/box/filter_form.php");
}
?>


<? echo '<script>SetInnerWidth();</script>'; ?>





