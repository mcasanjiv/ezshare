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
                                 global $Config;
				extract($arryDetails);
				$strAddQuery = " where j.LocationID = '".$_SESSION['locationID']."'";
				$SearchKey   = strtolower(trim($key));
				
				$strAddQuery .= (!empty($FromDate))?(" and j.JournalDate>='".$FromDate."'"):("");
				$strAddQuery .= (!empty($ToDate))?(" and j.JournalDate<='".$ToDate."'"):("");
					
					 if($SortBy != ''){
						$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '".$SearchKey."%')"):("");
					}			 
				 	  else{
				               $strAddQuery .= (!empty($SearchKey))?(" and (j.JournalNo like '".$SearchKey."%' or DECODE(j.TotalDebit,'". $Config['EncryptKey']."') = '".$SearchKey."' or DECODE(j.TotalCredit,'". $Config['EncryptKey']."') = '".$SearchKey."') "):("");
					}

					
                                        $strAddQuery .= (!empty($rule)) ? ("   " . $rule . "") : ("");
					$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by j.JournalID ");
					$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" DESC");

						   
					$strSQLQuery = "select j.*,DECODE(j.TotalDebit,'". $Config['EncryptKey']."') as TotalDebit, DECODE(j.TotalCredit,'". $Config['EncryptKey']."') as TotalCredit from f_gerenal_journal j  ".$strAddQuery;
					//echo $strSQLQuery;
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
                        
                         if($Config['CronEntry']==1){ //cron entry
				$JournalType = 'one_time';
                                $JournalNo = '';
                                $JournalDate = $Config['TodayDate'];
                                $journalPrefix = $this->getSettingVariable('JOURNAL_NO_PREFIX');
                                
			}else{
                            
                            $LocationID = $_SESSION['locationID'];
                        }
		
			 
                         if($JournalType == 'one_time'){
				$JournalStartDate=0;$JournalDateFrom='';$JournalDateTo='';$JournalInterval='';$JournalMonth=''; $EntryWeekly = '';
			}
                        
                            if($JournalInterval == 'monthly'){$JournalMonth='';$EntryWeekly = '';}
                            if($JournalInterval == 'yearly'){$EntryWeekly = '';}
                            if($JournalInterval == 'weekly'){$JournalStartDate = 0;$JournalMonth = '';}
                            if($JournalInterval == 'semi_monthly'){$JournalStartDate = 0;$JournalMonth='';$EntryWeekly = '';}
                            

			$strSQLQuery = "INSERT INTO f_gerenal_journal SET JournalNo = '".$JournalNo."', JournalDate='".$JournalDate."',JournalType='".$JournalType."', JournalInterval='".$JournalInterval."', JournalMonth='".$JournalMonth."', EntryWeekly = '".$EntryWeekly."', JournalDateFrom = '".$JournalDateFrom."', JournalDateTo='".$JournalDateTo."', JournalStartDate='".$JournalStartDate."', JournalMemo='".$JournalMemo."', TotalDebit = ENCODE('".$TotalDebit."','".$Config['EncryptKey']."'), TotalCredit = ENCODE('".$TotalCredit."','".$Config['EncryptKey']."'), LocationID='".$LocationID."', Currency='". $Config['Currency']."', CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."'";
			
			$this->query($strSQLQuery,0);
			$JournalID = $this->lastInsertId();

			//update journal no
			
			if(empty($JournalNo)){

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
                        
		         if($JournalType == 'one_time'){
				$JournalStartDate=0;$JournalDateFrom='';$JournalDateTo='';$JournalInterval='';$JournalMonth=''; $EntryWeekly = '';
			}
                        
                            if($JournalInterval == 'monthly'){$JournalMonth='';$EntryWeekly = '';}
                            if($JournalInterval == 'yearly'){$EntryWeekly = '';}
                            if($JournalInterval == 'weekly'){$JournalStartDate = 0;$JournalMonth = '';}
                            if($JournalInterval == 'semi_monthly'){$JournalStartDate = 0;$JournalMonth='';$EntryWeekly = '';}
                        
			$strSQLQuery = "update f_gerenal_journal SET  JournalDate='".$JournalDate."',JournalType='".$JournalType."', JournalInterval='".$JournalInterval."', JournalMonth='".$JournalMonth."', EntryWeekly = '".$EntryWeekly."', JournalDateFrom = '".$JournalDateFrom."', JournalDateTo='".$JournalDateTo."', JournalStartDate='".$JournalStartDate."', JournalMemo='".$JournalMemo."', TotalDebit = ENCODE('".$TotalDebit."','".$Config['EncryptKey']."'), TotalCredit = ENCODE('".$TotalCredit."','".$Config['EncryptKey']."'), LocationID='".$_SESSION['locationID']."', Currency='". $Config['Currency']."', UpdatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."' where JournalID='".$JournalID."'";
			 
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
						
                                                  $sql = "update f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', AccountName='".addslashes($arryDetails['AccountName'.$i])."', DebitAmnt= ENCODE('".$arryDetails['DebitAmnt'.$i]."','".$Config['EncryptKey']."'), CreditAmnt= ENCODE('".$arryDetails['CreditAmnt'.$i]."','".$Config['EncryptKey']."')  where JournalEntryID='".$JournalEntryID."'"; 
                                                  $this->query($sql, 0);
                                                       
					 }else{
                                            
                                            $sql = "insert into f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($arryDetails['AccountID'.$i])."', AccountName='".addslashes($arryDetails['AccountName'.$i])."', DebitAmnt= ENCODE('".$arryDetails['DebitAmnt'.$i]."','".$Config['EncryptKey']."'), CreditAmnt=ENCODE('".$arryDetails['CreditAmnt'.$i]."','".$Config['EncryptKey']."')";
                                            $this->query($sql, 0);	
                                                
					}
					
				}
			}
		       
			return true;

		}
                
             
               function PostJournalEntryToGL($arryDetails,$JournalNo)
               {
                   global $Config;
                   $ipaddress = $_SERVER["REMOTE_ADDR"];
                    $NumLine = sizeof($arryDetails);
                    for($Line=1;$Line<=$NumLine;$Line++) { 
                          $i=$Line-1;	

                          //echo "=>".$arryDetails[$i]['DebitAmnt'];

                             //Add Payment Transaction
                            //Get Journal No.
                                $strSQL = "select JournalNo,JournalDate from f_gerenal_journal where JournalID='".$arryDetails[$i]['JournalID']."'"; 
                                $arryRow = $this->query($strSQL, 1);		 
                                $JournalNo = $arryRow[0]['JournalNo'];
                                $JournalDate = $arryRow[0]['JournalDate'];
                             //end
                                
                            $strSQLQueryUpdate = "UPDATE f_gerenal_journal SET  PostToGL ='Yes', PostToGLDate='".$Config['TodayDate']."' WHERE JournalID='".$arryDetails[$i]['JournalID']."'";
                            $this->query($strSQLQueryUpdate, 0);
                            
                   if(intval($arryDetails[$i]['DebitAmnt']) > 0){
                          $strSQLQuery = "INSERT INTO f_payments SET  AccountName ='".addslashes($arryDetails[$i]['AccountName'])."', JournalID='".$arryDetails[$i]['JournalID']."', AccountID='".addslashes($arryDetails[$i]['AccountID'])."', DebitAmnt = ENCODE('".$arryDetails[$i]['DebitAmnt']."','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Config['TodayDate']."',  CreatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."'";

                        }

                        if(intval($arryDetails[$i]['CreditAmnt']) > 0){
                           $strSQLQuery = "INSERT INTO f_payments SET  AccountName ='".addslashes($arryDetails[$i]['AccountName'])."', JournalID='".$arryDetails[$i]['JournalID']."', AccountID='".addslashes($arryDetails[$i]['AccountID'])."', DebitAmnt = ENCODE('0.00','".$Config['EncryptKey']."'), CreditAmnt = ENCODE('".$arryDetails[$i]['CreditAmnt']."','".$Config['EncryptKey']."'),  ReferenceNo = '".$JournalNo."', PaymentDate = '".$JournalDate."', Currency = '". $Config['Currency']."', LocationID='".$_SESSION['locationID']."', PaymentType='Journal Entry', PostToGL='Yes',PostToGLDate = '".$Config['TodayDate']."', CreatedDate = '".$Config['TodayDate']."', IPAddress='".$ipaddress."'";

                        }

                        $this->query($strSQLQuery, 0);

                       //End Payment Transaction
                    }
                   
               }
               
                

	function AddJournalAttachment($JournalID,$arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			$strSQLQuery = "insert into f_gerenal_journal_attachment set JournalID='".$JournalID."', CmpID ='".$CmpID."', AttachmentNote='".addslashes($arryDetails['AttachmentNote'])."', CreatedDate = '".$Config['TodayDate']."', IPAddress = '".$ipaddress."'";
		 

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
			$objConfigure=new configure();	
				
			/******************ARCHIVE RECORD*********************************/
			
			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal SELECT * FROM f_gerenal_journal WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);


			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal_attachment SELECT * FROM f_gerenal_journal_attachment WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "INSERT INTO f_archive_gerenal_journal_entry SELECT * FROM f_gerenal_journal_entry WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			$this->query($strSQLQuery, 0);

			//$strSQLQuery = "INSERT INTO f_archive_payments SELECT * FROM f_payments WHERE JournalID ='".mysql_real_escape_string($JournalID)."'";
			//$this->query($strSQLQuery, 0);


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

						$objConfigure->UpdateStorage($AttachmentDir.$arryRow[$i]['AttachmentFile'],0,1);

						  unlink($AttachmentDir.$arryRow[$i]['AttachmentFile']);	
					}

                                 
				}

				
			}

			 

			$strSQLQuery = "DELETE FROM f_gerenal_journal_attachment WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			$strSQLQuery = "DELETE FROM f_gerenal_journal_entry WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			$this->query($strSQLQuery, 0);

			//$strSQLQuery1 = "DELETE FROM f_payments WHERE JournalID ='".mysql_real_escape_string($JournalID)."'"; 
			//$this->query($strSQLQuery1, 0);
			 
		}		


	function RemoveJournalAttachment($id)
		{
			
			$strSQLQuery = "select AttachmentID,AttachmentFile FROM f_gerenal_journal_attachment WHERE AttachmentID= '".mysql_real_escape_string($id)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);

			$AttachmentDir = 'upload/journal/'.$_SESSION['CmpID'].'/';

			if($arryRow[0]['AttachmentFile'] !='' && file_exists($AttachmentDir.$arryRow[0]['AttachmentFile']) )
			{	
				/*************/
				$objConfigure=new configure();
				$objConfigure->UpdateStorage($AttachmentDir.$arryRow[0]['AttachmentFile'],0,1);
				/*************/							
				unlink($AttachmentDir.$arryRow[0]['AttachmentFile']);	
			}

			$strSQLQuery = "DELETE FROM f_gerenal_journal_attachment WHERE AttachmentID ='".mysql_real_escape_string($id)."'"; 
			$this->query($strSQLQuery, 0);
			return 1;
		}		



	function getJournalById($JournalID)
	{
                global $Config;
		$strSQLQuery = "Select j.*,DECODE(j.TotalDebit,'". $Config['EncryptKey']."') as TotalDebit, DECODE(j.TotalCredit,'". $Config['EncryptKey']."') as TotalCredit from f_gerenal_journal j where j.JournalID = '".mysql_real_escape_string($JournalID)."'";	
		return $this->query($strSQLQuery, 1);
		
	}	

	function GetJournalEntry($JournalID)
	{       
                global $Config;
		$strSQLQuery = "Select j.*,DECODE(j.DebitAmnt,'". $Config['EncryptKey']."') as DebitAmnt, DECODE(j.CreditAmnt,'". $Config['EncryptKey']."') as CreditAmnt from f_gerenal_journal_entry j where j.JournalID = '".mysql_real_escape_string($JournalID)."' order by j.JournalEntryID asc";	
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
        
        
        function checkJournalDocFile($AttachmentFl,$CmpID)
        {

            $strSQLQuery = "Select AttachmentID from f_gerenal_journal_attachment where AttachmentFile = '".mysql_real_escape_string($AttachmentFl)."' and CmpID = '".mysql_real_escape_string($CmpID)."'"; 
            $arryRow = $this->query($strSQLQuery, 1);
            return $arryRow[0]['AttachmentID'];

        }
        
        /****************Recurring Function Satrt************************************/  
       function RecurringGeneralJournal(){       
          global $Config;
	  $Config['CronEntry']=1;
          $arryDate = explode(" ", $Config['TodayDate']);
   	  $arryDay = explode("-", $arryDate[0]);

	  $Month = (int)$arryDay[1];
	  $Day = $arryDay[2];	
	
	  $Din = date("l",strtotime($arryDate[0]));

	  $strSQLQuery = "select j.* from f_gerenal_journal as j where j.JournalType ='recurring' and j.JournalDateFrom<='".$arryDate[0]."' and j.JournalDateTo>='".$arryDate[0]."'";
          $arryJournal = $this->myquery($strSQLQuery, 1);
                  
          //echo "=>".$strSQLQuery;exit;
          //echo "<pre>";
         // print_r($arryJournal);
          //exit;
	
	  foreach($arryJournal as $value){
		$OrderFlag=0;
               
		switch($value['JournalInterval']){
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
				if($value['JournalStartDate']==$Day){
					$OrderFlag=1;
				}
				break;
			case 'yearly':
				if($value['JournalStartDate']==$Day && $value['JournalMonth']==$Month){
					$OrderFlag=1;
				}
				break;		
		
		}
		

		if($OrderFlag==1){
			//echo $value['JournalID'].'<br>';
	
			$NumLine = 0;
                        
                        $arryJournalEntry = $this->GetJournalEntry($value['JournalID']);
			$NumLine = sizeof($arryJournalEntry);	
                        
			if($NumLine>0){		
                            
                           
				$JournalID = $this->addJournal($value);
                                
				$this->AddUpdateJournalRecurringEntry($JournalID,$arryJournalEntry);
				
				$strSQL = "update f_gerenal_journal set LastRecurringEntry ='" . $Config['TodayDate'] . "' where JournalID='" . $value['JournalID'] . "'";
				$this->myquery($strSQL, 0);
		
			}


		}


	  }
       	  return true;
   }
   
   
   
		function AddUpdateJournalRecurringEntry($JournalID, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);
			$ipaddress = $_SERVER["REMOTE_ADDR"];
                        
                         foreach($arryDetails as $values){

                            if(!empty($values['JournalID'])) {			          


                                    $sql = "insert into f_gerenal_journal_entry set JournalID='".$JournalID."', AccountID='".addslashes($values['AccountID'])."', AccountName='".addslashes($values['AccountName'])."', DebitAmnt='".$values['DebitAmnt']."', CreditAmnt='".$values['CreditAmnt']."'";
                                   
                                    $this->query($sql, 0);	

                            }
                        }

                        
		       
			return true;

		}
                
                function getSettingVariable($settingKey)
		{
			$strSQLQuery = "select setting_value from settings where setting_key ='".trim($settingKey)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$settingValue = $arryRow[0]['setting_value'];	
			return $settingValue;
			
		}

}
?>
