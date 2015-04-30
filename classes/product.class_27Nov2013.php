<?
class product extends dbClass
{
		//constructor
		function product()
		{
			$this->dbClass();
		} 
		
		function  GetProducts($id=0,$CategoryID,$Status,$shortby,$Mfg)
		{

		        $strSQLQuery = "select p1.*,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID";
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status):(" and p1.Status=1 and c1.Status=1 ");
			$strSQLQuery .= (!empty($id))?(" where p1.ProductID=".$id):(" where 1 ");
			$strSQLQuery .= (!empty($CategoryID))?(" and p1.CategoryID=".$CategoryID):("");
                        $strSQLQuery .= (!empty($Mfg))?(" and p1.Mid=".$Mfg):("");
                        if($shortby == "name"){ $strSQLQuery .= "  order by p1.Name";}
                        elseif($shortby == "new"){$strSQLQuery .= "  order by p1.ProductID DESC";}
                        elseif($shortby == "hprice"){$strSQLQuery .= "  order by p1.Price DESC"; }
                        elseif($shortby == "lprice") {$strSQLQuery .= "  order by p1.Price ASC";}
                        else {$strSQLQuery .= "  order by p1.Name";}
                        //echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}
                
                function  GetProductById($id)
		{

		        $strSQLQuery = "select p1.*,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID";
			$strSQLQuery .= (!empty($id))?(" where p1.ProductID=".$id):(" where 1 ");
                        //echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}
                
               

		function  GetProductsView($id=0,$CategoryID,$SearchKey,$SortBy,$AscDesc,$Status)
		{
               
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where p1.ProductID=".$id):(" where 1");
			$strAddQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");
			
			$strAddQuery .= ($Status>0)?(" and p1.Status=".$Status." and m1.Status=1  "):("");
			
			if($SearchKey=='active' && ($SortBy=='p1.Status' || $SortBy=='') ){
				$strAddQuery .= " and p1.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='p1.Status' || $SortBy=='') ){
				$strAddQuery .= " and p1.Status=0";
			}
                        else if($SortBy=='p1.ProductSku'){
				$strAddQuery .= " and p1.ProductSku=".$SearchKey;
			}
                        else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (p1.Name like '".$SearchKey."%' or p1.ProductSku like '%".$SearchKey."%' or p1.AddedDate like '%".$SearchKey."%' or p1.Featured like '".$SearchKey."%') "):("");
			}
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by p1.ProductID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                       
			 $strSQLQuery = "select p1.* from e_products p1 ".$strAddQuery;
                                                   
			return $this->query($strSQLQuery, 1);
			
		}

		

		function  getProductStyles($id=0,$CategoryIDs,$Status,$key)
		{
			$strSQLQuery = "select p1.ProductStyle from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID left outer join e_manufacturers b1 on p1.brandID = b1.brandID where p1.ProductStyle!='' ";

			$strSQLQuery .= ($CategoryIDs>0)?(" and (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):("");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%' )"):("");


			$strSQLQuery .= ' group by p1.ProductStyle order by p1.ProductStyle asc ';

			return $this->query($strSQLQuery, 1);
		}

		function  getProductSizes($id=0,$CategoryIDs,$Status,$key,$state_id,$PostedByID)
		{
			$strSQLQuery = "select p1.ProductSize from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID left outer join e_manufacturers b1 on p1.brandID = b1.brandID ";

			$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):(" where 1 ");

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%' )"):("");

			$strSQLQuery .= ($state_id>0)?(" and m1.state_id=".$state_id):("");


			$strSQLQuery .= ' group by p1.ProductSize order by p1.ProductSize asc ';

			return $this->query($strSQLQuery, 1);
		}

		 

		function  AdvanceSearch($arryDetails)
		{
                   
			extract($arryDetails);
			
			if(!empty($price)){
				$arryPrice = explode('-',$price);
				$priceFrom = $arryPrice[0];
				$priceTo = $arryPrice[1];
			}



			//$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID left outer join e_manufacturers b1 on p1.Mid = b1.Mid where  p1.Status=1 and c1.Status=1 and b1.Status=1 ";
                        $strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID  where  p1.Status=1 and c1.Status=1 ";

                        switch ($search_in)
                            {
                                    case "id": 
                                    {
                                           $strSQLQuery .= (!empty($search_str))?(" and ( p1.ProductSku LIKE '%".$search_str."%')"):("");
                                            break;
                                    }
                                    case "name" : 
                                    {
                                           $strSQLQuery .= (!empty($search_str))?(" and ( p1.Name LIKE '%".$search_str."%')"):("");
                                            break;
                                    }
                                    default : 
                                    {
                                            $strSQLQuery .= (!empty($search_str))?(" and ( p1.Name LIKE '%".$search_str."%' OR p1.ProductSku LIKE '%".$search_str."%' OR p1.Detail LIKE '%".$search_str."%')"):("");
                                            break;
                                    }
                            }
                            

			$strSQLQuery .= ($CategoryID>0)?(" and  (p1.CategoryID =".$CategoryID." or c1.CategoryID =".$CategoryID." or c1.ParentID = ".$CategoryID." )"):("");

			$strSQLQuery .= ($cat>0)?(" and  (p1.CategoryID =".$cat." or c1.CategoryID =".$cat." )"):("");

			if(!empty($priceFrom)) $strSQLQuery .= " and p1.Price >= ".$priceFrom." ";
			if(!empty($priceTo)) $strSQLQuery .= " and p1.Price <= ".$priceTo." ";

			

			$strSQLQuery .= (!empty($style))?(" and LCASE(p1.ProductStyle)='".strtolower(trim($style))."'"):("");

			$strSQLQuery .= (!empty($size))?(" and LCASE(p1.ProductSize) like '%".strtolower(trim($size))."%'"):("");
			
			$strSQLQuery .= (!empty($Recently))?(" and DATEDIFF('".date('Y-m-d')."',p1.ViewedDate)<=7 "):("");
			
			
		
			if($npr>0){
				$ProductPrices = '';
				for($i=1;$i<=$npr;$i++){
					if($_GET['pr'.$i]!=''){

						$arryPr = explode('-',$_GET['pr'.$i]);
						$priceFrom = $arryPr[0];
						$priceTo = $arryPr[1];

						if(!empty($priceFrom)) $ProductPrices .= " (p1.Price >= ".$priceFrom." ";
						if(!empty($priceTo)) $ProductPrices .= " and p1.Price <= ".$priceTo." ";

						$ProductPrices .= ") or ";
					}
				}
				$ProductPrices = rtrim($ProductPrices,"or ");

				$strSQLQuery .= (!empty($ProductPrices))?(" and (".$ProductPrices.")"):("");
			}
			$strSQLQuery .= (!empty($Mfg))?(" and p1.Mid=".$Mfg):("");
                        if($shortBy == "name"){ $strSQLQuery .= "  order by p1.Name";}
                        elseif($shortBy == "new"){$strSQLQuery .= "  order by p1.ProductID DESC";}
                        elseif($shortBy == "hprice"){$strSQLQuery .= "  order by p1.Price DESC"; }
                        elseif($shortBy == "lprice") {$strSQLQuery .= "  order by p1.Price ASC";}
                        else {$strSQLQuery .= "  order by p1.Name";}

			//echo $strSQLQuery; exit;

			return $this->query($strSQLQuery, 1);
		}

		function  GetPriceRange()
		{
			$strSQLQuery = 'select * from price_refine order by id asc';
			return $this->query($strSQLQuery, 1);
		}
		

		function  SimilarProducts($ProductID,$CategoryIDs,$Status)
		{
			$strSQLQuery = "select p1.* from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):(" where 1 ");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= ($ProductID>0)?(" and p1.ProductID !=".$ProductID):("");

			$strSQLQuery .= ' order by p1.Name asc ';


			return $this->query($strSQLQuery, 1);
		}		

		function  SearchProductsCat($id=0,$CategoryIDs,$Status,$key,$state_id,$PostedByID,$Bidding)
		{
			$strSQLQuery = "select p1.*,if(p1.CategoryID>0,c1.Name,'') as CategoryName,c1.ParentID,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= ($CategoryIDs>0)?(" where (p1.CategoryID =".$CategoryIDs." or c1.ParentID = ".$CategoryIDs.")"):(" where 1 ");

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");

			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= (!empty($key))?(" and (p1.SearchTag LIKE '%".$key."%' OR p1.Name LIKE '%".$key."%' OR p1.ProductSku LIKE '%".$key."%')"):("");

			$strSQLQuery .= ($state_id>0)?(" and m1.state_id=".$state_id):("");

			$strSQLQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery .= ' order by p1.Name asc ';
	
			return $this->query($strSQLQuery, 1);
		}

		function  GetLatestOffers($CategoryID,$PostedByID,$Limit)
		{
			$strSQLQuery = "select p1.*,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= "where Price2>0 ";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");


			$strSQLQuery .= ' order by p1.ProductID desc ';
			$strSQLQuery .= ($Limit>0)?(" limit 0,".$Limit):("");

			return $this->query($strSQLQuery, 1);
		}
		
		function  GetNewProducts($CategoryID,$PostedByID,$Limit)
		{
			$strSQLQuery = "select p1.*,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= "where 1";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");


			$strSQLQuery .= ' order by p1.ProductID desc ';
			$strSQLQuery .= ($Limit>0)?(" limit 0,".$Limit):("");

			return $this->query($strSQLQuery, 1);
		}

		function  SearchProductsStoreCategory($CategoryID,$StoreCategoryID,$PostedByID)
		{
			$strSQLQuery = "select p1.*,if(p1.StoreCategoryID>0,c1.Name,'') as StoreCategoryName,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID ";

			$strSQLQuery .= "where 1";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");
			$strSQLQuery .= ($StoreCategoryID>0)?(" and p1.StoreCategoryID=".$StoreCategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");


			$strSQLQuery .= ' order by p1.Name desc ';
	
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetStoreItems($PostedByID,$Bidding)
		{
			$strSQLFeaturedQuery = ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");
			$strSQLFeaturedQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery = "select p1.* from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 ".$strSQLFeaturedQuery." ";

			return $this->query($strSQLQuery, 1);
		}

		function  GetNumStoreItems($PostedByID,$Bidding)
		{
			$strSQLFeaturedQuery = ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID):("");
			$strSQLFeaturedQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery = "select count(*) as NumItems from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 ".$strSQLFeaturedQuery." ";

			return $this->query($strSQLQuery, 1);
		}



		function  ProductsStoreCategory($CategoryID,$StoreCategoryID,$PostedByID,$Bidding)
		{
			$strSQLQuery = "select p1.*,if(p1.StoreCategoryID>0,c1.Name,'') as StoreCategoryName,m1.WebsiteStoreOption,m1.Ranking,m1.UserName,m1.CompanyName,m1.Website,m1.MembershipID,m1.CreditCard from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID  ";

			$strSQLQuery .= "where 1";

			$strSQLQuery .= ($PostedByID>0)?(" and p1.PostedByID=".$PostedByID." and c1.StoreID=".$PostedByID):("");
			$strSQLQuery .= ($CategoryID>0)?(" and p1.CategoryID=".$CategoryID):("");
			$strSQLQuery .= ($StoreCategoryID>0)?(" and p1.StoreCategoryID=".$StoreCategoryID):("");

			$Status=1;
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." "):("");

			$strSQLQuery .= ($Bidding=='Auction')?(" and p1.Bidding='".$Bidding."'"):("");

			$strSQLQuery .= ' order by p1.Name desc ';
	
			return $this->query($strSQLQuery, 1);
		}	
		
		function  FeaturedProducts($Status,$rand)
		{
			$strSQLQuery = "select p1.*,m1.Ranking,m1.UserName,m1.Website,m1.MembershipID,m1.CreditCard from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID inner join e_categories c1 on p1.CategoryID = c1.CategoryID ";

			$strSQLQuery .= " where p1.Featured='Yes' ";
			$strSQLQuery .= ($Status>0)?(" and p1.Status=".$Status." and c1.Status=".$Status." and m1.Status=".$Status." " ):("");

			$strSQLQuery .= ($rand==1)?(" order by rand()" ):(" order by p1.Name");


			return $this->query($strSQLQuery, 1);
		}



		
		function  CompareProducts($ids)
		{
			$strSQLQuery = "select p1.*,m1.Ranking,m1.WebsiteStoreOption,m1.UserName,m1.Website,m1.MembershipID,m1.CreditCard,c.name as Country,s.name as State from e_products p1 inner join members m1 on p1.PostedByID = m1.MemberID left outer join country c on m1.country_id=c.country_id left outer join state s on m1.state_id=s.state_id where p1.Status=1 and p1.ProductID in(".$ids.")  order by p1.ProductID";
			return $this->query($strSQLQuery, 1);
		}


		function  GetNameByParentID($id)
		{
			$strSQLQuery = "select c1.Name,c1.ParentID,if(c1.ParentID>0,c2.Name,'') as ParentName from e_categories c1 left outer join e_categories c2 on c1.ParentID = c2.CategoryID where c1.CategoryID = ".$id;
			return $this->query($strSQLQuery, 1);
		}

		function  GetFeaturedProducts()
		{
			$strSQLFeaturedQuery .= (" and p1.Featured='Yes'");

			$strSQLQuery = "select p1.* from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID where p1.Status=1 and c1.Status=1 ".$strSQLFeaturedQuery."   order by rand() Desc LIMIT 0,9";
			return $this->query($strSQLQuery, 1);
		}

		

                                function checkProductSku($prductSku)
                                {
                                    $strSQLQuery = "select * from e_products where ProductSku = '".trim($prductSku)."'";
		                    return $this->query($strSQLQuery, 1);
                                }
                                
                                    function GetProductSku($prductId)
                                    {
                                        $strSQLQuery = "select ProductSku from e_products where ProductID = ".$prductId;
                                        $row = $this->query($strSQLQuery, 1);
                                        return $row[0]['ProductSku'];
                                    }

		
		function AddProduct($arryDetails)
		{

			extract($arryDetails);
			if($CategoryID > 0){
				$strUpdateQuery = "update e_categories set NumProducts = NumProducts + 1 where CategoryID = '".$CategoryID."'";
				$this->query($strUpdateQuery, 0);
			}
                        
                        $Price1 =  $Price2>0?$Price2:$Price;
                        $Price2 = $Price2>0?$Price:$Price2;


			$strSQLQuery = "insert into e_products (Name,ProductSku,CategoryID,Price ,Price2,Status, AddedDate) 
                                                                                                         values ('".addslashes($Name)."', '".addslashes($ProductSku)."','".$CategoryID."' , '".$Price1."','".$Price2."', '".$Status."','".date('Y-m-d')."')";
                                                   

			$this->query($strSQLQuery, 0);
			$lastInsertId = $this->lastInsertId();

			return $lastInsertId;
			
		}


		function changeProductStatus($ProductID)
		{
			$sql="select * from e_products where ProductID=".$ProductID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update e_products set Status='$Status' where ProductID=".$ProductID;
				$this->query($sql,0);

			}	
			

			if($Status==1 && $rs[0]['Status']!=1 && $rs[0]['PostedByID']>1 ){
				$this->ProductActiveEmail($ProductID);
			}

			return true;


		}



		function MultipleProductStatus($ProductIDs,$Status)
		{
			$sql="select * from e_products where ProductID in (".$ProductIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0)
			{

				$sql="update e_products set Status=".$Status." where ProductID in (".$ProductIDs.")";
				$this->query($sql,0);

				for($i=0;$i<sizeof($arryRow);$i++) {

					if($Status==1 && $arryRow[$i]['Status']!=1 && $arryRow[$i]['PostedByID']>1 ){
						$this->ProductActiveEmail($arryRow[$i]['ProductID']);
						
					}
				}
				
			}	
			
			return true;

		}


		function changeFeaturedStatus($ProductID)
		{
			$sql="select * from e_products where ProductID=".$ProductID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Featured']=='Yes')
					$Featured='No';
				else
					$Featured='Yes';
					
				$sql="update e_products set Featured='$Featured' where ProductID=".$ProductID;
				$this->query($sql,0);
				return true;

			}			
		}

		function UpdateViewedDate($ProductID)
		{
			$sql="update e_products set ViewedDate='".date('Y-m-d')."' where ProductID=".$ProductID;
			$this->query($sql,0);
			return true;
		}


	
		
		function FeaturedDisabled($ProductIDs)
		{
					
			$sql="update e_products set Featured='No',FeaturedType='',Impression='0',ImpressionCount='0',  FeaturedStart='',FeaturedEnd=''   where ProductID in(".$ProductIDs.")";
			$this->query($sql,0);
			return true;

		}

		

		function UpdateImage($imageName,$ProductID)
		{
				$strSQLQuery = "update e_products set Image='".$imageName."' where ProductID=".$ProductID;
				return $this->query($strSQLQuery, 0);
		}

		
                
              function UpdateBasic($arryDetails)
		{
			
			
			extract($arryDetails);
                        
                         $Price1 =  $Price2>0?$Price2:$Price;
                        $Price2 = $Price2>0?$Price:$Price2;
                        
                        if($imagedelete == "Yes")
                        {
                                $select=mysql_query("select Image from e_products where ProductID=".$ProductID."");
                                $image=mysql_fetch_array($select);
                                $ImgDir = '../../upload/products/images/';
                                unlink($ImgDir.$image['Image']);
			  $strSQLQuery = "update e_products set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price1."', Price2='".$Price2."', Image='', Status='".$Status."' where ProductID=".$ProductID;
                        }
                       else {
                           $strSQLQuery = "update e_products set CategoryID = '".$CategoryID."', Name='".addslashes($Name)."', Price='".$Price1."', Price2='".$Price2."', Status='".$Status."' where ProductID=".$ProductID;
                       }
                      
                      //echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);

			return 1;
		}
                
               function UpdateOther($arryDetails)
		{
			
			
			extract($arryDetails);
			
                        $IsTaxable = isset($IsTaxable)?$IsTaxable:"No";
                        $FreeShipping = isset($FreeShipping)?$FreeShipping:"No";
                        
			$strSQLQuery = "update e_products set Mid='".$Mid."',Featured='".$Featured."', IsTaxable='".$IsTaxable."', Weight='".$Weight."', TaxClassId = '".$TaxClassId."', TaxRate = '".$TaxRate."', FreeShipping = '".$FreeShipping."',ShippingPrice='".$ShippingPrice."' where ProductID=".$ProductID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
                  function UpdateDescription($arryDetails)
		{
			
			
			extract($arryDetails);
			
			
			$strSQLQuery = "update e_products set Detail='".addslashes($Detail)."',ShortDetail='".addslashes($ShortDetail)."' where ProductID=".$ProductID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                 function UpdateSeo($arryDetails)
		{
			
			
			extract($arryDetails);
			
			
			$strSQLQuery = "update e_products set MetaTitle='".addslashes($MetaTitle)."',MetaKeywords='".addslashes($MetaKeywords)."',MetaDescription = '".addslashes($MetaDescription)."',UrlCustom = '".$UrlCustom."'  where ProductID=".$ProductID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                
                 function UpdateInventory($arryDetails)
		{
			
			
			extract($arryDetails);
			
			
			$strSQLQuery = "update e_products set Quantity='".addslashes($Quantity)."',InventoryControl='".addslashes($InventoryControl)."',InventoryRule = '".$InventoryRule."',StockWarning = '".$StockWarning."' where ProductID=".$ProductID;

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
              /*************************************Attribute Function Start******************************************************************/      
                
                function parseOptions($options)
                {
                        return explode("\n", $options);
                }
	
	
                               
                
               function InsertAttributes($arryDetails)
		{
			
			extract($arryDetails);
			
			$is_active = isset($is_active)?$is_active:"No";
                        
                        $parsed_options = explode("\n", $options);
                        
                        foreach ($parsed_options as $option)
                        {
                                if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
                                {
                                        $is_modifier = true;
                                }
                        }
                        
                      
                        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";
                       
			$strSQLQuery = "Insert into e_products_attributes set attribute_type='".trim($attribute_type)."',pid='".trim($ProductID)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."'";
			$this->query($strSQLQuery, 0);
                                                     if($ProductID >0)
                                                     {
                                                         $attributes_countVal = 0;
                                                         $sqlAttrVal= mysql_query("select AttributesCount from e_products where ProductID=".$ProductID);
                                                         $attributes_countRow = mysql_fetch_array($sqlAttrVal);
                                                         $attributes_countVal = $attributes_countRow['AttributesCount'];
                                                         $attributes_countVal = $attributes_countVal+1;
                                                         $strSQLQueryAttr = "update e_products set AttributesCount=".$attributes_countVal." where ProductID=".$ProductID;
		      	  $this->query($strSQLQueryAttr, 0);
                                                     }
			return 1;
		}
                
                
                function UpdateAttributes($arryDetails)
		{

			extract($arryDetails);
			$is_active = isset($is_active)?$is_active:"No";
                        
                         $parsed_options = explode("\n", $options);
                        
                        foreach ($parsed_options as $option)
                        {
                                if (preg_match("/^.+\(\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?)\s*((\,\s*([+-]?)\s*((\d+)|(\d+\.\d+))\s*([%]?))?)\s*\)\s*$/", $option))
                                {
                                        $is_modifier = true;
                                }
                        }
                        
                      
                        $is_modifierVal = isset($is_modifier) ? "Yes" : "No";
                        
			$strSQLQuery = "update e_products_attributes set attribute_type='".trim($attribute_type)."',gaid='0', is_modifier = '".$is_modifierVal."', is_active='".trim($is_active)."',priority='".trim($priority)."',name='".trim($attname)."',caption='".trim($attname)."',options='".trim($options)."' where paid = '".$AttributeId."' and pid=".$ProductID;
			$this->query($strSQLQuery, 0);
			return 1;
		}
                
                function GetAttributeByID($attId)
		{
	
			$strSQLQuery = "select * from e_products_attributes where paid = ".$attId;
			return $this->query($strSQLQuery, 1);
		}
               function GetProductAttributes($ProductID)
		{
			 
			$strSQLQuery = "Select * from e_products_attributes where pid=".$ProductID;
  			return $this->query($strSQLQuery, 1);
		}
                
                function GetProductAttributesForFront($ProductID)
		{
			 
			$strSQLQuery = "Select * from e_products_attributes where pid=".$ProductID." AND is_active='Yes'";
  			return $this->query($strSQLQuery, 1);
		}
             
                
                         
                                        
                        function deleteAttribute($pid,$attributeId)
                                {
                                        $strSQLQuery = "delete from e_products_attributes where paid=".$attributeId." and pid=".$pid; 
                                        $this->query($strSQLQuery, 0);

                                        $sqlAttrVal= mysql_query("select AttributesCount from e_products where ProductID=".$pid);
                                        $attributes_countRow = mysql_fetch_array($sqlAttrVal);
                                        $attributes_countVal = $attributes_countRow['AttributesCount'];
                                        $attributes_countVal = $attributes_countVal-1;
                                        $strSQLQueryAttr = "update e_products set AttributesCount=".$attributes_countVal." where ProductID=".$pid;
                                         $this->query($strSQLQueryAttr, 0);
                                               return 1;
                                }
                                
 /*************************************Attribute Function End******************************************************************/     
                                
                                /*************************************Discount Function Start******************************************************************/ 
                                   function InsertDiscount($arryDetails)
		{
			
			extract($arryDetails);
			$is_active = isset($is_active)?$is_active:"No";
			$strSQLQuery = "Insert into e_products_quantity_discounts set range_min='".trim($range_min)."',range_max = '".$range_max."',pid='".trim($ProductID)."',is_active='".trim($is_active)."',discount='".trim($discount)."',discount_type='".trim($discount_type)."',customer_type='".trim($customer_type)."'";
			$this->query($strSQLQuery, 0);
                                                     
			return 1;
		}
                
                            function GetProductDiscount($ProductID)
                                {

                                        $strSQLQuery = "Select * from e_products_quantity_discounts where pid=".$ProductID;
                                        return $this->query($strSQLQuery, 1);
                                }
                        function GetDiscountByID($disID)
                            {

                                    $strSQLQuery = "select * from e_products_quantity_discounts where qd_id = ".$disID;
                                    return $this->query($strSQLQuery, 1);
                            }
                      function UpdateDiscount($arryDetails)
		{

			extract($arryDetails);
			$is_active = isset($is_active)?$is_active:"No";
			$strSQLQuery = "update e_products_quantity_discounts set range_min='".trim($range_min)."',range_max = '".$range_max."',is_active='".trim($is_active)."',discount='".trim($discount)."',discount_type='".trim($discount_type)."',customer_type='".trim($customer_type)."' where qd_id = '".$DiscountId."' and pid=".$ProductID;
			$this->query($strSQLQuery, 0);
			return 1;
		}
                     function deleteDiscount($pid,$discId)
                                {
                                        $strSQLQuery = "delete from e_products_quantity_discounts where qd_id=".$discId." and pid=".$pid; 
                                        $this->query($strSQLQuery, 0);
                                               return 1;
                                }
                               
                                
                                /*************************************Discount Function End******************************************************************/ 
                                
		function SendEmailToAdmin($ProductID)
		{

			$arryProduct = $this->GetProducts($ProductID,0,0,0);

			if($arryProduct[0]['PostedByID']>0){
				$contents = file_get_contents("html/newproduct.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);


				$contents = str_replace("[FULLNAME]",$_SESSION['Name'],$contents);
				$contents = str_replace("[USERNAME]",$_SESSION['UserName'],$contents);
				$contents = str_replace("[POSTED_FOR]",$arryProduct[0]['PostedFor'],$contents);
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				$contents = str_replace("[PRICE]",$arryProduct[0]['Price'],$contents);
				$contents = str_replace("[QUANTITY]",$arryProduct[0]['Quantity'],$contents);
				$contents = str_replace("[Type]",$arryProduct[0]['Bidding'],$contents);

				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/images/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editProduct.php?edit='.$ProductID, $contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($_SESSION['Name'], $_SESSION['Email']);   
				$mail->Subject = $Config['SiteName']." - New product has been posted ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$_SESSION['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			}
		
			return 1;
		}
		

		function ProductActiveEmail($ProductID)
		{
			
			$arryProduct = $this->GetProducts($ProductID,0,0,0);

			if($arryProduct[0]['PostedByID']>0){
				$contents = file_get_contents("../html/activeproduct.htm");
				global $Config;
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);


				$contents = str_replace("[USERNAME]",stripslashes($arryProduct[0]['UserName']),$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
			
				$contents = str_replace("[PRODUCTNAME]",stripslashes($arryProduct[0]['Name']),$contents);
				$contents = str_replace("[DESCRIPTION]",nl2br(stripslashes($arryProduct[0]['Detail'])), $contents);
				$contents = str_replace("[Type]",$arryProduct[0]['Bidding'],$contents);

				if($arryProduct[0]['Image'] != ""){
					$ImageDestination = $Config['Url']."upload/products/images/".$arryProduct[0]['Image'];
				}else{
					$ImageDestination = $Config['Url']."images/no-image.jpg";
				}

				$contents = str_replace("[IMAGE]",$ImageDestination,$contents);
				

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryProduct[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Your product posting has been approved ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryProduct[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			}
		
			return 1;
		}
                
    /*************************************Alternatative Images Function Start******************************************************************/ 
                
		function AddAlternativeImage($ProductID)
		{

			$strSQLQuery ="select ProductID from e_products_images where ProductID='".$ProductID."'";

			$arryRow = $this->query($strSQLQuery, 1);
			if (empty($arryRow[0]['ProductID'])) {
				
				$strSQLQuery = "insert into e_products_images(ProductID) values ('".$ProductID."')"; 
				$this->query($strSQLQuery, 0);

			} 

			return 1;

		}


		function UpdateAlternativeImage($imageId,$imageName,$alt_text)
		{
			
			 $strSQLQuery = "INSERT INTO e_products_images set  ProductID=".$imageId.", Image='".$imageName."', alt_text='".$alt_text."'";
  			return $this->query($strSQLQuery, 0);
		}
                
                                     function GetTotalImagesCount($ProductID)
		{
			 
			$strSQLQuery = mysql_query("SELECT count( Iid ) as total FROM `e_products_images` WHERE `ProductID` =".$ProductID);
  			$exequery = mysql_fetch_array($strSQLQuery);
                                                       return $exequery['total'];
		}
                
                function GetAlternativeImage($ProductID)
		{
			 
			$strSQLQuery = "Select * from e_products_images where ProductID=".$ProductID;
  			return $this->query($strSQLQuery, 1);
		}
                
              
                
                
                
                          function deleteImage($pid,$imageId)
                                {
                                            $select=mysql_query("select Image from e_products_images where Iid = '".$imageId."' and ProductID=".$pid."");
                                            $image=mysql_fetch_array($select);
                                            $ImgDir = '../../upload/products/images/secondary/';
                                            unlink($ImgDir.$image['Image']);
                                            $strSQLQuery = "delete from e_products_images where Iid = '".$imageId."' and ProductID=".$pid; 
                                            $this->query($strSQLQuery, 0);
                                            return 1;
                                }
                               
/*************************************Alternatative Images Function Start******************************************************************/ 
		function RemoveProduct($id,$CategoryID,$Front)
		{
			$strSQLQuery = "select Image from e_products where ProductID=".$id; 
			$arryRow = $this->query($strSQLQuery, 1);
			
			$sql = "select * from e_products_images where ProductID=".$id; 
			$arry = $this->query($sql, 1);
			
			if($Front > 0){
				$ImgDir = 'upload/products/images/';
			}else{
				$ImgDir = '../upload/products/images/';
			}



			for($i=1;$i<=20;$i++){ 
				if($arry[0]['Image'.$i] !='' && file_exists($ImgDir.$arry[0]['Image'.$i]) ){
                                                                               unlink($ImgDir.$arry[0]['Image'.$i]);	
				}
			}



			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){
                                                                    unlink($ImgDir.$arryRow[0]['Image']);	
			}


			$strSQLQuery = "delete from e_products where ProductID=".$id; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from e_products_images where ProductID=".$id; 
			$this->query($strSQLQuery, 0);

			

			if($CategoryID > 0){
				$strSQLQuery ="select NumProducts from e_categories where CategoryID=".$CategoryID;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['NumProducts'])) {
					$strUpdateQuery = "update e_categories set NumProducts = NumProducts - 1 where CategoryID = ".$CategoryID;
					$this->query($strUpdateQuery, 0);
				} 
			}
			return 1;
		}
		

		function RemoveMultipleProduct($ids,$Front)
		{
			

			$strSQLQuery = "select Image,CategoryID from e_products where ProductID in (".$ids.")"; 
			$arryRow = $this->query($strSQLQuery, 1);

			$strSQLQuery = "delete from e_products where ProductID in (".$ids.")"; 
			$this->query($strSQLQuery, 0);

			


			if($Front > 0){
				$ImgDir = '../../upload/products/';
			}else{
				$ImgDir = '../../upload/products/images/';
			}
			
			for($i=0;$i<sizeof($arryRow);$i++) {
                            
                             
					if($arryRow[$i]['Image'] !='' && file_exists($ImgDir.$arryRow[$i]['Image']) ){
                                                                                                      
                                                                                                        unlink($ImgDir.$arryRow[$i]['Image']);	
					}

					if($arryRow[$i]['Image'] !='' && file_exists($ImgDir.'secondary/'.$arryRow[$i]['Image']) ){
                                                                                                   unlink($ImgDir.'secondary/'.$arryRow[$i]['Image']);
					}


					if($arryRow[$i]['CategoryID'] > 0){
						$strSQLQuery ="select NumProducts from e_categories where CategoryID=".$arryRow[$i]['CategoryID'];
						$arryRow2 = $this->query($strSQLQuery, 1);
						if (!empty($arryRow2[$i]['NumProducts'])) {
							$strUpdateQuery = "update e_categories set NumProducts = NumProducts - 1 where CategoryID = ".$arryRow[$i]['CategoryID'];
							$this->query($strUpdateQuery, 0);
						} 
					}


			}

			return 1;

		}


		function isProductExists($Name,$ProductID=0,$CategoryID)
		{

			$strSQLQuery ="select ProductID from e_products where LCASE(Name)='".strtolower(trim($Name))."'";

			$strSQLQuery .= ($ProductID>0)?(" and ProductID != ".$ProductID):("");
			//$strSQLQuery .= (!empty($CategoryID))?(" and CategoryID = ".$CategoryID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ProductID'])) {
				return true;
			} else {
				return false;
			}
		}
		

		function isProductNumberExists($ProductSku,$ProductID=0,$PostedByID)
		{

			$strSQLQuery ="select ProductID from e_products where LCASE(ProductSku)='".strtolower(trim($ProductSku))."'";

			$strSQLQuery .= ($ProductID>0)?(" and ProductID != ".$ProductID):("");
			$strSQLQuery .= (!empty($PostedByID))?(" and PostedByID = ".$PostedByID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ProductID'])) {
				return true;
			} else {
				return false;
			}
		}


		function IsActivatedProduct($ProductID)
		{
			$strSQLQuery = "select * from e_products where ProductID='".$ProductID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			if ($arryRow[0]['ProductID']>0) {
				return 1;
			} else {
				return 0;
			}
		}


		function AddSearchKeyword($Keyword,$KeywordType)
		{
			$strSQLQuery ="select Keyword from keywords where Keyword='".trim($Keyword)."' and KeywordType='".$KeywordType."'";

			$arryRow = $this->query($strSQLQuery, 1);


			if ($arryRow[0]['Keyword']=='') {
				
				$sql = "insert into keywords (Keyword,KeywordType,Date) values ('".addslashes(trim($Keyword))."', '".addslashes($KeywordType)."','".date('Y-m-d H:i:s')."')";

				$this->query($sql, 0);

			}else{
	
				$sql="update keywords set Date='".date('Y-m-d H:i:s')."' where LCASE(Keyword)='".strtolower(trim($Keyword))."' and KeywordType='".$KeywordType."'";
				$this->query($sql,0);
			}

			return 1;


		}


		function GetSearchKeywords()
		{
			$strSQLQuery = "select * from keywords where Status=1 order by Date desc limit 0,60";

			return $this->query($strSQLQuery, 1);

		}

		 

		/*****************Product Wishlist Functions Started************/

                
               function checkWishlistName($cid,$name)
               {

                   $SqlCustomer = "SELECT * FROM e_users_wishlist WHERE Name='".trim($name)."'  AND   Cid='".$cid."'";
                   return $this->query($SqlCustomer, 1);
               }

               function addWishlist($arryDetails,$oa_attributes)
               {

                   extract($arryDetails);
                   global $Config;
                   $SqlCustomer = "SELECT * FROM e_users_wishlist WHERE Name='".trim($Name)."'  AND   Cid='".$WhishlistCid."'";
                   $arrayRows = $this->query($SqlCustomer, 1);
                  
                   if(empty($arrayRows[0]['Wlid']))
                   {
                        $SqlCustomer = "INSERT INTO e_users_wishlist SET Name='".trim($Name)."', Cid='".$WhishlistCid."' , CreateDate = '".$Config['TodayDate']."', UpdateDate = '".$Config['TodayDate']."'";
                        $this->query($SqlCustomer, 1);
                        $lastInsertId = $this->lastInsertId();
                   
                        if (count($oa_attributes)>0)
                        {
                          foreach ($oa_attributes as $key=>$val)
                            {
                                    $sql = mysql_query("SELECT name, options FROM e_products_attributes WHERE pid= '".$WhislistProductId."' AND paid = '".$key."'");
                                    
                                    while ($rowReuslt = mysql_fetch_array($sql))
                                    {
                                            if ($rowReuslt["options"] != "")
                                            {
                                                    $options = $rowReuslt["options"];
                                                    $options_array = explode("\n", $options);				
                                                    for ($i=0; $i<count($options_array); $i++)
                                                    {
                                                            $option = trim($options_array[$i]);
                                                            if ($option != "")
                                                            {
                                                                    $option_parts = array();
                                                                    $option_parts = explode("(", $option);
                                                                    $option_name = trim($option_parts[0]);
                                                                    $option_partsVal = explode("(", $val);
                                                                    $option_nameVal = trim($option_partsVal[0]);
                                                                    
                                                                    if ($option_name ==  $option_nameVal)
                                                                    { 
                                                                            $wl_att[$key]=$rowReuslt["name"]." : ".$option_name;
                                                                    }
                                                            }
                                                    }	
                                            }
                                            else
                                            {
                                                    $wl_att[$key]=$rowReuslt["name"]." : ".$val;
                                            }			
                                    }
                            }
                 }
                
               if(count($wl_att)>0){
                            $attribute_id = "";
                            $options = "";	
                            foreach($wl_att as $att_id=>$val){
                                    $attribute_id .= (strlen($attribute_id)>0?",":"").$att_id;
                                    $options .= (strlen($options)>0?"\n":"").$val;
                            }
                            
                         					
		}  
               
              
                $SqlCustomer = "INSERT INTO e_users_wishlist_products SET Wlid='".$lastInsertId."', ProductId='".$WhislistProductId."' , AttributeId = '".$attribute_id."', options = '".$options."'";
                return $this->query($SqlCustomer, 1);
           }
        }

            function getWishlist($cid)
             {

                 $SqlCustomer = "SELECT * FROM e_users_wishlist WHERE Cid='".$cid."' ORDER BY Wlid DESC";
                 return $this->query($SqlCustomer, 1);
             }
            
            function addProductWishlist($arryDetails,$oa_attributes)
            {
                 extract($arryDetails);
                 
                 
                 
                 if (count($oa_attributes)>0)
                 {
                     foreach ($oa_attributes as $key=>$val)
                            {
                                    $sql = mysql_query("SELECT name, options FROM e_products_attributes WHERE pid= '".$WhislistProductId."' AND paid = '".$key."'");
                                    
                                    while ($rowReuslt = mysql_fetch_array($sql))
                                    {
                                            if ($rowReuslt["options"] != "")
                                            {
                                                    $options = $rowReuslt["options"];
                                                    $options_array = explode("\n", $options);				
                                                    for ($i=0; $i<count($options_array); $i++)
                                                    {
                                                            $option = trim($options_array[$i]);
                                                            if ($option != "")
                                                            {
                                                                    $option_parts = array();
                                                                    $option_parts = explode("(", $option);
                                                                    $option_name = trim($option_parts[0]);
                                                                    $option_partsVal = explode("(", $val);
                                                                    $option_nameVal = trim($option_partsVal[0]);
                                                                    
                                                                    if ($option_name ==  $option_nameVal)
                                                                    { 
                                                                            $wl_att[$key]=$rowReuslt["name"]." : ".$option_name;
                                                                    }
                                                            }
                                                    }	
                                            }
                                            else
                                            {
                                                    $wl_att[$key]=$rowReuslt["name"]." : ".$val;
                                            }			
                                    }
                            }
                 }
                
               if(count($wl_att)>0){
                            $attribute_id = "";
                            $options = "";	
                            foreach($wl_att as $att_id=>$val){
                                    $attribute_id .= (strlen($attribute_id)>0?",":"").$att_id;
                                    $options .= (strlen($options)>0?"\n":"").$val;
                            }
                            
                         					
		}  
               
              
                $SqlCustomer = "INSERT INTO e_users_wishlist_products SET Wlid='".trim($Wlid)."', ProductId='".$WhislistProductId."' , AttributeId = '".$attribute_id."', options = '".$options."'";
                return $this->query($SqlCustomer, 1);
                
            }
            
                function checkWishlistProduct($Wlid,$Productid)
                {
                    $SqlCustomer = "SELECT * FROM e_users_wishlist_products WHERE Wlid='".$Wlid."' AND ProductId = '".$Productid."'";
                    return $this->query($SqlCustomer, 1);
                }
                

               
                function getWishlistProduct($wlpid){
			$wl_product = array();
			$strSQLQuery = "SELECT *, e_products.ProductID FROM e_users_wishlist_products 
							 INNER JOIN e_products ON e_products.ProductID = e_users_wishlist_products.ProductId
							  WHERE Wlpid='".$wlpid."'";
                         $arryRow = $this->query($strSQLQuery, 1);
			if($arryRow){
				$wl_product = $arryRow[0];
				$product_attributes =array();
				if(strlen(trim($wl_product["Options"]))>0){
					$attribute_options= explode("\n", $wl_product["Options"]);	
					$attribute_id= explode(",", $wl_product["AttributeId"]);
					foreach ($attribute_id as $key=>$val) {
						$att_opts = explode(":", $attribute_options[$key]);
						$product_attributes[$val] =trim($att_opts[1]);
					}					
				}
				$wl_product["product_attributes"] = $product_attributes;
                                
                                //echo "<pre>";
                               // print_r($wl_product);exit;
                                
				return($wl_product);
			}
			return false;
		}
                
            function  GetProductByWishListId($Cid,$WishID)
		{

			//$strSQLQuery = "select p1.ProductID, p1.Name,p1.Quantity, p1.Status,w1.WishID  from e_products p1 inner join e_categories c1 on p1.CategoryID = c1.CategoryID inner join e_users_wishlist_products w1 on p1.ProductID = w1.ProductId left outer join e_customers c1 on p1.PostedByID = c1.Cid";

			//$strSQLQuery .= (!empty($WishID))?(" where w1.WishID=".$WishID):(" where 1 ");
			//$strSQLQuery .= ($MemberID>0)?(" and w1.MemberID=".$MemberID):("");
			//$strSQLQuery .= "  order by w1.WishID desc";
                       
			$strSQLQuery = "SELECT Wlid, Name FROM e_users_wishlist WHERE Wlid='".$WishID."'";
                        $arryRow = $this->query($strSQLQuery, 1);
			if($arryRow){
				$wl_data = $arryRow;
				$strSQLQuery = "SELECT * FROM e_users_wishlist_products WHERE Wlid='".$WishID."'";
				$wish_list_products = $this->query($strSQLQuery, 1);
                                //echo "<pre>";
                                //print_r($wish_list_products);
				$wl_products = array();
				
				if(count($wish_list_products)>0){ 											
					foreach($wish_list_products as $wl_product=>$valProduct){
						$strSQLQuery= "SELECT ProductID, ProductSku, CategoryID, Name, Price,Image FROM e_products WHERE ProductID ='".$valProduct["ProductId"]."'";
                                                $productsList = $this->query($strSQLQuery, 1);
						if($productsList){
							$product = $productsList[0];
							$product["attributes"] = "";
                                                       
							if(strlen(trim($valProduct["Options"]))> 0){
								$attribute_options= explode("\n", $valProduct["Options"]);
                                                               
								$selected_att = array();	
								foreach($attribute_options as $att=>$val){
									$product["attributes"] .= (strlen($product["attributes"])>0?"<br />":"").$val; 
									$att_val = explode(":", $val);
									$selected_att[$att] = $att_val[1];
								}
							}
							$product["Wlpid"]= $valProduct["Wlpid"];																								
							$wl_products[]= $product;
						}
					}
				}
				$list= array(						
					"Wlid" => $wl_data[0]["Wlid"],
					"Name" => $wl_data[0]["Name"],
					"whishlist_products" => $wl_products,
				);
					
			}
			
                        //echo "<pre>";
                       // print_r($list);
                        
			return ($list);
                
                        

		}

		function RemoveWishList($WishID,$Cid)
		{
			$strSQLQuery = "DELETE FROM e_users_wishlist where Wlid=".$WishID." AND Cid = ".$Cid.""; 
                        //echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
                        $strSQLQuery = "DELETE FROM e_users_wishlist_products where Wlid=".$WishID.""; 
			$this->query($strSQLQuery, 0);
		}
                
                
                function RemoveWishListProduct($Wlpid,$WishID)
		{
			
                        $strSQLQuery = "DELETE FROM e_users_wishlist_products WHERE Wlpid = '".$Wlpid."' AND  Wlid=".$WishID.""; 
			$this->query($strSQLQuery, 0);
		}
                
                function  UpdateWishList($arryDetails)
		{
                   
			extract($arryDetails);
                        global $Config;
                        $SqlCustomer = "UPDATE e_users_wishlist SET Name='".trim($Name)."', UpdateDate = '".$Config['TodayDate']."' WHERE Wlid = '".$Wlid."'";
                        $this->query($SqlCustomer, 0);
                }
                
         
               function EmailWishlist($Cid, $wishlist)
                    {
                                global $Config;
                                $htmlPrefix = $Config['EmailTemplateFolder'];
                              

                            $strSQLQuery = "SELECT FirstName, LastName,Email FROM e_customers  WHERE Cid='".$Cid."'";
                            $arryRow = $this->query($strSQLQuery, 1);
                             
                            if (!empty($arryRow[0]["Email"]))
                            {
                                    $FirstName = $arryRow[0]["FirstName"];
                                    $LastName = $arryRow[0]["LastName"];
                                    $your_email = $arryRow[0]["Email"];
                                    $EmailTitle = $mail_subject;
                                   
                                   $WishlistProductHtml ="<table width=700px cellpadding=0 cellspacing=0 style='border:1px solid #ddd'>
                                    <tr>
                                    <td width=15%  style='border-bottom:1px solid #ddd';><b>Product Image</b></td>
                                    <td width=40%  style='border-bottom:1px solid #ddd';><b>Product Description</b></td>
                                    <td width=15% style='border-bottom:1px solid #ddd';><b>Product Price</b></td>
                                    </tr>";
                                   
                                   
                                  
                                    foreach ($wishlist['whishlist_products'] as $key => $wishlistproduct)
                                    {
                                        $ImagePath = $Config['Url']."resizeimage.php?img=upload/products/images/".$wishlistproduct['Image'].'&w=150&h=100'; 
                                    
                                    $WishlistProductHtml .= "<tr valign=top>
                                    <td style=border-bottom:1px solid #ddd;>";
                                    if(!empty($wishlistproduct['Image'])){
                                    $WishlistProductHtml .="<img src=".$ImagePath." title=".ucfirst(stripslashes($wishlistproduct['Image']))." />";
                                    }
                                    else
                                    {
                                       
                                        $WishlistProductHtml .="<img src='./../images/no.jpg' title=".ucfirst(stripslashes($wishlistproduct['Image']))." />";
                                   
                                    }
                                    $WishlistProductHtml .= "</td>
                                    <td style=border-bottom:1px solid #ddd;padding-bottom:7px;>
                                    <a href=".$Config['Url'].$Config['SiteName']."/productDetails.php?id=".$wishlistproduct['ProductID'].">".$wishlistproduct['Name']." </a>  <br />".$wishlistproduct['attributes']."</td>
                                    <td style=border-bottom:1px solid #ddd;>&nbsp;".display_price($wishlistproduct['Price'],"","",$arryCurrency[0]['symbol_left'],$arryCurrency[0]['symbol_right'])."</td>
                                    </tr>";
                                    }
                                    $WishlistProductHtml .= "</table>";
                                    
                                $contents = file_get_contents($htmlPrefix."wishlistEmail.htm");
				$FullName = ucfirst($FirstName)." ".ucfirst($LastName);
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FirstName]",ucfirst($FirstName),$contents);
                                $contents = str_replace("[LastName]",ucfirst($LastName),$contents);
                                
                                $contents = str_replace("[WISHLIST_PRODUCT]",$WishlistProductHtml,$contents);
                                	
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[DATE]",date("jS, F Y"),$contents);			
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($your_email);
				$mail->sender($Config['SiteName']." - ", $Config['CompanyEmail']);   
				$mail->Subject = 'Your Wishlist - '.$wishlist['Name'];
				$mail->IsHTML(true);
				$mail->Body = $contents;  

				//echo $Email.$Config['AdminEmail'].$contents; exit;
                                
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
                                
                                 
                            }
                           else 
                               {
                                  echo "Failed";
                               }
                    }

                
                
                /****************************End Product Wihlist Functions***********************************************************************************************/
                
                
                
                
                function AddProductReview($arryDetails)
                {
                    extract($arryDetails);
                    global $Config;
                    $strSQLQuery = "INSERT INTO e_products_reviews SET Pid='".$ReviewProductID."',Cid = '".$ReviewCustId."',ReviewTitle='".  addslashes($ReviewTitle)."',ReviewText='".addslashes($ReviewText)."',Status = 'No',Rating='".$Rating."',DateCreated='".$Config['TodayDate']."'";
                    //echo $strSQLQuery;exit;
		    $this->query($strSQLQuery, 0);
                    $lastInsertId = $this->lastInsertId();
		    return $lastInsertId;
                }
                
            function getReviews($id=0,$Status,$SearchKey,$SortBy,$AscDesc) {
                
                
                       $strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where pr.ReviewId=".$id):(" where 1");
			
			$strAddQuery .= ($Status>0)?(" and pr.Status=".$Status.""):("");
			
			if($SearchKey=='active' && ($SortBy=='pr.Status' || $SortBy=='') ){
				$strAddQuery .= " and pr.Status='Yes'"; 
			}else if($SearchKey=='inactive' && ($SortBy=='pr.Status' || $SortBy=='') ){
				$strAddQuery .= " and pr.Status='No'";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (pr.ReviewTitle like '".$SearchKey."%' or p.ProductSku like '%".$SearchKey."%' or c.Email like '%".$SearchKey."%') "):("");
			}
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by pr.ReviewId ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                    
                        $strSQLQuery = "SELECT pr.*,p.Name,p.ProductSku,c.email,c.Cid FROM e_products_reviews AS pr JOIN e_products AS p ON p.ProductID = pr.Pid JOIN e_customers AS c ON c.Cid = pr.Cid ".$strAddQuery."";
                        //echo $strSQLQuery;exit;
                        return $this->query($strSQLQuery, 1);
                    }
                    
                  function getReviewsByProduct($pid) {
                
                        $where = "WHERE pr.Status = 'Yes' AND p.ProductID = ".$pid;
                        $strSQLQuery = "SELECT pr.*,p.Name,p.ProductSku,c.email,c.Cid,c.FirstName FROM e_products_reviews AS pr JOIN e_products AS p ON p.ProductID = pr.Pid JOIN e_customers AS c ON c.Cid = pr.Cid ".$where." Order By ReviewId Desc";
                        //echo $strSQLQuery;exit;
                        return $this->query($strSQLQuery, 1);
                    }   
                    
                     function countProductRating($pid) {
                
                        $where = "WHERE Status = 'Yes' AND Pid = ".$pid;
                        $strSQLQuery = "SELECT SUM(Rating) as total FROM e_products_reviews ".$where."";
                        //echo $strSQLQuery;exit;
                        return $this->query($strSQLQuery, 1);
                    }   
                    
                    
                     function deleteReview($id) {

                        $strSQLQuery = "DELETE FROM e_products_reviews WHERE ReviewId = " . $id;
                        $rs = $this->query($strSQLQuery, 0);

                        if (sizeof($rs))
                            return true;
                        else
                            return false;
                    }

                    function changeReviewStatus($id) {
                        $strSQLQuery = "SELECT * FROM e_products_reviews WHERE ReviewId=" . $id;
                        $rs = $this->query($strSQLQuery);
                        if (sizeof($rs)) {
                            if ($rs[0]['Status'] == 'Yes')
                                $Status = 'No';
                            else
                                $Status = 'Yes';

                            $strSQLQuery = "UPDATE e_products_reviews SET Status='" . $Status . "' WHERE ReviewId=" . $id;
                            $this->query($strSQLQuery, 0);
                            return true;
                        }
                    }
                    
                  function getDiscountByProduct($id)
                  {
                      $where = "WHERE is_active = 'Yes' AND pid = ".$id;
                      $strSQLQuery = "SELECT * FROM `e_products_quantity_discounts` ".$where."";
                      //echo $strSQLQuery;exit;
                      return $this->query($strSQLQuery, 1);
                  }
                  
                  function getItemsBestSellers($settings)
                  {
                      $bestsellersCount = 0;
                      $BestsellersPeriod = $settings['BestsellersPeriod'];
                    
                     if($settings['BestsellersAvailable'] == "Yes")
                     {
                        
                      //choose term
			switch($BestsellersPeriod)
			{
				case "Year" : $period = "1 YEAR"; break;
				case "6 Months" : $period = "6 MONTH"; break;
				case "3 Months" : $period = "3 MONTH"; break;
				case "2 Months" : $period = "2 MONTH"; break;
				default:
				case "Month": $period = "1 MONTH"; break;
			}
                        
                     $bestsellersCount =  $settings['BestsellersCount'];
                        
                        
                      $strSQLQuery =  "SELECT e_orderdetail . *, SUM(e_orderdetail.Quantity) AS product_quantity FROM e_orderdetail INNER JOIN e_orders ON e_orders.OrderID = e_orderdetail.OrderID INNER JOIN e_products ON e_products.ProductID = e_orderdetail.ProductID
                                         WHERE e_products.Status = '1' AND DATE_ADD( e_orders.OrderDate, INTERVAL ".($period)." ) > NOW( ) AND e_orders.PaymentStatus = '1' GROUP BY e_orderdetail.ProductID ORDER BY product_quantity DESC
				          LIMIT ".intval($bestsellersCount)."";
				
                         //echo $strSQLQuery;exit;
                      return $this->query($strSQLQuery, 1);	
			
                     }
                     
                     return false;
                  }

}

?>
