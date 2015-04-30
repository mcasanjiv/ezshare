<?php

class BankAccount extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function BankAccount(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}


/*******************************Bank Account Functions Start********************************************************************/
                function getBankAccount($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                {
                    $strAddQuery = "where f.LocationID = '".$_SESSION['locationID']."'";
					$SearchKey   = strtolower(trim($SearchKey));
					$strAddQuery .= (!empty($Status))?(" AND f.Status='".$Status."'"):("");
					if($SearchKey=='active' && ($SortBy=='f.Status' || $SortBy=='') ){
						$strAddQuery .= " AND f.Status='Yes'"; 
					}else if($SearchKey=='inactive' && ($SortBy=='f.Status' || $SortBy=='') ){
						$strAddQuery .= " AND f.Status='No'";
					}else if($SortBy != '' && $SortBy!='f.CustCode'){
						$strAddQuery .= (!empty($SearchKey))?(" AND (".$SortBy." like '".$SearchKey."%')"):("");
					}			 
				   else{
						$strAddQuery .= (!empty($SearchKey))?(" AND (f.BankName like '".$SearchKey."%' or f.AccountName like '%".$SearchKey."%' or f.AccountNumber like '%".$SearchKey."%' or f.AccountCode like '%".$SearchKey."%' or f.AccountType like '%".$SearchKey."%') "):("");
					}

					if(empty($SearchKey))
					{
					 if(!empty($id)){$strAddQuery .= ' AND f.ParentAccountID=0 AND f.AccountTYpe = '.$id.'';}
					}else{

						$strAddQuery .= ' AND f.AccountTYpe = '.$id.'';
					}

					$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by f.OrderBy ");
					$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" ASC");

						   
							//$strSQLQuery = "select f.*,(select SUM(Amount)  from f_payments p WHERE p.PaidTo = f.BankAccountID) as ReceivedAmnt,(select SUM(Amount)  from f_payments p WHERE p.PaidFrom = f.BankAccountID) as PaidAmnt from f_bank_account f ".$strAddQuery;

$strSQLQuery = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = f.BankAccountID) as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = f.BankAccountID) as PaidAmnt,t.AccountType as Type from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType ".$strAddQuery;
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
                
                function getBankAccountNameByID($id)
                {
                     $strSQLQuery = "select AccountName from f_bank_account where BankAccountID = '".mysql_real_escape_string($id)."'";
                     //echo $strSQLQuery;exit;
                    $arryRow = $this->query($strSQLQuery, 1);
                     return $arryRow[0]['AccountName'];
                    
                }

	function getBankAccountWithAccountType()
		{
		
			 $strSQLQuery = "select f.BankAccountID,f.AccountName,t.AccountType,t.AccountTypeID from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType  WHERE f.LocationID = '".$_SESSION['locationID']."' and f.Status = 'Yes' order by f.AccountName";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}

function getBankAccountForReceivePayment()
		{
		
			 $strSQLQuery = "select b.BankAccountID,b.AccountName,t.AccountType,t.AccountTypeID from f_bank_account b left outer join f_account_type t on t.AccountTypeID = b.AccountType  WHERE b.LocationID = '".$_SESSION['locationID']."' and b.AccountType IN(8,16) and b.Status = 'Yes' order by b.OrderBy";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}

function getBankAccountForPaidPayment()
		{
		
			 $strSQLQuery = "select b.BankAccountID,b.AccountName,t.AccountType,t.AccountTypeID from f_bank_account b left outer join f_account_type t on t.AccountTypeID = b.AccountType  WHERE b.LocationID = '".$_SESSION['locationID']."' and b.AccountType IN(16,19) and b.Status = 'Yes' order by b.OrderBy";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}

function getBankAccountForTransfer()
		{
		
			 $strSQLQuery = "select b.BankAccountID,b.AccountName,t.AccountType,t.AccountTypeID from f_bank_account b left outer join f_account_type t on t.AccountTypeID = b.AccountType  WHERE b.LocationID = '".$_SESSION['locationID']."' and b.AccountType IN(6,7,5,8,9,11,16,19) and b.Status = 'Yes' order by b.AccountName";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
		}

 function getBankAccountByAccountType($id)
                {
			
		  if(!empty($id)){$strAddQuery .= ' and AccountTYpeID = '.$id.'';}                    

          $strSQLQuery = "select f.BankAccountID,f.AccountType,t.AccountType,t.AccountTypeID from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType  WHERE f.LocationID = '".$_SESSION['locationID']."' ".$strAddQuery." group by f.AccountType order by f.AccountType desc";
						//echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }

function  GetSubAccountTree($ParentID,$num)
		     {
		           global $Config;
			 
		           $edit = $Config['editImg'];
		           $delete = $Config['deleteImg'];
			   $view = $Config['viewImg'];
                 
			  $query = "SELECT * FROM f_bank_account WHERE ParentAccountID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $num=$num+5;
                            while($values = mysql_fetch_array($result)) { 
				$ReceivedAmnt = $values['ReceivedAmnt'];
				$PaidAmnt = $values['PaidAmnt'];
				$Balance = $ReceivedAmnt-$PaidAmnt;
                                
                                $htmlAccount = '<tr align="left" bgcolor="#ffffff">
                                 <td>';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= $values['AccountName'];

			 $htmlAccount .= '</td>';
                         $htmlAccount .= '<td>'.$values['AccountNumber'].'</td>
                            <!--<td>'.$values['AccountCode'].'</td>-->
                            <td align="right"><strong>'.number_format($Balance,2,'.','').'</strong></td>
                            <td align="center" >';  
                                if ($values['Status'] == "Yes") {
                                    $status = 'Active';
                                } else {
                                    $status = 'InActive';
                                }



                        $htmlAccount .= '<a href="editAccount.php?active_id=' . $values["BankAccountID"] . '&ParentID=' . $values['ParentAccountID'] . '&curP=' . $_GET["curP"] . '" class=' . $status . '>' . $status . '</a>
                        
                        </td>
                            <td height="26" align="center" class="head1_inner" valign="top">
			        <a href="vAccount.php?view='.$values['BankAccountID'].'&curP='.$_GET['curP'].'">'.$view.'</a>		
                                <a href="editAccount.php?edit='.$values['BankAccountID'].'&ParentID='.$values['ParentAccountID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 
                                    $htmlAccount .= '<a href="editAccount.php?del_id='.$values['BankAccountID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentAccountID'].'" onclick="return confDel('.$cat_title.')" class="Blue" >'.$delete.'</a>';

//$htmlAccount .= '<br><a href="accountTransaction.php?accountID='.$values['BankAccountID'].'" class="fancybox account fancybox.iframe">Transaction</a>';				
                                

                                $htmlAccount .= '&nbsp;</td>
                        </tr>';
                                  
                                  echo $htmlAccount;
                                  
                                  
                                  if($values['ParentAccountID'] > 0)
                                  {
                                    $this->GetSubAccountTree($values['BankAccountID'],$num); 
                                  }
                                }  
             
		}

		function getAccountByAccountType($accountType)
		{
			 
			$strAddQuery = " where AccountType = '".$accountType."' and LocationID='".$_SESSION['locationID']."' and Status = 'Yes'";
			$strSQLQuery = "select * from f_bank_account ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}


function isBankAccountExists($AccountNumber,$BankAccountID=0)
				{
				    $strSQLQuery = (!empty($BankAccountID))?(" and BankAccountID != ".$BankAccountID):("");
					$strSQLQuery = "SELECT AccountNumber FROM f_bank_account WHERE LCASE(AccountNumber)='".strtolower(trim($AccountNumber))."' AND LocationID = '".$_SESSION['locationID']."'".$strSQLQuery;
					$arryRow = $this->query($strSQLQuery, 1);

					if (!empty($arryRow[0]['AccountNumber'])) {
						return true;
					} else {
						return false;
					}
				}
		
			 function getCashAccount($LocationID,$cashFlag)
				{
				    $strSQLQuery = (!empty($LocationID))?(" and LocationID = '".$LocationID."'"):("");
					$strSQLQuery = "SELECT AccountName FROM f_bank_account WHERE LCASE(CashFlag)='".$cashFlag."'".$strSQLQuery;
					$arryRow = $this->query($strSQLQuery, 1);
					//echo "=>".$strSQLQuery;exit;
					return $this->numRows();
					 
				}
              
                
                function addBankAccount($arryDetails)
                {

			 
			@extract($arryDetails);
			global $Config;

			if(empty($Status)) $Status="Yes";
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 

			if(empty($CashFlag)) $CashFlag=0;
                        
                     $strSQLQuery = "INSERT INTO f_bank_account SET AccountName = '".$AccountName."', AccountNumber='".$AccountNumber."',AccountType='".$AccountType."', ParentAccountID = '".$main_ParentAccountID."', AccountCode='".$AccountCode."', LocationID='".$_SESSION['locationID']."', Currency='". $Config['Currency']."', Address='".$Address."', Status = '".$Status."',  CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."',CashFlag='".$CashFlag."'";
					 
                     $this->query($strSQLQuery,0);
                     $BankAccountID = $this->lastInsertId();
                     return $BankAccountID;
                   
                }

function updateBankAccount($arryDetails)
                {
			@extract($arryDetails);
			global $Config;

			if(empty($Status)) $Status="Yes";
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 
                        
                     $strSQLQuery = "UPDATE f_bank_account SET AccountName = '".$AccountName."', AccountNumber='".$AccountNumber."',AccountType='".$AccountType."', ParentAccountID = '".$main_ParentAccountID."', AccountCode='".$AccountCode."', Address='".$Address."', Status = '".$Status."',  UpdateddDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."' WHERE BankAccountID = '".$EditBankAccountID."'";
					 
                     $this->query($strSQLQuery,0);
                     
                   
                }
				
			 
			 
               
		function RemoveBankAccount($BankAccountID)
		{

			$strSQLQuery = "INSERT INTO f_archive_bank_account SELECT * FROM f_bank_account WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."' AND LocationID = '".$_SESSION['locationID']."'";
			$this->query($strSQLQuery, 0);
	
			$strSQLQuery = "DELETE FROM f_bank_account WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."' AND LocationID = '".$_SESSION['locationID']."'"; 
			$this->query($strSQLQuery, 0);
			return 1;

		}
                
		function changeBankAccountStatus($BankAccountID)
		{
				$strSQLQuery = "SELECT * FROM f_bank_account WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."'"; 
				$rs = $this->query($strSQLQuery);
				if(sizeof($rs))
				{
						if($rs[0]['Status']== "Yes")
								$Status="No";
						else
								$Status="Yes";

						$strSQLQuery = "UPDATE f_bank_account SET Status ='$Status' WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."'"; 
						$this->query($strSQLQuery,0);
						return true;
				}			
		}
		
	   function getBankAccountById($BankAccountID)
			{
					$strSQLQuery = "SELECT * from f_bank_account WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."'";
					return $this->query($strSQLQuery, 1);
			}
              function getAccountTypeName($accountTypeID)
			{
					$strSQLQuery = "SELECT AccountType from f_account_type WHERE AccountTypeID ='".mysql_real_escape_string($accountTypeID)."'";
					$rows = $this->query($strSQLQuery, 1);
					$accountType = $rows[0]['AccountType'];
					return $accountType; 
			}
             function getParentAccountName($ParentAccountID)
			{
					$strSQLQuery = "SELECT AccountName from f_bank_account WHERE BankAccountID ='".mysql_real_escape_string($ParentAccountID)."'";
					$rows = $this->query($strSQLQuery, 1);
					$accountType = $rows[0]['AccountName'];
					return $accountType; 
			}
			
		function UpdateCountyStateCity($arryDetails,$BankAccountID){   
				extract($arryDetails);		

				$strSQLQuery = "UPDATE f_bank_account SET CountryName='".addslashes($Country)."',  StateName='".addslashes($State)."',  CityName='".addslashes($City)."' WHERE BankAccountID ='".mysql_real_escape_string($BankAccountID)."'";
				$this->query($strSQLQuery, 0);
				return 1;
			}

function getBankAccountHistory($BankAccountID,$SearchKey,$FromDate,$ToDate)
		{
				$strAddQuery = 'where 1';
				$SearchKey   = strtolower(trim($SearchKey));
				$strAddQuery .= ($BankAccountID>0)?(" and (p.AccountID = '".$BankAccountID."')"):("");
				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			        $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                                
                                 
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FullName like '".$SearchKey."%' or p.ReferenceNo like '%".$SearchKey."%' or p.PaymentType like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by p.PaymentID ASC";

				$strSQLQuery = "select p.*, c.Company as custCompany,CONCAT(c.FirstName,' ',c.LastName) as CustomerName,b.AccountName,CONCAT(s.FirstName,' ',s.LastName) as SupplierName,s.CompanyName as suppCompany from f_payments p left outer join s_customers c on c.Cid = p.CustID left outer join f_bank_account b on b.BankAccountID = p.AccountID left outer join p_supplier s on  BINARY s.SuppCode = BINARY p.SuppCode ".$strAddQuery;
				//echo $strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
		}
		
		function addTransfer($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 	
			
			$strSQLQuery = "INSERT INTO f_transfer SET  TransferAmount = '".$TransferAmount."', TransferFrom = '".$TransferFrom."', TransferTo = '".$TransferTo."', ReferenceNo = '".addslashes($ReferenceNo)."',TransferDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);	
			$TransferID = $this->lastInsertId();

		if($TransferFrom > 0){
			$strSQLQuery = "INSERT INTO f_payments SET  CreditAmnt = '".$TransferAmount."', AccountID = '".$TransferFrom."', TransferID = '".$TransferID."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Transfer',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			}

		if($TransferTo > 0){
			$strSQLQuery = "INSERT INTO f_payments SET  DebitAmnt = '".$TransferAmount."', AccountID = '".$TransferTo."', TransferID = '".$TransferID."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Transfer',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			}
		
		}

		function getTransfer($arryDetails)
			{
				extract($arryDetails);
				
				$strAddQuery = " where t.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($TransferID>0)?(" and t.TransferID = '".$TransferID."'"):("");
				$strAddQuery .= (!empty($FromDate))?(" and t.TransferDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and t.TransferDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (t.ReferenceNo like '%".$SearchKey."%' or t.TransferAmount like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by t.TransferID Desc";

				$strSQLQuery = "select t.*, b.AccountName as TransferFrom,ba.AccountName as TransferTo from f_transfer t left outer join f_bank_account b on b.BankAccountID = t.TransferFrom left outer join f_bank_account ba on ba.BankAccountID = t.TransferTo ".$strAddQuery;
				//echo $strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
			}

		function RemoveTransfer($TransferID)
		{
			
                    /******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_transfer SELECT * FROM f_transfer WHERE TransferID ='".mysql_real_escape_string($TransferID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE TransferID ='".mysql_real_escape_string($TransferID)."'";
			$this->query($strSQLQuery, 0);


			/*************************************************/
                    
			$strSQLQuery = "DELETE FROM f_transfer WHERE TransferID ='".mysql_real_escape_string($TransferID)."'"; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery1 = "DELETE FROM f_payments WHERE TransferID ='".mysql_real_escape_string($TransferID)."'"; 
			$this->query($strSQLQuery1, 0);

		}


		function getDeposit($arryDetails)
		  {
			extract($arryDetails);
			
			$strAddQuery = " where d.LocationID = '".$_SESSION['locationID']."'";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= ($DepositID>0)?(" and d.DepositID = '".$DepositID."'"):("");
			$strAddQuery .= (!empty($FromDate))?(" and d.DepositDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and d.DepositDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SearchKey))?(" and (d.ReferenceNo like '%".$SearchKey."%' or d.Amount like '%".$SearchKey."%') "):("");
			$strAddQuery .= " order by d.DepositID Desc";

			$strSQLQuery = "select d.*, b.AccountName,CONCAT(c.FirstName,' ',c.LastName) as Customer  from f_deposit d left outer join f_bank_account b on b.BankAccountID = d.AccountID left outer join s_customers c on c.Cid = d.ReceivedFrom ".$strAddQuery;
			//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		     }
		
		function addBankDeposit($arryDetails)
		{
			 extract($arryDetails);
			 global $Config;
			 $ipaddress = $_SERVER["REMOTE_ADDR"]; 
			
		$strSQLQuery = "INSERT INTO f_deposit SET  AccountID = '".$AccountID."', Amount = '".$Amount."', ReferenceNo = '".$ReferenceNo."',DepositDate = '".$DepositDate."', ReceivedFrom = '".$ReceivedFrom."', PaymentMethod = '".$Method."', Comment = '".$Comment."', 
Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', CreatedDate='".$Config['TodayDate']."', IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			$DepositID = $this->lastInsertId();
			

			$strSQLQuery = "INSERT INTO f_payments SET  DebitAmnt = '".$Amount."', AccountID = '".$AccountID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', DepositID = '".$DepositID."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', PaymentDate = '".$DepositDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Deposit',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
                        
                        $strSQLQueryPay = "INSERT INTO f_payments SET  DebitAmnt = '".$Amount."', AccountID = '19', DepositID = '".$DepositID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', PaymentDate = '".$DepositDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income', Flag= 1, IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);	
			
		
		}


	function RemoveDeposit($DepositID)
		{
			
                         /******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_deposit SELECT * FROM f_deposit WHERE DepositID ='".mysql_real_escape_string($DepositID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE DepositID ='".mysql_real_escape_string($DepositID)."'";
			$this->query($strSQLQuery, 0);
                        
                      

			/*************************************************/
                        
			$strSQLQuery = "DELETE FROM f_deposit WHERE DepositID ='".mysql_real_escape_string($DepositID)."'"; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery1 = "DELETE FROM f_payments WHERE DepositID ='".mysql_real_escape_string($DepositID)."'"; 
			$this->query($strSQLQuery1, 0);
                        
                       

		}

		
		function addOtherIncome($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 
			
			$TaxAmount = ($TaxRate*$Amount)/100;
			$TotalAmount = $Amount+$TaxAmount;
			 
			$strSQLQuery = "INSERT INTO f_income SET  Amount = '".$Amount."', TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = '".$TotalAmount."', BankAccount = '".$BankAccount."', ReceivedFrom = '".$ReceivedFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$IncomeTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);	
			$IncomeID = $this->lastInsertId();

			/****Add Payment Transaction******/
				
			$strSQLQueryPay = "INSERT INTO f_payments SET  DebitAmnt = '".$TotalAmount."', AccountID = '".$BankAccount."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income',IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);
                        
                        $strSQLQueryPay = "INSERT INTO f_payments SET  DebitAmnt = '".$TotalAmount."', AccountID = '".$IncomeTypeID."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income', Flag= 1, IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);	
		
		}
		
		function updateOtherIncome($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 
			
			$TaxAmount = ($TaxRate*$Amount)/100;
			$TotalAmount = $Amount+$TaxAmount;
			
			$strSQLQuery = "UPDATE f_income SET  Amount = '".$Amount."', TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = '".$TotalAmount."', BankAccount = '".$BankAccount."', ReceivedFrom = '".$ReceivedFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='".$IncomeTypeID."',UpdatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."' WHERE IncomeID = '".$IncomeID."'";
			$this->query($strSQLQuery, 0);	

			/********Update Payment Transaction******/		
			$strSQLQueryPay = "UPDATE f_payments SET  DebitAmnt = '".$TotalAmount."', AccountID = '".$BankAccount."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income',IPAddress='".$ipaddress."' WHERE IncomeID = '".$IncomeID."' AND Flag != 1";
		
			$this->query($strSQLQueryPay, 0);
                        
                        $strSQLQueryPay = "UPDATE f_payments SET  DebitAmnt = '".$TotalAmount."', AccountID = '".$IncomeTypeID."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income',IPAddress='".$ipaddress."' WHERE IncomeID = '".$IncomeID."' AND Flag = 1";
		
			$this->query($strSQLQueryPay, 0);
		
		}
		
		function RemoveOtherIncome($IncomeID)
		{
                    
                    
                     /******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_income SELECT * FROM f_income WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'";
			$this->query($strSQLQuery, 0);


			/*************************************************/
                        
			$strSQLQuery = "DELETE FROM f_income WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'"; 
			$this->query($strSQLQuery, 0);
			
			$strSQLQuery1 = "DELETE FROM f_payments WHERE IncomeID ='".mysql_real_escape_string($IncomeID)."'"; 
			$this->query($strSQLQuery1, 0);

			return 1;
		}
		
		function getOtherIncome($arryDetails)
			{
				extract($arryDetails);
				
				$strAddQuery = " where f.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($IncomeID>0)?(" and f.IncomeID = '".$IncomeID."'"):("");
                                 $strAddQuery .= ($Flag>0)?(" and f.Flag = 1"):(" and f.Flag != 1");
				$strAddQuery .= (!empty($FromDate))?(" and f.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and f.PaymentDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FirstName like '".$SearchKey."%' or f.ReferenceNo like '%".$SearchKey."%' or f.TotalAmount like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by f.IncomeID Desc";

				$strSQLQuery = "select f.*, c.Company,CONCAT(c.FirstName,' ',c.LastName) as Customer,b.AccountName  from f_income f left outer join s_customers c on c.Cid = f.ReceivedFrom left outer join f_bank_account b on b.BankAccountID = f.BankAccount ".$strAddQuery;
				//echo $strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
			}

/************************End Bank Account Functions***************************************************************************************************/

/********************************Account Type Functions Start*****************************************************************************************/
		
				function getAccountType($arryDetails)
				{
					 @extract($arryDetails);
					$strAddQuery = " where t.LocationID = '".$_SESSION['locationID']."' ";
					$SearchKey   = strtolower(trim($key));
					$strAddQuery .= ($AccountTypeID>0)?(" and t.AccountTypeID = '".$AccountTypeID."'"):("");

					
					if($SearchKey=='active' && ($SortBy=='f.Status' || $SortBy=='') ){
						$strAddQuery .= " and t.Status='Yes'"; 
					}else if($SearchKey=='inactive' && ($SortBy=='f.Status' || $SortBy=='') ){
						$strAddQuery .= " and t.Status='No'";
					}else if(!empty($Status)){
						$strAddQuery .= " and t.Status = 'Yes'";
					}			 
				     else{
					$strAddQuery .= (!empty($SearchKey))?(" and (t.AccountType like '%".$SearchKey."%') "):("");
					}
					
					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by t.AccountTypeID ");
					$strAddQuery .= (!empty($asc))?($asc):(" DESC");
					$strSQLQuery = "select t.* from f_account_type t ".$strAddQuery;
					//echo $strSQLQuery;exit;
					return $this->query($strSQLQuery, 1);
				}
 

				function addAccountType($arryDetails)
				{
				     @extract($arryDetails);
				     global $Config;
				    
				     $strSQLQuery = "INSERT INTO f_account_type SET AccountType = '".$AccountType."', Description = '".$Description."', LocationID='".$_SESSION['locationID']."',  Status = '".$Status."',  CreatedDate = '".$Config['TodayDate']."'";
							 
				     $this->query($strSQLQuery,0);
				     $AccountTypeID = $this->lastInsertId();
				     return $AccountTypeID;
				   
				}

				function updateAccountType($arryDetails)
				{
				     @extract($arryDetails);
				     global $Config;
				    
				     $strSQLQuery = "UPDATE f_account_type SET AccountType = '".$AccountType."', Description = '".$Description."', LocationID='".$_SESSION['locationID']."',  Status = '".$Status."',  UpdatedDate = '".$Config['TodayDate']."' WHERE AccountTypeID = '".$AccountTypeID."'";
							 
				     $this->query($strSQLQuery,0);
				}

				function RemoveAccountType($AccountTypeID)
				{
                                    $strSQLQuery = "INSERT INTO f_archive_account_type SELECT * FROM f_account_type WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."' AND LocationID = '".$_SESSION['locationID']."'";
                                    $this->query($strSQLQuery, 0);   
                                    $strSQLQuery = "DELETE FROM f_account_type WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."' AND LocationID = '".$_SESSION['locationID']."'"; 
                                    $this->query($strSQLQuery, 0);
                                    return 1;

				}
                
			function changeAccountTypeStatus($AccountTypeID)
			{
				$strSQLQuery = "SELECT * FROM f_account_type WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."'"; 
				$rs = $this->query($strSQLQuery);
				if(sizeof($rs))
				{
				if($rs[0]['Status']== "Yes")
					$Status="No";
				else
					$Status="Yes";

				$strSQLQuery = "UPDATE f_account_type SET Status ='$Status' WHERE AccountTypeID ='".mysql_real_escape_string($AccountTypeID)."'"; 
				$this->query($strSQLQuery,0);
				return true;
				}			
			}
/************************End Account Type Functions***********************************************************************************/		


/****************Sales/Purchases Function Start******************/	
                        
                            function getCustomerList()
                            {
                                $strSQLQuery = "Select c.Cid as custID,c.FullName as CustomerName from  s_customers c where c.Status = 'Yes' ORDER BY c.FullName ASC";

                                return $this->query($strSQLQuery, 1);

                            }
                            
                             function getVendorList()
                                {
                                    $strSQLQuery = "Select s.SuppID,s.SuppCode,s.UserName from  p_supplier s where s.Status = '1' ORDER BY s.UserName ASC";
                                    return $this->query($strSQLQuery, 1);

                                }
                                
                                function  ListUnpaidPurchaseInvoice($arryDetails)
                                {
                                        extract($arryDetails);

                                        $ModuleID = "PurchaseID"; 
					$SearchKey   = strtolower(trim($key));
					$strAddQuery = " where 1";
					
					$strAddQuery .= " and o.InvoiceID != '' and o.ReturnID = '' and o.InvoicePaid!='1' and o.Approved='1'";
                                        
                                        if(!empty($SuppCode))
                                        {
                                           $strAddQuery .= " and o.SuppCode = '".$SuppCode."'"; 
                                        }
                                        
                                        $strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.PostedDate ");
					$strAddQuery .= (!empty($asc))?($asc):(" desc");

                                        $strSQLQuery = "select (SELECT SUM(p.CreditAmnt) FROM f_payments p WHERE p.InvoiceID = o.InvoiceID) AS paidAmnt,o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid  from p_order o ".$strAddQuery;

                                         //echo "=>".$strSQLQuery;exit;   
                                        return $this->query($strSQLQuery, 1);		

                                }
				
				function  ListReceivePaymentInvoice($arryDetails)
				{
					extract($arryDetails);

					$ModuleID = "SaleID";
					$moduledd = 'Invoice';
					
					$strAddQuery = " where p.LocationID = '".$_SESSION['locationID']."'";
					$SearchKey   = strtolower(trim($key));
					

					$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
					$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");

				
					$strAddQuery .= (!empty($SearchKey))?(" and (p.".$ModuleID." like '%".$SearchKey."%' or p.PaymentDate like '%".$SearchKey."%' or p.DebitAmnt like '%".$SearchKey."%' or p.InvoiceID like '%".$SearchKey."%' or o.InvoicePaid = '".$SearchKey."' or o.CustomerName like '%".$SearchKey."%' ) " ):("");	
					$strAddQuery .= " and p.InvoiceID != '' and p.SaleID != '' and o.ReturnID='' and o.CreditID=''";
					

					$strAddQuery .= (!empty($Status))?(" and p.Status='".$Status."'"):("");
					$strAddQuery .= (!empty($InvoicePaid))?(" and p.InvoicePaid='".$InvoicePaid."'"):("");
					$strAddQuery .= ($Status=='Open')?(" and p.Approved='1'"):("");

					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by p.PaymentDate desc,p.PaymentID desc ");
					//$strAddQuery .= (!empty($asc))?($asc):("");

					$strSQLQuery = "select p.PaymentDate, p.OrderID,p.InvoiceID, p.SaleID,p.CustID,p.DebitAmnt, p.ReferenceNo,p.PaymentType,p.Currency,o.InvoicePaid,o.CustomerName from f_payments p left outer join s_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;

					//echo "=>".$strSQLQuery;exit;
					return $this->query($strSQLQuery, 1);		

				}

	
				
				function  ListSaleForPayment($arryDetails)
				{
					extract($arryDetails);

					$ModuleID = "SaleID"; 
				   
					$moduledd = 'Order';
					$strAddQuery = " where 1";
					$SearchKey   = strtolower(trim($key));
					$strAddQuery .= (!empty($module))?(" and o.Module='".$module."'"):("");
					
					if($SearchKey=='yes' && ($sortby=='o.Approved' || $sortby=='') ){
						$strAddQuery .= " and o.Approved='1'"; 
					}else if($SearchKey=='no' && ($sortby=='o.Approved' || $sortby=='') ){
						$strAddQuery .= " and o.Approved='0'";
					}else if($sortby != ''){
						$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
					}else{
						$strAddQuery .= (!empty($SearchKey))?(" and (o.".$ModuleID." like '%".$SearchKey."%'  or o.CustomerName like '%".$SearchKey."%' or o.CustCode like '%".$SearchKey."%'  or o.OrderDate like '%".$SearchKey."%' or o.TotalAmount like '%".$SearchKey."%' or o.CustomerCurrency like '%".$SearchKey."%' or o.Status like '%".$SearchKey."%' or o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' or SalesPerson like '%".$SearchKey."%' ) " ):("");	
					}

					$strAddQuery .= (!empty($Status))?(" and o.Status='".$Status."'"):("");
					$strAddQuery .= ($Status=='Open')?(" and o.Approved='1'"):("");
					
					$strAddQuery .= (" and o.SaleID != '' and o.ReturnID = ''");
					$strAddQuery .= (" group by SaleID");
					
					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
					//$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.OrderID ");
					$strAddQuery .= (!empty($asc))?($asc):(" desc");
					$strAddQuery .= (!empty($Limit))?(" limit 0, ".$Limit):("");
					
					

					$strSQLQuery = "select o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from s_order o ".$strAddQuery;
				
					//echo "=>".$strSQLQuery;
					return $this->query($strSQLQuery, 1);		
						
				}
				
				function  ListUnPaidInvoice($arryDetails)
				{
					extract($arryDetails);

					$ModuleID = "SaleID"; 
					$SearchKey   = strtolower(trim($key));
					$moduledd = 'Invoice';
					$strAddQuery = " where 1";
					
					$strAddQuery .= " and o.InvoiceID != '' and o.ReturnID = '' and o.InvoicePaid != 'Paid' and o.Approved='1'";
                                        
                                        if($custID > 0)
                                        {
                                           $strAddQuery .= " and o.CustID = '".$custID."'"; 
                                        }
					
					$strAddQuery .= (!empty($SearchKey))?(" and ( o.InvoiceID like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");	
			
					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
					$strAddQuery .= (!empty($asc))?($asc):(" desc");

					$strSQLQuery = "select (SELECT SUM(p.DebitAmnt) FROM f_payments p WHERE p.InvoiceID = o.InvoiceID) AS receivedAmnt,o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode,o.CustID, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module  from s_order o ".$strAddQuery;
				
					//echo "=>".$strSQLQuery;exit;
					return $this->query($strSQLQuery, 1);		
						
				}
                                
                   function  addIncomeInformation($arryDetails)
                    {
                            global $Config;
                            extract($arryDetails);
                            $ipaddress = $_SERVER["REMOTE_ADDR"];
                            
                             if($Method == "Check"){
                                $CheckBankName = $CheckBankName;
                                $CheckFormat = $CheckFormat;
                            }else{
                                $CheckBankName = '';
                                $CheckFormat = '';
                            }

                            $strSQLQuery = "INSERT INTO f_income SET  TotalAmount = '".$ReceivedAmount."', BankAccount = '".$PaidTo."', ReceivedFrom = '".$CustomerName."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='30',CreatedDate='".$Config['TodayDate']."', Flag =1,IPAddress='".$ipaddress."'";
                            $this->query($strSQLQuery, 0);	
                            $IncomeID = $this->lastInsertId();
                            
                            return $IncomeID;
                    }             

		function  addPaymentInformation($incomeID, $arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
                         if($Method == "Check"){
                                $CheckBankName = $CheckBankName;
                                $CheckFormat = $CheckFormat;
                            }else{
                                $CheckBankName = '';
                                $CheckFormat = '';
                            }
                            
                        for($i=1;$i<=$totalInvoice;$i++){
                            if($arryDetails['invoice_check_'.$i] == 'on' && $arryDetails['payment_amnt_'.$i] > 0){
                                $strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$arryDetails['OrderID_'.$i]."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', SaleID = '".$arryDetails['SaleID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', DebitAmnt = '".$arryDetails['payment_amnt_'.$i]."', AccountID = '".$PaidTo."',  ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);

                                $strSQLQuery = "INSERT INTO f_payments SET   DebitAmnt = '".$arryDetails['payment_amnt_'.$i]."', AccountID = '30', IncomeID = '".$incomeID."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag =1, IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);
                            }
                        
                        
                        }
                        

		}
		
		function GetSalesPaymentInvoice($oid,$inv)
		{
			$strSQLQuery = "select f.*,b.AccountName from f_payments f left outer join f_bank_account b on b.BankAccountID = f.AccountID where OrderID='".$oid."' and InvoiceID='".$inv."' order by PaymentID desc";
			return $this->query($strSQLQuery, 1);
		}
		
		function GetSalesTotalPaymentAmntForInvoice($InvoiceID)
		{
		    $strSQLQuery = "select sum(DebitAmnt) as total from f_payments where InvoiceID='".$InvoiceID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
		
		function GetSalesTotalPaymentAmntForOrder($SaleID)
		{
		    $strSQLQuery = "select sum(DebitAmnt) as total from f_payments where SaleID='".$SaleID."'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}

	 
			function  ListPaidPaymentInvoice($arryDetails)
			{
				extract($arryDetails);

				$ModuleID = "SaleID";
				$moduledd = 'Invoice';

				$strAddQuery = " where p.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));


				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");

                                    if($SearchKey == 'Paid' || $SearchKey == 'paid')
                                    {
                                        $InvoicePaid = 1;
                                    }else if($SearchKey == 'Part Paid' || $SearchKey == 'part paid')
                                    {
                                        $InvoicePaid = 2;
                                    }else{
                                        $InvoicePaid = 0;
                                    }
                                   
				$strAddQuery .= (!empty($SearchKey))?(" and (p.".$ModuleID." like '%".$SearchKey."%' or o.InvoicePaid = '".$InvoicePaid."' or p.PurchaseID like '%".$SearchKey."%'  or p.PaymentDate like '%".$SearchKey."%' or p.CreditAmnt like '%".$SearchKey."%' or p.InvoiceID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%' ) " ):("");	
				$strAddQuery .= " and p.InvoiceID != '' and p.PurchaseID != ''";


				$strAddQuery .= (!empty($Status))?(" and p.Status='".$Status."'"):("");
				//$strAddQuery .= (!empty($InvoicePaid))?(" and p.InvoicePaid='".$InvoicePaid."'"):("");
				$strAddQuery .= ($Status=='Open')?(" and p.Approved='1'"):("");

				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by p.PaymentDate desc,p.PaymentID desc ");
				//$strAddQuery .= (!empty($asc))?($asc):("");

				$strSQLQuery = "select p.PaymentDate, p.OrderID,p.InvoiceID, p.PurchaseID,o.SuppCode,p.CreditAmnt, p.ReferenceNo,p.PaymentType,p.Currency,o.InvoicePaid,o.SuppCompany from f_payments p left outer join p_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;

				//echo "=>".$strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);		

			}
		function GetPurchasesPaymentInvoice($oid,$inv)
		{
		$strSQLQuery = "select p.*,b.AccountName from f_payments p left outer join f_bank_account b on b.BankAccountID = p.AccountID where OrderID='".$oid."' and InvoiceID='".$inv."'order by PaymentID desc";
		return $this->query($strSQLQuery, 1);
		}
		function GetPurchaseTotalPaymentAmntForInvoice($InvoiceID)
		{
		    $strSQLQuery = "select sum(CreditAmnt) as total from f_payments where InvoiceID='".$InvoiceID."'";
			//echo "=>".$strSQLQuery;
		    $arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
		
		function GetPurchaseTotalPaymentAmntForOrder($PurchaseID)
		{
		    $strSQLQuery = "select sum(CreditAmnt) as total from f_payments where PurchaseID='".$PurchaseID."'";
		    $arryRow = $this->query($strSQLQuery, 1);
		   return $arryRow[0]['total'];
		
		}
                
                function GetOrderTotalPaymentAmntForPurchase($PurchaseID)
		{
		    $strSQLQuery = "select sum(TotalAmount) as total from p_order where PurchaseID='".$PurchaseID."' AND Module = 'Order'";
		    $arryRow = $this->query($strSQLQuery, 1);
		    return $arryRow[0]['total'];
		
		}
                
                 function  addExpenseInformation($arryDetails)
                    {
                            global $Config;
                            extract($arryDetails);
                            $ipaddress = $_SERVER["REMOTE_ADDR"];
                            
                            if($Method == "Check"){
                                $CheckBankName = $CheckBankName;
                                $CheckFormat = $CheckFormat;
                            }else{
                                $CheckBankName = '';
                                $CheckFormat = '';
                            }

                            $strSQLQuery = "INSERT INTO f_expense SET  TotalAmount = '".$PaidAmount."', BankAccount = '".$PaidFrom."', PaidTo = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='32',CreatedDate='".$Config['TodayDate']."', Flag =1, IPAddress='".$ipaddress."'";
                            $this->query($strSQLQuery, 0);	
                            $ExpenseID = $this->lastInsertId();	
                            
                            return $ExpenseID;
                    }  

		function  addPurchasePaymentInformation($ExpenseID,$arryDetails)
		{
			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
                        
                         if($Method == "Check"){
                                $CheckBankName = $CheckBankName;
                                $CheckFormat = $CheckFormat;
                            }else{
                                $CheckBankName = '';
                                $CheckFormat = '';
                            }
                       
                        for($i=1;$i<=$totalInvoice;$i++){
                          if($arryDetails['invoice_check_'.$i] == 'on' && $arryDetails['payment_amnt_'.$i] > 0){
                              
                                $strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$arryDetails['OrderID_'.$i]."', SuppCode = '".$SuppCode."', PurchaseID = '".$arryDetails['PurchaseID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', CreditAmnt = '".$arryDetails['payment_amnt_'.$i]."', AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 1);

                                $strSQLQueryPay = "INSERT INTO f_payments SET  DebitAmnt = '".$arryDetails['payment_amnt_'.$i]."', AccountID = '32', ExpenseID = '".$ExpenseID."', SuppCode = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= 1, IPAddress='".$ipaddress."'";
                                $this->query($strSQLQueryPay, 0);
                          }
                        
                        }
                        
                        
                       

		}

		function updatePurchaseInvoiceStatus($InvoiceID,$chk)
			{
			   
                           
                            if($chk == 1){$InvoiceStatus = 2;}else{ $InvoiceStatus = 1;}
			  
			   $strSQLQuery = "update p_order set InvoicePaid = '".$InvoiceStatus."' where InvoiceID='".$InvoiceID."'";
			   $this->query($strSQLQuery, 0);
			}
                        
                        function updateOrderStatus($PurchaseID)
			{
			   
			   $strSQLQuery = "update p_order set InvoicePaid = '1' where PurchaseID='".$PurchaseID."'";
			   $this->query($strSQLQuery, 0);
			}


			function addOtherExpense($arryDetails)
			{
				extract($arryDetails);
				global $Config;
				$ipaddress = $_SERVER["REMOTE_ADDR"]; 

				$TaxAmount = ($TaxRate*$Amount)/100;
				$TotalAmount = $Amount+$TaxAmount;

				$strSQLQuery = "INSERT INTO f_expense SET  Amount = '".$Amount."', TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = '".$TotalAmount."', BankAccount = '".$BankAccount."', PaidTo = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$ExpenseTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."'";
				$this->query($strSQLQuery, 0);	
				$ExpenseID = $this->lastInsertId();		

				/*********Add Payment Transaction**********/		
				$strSQLQueryPay = "INSERT INTO f_payments SET  CreditAmnt = '".$TotalAmount."', AccountID = '".$BankAccount."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Expense',IPAddress='".$ipaddress."'";
				$this->query($strSQLQueryPay, 0);
                                
                                $strSQLQueryPay = "INSERT INTO f_payments SET  DebitAmnt = '".$TotalAmount."', AccountID = '".$ExpenseTypeID."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Expense', Flag= 1, IPAddress='".$ipaddress."'";
				$this->query($strSQLQueryPay, 0);

			}

		function updateOtherExpense($arryDetails)
		{
			extract($arryDetails);
			global $Config;
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 

			$TaxAmount = ($TaxRate*$Amount)/100;
			$TotalAmount = $Amount+$TaxAmount;

			$strSQLQuery = "UPDATE f_expense SET  Amount = '".$Amount."', TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = '".$TotalAmount."', BankAccount = '".$BankAccount."', PaidTo = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='".$ExpenseTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."' WHERE ExpenseID = '".$ExpenseID."'";
			$this->query($strSQLQuery, 0);	

			/******Update Payment Transaction********/		
			$strSQLQueryPay = "UPDATE f_payments SET   CreditAmnt = '".$TotalAmount."', AccountID = '".$BankAccount."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Expense',IPAddress='".$ipaddress."' WHERE ExpenseID = '".$ExpenseID."' AND CreditAmnt > 0";
			$this->query($strSQLQueryPay, 0);	
                        
                        $strSQLQueryPay = "UPDATE f_payments SET   DebitAmnt = '".$TotalAmount."', AccountID = '".$ExpenseTypeID."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Expense',IPAddress='".$ipaddress."' WHERE ExpenseID = '".$ExpenseID."' AND DebitAmnt >0";
			$this->query($strSQLQueryPay, 0);	

		}

			function getOtherExpense($arryDetails)
			{
				extract($arryDetails);
                                
                                
				$strAddQuery = " where f.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($ExpenseID>0)?(" and f.ExpenseID = '".$ExpenseID."'"):("");
                                $strAddQuery .= ($Flag>0)?(" and f.Flag = 1"):(" and f.Flag != 1");
				$strAddQuery .= (!empty($FromDate))?(" and f.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and f.PaymentDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (s.FirstName like '".$SearchKey."%' or s.CompanyName like '".$SearchKey."%' or f.ReferenceNo like '%".$SearchKey."%' or f.TotalAmount like '%".$SearchKey."%') "):("");
				//$strAddQuery .= " order by f.ExpenseID Desc";
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by f.ExpenseID Desc ");

				$strSQLQuery = "select f.*, s.CompanyName,CONCAT(s.FirstName,' ',s.LastName) as supplier,b.AccountName  from f_expense f left outer join p_supplier s on BINARY s.SuppCode = BINARY f.PaidTo left outer join f_bank_account b on b.BankAccountID = f.BankAccount ".$strAddQuery;
				//echo $strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
			}

			function RemoveOtherExpense($ExpenseID)
			{
                            
                                /******************ARCHIVE RECORD*********************************/

                                $strSQLQuery = "INSERT INTO f_archive_expense SELECT * FROM f_expense WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'";
                                $this->query($strSQLQuery, 0);

                                $strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'";
                                $this->query($strSQLQuery, 0);


                                /*************************************************/
				$strSQLQuery = "DELETE FROM f_expense WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'"; 
				$this->query($strSQLQuery, 0);

				$strSQLQuery1 = "DELETE FROM f_payments WHERE ExpenseID ='".mysql_real_escape_string($ExpenseID)."'"; 
				$this->query($strSQLQuery1, 0);

				return 1;
			}


	 
/************************End Sales/Purchases Functions***********************************************************************************/			
						
                

 

/**************************Set Account Balance************************************************************/
			
		function setAccountBalance($accountid,$amount,$set)			
		 {
			$Balance = 0;
			$strSQLQuery = "SELECT Balance from f_bank_account WHERE BankAccountID ='".mysql_real_escape_string($accountid)."'";
			$rows = $this->query($strSQLQuery, 1);
			$Balance = $rows[0]['Balance'];
			 	

		    	if($set == 1)	
                         {
				$Balance = $Balance+$amount;	
				$strSQLQuery = "update f_bank_account set Balance = '".$Balance."' WHERE BankAccountID ='".mysql_real_escape_string($accountid)."'";
				$this->query($strSQLQuery, 0);
			 }
			if($set == 2)	
                         {
				$Balance = $Balance-$amount;	
				$strSQLQuery = "update f_bank_account set Balance = '".$Balance."' WHERE BankAccountID ='".mysql_real_escape_string($accountid)."'";
				$this->query($strSQLQuery, 0);
			 }
			

		 }
			

	function getAccountBalance($accountid)
	{
			$strSQLQuery = "SELECT SUM(DebitAmnt) as DbAmnt,SUM(CreditAmnt) as CrAmnt from f_payments WHERE AccountID ='".mysql_real_escape_string($accountid)."'";
			$rows = $this->query($strSQLQuery, 1);
			$DbAmnt = $rows[0]['DbAmnt'];
			$CrAmnt = $rows[0]['CrAmnt'];
				
			
                        
                        if($accountid == 7 || $accountid == 2){

                         $Balance = $CrAmnt-$DbAmnt;
                        }else{

                         $Balance = $DbAmnt-$CrAmnt;
                        }
                        
                        
                        
			return number_format($Balance,2,'.',','); 	
	}
/**************************End Account Balance************************************************************/
		 
		
        function getCustomerPaymentMethod($custID)
        {
                $strSQLQuery = "Select PaymentMethod from s_customers where Cid = '".mysql_real_escape_string($custID)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
				
		return $arryRow[0]['PaymentMethod'];
            
        }
        
         function getVendorPaymentMethod($SuppCode)
        {
                $strSQLQuery = "Select PaymentMethod from p_supplier where SuppCode = '".mysql_real_escape_string($SuppCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
				
		return $arryRow[0]['PaymentMethod'];
            
        }
	
		
		function sendSalesPaymentEmail($arryDetails)
		{
		   extract($arryDetails);
			global $Config;	
	
			if($OrderID>0){
				
				$PaymentDate = ($PaymentDate>0)?(date($Config['DateFormat'], strtotime($PaymentDate))):(NOT_SPECIFIED);
				$ReferenceNo = (!empty($ReferenceNo))? (stripslashes($ReferenceNo)): (NOT_SPECIFIED);

				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."sales_invoice_paid.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[InvoiceID]",$InvoiceID,$contents);
				$contents = str_replace("[Amount]",$ReceivedAmount,$contents);
				$contents = str_replace("[CustomerName]",$CustomerName,$contents);
				$contents = str_replace("[Method]",$Method,$contents);
				$contents = str_replace("[Date]",$PaymentDate,$contents);
				$contents = str_replace("[ReferenceNo]",$ReferenceNo,$contents);
				$contents = str_replace("[Currency]",$Currency,$contents);
				
				//$CC = "rajeev@sakshay.in";
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				//if(!empty($CC)) $mail->AddCC($CC);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Payment paid for Invoice Number ".$InvoiceID;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}

}
?>
