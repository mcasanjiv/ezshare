<?php

class journal extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function journal(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}


                function ListGerenalJournal($arryDetails)
                {
				extract($arryDetails);
				$strAddQuery = " where j.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				
				$strAddQuery .= (!empty($FromDate))?(" and j.JournalDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and j.JournalDate<='".$ToDate."'"):("");
					
					 if($SortBy != ''){
						$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
					}			 
				 	  else{
				               $strAddQuery .= (!empty($SearchKey))?(" and (j.JournalNo like '".$SearchKey."%') "):("");
					}

					

					$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by j.JournalID ");
					$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" DESC");

						   
					$strSQLQuery = "select j.* from f_gerenal_journal j  ".$strAddQuery;
					//echo $strSQLQuery;exit;
					return $this->query($strSQLQuery, 1);
                }

		
		function isJournalNoExists($JournalNo)
				{
					$strSQLQuery = "SELECT JournalID FROM f_gerenal_journal WHERE JournalNo ='".trim($JournalNo)."'";
					$arryRow = $this->query($strSQLQuery, 1);

					if (!empty($arryRow[0]['JournalID'])) {
						return true;
					} else {
						return false;
					}
				}


		function addJournal($arryDetails,$journalPrefix)
		{

			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
		
			if($JournalType == 'one_time'){$JournalStartDate=0;}

			$strSQLQuery = "INSERT INTO f_gerenal_journal SET JournalNo = '".$JournalNo."', JournalDate='".$JournalDate."',JournalType='".$JournalType."', JournalDateFrom = '".$JournalDateFrom."', JournalDateTo='".$JournalDateTo."', JournalStartDate='".$JournalStartDate."', JournalMemo='".$JournalMemo."', TotalDebit = '".$TotalDebit."', TotalCredit = '".$TotalCredit."', LocationID='".$_SESSION['locationID']."', Currency='". $Config['Currency']."', CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."'";
			 
			$this->query($strSQLQuery,0);
			$JournalID = $this->lastInsertId();

			//update journal no
			
			if(empty($arryDetails['JournalNo'])){

				$JournalNoValue = $journalPrefix.'000'.$JournalID;
				$strSQL = "update f_gerenal_journal set JournalNo = '".$JournalNoValue."' where JournalID='".$JournalID."'"; 
				$this->query($strSQL, 0);
			}

			//end

			return $JournalID;	
		}


		function updateJournal($arryDetails,$journalPrefix)
		{

			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
		        if($JournalType == 'one_time'){$JournalStartDate=0;}
			$strSQLQuery = "update f_gerenal_journal SET  JournalDate='".$JournalDate."',JournalType='".$JournalType."', JournalDateFrom = '".$JournalDateFrom."', JournalDateTo='".$JournalDateTo."', JournalStartDate='".$JournalStartDate."', JournalMemo='".$JournalMemo."', TotalDebit = '".$TotalDebit."', TotalCredit = '".$TotalCredit."', LocationID='".$_SESSION['locationID']."', Currency='". $Config['Currency']."', UpdatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."' where JournalID='".$JournalID."'";
			 
			$this->query($strSQLQuery,0);
			 
 	
		}



		function AddUpdateJournalEntry($JournalID, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];

			if(!empty($DelItem)){
				$strSQLQuery = "delete from f_gerenal_journal_entry where JournalEntryID in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
		 

				//Get Journal No.
				$strSQL = "select JournalNo,JournalDate from f_gerenal_journal where JournalID='".$JournalID."'"; 
				$arryRow = $this->query($strSQL, 1);		 
				$JournalNo = $arryRow[0]['JournalNo'];
				$JournalDate = $arryRow[0]['JournalDate'];
				//end

			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['AccountID'.$i])){
					
					$JournalEntryID = $arryDetails['JournalEntryID'.$i];
					
					
					 
					if($JournalEntryID>0){
						
					     if(!empty($arryDetails['EntityType'.$i]))
						{	
                                                 
						  $sql = "update f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', AccountName='".addslashes($arryDetails['AccountName'.$i])."', DebitAmnt='".$arryDetails['DebitAmnt'.$i]."', CreditAmnt='".$arryDetails['CreditAmnt'.$i]."', EntityType='".addslashes($arryDetails['EntityType'.$i])."', EntityName='".addslashes($arryDetails['EntityName'.$i])."', EntityID='".addslashes($arryDetails['EntityID'.$i])."' where JournalEntryID='".$JournalEntryID."'"; 
                                                  $this->query($sql, 0);
                                                  
                                                  
                                                  //Add Payment Transaction

                                                if($arryDetails['EntityType'.$i] == 'customer'){
                                                      $addSubQuery = "CustID = '".$arryDetails['EntityID'.$i]."'";

                                                      }else if($arryDetails['EntityType'.$i] == 'supplier'){

                                                       $addSubQuery = "SuppCode = '".$arryDetails['EntityID'.$i]."'";

                                                      }else{  $addSubQuery = "EmployeeID = '".$arryDetails['EntityID'.$i]."'"; }

                                                  if(intval($arryDetails['DebitAmnt'.$i]) > 0){

                                                  //$objBankAccount->setAccountBalance($arryDetails['AccountID'.$i],$arryDetails['DebitAmnt'.$i],1);

                                                  $strSQLQuery = "UPDATE f_payments SET  ".$addSubQuery.", AccountName ='".addslashes($arryDetails['AccountName'.$i])."',  AccountID='".addslashes($arryDetails['AccountID'.$i])."', DebitAmnt = '".$arryDetails['DebitAmnt'.$i]."', ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."',  UpdatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."' WHERE JournalID='".$JournalID."' AND DebitAmnt >0";

                                                  }

                                                  if(intval($arryDetails['CreditAmnt'.$i]) > 0){

                                                  //$objBankAccount->setAccountBalance($arryDetails['AccountID'.$i],$arryDetails['CreditAmnt'.$i],2);

                                                    $strSQLQuery = "UPDATE f_payments SET  ".$addSubQuery.", AccountName ='".addslashes($arryDetails['AccountName'.$i])."', JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', CreditAmnt = '".$arryDetails['CreditAmnt'.$i]."', ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."',  UpdatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."' WHERE JournalID='".$JournalID."' AND CreditAmnt > 0";

                                                  }

                                                  $this->query($strSQLQuery, 0);
					
				                //End Payment Transaction
						
                                                  
                                               }
                                                
                                                else{
                                                  $sql = "update f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', AccountName='".addslashes($arryDetails['AccountName'.$i])."', DebitAmnt='".$arryDetails['DebitAmnt'.$i]."', CreditAmnt='".$arryDetails['CreditAmnt'.$i]."' where JournalEntryID='".$JournalEntryID."'"; 
                                                  $this->query($sql, 0);
                                                  
                                                  //Add Payment Transaction
                                                  
                                                   if(intval($arryDetails['DebitAmnt'.$i]) > 0){

                                                  //$objBankAccount->setAccountBalance($arryDetails['AccountID'.$i],$arryDetails['DebitAmnt'.$i],1);

                                                   $strSQLQuery = "UPDATE f_payments SET  AccountName ='".addslashes($arryDetails['AccountName'.$i])."',  AccountID='".addslashes($arryDetails['AccountID'.$i])."', DebitAmnt = '".$arryDetails['DebitAmnt'.$i]."', ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', UpdatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."' WHERE JournalID='".$JournalID."' AND DebitAmnt >0";
                                                 

                                                  }

                                                  if(intval($arryDetails['CreditAmnt'.$i]) > 0){

                                                  //$objBankAccount->setAccountBalance($arryDetails['AccountID'.$i],$arryDetails['CreditAmnt'.$i],2);

                                                    $strSQLQuery = "UPDATE f_payments SET  AccountName ='".addslashes($arryDetails['AccountName'.$i])."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', CreditAmnt = '".$arryDetails['CreditAmnt'.$i]."', ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."',  LocationID='".$_SESSION['locationID']."', UpdatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."' WHERE JournalID='".$JournalID."' AND CreditAmnt >0";

                                                  }

                                                  $this->query($strSQLQuery, 0);
					
				                     //End Payment Transaction
					         }	
					
                                                 
                                          	       

					}else{
		
						$sql = "insert into f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', AccountName='".addslashes($arryDetails['AccountName'.$i])."', DebitAmnt='".$arryDetails['DebitAmnt'.$i]."', CreditAmnt='".$arryDetails['CreditAmnt'.$i]."', EntityType='".addslashes($arryDetails['EntityType'.$i])."', EntityName='".addslashes($arryDetails['EntityName'.$i])."', EntityID='".addslashes($arryDetails['EntityID'.$i])."'";
                                                $this->query($sql, 0);	
                                                
                                         //Add Payment Transaction

				          if($arryDetails['EntityType'.$i] == 'customer'){
						$addSubQuery = "CustID = '".$arryDetails['EntityID'.$i]."'";

						}else if($arryDetails['EntityType'.$i] == 'supplier'){

						 $addSubQuery = "SuppCode = '".$arryDetails['EntityID'.$i]."'";

						}else{  $addSubQuery = "EmployeeID = '".$arryDetails['EntityID'.$i]."'"; }
				
                                            if(intval($arryDetails['DebitAmnt'.$i]) > 0){

                                            //$objBankAccount->setAccountBalance($arryDetails['AccountID'.$i],$arryDetails['DebitAmnt'.$i],1);

                                            $strSQLQuery = "INSERT INTO f_payments SET  ".$addSubQuery.", AccountName ='".addslashes($arryDetails['AccountName'.$i])."', JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', DebitAmnt = '".$arryDetails['DebitAmnt'.$i]."', ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry',  CreatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."'";

                                            }

                                            if(intval($arryDetails['CreditAmnt'.$i]) > 0){

                                            //$objBankAccount->setAccountBalance($arryDetails['AccountID'.$i],$arryDetails['CreditAmnt'.$i],2);

                                            $strSQLQuery = "INSERT INTO f_payments SET  ".$addSubQuery.", AccountName ='".addslashes($arryDetails['AccountName'.$i])."', JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', CreditAmnt = '".$arryDetails['CreditAmnt'.$i]."', ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry',  CreatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."'";

                                            }

                                            $this->query($strSQLQuery, 0);
					
				        //End Payment Transaction	
                                        
					}
					


				

				}
			}
		       
			return true;

		}

	function AddJournalAttachment($JournalID,$arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			$strSQLQuery = "insert into f_gerenal_journal_attachment set JournalID='".$JournalID."', AttachmentNote='".addslashes($arryDetails['AttachmentNote'])."', CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."'";
		 

			$this->query($strSQLQuery,1);
			$AttachmentID = $this->lastInsertId();

			return $AttachmentID;

		}


		function UpdateJournalAttachment($AttachmentID,$AttachmentName,$arryDetails)
		{  
			 
			$strSQLQuery = "UPDATE f_gerenal_journal_attachment SET AttachmentFile='".addslashes($AttachmentName)."' WHERE AttachmentID = '".mysql_real_escape_string($AttachmentID)."'";
			 $this->query($strSQLQuery, 0);

		}


	function RemoveJournalEntry($JournalID)
		{

			/******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal SELECT * FROM f_gerenal_journal WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);


			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal_attachment SELECT * FROM f_gerenal_journal_attachment WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal_entry SELECT * FROM f_gerenal_journal_entry WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);


			/*************************************************/

			$strSQLQuery = "DELETE FROM f_gerenal_journal WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "select AttachmentID,AttachmentFile FROM f_gerenal_journal_attachment WHERE JournalID= '".mysql_real_escape_string($JournalID)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			$AttachmentDir = 'upload/journal/'.$_SESSION['CmpID'].'/';
	
			/**************************************************************/
			$MainDir = "upload/journal_archive/".$_SESSION['CmpID']."/";	

			if (!is_dir($MainDir)) {
				mkdir($MainDir);
				chmod($MainDir,0777);
			}


			/**************************************************************************/

			for($i=0;$i<sizeof($arryRow);$i++) {
				if($arryRow[$i]['AttachmentFile'] !='' && file_exists($AttachmentDir.$arryRow[$i]['AttachmentFile']) ){

					$AttachmentDestination = $MainDir.$arryRow[$i]['AttachmentFile'];

					if (copy($AttachmentDir.$arryRow[$i]['AttachmentFile'],$AttachmentDestination)) {
						  unlink($AttachmentDir.$arryRow[$i]['AttachmentFile']);	
					}

                                 
				}

				
			}

			 

			$strSQLQuery = "DELETE FROM f_gerenal_journal_attachment WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "DELETE FROM f_gerenal_journal_entry WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery1 = "DELETE FROM f_payments WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery1, 0);
			 
		}		


	function RemoveJournalAttachment($id)
		{

			$strSQLQuery = "select AttachmentID,AttachmentFile FROM f_gerenal_journal_attachment WHERE AttachmentID= '".mysql_real_escape_string($id)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			$AttachmentDir = 'upload/journal/'.$_SESSION['CmpID'].'/';

			if($arryRow[0]['AttachmentFile'] !='' && file_exists($AttachmentDir.$arryRow[0]['AttachmentFile']) )
			{							
				unlink($AttachmentDir.$arryRow[0]['AttachmentFile']);	
			}

			$strSQLQuery = "DELETE FROM f_gerenal_journal_attachment WHERE AttachmentID ='".mysql_real_escape_string($id)."'"; 
			$this->query($strSQLQuery, 0);
			return 1;
		}		



	function getJournalById($JournalID)
	{
		$strSQLQuery = "Select * from f_gerenal_journal where JournalID = '".mysql_real_escape_string($JournalID)."'";	
		return $this->query($strSQLQuery, 1);
		
	}	

	function GetJournalEntry($JournalID)
	{
		$strSQLQuery = "Select * from f_gerenal_journal_entry where JournalID = '".mysql_real_escape_string($JournalID)."' order by JournalEntryID asc";	
		return $this->query($strSQLQuery, 1);
		
	}	

	function GetJournalAttachment($JournalID)
	{
		$strSQLQuery = "Select * from f_gerenal_journal_attachment where JournalID = '".mysql_real_escape_string($JournalID)."'";	
		return $this->query($strSQLQuery, 1);
		
	}	


		
	function getCustomerList()
	{
		$strSQLQuery = "Select c.Cid as EntityID,CONCAT(c.FirstName,' ', c.LastName) as EntityName from  s_customers c where c.Status = 'Yes'";
				
		return $this->query($strSQLQuery, 1);
		
	}

	function getSupplierList()
	{
		$strSQLQuery = "Select s.SuppCode as EntityID,CONCAT(s.FirstName,' ',s.LastName) as EntityName from  p_supplier s where s.Status = '1'";
				
		return $this->query($strSQLQuery, 1);
		
	}
	
	function getEmployeeList()
	{
		$strSQLQuery = "Select e.EmpID as EntityID,CONCAT(e.FirstName,' ',e.LastName) as EntityName from h_employee e where e.Status = '1'";
				
		return $this->query($strSQLQuery, 1);
		
	}

	function getEntityName($EntityID,$EntityType)
	{

		if($EntityType == "customer"){
	         $strSQLQuery = "Select CONCAT(c.FirstName,' ', c.LastName) as EntityName from  s_customers c where c.Cid = '".$EntityID."'";
		}else if($EntityType == "supplier"){
		 $strSQLQuery = "Select CONCAT(s.FirstName,' ',s.LastName) as EntityName from  p_supplier s where s.SuppCode = '".$EntityID."'";
		}else{
		 $strSQLQuery = "Select CONCAT(e.FirstName,' ',e.LastName) as EntityName from h_employee e where e.EmpID = '".$EntityID."'";
		}
		
		 
		$arryRow = $this->query($strSQLQuery, 1);
				
		return $arryRow[0]['EntityName'];
		
	}

	function getAccountName($AccountID)
	{

		$strSQLQuery = "Select b.AccountName as AccountName from f_bank_account b where b.BankAccountID = '".$AccountID."'"; 
		$arryRow = $this->query($strSQLQuery, 1);
				
		return $arryRow[0]['AccountName'];
		
	}


}
?>
