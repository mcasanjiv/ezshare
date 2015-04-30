<?
class employee extends dbClass
{
		//constructor
		function employee()
		{
			$this->dbClass();
		} 
		
		function  ListEmployee($arryDetails)
		{
			extract($arryDetails);

			$strAddQuery = '';
			$SearchKey   = strtolower(trim($key));
			$strAddQuery .= (!empty($id))?(" where e.EmpID='".mysql_real_escape_string($id)."'"):(" where e.locationID=".$_SESSION['locationID']);
			$strAddQuery .= (!empty($FromDate))?(" and e.JoiningDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and e.JoiningDate<='".$ToDate."'"):("");

			$strAddQuery .= (!empty($Division))?(" and e.Division in (".$Division.")"):("");

			if($SearchKey=='active' && ($sortby=='e.Status' || $sortby=='') ){
				$strAddQuery .= " and e.Status=1"; 
			}else if($SearchKey=='inactive' && ($sortby=='e.Status' || $sortby=='') ){
				$strAddQuery .= " and e.Status=0";
			}else if($sortby != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$sortby." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.EmpCode like '%".$SearchKey."%'  or e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpID like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%' or e.JobTitle like '%".$SearchKey."%'  ) " ):("");			
			}

			$strAddQuery .= (!empty($sortby))?(" order by ".$sortby." "):(" order by e.UserName ");
			$strAddQuery .= (!empty($asc))?($asc):(" Asc");

			$strSQLQuery = "select e.EmpID,e.UserID,e.EmpCode,e.Status,e.UserName,e.JobTitle, e.Email,e.JoiningDate,e.Image,d.Department,e2.UserName as SupervisorName from h_employee e left outer join  h_department d on e.Department=d.depID left outer join  h_employee e2 on e.Supervisor=e2.EmpID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	
		
		function  CountEmployee()
		{
			$strSQLQuery = "select count(EmpID) as TotalEmployee from h_employee where locationID=".$_SESSION['locationID'];
			return $this->query($strSQLQuery, 1);		
		}	

		function  GetNumEmployee($depID)
		{
			$strSQLQuery = "select count(EmpID) as TotalEmployee from h_employee where locationID=".$_SESSION['locationID'];
			$strSQLQuery .= (!empty($depID))?(" and Department='".$depID."'"):("");
			//echo $strSQLQuery;exit;
				
			return $this->query($strSQLQuery, 1);		
		}

		function  GetNumEmployeeByYear($depID,$Year)
		{
			#$strSQLQuery = "select EmpID,JoiningDate,ExitDate from h_employee where locationID=".$_SESSION['locationID'];
			$strSQLQuery = "select count(EmpID) as TotalEmployee from h_employee where locationID=".$_SESSION['locationID'];
			$strSQLQuery .= (!empty($depID))?(" and Department='".$depID."'"):("");
			if(!empty($Year)){
				$DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
				$strSQLQuery .= " and JoiningDate<='".$DateEnd."' and (ABS(ExitDate)=0 OR ExitDate>'".$DateEnd."')";
				//$strSQLQuery .= " and JoiningDate<='".$DateEnd."' ";
			}
			//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}


		function  GetEmpByYear($depID,$Year)
		{
			#$strSQLQuery = "select EmpID,JoiningDate,ExitDate from h_employee where locationID=".$_SESSION['locationID'];
			$strSQLQuery = "select count(EmpID) as TotalEmployee from h_employee where locationID=".$_SESSION['locationID'];
			$strSQLQuery .= (!empty($depID))?(" and Department='".$depID."'"):("");
			if(!empty($Year)){
				$DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
				//$strSQLQuery .= " and JoiningDate<='".$DateEnd."' and ( ABS(ExitDate)=0 )";
				$strSQLQuery .= " and JoiningDate<='".$DateEnd."' and (ABS(ExitDate)=0 OR ExitDate>'".$DateEnd."')";
				//$strSQLQuery .= " and JoiningDate<='".$DateEnd."' ";
			}
			//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}



		function GetEmployeeUser($UserID,$Status){
			$strSQLQuery = "select * from h_employee where UserID='".$UserID."' ";
			$strSQLQuery .= ($Status>0)?(" and Status='".$Status."' and ABS(ExitDate)=0"):("");
		
			return $this->query($strSQLQuery, 1);
		}

		function  GetResignation($depID,$Year)
		{
			$strSQLQuery = "select count(EmpID) as TotalEmployee from h_employee where locationID=".$_SESSION['locationID'];
			$strSQLQuery .= (!empty($depID))?(" and Department='".$depID."'"):("");
			if(!empty($Year)){
				$DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
				$strSQLQuery .= " and ExitDate<='".$DateEnd."' and ExitDate>='".$DateFrom."' and ABS(ExitDate)>0";
			}
			//echo $strSQLQuery;exit;
			return $this->query($strSQLQuery, 1);		
		}

		function GetEmployeeList($arryDetails)
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

			$strSQLQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.EmpCode like '%".$SearchKey."%'  or e.JobTitle like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%') " ):("");			
			$strSQLQuery .= " Order by e.UserName Asc";
			
			return $this->query($strSQLQuery, 1);
		}

		function  GetEmployeeImage($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where EmpID='".$id."'"):(" where 1 ");

			$strSQLQuery = "select e.Image  from h_employee e ".$strAddQuery;

			return $this->query($strSQLQuery, 1);
		}

	

		function  GetEmployee($EmpID,$Status)
		{
			$strSQLQuery = "select e.*, s.shiftName, s.WorkingHourStart, s.WorkingHourEnd, s.FlexTime, d.Department as DepartmentName, dv.Department as DivisionName,ct.catName from h_employee e left outer join department dv on e.Division=dv.depID left outer join h_department d on e.Department=d.depID left outer join  h_component_cat ct on e.catID=ct.catID left outer join  h_shift s on e.shiftID=s.shiftID";

			$strSQLQuery .= (!empty($EmpID))?(" where e.EmpID='".mysql_real_escape_string($EmpID)."'"):(" and e.locationID=".$_SESSION['locationID']);
			$strSQLQuery .= ($Status>0)?(" and e.Status='".$Status."'"):("");

			return $this->query($strSQLQuery, 1);
		}
                
                 function GetCommissionType($EmpID)
		{
			
			$strSQLQuery = "select CommissionType from h_commission where EmpID='".$EmpID."'";
			return $this->query($strSQLQuery, 1);
		}
		
		function GetEmployeeBrief($EmpID)
		{
			$strAddQuery .= (!empty($EmpID))?(" and e.EmpID='".mysql_real_escape_string($EmpID)."'"):(" and locationID='".mysql_real_escape_string($_SESSION['locationID'])."'");
			$strSQLQuery = "select e.EmpID, e.EmpCode, e.UserName, e.Email, e.JobTitle, e.JobType, e.catID, e.Division, e.JoiningDate, e.LeaveAccrual, e.ProbationPeriod, e.EligibilityPeriod ,e.ProbationUnit, e.EligibilityUnit ,d.depID, d.Department,c.CommOn from h_employee e left outer join h_commission c on e.EmpID=c.EmpID  left outer join  h_department d on e.Department=d.depID where 1 ".$strAddQuery." order by d.depID asc,e.UserName asc";
			return $this->query($strSQLQuery, 1);
		}
				
		function  AllEmployees($Status)
		{
			$strSQLQuery = "select EmpID,UserName,Email from h_employee where 1 ";

			$strSQLQuery .= ($Status>0)?(" and Status='".$Status."'"):("");

			$strSQLQuery .= " order by UserName,Email Asc";

			return $this->query($strSQLQuery, 1);
		}


		function  GetEmployeeDetail($id=0)
		{
			$strAddQuery = '';
			$strAddQuery .= (!empty($id))?(" where e.EmpID='".mysql_real_escape_string($id)."'"):(" where 1 ");

			$strAddQuery .= " order by e.JoiningDate Desc ";

			$strSQLQuery = "select e.*,c.name as Country , if(e.city_id>0,ct.name,e.OtherCity) as City, if(e.state_id>0,s.name,e.OtherState) as State from h_employee e left outer join country c on e.country_id=c.country_id left outer join state s on e.state_id=s.state_id left outer join city ct on e.city_id=ct.city_id  ".$strAddQuery;
			return $this->query($strSQLQuery, 1);
		}

		
		function AddEmployee($arryDetails)
		{  
			
			global $Config;
			extract($arryDetails);
			if($main_state_id>0) $OtherState = '';
			if($main_city_id>0) $OtherCity = '';
			if(empty($Status)) $Status=1;
			$UserName = trim($FirstName.' '.$LastName);
			if(empty($LandlineNumber)){
				$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
			}
	
			$ipaddress = $_SERVER["REMOTE_ADDR"];
			if(sizeof($Skill)>0){
				$SkillVal = implode(", ", $Skill); 
			}
			
			if($Department>0){
			$sql = "select Division from h_department where depID='".$Department."'";
			$arryRow = $this->query($sql, 1);
			$Division = $arryRow[0]["Division"];
			}else if(empty($Division)){
				$Division=1;
			}
			//echo $Division; exit;



			$strSQLQuery = "insert into h_employee (locationID, EmpCode, catID, UserName,Email,Password,FirstName,LastName,Gender ,date_of_birth,Address, city_id, state_id, ZipCode, country_id,Mobile, LandlineNumber, PersonalEmail,  Status, JoiningDate, OtherGraduation, OtherPostGraduation, OtherState, OtherCity, ExperienceYear, ExperienceMonth, Skill, Doctorate, OtherDoctorate, Graduation, PostGraduation, Certification, Resume,TempPass,ipaddress,Nationality, MaritalStatus, Division, Department, JobTitle, JobType, Salary, SalaryFrequency, Role, UpdatedDate, BloodGroup, SSN, UnderGraduate, ProfessionalCourse, OtherUnderGraduate, OtherProfessionalCourse, LastWorking ) values(  '".$_SESSION['locationID']."', '".addslashes($EmpCode)."', '".addslashes($catID)."', '".addslashes($UserName)."', '".addslashes($Email)."', '".md5($Password)."','".addslashes($FirstName)."', '".addslashes($LastName)."','".addslashes($Gender)."', '".$date_of_birth."', '".addslashes(strip_tags($Address))."',  '".$main_city_id."', '".$main_state_id."','".addslashes($ZipCode)."', '".$country_id."', '".addslashes($Mobile)."','".addslashes($LandlineNumber)."', '".addslashes($PersonalEmail)."', '".$Status."', '".$JoiningDate."', '".addslashes($OtherGraduation)."', '".addslashes($OtherPostGraduation)."',  '".addslashes($OtherState)."', '".addslashes($OtherCity)."',  '".addslashes($ExperienceYear)."', '".addslashes($ExperienceMonth)."',  '".addslashes($SkillVal)."', '".addslashes($Doctorate)."', '".addslashes($OtherDoctorate)."', '".$Graduation."', '".addslashes($PostGraduation)."', '".addslashes(strip_tags($Certification))."',  '".addslashes($Resume)."' ,  '".$Password555."', '".$ipaddress."','".addslashes($Nationality)."', '".addslashes($MaritalStatus)."', '".addslashes($Division)."', '".addslashes($Department)."', '".addslashes($JobTitle)."', '".addslashes($JobType)."', '".addslashes($Salary)."', '".addslashes($SalaryFrequency)."', '".addslashes($Role)."', '".$Config['TodayDate']."', '".addslashes($BloodGroup)."', '".addslashes($SSN)."', '".addslashes($UnderGraduate)."', '".addslashes($ProfessionalCourse)."', '".addslashes($OtherUnderGraduate)."', '".addslashes($OtherProfessionalCourse)."', '".addslashes($LastWorking)."')";


			$this->query($strSQLQuery, 0);

			$EmpID = $this->lastInsertId();

			if(empty($EmpCode)){
				$EmpCode = 'EMP000'.$EmpID;
				$strSQL = "update h_employee set EmpCode='".$EmpCode."' where EmpID='".$EmpID."'"; 
				$this->query($strSQL, 0);
			}



			/***********************/
			$objConfig=new admin();
			$Config['DbName'] = $Config['DbMain'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			
			$objConfig->addUserEmail($_SESSION['CmpID'],$EmpID,$Email);

			$Config['DbName'] = $_SESSION['CmpDatabase'];
			$objConfig->dbName = $Config['DbName'];
			$objConfig->connect();
			/***********************/


			$htmlPrefix = $Config['EmailTemplateFolder'];
			$contents = file_get_contents($htmlPrefix."logindetails.htm");
			$subject  = "Account Details";
			
			$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);

			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);	
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
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

			
			//Send Acknowledgment Email to admin
			$contents = file_get_contents($htmlPrefix."admin_signup.htm");

			$contents = str_replace("[URL]",$Config['Url'],$contents);
			$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
			$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
			$contents = str_replace("[FULLNAME]",$UserName, $contents);
			$contents = str_replace("[EMAIL]",$Email,$contents);
			$contents = str_replace("[PASSWORD]",$Password,$contents);
			$contents = str_replace("[EmpCode]",$EmpCode,$contents);		
			$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);

			$mail = new MyMailer();
			$mail->IsMail();			
			$mail->AddAddress($Config['AdminEmail']);
			$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
			$mail->Subject = $Config['SiteName']." - Employee - ".$subject;
			$mail->IsHTML(true);
			//echo $Config['AdminEmail'].$contents; exit;
			$mail->Body = $contents;    
			if($Config['Online'] == '1'){
				$mail->Send();	
			}
			#echo $mail->Subject.','.$Email.','.$Config['AdminEmail'].$contents; exit;

			return $EmpID;

		}


		function UpdateEmployee($arryDetails){ 
			global $Config;
			extract($arryDetails);

			if(!empty($EmpID)){
				$UserName = trim($FirstName.' '.$LastName);
		
				
				$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);
				
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';
				if(empty($Status)) $Status=1;

				if(empty($EmpCode)){
					$EmpCode = 'EMP000'.$EmpID;
				}

				$strSQLQuery = "update h_employee set EmpCode='".addslashes($EmpCode)."', UserName='".addslashes($UserName)."', Email='".addslashes($Email)."',  FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', Gender='".addslashes($Gender)."',date_of_birth='".$date_of_birth."', 
				Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."', PersonalEmail='".addslashes($PersonalEmail)."', Status='".$Status."', OtherGraduation='".addslashes($OtherGraduation)."', OtherPostGraduation='".addslashes($OtherPostGraduation)."' 
				,OtherState='".addslashes($OtherState)."',OtherCity='".addslashes($OtherCity)."'			 
				,ExperienceYear='".addslashes($ExperienceYear)."'
				,ExperienceMonth='".addslashes($ExperienceMonth)."'
				,Skill='".addslashes($Skill)."'
				,Doctorate='".addslashes($Doctorate)."'
				,OtherDoctorate='".addslashes($OtherDoctorate)."'
				,Graduation='".$Graduation."'
				,PostGraduation='".addslashes($PostGraduation)."'
				,Certification='".addslashes($Certification)."'
				,UpdatedDate = '".$Config['TodayDate']."'
				,Nationality='".addslashes($Nationality)."'
				,MaritalStatus='".addslashes($MaritalStatus)."'
				,Division='".addslashes($Division)."'
				,Department='".addslashes($Department)."'
				,JobTitle='".addslashes($JobTitle)."'
				,JobType='".addslashes($JobType)."'
				,Salary='".addslashes($Salary)."'
				,SalaryFrequency='".addslashes($SalaryFrequency)."'
				,Role='".addslashes($Role)."'
				,BloodGroup='".addslashes($BloodGroup)."'
				,UnderGraduate='".addslashes($UnderGraduate)."'
				,ProfessionalCourse='".addslashes($ProfessionalCourse)."'
				,OtherUnderGraduate='".addslashes($OtherUnderGraduate)."'
				,OtherProfessionalCourse='".addslashes($OtherProfessionalCourse)."'
				where EmpID='".$EmpID."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;

		}

		function UpdateDepartmentHead($EmpID,$depID,$DeptHead){  
			/*
			$sql = "select EmpID,depID from department where depID=".$depID;
			$arryRow = $this->query($sql, 1);
			if(!empty($arryRow[0]["EmpID"])){
				$strSQLQuery = "update department set EmpID='0' where depID=".$arryRow[0]["depID"]; 
				$this->query($strSQLQuery, 0);
			}	*/		
			
			$strSQLQuery = "update department set EmpID='0' where EmpID='".$EmpID."'"; 
			$this->query($strSQLQuery, 0);	


			if($DeptHead==1){
				$strSQLQuery = "update department set EmpID='".$EmpID."' where depID='".$depID."'"; 
				$this->query($strSQLQuery, 0);
			}else{
				$strSQLQuery = "update department set EmpID='0' where depID='".$depID."'"; 
				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

		function UpdateBasicInfo($arryDetails){   
			global $Config;
			extract($arryDetails);

			if(!empty($EmpID)){
				$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);			
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';

				if(sizeof($Skill)>0){
					$SkillVal = implode(", ", $Skill); 
				}

				$strSQLQuery = "update h_employee set 
				date_of_birth='".$date_of_birth."'
				, Nationality='".addslashes($Nationality)."' , MaritalStatus='".addslashes($MaritalStatus)."',UpdatedDate = '".$Config['TodayDate']."', BloodGroup='".addslashes($BloodGroup)."', Address='".addslashes(strip_tags($Address))."',  city_id='".$main_city_id."', state_id='".$main_state_id."', ZipCode='".addslashes($ZipCode)."', country_id='".$country_id."', Mobile='".addslashes($Mobile)."', LandlineNumber='".addslashes($LandlineNumber)."', PersonalEmail='".addslashes($PersonalEmail)."', OtherState='".addslashes($OtherState)."' ,OtherCity='".addslashes($OtherCity)."',  ImmigrationType='".addslashes($ImmigrationType)."', ImmigrationNo='".addslashes($ImmigrationNo)."', ImmigrationExp='".addslashes($ImmigrationExp)."', SSN='".addslashes($SSN)."', Skill='".addslashes($SkillVal)."'				
				where EmpID='".$EmpID."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}



		function UpdatePersonal($arryDetails){   
			global $Config;
			extract($arryDetails);
			if(!empty($EmpID)){
				$UserName = trim($FirstName.' '.$LastName);

				if(empty($EmpCode)){
					$EmpCode = 'EMP000'.$EmpID;
				}

				
				if(!empty($JobTitle)){
					$AddSqlQuery .= ", JobTitle='".addslashes($JobTitle)."'";
				
				}

				$strSQLQuery = "update h_employee set EmpCode='".addslashes($EmpCode)."', UserName='".addslashes($UserName)."', FirstName='".addslashes($FirstName)."', LastName='".addslashes($LastName)."', Gender='".addslashes($Gender)."',date_of_birth='".$date_of_birth."',Nationality='".addslashes($Nationality)."' ,MaritalStatus='".addslashes($MaritalStatus)."',UpdatedDate = '".$Config['TodayDate']."',BloodGroup='".addslashes($BloodGroup)."',SSN='".addslashes($SSN)."' ".$AddSqlQuery." where EmpID='".$EmpID."'"; 
				$this->query($strSQLQuery, 0);


			}
			return 1;
		}


		function UpdateMyPersonal($arryDetails){   
			global $Config;
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set date_of_birth='".mysql_real_escape_string(strip_tags($date_of_birth))."'
				,Nationality='".mysql_real_escape_string(strip_tags($Nationality))."' ,MaritalStatus='".mysql_real_escape_string(strip_tags($MaritalStatus))."',UpdatedDate = '".mysql_real_escape_string(strip_tags($Config['TodayDate']))."',BloodGroup='".mysql_real_escape_string(strip_tags($BloodGroup))."',SSN='".mysql_real_escape_string(strip_tags($SSN))."'	where EmpID='".mysql_real_escape_string($EmpID)."'";
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}

		function UpdateContact($arryDetails){   
			extract($arryDetails);		
			if(!empty($EmpID)){
				$LandlineNumber = trim($Landline1.' '.$Landline2.' '.$Landline3);			
				if($main_city_id>0) $OtherCity = '';
				if($main_state_id>0) $OtherState = '';

				$strSQLQuery = "update h_employee set Address='".mysql_real_escape_string(strip_tags($Address))."',  city_id='".mysql_real_escape_string(strip_tags($main_city_id))."', state_id='".mysql_real_escape_string(strip_tags($main_state_id))."', ZipCode='".mysql_real_escape_string(strip_tags($ZipCode))."', country_id='".mysql_real_escape_string(strip_tags($country_id))."', Mobile='".mysql_real_escape_string(strip_tags($Mobile))."', LandlineNumber='".mysql_real_escape_string(strip_tags($LandlineNumber))."', PersonalEmail='".mysql_real_escape_string(strip_tags($PersonalEmail))."', OtherState='".mysql_real_escape_string(strip_tags($OtherState))."' ,OtherCity='".mysql_real_escape_string(strip_tags($OtherCity))."' 
				where EmpID='".mysql_real_escape_string($EmpID)."'";
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}

		
		function UpdateEducation($arryDetails){   
			global $Config;
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set  OtherGraduation='".mysql_real_escape_string(strip_tags($OtherGraduation))."', OtherPostGraduation='".mysql_real_escape_string(strip_tags($OtherPostGraduation))."' 
				,Doctorate='".mysql_real_escape_string(strip_tags($Doctorate))."'
				,OtherDoctorate='".mysql_real_escape_string(strip_tags($OtherDoctorate))."'
				,Graduation='".mysql_real_escape_string(strip_tags($Graduation))."'
				,PostGraduation='".mysql_real_escape_string(strip_tags($PostGraduation))."'
				,Certification='".mysql_real_escape_string(strip_tags($Certification))."'
				,UpdatedDate = '".mysql_real_escape_string(strip_tags($Config['TodayDate']))."'			
				,UnderGraduate='".mysql_real_escape_string(strip_tags($UnderGraduate))."'
				,ProfessionalCourse='".mysql_real_escape_string(strip_tags($ProfessionalCourse))."'
				,OtherUnderGraduate='".mysql_real_escape_string(strip_tags($OtherUnderGraduate))."'
				,OtherProfessionalCourse='".mysql_real_escape_string(strip_tags($OtherProfessionalCourse))."'
				where EmpID='".mysql_real_escape_string($EmpID)."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}

		function UpdateJobDetail($arryDetails){   
			global $Config;
			extract($arryDetails);
			if(!empty($EmpID)){
				if(sizeof($Skill)>0){
					$SkillVal = implode(", ", $Skill); 
				}

			if($Department>0){
			$sql = "select Division from h_department where depID='".$Department."'";
			$arryRow = $this->query($sql, 1);
			$Division = $arryRow[0]["Division"];
			}else{
				$Division=1;
			}
			



				$strSQLQuery = "update h_employee set catID='".mysql_real_escape_string($catID)."'		,ExperienceYear='".mysql_real_escape_string($ExperienceYear)."',ExperienceMonth='".mysql_real_escape_string($ExperienceMonth)."'	,JoiningDate = '".$JoiningDate."', UpdatedDate = '".$Config['TodayDate']."' , Division='".mysql_real_escape_string($Division)."'
				,Department='".mysql_real_escape_string($Department)."',JobTitle='".mysql_real_escape_string($JobTitle)."'
				,JobType='".mysql_real_escape_string($JobType)."'	,Skill='".mysql_real_escape_string($SkillVal)."', Salary='".mysql_real_escape_string($Salary)."'
				,SalaryFrequency='".mysql_real_escape_string($SalaryFrequency)."',shiftID='".mysql_real_escape_string($shiftID)."' ,ProbationPeriod='".mysql_real_escape_string($ProbationPeriod)."', EligibilityPeriod='".mysql_real_escape_string($EligibilityPeriod)."' ,LeaveAccrual='".mysql_real_escape_string($LeaveAccrual)."',LeaveExempt='".mysql_real_escape_string($LeaveExempt)."',ProbationUnit='".mysql_real_escape_string($ProbationUnit)."', EligibilityUnit='".mysql_real_escape_string($EligibilityUnit)."'
				where EmpID='".mysql_real_escape_string($EmpID)."'"; 
				$this->query($strSQLQuery, 0);

				/*************************/ 
				//$this->UpdateDeptHead($Department,$EmpID,$DeptHead);
				/*************************/
			}

			return 1;
		}


		function UpdateJobEmp($arryDetails){   
			global $Config;

			extract($arryDetails);
			if(!empty($EmpID)){
				if(sizeof($Skill)>0){
					$SkillVal = implode(", ", $Skill); 
				}

				$strSQLQuery = "update h_employee set Skill='".mysql_real_escape_string(strip_tags($SkillVal))."' where EmpID='".$EmpID."'"; 
				$this->query($strSQLQuery, 0);

		
			}

			return 1;
		}

		function  GerPrevTier($Range){
			if(!empty($Range)){
				$sql = "select t.RangeFrom as PrevRange from h_tier t where t.RangeFrom<".$Range." and Status=1 order by RangeFrom desc limit 0,1";
				$arryRow = $this->query($sql, 1);
				return $arryRow[0]['PrevRange'];
			}
		}
		function  GerNextTier($Range){
			if(!empty($Range)){
				$sql = "select t.RangeFrom as NextRange from h_tier t where t.RangeFrom>".$Range." and Status=1 order by RangeFrom asc limit 0,1";
				$arryRow = $this->query($sql, 1);
				return $arryRow[0]['NextRange'];
			}
		}


		function  GetSalesCommission($EmpID){
			if(!empty($EmpID)){
				$strSQLQuery = "select c.*,t.Percentage,t.RangeFrom,t.RangeTo,s.SalesTarget,s.SpiffAmount from h_commission c left outer join h_tier t on c.tierID=t.tierID left outer join h_spiff s on c.spiffID=s.spiffID where c.EmpID= '".mysql_real_escape_string($EmpID)."' order by c.comID Asc";
				return $this->query($strSQLQuery, 1);
			}
		}

		function UpdateSalesCommission($arryDetails){   
			global $Config;
			extract($arryDetails);	
			/******************/
			$arrytierID = explode("|",$tierID);
			$tierID = $arrytierID[0];

			$arryspiffID = explode("|",$spiffID);
			$spiffID = $arryspiffID[0];
			/******************/

			$sql = "select RangeFrom,RangeTo from h_tier where tierID='".$tierID."' ";
			$arryRow = $this->query($sql, 1);
			$RangeFrom = $arryRow[0]["RangeFrom"];
			$RangeTo = $arryRow[0]["RangeTo"];

			/*$PrevRange = $this->GerPrevTier($RangeFrom);
			$NextRange = $this->GerNextTier($RangeFrom);
			if(empty($PrevRange)) $PrevRange=0;

			$TargetFrom = $PrevRange+1;
			$TargetTo = $RangeFrom;

			if($RangeFrom==$TargetTo && empty($NextRange)) $TargetTo=0;
			
			#echo $RangeFrom.' = '.$TargetFrom.' - '.$TargetTo;exit;
			*/
			
			$TargetFrom = $RangeFrom;
			$TargetTo = $RangeTo;

			/******************/


			if(!empty($EmpID)){
				$sql = "select EmpID from h_commission where EmpID='".$EmpID."' ";
				$arryRow = $this->query($sql, 1);
	
				if($arryRow[0]['EmpID']>0){
					$strSQLQuery = "update h_commission set CommType='".mysql_real_escape_string(strip_tags($CommType))."', tierID='".mysql_real_escape_string(strip_tags($tierID))."', spiffID='".mysql_real_escape_string(strip_tags($spiffID))."', SalesPersonType='".mysql_real_escape_string(strip_tags($SalesPersonType))."', Accelerator='".mysql_real_escape_string(strip_tags($Accelerator))."', AcceleratorPer='".mysql_real_escape_string(strip_tags($AcceleratorPer))."', TargetFrom='".mysql_real_escape_string(strip_tags($TargetFrom))."', TargetTo='".mysql_real_escape_string(strip_tags($TargetTo))."', CommPercentage='".mysql_real_escape_string(strip_tags($CommPercentage))."', SpiffTarget='".mysql_real_escape_string(strip_tags($SpiffTarget))."', SpiffEmp='".mysql_real_escape_string(strip_tags($SpiffEmp))."', CommOn='".mysql_real_escape_string(strip_tags($CommOn))."',CommissionType='".mysql_real_escape_string($Commission_type)."' where EmpID='".mysql_real_escape_string($EmpID)."'" ;
$this->query($strSQLQuery, 0);	
				}else if(!empty($CommType)){
					$strSQLQuery = "insert into h_commission (EmpID, CommType, tierID, spiffID, SalesPersonType, Accelerator, AcceleratorPer, TargetFrom, TargetTo, CommPercentage, SpiffTarget, SpiffEmp, CommOn,CommissionType ) values('".mysql_real_escape_string($EmpID)."', '".mysql_real_escape_string($CommType)."', '".mysql_real_escape_string(strip_tags($tierID))."', '".mysql_real_escape_string(strip_tags($spiffID))."','".mysql_real_escape_string(strip_tags($SalesPersonType))."', '".mysql_real_escape_string(strip_tags($Accelerator))."', '".mysql_real_escape_string(strip_tags($AcceleratorPer))."', '".mysql_real_escape_string($TargetFrom)."', '".mysql_real_escape_string($TargetTo)."', '".mysql_real_escape_string($CommPercentage)."', '".mysql_real_escape_string($SpiffTarget)."', '".mysql_real_escape_string($SpiffEmp)."', '".mysql_real_escape_string($CommOn)."','".mysql_real_escape_string($Commission_type)."')";
$this->query($strSQLQuery, 0);	
				}
				

			}

			return 1;

		}



		function UpdateDeptHead($Department,$EmpID,$DeptHead){   

			if(!empty($Department)){
				$strSQLQuery = "select EmpID from h_employee where Department='".$Department."' and DeptHead=1 and locationID=".$_SESSION['locationID'];
				$arryRow = $this->query($strSQLQuery, 1);
				foreach($arryRow as $key=>$values){
					if(!empty($values['EmpID'])) {
						$strSQL = "update h_employee set DeptHead='0' where EmpID='".$values['EmpID']."'"; 
						$this->query($strSQL, 0);
					}
				}
				if($EmpID>0){
				$strSQL = "update h_employee set DeptHead='".$DeptHead."' where EmpID='".$EmpID."'"; 
				$this->query($strSQL, 0);
				}	
			}

			return 1;
		}



		function UpdateOtherHead($Department,$EmpID1,$EmpID2){   
			if(!empty($Department)){
				$strSQLQuery = "select EmpID from h_employee where Department='".$Department."' and OtherHead=1 and locationID=".$_SESSION['locationID'];
				$arryRow = $this->query($strSQLQuery, 1);
				foreach($arryRow as $key=>$values){
					if(!empty($values['EmpID'])) {
						$strSQL = "update h_employee set OtherHead='0' where EmpID='".$values['EmpID']."'"; 
						$this->query($strSQL, 0);
					}
				}

				$strSQL = "update h_employee set OtherHead='1' where EmpID='".$EmpID1."'"; 
				$this->query($strSQL, 0);
				$strSQL2 = "update h_employee set OtherHead='1' where EmpID='".$EmpID2."'"; 
				$this->query($strSQL2, 0);
			}

			return 1;
		}





		function UpdateBankDetail($arryDetails){   
			global $Config;
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set BankName='".addslashes($BankName)."'		,AccountName='".addslashes($AccountName)."'	, AccountNumber='".addslashes($AccountNumber)."', IFSCCode='".addslashes($IFSCCode)."',UpdatedDate = '".$Config['TodayDate']."'
				where EmpID='".$EmpID."'"; 

				$this->query($strSQLQuery, 0);
			}

			return 1;
		}



		function UpdateEmpExit($arryDetails){   
			global $Config;
			extract($arryDetails);
			if(!empty($EmpID)){
				if(!empty($ExitDate) && $FullFinal=='Yes'){
					$Addsql = ', Status=0 ';

					$sql = "select FullFinal,ExitDate from h_employee where EmpID='".mysql_real_escape_string($EmpID)."'";
					$arryOldData = $this->query($sql, 1);
				}

				$strSQLQuery = "update h_employee set ExitDate='".$ExitDate."', ExitType='".addslashes($ExitType)."', ExitReason='".addslashes($ExitReason)."', LastWorking='".$LastWorking."', FullFinal='".$FullFinal."', ExitDesc='".addslashes(strip_tags($ExitDesc))."', ExitClearence='".addslashes($ExitClearence)."', UpdatedDate = '".$Config['TodayDate']."' ".$Addsql." where EmpID='".$EmpID."'"; 
				$this->query($strSQLQuery, 0);



				/**************************/
				if(!empty($ExitDate) && $FullFinal!=$arryOldData[0]['FullFinal']  && $FullFinal=='Yes'){
					
						$arryRow = $this->GetEmployee($EmpID,'');

						$JoiningDate = ($arryRow[0]['JoiningDate']>0)?(date($Config['DateFormat'], strtotime($arryRow[0]['JoiningDate']))):(NOT_SPECIFIED);
						$ExitType = (!empty($arryRow[0]['ExitType']))?(stripslashes($arryRow[0]['ExitType'])):(NOT_SPECIFIED);
						$ExitReason = (!empty($arryRow[0]['ExitReason']))?(stripslashes($arryRow[0]['ExitReason'])):(NOT_SPECIFIED);
						$ExitDate = ($arryRow[0]['ExitDate']>0)?(date($Config['DateFormat'], strtotime($arryRow[0]['ExitDate']))):(NOT_SPECIFIED);
						$LastWorking = ($arryRow[0]['LastWorking']>0)?(date($Config['DateFormat'], strtotime($arryRow[0]['LastWorking']))):(NOT_SPECIFIED);
						$FullFinal = (!empty($arryRow[0]['FullFinal']))?(stripslashes($arryRow[0]['FullFinal'])):(NOT_SPECIFIED);
						$ExitClearence = ($arryRow[0]['ExitClearence']=='1')?('Yes'):('No');

						$htmlPrefix = $Config['EmailTemplateFolder'];		
						$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
									
						$contents = file_get_contents($htmlPrefix."emp_exit.htm");
						
						$contents = str_replace("[URL]",$Config['Url'],$contents);
						$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);

						$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
						$contents = str_replace("[Email]",$arryRow[0]['Email'],$contents);
						$contents = str_replace("[Department]",$arryRow[0]['DepartmentName'],$contents);
						$contents = str_replace("[JobTitle]",$arryRow[0]['JobTitle'],$contents);
						$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
						$contents = str_replace("[JoiningDate]",$JoiningDate,$contents);	
						$contents = str_replace("[ExitType]",$ExitType,$contents);	
						$contents = str_replace("[ExitReason]",$ExitReason,$contents);	
						$contents = str_replace("[ExitDate]",$ExitDate,$contents);	
						$contents = str_replace("[LastWorking]",$LastWorking,$contents);	
						$contents = str_replace("[FullFinal]",$FullFinal,$contents);	
						$contents = str_replace("[ExitClearence]",$ExitClearence,$contents);	

						$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
						$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
								
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($Config['AdminEmail']);
						if(!empty($Config['DeptHeadEmail'])){
							$mail->AddCC($Config['DeptHeadEmail']);
						}
						$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
						$mail->Subject = $Config['SiteName']." - Employee Exit";
						$mail->IsHTML(true);
						$mail->Body = $contents;  

						#echo $Config['DeptHeadEmail'].$Config['AdminEmail'].$contents; exit;

						if($Config['Online'] == '1'){
							$mail->Send();	
						}

				}
				/**************************/

			}

			return 1;
		}

		function UpdateAccount($arryDetails){  
			global $Config; 
			extract($arryDetails);

			if(!empty($Email) && !empty($EmpID)){
				if($Status=='') $Status=1;

				if(!empty($Password)) $PasswordSql = ", Password='".md5($Password)."'" ;

				$strSQLQuery = "update h_employee set Email='".addslashes($Email)."', Status='".$Status."' ".$PasswordSql." where EmpID='".mysql_real_escape_string($EmpID)."'"; 

				$this->query($strSQLQuery, 0);



				/***********************/
				$objConfig=new admin();
				$Config['DbName'] = $Config['DbMain'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
			
				$objConfig->UpdateUserEmail($_SESSION['CmpID'],$EmpID,$Email);

				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
				/***********************/

			}

			return 1;
		}


		function UpdateRoleModules($arryDetails)
		{
			extract($arryDetails);

			if(!empty($EmpID)){
					$strSQLQuery = "update h_employee set Role='".$Role."' where EmpID='".$EmpID."'"; 
					$this->query($strSQLQuery, 0);
					
					$sql = "delete from h_permission where EmpID ='".$EmpID."'";
					$rs = $this->query($sql,0);
					
					if($Role=="Admin"){

						if($Line>0){
							for($i=1;$i<=$Line; $i++){
								$ViewFlag = 0; $ModifyFlag = 0; $ModuleID=0;
								$ViewLabel = $arryDetails["ViewLabel".$i];
								$ModifyLabel = $arryDetails["ModifyLabel".$i];
								
								if($ModifyLabel>0){
									$ModuleID = $ModifyLabel;
									$ModifyFlag = 1;
								}
								if($ViewLabel>0){
									$ModuleID = $ViewLabel;
									$ViewFlag = 1;
								}
								
								if($ModuleID>0){
									$sql = "insert ignore into h_permission(EmpID,ModuleID,ViewLabel,ModifyLabel) values('".$EmpID."', '".$ModuleID."', '".$ViewFlag."', '".$ModifyFlag."')";
									$rs = $this->query($sql,0);
								}

							}
						}
					}
			
			
			
			
			
			}


			return 1;

		}


		function UpdateEmpRole($arryDetails){   
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set Role='".mysql_real_escape_string(strip_tags($Role))."', vUserInfo='".mysql_real_escape_string(strip_tags($vUserInfo))."', vAllRecord='".mysql_real_escape_string(strip_tags($vAllRecord))."' where EmpID='".mysql_real_escape_string($EmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}


		function UpdateSupervisor($arryDetails){   
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set Supervisor='".mysql_real_escape_string(strip_tags($Supervisor))."', ReportingMethod='".mysql_real_escape_string(strip_tags($ReportingMethod))."' where EmpID='".mysql_real_escape_string($EmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}
                
                function UpdateSalesPerson($arryDetails){
                    //print_r($arryDetails);die;
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set SalesID='".mysql_real_escape_string(strip_tags($arryDetails['SalesPersonID']))."', ReportingMethod='".mysql_real_escape_string(strip_tags($ReportingMethod))."' where EmpID='".mysql_real_escape_string($EmpID)."'"; 
                                //echo $strSQLQuery;die;
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}

		function UpdateImmigration($arryDetails){   
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set ImmigrationType='".mysql_real_escape_string(strip_tags($ImmigrationType))."', ImmigrationNo='".mysql_real_escape_string(strip_tags($ImmigrationNo))."', ImmigrationExp='".mysql_real_escape_string(strip_tags($ImmigrationExp))."' where EmpID='".mysql_real_escape_string($EmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;
		}
		
		function UpdateEmployeeResume($arryDetails){   
			
			extract($arryDetails);
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set UpdatedDate = '".$Config['TodayDate']."'	where EmpID='".mysql_real_escape_string($EmpID)."'"; 
				$this->query($strSQLQuery, 0);
			}
			return 1;

		}


		function ChangePassword($EmpID,$Password)
		{
			global $Config;	
		
			if(!empty($EmpID) && !empty($Password)){
				$strSQLQuery = "update h_employee set Password='".mysql_real_escape_string(md5($Password))."' where EmpID='".mysql_real_escape_string($EmpID)."'";
				$this->query($strSQLQuery, 0);

				$sql = "select EmpID,UserName,Email from h_employee where EmpID='".mysql_real_escape_string($EmpID)."'";
				$arryRow = $this->query($sql, 1);

				$htmlPrefix = 'hrms/'.$Config['EmailTemplateFolder'];

				$contents = file_get_contents($htmlPrefix."password.htm");
				
				$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';
				$contents = str_replace("[URL]",$Config['Url'],$contents);
				$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
				$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
				$contents = str_replace("[EMAIL]",$arryRow[0]['Email'],$contents);
				$contents = str_replace("[PASSWORD]",$Password,$contents);	
				$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
				$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($arryRow[0]['Email']);
				$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
				$mail->Subject = $Config['SiteName']." - Employee - Your login details have been reset";
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//echo $arryRow[0]['Email'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
					$mail->Send();	
				}

			}

			return 1;
		}		
		
		function IsActivatedEmployee($EmpID,$verification_code)
		{
			$sql = "select * from h_employee where EmpID='".mysql_real_escape_string($EmpID)."' and verification_code='".$verification_code."'";

			$arryRow = $this->query($sql, 1);

			if ($arryRow[0]['EmpID']>0) {
				if ($arryRow[0]['Status']>0) {
					return 1;
				}else{
					return 2;
				}
			} else {
				return 0;
			}
		}

		

		
		function ForgotPassword($Email){
			
			global $Config;
			if(!empty($Email)){
				$sql = "select * from h_employee where Email='".mysql_real_escape_string($Email)."' and Status=1"; 
				$arryRow = $this->query($sql, 1);
				$UserName = $arryRow[0]['UserName'];
				$UserID = $arryRow[0]['UserID'];

				if(sizeof($arryRow)>0)
				{
					$Password = substr(md5(rand(100,10000)),0,8);
					
					$sql_u = "update h_employee set Password='".md5($Password)."'
					where Email='".$Email."'";
					$this->query($sql_u, 0);


					if($UserID>0){
						$sql_u = "update user set Password='".md5($Password)."'
						where UserID='".$UserID."'";
						$this->query($sql_u, 0);
					}
					

					$htmlPrefix = 'hrms/'.$Config['EmailTemplateFolder'];

					$contents = file_get_contents($htmlPrefix."forgot.htm");
					$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';


					$contents = str_replace("[COMPNAY_URL]",$CompanyUrl,$contents);
					$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);
					$contents = str_replace("[USERNAME]",$arryRow[0]['UserName'],$contents);
					$contents = str_replace("[EMAIL]",$Email,$contents);
					$contents = str_replace("[PASSWORD]",$Password,$contents);	
					$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
					$contents = str_replace("[DATE]",date("jS, F Y"),$contents);	
							
					$mail = new MyMailer();
					$mail->IsMail();			
					$mail->AddAddress($Email);
					$mail->sender($Config['SiteName'], $Config['AdminEmail']);   
					$mail->Subject = $Config['SiteName']." - Employee - New Password";
					$mail->IsHTML(true);
					$mail->Body = $contents;  

				//echo $Config['SiteName'].$Email.$Config['AdminEmail'].$contents; exit;

					if($Config['Online'] == '1'){
						$mail->Send();	
					}
					return 1;
				}else{
					return 0;
				}
			}
		}				
		

		function RequestSalarySlip($arryRequest){
			
			global $Config;
			extract($arryRequest);
			if(!empty($EmpID)){
					$arryRow = $this->GetEmployeeBrief($EmpID);
					$objConfigure=new configure();
					$arryDept = $objConfigure->GetSubDepartmentInfo(1);

					$ToName = $arryDept[0]['UserName'];
					$ToEmail = $arryDept[0]['Email'];

					if(sizeof($arryRow)>0 && !empty($ToEmail))
					{
						
						$htmlPrefix = $Config['EmailTemplateFolder'];		

						$CompanyUrl = $Config['Url'].$Config['AdminFolder'].'/';

						$contents = file_get_contents($htmlPrefix."request_salary_slip.htm");
						
						$contents = str_replace("[URL]",$Config['Url'],$contents);
						$contents = str_replace("[SITENAME]",$Config['SiteName'],$contents);

						$contents = str_replace("[ToName]",$ToName,$contents);

						$contents = str_replace("[UserName]",$arryRow[0]['UserName'],$contents);
						$contents = str_replace("[Email]",$arryRow[0]['Email'],$contents);
						$contents = str_replace("[Department]",$arryRow[0]['Department'],$contents);
						$contents = str_replace("[JobTitle]",$arryRow[0]['JobTitle'],$contents);
						$contents = str_replace("[EmpCode]",$arryRow[0]['EmpCode'],$contents);
						$contents = str_replace("[FromDate]",date("jS, F Y", strtotime($FromDate)),$contents);	
						$contents = str_replace("[ToDate]",date("jS, F Y", strtotime($ToDate)),$contents);	
						$contents = str_replace("[Message]",$Message,$contents);	

						$contents = str_replace("[COMPNAY_URL]",$CompanyUrl, $contents);
						$contents = str_replace("[FOOTER_MESSAGE]",$Config['MailFooter'],$contents);
								
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($ToEmail);
						$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
						$mail->Subject = $Config['SiteName']." - Salary Slip Request";
						$mail->IsHTML(true);
						$mail->Body = $contents;  

						//echo $ToEmail.$Config['AdminEmail'].$contents; exit;

						if($Config['Online'] == '1'){
							$mail->Send();	
						}
						return 1;
					}else{
						return 0;
					}

			}


		}	



		function RemoveEmployee($EmpID)
		{

			global $Config;
			$objConfigure=new configure();
			if(!empty($EmpID)){
					$strSQLQuery = "select UserID,Email,Image,Resume,IdProof,AddressProof1,AddressProof2 from h_employee where EmpID='".mysql_real_escape_string($EmpID)."'"; 
					$arryRow = $this->query($strSQLQuery, 1);


	$ImgDir = $Config['UploadPrefix'].'upload/employee/'.$_SESSION['CmpID'].'/';
	$ResumeDir = $Config['UploadPrefix'].'upload/resume/'.$_SESSION['CmpID'].'/';
	$IDDir = $Config['UploadPrefix'].'upload/ids/'.$_SESSION['CmpID'].'/';
	$AddressDir = $Config['UploadPrefix'].'upload/add_proof/'.$_SESSION['CmpID'].'/';

				
if($arryRow[0]['Image'] !='' && file_exists($ImgDir.$arryRow[0]['Image']) ){				
	$objConfigure->UpdateStorage($ImgDir.$arryRow[0]['Image'],0,1);		
	unlink($ImgDir.$arryRow[0]['Image']);	
}

if($arryRow[0]['Resume'] !='' && file_exists($ResumeDir.$arryRow[0]['Resume']) )
{	
	$objConfigure->UpdateStorage($ResumeDir.$arryRow[0]['Resume'],0,1);					
	unlink($ResumeDir.$arryRow[0]['Resume']);	
}	

if($arryRow[0]['IdProof'] !='' && file_exists($IDDir.$arryRow[0]['IdProof']) ){	
	$objConfigure->UpdateStorage($IDDir.$arryRow[0]['IdProof'],0,1);				
	unlink($IDDir.$arryRow[0]['IdProof']);	
}			

if($arryRow[0]['AddressProof1'] !='' && file_exists($AddressDir.$arryRow[0]['AddressProof1']) ){	
	$objConfigure->UpdateStorage($AddressDir.$arryRow[0]['AddressProof1'],0,1);				
	unlink($AddressDir.$arryRow[0]['AddressProof1']);	
}
if($arryRow[0]['AddressProof2'] !='' && file_exists($AddressDir.$arryRow[0]['AddressProof2']) ){	
	$objConfigure->UpdateStorage($AddressDir.$arryRow[0]['AddressProof2'],0,1);				
	unlink($AddressDir.$arryRow[0]['AddressProof2']);	
}
	
$arryDocument = $this->GetEmployeeDoc($EmpID,'Education');
$DocDir = 'upload/education/'.$_SESSION['CmpID'].'/';
foreach ($arryDocument as $key => $values) {
	$Document = $values['Document'];
	if ($Document != '' && file_exists($DocDir . $Document)) {
		$objConfigure->UpdateStorage($DocDir.$Document,0,1);	
		#unlink($DocDir . $Document);
	}
}

/**************************/				
$strSQLQuery = "delete from h_employee where EmpID='".mysql_real_escape_string($EmpID)."'";  
$this->query($strSQLQuery, 0);			

$sql = "delete from h_entitlement where EmpID = '".mysql_real_escape_string($EmpID)."'"; 
$this->query($sql, 0);		

$sql = "delete from h_leave where EmpID = '".mysql_real_escape_string($EmpID)."'"; 
$this->query($sql, 0);			

$sql = "delete from h_employment where EmpID = '".mysql_real_escape_string($EmpID)."'"; 
$this->query($sql, 0);			

$sql = "delete from  h_salary where EmpID = '".mysql_real_escape_string($EmpID)."'"; 
$this->query($sql, 0);	

$sql = "delete from h_pay_salary where EmpID = '".mysql_real_escape_string($EmpID)."'"; 
$this->query($sql, 0);	
		
$sql = "delete from h_employee_doc where EmpID = '".mysql_real_escape_string($EmpID)."'"; 
$this->query($sql, 0);

$sql = "delete from h_commission where EmpID = '".mysql_real_escape_string($EmpID)."'"; 
$this->query($sql, 0);



					/********************/
					if($arryRow[0]['UserID']>0){
						$objUser=new user();
						$objUser->RemoveUser($arryRow[0]['UserID']);		
					}
					/********************/



					/***********************/
					$objConfig=new admin();
					$Config['DbName'] = $Config['DbMain'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
			
					$objConfig->RemoveUserEmail($arryRow[0]['Email']);

					$Config['DbName'] = $_SESSION['CmpDatabase'];
					$objConfig->dbName = $Config['DbName'];
					$objConfig->connect();
					/***********************/


			}

			return 1;

		}

		function UpdateImage($Image,$EmpID)
		{
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set Image='".$Image."' where EmpID='".$EmpID."'";
				return $this->query($strSQLQuery, 0);
			}
		}
		
		function UpdateResume($Resume,$EmpID)
		{
			if(!empty($EmpID)){
				 $strSQLQuery = "update h_employee set Resume='".$Resume."' where EmpID='".$EmpID."'";
				 $this->query($strSQLQuery, 0);
			}
			 return true;
		}

		function UpdateIdFile($IdProof,$EmpID)
		{
			if(!empty($EmpID)){
				$strSQLQuery = "update h_employee set IdProof='".$IdProof."' where EmpID='".$EmpID."'";
				return $this->query($strSQLQuery, 0);
			}
		}

		function UpdateUploadedFile($FieldName, $FileName, $dir, $EmpID)
		{
			if(!empty($EmpID)){
				$strSQLQuery = "select ".$FieldName." from h_employee where EmpID='".$EmpID."'";
				$arryRow = $this->query($strSQLQuery, 1);
				$FileDir = 'upload/'.$dir.'/'.$_SESSION['CmpID'].'/';

				if($arryRow[0][$FieldName] !='' && $arryRow[0][$FieldName] !=$FileName && file_exists($FileDir.$arryRow[0][$FieldName]) ){							
					unlink($FileDir.$arryRow[0][$FieldName]);	
				}


				$strSQLQuery = "update h_employee set ".$FieldName."='".$FileName."' where EmpID='".$EmpID."'";
				return $this->query($strSQLQuery, 0);
			}
		}
		

		function AddEmployeeDoc($EmpID, $Document, $DocType, $DocumentTitle){   
			global $Config;
			$strSQLQuery = "insert into h_employee_doc (EmpID, DocType, Document, DocumentTitle, AddedDate) values('".$EmpID."', '".mysql_real_escape_string($DocType)."', '".mysql_real_escape_string($Document)."', '".mysql_real_escape_string($DocumentTitle)."','".$Config['TodayDate']."')";
			$this->query($strSQLQuery, 0);
			return 1;
		}

		function  GetEmployeeDoc($EmpID,$DocType){
				if(!empty($EmpID)){
					$strSQLQuery = "select * from h_employee_doc where EmpID= '".mysql_real_escape_string($EmpID)."' and DocType= '".mysql_real_escape_string($DocType)."' order by DocID Asc";
					return $this->query($strSQLQuery, 1);
				}
		}
                
                function  GetSalesPerson($EmppID){
                    
                                       $strSQLQuery = "select CONCAT(FirstName,' ',LastName) as name from h_employee where EmpID= '".mysql_real_escape_string($EmppID)."'";
                                        //echo $strSQLQuery;die;
					return $this->query($strSQLQuery, 1);
				
		}


		function RemoveEmpDoc($DocID,$Dir)
		{
				$objConfigure=new configure();
				$strSQLQuery = "select Document from h_employee_doc where DocID='".mysql_real_escape_string($DocID)."'"; 
				$arryRow = $this->query($strSQLQuery, 1);
				
				$DocDir = 'upload/'.$Dir.'/'.$_SESSION['CmpID'].'/';

				if($arryRow[0]['Document'] !='' && file_exists($DocDir.$arryRow[0]['Document']) ){	
				$objConfigure->UpdateStorage($DocDir.$arryRow[0]['Document'],0,1);		
				unlink($DocDir.$arryRow[0]['Document']);	
				}

				$sql = "delete from h_employee_doc where DocID='".mysql_real_escape_string($DocID)."'"; 
				$rs = $this->query($sql,0);

				if(sizeof($rs))
					return true;
				else
					return false;

		}


		function changeEmployeeStatus($EmpID)
		{
			if(!empty($EmpID)){
				$sql="select EmpID,EmpCode,Status,UserName from h_employee where EmpID='".mysql_real_escape_string($EmpID)."'";
				$rs = $this->query($sql);
				if(sizeof($rs))
				{
					if($rs[0]['Status']==1){
						$Status=0; $newValue = 'deactivated';
					}else{
						$Status=1; $newValue = 'activated';
					}
						
					$sql="update h_employee set Status='$Status' where EmpID='".mysql_real_escape_string($EmpID)."'";
					$this->query($sql,0);	
					
					/**** Notification ****/
					$arryNotification['refID'] = $EmpID;
					$arryNotification['refType'] = "EmpStatus";
					$arryNotification['Name'] = $rs[0]['UserName'];
					$arryNotification['Subject'] = "Employee account ".$newValue;
					$arryNotification['Message'] = 'Login account for employee: '.$rs[0]['UserName'].' [<a class="fancybox fancybox.iframe" href="empInfo.php?view='.$EmpID.'" >'.$rs[0]['EmpCode'].'</a>] has been '.$newValue;
					$objConfigure=new configure();
					$objConfigure->AddNotification($arryNotification);
					/*********************/

				}		
			}
			return true;
		}
		

		function MultipleEmployeeStatus($EmpIDs,$Status)
		{
			$sql="select EmpID from h_employee where EmpID in (".$EmpIDs.") and Status!=".$Status; 
			$arryRow = $this->query($sql);
			if(sizeof($arryRow)>0){
				$sql="update h_employee set Status=".$Status." where EmpID in (".$EmpIDs.")";
				$this->query($sql,0);			
			}	
			return true;
		}

		

		function ValidateEmployee($Email,$Password){
			if(!empty($Email) && !empty($Password)){
				$strSQLQuery = "select * from h_employee where MD5(Email)='".md5($Email)."' and Password='".md5($Password)."' and Status=1";
				return $this->query($strSQLQuery, 1);
			}
		}

		function isEmailExists($Email,$EmpID=0)
		{
			$strSQLQuery = (!empty($EmpID))?(" and EmpID != '".$EmpID."'"):("");
			$strSQLQuery = "select EmpID from h_employee where LCASE(Email)='".strtolower(trim($Email))."'".$strSQLQuery;
			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['EmpID'])) {
				return true;
			} else {
				return false;
			}
		}
	
		function isEmpCodeExists($EmpCode,$EmpID=0)
		{
			$strSQLQuery = (!empty($EmpID))?(" and EmpID != '".$EmpID."'"):("");
			$strSQLQuery = "select EmpID from h_employee where locationID=".$_SESSION['locationID']." and LCASE(EmpCode)='".strtolower(trim($EmpCode))."'".$strSQLQuery;

			$arryRow = $this->query($strSQLQuery, 1);

			if (!empty($arryRow[0]['EmpID'])) {
				return true;
			} else {
				return false;
			}
		}
		
		function UpdatePasswordEncrypted($EmpID,$Password)
		{
				if(!empty($EmpID) && !empty($Password)){
					$sql = "update h_employee set Password='".md5($Password)."', PasswordUpdated='1'  where EmpID = '".$EmpID."'";
					$rs = $this->query($sql,0);
				}
				
				return true;

		}

		function isPermittedEmp($UserID)
		{
			if(!empty($UserID)){
				$strSQLQuery = "select count(UserID) as TotalNum from permission where UserID='".$UserID."'";
				$arryRow = $this->query($strSQLQuery, 1);

				if (!empty($arryRow[0]['TotalNum'])) {
					return true;
				} else {
					return false;
				}
			}else{
				return false;
			}
		}

		function  ListTerminated($id=0,$Year,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where e.EmpID='".$id."'"):(" where e.locationID=".$_SESSION['locationID']." and ABS(e.ExitDate)>0 ");

			if($SearchKey=='active' && ($SortBy=='e.Status' || $SortBy=='') ){
				$strAddQuery .= " and e.Status=1"; 
			}else if($SearchKey=='inactive' && ($SortBy=='e.Status' || $SortBy=='') ){
				$strAddQuery .= " and e.Status=0";
			}else if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.ExitType like '%".$SearchKey."%' or e.ExitReason like '%".$SearchKey."%' or e.FullFinal like '%".$SearchKey."%' or e.EmpCode like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%' ) " ):("");	
			}

			if(!empty($Year)){
				$DateFrom = $Year.'-01-01'; $DateEnd = $Year.'-12-31';
				//$strAddQuery .= " and e.JoiningDate<='".$DateEnd."' and (ABS(ExitDate)=0 OR e.ExitDate>'".$DateFrom."')";
				$strAddQuery .= " and e.ExitDate>='".$DateFrom."' and e.ExitDate<='".$DateEnd."' ";
			}


			$strAddQuery .= (!empty($SortBy))?(" order by ".$SortBy." "):(" order by e.ExitDate ");
			$strAddQuery .= (!empty($AscDesc))?($AscDesc):(" Desc");

			$strSQLQuery = "select e.EmpID,e.EmpCode,e.Status,e.UserName,e.ExitType, e.ExitReason,e.JoiningDate,e.ExitDate, e.ExitDesc, e.FullFinal, d.Department from h_employee e left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}


		function  ListHired($FromDate,$ToDate,$Department)
		{
			$strAddQuery = " where e.locationID=".$_SESSION['locationID'];

			$strAddQuery .= (!empty($FromDate))?(" and e.JoiningDate>='".$FromDate."'"):("");
			$strAddQuery .= (!empty($ToDate))?(" and e.JoiningDate<='".$ToDate."'"):("");
			$strAddQuery .= (!empty($Department))?(" and e.Department='".$Department."'"):("");

			$strAddQuery .= " order by e.EmpID desc ";

			$strSQLQuery = "select e.EmpID,e.EmpCode,e.Status,e.UserName,e.Email, e.JoiningDate, e.JobTitle,e.ExitDate, e.ExitDesc, d.Department from h_employee e left outer join  h_department d on e.Department=d.depID ".$strAddQuery;
		
		
			return $this->query($strSQLQuery, 1);		
				
		}


		
		function  ListDirectory($id=0,$SearchKey,$SortBy,$AscDesc)
		{
			$strAddQuery = '';
			$SearchKey   = strtolower(trim($SearchKey));
			$strAddQuery .= (!empty($id))?(" where e.EmpID='".$id."'"):(" where e.locationID=".$_SESSION['locationID']);

			if($SortBy != ''){
				$strAddQuery .= (!empty($SearchKey))?(" and (".$SortBy." like '%".$SearchKey."%')"):("");
			}else{
				$strAddQuery .= (!empty($SearchKey))?(" and (e.UserName like '%".$SearchKey."%'  or e.Email like '%".$SearchKey."%' or e.Mobile like '%".$SearchKey."%' or e.JobTitle like '%".$SearchKey."%' or e.EmpID like '%".$SearchKey."%'  or d.Department like '%".$SearchKey."%' ) " ):("");		
			}


			$strSQLQuery = "select e.EmpID,e.UserName,e.Mobile, e.Email, e.OrderBy, e.JobTitle, e.Image,d.Department from h_employee e left outer join  h_department d on e.Department=d.depID ".$strAddQuery."  Order by Case When OrderBy>0 Then 0 Else 1 End,OrderBy Asc ";
		
		
			return $this->query($strSQLQuery, 1);		
				
		}	

	function updateOrderBy($arryDetails){   
		foreach($arryDetails as $key=>$values){
			$arryOrder = explode("_",$key);
			$EmpID = $arryOrder[1];
			if($EmpID>0){
				$strSQLQuery = "update h_employee set OrderBy='".addslashes($values)."' where EmpID='".$EmpID."'";
				$this->query($strSQLQuery, 0);
			}
		}

		return 1;
	}



	/***************************************/
	/*************Employment ****************/
	function UpdateEmployment($arryDetails){   
		extract($arryDetails);		
		if($employmentID>0){
			$strSQLQuery = "update h_employment set EmployerName='".mysql_real_escape_string(strip_tags($EmployerName))."',  Designation='".mysql_real_escape_string(strip_tags($Designation))."', FromDate='".mysql_real_escape_string(strip_tags($FromDate))."', ToDate='".mysql_real_escape_string(strip_tags($ToDate))."', JobProfile='".mysql_real_escape_string(strip_tags($JobProfile))."' where EmpID='".mysql_real_escape_string($EmpID)."' and employmentID='".mysql_real_escape_string($employmentID)."'";
		}else{
			$strSQLQuery = "insert into h_employment (EmpID, EmployerName, Designation ,FromDate, ToDate, JobProfile) values('".mysql_real_escape_string($EmpID)."', '".mysql_real_escape_string(strip_tags($EmployerName))."','".mysql_real_escape_string(strip_tags($Designation))."', '".mysql_real_escape_string(strip_tags($FromDate))."', '".mysql_real_escape_string(strip_tags($ToDate))."', '".mysql_real_escape_string(strip_tags($JobProfile))."')";
		}
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function  GetEmployment($EmpID){
		if(!empty($EmpID)){
			$strSQLQuery = "select * from h_employment where EmpID='".mysql_real_escape_string($EmpID)."' order by employmentID Asc";
			return $this->query($strSQLQuery, 1);
		}
	}
	function  GetEmploymentDetail($EmpID,$employmentID){
		if(!empty($EmpID) && !empty($employmentID)){
			$strSQLQuery = "select * from h_employment where EmpID='".mysql_real_escape_string($EmpID)."' and employmentID='".mysql_real_escape_string($employmentID)."'";
			return $this->query($strSQLQuery, 1);
		}
	}
	function RemoveEmployment($employmentID){
		if(!empty($employmentID)){
			$sql = "delete from h_employment where employmentID = '".mysql_real_escape_string($employmentID)."'";
			$this->query($sql, 0);			
		}
		return 1;
	}
	/***************************************/
	/*************Family ****************/
	function UpdateFamily($arryDetails){   
		extract($arryDetails);		
		if($familyID>0){
			$strSQLQuery = "update h_family set Name='".mysql_real_escape_string(strip_tags($Name))."', Relation='".mysql_real_escape_string(strip_tags($Relation))."', Age='".mysql_real_escape_string(strip_tags($Age))."', Dependent='".mysql_real_escape_string(strip_tags($Dependent))."' where EmpID='".mysql_real_escape_string($EmpID)."' and familyID='".mysql_real_escape_string($familyID)."'";
		}else{
			$strSQLQuery = "insert into h_family (EmpID, Name, Relation ,Age, Dependent) values('".mysql_real_escape_string($EmpID)."', '".mysql_real_escape_string(strip_tags($Name))."','".mysql_real_escape_string(strip_tags($Relation))."', '".mysql_real_escape_string(strip_tags($Age))."', '".mysql_real_escape_string(strip_tags($Dependent))."')";
		}
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function  GetFamily($EmpID){
		if(!empty($EmpID)){
			$strSQLQuery = "select * from h_family where EmpID= '".mysql_real_escape_string($EmpID)."' order by familyID Asc";
			return $this->query($strSQLQuery, 1);
		}
	}
	function  GetFamilyDetail($EmpID,$familyID){
		if(!empty($EmpID) && !empty($familyID) ){
			$strSQLQuery = "select * from h_family where EmpID='".mysql_real_escape_string($EmpID)."' and familyID='".mysql_real_escape_string($familyID)."'";
			return $this->query($strSQLQuery, 1);
		}
	}
	function RemoveFamily($familyID){
		if(!empty($familyID)){
			$sql = "delete from h_family where familyID = '".mysql_real_escape_string($familyID)."'";
			$this->query($sql, 0);
		}
		return 1;
	}

	/**********************************************/
	/*************Emergency Contact ****************/
	function UpdateEmergency($arryDetails){   
		extract($arryDetails);		
		if($contactID>0){
			$strSQLQuery = "update h_emergency set Name='".mysql_real_escape_string(strip_tags($Name))."', Relation='".mysql_real_escape_string(strip_tags($Relation))."', Address='".mysql_real_escape_string(strip_tags($Address))."', Mobile='".mysql_real_escape_string(strip_tags($Mobile))."', HomePhone='".mysql_real_escape_string(strip_tags($HomePhone))."', WorkPhone='".mysql_real_escape_string(strip_tags($WorkPhone))."' where EmpID='".mysql_real_escape_string($EmpID)."' and contactID='".mysql_real_escape_string($contactID)."'";
		}else{
			$strSQLQuery = "insert into h_emergency (EmpID, Name, Relation ,Address, Mobile, HomePhone, WorkPhone) values('".mysql_real_escape_string(strip_tags($EmpID))."', '".mysql_real_escape_string(strip_tags($Name))."','".mysql_real_escape_string(strip_tags($Relation))."', '".mysql_real_escape_string(strip_tags($Address))."', '".mysql_real_escape_string(strip_tags($Mobile))."', '".mysql_real_escape_string(strip_tags($HomePhone))."', '".mysql_real_escape_string(strip_tags($WorkPhone))."')";
		}
		$this->query($strSQLQuery, 0);
		return 1;
	}

	function  GetEmergency($EmpID){
		if(!empty($EmpID)){
			$strSQLQuery = "select * from h_emergency where EmpID= '".mysql_real_escape_string($EmpID)."' order by contactID Asc";
			return $this->query($strSQLQuery, 1);
		}
	}
	function  GetEmergencyDetail($EmpID,$contactID){
		if(!empty($EmpID) && !empty($contactID)){
			$strSQLQuery = "select * from h_emergency where EmpID='".mysql_real_escape_string($EmpID)."' and contactID='".mysql_real_escape_string($contactID)."'";
			return $this->query($strSQLQuery, 1);
		}
	}
	function RemoveEmergency($contactID){
		if(!empty($contactID)){
			$sql = "delete from h_emergency where contactID = '".mysql_real_escape_string($contactID)."'";
			$this->query($sql, 0);
		}
		return 1;
	}

	



	/************UpdateEmpCode****************/
	/*******************************************/
	function UpdateEmpCode()
	{  
		$strSQLQuery = "select EmpID,EmpCode from h_employee ";
		$arryRow = $this->query($strSQLQuery, 1);
		foreach($arryRow as $key=>$values){
			//if(empty($values["EmpCode"])){
				$strSQL = "update h_employee set EmpCode='EMP000".$values["EmpID"]."' where EmpID='".$values["EmpID"]."'"; 
				$this->query($strSQL, 0);
			//}
		}
		return true;
	}

	function UpdateEmpEmail()
	{  
		global $Config;
		$strSQLQuery = "select EmpID,Email from h_employee ";
		$arryRow = $this->query($strSQLQuery, 1);

		/***********************/
		$objConfig=new admin();
		$Config['DbName'] = $Config['DbMain'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();

		foreach($arryRow as $key=>$values){
			$objConfig->addUserEmail($_SESSION['CmpID'],$values['EmpID'],$values['Email']);
		}

		$Config['DbName'] = $_SESSION['CmpDatabase'];
		$objConfig->dbName = $Config['DbName'];
		$objConfig->connect();
		return true;
	}


	/************* Get Event By Bhoodev *************/
	/*******************************************/

	function  GetEventDetail(){

		global $Config;

        $TodayDate = $Config['TodayDate'];
		$arryDate = explode("-",$TodayDate);
		$arryDay = explode(" ",$arryDate[2]);

		$today  = date("m-d", strtotime($TodayDate));
		$tomorrow  = date("m-d", mktime(0, 0, 0, $arryDate[1] , $arryDay[0]+1, $arryDate[0]));

		$sql = "SELECT EmpID,UserName,date_of_birth, CONCAT('Birthday') as EventType FROM `h_employee` WHERE Status=1 and (`date_of_birth` LIKE '%".$today."' or `date_of_birth` LIKE '%".$tomorrow."') order by Day(date_of_birth) asc";
		$arryDB = $this->query($sql, 1);
		

		$sql = "SELECT EmpID,UserName,JoiningDate, CONCAT('Joinning') as EventType FROM `h_employee` WHERE Status=1 and (JoiningDate LIKE '%".$today."' or JoiningDate LIKE '%".$tomorrow."') order by Day(JoiningDate) asc";
		$arryJoining = $this->query($sql, 1);
		
	   
		 $arryEvent = array_merge($arryDB,$arryJoining );
		 return $arryEvent;

		}	


			function GetTemplateContent($TemplateID=0,$Status=0)
		{
			$sql = " where 1 ";
			$sql .= (!empty($TemplateID))?(" and TemplateID = '".$TemplateID."'"):("");
			$sql .= (!empty($Status) && $Status == 1)?(" and Status = '".$Status."'"):("");

			$sql = "select * from email_template ".$sql." order by TemplateID asc" ; 
			return $this->query($sql, 1);
		}

		function GetTemplateCategory($CatID)
		{
			$sql = (!empty($CatID))?(" where CatID = '".$CatID."'"):("");

			 $sql = "select * from email_cat ".$sql." order by CatID asc" ; 
			return $this->query($sql, 1);
		}

		function GetTemplateByCategory($CatID)
		{
			$sql = (!empty($CatID))?(" where CatID = ".$CatID):("");

			 $sql = "select * from email_template ".$sql." order by TemplateID asc" ; 
			return $this->query($sql, 1);
		}

		function UpdateTemplateContent($arryDetails)
		{
			global $Config;
			extract($arryDetails);          

			$sql="update email_template set Status='".$Status."',Content='".addslashes($TemplateContent)."',subject='".addslashes($subject)."' where TemplateID = '".$TemplateID."'";

			$this->query($sql,0);			
	    }


		function SendEventEmail($arryDetails)
		{
			global $Config;
			extract($arryDetails);          

             if(!empty($EmpID)){
					$arryRow = $this->GetEmployeeBrief($EmpID);
					$ToName = $arryRow[0]['UserName'];
					$ToEmail = $arryRow[0]['Email'];

					if(sizeof($arryRow)>0 && !empty($ToEmail))
					{
						
						$contents = $TemplateContent;	
						$mail = new MyMailer();
						$mail->IsMail();			
						$mail->AddAddress($ToEmail);
						$mail->sender($Config['SiteName']." - ", $Config['AdminEmail']);   
						$mail->Subject = $Config['SiteName']." - ".$subject;
						$mail->IsHTML(true);
						$mail->Body = $contents;  

						#echo $ToEmail.$Config['AdminEmail'].$contents.$subject; exit;

						if($Config['Online'] == '1'){
							$mail->Send();	
						}
					return 1;
				}else{
				return 0;
			  }
			 }



	    }


	/*******************************************/
	/*******************************************/

	function UploadEmpData($arryEmp)  
	{
		global $Config;
		$Count=0;

		$Config['Online']=0; // To Stop Email Send
		$objUser=new user();
		$objCommon=new common();
		$objConfigure=new configure();
		foreach($arryEmp as $key=>$values){
	
			$EmpCode = $values['EmpCode'];
			$Email = $values['Email'];	
			
			if(!empty($Email)){
				if (preg_match("/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/",$Email))
				{
					$ValidEmail = 1;
				}else{
					$ValidEmail = 0;
				}
				
			}
			
	
			if(!empty($EmpCode) && !empty($Email) && $ValidEmail==1){

				if($this->isEmpCodeExists($EmpCode,"")){
					//echo "1";
				}else if($this->isEmailExists($Email,"")){
					//echo "1";
				}else{
					$values['Status'] = 1;
					$values['catID'] = 4;  //executives
					$values['JobType'] = 'Confirmed'; 
					$values['Password'] = substr(md5(rand(100,10000)),0,8);
					$values['JoiningDate'] = $objConfigure->ExcelToPHPDate($values['DateOfJoining']);
					$values['date_of_birth'] = $objConfigure->ExcelToPHPDate($values['DateOfBirth']); 
					if($values['DateOfLeaving']>0){
						$values['LastWorking'] = $objConfigure->ExcelToPHPDate($values['DateOfLeaving']);
					}
					if($values['MaritalStatus']!="Married")$values['MaritalStatus'] = "Single";
					
					$values['LandlineNumber'] = str_replace("-"," ",$values['LandlineNumber']);
					$values['Nationality'] = str_replace("Indian","India",$values['Nationality']);
					


					/****** Add Department ******/
					$values['Department'] = $objCommon->addUpdateDepartment($values['DepartmentName']); 
					/****** Add Job Title ******/
					$objCommon->addUpdateAttribute($values['JobTitle'],11); 
					/*******************************/	
					$EmpID = $this->AddEmployee($values); 
					/****** Add Family ******/
					unset($arryFamily);
					$arryFamily['EmpID'] = $EmpID;
					$arryFamily['Name'] = $values['Father'];
					$arryFamily['Relation'] = 'Father';
					$this->UpdateFamily($arryFamily);
					
					$arryFamily['Name'] = $values['MotherFirstName'].' '.$values['MotherLastName'];
					$arryFamily['Relation'] = 'Mother';
					$this->UpdateFamily($arryFamily);


					/****** Add To User Table******/
					unset($arryUser);
					$arryUser['Status'] = $values['Status'];
					$arryUser['Email'] = $values['Email'];
					$arryUser['Password'] = $values['Password'];
					$arryUser['UserName'] = $values['FirstName'].' '.$values['LastName'];
					$arryUser['UserType'] = "employee";
					$UserID = $objUser->AddUser($arryUser);
					$this->query("update h_employee set UserID=".$UserID." where EmpID=".$EmpID, 0);	
					/*******************************/
					
			
					$Count++;

				}					
						

				


			} //end if

		} //end foreach

		return $Count;

	}








}
?>
