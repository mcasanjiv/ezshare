<? 
    require_once("../includes/config.php");
	require_once("../classes/dbClass.php");
	require_once("../classes/admin.class.php");
	require_once("../classes/company.class.php");
	require_once("../classes/license.class.php");

	$objConfig=new admin();	

	
	
	/* Checking for Company existance */
	if($_GET['Multiple'] == "1" && $_GET['DisplayName'] != ""){
		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "2";
		}else{
			if($_GET['Email'] != ""){
				if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
					echo "1";
				}else{
					echo "0";
				}
			}else{
				echo "0";
			}
		}
		exit;
	}

	/* Checking for Company existance */
	if($_GET['DisplayName'] != ""){

		$objCompany = new company();
		if($objCompany->isDisplayNameExists($_GET['DisplayName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}
	/* Checking for Company Email existance */
	if($_GET['Type'] == "Company" && $_GET['Email'] != ""){
		$objCompany = new company();
		if($objConfig->isCmpEmailExists($_GET['Email'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}

		/* Checking for DomainName existance */
	if($_GET['DomainName'] != ""){
		$objLicense=new license();
		if($objLicense->isDomainExists($_GET['DomainName'],$_GET['editID'])){
			echo "1";
		}else{
			echo "0";
		}
		exit;
	}	


?>
