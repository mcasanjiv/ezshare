<?php
class lead extends dbClass
{
		//constructor
		function lead()
		{
			$this->dbClass();
		} 
		
		 function  ListLead($id=0,$SearchKey,$SortBy,$AscDesc)
               {
			global $Config;
                       $strAddQuery = 'where 1';
                       $SearchKey   = strtolower(trim($SearchKey));
                       $strAddQuery .= (!empty($id))?(" and l.leadID=".$id):(" and l.Opportunity=0 ");
                       $strAddQuery .= ($Config['vAllRecord']!=1)?(" and (l.AssignTo='".$_SESSION['AdminID']."' OR l.created_id='".$_SESSION['AdminID']."')"):("");
                       if($SortBy == 'e.UserName'){
                               $strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%')"):("");
                               }
                       else if($SortBy == 'l.leadID'){
               $strAddQuery .= (!empty($SearchKey))?(" and (l.leadID = '".$SearchKey."')"):("");
                       }else{

                        if($SortBy != ''){
                               $strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
                       }else{
                               $strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' or l.primary_email like '%".$SearchKey."%' or l.leadID like '%".$SearchKey."%' or l.lead_status like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%' or l.company like '%".$SearchKey."%'  ) "  ):("");                        
                               }

                               }

                       $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by l.leadID ");
                       $strAddQuery .= (!empty($AscDesc))?($AscDesc):("desc");

                       $strSQLQuery = "select l.*,d.Department,e.EmpID,e.Department as emp_department,e.Role,e.FirstName as emp_name ,e.UserName as AssignTo,e2.UserName as created,e2.Department as create_department,d2.Department as create_Department,e2.Role as create_role from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e2.EmpID=l.created_id left outer join  h_department d2 on e2.Department=d2.depID ".$strAddQuery;
                         
                       
               
               
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

			$strSQLQuery = "select e.EmpID,e.Status,e.UserName,e.Email,e.Role,e.Image,d.Department,e2.UserName as SupervisorName from h_employee e left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e.Supervisor=e2.EmpID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
*/
		/****************************************************/
		

		function  ListSearchLead($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where l.leadID=".$id):(" where 1 ");
			$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

			
				$strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' ) "  ):("");			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by l.leadID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" desc");

			  $strSQLQuery = "select l.leadID,l.primary_email,l.FirstName,l.LastName,l.AssignTo,l.lead_status,l.description,l.company,d.Department,e.Role,e.UserName as AssignTo from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		
		function  ConvertLead($leadID,$Opportunity=0)
		{
			$strSQLQuery = "update c_lead set  Opportunity='".$Opportunity."'";

			$strSQLQuery .= (!empty($leadID))?(" where leadID=".$leadID):(" where 1 ");
			//$strSQLQuery .= ($Opportunity>0)?(" and l.Opportunity=".$Opportunity):("");

			$this->query($strSQLQuery, 0);
		}	



       function  GetDashboardLead($AdminType,$EmpID)
		{
			$strSQLQuery = "select l.leadID,l.FirstName,l.LastName,l.company,l.AssignTo,l.type,l.Opportunity from c_lead l ";
			

			$strSQLQuery .= ($AdminType!="admin")?(" where l.AssignTo=".$EmpID):(" where 1 ");
			$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");
			//$strAddQuery .= ($Opportunity!=1)?(" and l.Opportunity='".$Opportunity."' "):("");
			
			$strSQLQuery .= " and l.Opportunity='0' order by l.leadID desc limit 0,7";

			//echo $strSQLQuery;

			return $this->query($strSQLQuery, 1);
		}		


		function  GetLead($leadID,$Opportunity)
		{
			$strSQLQuery = "select * from c_lead  ";

			$strSQLQuery .= (!empty($leadID))?(" where leadID=".$leadID):(" where 1 ");
			$strSQLQuery .= ($Opportunity>0)?(" and Opportunity=".$Opportunity):("");
			//$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and (AssignTo='".$_SESSION['AdminID']."' OR created_id='".$_SESSION['AdminID']."') "):("");
			
			

			return $this->query($strSQLQuery, 1);
		}		
		

		function  GetLeadsForprimary_email($leadID)
		{
			$strSQLQuery = "select leadID,primary_email from c_lead where 1";
			$strSQLQuery .= (!empty($leadID))?(" and leadID!='".$leadID."'"):("");
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllLeads($Opportunity)
		{
			$strSQLQuery = "select leadID,primary_email from c_lead where 1 ";

			$strSQLQuery .= ($Opportunity>0)?(" and Opportunity='".$Opportunity."'"):("");
			$strSQLQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

			$strSQLQuery .= " order by primary_email Asc";

			return $this->query($strSQLQuery, 1);
		}


		function  GetLeadDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where l.leadID='".$id."'"):(" where 1 ");
			$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");

			$strAddQuery .= "and l.Opportunity=0 order by l.JoiningDate Desc ";

			 $strSQLQuery = "select l.*, e.Role,e.UserName as AssignTo from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  h_department d on e.Department=d.depID  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddLead($arryDetails)
		{  
			
			global $Config;

			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			//if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			$JoiningDatl=$Config['TodayDate'];

		 $strSQLQuery = "insert into c_lead (type,ProductID,product_price, primary_email,company,Website,FirstName,LastName,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber,lead_status,lead_source, JoiningDate,  OtherState, OtherCity,  ipaddress, UpdatedDate,AssignTo,AnnualRevenue,designation,description,Industry ) values('".addslashes($type)."','".addslashes($ProductID)."', '".addslashes($product_price)."','".addslashes($primary_email)."', '".addslashes($company)."','".addslashes($Website)."','".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($LandlineNumber)."','".addslashes($lead_status)."','".addslashes($lead_source)."',  '".$JoiningDatl."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."','".$ipaddress."',  '".$Config['TodayDate']."','".addslashes($AssignTo)."','".addslashes($AnnualRevenue)."','".addslashes($designation)."','".addslashes($description)."','".addslashes($Industry)."')";

			$this->query($strSQLQuery, 0);

			

			$LeadID = $this->lastInsertId();

            if($AssignTo!=''){

				//$objEmployee= new employee();

				//$arryEmp=$objEmployee->GetEmployeeUser($AssignTo,1);
                                   $strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignTo."'";
					$arryEmp = $this->query($strSQLQuery, 1);


					$ToEmail = $arryEmp[0]['Email'];
					$CC = $Config['AdminEmail'];

				     $assignEmail=$arryEmp[0]['Email'];

		

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."LeadAssigned.htm");
			$subject  = "  Assigned to You ";
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[LEADSTATUS]",$lead_status, $contents);
			$contents = str_replace("[DETAIL]",stripslashes($description), $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			$contents = str_replace("[COMPANY]",$company,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($assignEmail);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);    
			$mail->Subject = $Config['SiteName']." - Lead [".$UserName."] - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;  
                        #echo $assignEmail.$Config['AdminEmail'].$contents; exit; 
			if($Config['Online'] == 1){
				 $mail->Send();	
			}

		}
		#echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;

			//Projects [Sunesta]. Task Assigned to You: Email for Images and Files
			//Send Acknowledgment Email to admin
                        $subject2  = "  has been Submitted";
			$contents = file_get_contents($htmlPrefix."admin_Lead.htm");

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

            $mail = new MyMailer();
            $mail->IsMail();           
            $mail->AddAddress($Config['AdminEmail']);
            if(!empty($Config['DeptHeadEmail'])){
                $mail->AddCC($Config['DeptHeadEmail']);
            }
                   
           $mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." -New Lead - ".$subject2;
            $mail->IsHTML(true);
            $mail->Body = $contents; 
            //echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
		    if($Config['Online'] == '1'){
		        $mail->Send();   
		    }
			
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $LeadID;

		}


		

		function UpdateLead($arryDetails){ 

			global $Config;

			extract($arryDetails);

			$UserName = trim($FirstName.' '.$LastName);
	
			
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);

			 $sql = "select * from c_lead where AssignTo!='".$AssignTo."' and leadID=".$leadID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{

			if($AssignTo!=''){

				//$objEmployee= new employee();

				//$arryEmp=$objEmployee->GetEmployeeUser($AssignTo,1);
                                  $strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignTo."'";
					$arryEmp = $this->query($strSQLQuery, 1);

					$ToEmail = $arryEmp[0]['Email'];
					$CC = $Config['AdminEmail'];

				     $assignEmail=$arryEmp[0]['Email'];

				

		

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."LeadAssigned.htm");
			$subject  = "  Assigned to You ";
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[LEADSTATUS]",$lead_status, $contents);
			$contents = str_replace("[DETAIL]",stripslashes($description), $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			$contents = str_replace("[COMPANY]",$company,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($assignEmail);
			$mail->sender($UserName, $primary_email);   
			$mail->Subject = $Config['SiteName']." - Lead [".$UserName."] - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['Online'] == 1){
				 $mail->Send();	
			}

		}
#echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;

	}
		
			
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			//if(empty($Status)) $Status=1;type,ProductID,product_price
			 $strSQLQuery = "update c_lead set  type='".addslashes($type)."', ProductID='".addslashes($ProductID)."', product_price='".addslashes($product_price)."',FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."',Website='".addslashes($Website)."',
			primary_email='".addslashes($primary_email)."',designation='".addslashes($designation)."',
			Industry='".addslashes($Industry)."',AnnualRevenue='".addslashes($AnnualRevenue)."',
			lead_source='".addslashes($lead_source)."',AssignTo='".addslashes($AssignTo)."',lead_status='".addslashes($lead_status)."',Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."',  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',company='".addslashes($company)."', description='".addslashes($description)."'
			where leadID=".$leadID; 

			$this->query($strSQLQuery, 0);


			

			return 1;
		}


			function UpdateCreater($arryDetail,$table,$typeID,$ID){

                    extract($arryDetail);

					 $strSQLQuery = "update ".$table." set  created_id='".addslashes($created_id)."', created_by='".addslashes($created_by)."' where ".$typeID."=".$ID;
					
				
					$this->query($strSQLQuery, 0);
					return 1;

			}


	
		

		

		
		
		function RemoveLead($leadID)
		{

			$strSQLQuery = "delete from c_lead where leadID=".$leadID; 
			$this->query($strSQLQuery, 0);			
			return 1;

		}

		
		
		
		function changeLeadStatus($leadID)
		{
			$sql="select * from c_lead where leadID=".$leadID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_lead set Status='$Status' where leadID=".$leadID;
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleLeadStatus($leadIDs,$Status)
		{
			$sql="select leadID from c_lead where leadID in (".$leadIDs.") "; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update c_lead set Status=".$Status." where leadID in (".$leadIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		

		function isprimary_emailExists($primary_email,$leadID=0)
		{
			$strSQLQuery = (!empty($leadID))?(" and leadID != ".$leadID):("");
			$strSQLQuery = "select leadID from c_lead where LCASE(primary_email)='".strtolower(trim($primary_email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['leadID'])) {
				return true;
			} else {
				return false;
			}
		}
	


function isOpportunityNameExists($OpportunityName,$OpportunityID=0)
		{
			$strSQLQuery = (!empty($leadID))?(" and OpportunityID != ".$OpportunityID):("");
			$strSQLQuery = "select OpportunityID from c_opportunity where LCASE(OpportunityName)='".strtolower(trim($OpportunityName))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['OpportunityID'])) {
				return true;
			} else {
				return false;
			}
		}

		function isTicketTitleExists($title,$TicketID=0)
		{
			$strSQLQuery = (!empty($leadID))?(" and TicketID != ".$TicketID):("");
			$strSQLQuery = "select TicketID from c_ticket where LCASE(title)='".strtolower(trim($title))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['TicketID'])) {
				return true;
			} else {
				return false;
			}
		}
	
	
		
	/************Ticket Function*****************/


	function AddTicket($arryDetails)
		{  
			
			global $Config;
	

			extract($arryDetails);
              
                      if($assign == 'User'){
                         $AssignUser = $AssignToUser;
                         $AssignType = $assign;
                      }else{
			  $arryAsign = explode(":",$AssignToGroup);
                          $AssignUser = $arryAsign[0];
			  $AssignType = $assign;
			  $GroupID =  $arryAsign[1];
				

			}


			  


			$htmlPrefix = $Config['EmailTemplateFolder'];
			
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];

			$strSQLQuery = "insert into c_ticket ( title,AssignedTo,AssignType,GroupID,category,Name,day,hours, priority, description, solution,Status,ticketDate,parent_type,parentID,created_by,created_id ) values( '".addslashes($title)."', '".addslashes($AssignUser)."','".addslashes($AssignType)."','".addslashes($GroupID)."','".addslashes($category)."','".addslashes($Name)."', '".addslashes($day)."', '".addslashes($hours)."',  '".$priority."', '".addslashes($description)."', '".addslashes($solution)."','".$Status."','".$Config['TodayDate']."','".$parent_type."','".$parentID."','".$created_by."','".$created_id."')";

			$this->query($strSQLQuery, 0);

			$TicketID = $this->lastInsertId(); 

            if($parent_type!='' && $parentID!=''  && $TicketID!=''  ){

				$mode_type="Ticket";

			 $strQuery = "insert into c_compaign_sel (compaignID,parent_type,parentID,mode_type ) values('".$TicketID."','".addslashes($parent_type)."','".addslashes($parentID)."','".addslashes($mode_type)."')";

			 $this->query($strQuery, 0);

			$ID = $this->lastInsertId();
             
			         $subject =" has been added in ".$mode_type."[".$parentID."]";
					$contents = file_get_contents($htmlPrefix."Added_Ticket.htm");

					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
                    $contents = str_replace("[PARENT]",$parent_type, $contents);
					$contents = str_replace("[PARENTID]",$parentID, $contents);
					$contents = str_replace("[TITLE]",$title, $contents);
					$contents = str_replace("[CATEGORY]",$category,$contents);
					//$contents = str_replace("[NAME]",$Name,$contents);	
					$contents = str_replace("[PRIORITY]",$priority, $contents);
					$contents = str_replace("[DETAIL]",$description, $contents);
					$contents = str_replace("[SOLUTION]",$solution, $contents);
					$contents = str_replace("[DATE]",$Config['TodayDate'],$contents);

					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Config['AdminEmail']);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Ticket - ".$subject2;
					$mail->IsHTML(true);
					#echo $Config['AdminEmail'].$contents; exit;
					$mail->Body = $contents;    
					if($Config['Online'] == 1){
						$mail->Send();	
					}

			}

			 if($arryAsign[0]!=''){
                              $strSQLQuery = "select UserName,Email from h_employee where EmpID in (".$arryAsign[0].")"; 
				 //$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignedTo."'";
					$arryEmp = $this->query($strSQLQuery, 1);
					

					foreach($arryEmp as $email)
					{
						$ToEmail .= $email['Email'].",";
					}
					$assignEmail = rtrim($ToEmail,",");
					
					//$ToEmail = $arryEmp[0]['Email'];
					$CC = $Config['AdminEmail'];

				     //$assignEmail=$arryEmp[0]['Email'];

			//$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../".$Config['primary_emailTemplateFolder']):($Config['primary_emailTemplateFolder']);
			
			//$contents = file_get_contents($htmlPrefix."TicketAssigned.htm");

			//$_SESSION['mess_account'] = SUCCESSFULLY_REGISTERED;
			$contents = file_get_contents($htmlPrefix."assign_ticket.htm");
			$subject2  = " Assigned To You";
			
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

			$contents = str_replace("[TITLE]",$title, $contents);
			$contents = str_replace("[CATEGORY]",$category,$contents);
			$contents = str_replace("[NAME]",$Name,$contents);
			$contents = str_replace("[DATE]",$Config['TodayDate'],$contents);
			$contents = str_replace("[PRIORITY]",$priority, $contents);
			$contents = str_replace("[DETAIL]",$description, $contents);
			$contents = str_replace("[SOLUTION]",$solution, $contents);

			//$contents = str_replace("[DATE]",$ticketDate, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($assignEmail);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Ticket - ".$subject2;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
#echo $assignEmail.$Config['AdminEmail'].$contents; exit;
			if($Config['Online'] == 1){
				 $mail->Send();	
			}

			 }

			#echo $assignEmail.$Config['AdminEmail'].$contents; exit;



			
					//Send Acknowledgment primary_email to admin

					$subject3 ="Details";
					$contents = file_get_contents($htmlPrefix."admin_Ticket.html");

					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

					$contents = str_replace("[TITLE]",$title, $contents);
					$contents = str_replace("[CATEGORY]",$category,$contents);
					//$contents = str_replace("[NAME]",$Name,$contents);	
					$contents = str_replace("[PRIORITY]",$priority, $contents);
					$contents = str_replace("[DETAIL]",$description, $contents);
					$contents = str_replace("[SOLUTION]",$solution, $contents);
					$contents = str_replace("[DATE]",$$Config['TodayDate'],$contents);

					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Config['AdminEmail']);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Ticket - ".$subject3;
					$mail->IsHTML(true);
					//echo $Config['AdminEmail'].$contents; exit;
					$mail->Body = $contents;    
					if($Config['Online'] == 1){
						$mail->Send();	
					}
              //echo $assignEmail.$Config['AdminEmail'].$contents; exit;
			


			return $TicketID;

		}

/**************************************/
	function  ListTicket($PID,$parent_type,$parentID,$SearchKey,$SortBy,$AscDesc)
		{
			global $Config;
			$strAddQuery = " where 1 ";
                        $SearchKey   = strtolower(trim($SearchKey));

                      
		        if($SearchKey != "" && $SortBy == "t.TicketID"){

                             $strAddQuery .= " and t.TicketID = '".$SearchKey."'";
	
                        }elseif($SearchKey != "" && $SortBy == "t.title"){

                             $strAddQuery .= " and  t.title like '%".$SearchKey."%'";
			
                         }elseif($SortBy=='t.Status'){   
                             $strAddQuery .= " and  t.Status='".$SearchKey."'";
                          }
                      
                        else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}
                        else{

$strAddQuery .= (!empty($SearchKey))?(" and (t.title like '%".$SearchKey."%' or t.TicketID like '%".$SearchKey."%'   or t.Status like '%".$SearchKey."%' or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%' ) and t.PID =0 " ):("");	




				//$strAddQuery .= "(!empty($SearchKey))? 1 AND (t.title like '%".$SearchKey."%' or t.TicketID = '".$SearchKey."' or  t.TicketID = '".$SearchKey."') and t.PID =0" ;	
			}
                        $strAddQuery .= ($Config['vAllRecord']!=1)?(" and (t.AssignedTo like '%".$_SESSION['AdminID']."%' OR t.created_id='".$_SESSION['AdminID']."') "):("");
                        $strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by t.TicketID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");
                    
                        $strSQLQuery = "select t.*,if(t.PID>0,t2.title,'') as ParentName,d.Department,e.EmpID,e.Role,e.UserName as AssignTo from c_ticket t left outer join c_ticket t2 on t.PID = t2.TicketID left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID".$strAddQuery.$OrderBy;
                        #echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		}
                
                function  ListAllCategories()
		{
			
			
                        $strSQLQuery = "select CategoryID,Level,Name,Status from e_categories WHERE ParentID =0";
			return $this->query($strSQLQuery, 1);
		}
                
               /*function  ListAllCategoriesAndSubcategories()
		{
			
			
                        $strSQLQuery = "select CategoryID,Level,Name,Status from e_categories";
			return $this->query($strSQLQuery, 1);
		}*/

		function  GetCategory($CategoryID,$ParentID)
		{
			$strAddQuery = '';
			$strAddQuery .= ($ParentID>0)?(" where c1.ParentID=".$ParentID):(" where c1.ParentID=0");
			$strAddQuery .= ($CategoryID>0)?(" and c1.CategoryID=".$CategoryID):("");

			$strSQLQuery = "select t1.*,if(t1.PID>0,t2.title,'') as ParentName,d.Department,e.Role,e.UserName as AssignTo from c_ticket t1 left outer join c_ticket c2 on c1.PID = c2.TicketID left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID ".$strAddQuery." order by t1.title";
                                                    
			return $this->query($strSQLQuery, 1);
		}
		
		function  GetSubCategoryByParent($Status,$ParentID)
		{
                    
                     if($Status=='1' || $Status=='active' || $Status=='Active')
                        {   
                                  $strAddQuery .= " and Status=1";
                        }
                        else if($Status=='0' || $Status=='inactive'){
				  $strAddQuery .= " and Status=0";
			}
                        

			$strSQLQuery = "select * from e_categories where ParentID=".$ParentID.$strAddQuery." order by CategoryID";
                        
			return $this->query($strSQLQuery, 1);
		}

		
		
		function  GetNameByParentID($ParentID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select Name from e_categories where CategoryID = ".$ParentID.$strAddQuery." order by Name";
			return $this->query($strSQLQuery, 1);
		}

		

		function  GetCategoryNameByID($CategoryID)
		{
			$strAddQuery = '';
			$strSQLQuery = "select c1.Name,c1.Image,c1.CategoryID,c1.ParentID from e_categories c1 where c1.Status=1 and c1.CategoryID in(".$CategoryID.") ".$strAddQuery." order by c1.Name ";
			return $this->query($strSQLQuery, 1);
		}




/****************************************/






	function  ListTicket6756($id=0,$parent_type,$parentID,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where t.TicketID=".$id):(" where 1 ");

			$strAddQuery .= (!empty($parent_type))?(" and t.parent_type='".$parent_type."' "):("");
			$strAddQuery .= (!empty($parentID))?(" and t.parentID=".$parentID):("");

			if($SearchKey=='active' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and t.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='t.Status' || $SortBy=='') ){
				$strAddQuery .= " and t.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." = '".$SearchKey."')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( t.title like '%".$SearchKey."%' or t.priority like '%".$SearchKey."%' or t.TicketID like '%".$SearchKey."%' ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by t.TicketID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select t.*, d.Department,e.Role,e.UserName as AssignTo from c_ticket t  left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID  ".$strAddQuery;
			 

			
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	

		function  GetTicket($TicketID,$Status)
		{
			$strSQLQuery = "select t.*,if(t.PID>0,t2.title,'') as ParentName,d.Department,e.EmpID,e.Role,e.UserName as AssignTo from c_ticket t left outer join c_ticket t2 on t.PID = t2.TicketID left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID  where  t.TicketID=".$TicketID;

			//$strSQLQuery .= (!empty($leadID))?(" where t.TicketID=".$TicketID):(" where 1 ");
			//$strSQLQuery .= ($Status>0)?(" and t.Status=".$Status):("");
//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		}		

	
           function RemoveTicket($TicketID)
		{

			$strSQLQuery = "delete from c_ticket where TicketID=".$TicketID; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}
		
			function UpdateTicketDetail($arryDetails){
				global $Config;
			     extract($arryDetails);
                                  if($assign == 'User'){
				         $AssignUser = $AssignToUser;
				         $AssignType = $assign;
				     }else{
					  $arryAsign = explode(":",$AssignToGroup);
				          $AssignUser = $arryAsign[0];
					  $AssignType = $assign;
					  $GroupID =  $arryAsign[1];
			              }

			      $UserName = trim($FirstNaml.' '.$LastName);
 

			 $sql = "select * from c_ticket where AssignedTo!='".$AssignUser."' and TicketID='".$TicketID."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
			 if($arryAsign[0]!=''){
				 $ticketDate=$rs[0]['ticketDate'];

				$strSQLQuery = "select UserName,Email from h_employee where EmpID in (".$AssignUser.")"; 
					$arryEmp = $this->query($strSQLQuery, 1);

                                    foreach($arryEmp as $email)
					{
						$ToEmail .= $email['Email'].",";
					}
					$assignEmail = rtrim($ToEmail,",");

					$ToEmail = $arryEmp[0]['Email'];
					$CC = $Config['AdminEmail'];

			$htmlPrefix = $Config['EmailTemplateFolder'];
			
			$contents = file_get_contents($htmlPrefix."assign_ticket.htm");
			$subject  = " Assigned To You";
			
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

			$contents = str_replace("[TITLE]",$title, $contents);
			$contents = str_replace("[CATEGORY]",$category,$contents);
			//$contents = str_replace("[NAME]",$Name,$contents);	
			$contents = str_replace("[PRIORITY]",$priority, $contents);
			$contents = str_replace("[DETAIL]",$description, $contents);
			$contents = str_replace("[SOLUTION]",$solution, $contents);

			$contents = str_replace("[DATE]",$ticketDate, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($assignEmail);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Ticket - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents; 
#echo $assignEmail.$Config['AdminEmail'].$contents; exit;  
			if($Config['Online'] == 1){
				 $mail->Send();	
			}

		}
	}
			


			$strSQLQuery = "update c_ticket set  title='".addslashes($title)."', AssignedTo='".addslashes($AssignUser)."',AssignType = '".$AssignType."',GroupID = '".$GroupID."',Status='".addslashes($Status)."',priority='".addslashes($priority)."',category='".addslashes($category)."',day='".addslashes($day)."',Hours='".$Hours."'	where TicketID=".$TicketID; 
			$this->query($strSQLQuery, 0);


			return 1;
		}


		function UpdateDescription($arryDetails){   
			extract($arryDetails);		
			

			$strSQLQuery = "update c_ticket set description='".addslashes($description)."'
			where TicketID=".$TicketID;
			$this->query($strSQLQuery, 0);
			return 1;
		}
		

		function UpdateResolution($arryDetails){  
			global $Config;
			extract($arryDetails);		
			

			$strSQLQuery = "update c_ticket set solution='".addslashes($solution)."'
			where TicketID=".$TicketID;
			$this->query($strSQLQuery, 0);
			return 1;
		}
		
		/************ Comment Section ***********/

		function AddComment($arrydetail){
           global $Config;

            extract($arrydetail);	
			$time=time();

            $strSQLQuery = "insert into c_comments (parent,commented_by,commented_id,parent_type,parentID,Comment,CommentDate,timestamp ) values( '".addslashes($parent)."', '".addslashes($commented_by)."','".addslashes($commented_id)."','".addslashes($parent_type)."','".addslashes($parentID)."','".addslashes($Comment)."','".date("y-m-d h:i:s")."','".$time."')";

			$this->query($strSQLQuery, 0);

			$cmtID = $this->lastInsertId(); 
			return $cmtID;
         }

		function GetCommentUser($id,$parentID,$parent_type,$parent,$status=0){

            $strAddQuery = 'where parent = ""';
		    $strAddQuery .= (!empty($id))?(" c.CommentID=".$id):("  ");
			$strAddQuery .= (!empty($parentID))?(" and c.parentID=".$parentID):("  ");
			$strAddQuery .= (!empty($parent_type))?(" and c.parent_type='".$parent_type."'"):(" ");
			$strAddQuery .= (!empty($parent))?(" and c.parent=".$parent):(" ");

			$strAddQuery .= " order by c.CommentID asc ";

			  $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_comments c left outer join h_employee e  on e.EmpID=c.commented_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function GetCommentByID($id,$parent){

            $strAddQuery = 'where 1';
		    $strAddQuery .= (!empty($id))?(" c.CommentID=".$id):("  ");
			$strAddQuery .= (!empty($parent))?(" and c.parent=".$parent):(" ");

			$strAddQuery .= " order by c.CommentID asc ";

			  $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_comments c left outer join h_employee e  on e.EmpID=c.commented_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		 function RemoveComment($commentID)
		{

			$strSQLQuery = "delete from c_comments where CommentID=".$commentID; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}


		/*********************Document Section ***********************/
      function  ListDocument($id=0,$parent_type,$parentID,$SearchKey,$SortBy,$AscDesc)
		{
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where d.documentID=".$id):(" where 1 ");
              
			$strAddQuery .= (!empty($parent_type))?(" and d.parent_type='".$parent_type."' "):("");
			$strAddQuery .= (!empty($parentID))?(" and d.parentID=".$parentID):("");
			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and d.AssignTo like '%".$_SESSION['AdminID']."%' "):("");

			if($SearchKey=='active' && ($SortBy=='d.Status' || $SortBy=='') ){
				$strAddQuery .= " and d.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='d.Status' || $SortBy=='') ){
				$strAddQuery .= " and d.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." = '".$SearchKey."')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( d.FileName like '%".$SearchKey."%' or d.title like '%".$SearchKey."%' or d.documentID like '%".$SearchKey."%' ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by d.documentID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" desc");

			 $strSQLQuery = "select d.documentID,d.DownloadType,d.AddedDate,d.Status,d.title,d.FileName,d.AssignTo,d.description,e.Role,e.UserName as AssignTo from c_document d left outer join  h_employee e on e.EmpID=d.AssignTo  ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

        function AddDocument($arrydetail){

	global $Config;
		  
        extract($arrydetail);


if($assign == 'User'){$AssignTo = $AssignToUser;}else{

$group = explode(":",$AssignToGroup);

$AssignTo = $group[0] ;
$GroupID = $group[1] ;

}
$time=time();

echo $strSQLQuery = "insert into c_document (linkId,title,module,DownloadType,AddedDate,description,AddedBy,AssignTo,parent_type,parentID,AssignType,GroupID ) values( '".addslashes($linkId)."', '".addslashes($title)."','".addslashes($module)."','".addslashes($DownloadType)."','".$Config['TodayDate']."','".addslashes($description)."','".addslashes($AddedBy)."','".$AssignTo."','".$parent_type."','".$parentID."','".$assign ."','".$GroupID."')";
		  

	$this->query($strSQLQuery, 0);

	$cmtID = $this->lastInsertId(); 
	return $cmtID;
         }



function addDocAssign($arryDetails)
		{
			
			extract($arryDetails);
			$EmpID=explode(",",$AssignTo);
			
			
			$sql = "delete from c_doc_assign where documentID =".$_POST['documentID'];
			$rs = $this->query($sql,0);
			for($i=0;$i<sizeof($EmpID); $i++){
				$sql = "insert into c_doc_assign( EmpID, documentID) values('".$EmpID[$i]."', '".$_POST['documentID']."')";
				$rs = $this->query($sql,0);
				}
		
			return 1;

		}

		function getDocAssign($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and a.documentID = ".$id):("");
		$sql = "select a.*,e.UserName,e.EmpID,e.Department,e.JobTitle,e.Image,d.Department as emp_dep,d.depID from c_doc_assign a left outer join  h_employee e on e.EmpID=a.EmpID left outer join  h_department d on e.Department=d.depID ".$sql." order by a.EmpID Asc" ; 
		return $this->query($sql, 1);
	}


		function UpdateDoc($FileName,$documentID)
		{
			$strSQLQuery = "update c_document set FileName='".$FileName."' where documentID=".$documentID;
			 $this->query($strSQLQuery, 0);
			 return true;
		}

		function changeDocumentStatus($documentID)
		{
			$sql="select * from c_document where documentID=".$documentID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_document set Status='$Status' where documentID=".$documentID;
				$this->query($sql,0);				

				return true;
			}			
		}
		function RemoveDocument($documentID)
		{

			$strSQLQuery = "select FileName from c_document where documentID=".$documentID; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($Front > 0){
				$ImgDirPrefix = '';
			}else{
				$ImgDirPrefix = '../';
			}

			
			$DocDir = $ImgDirPrefix.'admin/crm/upload/Document/';

		
			

			if($arryRow[0]['FileName'] !='' && file_exists($DocDir.$arryRow[0]['FileName']) ){					
				unlink($ResumeDir.$arryRow[0]['FileName']);	
			}			
        
			
			$strSQLQuery = "delete from c_document where documentID=".$documentID; 
			$this->query($strSQLQuery, 0);			

			//$sql = "delete from admin_permission where contactID = ".$contactID;
			//$this->query($sql, 0);			


			return 1;

		}
		
			function UpdateDocument($arryDetails){ 
			global $Config;
			extract($arryDetails);
			if($assign == 'User'){$AssignTo = $AssignToUser;}
                         else{
				$group = explode(":",$AssignToGroup);
				$AssignTo = $group[0] ;
				$GroupID = $group[1] ;

			}
			
			$strSQLQuery = "update c_document set  title='".addslashes($title)."', AssignTo='".addslashes($AssignTo)."', AssignType='".addslashes($assign)."',GroupID='".addslashes($GroupID)."',Status='".addslashes($Status)."',DownloadType='".addslashes($DownloadType)."',description='".addslashes($description)."',AddedDate='".$Config['TodayDate']."'	where documentID=".$documentID; 
			$this->query($strSQLQuery, 0);
			return 1;
		}

			function isDocumentExists($title,$documentID=0)
		{
			$strAddQuery = (!empty($documentID))?(" and documentID != ".$documentID):("");
			 $strSQLQuery = "select documentID from c_document where title='".$title."' ".$strAddQuery;
			$arryRow = $this->query($strSQLQuery, 1);
		
//echo $arryRow[0]['documentID']; exit;
			if (!empty($arryRow[0]['documentID'])) {
				return true;
			} else {
				return false;
			}	exit;
		}



function  GetDocument($documentID,$Status)
		{
			$strSQLQuery = "select t.* from c_document t where  t.documentID=".$documentID;

			//$strSQLQuery .= (!empty($leadID))?(" where t.TicketID=".$TicketID):(" where 1 ");
			//$strSQLQuery .= ($Status>0)?(" and t.Status=".$Status):("");
//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		}		



		/***************************Opprtunity**********************/

		function  ListOpportunity($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where o.OpportunityID=".$id):(" where 1 ");
			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (o.AssignTo='".$_SESSION['AdminID']."' OR o.created_id='".$_SESSION['AdminID']."') "):("");

			if($SearchKey=='active' && ($SortBy=='o.Status' || $SortBy=='') ){
				$strAddQuery .= " and o.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='o.Status' || $SortBy=='') ){
				$strAddQuery .= " and o.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." = '".$SearchKey."')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( o.OpportunityName like '%".$SearchKey."%' or o.lead_source like '%".$SearchKey."%' or o.SalesStage like '%".$SearchKey."%' ) "  ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by o.OpportunityID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" desc");

			 $strSQLQuery = "select o.OpportunityID,o.created_id,o.LeadID,o.Status,o.OpportunityName,o.lead_source,o.CloseDate,o.SalesStage,o.description,e.EmpID,d.Department,e.Role,e.UserName as AssignTo from c_opportunity o left outer join  h_employee e on e.EmpID=o.AssignTo left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		 function  GetDashboardOpportunity()
		{
			$strSQLQuery = "select o.OpportunityID,o.LeadID,o.Status,o.OpportunityName,o.lead_source,o.Amount from c_opportunity o ";

			$strSQLQuery .= " where o.Amount!='' and o.Status='1' ";

			$strSQLQuery .= ($_SESSION['AdminType']!="admin")?(" and o.AssignTo='".$_SESSION['AdminID']."' "):("");
			
			$strSQLQuery .= " order by o.Amount desc limit 0,7 ";

			//echo $strSQLQuery;

			return $this->query($strSQLQuery, 1);
		}		


		function AddOpportunity($arryDetails)
		{  
			 
			global $Config;
			extract($arryDetails);
			
			
			if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
			 $expCloseDate=$CloseDate.' '.$CloseTime;
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			
             //if($Status=0 && !empty($Status)){ $Status=1;}

			 $strSQLQuery = "insert into c_opportunity ( LeadID,OpportunityName,Amount,OrgName,AssignTo,CloseDate,lead_source,SalesStage,OpportunityType,NextStep, 	description,Probability,Campaign_Source,ContactName,AddedDate,forecast_amount,oppsite,Status ) values( '".$LeadID."', '".addslashes($OpportunityName)."','".addslashes($Amount)."','".addslashes($OrgName)."','".addslashes($AssignTo)."', '".addslashes($expCloseDate)."', '".addslashes($lead_source)."',  '".addslashes($SalesStage)."','".addslashes($OpportunityType)."','".addslashes($NextStep)."','".addslashes($description)."','".addslashes($Probability)."',  '".addslashes($Campaign_Source)."', '".addslashes($ContactName)."',  '". $Config['TodayDate']."','".addslashes($forecast_amount)."','".addslashes($oppsite)."','".$Status."')";
			
		

			$this->query($strSQLQuery, 0);


			/*if($LeadID!=''){
              $strUpSQLQuery = "update c_lead set  Opportunity=0 where leadID=".$LeadID;


                $this->query($strUpSQLQuery, 0);
			}*/

			

			$OpportunityID = $this->lastInsertId();

			 if($AssignTo!=''){

				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignTo."'";
				$arryEmp = $this->query($strSQLQuery, 1);

				$ToEmail = $arryEmp[0]['Email'];
				$CC = $Config['AdminEmail'];

				$assignEmail=$arryEmp[0]['Email'];

				

		

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."oppAssigned.htm");
			$subject  = "  Assigned to You ";
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			//$contents = str_replace("[FULLNAME]",$arryEmp[0]['UserName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[OPPNAME]",$OpportunityName, $contents);
			$contents = str_replace("[CLOSEDATE]",date($Config['DateFormat'] , strtotime($expCloseDate)), $contents);
			$contents = str_replace("[DETAIL]",stripslashes($description), $contents);
			$contents = str_replace("[SALESTAGE]",$SalesStage,$contents);
			$contents = str_replace("[CONNAME]",$ContactName,$contents);
			//$contents = str_replace("[COMPANY]",$company,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($assignEmail);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Opportunity [".$OpportunityName."] - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['Online'] == 1){
				 $mail->Send();	
			}

		}
		#echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;

			$subject2  = "  has been Submitted. ";
			//Send Acknowledgment Email to admin
			$contents = file_get_contents($htmlPrefix."admin_opp.htm");

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[OPPNAME]",$OpportunityName, $contents);
			$contents = str_replace("[CLOSEDATE]",date($Config['DateFormat'] , strtotime($expCloseDate)), $contents);
			$contents = str_replace("[DETAIL]",stripslashes($description), $contents);
			$contents = str_replace("[SALESTAGE]",$SalesStage,$contents);
			$contents = str_replace("[CONNAME]",$ContactName,$contents);	
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." -New  Opportunity - ".$subject2;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['Online'] == 1){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $OpportunityID;

		}


		function UpdateOpportunity($arryDetails){   
			
			
					extract($arryDetails);
    				$expCloseDate=$CloseDate.' '.$CloseTime;
			
			
			//if(empty($Status)) $Status=1;
            $strSQLQuery = "update c_opportunity set  OpportunityName='".addslashes($OpportunityName)."', Amount='".addslashes($Amount)."',OrgName='".addslashes($OrgName)."',
			AssignTo='".addslashes($AssignTo)."',CloseDate='".addslashes($expCloseDate)."',
			lead_source='".addslashes($lead_source)."',
			SalesStage='".addslashes($SalesStage)."',
			OpportunityType='".addslashes($OpportunityType)."',
			NextStep='".addslashes($NextStep)."', 
			description='".addslashes($description)."',
			Probability='".addslashes($Probability)."',
			Campaign_Source='".addslashes($Campaign_Source)."',
			ContactName='".addslashes($ContactName)."', 
			forecast_amount='".addslashes($forecast_amount)."',
			oppsite='".addslashes($oppsite)."',
			Status='".$Status."'
			where OpportunityID=".$OpportunityID; 
		

			$this->query($strSQLQuery, 0);

			return 1;
		}

			function  GetOpportunity($OpportunityID,$Status)
		{
			$strSQLQuery = "select l.* from c_opportunity l ";

			$strSQLQuery .= (!empty($OpportunityID))?(" where l.OpportunityID=".$OpportunityID):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and l.Status=".$Status):("");
			$strSQLQuery .= ($_SESSION['AdminType']!="admin")?(" and l.AssignTo='".$_SESSION['AdminID']."' "):("");
			

			return $this->query($strSQLQuery, 1);
		}	


		function changeOpportunityStatus($OpportunityID)
		{
			$sql="select * from c_opportunity where OpportunityID=".$OpportunityID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_opportunity set Status='$Status' where OpportunityID=".$OpportunityID;
				$this->query($sql,0);				

				return true;
			}			
		}

		function RemoveOpportunity($OpportunityID)
		{

			
			
			$strSQLQuery = "delete from c_opportunity where OpportunityID=".$OpportunityID; 
			$this->query($strSQLQuery, 0);			

			

			return 1;

		}

		/***************************Compaign**********************/

		function  ListCampaign($id=0,$SearchKey,$SortBy,$closingdate,$AscDesc)
		{
			global $Config;
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where c.campaignID=".$id):(" where 1 ");
			
			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (c.assignedTo='".$_SESSION['AdminID']."' OR c.created_id='".$_SESSION['AdminID']."') "):("");
			 if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy."  = '".$SearchKey."')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( c.campaignname like '%".$SearchKey."%' or c.campaigntype like '%".$SearchKey."%' or c.campaignstatus like '%".$SearchKey."%' or c.expectedrevenue like '%".$SearchKey."%' or closingdate like '%".$SearchKey."%' ) "  ):("");			}

				$strAddQuery .= (!empty($closingdate))?(" and ( c.closingdate = '".$closingdate."')"):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by c.campaignID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" DESC");
              

			$strSQLQuery = "select c.*,d.Department,e.EmpID,e.Role,e.UserName as AssignTo from c_campaign c left outer join  h_employee e on e.EmpID=c.assignedTo left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		function AddCampaign($arryDetails)
		{  
			 
			global $Config;
			extract($arryDetails);
			
			//if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
			 $expCloseDate=$CloseDate.' '.$CloseTime;
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			

			 $strSQLQuery = "insert into c_campaign (campaignname,campaign_no,assignedTo,campaignstatus,campaigntype,product,targetaudience,closingdate,sponsor, 	targetsize,numsent,budgetcost,actualcost,expectedresponse,expectedrevenue,expectedsalescount,actualsalescount,expectedresponsecount,actualresponsecount,expectedroi,actualroi,description,created_by,created_id,parent_type,parentID ) values('".addslashes($campaignname)."','".addslashes($campaign_no)."','".addslashes($assignedTo)."','".addslashes($campaignstatus)."', '".addslashes($campaigntype)."', '".addslashes($product)."',  '".addslashes($targetaudience)."','".addslashes($closingdate)."','".addslashes($sponsor)."','".addslashes($targetsize)."','".addslashes($numsent)."',  '".addslashes($budgetcost)."', '".addslashes($actualcost)."',  '".addslashes($expectedresponse) ."','".addslashes($expectedrevenue)."','".addslashes($expectedsalescount)."','".addslashes($actualsalescount)."','".addslashes($expectedresponsecount)."','".addslashes($actualresponsecount)."','".addslashes($expectedroi)."','".addslashes($actualroi)."','".addslashes($description)."','".addslashes($created_by)."','".addslashes($created_id)."','".addslashes($parent_type)."','".addslashes($parentID)."')";
			
		

			$this->query($strSQLQuery, 0);


			/*if($LeadID!=''){
              $strUpSQLQuery = "update c_lead set  Campaign=0 where leadID=".$LeadID;


                $this->query($strUpSQLQuery, 0);
			}*/

			

			$CampaignID = $this->lastInsertId();

			 if($assignedTo!=''){

				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$assignedTo."'";
				$arryEmp = $this->query($strSQLQuery, 1);

				$ToEmail = $arryEmp[0]['Email'];
				$CC = $Config['AdminEmail'];

				$assignEmail=$arryEmp[0]['Email'];


				

		

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."CompaignAssigned.htm");
			$subject  = "  Assigned to You ";
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[COMNAME]",$campaignname, $contents);
                        $contents = str_replace("[COMSTATUS]",$campaignstatus, $contents);


			$contents = str_replace("[COMTYPE]",$campaigntype, $contents);
			$contents = str_replace("[TARGETAUDI]",$targetaudience, $contents);
			$contents = str_replace("[NUMSENT]",$numsent, $contents);
			$contents = str_replace("[BUDGETCOST]",$budgetcost, $contents);
			$contents = str_replace("[ACTUALCOST]",$actualcost, $contents);

			$contents = str_replace("[CLOSEDATE]",date($Config['DateFormat']." H:i:s" , strtotime($closingdate)), $contents);
			
			//$contents = str_replace("[COMPANY]",$company,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($assignEmail);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Campaign [".$campaignname."] - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents; 
#echo $mail->Subject.','.$assignEmail.$contents; exit;  
			if($Config['Online'] == 1){
				 $mail->Send();	
			}

		}
		#echo $mail->Subject.','.$primary_email.','.$assignEmail.$contents; exit;

			if(!empty($CampaignID)){
			//Send Acknowledgment Email to admin
			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."Compaign_Admin.htm");
			$subject  = "  Assigned to You ";
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[COMNAME]",$campaignname, $contents);
                        $contents = str_replace("[COMSTATUS]",$campaignstatus, $contents);


			$contents = str_replace("[COMTYPE]",$campaigntype, $contents);
			$contents = str_replace("[TARGETAUDI]",$targetaudience, $contents);
			$contents = str_replace("[NUMSENT]",$numsent, $contents);
			$contents = str_replace("[BUDGETCOST]",$budgetcost, $contents);
			$contents = str_replace("[ACTUALCOST]",$actualcost, $contents);

			$contents = str_replace("[CLOSEDATE]",date($Config['DateFormat']." H:i:s" , strtotime($closingdate)), $contents);

			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($_SESSION['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." -New  Campaign - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['Online'] == 1){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;
                     }
			return $CampaignID;

		}


		function UpdateCampaign($arryDetails){   
			
			global $Config;
//echo"<pre>";
			//print_r($arryDetails);
			
					extract($arryDetails);
    				$expCloseDate=$CloseDate.' '.$CloseTime;
			
			
			//if(empty($Status)) $Status=1;
             $strSQLQuery = "update c_campaign set  campaignname='".addslashes($campaignname)."',
													campaign_no='".addslashes($campaign_no)."',
													assignedTo='".addslashes($assignedTo)."',
													campaignstatus='".addslashes($campaignstatus)."',
													campaigntype='".addslashes($campaigntype)."',
													product='".addslashes($product)."',
													targetaudience='".addslashes($targetaudience)."',
													closingdate='".addslashes($closingdate)."',
													sponsor='".addslashes($sponsor)."',													 
													targetsize='".addslashes($targetsize)."',
													numsent='".addslashes($numsent)."',
													budgetcost='".addslashes($budgetcost)."',
													actualcost='".addslashes($actualcost)."',
													expectedresponse='".addslashes($expectedresponse)."',
													expectedrevenue='".addslashes($expectedrevenue)."',
													expectedsalescount='".addslashes($expectedsalescount)."',
													actualsalescount='".addslashes($actualsalescount)."',
													expectedresponsecount='".addslashes($expectedresponsecount)."',
													actualresponsecount='".addslashes($actualresponsecount)."',
													expectedroi='".addslashes($expectedroi)."',
													actualroi='".addslashes($actualroi)."',
													description='".addslashes($description)."',
													actualroi='".addslashes($actualroi)."',
													parent_type='".addslashes($parent_type)."',
													parentID='".addslashes($parentID)."'
								where campaignID=".$campaignID; 
		

			$this->query($strSQLQuery, 0);

			 if($assignedTo!=''){

				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$assignedTo."'";
				$arryEmp = $this->query($strSQLQuery, 1);

				$ToEmail = $arryEmp[0]['Email'];
				$CC = $Config['AdminEmail'];

				$assignEmail=$arryEmp[0]['Email'];

		

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."CompaignAssigned.htm");
			$subject  = "  Assigned to You ";
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[COMNAME]",$campaignname, $contents);
                        $contents = str_replace("[COMSTATUS]",$campaignstatus, $contents);


			$contents = str_replace("[COMTYPE]",$campaigntype, $contents);
			$contents = str_replace("[TARGETAUDI]",$targetaudience, $contents);
			$contents = str_replace("[NUMSENT]",$numsent, $contents);
			$contents = str_replace("[BUDGETCOST]",$budgetcost, $contents);
			$contents = str_replace("[ACTUALCOST]",$actualcost, $contents);

			$contents = str_replace("[CLOSEDATE]",date($Config['DateFormat']." H:i:s" , strtotime($closingdate)), $contents);
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($assignEmail);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Campaign [".$CampaignName."][".$CampaignID."] - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['Online'] == 1){
				 $mail->Send();	
			}

		}


			return 1;
		}

			function  GetCampaign($campaignID,$Status)
		{
			$strSQLQuery = "select l.* from c_campaign l ";

			$strSQLQuery .= (!empty($campaignID))?(" where l.campaignID=".$campaignID):(" where 1 ");
			
			$strSQLQuery .= ($_SESSION['AdminType']!="admin")?(" and l.assignedTo='".$_SESSION['AdminID']."' "):("");
			//$strSQLQuery .= ($Status>0)?(" and l.Status=".$Status):("");
			

			return $this->query($strSQLQuery, 1);
		}	


		function changeCampaignStatus($campaignID)
		{
			$sql="select * from c_campaign where campaignID=".$campaignID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update c_campaign set Status='$Status' where campaignID=".$campaignID;
				$this->query($sql,0);				

				return true;
			}			
		}

		function RemoveCampaign($campaignID)
		{

			
			
			$strSQLQuery = "delete from c_campaign where campaignID=".$campaignID; 
			$this->query($strSQLQuery, 0);			

			

			return 1;

		}

		function RemoveSelectCompaign($sid)
		{

			
			$strSQLQuery="delete from c_compaign_sel  where sid=".$sid;
			//$strSQLQuery = "delete from c_compaign_sel where campaignID=".$campaignID; 
			$this->query($strSQLQuery, 0);			

			

			return 1;

		}


		

		function AddMultipleCompaign($arrydetail){

			
			extract($arrydetail);
			//print_r($campaignID);
			
			for($i=0;$i<sizeof($ID);$i++){

				$sql="select compaignID from c_compaign_sel where compaignID ='".$ID[$i]."' and parent_type='".$parent_type."' and parentID=".$parentID ; 
			$arryRow = $this->query($sql);

			if(sizeof($arryRow)==0){
            
             $strSQLQuery = "insert into c_compaign_sel (compaignID,parent_type,parentID,mode_type ) values('".$ID[$i]."','".addslashes($parent_type)."','".addslashes($parentID)."','".addslashes($mode_type)."')";

			 $this->query($strSQLQuery, 0);	
			 
			}

				//echo $campaignID[$i];

			
			}

			return true;

		}

		function  GetCompaignData($id=0,$parentType,$mode_type)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where c2.parentID=".$id):(" where 1 ");
			$strAddQuery .= (!empty($id))?(" and c2.parent_type='".$parentType."'"):("  ");
			$strAddQuery .= (!empty($id))?(" and c2.mode_type='".$mode_type."'"):("  ");
			$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and c.assignedTo='".$_SESSION['AdminID']."' "):("");

			$strAddQuery .= " and c2.deleted=0";

			$strAddQuery .= " order by c2.sid Desc ";

			 $strSQLQuery = "select c.campaignname,c.campaigntype,c.campaignstatus,c.expectedrevenue,c.closingdate,c.assignedTo,e.EmpID,c.campaignID,d.Department, e.Role,e.UserName as AssignTo,c2.sid,c2.parent_type,c2.parentID,c2.mode_type from c_campaign c left outer join  h_employee e on e.EmpID=c.assignedTo left outer join  h_department d on e.Department=d.depID  left outer join  c_compaign_sel c2 on c.campaignID=c2.compaignID  ".$strAddQuery;

			

			return $this->query($strSQLQuery, 1);
		}

		function  GetTicketData($id=0,$parentType,$mode_type)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where c2.parentID=".$id):(" where 1 ");
			$strAddQuery .= (!empty($id))?(" and c2.parent_type='".$parentType."'"):("  ");
			$strAddQuery .= (!empty($id))?(" and c2.mode_type='".$mode_type."'"):("  ");
			$strAddQuery .= ($_SESSION['AdminType']!="admin")?(" and t.AssignedTo='".$_SESSION['AdminID']."' "):("");

			$strAddQuery .= " and c2.deleted=0";

			$strAddQuery .= " order by c2.sid Desc ";

			 $strSQLQuery = "select t.title,t.ticketDate,t.TicketID,t.AssignedTo,t.Status,d.Department,e.EmpID,e.Role,e.UserName as AssignTo,c2.sid,c2.parent_type,c2.parentID from c_ticket t left outer join  h_employee e on e.EmpID=t.AssignedTo left outer join  h_department d on e.Department=d.depID  left outer join  c_compaign_sel c2 on t.TicketID=c2.compaignID  ".$strAddQuery;

			

			return $this->query($strSQLQuery, 1);
		}


		/******************Reports*****************/

		function  LeadReport($arryDetails)
		{
//$FilterBy,$FromDate,$ToDate,$Month,$Year,$leadID,$source,$Status
extract($arryDetails);

			$strAddQuery = "";
			if($fby=='Year'){
				$strAddQuery .= " and YEAR(l.JoiningDate)='".$y."'";
			} else{
				$strAddQuery .= (!empty($f))?(" and l.JoiningDate>='".$f."'"):("");
				$strAddQuery .= (!empty($t))?(" and l.JoiningDate<='".$t."'"):("");
			}
			$strAddQuery .= (!empty($w))?(" and l.leadID='".$w."'"):("");
			$strAddQuery .= (!empty($lst))?(" and l.lead_status='".$lst."'"):("");
			$strAddQuery .= (!empty($lso))?(" and l.lead_source='".$lso."'"):("");

			 $strSQLQuery = "select  l.JoiningDate,l.leadID,l.FirstName, l.LastName, l.lead_source,l.lead_status,l.type   from c_lead l  where 1 ".$strAddQuery." order by l.JoiningDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}

function  GetNumLeadByYear($FilterBy,$month,$Year,$FromDate,$ToDate,$leadID,$Source,$Status)
		{

			$strAddQuery = "";
			if($FilterBy=='Year'){
				$strAddQuery .= " and YEAR(a.JoiningDate)='".$Year."'";
			} if($fby=='Month'){
				$strAddQuery .= " and MONTH(a.JoiningDate)='".$FromDate."'";
		    }else{
				$strAddQuery .= (!empty($FromDate))?(" and a.JoiningDate >= '".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and a.JoiningDate <= '".$ToDate."'"):("");
			}
				
			
		   
			$strAddQuery .= (!empty($leadID))?(" and a.leadID='".$leadID."'"):("");
			$strAddQuery .= (!empty($Status))?(" and a.lead_status='".$Status."'"):("");
			$strAddQuery .= (!empty($Source))?(" and a.lead_source='".$Source."'"):("");

			 $strSQLQuery = "select count(a.leadID) as TotalLead  from c_lead a where YEAR(a.JoiningDate)='".$Year."' ".$strAddQuery." order by a.JoiningDate desc"; 
				
			return $this->query($strSQLQuery, 1);		
		}
	

		function  OpportunityReport($arryDetails)
		{
//$FilterBy,$FromDate,$ToDate,$Month,$Year,$leadID,$source,$Status
          extract($arryDetails);

			$strAddQuery = "";
			if($fby=='Year'){
				$strAddQuery .= " and YEAR(p.AddedDate)='".$y."'";
			} if($fby=='Month'){
				$strAddQuery .= " and MONTH(p.AddedDate)='".$m."'";
		    }else{
				$strAddQuery .= (!empty($f))?(" and p.AddedDate>='".$f."'"):("");
				$strAddQuery .= (!empty($t))?(" and p.AddedDate<='".$t."'"):("");
			}
			$strAddQuery .= (!empty($w))?(" and p.OpportunityID='".$w."'"):("");
			$strAddQuery .= (!empty($lst))?(" and p.lead_source='".$lst."'"):("");
			$strAddQuery .= (!empty($lst))?(" and p.SalesStage='".$lso."'"):("");
			

			 $strSQLQuery = "select  p.AddedDate,p.OpportunityID,p.OpportunityName, p.SalesStage, p.lead_source   from c_opportunity p  where 1 ".$strAddQuery." order by p.AddedDate desc";
				
			return $this->query($strSQLQuery, 1);		
		}

function  GetNumOpportunityByYear($FilterBy,$month,$Year,$FromDate,$ToDate,$Source,$Status)
		{

			$strAddQuery = "";
			
			$strAddQuery .= (!empty($FromDate))?(" and a.AddedDate >= '".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and a.AddedDate <= '".$ToDate."'"):("");
			
			
			$strAddQuery .= (!empty($Source))?(" and a.lead_source='".$Status."'"):("");
			$strAddQuery .= (!empty($lst))?(" and a.SalesStage='".$Source."'"):("");

			 $strSQLQuery = "select count(a.OpportunityID) as TotalOpportunity  from c_opportunity a where YEAR(a.AddedDate)='".$Year."' ".$strAddQuery." order by a.AddedDate desc"; 
				
			return $this->query($strSQLQuery, 1);		
		}


	function GetAssigneeUser($arrayDetail) {
		 $strSQLQuery = "select e.*,d.Department as emp_dep,d.depID from h_employee e left outer join  h_department d on e.Department=d.depID  WHERE e.Status=1 and e.Division in (5) and  e.EmpID in (".$arrayDetail.")";
		return $this->query($strSQLQuery, 1);

	}
	

}
?>
