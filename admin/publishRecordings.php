<?php
$HideNavigation = 1;
require_once("includes/header.php");
	
$meetingId = $_REQUEST['meetingId']; 
$publish = $_REQUEST['publish']; 
$bbb = new BigBlueButton();

$recordingsParams = array(
	'meetingId' => $meetingId, 			// OPTIONAL - comma separate if multiples

);

// Now get recordings info and display it:
$itsAllGood = true;
try {$result = $bbb->getRecordingsWithXmlResponseArray($recordingsParams);}
	catch (Exception $e) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
		$itsAllGood = false;
	}

	if ($itsAllGood == true) {
		// If it's all good, then we've interfaced with our BBB php api OK:
		if ($result == null) {
			// If we get a null response, then we're not getting any XML back from BBB.
			echo "Failed to get any response. Maybe we can't contact the BBB server.";
		}	
		else { 
		// We got an XML response, so let's see what it says:
		
		//var_dump($result);
			if ($result['returncode'] == 'SUCCESS') {
				// Then do stuff ...
				
				echo "<p>Meeting info was found on the server and publish succesfully.</p>";
				$recordId=$result[0]['recordId']; //echo $recordId.'rjrrj';
				$presentation=$result[0]['playbackFormatUrl'];
				
     $recordingParams = array(
   'recordId' => $recordId, 			
   'publish' => $publish,		
     );

// Now do it:
$itsAllGood = true;
try {$result = $bbb->publishRecordingsWithXmlResponseArray($recordingParams);}
	catch (Exception $e) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
		$itsAllGood = false;
	}

if ($itsAllGood == true) {
	//Output results to see what we're getting:
	print_r($result); 
	 header("location:recordmeeting.php?presentation=$presentation");
			 exit;	
}	
			}
			else {
				echo "<p>Failed to get meeting info.</p>";
			}
		}
	}	
?>