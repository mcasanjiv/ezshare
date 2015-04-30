<div class="main-container">
  <div class="mid_wraper clearfix">
    <?php include_once("includes/left.php"); ?>
    <div class="right_pen">
      <div class="products_list block">
        <h2>
          <?=$MenuTitle;?>
        </h2>
       
        <?php
			
         if($num>0 ) { 

            if(!empty($_GET['curP']))
            {
                $curPage = $_GET['curP'];
            }
        else {
            $curPage =1;
        }

	$RecordsPerPage = 9;
	
	// Getting the query string
	
	$arryServerVar=$_SERVER;
	$queryString  = str_replace('curP='.$curPage,'', $arryServerVar['QUERY_STRING']);
	$TotalPage = ceil(($num/ $RecordsPerPage));
	
	$pagerLink=$objPager->getPager($bestseller_items,$RecordsPerPage,$curPage);
 	(count($bestseller_items)>0)?($bestseller_items=$objPager->getPageRecords()):("");


	
?>
       
        <ul class="listing_prod clearfix">
          <? 
   
                $i=0;

               foreach($bestseller_items as $key=>$values){
                $i++;
   
    		
		$Price = ($values['Price2']>0)?($values['Price']):($values['Price']);
		$PrdLink   = 'productDetails.php?id='.$values['ProductID'];
		
		
		
	
		if($values['Image'] !='' && file_exists('upload/products/images/'.$values['Image']) ){  
			$ImagePath = 'resizeimage.php?img=upload/products/images/'.$values['Image'].'&w=160&h=160'; 

			$ImagePath = '<img src="'.$ImagePath.'"  border="0" />';
			//$EnlargeImage = '<a onclick="OpenNewPopUp(\'showimage.php?img=upload/products/'.$values['Image'].'\', 150, 100, \'no\' );" href="#" class=skytxt>'.CLICK_TO_ENLARGE.'</a>';
		}else{
			$ImagePath = '<img src="../images/no.jpg" height="150" border="0" />';
			//$EnlargeImage = '';
		}
		?>
          <li <?php if($i%3==0){?> class="third"<?php }?>>
            <div class="img">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="middle" align="center"><a href="<?=$PrdLink;?>" >
                    <?=$ImagePath?>
                    </a></td>
                </tr>
              </table>
            </div>
            <div class="name"> <a href="<?=$PrdLink;?>">
              <?=ucfirst(stripslashes($values['ProductName']));?>
              </a> </div>
            <div class="price">
              <?=display_price($Price);?>
            </div>
            <div class="details">
                <a href="<?=$PrdLink;?>"><input type="submit" value="Details" name=""></a>
            </div>
          </li>
          <?php } 
	 
	 ?>
        </ul>
        <? if($num>count($bestseller_items)){ ?>
        <div class="pager">
          <?=$pagerLink?>
        </div>
        <?	} ?>
        <? } else{ ?>
        <div class="productnotfound"><? echo "No Bestseller Found"; ?></div>
        <? } ?>
      </div>
    
    </div>
  </div>
</div>
