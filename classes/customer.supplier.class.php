<?php

class CustomerSupplier extends dbFunction
{ 

	var $tables;
	
	// consturctor 
	function CustomerSupplier(){
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
	
	function CheckUserEmail($email){	
		$count =array();	
		 $sql="Select count(*) as c FROM `company_user` WHERE `user_name`='$email'";
		 $count=$this->get_results($this->prepare($sql));
		return ($count[0]->c);
	}
	/*
	 * Check Login 
	 *
	 * @param ($username)  User NAme string
	 * @param ($password)  User Password Simple String
	 * @return if valid  return customer data else false
	 */
	
	function UserLogin($username=null,$password=null){
		global $configTables,$Config;
		$results=array();
		if($username==null OR $password==null)
		return false;		
		$password=md5($password);
		$sql="SELECT * FROM  `company_user` WHERE `user_name`='$username' AND `password` ='$password'";
		$results=$this->get_results($sql);
		if(empty($results))
		return false;
		return $results[0];
		
	}
	
	/*
	 * Check UserName AND Password 
	 *
	 * @param ($username)  User NAme string
	 * @param ($password)  User Password Simple String
	 * @return if valid  return customer data else false
	 */
	
	function CheckUserPassword($username=null,$password=null){
		global $configTables,$Config;
		$results=array();
		if($username==null OR $password==null)
		return false;		
		$password=md5($password);
		$sql="SELECT * FROM  `company_user` WHERE `user_name`='$username' AND `password` ='$password'";
		$results=$this->get_results($sql);
		if(empty($results))
		return true;
		return false;
		
	}
	/*
	 * Get User Login detail By company , email, user type
	 *
	 * @param ($comId)  company id int
	 * @param ($email) customer email String
	 * @param ($usertype) usertype customer or vendor
	 * @return if valid  return customer data else false
	 */
	
	function GetCustomerLogindetail($comId,$email,$usertype='customer'){
		global $configTables,$Config;	
		if(empty($comId) OR  empty($email) OR empty($usertype))
		return false;
		$sql="Select * FROM `company_user` WHERE 1 AND comId='$comId' AND user_name='$email' AND user_type='$usertype'";
		$results=$this->get_results($sql);
		if(empty($results))
		return false;
		return $results[0];
		
	}
	
	/*
	 * Change Password 
	 *
	 * @param ($comId)  company id int
	 * @param ($email) customer email String
	 * @param ($usertype) usertype customer or vendor
	 * @return if valid  return customer data else false
	 */
	function ChangePassword($cmpid,$custlogid,$ref,$password){
		global $configTables,$Config;	
		if(empty($cmpid) OR  empty($custlogid) OR empty($ref) OR empty($password))
		return false;	
		$data['password']=md5($password);
		$where=array('id'=>$custlogid ,'ref_id'=>$ref ,'comid'=>$cmpid);
		 $this->update('company_user',$data,$where);
		 return true;
	}
	
	 /*
	 * Add User Login Detail 
	 *
	 * @param ($comId)  array 	
	 * @return if valid  return customer data else false
	 */
	
	function AddUserLoginDetail($arg){
		global $Config;
		$res=$data=$customerdara=array();
		if(empty($arg['ref_id']) OR empty($arg['comid']) OR empty($arg['user_name']) OR empty($arg['password']) OR empty($arg['user_type']))
		return false;
		$customerdara=$this->GetCustomerLogindetail($arg['comid'],$arg['user_name'],$arg['user_type']);
		
		if(empty($customerdara)){
			$password=$arg['password'];
			$arg['password']=md5($arg['password']);
			$name=$arg['name'];
			unset($arg['name']);
			$this->insert('company_user',$arg);
			$customerId=$this->lastInsertId();
			$customerdara=$this->GetCustomerLogindetail($arg['comid'],$arg['user_name'],$arg['user_type']);

			
			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."customerlogindetails.htm");
			$subject  = "Account Details";				
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[EMAIL]",$customerdara->user_name,$contents);
			$contents = str_replace("[FULLNAME]",$name,$contents);
			$contents = str_replace("[PASSWORD]",$password,$contents);	
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);	
			$Email= $customerdara->user_name;
			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Email);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Employee - ".$subject;
			$mail->IsHTML(true);
			$mail->Body = $contents;  
			if($Config['Online'] == '1' && $Email!=''){			
				 $mail->Send();	
			}
			
			$res['data']=$customerdara;		
			$res['message']='Add Successfully';
			$res['res']=1;								
		}else{
			$res['data']=$customerdara;		
			$res['message']='Already Added';
			$res['res']=2;;			
		}
		return $res;
		
	}
	/*
	 * Get Customer Permission  
	 *
	 * @param ($comId)  company id int
	 * @param ($email) customer email String
	 * @param ($usertype) usertype customer or vendor
	 * @return if valid  return customer data else false
	 */
	
	function getCustVenPermission($user_id=0,$ref=0,$comId=0){
		global $Config;
		$res=$data=$customerdara=array();
		if(empty($user_id) OR empty($ref) OR empty($comId))
		return false;
		$sql="Select permission FROM `company_user` WHERE id='$user_id' AND ref_id='$ref' AND comId='$comId'";
		$results=$this->get_results($sql);
		if(empty($results))
		return false;
			if(!empty($results[0]->permission))
				return unserialize($results[0]->permission);
				else
				return false;
		
	}




	/*
     * Get Customer Contact Status update And Ref 
     *
     * @param ($comId)  company id int
     * @param ($email) customer email String
     * @param ($usertype) usertype customer or vendor
     * @return if valid  return customer data else false
     */
    
    function ChangeCustAddressStatus($CustID,$AddID,$ref=null,$status=null){
        global $Config;
        $data=array();
        if(empty($ref) AND empty($status))
        return false;
        if($status!==null)
        $data['Status']=$status;
        if($ref!=null)
        $data['ref_id']=$ref;   
        $this->update('s_address_book',$data,array('CustID'=>$CustID,'AddID'=>$AddID));
        
        
    }
    
	/*
     * Add Customer Shipping
     *
     * @param ($comId)  company id int
     * @param ($email) customer email String
     * @param ($usertype) usertype customer or vendor
     * @return if valid  return customer data else false
     */
    
   	 function AddCustShipping($data=array()){ 
			global $Config;					
			$strSQLQuery = "select AddID FROM s_address_book WHERE CustId= '".$data['CustId']."' and AddType='".$data['AddType']."' AND Status=1"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$AddID = $arryRow[0]['AddID'];	
			$this->insert('s_address_book',$data);
			$shippid = $this->lastInsertId();
			$this->update('s_address_book',array('Status'=>0,'ref_id'=>$shippid),array('AddID'=>$AddID));	
		
			return $shippid;
		 }
		 
	/*
     * Add Vendor Shipping
     *
     * @param ($comId)  company id int
     * @param ($email) customer email String
     * @param ($usertype) usertype customer or vendor
     * @return if valid  return customer data else false
     */
    
   	 	function AddVendorShipping($data=array()){ 
			global $Config;					
			$strSQLQuery = "select AddID FROM p_address_book WHERE SuppID= '".$data['SuppID']."' and AddType='".$data['AddType']."' AND Status=1"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$AddID = $arryRow[0]['AddID'];	
			$this->insert('p_address_book',$data);
			$shippid = $this->lastInsertId();
			$this->update('p_address_book',array('Status'=>0,'ref_id'=>$shippid),array('AddID'=>$AddID));	
		
			return $shippid;
		 }






}

?>
