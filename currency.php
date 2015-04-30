<?
	/*
	function CurrencyConvertor($amount,$from,$to){
		$get = file_get_contents("https://www.google.com/finance/converter?a=".$amount."&from=".$from."&to=".$to."");
		$get = explode("<span class=bld>",$get);
		$get = explode("</span>",$get[1]);  
		$converted_amount = preg_replace("/[^0-9\.]/", null, $get[0]);
		return $converted_amount;
	}*/

    require_once("includes/function.php");
	echo CurrencyConvertor(1,'USD','INR');

	/*
	$url = 'http://www.google.com/finance/converter?a=1&from=USD&to=INR';

	$cinit = curl_init();
	curl_setopt($cinit, CURLOPT_URL, $url);
	curl_setopt($cinit, CURLOPT_HEADER,0);
	curl_setopt($cinit, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
	curl_setopt($cinit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	curl_setopt($cinit, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($cinit, CURLOPT_TIMEOUT, 30);
	curl_setopt($cinit, CURLOPT_CUSTOMREQUEST, 'GET');  

	$response = curl_exec($cinit);
	$httpCode = curl_getinfo($cinit, CURLINFO_HTTP_CODE); 
	$info = curl_getinfo($cinit);
	$err = curl_error($cinit);  
	curl_close($cinit); 

	//echo '<pre>';print_r($info); 
	//echo '<br><br>httpCode:'. $httpCode;

	if($err){
		echo '<br><br>Error: '.$err; exit;
	}else{
		echo '<br><br>Response: '.$response; exit;
	}


	exit;*/

?>