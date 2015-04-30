<?
class payroll extends dbClass
{
		//constructor
		function payroll()
		{
			$this->dbClass();
		} 

		////////// Head Start ///////////////

		function addHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	


			$sql = "insert into h_pay_head (locationID, catID, heading, subheading, HeadType, Percentage, Amount, `Default`, Status, updatedDate) values('".$_SESSION['locationID']."', '".addslashes($catID)."', '".addslashes($heading)."', '".addslashes($subheading)."', '".addslashes($HeadType)."', '".addslashes($Percentage)."', '".addslashes($Amount)."', '".$Default."',  '".addslashes($Status)."', '".$Config['TodayDate']."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			if(!empty($headID)){
				if($HeadType=="Other")$Amount=0;
				$sql = "update h_pay_head set heading='".addslashes($heading)."', subheading = '".addslashes($subheading)."', Percentage = '".addslashes($Percentage)."', Amount = '".addslashes($Amount)."', HeadType = '".addslashes($HeadType)."' ,Status = '".$Status."', updatedDate = '".$Config['TodayDate']."'  where headID = '".$headID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and headID = '".mysql_real_escape_string($id)."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = '".mysql_real_escape_string($catID)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_pay_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function getDefaultHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where `Default`=1 ";
			$sql .= (!empty($id))?(" and headID = '".mysql_real_escape_string($id)."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = '".mysql_real_escape_string($catID)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_pay_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function changeHeadStatus($headID)
		{
			if(!empty($headID)){
				$sql="select * from  h_pay_head where headID='".mysql_real_escape_string($headID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{

					if($rs[0]['Status']==1){
						$Status=0; 
					}else{
						$Status=1;
					}
						
					$sql="update  h_pay_head set Status='".$Status."' where headID='".mysql_real_escape_string($headID)."'";
					$this->query($sql,0);
				}	
			}
			return true;
		}

		function deleteHead($headID)
		{
			if(!empty($headID)){
				$sql = "delete from h_pay_head where headID = '".mysql_real_escape_string($headID)."'";
				$rs = $this->query($sql,0);
			}

			return true;
		}
		
		function  ListHead($id=0, $catID=0, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and headID='".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($catID))?(" and catID='".mysql_real_escape_string($catID)."'"):("");

			if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or subheading like '%".$SearchKey."%' or Percentage like '%".$SearchKey."%' )"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by headID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from  h_pay_head ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function isHeadExists($heading, $catID, $headID)
		{

			$strSQLQuery = "select headID from h_pay_head where LCASE(heading)='".strtolower(trim($heading))."' and locationID='".$_SESSION['locationID']."' and catID='".$catID."'";

			$strSQLQuery .= (!empty($headID))?(" and headID != '".$headID."'"):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['headID'])) {
				return true;
			} else {
				return false;
			}

		}
		/***************************/

		////////// Head Start ///////////////

		function addDecHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	


			$sql = "insert into h_dec_head (locationID, catID, heading, subheading, `Default`, Status, updatedDate) values('".$_SESSION['locationID']."', '".addslashes($catID)."', '".addslashes($heading)."', '".addslashes($subheading)."', '".$Default."',  '".addslashes($Status)."', '".$Config['TodayDate']."' )";
		
			$this->query($sql, 0);
			$lastInsertId = $this->lastInsertId();
			return $lastInsertId;

		}
		function updateDecHead($arryDetails)
		{
			global $Config;
			@extract($arryDetails);	
			$sql = "update h_dec_head set heading='".addslashes($heading)."', subheading = '".addslashes($subheading)."',Status = '".$Status."', updatedDate = '".$Config['TodayDate']."'  where headID = '".$headID."'"; 
			$rs = $this->query($sql,0);
				
			if(sizeof($rs))
				return true;
			else
				return false;

		}

		function getDecHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where 1";
			$sql .= (!empty($id))?(" and headID = '".mysql_real_escape_string($id)."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = '".mysql_real_escape_string($catID)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_dec_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function getDefaultDecHead($id=0, $catID=0, $Status=0)
		{
			$sql = " where `Default`=1 ";
			$sql .= (!empty($id))?(" and headID = '".mysql_real_escape_string($id)."'"):(" and locationID=".$_SESSION['locationID']);
			$sql .= (!empty($catID))?(" and catID = '".mysql_real_escape_string($catID)."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from  h_dec_head ".$sql." order by headID Asc" ; 
			return $this->query($sql, 1);
		}

		function changeDecHeadStatus($headID)
		{
			$headID = mysql_real_escape_string($headID);
			if(!empty($headID)){
				$sql="select * from  h_dec_head where headID='".$headID."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{

					if($rs[0]['Status']==1){
						$Status=0; 
					}else{
						$Status=1;
					}
						
					$sql="update  h_dec_head set Status='$Status' where headID='".$headID."'";
					$this->query($sql,0);
				}	
			}
			return true;
		}

		function deleteDecHead($headID)
		{
			if(!empty($headID)){
				$sql = "delete from  h_dec_head where headID = '".mysql_real_escape_string($headID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}
		
		function  ListDecHead($id=0, $catID=0, $SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = " where 1";
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" and headID='".$id."'"):(" and locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($catID))?(" and catID='".$catID."'"):("");

			if($SearchKey=='active' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='Status' || $SortBy=='') ){
					$strAddQuery .= " and Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (heading like '%".$SearchKey."%' or subheading like '%".$SearchKey."%' )"):("");
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by headID ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Asc ");

			$strSQLQuery = "select * from  h_dec_head ".$strAddQuery;
			return $this->query($strSQLQuery, 1);

		}

		function isDecHeadExists($heading, $catID, $headID)
		{

			$strSQLQuery = "select headID from h_dec_head where LCASE(heading)='".strtolower(trim($heading))."' and locationID=".$_SESSION['locationID']." and catID='".$catID."'";

			$strSQLQuery .= (!empty($headID))?(" and headID != '".$headID."'"):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['headID'])) {
				return true;
			} else {
				return false;
			}

		}
		/***************************/	


		function getPayCategory($catID=0,$Status)
		{
			$addsql = (!empty($catID))?(" and catID='".mysql_real_escape_string($catID)."'"):("");
			$addsql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
			$sql = "select * from  h_pay_cat where 1 ".$addsql." order by catID Asc" ; 
			return $this->query($sql, 1);
		}

		function getDecCategory($catID=0,$Status)
		{
			$addsql = (!empty($catID))?(" and catID='".mysql_real_escape_string($catID)."'"):("");
			$addsql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");
			$sql = "select * from  h_dec_cat where 1 ".$addsql." order by catID Asc" ; 
			return $this->query($sql, 1);
		}

		/********** Salary Management *********/
		/*******************************************/
		function  ListSalary($id=0,$depID,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where s.salaryID='".mysql_real_escape_string($id)."'"):(" where e.locationID=".$_SESSION['locationID']);

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%') " ):("");			
			}			

			$strAddQuery .= (!empty($depID))?(" and d.depID='".mysql_real_escape_string($depID)."'"):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by e.UserName asc ");

			$strSQLQuery = "select s.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_salary s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getSalary($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.salaryID='".mysql_real_escape_string($id)."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID='".mysql_real_escape_string($EmpID)."'"):("");

			$strSQLQuery = "select s.*,e.UserName,e.Email,e.JobTitle, d.Department from h_salary s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deleteSalary($salaryID){
			if(!empty($salaryID)){
				$sql = "delete from h_salary where salaryID = '".mysql_real_escape_string($salaryID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}


		function addSalary($arryDetails){ 
			global $Config;
			/********************/
			$SalaryData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			/********************/
			@extract($arryDetails);	 
			$sql = "insert into h_salary(EmpID, CTC, Gross, NetSalary, SalaryData, updatedDate, BankName, AccountName, AccountNumber, IFSCCode) values('".$EmpID."', '".$CTC."', '".$Gross."', '".$NetSalary."', '".$SalaryData."', '".$Config['TodayDate']."', '".addslashes($BankName)."', '".addslashes($AccountName)."', '".addslashes($AccountNumber)."', '".addslashes($IFSCCode)."')";
			$this->query($sql,0);
			return true;
		}

		function updateSalary($arryDetails){
			global $Config;
			/********************/
			$SalaryData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			/********************/
			@extract($arryDetails);	
			$sql = "update h_salary set CTC='".$CTC."', Gross = '".$Gross."', NetSalary = '".$NetSalary."', SalaryData = '".$SalaryData."', updatedDate = '".$Config['TodayDate']."', BankName='".addslashes($BankName)."'		,AccountName='".addslashes($AccountName)."'	, AccountNumber='".addslashes($AccountNumber)."', IFSCCode='".addslashes($IFSCCode)."' where salaryID = '".$salaryID."'"; 
			$rs = $this->query($sql,0);
				
			return true;
		}

		function isSalaryExists($EmpID,$salaryID)
		{
			$strSQLQuery = "select salaryID from h_salary where EmpID='".trim($EmpID)."' ";

			$strSQLQuery .= (!empty($salaryID))?(" and salaryID != '".$salaryID."'"):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['salaryID'])) {
				return $arryRow[0]['salaryID'];
			} else {
				return false;
			}

		}

		/**********Generated Salary Management *********/
		/*******************************************/
		function  ListPaySalary($Department, $EmpID,$Year,$Month,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= ($EmpID>0)?(" where p.EmpID='".mysql_real_escape_string($EmpID)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($Year))?(" and p.Year='".mysql_real_escape_string($Year)."'"):("");
			$strAddQuery .= (!empty($Month))?(" and p.Month='".mysql_real_escape_string($Month)."'"):("");
			$strAddQuery .= (!empty($Department))?(" and e.Department='".mysql_real_escape_string($Department)."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%') " ):("");			
			}			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by p.Year desc, p.Month desc ");

			$strSQLQuery = "select p.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.depID, d.Department from h_pay_salary p inner join h_employee e on p.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deletePaySalary($payID){
			if(!empty($payID)){
				$sql = "delete from h_pay_salary where payID = '".mysql_real_escape_string($payID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}


		function changePayStatus($payID)
		{
			if(!empty($payID)){
				$sql="select payID,Status from h_pay_salary where payID='".mysql_real_escape_string($payID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1)
						$Status=0;
					else
						$Status=1;
						
					$sql="update h_pay_salary set Status='$Status' where payID='".mysql_real_escape_string($payID)."'";
					$this->query($sql,0);				

				}		
			}
			return true;
		}

		function isPaySalaryExists($EmpID,$Year,$Month)
		{
			if(!empty($EmpID)){
				$strSQLQuery = "select payID from h_pay_salary where EmpID='".trim($EmpID)."' and Year='".trim($Year)."' and Month='".trim($Month)."'";

				$arryRow = $this->query($strSQLQuery, 1);
				if (!empty($arryRow[0]['payID'])) {
					return $arryRow[0]['payID'];
				} else {
					return false;
				}
			}

		}

		function addPaySalary($arryDetails){ 
			global $Config;
			/********************/
			$SalaryData='';
			
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			
			/********************/ 
			@extract($arryDetails);	 
			$sql = "insert into h_pay_salary(EmpID, Year, Month, CTC, Gross, NetSalary, CurrentSalary, SalaryData, addedDate, updatedDate, SubTotalA, SubTotalB, SubTotalC, SubTotalD, LeaveTaken, LeaveDeduction, Advance, Loan, Overtime, Bonus ) values('".$EmpID."', '".$Year."', '".$Month."', '".$CTC."', '".$Gross."', '".$NetSalary."', '".$CurrentSalary."', '".$SalaryData."', '".$Config['TodayDate']."', '".$Config['TodayDate']."', '".$SubTotalA."', '".$SubTotalB."', '".$SubTotalC."', '".$SubTotalD."', '".$LeaveTaken."', '".$LeaveDeduction."', '".$Advance."', '".$Loan ."', '".$Overtime."', '".$Bonus ."')";
			$this->query($sql,0);
			return true;
		}

		function updatePaySalary($arryDetails){
			global $Config;
			/********************/
			$SalaryData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$SalaryData .= $headID.':'.$values.'#';
				}
			}
			$SalaryData = rtrim($SalaryData,"#");
			/********************/
			@extract($arryDetails);	
			if(!empty($payID)){
				$sql = "update h_pay_salary set CTC='".$CTC."', Gross = '".$Gross."', NetSalary = '".$NetSalary."', CurrentSalary = '".$CurrentSalary."', SalaryData = '".$SalaryData."', updatedDate = '".$Config['TodayDate']."', SubTotalA = '".$SubTotalA."', SubTotalB = '".$SubTotalB."', SubTotalC = '".$SubTotalC."', SubTotalD = '".$SubTotalD."', LeaveTaken = '".$LeaveTaken."', LeaveDeduction = '".$LeaveDeduction."', Advance = '".$Advance."', Loan = '".$Loan."', Overtime = '".$Overtime."', Bonus = '".$Bonus."' where payID = '".$payID."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;
		}


		function  getPaySalary($id=0,$EmpID,$Year,$Month){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where p.payID='".mysql_real_escape_string($id)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($EmpID))?(" and p.EmpID='".mysql_real_escape_string($EmpID)."'"):("");
			$strAddQuery .= (!empty($Year))?(" and p.Year='".mysql_real_escape_string($Year)."'"):("");
			$strAddQuery .= (!empty($Month))?(" and p.Month=".mysql_real_escape_string($Month)."'"):("");

			$strSQLQuery = "select p.*,e.UserName,e.Email,e.JobTitle, d.Department from h_pay_salary p inner join h_employee e on p.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}


		function  EmpToPaySalary($Department,$Year,$Month){
			$strAddQuery .= (!empty($Department))?(" and e.Department='".mysql_real_escape_string($Department)."'"):("");

			$strSQLQuery = "select s.Gross, s.NetSalary, s.SalaryData, e.EmpID,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.depID, d.Department from h_employee e left outer join h_department d on e.Department=d.depID inner join h_salary s on e.EmpID=s.EmpID left outer join h_pay_salary p on (e.EmpID=p.EmpID and p.Year='".$Year."' and p.Month='".$Month."') where p.payID IS NULL and e.locationID='".$_SESSION['locationID']."' ".$strAddQuery." order by e.UserName asc";
		
			return $this->query($strSQLQuery, 1);	
					
		}


		/********** Employee Declaration Management *********/
		/*******************************************/
		function  ListDeclaration($EmpID=0,$Year,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($EmpID))?(" where s.EmpID='".mysql_real_escape_string($EmpID)."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($Year))?(" and s.Year='".mysql_real_escape_string($Year)."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%' or s.Year like '%".$SearchKey."%') " ):("");			
			}			

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by d.depID asc, s.decID asc ");

			$strSQLQuery = "select s.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_declaration s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getDeclaration($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.decID='".mysql_real_escape_string($id)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID='".mysql_real_escape_string($EmpID)."'"):("");

			$strSQLQuery = "select s.*,e.UserName,e.Email,e.JobTitle, d.Department from h_declaration s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deleteDeclaration($decID){
			if(!empty($decID)){
				$strSQLQuery = "select document from h_declaration where decID='".mysql_real_escape_string($decID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				
				$DecDir = 'upload/declaration/';

				if($arryRow[0]['document'] !='' && file_exists($DecDir.$arryRow[0]['document']) ){									
					unlink($DecDir.$arryRow[0]['document']);	
				}

				$sql = "delete from h_declaration where decID = '".mysql_real_escape_string($decID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}


		function addDeclaration($arryDetails){ 
			global $Config;

			@extract($arryDetails);	 
			$sql = "insert into h_declaration(EmpID, Year, updatedDate) values('".mysql_real_escape_string(strip_tags($EmpID))."', '".mysql_real_escape_string(strip_tags($Year))."', '".$Config['TodayDate']."')";

			$this->query($sql, 0);
			$decID = $this->lastInsertId();

			return $decID;
		}

		function updateDeclaration($arryDetails){
			global $Config;
			@extract($arryDetails);	
			if(!empty($decID)){
				$sql = "update h_declaration set Year='".mysql_real_escape_string(strip_tags($Year))."', updatedDate = '".$Config['TodayDate']."' where decID = '".mysql_real_escape_string($decID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;
		}

		function updateDeclarationFile($document,$decID)
		{
			if(!empty($decID)){
				$strSQLQuery = "select document from h_declaration where decID='".mysql_real_escape_string($decID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				
				$DecDir = 'upload/declaration/';

				if($arryRow[0]['document'] !='' && file_exists($DecDir.$arryRow[0]['document']) ){									
					unlink($DecDir.$arryRow[0]['document']);	
				}



				$strSQLQuery = "update h_declaration set document='".mysql_real_escape_string(strip_tags($document))."' where decID='".mysql_real_escape_string($decID)."'";
				return $this->query($strSQLQuery, 0);
			}
		}

		function isDeclarationExists($EmpID,$Year,$decID)
		{
			$strSQLQuery = "select decID from h_declaration where EmpID='".mysql_real_escape_string(trim($EmpID))."' and Year='".mysql_real_escape_string($Year)."' ";

			$strSQLQuery .= (!empty($decID))?(" and decID != '".mysql_real_escape_string($decID)."'"):("");

			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['decID'])) {
				return $arryRow[0]['decID'];
			} else {
				return false;
			}

		}


		/********** Appraisal Management *********/
		/*******************************************/
		function  ListAppraisal($id=0,$depID,$SearchKey,$SortBy,$AscDesc){
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where a.appraisalID='".$id."'"):(" where e.locationID=".$_SESSION['locationID']);

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (a.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%'  ) " ):("");			
			}			

			$strAddQuery .= (!empty($depID))?(" and d.depID='".$depID."'"):("");

			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." ".$AscDesc):(" order by d.depID asc, e.EmpID asc ");

			$strSQLQuery = "select a.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_appraisal a inner join h_employee e on a.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getAppraisal($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where a.appraisalID='".$id."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($EmpID))?(" and a.EmpID='".$EmpID."'"):("");

			$strSQLQuery = "select a.*,e.UserName,e.Email,e.JobTitle, d.Department from h_appraisal a inner join h_employee e on a.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deleteAppraisal($appraisalID){
			if(!empty($appraisalID)){
				$sql = "delete from h_appraisal where appraisalID = '".mysql_real_escape_string($appraisalID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}


		function addAppraisal($arryDetails){ 
			global $Config;
			/********************
			$AppraisalData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$AppraisalData .= $headID.':'.$valuea.'#';
				}
			}
			$AppraisalData = rtrim($AppraisalData,"#");
			/********************/
			@extract($arryDetails);	 
			$sql = "insert into h_appraisal(EmpID, CTC, AppraisalAmount, NetSalary, AppraisalData, FromDate, updatedDate) values('".$EmpID."', '".$CTC."', '".$AppraisalAmount."', '".$NetSalary."', '".$AppraisalData."', '".$FromDate."','".$Config['TodayDate']."')";
			$this->query($sql,0);
			return true;
		}

		function updateAppraisal($arryDetails){
			global $Config;
			/********************
			$AppraisalData='';
			foreach($arryDetails as $key=>$values){
				if(substr_count($key, 'Field')>0){
					$headID = str_replace("Field","",$key);
					$AppraisalData .= $headID.':'.$valuea.'#';
				}
			}
			$AppraisalData = rtrim($AppraisalData,"#");
			/********************/
			@extract($arryDetails);	
			if(!empty($appraisalID)){
				$sql = "update h_appraisal set CTC='".$CTC."', AppraisalAmount = '".$AppraisalAmount."', NetSalary = '".$NetSalary."', AppraisalData = '".$AppraisalData."', FromDate = '".$FromDate."', updatedDate = '".$Config['TodayDate']."' where appraisalID = '".mysql_real_escape_string($appraisalID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;
		}

		function isAppraisalExists($EmpID,$appraisalID)
		{
			$strSQLQuery = "select appraisalID from h_appraisal where EmpID='".trim($EmpID)."' ";

			$strSQLQuery .= (!empty($appraisalID))?(" and appraisalID != '".$appraisalID."'"):("");
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['appraisalID'])) {
				return $arryRow[0]['appraisalID'];
			} else {
				return false;
			}

		}



		/********** Employee Advance Management *********/
		/************************************************/
		function  ListAdvance($arryDetails){
			extract($arryDetails);
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($EmpID))?(" where s.EmpID='".mysql_real_escape_string($EmpID)."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($FromDate))?(" and s.ApplyDate>='".mysql_real_escape_string($FromDate)."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and s.ApplyDate<='".mysql_real_escape_string($ToDate)."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%' or  d.Department like '%".$SearchKey."%' or s.Status like '%".$SearchKey."%' ) " ):("");			
			}			

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by s.AdvID desc ");

			$strSQLQuery = "select s.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_advance s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getActiveAdvance($EmpID,$Year,$Month){
			if(!empty($EmpID)){
				if(!empty($Year) && !empty($Month)){
					$FromDate = $Year."-".$Month."-01";
					$date = date('Y-m-d', mktime(0, 0, 0, $Month + 1, 1, $Year));
					$addsql = " and s.IssueDate<='".$date."'";
				}
				$strSQLQuery = "select s.* from h_advance s inner join h_employee e on s.EmpID=e.EmpID where s.EmpID='".mysql_real_escape_string($EmpID)."' and s.ReturnPeriod>0 and s.ReturnType='2' and s.Approved='1' and s.Returned!='1' and s.Status!='Closed' ".$addsql." order by s.AdvID desc";		
				return $this->query($strSQLQuery, 1);
			}
					
		}

		function  getAdvance($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.AdvID='".mysql_real_escape_string($id)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID='".mysql_real_escape_string($EmpID)."'"):("");

			$strSQLQuery = "select s.*,e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_advance s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery." order by s.AdvID desc";		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getAdvanceReturn($AdvID){
			if(!empty($AdvID)){
				$strSQLQuery = "select * from  h_advance_return where AdvID= '".mysql_real_escape_string($AdvID)."' order by ReturnDate asc";
				return $this->query($strSQLQuery, 1);	
			}
		}

		function deleteAdvance($AdvID){
			if(!empty($AdvID)){
				$sql = "delete from h_advance where AdvID = '".mysql_real_escape_string($AdvID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}


		function addAdvance($arryDetails){ 
			global $Config;
			@extract($arryDetails);	 

			switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}


			$sql = "insert into h_advance(EmpID, Amount, IssueDate, ApplyDate, Approved, ReturnType, ReturnDate, ReturnPeriod, updatedDate,Status,Comment) values('".mysql_real_escape_string(strip_tags($EmpID))."', '".mysql_real_escape_string(strip_tags($Amount))."', '".mysql_real_escape_string(strip_tags($IssueDate))."', '".$Config['TodayDate']."', '".mysql_real_escape_string(strip_tags($Approved))."', '".mysql_real_escape_string(strip_tags($ReturnType))."', '".mysql_real_escape_string(strip_tags($ReturnDate))."', '".mysql_real_escape_string(strip_tags($ReturnPeriod))."', '".$Config['TodayDate']."', '".mysql_real_escape_string(strip_tags($Status))."', '".mysql_real_escape_string(strip_tags($Comment))."')";

			$this->query($sql, 0);
			$AdvID = $this->lastInsertId();

			return $AdvID;
		}


		function returnAdvance($arryDetails){
			global $Config;
			@extract($arryDetails);	
			if(!empty($AdvID)){

				$sql_ins = "insert into h_advance_return(AdvID, ReturnAmount, ReturnDate, updatedDate) values('".mysql_real_escape_string(strip_tags($AdvID))."', '".mysql_real_escape_string(strip_tags($ReturnAmount))."', '".mysql_real_escape_string(strip_tags($ReturnDate))."',  '".$Config['TodayDate']."')";
				$this->query($sql_ins, 0);

				$sql = "update h_advance set Status='In Process',AmountReturned=AmountReturned+".$ReturnAmount.", updatedDate = '".$Config['TodayDate']."' where AdvID = '".mysql_real_escape_string($AdvID)."'"; 
				$rs = $this->query($sql,0);
				/****************************/
				$strSQLQuery = "select AmountReturned,Amount from h_advance where AdvID='".mysql_real_escape_string($AdvID)."'";
				$arryRow = $this->query($strSQLQuery, 1);	
				if($arryRow[0]['AmountReturned']>=$arryRow[0]['Amount']){
					$sql = "update h_advance set Returned='1',Status='Closed' where AdvID = '".mysql_real_escape_string($AdvID)."'"; 
					$rs = $this->query($sql,0);
				}
				/****************************/

			}
				
			return true;
		}

		
		function updateReturnAdvance($AdvanceData){
			global $Config;
			if(!empty($AdvanceData)){
				$arryAdvanceData = explode("#",$AdvanceData);
				foreach($arryAdvanceData as $values_sub){
					$arryIDAdvance = explode(":",$values_sub);
					if($arryIDAdvance[0]>0 && !empty($arryIDAdvance[1])){
						$arryAdvance["AdvID"] = $arryIDAdvance[0];
						$arryAdvance["ReturnAmount"] = $arryIDAdvance[1];
						$arryAdvance["ReturnDate"] = $Config['TodayDate'];

						$StartDate = date("Y-m")."-01"; $EndDate = date("Y-m")."-31";

						$strSQLQuery = "select ReturnID from h_advance_return where AdvID='".$arryAdvance["AdvID"]."' and ReturnDate>='".$StartDate."' and ReturnDate<='".$EndDate."'";
						$arryRow = $this->query($strSQLQuery, 1);	
						
						if(empty($arryRow[0]["ReturnID"])){
							$this->returnAdvance($arryAdvance);
						}
						
					}

				} //end foreach




			} //end first if


		}

		function updateAdvance($arryDetails){
			global $Config;
			@extract($arryDetails);	

			switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}


			if(!empty($AdvID)){
				$sql = "update h_advance set Approved='".mysql_real_escape_string(strip_tags($Approved))."', Status='".mysql_real_escape_string(strip_tags($Status))."',IssueDate='".mysql_real_escape_string(strip_tags($IssueDate))."',  Comment='".mysql_real_escape_string(strip_tags($Comment))."', updatedDate = '".$Config['TodayDate']."' where AdvID = '".mysql_real_escape_string($AdvID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}


		function sendAdvanceEmail($AdvID)
		{
			global $Config;	
			$AdvID = mysql_real_escape_string($AdvID);
			if($AdvID>0){
				$arryRow = $this->getAdvance($AdvID,''); 


				$ReturnType = ($arryAdvance[0]['ReturnType']=="1")?(RETURN_ONE):(RETURN_INSTALLMENT);
				$Amount = (!empty($arryRow[0]['Amount']))?(number_format($arryRow[0]['Amount'])." ".$Config['Currency']):("0");
				$Comment = (!empty($arryRow[0]['Comment']))?(nl2br(stripslashes($arryRow[0]['Comment']))):(NOT_SPECIFIED);

				if($arryRow[0]['EmpID']!=$arryRow[0]['Supervisor']){
					$sql = "select Email from h_employee where EmpID='".$arryRow[0]['Supervisor']."'" ; 
					$arrySupervisor = $this->query($sql, 1);
				}
				if($arryRow[0]['Approved']==1){
					$arryRow[0]['Status'] = 'Approved';
				}

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."advance.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[ReturnType]",$ReturnType,$contents);
				$contents = str_replace("[Amount]",$Amount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Advance Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/
				$contents = file_get_contents($htmlPrefix."advance_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[ReturnType]",$ReturnType,$contents);
				$contents = str_replace("[Amount]",$Amount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}
				if(!empty($arrySupervisor[0]['Email'])){
					$mail->AddCC($arrySupervisor[0]['Email']);
				}			
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Advance Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arrySupervisor[0]['Email'].$Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}



		/********** Employee Loan Management *********/
		/************************************************/
		function  ListLoan($arryDetails){
			extract($arryDetails);
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($EmpID))?(" where s.EmpID='".mysql_real_escape_string($EmpID)."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($FromDate))?(" and s.ApplyDate>='".mysql_real_escape_string($FromDate)."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and s.ApplyDate<='".mysql_real_escape_string($ToDate)."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%' or  d.Department like '%".$SearchKey."%' or s.Status like '%".$SearchKey."%' ) " ):("");			
			}			

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by s.LoanID desc ");

			$strSQLQuery = "select s.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_loan s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getLoan($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.LoanID='".mysql_real_escape_string($id)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID='".mysql_real_escape_string($EmpID)."'"):("");

			$strSQLQuery = "select s.*,e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_loan s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery." order by s.LoanID desc";		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getActiveLoan($EmpID,$Year,$Month){
			if(!empty($EmpID)){
				if(!empty($Year) && !empty($Month)){
					$FromDate = $Year."-".$Month."-01";
					$date = date('Y-m-d', mktime(0, 0, 0, $Month + 1, 1, $Year));
					$addsql = " and s.IssueDate<='".$date."'";
				}
				
				$strSQLQuery = "select s.* from h_loan s inner join h_employee e on s.EmpID=e.EmpID where s.EmpID='".mysql_real_escape_string($EmpID)."' and s.Approved='1' and s.Returned!='1' and s.Status!='Closed' ".$addsql." order by s.LoanID desc";		
				return $this->query($strSQLQuery, 1);
			}
					
		}

		function  getLoanReturn($LoanID){
			if(!empty($LoanID)){
				$strSQLQuery = "select * from  h_loan_return where LoanID= '".mysql_real_escape_string($LoanID)."' order by ReturnDate asc";
				return $this->query($strSQLQuery, 1);	
			}
		}

		function deleteLoan($LoanID){
			if(!empty($LoanID)){
				$sql = "delete from h_loan where LoanID = '".mysql_real_escape_string($LoanID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}


		function addLoan($arryDetails){ 
			global $Config;
			@extract($arryDetails);	 

			switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}


			$sql = "insert into h_loan(EmpID, Amount, IssueDate, ApplyDate, Approved, ReturnType, ReturnDate, ReturnPeriod, updatedDate,Status,Comment,Rate) values('".mysql_real_escape_string(strip_tags($EmpID))."', '".mysql_real_escape_string(strip_tags($Amount))."', '".mysql_real_escape_string(strip_tags($IssueDate))."', '".$Config['TodayDate']."', '".mysql_real_escape_string(strip_tags($Approved))."', '".mysql_real_escape_string(strip_tags($ReturnType))."', '".mysql_real_escape_string(strip_tags($ReturnDate))."', '".mysql_real_escape_string(strip_tags($ReturnPeriod))."', '".$Config['TodayDate']."', '".mysql_real_escape_string(strip_tags($Status))."', '".mysql_real_escape_string(strip_tags($Comment))."', '".mysql_real_escape_string(strip_tags($Rate))."')";

			$this->query($sql, 0);
			$LoanID = $this->lastInsertId();

			return $LoanID;
		}


		function returnLoan($arryDetails){
			global $Config;
			@extract($arryDetails);	
			if(!empty($LoanID)){

				$sql_ins = "insert into h_loan_return(LoanID, ReturnAmount, ReturnDate, updatedDate) values('".mysql_real_escape_string(strip_tags($LoanID))."', '".mysql_real_escape_string(strip_tags($ReturnAmount))."', '".mysql_real_escape_string(strip_tags($ReturnDate))."',  '".$Config['TodayDate']."')";
				$this->query($sql_ins, 0);

				$sql = "update h_loan set Status='In Process',AmountReturned=AmountReturned+".$ReturnAmount.", updatedDate = '".$Config['TodayDate']."' where LoanID = '".mysql_real_escape_string($LoanID)."'"; 
				$rs = $this->query($sql,0);
				/****************************/
				$strSQLQuery = "select AmountReturned,Amount from h_loan where LoanID='".mysql_real_escape_string($LoanID)."'";
				$arryRow = $this->query($strSQLQuery, 1);	
				if($arryRow[0]['AmountReturned']>=$arryRow[0]['Amount']){
					$sql = "update h_loan set Returned='1',Status='Closed' where LoanID = '".mysql_real_escape_string($LoanID)."'"; 
					$rs = $this->query($sql,0);
				}
				/****************************/

			}
				
			return true;
		}



	function updateReturnLoan($LoanData){
			global $Config;
			if(!empty($LoanData)){
				$arryLoanData = explode("#",$LoanData);
				foreach($arryLoanData as $values_sub){
					$arryIDLoan = explode(":",$values_sub);
					if($arryIDLoan[0]>0 && !empty($arryIDLoan[1])){
						$arryLoan["LoanID"] = $arryIDLoan[0];
						$arryLoan["ReturnAmount"] = $arryIDLoan[1];
						$arryLoan["ReturnDate"] = $Config['TodayDate'];

						$StartDate = date("Y-m")."-01"; $EndDate = date("Y-m")."-31";

						$strSQLQuery = "select ReturnID from h_loan_return where LoanID='".$arryLoan["LoanID"]."' and ReturnDate>='".$StartDate."' and ReturnDate<='".$EndDate."'";
						$arryRow = $this->query($strSQLQuery, 1);	
						
						if(empty($arryRow[0]["ReturnID"])){
							$this->returnLoan($arryLoan);
						}
						
					}

				} //end foreach




			} //end first if


		}




		function updateLoan($arryDetails){
			global $Config;
			@extract($arryDetails);	

			switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}

			if($Approved==1 && !empty($IssueDate)){
				$strSQLQuery = "select ReturnPeriod from h_loan where LoanID='".mysql_real_escape_string($LoanID)."'";
				$arryRow = $this->query($strSQLQuery, 1);
				$ReturnPeriod = $arryRow[0]['ReturnPeriod'];

				$DateAry = explode("-",$IssueDate);
				$ReturnDate = date('Y-m-d', mktime(0, 0, 0, $DateAry[1]+$ReturnPeriod, $DateAry[2], $DateAry[0]));
				$AddSql = ",ReturnDate='".$ReturnDate."'";
				
			}


			if(!empty($LoanID)){
				$sql = "update h_loan set Approved='".mysql_real_escape_string(strip_tags($Approved))."', Status='".mysql_real_escape_string(strip_tags($Status))."',IssueDate='".mysql_real_escape_string(strip_tags($IssueDate))."', Comment='".mysql_real_escape_string(strip_tags($Comment))."', Rate='".mysql_real_escape_string(strip_tags($Rate))."', updatedDate = '".$Config['TodayDate']."' ".$AddSql." where LoanID = '".mysql_real_escape_string($LoanID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}


		function sendLoanEmail($LoanID)
		{
			global $Config;	
			$LoanID = mysql_real_escape_string($LoanID);
			if($LoanID>0){
				$arryRow = $this->getLoan($LoanID,''); 


				$ReturnType = ($arryLoan[0]['ReturnType']=="1")?(RETURN_ONE):(RETURN_INSTALLMENT);
				$Amount = (!empty($arryRow[0]['Amount']))?(number_format($arryRow[0]['Amount'])." ".$Config['Currency']):("0");
				$Comment = (!empty($arryRow[0]['Comment']))?(nl2br(stripslashes($arryRow[0]['Comment']))):(NOT_SPECIFIED);

				if($arryRow[0]['EmpID']!=$arryRow[0]['Supervisor']){
					$sql = "select Email from h_employee where EmpID='".$arryRow[0]['Supervisor']."'" ; 
					$arrySupervisor = $this->query($sql, 1);
				}
				if($arryRow[0]['Approved']==1){
					$arryRow[0]['Status'] = 'Approved';
				}

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."loan.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[ReturnType]",$ReturnType,$contents);
				$contents = str_replace("[Amount]",$Amount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Loan Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				#echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/
				$contents = file_get_contents($htmlPrefix."loan_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[ReturnType]",$ReturnType,$contents);
				$contents = str_replace("[Amount]",$Amount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}
				if(!empty($arrySupervisor[0]['Email'])){
					$mail->AddCC($arrySupervisor[0]['Email']);
				}			
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Loan Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				#echo $arrySupervisor[0]['Email'].$Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}


		/********** Employee Bonus Management *********/
		/************************************************/
		function  ListBonus($arryDetails){
			extract($arryDetails);
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($EmpID))?(" where s.EmpID='".mysql_real_escape_string($EmpID)."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($y))?(" and s.Year='".mysql_real_escape_string($y)."'"):("");
			$strAddQuery .= (!empty($m))?(" and s.Month='".mysql_real_escape_string($m)."'"):("");

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%' or  d.Department like '%".$SearchKey."%' or s.Status like '%".$SearchKey."%' ) " ):("");			
			}			

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." ".$asc):(" order by s.Year desc, s.Month desc ");

			$strSQLQuery = "select s.*,e.EmpCode,e.UserName,e.Email,e.JobTitle, d.Department from h_bonus s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery;		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function  getBonus($id=0,$EmpID){
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where s.BonusID='".mysql_real_escape_string($id)."'"):(" where e.locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strAddQuery .= (!empty($EmpID))?(" and s.EmpID='".mysql_real_escape_string($EmpID)."'"):("");

			$strSQLQuery = "select s.*,e.UserName,e.EmpCode,e.Email,e.JobTitle, e.Supervisor, d.Department from h_bonus s inner join h_employee e on s.EmpID=e.EmpID left outer join h_department d on e.Department=d.depID ".$strAddQuery." order by s.BonusID desc";		
		
			return $this->query($strSQLQuery, 1);	
					
		}

		function deleteBonus($BonusID){
			if(!empty($BonusID)){
				$sql = "delete from h_bonus where BonusID = '".mysql_real_escape_string($BonusID)."'";
				$rs = $this->query($sql,0);
			}
			return true;
		}

		function paidBonus($BonusIDs){
			if(!empty($BonusIDs)){
				$sql = "update h_bonus set Paid='1', Status='Paid' where BonusID in (".$BonusIDs.")";
				$this->query($sql,0);
			}
			return true;
		}


		function addBonus($arryDetails){ 
			global $Config;
			@extract($arryDetails);	 

			switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}


			$sql = "insert into h_bonus(Year, Month, EmpID, Amount, IssueDate, Approved, updatedDate, Status, Comment) values('".mysql_real_escape_string(strip_tags($Year))."', '".mysql_real_escape_string(strip_tags($Month))."','".mysql_real_escape_string(strip_tags($EmpID))."',  '".mysql_real_escape_string(strip_tags($Amount))."', '".mysql_real_escape_string(strip_tags($IssueDate))."',  '".mysql_real_escape_string(strip_tags($Approved))."', '".$Config['TodayDate']."', '".mysql_real_escape_string(strip_tags($Status))."', '".mysql_real_escape_string(strip_tags($Comment))."')";

			$this->query($sql, 0);
			$BonusID = $this->lastInsertId();

			return $BonusID;
		}



		function updateBonus($arryDetails){
			global $Config;
			@extract($arryDetails);	

			switch($Approved){
				case '1': $Status = 'Pending'; break;
				case '2': $Status = 'Cancelled'; break;
				default: $Status = 'Pending'; break;
			}

			if(!empty($BonusID)){
				$sql = "update h_bonus set Approved='".mysql_real_escape_string(strip_tags($Approved))."', Status='".mysql_real_escape_string(strip_tags($Status))."',IssueDate='".mysql_real_escape_string(strip_tags($IssueDate))."', Comment='".mysql_real_escape_string(strip_tags($Comment))."',  updatedDate = '".$Config['TodayDate']."'  where BonusID = '".mysql_real_escape_string($BonusID)."'"; 
				$rs = $this->query($sql,0);
			}
				
			return true;

		}

		function getTotalBonus($EmpID=0,$Year,$Month)
		{
			if(!empty($EmpID) && !empty($Year) && !empty($Month) ){
				$sql = "select a.Amount,a.BonusID  from h_bonus a inner join h_employee e on a.EmpID=e.EmpID where a.Approved=1 and a.EmpID = '".mysql_real_escape_string($EmpID)."' and a.Year = '".mysql_real_escape_string($Year)."' and a.Month = '".mysql_real_escape_string($Month)."' "; 
				return $this->query($sql, 1);
			}
		}

		function sendBonusEmail($BonusID)
		{
			global $Config;	
			$BonusID = mysql_real_escape_string($BonusID);
			if($BonusID>0){
				$arryRow = $this->getBonus($BonusID,''); 

				$Amount = (!empty($arryRow[0]['Amount']))?(number_format($arryRow[0]['Amount'])." ".$Config['Currency']):("0");
				$Comment = (!empty($arryRow[0]['Comment']))?(nl2br(stripslashes($arryRow[0]['Comment']))):(NOT_SPECIFIED);

				if($arryRow[0]['EmpID']!=$arryRow[0]['Supervisor']){
					$sql = "select Email from h_employee where EmpID='".$arryRow[0]['Supervisor']."'" ; 
					$arrySupervisor = $this->query($sql, 1);
				}
				if($arryRow[0]['Approved']==1){
					$arryRow[0]['Status'] = 'Approved';
				}

				$htmlPrefix = $Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."bonus.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[Amount]",$Amount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Bonus Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				#echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

				/***************************/
				$contents = file_get_contents($htmlPrefix."bonus_admin.htm");
				
				$CompanyUrl = $Config['Url'].$_SESSION['DisplayName'].'/admin/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
				$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
				$contents = str_replace("[Amount]",$Amount,$contents);
				$contents = str_replace("[Comment]",$Comment,$contents);
				$contents = str_replace("[Status]",$arryRow[0]['Status'],$contents);
				$contents = str_replace("[ApplyDate]",date("j M Y", strtotime($arryRow[0]['ApplyDate'])),$contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($Config['AdminEmail']);
				if(!empty($Config['DeptHeadEmail'])){
					$mail->AddCC($Config['DeptHeadEmail']);
				}
				if(!empty($arrySupervisor[0]['Email'])){
					$mail->AddCC($arrySupervisor[0]['Email']);
				}			
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Bonus Status";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				#echo $arrySupervisor[0]['Email'].$Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}




}

?>
