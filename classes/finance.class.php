<?
class common extends dbClass
{
		//constructor
		function common()
		{
			$this->dbClass();
		} 
		
		///////  Attribute Management //////

		function  GetAttributeValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 and locationID=".$_SESSION['locationID']):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  GetAttributeByValue($attribute_value,$attribute_name)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and locationID=".$_SESSION['locationID']):("");

			$strSQLFeaturedQuery .= (!empty($attribute_value))?(" and v.attribute_value like '".$attribute_value."%'"):("");

			$strSQLQuery = "select v.attribute_value from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery;

			return $this->query($strSQLQuery, 1);
		}	



		function  GetFixedAttribute($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}

		function  AllAttributes($id)
		{
			$strSQLQuery = " where 1 ";
			$strSQLQuery .= (!empty($id))?(" and attribute_id in(".$id.")"):("");
		
			$strSQLQuery = "select * from f_attribute ".$strSQLQuery." order by attribute_id Asc" ;

			return $this->query($strSQLQuery, 1);
		}	
			
		function addAttribute($arryAtt)
		{
			@extract($arryAtt);	 
			$sql = "insert into f_attribute_value (attribute_value,attribute_id,Status,locationID) values('".addslashes($attribute_value)."','".$attribute_id."','".$Status."','".$_SESSION['locationID']."')";
			$rs = $this->query($sql,0);
			$lastInsertId = $this->lastInsertId();

			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function updateAttribute($arryAtt)
		{
			@extract($arryAtt);	
			$sql = "update f_attribute_value set attribute_value = '".addslashes($attribute_value)."',attribute_id = '".$attribute_id."',Status = '".$Status."'  where value_id = '".$value_id."'"; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}
		function getAttribute($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($attribute_id))?(" and attribute_id = ".$attribute_id):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from f_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}
		function countAttributes()
		{
			$sql = "select sum(1) as NumAttribute from f_attribute_value where Status=1" ;
			return $this->query($sql, 1);
		}

		function changeAttributeStatus($value_id)
		{
			$sql="select * from f_attribute_value where value_id = '".$value_id."'";
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update f_attribute_value set Status='$Status' where value_id = '".$value_id."'";
				$this->query($sql,0);
				return true;
			}			
		}

		function deleteAttribute($id)
		{
			$sql = "delete from f_attribute_value where value_id = '".$id."'";
			$rs = $this->query($sql,0);

			if(sizeof($rs))
				return true;
			else
				return false;
		}
	
		function isAttributeExists($attribute_value,$attribute_id,$value_id)
			{

				$strSQLQuery ="select value_id from f_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' and locationID=".$_SESSION['locationID'];

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != '".$value_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}

		////////////Fixed Attribute Start ///// 
		function  GetAttribMultiple($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name in(".$attribute_name.") and v.Status=1 "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}



		function  GetAttribValue($attribute_name,$OrderBy)
		{
			
			$strSQLFeaturedQuery = (!empty($attribute_name))?(" where a.attribute_name='".$attribute_name."' and v.Status=1 "):("");

			$OrderSql = (!empty($OrderBy))?(" order by v.".$OrderBy." asc"):(" order by v.value_id asc");

			$strSQLQuery = "select v.* from f_attribute_value v inner join f_attribute a on v.attribute_id = a.attribute_id ".$strSQLFeaturedQuery.$OrderSql;

			return $this->query($strSQLQuery, 1);
		}
		function getAttrib($id=0,$attribute_id,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($id))?(" and value_id = '".$id."'"):("");
			$sql .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from f_attribute_value ".$sql." order by value_id asc" ;
		
			return $this->query($sql, 1);
		}

		function isAttribExists($attribute_value,$attribute_id,$value_id)
		{

				$strSQLQuery ="select value_id from f_attribute_value where LCASE(attribute_value)='".strtolower(trim($attribute_value))."' ";

				$strSQLQuery .= (!empty($attribute_id))?(" and attribute_id = '".$attribute_id."'"):("");
				$strSQLQuery .= (!empty($value_id))?(" and value_id != '".$value_id."'"):("");
				//echo $strSQLQuery; exit;
				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['value_id'])) {
					return true;
				} else {
					return false;
				}
		}

		/********************************************/
		/*************Payment Term Start ************/

		function  ListTerm($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" and termID=".$id):("");

			if($SearchKey=='active' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status=1"; 
			}else if($SearchKey=='inactive' && ($sortby=='Status' || $sortby=='') ){
				$strAddQuery .= " and Status=0";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (termName like '%".$SearchKey."%' or Day like '%".$SearchKey."%' or Due like '%".$SearchKey."%' or CreditLimit like '%".$SearchKey."%') " ):("");		
			}
			$strAddQuery .= ($Status>0)?(" and Status=".$Status):("");

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by termID ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			$strSQLQuery = "select * from f_term  ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}

		function  GetTerm($termID,$Status)
		{

			$strAddQuery = " where 1 ";
			$strAddQuery .= (!empty($termID))?(" and termID=".$termID):("");
			$strAddQuery .= ($Status>0)?(" and Status=".$Status):("");

			$strSQLQuery = "select * from f_term  ".$strAddQuery." order by termID Asc";

			return $this->query($strSQLQuery, 1);
		}		
			
		
		function AddTerm($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "insert into f_term (termName, termDate, Due, Status, Day, CreditLimit, UpdatedDate ) values( '".addslashes($termName)."', '".$termDate."', '".addslashes($Due)."', '".$Status."', '".addslashes($Day)."', '".addslashes($CreditLimit)."',  '".$Config['TodayDate']."')";

			$this->query($strSQLQuery, 0);

			$termID = $this->lastInsertId();
			
			return $termID;

		}


		function UpdateTerm($arryDetails){
			global $Config;
			extract($arryDetails);

			$strSQLQuery = "update f_term set termName='".addslashes($termName)."', termDate='".$termDate."',  Due='".addslashes($Due)."',  Status='".$Status."'  ,Day='".addslashes($Day)."'	,CreditLimit='".addslashes($CreditLimit)."'	, UpdatedDate = '".$Config['TodayDate']."' where termID=".$termID; 

			$this->query($strSQLQuery, 0);

			return 1;
		}

					
		
		function RemoveTerm($termID)
		{
		
			$strSQLQuery = "delete from f_term where termID=".$termID; 
			$this->query($strSQLQuery, 0);			

			return 1;

		}

		function changeTermStatus($termID)
		{
			$sql="select * from f_term where termID=".$termID;
			$rs = $this->query($sql);
			if(sizeof($rs))
			{
				if($rs[0]['Status']==1)
					$Status=0;
				else
					$Status=1;
					
				$sql="update f_term set Status='$Status' where termID=".$termID;
				$this->query($sql,0);				

				return true;
			}			
		}
		

		function MultipleTermStatus($termIDs,$Status)
		{
			$sql="select termID from f_term where termID in (".$termIDs.") and Status!='".$Status."'"; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update f_term set Status='".$Status."' where termID in (".$termIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}
		

		function isTermExists($termName,$termID=0)
		{
			$strSQLQuery = (!empty($termID))?(" and termID != ".$termID):("");
			$strSQLQuery = "select termID from f_term where LCASE(termName)='".strtolower(trim($termName))."'".$strSQLQuery; 
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['termID'])) {
				return true;
			} else {
				return false;
			}
		}


		/*************Payment Term End ************/



		function getSettingVariable($settingKey)
		{
			$strSQLQuery = "select setting_value from settings where setting_key ='".trim($settingKey)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$settingValue = $arryRow[0]['setting_value'];	
			return $settingValue;
			
		}
		function getCustomerCode($CustID)
		{
			$strSQLQuery = "select CustCode from s_customers where Cid ='".mysql_real_escape_string($CustID)."'"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$CustCode = $arryRow[0]['CustCode'];	
			return $CustCode;
			
		}
		


                
              /**************************FUNCTION STARTED FOR SETTINGS******************************************** */

        
               function getSettingsFields($depID,$group_id)
               {
                    $strSQLQuery =  "SELECT * FROM settings WHERE visible='Yes' AND group_id = '".$group_id."' and dep_id='".$depID."' ORDER BY priority";
                    return $this->query($strSQLQuery, 1);
               }

               function updateSettingsFields($arrayFields)
               {
                   foreach ($arrayFields as $key=>$value)
                   {
                         
                      $strSQLQuery =  "UPDATE settings SET setting_value='".$value."' WHERE setting_key LIKE '".trim($key)."'";
                      $this->query($strSQLQuery, 0);
                   }
               }
               
                function getSpiffSettings()
               {
                    $strSQLQuery =  "SELECT * FROM f_spiff";
                    return $this->query($strSQLQuery, 1);
               }

               function updateSpiffSettings($arryDetails)
               {
                        global $Config;
			extract($arryDetails);
                        $strSQLQuery = "select SpiffID from f_spiff"; 
			$arryRow = $this->query($strSQLQuery, 1);
			$SpiffID = $arryRow[0]['SpiffID'];
                        
                        
                        if($SpiffID > 0)
                        {
                              $strSQLQuery =  "UPDATE f_spiff SET GLAccountTo='".$GLAccountTo."',GLAccountFrom='".$GLAccountFrom."',PaymentTerm='".addslashes($PaymentTerm)."',PaymentMethod='".addslashes($PaymentMethod)."' WHERE SpiffID = '".$SpiffID."'";
                              $this->query($strSQLQuery, 0);
                            
                        }else{
                            
                              $strSQLQuery =  "INSERT INTO f_spiff SET GLAccountTo='".$GLAccountTo."',GLAccountFrom='".$GLAccountFrom."',PaymentTerm='".addslashes($PaymentTerm)."',PaymentMethod='".addslashes($PaymentMethod)."'";
                              $this->query($strSQLQuery, 0);
                        }
                    
               }

              
    
    /**************************FUNCTION ENDED FOR SETTINGS******************************************** */






}

?>
