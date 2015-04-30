<?php 

class phone extends dbFunction
{
		//constructor
		var $tables;
		public $server_id;
		function phone()
		{
			global $configTables,$Config;		
			$this->tables=$configTables;
			$this->dbClass();
		} 
	/*
	 * Cheack User Email exits or not
	 *
	 * @$email (staring) about this param
	 * @return (0 OR 1)
	 */
	
	function connectCallServer($data , $server_id){	
		$empdata =array();			
			$results=$saveId=array();
		
				 $empdata =	$this->getCallRegiUserid($server_id);				
				if(!empty($data)){
					foreach( $data as $val){
						$results=array();
						if(!empty($val['agentID'])){
						
							if(!is_int($val['EmpID'])){
								$adminid=explode('-',$val['EmpID']);
								if(empty($adminid[1])){
								$val['EmpID']=$adminid[0];
								}else{						
								$val['EmpID']=$adminid[1];
								$results['type']='admin';	
								}					
							}
							
							$results['user_id']=$val['EmpID'];
							$results['agent_id']=$val['agentID'];
							$results['server_id']=$server_id;							
							if(!in_array($empdata,$val['EmpID'])){							
							$saveId[] =	$this->insert('c_callUsers',$results);
							}else{
							// Update Code
							
							}
						}else{						
							// Delete Code
						}
					}
				
				}
				return $saveId;
	}
	
	function getCallRegiUserid($serverId,$agent=false){
		$results=array();
		$agents=array();
		 		 $sql="Select * FROM `c_callUsers` WHERE `server_id`='$serverId'";		 
				 $empdata=$this->get_results($this->prepare($sql));				
				 if(!empty($empdata)){				 
					 foreach($empdata as $val){	
					 				 
						 $results[]=$val->user_id;
						 $agents[]=$val->agent_id;
					 }
				 }
				 if(empty($agent))
				 return $results;
				 else 
				 return $agents;
				 
	
	}
	function getCallRegisData($serverId,$type='_OBJ')
	{
	$results=array();
	  $sql="Select * FROM `c_callUsers` WHERE `server_id`='$serverId'";		 
		$results=$this->get_results($this->prepare($sql));	
		if($type=='_ARRAY')
			return (array) $results;
		else
		return $results;
	}
	function api($url,$params=array()){
		  $postData = ''; 
		  if(empty($this->server_id)) 
		 	 return  false;
		  $base='https://'.$this->server_id.'/webservice/';
			  $results=array();
			  $url=$base.$url;
			  if($_GET['test']){
			  echo $url;
			  print_r($params);
			  
			  }
		   foreach($params as $k => $v) 
		   { 
		      $postData .= $k . '='.$v.'&'; 
		   }
		   rtrim($postData, '&');		
			$ch = curl_init();
			
			curl_setopt($ch, CURLOPT_URL,$url);
			
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS,$postData);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			
			$server_output = curl_exec ($ch);
			curl_close ($ch);
			
			//echo "<pre>";print_r($server_output);die;
			$results = json_decode($server_output);			
			return $results;
	
	}
	
	function getServerUrl($server_id){
	//$Config['DbName'] = $Config['DbMain'];
	//$objConfig->dbName = $Config['DbName'];
	//$objConfig->connect();
		$sql="Select * from call_server WHERE id = '$server_id'";
		$results =$this->get_results($this->prepare($sql));	
		return $results;
	
	}
	
	function deleteCallEmployee($agent_id,$user_id,$server_id){		
		$this->delete('c_callUsers',array('user_id'=>$user_id,'agent_id'=>$agent_id,'server_id'=>$server_id));
	}
	
	function GetcallSetting(){
		$sql="Select * FROM c_call_setting";		 
		$results =$this->get_results($this->prepare($sql));	
		return $results;
	}
	
	function CreateGroup($name,$serverid){
		$responce=array();
		$parm = "acl_group.php?action=groupadd&group=".$name."&description=".$name;
		
		try{
	     $data  = $this->api($parm);
		 if($data->error){
		 	 $responce['error'] = '<div class="error">'.$data->error.'</div>';
			  return $responce;
		 }
		 $setting['server_id'] = $serverid;
		 $setting['group_id'] = $data->id;
		 $setting['group_name'] = $name;
		 $this->insert('c_call_setting',$setting);
		 $responce['success']='<div class="success">Group added successfully.</div>';
		  return $responce;
		}catch(Exception $e) {
			$responce['error']='<div class="error">Something went wrong. Please try to letter.</div>';
		 return $responce;
		 return $mag;
	     }
	}

	
	function getEmpQuota($server_id,$empid,$status='active' , $type='_OBJ'){
	$where='1=1 ';	
	if(!empty($server_id))
		$where .=" AND server_id='$server_id'";
	if(!empty($empid))
		$where .=" AND user_id='$empid'";
	if(!empty($empid))
		$where .=" AND status='$status'";
	$sql="Select* From c_callquota WHERE $where";
	$results=$this->get_results($this->prepare($sql));	
		if($type=='_ARRAY')
			return (array) $results;
		else
		return $results;
	}
	
	function SaveEmpQuota($data){
		$this->insert('c_callquota',$data);	
	}
	
	function updateEmpQuota($data,$where){
		$this->update('c_callquota',$data,$where);	
	
	}
	
	function DeleteGroup($group_id){
		
		$parm = "acl_group.php?action=groupdelete&group_id=".$group_id;
		
		try{
	     $data  = $this->api($parm);
		 $this->delete('c_call_setting',array('group_id'=>$group_id));
		 //$this->insert('c_call_setting',$setting);
		 return '<div class="success">Group delete successfully.</div>';
		}catch(Exception $e) {
		  return '<div class="error">Something went wrong. Please try to letter.</div>';
		 return $mag;
	     }
		
	}
	
	# list server 
	function ListServer($condi=array()){
		$where=' WHERE 1 ';
		foreach($condi as $k=>$cond){
		$where .=' AND '.$k.' = "'.$cond.'"';		
		}
		
	 $sql="Select * FROM call_server $where";		 
		$results =$this->get_results($this->prepare($sql));	
		
		return $results;	
	}
	# delete server 
	function DeleteServer($delID){
		$this->delete('call_server',array('id'=>$delID));
		
	}
	
	function GetEmployeeListByIds($arryDetails,$ids=array(),$serverid)
		{
			extract($arryDetails);
			$SearchKey   = strtolower(trim($key));

			$strSQLQuery = "select e.EmpID,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_employee e left outer join h_department d on e.Department=d.depID where 1 ";

			$strSQLQuery .= (!empty($EmpID))?(" and e.EmpID='".$EmpID."'"):(" and e.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= ($Status>0)?(" and e.Status='".$Status."'"):("");
			$strSQLQuery .= (!empty($Department))?(" and e.Department='".$Department."'"):("");
			$strSQLQuery .= (!empty($Division))?(" and e.Division in (".$Division.")"):("");
			$strSQLQuery .= (!empty($JobType))?(" and e.JobType='".$JobType."'"):("");
			$strSQLQuery .= (!empty($FixedLeave))?(" and e.LeaveAccrual!='1'"):("");
			$strSQLQuery .= (!empty($ids))?(" and e.EmpID IN (".implode(',',$ids).")"):("");
			$strSQLQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpCode like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%') " ):("");			
			$strSQLQuery .= " Order by e.UserName Asc";			
			return $this->query($strSQLQuery, 1);
		}
	
	
	
}

?>
