<?php 

class phone extends dbFunction
{
		//constructor
		var $tables;
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
		  $base='https://66.55.11.57/webservice/';
			  $results=array();
			  $url=$base.$url;
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
	
	function deleteCallEmployee($agent_id,$user_id,$server_id){		
		$this->delete('c_callUsers',array('user_id'=>$user_id,'agent_id'=>$agent_id,'server_id'=>$server_id));
	}
	
	function GetcallSetting(){
		$sql="Select * FROM c_call_setting";		 
		$results =$this->get_results($this->prepare($sql));	
		return $results;
	}
	
	function CreateGroup($name){
		
		$parm = "acl_group.php?action=groupadd&group=".$name."&description=".$name;
		try{
	     $data  = $this->api($parm);
		 if($data->error){
			echo $data->error; die;
		 }
		 echo "<pre>";print_r($data);die;
		 return $data; 
		}catch(Exception $e) {
		 echo "Something went wrong.Please try to letter."; die;
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
}

?>
