<?php 	$LoginPage=1;

	require_once("includes/header.php");

	$objConfig = new admin();

	if ($_POST['LoginEmail']!='') {
		if (empty($_POST['LoginEmail'])) {
			$mess = ENTER_EMAIL;
		}elseif (empty($_POST['LoginPassword'])) {
			$mess = ENTER_PASSWORD;
		} else{
			$ArryAdmin = $objConfig->ValidateAdmin($_POST['LoginEmail'], $_POST['LoginPassword']);
			
			if(md5($_POST['LoginPassword']) != $ArryAdmin[0]['Password']){
				$mess = INVALID_EMAIL_PASSWORD;
			}else{

				if($ArryAdmin[0]['AdminID']>0){
					$_SESSION['SuperAdminID'] = $ArryAdmin[0]['AdminID']; 
					$_SESSION['AdminID'] = $ArryAdmin[0]['AdminID']; 
					$_SESSION['UserName'] = $ArryAdmin[0]['Name'];
					$_SESSION['AdminEmail'] = $ArryAdmin[0]['AdminEmail'];					
					$_SESSION['AdminPassword'] = $ArryAdmin[0]['Password'];			

					
					if(!empty($_POST['ContinueUrl'])){
								$_POST['ContinueUrl'] = str_replace(",","&",$_POST['ContinueUrl']);

					
						echo '<script>location.href="'.$_POST['ContinueUrl'].'";</script>';
						exit;
					}else{
						echo '<script>location.href="adminDesktop.php";</script>';
						exit;
					}
				}

				$mess = INVALID_EMAIL_PASSWORD;
			}
			
			
		}
	}

	require_once("includes/footer.php");
 ?>
