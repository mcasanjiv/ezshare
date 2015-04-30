<?
class bom extends dbClass
{
		//constructor
		function bom()
		{
			$this->dbClass();
		} 
		
		
                  
  function  ListBOM($id=0,$SearchKey,$SortBy,$AscDesc,$Status)
		{

			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where b.bomID=".$id):(" where 1 ");
			//$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
		
		   if($SortBy == 'id'){
                         $strAddQuery .= (!empty($SearchKey))?(" and (b.bomID = '".$SearchKey."')"):("");
		   }else{

		  if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and ( b.bom_code like '%".$SearchKey."%' or b.Sku like '%".$SearchKey."%'  ) "  ):("");			
			}

		     }

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by b.bomID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			$strSQLQuery = "select b.*,i.Sku,i.description,i.itemType,i.evaluationType from inv_bill_of_material b left outer join  inv_items  i on i.Sku=b.Sku  ".$strAddQuery;
			
			return $this->query($strSQLQuery, 1);		
				
		}	
                function RemoveBOM($id) {

                        $strSQLQuery = "DELETE FROM inv_bill_of_material WHERE bomID = " . $id;
                        $rs = $this->query($strSQLQuery, 0);
                        
                        $strSQLQuery2 = "DELETE FROM inv_item_bom WHERE bomID = " . $id;
                        $this->query($strSQLQuery2, 0);

                        if (sizeof($rs))
                           
                            return true;
                        else
                            return false;
                    }
                
                function AddBOM($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
	
			 $strSQLQuery = "insert into inv_bill_of_material(item_id,Sku,unit_cost,total_cost,on_hand_qty,bomDate,created_by,created_id,Status) 
                         values('".$item_id."', '".$Sku."',  '".$price."', '".$TotalValue."', '".$on_hand_qty."', '".$Config['TodayDate']."','".$_SESSION['AdminType']."','".$_SESSION['AdminID']."','".$Status."')";
			
                         
                         $this->query($strSQLQuery, 0);
                         $materialID = $this->lastInsertId();
                        if($materialID>0){
                         $rs=$this->getPrefix(1);
                       
                        $PrefixAD=$rs[0]['bom_prefix'];

			
				$ModuleIDValue = $PrefixAD.'-000'.$materialID;
				$strSQL = "update inv_bill_of_material set bom_code='".$ModuleIDValue."' where bomID=".$materialID; 
				$this->query($strSQL, 0);
			}

			return $materialID;

		}
                
                function UpdateBOM($arryDetails){ 
			global $Config;
			extract($arryDetails);
                        
                        

			/*if($Closed==1){
				$Status="Closed"; $ClosedDate=$Config['TodayDate'];
			}else{
				$Status="In Process"; $ClosedDate='';
			}
*/
                        
                        ;
			
                         

			$strSQLQuery = "update inv_bill_of_material set 
                            item_id='".$item_id."',
                                Sku='".$Sku."', 
                                    unit_cost='".$price."', 
                                        total_cost='".$TotalValue."',
                                            on_hand_qty='".$on_hand_qty."',
                                                Status='".$Status."',UpdatedDate = '".$Config['TodayDate']."'
			where bomID=".$bomID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
                function AddUpdateBOMItem($BID, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);

                        
                        

			if(!empty($DelItem)){
				$strSQLQuery = "delete from inv_item_bom where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
		
                         
                       
			for($i=1;$i<=$NumLine;$i++){
                           
				if(!empty($arryDetails['sku'.$i])){
					//$arryTax = explode(":",$arryDetails['tax'.$i]);
					
					$id = $arryDetails['id'.$i];
					if($id>0){
						$sql = "update inv_item_bom set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', bom_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_bom_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id; 
					}else{
						
                                           $sql = "insert into inv_item_bom (bomID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost) values('".$BID."','".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['Wastageqty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."','".addslashes($arryDetails['amount'.$i])."')";
					
                                           
                                        }
					$this->query($sql, 0);	

				}
			}

			return true;

		}
                 function  GetBOMStock($bomID)
		{
			$strAddQuery .= (!empty($bomID))?(" and bomID=".$bomID):("");
			$strSQLQuery = "select * from inv_item_bom  where 1".$strAddQuery." order by id asc";
			return $this->query($strSQLQuery, 1);
		}  
               
                
             function getTotalQtySum($ItemID){
                 
                 $strSQLQuery = "Select SUM(qty) as totalQty from `inv_stock_adjustment`";
		 $strSQLQuery .= "where 1";
		$strSQLQuery .= ($ItemID>0)?(" and `item_id` ='".$ItemID."'"):("");
                
                
                $rs= $this->query($strSQLQuery, 1);
                if( $rs[0]['totalQty']){
                    return $rs[0]['totalQty'];
                }
                
             }
                
               function updateStockQty($arryDetails)
		{
         
		global $Config;
			extract($arryDetails);
			
		
                
                for($i=1;$i<=$NumLine;$i++){
                           
				if(!empty($arryDetails['item_id'.$i])){
                                    
                                    
					$totalQTY = $this->getTotalQtySum($arryDetails['item_id'.$i]);
                                        
					
					$id = $arryDetails['id'.$i];
					if($arryDetails['Status']==2){
						$sql = "update inv_items set qty_on_hand='".$totalQTY."',average_cost='".$arryDetails['price'.$i]."'  where ItemID=".$arryDetails['item_id'.$i]; 
					}else if($arryDetails['Status']==1){
						
                                           $sql = "update inv_items set allocated_qty='".$totalQTY."',average_cost='".$arryDetails['price'.$i]."'  where ItemID=".$arryDetails['item_id'.$i]; 
					
                                           
                                        }
					$this->query($sql, 0);	

				}
			}
                
                
                
                
  			//$exequery = mysql_fetch_array($strSQLQuery);
          
		}
                /***************** End BOM ***********************/
             function GetSerialNumberCount($Sku,$identifier)
		{
                    $strSQLQuery = "Select count( serialID ) as totalSerial from `inv_serial_item`";
		    $strSQLQuery .= "where 1";
		    $strSQLQuery .= (!empty($Sku))?(" and `Sku` ='".$Sku."'"):("");
                    $strSQLQuery .= ($identifier>0)?(" and `identifier` ='".$identifier."'"):("");
		
			
		    $rs = $this->query($strSQLQuery, 1);
                    
                    return $rs[0]['totalSerial'] ; 
  			
                    
		}   
                
                function getPrefix($prefixID){
                    
                      $strSQLQuery = "SELECT * FROM inv_prefix where prefixID= '".$prefixID."'";
                      //echo $strSQLQuery;exit;
                      return $this->query($strSQLQuery, 1);
                    
                }
                
                
                /****************** Assembly****************/
                
       function  ListAssemble($id=0,$SearchKey,$SortBy,$AscDesc,$Status)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where a.asmID=".$id):(" where 1 ");
			//$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
		   if($SortBy == 'id'){
                         $strAddQuery .= (!empty($SearchKey))?(" and (a.asmID = '".$SearchKey."')"):("");
		   }else{
				  if($SortBy != ''){
					$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
					}else{
					$strAddQuery .= (!empty($SearchKey))?(" and ( a.asm_code like '%".$SearchKey."%' or a.Sku like '%".$SearchKey."%'  ) "  ):("");			
					}
		  }
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by a.asmID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");
			$strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType from inv_assembly a left outer join  inv_items  i on i.Sku=a.Sku  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);		
				
		}	
        function RemoveAssemble($id) {

              $strSQLQuery = "DELETE FROM inv_assembly WHERE asmID = " . $id;
              $rs = $this->query($strSQLQuery, 0);         
              $strSQLQuery2 = "DELETE FROM inv_item_assembly WHERE asmID = " . $id;
              $this->query($strSQLQuery2, 0);
              if (sizeof($rs))            
                return true;
               else
               return false;
          }
                
  function AddAssemble($arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			if(empty($Currency)) $Currency =  $Config['Currency'];
	
		$strSQLQuery = "insert into inv_assembly(warehouse_code,assembly_qty,item_id,Sku,unit_cost,total_cost,on_hand_qty,asmDate,created_by,created_id,Status) 
                        values('".$warehouse."','".$assembly_qty."','".$item_id."', '".$Sku."',  '".$price."', '".$TotalValue."', '".$on_hand_qty."', '".$Config['TodayDate']."','".$_SESSION['AdminType']."','".$_SESSION['AdminID']."','".$Status."')";
			
       
                         $this->query($strSQLQuery, 0);
                         $materialID = $this->lastInsertId();
                        if($materialID>0){
                         //$rs=$this->getPrefix(1);
                       
                        $PrefixAD="ASM";

			
				$ModuleIDValue = $PrefixAD.'-000'.$materialID;
				$strSQL = "update inv_assembly set asm_code='".$ModuleIDValue."' where asmID=".$materialID; 
				$this->query($strSQL, 0);
			}

			return $materialID;

		}
                
          function UpdateAssemble($arryDetails){ 
			global $Config;
			extract($arryDetails);
                        
                        

			/*if($Closed==1){
				$Status="Closed"; $ClosedDate=$Config['TodayDate'];
			}else{
				$Status="In Process"; $ClosedDate='';
			}
*/

			echo $strSQLQuery = "update inv_assembly set warehouse_code='".addslashes($warehouse)."',
                                                    item_id='".$item_id."', 
                                                    Sku='".$Sku."', 
                                                    unit_cost='".$price."',
                                                    total_cost='".$TotalValue."',
                                                    on_hand_qty='".$on_hand_qty."', 
													description='".addslashes($description)."', 
													UpdatedDate = '".$Config['TodayDate']."',
													Status      = '".$Status."',
													assembly_qty = '".$assembly_qty."'
			                                        where asmID=".$asmID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}
                
      function AddAssembleItem($AID, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			
			

			if(!empty($DelItem)){
				$strSQLQuery = "delete from inv_item_assembly where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
		          
			for($i=1;$i<=$NumLine;$i++){
                           
				if(!empty($arryDetails['sku'.$i])){
					//$arryTax = explode(":",$arryDetails['tax'.$i]);
					
					$id = $arryDetails['id'.$i];
					/*if($id>0){
						$sql = "update inv_item_assembly set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', asm_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_Assemble_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id; 
					}else{*/
                        $sql = "insert into inv_item_assembly (asmID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost) values('".$AID."','".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['Wastageqty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."','".addslashes($arryDetails['amount'.$i])."')";
					                       
                    //}
					$this->query($sql, 0);	

				}
			}

			return true;

		}


		 function AddUpdateAssembleItem($AID, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);

			
			

			if(!empty($DelItem)){
				$strSQLQuery = "delete from inv_item_assembly where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
		          
			for($i=1;$i<=$NumLine;$i++){
                           
				if(!empty($arryDetails['sku'.$i])){
					//$arryTax = explode(":",$arryDetails['tax'.$i]);
					
					$id = $arryDetails['id'.$i];
					if($id>0){
						$sql = "update inv_item_assembly set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', bom_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_bom_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id; 
					}
					$this->query($sql, 0);	

				}
			}

			return true;

		}
      function  GetAssembleStock($asmID)
		{
			$strAddQuery .= (!empty($asmID))?(" and asmID=".$asmID):("");
			$strSQLQuery = "select * from inv_item_assembly  where 1".$strAddQuery." order by id asc";
			return $this->query($strSQLQuery, 1);
		}  
               
         function  isSkuNameExists($Sku,$asmID) {
             
             
			$strSQLQuery ="select asmID from inv_assembly where LCASE(Sku)='".strtolower(trim($Sku))."'";

			$strSQLQuery .= ($asmID>0)?(" and asmID != '".$asmID."'"):("");
			//$strSQLQuery .= (!empty($PostedByID))?(" and PostedByID = ".$PostedByID):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['asmID'])) {
				return true;
			} else {
				return false;
			}
             
             
         }  
                
                
}

?>
