<?php   
require_once("includes/header.php");
include_once("includes/header_menu.php");


	if($_GET['cat'] > 0){
			$TopCatID = $_GET['cat'];
                        $arryProduct=$objProduct->GetProducts('',$_GET['cat'],'',$_GET['shortBy'],$_GET['Mfg']);
                        $num=$objProduct->numRows();
			$LevelCategory = 1;
			$arrayParent1 = $objCategory->GetCategoryNameByID($_GET['cat']);
			$ParentCategory  = stripslashes($arrayParent1[0]['Name']);
			
                        //Get Sub Category By Id
                        $arraySubCategoty = $objCategory->GetSubCategoryByID($_GET['cat']);
			
	    }
          else{
                    $arryProduct=$objProduct->AdvanceSearch($_GET);
                    $num=$objProduct->numRows();
                    $ParentCategory = 'Search Products';

	    }
	

	
	$MenuTitle = $ParentCategory;
	




require_once("includes/footer.php"); 

               
?>