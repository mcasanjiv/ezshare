<?php 
class shipment extends dbClass
{
		//constructor
		function shipment()
		{
			$this->dbClass();
		} 


function  ListShipment($arryDetails)
		{
			
			global $Config;
			extract($arryDetails);
	
			$strAddQuery = "where o.Module='shipment' ";
			$SearchKey   = strtolower(trim($key));

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (o.SalesPersonID='".$_SESSION['AdminID']."' or o.AdminID='".$_SESSION['AdminID']."') "):(""); 

			$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");
			$strAddQuery .= (!empty($FromDateShip))?(" and s.ShipmentDate>='".$FromDateShip."'"):("");
			$strAddQuery .= (!empty($ToDateShip))?(" and s.ShipmentDate<='".$ToDateShip."'"):("");

			/*if($SearchKey=='yes' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and o.ReturnPaid='Yes'"; 
			}else if($SearchKey=='no' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and o.ReturnPaid!='Yes'";
			}else*/ if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.ShippedID like '%".$SearchKey."%'  or o.InvoiceID like '%".$SearchKey."%'  or o.SaleID like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' ) " ):("");	
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".mysql_real_escape_string($CustCode)."'"):("");


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by s.ShipmentDate desc,s.ShipmentID desc ");
		
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");

			$strSQLQuery = "select o.ShippedDate,s.ShipmentDate, o.ShippedID as ShippingID,o.OrderDate, o.InvoiceDate, o.OrderID, o.SaleID,o.InvoiceID, o.CustCode, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.SalesPerson,s.RefID, s.OrderID as InvID, s.ShipComment,ShipmentStatus,s.ShippedID   from s_order o left  join w_shipment  s  on o.OrderID=s.ShippedID  ".$strAddQuery;
		//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}


		function  GetNumShippingByYear($Year,$FromDate,$ToDate,$CustCode,$SalesPID,$Status)
		{
			$strAddQuery = "";
			$strAddQuery .= (!empty($FromDate))?(" and s.ShipmentDate >='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and s.ShipmentDate <='".$ToDate."'"):("");

			$strSQLQuery = "select count(s.ShipmentID) as TotalShipping  from s_order o left  join w_shipment  s  on o.OrderID=s.ShippedID  where 1 and YEAR(s.ShipmentDate)='".$Year."' ".$strAddQuery." order by s.ShipmentDate desc";
			
			return $this->query($strSQLQuery, 1);		
		}


         function RemoveShipment($OrderID){
			
			$strSQLQuery = "delete from s_order where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from s_order_item where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}
function AddShipment($arryDetails){
		
		    global $Config;
		    
			extract($arryDetails);


			 		 	
		     $strSQLQuery = "INSERT INTO w_shipment SET ModuleType = 'Shipment', 
								ShippedID ='".$ShippedID."',
								RefID     ='".$InvoiceID."',
								OrderID   ='".$RefOrderID."',
								ShipmentStatus = '".$ShipStatus."',
								ShipComment = '".addslashes($ShipmentComment)."',
								CreatedBy = '".addslashes($_SESSION['UserName'])."',
								AdminID='".$_SESSION['AdminID']."',
								AdminType='".$_SESSION['AdminType']."',
								ShipmentDate='".$ShippedDate."',
								WID ='".$WID."',
								WarehouseName = '".addslashes($WarehouseName)."',
                                                                WarehouseCode = '".addslashes($WarehouseCode)."',
								ShipmentMethod='".addslashes($ShippingMethod)."',
								ShipCreateDate ='".$Config['TodayDate']."' ";
			#echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$shipment_id = $this->lastInsertId();
			
			

		 return $shipment_id;		
		}

function AddShipOrder($arryDetails){
		
		    global $Config;
		    
			extract($arryDetails);
			 		 	
			$strSQLQuery = "INSERT INTO s_order SET Module = '".$Module."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."', CustomerCurrency = '".addslashes($CustomerCurrency)."', BillingName = '".addslashes($BillingName)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."', Freight ='".addslashes($Freight)."', taxAmnt ='".addslashes($taxAmnt)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', wCode ='".$wCode."', wName = '".addslashes($wName)."', InvoiceDate ='".$Config['TodayDate']."', InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."', ReturnID = '".$ReturnID."', ReturnDate='".$ReturnDate."',ReturnPaid='".$ReturnPaid."',ReturnComment='".addslashes($ReturnComment)."',Taxable='".addslashes($Taxable)."',Reseller='".addslashes($Reseller)."' ,ResellerNo='".addslashes($ResellerNo)."' ,tax_auths='".addslashes($tax_auths)."', TaxRate='".addslashes($TaxRate)."' ";
			#echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			if(empty($ShippedID)){
				$ShippedID = 'SHIP000'.$OrderID;
			}

			$sql="UPDATE s_order SET ShippedID='".$ShippedID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);

		 return $OrderID;		
		}




               function ShipOrder($arryDetails)	{


			global $Config;
			extract($arryDetails);
                        $objSale = new sale();
			$arrySale = $objSale->GetSale($ShippedOrderID,'','');

			$arrySale[0]["Module"] = "Shipment";
			$arrySale[0]["ModuleID"] = "ShippedID";
			$arrySale[0]["PrefixSale"] = "SHIP";
			$arrySale[0]["ShippedID"] = $ShippedID;
			$arrySale[0]["ShippedDate"] = $ShippedDate;
			$arrySale[0]["Freight"] = $Freight;
			$arrySale[0]["taxAmnt"] = $taxAmnt;
			$arrySale[0]["TotalAmount"] = $TotalAmount;	
			$arrySale[0]["ShipmentComment"] = $ShipmentComment;	
			/*$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	
			$arrySale[0]["EmpID"] = $arrySale[0]['SalesPersonID'];	
			$arrySale[0]["EmpName"] = $arrySale[0]['AssignedEmp'];	*/
			$order_id = $this->AddShipOrder($arrySale[0]);
			if($order_id>0){

                        $arrySale[0]["ShipStatus"] = $ShipStatus;
			$arrySale[0]["WarehouseCode"] = $WarehouseCode;
			$arrySale[0]["WarehouseName"] = $WarehouseName;	
			$arrySale[0]["WID"] = $WID;
                        $arrySale[0]["ShippedID"] = $order_id;
                        $arrySale[0]["RefOrderID"] = $ShippedOrderID;
                        


			 $shipment_id = $this->AddShipment($arrySale[0]);
			}


			/******** Item Updation for Return ************/
			$arryItem = $objSale->GetSaleItem($ShippedOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id) && $arryDetails['qty'.$i]>0){
					$qty_shipped = $arryDetails['qty'.$i];
                                        $SerialNumbers = $arryDetails['serial_value'.$i];
					$sql = "insert into s_order_item(OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_shipped, price, tax_id, tax, amount, Taxable, req_item,SerialNumbers) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['received_qty'.$i])."', '".addslashes($arryDetails['received_qty'.$i])."','".$qty_shipped."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$SerialNumbers."')";

					$this->query($sql, 0);	
					
					//Update Item
					$sqlSelect = "select qty_shipped from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_shipped = $arrRow[0]['qty_shipped'];
					$qty_shipped = $qty_shipped+$arryDetails['qty'.$i];
					$sqlupdate = "update s_order_item set qty_shipped= '".$qty_shipped."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);	
					//end code
				}
			}


			return $order_id;
		}

function  GetQtyShipped($id)
		{
			$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty_shipped) as QtyShipped from s_order_item i where i.OrderID='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			return $rs;
		}

function  GetShipment($OrderID,$ShippedID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($ShippedID))?(" and o.ShippedID='".$ShippedID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			 $strSQLQuery = "select o.* from s_order o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}

function  GetWarehouseShip($ShipmentID,$ShippedID)
		{
			$strAddQuery .= (!empty($ShipmentID))?(" and o.ShipmentID=".$ShipmentID):("");
			$strAddQuery .= (!empty($ShippedID))?(" and o.ShippedID='".$ShippedID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.ModuleType='".$Module."'"):("");
			$strSQLQuery = "select o.* from w_shipment o where 1".$strAddQuery." order by o.ShipmentID desc";
			 return $this->query($strSQLQuery, 1);
		}

function UpdateShip($arryDetails){ 
			global $Config;
			extract($arryDetails);



			$strSQLQuery = "update w_shipment set ShipmentStatus='".$ShipStatus."', ShipComment='".addslashes($ShipmentComment)."'
			where ShipmentID=".$shipID.""; 

#echo $strSQLQuery; exit;
			$this->query($strSQLQuery, 0);

			return 1;
		}	





}?>
