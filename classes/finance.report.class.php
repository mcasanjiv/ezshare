<?
class report extends dbClass
{
		//constructor
		function report()
		{
			$this->dbClass();
		} 
		
		
       

	 function getAccountTypeForProfitLossReport()
                {
        			
		    $strAddQuery .= " LocationID = '".$_SESSION['locationID']."' AND AccountTYpeID  IN (13,15,17)"; 
                    $strSQLQuery = "select t.AccountType,t.AccountTypeID from f_account_type t WHERE  ".$strAddQuery." Order By t.OrderBy";
		    //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
                
                
                
	 function getAccountTypeForBalanceSheetReport()
                {
        			
		    $strAddQuery .= " LocationID = '".$_SESSION['locationID']."' AND  AccountTYpeID  IN (16,12,8,11,9,19,14,6,7,5)"; 
                    $strSQLQuery = "select t.AccountType,t.AccountTypeID from f_account_type t WHERE  ".$strAddQuery." Order By t.OrderBy";
		    //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
               
                
		
                
                function  GetSubAccountTreeForReport($ParentID,$num,$arryDetails)
		     {
		           global $Config;
			 
		          
                 
			  $query = "SELECT * FROM f_bank_account WHERE ParentAccountID ='".$ParentID."'";
                          //echo "=>".$query."<br>";
                                  $result = mysql_query($query);
                                 $htmlAccount = '';
                                 $num=$num+20;
                            while($values = mysql_fetch_array($result)) { 
				/*$ReceivedAmnt = $values['ReceivedAmnt'];
				$PaidAmnt = $values['PaidAmnt'];
				$Balance = $ReceivedAmnt-$PaidAmnt;*/
                                
                                $Balance = $this->getAccountBalance($values['BankAccountID'],$values['AccountType'],$arryDetails);
                                
                                //echo "=>".$Balance;
                                
                                $htmlAccount = '<tr align="left" bgcolor="#ffffff">
                                 <td width="250" height="20">&nbsp;&nbsp;&nbsp;';
				$htmlAccount .= str_repeat("&nbsp;",$num);
                                $htmlAccount .= $values['AccountName'];

			 $htmlAccount .= '</td>';
                          $htmlAccount .= '<td width="200">---------------------------------------------------------------------------</td>';
                         $htmlAccount .= '<td align="right" width="50"><strong>'.number_format($Balance,2,'.','').'</strong></td>
                        </tr>';
                                  
                                  echo $htmlAccount;
                                  
                                  
                                  if($values['ParentAccountID'] > 0)
                                  {
                                    $this->GetSubAccountTreeForReport($values['BankAccountID'],$num,$arryDetails); 
                                  }
                                }  
             
		}


                
               function getTotalAmount($accountType,$arryDetails){
                   
                    global $Config;
                   extract($arryDetails);
                    
                    if($TransactionDate == "All")
                    {
                        $FromDate = '2014-01-01';
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($TransactionDate == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($TransactionDate == "Last Three Month")
                    {
                       $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                    }else{
                        
                       if(!empty($FromDate)){
                            
                            $FromDate = $FromDate;
                            $ToDate = $ToDate;
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }
                    
                    $strAddQuery .= (!empty($FromDate))?(" and f.AccountType = '".$accountType."'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= " and p.PostToGL ='Yes'";
                     
                    $strSQLQuery = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.LocationID = '".$_SESSION['locationID']."' and f.Status = 'Yes' ".$strAddQuery."";
                                     
                   //echo "=>".$strSQLQuery;
                    $arryRows = $this->query($strSQLQuery, 1);

                    $ReceivedAmnt = $arryRows[0]['ReceivedAmnt'];
                    $PaidAmnt = $arryRows[0]['PaidAmnt'];
                    
                    if($arryRows[0]['BankAccountID'] == 7 || $arryRows[0]['BankAccountID'] == 2){

                     $Balance = $PaidAmnt-$ReceivedAmnt;
                    }else{

                     $Balance = $ReceivedAmnt-$PaidAmnt;
                    }
                    
                   
                   return $Balance;
                   
               } 
               
            function getAccountBalanceForReport($accountid,$arryDetails)
            {
                global $Config;
                extract($arryDetails);
                
                if($TransactionDate == "All")
                    {
                        $FromDate = '2014-01-01';
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($TransactionDate == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($TransactionDate == "Last Three Month")
                    {
                        $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                    }else{
                        
                        if(!empty($FromDate)){
                            
                            $FromDate = $FromDate;
                            $ToDate = $ToDate;
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }
                    
                    $strAddQuery .= (!empty($FromDate))?(" WHERE f.BankAccountID = '".$accountid."'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    $strAddQuery .= " and p.PostToGL ='Yes'";
                    
                    $strSQLQuery = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName from f_bank_account f left outer join f_payments p on p.AccountID = f.BankAccountID
                         ".$strAddQuery."";
                    //echo "=>". $strSQLQuery;
                     $arryRows = $this->query($strSQLQuery, 1);

                    $ReceivedAmnt = $arryRows[0]['ReceivedAmnt'];
                    $PaidAmnt = $arryRows[0]['PaidAmnt'];
                    
                    if($accountid == 7 || $accountid == 2){

                     $Balance = $PaidAmnt-$ReceivedAmnt;
                    }else{

                    $Balance = $ReceivedAmnt-$PaidAmnt;
                    }
                    
                   
                   
                   return $Balance;
                    
            }
            
            function sendPLReport($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			

				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."email_pl_report.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				
				$contents = str_replace("[Message]",$Message,$contents);
				

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$SubjectEmail;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			

			return 1;
		}

             function sendBLReport($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			

				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."email_bl_report.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				
				$contents = str_replace("[Message]",$Message,$contents);
				

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$SubjectEmail;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			

			return 1;
		}
                
                
          /*********************CODE FOR DASHBOARD********************************************************************/
                
                function getIncomeBankAccount($id=0,$Status,$SearchKey,$SortBy,$AscDesc)
                {
                        global $Config;
                                $strAddQuery = "where f.LocationID = '".$_SESSION['locationID']."' and f.AccountTYpe = '".$id."'";

                                            $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by f.OrderBy ");
                                            $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" ASC");

						   
							

                 $strSQLQuery = "select f.*,(select SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID) as ReceivedAmnt,(select SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."'))  from f_payments p WHERE p.AccountID = f.BankAccountID) as PaidAmnt from f_bank_account f ".$strAddQuery;
		 //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                }
                
                function  GetIncomeExpByYear($FromDate,$ToDate)
		{
                    
                    global $Config;
                    $strAddQuery .= (!empty($FromDate))?(" and f.AccountType = '15'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    
                    $strSQLQuery = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.LocationID = '".$_SESSION['locationID']."' and f.Status = 'Yes' ".$strAddQuery."";
                                     
                  // echo "=>".$strSQLQuery;exit;
                    $arryRows = $this->query($strSQLQuery, 1);

                    $ReceivedAmnt = $arryRows[0]['ReceivedAmnt'];
                    $PaidAmnt = $arryRows[0]['PaidAmnt'];
                    
                    $Balance['totalIncome'] = $ReceivedAmnt-$PaidAmnt;
                 
                    
                    
                    /*************************CODE FOR EXPENSES********/
                    
                    $strAddQuery1 .= (!empty($FromDate))?(" and f.AccountType = '13'"):("");
                    $strAddQuery1 .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery1 .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    
                    $strSQLQuery1 = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.LocationID = '".$_SESSION['locationID']."' and f.Status = 'Yes' ".$strAddQuery1."";
                                     
                  // echo "=>".$strSQLQuery;exit;
                    $arryRows1 = $this->query($strSQLQuery1, 1);

                    $ReceivedAmnt1 = $arryRows1[0]['ReceivedAmnt'];
                    $PaidAmnt1 = $arryRows1[0]['PaidAmnt'];
                    
                    $Balance['totalExpense'] = $ReceivedAmnt1-$PaidAmnt1;
              
                    
                    
                    /*************************CODE FOR COST FOR GOOD SOLD********/
                    
                    $strAddQuery2 .= (!empty($FromDate))?(" and f.AccountType = '17'"):("");
                    $strAddQuery2 .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                    $strAddQuery2 .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                    
                    $strSQLQuery1 = "SELECT f.BankAccountID,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as ReceivedAmnt,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt,f.AccountName,t.AccountType,t.AccountTypeID from f_bank_account f left outer join f_account_type t on t.AccountTypeID = f.AccountType left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.LocationID = '".$_SESSION['locationID']."' and f.Status = 'Yes' ".$strAddQuery2."";
                                     
                  // echo "=>".$strSQLQuery;exit;
                    $arryRows1 = $this->query($strSQLQuery1, 1);

                    $ReceivedAmnt2 = $arryRows1[0]['ReceivedAmnt'];
                    $PaidAmnt2 = $arryRows1[0]['PaidAmnt'];
                    
                    $Balance['totalCostOfGoodSold'] = $ReceivedAmnt2-$PaidAmnt2;
                
                    
                   /*echo "<pre>";
                   print_r($Balance);exit;*/
                   return $Balance;

			
		}
                
          /*********************END DASHBOARD CODE*********************************************************/      


function getAccountBalance($accountid,$AccountType,$arrDetails)
	{
                        global $Config;
                        extract($arrDetails);
                       
                    if($TransactionDate == "All")
                    {
                        $FromDate = '2014-01-01';
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Today")
                    {
                        $FromDate = date('Y-m-d');
                        $ToDate = date('Y-m-d');
                        
                    }else if($TransactionDate == "Last Week")
                    {
                        $previous_week = strtotime("-1 week +1 day");

                        $start_week = strtotime("last sunday midnight",$previous_week);
                        $end_week = strtotime("next saturday",$start_week);

                        $start_week = date("Y-m-d",$start_week);
                        $end_week = date("Y-m-d",$end_week);
                        
                        $FromDate = $start_week;
                        $ToDate = $end_week;
                        
                    }else if($TransactionDate == "Last Month")
                    {
                        $FromDate = date("Y-m-1", strtotime("first day of previous month") );
                        $ToDate = date("Y-m-t", strtotime("last day of previous month") );
                        
                    }else if($TransactionDate == "Last Three Month")
                    {
                        $FromDate = date("Y-m-1",strtotime("-3 Months"));
                        $ToDate = date("Y-m-t",strtotime("-1 Months"));
                        
                    }else{
                        
                        if(!empty($FromDate)){
                            
                            $FromDate = $FromDate;
                            $ToDate = $ToDate;
                        }else{
                        
                           $FromDate = date('Y-m-1');
                           $ToDate = date('Y-m-d');
                        }
                    }
                    
                  
                   
                        
			$strSQLQuery = "SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) as DbAmnt,SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) as CrAmnt from f_payments WHERE AccountID ='".mysql_real_escape_string($accountid)."' AND PaymentDate>='".$FromDate."' AND PaymentDate<='".$ToDate."' AND PostToGL = 'Yes'";
                       // echo "=>".$strSQLQuery;
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
        
        
        function  SalesTaxReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status)
		{
                        global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");

			$strSQLQuery = "select o.OrderDate, o.PostedDate,o.InvoiceDate,o.InvoicePaid, o.OrderID, o.SaleID,o.CustID, o.CustCode, o.CustomerName, o.SalesPerson, o.InvoiceID,o.taxAmnt, o.TotalAmount from s_order o  where o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery." order by o.InvoiceDate desc";
				//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                
                function getCustomerTaxAmount($FilterBy,$FromDate,$ToDate,$Month,$Year,$CustCode,$Status)
		{
			 global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.InvoiceDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.InvoiceDate)='".$Month."' and YEAR(o.InvoiceDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");
			
			$strSQLQuery = "select SUM(taxAmnt) as totalTaxAmnt from s_order as o WHERE o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery;
			//echo $strSQLQuery;exit;
			$rs = $this->query($strSQLQuery, 1);
		    return $rs[0]['totalTaxAmnt'];	
		
		}
                
                function  PurchaseTaxReport($FilterBy,$FromDate,$ToDate,$Month,$Year,$SuppCode,$Status)
		{
                         global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.PostedDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.PostedDate)='".$Month."' and YEAR(o.PostedDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			if($Status == 1){
			 $strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");
                        }
                        if($Status == 2){
                            $strAddQuery .= (!empty($Status))?(" and o.InvoicePaid=''"):("");
                        }

			$strSQLQuery = "select o.OrderDate, o.PostedDate,o.InvoicePaid,o.OrderID,o.PurchaseID,o.SuppCode,o.SuppCompany,o.InvoiceID,o.taxAmnt from p_order o  where o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery." order by o.PostedDate desc";
			//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                
                function getPurchaseTaxAmount($FilterBy,$FromDate,$ToDate,$Month,$Year,$SuppCode,$Status)
		{
			 global $Config;
			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(o.PostedDate)='".$Year."'";
			}else if($FilterBy=='Month'){
				$strAddQuery .= " and MONTH(o.PostedDate)='".$Month."' and YEAR(o.PostedDate)='".$Year."'";
			}else{
				$strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
			}
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
                        if($Status == 1){
			$strAddQuery .= (!empty($Status))?(" and o.InvoicePaid='".$Status."'"):("");
                        }
                        if($Status == 2){
                            $strAddQuery .= (!empty($Status))?(" and o.InvoicePaid=''"):("");
                        }
			
			$strSQLQuery = "select SUM(taxAmnt) as totalTaxAmnt from p_order as o WHERE o.module='Invoice' and o.taxAmnt > 0 and o.ReturnID='' ".$strAddQuery;
			//echo $strSQLQuery;exit;
			$rs = $this->query($strSQLQuery, 1);
		    return $rs[0]['totalTaxAmnt'];	
		
		}
                
                function  arAgingReort($CustCode)
		{
                         global $Config;
			$strAddQuery = "";
			
			$strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
			
			$strSQLQuery = "select o.InvoicePaid, o.CustID, o.CustCode, o.CustomerName, o.InvoiceID,sum(o.TotalInvoiceAmount) as TotalInvoiceAmount ,(SELECT SUM(DECODE(DebitAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.CustID=o.CustID and p.InvoiceID !='' and  (p.PaymentType = 'Sales' or p.PaymentType = 'Other Income')) as ReceiveAmnt 
                            from s_order o  where o.module='Invoice' and o.ReturnID='' ".$strAddQuery." group by o.CustID order by o.InvoiceDate desc";
			//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                
                function  apAgingReort($SuppCode)
		{
                         global $Config;
			$strAddQuery = "";
			
			$strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
			
			$strSQLQuery = "select o.InvoicePaid,o.SuppCode, o.SuppCompany, o.InvoiceID,sum(o.TotalAmount) as TotalInvoiceAmount ,(SELECT SUM(DECODE(CreditAmnt,'". $Config['EncryptKey']."')) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and p.InvoiceID!='' and (p.PaymentType = 'Purchase' or p.PaymentType = 'Other Expense' or p.PaymentType = 'Spiff Expense')) as PaidAmnt 
                            from p_order o  where o.module='Invoice' and o.ReturnID='' ".$strAddQuery." group by o.SuppCode order by o.PostedDate desc";
			//echo "=>".$strSQLQuery;
			return $this->query($strSQLQuery, 1);		
		}
                
                function getARUnpaidInvoiceByDays($FromDate,$ToDate,$CustCode)
                {
                    global $Config;
                    $strAddQuery = "";
                    $strAddQuery .= (!empty($CustCode))?(" and o.CustCode='".$CustCode."'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and o.InvoiceDate>='".$FromDate."'"):("");
		    $strAddQuery .= (!empty($ToDate))?(" and o.InvoiceDate<='".$ToDate."'"):("");
                    
                    /*$strSQLQuery = "select sum(o.TotalInvoiceAmount) as TotalInvoiceAmount ,(SELECT SUM(DebitAmnt) FROM `f_payments` p WHERE p.CustID=o.CustID and `InvoiceID`!='' and p.PaymentDate >= '".$FromDate."' and p.PaymentDate <= '".$ToDate."') as PaidAmnt 
                        from s_order o  where o.module='Invoice' and o.ReturnID='' ".$strAddQuery." group by o.CustID order by o.InvoiceDate desc";*/
                    
                     $strSQLQuery = "select sum(o.TotalInvoiceAmount) as TotalInvoiceAmount ,SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) as PaidAmnt 
                        from s_order o left join f_payments p on p.InvoiceID = o.InvoiceID where o.module='Invoice' and o.ReturnID='' ".$strAddQuery." group by o.CustID order by o.InvoiceDate desc";
                    
                    //echo "=>".$strSQLQuery;
                     $row = $this->query($strSQLQuery, 1);
                     $totalInvoice = $row[0]['TotalInvoiceAmount'];
                     $PaidAmnt = $row[0]['PaidAmnt'];
                     if($PaidAmnt > 0)
                     {
                         $UnpaidInvoice = $totalInvoice-$PaidAmnt;
                     }else{
                         $UnpaidInvoice = $totalInvoice;
                     }
                    return $UnpaidInvoice;	
                }
                
                function getAPUnpaidInvoiceByDays($FromDate,$ToDate,$SuppCode)
                {
                    global $Config;
                    $strAddQuery = "";
                    $strAddQuery .= (!empty($SuppCode))?(" and o.SuppCode='".$SuppCode."'"):("");
                    $strAddQuery .= (!empty($FromDate))?(" and o.PostedDate>='".$FromDate."'"):("");
		    $strAddQuery .= (!empty($ToDate))?(" and o.PostedDate<='".$ToDate."'"):("");
                    /*$strSQLQuery = "select sum(o.TotalAmount) as TotalInvoiceAmount ,(SELECT SUM(CreditAmnt) FROM `f_payments` p WHERE p.SuppCode=o.SuppCode and `InvoiceID`!='' and p.PaymentDate >= '".$FromDate."' and p.PaymentDate <= '".$ToDate."') as PaidAmnt 
                        from p_order o  where o.module='Invoice' and o.ReturnID='' ".$strAddQuery." group by o.SuppCode order by o.PostedDate desc";*/
                    $strSQLQuery = "select o.SuppCode, sum(o.TotalAmount) as TotalInvoiceAmount ,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) as PaidAmnt from p_order o left join f_payments p on  p.InvoiceID = o.InvoiceID where o.module='Invoice' and o.ReturnID='' 
                            ".$strAddQuery." group by o.SuppCode order by o.PostedDate desc";
                    //echo "=>".$strSQLQuery;exit;
                     $row = $this->query($strSQLQuery, 1);
                     $totalInvoice = $row[0]['TotalInvoiceAmount'];
                     $PaidAmnt = $row[0]['PaidAmnt'];
                     if($PaidAmnt > 0)
                     {
                         $UnpaidInvoice = $totalInvoice-$PaidAmnt;
                     }else{
                         $UnpaidInvoice = $totalInvoice;
                     }
                    return $UnpaidInvoice;	
                }
                     
                
               /***********************START CODE FOR PERIOD END SETTING************************************************/ 
                
                function AddUpdatePeriodSetting($arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
                        
                        

			for($i=1;$i<=$NumLine;$i++){
                            
				if(!empty($arryDetails['PeriodYear'.$i]) && !empty($arryDetails['PeriodStatus'.$i])){
					
                                        //Get PeriodYear,PeriodMonth,PeriodModule
                                        $strSQL = "select PeriodID  from f_period_end where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$arryDetails['PeriodMonth'.$i]."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."'"; 
                                        $arryRow = $this->query($strSQL, 1);		 
                                        $PeriodID = $arryRow[0]['PeriodID'];
                                         //echo "=>".$PeriodID;exit;
                                        //end
					
					if($PeriodID>0){
						
                                                  $sql = "update f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodUpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."' where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$arryDetails['PeriodMonth'.$i]."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."'"; 
                                                  $this->query($sql, 0);
                                                       
					 }else{
                                             
                                             /*******************************************************/
                                            if($arryDetails['PeriodMonth'.$i] == "01" && $arryDetails['PeriodYear'.$i] == date('Y'))
                                            {
                                                    $sql = "insert into f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodCreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."'";
                                                    $this->query($sql, 0);

                                            }
                                            else{
                                                    $PeriodMonth = $arryDetails['PeriodMonth'.$i]-1;
                                                    if($PeriodMonth < 10)$PeriodMonth = "0".$PeriodMonth;
                                                    $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$arryDetails['PeriodYear'.$i]."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$arryDetails['PeriodModule'.$i]."' and PeriodStatus='Closed'";
                                                    //echo "=>".$strSQLQuery;exit;
                                                    $row = $this->query($strSQLQuery, 1);
                                                    if($row[0]['PeriodID'] > 0)
                                                    {
                                                    /*****************************************************/

                                                        $sql = "insert into f_period_end set PeriodYear='".$arryDetails['PeriodYear'.$i]."', PeriodMonth='".$arryDetails['PeriodMonth'.$i]."', PeriodStatus='".addslashes($arryDetails['PeriodStatus'.$i])."', PeriodModule='".$arryDetails['PeriodModule'.$i]."', PeriodCreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."'";
                                                        $this->query($sql, 0);	
                                                    //$PeriodID = $this->lastInsertId();
                                                    //return $PeriodID;
                                                    }
                                            } 
					}
					
				}
			}
		       
			return true;

		}
                
                function getPeriodFields($arryDetails)
                {
                    extract($arryDetails);
                    $strAddQuery = " where p.LocationID = '".$_SESSION['locationID']."'";
                    $SearchKey   = strtolower(trim($_GET['search']));
                    
                    if(!empty($_GET['PeriodModule'])){
                        $strAddQuery .= " and p.PeriodModule like '".$_GET['PeriodModule']."%'";
                    }
                     if(!empty($_GET['PeriodYear'])){
                        $strAddQuery .= " and p.PeriodYear like '".$_GET['PeriodYear']."%'";
                    }
                    if(!empty($_GET['PeriodMonth'])){
                        $strAddQuery .= " and p.PeriodMonth like '".$_GET['PeriodMonth']."%'";
                    }
                   
                    if($PeriodID >0 ){
                        $strAddQuery .= " and p.PeriodID = '".$PeriodID."'";
                    }
                    
                    //$strAddQuery .= (!empty($SearchKey))?(" and (p.PeriodModule like '".$_GET['PeriodModule']."%' or p.PeriodYear = '".$_GET['PeriodYear']."' or p.PeriodMonth = '".$_GET['PeriodMonth']."') "):("");
                    $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by p.PeriodID ");
                    $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" DESC");
			   
                    $strSQLQuery = "select p.* from f_period_end p  ".$strAddQuery;
                      //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                    
                }
                
                function changePeriodFieldStatus($arryDetails)
		{
                    global $Config;
                    extract($arryDetails);
                    $strSQLQuery = "UPDATE f_period_end SET PeriodStatus ='".$PeriodStatus."',PeriodUpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."' WHERE PeriodID ='".mysql_real_escape_string($active_id)."'"; 
                    $this->query($strSQLQuery,0);
                    return true;
				 			
		}
                
                function RemovePeriodField($PeriodID)
		{
		
			$strSQLQuery = "delete from f_period_end where PeriodID = '".$PeriodID."'"; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}
                
                function getCurrentPeriod($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and  LocationID='".$_SESSION['locationID']."' and PeriodStatus='Closed' order by PeriodYear desc,PeriodMonth desc LIMIT 0, 1 ";
                    $row = $this->query($strSQLQuery, 1);
                   
                    $lastMonth = $row[0]['PeriodMonth'];
                    
                    
                    if(empty($lastMonth)){
                        $monthName = "January";
                        $lastYear = date('Y');
                    }else{
                    
                        if($lastMonth < 12){
                            $monthNum  = 1+$lastMonth;
                            $lastYear = $row[0]['PeriodYear'];
                        }else{
                            $monthNum  = 13-$lastMonth;
                            $lastYear = 1+$row[0]['PeriodYear'];
                        }
                        
                        $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        $monthName = $dateObj->format('F'); // March 
                    }
                    
                   
                    
                    $currentPeriod = "Current Period ".$monthName." ".$lastYear;
                    return $currentPeriod;
                    
                }
                
                 function getCurrentPeriodDate($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and LocationID='".$_SESSION['locationID']."' and PeriodStatus='Closed' order by PeriodYear desc,PeriodMonth desc LIMIT 0, 1 ";
                    $row = $this->query($strSQLQuery, 1);
                   
                    $lastMonth = $row[0]['PeriodMonth'];
                    
                    
                    if(empty($lastMonth)){
                        $monthNum = 01;
                        $lastYear = date('Y');
                    }else{
                    
                        if($lastMonth < 12){
                            $monthNum  = 1+$lastMonth;
                            $lastYear = $row[0]['PeriodYear'];
                        }else{
                            $monthNum  = 13-$lastMonth;
                            $lastYear = 1+$row[0]['PeriodYear'];
                        }
                        
                       // $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                        //$monthName = $dateObj->format('F'); // March 
                    }
                    
                   
                    if($monthNum < 10)$monthNum = "0".$monthNum;
                    $currentPeriod = $lastYear."-".$monthNum."-01";
                    return $currentPeriod;
                    
                }
                
                 function getBackOpenMonth($moduleName)
                {
                    $strSQLQuery = "select * from f_period_end where PeriodModule = '".$moduleName."' and PeriodStatus='Open' and LocationID='".$_SESSION['locationID']."'";
                    return $this->query($strSQLQuery, 1);
                   
                    
                    
                }
                
                function CheckPeriodSettings($PeriodYear,$PeriodMonth,$PeriodStatus,$PeriodModule)
                {
                    if($PeriodMonth == "01" && $PeriodYear == date('Y'))
                    {
                         $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                         $row = $this->query($strSQLQuery, 1);
                         if($row[0]['PeriodID'] > 0)
                            {
                                $returnStr = "This month already closed for ".$PeriodModule.".";
                            }else{
                                $returnStr = 1;
                            }
                            return $returnStr;
                       
                    }
                    else{
                        
                         $strSQLQuery2 = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                         $row2 = $this->query($strSQLQuery2, 1);
                         if($row2[0]['PeriodID'] > 0)
                            {
                                $returnStr = "This month already closed for ".$PeriodModule.".";
                            }else{
                        
                                    $PeriodMonth = $PeriodMonth-1;
                                    if($PeriodMonth < 10)$PeriodMonth = "0".$PeriodMonth;
                                    $strSQLQuery = "select PeriodID from f_period_end where PeriodYear='".$PeriodYear."' and PeriodMonth='".$PeriodMonth."' and LocationID='".$_SESSION['locationID']."' and PeriodModule='".$PeriodModule."' and PeriodStatus='Closed'";
                                    //echo "=>".$strSQLQuery;exit;
                                    $row = $this->query($strSQLQuery, 1);
                                    if($row[0]['PeriodID'] > 0)
                                    {
                                        $returnStr = 1;
                                    }else{
                                        $returnStr = "Please closed all previous months for ".$PeriodModule.".";
                                    }
                                    
                          }  
                          
                          return $returnStr;
                        }
                  
                    
                }

            /***********************END CODE FOR PERIOD END SETTING************************************************/    
                
                
                
                
                
           /************************START CODE FOR BANK Reconciliation**************************************************************/  
                
             function getTransactionForReconciliation($FromDate,$ToDate,$AccountID)
             {
                     global $Config;   
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
                     $strAddQuery .= " and p.PostToGL ='Yes' order by PaymentDate desc,PaymentID desc";
                     
                    $strSQLQuery = "SELECT f.BankAccountID,p.PaymentID,p.PaymentDate,p.PaymentType,DECODE(p.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt,DECODE(p.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt,f.AccountName from f_bank_account f left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.LocationID = '".$_SESSION['locationID']."' ".$strAddQuery."";
                    
                    //echo "=>".$strSQLQuery;
                    return $this->query($strSQLQuery, 1);
             }
             
              function getTotalForReconciliation($FromDate,$ToDate,$AccountID)
             {
                     global $Config;
                     $strAddQuery = "";
                     $strAddQuery .= (!empty($FromDate))?(" and p.PaymentDate>='".$FromDate."'"):("");
                     $strAddQuery .= (!empty($ToDate))?(" and p.PaymentDate<='".$ToDate."'"):("");
                     $strAddQuery .= (!empty($AccountID))?(" and p.AccountID='".$AccountID."'"):("");
                     $strAddQuery .= " and p.PostToGL ='Yes' order by PaymentDate desc,PaymentID desc";
                     
                    $strSQLQuery = "SELECT SUM(DECODE(p.DebitAmnt,'". $Config['EncryptKey']."')) AS totalDebit,SUM(DECODE(p.CreditAmnt,'". $Config['EncryptKey']."')) AS totalCredit from f_bank_account f left outer join f_payments p on p.AccountID = f.BankAccountID
                        WHERE f.LocationID = '".$_SESSION['locationID']."' ".$strAddQuery."";
                    
                    //echo "=>".$strSQLQuery;
                    return $this->query($strSQLQuery, 1);
             }
                
            function AddMonthReconciliation($arryDetails)
            {
                         extract($arryDetails); 
                         global $Config;
                         $ipaddress = $_SERVER["REMOTE_ADDR"];
                         
                         $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID='".$AccountID."' and LocationID='".$_SESSION['locationID']."'";
                         $row = $this->query($strSQLQuery, 1);
                         
                         if($row[0]['ReconcileID'] > 0)
                         {
                            $strAddQuery = "update f_reconcile set Year='".$Year."', Month='".$Month."',AccountID='".$AccountID."', Status='".$Status."', EndingBankBalance = '".$EndingBankBalance."',TotalDebitByCheck = '".$TotalDebitByCheck."',TotalCreditByCheck='".$TotalCreditByCheck."',TotalDebitCreditByCheck='".$TotalDebitCreditByCheck."',
                                UpdateDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."' WHERE ReconcileID ='".$row[0]['ReconcileID']."'";
                            $this->query($strAddQuery, 0);
                            $ReconcileID = $row[0]['ReconcileID'];
                             
                         }else{
                         
                            $strAddQuery = "insert into f_reconcile set Year='".$Year."', Month='".$Month."',AccountID='".$AccountID."', Status='".$Status."', EndingBankBalance = '".$EndingBankBalance."',TotalDebitByCheck = '".$TotalDebitByCheck."',TotalCreditByCheck='".$TotalCreditByCheck."',TotalDebitCreditByCheck='".$TotalDebitCreditByCheck."',
                                CreatedDate='".$Config['TodayDate']."',LocationID='".$_SESSION['locationID']."',IPAddress='".$ipaddress."'";
                            $this->query($strAddQuery, 0);
                            $ReconcileID = $this->lastInsertId();
                         }
                         
                         return $ReconcileID;
            }
            
            function AddMonthReconciliationTransaction($arryDetails,$ReconcileID)
            {
                
                global $Config;
                extract($arryDetails);
                
                if(!empty($ReconcileID)){
                            $strSQLQuery = "delete from f_reconcile_transaction WHERE ReconcileID ='".$ReconcileID."'";
                            $this->query($strSQLQuery, 0);
			}
                        
                        for($i=1;$i<=$totalChecked;$i++){
                         if($arryDetails['Reconcil_'.$i] > 0){
                            $strAddQuery = "insert into f_reconcile_transaction set ReconcileID='".$ReconcileID."', PaymentID='".$arryDetails['Reconcil_'.$i]."'";
                            $this->query($strAddQuery, 0);
                         }
                        }

                
            }
            
            function getReconciliationMonths($arryDetails)
            {
                
                extract($arryDetails);
                    $strAddQuery = " where r.LocationID = '".$_SESSION['locationID']."'";
                    $SearchKey   = strtolower(trim($_GET['search']));
               
                    if(!empty($RYear)){
                        $strAddQuery .= " and r.Year like '".$RYear."%'";
                    }
                    if(!empty($RMonth)){
                        $strAddQuery .= " and r.Month like '".$RMonth."%'";
                    }
                     if(!empty($RAccountID)){
                        $strAddQuery .= " and r.AccountID like '".$RAccountID."%'";
                    }
                   
                    if($ReconcileID >0 ){
                        $strAddQuery .= " and r.ReconcileID = '".$ReconcileID."'";
                    }
                    
                    //$strAddQuery .= (!empty($SearchKey))?(" and (p.PeriodModule like '".$_GET['PeriodModule']."%' or p.PeriodYear = '".$_GET['PeriodYear']."' or p.PeriodMonth = '".$_GET['PeriodMonth']."') "):("");
                    $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by r.ReconcileID ");
                    $strAddQuery .= (!empty($AscDesc))?($AscDesc):(" DESC");
			   
                    $strSQLQuery = "select r.* from f_reconcile r  ".$strAddQuery;
                    //echo $strSQLQuery;exit;
                    return $this->query($strSQLQuery, 1);
                
            }
            
            function CheckReconcilMonth($Year,$Month,$editID,$AccountID)
            {
                if($editID > 0){
                 $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID = '".$AccountID."' and LocationID='".$_SESSION['locationID']."' and Status='Reconciled' and ReconcileID != '".$editID."'";
                }else{
                    $strSQLQuery = "select ReconcileID from f_reconcile where Year='".$Year."' and Month='".$Month."' and AccountID = '".$AccountID."' and LocationID='".$_SESSION['locationID']."' and Status='Reconciled'";
                }
               
                 $row = $this->query($strSQLQuery, 1);
                 return $row[0]['ReconcileID'];
            }
            
            function RemoveMonthReconciliation($ReconcileID)
            {
                $strSQLQuery = "delete from f_reconcile where ReconcileID = '".$ReconcileID."'"; 
                $this->query($strSQLQuery, 0);
                
               $strSQLQuery2 = "delete from f_reconcile_transaction where ReconcileID = '".$ReconcileID."'"; 
              $this->query($strSQLQuery2, 0);

               
            }
            
            function checkPaymentIDExist($PaymentID)
            {
                $strSQLQuery = "select PaymentID from f_reconcile_transaction where PaymentID='".$PaymentID."'";
                $row = $this->query($strSQLQuery, 1);
                return $row[0]['PaymentID'];
            }
            function getMonthReconcil($ReconcileID)
            {
                 $strSQLQuery = "select * from f_reconcile where ReconcileID='".$ReconcileID."'";
                 return $this->query($strSQLQuery, 1);
                
            }
           /***********************END CODE FOR Reconciliation****************************************************************/     
}

?>
