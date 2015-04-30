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
                        global $Config;
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

$strSQLQuery = "select f.*,(select SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID AND p.PostToGL = 'Yes') as PaidAmnt,t.AccountType as Type from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType ".$strAddQuery;
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
                           $history = $Config['history'];
                           
                           //$query = "select f.*,(select SUM(DebitAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as ReceivedAmnt,(select SUM(CreditAmnt)  from f_payments p WHERE p.AccountID = ".$ParentID." AND p.PostToGL = 'Yes') as PaidAmnt, from f_bank_account f WHERE f.ParentAccountID ='".$ParentID."'";
			  $query = "SELECT * FROM f_bank_account WHERE ParentAccountID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $num=$num+5;
                                 $Balance =0;
                            while($values = mysql_fetch_array($result)) { 
				/*$ReceivedAmnt = $values['ReceivedAmnt'];
				$PaidAmnt = $values['PaidAmnt'];
				$Balance = $ReceivedAmnt-$PaidAmnt;*/
                                
                              $Balance = $this->getAccountBalance($values['BankAccountID'],$values['AccountType']);
                                
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
                            
			        <a href="vAccount.php?view='.$values['BankAccountID'].'&curP='.$_GET['curP'].'">'.$view.'</a>';	
                                 if($Balance == 0 && $values['CashFlag'] != 1) {    
                                $htmlAccount .= '<a href="editAccount.php?edit='.$values['BankAccountID'].'&ParentID='.$values['ParentAccountID'].'&curP='.$_GET['curP'].'" class="Blue">'.$edit.'</a>&nbsp;&nbsp;';
                                 
                                    $htmlAccount .= '<a href="editAccount.php?del_id='.$values['BankAccountID'].'&curP='.$_GET['curP'].'&ParentID='.$values['ParentAccountID'].'" onclick="return confDel('.$cat_title.')" class="Blue" >'.$delete.'</a>';
                                 }
                $htmlAccount .= '<a href="accountHistory.php?accountID='.$values['BankAccountID'].'&accountType='.$values['AccountType'].'" target="_blank">'.$history.'</a>';				
                                

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
                                global $Config;
				$strAddQuery = "where p.PostToGL = 'Yes'";
				$SearchKey   = strtolower(trim($SearchKey));
				$strAddQuery .= ($BankAccountID>0)?(" and (p.AccountID = '".$BankAccountID."')"):("");
				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
			        $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                               
                                 
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FullName like '".$SearchKey."%' or p.ReferenceNo like '%".$SearchKey."%' or p.PaymentType like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by p.PaymentID ASC";

				$strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, c.Company as custCompany,CONCAT(c.FirstName,' ',c.LastName) as CustomerName,b.AccountName,CONCAT(s.FirstName,' ',s.LastName) as SupplierName,s.CompanyName as suppCompany from f_payments p left outer join s_customers c on c.Cid = p.CustID left outer join f_bank_account b on b.BankAccountID = p.AccountID left outer join p_supplier s on  BINARY s.SuppCode = BINARY p.SuppCode ".$strAddQuery;
				//echo $strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);
		}
		
		function addTransfer($arryDetails)
		{
                        global $Config;
			extract($arryDetails);
			
			$ipaddress = $_SERVER["REMOTE_ADDR"]; 	
			
			$strSQLQuery = "INSERT INTO f_transfer SET  TransferAmount = ENCODE('".$TransferAmount."','".$Config['EncryptKey']."'), TransferFrom = '".$TransferFrom."', TransferTo = '".$TransferTo."', ReferenceNo = '".addslashes($ReferenceNo)."',TransferDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);	
			$TransferID = $this->lastInsertId();

		if($TransferFrom > 0){
			$strSQLQuery = "INSERT INTO f_payments SET  CreditAmnt = ENCODE('".$TransferAmount."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$TransferFrom."', TransferID = '".$TransferID."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Transfer',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			}

		if($TransferTo > 0){
			$strSQLQuery = "INSERT INTO f_payments SET  DebitAmnt = ENCODE('".$TransferAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$TransferTo."', TransferID = '".$TransferID."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$TransferDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Transfer',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			}
		
		}

		function getTransfer($arryDetails)
			{
                                global $Config;
				extract($arryDetails);
				
				$strAddQuery = " where t.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($TransferID>0)?(" and t.TransferID = '".$TransferID."'"):("");
                                $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
				$strAddQuery .= (!empty($FromDate))?(" and t.TransferDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and t.TransferDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (t.ReferenceNo like '%".$SearchKey."%' or DECODE(t.TransferAmount,'". $Config['EncryptKey']."') like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by t.TransferID Desc";

				$strSQLQuery = "select t.*,DECODE(t.TransferAmount,'". $Config['EncryptKey']."') as TransferAmount, b.AccountName as TransferFrom,ba.AccountName as TransferTo from f_transfer t left outer join f_bank_account b on b.BankAccountID = t.TransferFrom left outer join f_bank_account ba on ba.BankAccountID = t.TransferTo ".$strAddQuery;
				//echo $strSQLQuery;
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
                         global $Config;
			extract($arryDetails);
			
			$strAddQuery = " where d.LocationID = '".$_SESSION['locationID']."'";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= ($DepositID>0)?(" and d.DepositID = '".$DepositID."'"):("");
                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
			$strAddQuery .= (!empty($FromDate))?(" and d.DepositDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and d.DepositDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($SearchKey))?(" and (d.ReferenceNo like '%".$SearchKey."%' or DECODE(d.Amount,'". $Config['EncryptKey']."') like '%".$SearchKey."%') "):("");
			$strAddQuery .= " order by d.DepositID Desc";

			$strSQLQuery = "select d.*,DECODE(d.Amount,'". $Config['EncryptKey']."') as Amount, b.AccountName,CONCAT(c.FirstName,' ',c.LastName) as Customer  from f_deposit d left outer join f_bank_account b on b.BankAccountID = d.AccountID left outer join s_customers c on c.Cid = d.ReceivedFrom ".$strAddQuery;
			//echo $strSQLQuery;
			return $this->query($strSQLQuery, 1);
		     }
		
		function addBankDeposit($arryDetails)
		{
			 extract($arryDetails);
			 global $Config;
			 $ipaddress = $_SERVER["REMOTE_ADDR"]; 
			
		$strSQLQuery = "INSERT INTO f_deposit SET  AccountID = '".$AccountID."', Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), ReferenceNo = '".$ReferenceNo."',DepositDate = '".$DepositDate."', ReceivedFrom = '".$ReceivedFrom."', PaymentMethod = '".$Method."', Comment = '".$Comment."', 
Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', CreatedDate='".$Config['TodayDate']."', IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
			$DepositID = $this->lastInsertId();
			

			$strSQLQuery = "INSERT INTO f_payments SET  DebitAmnt = ENCODE('".$Amount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$AccountID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', DepositID = '".$DepositID."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', PaymentDate = '".$DepositDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Deposit',IPAddress='".$ipaddress."'";
			$this->query($strSQLQuery, 0);
                        
                        $strSQLQueryPay = "INSERT INTO f_payments SET  DebitAmnt = ENCODE('".$Amount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '19', DepositID = '".$DepositID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', PaymentDate = '".$DepositDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income', Flag= 1, IPAddress='".$ipaddress."'";
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
				
			$strSQLQueryPay = "INSERT INTO f_payments SET SaleID='".addslashes($ReferenceNo)."', DebitAmnt = '".$TotalAmount."', AccountID = '".$BankAccount."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income',IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);
                        $PID = $this->lastInsertId();
                        
                        $strSQLQueryPay = "INSERT INTO f_payments SET  PID='".$PID."', DebitAmnt = '".$TotalAmount."', AccountID = '".$IncomeTypeID."', IncomeID = '".$IncomeID."', CustID = '".$ReceivedFrom."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Other Income', Flag= 1, IPAddress='".$ipaddress."'";
			$this->query($strSQLQueryPay, 0);
                        
                         if(empty($InvoiceID)){
                                     $InvoiceID = 'INVE'.$PID;
                                }

                        $sql="UPDATE f_payments SET InvoiceID='".$InvoiceID."' WHERE PaymentID='".$PID."'";
                        $this->query($sql,0);	

                        $strSQLQuery = "update f_income SET PID='".$PID."',InvoiceID='".$InvoiceID."' where IncomeID = '".$IncomeID."'";
                        $this->query($strSQLQuery, 0);
		
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
                                global $Config;
				extract($arryDetails);
				
				$strAddQuery = " where f.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($IncomeID>0)?(" and f.IncomeID = '".$IncomeID."'"):("");
                                 $strAddQuery .= ($Flag>0)?(" and f.Flag = 1"):(" and f.Flag != 1");
				$strAddQuery .= (!empty($FromDate))?(" and f.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and f.PaymentDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (c.FirstName like '".$SearchKey."%' or f.ReferenceNo like '%".$SearchKey."%' or f.TotalAmount like '%".$SearchKey."%') "):("");
				$strAddQuery .= " order by f.IncomeID Desc";

				$strSQLQuery = "select f.*,DECODE(f.Amount ,'". $Config['EncryptKey']."') as Amount,DECODE(f.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount, c.Company,CONCAT(c.FirstName,' ',c.LastName) as Customer,b.AccountName  from f_income f left outer join s_customers c on c.Cid = f.ReceivedFrom left outer join f_bank_account b on b.BankAccountID = f.BankAccount ".$strAddQuery;
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
                                    $strSQLQuery = "Select s.SuppID,s.SuppCode,s.UserName,CompanyName from  p_supplier s where s.Status = '1' ORDER BY s.UserName ASC";
                                    return $this->query($strSQLQuery, 1);

                                }
                                
                                function  ListUnpaidPurchaseInvoice($arryDetails)
                                {
                                        global $Config;
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

                                        $strSQLQuery = "select (SELECT SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) FROM f_payments p WHERE p.InvoiceID = o.InvoiceID) AS paidAmnt,o.OrderType, o.OrderDate, o.PostedDate, o.OrderID, o.PurchaseID, o.QuoteID, o.InvoiceID, o.SuppCode, o.SuppCompany, o.TotalAmount, o.Currency,o.InvoicePaid,o.InvoiceEntry  from p_order o ".$strAddQuery;

                                         //echo "=>".$strSQLQuery;exit;   
                                        return $this->query($strSQLQuery, 1);		

                                }
				
				function  ListReceivePaymentInvoice($arryDetails)
				{
					global $Config;
                                       extract($arryDetails);

					$ModuleID = "SaleID";
					$moduledd = 'Invoice';
					
					$strAddQuery = " where p.LocationID = '".$_SESSION['locationID']."'";
					$SearchKey   = strtolower(trim($key));
					

					$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
					$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                                      
                                        if($SearchKey == "partially paid"){$SearchKey = "part paid";}
					
				if($sortby != ''){
					$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
				}else{
					$strAddQuery .= (!empty($SearchKey))?(" and (p.".$ModuleID." like '%".$SearchKey."%' or p.PaymentDate like '%".$SearchKey."%' or p.DebitAmnt like '%".$SearchKey."%' or p.InvoiceID like '%".$SearchKey."%' or o.InvoicePaid = '".$SearchKey."' or o.CustomerName like '%".$SearchKey."%' ) " ):("");
				}



	                                $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
					//$strAddQuery .= " and p.InvoiceID != '' and p.SaleID != '' and o.ReturnID='' and o.CreditID=''";
					$strAddQuery .= " and p.InvoiceID != '' and (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')";

					$strAddQuery .= (!empty($Status))?(" and p.Status='".$Status."'"):("");
					$strAddQuery .= (!empty($InvoicePaid))?(" and p.InvoicePaid='".$InvoicePaid."'"):("");
					$strAddQuery .= ($Status=='Open')?(" and p.Approved='1'"):("");

					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by p.PaymentDate desc,p.PaymentID desc ");
					//$strAddQuery .= (!empty($asc))?($asc):("");

					#$strSQLQuery = "select p.,o.InvoicePaid,o.CustomerName,o.InvoiceEntry from f_payments p left outer join s_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;
                                     $strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, o.InvoicePaid,o.CustomerName,o.InvoiceEntry from f_payments p left outer join s_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;
				//echo "=>".$strSQLQuery;

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
                                        global $Config;
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
					
					$strAddQuery .= (!empty($SearchKey))?(" and ( o.InvoiceID like '%".$SearchKey."%' or o.CustomerName like '%".$SearchKey."%' or o.SalesPerson like '%".$SearchKey."%' or o.TotalInvoiceAmount like '%".$SearchKey."%' or o.SaleID like '%".$SearchKey."%' ) " ):("");	
			
					$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by o.".$moduledd."Date ");
					$strAddQuery .= (!empty($asc))?($asc):(" desc");

					$strSQLQuery = "select (SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) FROM f_payments p WHERE p.InvoiceID = o.InvoiceID) AS receivedAmnt,o.OrderDate, o.InvoiceDate, o.PostedDate, o.OrderID, o.SaleID, o.QuoteID, o.CustCode,o.CustID, o.CustomerName, o.SalesPerson, o.CustomerCompany, o.TotalAmount, o.Status,o.Approved,o.CustomerCurrency,o.InvoiceID,o.InvoicePaid,o.TotalInvoiceAmount,o.Module,o.InvoiceEntry from s_order o ".$strAddQuery;
				
					//echo "=>".$strSQLQuery;exit;
					return $this->query($strSQLQuery, 1);		
						
				}
                                
                  /* function  addIncomeInformation($arryDetails)
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
                    } */            

		function  addPaymentInformation($arryDetails)
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
                                
                                $strSQLQuery = "INSERT INTO f_income SET  InvoiceID='".$arryDetails['InvoiceID_'.$i]."', Amount = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), TotalAmount = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), BankAccount = '".$PaidTo."', ReceivedFrom = '".$CustomerName."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', IncomeTypeID='30',CreatedDate='".$Config['TodayDate']."', Flag =1,IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);	
                                $incomeID = $this->lastInsertId();

                                $strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$arryDetails['OrderID_'.$i]."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', SaleID = '".$arryDetails['SaleID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', DebitAmnt = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidTo."',  ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales',IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);
                                $PID = $this->lastInsertId(); 


                                $strSQLQuery = "INSERT INTO f_payments SET PID='".$PID."',  DebitAmnt = ENCODE('" .$arryDetails['payment_amnt_'.$i]. "','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '30', IncomeID = '".$incomeID."', CustID = '".$CustomerName."', CustCode = '".$CustCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."',EntryType='".$EntryType."',GLCode='".addslashes($GLCode)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Sales', Flag =1, IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);

                                $strSQLQuery = "update f_income SET PID='".$PID."' where IncomeID = '".$incomeID."'";
                                $this->query($strSQLQuery, 0);
                            }
                        
                        
                        }
                        
                         
		}
		
		function GetSalesPaymentInvoice($oid,$inv)
		{
                         global $Config;
			$strSQLQuery = "select f.*,DECODE(f.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(f.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt, b.AccountName from f_payments f left outer join f_bank_account b on b.BankAccountID = f.AccountID where OrderID='".$oid."' and InvoiceID='".$inv."' order by PaymentID desc";
			return $this->query($strSQLQuery, 1);
		}
		
		function GetSalesTotalPaymentAmntForInvoice($InvoiceID)
		{
                        global $Config;
		        $strSQLQuery = "select sum(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as total from f_payments where InvoiceID='".$InvoiceID."' and PaymentType = 'Sales'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
		
		function GetSalesTotalPaymentAmntForOrder($SaleID)
		{
                       global $Config;
		       $strSQLQuery = "select sum(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as total from f_payments where SaleID='".$SaleID."' and PaymentType = 'Sales'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
               
	 
			function  ListPaidPaymentInvoice($arryDetails)
			{
                                global $Config;
				extract($arryDetails);

				$ModuleID = "SaleID";
				$moduledd = 'Invoice';

				$strAddQuery = " where p.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));


				$strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");

                                    if($SearchKey == 'paid')
                                    {
                                        $InvoicePaid = 1;
                                    }else if($SearchKey == "partially paid" || $SearchKey == 'part paid' )
                                    {
                                        $InvoicePaid = 2;
                                    }else{
                                        $InvoicePaid = 0;
                                    }
                                $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
				$strAddQuery .= (!empty($SearchKey))?(" and (p.".$ModuleID." like '%".$SearchKey."%' or o.InvoicePaid = '".$InvoicePaid."' or p.PurchaseID like '%".$SearchKey."%'  or p.PaymentDate like '%".$SearchKey."%' or p.CreditAmnt like '%".$SearchKey."%' or p.InvoiceID like '%".$SearchKey."%' or o.SuppCompany like '%".$SearchKey."%' ) " ):("");	
				//$strAddQuery .= " and p.InvoiceID != '' and p.PurchaseID != ''";
                                $strAddQuery .= " and p.InvoiceID != '' and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense')";

				$strAddQuery .= (!empty($Status))?(" and p.Status='".$Status."'"):("");
				//$strAddQuery .= (!empty($InvoicePaid))?(" and p.InvoicePaid='".$InvoicePaid."'"):("");
				$strAddQuery .= ($Status=='Open')?(" and p.Approved='1'"):("");

				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by p.PaymentDate desc,p.PaymentID desc ");
				//$strAddQuery .= (!empty($asc))?($asc):("");

				#$strSQLQuery = "select p.PaymentID,p.PostToGL,p.PaymentType,p.ExpenseID, p.PaymentDate, p.OrderID,p.InvoiceID, p.PurchaseID,p.SuppCode,p.CreditAmnt, p.ReferenceNo,p.PaymentType,p.Currency,o.InvoiceEntry,o.InvoicePaid,o.SuppCompany from f_payments p left outer join p_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;
                                $strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,o.InvoiceEntry,o.InvoicePaid,o.SuppCompany from f_payments p left outer join p_order o on o.InvoiceID = p.InvoiceID ".$strAddQuery;
				#echo "=>".$strSQLQuery;exit;
				return $this->query($strSQLQuery, 1);		

			}
		function GetPurchasesPaymentInvoice($oid,$inv)
		{
                    global $Config;
                    $strSQLQuery = "select p.*,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,b.AccountName from f_payments p left outer join f_bank_account b on b.BankAccountID = p.AccountID where OrderID='".$oid."' and InvoiceID='".$inv."'order by PaymentID desc";
                    return $this->query($strSQLQuery, 1);
		}
		function GetPurchaseTotalPaymentAmntForInvoice($InvoiceID)
		{
                    global $Config;
		    $strSQLQuery = "select sum(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as total from f_payments where InvoiceID='".$InvoiceID."' and PaymentType='Purchase'";
			//echo "=>".$strSQLQuery;exit;
		    $arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
		
		function GetPurchaseTotalPaymentAmntForOrder($PurchaseID)
		{
                    global $Config;
		    $strSQLQuery = "select sum(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as total from f_payments where PurchaseID='".$PurchaseID."' AND PaymentType='Purchase'";
                    //echo "=>".$strSQLQuery;exit;
		    $arryRow = $this->query($strSQLQuery, 1);
		   return $arryRow[0]['total'];
		
		}
                
                function GetOrderTotalPaymentAmntForPurchase($PurchaseID)
		{
		    $strSQLQuery = "select sum(TotalAmount) as total from p_order where PurchaseID='".$PurchaseID."' AND Module = 'Order'";
		    $arryRow = $this->query($strSQLQuery, 1);
		    return $arryRow[0]['total'];
		
		}
                
                function GetOrderTotalPaymentAmntForSale($SaleID)
		{
		    $strSQLQuery = "select sum(TotalAmount) as total from s_order where SaleID='".$SaleID."' AND Module = 'Order'";
		    $arryRow = $this->query($strSQLQuery, 1);
		    return $arryRow[0]['total'];
		
		}
                
                function getSpiffData($SaleID)
		{
		    $strSQLQuery = "select Spiff,SpiffContact,SpiffAmount from s_order where SaleID='".$SaleID."' AND Module = 'Order'";
		    return $this->query($strSQLQuery, 1);
		     
		
		}
                
                
                 /*function  addExpenseInformation($arryDetails)
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
                    }*/  

		function  addPurchasePaymentInformation($arryDetails)
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
                              
                                //$strSQLQuery = "INSERT INTO f_expense SET  TotalAmount = '".$arryDetails['payment_amnt_'.$i]."', BankAccount = '".$PaidFrom."', PaidTo = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='32',CreatedDate='".$Config['TodayDate']."', Flag =1, IPAddress='".$ipaddress."'";
                                $strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$arryDetails['InvoiceID_'.$i]."', OrderID='".$arryDetails['OrderID_'.$i]."', Amount = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'), TotalAmount = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'), BankAccount = '".$PaidFrom."', PaidTo = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '".$Config['Currency']."', LocationID='".$_SESSION['locationID']."', ExpenseTypeID='32',CreatedDate='".$Config['TodayDate']."', Flag =1, IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 0);	
                                $ExpenseID = $this->lastInsertId();	
                              
                                $strSQLQuery = "INSERT INTO f_payments SET  OrderID = '".$arryDetails['OrderID_'.$i]."', SuppCode = '".$SuppCode."', PurchaseID = '".$arryDetails['PurchaseID_'.$i]."', InvoiceID='".$arryDetails['InvoiceID_'.$i]."', CreditAmnt = ENCODE('".$arryDetails['payment_amnt_'.$i]."','".$Config['EncryptKey']."'),DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$PaidFrom."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."',Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', IPAddress='".$ipaddress."'";
                                $this->query($strSQLQuery, 1);
                                $PID = $this->lastInsertId();
                                

                                $strSQLQueryPay = "INSERT INTO f_payments SET PID='".$PID."', DebitAmnt = ENCODE('".$arryDetails['payment_amnt_'.$i]."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '32', ExpenseID = '".$ExpenseID."', SuppCode = '".$SuppCode."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($Method)."', CheckBankName='".addslashes($CheckBankName)."', CheckFormat='".$CheckFormat."', PaymentDate = '".$Date."', Comment = '".addslashes($Comment)."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Purchase', Flag= 1, IPAddress='".$ipaddress."'";
                                $this->query($strSQLQueryPay, 0);
                                
                                $strSQLQuery = "update f_expense SET PID='".$PID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0);	
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

                        function  GetSupplier($SuppID,$SuppCode,$Status)
                        {
                            $strSQLQuery = "select s.*,ab.Address, ab.Country,ab.State, ab.City,  ab.ZipCode from p_supplier s left outer join p_address_book ab ON (s.SuppID = ab.SuppID and ab.AddType = 'contact' and ab.PrimaryContact='1') ";

                            #$strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".$SuppID."'"):(" and s.locationID=".$_SESSION['locationID']);
                            $strSQLQuery .= (!empty($SuppID))?(" where s.SuppID='".mysql_real_escape_string($SuppID)."'"):(" where 1");
                            $strSQLQuery .= (!empty($SuppCode))?(" and s.SuppCode='".mysql_real_escape_string($SuppCode)."'"):("");
                            $strSQLQuery .= ($Status>0)?(" and s.Status='".$Status."'"):("");

                            return $this->query($strSQLQuery, 1);
                        }	

			function addOtherExpense($arryDetails)
			{
				extract($arryDetails);
				global $Config;
				$ipaddress = $_SERVER["REMOTE_ADDR"]; 
                                
                        
                                
                                if($Config['CronEntry']==1){ //cron entry
                                        $EntryType = 'one_time';
                                        $InvoiceID = '';	
                                        $Currency = $Currency;
                                        $PaymentDate = $Config['TodayDate'];
                                        $MultiPaymentData = $Config['arryGLAccountData'];
                                }else{

                                        $TaxAmount = ($TaxRate*$Amount)/100;
                                        if($TaxAmount > 0){
                                            $TotalAmount = $Amount+$TaxAmount;
                                        }else{
                                             $TotalAmount = $Amount;
                                        }
                                        
                                        $Currency = $Config['Currency'];
                                        
                                        $CreatedBy  = addslashes($_SESSION['UserName']);
                                        $AdminID  = $_SESSION['AdminID'];
                                        $AdminType  = $_SESSION['AdminType'];
                                        $LocationID = $_SESSION['locationID'];
                                
                             }
                                
                                
                                 if($EntryType == 'one_time'){$EntryDate=0;$EntryFrom='';$EntryTo='';$EntryInterval='';$EntryMonth=''; $EntryWeekly = '';}
                                 
                                if($EntryInterval == 'monthly'){$EntryMonth='';$EntryWeekly = '';}
                                if($EntryInterval == 'yearly'){$EntryWeekly = '';}
                                if($EntryInterval == 'weekly'){$EntryDate = 0;$EntryMonth = '';}
                                if($EntryInterval == 'semi_monthly'){$EntryDate = 0;$EntryMonth='';$EntryWeekly = '';}
                                 
                                 
                                $supplierData =  $this->GetSupplier('',$PaidTo,'');
                                
                                  if(!empty($InvoiceEntry)){$InvoiceEntry = $InvoiceEntry;}else{$InvoiceEntry = 2;}
                                      
                                 
                                   $strSQLQueryPO = "insert into p_order set Module='Invoice',
                                        PurchaseID = '".addslashes($ReferenceNo)."',
                                        InvoiceID  = '".$InvoiceID."',
                                        Approved  = '1',
                                        Comment  = '".addslashes(strip_tags($Comment))."',
                                        SuppCode  = '".addslashes($supplierData[0]['SuppCode'])."',
                                        SuppCompany  = '".addslashes($supplierData[0]['CompanyName'])."',  
                                        SuppContact  = '".addslashes($supplierData[0]['SuppContact'])."',   
                                        Address  = '".addslashes($supplierData[0]['Address'])."',   
                                        City  = '".addslashes($supplierData[0]['City'])."',
                                        State  = '".addslashes($supplierData[0]['State'])."',
                                        Country  = '".addslashes($supplierData[0]['Country'])."',
                                        ZipCode  = '".addslashes($supplierData[0]['ZipCode'])."',   
                                        Currency  = '".$Currency."',
                                        SuppCurrency  = '".addslashes($supplierData[0]['SuppCurrency'])."',
                                        Mobile  = '".addslashes($supplierData[0]['Mobile'])."',
                                        Landline  = '".addslashes($supplierData[0]['Landline'])."',
   
                                        Fax  = '".addslashes($supplierData[0]['Fax'])."',
                                        Email  = '".addslashes($supplierData[0]['Email'])."',
                                         
                                        TotalAmount  = '".addslashes($TotalAmount)."',
                                       
                                        CreatedBy  = '".$CreatedBy."',
                                        AdminID  = '".$AdminID."', 
                                        AdminType  = '".$AdminType."',
                                        PostedDate  = '".$Config['TodayDate']."',
                                        UpdatedDate  = '".$Config['TodayDate']."',
                                        InvoiceComment  = '".addslashes(strip_tags($InvoiceComment))."',
                                        PaymentMethod  = '".addslashes($PaymentMethod)."',
                                        ShippingMethod  = '".addslashes($ShippingMethod)."', 
                                        PaymentTerm  = '".addslashes($PaymentTerm)."',
                                        AssignedEmpID  = '".addslashes($EmpID)."',
                                        AssignedEmp  = '".addslashes($EmpName)."',
                                        Taxable  = '".addslashes($Taxable)."',
                                        InvoiceEntry='".$InvoiceEntry."',InvoicePaid='1',EntryType='".$EntryType."',
                                        EntryInterval='".$EntryInterval."',
                                        EntryMonth='".$EntryMonth."',   
                                        EntryWeekly = '".$EntryWeekly."',      
                                        EntryFrom='".$EntryFrom."',
                                        EntryTo='".$EntryTo."',
                                        EntryDate='".$EntryDate."'";

                                  
                                    $this->query($strSQLQueryPO, 0);
                                    $OrderID = $this->lastInsertId();
                                 
                                 
				$strSQLQuery = "INSERT INTO f_expense SET  InvoiceID  = '".$InvoiceID."', OrderID='".$OrderID."', Amount = ENCODE('".$Amount."','".$Config['EncryptKey']."'), TaxID = '".$TaxID."',TaxRate='".$TaxRate."', TotalAmount = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), BankAccount = '".$BankAccount."', PaidTo = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', PaymentMethod= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', ExpenseTypeID='".$ExpenseTypeID."',CreatedDate='".$Config['TodayDate']."',IPAddress='".$ipaddress."',EntryType='".$EntryType."', EntryInterval='".$EntryInterval."',EntryMonth='".$EntryMonth."', EntryWeekly = '".$EntryWeekly."', EntryFrom='".$EntryFrom."',EntryTo='".$EntryTo."',EntryDate='".$EntryDate."',GlEntryType='".$GlEntryType."'";
                                
                                
				$this->query($strSQLQuery, 0);	
				$ExpenseID = $this->lastInsertId();		

				/*********Add Payment Transaction**********/
                                
				$strSQLQueryPay = "INSERT INTO f_payments SET  InvoiceID  = '".$InvoiceID."', OrderID='".$OrderID."', PurchaseID='".addslashes($ReferenceNo)."', CreditAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$BankAccount."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Spiff Expense',IPAddress='".$ipaddress."'";
				$this->query($strSQLQueryPay, 0);
                                $PID = $this->lastInsertId();
                                
                                if($GlEntryType == "Single"){
                                    $strSQLQueryPay = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$TotalAmount."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$ExpenseTypeID."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Spiff Expense', Flag= 1, IPAddress='".$ipaddress."'";
                                    $this->query($strSQLQueryPay, 0);
                                }else{
                                    
                                   if($Config['CronEntry']==1){
                                       
                                       foreach($MultiPaymentData as $value){
                                           
                                           $strSQLQueryPayMul = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$value['Amount']."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$value['AccountID']."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Other Expense', Flag= 1, IPAddress='".$ipaddress."'";
                                           $this->query($strSQLQueryPayMul, 0);

                                            $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account_payment SET  AccountID='".$value['AccountID']."', AccountName = '".$value['AccountName']."', Amount = ENCODE('".$value['Amount']."','".$Config['EncryptKey']."'),  ExpenseID = '".$ExpenseID."'";
                                            $this->query($strSQLQueryPayMulAcc, 0);
                                           
                                       }
                                       
                                    
                                   }else{
                                            for($i=1;$i<=$NumLine1;$i++){
                                                if($arryDetails['GlAmnt'.$i] > 0 && !empty($arryDetails['AccountID'.$i])){
                                                    $strSQLQueryPayMul = "INSERT INTO f_payments SET  PID='".$PID."',  DebitAmnt = ENCODE('".$arryDetails['GlAmnt'.$i]."', '".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), AccountID = '".$arryDetails['AccountID'.$i]."', ExpenseID = '".$ExpenseID."', SuppCode = '".$PaidTo."', ReferenceNo = '".addslashes($ReferenceNo)."', Method= '".addslashes($PaymentMethod)."', PaymentDate = '".$PaymentDate."', Comment = '".addslashes($Comment)."', Currency = '".$Currency."', LocationID='".$LocationID."', PaymentType='Other Expense', Flag= 1, IPAddress='".$ipaddress."'";
                                                    $this->query($strSQLQueryPayMul, 0);

                                                    $strSQLQueryPayMulAcc = "INSERT INTO f_multi_account_payment SET  AccountID='".$arryDetails['AccountID'.$i]."', AccountName = '".$arryDetails['AccountName'.$i]."', Amount = ENCODE('".$arryDetails['GlAmnt'.$i]."','".$Config['EncryptKey']."'),  ExpenseID = '".$ExpenseID."'";
                                                    $this->query($strSQLQueryPayMulAcc, 0);
                                                }
                                            }
                                    
                                   } 
                                }
                                
                                
                                if(empty($InvoiceID)){
                                     $InvoiceID = 'INV000'.$OrderID;
                                
                                $strSQL = "update p_order set InvoiceID ='".$InvoiceID."' where OrderID='".$OrderID."'"; 
				$this->query($strSQL, 0);
                                
                                $sql="UPDATE f_payments SET InvoiceID='".$InvoiceID."' WHERE PaymentID='".$PID."'";
                                $this->query($sql,0);	
                                
                                $strSQLQuery = "update f_expense SET PID='".$PID."',InvoiceID='".$InvoiceID."' where ExpenseID = '".$ExpenseID."'";
                                $this->query($strSQLQuery, 0);
                                }

                                 $strSQLUp = "update p_order set ExpenseID ='".$ExpenseID."' where OrderID='".$OrderID."'"; 
				 $this->query($strSQLUp, 0);
                              
                                    
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
                                global $Config;
                                
				$strAddQuery = " where f.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				$strAddQuery .= ($ExpenseID>0)?(" and f.ExpenseID = '".$ExpenseID."'"):("");
                                //$strAddQuery .= ($Flag>0)?(" and f.Flag = 1"):(" and f.Flag != 1");
				$strAddQuery .= (!empty($FromDate))?(" and f.PaymentDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and f.PaymentDate<='".$ToDate."'"):("");
				$strAddQuery .= (!empty($SearchKey))?(" and (s.FirstName like '".$SearchKey."%' or s.CompanyName like '".$SearchKey."%' or f.ReferenceNo like '%".$SearchKey."%' or f.TotalAmount like '%".$SearchKey."%') "):("");
				//$strAddQuery .= " order by f.ExpenseID Desc";
				$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc." "):(" order by f.ExpenseID Desc ");

				$strSQLQuery = "select f.*,DECODE(f.Amount ,'". $Config['EncryptKey']."') as Amount,DECODE(f.TotalAmount,'". $Config['EncryptKey']."') as TotalAmount, s.CompanyName,CONCAT(s.FirstName,' ',s.LastName) as supplier,b.AccountName  from f_expense f left outer join p_supplier s on BINARY s.SuppCode = BINARY f.PaidTo left outer join f_bank_account b on b.BankAccountID = f.BankAccount ".$strAddQuery;
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
			

	function getAccountBalance($accountid,$AccountType)
	{
			$strSQLQuery = "SELECT SUM(DebitAmnt) as DbAmnt,SUM(CreditAmnt) as CrAmnt from f_payments WHERE AccountID ='".mysql_real_escape_string($accountid)."' AND PostToGL = 'Yes'";
                        //echo "=>".$strSQLQuery;exit;
			$rows = $this->query($strSQLQuery, 1);
			$DbAmnt = $rows[0]['DbAmnt'];
			$CrAmnt = $rows[0]['CrAmnt'];
				
			
                        $Balance = 0;
                        if($AccountType == 19 || $AccountType == 14){

                         $Balance = floatval($CrAmnt)-floatval($DbAmnt);
                        }else{

                         $Balance = floatval($DbAmnt)-floatval($CrAmnt);
                        }
                        
                        
                        
			return $Balance; 	
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
        
        function getSupplierName($SuppCode)
        {
                $strSQLQuery = "Select SuppID,UserName,CompanyName from p_supplier where SuppCode = '".mysql_real_escape_string($SuppCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
                
                if(!empty($arryRow[0]['CompanyName']))
                {
                    $SupplierName = $arryRow[0]['CompanyName'];
                }else{
                   $SupplierName = $arryRow[0]['UserName'];
                }
                
		return $SupplierName;
            
        }
        
         function getCustomerName($CustCode)
        {
                $strSQLQuery = "Select FullName from s_customers where CustCode = '".mysql_real_escape_string($CustCode)."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
                
                $FullName = $arryRow[0]['FullName'];
                
		return $FullName;
            
        }
        
        function GetSalesTotalPaymentAmntForOrderAfterPostGL($SaleID)
		{
		        $strSQLQuery = "select sum(DebitAmnt) as total from f_payments where SaleID='".$SaleID."' and PostToGL = 'Yes' and PaymentType = 'Sales'";
			$arryRow = $this->query($strSQLQuery, 1);
			return $arryRow[0]['total'];
		
		}
        
        function commonPostToGL($paymentID,$SaleID,$InvoiceEntry)
        {
            global $Config;
            $strSQLQuery = "update f_payments set PostToGL = 'Yes',PostToGLDate='".$Config['TodayDate']."' WHERE PaymentID ='".mysql_real_escape_string($paymentID)."' OR PID = '".mysql_real_escape_string($paymentID)."'";
            $this->query($strSQLQuery, 0);
            
            if($InvoiceEntry != 1){
                $postGLOrderAmnt = $this->GetSalesTotalPaymentAmntForOrderAfterPostGL($SaleID);

                return $postGLOrderAmnt;
            }
            
        }
        
        function isInvoiceNumberExists($InvoiceID)
		{
			
			$strSQLQuery = "SELECT ExpenseID from f_expense where InvoiceID = '".trim($InvoiceID)."'";

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['ExpenseID'])) {
				return true;
			} else {
				return false;
			}
		}	
                
            function isInvoiceNumberExistsForIncome($InvoiceID)
		{
			
			$strSQLQuery = "SELECT IncomeID from f_income where InvoiceID = '".trim($InvoiceID)."'";

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['IncomeID'])) {
				return true;
			} else {
				return false;
			}
		}	     
                
                function getMultiAccount($ExpenseID)
                {
                       global $Config;
                       $strSQLQuery = "SELECT f.*,DECODE(f.Amount,'". $Config['EncryptKey']."') as Amount from f_multi_account_payment f where f.ExpenseID = '".trim($ExpenseID)."'";
                      
		       $arryRow = $this->query($strSQLQuery, 1);
                    return $arryRow;
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
                
                
    /****************Recurring Function Satrt************************************/  
       function RecurringGlAccount(){       
          global $Config;
	  $Config['CronEntry']=1;
          $arryDate = explode(" ", $Config['TodayDate']);
   	  $arryDay = explode("-", $arryDate[0]);

	  $Month = (int)$arryDay[1];
	  $Day = $arryDay[2];	
	
	  $Din = date("l",strtotime($arryDate[0]));

	  $strSQLQuery = "select o.*,e.ExpenseID,e.ExpenseTypeID,e.BankAccount,e.Amount,e.TaxID,e.TaxRate,e.TotalAmount,e.Currency,e.LocationID,e.PaidTo,e.ReferenceNo,e.Comment,e.Flag,e.GlEntryType
              from p_order o left outer join f_expense e on o.OrderID = e.OrderID where o.InvoiceEntry=2 and o.Module='Invoice' and o.InvoiceID != '' and o.ReturnID = '' and o.EntryType ='recurring' and o.EntryFrom<='".$arryDate[0]."' and o.EntryTo>='".$arryDate[0]."' ";
          $arryInvoice = $this->myquery($strSQLQuery, 1);
                  
          //echo "=>".$strSQLQuery;exit;
          /*echo "<pre>";
          print_r($arryInvoice);
          exit;*/
	
	  foreach($arryInvoice as $value){
		$OrderFlag=0;
               
		switch($value['EntryInterval']){
			case 'biweekly':
				$NumDay = 0;
				if($value['LastRecurringEntry']>0){
					$NumDay = (strtotime($arryDate[0]) - strtotime($value['LastRecurringEntry']))/(24*3600);	
				}			
				
				if($value['EntryWeekly']==$Din && ($NumDay==0 || $NumDay>10)){
					$OrderFlag=1;
				}
				break;
			case 'semi_monthly':
				if($Day=="01" || $Day=="15"){
					$OrderFlag=1;
				}
				break;
			case 'monthly':
				if($value['EntryDate']==$Day){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['EntryDate']==$Day && $value['EntryMonth']==$Month){
					$OrderFlag=1;
				}
				break;		
		
		}
		

		if($OrderFlag==1){
			//echo $value['OrderID'].'<br>';
                        //echo $value['ExpenseID'].'<br>';
                       
			/*$NumLine = 0;
                        
                        if($value['GlEntryType'] == "Single"){
                           $arryPayments = $this->GetPaymentEntry($value['OrderID']);
                        }
			$NumLine = sizeof($arryPayments);*/
                        
                        if($value['ExpenseID'] > 0){
                            $arryGLAccountData = $this->GetMultiGLAccount($value['ExpenseID']);
                         }
                        
                         $Config['arryGLAccountData']=$arryGLAccountData;
                        
                        
                        
			if($value['OrderID'] > 0){		
                            
                           
				$order_id = $this->addOtherExpense($value);
                                
				$strSQL = "update p_order set LastRecurringEntry ='" . $Config['TodayDate'] . "' where OrderID='" . $value['OrderID'] . "'";
				$this->myquery($strSQL, 0);
		
			}


		}


	  }
       	  return true;
   }
   
   
    function GetMultiGLAccount($ExpenseID){
       
          $strSQLQuery = "select m.* from f_multi_account_payment m where m.ExpenseID = '".$ExpenseID."'";
          return $this->myquery($strSQLQuery, 1);

       
   }
   
   function GetPaymentEntry($OrderID){
       
          $strSQLQuery = "select p.* from f_payments p where p.OrderID = '".$OrderID."'";
          $arryRow =  $this->myquery($strSQLQuery, 1);
          
          if(sizeof($arryRow) > 0){
             foreach($arryRow as $value){ 
                $strSQLQuery = "select p.* from f_payments p where p.PID = '".$value['PaymentID']."'";
                $arryRowNew =  $this->myquery($strSQLQuery, 1);
             }
          }
          
          return array_merge($arryRow,$arryRowNew);
       
   }
   

}
?>
