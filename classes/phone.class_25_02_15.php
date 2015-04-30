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
			$results=json_decode($server_output);			
			return $results;
	
	}
	
	function deleteCallEmployee($agent_id,$user_id,$server_id){		
		$this->delete('c_callUsers',array('user_id'=>$user_id,'agent_id'=>$agent_id,'server_id'=>$server_id));
	}
		
}

?>
