<?php
class warehouse extends dbClass
{
		//constructor
		function warehouse()
		{
			$this->dbClass();
		} 
		
		function  ListWarehouse($id=0,$SearchKey,$SortBy,$AscDesc,$Status)
		{
			
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where  w.WID=".$id):(" where w.location='".$_SESSION['locationID']."' ");
			$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
		

		  if($SearchKey=='active' && ($SortBy=='w.Status' || $SortBy=='') ){
				$strAddQuery .= " and w.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='w.Status' || $SortBy=='') ){
				$strAddQuery .= " and w.Status=0";
			}else	
		   if($SortBy == 'WID'){
                         $strAddQuery .= (!empty($SearchKey))?(" and (w.WID = '".$SearchKey."')"):("");
		   }else{

		  if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and ( w.warehouse_name like '%".$SearchKey."%' or w.warehouse_code like '%".$SearchKey."%' or l.City like '%".$SearchKey."%' or w.ContactName like '%".$SearchKey."%' or l.State like '%".$SearchKey."%' or l.City like '%".$SearchKey."%'   ) "  ):("");			
			}

		     }

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by w.WID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			$strSQLQuery = "select w.*,l.ZipCode,l.City,l.State,l.Country, l.Address,l.country_id,l.city_id,l.state_id,l.OtherState,l.OtherCity from w_warehouse w left outer join  w_warehouse_location  l on l.WID=w.WID  ".$strAddQuery;	
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	

		function GetWarehouseBrief($WID)
		{
			
			$strAddQuery .= (!empty($WID))?(" and w.WID='".$WID."'"):(" ");
			$strSQLQuery = "select w.WID,w.warehouse_code,w.warehouse_name from w_warehouse w where w.Status=1 ".$strAddQuery." order by w.warehouse_name asc";
			return $this->query($strSQLQuery, 1);
		}
              function ListInStock($id=0,$SearchKey,$SortBy,$AscDesc,$Status)
		{
			
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($Status))?(" where w.status=".$Status):(" ");
		

		  if($SearchKey=='active' && ($SortBy=='w.status' || $SortBy=='') ){
				$strAddQuery .= " and w.status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='w.status' || $SortBy=='') ){
				$strAddQuery .= " and w.status=0";
			}else	
		   if($SortBy == 'stockin_id'){
                         $strAddQuery .= (!empty($SearchKey))?(" and (w.stockin_id = '".$SearchKey."')"):("");
		   }else{

		  if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and ( w.warehouse_name like '%".$SearchKey."%' or w.receiving_date like '%".$SearchKey."%')"):("");			
			}

		     }
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by w.stockin_id ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			//$strSQLQuery = "select w.*,l.ZipCode,l.City,l.State,l.Country, l.Address,l.country_id,l.city_id,l.state_id,l.OtherState,l.OtherCity from w_warehouse w left outer join  w_warehouse_location  l on l.WID=w.WID  ".$strAddQuery;	
		        $strSQLQuery = "select w.* from w_stock_in w ".$strAddQuery;	
		        
			return $this->query($strSQLQuery, 1);		
				
		}	


		/************************** Employee List *************************/

	/*	function  ListEmployee($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where e.EmpID=".$id):(" where e.locationID=".$_SESSION['locationID']);

			if($SearchKey=='active' && ($SortBy=='e.Status' || $SortBy=='') ){
				$strAddQuery .= " and e.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='e.Status' || $SortBy=='') ){
				$strAddQuery .= " and e.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpID like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%' or e.Role like '%".$SearchKey."%' or e2.UserName like '%".$SearchKey."%' ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by e.EmpID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			$strSQLQuery = "select e.EmpID,e.Status,e.UserName,e.Email,e.Role,e.Image,d.Department,e2.UserName as SupervisorName from h_employee e left outer join  department d on e.Department=d.depID left outer join  h_employee e2 on e.Supervisor=e2.EmpID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
*/
		/****************************************************/
		

		function  ListSearchWarehouse($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where l.WID=".$id):(" where 1 ");
			$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

			
				$strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' ) "  ):("");			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by l.WID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			  $strSQLQuery = "select l.WID,l.primary_email,l.FirstName,l.LastName,l.AssignTo,l.lead_status,l.description,l.company,d.Department,e.Role,e.UserName as AssignTo from w_warehouse l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		
		



       function  GetDashboardWarehouse($AdminType,$EmpID)
		{
			$strSQLQuery = "select l.WID,l.FirstName,l.LastName,l.company,l.AssignTo from w_warehouse l ";
			

			$strSQLQuery .= ($AdminType!="admin")?(" where l.AssignTo=".$EmpID):(" where 1 ");
			$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");
			
			$strSQLQuery .= " order by l.WID limit 0,7 ";

			//echo $strSQLQuery;

			return $this->query($strSQLQuery, 1);
		}		


		function  GetWarehouse($WID)
		{
			$strSQLQuery = "select w.*,l.ZipCode, l.Address,l.country_id,l.city_id,l.state_id,l.OtherState,l.OtherCity,l.City,l.State,l.Country from w_warehouse w left outer join  w_warehouse_location  l on l.WID=w.WID";

			$strSQLQuery .= (!empty($WID))?(" where w.WID=".$WID):(" where 1 ");
			//$strSQLQuery .= ($Opportunity>0)?(" and l.Opportunity=".$Opportunity):("");
			///$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

			return $this->query($strSQLQuery, 1);
		}		
		

		function  GetWarehousesForprimary_email($WID)
		{
			$strSQLQuery = "select WID,primary_email from w_warehouse where 1";
			$strSQLQuery .= (!empty($WID))?(" and WID!=".$WID):("");
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllWarehouses($warehouse_code)
		{
			$strSQLQuery = "select WID,warehouse_name,warehouse_code from w_warehouse where 1  ";

			$strSQLQuery .= (!empty($warehouse_code))?(" and warehouse_code='".$warehouse_code."'"):("");
			

			$strSQLQuery .= " order by warehouse_code Asc";
                        
                        #echo $strSQLQuery; exit;
                    

			return $this->query($strSQLQuery, 1);
		}
                 
              
		function  GetWarehouseDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where w.WID=".$id):(" where 1 ");
			//$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

			$strAddQuery .= " order by w.CreateDate Desc ";

			$strSQLQuery = "select w.*,a.ZipCode,a.Address,a.country_id,a.city_id,a.state_id,a.OtherState,a.OtherCity from w_warehouse w left outer join  w_warehouse_location  a on a.WID=w.WID   ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddWarehouse($arryDetails)
		{  
			
			global $Config;

			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			//if(empty($Status)) $Status=1;
			
			//$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			$JoiningDatl=$Config['TodayDate'];

		$strSQLQuery = "insert into w_warehouse (warehouse_name,warehouse_code,ContactName,phone_number,mobile_number,`Default`,description,location,CreateDate,ipaddress,created_by,created_id,Status)values('".addslashes($warehouse_name)."','".addslashes($warehouse_code)."', '".addslashes($ContactName)."','".addslashes($phone_number)."','".addslashes($mobile_number)."','".addslashes($Default)."','".addslashes($description)."','".$_SESSION['locationID']."', '".$JoiningDatl."', '".$ipaddress."', '".addslashes($_SESSION['AdminType'])."','".$_SESSION['AdminID']."','".$Status."' )";

		  //(WID,Address,city_id, state_id, ZipCode, country_id)values('".addslashes($warehouse_name)."' '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."' )";

			$this->query($strSQLQuery, 0);

			

			$WID = $this->lastInsertId();

			if($WID>0){
                          $strQuery = "insert into w_warehouse_location (WID,Address,city_id, state_id, ZipCode, country_id,OtherState,OtherCity)values('".$WID."','".addslashes($Address)."', '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."','".$OtherState."','".$OtherCity."' )";
			  $this->query($strQuery, 0);
			}

          
			return $WID;

		}

          
		

		function UpdateWarehouse($arryDetails){ 

			global $Config;

			extract($arryDetails);

			
		
			
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			//if(empty($Status)) $Status=1;type,ProductID,product_price

			 $strSQLQuery = "update w_warehouse set  warehouse_name='".addslashes($warehouse_name)."',
			                                         ContactName='".addslashes($ContactName)."',
					 phone_number='".addslashes($phone_number)."',
					mobile_number='".addslashes($mobile_number)."',
					description='".addslashes($description)."',
					Status='".addslashes($Status)."',
					 description='".addslashes($description)."',
                                          email='".addslashes($email)."'
                                         where WID=".$WID; 

						$this->query($strSQLQuery, 0);


                     $strUpdateQuery = "update w_warehouse_location set  Address='".addslashes($Address)."',
			                                         city_id='".$main_city_id."',
													 state_id='".$main_state_id."',
													 ZipCode='".addslashes($ZipCode)."',
													 country_id='".$country_id."',
													 OtherState='".addslashes($OtherState)."',
													 OtherCity='".addslashes($OtherCity)."'
													 where WID=".$WID; 
						$this->query($strUpdateQuery, 0);

														

			


			

			return 1;
		}


		
         function UpdateCountyStateCity($arryDetails,$WID){  
                       extract($arryDetails);                

                       $strSQLQuery = "update  w_warehouse_location set Country='".addslashes($Country)."',  State='".addslashes($State)."',  City='".addslashes($City)."' where WID=".$WID;
                       $this->query($strSQLQuery, 0);
                       return 1;
               }
	
		

		

		
		
		function RemoveWarehouse($WID)
		{

			$strSQLQuery = "delete from w_warehouse where WID=".$WID; 
			$this->query($strSQLQuery, 0);	
                        
                        $strSQLQuery2 = "delete from w_warehouse_location where WID=".$WID; 
			$this->query($strSQLQuery2, 0);	
                        
			return 1;

		}

		
		
		
		function changeWarehouseStatus($WID)
		{
			$sql="select * from w_warehouse where WID=".$WID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update w_warehouse set Status='$Status' where WID=".$WID;
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleWarehouseStatus($WIDs,$Status)
		{
			$sql="select WID from w_warehouse where WID in (".$WIDs.") "; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update w_warehouse set Status=".$Status." where WID in (".$WIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		

		function isCodeExists($warehouse_code,$WID=0)
		{
			$strSQLQuery = (!empty($WID))?(" and WID != ".$WID):("");
			$strSQLQuery = "select WID from w_warehouse where warehouse_code='".$warehouse_code."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['WID'])) {
				return true;
			} else {
				return false;
			}
		}
	


	
		function isWarehouseNameExists($warehouse_name,$WID=0)
		{
			$strSQLQuery = (!empty($WID))?(" and WID != ".$WID):("");
			$strSQLQuery = "select WID from w_warehouse where warehouse_name='".$warehouse_name."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['WID'])) {
				return true;
			} else {
				return false;
			}
		}
		

		function isBinExists($binlocation,$binid=0,$warehouse_id)
		{
			$strSQLQuery = (!empty($binid))?(" AND binid != '".$binid."'"):("");
			$strSQLQuery = "select binid from w_binlocation  where binlocation_name='".$binlocation."' AND warehouse_id = '".$warehouse_id."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['binid'])) {
				return true;
			} else {
				return false;
			}
		}	
	       	
			function AddBinLocation($arryDetails){  
				extract($arryDetails);
					
if($warehouse_name != ""):
	
						$arr_data = $this->AllWarehouses($arryDetails['warehouse_name']);
 
						$BinCode = strtoupper(substr(md5($arryDetails['binlocation']),0,6)); 
						$strSQLQuery = "insert into w_binlocation (binid,warehouse_id,binlocation_name,status,description,warehouse_name,warehouse_code,barcode) values('','".$arryDetails['warehouse_name']."', '".addslashes($arryDetails['binlocation'])."','".$arryDetails['Status']."','".addslashes($arryDetails['description'])."','".$arr_data['0']['warehouse_name']."','".$arr_data['0']['warehouse_code']."','".$BinCode."')";
						
		$this->query($strSQLQuery, 0);  
						
		    return $binid;
              
			else:
              
			return "null";  
         
			endif;

		}

		/*function ListStockIn($id=0,$SearchKey,$SortBy,$AscDesc,$Status)
		{			
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));			
			$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
		

		  if($SearchKey=='active' && ($SortBy=='w.Status' || $SortBy=='') ){
				$strAddQuery .= " and w.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='w.Status' || $SortBy=='') ){
				$strAddQuery .= " and w.Status=0";
			}else	
		   if($SortBy == 'binid'){
                         $strAddQuery .= (!empty($SearchKey))?(" and (w.OrderID = '".$SearchKey."')"):("");
		   }else{

		  if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and ( w.wCode like '%".$SearchKey."%' or w.warehouse_id like '%".$SearchKey."%' ) "  ):("");			
			}

		     }                  
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by w.OrderID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			$strSQLQuery = "select w.* from p_order w where 1".$strAddQuery;
	
		       
			return $this->query($strSQLQuery, 1);		
				
		}*/

		
	function ListManageBin($id=0,$SearchKey,$SortBy,$AscDesc,$Status){			
	$strAddQuery = '';
	$SearchKey   = strtolower(trim($SearchKey));			
	$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
		

        if($SearchKey=='active' && ($SortBy=='w.Status' || $SortBy=='') ){
		$strAddQuery .= " and w.Status=1"; 
	}else if($SearchKey=='inactive' && ($SortBy=='w.Status' || $SortBy=='') ){
	 $strAddQuery .= " and w.Status=0";
	}else	
	   if($SortBy == 'binid'){
		 $strAddQuery .= (!empty($SearchKey))?(" and (w.binid = '".$SearchKey."')"):("");
	   }else{

	  if($SortBy != ''){
		$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
		$strAddQuery .= (!empty($SearchKey))?(" and ( w.binlocation_name like '%".$SearchKey."%' or w.warehouse_id like '%".$SearchKey."%' ) "  ):("");			
		}

	     }                  
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by w.binid ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select w.* from w_binlocation w where 1 ".$strAddQuery; 
	
		       
			return $this->query($strSQLQuery, 1);		
				
		}
		
			
		
		function ListStockIn($id=0,$SearchKey,$SortBy,$AscDesc,$Status)
		{			
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));			
			$strAddQuery .= (!empty($Status))?(" and w.Status=".$Status):(" ");
		

		  if($SearchKey=='active' && ($SortBy=='w.Status' || $SortBy=='') ){
				$strAddQuery .= " and w.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='w.Status' || $SortBy=='') ){
				$strAddQuery .= " and w.Status=0";
			}else if($SortBy == 'binid'){
            $strAddQuery .= (!empty($SearchKey))?(" and (w.binid = '".$SearchKey."')"):("");
		   }else{
            if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and ( w.binlocation_name like '%".$SearchKey."%' or w.warehouse_id like '%".$SearchKey."%' ) "  ):("");			
			}

		     }                  
			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by w.binid ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select w.* from w_binlocation w where 1".$strAddQuery; 
	
		       
			return $this->query($strSQLQuery, 1);		
				
		}
     
			


			function getWarehousedata($WID)
{

				$strAddQuery = "where 1 ";
				$strAddQuery .= (!empty($WID))?("and WID ='".$WID."'"):(" ");
				$strSQLQuery = "select warehouse_name,warehouse_code from w_warehouse ".$strAddQuery;   
				return $this->query($strSQLQuery, 1);

	
			}
               
				

		   function getBindata($bid)
{
	
            $strAddQuery = "where 1 ";
				$strAddQuery .= (!empty($bid))?("and binid ='".$bid."'"):(" ");
				$strSQLQuery = "select * from w_binlocation ".$strAddQuery;

				
		      	return $this->query($strSQLQuery, 1);

	
			}


		function GetWarehouseBin($wCode)
		{

			$strAddQuery = "where 1 and Status ='1' ";
			$strAddQuery .= ($wCode!='')?("and warehouse_code ='".$wCode."'"):(" ");
			$strSQLQuery = "select * from w_binlocation ".$strAddQuery; 


			return $this->query($strSQLQuery, 1);


		}


	
	
			
			function UpdateBinLocation($arryDetails){  
				extract($arryDetails);   
                                
                                
				
                       if($warehouse_name != ""){
	
				$arryWarehouse = $this->AllWarehouses($warehouse_name);
                                

				$strSQLQuery = "update  w_binlocation set binlocation_name='".addslashes($binlocation)."',warehouse_code = '".addslashes($warehouse_name)."' , status='".addslashes($Status)."',description = '".addslashes($description)."' where binid='".$binid."'";
				}
				$this->query($strSQLQuery, 0);
				return 1;
			}
					
				
			function RemoveBinLocation($BID)
{
	
				$strSQLQuery = "delete from w_binlocation where binid='".$BID."'"; 
			    $this->query($strSQLQuery, 0);	                       
			    return 1;

	
			}
		
				   
			   
			function changeBinStatus($bid){
	
				   $sql="select * from w_binlocation where binid='".$bid."'";
			       $rs = $this->query($sql);
					if(sizeof($rs))
					{
						if($rs[0]['status']==1)
							$Status=0;
						else
							$Status=1;
							
						$sql="update w_binlocation set status='$Status' where binid='".$bid."'";
						$this->query($sql,0);				
						return true;
					}
	
		
			}
					

					/**************************************/

		function GenerateShipping($InvoiceData)
		 {
		    global $Config;
		    //$arryDetails = $this->GetSaleOrderForInvoice($InvoiceData['OrderID']);
			
			
			//extract($arryDetails);
			 		 	
		    $SelectQury="select InvoiceID,TotalAmount,Freight,ShippedDate,wCode,wName,InvoiceComment,SaleID from s_order where InvoiceID ='".$InvoiceData['ShipInVoice']."' "; 
             $rs = $this->query($SelectQury);
			 

			$InvoiceID = $rs['InvoiceID'];
			$SaleID = $rs['SaleID'];
            $TotalInvoiceAmount = $rs['TotalAmount'];
			$Freight = $rs['Freight'];
			
			$ShippedDate = $rs['ShippedDate'];
			$wCode = $rs['wCode'];
			$wName = $rs['wName'];
			$InvoiceComment = $rs['InvoiceComment'];
			
			//if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];
			
			  $strSQLQuery = "INSERT INTO w_outbound SET Module = 'Invoice',RefID='".$InvoiceData['ShipInVoice']."',  OrderID ='".$InvoiceData['OrderID']."', shipping = '".$shipping."',createDate='".$Config['TodayDate']."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',OrderType = 'Sales',ShipDate = '".$InvoiceData['ShipDate']."',transport = '".$InvoiceData['transport']."',packageCount = '".$InvoiceData['packageCount']."',PackageType = '".$InvoiceData['PackageType']."',Weight = '".$InvoiceData['Weight']."' ";
			  
				$this->query($strSQLQuery, 0);
				$OrdID = $this->lastInsertId();
			
			if(empty($shipID)){
				$ShipInvoiceID = 'SHIP000'.$OrdID;
			}

			$sql="UPDATE w_outbound SET shipID='".$ShipInvoiceID."',order_id='".$rs['OrderID']."' WHERE id='".$OrdID."'";
			$this->query($sql,0);	
			return $OrdID;
		}

		function AddShippingItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
         
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['pickQty'.$i])){
					
					$id = $arryDetails['id'.$i];
					
					$sql = "insert into w_outbound_item(shipID,InvoiceID,ref_id, item_id, sku, pickQty, qty_invoiced,binid ) values('".$order_id."','".$ShipInVoice."', '".$id."','".addslashes($arryDetails['item_id'.$i])."', '".addslashes($arryDetails['sku'.$i])."','".addslashes($arryDetails['pickQty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."','".addslashes($arryDetails['bin'.$i])."')";
					$this->query($sql, 0);	
					
					/*$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qtyreceived = $arrRow[0]['qty_received'];
					$qtyreceived = $qtyreceived+$arryDetails['qty'.$i];
					
					$qtyinvoiced = $arrRow[0]['qty_invoiced'];
					$qtyinvoiced = $qtyinvoiced+$arryDetails['qty'.$i];
					
					$sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);*/	
				}
			}

			return true;

		}



		/**************************Transfer Shipping***********************/

		
		function GenerateTranferShipping($InvoiceData)
		 {
		    global $Config;
		    //$arryDetails = $this->GetSaleOrderForInvoice($InvoiceData['OrderID']);
			
			
			//extract($arryDetails);
			 		 	
		    $SelectQury="select transferNo,to_WID,from_WID,transferDate,transfer_reason,transferID from inv_transfer where transferNo ='".$InvoiceData['ShipOrder']."' "; 
             $rs = $this->query($SelectQury);
			 

			$Transfer_No = $rs['transferNo'];
			$transfer_id = $rs['transferID'];
            //$TotalInvoiceAmount = $rs['TotalAmount'];
			//$Freight = $rs['Freight'];
			
			$transferDate = $rs['transferDate'];
			echo $to_WID = $rs['to_WID'];
			$from_WID = $rs['from_WID'];
			$transfer_reason = $rs['transfer_reason'];
			
			//if(empty($CustomerCurrency)) $CustomerCurrency =  $Config['Currency'];
			
			 $strSQLQuery = "INSERT INTO w_outbound SET Module = 'Transfer',RefID='".$InvoiceData['ShipOrder']."',  OrderID ='".$InvoiceData['OrderID']."', shipping = '".$shipping."',createDate='".$Config['TodayDate']."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',OrderType = 'Transfer',ShipDate = '".$InvoiceData['ShipDate']."',transport = '".$InvoiceData['transport']."',packageCount = '".$InvoiceData['packageCount']."',PackageType = '".$InvoiceData['PackageType']."',Weight = '".$InvoiceData['Weight']."' "; 
			$this->query($strSQLQuery, 0);
			$OrdID = $this->lastInsertId();
			
			if(empty($shipID)){
				$ShipInvoiceID = 'SHIP000'.$OrdID;
			}

			$sql="UPDATE w_outbound SET shipID='".$ShipInvoiceID."',to_warehouse ='".$to_WID."',from_warehouse = '".$from_WID."',order_id='".$transfer_id."' WHERE id='".$OrdID."'";
			$this->query($sql,0);	
			return $OrdID;
		}

		function AddTranferShippingItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
         
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['pickQty'.$i])){
					
					$id = $arryDetails['id'.$i];
					
					$sql = "insert into w_outbound_item(shipID,InvoiceID,ref_id, item_id, sku, pickQty, qty_invoiced,binid ) values('".$order_id."','".$ShipOrder."', '".$id."','".addslashes($arryDetails['item_id'.$i])."', '".addslashes($arryDetails['sku'.$i])."','".addslashes($arryDetails['pickQty'.$i])."', '".addslashes($arryDetails['ordered_qty'.$i])."','".addslashes($arryDetails['bin'.$i])."')";
					$this->query($sql, 0);	
					
					/*$sqlSelect = "select qty_received, qty_invoiced from s_order_item where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qtyreceived = $arrRow[0]['qty_received'];
					$qtyreceived = $qtyreceived+$arryDetails['qty'.$i];
					
					$qtyinvoiced = $arrRow[0]['qty_invoiced'];
					$qtyinvoiced = $qtyinvoiced+$arryDetails['qty'.$i];
					
					$sqlupdate = "update s_order_item set qty_received = '".$qtyreceived."',qty_invoiced = '".$qtyinvoiced."' where id = '".$id."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$this->query($sqlupdate, 0);*/	
				}
			}

			return true;

		}


		function  GetShipDetail($arryDetails){

		global $Config;

		 $sql = "SELECT id,shipID,Module,RefID,OrderType,ShipDate,transport,CreatedBy,AdminID,AdminType FROM `w_outbound`  WHERE deleted = '0' order by shipID asc"; 
		$arryDB = $this->query($sql, 1);
		
		 return $arryDB;

		}	


				 function RemoveShip($id){

				   $sql="update `w_outbound` set deleted=1 where id='".$id."'";
					$this->query($sql,0);				
					return 1;

				 }


		/**********************************************/

/***************Sales Return **************************/


	function AddReceiptOrder($arryDetails){
		
		    global $Config;
		    
			extract($arryDetails);



			 		 	
			 $strSQLQuery = "INSERT INTO w_receipt SET Module = 'Receipt',ModuleType ='Sales', OrderID='".$OrderID."', SaleID ='".$SaleID."', QuoteID = '".$QuoteID."',InvoiceID ='".$InvoiceID."',ReturnID = '".$ReturnID."',ReceiptStatus = '".$ReceiptStatus."' ,packageCount = '".addslashes($packageCount)."',transport = '".addslashes($transport)."',Weight = '".$Weight."', ReceiptComment = '".addslashes($ReceiptComment)."',TotalReceiptAmount = '".addslashes($TotalAmount)."', CreatedBy = '".addslashes($_SESSION['UserName'])."', AdminID='".$_SESSION['AdminID']."',AdminType='".$_SESSION['AdminType']."',PostedDate='".$Config['TodayDate']."',UpdatedDate='".$Config['TodayDate']."',ReceiptDate='".$ReceiptDate."', wCode ='".$warehouse."'"; 


			//echo "=>".$strSQLQuery;exit;
			$this->query($strSQLQuery, 0);
			$RECPTID = $this->lastInsertId();
			
			if(empty($ReceiptNo)){

				$ReceiptNo = 'RCPT000'.$RECPTID;
			}

			$sql="UPDATE w_receipt SET ReceiptNo='".$ReceiptNo."' WHERE ReceiptID='".$RECPTID."'";
			$this->query($sql,0);

		 return $RECPTID;		
		}




         function  GetReceipt($OrderID,$ReceiptID,$Module)
		{
			$strAddQuery .= (!empty($OrderID))?(" and o.ReceiptID=".$OrderID):("");
			$strAddQuery .= (!empty($ReceiptID))?(" and o.ReceiptNo='".$ReceiptID."'"):("");
			$strAddQuery .= (!empty($Module))?(" and o.Module='".$Module."'"):("");
			$strSQLQuery = "select o.*,s.* from w_receipt o left outer join s_order s on o.OrderID = s.OrderID  where 1".$strAddQuery." order by o.OrderID desc"; 
			return $this->query($strSQLQuery, 1);
		}

function  GetQtyReturned($id)
		{
			$sql = "select sum(i.qty_returned) as QtyReturned,sum(i.qty_receipt) as QtyReceipt from s_receipt_item i where i.OrderID='".$id."' group by i.ReceiptID";
			$rs = $this->query($sql);
			return $rs;
		}
 function RecieptOrder($arryDetails)	{
			global $Config;
			extract($arryDetails);
		
                         $strSQLQuery = "select o.*,e.Email as CreatedByEmail from s_order o left outer join h_employee e on (o.AdminID=e.EmpID and o.AdminType!='admin') where 1 and o.OrderID='".$ReturnOrderID."' ";
			$arrySale =  $this->query($strSQLQuery, 1);

			
			$arrySale[0]["PrefixSale"] = "RCPT";
			$arrySale[0]["warehouse"] = $warehouse;
			$arrySale[0]["ReceiptDate"] = $ReceiptDate;
			$arrySale[0]["ReceiptStatus"] = $ReceiptStatus;
			$arrySale[0]["packageCount"] = $packageCount;
			$arrySale[0]["transport"] = $transport;
			$arrySale[0]["PackageType"] = $PackageType;
			$arrySale[0]["Weight"] = $Weight;
			$arrySale[0]["ReceiptComment"] = $ReceiptComment;

			
			
			$receipt_id = $this->AddReceiptOrder($arrySale[0]);


			/******** Item Updation for Return ************/
			#$arryItem = $this->GetSaleItem($ReturnOrderID);

$strQuery = "select i.*,t.RateDescription,itm.evaluationType from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId left outer join inv_items itm on i.item_id=itm.ItemID where 1 and i.OrderID='".$ReturnOrderID."' order by i.id asc";
			$arryItem = $this->query($strQuery, 1);



			$NumLine = sizeof($arryItem);

			for($i=1;$i<=$NumLine;$i++){
				$Count=$i-1;
				$id = $arryDetails['id'.$i];

                            

                                      $qty_receipt = $arryDetails['qty'.$i];
                                        $SerialNumbers = $arryDetails['serial_value'.$i];       

                          
				if(!empty($id) && $arryDetails['qty'.$i]>0){

 if(!empty($Recipt_ID)){


if($id>0){
						/*$sql = "update w_receipt_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."',qty_receipt = qty_receipt+'".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."',Taxable='".addslashes($arryDetails['item_taxable'.$i])."'  where id=".$id; 
					}else{*/
						
					$sql = "insert into w_receipt_item(ReceiptID,OrderID, item_id, ref_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers) values('".$receipt_id."','".$arryItem[$Count]["OrderID"]."', '".$arryItem[$Count]["item_id"]."' , '".$arryDetails['id'.$i]."', '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['received_qty'.$i])."', '".addslashes($arryDetails['received_qty'.$i])."','".$arryItem[$Count]["qty_returned"]."','".$qty_receipt ."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$SerialNumbers."')";

}
				

}else{

$sql = "insert into w_receipt_item(ReceiptID,OrderID, item_id, sku, description, on_hand_qty, qty, qty_received,qty_invoiced,qty_returned,qty_receipt , price, tax_id, tax, amount, Taxable, req_item,SerialNumbers) values('".$receipt_id."','".$arryItem[$Count]["OrderID"]."', '".$arryItem[$Count]["item_id"]."' ,  '".$arryItem[$Count]["sku"]."', '".$arryItem[$Count]["description"]."', '".$arryItem[$Count]["on_hand_qty"]."', '".$arryItem[$Count]["qty"]."', '".addslashes($arryDetails['received_qty'.$i])."', '".addslashes($arryDetails['received_qty'.$i])."','".$arryItem[$Count]["qty_returned"]."','".$qty_receipt ."', '".$arryItem[$Count]["price"]."', '".$arryItem[$Count]["tax_id"]."', '".$arryItem[$Count]["tax"]."', '".$arryDetails['amount'.$i]."', '".$arryItem[$Count]["Taxable"]."', '".addslashes($arryItem[$Count]["req_item"])."','".$SerialNumbers."')";

}

					$this->query($sql, 0);	
					
					//Update Item
					$sqlSelect = "select qty_receipt from w_receipt_item where OrderID = '".$ReturnOrderID."' and item_id = '".$arryDetails['item_id'.$i]."'";
					$arrRow = $this->query($sqlSelect, 1);
					$qty_receipt = $arrRow[0]['qty_receipt'];
					$qty_receipt = $qty_receipt+$arryDetails['qty'.$i];
					 $sqlupdate = "update w_receipt_item set qty_receipt = '".$qty_receipt."' where id = '".$arrRow[0]['id']."' and item_id = '".$arryDetails['item_id'.$i]."'"; 
					$this->query($sqlupdate, 0);	
					//end code
				}
			}


			return $order_id;
		}


function  GetSaleReceiptItem($OrderID,$SalesID) 
		{
			$strAddQuery .= (!empty($OrderID))?(" and i.ReceiptID='".$OrderID."'"):("");
                        $strAddQuery .= (!empty($SalesID))?(" and i.OrderID='".$SalesID."'"):("");
			//$strSQLQuery = "select i.*,t.RateDescription from s_order_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
                        $strSQLQuery = "select i.*,itm.evaluationType from w_receipt_item i  left outer join inv_items itm on i.item_id=itm.ItemID where 1".$strAddQuery." order by i.id asc"; 

#echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
		}


		function  GetSumQtyReturned($id)
		{
			$sql = "select sum(i.qty_returned) as QtyReturned,sum(r.qty_receipt) as QtyReceipt from s_order_item i left outer join w_receipt_item r on i.item_id=r.item_id where i.OrderID='".$id."' group by i.OrderID";
			$rs = $this->query($sql);
			return $rs;
		}


function  GetSumQtyReceipt($id,$item_id)
		{
			$sql = "select sum(r.qty_receipt) as Qty_Receipt from w_receipt_item  r  where r.OrderID='".$id."'  and r.item_id = '".$item_id."'  group by r.item_id  order by id asc";
			$rs = $this->query($sql);
			return $rs[0]['Qty_Receipt'];
		}



function  ListReceipt($arryDetails)
		{
			
			global $Config;
			extract($arryDetails);
	
			$strAddQuery = "where w.Module='Receipt' ";
			$SearchKey   = strtolower(trim($key));

			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (s.SalesPersonID='".$_SESSION['AdminID']."' or s.AdminID='".$_SESSION['AdminID']."') "):(""); 

			$strAddQuery .= (!empty($so))?(" and w.SaleID='".$so."'"):("");
			$strAddQuery .= (!empty($FromDateRtn))?(" and w.ReceiptDate>='".$FromDateRtn."'"):("");
			$strAddQuery .= (!empty($ToDateRtn))?(" and w.ReceiptDate<='".$ToDateRtn."'"):("");

			if($SearchKey=='yes' && ($sortby=='s.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and s.ReturnPaid='Yes'"; 
			}else if($SearchKey=='no' && ($sortby=='o.ReturnPaid' || $sortby=='') ){
				$strAddQuery .= " and s.ReturnPaid!='Yes'";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (w.ReceiptStatus like '%".$SearchKey."%' or w.ReceiptNo like '%".$SearchKey."%' or  s.ReturnID like '%".$SearchKey."%'  or s.InvoiceID like '%".$SearchKey."%'  or s.SaleID like '%".$SearchKey."%'  or s.CustomerName like '%".$SearchKey."%' or s.CustCode like '%".$SearchKey."%' or s.TotalAmount like '%".$SearchKey."%' or s.CustomerCurrency like '%".$SearchKey."%' ) " ):("");	
			}
			$strAddQuery .= (!empty($CustCode))?(" and s.CustCode='".mysql_real_escape_string($CustCode)."'"):("");


			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by w.ReceiptID ");
			$strAddQuery .= (!empty($asc))?($asc):(" desc");

			$strSQLQuery = "select w.*,s.OrderDate, s.ReturnDate, s.OrderID, s.SaleID,s.ReturnID,s.InvoiceID, s.CustCode, s.CustomerName, s.TotalAmount, s.CustomerCurrency,s.ReturnPaid,s.SalesPerson  from w_receipt w  left outer join s_order s on w.OrderID = s.OrderID ".$strAddQuery;
		#echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);		
				
		}

	function RemoveReceipt($OrderID){
	
		$strSQLQuery = "delete from w_receipt where ReceiptID='".$OrderID."'"; 
		$this->query($strSQLQuery, 0);

		$strSQLQuery = "delete from w_receipt_item where ReceiptID='".$OrderID."'"; 
		$this->query($strSQLQuery, 0);	

		return 1;

	}

		function UpdateSalesReturn($arryDetails){ 
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update w_receipt set ReceiptStatus='".$ReceiptStatus."', ReceiptComment='".addslashes($ReceiptComment)."', UpdatedDate = '".$Config['TodayDate']."'
			where ReceiptID=".$rcptID."";  
			$this->query($strSQLQuery, 0);

			return 1;
		}



			function CheckReceipt($OrderID){

			 $sql = "select ReceiptID from w_receipt  where OrderID='".$OrderID."'  ";
				$rs = $this->query($sql);
	                  if(!empty($rs[0]['ReceiptID'])){  $receiptID = $rs[0]['ReceiptID']; }else{ $receiptID = '';}
				return $receiptID;
			}


}
?>
