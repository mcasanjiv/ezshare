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
	{    global $Config;
     
		@extract($arryDetails);	


			  $arryAsign = explode(":",$assignTo);
			  		
					 $AssignUser = $arryAsign[0];
					 $AssignType = $arryAsign[1];
					 $GroupID =  $arryAsign[2];


		    $sql = "INSERT INTO c_quotes SET subject = '".$subject."',
					 quotestage='".addslashes($quotestage)."',
					 validtill ='".$validtill."', 
					contactid = '".addslashes($contact_name)."', 
					carrier = '".$carrier."',
					 shipping = '".addslashes($shipping)."',
					assignTo = '".$AssignUser."',
					AssignType = '".$AssignType."',
					GroupID = '".$GroupID."',
					currency_id = '".$currency_id."',
					 description = '".$description."',
					 opportunityName = '".$opportunityName."',
		                           OpportunityID = '".$opportunityID."',
					TotalAmount = '".addslashes($TotalAmount)."',
					 Freight ='".addslashes($Freight)."', 
					CreatedBy = '".addslashes($_SESSION['UserName'])."', 
					AdminID='".$_SESSION['AdminID']."',
					AdminType='".$_SESSION['AdminType']."',
					PostedDate='".$Config['TodayDate']."',
					UpdatedDate='".$Config['TodayDate']."'";


	
		$this->query($sql, 0);
		$lastInsertId = $this->lastInsertId();

		//'".addslashes($opportunityName)."','".addslashes($opportunityID)."',

		if(!empty($lastInsertId)){

         
		  /***************************BILL ADDRESS ADDED ******/ 
			  $sqlbillads = "insert into c_quotesbillads  (quoteid,bill_city,bill_code,bill_country,bill_state,bill_street,bill_pobox,ship_city,ship_code,ship_country, 	ship_state,ship_street,ship_pobox) values( '".$lastInsertId."', '".addslashes($bill_city)."','".addslashes($bill_code)."','".addslashes($bill_country)."','".addslashes($bill_state)."','".addslashes($bill_street)."',  '".addslashes($bill_pobox)."','".addslashes($ship_city)."','".addslashes($ship_code)."','".addslashes($ship_country)."','".addslashes($ship_state)."','".$ship_street."','".$ship_pobox."')";

			  $this->query($sqlbillads, 0);
		  /***************************END BILL ADDRESS ******/


		  /********************OPPORTUNITY ADDED ******/

					if($opportunityID!=''){
							  $sqlOppAdd="insert into c_quote_opp  (quoteID,opportunityName,opportunityID,mode_type) values(  '".addslashes($lastInsertId)."','".addslashes($opportunityName)."','".addslashes($opportunityID)."','Quote')";
					$this->query($sqlOppAdd, 0);
					}

		  /************End Opportunity**************/

		  /********************PRODUCT ADDED ******/

		/*for($i=1; $i<=$totalProductCount; $i++){
			  $sqlquoteProduct = "insert into c_quotes_products  (quoteId,productName,hdnProductId,qty,comment,type,listPrice ,discount_type ,discount ,discount_percentage ,discount_amount,qty_in_stock) values('".$lastInsertId."','".addslashes($_POST['productName'.$i])."' ,'".$_POST['hdnProductId'.$i]."','".$_POST['qty'.$i]."' ,'".addslashes($_POST['comment'.$i])."' , '".$_POST['type'.$i]."','".$_POST['listPrice'.$i]."' ,'".$_POST['discount_type'.$i]."' ,'".$_POST['discount'.$i]."' ,'".$_POST['discount_percentage'.$i]."' ,'".$_POST['discount_amount'.$i]."','".$_POST['qty_in_stock'.$i]."')";
			

		  $this->query($sqlquoteProduct, 0);
	}*/
	/************End PRODUCT**************/
		}
		return $lastInsertId;
		
	}

     function AddUpdateQuoteItem($order_id, $arryDetails)
		{  
			global $Config;
			extract($arryDetails);


			if(!empty($DelItem)){
				echo $strSQLQuery = "delete from c_quote_item where id in(".$DelItem.")"; 
				$this->query($strSQLQuery, 0);
			}
		   $discountAmnt = 0;$taxAmnt=0;
			for($i=1;$i<=$NumLine;$i++){
				if(!empty($arryDetails['sku'.$i])){
					$arryTax = explode(":",$arryDetails['tax'.$i]);
					$id = $arryDetails['id'.$i];
					
					if($arryDetails['discount'.$i] > 0){
					 $discountAmnt += $arryDetails['discount'.$i];
					}
				
					if($arryTax[1] > 0){
					 $actualAmnt = $arryDetails['price'.$i]-$arryDetails['discount'.$i];	
					 $taxAmnt = ($actualAmnt*$arryTax[1])/100;
					 $totalTaxAmnt += $taxAmnt;
					}
					if($id>0){
						$sql = "update c_quote_item set item_id='".$arryDetails['item_id'.$i]."', sku='".addslashes($arryDetails['sku'.$i])."', description='".addslashes($arryDetails['description'.$i])."', on_hand_qty='".addslashes($arryDetails['on_hand_qty'.$i])."', qty='".addslashes($arryDetails['qty'.$i])."', price='".addslashes($arryDetails['price'.$i])."', tax_id='".$arryTax[0]."', tax='".$arryTax[1]."', amount='".addslashes($arryDetails['amount'.$i])."', discount ='".addslashes($arryDetails['discount'.$i])."'  where id='".$id."'"; 
					}else{
						$sql = "insert into c_quote_item(OrderID, item_id, sku, description, on_hand_qty, qty, price, tax_id, tax, amount, discount) values('".$order_id."', '".$arryDetails['item_id'.$i]."', '".addslashes($arryDetails['sku'.$i])."', '".addslashes($arryDetails['description'.$i])."', '".addslashes($arryDetails['on_hand_qty'.$i])."', '".addslashes($arryDetails['qty'.$i])."', '".addslashes($arryDetails['price'.$i])."', '".$arryTax[0]."', '".$arryTax[1]."', '".addslashes($arryDetails['amount'.$i])."','".addslashes($arryDetails['discount'.$i])."')";
					}
					$this->query($sql, 0);	

				}
			}
$strSQL = "update c_quotes set discountAmnt ='".$discountAmnt."',taxAmnt = '".$taxAmnt."' where quoteid='".$order_id."'"; 
				$this->query($strSQL, 0);
			return true;

		}
	function updateQuote($arryDetails)
	{
		@extract($arryDetails);	

                                     $arryAsign = explode(":",$assignTo);
			  		
					 $AssignUser = $arryAsign[0];
					 $AssignType = $arryAsign[1];
					 $GroupID =  $arryAsign[2];

			$sql = "update c_quotes set subject = '".$subject."',
					 quotestage='".addslashes($quotestage)."',
					 validtill ='".$validtill."', 
					contactid = '".addslashes($contact_name)."', 
					carrier = '".$carrier."',
					 shipping = '".addslashes($shipping)."',
					assignTo = '".$AssignUser."',
AssignType = '".$AssignType."',
GroupID = '".$GroupID."',
					currency_id = '".$currency_id."',
					 description = '".$description."',
					 opportunityName = '".$opportunityName."',
		                           OpportunityID = '".$opportunityID."',
					TotalAmount = '".addslashes($TotalAmount)."',
					 Freight ='".addslashes($Freight)."'
				
				
				
				

			where quoteid = '".$quoteid."'"; 
			$rs = $this->query($sql,0);

		
  /********************OPPORTUNITY Update ******/
   $sql4 = "delete from c_quote_opp where quoteID = ".$quoteid;
		 $this->query($sql4,0);

if($opportunityID!=''){
	$sqlOppAdd="insert into c_quote_opp  (quoteID,opportunityName,opportunityID,mode_type) values(  '".addslashes				($quoteid)."','".addslashes($opportunityName)."','".addslashes($opportunityID)."','Quote')";
	$this->query($sqlOppAdd, 0);
}

		  /************End Opportunity**************/

		

 $sqlAddress = "update c_quotesbillads set bill_city = '".addslashes($bill_city)."',bill_code = '".addslashes($bill_code)."',bill_country = '".addslashes($bill_country)."',	bill_state = '".addslashes($bill_state)."',bill_street = '".addslashes($bill_street)."',									bill_pobox = '".$bill_pobox."',ship_city = '".$ship_city."',ship_code = '".$ship_code."',ship_country = '".addslashes($ship_country)."',						ship_state = '".addslashes($ship_state)."',ship_street = '".addslashes($ship_street)."',ship_pobox = '".addslashes($ship_pobox)."'
  where quoteid = '".$quoteid."'"; 
		  $rsUp = $this->query($sqlAddress,0);


		
		if(sizeof($rs)){	   

			return true;
		}else{
			return false;
		}
	}



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


		$sql = "select q.*,em.UserName,em.Email,d.Department,o.opportunityName,o.OpportunityID,o.quoteID as OppQuoteID from c_quotes q left outer join h_employee em on q.assignTo=em.EmpID left outer join  h_department d on em.Department=d.depID  left outer join  c_quote_opp o on q.quoteid=o.quoteID".$sql." order by q.quoteid Asc" ; 

		

		return $this->query($sql, 1);
	}


function GetQuoteAddress($quoteid,$Limit)
	{
		$sql = " where 1 ";
		$sql .= (!empty($quoteid))?(" and quoteid = '".$quoteid."'"):("");
		$sql = "select * from c_quotesbillads ".$sql; 

		return $this->query($sql, 1);
	}

            function  GetQuoteItem($quoteid)
		{
			$strAddQuery .= (!empty($quoteid))?(" and i.OrderID='".$quoteid."'"):("");
			$strSQLQuery = "select i.*,t.RateDescription from c_quote_item i left outer join inv_tax_rates t on i.tax_id=t.RateId where 1".$strAddQuery." order by i.id asc";
#echo $strSQLQuery; exit;
			return $this->query($strSQLQuery, 1);
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

		$sql3 = "delete from c_quote_item where OrderID = ".$quoteID;
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

			$htmlPrefix = $Config['EmailTemplateFolder'];
            
			 if($arryQuote[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
					$ToEmail = $Config['AdminEmail'];
			 }else{
				$CreatedBy = stripslashes($arryQuote[0]['CreatedBy']);
				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$arryQuote[0]['AdminID']."'";
				$arryEmp = $this->query($strSQLQuery, 1);
				$ToEmail = $arryEmp[0]['Email'];
				$CC = $Config['AdminEmail'];
				}

			
				//$QuoteTitle = GetQuoteTitle($arryQuote[0]);
				$contents = file_get_contents($htmlPrefix."new_quote.htm");
				//$contents = file_get_contents($Config['EmailTemplateFolder']."newquote.htm");
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[SUBJECT]",$arryQuote[0]['subject'],$contents);
				$contents = str_replace("[OPPORTUNITY]",$arryQuote[0]['opportunityName'],$contents);
				$contents = str_replace("[OPPORTUNITYID]",$arryQuote[0]['OpportunityID'],$contents);
				$contents = str_replace("[QUOTEID]",$arryQuote[0]['quoteid'],$contents);
				$contents = str_replace("[VALIDTILL]",date($Config['DateFormat'],strtotime($arryQuote[0]['validtill'])),$contents);
$contents = str_replace("[CREATED]",$CreatedBy,$contents);
				//$contents = str_replace("[type]",$arryQuote[0]['type'],$contents);
				//$contents = str_replace("[startDate]",$arryQuote[0]['startDate'],$contents);
				//$contents = str_replace("[endDate]",$arryQuote[0]['endDate'],$contents);
				$contents= str_replace("[LINK_URL]",$Config['Url'].'admin/crm/vQuote.php?view='.$quoteID.'&module=Quote', $contents);

				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
                                #$mail->AddAddress("bhoodev@sakshay.in");
                                //if(!empty($CC)) $mail->AddAddress($CC);
				$mail->sender($_SESSION['UserName'], $_SESSION['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - ".$_SESSION['UserName']." - has been Created New quote  ";
				$mail->IsHTML(true);
	
				$mail->Body = $contents;  
				#echo $ToEmail.$CC.$contents; exit;

				
				if($Config['Online'] == '1'){
					$mail->Send();	
				}
		
			return 1;
		}
		

	function SendAssignEmail($quoteID)
	 {
	  global $Config;

	 $arryQuote = $this->GetQuote($quoteID,'','','','');

	 $htmlPrefix = $Config['EmailTemplateFolder'];
            
                         if($arryQuote[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
					//$ToEmail = $Config['AdminEmail'];
			 }else{
				$CreatedBy = stripslashes($arryQuote[0]['CreatedBy']);
				$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$arryQuote[0]['AdminID']."'";
				$arryEmp = $this->query($strSQLQuery, 1);
				//$ToEmail = $arryEmp[0]['Email'];
                                $CreatedBy = $arryEmp[0]['UserName'];
				//$CC = $Config['AdminEmail'];
				}


	  if($arryQuote[0]['assignTo']>0){
		$AssignUser = $arryQuote[0]['assignTo'];
		$strSQLQuery = "select UserName,Email from h_employee where EmpID='".$AssignUser."'";
		$arryEmp = $this->query($strSQLQuery, 1);
		$ToEmail = $arryEmp[0]['Email'];
		$CC = $Config['AdminEmail'];
              }
				
		$contents = file_get_contents($htmlPrefix."assign_quote.htm");
		$contents = str_replace("[URL]",$Config['Url'],$contents);
		$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
		$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
                $contents = str_replace("[USERNAME]",$arryEmp[0]['UserName'],$contents);
		$contents = str_replace("[SUBJECT]",$arryQuote[0]['subject'],$contents);
		$contents = str_replace("[OPPORTUNITY]",$arryQuote[0]['opportunityName'],$contents);
		$contents = str_replace("[OPPORTUNITYID]",$arryQuote[0]['OpportunityID'],$contents);
		$contents = str_replace("[QUOTEID]",$arryQuote[0]['quoteid'],$contents);
		$contents = str_replace("[VALIDTILL]",date($Config['DateFormat'],strtotime($arryQuote[0]['validtill'])),$contents);
                $contents = str_replace("[CREATED]",$CreatedBy,$contents);
		$contents= str_replace("[LINK_URL]",$Config['Url'].'admin/crm/vQuote.php?view='.$quoteID.'&module=Quote', $contents);

		$mail = new MyMailer();
		$mail->IsMail();			
		$mail->AddAddress($ToEmail);
                #$mail->AddAddress("bhoodev@sakshay.in");
                if(!empty($CC)) $mail->AddAddress($CC);
		$mail->sender($_SESSION['UserName'], $_SESSION['AdminEmail']);   
		$mail->Subject = $Config['SiteName']." - ".$_SESSION['UserName']." - has been Assign New quote  ";
		$mail->IsHTML(true);

		$mail->Body = $contents;  
		#echo $ToEmail.$CC.$contents; exit;

		
		if($Config['Online'] == '1'){
			$mail->Send();	
		}
		
			return 1;
		}
		
		
		
	
	function  ListQuote($id=0,$parent_type,$parentID,$SearchKey,$SortBy,$AscDesc)
			{
			global $Config;
			$strAddQuery = ' where 1 ';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and q.quoteid=".$id):("");
			$strAddQuery .= ($Config['vAllRecord']!=1)?(" and (q.assignTo like '%".$_SESSION['AdminID']."%' OR q.AdminID='".$_SESSION['AdminID']."') "):("");

			if($SortBy == 'q.subject'){$strAddQuery .= (!empty($SearchKey))?(" and (q.subject like '%".$SearchKey."%')"):("");	}
			else if($SortBy == 'q.quoteid'){ $strAddQuery .= (!empty($SearchKey))?(" and (q.quoteid = '".$SearchKey."')"):("");}
			else{
			if($SortBy != ''){
			$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
			$strAddQuery .= (!empty($SearchKey))?(" and (q.subject like '%".$SearchKey."%' or q.quotestage like '%".$SearchKey."%' or o.OpportunityName like '%".$SearchKey."%' or q.TotalAmount like '%".$SearchKey."%' or q.quoteid like '%".$SearchKey."%'  )"):("");
			}
			}

			$strAddQuery .= (!empty($SortBy))?(" group by q.quoteid order by ".$SortBy." "):(" group by q.quoteid order by q.quoteid ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc ");


			$strSQLQuery = "select q.*,opp.OpportunityID,o.opportunityName,o.OpportunityID,o.quoteID as OppQuoteID,em.UserName,em.EmpID,em.Email,d.Department from c_quotes q left outer join c_opportunity opp on q.OpportunityID=opp.OpportunityID  inner join h_employee em on q.assignTo=em.EmpID left outer join  h_department d on em.Department=d.depID left outer join  c_quote_opp o on q.quoteid=o.quoteID  ".$strAddQuery;

			return $this->query($strSQLQuery, 1);

	}
	
	
	
	function GetAssignee($arrayDetail) {
		$strSQLQuery = "select EmpID,UserName,Email from h_employee where EmpID in (".$arrayDetail.")";
		return $this->query($strSQLQuery, 1);

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

	function sendOrderToCustomer($arrDetails)
		{
			global $Config;	
			extract($arrDetails);

			if($quoteid>0){
				$arrySale = $this->GetQuote($quoteid,'','');
				$module = $arrySale[0]['Module'];
				(!$module)?($module='Quote'):(""); 

				if($module=='Quote'){	
					$ModuleIDTitle = "Quote Number"; $ModuleID = "quoteid"; 
				}else if($module=='Order'){
					$ModuleIDTitle = "Sales Order Number"; $ModuleID = "SaleID";
				}

				if($arrySale[0]['AdminType'] == 'admin'){
					$CreatedBy = 'Administrator';
				}else{
					$CreatedBy = stripslashes($arrySale[0]['CreatedBy']);
				}
				
				$OrderDate = ($arrySale[0]['PostedDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['PostedDate']))):(NOT_SPECIFIED);
				$Approved = ($arrySale[0]['Approved'] == 1)?('Yes'):('No');

				$DeliveryDate = ($arrySale[0]['DeliveryDate']>0)?(date($Config['DateFormat'], strtotime($arrySale[0]['DeliveryDate']))):(NOT_SPECIFIED);

				$PaymentTerm = (!empty($arrySale[0]['PaymentTerm']))? (stripslashes($arrySale[0]['PaymentTerm'])): (NOT_SPECIFIED);
				$PaymentMethod = (!empty($arrySale[0]['PaymentMethod']))? (stripslashes($arrySale[0]['PaymentMethod'])): (NOT_SPECIFIED);
				$ShippingMethod = (!empty($arrySale[0]['ShippingMethod']))? (stripslashes($arrySale[0]['ShippingMethod'])): (NOT_SPECIFIED);
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				#$CreatedBy = ($arrySale[0]['AdminType'] == 'admin')? ('Administrator'): ($arrySale[0]['CreatedBy']);


				/**********************/
				$htmlPrefix = $Config['EmailTemplateFolder'];				
				$contents = file_get_contents($htmlPrefix."sales_cust.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

				$contents = str_replace("[Module]",$module,$contents);
				$contents = str_replace("[ModuleIDTitle]",$ModuleIDTitle,$contents);
				$contents = str_replace("[ModuleID]",$arrySale[0][$ModuleID],$contents);
				$contents = str_replace("[OrderDate]",$OrderDate,$contents);
				$contents = str_replace("[CreatedBy]",$CreatedBy,$contents);
				$contents = str_replace("[Approved]",$Approved,$contents);
				$contents = str_replace("[Status]",$arrySale[0]['Status'],$contents);
				$contents = str_replace("[Subject]",$arrySale[0]['subject'],$contents);
				$contents = str_replace("[Message]",$Message,$contents);
				$contents = str_replace("[DeliveryDate]",$DeliveryDate,$contents);
				$contents = str_replace("[PaymentTerm]",$PaymentTerm,$contents);
				$contents = str_replace("[PaymentMethod]",$PaymentMethod,$contents);
				$contents = str_replace("[ShippingMethod]",$ShippingMethod,$contents);
				$contents = str_replace("[Customer]",stripslashes($arrySale[0]['CustomerName']),$contents);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($ToEmail);
				if(!empty($CCEmail)) $mail->AddCC($CCEmail);
				if(!empty($Attachment)) $mail->AddAttachment($Attachment);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Sales ".$module;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $ToEmail.$CCEmail.$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}



		function  GetLeadCustomer($leadID)
		{
			$strSQLQuery = "select leadID,FirstName,LastName, primary_email from c_lead where primary_email!= '' ";
			$strSQLQuery .= (!empty($leadID))?(" and leadID!='".$leadID."'"):("");
			$strSQLQuery .= " order by FirstName";
			return $this->query($strSQLQuery, 1);
		}



}
?>
