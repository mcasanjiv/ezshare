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
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where l.leadID=".$id):(" where  l.Status=1 ");

			if($SearchKey=='active' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and l.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and l.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' or l.primary_email like '%".$SearchKey."%' or l.leadID like '%".$SearchKey."%' ) "  ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by l.leadID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			  $strSQLQuery = "select l.leadID,l.Status,l.primary_email,l.FirstName,l.LastName,l.AssignTo,l.lead_status,l.description,l.company,d.Department,e.Role,e.UserName as AssignTo from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		


		
		function  ConvertLead($leadID,$Status=0)
		{
			$strSQLQuery = "update c_lead set  Status='".$Status."'";

			$strSQLQuery .= (!empty($leadID))?(" where leadID=".$leadID):(" where 1 ");
			//$strSQLQuery .= ($Status>0)?(" and l.Status=".$Status):("");

			$this->query($strSQLQuery, 0);
		}	


		function  GetLead($leadID,$Status)
		{
			$strSQLQuery = "select l.* from c_lead l ";

			$strSQLQuery .= (!empty($leadID))?(" where l.leadID=".$leadID):(" where 1 ");
			$strSQLQuery .= ($Status>0)?(" and l.Status=".$Status):("");

			return $this->query($strSQLQuery, 1);
		}		
		

		function  GetLeadsForprimary_email($leadID)
		{
			$strSQLQuery = "select leadID,primary_email from c_lead where Status=1";
			$strSQLQuery .= (!empty($leadID))?(" and leadID!=".$leadID):("");
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllLeads($Status)
		{
			$strSQLQuery = "select leadID,primary_email from c_lead where 1 ";

			$strSQLQuery .= ($Status>0)?(" and Status=".$Status.""):("");

			$strSQLQuery .= " order by primary_email Asc";

			return $this->query($strSQLQuery, 1);
		}


		function  GetLeadDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where l.leadID=".$id):(" where 1 ");

			$strAddQuery .= " order by l.JoiningDate Desc ";

			$strSQLQuery = "select l.*, e.Role,e.UserName as AssignTo from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  department d on e.Department=d.depID  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddLead($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];

		 $strSQLQuery = "insert into c_lead ( primary_email,company,Website,FirstName,LastName,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber,lead_status,lead_source,Status, JoiningDate,  OtherState, OtherCity,  ipaddress, UpdatedDate,AssignTo,AnnualRevenue,designation,description,Industry ) values( '".addslashes($primary_email)."', '".addslashes($company)."','".addslashes($Website)."','".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($LandlineNumber)."','".addslashes($lead_status)."','".addslashes($lead_source)."',  '".$Status."', '".$JoiningDatl."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."','".$ipaddress."',  '".date('Y-m-d')."','".addslashes($AssignTo)."','".addslashes($AnnualRevenue)."','".addslashes($designation)."','".addslashes($description)."','".addslashes($Industry)."')";

			$this->query($strSQLQuery, 0);

			

			$LeadID = $this->lastInsertId();

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."Leaddetails.htm");
			$subject  = " Details";
			
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Lead - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['DbUser'] != 'root'){
				 $mail->Send();	
			}

			
			//Send Acknowledgment Email to admin
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
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Lead - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $LeadID;

		}


		

		function UpdateLead($arryDetails){   
			extract($arryDetails);

			$UserName = trim($FirstNaml.' '.$LastName);
	
			
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
			
			if($main_city_id>0) $OtherCity = '';
			if($main_state_id>0) $OtherState = '';
			if(empty($Status)) $Status=1;
			 $strSQLQuery = "update c_lead set  FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."',Website='".addslashes($Website)."',
			primary_email='".addslashes($primary_email)."',designation='".addslashes($designation)."',
			Industry='".addslashes($Industry)."',AnnualRevenue='".addslashes($AnnualRevenue)."',
			lead_source='".addslashes($lead_source)."',AssignTo='".addslashes($AssignTo)."',lead_status='".addslashes($lead_status)."',Address='".addslashes($Address)."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."',  OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',company='".addslashes($company)."', description='".addslashes($description)."'
			where leadID=".$leadID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}





	
		
		function IsActivatedLead($leadID,$verification_code)
		{
			$sql = "select * from c_lead where leadID='".$leadID."' and verification_code='".$verification_codl."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['leadID']>0) {
				if ($arryRow[0]['Status']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}

		

		
		
		function RemoveLead($leadID)
		{

			$strSQLQuery = "delete from c_lead where leadID=".$leadID; 
			$this->query($strSQLQuery, 0);			
			return 1;

		}

		function UpdateImage($Image,$leadID)
		{
			$strSQLQuery = "update c_lead set Image='".$Imagl."' where leadID=".$leadID;
			return $this->query($strSQLQuery, 0);
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
			$sql="select leadID from c_lead where leadID in (".$leadIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update c_lead set Status=".$Status." where leadID in (".$leadIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function ValidateLead($primary_email,$Password){
			$strSQLQuery = "select * from c_lead where primary_email='".$primary_email."' and Password='".md5($Password)."' and Status=1";
			return $this->query($strSQLQuery, 1);
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
	
		
		function UpdatePasswordEncrypted($leadID,$Password)
		{
				 $sql = "update c_lead set Password='".md5($Password)."', PasswordUpdated='1'  where leadID = ".$leadID;
				$rs = $this->query($sql,0);
				
				return true;

		}
	/************Ticket Function*****************/


	function AddTicket($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];

			$strSQLQuery = "insert into c_ticket ( title,AssignedTo,category,Name,day,hours, priority, description, solution,Status,ticketDate ) values( '".addslashes($title)."', '".addslashes($AssignedTo)."','".addslashes($category)."','".addslashes($Name)."', '".addslashes($day)."', '".addslashes($hours)."',  '".$priority."', '".addslashes($description)."', '".addslashes($solution)."','".$Status."','".date('Y-m-d H:i:s')."')";

			$this->query($strSQLQuery, 0);

			$TicketID = $this->lastInsertId(); 

			$htmlPrefix = eregi('admin',$_SERVER['PHP_SELF'])?("../".$Config['primary_emailTemplateFolder']):($Config['primary_emailTemplateFolder']);

			$_SESSION['mess_account'] = SUCCESSFULLY_REGISTERED;
			$contents = file_get_contents($htmlPrefix."logindetails.htm");
			$subject  = "Account Details";
			
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[primary_email]",$primary_email,$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($primary_email);
			$mail->sender($Config['SiteName'], $Config['Adminprimary_email']);   
			$mail->Subject = $Config['SiteName']." - Lead - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['DbUser'] != 'root'){
				 $mail->Send();	
			}

			//echo $LeadApproval.$primary_email.$Config['Adminprimary_email'].$contents; 



			if($Config['RecieveSignprimary_email']=='y'){
					//Send Acknowledgment primary_email to admin
					$contents = file_get_contents($htmlPrefix."admin_signup.htm");

					$contents = str_replace("[URL]",$Config['Url'],$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

					$contents = str_replace("[FULLNAME]",$FirstNaml." ".$LastName, $contents);
					$contents = str_replace("[primary_email]",$primary_email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[USERNAME]",$UserName,$contents);
					$contents = str_replace("[ReferenceNo]",$leadID,$contents);

					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Config['Adminprimary_email']);
					$mail->sender($Config['SiteName'], $Config['Adminprimary_email']);   
					$mail->Subject = $Config['SiteName']." - Lead - ".$subject;
					$mail->IsHTML(true);
					//echo $Config['Adminprimary_email'].$contents; exit;
					$mail->Body = $contents;    
					if($Config['DbUser'] != 'root'){
						$mail->Send();	
					}

			}


			return $leadID;

		}


	function  ListTicket($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where t.TicketID=".$id):(" where 1 ");

			if($SearchKey=='active' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and t.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='t.Status' || $SortBy=='') ){
				$strAddQuery .= " and t.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( t.title like '%".$SearchKey."%' or t.priority like '%".$SearchKey."%' or t.TicketID like '%".$SearchKey."%' ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by t.TicketID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select t.TicketID,t.Status,t.title,t.Name,t.AssignedTo,t.description,t.priority from c_ticket t ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	

		function  GetTicket($TicketID,$Status)
		{
			$strSQLQuery = "select t.* from c_ticket t where  t.TicketID=".$TicketID;

			//$strSQLQuery .= (!empty($leadID))?(" where t.TicketID=".$TicketID):(" where 1 ");
			//$strSQLQuery .= ($Status>0)?(" and t.Status=".$Status):("");
//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);
		}		

	
function RemoveTicket($TicketID)
		{

			/*$strSQLQuery = "select Image,Resume from contact where contactID=".$contactID; 
			$arryRow = $this->query($strSQLQuery, 1);

			if($Front > 0){
				$ImgDirPrefix = '';
			}else{
				$ImgDirPrefix = '../';
			}

			$ImgDir = $ImgDirPrefix.'upload/contact/';
			$ResumeDir = $ImgDirPrefix.'upload/resume/';

		
			if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){							
				unlink($ImgDir.$arryRow[0]['Image']);	
			}

			if($arryRow[0]['Resume'] !='' && file_exists($ResumeDir.$arryRow[0]['Resume']) ){					
				unlink($ResumeDir.$arryRow[0]['Resume']);	
			}			
        */
			
			$strSQLQuery = "delete from c_ticket where TicketID=".$TicketID; 
			$this->query($strSQLQuery, 0);			

			//$sql = "delete from admin_permission where contactID = ".$contactID;
			//$this->query($sql, 0);			


			return 1;

		}
		
			function UpdateTicketDetail($arryDetails){   
			extract($arryDetails);
			$UserName = trim($FirstNaml.' '.$LastName);
			$strSQLQuery = "update c_ticket set  title='".addslashes($title)."', AssignedTo='".addslashes($AssignedTo)."',Status='".addslashes($Status)."',priority='".addslashes($priority)."',category='".addslashes($category)."',day='".addslashes($day)."',Hours='".$Hours."'	where TicketID=".$TicketID; 
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
			extract($arryDetails);		
			

			$strSQLQuery = "update c_ticket set solution='".addslashes($solution)."'
			where TicketID=".$TicketID;
			$this->query($strSQLQuery, 0);
			return 1;
		}
		
		/************ Comment Section ***********/

		function AddComment($arrydetail){

            extract($arrydetail);	
			$time=time();
            $strSQLQuery = "insert into c_comments ( EmpID,Comment,TicketID,CommentDate,timestamp ) values( '".addslashes($AdminID)."', '".addslashes($Comment)."','".addslashes($TicketID)."','".date('Y-m-d H:i:s')."','".$time."')";

			$this->query($strSQLQuery, 0);

			$cmtID = $this->lastInsertId(); 
			return $cmtID;
         }

		function GetCommentUser($id,$status=0){

         $strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where c.TicketID=".$id):(" where 1 ");

			$strAddQuery .= " order by c.CommentDate Desc ";

			 $strSQLQuery = "select c.*,e.UserName,e.Image,e.Department from c_comments c left outer join h_employee e  on e.EmpID=c.EmpID left outer join c_comments t on c.TicketID=t.TicketID   ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}


		/*********************Document Section ***********************/
      function  ListDocument($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where d.documentID=".$id):(" where 1 ");

			if($SearchKey=='active' && ($SortBy=='d.Status' || $SortBy=='') ){
				$strAddQuery .= " and d.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='d.Status' || $SortBy=='') ){
				$strAddQuery .= " and d.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( d.FileName like '%".$SearchKey."%' or d.title like '%".$SearchKey."%' or d.documentID like '%".$SearchKey."%' ) " ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by d.documentID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select d.documentID,d.DownloadType,d.AddedDate,d.Status,d.title,d.FileName,d.AssignTo,d.description,e.Role,e.UserName as AssignTo from c_document d left outer join  h_employee e on e.EmpID=d.AssignTo  ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

        function AddDocument($arrydetail){
			
            extract($arrydetail);	
			$time=time();
            $strSQLQuery = "insert into c_document ( linkId,title,module,DownloadType,AddedDate,description,AddedBy,AssignTo ) values( '".addslashes($linkId)."', '".addslashes($title)."','".addslashes($module)."','".addslashes($DownloadType)."','".date('Y-m-d H:i:s')."','".addslashes($description)."','".addslashes($AddedBy)."','".$AssignTo."')";
		  

			$this->query($strSQLQuery, 0);

			$cmtID = $this->lastInsertId(); 
			return $cmtID;
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
			extract($arryDetails);
			$UserName = trim($FirstNaml.' '.$LastName);
			$strSQLQuery = "update c_document set  title='".addslashes($title)."', AssignedTo='".addslashes($AssignedTo)."',Status='".addslashes($Status)."',priority='".addslashes($priority)."',category='".addslashes($category)."',day='".addslashes($day)."',Hours='".$Hours."'	where TicketID=".$TicketID; 
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





		/***************************Opprtunity**********************/

		function  ListOpportunity($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where l.leadID=".$id):(" where  l.Status=0 ");

			if($SearchKey=='active' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and l.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='l.Status' || $SortBy=='') ){
				$strAddQuery .= " and l.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and ( l.FirstName like '%".$SearchKey."%' or l.primary_email like '%".$SearchKey."%' or l.leadID like '%".$SearchKey."%' ) "  ):("");			}

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by l.leadID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc");

			 $strSQLQuery = "select l.leadID,l.Status,l.primary_email,l.FirstName,l.LastName,l.AssignTo,l.lead_status,l.description,l.company,d.Department,e.Role,e.UserName as AssignTo from c_lead l left outer join  h_employee e on e.EmpID=l.AssignTo left outer join  department d on e.Department=d.depID ".$strAddQuery;
			
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	


		function AddOpportunity($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status=0;
			$UserName = trim($FirstName.' '.$LastName);
			$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];

			echo $strSQLQuery = "insert into c_lead ( primary_email,company,Website,FirstName,LastName,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber,lead_status,lead_source,Status, JoiningDate,  OtherState, OtherCity,  ipaddress, UpdatedDate,AssignTo,AnnualRevenue,designation,description,Industry ) values( '".addslashes($primary_email)."', '".addslashes($company)."','".addslashes($Website)."','".addslashes($FirstName)."', '".addslashes($LastName)."', '".addslashes($Address)."',  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($LandlineNumber)."','".addslashes($lead_status)."','".addslashes($lead_source)."',  '".$Status."', '".$JoiningDatl."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."','".$ipaddress."',  '".date('Y-m-d')."','".addslashes($AssignTo)."','".addslashes($AnnualRevenue)."','".addslashes($designation)."','".addslashes($description)."','".addslashes($Industry)."')";
			exit;

			$this->query($strSQLQuery, 0);

			

			$LeadID = $this->lastInsertId();

			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."Leaddetails.htm");
			$subject  = " Details";
			
			$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$primary_email,$contents);
			//$contents = str_replace("[PASSWORD]",$Password,$contents);	
			//$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Lead - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;   
			if($Config['DbUser'] != 'root'){
				 $mail->Send();	
			}

			
			//Send Acknowledgment Email to admin
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
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Lead - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['DbUser'] != 'root'){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $LeadID;

		}

	

}
?>
