<?
class activity extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function activity(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addActivity($arryDetails)
	{
		@extract($arryDetails);	
		$arryAsign = explode(":",$assignedTo);

		
                      if($assign == 'User'){
                         $AssignUser = $AssignToUser;
                         $AssignType = $assign;
                      }else{
			  $arryAsign = explode(":",$AssignToGroup);
                          $AssignUser = $arryAsign[0];
			  $AssignType = $assign;
			  $GroupID =  $arryAsign[1];
				

			}

		$sql = "insert into c_activity  (subject,title,created_by,created_id,description,startDate,startTime,closeDate,closeTime,status,activityType,location,priority,visibility,Notification,reminder,parent_type,parentID,assignedTo,AssignType,GroupID,RelatedType,LeadID,OpprtunityID,CampaignID) values( '".addslashes($subject)."', '".addslashes($title)."','".addslashes($created_by)."','".addslashes($created_id)."','".addslashes($description)."', '".$startDate."','".$startTime."','".$closeDate."','".$closeTime."','".$status."','".$activity_type."', '".$location."', '".addslashes($priority)."', '".addslashes($visibility)."','".$Notification."','".$reminder."','".$parent_type."','".$parentID."','".$AssignUser."','".$AssignType."','".$GroupID."','".$RelatedType."','".$LeadID."','".$OpprtunityID."','".$CampaignID."')";


		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();


		return $lastInsertId;

	}

	function updateDragActivity($arryDetails)
	{
		@extract($arryDetails);	

		//print_r($arryDetails);

		$start= explode(' ',$start);
		$end= explode(' ',$end);

		$sql = "update c_activity set startDate = '".$start[0]."',
		startTime = '".$start[1]."',
		closeDate = '".$end[0]."',
		closeTime = '".$end[1]."'
		where activityID = ".$id; 
		$rs = $this->query($sql,0);
	}	

	function updateActivity($arryDetails)
	{
		@extract($arryDetails);	

		
                      if($assign == 'User'){
                         $AssignUser = $AssignToUser;
                         $AssignType = $assign;
                      }else{
			  $arryAsign = explode(":",$AssignToGroup);
                          $AssignUser = $arryAsign[0];
			  $AssignType = $assign;
			  $GroupID =  $arryAsign[1];
				

			}


		$sql = "update c_activity set subject = '".addslashes($subject)."', 
		title = '".addslashes($title)."', 
		description = '".addslashes($description)."',
		assignedTo  = '".$AssignUser."',
		AssignType  = '".$AssignType."',
		GroupID  = '".$GroupID."',
		startDate = '".$startDate."',
		startTime = '".$startTime."',
		closeDate = '".$closeDate."',
		closeTime = '".$closeTime."',
		status = '".addslashes($event_status)."',
		activityType = '".addslashes($activity_type)."',
		location = '".addslashes($location)."',
		priority = '".addslashes($priority)."',
		visibility = '".addslashes($visibility)."',
		Notification = '".addslashes($Notification)."',
		RelatedType  = '".addslashes($RelatedType)."',

		LeadID = '".$LeadID."',
		OpprtunityID = '".$OpprtunityID."',
		CampaignID = '".$CampaignID."',
		reminder = '".addslashes($reminder)."'


		where activityID = ".$activityID; 
		$rs = $this->query($sql,0);

		if(sizeof($rs))
		return true;
		else
		return false;

	}



	function addActivityEmp($arryDetails)
	{

		extract($arryDetails);
		$sql = "delete from c_activity_emp where activityID =".$_POST['activityID'];
		$rs = $this->query($sql,0);
		$arryEmpID=explode(',',$EmpID);
		for($i=0;$i<sizeof($arryEmpID); $i++){
			$sql = "insert into c_activity_emp( EmpID, activityID) values('".$arryEmpID[$i]."', '".$_POST['activityID']."')";
			$rs = $this->query($sql,0);
		}

	return 1;

	}

	function addAssignEmp($arryDetails)
	{

		extract($arryDetails);
		$sql = "delete from c_assign_emp where activityID ='".$_POST['activityID']."'";
		$rs = $this->query($sql,0);
		$arryEmpID=explode(',',$assignedTo);
		for($i=0;$i<sizeof($arryEmpID); $i++){
			$sql = "insert into c_assign_emp( EmpID, activityID) values('".$arryEmpID[$i]."', '".$_POST['activityID']."')";
			$rs = $this->query($sql,0);
		}

	return 1;

	}



	function getActivityEmp($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and activityID = '".$id."'"):("");
		$sql = "select EmpID from c_activity_emp ".$sql." order by EmpID Asc" ; 
		return $this->query($sql, 1);
	}

	function getActivityEmp2($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and e.activityID = '".$id."'"):("");
		$sql = "select e.*,em.UserName,em.Email,d.Department ,em.JobTitle,em.Image  from c_activity_emp e inner join h_employee em on e.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID".$sql." order by e.activityID Asc" ; 
		return $this->query($sql, 1);
	}



function getAssignEmp($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and e.activityID = ".$id):("");
		$sql = "select e.*,em.UserName,em.Email,d.Department ,em.JobTitle,em.Image  from c_assign_emp e inner join h_employee em on e.EmpID=em.EmpID left outer join  h_department d on em.Department=d.depID".$sql." order by e.activityID Asc" ; 
		return $this->query($sql, 1);
	}

	function GetActivity($activityID,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($activityID))?(" and activityID = '".$activityID."'"):("");
		
		$sql = "select * from c_activity   ".$sql;

		

		return $this->query($sql, 1);
	}

	function getUpActivity($Limit)
	{
		$sql = " where  e.startDate>=now() ";

		$sql = "select e.*, from c_activity e  ".$sql." order by e.startDate asc";

		$sql .= (!empty($Limit))?(" limit 0,".$Limit):("");

		return $this->query($sql, 1);
	}


	
	function changeActivityStatus($activityID)
	{
		$sql="select * from c_activity where activityID=".$activityID;
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update c_activity set Status='$Status' where activityID=".$activityID;
			$this->query($sql,0);
			
		}
		if($Status==1 && $rs[0]['Status']!=1 ){
				$this->ActivityActiveEmail($activityID);
			}
			return true;			
	}

	
	function deleteActivity($activityID)
	{


		$sql = "delete from c_activity where activityID = ".$activityID;
		$rs = $this->query($sql,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	function SendEmailToAdmin($activityID)
		{
			global $Config;

			$arryActivity = $this->GetActivity($activityID,'');
			if($arryActivity[0]['created_by'] = 'Admin'){
			$CreateBy = "Administrator";
			}else{
                        $CreateBy = "User";

			}

			

				//$ActivityTitle = GetActivityTitle($arryActivity[0]);
				$contents = file_get_contents($Config['EmailTemplateFolder']."newevent.htm");
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[SUBJECT]",$arryActivity[0]['subject'],$contents);
				$contents = str_replace("[STARTDATE]",$arryActivity[0]['startDate'],$contents);
				$contents = str_replace("[STARTTIME]",$arryActivity[0]['startTime'],$contents);
				$contents = str_replace("[CLOSEDATE]",$arryActivity[0]['closeDate'],$contents);
				$contents = str_replace("[CLOSETIME]",$arryActivity[0]['closeTime'],$contents);
				$contents = str_replace("[startDate]",$arryActivity[0]['startDate'],$contents);
				$contents = str_replace("[STATUS]",$arryActivity[0]['status'],$contents);
				$contents = str_replace("[ACTTYPE]",$arryActivity[0]['activityType'],$contents);
				$contents = str_replace("[PRIORITY]",$arryActivity[0]['priority'],$contents);
				$contents = str_replace("[CREATED]",$CreateBy ,$contents);
//$contents = str_replace("[ADDDATE]",$arryActivity[0]['add_date'],$contents);
				//$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editActivity.php?edit='.$activityID."&cat=".$arryActivity[0]['cat_id'], $contents);

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryActivity[0]['ContributorName'], $arryActivity[0]['ContributorEmail']);   
				$mail->Subject = $Config['SiteName']." - New event has been posted ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryActivity[0]['ContributorEmail'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				
			}
		
			return 1;
		}
		
		
		function ActivityActiveEmail($activityID)
		{
			global $Config;

			$arryActivity = $this->getActivity($activityID,'','','','');
				$contents = file_get_contents("../".$Config['EmailTemplateFolder']."activenewevent.htm");
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[FULLNAME]",$arryActivity[0]['ContributorName'],$contents);
				$contents = str_replace("[Email]",$arryActivity[0]['ContributorEmail'],$contents);
				$contents = str_replace("[activityID]",$arryActivity[0]['activityID'],$contents);
				$contents = str_replace("[ActivityTitle]",$arryActivity[0]['heading'],$contents);
				$contents = str_replace("[type]",$arryActivity[0]['type'],$contents);
				$contents = str_replace("[startDate]",$arryActivity[0]['startDate'],$contents);
				$contents = str_replace("[endDate]",$arryActivity[0]['endDate'],$contents);
				$contents= str_replace("[EVENT_URL]",$Config['Url'].'events.html?eId='.$activityID, $contents);
				
				
				
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryActivity[0]['ContributorEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Your event has been approved ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryActivity[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			
		
			return 1;
		}
		
	
	function  ListActivity($id=0,$parent_type,$parentID,$SearchKey,$SortBy,$AscDesc)
	{
		global $Config;
	$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and e.activityID=".$id):("");
		//$strAddQuery .= (!empty($cat_id))?(" and cat_id=".$cat_id):("");
		$strAddQuery .= (!empty($parent_type))?(" and e.parent_type='".$parent_type."' "):("");
		$strAddQuery .= (!empty($parentID))?(" and e.parentID=".$parentID):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." = '".$SearchKey."')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (e.subject like '%".$SearchKey."%'  or e.activityID like '%".$SearchKey."%'     or e.activityType like '%".$SearchKey."%'  or e.status like '%".$SearchKey."%' or e.startDate like '%".$SearchKey."%' or e.closeDate like '%".$SearchKey."%')"):("");
		}

//$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (a.EmpID='".$_SESSION['AdminID']."' OR e.created_id='".$_SESSION['AdminID']."') "):("");
 $strAddQuery .= ($Config['vAllRecord']!=1)?(" and (e.assignedTo like '%".$_SESSION['AdminID']."%' OR e.created_id='".$_SESSION['AdminID']."') "):("");
		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):("  order by e.activityID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		 $strSQLQuery = "select e.* from c_activity  e ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}
	
	
	
	
	
	
	
	

	function UpdateImage($imageName,$activityID)
	{
			$strSQLQuery = "update c_activity set Image='".$imageName."' where activityID=".$activityID;
			return $this->query($strSQLQuery, 0);
	}
	function UpdatePdf($Pdf,$activityID)
	{
			$strSQLQuery = "update c_activity set Pdf='".$Pdf."' where activityID=".$activityID;
			return $this->query($strSQLQuery, 0);
	}

	function isEventExists($subject,$activityID,$Type)
	{

		$strSQLQuery ="select * from c_activity where LCASE(subject)='".strtolower(trim($subject))."'";

		$strSQLQuery .= (!empty($activityID))?(" and activityID != ".$activityID):("");
		$strSQLQuery .= (!empty($cat_id))?(" and activityType = ".$Type):("");

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['activityID'])) {
			return true;
		} else {
			return false;
		}


	}


	function isEventDateExists($startDate,$closeDate,$closeTime,$startTime,$activityID,$Type)
	{

		$strSQLQuery ="select * from c_activity where startDate <= '".$startDate."'";
        $strSQLQuery .= (!empty($closeDate))?(" and closeDate <= '".$closeDate."'"):("");
	    //$strSQLQuery .= (!empty($closeTime))?(" and closeTime = '".$closeTime."'"):("");
	    //$strSQLQuery .= (!empty($startTime))?(" and startTime = '".$startTime."'"):("");
	
		$strSQLQuery .= (!empty($activityID))?(" and activityID != ".$activityID):("");
		$strSQLQuery .= (!empty($Type))?(" and activityType = '".$Type."'"):("");

		//echo $strSQLQuery;

		$arryRow = $this->query($strSQLQuery, 1);
		
		if (!empty($arryRow[0]['activityID'])) {
			return true;
		} else {
			return false;
		}


	}
function GetAssignee($arrayDetail) {
		$strSQLQuery = "select EmpID,UserName,Email from h_employee where EmpID in (".$arrayDetail.")";
		return $this->query($strSQLQuery, 1);

	}
function  GetNumActivityYear($Type,$startDate,$closeDate)
	{

		$strSQLQuery = "select count(activityID) as TotalActivity from c_activity where 1 ";
		$strSQLQuery .= (!empty($Type))?(" and activityType = '".$Type."'"):("");
		$strSQLQuery .= (!empty($startDate))?(" and startDate <= '".$startDate."'"):("");
		$strSQLQuery .= (!empty($closeDate))?(" and closeDate <= '".$closeDate."'"):("");
                $strSQLQuery .= " order by startDate desc";

		/*if(!empty($Year)){
		$DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
		$strSQLQuery .= " and JoiningDate<='".$DateEnd."' and (ABS(ExitDate)=0 OR ExitDate>'".$DateEnd."')";
		//$strSQLQuery .= " and JoiningDate<='".$DateEnd."' ";
		}*/
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);		
	}

function  GetActivityDeshboard($Type)
	{
global $Config;
		$strSQLQuery = "select subject,activityID,activityType,startDate,closeDate,closeTime,startTime from c_activity where 1 ";
$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (assignedTo like '%".$_SESSION['AdminID']."%'   OR   created_id='".$_SESSION['AdminID']."') "):("");
		$strSQLQuery .= (!empty($Type))?(" and activityType = '".$Type."'"):("");
		//$strSQLQuery .= (!empty($startDate))?(" and startDate <= '".$startDate."'"):("");
		$strSQLQuery .= " and startDate >= CURDATE() ";
                $strSQLQuery .= " order by startDate asc limit 0,7";

		/*if(!empty($Year)){
		$DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
		$strSQLQuery .= " and JoiningDate<='".$DateEnd."' and (ABS(ExitDate)=0 OR ExitDate>'".$DateEnd."')";
		//$strSQLQuery .= " and JoiningDate<='".$DateEnd."' ";
		}*/
		//echo $strSQLQuery;exit;
		return $this->query($strSQLQuery, 1);		
	}

function  CountActivity($Type)
	{
global $Config;
		$strSQLQuery = "select COUNT(activityID) as totalAct from c_activity where 1 ";
$strSQLQuery .= ($Config['vAllRecord']!=1)?(" and (assignedTo like '%".$_SESSION['AdminID']."%'   OR   created_id='".$_SESSION['AdminID']."') "):("");
                 $strSQLQuery .= (!empty($Type))?(" and activityType = '".$Type."'"):("");
		$strSQLQuery .= " and startDate >= CURDATE()";
                $strSQLQuery .= " order by startDate asc limit 0,7";
		$arryRow = $this->query($strSQLQuery, 1);

		if($arryRow[0]['totalAct'] >0){
		return $arryRow[0]['totalAct']; 
		}else{
		return 0;
		}
		//echo $strSQLQuery;exit;
		//return $this->query($strSQLQuery, 1);		
	}


}
?>
