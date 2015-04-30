<?	
	require_once("classes/MyMailer.php");

	$FromName = 'ERP Admin';
	$FromEmail = 'bhoodevvidua1921@hmail.com';

	$To = 'parwez.khan@sakshay.in,mohit.sharma@sakshay.in';
	//$To = 'mohit.sharma@sakshay.in';

	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= "From: ".$FromName. "<".$FromEmail.">\r\n" .
	"Reply-To: ".$FromEmail. "\r\n" .
	"X-Mailer: PHP/" . phpversion();
	
	$Subject = 'simple mailer';

	$contents = 'hi test <b>content</b><br><br>';

	$pp = mail($To, $Subject, $contents, $headers);
	if($pp) echo 'Mail Sent';
	else echo 'Error: Mail not sent.<br><br>';
	 /******************/
	$contents = $contents.'final mailer test content';

	$mail = new MyMailer();
	$mail->IsMail();			
	$mail->AddAddress($To);
	//$mail->AddCC($CC);
	$mail->sender($FromName, $FromEmail);   
	$mail->Subject = 'php mailer';
	$mail->IsHTML(true);
	$mail->Body = $contents;    
	$mail->Send();	


?>
