<table cellspacing="0" cellpadding="0" width="100%" align="center">
  <tr>
    <td align="left"  width="100%" valign="top">
     <table cellspacing="0" cellpadding="0" width="100%" align="center">

     <!-- <tr>
        <td  align="left" valign="middle" class="heading">
		
		<//?=$_SESSION['SUCC_TITLE']?> 
		</td>
      </tr>-->
      <tr>
        <td height="35"></td>
      </tr>
      <tr>
        <td height="32" class="generaltxt_inner">
		
			<? echo '<Div align=center class=redtxt>'.$_SESSION['mess_account'].'</Div>'; ?>
	
	<br><Div align=center class=blacktxt> 
	<?
	 /*if(empty($_GET['logout'])){ echo REDIRECTING;
	} */
	?>
	 <a href="<?=$RedirectUrl?>"><?=CLICK_TO_CONTINUE?></a></Div>

		
		</td>
      </tr>
    </table></td>
    </td>
  </tr>
</table>


<script language="javascript1.2">
var RedirectUrl = '<?=$RedirectUrl?>';
var LogOut = '<?=$_GET['logout']?>';
window.setTimeout(RedirectToNext,5000);

function RedirectToNext(){
	if(LogOut == '')
		//location.href = RedirectUrl;
}
</script>
