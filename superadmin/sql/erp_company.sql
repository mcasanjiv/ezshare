
CREATE TABLE IF NOT EXISTS `admin_modules` (
  `ModuleID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Link` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `Parent` int(10) NOT NULL DEFAULT '0',
  `Default` tinyint(4) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  PRIMARY KEY (`ModuleID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `configuration`
--

CREATE TABLE IF NOT EXISTS `configuration` (
  `ConfigID` int(11) NOT NULL AUTO_INCREMENT,
  `RecordsPerPage` int(11) NOT NULL DEFAULT '10',
  `Tax` float(10,2) NOT NULL DEFAULT '5.00',
  `Shipping` float(10,2) NOT NULL DEFAULT '20.00',
  `PaypalID` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `MetaKeywords` text COLLATE latin1_general_ci NOT NULL,
  `MetaDescription` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`ConfigID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_field`
--

CREATE TABLE IF NOT EXISTS `custom_field` (
  `FieldID` int(10) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `depID` int(10) NOT NULL,
  `FieldTitle` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FieldName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `FieldInfo` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Module` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Tab` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Parent` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  PRIMARY KEY (`FieldID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


--
-- Table structure for table `dashboard_icon`
--

CREATE TABLE IF NOT EXISTS `dashboard_icon` (
  `IconID` int(10) NOT NULL AUTO_INCREMENT,
  `Module` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `Link` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `ModuleID` int(10) NOT NULL,
  `EditPage` tinyint(1) NOT NULL DEFAULT '0',
  `IframeFancy` char(1) COLLATE latin1_general_ci NOT NULL,
  `depID` int(10) NOT NULL,
  `Display` tinyint(1) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `OrderBy` int(10) NOT NULL,
  `IconType` tinyint(1) NOT NULL,
  `Default` tinyint(1) NOT NULL,
  PRIMARY KEY (`IconID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `depID` int(10) NOT NULL AUTO_INCREMENT,
  `Department` varchar(50) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`depID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `emails` (
  `templateID` int(11) NOT NULL AUTO_INCREMENT,
  `depID` int(10) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Title` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `Note` varchar(255) NOT NULL,
  `Important` text NOT NULL,
  `Subject` varchar(200) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `OrderBy` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  PRIMARY KEY (`templateID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;



--
-- Table structure for table `email_cat`
--


CREATE TABLE IF NOT EXISTS `email_cat` (
  `CatID` int(10) NOT NULL AUTO_INCREMENT,
  `department` int(15) NOT NULL,
  `Name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OrderLevel` int(15) NOT NULL,
  PRIMARY KEY (`CatID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_template`
--

CREATE TABLE IF NOT EXISTS `email_template` (
  `TemplateID` int(11) NOT NULL AUTO_INCREMENT,
  `CatID` int(10) NOT NULL,
  `Title` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Content` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `arr_field` text NOT NULL,
  `Status` int(1) DEFAULT '1',
  PRIMARY KEY (`TemplateID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------


--
-- Table structure for table `h_asset`
--

CREATE TABLE IF NOT EXISTS `h_asset` (
  `AssetID` int(20) NOT NULL AUTO_INCREMENT,
  `TagID` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `locationID` int(10) NOT NULL,
  `AssignID` int(10) NOT NULL,
  `RFID` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssetName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `SerialNumber` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Location` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Description` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Vendor` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Acquired` date NOT NULL,
  `Category` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Brand` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Model` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `WrStart` date NOT NULL,
  `WrEnd` date NOT NULL,
  `Status` varchar(20) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`AssetID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_asset_assign`
--

CREATE TABLE IF NOT EXISTS `h_asset_assign` (
  `AssignID` int(20) NOT NULL AUTO_INCREMENT,
  `AssetID` int(20) NOT NULL,
  `TagID` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssetName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `EmpID` int(10) NOT NULL,
  `EmpName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ExpectedReturnDate` date NOT NULL,
  `AssignedBy` int(10) NOT NULL,
  `AssignedByName` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AssignDate` date NOT NULL,
  `ReturnDate` date NOT NULL,
  `UpdatedDate` date NOT NULL,
  `ipaddress` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`AssignID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_attendence`
--

CREATE TABLE IF NOT EXISTS `h_attendence` (
  `attID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `attDate` date NOT NULL,
  `InTime` varchar(20) NOT NULL,
  `OutTime` varchar(20) NOT NULL,
  `InComment` varchar(250) NOT NULL,
  `OutComment` varchar(250) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  `WorkingHourStart` varchar(6) NOT NULL,
  `WorkingHourEnd` varchar(6) NOT NULL,
  `shiftID` int(10) NOT NULL,
  PRIMARY KEY (`attID`),
  KEY `EmpID` (`EmpID`),
  KEY `attDate` (`attDate`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;


--
-- Table structure for table `h_attribute`
--

CREATE TABLE IF NOT EXISTS `h_attribute` (
  `attribute_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_name` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `attribute` varchar(40) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `h_attribute_value`
--

CREATE TABLE IF NOT EXISTS `h_attribute_value` (
  `value_id` int(10) NOT NULL AUTO_INCREMENT,
  `attribute_value` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `attribute_id` int(10) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `locationID` int(11) NOT NULL,
  PRIMARY KEY (`value_id`),
  KEY `attribute_id` (`attribute_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_candidate`
--

CREATE TABLE IF NOT EXISTS `h_candidate` (
  `CanID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `FirstName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UserName` varchar(80) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Gender` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `date_of_birth` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Vacancy` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Salary` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `SalaryFrequency` varchar(10) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ExperienceYear` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ExperienceMonth` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Resume` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `InterviewStatus` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `TestTaken` varchar(250) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `JoiningDate` date NOT NULL,
  `OfferedDate` date NOT NULL,
  `ApplyDate` date NOT NULL,
  `Skill` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  `EmpID1` int(11) NOT NULL,
  `EmpID2` int(11) NOT NULL,
  `EmpID3` int(11) NOT NULL,
  `EmpName1` varchar(80) NOT NULL,
  `EmpName2` varchar(80) NOT NULL,
  `EmpName3` varchar(80) NOT NULL,
  PRIMARY KEY (`CanID`),
  KEY `country_id` (`country_id`),
  KEY `locationID` (`locationID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `h_commission` (
  `comID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `CommType` varchar(30) NOT NULL,
  `tierID` int(10) NOT NULL,
  `spiffID` int(10) NOT NULL,
  `SalesPersonType` varchar(30) NOT NULL,
  `Accelerator` varchar(3) NOT NULL,
  `AcceleratorPer` varchar(6) NOT NULL,
  `TargetFrom` varchar(30) NOT NULL,
  `TargetTo` varchar(30) NOT NULL,
  `CommPercentage` varchar(6) NOT NULL,
  `SpiffTarget` varchar(30) NOT NULL,
  `SpiffEmp` varchar(30) NOT NULL,
  `CommOn` tinyint(1) NOT NULL,
  `CommissionType` varchar(20) NOT NULL,
  PRIMARY KEY (`comID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ;


--
-- Table structure for table `h_declaration`
--

CREATE TABLE IF NOT EXISTS `h_declaration` (
  `decID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `Year` varchar(30) NOT NULL,
  `document` varchar(100) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`decID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_dec_cat`
--

CREATE TABLE IF NOT EXISTS `h_dec_cat` (
  `catID` int(20) NOT NULL AUTO_INCREMENT,
  `catName` varchar(40) NOT NULL,
  `catGrade` varchar(40) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_dec_head`
--

CREATE TABLE IF NOT EXISTS `h_dec_head` (
  `headID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(11) NOT NULL,
  `catID` int(11) NOT NULL,
  `heading` varchar(100) NOT NULL,
  `subheading` varchar(100) NOT NULL,
  `Default` tinyint(1) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`headID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_department`
--

CREATE TABLE IF NOT EXISTS `h_department` (
  `depID` int(11) NOT NULL AUTO_INCREMENT,
  `Division` int(10) NOT NULL,
  `Department` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`depID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `c_activity`
--


CREATE TABLE IF NOT EXISTS `c_activity` (
  `activityID` int(15) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `created_by` varchar(36) DEFAULT NULL,
  `created_id` int(15) DEFAULT NULL,
  `description` text,
  `deleted` tinyint(1) DEFAULT '0',
  `assignedTo` varchar(80) DEFAULT NULL,
  `AssignType` varchar(50) NOT NULL,
  `GroupID` int(18) NOT NULL,
  `startDate` date DEFAULT NULL,
  `startTime` time DEFAULT NULL,
  `closeDate` date DEFAULT NULL,
  `closeTime` time DEFAULT NULL,
  `parent_type` varchar(255) DEFAULT NULL,
  `parentID` char(36) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `activityType` varchar(100) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `priority` varchar(100) DEFAULT NULL,
  `visibility` varchar(50) DEFAULT NULL,
  `Notification` tinyint(1) DEFAULT '0',
  `reminder` tinyint(1) NOT NULL DEFAULT '0',
  `RelatedType` varchar(100) NOT NULL,
  `LeadID` int(15) NOT NULL,
  `OpprtunityID` int(15) NOT NULL,
  `CampaignID` int(15) NOT NULL,
  `TicketID` int(15) NOT NULL,
  `QuoteID` int(15) NOT NULL,
  `add_date` date DEFAULT NULL,
  `CustID` int(11) NOT NULL,
  `EntryType` varchar(30) NOT NULL,
  `EntryFrom` date NOT NULL,
  `EntryTo` date NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `EntryInterval` varchar(30) NOT NULL,
  `EntryMonth` int(2) NOT NULL,
  `EntryWeekly` varchar(30) NOT NULL,
  `LastRecurringEntry` date NOT NULL,
  PRIMARY KEY (`activityID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `c_column` (
 `cvid` int(19) NOT NULL,
 `colindex` int(11) NOT NULL,
 `colname` varchar(250) NOT NULL,
 `colvalue` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `c_customview` (
  `cvid` int(19) NOT NULL AUTO_INCREMENT,
  `viewname` varchar(150) NOT NULL DEFAULT '0',
  `setdefault` tinyint(1) NOT NULL DEFAULT '0',
  `setmetrics` tinyint(1) NOT NULL,
  `entitytype` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `userid` int(19) NOT NULL,
  `locationID` int(15) NOT NULL,
  `ModuleType` varchar(50) NOT NULL,
  `department` int(10) NOT NULL,
  PRIMARY KEY (`cvid`),
  KEY `department` (`department`,`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Dumping data for table `h_department`
--

INSERT INTO `h_department` (`depID`, `Division`, `Department`, `Status`) VALUES
(1, 1, 'HR', 1),
(2, 1, 'Reception', 1),
(3, 1, 'Account', 1),
(4, 2, 'Sale', 1),
(5, 3, 'Production', 1),
(6, 3, 'Manufacturing', 1),
(7, 3, 'Receiving', 1),
(8, 4, 'Purchase', 1),
(10, 4, 'Invoice', 1),
(13, 6, 'Stock Keeper', 1),
(14, 7, 'Sales D', 1),
(15, 5, 'Marketting', 1),
(16, 4, 'Receiving PO', 1),
(17, 7, 'Sales Person', 1);



--
-- Table structure for table `h_document`
--

CREATE TABLE IF NOT EXISTS `h_document` (
  `documentID` int(20) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `heading` varchar(50) NOT NULL,
  `document` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `publish` tinyint(1) NOT NULL,
  `docDate` date NOT NULL,
  `AdminID` int(20) NOT NULL,
  `AdminType` varchar(20) NOT NULL,
  PRIMARY KEY (`documentID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_emergency`
--

CREATE TABLE IF NOT EXISTS `h_emergency` (
  `contactID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Relation` varchar(30) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `Mobile` varchar(30) NOT NULL,
  `HomePhone` varchar(30) NOT NULL,
  `WorkPhone` varchar(30) NOT NULL,
  PRIMARY KEY (`contactID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_employee`
--

CREATE TABLE IF NOT EXISTS `h_employee` (
  `EmpID` int(20) NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) NOT NULL,
  `locationID` int(10) NOT NULL DEFAULT '1',
  `EmpCode` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `FirstName` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `LastName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `UserName` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `Gender` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `Role` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `vUserInfo` tinyint(1) NOT NULL,
  `vAllRecord` tinyint(1) NOT NULL,
  `date_of_birth` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Password` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `Nationality` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `MaritalStatus` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `catID` int(3) NOT NULL,
  `shiftID` int(10) NOT NULL,
  `Division` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Department` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `DeptHead` tinyint(1) NOT NULL,
  `OtherHead` tinyint(1) NOT NULL,
  `JobTitle` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `JobType` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `Salary` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `SalaryFrequency` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `ExperienceYear` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `ExperienceMonth` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(55) COLLATE latin1_general_ci NOT NULL,
  `Resume` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Address` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `city_id` int(12) NOT NULL,
  `state_id` int(12) NOT NULL,
  `OtherState` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherCity` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `country_id` int(11) NOT NULL,
  `Mobile` varchar(25) COLLATE latin1_general_ci NOT NULL,
  `LandlineNumber` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `PersonalEmail` varchar(80) COLLATE latin1_general_ci NOT NULL,
  `Status` varchar(1) COLLATE latin1_general_ci NOT NULL DEFAULT '1',
  `JoiningDate` date NOT NULL,
  `ExitDate` date NOT NULL,
  `ExitDesc` text COLLATE latin1_general_ci NOT NULL,
  `ExitType` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ExitReason` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ExitClearence` tinyint(1) NOT NULL,
  `LastWorking` date NOT NULL,
  `FullFinal` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `verification_code` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `Skill` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `Graduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `PostGraduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Doctorate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `OtherGraduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `OtherPostGraduation` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `OtherDoctorate` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Certification` text COLLATE latin1_general_ci NOT NULL,
  `UnderGraduate` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `ProfessionalCourse` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherUnderGraduate` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `OtherProfessionalCourse` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `UpdatedDate` date NOT NULL,
  `TempPass` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `PasswordUpdated` tinyint(4) NOT NULL,
  `ipaddress` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `Supervisor` int(11) NOT NULL,
  `ReportingMethod` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ImmigrationType` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ImmigrationNo` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `ImmigrationExp` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `IdProof` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `BloodGroup` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `SSN` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `BankName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `AccountName` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `AccountNumber` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `IFSCCode` varchar(40) COLLATE latin1_general_ci NOT NULL,
  `LastLogin` datetime NOT NULL,
  `CurrentLogin` datetime NOT NULL,
  `OrderBy` int(10) NOT NULL,
  `AddressProof1` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `AddressProof2` varchar(30) COLLATE latin1_general_ci NOT NULL,
  `LeaveAccrual` varchar(11) COLLATE latin1_general_ci NOT NULL,
  `ProbationPeriod` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `EligibilityPeriod` varchar(20) COLLATE latin1_general_ci NOT NULL,
  `ProbationUnit` int(11) COLLATE latin1_general_ci NOT NULL,
  `EligibilityUnit` int(11) COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`EmpID`),
  KEY `country_id` (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `c_territory_assign` (
  `AssignID` int(20) NOT NULL AUTO_INCREMENT,
  `TerritoryID` text NOT NULL,
  `AssignType` varchar(15) NOT NULL,
  `AssignTo` int(20) NOT NULL,
  `ManagerID` int(20) NOT NULL,
  `AddedDate` date NOT NULL,
  `IPAddress` varchar(30) NOT NULL,
  PRIMARY KEY (`AssignID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

--
-- Table structure for table `h_employee_doc`
--

CREATE TABLE IF NOT EXISTS `h_employee_doc` (
  `DocID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `EmpID` int(10) NOT NULL,
  `DocType` varchar(20) NOT NULL,
  `DocumentTitle` varchar(50) NOT NULL,
  `Document` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `AddedDate` date NOT NULL,
  PRIMARY KEY (`DocID`),
  KEY `DocID` (`EmpID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_employment`
--

CREATE TABLE IF NOT EXISTS `h_employment` (
  `employmentID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(20) NOT NULL,
  `EmployerName` varchar(50) NOT NULL,
  `Designation` varchar(40) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `JobProfile` varchar(250) NOT NULL,
  PRIMARY KEY (`employmentID`),
  KEY `EmpID` (`EmpID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_news`
--

CREATE TABLE IF NOT EXISTS `h_news` (
  `newsID` int(11) NOT NULL AUTO_INCREMENT,
  `heading` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Image` varchar(30) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `newsDate` date NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`newsID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `h_benefit` (
  `Bid` int(11) NOT NULL AUTO_INCREMENT,
  `Heading` varchar(100) NOT NULL,
  `Detail` text NOT NULL,
  `Document` varchar(100) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `Date` date NOT NULL,
  `ApplyAll` tinyint(1) NOT NULL,
  PRIMARY KEY (`Bid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


--
-- Table structure for table `h_request`
--

CREATE TABLE IF NOT EXISTS `h_request` (
  `RequestID` int(11) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `EmpCode` varchar(100) NOT NULL,
  `Department` varchar(100) NOT NULL,
  `Subject` varchar(100) NOT NULL,
  `Message` text NOT NULL,
  `RequestDate` date NOT NULL,
  `Moved` tinyint(1) NOT NULL,
  PRIMARY KEY (`RequestID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_component_cat`
--

CREATE TABLE IF NOT EXISTS `h_component_cat` (
  `catID` int(20) NOT NULL AUTO_INCREMENT,
  `catName` varchar(40) NOT NULL,
  `catGrade` varchar(40) NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `Weightage1` int(3) NOT NULL,
  `Weightage2` int(3) NOT NULL,
  `Weightage3` int(3) NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`catID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_shift`
--

CREATE TABLE IF NOT EXISTS `h_shift` (
  `shiftID` int(11) NOT NULL AUTO_INCREMENT,
  `locationID` int(10) NOT NULL,
  `shiftName` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `detail` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL DEFAULT '1',
  `WorkingHourStart` varchar(6) NOT NULL,
  `WorkingHourEnd` varchar(6) NOT NULL,
  `SL_Coming` varchar(6) NOT NULL,
  `SL_Leaving` varchar(6) NOT NULL,
  `FlexTime` tinyint(1) NOT NULL,
  `LunchPunch` tinyint(1) NOT NULL,
  `LunchTime` varchar(6) NOT NULL,
  `ShortBreakPunch` tinyint(1) NOT NULL,
  `ShortBreakLimit` tinyint(1) NOT NULL,
  `ShortBreakTime` varchar(50) NOT NULL,
  `LunchPaid` tinyint(1) NOT NULL,
  `ShortBreakPaid` tinyint(1) NOT NULL,
  PRIMARY KEY (`shiftID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `h_review`
--

CREATE TABLE IF NOT EXISTS `h_review` (
  `reviewID` int(20) NOT NULL AUTO_INCREMENT,
  `EmpID` int(11) NOT NULL,
  `ReviewerID` int(11) NOT NULL,
  `FromDate` date NOT NULL,
  `ToDate` date NOT NULL,
  `Rating1` varchar(10) NOT NULL,
  `Rating2` varchar(10) NOT NULL,
  `Rating3` varchar(10) NOT NULL,
  `Comment` varchar(250) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `ReviewDate` date NOT NULL,
  `updatedDate` date NOT NULL,
  PRIMARY KEY (`reviewID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;


--
-- Table structure for table `location`
--

CREATE TABLE IF NOT EXISTS `location` (
  `locationID` int(11) NOT NULL AUTO_INCREMENT,
  `Address` varchar(250) COLLATE latin1_general_ci NOT NULL,
  `country_id` int(10) NOT NULL,
  `state_id` int(10) NOT NULL,
  `city_id` int(10) NOT NULL,
  `Country` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `State` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `City` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `ZipCode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `LeaveStart` date NOT NULL,
  `LeaveEnd` date NOT NULL,
  `Timezone` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `currency_id` int(10) NOT NULL,
  `WorkingHourStart` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `WorkingHourEnd` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `Overtime` tinyint(1) NOT NULL,
  `OvertimeFrom` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `OvertimeRate` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `HalfDayHour` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `FullDayHour` varchar(5) COLLATE latin1_general_ci NOT NULL,
  `MaxLeaveMonth` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `MaxShortLeave` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `WeekStart` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `WeekEnd` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `WeekEndOff` varchar(10) COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `SalaryDate` varchar(2) COLLATE latin1_general_ci NOT NULL,
  `LableLeave` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'L',
  `LableHalfDay` varchar(20) COLLATE latin1_general_ci NOT NULL DEFAULT 'HD',
  `Advance` tinyint(1) NOT NULL,
  `Loan` tinyint(1) NOT NULL,
  `Bonus` tinyint(1) NOT NULL,
  `SL_Coming` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `SL_Leaving` varchar(10) COLLATE latin1_general_ci NOT NULL,
  `SL_Deduct` tinyint(1) NOT NULL,
  `ExpenseClaim` tinyint(1) NOT NULL,
  `FlexTime` tinyint(1) NOT NULL,
  `ProbationTime` tinyint(1) NOT NULL,
  `LeaveApprovalCheck` tinyint(1) NOT NULL,
  `LunchPunch` tinyint(1) NOT NULL,
  `LunchTime` varchar(6) COLLATE latin1_general_ci NOT NULL,
  `ShortBreakPunch` tinyint(1) NOT NULL,
  `ShortBreakLimit` tinyint(1) NOT NULL,
  `ShortBreakTime` varchar(50) COLLATE latin1_general_ci NOT NULL,
  `UseShift` tinyint(1) NOT NULL,
  `LunchPaid` tinyint(1) NOT NULL,
  `ShortBreakPaid` tinyint(1) NOT NULL,
  PRIMARY KEY (`locationID`),
  KEY `country_id` (`country_id`),
  KEY `state_id` (`state_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `notifyID` bigint(20) NOT NULL AUTO_INCREMENT,
  `depID` int(11) NOT NULL,
  `locationID` int(10) NOT NULL,
  `refID` varchar(50) NOT NULL,
  `refType` varchar(50) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Message` text NOT NULL,
  `oldValue` varchar(30) NOT NULL,
  `newValue` varchar(30) NOT NULL,
  `AdminID` int(11) NOT NULL,
  `AdminType` varchar(15) NOT NULL,
  `CreatedBy` varchar(60) NOT NULL,
  `notifyDate` datetime NOT NULL,
  `Read` tinyint(1) NOT NULL,
  PRIMARY KEY (`notifyID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `UserID` int(20) NOT NULL,
  `ModuleID` int(10) NOT NULL,
  `ViewLabel` tinyint(1) NOT NULL,
  `ModifyLabel` tinyint(1) NOT NULL,
  `FullLabel` tinyint(1) NOT NULL,
  UNIQUE KEY `EmpID` (`UserID`,`ModuleID`),
  KEY `AdminID` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UserID` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserType` varchar(20) NOT NULL,
  `locationID` int(10) NOT NULL,
  `UserName` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `Role` varchar(30) NOT NULL,
  `Status` tinyint(1) NOT NULL,
  `UpdatedDate` datetime NOT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`,`UserType`),
  KEY `UserType` (`UserType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_block`
--

CREATE TABLE IF NOT EXISTS `user_block` (
  `blockID` bigint(20) NOT NULL AUTO_INCREMENT,
  `LoginTime` varchar(30) NOT NULL,
  `LoginIP` varchar(30) NOT NULL,
  PRIMARY KEY (`blockID`),
  KEY `LoginIP` (`LoginIP`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `loginID` bigint(20) NOT NULL AUTO_INCREMENT,
  `UserID` bigint(20) NOT NULL,
  `UserType` varchar(20) NOT NULL,
  `LoginTime` datetime NOT NULL,
  `LogoutTime` datetime NOT NULL,
  `LoginIP` varchar(30) NOT NULL,
  `Browser` varchar(50) NOT NULL,
  `Kicked` tinyint(1) NOT NULL,
  PRIMARY KEY (`loginID`),
  KEY `UserID` (`UserID`),
  KEY `UserType` (`UserType`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `user_login_page` (
  `pageID` bigint(20) NOT NULL AUTO_INCREMENT,
  `loginID` bigint(20) NOT NULL,
  `UserID` bigint(20) NOT NULL,
  `PageUrl` varchar(100) NOT NULL,
  `PageName` varchar(100) NOT NULL,
  `PageHeading` varchar(250) NOT NULL,
  `ViewTime` datetime NOT NULL,
  PRIMARY KEY (`pageID`),
  KEY `loginID` (`loginID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------
--
-- Dumping data for table `admin_modules`
--

INSERT INTO `admin_modules` (`ModuleID`, `Module`, `Link`, `depID`, `Parent`, `Default`, `Status`, `OrderBy`) VALUES
(1, 'Company Settings', '', 0, 0, 0, 1, 0),
(49, 'Manage Skill', 'viewAttribute.php?att=23', 0, 15, 0, 1, 3),
(3, 'Leave Management', '', 1, 0, 0, 1, 2),
(2, 'Employee', '', 1, 0, 0, 1, 1),
(50, 'Other Modules', '', 0, 0, 0, 0, 0),
(51, 'Edit Company Profile', 'editCompany.php', 0, 1, 0, 1, 0),
(52, 'Manage Employee', 'viewEmployee.php', 0, 2, 0, 1, 1),
(57, 'Dashboard Icon', 'mngDashboard.php', 0, 1, 0, 1, 0),
(54, 'Manage Countries', 'viewCountries.php', 0, 1, 0, 0, 0),
(55, 'Manage States', 'viewStates.php', 0, 1, 0, 0, 0),
(56, 'Manage Cities', 'viewCities.php', 0, 1, 0, 0, 0),
(53, 'Company Location', 'viewLocation.php', 0, 1, 0, 1, 0),
(58, 'My Leaves', 'myLeave.php', 0, 6, 1, 1, 0),
(59, 'My Timesheet', 'myTimesheet.php', 0, 7, 0, 0, 0),
(60, 'My Attendance', 'myAttendence.php', 0, 7, 0, 1, 0),
(61, 'Timesheet', 'viewTimesheet.php', 0, 5, 0, 0, 0),
(62, 'Attendance List', 'viewAttendence.php', 0, 5, 0, 1, 0),
(63, 'Job Type', 'viewAttribute.php?att=1', 0, 15, 0, 1, 0),
(64, 'Salary Frequency', 'viewAttribute.php?att=2', 0, 15, 0, 0, 0),
(65, 'Job Title', 'viewAttribute.php?att=11', 0, 15, 0, 1, 0),
(66, 'Manage Education', 'viewEducation.php', 0, 15, 0, 1, 0),
(68, 'Leave Type', 'viewAttribute.php?att=9', 0, 15, 0, 1, 0),
(67, 'Leave Period', 'leavePeriod.php', 0, 15, 0, 1, 0),
(73, 'Holidays', 'viewHoliday.php', 0, 3, 0, 1, 0),
(74, 'Leave Entitlement', 'viewEntitlement.php', 0, 3, 0, 1, 0),
(75, 'Manage Leave', 'viewLeave.php', 0, 3, 0, 1, 1),
(31, 'Leave Report', 'viewLeaveReport.php', 0, 30, 0, 1, 0),
(77, 'Manage Candidates', 'viewCandidate.php?module=Manage', 0, 4, 0, 1, 0),
(78, 'Leave Applied to Me', 'leaveApplied.php', 0, 6, 1, 1, 0),
(69, 'Manage Vacancies', 'viewVacancy.php', 0, 4, 0, 1, 0),
(70, 'Apply For Leave', 'applyLeave.php', 0, 6, 1, 1, 0),
(6, 'My Leaves', '', 1, 0, 1, 1, 0),
(4, 'Recruitment', '', 1, 0, 0, 1, 3),
(7, 'Time', '', 1, 0, 1, 1, 0),
(5, 'Time Management', '', 1, 0, 0, 1, 4),
(137, 'Calendar View', 'calender.php?module=calender', 0, 136, 0, 1, 0),
(134, 'Lead Industry', 'viewAttribute.php?att=51', 0, 115, 0, 1, 0),
(133, 'Manage Contact', 'viewContact.php?module=contact', 0, 107, 0, 1, 0),
(131, 'Sales Stage', 'viewAttribute.php?att=16', 0, 115, 0, 1, 0),
(130, 'Ticket Category', 'viewAttribute.php?att=15', 0, 115, 0, 1, 0),
(127, 'Manage Campaign', 'viewCampaign.php?module=Campaign', 0, 106, 0, 1, 0),
(126, 'Manage Document', 'viewDocument.php?module=Document', 0, 105, 0, 1, 0),
(124, 'Lead Source', 'viewAttribute.php?att=11', 0, 115, 0, 1, 0),
(10, 'Directory', '', 1, 0, 0, 1, 10),
(11, 'Announcements', '', 1, 0, 0, 1, 9),
(8, 'Performance', '', 1, 0, 0, 1, 6),
(71, 'Documents', 'viewDocument.php', 0, 11, 0, 1, 2),
(72, 'Announcements', 'viewNews.php', 0, 11, 0, 1, 1),
(12, 'Payroll', '', 1, 0, 0, 1, 5),
(79, 'Shortlisted Candidates', 'viewCandidate.php?module=Shortlisted', 0, 4, 0, 1, 0),
(136, 'Calendar', '', 5, 0, 0, 1, 7),
(123, 'Manage Ticket', 'viewTicket.php?module=Ticket', 0, 104, 0, 1, 0),
(122, 'Manage Opportunity ', 'viewOpportunity.php?module=Opportunity', 0, 103, 0, 1, 0),
(121, 'Manage Lead', 'viewLead.php?module=lead', 0, 102, 0, 1, 0),
(80, 'Offered Candidates', 'viewCandidate.php?module=Offered', 0, 4, 0, 1, 0),
(81, 'Interview Test', 'viewAttrib.php?att=12', 0, 4, 0, 1, 0),
(108, 'Quotes', '', 5, 0, 0, 1, 6),
(107, 'Contact', '', 5, 0, 0, 1, 5),
(106, 'Campaign', '', 5, 0, 0, 1, 9),
(105, 'Document', '', 5, 0, 0, 1, 8),
(104, 'Ticket', '', 5, 0, 0, 1, 4),
(103, 'Opportunity', '', 5, 0, 0, 1, 3),
(102, 'Lead', '', 5, 0, 0, 1, 2),
(82, 'Components', 'viewComponent.php', 0, 8, 0, 1, 0),
(83, 'Weightages', 'viewWeightage.php', 0, 8, 0, 1, 0),
(84, 'KRA', 'viewKra.php', 0, 8, 0, 1, 0),
(85, 'Reviews', 'viewReview.php', 0, 8, 0, 1, 0),
(86, 'Payroll Structure', 'viewPayStructure.php', 0, 12, 0, 1, 1),
(87, 'Employee Salary', 'viewSalary.php', 0, 12, 0, 1, 2),
(138, 'Manage Event / Task', 'viewActivity.php?module=Activity', 0, 136, 0, 1, 0),
(140, 'Lead Document', 'viewDocument.php?module=Lead', 0, 102, 0, 0, 0),
(141, 'Opportunity Document', 'viewDocument.php?module=Opportunity', 0, 103, 0, 0, 0),
(143, 'Campaign Type', 'viewAttribute.php?att=54', 0, 115, 0, 1, 0),
(144, 'Manage Quotes', 'viewQuote.php?module=Quote', 0, 108, 0, 1, 0),
(145, 'Ticket Document', 'viewDocument.php?module=Ticket', 0, 104, 0, 0, 0),
(146, 'Event Document', 'viewDocument.php?module=Event', 0, 136, 0, 0, 0),
(147, 'Expected Response', 'viewAttribute.php?att=55', 0, 115, 0, 1, 0),
(153, 'Activity Status', 'viewAttribute.php?att=18', 0, 115, 0, 1, 0),
(154, 'Activity Type', 'viewAttribute.php?att=19', 0, 115, 0, 1, 0),
(155, 'Manage Territory', 'viewTerritory.php', 0, 115, 0, 1, 0),
(156, 'Territory Rules', 'viewTerritoryRule.php', 0, 115, 0, 1, 0),
(157, 'Territory Customer Report', 'territoryCustomerReport.php', 0, 116, 0, 1, 0),
(158, 'Territory Lead Report', 'territoryLeadReport.php', 0, 116, 0, 1, 0),
(201, 'Products & Categories', '', 2, 0, 0, 1, 1),
(204, 'Settings', '', 2, 0, 0, 1, 5),
(205, 'Orders & Customers', '', 2, 0, 0, 1, 2),
(211, 'Manage Products', 'viewProduct.php', 0, 201, 0, 1, 0),
(212, 'Manage Categories', 'viewCategory.php', 0, 201, 0, 1, 0),
(213, 'Manage Manufacturers', 'viewManufacturer.php', 0, 201, 0, 1, 0),
(215, 'Store Settings', 'cartSetting.php?module=1', 0, 204, 0, 1, 0),
(216, 'Manage Shipping', 'viewShipping.php', 0, 202, 0, 1, 0),
(217, 'Manage Tax', 'viewTax.php', 0, 202, 0, 1, 0),
(218, 'Manage Tax Class', 'viewTaxClass.php', 0, 202, 0, 1, 0),
(219, 'Manage Orders', 'viewOrder.php', 0, 205, 0, 1, 0),
(220, 'Manage Customers', 'viewCustomer.php', 0, 205, 0, 1, 0),
(148, 'Document', 'viewDocument.php?module=Quote', 0, 108, 0, 0, 0),
(228, 'Manage Pages', 'viewPages.php', 0, 204, 0, 1, 0),
(206, 'Marketing', '', 2, 0, 0, 1, 7),
(221, 'Global Attributes', 'viewGlobalAttribute.php', 0, 201, 0, 1, 0),
(9, 'My Profile', '', 1, 0, 1, 1, 0),
(89, 'My Profile', 'myProfile.php', 0, 9, 0, 1, 0),
(90, 'Salary Details', 'mySalary.php', 0, 9, 0, 1, 0),
(91, 'My Declaration', 'myDeclaration.php', 0, 9, 0, 1, 0),
(92, 'Tax Declaration Form', 'taxDeclarationForm.php', 0, 12, 0, 1, 0),
(93, 'Employee Declaration', 'viewDeclaration.php', 0, 12, 0, 1, 0),
(13, 'Training', '', 1, 0, 0, 1, 7),
(94, 'Manage Training', 'viewTraining.php', 0, 13, 0, 1, 0),
(95, 'Manage Participants', 'viewParticipant.php', 0, 13, 0, 1, 0),
(88, 'Generated Salary', 'viewGeneratedSalary.php', 0, 12, 0, 1, 3),
(223, 'Manage Subscribers Email', 'viewSubscriber.php', 0, 206, 0, 1, 0),
(224, 'Manage Reviews', 'viewProductReview.php', 0, 201, 0, 1, 0),
(225, 'Send Newsletter', 'emailNewsletter.php', 0, 206, 0, 1, 0),
(226, 'Newsletter Templates', 'viewNewsletterTemplate.php', 0, 206, 0, 1, 0),
(227, 'Social Settings', 'cartSetting.php?module=2', 0, 204, 0, 1, 0),
(30, 'Report', '', 1, 0, 0, 1, 8),
(32, 'Employee Turn Over', 'viewEmpturnover.php', 0, 30, 0, 1, 0),
(33, 'Employee Exit Report', 'terminationReport.php', 0, 30, 0, 1, 0),
(34, 'Vacancy Succession Report', 'vacancyReport.php', 0, 30, 0, 1, 0),
(35, 'Employee Hiring Report', 'hiringReport.php', 0, 30, 0, 1, 0),
(37, 'Directory', 'viewDirectory.php', 0, 10, 0, 1, 0),
(202, 'Shipping & Taxes', '', 2, 0, 0, 1, 3),
(222, 'Bestseller Settings', 'cartSetting.php?module=3', 0, 204, 0, 1, 0),
(203, 'Payment Methods', '', 2, 0, 0, 1, 4),
(229, 'Manage Payment Methods', 'viewPayment.php', 0, 203, 0, 1, 0),
(230, 'Payment Method Configure', 'paymentConfigure.php', 0, 203, 0, 1, 0),
(207, 'Discounts & Coupon', '', 2, 0, 0, 1, 6),
(231, 'Global Discounts', 'viewDiscount.php', 0, 207, 0, 1, 0),
(232, 'Coupon Codes', 'viewCoupon.php', 0, 207, 0, 1, 0),
(15, 'Settings', '', 1, 0, 0, 1, 5),
(233, 'Customer Groups', 'viewCustomerGroup.php', 0, 205, 0, 1, 0),
(601, 'Item Master', '', 6, 0, 0, 1, 0),
(602, 'Stock Adjustments', '', 6, 0, 0, 1, 0),
(603, 'Stock Transfers', '', 6, 0, 0, 1, 0),
(604, 'BOM', '', 6, 0, 0, 1, 0),
(610, 'Settings', '', 6, 0, 0, 1, 0),
(628, 'Manage Items', 'viewItem.php', 0, 601, 0, 1, 0),
(629, 'Manage Unit', 'viewAttribute.php?att=11', 0, 610, 0, 1, 0),
(630, 'Tax Rate', 'viewTax.php', 0, 610, 0, 0, 0),
(631, 'Tax Class', 'viewTaxClass.php', 0, 610, 0, 0, 0),
(634, 'Manage Categories', 'viewCategory.php', 0, 601, 0, 1, 0),
(635, 'Item Type', 'viewAttribute.php?att=1', 0, 610, 0, 1, 0),
(636, 'Procurement', 'viewAttribute.php?att=2', 0, 610, 0, 1, 0),
(637, 'Valuation Type', 'viewAttribute.php?att=3', 0, 610, 0, 1, 0),
(638, 'Adjustments', 'viewAdjustment.php', 0, 602, 0, 1, 0),
(639, 'Adjustment Reason', 'viewAttribute.php?att=13', 0, 610, 0, 1, 0),
(640, 'Manage Stock Transfer', 'viewTransfer.php', 0, 603, 0, 1, 0),
(641, 'Manage BOM', 'viewBOM.php', 0, 604, 0, 1, 0),
(642, 'Manage Prefixes', 'editPrefixes.php', 0, 610, 0, 1, 0),
(648, 'Manage Model', 'viewModel.php', 0, 610, 0, 1, 0),
(649, 'Manage Generation', 'viewAttribute.php?att=5', 0, 610, 0, 1, 0),
(650, 'Manage Extended', 'viewAttribute.php?att=7', 0, 610, 0, 1, 0),
(651, 'Manage Manufacture', 'viewAttribute.php?att=8', 0, 610, 0, 1, 0),
(652, 'Manage Condition', 'viewAttribute.php?att=6', 0, 610, 0, 1, 0),
(653, 'Reorder Method', 'viewAttribute.php?att=9', 0, 610, 0, 1, 0),
(654, 'Stock Search', 'searchItemStock.php', 0, 601, 0, 1, 0),
(655, 'Manage Disassembly', 'viewDisassembly.php', 0, 604, 0, 1, 0),
(403, 'Purchase Order', '', 4, 0, 0, 1, 3),
(404, 'Invoices', '', 4, 0, 0, 0, 4),
(405, 'Returns', '', 4, 0, 0, 1, 5),
(407, 'Credit Note', '', 4, 0, 0, 0, 0),
(409, 'Report', '', 4, 0, 0, 1, 0),
(410, 'Settings', '', 4, 0, 0, 0, 0),
(411, 'Purchase Quote', 'viewPO.php?module=Quote', 0, 402, 0, 1, 0),
(413, 'Purchase Order', 'viewPO.php?module=Order', 0, 403, 0, 1, 0),
(414, 'Invoices', 'viewPoInvoice.php', 0, 404, 0, 1, 0),
(415, 'Manage Vendor', 'viewSupplier.php', 0, 401, 0, 1, 0),
(416, 'Vendor Purchases', 'viewSuppPO.php', 0, 401, 0, 1, 0),
(417, 'Vendor Invoices', 'viewSuppInvoice.php', 0, 401, 0, 1, 0),
(418, 'Returns', 'viewReturn.php', 0, 405, 0, 1, 0),
(419, 'Vendor Returns', 'viewSuppReturn.php', 0, 401, 0, 1, 0),
(420, 'Credit Note', 'viewPoCreditNote.php', 0, 407, 0, 1, 0),
(421, 'Vendor Price List', 'viewSuppPrice.php', 0, 401, 0, 1, 0),
(430, 'Customize Fields', 'customizeField.php', 0, 410, 0, 0, 0),
(431, 'Payment Method', 'viewAttrib.php?att=1', 0, 410, 0, 0, 0),
(76, 'Manage Department', 'viewDepartment.php', 0, 15, 0, 1, 2),
(718, 'Customer Order', 'viewCustomerOrderInvoice.php?module=Order', 0, 701, 0, 1, 0),
(717, 'Sales Order', 'viewSalesQuoteOrder.php?module=Order', 0, 703, 0, 1, 0),
(716, 'Shipping Method', 'viewAttrib.php?att=2', 0, 710, 0, 0, 0),
(715, 'Payment Term', 'viewTerm.php', 0, 710, 0, 0, 0),
(714, 'Payment Method', 'viewAttrib.php?att=1', 0, 710, 0, 0, 0),
(713, 'Sales Quote', 'viewSalesQuoteOrder.php?module=Quote', 0, 702, 0, 1, 0),
(432, 'Payment Term', 'viewTerm.php', 0, 410, 0, 0, 0),
(433, 'Shipping Method', 'viewAttrib.php?att=2', 0, 410, 0, 0, 0),
(441, 'PO Report', 'viewPoReport.php', 0, 409, 0, 1, 0),
(442, 'Invoice Report', 'viewInvReport.php', 0, 409, 0, 0, 0),
(719, 'Customer Invoice', 'viewCustomerOrderInvoice.php?module=Invoice', 0, 701, 0, 1, 0),
(720, 'Invoices', 'viewInvoice.php', 0, 704, 0, 1, 0),
(721, 'Returns', 'viewReturn.php', 0, 705, 0, 1, 0),
(643, 'Price List', 'viewPriceList.php', 0, 601, 0, 1, 0),
(644, 'Serial Number List', 'viewSerial.php', 0, 601, 0, 1, 0),
(402, 'Purchase Quote', '', 4, 0, 0, 1, 2),
(401, 'Vendor', '', 4, 0, 0, 0, 1),
(443, 'Payment History', 'viewPaymentReport.php', 0, 409, 0, 0, 0),
(722, 'Customer Return', 'viewCustomerReturn.php?module=Return', 0, 701, 0, 1, 0),
(723, 'Sales by Customer', 'viewSalesbyCustomer.php', 0, 706, 0, 1, 0),
(724, 'Sales by Sales Person', 'viewSalesbySalesPerson.php', 0, 706, 0, 1, 0),
(725, 'Sales Statistics', 'viewSalesStatistics.php', 0, 706, 0, 0, 0),
(712, 'Manage Customer', 'viewCustomer.php', 0, 701, 0, 1, 2),
(710, 'Settings', '', 7, 0, 0, 0, 0),
(706, 'Reports', '', 7, 0, 0, 1, 0),
(705, 'Returns', '', 7, 0, 0, 1, 0),
(704, 'Invoices', '', 7, 0, 0, 0, 0),
(703, 'Sales Order', '', 7, 0, 0, 1, 0),
(702, 'Sales Quote', '', 7, 0, 0, 1, 0),
(701, 'Customer', '', 7, 0, 0, 0, 1),
(707, 'Credit Note', '', 7, 0, 0, 0, 0),
(726, 'Credit Note', 'viewCreditNote.php', 0, 707, 0, 1, 0),
(727, 'Payment History', 'viewPayReport.php', 0, 706, 0, 0, 0),
(645, 'Manage Assembly', 'viewAssemble.php', 0, 604, 0, 1, 0),
(605, 'Report', '', 6, 0, 0, 1, 0),
(646, 'Stock Transfer Report', 'viewTransferReport.php', 0, 605, 0, 1, 0),
(647, 'Stock Adjustment Report', 'viewAdjReport.php', 0, 605, 0, 1, 0),
(324, 'Stock Transfer', 'viewStockTransfer.php', 0, 302, 0, 0, 0),
(323, ' Sales Return ', 'viewSalesReturn.php', 0, 302, 0, 1, 0),
(322, 'PO Receipt Invoices', 'viewPoInvoice.php', 0, 302, 0, 1, 0),
(321, 'Manage Bin', 'viewManageBin.php', 0, 301, 0, 1, 0),
(320, 'Manage Warehouse', 'viewWarehouse.php', 0, 301, 0, 1, 0),
(306, 'Settings', '', 3, 0, 0, 1, 0),
(305, 'Transportation', '', 3, 0, 0, 0, 0),
(304, 'Outbound Order', '', 3, 0, 0, 1, 0),
(303, 'Internal Order', '', 3, 0, 0, 0, 0),
(302, 'Inbound Order', '', 3, 0, 0, 1, 0),
(301, 'Warehouse', '', 3, 0, 0, 1, 0),
(325, 'Manage Transport', 'viewAttrib.php?att=1', 0, 306, 0, 1, 1),
(326, 'Package Type', 'viewAttrib.php?att=2', 0, 306, 0, 1, 0),
(327, 'Manage Charge', 'viewAttrib.php?att=3', 0, 306, 0, 1, 0),
(328, 'Manage Paid', 'viewAttrib.php?att=4', 0, 306, 0, 1, 0),
(329, 'Stock Adjustment', 'viewStockAdjustment.php', 0, 302, 0, 0, 0),
(330, 'Manage Cargo', 'viewCargo.php', 0, 305, 0, 1, 1),
(331, 'Assemble Order', 'viewProduction.php', 0, 303, 0, 1, 0),
(332, 'Shipment', 'viewShipment.php', 0, 304, 0, 1, 0),
(115, 'Settings', '', 5, 0, 0, 1, 10),
(116, 'Report', '', 5, 0, 0, 1, 0),
(149, 'Lead Report', 'viewLeadReport.php', 0, 116, 0, 1, 0),
(1004, 'Loan', 'myLoan.php', 0, 9, 0, 1, 0),
(1005, 'Global Settings', 'globalSetting.php', 0, 15, 0, 1, 1),
(1006, 'Overtime', 'viewOvertime.php', 0, 5, 0, 1, 0),
(1003, 'Advance', 'myAdvance.php', 0, 9, 0, 1, 0),
(1002, 'Loan', 'viewLoan.php', 0, 12, 0, 1, 0),
(1001, 'Advance', 'viewAdvance.php', 0, 12, 0, 1, 0),
(1007, 'Bonus', 'viewBonus.php', 0, 12, 0, 1, 0),
(1008, 'Short Leave', 'viewShortLeave.php', 0, 3, 0, 0, 0),
(1009, 'Send Request', 'sendRequest.php', 0, 9, 0, 0, 0),
(1010, 'Employee Request', 'viewRequest.php', 0, 11, 0, 0, 0),
(1011, 'Comp-Off', 'viewComp.php', 0, 3, 0, 0, 0),
(1012, 'Compensation', 'myComp.php', 0, 6, 0, 0, 0),
(1013, 'Comp-Off Applied to Me', 'compApplied.php', 0, 6, 0, 0, 0),
(1015, 'Email Template', 'email_template.php', 0, 15, 0, 0, 0),
(1014, 'Events', 'viewEvent.php', 0, 11, 0, 0, 0),
(96, 'Manage Assets', 'viewAsset.php', 0, 14, 0, 1, 1),
(97, 'Manage Brand', 'viewAttrib.php?att=24', 0, 14, 0, 0, 0),
(98, 'Manage Category', 'viewAttrib.php?att=25', 0, 14, 0, 0, 0),
(99, 'Manage Vendor', 'viewVendor.php', 0, 14, 0, 0, 0),
(100, 'Assigned Assets', 'viewAssignAsset.php', 0, 14, 0, 1, 2),
(14, 'Assets', '', 1, 0, 0, 1, 0),
(1017, 'Attrition Report', 'attritionReport.php', 0, 30, 0, 0, 0),
(1018, 'Work Shift', 'viewShift.php', 0, 15, 0, 1, 2),
(1019, 'Expense Claim', 'viewExpenseClaim.php', 0, 12, 0, 0, 0),
(1020, 'Expense Claim', 'myExpenseClaim.php', 0, 9, 1, 0, 0),--
-- Table structure for table `meeting_join`
--

CREATE TABLE IF NOT EXISTS `meeting_join` (
`id` int(100) NOT NULL,
  `meetingId` varchar(200) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `MType` tinyint(2) NOT NULL,
  `createTime` datetime NOT NULL,
  `userId` varchar(200) NOT NULL,
  `JoinStatus` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;

(1021, 'Appraisal', 'viewAppraisal.php', 0, 12, 0, 0, 4),
(333, 'Ship Transfer Order', 'viewTransferOrder.php', 0, 304, 0, 0, 0),
(334, 'PO Return Order', 'viewReturn.php', 0, 304, 0, 1, 0),
(335, 'Released Production Orders', 'viewProductionOrder.php', 0, 304, 0, 0, 0),
(336, 'Manage Shipping', 'viewShipOrder.php', 0, 304, 0, 0, 0),
(337, 'Shipping Method', 'viewAttrib.php?att=6', 0, 306, 0, 1, 0),
(338, 'Pick & Put Qty', 'viewInternalBinOrder.php', 0, 303, 0, 1, 0),
(2001, 'Users', '', 5, 0, 0, 0, 0),
(2002, 'Manage Users', 'viewUser.php', 0, 2001, 0, 1, 0),
(2003, 'Item Master', '', 5, 0, 0, 0, 0),
(2004, 'Manage Items', 'viewItem.php', 0, 2003, 0, 1, 0),
(2005, 'Users', '', 6, 0, 0, 0, 0),
(2006, 'Manage Users', 'viewUser.php', 0, 2005, 0, 1, 0),
(151, 'Manage Group', 'viewGroup.php', 0, 115, 0, 1, 1),
(152, 'Email Template', 'email_template.php', 0, 115, 0, 1, 0),
('728', 'Sales Commission Report', 'viewSalesCommReport.php', '0', '706', '0', '0', '0'),
(729, 'Sales by Territory ', 'salesTerritory.php', 0, 706, 0, 1, 0),
(2007, 'Sales Commission Tier', 'viewTier.php', 0, 15, 0, 1, 0),
(2008, 'Sales Commission Tier', 'viewTier.php', 0, 115, 0, 0, 0),
(2009, 'Sales Commission Tier', 'viewTier.php', 0, 610, 0, 0, 0),
(2010, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 15, 0, 1, 0),
(2011, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 115, 0, 0, 0),
(2012, 'Sales Person Spiff Tier', 'viewSpiffTier.php', 0, 610, 0, 0, 0),
(2015, 'Customer', '', 5, 0, 0, 1, 0),
(2016, 'Manage Customer', 'viewCustomer.php', 0, 2015, 0, 1, 0),
(801, 'Chart of Accounts', '', 8, 0, 0, 1, 0),
(802, 'AR', '', 8, 0, 0, 1, 0),
(803, 'AP', '', 8, 0, 0, 1, 0),
(804, 'Journal Entry', '', 8, 0, 0, 1, 0),
(805, 'Reports', '', 8, 0, 0, 1, 0),
(810, 'Settings', '', 8, 0, 0, 1, 0),
(816, 'Chart of Accounts', 'viewAccount.php', 0, 801, 0, 1, 0),
(817, 'Cash Receipt', 'viewSalesPayments.php', 0, 802, 0, 1, 0),
(818, 'Payment Method', 'viewAttrib.php?att=1', 0, 810, 0, 1, 0),
(819, 'Manage Tax', 'viewTax.php', 0, 810, 0, 1, 0),
(820, 'Global Setting', 'globalSetting.php', 0, 810, 0, 1, 1),
(821, 'Tax Class', 'viewTaxClass.php', 0, 810, 0, 1, 0),
(822, 'Manage Account Types', 'viewAccountType.php', 0, 801, 0, 1, 0),
(823, 'General Journal', 'viewGeneralJournal.php', 0, 804, 0, 1, 0),
(824, 'Other Income', 'viewOtherIncome.php', 0, 802, 0, 0, 0),
(825, 'Payments', 'viewPurchasePayments.php', 0, 803, 0, 1, 0),
(826, 'Invoice Entry', 'viewOtherExpense.php', 0, 803, 0, 0, 0),
(827, 'Transfer', 'viewTransfer.php', 0, 804, 0, 1, 0),
(828, 'Bank Deposit', 'viewDeposit.php', 0, 804, 0, 1, 0),
(829, 'Profit and Loss', 'reportProfitLoss.php', 0, 805, 0, 1, 0),
(830, 'Balance Sheet', 'reportBalanceSheet.php', 0, 805, 0, 0, 0),
(831, 'Period End', 'periodEndSetting.php', 0, 801, 0, 1, 0),
(832, 'Customer Tax', 'viewSalesTaxReport.php', 0, 805, 0, 1, 0),
(833, 'Vendor Tax', 'viewPurchaseTaxReport.php', 0, 805, 0, 1, 0),
(834, 'AR Aging', 'arAging.php', 0, 805, 0, 1, 0),
(835, 'AP Aging', 'apAging.php', 0, 805, 0, 1, 0),
(836, 'Bank Reconciliation', 'bankReconciliation.php', 0, 801, 0, 1, 0),
(837, 'Spiff Setting', 'spiffSetting.php', 0, 810, 0, 1, 2),
(860, 'Manage Customer', 'viewCustomer.php', 0, 802, 0, 1, 0),
(861, 'Customer Order', 'viewCustomerOrderInvoice.php?module=Order', 0, 802, 0, 1, 0),
(862, 'Customer Invoice', 'viewCustomerOrderInvoice.php?module=Invoice', 0, 802, 0, 1, 0),
(863, 'Customer Return', 'viewCustomerReturn.php?module=Return', 0, 802, 0, 1, 0),
(865, 'Invoices', 'viewInvoice.php', 0, 802, 0, 1, 0),
(866, 'Credit Note', 'viewCreditNote.php', 0, 802, 0, 1, 0),
(870, 'Manage Vendor', 'viewSupplier.php', 0, 803, 0, 1, 0),
(871, 'Vendor Purchases', 'viewSuppPO.php', 0, 803, 0, 1, 0),
(872, 'Vendor Invoices', 'viewSuppInvoice.php', 0, 803, 0, 1, 0),
(873, 'Vendor Returns', 'viewSuppReturn.php', 0, 803, 0, 1, 0),
(874, 'Vendor Price List', 'viewSuppPrice.php', 0, 803, 0, 1, 0),
(880, 'Invoices', 'viewPoInvoice.php', 0, 803, 0, 1, 0),
(881, 'Credit Note', 'viewPoCreditNote.php', 0, 803, 0, 1, 0),
(882, 'Invoice Report', 'viewInvReport.php', 0, 803, 0, 1, 0),
(883, 'Payment History', 'viewPaymentReport.php', 0, 803, 0, 1, 0),
(885, 'Payment Term', 'viewTerm.php', 0, 810, 0, 1, 0),
(886, 'Sales Statistics', 'viewSalesStatistics.php', 0, 802, 0, 1, 0),
(887, 'Payment History', 'viewPayReport.php', 0, 802, 0, 1, 0),
(888, 'Sales Commission Report', 'viewSalesCommReport.php', 0, 802, 0, 1, 0),
(150, 'Activity Document', 'viewDocument.php?module=Activity', 0, 136, 0, 0, 0),
(170, 'Recurring Event / Task', 'viewRecurringActivity.php', 0, 136, 0, 1, 0),
(171, 'Recurring Quotes', 'viewRecurringQuote.php', 0, 108, 0, 1, 0),
(175, 'Create Lead Form', 'leadForm.php', 0, 102, 0, 1, 0),
(731, 'Recurring', '', 7, 0, 0, 1, 0),
(732, 'Recurring Order', 'viewRecurringSO.php?module=Order', 0, 731, 0, 1, 0),
(733, 'Recurring Quote', 'viewRecurringSO.php?module=Quote', 0, 731, 0, 1, 0),
(890, 'Recurring Invoices', 'viewRecurringInvoice.php', 0, 802, 0, 1, 0),
(1050, 'User Log', 'viewUserLog.php', 0, 1, 0, 1, 0),
('2017', 'Leave Approval Check', 'viewLeaveCheck.php', '0', '15', '0', '0', '0'),
('2018', 'Benefits', 'viewBenefit.php', '0', '15', '0', '1', '0'),
('2019', 'Benefits', 'myBenefit.php', '0', '9', '0', '1', '0');


--
-- Dumping data for table `configuration`
--

INSERT INTO `configuration` (`ConfigID`, `RecordsPerPage`, `Tax`, `Shipping`, `PaypalID`, `MetaKeywords`, `MetaDescription`) VALUES
(1, 20, 0.00, 0.00, 'test@gmail.com', '', '');

--
-- Dumping data for table `custom_field`
--

INSERT INTO `custom_field` (`FieldID`, `locationID`, `depID`, `FieldTitle`, `FieldName`, `FieldInfo`, `Module`, `Tab`, `Parent`, `Status`, `OrderBy`) VALUES
(1, 1, 4, 'Tax Number', 'TaxNumber', 'VAT Number', 'Vendor', '', 0, 0, 0);

--
-- Dumping data for table `c_attribute`
--

INSERT INTO `c_attribute` (`attribute_id`, `attribute_name`, `attribute`) VALUES
(11, 'LeadSource', 'Lead Source'),
(12, 'LeadStatus', 'Lead Status'),
(13, 'TicketStatus', 'Ticket Status'),
(14, 'Priority', 'Priority'),
(15, 'TicketCategory', 'Ticket Category'),
(16, 'SalesStage', 'Sales Stage'),
(17, 'Type', 'Type'),
(18, 'ActivityStatus', 'Activity Status'),
(19, 'ActivityType', 'Activity Type'),
(51, 'LeadIndustry', 'Lead Industry'),
(52, 'LeadRating', 'Lead Rating'),
(53, 'campaignstatus', 'Campaign Status'),
(54, 'campaigntype', 'Campaign Type'),
(55, 'expectedresponse', 'Expected Response');

--
-- Dumping data for table `c_attribute_value`
--

INSERT INTO `c_attribute_value` (`value_id`, `attribute_value`, `attribute_id`, `Status`, `locationID`) VALUES
(80, 'Pending', 10, 1, 0),
(81, 'Approved', 10, 1, 0),
(82, 'Taken', 10, 1, 0),
(83, 'Rejected', 10, 1, 0),
(84, 'Cold call', 11, 1, 0),
(86, 'Hot', 12, 1, 0),
(91, 'Entertainment', 18, 1, 1),
(92, 'Task', 19, 1, 1),
(94, 'Open', 13, 1, 1),
(95, 'In progress', 13, 1, 1),
(96, 'Wait for Response', 13, 1, 1),
(97, 'Low', 14, 1, 1),
(98, 'Normal', 14, 1, 1),
(99, 'High', 14, 1, 1),
(100, 'Urgent', 14, 1, 1),
(101, 'Big Problem', 15, 1, 1),
(102, 'Small Problem', 15, 1, 1),
(103, 'Other Problem', 15, 1, 1),
(104, 'Cold', 12, 1, 2),
(105, 'Warm', 12, 1, 2),
(106, 'Conference', 54, 1, 1),
(107, 'Webinar', 54, 0, 1),
(108, 'Trade Show', 54, 1, 1),
(109, 'Public Relations', 54, 1, 1),
(110, 'Partners', 54, 1, 1),
(111, 'Referral Program', 54, 1, 1),
(112, 'Advertisement', 54, 1, 1),
(113, 'Banner Ads', 54, 1, 1),
(114, 'Direct Mail', 54, 1, 1),
(115, 'Email', 54, 1, 1),
(116, 'Telemarketing', 54, 1, 1),
(117, 'Others', 54, 1, 1),
(118, 'Planning', 53, 1, 1),
(119, 'Active', 53, 1, 1),
(120, 'Inactive', 53, 1, 1),
(121, 'Completed', 53, 1, 1),
(122, 'Cancelled', 53, 1, 1),
(123, 'Excellent', 55, 1, 1),
(124, 'Good', 55, 1, 1),
(125, 'Average', 55, 1, 1),
(126, 'Poor', 55, 1, 1),
(135, 'IT', 51, 1, 1),
(136, 'Bakery & biscuit manufacturer', 51, 0, 1),
(163, 'Retail', 51, 1, 2),
(165, 'Word of Mouth', 11, 1, 1),
(166, 'Website', 11, 1, 1),
(167, 'Tradeshow', 11, 1, 1),
(168, 'Conference', 11, 1, 1),
(169, 'Direct Mail', 11, 1, 1),
(170, 'Public Relation', 11, 1, 1),
(171, 'Partner', 11, 1, 1),
(172, 'Employee', 11, 1, 1),
(173, 'Other', 11, 1, 1),
(174, 'Contacted', 12, 1, 1),
(175, 'Contact in Future', 12, 1, 1),
(176, 'Junk Lead', 12, 1, 1),
(177, 'Lost Lead', 12, 1, 1),
(178, 'Not Contacted', 12, 1, 1),
(179, 'Attempted to Contact', 12, 1, 1),
(180, 'Hospitality', 51, 1, 1),
(181, 'Insurance', 51, 1, 1),
(182, 'Media', 51, 1, 1),
(183, 'Telecommunication', 51, 1, 1),
(184, 'Other', 51, 1, 1),
(185, 'Prospecting', 16, 1, 1),
(186, 'Closed Won', 16, 1, 1),
(187, 'Negotiation or Review', 16, 1, 1),
(188, 'Proposal Or Price Quote', 16, 1, 1),
(189, 'Identify decision maker', 16, 1, 1),
(190, 'Qualification', 16, 1, 1),
(191, 'Closed Lost', 16, 1, 1),
(192, 'Existing Business', 17, 1, 1),
(193, 'New Business', 17, 1, 1),
(194, 'Closed', 13, 1, 1),
(196, 'Planned', 18, 1, 1),
(197, 'Held', 18, 1, 1),
(198, 'Not Held', 18, 1, 1),
(199, 'Call', 19, 1, 1),
(200, 'Meeting', 19, 1, 1);
--
-- Dumping data for table `dashboard_icon`
--

INSERT INTO `dashboard_icon` (`IconID`, `Module`, `Link`, `ModuleID`, `EditPage`, `IframeFancy`, `depID`, `Display`, `Status`, `OrderBy`, `IconType`, `Default`) VALUES
(1, 'Employee', 'viewEmployee.php', 2, 0, '', 1, 1, 1, 1, 2, 0),
(21, 'My Leaves', 'myLeave.php', 3, 0, '', 1, 1, 1, 21, 3, 1),
(11, 'My Timesheet', 'myTimesheet.php', 5, 0, '', 1, 1, 0, 11, 4, 1),
(13, 'My Attendance', 'myAttendence.php', 5, 0, '', 1, 1, 1, 13, 4, 1),
(2, 'Add Employee', 'editEmployee.php', 2, 1, '', 1, 1, 1, 2, 0, 0),
(12, 'Attendance', 'viewAttendence.php', 5, 0, '', 1, 1, 1, 12, 4, 0),
(98, 'Holidays', '#holiday_div', 3, 0, 'f', 1, 1, 1, 0, 3, 1),
(10, 'Timesheet', 'viewTimesheet.php', 5, 0, '', 1, 1, 0, 10, 4, 0),
(4, 'Manage Leave', 'viewLeave.php', 3, 0, '', 1, 1, 1, 4, 5, 0),
(16, 'KRA', 'viewKra.php', 8, 0, '', 1, 1, 1, 16, 5, 0),
(3, 'Apply For Leave', 'applyLeave.php', 3, 0, '', 1, 1, 1, 3, 1, 1),
(116, 'Add Task', 'editActivity.php?module=Activity&mode=Task', 136, 1, '', 5, 0, 0, 16, 0, 0),
(115, 'Add Event', 'editActivity.php?module=Activity&mode=Event', 136, 1, '', 5, 0, 0, 15, 0, 0),
(114, 'Events / Tasks', 'viewActivity.php?module=Activity', 136, 0, '', 5, 1, 1, 14, 4, 0),
(113, 'Calendar', 'calender.php?module=calender', 136, 0, '', 5, 1, 1, 13, 3, 0),
(112, 'Add Quote', 'editQuote.php?module=Quote', 108, 1, '', 5, 1, 1, 12, 0, 0),
(111, 'Quotes', 'viewQuote.php?module=Quote', 108, 0, '', 5, 1, 1, 11, 5, 0),
(110, 'Add Campaign', 'editCampaign.php?module=Campaign', 106, 1, '', 5, 1, 1, 10, 0, 0),
(109, 'Campaign', 'viewCampaign.php?module=Campaign', 106, 0, '', 5, 1, 1, 9, 3, 0),
(108, 'Add Document', 'editDocument.php?module=Document', 105, 1, '', 5, 1, 1, 8, 0, 0),
(107, 'Documents', 'viewDocument.php?module=Document', 105, 0, '', 5, 1, 1, 7, 5, 0),
(106, 'Add Ticket', 'editTicket.php?module=Ticket', 104, 1, '', 5, 1, 1, 6, 0, 0),
(105, 'Tickets', 'viewTicket.php?module=Ticket', 104, 0, '', 5, 1, 1, 5, 5, 0),
(104, 'Add Opportunity', 'editOpportunity.php?module=Opportunity', 103, 1, '', 5, 1, 1, 4, 0, 0),
(5, 'Assign Leave', 'assignLeave.php', 3, 1, '', 1, 1, 1, 5, 1, 0),
(15, 'Generate Salary', 'generateSalary.php', 12, 1, '', 1, 1, 1, 15, 1, 0),
(103, 'Opportunities', 'viewOpportunity.php?module=Opportunity', 103, 0, '', 5, 1, 1, 3, 5, 0),
(102, 'Add Lead', 'editLead.php?module=lead', 102, 1, '', 5, 1, 1, 2, 0, 0),
(101, 'Lead', 'viewLead.php?module=lead', 102, 0, '', 5, 1, 1, 1, 5, 0),
(18, 'Training', 'viewTraining.php', 13, 0, '', 1, 1, 1, 18, 5, 0),
(210, 'Add Product', 'editProduct.php', 201, 1, '', 2, 1, 1, 1, 0, 0),
(201, 'Products', 'viewProduct.php', 201, 0, '', 2, 1, 1, 1, 5, 0),
(202, 'Categories', 'viewCategory.php', 201, 0, '', 2, 1, 1, 2, 5, 0),
(206, 'Manufacturers', 'viewManufacturer.php', 201, 0, '', 2, 1, 1, 6, 5, 0),
(203, 'Store Settings', 'cartSetting.php?module=1', 204, 0, '', 2, 1, 1, 3, 1, 0),
(207, 'Send Newsletter', 'emailNewsletter.php', 206, 1, '', 2, 1, 1, 7, 1, 0),
(208, 'Manage Pages', 'viewPages.php', 204, 0, '', 2, 1, 1, 8, 5, 0),
(209, 'Tax Class', 'viewTaxClass.php', 202, 0, '', 2, 1, 1, 0, 1, 0),
(204, 'Orders', 'viewOrder.php', 205, 0, '', 2, 1, 1, 4, 3, 0),
(205, 'Customers', 'viewCustomer.php', 205, 0, '', 2, 1, 1, 5, 2, 0),
(14, 'Payroll', 'viewSalary.php', 12, 0, '', 1, 1, 1, 14, 3, 0),
(22, 'My Profile', 'myProfile.php', 2, 0, '', 1, 1, 1, 22, 2, 1),
(17, 'Review', 'viewReview.php', 8, 0, '', 1, 1, 1, 17, 3, 0),
(23, 'My Declaration', 'myDeclaration.php', 12, 0, '', 1, 1, 1, 23, 1, 1),
(9, 'Add Candidate', 'editCandidate.php?module=Manage', 4, 1, '', 1, 1, 1, 9, 0, 0),
(8, 'Candidates', 'viewCandidate.php?module=Manage', 4, 0, '', 1, 1, 1, 8, 2, 0),
(7, 'Add Vacancy', 'editVacancy.php', 4, 1, '', 1, 1, 1, 7, 0, 0),
(6, 'Vacancies', 'viewVacancy.php', 4, 0, '', 1, 1, 1, 6, 5, 0),
(97, 'Directory', 'viewDirectory.php?pop=1', 10, 0, 'i', 1, 1, 1, 0, 3, 0),
(99, 'Punch In/Out', 'punching.php', 5, 0, 'i', 1, 1, 1, 0, 4, 1),
(24, 'Report', 'viewLeaveReport.php', 30, 0, '', 1, 1, 1, 24, 3, 0),
(301, 'Warehouse', 'viewWarehouse.php', 301, 0, '', 3, 1, 1, 1, 0, 0),
(303, 'Bin', 'viewManageBin.php', 301, 0, '', 3, 1, 1, 2, 3, 0),
(307, 'Assemble Order', 'viewProduction.php', 303, 0, '', 3, 1, 1, 6, 0, 0),
(309, 'Pick & Put Qty', 'viewInternalBinOrder.php', 303, 0, '', 3, 1, 1, 7, 0, 0),
(311, 'Cargo', 'viewCargo.php', 305, 0, '', 3, 1, 1, 10, 0, 0),
(313, 'Ship Sales Order', 'viewShipment.php', 302, 0, '', 3, 1, 1, 4, 4, 0),
(314, 'Receive PO', 'viewPoInvoice.php', 302, 0, '', 3, 1, 1, 3, 3, 0),
(401, 'Vendor', 'viewSupplier.php', 401, 0, '', 4, 1, 1, 0, 2, 0),
(402, 'Add Vendor', 'editSupplier.php', 401, 1, '', 4, 1, 1, 0, 0, 0),
(403, 'Purchase Quote', 'viewPO.php?module=Quote', 402, 0, '', 4, 1, 1, 0, 2, 0),
(404, 'Add Quote', 'editPO.php?module=Quote', 402, 1, '', 4, 1, 1, 0, 0, 0),
(405, 'Purchase Order', 'viewPO.php?module=Order', 403, 0, '', 4, 1, 1, 0, 2, 0),
(406, 'Add PO', 'editPO.php?module=Order', 403, 1, '', 4, 1, 1, 0, 0, 0),
(407, 'Invoices', 'viewPoInvoice.php', 404, 0, '', 4, 1, 1, 0, 2, 0),
(408, 'Receive Order', 'PoList.php?link=recieveOrder.php', 404, 1, 'i', 4, 1, 1, 0, 0, 0),
(409, 'Returns', 'viewReturn.php', 405, 0, '', 4, 1, 1, 0, 2, 0),
(410, 'Add Return', 'PoList.php?link=editReturn.php', 405, 1, 'i', 4, 1, 1, 0, 0, 0),
(411, 'Credit Note', 'viewPoCreditNote.php', 407, 0, '', 4, 1, 1, 0, 2, 0),
(412, 'Add Credit Note', 'editPoCreditNote.php', 407, 1, '', 4, 1, 1, 0, 0, 0),
(413, 'PO Report', 'viewPoReport.php', 409, 0, '', 4, 1, 1, 0, 2, 0),
(414, 'Invoice Report', 'viewInvReport.php', 409, 0, '', 4, 1, 0, 0, 0, 0),
(415, 'Payment History', 'viewPayReport.php', 409, 0, '', 4, 1, 0, 0, 2, 0),
(701, 'Customer', 'viewCustomer.php', 701, 0, '', 7, 1, 1, 0, 2, 0),
(702, 'Add Customer', 'addCustomer.php', 701, 1, '', 7, 1, 1, 0, 0, 0),
(703, 'Sales Quote', 'viewSalesQuoteOrder.php?module=Quote', 702, 0, '', 7, 1, 1, 0, 2, 0),
(704, 'Add Quote', 'editSalesQuoteOrder.php?module=Quote', 702, 1, '', 7, 1, 1, 0, 0, 0),
(705, 'Sales Order', 'viewSalesQuoteOrder.php?module=Order', 703, 0, '', 7, 1, 1, 0, 2, 0),
(706, 'Add SO', 'editSalesQuoteOrder.php?module=Order', 703, 1, '', 7, 1, 1, 0, 0, 0),
(707, 'Invoices', 'viewInvoice.php', 704, 0, '', 7, 1, 1, 0, 2, 0),
(709, 'Returns', 'viewReturn.php', 705, 0, '', 7, 1, 1, 0, 2, 0),
(710, 'Add Return', 'SoList.php', 705, 1, 'i', 7, 1, 1, 0, 0, 0),
(715, 'Report', 'viewSalesbyCustomer.php', 706, 0, '', 7, 1, 1, 0, 2, 0),
(716, 'Sales Statistics', 'viewSalesStatistics.php', 706, 0, '', 7, 1, 0, 0, 2, 0),
(601, 'Items', 'viewItem.php', 601, 0, '', 6, 1, 1, 1, 2, 0),
(602, 'Add Item', 'editItem.php', 601, 1, '', 6, 1, 1, 0, 0, 0),
(603, 'Categories', 'viewCategory.php', 601, 0, '', 6, 1, 1, 0, 2, 0),
(604, 'Add Category', 'editCategory.php', 601, 1, '', 6, 1, 1, 0, 0, 0),
(605, 'Price List', 'viewPriceList.php', 601, 0, '', 6, 1, 1, 0, 2, 0),
(606, 'Stock Adjustment', 'viewAdjustment.php', 602, 1, '', 6, 1, 1, 0, 0, 0),
(607, 'Stock Transfers', 'viewTransfer.php', 603, 0, '', 6, 1, 1, 0, 2, 0),
(608, 'BOM', 'viewBOM.php', 604, 1, '0', 6, 1, 1, 0, 0, 0),
(122, 'Add Customer', 'addCustomer.php', 2015, 1, '', 5, 1, 1, 22, 0, 0),
(120, 'Add Item', 'editItem.php', 2003, 1, '', 5, 1, 1, 20, 0, 0),
(121, 'Customer', 'viewCustomer.php', 2015, 0, '', 5, 1, 1, 21, 2, 0),
(119, 'Items', 'viewItem.php', 2003, 0, '', 5, 1, 1, 19, 2, 0),
(117, 'Users', 'viewUser.php', 2001, 0, '', 5, 1, 1, 17, 2, 0),
(118, 'Add User', 'editUser.php', 2001, 1, '', 5, 1, 1, 18, 0, 0),
(609, 'Users', 'viewUser.php', 2005, 0, '', 6, 1, 1, 0, 2, 0),
(610, 'Add User', 'editUser.php', 2005, 1, '', 6, 1, 1, 0, 0, 0),
(612, 'Stock Search', 'searchItemStock.php', 601, 1, '0', 6, 1, 1, 2, 0, 0),
(801, 'Chart of Accounts', 'viewAccount.php', 801, 0, '', 8, 1, 1, 1, 2, 0),
(802, 'AR Cash Receipt', 'viewSalesPayments.php', 802, 0, '', 8, 1, 1, 2, 2, 0),
(803, 'AP Payments', 'viewPurchasePayments.php', 803, 0, '', 8, 1, 1, 3, 2, 0),
(804, 'Journal Entry', 'viewGeneralJournal.php', 804, 0, '', 8, 1, 1, 4, 2, 0),
(805, 'Profit and Loss', 'reportProfitLoss.php', 805, 0, '', 8, 1, 1, 5, 2, 0),
(806, 'Balance Sheet', 'reportBalanceSheet.php', 805, 0, '', 8, 1, 1, 6, 2, 0),
(807, 'Customer', 'viewCustomer.php', 802, 0, '', 8, 1, 1, 7, 2, 0),
(808, 'AR Invoices', 'viewInvoice.php', 802, 0, '', 8, 1, 1, 8, 2, 0),
(809, 'Sales Commission', 'viewSalesCommReport.php', 802, 0, '', 8, 1, 1, 9, 2, 0),
(810, 'Vendor', 'viewSupplier.php', 803, 0, '', 8, 1, 1, 10, 2, 0),
(811, 'AP Invoices', 'viewPoInvoice.php', 803, 0, '', 8, 1, 1, 11, 2, 0),
(812, 'Receive Payment', 'receivePayment.php', 802, 0, '', 8, 1, 1, 2, 2, 0),
(813, 'Pay Vendor', 'payVendor.php', 803, 0, '', 8, 1, 1, 3, 2, 0);


--
-- Dumping data for table `department`
--

INSERT INTO `department` (`depID`, `Department`, `Status`) VALUES
(1, 'HRMS', 1),
(2, 'E-Commerce', 1),
(3, 'Warehouse', 1),
(4, 'Purchasing', 1),
(5, 'CRM', 1),
(6, 'Inventory', 1),
(7, 'Sales', 1),
(8, 'Finance', 1);

--
-- Dumping data for table `email_cat`
--

INSERT INTO `email_cat` (`CatID`, `department`, `Name`, `OrderLevel`) VALUES
(1, 5, 'Lead Assign', 0),
(2, 5, 'New Lead', 0),
(3, 5, 'New Opportunity', 0),
(4, 5, 'Opportunity Assign', 0),
(5, 5, 'New Ticket', 0),
(6, 5, 'Ticket Assign', 0),
(7, 5, 'New Quote', 0),
(8, 5, 'Quote Assign', 0);

--
-- Dumping data for table `email_template`
--


INSERT INTO `email_template` (`TemplateID`, `CatID`, `Title`, `subject`, `Content`, `arr_field`, `Status`) VALUES
(1, 1, NULL, 'New Lead  has been Assigned to You', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Lead  has been assigned to you on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below Lead details : <br />\r\n            <br />\r\n            First Name:&nbsp;[FIRSTNAME]<br />\r\n            <br />\r\n            Last Name:&nbsp;[LASTNAME]<br />\r\n            <br />\r\n            Lead Name:&nbsp;[FIRSTNAME] [LASTNAME]<br />\r\n            <br />\r\n            Title:&nbsp;[TITLE]<br />\r\n            <br />\r\n            Primary Email:&nbsp;[PRIMARYEMAIL]<br />\r\n            <br />\r\n            Company:&nbsp;[COMPANY]<br />\r\n            <br />\r\n            Website:&nbsp;[WEBSITE]<br />\r\n            <br />\r\n            Sales Person:&nbsp;[ASSIGNEDTO]<br />\r\n            <br />\r\n            Product:&nbsp;[PRODUCT]<br />\r\n            <br />\r\n            Product Price:&nbsp;[PRODUCTPRICE]<br />\r\n            <br />\r\n            Annual Revenue:&nbsp;[ANNUALREVENUE]<br />\r\n            <br />\r\n            Number Of Employees:&nbsp;[NUMBEROFEMPLOYEES]<br />\r\n            <br />\r\n            Last Contact Date:&nbsp;[LASTCONTACTDATE]<br />\r\n            <br />\r\n            Lead Source:&nbsp;[LEADSOURCE]<br />\r\n            <br />\r\n            Lead Status:&nbsp;[LEADSTATUS]<br />\r\n            <br />\r\n            Lead Date: &nbsp;[LEADDATE]<br />\r\n            <br />\r\n            Description:&nbsp;[DESCRIPTION]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">Sakshay Web Technology Pvt Ltd.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(2, 2, NULL, 'New Lead  has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal"><br />\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Lead  has been submitted on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below Lead details : <br />\r\n            <br />\r\n            Lead Name: [FIRSTNAME][LASTNAME]<br />\r\n            <br />\r\n            Title: [TITLE]<br />\r\n            <br />\r\n            Primary Email: [PRIMARYEMAIL]<br />\r\n            <br />\r\n            Sales Person: [ASSIGNEDTO]<br />\r\n            <br />\r\n            Company            : [COMPANY]   <br />\r\n            <br />\r\n            Product:&nbsp;[PRODUCT]<br />\r\n            <br />\r\n            Product Price:&nbsp;[PRODUCTPRICE]<br />\r\n            <br />\r\n            Lead Source:&nbsp;[LEADSOURCE]<br />\r\n            <br />\r\n            Lead Status:&nbsp;[LEADSTATUS]<br />\r\n            <br />\r\n            Lead Date:&nbsp;[LEADDATE]<br />\r\n            <br />\r\n            Description        : [DESCRIPTION]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">Sakshay Web Technology Pvt. Ltd.</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Lead ID,First Name,Last Name,Primary Email,Assigned To,Company,Website,Title,Product,Product Price,Annual Revenue,Lead Source,Number of Employees,Lead Status,Lead Date,Last Contact Date,description', 1),
(3, 3, NULL, 'New Opportunity  has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">Dear Administrator,<br />\r\n<table cellspacing="5" cellpadding="5" border="0" width="100%" class="tablenormal">\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">\r\n            <p><br />\r\n            New Opportunity  has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>: <br />\r\n            <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Opportunity Name          : [OPPORTUNITYNAME]<br />\r\n            <br />\r\n            Organization&nbsp;&nbsp; : [ORGANIZATIONNAME]<br />\r\n            <br />\r\n            Expected Close Date    :[EXPECTEDCLOSEDATE]<br />\r\n            <br />\r\n            Amount      :[AMOUNT]<br />\r\n            <br />\r\n            Sale stage              : [SALESSTAGE]<br />\r\n            <br />\r\n            Assign To :[ASSIGNEDTO]<br />\r\n            <br />\r\n            Customer&nbsp; :[CUSTOMER]<br />\r\n            <br />\r\n            Lead Source :[LEADSOURCE]<br />\r\n            <br />\r\n            Industry : [INDUSTRY]<br />\r\n            <br />\r\n            Next Step :[NEXTSTEP]<br />\r\n            <br />\r\n            Opportunity Type :[OPPORTUNITYTYPE]<br />\r\n            <br />\r\n            Probability :[PROBABILITY]<br />\r\n            <br />\r\n            Campaign Source :[CAMPAIGNSOURCE]<br />\r\n            <br />\r\n            Forcast Amount:[FORECASTAMOUNT]<br />\r\n            <br />\r\n            Contact Name           :[CONTACTNAME]<br />\r\n            <br />\r\n            Website :[WEBSITE]<br />\r\n            <br />\r\n            Description :[DESCRIPTION]<br />\r\n            <br />\r\n            Sales Person       : [ASSIGNEDTO]<br />\r\n            &nbsp;</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(4, 4, NULL, 'New Opportunity  has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">New Opportunity  has been Assigned to You on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Please see below  Opportunity details : <br />\r\n            <br />\r\n            Opportunity Name          : [OPPORTUNITYNAME]<br />\r\n            <br />\r\n            Organization&nbsp;&nbsp; : [ORGANIZATIONNAME]<br />\r\n            <br />\r\n            Expected Close Date    :[EXPECTEDCLOSEDATE]<br />\r\n            <br />\r\n            Amount      :[AMOUNT]<br />\r\n            <br />\r\n            Sale stage              : [SALESSTAGE]<br />\r\n            <br />\r\n            Sales Person :[ASSIGNEDTO]<br />\r\n            <br />\r\n            Customer&nbsp; :[CUSTOMER]<br />\r\n            <br />\r\n            Lead Source :[LEADSOURCE]<br />\r\n            <br />\r\n            Industry :[INDUSTRY]<br />\r\n            <br />\r\n            Next Step :[NEXTSTEP]<br />\r\n            <br />\r\n            Opportunity Type :[OPPORTUNITYTYPE]<br />\r\n            <br />\r\n            Probability :[PROBABILITY]<br />\r\n            <br />\r\n            Campaign Source :[CAMPAIGNSOURCE]<br />\r\n            <br />\r\n            Forcast Amount:[FORECASTAMOUNT]<br />\r\n            <br />\r\n            Contact Name           :[CONTACTNAME]<br />\r\n            <br />\r\n            Website :[WEBSITE]<br />\r\n            <br />\r\n            Description :[DESCRIPTION]<br />\r\n            <br />\r\n            <br />\r\n            &nbsp;\r\n            <p>&nbsp;</p>\r\n            </td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', ' Opportunity ID,Opportunity Name,Organization Name,Amount,Expected Close Date,Sales Stage,Assigned To,Customer,Lead Source,industry,Next Step,Opportunity Type,Probability,Campaign Source,Forecast Amount,Contact Name,Website,Description', 1),
(5, 5, NULL, 'New Ticket  has been Added', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal"><br />\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">Ticket  has been Added with [PARENT] [[PARENTID]] on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below  Ticket details : <br />\r\n            <br />\r\n            <br />\r\n            Ticket Title            :  [TITLE]    <br />\r\n            <br />\r\n            Ticket Category      : [CATEGORY]   <br />\r\n            <br />\r\n            Generate Date         : [CREATEDON]<br />\r\n            <br />\r\n            Priority             : [PRIORITY]   <br />\r\n            <br />\r\n            Description          :[DESCRIPTION]<br />\r\n            <br />\r\n            Status&nbsp;&nbsp; :[STATUS]<br />\r\n            <br />\r\n            Priority&nbsp; : [PRIORITY]<br />\r\n            <br />\r\n            Category&nbsp; :[CATEGORY]<br />\r\n            <br />\r\n            Days : [DAYS]<br />\r\n            <br />\r\n            Hours :[HOURS]<br />\r\n            <br />\r\n            Solution :[SOLUTION]<br />\r\n            <br />\r\n            Assign To:&nbsp;[ASSIGNEDTO]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[Sakshay Web Technology]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(6, 6, NULL, 'Ticket  has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td class="blacknormal">Ticket  has been Assigned to You on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below  Ticket details : <br />\r\n            <br />\r\n            Ticket Title            :  [TITLE] <br />\r\n            <br />\r\n            Ticket Status:&nbsp;[STATUS]<br />\r\n            <br />\r\n            Ticket Priority:&nbsp;[PRIORITY]<br />\r\n            <br />\r\n            Sales Person:&nbsp;[ASSIGNEDTO]<br />\r\n            <br />\r\n            Ticket Category      : [CATEGORY]   <br />\r\n            <br />\r\n            Days:&nbsp;[DAYS]<br />\r\n            <br />\r\n            Hours:&nbsp;[HOURS]<br />\r\n            <br />\r\n            Description          : [DESCRIPTION]<br />\r\n            <br />\r\n            Solution :[SOLUTION]<br />\r\n            <br />\r\n            Created Date:&nbsp;[CREATEDON]</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Ticket ID,Title,Status,Priority,Assigned To,Category,Days,Hours,Description,Solution,Created on', 1),
(8, 8, NULL, 'New Quote has been Assigned to You', '<link type="text/css" rel="stylesheet" href="[URL]css/mail.css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td width="339" class="blacknormal">New Quote  has been Assigned  on <a class="normallink" target="_blank" href="[COMPNAY_URL]">[SITENAME]</a>. <br />\r\n            Please see below his Quote details : <br />\r\n            <br />\r\n            <br />\r\n            Quote Subject          :  [SUBJECT]<br />\r\n            <br />\r\n            Opportunity/Customer:&nbsp;[CUSTOMERTYPE]<br />\r\n            <br />\r\n            Quote Stage : [QUOTESTAGE]<br />\r\n            <br />\r\n            Carrier : [CARRIER]<br />\r\n            <br />\r\n            Sales Person : [ASSIGNEDTO]<br />\r\n            <br />\r\n            Valid till    :  [VALIDTILL]<br />\r\n            <br />\r\n            <br />\r\n            &nbsp;</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till', 1),
(7, 7, NULL, 'New quote has been created', '<link href="[URL]css/mail.css" rel="stylesheet" type="text/css" />\r\n<div class="divnormal">\r\n<table cellspacing="5" cellpadding="5" border="0" class="tablenormal">\r\n    <!--<tr>\r\n    <td   bgcolor="#1D4D95"><img src="[URL]images/logo.gif" border="0" /></td>\r\n  </tr>-->\r\n    <tbody>\r\n        <tr>\r\n            <td width="339" class="blacknormal">New quote  has been created on <a href="[COMPNAY_URL]" target="_blank" class="normallink">[SITENAME]</a>. <br />\r\n            Please see below the quote details : <br />\r\n            <br />\r\n            Quote ID          :  [QUOTEID]<br />\r\n            <br />\r\n            Subject          :  [SUBJECT]<br />\r\n            <br />\r\n            Opportunity : [OPPORTUNITY]<br />\r\n            <br />\r\n            Type : [CUSTOMERTYPE]<br />\r\n            <br />\r\n            Quote Stage : [QUOTESTAGE]<br />\r\n            <br />\r\n            Carrier : [CARRIER]<br />\r\n            <br />\r\n            Valid Till : [VALIDTILL]<br />\r\n            <br />\r\n            Created By : [CREATED]<br />\r\n            <br />\r\n            Sales Person : [ASSIGNEDTO]<br />\r\n            <br />\r\n            Amount : [TOTALAMOUNT]<br />\r\n            <br />\r\n            Please <a href="[LINK_URL]">Click here</a> to see full detail of this quote.</td>\r\n        </tr>\r\n        <tr>\r\n            <td class="blackbold">[FOOTER_MESSAGE]</td>\r\n        </tr>\r\n    </tbody>\r\n</table>\r\n</div>', 'Quote ID,Subject,Customer Type,Quote Stage,Carrier,Assigned To,Valid Till,CREATED,Opportunity,Total Amount', 1);


--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`visible`, `input_type`, `group_id`, `group_name`, `caption`, `setting_key`, `setting_value`, `options`, `validation`, `dep_id`, `priority`) VALUES
('Yes', 'text', 1, 'Global Settings', 'Notification Email', 'Notification_Email', 'notifications@site.com', '', 'No', 8, 2),
('Yes', 'text', 1, 'Global Settings', 'Journal Prefix', 'JOURNAL_NO_PREFIX', 'JN', '', 'No', 8, 1),
('Yes', 'text', '1', 'Global Settings', 'Fiscal Year', 'FiscalYearStartDate', NULL, '', 'No', '8', '0'),
 ('Yes', 'text', '1', 'Global Settings', 'Fiscal Year', 'FiscalYearEndDate', NULL, '', 'No', '8', '0')
;

--
-- Table structure for table `meeting_join`
--

CREATE TABLE IF NOT EXISTS `meeting_join` (
`id` int(100) NOT NULL AUTO_INCREMENT,
  `meetingId` varchar(200) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Email` varchar(150) NOT NULL,
  `MType` tinyint(2) NOT NULL,
  `createTime` datetime NOT NULL,
  `userId` varchar(200) NOT NULL,
  `JoinStatus` int(2) NOT NULL,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Table structure for table `meeting`
--

CREATE TABLE IF NOT EXISTS `meeting` (
`meeting_Id` int(100) NOT NULL AUTO_INCREMENT,
  `meetingId` int(10) NOT NULL,
  `meetingName` varchar(200) NOT NULL,
  `attendeePw` varchar(200) NOT NULL,
  `moderatorPw` varchar(200) NOT NULL,
  `welcomeMsg` varchar(200) NOT NULL,
  `dialNumber` varchar(200) NOT NULL,
  `voiceBridge` varchar(200) NOT NULL,
  `webVoice` varchar(200) NOT NULL,
  `logoutUrl` varchar(200) NOT NULL,
  `maxParticipants` varchar(200) NOT NULL,
  `record` varchar(200) NOT NULL,
  `duration` varchar(200) NOT NULL,
  `createtime` varchar(100) NOT NULL,
  `createDate` date NOT NULL,
  `UserId` int(10) NOT NULL,
   PRIMARY KEY (`meeting_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1;

--
-- Dumping data for table `meeting`
--

INSERT INTO `meeting` (`meeting_Id`, `meetingId`, `meetingName`, `attendeePw`, `moderatorPw`, `welcomeMsg`, `dialNumber`, `voiceBridge`, `webVoice`, `logoutUrl`, `maxParticipants`, `record`, `duration`, `createtime`, `createDate`, `UserId`) VALUES
(7, 1429514382, 'vstacks', 'abcd', 'abc', '', '', '', '', '', '', 'false', '20', '07:56:22am', NOW(), 0);

