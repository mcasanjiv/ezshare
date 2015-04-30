<?
class wrecieve extends dbClass
{
		//constructor
		function wrecieve()
		{
			$this->dbClass();
		} 
		
		function  ListSale($arryDetails)
		{
			extract($arryDetails);

			if($module=='Quote'){	
				$ModuleID = "QuoteID"; 
			}else{
				$ModuleID = "SaleID"; 
			}
           
			if($module == "Invoice"){ $moduledd = 'Invoice';}else{$moduledd = 'Order';}
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and o.OrderDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and o.OrderDate<='".$ToDate."'"):("");
			
			$strAddQuery .= (!empty($FromDateInv))?(" and o.InvoiceDate>='".$FromDateInv."'"):("");
			$strAddQuery .= (!empty($ToDateInv))?(" and o.InvoiceDate<='".$ToDateInv."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
			$strAddQuery .= " and o.Approved='1'"; 
			}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
			$strAddQuery .= " and o.Approved='0'";
			}else if($sortby != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
			$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
			
			if($ToApprove=='1'){
				$strAddQuery .= " and o.Approved!='1' and o.Status not in('Completed', 'Cancelled', 'Rejected') ";
			}
			
			$strAddQuery .= (!empty($InvoiceID))?(" and o.InvoiceID != '' and o.RecieveID = '' and o.Status != 'Cancelled'"):(" ");
			$strAddQuery .= (!empty($InvoiceID))?(" group by SaleID"):(" ");
			
			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
			//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");
			$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");
			
			

			$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from w_order_recieve  o ".$strAddQuery;
		
		    //echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}
		
	
		function  GetShipSale($OrderID,$SaleID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from w_order_recieve  o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		
		
		function  GetWInvoice($OrderID,$InvoiceID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.InvoiceID='".$InvoiceID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from w_order_recieve  o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}	
		
		function  GetSaleInvoice($OrderID,$InvoiceID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.InvoiceID='".$InvoiceID."'"):("");
			//$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			 $strSQLQuery = "select o.* from s_order  o where 1".$strAddQuery." order by o.OrderID desc"; 
			return $this->query($strSQLQuery, 1);
		}	
		
		function  GetRecieve($OrderID,$RecieveID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($RecieveID))?(" and o.RecieveID='".$RecieveID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from w_order_recieve  o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}		

		function  GetShipSaleItem($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID=".$OrderID):("");
			  $strSQLQuery = "select i.*,t.RateDescription from w_recieve_item   i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc"; 
			
			return $this->query($strSQLQuery, 1);
		}

		function  GetSaleInvoiceItem($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and i.OrderID=".$OrderID):("");
			$strSQLQuery = "select i.*,t.RateDescription from s_order_item   i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
			return $this->query($strSQLQuery, 1);
		}

		function  GetInvoiceOrder($SaleID)
		{
			$strSQLQuery = "select OrderID from w_order_recieve  o where SaleID='".$SaleID."' and Module='Invoice' order by o.OrderID asc";
			return $this->query($strSQLQuery, 1);
		}	

		function  GetSuppPurchase($CustCode,$OrderID,$SaleID,$Module)
		{
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.SaleID='".$SaleID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from w_order_recieve  o where 1".$strAddQuery." order by o.OrderID desc";
			return $this->query($strSQLQuery, 1);
		}

		function AddSale($arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			 
			
			if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];
			if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];
	
		    $strSQLQuery = "INSERT INTO w_order_recieve  SET Module = '".$Module."', OrderDate='".$OrderDate."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."', SalesPersonID = '".$SalesPersonID."', SalesPerson = '".addslashes($SalesPerson)."', InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."', Status = '".$Status."', DeliveryDate = '".$DeliveryDate."', ClosedDate = '".$ClosedDate."', Comment = '".addslashes($Comment)."', CustCode='".addslashes($CustCode)."', CustID = '".$CustID."',CustomerCurrency = '".addslashes($CustomerCurrency)."', CustomerName = '".addslashes($CustomerName)."', CustomerCompany = '".addslashes($CustomerCompany)."', Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',State = '".addslashes($State)."', Country = '".addslashes($Country)."', ZipCode = '".addslashes($ZipCode)."', Mobile = '".$Mobile."', Landline = '".$Landline."', Fax = '".$Fax."', Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."', ShippingCompany = '".addslashes($ShippingCompany)."', ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."', ShippingCity = '".addslashes($ShippingCity)."',ShippingState = '".addslashes($ShippingState)."', ShippingCountry = '".addslashes($ShippingCountry)."', ShippingZipCode = '".addslashes($ShippingZipCode)."', ShippingMobile = '".$ShippingMobile."', ShippingLandline = '".$ShippingLandline."', ShippingFax = '".$ShippingFax."', ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."', Freight ='".addslashes($Freight)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."',InvoiceComment='".addslashes($InvoiceComment)."',PaymentMethod='".addslashes($PaymentMethod)."',ShippingMethod='".addslashes($ShippingMethod)."',PaymentTerm='".addslashes($PaymentTerm)."'";
			$this->query($strSQLQuery, 0);
			
			//echo "=>".$strSQLQuery;exit;
			$OrderID = $this->lastInsertId();

			if(empty($arryDetails[$ModuleID])){
				$ModuleIDValue = 'SHIP000'.$OrderID;
				$strSQL = "update w_order_recieve  set ".$ModuleID."='".$ModuleIDValue."' where OrderID=".$OrderID.""; 
				$this->query($strSQL, 0);
			}

			return $OrderID;

		}


		function ReceiveOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);
			

            $CheckID =$objWrecieve->isInvoice($_GET['InvoiceID']);
	         if($CheckID>0){
		     $arrySale = $objWrecieve->GetWInvoice($CheckID,$_GET['InvoiceID'],'');
		     $OrderID   = $arrySale[0]['OrderID'];
			 }
			$arryPurchase = $this->GetSale($ReceiveOrderID,'','');
			$arryPurchase[0]["Module"] = "Invoice";
			$arryPurchase[0]["ModuleID"] = "InvoiceID";
			$arryPurchase[0]["PrefixSale"] = "INV";
			$arryPurchase[0]["ShippedDate"] = $ShippedDate;
			$arryPurchase[0]["Freight"] = $Freight;
			$arryPurchase[0]["TotalAmount"] = $TotalAmount;	
			$arryPurchase[0]["InvoicePaid"] = $InvoicePaid;	
			$arryPurchase[0]["InvoiceComment"] = $InvoiceComment;	
			$order_id = $this->AddSale($arryPurchase[0]);


			/******** Item Updation for Invoice ************/
			$arryItem = $this->GetSaleItem($ReceiveOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				
				if(!empty($arryDetails['id'.$i]) ){
					$qty_received = $arryDetails['qty'.$i];
					$sql = "insert into w_recieve_item  (OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".$qty_received."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."')";

					$this->query($sql, 0);	

				}
			}

			//echo $order_id; exit;


			return $order_id;
		}



		function  ListRecieve($arryDetails)
		{
			extract($arryDetails);
	
			$strAddQuery = "where 1 ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($so))?(" and o.SaleID='".$so."'"):("");
			$strAddQuery .= (!empty($FromDateRtn))?(" and o.RecieveDate>='".$FromDateRtn."'"):("");
			$strAddQuery .= (!empty($ToDateRtn))?(" and o.RecieveDate<='".$ToDateRtn."'"):("");

			if($SearchKey=='yes' && ($sortby=='o.RecievePaid' || $sortby=='') ){
				$strAddQuery .= " and o.RecievePaid='Yes'"; 
			}else if($SearchKey=='no' && ($sortby=='o.RecievePaid' || $sortby=='') ){
				$strAddQuery .= " and o.RecievePaid!='Yes'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.RecieveID like '%".$SearchKey."%'  or o.InvoiceID like '%".$SearchKey."%'  or o.SaleID like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' ) " ):("");	
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select o.OrderDate, o.RecieveDate, o.OrderID, o.SaleID,o.RecieveID,o.InvoiceID, o.CustCode, o.CustomerName, o.TotalAmount, o.CustomerCurrency,o.RecievePaid,o.SalesPerson  from w_order_recieve  o ".$strAddQuery;
		//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}

		



		

		function RemoveSale($OrderID){
			
			$strSQLQuery = "delete from w_order_recieve  where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from w_recieve_item   where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}

		function  GetQtyReceived($id)
		{
			$sql = "select sum(i.qty_received) as QtyReceived from w_recieve_item   i where i.ref_id='".$id."' group by i.ref_id";
			$rs = $this->query($sql);
			return $rs[0]['QtyReceived'];
		}

		function  GetQtyOrderded($id)
		{
			$sql = "select i.qty as QtyOrderded from w_recieve_item   i where i.id='".$id."'";
			$rs = $this->query($sql);
			return $rs[0]['QtyOrderded'];
		}


		function ConvertToSaleOrder($OrderID,$SaleID)
		{
			if(empty($SaleID)){
				$SaleID = 'SO000'.$OrderID;
			}

			$sql="UPDATE w_order_recieve  SET Module='Order',SaleID='".$SaleID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);				

			return true;
		}
		
		
		function  GetSaleOrderForInvoice($OrderID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID=".$OrderID):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.* from w_order_recieve  o where 1".$strAddQuery." order by o.OrderID desc";
			$arrayRow = $this->query($strSQLQuery, 1);
			return $arrayRow[0];
		}		
		
		
		
		
		
		
		function  GetQtyInvoiced($id)
		{
			$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty) as Qty from w_recieve_item   i where i.OrderID='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			return $rs;
		}
		
		function  GetQtyRecieved($id)
		{
			$sql = "select sum(i.qty_invoiced) as QtyInvoiced,sum(i.qty_returned) as QtyRecieved from w_recieve_item   i where i.OrderID='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			return $rs;
		}
		
		
		function RemoveInvoice($OrderID){
			
			$strSQLQuery = "delete from w_order_recieve  where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from w_recieve_item   where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}
		
		
		
	
		
		
		

		function isSaleExists($SaleID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" AND OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "SELECT OrderID from w_order_recieve  where Module='Order' AND SaleID='".trim($SaleID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}			
		
		
		function  isInvoice($InvoiceID)
		{
			$sql = "select OrderID  from w_order_recieve where InvoiceID='".trim($InvoiceID)."'";
			$rs = $this->query($sql);
			return $rs[0]['OrderID'];
		}

		function isInvoiceExists($InvoiceID,$OrderID=0)
		{
			$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
			$strSQLQuery = "select OrderID from w_order_recieve  where  InvoiceID='".trim($InvoiceID)."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OrderID'])) {
				return true;
			} else {
				return false;
			}
		}	

	 function AddSoDetail($arryDetails,$SOID)
		{  
			global $Config;
			extract($arryDetails);

			//if(empty($Currency)) $Currency =  $Config['Currency'];
			//if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];


			  $strSQLQuery = "insert into w_sale_item_ship(warehouse, RecieveID, transaction_ref,InvoiceID,  transport, packageCount, PackageType, Weight, charge, Currency, Status, Description, apply_to, Price, PaidAs, amount,  CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, RecievedDate) values('".$warehouse."', '".$RecieveID."', '".$transaction_ref."',  '".$InvoiceID."', '".$transport."', '".$packageCount."', '".$PackageType."', '".$Weight."','".$charge."','".$Currency."','".$Status."', '".addslashes(strip_tags($Description))."', '".$apply_to."', '".$Price."', '".$PaidAs."', '".$ammount."',  '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$RecievedDate."')";
			
			
			$this->query($strSQLQuery, 0);
			$shipID = $this->lastInsertId();

			if($shipID>0){
            $sqlupdate = "update w_sale_item_ship   set OrderID = '".$SOID."' where shipID = '".$shipID."'";
			$this->query($sqlupdate, 0);
			}

			

			return $shipID;

		}

		function  GetSoDetails($shipID,$OrderID)
		{
			$strAddQuery .= (!empty($InboundID))?(" and o.shipID='".$shipID."'"):("");
			$strAddQuery .= (!empty($OrderID))?(" and o.OrderID='".$OrderID."'"):("");
			$strSQLQuery = "select o.* from w_sale_item_ship o where 1".$strAddQuery." order by o.shipID desc";
			
			return $this->query($strSQLQuery, 1);
		}
		
		
	 function RecieveOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);

			
			 $CheckID =$this->isInvoice($InvoiceID);
	        if(empty($CheckID)){
            /*****************************/
			$arrySale = $this->GetSaleInvoice($ReturnOrderID,$InvoiceID,'Invoice');
                       
                        $arrySale[0]['RecieveDate'] = $RecieveDate;
                        $arrySale[0]['ReturnStatus'] = $ReturnStatus;
            
			$order_id = $this->AddRecieveOrder($arrySale[0]);
			if($order_id>0){
                          $shipID = $this->AddSoDetail($arryDetails,$order_id);
			}
		      $arryItem = $this->GetSaleInvoiceItem($ReturnOrderID);
			/*****************************/

			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id)){
					$qty_returned = $arryDetails['qty'.$i];
					$sql = "insert into w_recieve_item  (OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned, price, tax_id, tax, amount) values('".$order_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['received_qty'.$i])."', '".addslashes($arryDetails['received_qty'.$i])."','".$qty_returned."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."')";
					$this->query($sql, 0);	
						
					/***************** Stock Update In Item **************/
					 $strSQ = "update inv_items set qty_on_hand=qty_on_hand+'".$arryDetails['received_qty'.$i]."' where Sku='".$arrayW_item[$Count2]['sku']."'"; 
					 $this->query($strSQ, 0);
					/****************************************************/ 
					
				}
			}
 } else {

            $arryItem = $this->GetSaleItem($RecieveOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id) && $arryDetails['qty'.$i]>0){
                  $sqlSelect = "select qty_returned from w_recieve_item   where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_returned = $arrRow[0]['qty_returned'];
					//$qty_returned = $qty_returned2+$arryDetails['qty'.$i];
					$sqlupdate = "update w_recieve_item   set qty_returned = '".$qty_returned."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);
					
				/***************** Stock Update In Item **************/
					$strSQ = "update inv_items set qty_on_hand=qty_on_hand+'".$qty_returned."' where Sku='".$arrayW_item[$Count2]['sku']."'"; 
					$this->query($strSQ, 0);
				        /***************************/

				}

			}
		}
		


			return $order_id;
		}
		
		function AddRecieveOrder($arryDetails){
		
		    global $Config;
		    
			extract($arryDetails);
			 		 	
			$strSQLQuery = "INSERT INTO w_order_recieve  SET Module = '".$Module."',
			OrderDate='".$OrderDate."',
			SaleID ='".$SaleID."',
			QuoteID = '".$QuoteID."',
			SalesPersonID = '".$SalesPersonID."',
			SalesPerson = '".addslashes($SalesPerson)."',
			InvoiceID = '".$InvoiceID."',
			Approved = '".$Approved."',
			Status = '".$ReturnStatus."',
			DeliveryDate = '".$DeliveryDate."',
			Comment = '".addslashes($Comment)."',
			CustCode='".addslashes($CustCode)."',
			CustID = '".$CustID."',
			CustomerCurrency = '".addslashes($CustomerCurrency)."',
			CustomerName = '".addslashes($CustomerName)."',
			CustomerCompany = '".addslashes($CustomerCompany)."',
			Address = '".addslashes(strip_tags($Address))."',
			City = '".addslashes($City)."',
			State = '".addslashes($State)."',
			Country = '".addslashes($Country)."',
			ZipCode = '".addslashes($ZipCode)."',
			Mobile = '".$Mobile."',
			Landline = '".$Landline."',
			Fax = '".$Fax."',
			Email = '".addslashes($Email)."',
			ShippingName = '".addslashes($ShippingName)."',
			ShippingCompany = '".addslashes($ShippingCompany)."',
			ShippingAddress = '".addslashes(strip_tags($ShippingAddress))."',
			ShippingCity = '".addslashes($ShippingCity)."',
			ShippingState = '".addslashes($ShippingState)."',
			ShippingCountry = '".addslashes($ShippingCountry)."',
			ShippingZipCode = '".addslashes($ShippingZipCode)."',
			ShippingMobile = '".$ShippingMobile."',
			ShippingLandline = '".$ShippingLandline."',
			ShippingFax = '".$ShippingFax."',
			ShippingEmail = '".addslashes($ShippingEmail)."',
			TotalAmount = '".addslashes($TotalAmount)."',
			TotalInvoiceAmount = '".addslashes($TotalInvoiceAmount)."',
			Freight ='".addslashes($Freight)."',
			CreatedBy = '".addslashes($_SESSION['UserName'])."', 
			AdminID='".$_SESSION['AdminID']."',
			AdminType='".$_SESSION['AdminType']."',
			PostedDate='".$Config['TodayDate']."',
			UpdatedDate='".$Config['TodayDate']."',
			ShippedDate='".$ShippedDate."', 
			wCode ='".$wCode."',
			wName = '".addslashes($wName)."', 
			InvoiceDate ='".$Config['TodayDate']."',
			InvoiceComment='".addslashes($InvoiceComment)."',
			PaymentMethod='".addslashes($PaymentMethod)."',
			ShippingMethod='".addslashes($ShippingMethod)."',
			PaymentTerm='".addslashes($PaymentTerm)."',
			RecieveID = '".$RecieveID."', 
			RecieveDate='".$RecieveDate."',
			RecievePaid='".$RecievePaid."',
                       
			RecieveComment='".addslashes($RecieveComment)."'";
			//echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$OrderID = $this->lastInsertId();
			
			if(empty($RecieveID)){
				$RecieveID = 'RTN000'.$OrderID;
			}

			$sql="UPDATE w_order_recieve  SET RecieveID='".$RecieveID."' WHERE OrderID='".$OrderID."'";
			$this->query($sql,0);

		 return $OrderID;		
		}
		
		function RemoveRecieve($OrderID){
			
			$strSQLQuery = "delete from w_order_recieve  where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "delete from w_recieve_item   where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery, 0);	

			return 1;

		}
		
		function UpdateRecieve($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update w_order_recieve  set RecievePaid='".$RecievePaid."', RecieveComment='".addslashes($RecieveComment)."', UpdatedDate = '".$Config['TodayDate']."'
			where OrderID=".$OrderID.""; 
			$this->query($strSQLQuery, 0);

			return 1;
		}
		
			function isRecieveExists($RecieveID,$OrderID=0)
			{
				$strSQLQuery = (!empty($OrderID))?(" and OrderID != '".$OrderID."'"):("");
				$strSQLQuery = "select OrderID from w_order_recieve  where Module='Recieve' and RecieveID='".trim($RecieveID)."'".$strSQLQuery;
				$arryRow = $this->query($strSQLQuery, 1);

				if (!empty($arryRow[0]['OrderID'])) {
					return true;
				} else {
					return false;
				}
			}	
			
			
			//Sent All Email Here
			
		
		
		
		
		
			//End Email Code
			
			

		
		
		function  isReturnSo($InvoiceID)
		{
		  $sql = "select SaleID  from w_order_recieve where 	InvoiceID='".$InvoiceID."'"; 
			$rs = $this->query($sql);
			return $rs[0]['SaleID'];
		}




		

		
		function  isTransfer($InvoiceID)
		{
			$sql = "select transferID  from w_transfer where refID='".trim($InvoiceID)."'"; 
			$rs = $this->query($sql);
			return $rs[0]['transferID'];
		}

         function RemoveTransferRecieve($OrderID){
			
			$strSQLQuery1 = "delete from w_transfer  where transferID='".$OrderID."'"; 
			$this->query($strSQLQuery1, 0);

			$strSQLQuery2 = "delete from w_transfer_recieve   where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery2, 0);	

			$strSQLQuery3 = "delete from w_transfer_item   where OrderID='".$OrderID."'"; 
			$this->query($strSQLQuery3, 0);

			return 1;

		}

		function AddTransferOrder($arryDetails){
		
		    global $Config;
		    extract($arryDetails);
			 		 	
			$strSQLQuery = "INSERT INTO w_transfer  SET 
			transferNo='".$transferNo."',
			refID ='".$transferID."',
			to_WID = '".$to_WID."',
			from_WID = '".$from_WID."',
			warehouse_code = '".addslashes($warehouse_code)."',
			total_transfer_qty = '".$total_transfer_qty."',
			total_transfer_value = '".$total_transfer_value."',
			transfer_reason = '".$transfer_reason."',
			transferDate = '".$transferDate."',
			created_by = '".addslashes($created_by)."',
			created_id='".addslashes($created_id)."',
			Status = '".$Status."'";
			#echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$transID = $this->lastInsertId();
			
			if(empty($RecieveID)){
				$RecieveID = 'TNS000'.$transID;
			}

			$sql="UPDATE w_transfer_recieve  SET RecieveID='".$RecieveID."' WHERE OrderID='".$transID."'";
			$this->query($sql,0);

		 return $transID;		
		}


       function GetTransfer($transferID) {
        $strAddQuery .= (!empty($transferID)) ? (" and transferID=" . $transferID) : ("");
        $strSQLQuery = "select * from inv_transfer  where 1" . $strAddQuery . " order by transferID asc";
        return $this->query($strSQLQuery, 1);
       }

	 function GetTransferStock($transferID) {
        $strAddQuery .= (!empty($transferID)) ? (" and transferID=" . $transferID) : ("");
        $strSQLQuery = "select * from inv_stock_transfer  where 1" . $strAddQuery . " order by transferID asc"; 
        return $this->query($strSQLQuery, 1);
    }

		 function TransferRecieveOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);
            

			 $TransferOrderID = $RecieveOrderID;

			
			$CheckID =$this->isTransfer($TransferOrderID);
	        if(empty($CheckID)){
            /*****************************/
			$arryTransfer = $this->GetTransfer($TransferOrderID);
			
            $arryTransfer[0]['RecieveDate'] = $RecieveDate;
			$transfer_id = $this->AddTransferOrder($arryTransfer[0]);
			if($transfer_id>0){

                $shipID = $this->AddTransferDetail($arryDetails,$transfer_id);
			}
		    $arryItem = $this->GetTransferStock($TransferOrderID);
			/*****************************/

			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id)){
					
					$sql = "insert into w_transfer_item  (OrderID, item_id, sku, description, on_hand_qty,  qty,qty_received, price, amount,transferID) values('".$transfer_id."', '".$arryItem[$Count]["item_id"]."' , '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['qty'.$i])."',  '".$arryItem[$Count]["price"]."',  '".$arryDetails['amount'.$i]."','".$TransferOrderID."')";

					$this->query($sql, 0);	
					
					
				}
			}


			
            } else {

            $arryItem = $this->GetTransferStock($TransferOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id) && $arryDetails['qty'.$i]>0){
                  $sqlSelect = "select qty_received from w_transfer_item   where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_returned = $arrRow[0]['qty_received'];
					$qty_returned = $qty_returned+$arryDetails['qty'.$i];
					$sqlupdate = "update w_transfer_item   set qty_received = '".$qty_returned."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);

				}

			}
		}
		


			return $transfer_id;
		}


		   function GetTransferOrderItem($OrderID) {
				$strAddQuery .= (!empty($OrderID)) ? (" and OrderID=" . $OrderID) : ("");
				 $strSQLQuery = "select * from w_transfer_item  where 1" . $strAddQuery . " order by OrderID asc"; 
				return $this->query($strSQLQuery, 1);
			}


		function  GetTransferOrder($transferID,$refNumber,$refID)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.transferID=".$transferID):("");
			$strAddQuery .= (!empty($SaleID))?(" and o.refNumber='".$refNumber."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.refID='".$refID."'"):("");
			$strSQLQuery = "select o.*,t.* from w_transfer  o left outer join w_transfer_recieve  t on  t.OrderID =  o.transferID  where 1".$strAddQuery." order by o.transferID desc";
			return $this->query($strSQLQuery, 1);
		}
		
		 function AddTransferDetail($arryDetails,$TNID)
		{  
			global $Config;
			extract($arryDetails);
	        //if(empty($Currency)) $Currency =  $Config['Currency'];
			//if(empty($ClosedDate)) $ClosedDate = $Config['TodayDate'];


			   $strSQLQuery = "insert into w_transfer_recieve(warehouse, RecieveID, transaction_ref,InvoiceID,  transport, packageCount, PackageType, Weight, charge, Currency, Status, Description, apply_to, Price, PaidAs, amount,  CreatedBy, AdminID, AdminType, PostedDate, UpdatedDate, RecievedDate) values('".$warehouse."', '".$ReturnID."', '".$transaction_ref."',  '".$InvoiceID."', '".$transport."', '".$packageCount."', '".$PackageType."', '".$Weight."','".$charge."','".$Currency."','".$Status."', '".addslashes(strip_tags($Description))."', '".$apply_to."', '".$Price."', '".$PaidAs."', '".$ammount."',  '".addslashes($_SESSION['UserName'])."', '".$_SESSION['AdminID']."', '".$_SESSION['AdminType']."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$RecieveDate."')";
			 
			
			
			$this->query($strSQLQuery, 0);
			$shipID = $this->lastInsertId();
			
			if($shipID>0){
		  if(empty($ReturnID)){
            $ReturnID = 'TNS000'.$shipID;
			}
            $sqlupdate = "update w_transfer_recieve   set OrderID = '".$TNID."',RecieveID ='".$ReturnID."' where shipID = '".$shipID."'";
			$this->query($sqlupdate, 0);
			}

			

			return $shipID;

		}
function  GetTransferQtyRecieved($id)
		{
			  $sql = "select sum(i.qty_received) as QtyRecieved from w_transfer_item   i where i.id='".$id."' group by i.transferID";  
			$rs = $this->query($sql);
			return $rs[0]['QtyRecieved'];
		}

		function  GetQtyTransfer($id)
		{
			$sql = "select i.qty as QtyTransfer from w_transfer_item   i where i.id='".$id."'";
			$rs = $this->query($sql);
			return $rs[0]['QtyTransfer'];
		}

function  ListTransferRecieve($arryDetails)
		{
			extract($arryDetails);
	
			$strAddQuery = "where 1 ";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($so))?(" and o.transferID='".$so."'"):("");
			$strAddQuery .= (!empty($TPostedDate))?(" and r.RecievedDate<='".$TPostedDate."'"):("");
			$strAddQuery .= (!empty($FPostedDate))?(" and r.RecievedDate<='".$FPostedDate."'"):("");

			 if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (o.RecieveID like '%".$SearchKey."%'  or o.transferNo like '%".$SearchKey."%'  ) " ):("");	
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.transferID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			 $strSQLQuery = "select o.transferDate,o.refID,o.transferNo,o.transferID,o.total_transfer_value,o.to_WID,o.from_WID,t.warehouse_name as to_warehouse,t.WID,t.warehouse_code as t_warehouse,f.warehouse_name as from_warehouse,f.WID,f.warehouse_code as fr_warehouse,  o.transferID,r.RecieveID,r.RecievedDate,r.transaction_ref from w_transfer  o left outer join w_warehouse t on  t.WID =  o.to_WID left outer join w_warehouse  f on  f.WID =  o.from_WID left outer join w_transfer_recieve  r on  r.OrderID = o.transferID ".$strAddQuery;
		//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);		
				
		}

		/*********************************************************/
		 function GetAdjustmentStock($adjID) {
			 $strAddQuery .= (!empty($adjID)) ? (" and adjID=" . $adjID) : ("");
			 $strSQLQuery = "select * from inv_stock_adjustment  where 1" . $strAddQuery . " order by id asc"; 
			return $this->query($strSQLQuery, 1);
		 }

       function  GetAdjustment($AdjID,$Status)
		{
			$strAddQuery .= (!empty($AdjID))?(" and a.adjID=".$AdjID):("");
			$strAddQuery .= (!empty($Status))?(" and a.Status='".$Status."'"):("");
			
			$strSQLQuery = "select a.*, w.warehouse_name,w.WID,w.warehouse_code  from inv_adjustment a left outer join w_warehouse  w on BINARY w.warehouse_code = BINARY a.warehouse_code where 1".$strAddQuery." order by a.adjID desc";
			return $this->query($strSQLQuery, 1);
		}


     function  isAdjustment($adjID)
		{
			$sql = "select adjustmentID  from w_adjustment where adjID='".trim($adjID)."'";
			$rs = $this->query($sql);
			return $rs[0]['adjustmentID'];
		}

    function  GetAdjustmentOrder($AdjustmentID)
		{
			$strAddQuery .= (!empty($AdjustmentID))?(" and a.adjustmentID=".$AdjustmentID):("");
			$strSQLQuery = "select a.*,a.AdminType as created_by, a.AdminID as created_id   from w_adjustment a  where 1".$strAddQuery." order by a.adjID desc";
			return $this->query($strSQLQuery, 1);
		}

    function GetAdjustmentOrderItem($AdjustmentID) {
			 $strAddQuery .= (!empty($AdjustmentID)) ? (" and adjID=" . $AdjustmentID) : ("");
			 $strSQLQuery = "select * from w_adjustment_item  where 1" . $strAddQuery . " order by id asc"; 
			return $this->query($strSQLQuery, 1);
		 }

     function RemoveAdjustmentOrder($adjustmentID){
			
			$strSQLQuery = "delete from w_adjustment  where adjustmentID='".$adjustmentID."'"; 
			$this->query($strSQLQuery, 0);
			$strSQLQuery = "delete from w_adjustment_item   where adjustmentID='".$adjustmentID."'"; 
			$this->query($strSQLQuery, 0);	
			return 1;

		}

		 function AdjustmentOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);

			
			$CheckID =$this->isAdjustment($ReturnOrderID);
	        if(empty($CheckID)){
            /*****************************/
			$arryAdjustment = $this->GetAdjustment($ReturnOrderID);
            $arryAdjustment[0]['RecieveDate'] = $RecieveDate;
			$arryAdjustment[0]['RecieveID'] = $RecieveID;
			$arryAdjustment[0]['transaction_ref'] = $transaction_ref;
			$arryAdjustment[0]['transport'] = $transport;
			$arryAdjustment[0]['packageCount'] = $packageCount;
			$arryAdjustment[0]['PackageType'] = $PackageType;
			$arryAdjustment[0]['Weight'] = $Weight;

			$arryAdjustment[0]['charge'] = $charge;
			$arryAdjustment[0]['Description'] = $Description;
			$arryAdjustment[0]['Price'] = $Price;
			$arryAdjustment[0]['PaidAs'] = $PaidAs;
			$arryAdjustment[0]['ammount'] = $ammount;
			$arryAdjustment[0]['TaxRateOption'] = $ammount;
			$adjustment_id = $this->AddAdjustmentOrder($arryAdjustment[0]);
			#echo $adjustment_id; exit;
			
		    $arryItem = $this->GetAdjustmentStock($ReturnOrderID);
		
			/*****************************/

			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id)){
					$qty_returned = $arryDetails['qty'.$i];
					echo $sql = "insert into w_adjustment_item  (adjID, item_id,  sku, description, on_hand_qty, qty, qty_received, price, tax_id, tax, amount) values('".$adjustment_id."', '".$arryItem[$Count]["item_id"]."' ,  '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['qty'.$i])."',  '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."')"; 

					$this->query($sql, 0);	
					
					//Update Item
					/*$sqlSelect = "select qty_returned from w_recieve_item   where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_returned = $arrRow[0]['qty_returned'];
					$qty_returned = $qty_returned+$arryDetails['qty'.$i];
					$sqlupdate = "update w_recieve_item   set qty_returned = '".$qty_returned."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);*/	
					//end code
				}
			}


			
            } else {

            $arryItem = $this->GetAdjustmentStock($ReturnOrderID);
			$NumLine = sizeof($arryItem);
			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];
				if(!empty($id) && $arryDetails['qty'.$i]>0){
                  $sqlSelect = "select qty_received from w_adjustment_item   where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_recieved = $arrRow[0]['qty_received'];
					$tot_qty_recieved = $qty_recieved+$arryDetails['qty'.$i];
					$sqlupdate = "update w_adjustment_item   set qty_received = '".$tot_qty_recieved."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);

				}

			}
		}
		


			return $adjustment_id;
		}
		
		function AddAdjustmentOrder($arryDetails){
		
		    global $Config;
		    
			extract($arryDetails);
			
			 		 	
			 $strSQLQuery = "INSERT INTO w_adjustment  SET warehouse_code = '".$warehouse_code."',
			adjDate='".$adjDate."',
			transaction_ref ='".$transaction_ref."',
			adjID = '".$adjID."',
			adjustNo = '".$adjID."',
			packageCount = '".$packageCount."',
			RecieveID = '".addslashes($RecieveID)."',
			WID = '".$WID."',
			transport = '".$transport."',
			PackageType = '".$PackageType."',
			Weight = '".$Weight."',
			charge = '".addslashes($charge)."',
			Description='".addslashes($Description)."',
			apply_to = '".$CustID."',
			Price = '".$Price."',
			PaidAs = '".addslashes($PaidAs)."',
			amount = '".addslashes($ammount)."',
			ReceivedDate = '".$RecieveDate."',
			Status       = '".$Status."',
			TotalAmount = '".addslashes($total_adjust_value)."',
			Currency = '".$Config['Currency']."',
			CreatedBy = '".addslashes($_SESSION['UserName'])."', 
			AdminID='".$_SESSION['AdminID']."',
			AdminType='".$_SESSION['AdminType']."',
			AssignedEmp='".addslashes($AssignedEmp)."',
			AssignedEmpID='".addslashes($AssignedEmpID)."'";
			#echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$adjustment_ID = $this->lastInsertId();
			
			if(empty($RecieveID)){
				$RecieveID = 'RTN000'.$adjustment_ID;
			}

			$sql="UPDATE w_adjustment  SET RecieveID='".$RecieveID."' WHERE adjustmentID='".$adjustment_ID."'";
			$this->query($sql,0);

		 return $adjustment_ID;		
		}

		function  GetQtyAdjustment($id)
		{
			 $sql = "select i.qty as QtyAdjustment from w_adjustment_item i where i.id='".$id."'"; 
			$rs = $this->query($sql);
			return $rs[0]['QtyAdjustment'];
		}

		function  GetQtyAdjustmentReceived($id)
		{
			 $sql = "select sum(i.qty) as QtyAdjustment,sum(i.qty_received) as QtyRecieved from w_adjustment_item   i where i.id='".$id."' group by i.adjID"; 
			$rs = $this->query($sql);
			return $rs[0]['QtyRecieved'];
			return $rs;
		}


	
}
?>
