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
		

            $sql = "insert into c_activity  (subject,title,created_by,created_id,description,startDate,startTime,closeDate,closeTime,status,activityType,location,priority,visibility,Notification,reminder,parent_type,parentID,assignedTo,RelatedType,LeadID,OpprtunityID,CampaignID) values( '".addslashes($subject)."', '".addslashes($title)."','".addslashes($created_by)."','".addslashes($created_id)."','".addslashes($description)."', '".$startDate."','".$startTime."','".$closeDate."','".$closeTime."','".$status."','".$activity_type."', '".$location."', '".addslashes($priority)."', '".addslashes($visibility)."','".$Notification."','".$reminder."','".$parent_type."','".$parentID."','".$assignedTo."','".$RelatedType."','".$LeadID."','".$OpprtunityID."','".$CampaignID."')";

	
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

		


		$sql = "update c_activity set subject = '".addslashes($subject)."', 
									title = '".addslashes($title)."', 
									description = '".addslashes($description)."',
									assignedTo  = '".$assignedTo."',
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


/*function addActivityEmp($arryDetails)  
	{ 
		@extract($arryDetails);	
		for($i=0;$i<sizeof($EmpID);$i++ ){	

			echo $EmpID[$i];
			
			echo $sql ="select activityID from c_activity_emp where EmpID='".$EmpID[$i]."' and activityID='".$activityID."'";
			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['activityID'])) {
				$sql = "update c_activity_emp set EmpID = '".$EmpID[$i]."' where activityID = ".$arryRow[0]['activityID']; 
			}else{
				$sql = "insert into c_activity_emp( EmpID, activityID) values('".$EmpID[$i]."', '".$activityID."')";
			}
			$this->query($sql,0);
		}
		exit;
		return true;

	}*/


function addActivityEmp($arryDetails)
		{
			
			//print_r($_POST['EmpID']);
			//exit;
			extract($arryDetails);
			$sql = "delete from c_activity_emp where activityID =".$_POST['activityID'];
			$rs = $this->query($sql,0);
			for($i=0;$i<sizeof($EmpID); $i++){
				$sql = "insert into c_activity_emp( EmpID, activityID) values('".$EmpID[$i]."', '".$_POST['activityID']."')";
				$rs = $this->query($sql,0);
				}
		
			return 1;

		}



	function getActivityEmp($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and activityID = ".$id):("");
		$sql = "select EmpID from c_activity_emp ".$sql." order by EmpID Asc" ; 
		return $this->query($sql, 1);
	}

	function getActivityEmp2($id=0){
		$sql = " where 1";
		$sql .= (!empty($id))?(" and e.activityID = ".$id):("");
		$sql = "select e.*,em.UserName,em.Email,d.Department from c_activity_emp e inner join h_employee em on e.EmpID=em.EmpID left outer join  department d on em.Department=d.depID".$sql." order by e.activityID Asc" ; 
		return $this->query($sql, 1);
	}

	function GetActivity($activityID,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($activityID))?(" and activityID = ".$activityID):("");
		
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

			$arryActivity = $this->GetActivity($activityID,'','','','');

			

				//$ActivityTitle = GetActivityTitle($arryActivity[0]);
				$contents = file_get_contents($Config['EmailTemplateFolder']."newevent.htm");
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
				$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editActivity.php?edit='.$activityID."&cat=".$arryActivity[0]['cat_id'], $contents);

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
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and e.activityID=".$id):("");
		//$strAddQuery .= (!empty($cat_id))?(" and cat_id=".$cat_id):("");
		$strAddQuery .= (!empty($parent_type))?(" and e.parent_type='".$parent_type."' "):("");
		$strAddQuery .= (!empty($parentID))?(" and e.parentID=".$parentID):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." = '".$SearchKey."')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (e.subject like '".$SearchKey."%' or e.status like '".$SearchKey."%' or e.startDate like '%".$SearchKey."%' or e.closeDate like '%".$SearchKey."%')"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by e.activityID ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");

		 $strSQLQuery = "select e.*,d.Department,u.Role,u.UserName as AssignTo from c_activity e left outer join  h_employee u on u.EmpID=e.assignedTo left outer join  department d on u.Department=d.depID ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}
	
	function  AdvanceSearch($arryDetails)
		{
			extract($arryDetails);


			$strSQLQuery = "select e.*,c.cat_name from c_activity e left outer join event_cat c on e.cat_id=c.cat_id  where 1 ";
			#$strSQLQuery .= 'and e.Status=1 and e.startDate>=now()';
			$strSQLQuery .= 'and e.Status=1 ';

			$strSQLQuery .= ($CountryName!='')?(" and e.Country like '%".$CountryName."%'"):("");
			$strSQLQuery .= ($Region!='')?(" and e.Region like '%".$Region."%'"):("");
			$strSQLQuery .= ($State!='')?(" and e.State like '%".$State."%'"):("");
			$strSQLQuery .= ($City!='')?(" and e.City like '%".$City."%'"):("");
			$strSQLQuery .= ($cat_id!='')?(" and e.cat_id =".$cat_id.""):("");

			$strSQLQuery .= (!empty($s_key))?(" and (e.heading LIKE '%".$s_key."%' OR e.detail LIKE '%".$s_key."%' OR e.type LIKE '%".$s_key."%' OR e.Topic LIKE '%".$s_key."%' OR c.cat_name LIKE '%".$s_key."%')"):("");


			if($fromMonth!='' && $fromYear!=''){
			  $fromDate=$fromYear.'-'.$fromMonth.'-01';
			  $strSQLQuery .= " and e.startDate >='".$fromDate."'";
			}

			if($toMonth!='' && $toYear!=''){
			  $toDate=$toYear.'-'.$toMonth.'-31';
			  $strSQLQuery .= " and e.endDate <='".$toDate."'";
			}

			if($calender_search!=''){
			  $strSQLQuery .= " and DATEDIFF('".$calender_search."',e.startDate)>=0 and DATEDIFF(e.endDate,'".$calender_search."')>=0 ";
			  #$strSQLQuery .= " and ('".$calender_search."' BETWEEN e.startDate and e.endDate)";
			}

			$strSQLQuery .= (!empty($SortOrder))?(" order by ".$SortOrder):(" order by e.startDate");
			$strSQLQuery .= (!empty($SortBy))?(" ".$SortBy):(" Desc");
			//echo $strSQLQuery;
		
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


}
?>
