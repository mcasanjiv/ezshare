<?
class quote extends dbClass
{ 

	var $tables;
	
	// consturctor 
	function quote(){
		global $configTables;
		$this->tables=$configTables;
		$this->dbClass();
	}

	function addQuote($arryDetails)
	{
     
		@extract($arryDetails);	

             $sql = "insert into c_quotes  (subject,opportunityName,OpportunityID,quotestage,validtill,contactid,quote_no,carrier,shipping,assignTo,accountid,terms_conditions,currency_id,conversion_rate,created_date,created_by,created_id,description,discount_type_final,
  discount_final , discount_percentage_final,discount_amount_final,shipping_handling_charge ,shtax1_sh_percent , shtax1_sh_amount,shtax2_sh_percent ,
   shtax2_sh_amount,shtax3_sh_percent,shtax3_sh_amount,adjustment ,adjustmentType ,totalProductCount,subtotal,total) values( '".addslashes($subject)."', '".addslashes($opportunityName)."','".addslashes($opportunityID)."','".addslashes($quotestage)."','".addslashes($validtill)."','".addslashes($contactid)."','".addslashes($quote_no)."','".$carrier."','".$shipping."','".$assignTo."','".$accountid."','".addslashes($terms_conditions)."','".$currency_id."','".$conversion_rate."','". date("Y-m-d")."','".$created_by."','".$created_id."','".addslashes($description)."','".addslashes($discount_type_final)."', '".addslashes($discount_final)."','".addslashes($discount_percentage_final)."','".addslashes($discount_amount_final)."','".addslashes($shipping_handling_charge)."','".addslashes($shtax1_sh_percent)."','".addslashes($shtax1_sh_amount)."','".$shtax2_sh_percent."','".$shtax2_sh_amount."','".$shtax3_sh_percent."','".$shtax3_sh_amount."','".addslashes($adjustment)."','".$adjustmentType."','".$totalProductCount."','". $subtotal."','".$total."')";

	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();

		if(!empty($lastInsertId)){

          $sqlbillads = "insert into c_quotesbillads  (quoteid,bill_city,bill_code,bill_country,bill_state,bill_street,bill_pobox,ship_city,ship_code,ship_country, 	ship_state,ship_street,ship_pobox) values( '".$lastInsertId."', '".addslashes($bill_city)."','".addslashes($bill_code)."','".addslashes($bill_country)."','".addslashes($bill_state)."','".addslashes($bill_street)."',  '".addslashes($bill_pobox)."','".addslashes($ship_city)."','".addslashes($ship_code)."','".addslashes($ship_country)."','".addslashes($ship_state)."','".$ship_street."','".$ship_pobox."')";

		  $this->query($sqlbillads, 0);
	
		for($i=1; $i<=$totalProductCount; $i++){
			  $sqlquoteProduct = "insert into c_quotes_products  (quoteId,productName,hdnProductId,qty,comment,type,listPrice ,discount_type ,discount ,discount_percentage ,discount_amount,qty_in_stock) values('".$lastInsertId."','".addslashes($_POST['productName'.$i])."' ,'".$_POST['hdnProductId'.$i]."','".$_POST['qty'.$i]."' ,'".addslashes($_POST['comment'.$i])."' , '".$_POST['type'.$i]."','".$_POST['listPrice'.$i]."' ,'".$_POST['discount_type'.$i]."' ,'".$_POST['discount'.$i]."' ,'".$_POST['discount_percentage'.$i]."' ,'".$_POST['discount_amount'.$i]."','".$_POST['qty_in_stock'.$i]."')";
			

		  $this->query($sqlquoteProduct, 0);
	}
		}
		return $lastInsertId;
		
	}
	function updateQuote($arryDetails)
	{
		@extract($arryDetails);	



		$sql = "update c_quotes set subject = '".addslashes($subject)."',
		                            opportunityName = '".addslashes($opportunityName)."',
									OpportunityID = '".addslashes($opportunityID)."',
									quotestage = '".addslashes($quotestage)."', 
									validtill = '".addslashes($validtill)."',
									contactid = '".addslashes($contactid)."',
									carrier = '".addslashes($carrier)."',
									shipping = '".$shipping."',
									assignTo = '".$assignTo."',
								    terms_conditions = '".addslashes($terms_conditions)."',
									conversion_rate = '".addslashes($conversion_rate)."',
									description = '".addslashes($description)."',
									discount_type_final = '".addslashes($discount_type_final)."',
									discount_final = '".addslashes($discount_final)."',
									discount_percentage_final = '".addslashes($discount_percentage_final)."',
			                        discount_amount_final = '".addslashes($discount_amount_final)."',
                                    shipping_handling_charge = '".addslashes($shipping_handling_charge)."',
									shtax1_sh_percent = '".addslashes($shtax1_sh_percent)."',
									shtax1_sh_amount = '".addslashes($shtax1_sh_amount)."',
									shtax2_sh_percent = '".addslashes($shtax2_sh_percent)."',
                                    shtax2_sh_amount = '".addslashes($shtax2_sh_amount)."',
									shtax3_sh_percent = '".addslashes($shtax3_sh_percent)."',
									shtax3_sh_amount = '".addslashes($shtax3_sh_amount)."',
                                    adjustment = '".addslashes($shtax2_sh_amount)."',
									adjustmentType = '".addslashes($shtax3_sh_percent)."',
									totalProductCount = '".addslashes($shtax3_sh_amount)."',
                                    subtotal = '".addslashes($subtotal)."',
									total = '".addslashes($total)."',
									accountid = '".addslashes($accountid)."'
									
									where quoteid = ".$quoteid; 
		$rs = $this->query($sql,0);

		


		

           		$sqlAddress = "update c_quotesbillads set bill_city = '".addslashes($bill_city)."', 
									bill_code = '".addslashes($bill_code)."', 
									bill_country = '".addslashes($bill_country)."',
									bill_state = '".addslashes($bill_state)."',
									bill_street = '".addslashes($bill_street)."',
									bill_pobox = '".$bill_pobox."',
									ship_city = '".$ship_city."',
									ship_code = '".$ship_code."',
									ship_country = '".addslashes($ship_country)."',
									ship_state = '".addslashes($ship_state)."',
									ship_street = '".addslashes($ship_street)."',
									ship_pobox = '".addslashes($ship_pobox)."'
									
									where quoteid = ".$quoteid; 
		  $rsUp = $this->query($sqlAddress,0);


		  $sql3 = "delete from c_quotes_products where quoteid = ".$quoteid;
		$rs3 = $this->query($sql3,0);
if(sizeof($rs3)){
		 for($i=1; $i<=$totalProductCount; $i++){
			  $sqlquoteProduct = "insert into c_quotes_products  (quoteId,productName,hdnProductId,qty,comment,listPrice ,discount_type ,discount ,discount_percentage ,discount_amount,qty_in_stock) values('".$quoteid."','".addslashes($_POST['productName'.$i])."' ,'".$_POST['hdnProductId'.$i]."','".$_POST['qty'.$i]."' ,'".addslashes($_POST['comment'.$i])."','".$_POST['listPrice'.$i]."' ,'".$_POST['discount_type'.$i]."' ,'".$_POST['discount'.$i]."' ,'".$_POST['discount_percentage'.$i]."' ,'".$_POST['discount_amount'.$i]."','".$_POST['qty_in_stock'.$i]."')";
			

		  $this->query($sqlquoteProduct, 0);
	}
}
		if(sizeof($rs)){	   

			return true;
		}else{
			return false;
		}
	}


/*function addQuoteEmp($arryDetails)  
	{ 
		@extract($arryDetails);	
		for($i=0;$i<sizeof($EmpID);$i++ ){	

			echo $EmpID[$i];
			
			echo $sql ="select quoteID from c_quotes_emp where EmpID='".$EmpID[$i]."' and quoteID='".$quoteID."'";
			$arryRow = $this->query($sql, 1);
			if (!empty($arryRow[0]['quoteID'])) {
				$sql = "update c_quotes_emp set EmpID = '".$EmpID[$i]."' where quoteID = ".$arryRow[0]['quoteID']; 
			}else{
				$sql = "insert into c_quotes_emp( EmpID, quoteID) values('".$EmpID[$i]."', '".$quoteID."')";
			}
			$this->query($sql,0);
		}
		exit;
		return true;

	}*/


function addQuoteEmp($arryDetails)
		{
			
			extract($arryDetails);
			$sql = "delete from c_quotes_emp where quoteID =".$quoteID;
			$rs = $this->query($sql,0);
			for($i=0;$i<sizeof($EmpID); $i++){
				$sql = "insert into c_quotes_emp( EmpID, quoteID) values('".$EmpID[$i]."', '".$quoteID."')";
				$rs = $this->query($sql,0);
				}
		
			return 1;

		}




	function GetQuote($quoteid,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($quoteid))?(" and q.quoteid = ".$quoteid):("");
		
		//$sql = "select * from c_quotes   ".$sql;


		$sql = "select q.*,em.UserName,em.Email,d.Department from c_quotes q inner join h_employee em on q.assignTo=em.EmpID left outer join  department d on em.Department=d.depID".$sql." order by q.quoteid Asc" ; 

		

		return $this->query($sql, 1);
	}


function GetQuoteAddress($quoteid,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($quoteid))?(" and quoteid = ".$quoteid):("");
		
		$sql = "select * from c_quotesbillads   ".$sql;

		return $this->query($sql, 1);
	}

	function GetQuoteProduct($quoteid,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($quoteid))?(" and q.quoteid = ".$quoteid):("");
		
		//$sql = "select * from c_quotes_products   ".$sql;

		$sql = "select q.*,p.Name,p.Price as SalePrice,p.Quantity from c_quotes_products q inner join e_products p on q.hdnProductId=p.ProductID ".$sql." order by q.qtpid Asc" ; 

		return $this->query($sql, 1);
	}
	function getUpQuote($Limit)
	{
		$sql = " where  e.startDate>=now() ";

		$sql = "select e.*, from c_quotes e  ".$sql." order by e.startDate asc";

		$sql .= (!empty($Limit))?(" limit 0,".$Limit):("");

		return $this->query($sql, 1);
	}


	
	function changeQuoteStatus($quoteID)
	{
		$sql="select * from c_quotes where quoteID=".$quoteID;
		$rs = $this->query($sql);
		if(sizeof($rs))
		{
			if($rs[0]['Status']==1)
				$Status=0;
			else
				$Status=1;
				
			$sql="update c_quotes set Status='$Status' where quoteID=".$quoteID;
			$this->query($sql,0);
			
		}
		if($Status==1 && $rs[0]['Status']!=1 ){
				$this->QuoteActiveEmail($quoteID);
			}
			return true;			
	}

	
	function RemoveQuote($quoteID)
	{


		$sql = "delete from c_quotes where quoteid = ".$quoteID;
		$rs = $this->query($sql,0);

		$sql2 = "delete from c_quotesbillads where quoteid = ".$quoteID;
		$rs2 = $this->query($sql2,0);

		$sql3 = "delete from c_quotes_products where quoteid = ".$quoteID;
		$rs3 = $this->query($sql3,0);

		if(sizeof($rs))
			return true;
		else
			return false;

	}
	function SendEmailToAdmin($quoteID)
		{
			global $Config;

			$arryQuote = $this->GetQuote($quoteID,'','','','');

			

				//$QuoteTitle = GetQuoteTitle($arryQuote[0]);
				$contents = file_get_contents($Config['EmailTemplateFolder']."newquote.htm");
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[FULLNAME]",$arryQuote[0]['ContributorName'],$contents);
				$contents = str_replace("[Email]",$arryQuote[0]['ContributorEmail'],$contents);
				$contents = str_replace("[quoteID]",$arryQuote[0]['quoteID'],$contents);
				$contents = str_replace("[QuoteTitle]",$arryQuote[0]['heading'],$contents);
				$contents = str_replace("[type]",$arryQuote[0]['type'],$contents);
				$contents = str_replace("[startDate]",$arryQuote[0]['startDate'],$contents);
				$contents = str_replace("[endDate]",$arryQuote[0]['endDate'],$contents);
				$contents= str_replace("[ACTIVATE_URL]",$Config['Url'].'admin/editQuote.php?edit='.$quoteID."&cat=".$arryQuote[0]['cat_id'], $contents);

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				$mail->sender($arryQuote[0]['ContributorName'], $arryQuote[0]['ContributorEmail']);   
				$mail->Subject = $Config['SiteName']." - New quote has been posted ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryQuote[0]['ContributorEmail'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				
			}
		
			return 1;
		}
		
		
		function QuoteActiveEmail($quoteID)
		{
			global $Config;

			$arryQuote = $this->getQuote($quoteID,'','','','');
				$contents = file_get_contents("../".$Config['EmailTemplateFolder']."activenewquote.htm");
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[FULLNAME]",$arryQuote[0]['ContributorName'],$contents);
				$contents = str_replace("[Email]",$arryQuote[0]['ContributorEmail'],$contents);
				$contents = str_replace("[quoteID]",$arryQuote[0]['quoteID'],$contents);
				$contents = str_replace("[QuoteTitle]",$arryQuote[0]['heading'],$contents);
				$contents = str_replace("[type]",$arryQuote[0]['type'],$contents);
				$contents = str_replace("[startDate]",$arryQuote[0]['startDate'],$contents);
				$contents = str_replace("[endDate]",$arryQuote[0]['endDate'],$contents);
				$contents= str_replace("[EVENT_URL]",$Config['Url'].'quotes.html?eId='.$quoteID, $contents);
				
				
				
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryQuote[0]['ContributorEmail']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Your quote has been approved ";
				$mail->IsHTML(true);

				//echo $Config['AdminEmail'].$arryQuote[0]['Email'].$contents; exit;

				$mail->Body = $contents;    
				if($Config['DbUser'] != 'root'){
					$mail->Send();	
				}
			
		
			return 1;
		}
		
	
	function  ListQuote($id=0,$parent_type,$parentID,$SearchKey,$SortBy,$AscDesc)
	{
		$strAddQuery = ' where 1 ';
		$SearchKey   = strtolower(trim($SearchKey));
		$strAddQuery .= (!empty($id))?(" and q.quoteid=".$id):("");
		//$strAddQuery .= (!empty($cat_id))?(" and cat_id=".$cat_id):("");
		//$strAddQuery .= (!empty($parent_type))?(" and parent_type='".$parent_type."' "):("");
		//$strAddQuery .= (!empty($parentID))?(" and parentID=".$parentID):("");


		if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
		}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (q.subject like '".$SearchKey."%' or q.quotestage like '".$SearchKey."%' or opp.OpportunityName like '".$SearchKey."%' or q.total like '".$SearchKey."%' )"):("");
		}


		$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by q.quoteid ");
		$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");


		 $strSQLQuery = "select q.*,opp.OpportunityID,opp.OpportunityName,em.UserName,em.Email,d.Department from c_quotes q left outer join c_opportunity opp on q.OpportunityID=opp.OpportunityID  inner join h_employee em on q.assignTo=em.EmpID left outer join  department d on em.Department=d.depID  ".$strAddQuery;
		return $this->query($strSQLQuery, 1);

	}
	
	function  AdvanceSearch($arryDetails)
		{
			extract($arryDetails);


			$strSQLQuery = "select q.*,c.cat_name from c_quotes e left outer join quote_cat c on q.cat_id=c.cat_id  where 1 ";
			#$strSQLQuery .= 'and q.Status=1 and q.startDate>=now()';
			$strSQLQuery .= 'and q.Status=1 ';

			$strSQLQuery .= ($CountryName!='')?(" and q.Country like '%".$CountryName."%'"):("");
			$strSQLQuery .= ($Region!='')?(" and q.Region like '%".$Region."%'"):("");
			$strSQLQuery .= ($State!='')?(" and q.State like '%".$State."%'"):("");
			$strSQLQuery .= ($City!='')?(" and q.City like '%".$City."%'"):("");
			$strSQLQuery .= ($cat_id!='')?(" and q.cat_id =".$cat_id.""):("");

			$strSQLQuery .= (!empty($s_key))?(" and (q.heading LIKE '%".$s_key."%' OR q.detail LIKE '%".$s_key."%' OR q.type LIKE '%".$s_key."%' OR q.Topic LIKE '%".$s_key."%' OR c.cat_name LIKE '%".$s_key."%')"):("");


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
	
	
	
	
	
	

	function UpdateImage($imageName,$quoteID)
	{
			$strSQLQuery = "update c_quotes set Image='".$imageName."' where quoteID=".$quoteID;
			return $this->query($strSQLQuery, 0);
	}
	function UpdatePdf($Pdf,$quoteID)
	{
			$strSQLQuery = "update c_quotes set Pdf='".$Pdf."' where quoteID=".$quoteID;
			return $this->query($strSQLQuery, 0);
	}

	function isQuoteExists($heading,$quoteID)
	{

		$strSQLQuery ="select * from c_quotes where LCASE(subject)='".strtolower(trim($heading))."'";

		$strSQLQuery .= (!empty($quoteID))?(" and quoteid != ".$quoteID):("");
		

		$arryRow = $this->query($strSQLQuery, 1);
		if (!empty($arryRow[0]['quoteid'])) {
			return true;
		} else {
			return false;
		}


	}


}
?>
