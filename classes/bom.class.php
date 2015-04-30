<?

class bom extends dbClass {

    //constructor
    function bom() {
        $this->dbClass();
    }

    function ListBOM($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {

        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where b.bomID=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");

        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (b.bomID = '" . $SearchKey . "')") : ("");
        } else {

            if ($SortBy != '') {
                $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( b.bom_code like '%" . $SearchKey . "%' or b.Sku like '%" . $SearchKey . "%' or b.bill_option like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%'  ) " ) : ("");
            }
        }

        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by b.bomID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");

        $strSQLQuery = "select b.*,i.Sku,i.Condition,i.description,i.itemType,i.evaluationType from inv_bill_of_material b left outer join  inv_items  i on i.Sku=b.Sku  " . $strAddQuery;

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

    function AddBOM($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_bill_of_material(bom_code,item_id,Sku,unit_cost,total_cost,on_hand_qty,bomDate,created_by,created_id,Status,bill_option,bomCondition) 
                         values('" . $bom_code . "','" . $bom_item_id . "', '" . $bom_Sku . "',  '" . $bom_price . "', '" . $TotalValue . "', '" . $bom_on_hand_qty . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "','" . $bill_option . "','".$bomCondition."')";


        $this->query($strSQLQuery, 0);
        $materialID = $this->lastInsertId();
        /*  if($materialID>0){
          $rs=$this->getPrefix(1);

          $PrefixAD=$rs[0]['bom_prefix'];


          $ModuleIDValue = $PrefixAD.'-000'.$materialID;
          $strSQL = "update inv_bill_of_material set bom_code='".$ModuleIDValue."' where bomID=".$materialID;
          $this->query($strSQL, 0);
          } */

        return $materialID;
    }


 

    function GetBOMStock($bomID, $optionID) {
        $strAddQuery .= (!empty($optionID)) ? (" and b.optionID=" . $optionID) : ("and b.optionID = 0");
        $strAddQuery .= (!empty($bomID)) ? (" and b.bomID=" . $bomID) : ("");
        $strSQLQuery = "select b.*,i.Condition from inv_item_bom b left outer join inv_items i on b.Sku = i.sku  where 1 " . $strAddQuery . " order by b.id asc";
        return $this->query($strSQLQuery, 1);
    }

    function UpdateBOM($arryDetails) {
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "update inv_bill_of_material set 
					item_id='" . $bom_item_id . "',
					Sku='" . $bom_Sku . "', 
					unit_cost='" . $bom_price . "',
					bill_option = '" . $bill_option . "', 
					total_cost='" . $TotalValue . "',
					on_hand_qty='" . $on_hand_qty . "',
                                        bomCondition='" . $bomCondition . "',
					Status='" . $Status . "',UpdatedDate = '" . $Config['TodayDate'] . "'
			where bomID=" . $bomID;

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function AddUpdateBOMItem($BID, $opId, $arryDetails) {
        global $Config;
        extract($arryDetails);

        #echo $BID; exit;


        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_bom where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }
        if ($opId == '') {
            $strUpSQLQuery = "update inv_bill_of_material set 
				total_cost='" . $TotalValue . "',
				UpdatedDate = '" . $Config['TodayDate'] . "'
				where bomID='" . $BID."'";

            $this->query($strUpSQLQuery, 0);
        }
        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_item_bom set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', wastageQty='" . addslashes($arryDetails['Wastageqty' . $i]) . "', bom_qty='" . addslashes($arryDetails['qty' . $i]) . "', unit_cost='" . addslashes($arryDetails['price' . $i]) . "', total_bom_cost='" . addslashes($arryDetails['amount' . $i]) . "',`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "'  where id=" . $id;
                    $this->query($sql, 0);
                } else {

                    $sql = "insert into inv_item_bom (bomID,optionID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost,`Condition`) values('" . $BID . "','" . $opId . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['Wastageqty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "')";

                    $this->query($sql, 0);
                }
            }
        }

        return true;
    }

    function UpdateOptionBill($arryDetails) {
        global $Config;
        extract($arryDetails);

        $strSQLQuery = "update inv_bom_cat set 
					option_cat='" . $option_cat . "',
					option_price='" . $option_price . "', 
					TotalValue='" . $TotalValue . "',
					req_status = '" . $req_status . "',
                                        qty = '" . $option_qty . "',
                                        TotalValue='" . $TotalValue . "',
					description1='" . $description_one . "',
					description2='" . $description_two . "'
					
			where optionID=" . $optionID;

        $this->query($strSQLQuery, 0);

        return 1;
    }

    function RemoveOptionBOM($id) {

        $strSQLQuery = "DELETE FROM inv_bom_cat WHERE optionID = " . $id;
        $rs = $this->query($strSQLQuery, 0);
        $strSQLQuery2 = "DELETE FROM inv_item_bom WHERE optionID = " . $id;
        $this->query($strSQLQuery2, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function AddOptionCat($bom_id, $arryDetails) {
        global $Config;
        extract($arryDetails);


        $sql = "insert into inv_bom_cat (option_cat, option_code, option_price,TotalValue,qty, req_status, description1, description2) values('" . $option_cat . "','" . addslashes($option_code) . "', '" . addslashes($option_price) . "','" . $TotalValue . "','" . $option_qty . "', '" . addslashes($req_status) . "', '" . addslashes($description_one) . "', '" . addslashes($description_two) . "')";
        $this->query($sql, 0);
        $opID = $this->lastInsertId();

        if ($opID > 0) {
            $Upsql = "update inv_bom_cat set bomID='" . $bom_id . "'  where optionID=" . $opID;
            $this->query($Upsql, 0);
        }



        return $opID;
    }

    function GetOptionStock($bomID, $optionID) {
        $strAddQuery .= (!empty($optionID)) ? (" and optionID=" . $optionID) : ("");
        $strAddQuery .= (!empty($bomID)) ? (" and bomID=" . $bomID) : ("");
        $strSQLQuery = "select * from inv_item_bom  where 1 " . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    function getTotalQtySum($ItemID) {

        $strSQLQuery = "Select SUM(qty) as totalQty from `inv_stock_adjustment`";
        $strSQLQuery .= "where 1";
        $strSQLQuery .= ($ItemID > 0) ? (" and `item_id` ='" . $ItemID . "'") : ("");

        $rs = $this->query($strSQLQuery, 1);
        if ($rs[0]['totalQty']) {
            return $rs[0]['totalQty'];
        }
    }

    function updateStockQty($arryDetails) {

        global $Config;
        extract($arryDetails);



        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['item_id' . $i])) {


                $totalQTY = $this->getTotalQtySum($arryDetails['item_id' . $i]);


                $id = $arryDetails['id' . $i];
                if ($arryDetails['Status'] == 2) {
                    $sql = "update inv_items set qty_on_hand='" . $totalQTY . "',average_cost='" . $arryDetails['price' . $i] . "'  where ItemID=" . $arryDetails['item_id' . $i];
                } else if ($arryDetails['Status'] == 1) {

                    $sql = "update inv_items set allocated_qty='" . $totalQTY . "',average_cost='" . $arryDetails['price' . $i] . "'  where ItemID=" . $arryDetails['item_id' . $i];
                }
                $this->query($sql, 0);
            }
        }




        //$exequery = mysql_fetch_array($strSQLQuery);
    }

    function isBomSkuExists($BomSku, $edit) {
        $strSQLQuery = "select bomID from inv_bill_of_material where LCASE(Sku)='" . strtolower(trim($BomSku)) . "'";
        $strSQLQuery .= ($edit > 0) ? (" and bomID != '" . $edit . "'") : ("");
        #echo $strSQLQuery;exit; 
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['bomID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isOptionCodeExists($OptionCode, $edit) {
        $strSQLQuery = "select optionID from inv_bom_cat where LCASE(option_code)='" . strtolower(trim($OptionCode)) . "'";
        $strSQLQuery .= ($edit > 0) ? (" and optionID != '" . $edit . "'") : ("");
        #echo $strSQLQuery;exit; 
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['optionID'])) {
            return true;
        } else {
            return false;
        }
    }

    function isBomCodeExists($bom_code, $edit) {
        $strSQLQuery = "select bomID from inv_bill_of_material where LCASE(bom_code)='" . strtolower(trim($bom_code)) . "'";
        $strSQLQuery .= ($edit > 0) ? (" and bomID != '" . $edit . "'") : ("");
        #echo $strSQLQuery;exit; 
        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['bomID'])) {
            return true;
        } else {
            return false;
        }
    }

    /*     * *************** End BOM ********************** */

    function GetSerialNumberCount($Sku, $identifier) {
        $strSQLQuery = "Select count( serialID ) as totalSerial from `inv_serial_item`";
        $strSQLQuery .= "where 1";
        $strSQLQuery .= (!empty($Sku)) ? (" and `Sku` ='" . $Sku . "'") : ("");
        $strSQLQuery .= ($identifier > 0) ? (" and `identifier` ='" . $identifier . "'") : ("");


        $rs = $this->query($strSQLQuery, 1);

        return $rs[0]['totalSerial'];
    }

    function getPrefix($prefixID) {

        $strSQLQuery = "SELECT * FROM inv_prefix where prefixID= '" . $prefixID . "'";
        //echo $strSQLQuery;exit;
        return $this->query($strSQLQuery, 1);
    }

    /*     * **************** Assembly*************** */

    function ListAssemble($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.asmID=" . $id) : (" where 1 ");
        $strAddQuery .= (!empty($Status)) ? (" and a.Status='" . $Status . "'") : (" ");
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.asmID = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
                if ($SortBy == 'a.Status') {
                    if ($SearchKey == 'completed') {
                        $SearchKey = 2;
                    } elseif ($SearchKey == 'parked') {
                        $SearchKey = 0;
                    } elseif ($SearchKey == 'cancel') {
                        $SearchKey = 1;
                    } else {
                        $SearchKey = $SearchKey;
                    }
                    $strAddQuery .= " and a.Status like '%" . $SearchKey . "%'";
                } else {
                    $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
                }
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.asm_code like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%' or a.warehouse_code like '%" . $SearchKey . "%' ) " ) : ("");
            }
        }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.asmID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.*,i.Sku,i.Condition,i.description,i.itemType,i.evaluationType,w.warehouse_name,w.warehouse_code from inv_assembly a left outer join  inv_items  i on i.Sku=a.Sku left outer join  w_warehouse  w on a.warehouse_code=w.WID   " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

    /*
      function LastAssembleID() {

      $strSQLQuery = "SELECT MAX( id ) FROM subscription";
      $rs = $this->query($strSQLQuery, 0);
      $strSQLQuery2 = "DELETE FROM inv_item_assembly WHERE asmID = " . $id;
      $this->query($strSQLQuery2, 0);
      if (sizeof($rs))
      return true;
      else
      return false;
      } */

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

    function AddAssemble($arryDetails) {
        global $Config;
        extract($arryDetails);
        
       

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_assembly(warehouse_code,assembly_qty,item_id,Sku,unit_cost,total_cost,on_hand_qty,asmDate,created_by,created_id,Status,serial_name,serial_qty,bomCondition) 
				values('" . $warehouse . "','" . $assembly_qty . "','" . $item_id . "', '" . $Sku . "',  '" . $price . "', '" . $TotalValue . "', '" . $on_hand_qty . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "','" . $serial_Num . "','" . $serial_qty . "','".$bomCondition."')";


        $this->query($strSQLQuery, 0);
        $materialID = $this->lastInsertId();
        if ($materialID > 0) {
            //$rs=$this->getPrefix(1);

            $PrefixAD = "ASM";


            $ModuleIDValue = $PrefixAD . '-000' . $materialID;
            $strSQL = "update inv_assembly set asm_code='" . $ModuleIDValue . "' where asmID=" . $materialID;
            $this->query($strSQL, 0);
            
            
           
            

            if ($Status == 2) {
                
                
                    //SET TRANSACTION DATA

                        $arryTransaction['TransactionOrderID'] = $materialID;
                        $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Assemble';

                        $objItem = new items();
                        $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='ASM');


                    //END TRANSACTION DATA


                /************** Add Serial Number ************************ */
                if ($arryDetails['serial_Num'] != '') {
                    $serial_no = explode(",", $arryDetails['serial_Num']);
                    for ($j = 0; $j <= sizeof($serial_no); $j++) {
                        $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $warehouse . "','" . $serial_no[$j] . "','" . $Sku . "','" . $materialID . "')";
                        $this->query($strSQLQuery, 0);
                        //echo   $serial_no[$i]."<br/>"; 
                    }
                }
            

                $strAsmSQL = "update inv_bill_of_material set AsmCount = AsmCount+1 where sku='" . $Sku . "'";
                $this->query($strAsmSQL, 0);
                /****************Update Bin Location**************/
                 $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity+" . $assembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                /****************End Bin Location**************/
                 /****************Update Item Qty**************/
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand+" . $assembly_qty . " where Sku='" . $Sku . "'";
                $this->query($strSQLItem, 0);
           /****************End Item Qty**************/
        }
      }

        return $materialID;
    }

    function UpdateAssemble($arryDetails) {
        global $Config;
        extract($arryDetails);



        /* if($Closed==1){
          $Status="Closed"; $ClosedDate=$Config['TodayDate'];
          }else{
          $Status="In Process"; $ClosedDate='';
          }
         */

        $strSQLQuery = "update inv_assembly set warehouse_code='" . addslashes($warehouse) . "',
			item_id='" . $item_id . "', 
			Sku='" . $Sku . "', 
			unit_cost='" . $price . "',
			total_cost='" . $TotalValue . "',
			on_hand_qty='" . $on_hand_qty . "', 
			description='" . addslashes($description) . "', 
			UpdatedDate = '" . $Config['TodayDate'] . "',
			Status      = '" . $Status . "',
                        bomCondition      = '" . $bomCondition . "',
			assembly_qty = '" . $assembly_qty . "'
			where asmID=" . $asmID;

        $this->query($strSQLQuery, 0);

        if ($Status == 2) {
            $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand+'" . $assembly_qty . "' where Sku='" . $Sku . "'";
            $this->query($strSQLItem, 0);
            
            $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity+" . $assembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                 
                 
                 //SET TRANSACTION DATA

                        $arryTransaction['TransactionOrderID'] = $asmID;
                        $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                        $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                        $arryTransaction['TransactionType'] = 'Assemble';

                        $objItem = new items();
                        $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='ASM');


                    //END TRANSACTION DATA
        }

        return 1;
    }

    function AddAssembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);




        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_assembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                /* if($id>0){
                  $sql = "update inv_item_assembly set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', asm_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_Assemble_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id;
                  }else{ */
                $sql = "insert into inv_item_assembly (asmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial,`Condition`) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_number' . $i]) . "', '" . addslashes($arryDetails['Condition' . $i]) . "')";

                //}
                $this->query($sql, 0);

                if ($arryDetails['Status'] == 2) {
                    $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);
                }
            }
        }

        return true;
    }

    function AddUpdateAssembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);




        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_assembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_item_assembly set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', qty='" . addslashes($arryDetails['qty' . $i]) . "', unit_cost='" . addslashes($arryDetails['price' . $i]) . "', total_bom_cost='" . addslashes($arryDetails['amount' . $i]) . "' ,serial='" . addslashes($arryDetails['serial_number' . $i]) . "',`Condition` = '" . addslashes($arryDetails['Condition' . $i]) . "'  where id=" . $id;
                } else {

                    $sql = "insert into inv_item_assembly (asmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial,`Condition`) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_number' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "')";
                }
                $this->query($sql, 0);
                if ($arryDetails['Status'] == 2) {
                    $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $arryDetails['qty' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);
                }
            }
        }

        return true;
    }

    function GetAssembleStock($asmID) {
        $strAddQuery .= (!empty($asmID)) ? (" and asmID=" . $asmID) : ("");
        $strSQLQuery = "select * from inv_item_assembly  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    function isSkuNameExists($Sku, $asmID) {


        $strSQLQuery = "select asmID from inv_assembly where LCASE(Sku)='" . strtolower(trim($Sku)) . "'";

        $strSQLQuery .= ($asmID > 0) ? (" and asmID != '" . $asmID . "'") : ("");
        //$strSQLQuery .= (!empty($PostedByID))?(" and PostedByID = ".$PostedByID):("");

        $arryRow = $this->query($strSQLQuery, 1);
        if (!empty($arryRow[0]['asmID'])) {
            return true;
        } else {
            return false;
        }
    }

    function ListOptionBill($arryDetails) {
        extract($arryDetails);
        $strAddQuery = '';
        $SearchKey = strtolower(trim($key));
        $strAddQuery = "where 1 ";
        $strAddQuery .= (!empty($optionID)) ? (" and o.optionID=" . $optionID) : ("  ");
        $strAddQuery .= (!empty($edit)) ? (" and o.bomID=" . $edit) : ("  ");
        $strAddQuery .= (!empty($view)) ? (" and o.bomID=" . $view) : ("  ");


        $strAddQuery .= (!empty($SearchKey)) ? (" and ( o.option_code like '%" . $SearchKey . "%'   ) " ) : ("");


        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by o.optionID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");

        $strSQLQuery = "select o.* from  `inv_bom_cat` o  " . $strAddQuery;
#echo $strSQLQuery;

        return $this->query($strSQLQuery, 1);
    }

    function GetOptionBill($optionID, $bom) {
        $strAddQuery = "where 1 ";
        $strAddQuery .= (!empty($optionID)) ? (" and o.optionID=" . $optionID) : ("  ");
        $strAddQuery .= (!empty($bom)) ? (" and o.bomID=" . $bom) : ("  ");
        $strSQLQuery = "select o.* from  `inv_bom_cat` o  " . $strAddQuery;

        return $this->query($strSQLQuery, 1);
    }

///// Disassembly


    function ListDisassemble($id = 0, $SearchKey, $SortBy, $AscDesc, $Status) {
        $strAddQuery = '';
        $SearchKey = strtolower(trim($SearchKey));
        $strAddQuery .= (!empty($id)) ? (" where a.DsmID=" . $id) : (" where 1 ");
        //$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):(" ");
        if ($SortBy == 'id') {
            $strAddQuery .= (!empty($SearchKey)) ? (" and (a.DsmID = '" . $SearchKey . "')") : ("");
        } else {
            if ($SortBy != '') {
                if ($SortBy == 'a.Status') {
                    if ($SearchKey == 'completed') {
                        $SearchKey = 2;
                    } elseif ($SearchKey == 'parked') {
                        $SearchKey = 0;
                    } elseif ($SearchKey == 'cancel') {
                        $SearchKey = 1;
                    } else {
                        $SearchKey = $SearchKey;
                    }
                    $strAddQuery .= " and a.Status like '%" . $SearchKey . "%'";
                } else {
                    $strAddQuery .= (!empty($SearchKey)) ? (" and (" . $SortBy . " like '%" . $SearchKey . "%')") : ("");
                }
            } else {
                $strAddQuery .= (!empty($SearchKey)) ? (" and ( a.DsmCode like '%" . $SearchKey . "%' or a.Sku like '%" . $SearchKey . "%' or i.description like '%" . $SearchKey . "%' or a.WarehouseCode like '%" . $SearchKey . "%' ) " ) : ("");
            }
        }
        $strAddQuery .= (!empty($SortBy)) ? (" order by " . $SortBy . " ") : (" order by a.DsmID ");
        $strAddQuery .= (!empty($AscDesc)) ? ($AscDesc) : (" Desc");
        $strSQLQuery = "select a.*,i.Sku,i.description,i.itemType,i.evaluationType,w.warehouse_name,w.warehouse_code from inv_disassembly a left outer join  inv_items  i on i.Sku=a.Sku left outer join  w_warehouse  w on a.WarehouseCode=w.WID " . $strAddQuery;
#echo $strSQLQuery; exit;
        return $this->query($strSQLQuery, 1);
    }

    function RemoveDisassemble($id) {

        $strSQLQuery = "DELETE FROM inv_disassembly WHERE DsmID = '" . $id . "'";
        $rs = $this->query($strSQLQuery, 0);
        $strSQLQuery2 = "DELETE FROM inv_item_disassembly WHERE DsmID = '" . $id . "'";
        $this->query($strSQLQuery2, 0);
        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function AddDisassemble($arryDetails) {
        global $Config;
        extract($arryDetails);

        if (empty($Currency))
            $Currency = $Config['Currency'];

        $strSQLQuery = "insert into inv_disassembly(WarehouseCode,disassembly_qty,item_id,Sku,unit_cost,total_cost,on_hand_qty,disassemblyDate,created_by,created_id,Status,serial_Num,bomCondition) 
		        values('" . $warehouse . "','" . $disassembly_qty . "','" . $item_id . "', '" . $Sku . "',  '" . $price . "', '" . $TotalValue . "', '" . $on_hand_qty . "', '" . $Config['TodayDate'] . "','" . $_SESSION['AdminType'] . "','" . $_SESSION['AdminID'] . "','" . $Status . "','" . $serial_Num . "','".$bomCondition."')";


        $this->query($strSQLQuery, 0);
        $materialID = $this->lastInsertId();
        if ($materialID > 0) {
            //$rs=$this->getPrefix(1);




            $PrefixAD = "DSM";


            $ModuleIDValue = $PrefixAD . '-000' . $materialID;
            $strSQL = "update inv_disassembly set DsmCode='" . $ModuleIDValue . "' where DsmID='" . $materialID . "'";
            $this->query($strSQL, 0);




            if ($Status == 2) {
                
                
                
                 //SET TRANSACTION DATA

                    $arryTransaction['TransactionOrderID'] = $materialID;
                    $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                    $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                    $arryTransaction['TransactionType'] = 'Disassemble';

                    $objItem = new items();
                    $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='DSM');


                    //END TRANSACTION DATA


                /************** Add Serial Number ************************ */
                if ($arryDetails['serial_Num'] != '') {
                    $serial_no = explode(",", $arryDetails['serial_Num']);
                    for ($j = 0; $j <= sizeof($serial_no); $j++) {
                        $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $warehouse . "','" . $serial_no[$j] . "','" . $Sku . "','" . $materialID . "')";
                        $this->query($strSQLQuery, 0);
                        //echo   $serial_no[$i]."<br/>"; 
                    }
                }
                /**                 * *********** Exit; ********************************** */
                $strDsmSQL = "update inv_bill_of_material set DsmCount = DsmCount+1 where sku='" . $Sku . "'";
                $this->query($strDsmSQL, 0);
                 /****************Update Bin Location**************/
                 $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity-" . $disassembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' and quantity!=0  order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                /****************End Bin Location**************/
                $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $disassembly_qty . "' where Sku='" . $Sku . "'";
                $this->query($strSQLItem, 0);
                
                
            }
        }

        return $materialID;
    }

    function UpdateDisassemble($arryDetails) {
        global $Config;
        extract($arryDetails);



        /* if($Closed==1){
          $Status="Closed"; $ClosedDate=$Config['TodayDate'];
          }else{
          $Status="In Process"; $ClosedDate='';
          }
         */

        $strSQLQuery = "update inv_disassembly set WarehouseCode='" . addslashes($warehouse) . "',
			item_id='" . $item_id . "', 
			Sku='" . $Sku . "', 
			unit_cost='" . $price . "',
			total_cost='" . $TotalValue . "',
			on_hand_qty='" . $on_hand_qty . "', 
			description='" . addslashes($description) . "', 
			UpdatedDate = '" . $Config['TodayDate'] . "',
			Status      = '" . $Status . "',
                        serial_Num = '" . $serial_Num . "',
                        bomCondition = '" . $bomCondition . "',
			disassembly_qty = '" . $disassembly_qty . "'
			where DsmID=" . $DsmID;

        $this->query($strSQLQuery, 0);


        if ($Status == 2) {

            /**             * *********** Add Serial Number ************************ */
            if ($arryDetails['serial_Num'] != '') {
                $serial_no = explode(",", $arryDetails['serial_Num']);
                for ($j = 0; $j <= sizeof($serial_no); $j++) {
                    $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $warehouse . "','" . $serial_no[$j] . "','" . $Sku . "','" . $materialID . "')";
                    $this->query($strSQLQuery, 0);
                    //echo   $serial_no[$i]."<br/>"; 
                }
            }
            /**             * *********** Exit; ********************************** */
            $strSQLItem = "update inv_items set qty_on_hand = qty_on_hand-'" . $disassembly_qty . "' where Sku='" . $Sku . "'";
            $this->query($strSQLItem, 0);
             /****************Update Bin Location**************/
                 $strSQLBinItem = "update `inv_bin_stock` set quantity = quantity-" . $disassembly_qty . " where Wcode ='".$warehouse."' and Sku='" . $Sku . "' and quantity!=0  order by id LIMIT 1";
                 $this->query($strSQLBinItem, 0);
                /****************End Bin Location**************/
                 
            //SET TRANSACTION DATA

                    $arryTransaction['TransactionOrderID'] = $DsmID;
                    $arryTransaction['TransactionInvoiceID'] = $ModuleIDValue;
                    $arryTransaction['TransactionDate'] = $Config['TodayDate'];
                    $arryTransaction['TransactionType'] = 'Disassemble';

                    $objItem = new items();
                    $objItem->addItemTransaction($arryTransaction,$arryDetails,$type='DSM');


                    //END TRANSACTION DATA     
                 
        }

        return 1;
    }

    function AddDisassembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);

        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_disassembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                /* if($id>0){
                  $sql = "update inv_item_disassembly set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', wastageQty='".addslashes($arryDetails['Wastageqty'.$i])."', asm_qty='".addslashes($arryDetails['qty'.$i])."', unit_cost='".addslashes($arryDetails['price'.$i])."', total_Assemble_cost='".addslashes($arryDetails['amount'.$i])."'  where id=".$id;
                  }else{ */

                $sql = "insert into inv_item_disassembly (dsmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial_value,`Condition`) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "')";





                /*                 * ************ Update Qty **************************** */
                if ($arryDetails['Status'] == 2) {

                    /*                     * ************ Add Serial Number ************************ */
                    if ($arryDetails['serial_value' . $i] != '') {
                        $serial_noum = explode(",", $arryDetails['serial_value' . $i]);
                        for ($j = 0; $j <= sizeof($serial_noum) - 1; $j++) {
                            $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $arryDetails['warehouse'] . "','" . $serial_noum[$j] . "','" . addslashes($arryDetails['sku' . $i]) . "','" . $AID . "')";
                            $this->query($strSQLQuery, 0);
                            //echo   $serial_no[$i]."<br/>"; 
                        }
                    }
                    /*                     * ************ Exit; ********************************** */



                    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+'" . $arryDetails['qty' . $i] . "'  where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateQtysql, 0);

                    $UpdateCostItem = "update inv_item_bom set unit_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateCostItem, 0);

                    /*                     * ************ Update Unit Cost ************************ */
                    $strSQLItem = "update inv_items set purchase_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);
                    /*                     * ************ Exit; ********************************** */
                }
                /*                 * ************ Exit; ********************************** */



                /* $sql = "insert into inv_item_disassembly (DsmID, item_id, sku, description, wastageQty, bom_qty, unit_cost, total_bom_cost) values('" . $AID . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "', '" . addslashes($arryDetails['Wastageqty' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "')"; */

                //}
                $this->query($sql, 0);
            }
        }

        return true;
    }

    function AddUpdateDisassembleItem($AID, $arryDetails) {
        global $Config;
        extract($arryDetails);
        if (!empty($DelItem)) {
            $strSQLQuery = "delete from inv_item_disassembly where id in(" . $DelItem . ")";
            $this->query($strSQLQuery, 0);
        }

        for ($i = 1; $i <= $NumLine; $i++) {

            if (!empty($arryDetails['sku' . $i])) {
                //$arryTax = explode(":",$arryDetails['tax'.$i]);

                $id = $arryDetails['id' . $i];
                if ($id > 0) {
                    $sql = "update inv_item_disassembly set item_id='" . $arryDetails['item_id' . $i] . "', sku='" . addslashes($arryDetails['sku' . $i]) . "', description='" . addslashes($arryDetails['description' . $i]) . "', qty='" . addslashes($arryDetails['qty' . $i]) . "', unit_cost='" . addslashes($arryDetails['price' . $i]) . "', total_bom_cost='" . addslashes($arryDetails['amount' . $i]) . "' ,serial='" . addslashes($arryDetails['serial_value' . $i]) . "',`Condition`='" . addslashes($arryDetails['Condition' . $i]) . "'  where id=" . $id;
                } else {

                    $sql = "insert into inv_item_disassembly (dsmID,bomID,bom_refID, item_id, sku, description,valuationType,available_qty, qty, unit_cost, total_bom_cost,serial_value,`Condition`) values('" . $AID . "','" . $bomID . "','" . $id . "','" . $arryDetails['item_id' . $i] . "', '" . addslashes($arryDetails['sku' . $i]) . "', '" . addslashes($arryDetails['description' . $i]) . "','" . addslashes($arryDetails['valuationType' . $i]) . "','" . addslashes($arryDetails['on_hand' . $i]) . "', '" . addslashes($arryDetails['qty' . $i]) . "', '" . addslashes($arryDetails['price' . $i]) . "','" . addslashes($arryDetails['amount' . $i]) . "','" . addslashes($arryDetails['serial_value' . $i]) . "','" . addslashes($arryDetails['Condition' . $i]) . "')";
                }
                $this->query($sql, 0);

                if ($arryDetails['Status'] == 2) {


                    /*                     * ************ Add Serial Number ************************ */
                    if ($arryDetails['serial_value' . $i] != '') {
                        $serial_noum = explode(",", $arryDetails['serial_value' . $i]);
                        for ($j = 0; $j <= sizeof($serial_noum) - 1; $j++) {
                            $strSQLQuery = "insert into inv_serial_item (warehouse,serialNumber,Sku,disassembly)  values ('" . $arryDetails['warehouse'] . "','" . $serial_noum[$j] . "','" . addslashes($arryDetails['sku' . $i]) . "','" . $AID . "')";
                            $this->query($strSQLQuery, 0);
                            //echo   $serial_no[$i]."<br/>"; 
                        }
                    }
                    /*                     * ************ Exit; ********************************** */


                    $UpdateQtysql = "update inv_items set qty_on_hand = qty_on_hand+'" . $arryDetails['qty' . $i] . "'  where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateQtysql, 0);

                    $UpdateCostItem = "update inv_item_bom set unit_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($UpdateCostItem, 0);

                    /*                     * ************ Update Unit Cost ************************ */
                    $strSQLItem = "update inv_items set purchase_cost = '" . $arryDetails['price' . $i] . "' where Sku='" . $arryDetails['sku' . $i] . "'";
                    $this->query($strSQLItem, 0);
                    /*                     * ************ Exit; ********************************** */
                }
            }
        }

        return true;
    }

    function GetDisassembleStock($DsmID) {
        $strAddQuery .= (!empty($DsmID)) ? (" and DsmID=" . $DsmID) : ("");
        $strSQLQuery = "select * from inv_item_disassembly  where 1" . $strAddQuery . " order by id asc";
        return $this->query($strSQLQuery, 1);
    }

    function CountSkuSerialNo($Sku) {
        $strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and Sku='" . $Sku . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        $sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='" . $Sku . "' group by i.sku";
        $arryInvoiced = $this->query($sqlInvoiced);
        $NumLeft = $arryRow[0]['TotalSerial'] - $arryInvoiced[0]['QtyInvoiced'];

        if ($NumLeft < 0)
            $NumLeft = 0;
        return $NumLeft;
    }

    function CountSkuSerialNoAndQtyInvoiced($Sku) {
        $strSQLQuery = "select count(serialID) as TotalSerial from inv_serial_item where Status='1' and Sku='" . $Sku . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        $sqlInvoiced = "select sum(i.qty_invoiced) as QtyInvoiced from s_order_item i inner join s_order s on i.OrderID=s.OrderID where s.Module='Invoice' and s.InvoiceID!='' and s.SaleID!='' and i.sku='" . $Sku . "' group by i.sku";
        $arryInvoiced = $this->query($sqlInvoiced);
        $SerialNoAndQtyInvoiced = $arryRow[0]['TotalSerial'] . "#" . $arryInvoiced[0]['QtyInvoiced'];

        return $SerialNoAndQtyInvoiced;
    }

    function selectSerialNumberForItem($Sku) {
        $strSQLQuery = "select * from inv_serial_item where Status='1' and Sku='" . $Sku . "' and UsedSerial = '0'";
        return $this->query($strSQLQuery, 1);
    }

    function checkSerializedItem($serialNumber) {
        $strSQLQuery = "select serialNumber from inv_serial_item where serialNumber='" . $serialNumber . "'";
        $arryRow = $this->query($strSQLQuery, 1);

        return $arryRow[0]['serialNumber'];
    }

    function addSerailNumberForInvoice($arryDetails) {
        global $Config;
        extract($arryDetails);
        $strSQLQuery = "update inv_serial_item set UsedSerial = '1' where serialNumber = '" . addslashes($serialNumber) . "' and Sku = '" . addslashes($Sku) . "'";
        $this->query($strSQLQuery, 0);
    }
    
       function getBinBySku($Wcode,$Sku){

                    $strAddQuery = (!empty($Wcode))?(" where s.Wcode='".$Wcode."'"):("");
                     $strAddQuery = (!empty($Sku))?(" where s.Sku='".$Sku."'"):("");
                   echo  $strSQLQuery = "select b.*,s.Sku,s.Wcode,s.bin from w_binlocation b inner join inv_bin_stock s on BINARY b.warehouse_code= BINARY s.Wcode ".$strAddQuery." ";
                    return $this->query($strSQLQuery, 1);

        }
    
    
    
    

}

?>
