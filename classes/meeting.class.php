<?php			
class Meeting extends dbClass{
	const MEETING_MOD = 1;
	const MEETING_ATTENDEE = 0;
	const DEFAULT_MOD_PWD = 'mp';
	const DEFAULT_ATD_PWD = 'ap';
	
	
	
	
	function addMeeting($data)
	{ 
			global $Config;
			
			extract($data);
			$sql = "insert into meeting (meetingId,meetingName,attendeePw,moderatorPw,record,duration,createtime,createDate,UserId) 
			values('".addslashes($meetingId)."','".addslashes($meetingName)."','".addslashes($attendeePw)."','".addslashes($moderatorPw)."','".addslashes($record)."','".$duration."', '".$createtime."','".$createdate."','".$_SESSION['UserID']."')";
			//echo $sql; die();
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;
			  header("location:dashboard.php?module=meeting");
                   exit;

	}
		
	
	function joinMeeting($arraydata,$MType=0)
	{
	    extract($arraydata);
	    $query ="insert into meeting_join(meetingId,Name,Email,MType,createTime,userId) 
	    values('".addslashes($meetingId)."','".addslashes($userName)."','".addslashes($email)."','".$MType."', NOW(),'".$_SESSION['UserID']."')";
	    $this->query($query);
	    //$rs = $this->query($query,0);
		$lastInsertId = $this->lastInsertId();
		return $lastInsertId;
	}	
	

 	function updateMeetingStatus($joinmeetingId) {
        $strSQLQuery = "update  meeting_join set JoinStatus='1' where id='" . $joinmeetingId . "' ";
        $this->query($strSQLQuery, 0);
        return 1;
    }
    
		
 	function  GetMeeting($meeting_Id = null,$join=false){	
		    $todaysDate = date("Y-m-d");
		    $where = "where UserId ='".$_SESSION['UserID']."' and createDate >='".$todaysDate."'";
		    
			if($join)  $join = "inner join meeting_join jm on(m.meetingId=jm.meetingId)";
			else $join = '';
			
			if(!empty($meeting_Id)) $where = "where meetingId='".$meeting_Id."'";
			
			$strSQLQuery = "select * from meeting m ".$join .' '. $where.'  '.'ORDER BY createDate,createtime ASC'; 
			return $this->query($strSQLQuery, 1); 
	}
	
	
	function  GetMeetingVideo($meeting_Id = null,$join=false){	
		    $todaysDate = date("Y-m-d");
		    $where = "where UserId ='".$_SESSION['UserID']."' and record='true'";
		    
			if($join)  $join = "inner join meeting_join jm on(m.meetingId=jm.meetingId)";
			else $join = '';
			
			if(!empty($meeting_Id)) $where .= " and meeting_Id='".$meeting_Id."'";
			
			$strSQLQuery = "select * from meeting m ".$join .' '. $where.'  '.'ORDER BY createDate,createtime ASC'; 
			return $this->query($strSQLQuery, 1); 
	}
	
	
	function getMeetingHistory($meeting_Id = null){	
		    $where = "where UserId ='".$_SESSION['UserID']."'";
			if($join)  $join = "inner join meeting_join jm on(m.meetingId=jm.meetingId)";
			else $join = '';
			if(!empty($meeting_Id)) $where .= " and meeting_Id='".$meeting_Id."'";
			$strSQLQuery = "select * from meeting m ".$join .' '. $where.'  '.'ORDER BY createDate,createtime ASC'; 
			return $this->query($strSQLQuery, 1); 
	}
	
    
    function UpdateMeeting($arryDetails) {
        $objConfigure = new configure();
        global $Config;
        extract($arryDetails); 
        $strSQLQuery = "update meeting set  createDate='" .$createDate . "',createtime='" . addslashes($createtime) . "',duration='" . addslashes($duration) . "'	where meeting_Id='" . $meeting_Id . "'";
      // echo $strSQLQuery; die();
        $this->query($strSQLQuery, 0);
        return 1;
    }
	
    
	 function RemoveMeeting($meetin_Id) {
        $strSQLQuery = "delete from meeting where meeting_Id='" . $meetin_Id . "'";
        $this->query($strSQLQuery, 0);
        return 1;
    }
    
    
    function getMeetingId($meetingID){
    		 $strSQLQuery = "select * from meeting where meetingId =$meetingID"; 
			$record = $this->query($strSQLQuery, 1);
			if(count($record)>0){
				return $record[0];
			}else{
				return false;
			}
    }
    
	function getAttendees($meetingId = null){	
			$strSQLQuery = "select * from meeting_join where meetingId='".$meetingId."'"; 
			return $this->query($strSQLQuery, 1); 
		}
    
    
    function attendMeeting($meetingId,$meetingName,$password){
    	include_once '../includes/bbb-api.php';
    	$bbb = new BigBlueButton();
				
				$joinParams = array(
					'meetingId' => $meetingId, 		    
					'username' => $meetingName,		    
					'password' => $password,			
					'createTime' => date('Y-M-D'),					
					'userId' => '',						
					'webVoiceConf' => ''				
				);
				
				$itsAllGood = true;
				try {
					$result = $bbb->getJoinMeetingURL($joinParams);
				}
				catch (Exception $e) {
						echo 'Caught exception: ', $e->getMessage(), "\n";
						$itsAllGood = false;
				}
				
				if ($itsAllGood == true) {
					//$objMeeting->updateMeetingUrl($joinmeetingId,$result);
					return $result;
				}else{
					return false;
				}
    }
    
    
    function getAvailbeVideo($meetingId){
    	include_once '../includes/bbb-api.php';
    	$bbb = new BigBlueButton();
    	$recordingsParams = array(
			'meetingId' => $meetingId, 			
		);
		
		$itsAllGood = true;
		try {$result = $bbb->getRecordingsWithXmlResponseArray($recordingsParams);}
			catch (Exception $e) {
				echo 'Caught exception: ', $e->getMessage(), "\n";
				$itsAllGood = false;
			}
		
			if ($itsAllGood == true) {
				// If it's all good, then we've interfaced with our BBB php api OK:
				if ($result == null) {
					// If we get a null response, then we're not getting any XML back from BBB.
					echo "Failed to get any response. Maybe we can't contact the BBB server.";
				}	
				else { 
				// We got an XML response, so let's see what it says:
				print_r($result); echo $result['message']; exit;
					if ($result['returncode'] == 'SUCCESS') {
						// Then do stuff ...
						echo "Meeting info was found on the server";
					}
					else {
						echo "Failed to get meeting info";
					}
				}
			}	
    }
    
		
}

 