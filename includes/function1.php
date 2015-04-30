<?php	
	// Function for checking admin session. 
	function ValidateAdminSession($ThisPage){	
		$Page = explode("/",$_SERVER['PHP_SELF']); 
		if(!empty($Page[4])){
			$Prefix = '../';
			$ThisPage = $Page[3]."/".$ThisPage;
		}
	
		if($_SESSION['AdminID']  == '') {
			echo '<script>location.href="'.$Prefix.'index.php?c='.$_COOKIE["DisplayNameCookie"].'&ref='.$ThisPage.'";</script>';
			exit;
		}
	}

	// Function for checking session on frontend for loggrd in member. 
	function ValidateMemberSession($ThisPage){	
		
		if($_SESSION['MemberID']  == '' || $_SESSION['UserName']  == '' || $_SESSION['Email']  == '') {
			
			//echo '<script>location.href="login.php?ref='.$ThisPage.'";</script>';
			global $Config;
			header('location: '.$Config['Url'].'login.php?ref='.$ThisPage);
			exit;
		}
	}
	
	//Function to redirects the execution to given URL after below mentioned seconds.
	function redirect( $message, $url, $waitTime = 2, $alt = 1 ){ 
		$HTML =  " <html><head><title>Redirecting...</title><meta HTTP-EQUIV=Refresh CONTENT=\"$waitTime; URL=$url\" level='_parent'></head><body><center><IMG SRC=images/ticket_01.gif WIDTH=768 HEIGHT=143 > ";

		if( $message )
			$HTML .= "<font face=verdana><br><br><br><br><br><br><center><p style='font-face:tahoma; font-size:14px; font-weight:bold'><b>$message</b></p></center> ";

		if ($alt != 0)
			$HTML .= "<center><p style='font-face:tahoma; font-size:14px;'>If your browser cannot load the url, <a href=\"$url\" style='font-face:tahoma; font-size:14px;'>click here to continue</a>.</p></center>";

		$HTML .= " </body></html>";

		echo $HTML;
	}
	

	// Function to time difference. 
	function time_diff($s){
		$m=0;$hr=0;$d=0; $td=$s." sec";

		if($s>59) {
			$m = (int)($s/60);
			$s = $s-($m*60); // sec left over
			$td = "$m min";
		}
		if($m>59){
			$hr = (int)($m/60);
			$m = $m-($hr*60); // min left over
			$td = "$hr hr"; if($hr>1) $td .= "s";
			if($m>0) $td .= ", $m min";
		}
		if($hr>23){
			$d = (int)($hr/24);
			$hr = $hr-($d*24); // hr left over
			$td = "$d day"; if($d>1) $td .= "s";
			if($d<3){
				if($hr>0) $td .= ", $hr hr"; if($hr>1) $td .= "s";
			}
		}

		//if($s>0) $td .=  " $s sec";

		return $td;
	} 


	// Function to Get Week. 
	function GetWeek($Today,$Format){
		$arryDate = explode("-",$Today);
		list($year, $month, $day) = $arryDate;

		$NumDay = date("N",strtotime($Today));

		$tomorrow  = mktime(0, 0, 0, $month , $day+1, $year);

		for($i=1;$i<=7;$i++){
			if($i!=$NumDay){
				$DayDif = $NumDay-$i;
				$NextPrevDay  = mktime(0, 0, 0, $month , $day-$DayDif, $year);

				$ArryWeek[$i] = date($Format,$NextPrevDay);
			}else{
				$ArryWeek[$NumDay] = date($Format,strtotime($Today));
			}
		}

		return $ArryWeek;
	}


	// Function to get extension of a file. 
	function GetExtension($file){
		$revfile=strrev($file);		// Reverse the string for getting the extension
		$arr_t=explode(".",$revfile);
		$file_type=$arr_t[0];
		return strrev($file_type);  // File Extension
	}

	function display_price($Price){
		global $Config;

		if(empty($Config['CurrencyValue'])) $Config['CurrencyValue'] = 1;
		$Price = $Config['CurrencyValue']*$Price;
		$final_price = $Config['CurrencySymbol'].''.number_format($Price,2,'.',',').''.$Config['CurrencySymbolRight'];

		return $final_price;
	}

	function Alphabets($Page,$Class,$Selected){
		for($i=65;$i<=90;$i++){
			$alphabet = chr($i);
			$alph = $alphabet;
			if($alph == $Selected){
				$alphabet = '<b>'.$alph.'</b>';
			}
			
			echo '<a href="'.$Page.$alph.'" class="'.$Class.'">'.$alphabet.'</a>';
			if($i<90) echo '&nbsp;';

		}
	}
	function ClearDirectory($dir){
		if (is_dir($dir)) { 
		   if ($dh = opendir($dir)) {
			   $cnt=0;
			   while (($file = readdir($dh)) !== false) {
				   if($file !='' && strlen($file) > 2)
				   {
					  $path =  $dir.$file;
					  unlink($path);
				   }
			   }
			   closedir($dh);
		   }
		}
	}

	function GetPage(){
		$Page = explode("/",$_SERVER['PHP_SELF']); 
		/*
		if($HTTP_SERVER_VARS['HTTP_HOST']!="localhost"){
			return $Page[2];
		}else{
			return $Page[3];
		}*/
		return $Page[2];
	}

	function GetAdminPage(){
		$Page = explode("/",$_SERVER['PHP_SELF']); 
		$cPage = (!empty($Page[4]))?($Page[4]):($Page[3]);
		return $cPage;
	}



	function date_of_birth($date_value,$month_field,$day_field,$year_field,$class_name){

		if($date_value > 0){
			$datebirthArray = explode("-",$date_value);
			  $year_of_birth   = $datebirthArray[0];
			  $month_of_birth  = $datebirthArray[1];
			  $day_of_birth    = $datebirthArray[2];
		}


		if($month_of_birth == '01') $sel_01=' Selected'; 
		if($month_of_birth == '02') $sel_02=' Selected'; 
		if($month_of_birth == '03') $sel_03=' Selected'; 
		if($month_of_birth == '04') $sel_04=' Selected'; 
		if($month_of_birth == '05') $sel_05=' Selected'; 
		if($month_of_birth == '06') $sel_06=' Selected'; 
		if($month_of_birth == '07') $sel_07=' Selected'; 
		if($month_of_birth == '08') $sel_08=' Selected'; 
		if($month_of_birth == '09') $sel_09=' Selected'; 
		if($month_of_birth == '10') $sel_10=' Selected'; 
		if($month_of_birth == '11') $sel_11=' Selected'; 
		if($month_of_birth == '12') $sel_12=' Selected'; 


		$Month_String = '<select name="'.$month_field.'" id="'.$month_field.'" class="'.$class_name.'" style="width: 58px;">
						<option value=""> Month </option>
						<option value="01" '.$sel_01.'> Jan </option>
						<option value="02" '.$sel_02.'> Feb </option>
						<option value="03" '.$sel_03.'> March </option>
						<option value="04" '.$sel_04.'> Apr </option>
						<option value="05" '.$sel_05.'> May </option>
						<option value="06" '.$sel_06.'> June </option>
						<option value="07" '.$sel_07.'> July </option>
						<option value="08" '.$sel_08.'> Aug </option>
						<option value="09" '.$sel_09.'> Sep </option>
						<option value="10" '.$sel_10.'> Oct </option>
						<option value="11" '.$sel_11.'> Nov </option>
						<option value="12" '.$sel_12.'> Dec </option>
					</select>';

		///////////////////////////////////////
		$Day_String = ' <select name="'.$day_field.'" id="'.$day_field.'" class="'.$class_name.'" style="width: 50px;">';
				$Day_String .= '<option value="">Day</option>';
		 for($d=1;$d<=31;$d++){
				$DayVal = $d; 
				if($DayVal<10) $DayVal = '0'.$DayVal;

				if($day_of_birth == $d) $d_selected=' Selected'; else $d_selected='';

				$Day_String .= '<option value="'.$d.'" '.$d_selected.'> '.$DayVal.' </option>';
			}
		$Day_String .= ' </select>';

		////////////////////////////////////////

		$Year_String = ' <select name="'.$year_field.'" id="'.$year_field.'" class="'.$class_name.'" style="width: 50px;">';
		$c_year = date('Y');
		$start_year = 1950;
			$Year_String .= '<option value=""> Year </option>';
		 for($y=$start_year;$y<$c_year;$y++){

				if($year_of_birth == $y) $y_selected=' Selected'; else $y_selected='';

				$Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
			}
		$Year_String .= ' </select>';

		///////////////////////////////////////////
		/*
		$str = '<table width=\"100%\"  border=\"0\" cellspacing=\"0\" cellpadding=\"3\" align=left>
				  <tr>
					<td align=left width=\"20\">
					'.$Month_String.'&nbsp;'.$Day_String.'&nbsp;'.$Year_String.'
					</td>
				  </tr>
				</table>';
	*/
		$str = $Day_String.'&nbsp;'.$Month_String.'&nbsp;'.$Year_String;	
		return $str;
	}
	


	function getMonths($month_value,$month_field,$class_name){

		if($month_value == '01') $sel_01=' Selected'; 
		if($month_value == '02') $sel_02=' Selected'; 
		if($month_value == '03') $sel_03=' Selected'; 
		if($month_value == '04') $sel_04=' Selected'; 
		if($month_value == '05') $sel_05=' Selected'; 
		if($month_value == '06') $sel_06=' Selected'; 
		if($month_value == '07') $sel_07=' Selected'; 
		if($month_value == '08') $sel_08=' Selected'; 
		if($month_value == '09') $sel_09=' Selected'; 
		if($month_value == '10') $sel_10=' Selected'; 
		if($month_value == '11') $sel_11=' Selected'; 
		if($month_value == '12') $sel_12=' Selected'; 

		$Month_String = '<select name="'.$month_field.'" id="'.$month_field.'" class="'.$class_name.'" >
						<option value="">Select Month</option>
						<option value="01" '.$sel_01.'> January </option>
						<option value="02" '.$sel_02.'> February </option>
						<option value="03" '.$sel_03.'> March </option>
						<option value="04" '.$sel_04.'> April </option>
						<option value="05" '.$sel_05.'> May </option>
						<option value="06" '.$sel_06.'> June </option>
						<option value="07" '.$sel_07.'> July </option>
						<option value="08" '.$sel_08.'> August </option>
						<option value="09" '.$sel_09.'> September </option>
						<option value="10" '.$sel_10.'> October </option>
						<option value="11" '.$sel_11.'> November </option>
						<option value="12" '.$sel_12.'> December </option>
					</select>';
		
		return $Month_String;
	}


	function getYears($year_value,$year_field,$class_name){

		$Year_String = ' <select name="'.$year_field.'" id="'.$year_field.'" class="'.$class_name.'" >';
		$c_year = date('Y');
		$start_year = $c_year-20;
			$Year_String .= '<option value="">Select Year</option>';
		 for($y=$c_year;$y>$start_year;$y--){
				if($year_value == $y) $y_selected=' Selected'; else $y_selected='';
				$Year_String .= '<option value="'.$y.'" '.$y_selected.'> '.$y.' </option>';
			}
		$Year_String .= ' </select>';
		
		return $Year_String;
	}



	function getTimeZone($CuurentTimezone){
		$PlusMinus = substr($CuurentTimezone,0,1);
		$TimezoneValue = substr($CuurentTimezone,1,5); 

		$PlusSelected = ($PlusMinus=="+")?("selected"):("");
		$MinusSelected = ($PlusMinus=="-")?("selected"):("");
		$TimezoneHtml = '<div class="timezone">
		<select name="TimezonePlusMinus" style="border:none;color:#000;" id="TimezonePlusMinus" onchange="Javascript:GetLocalTime();">
			  <option value="+" '.$PlusSelected.'> + </option>
			  <option value="-" '.$MinusSelected.'> - </option>
		</select>
		</div>  <input name="Timezone" type="text" class="disabled" size="4" id="Timezone" value="'.$TimezoneValue.'"  autocomplete="off" onchange="Javascript:GetLocalTime();"/>
		 <br><br>UTC Time:<strong>&nbsp;&nbsp;'.gmdate("Y-m-d H:i:s").'</strong><div id="LocalTimeDiv"></div>';
		
		return $TimezoneHtml;
	}

	function getLocalTime($Timezone){
		$arryZone = explode(":",$Timezone);
		list($hour, $minute, $second) = $arryZone;
		$minute = ($minute*100)/60;
		$hourMinute = ($hour.'.'.$minute)*3600;

		$GMT = strtotime(gmdate("Y-m-d H:i:s"))+$hourMinute;
		$DateTime = date("Y-m-d H:i:s",$GMT);
		return $DateTime;
	}


	function imageThumb2($filename, $imageThumbPath, $width , $height)
   	{
		
		// Get new dimensions	
		list($width_orig, $height_orig) = getimagesize($filename);

		if($height_orig >= $height){
			if ($width && ($width_orig > $height_orig)) 
			{
				$width = ($height / $height_orig) * $width_orig;
			} 
			else 
			{
				$width = ($height / $height_orig) * $width_orig;
				$height = ($width / $width_orig) * $height_orig;
			}
		}else{

			if($width_orig >= $width){
				if ($width && ($width_orig < $height_orig)) 
				{
					$width = ($height / $height_orig) * $width_orig;
				} 
				else 
				{
					$height = ($width / $width_orig) * $height_orig;
				}
			}else{
					$width = $width_orig;
					$height = $height_orig;
			}

		}



		$imageInfo = getimagesize($filename);
		$type = $imageInfo['mime'];		
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imSource = @imagecreatefromjpeg($filename);
		}
		else if ($type == 'image/gif') 
        {
          $imSource = @imagecreatefromgif($filename);
        }
		else if ($type == 'image/png') 
        {
          $imSource = @imagecreatefrompng($filename);
        }
		
		if (function_exists('imagecreatetruecolor')) {
   			$imDestination = imagecreatetruecolor($width, $height);
			} else {
   			$imDestination = imagecreate($width, $height);
		}

		imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		//$imageCreated = imagejpeg($image_p,$imageThumbPath, 100);
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imageCreated = imagejpeg($imDestination, $imageThumbPath,75);
		}
		else if ($type == 'image/gif') 
        {
			$imageCreated = imagegif($imDestination, $imageThumbPath,75);
		}	
		else if ($type == 'image/png') 
        {
			$imageCreated = imagepng($imDestination, $imageThumbPath,75);
		}	
		
		imagedestroy($imSource);
		imagedestroy($imDestination);
		
		return true;
   	}

	function imageThumb($filename, $imageThumbPath, $width , $height)
   	{
		// Get new dimensions	
		
		$backColor = 'ffffff';

		list($width_orig, $height_orig) = getimagesize($filename);
		if($width_orig >= $width){
			if ($width && ($width_orig < $height_orig)) 
			{
				$width = ($height / $height_orig) * $width_orig;
			} 
			else 
			{
				$height = ($width / $width_orig) * $height_orig;
			}
		}else{
				$width = $width_orig;
				$height = $height_orig;
		}
		$imageInfo = getimagesize($filename);
		$type = $imageInfo['mime'];		

		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imSource = @imagecreatefromjpeg($filename);
		}
		else if ($type == 'image/gif') 
        {
          $imSource = @imagecreatefromgif($filename);
        }
		else if ($type == 'image/png') 
        {
          $imSource = @imagecreatefrompng($filename);
        }
		
		if (function_exists('imagecreatetruecolor')) {
   			$imDestination = imagecreatetruecolor($width, $height);
		} else {
   			$imDestination = imagecreate($width, $height);
		}

		/////////////////////////////
		
		if($backColor != '' && $type == 'image/gif'){
			$RGBArray = html2rgb($backColor);
			$R = $RGBArray[0];
			$G = $RGBArray[1];
			$B = $RGBArray[2];
			$th_bg_color = imagecolorallocate($imDestination, $R , $G, $B);
			imagefill($imDestination, 0, 0, $th_bg_color);
			imagecolortransparent($imDestination, $th_bg_color);
		}
		
		/////////////////////////////

		imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		//$imageCreated = imagejpeg($image_p,$imageThumbPath, 100);
		
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imageCreated = imagejpeg($imDestination, $imageThumbPath,75);
		}
		else if ($type == 'image/gif') 
        {
			$imageCreated = imagegif($imDestination, $imageThumbPath,75);
		}	
		else if ($type == 'image/png') 
        {
			$imageCreated = imagepng($imDestination, $imageThumbPath,75);
		}	
		
		imagedestroy($imSource);
		imagedestroy($imDestination);
		
		
		return true;
   	}



 	function getRatingOrangeHTML($Points,$TotalPoints){
	
		$total_width = 55;
		
		if($TotalPoints>0)
			$rating = ($Points*100)/$TotalPoints;
		
		if($rating>0)
			$rating_width = round(($total_width/100)*$rating,0);


		$static_rater = '<div class="ratingblock"  align=left><div class="whitestar" style="width: '.$total_width.'px;" >';

		if($rating>0){
			$static_rater .= '<div class="yellowstar" style="width:'.$rating_width.'px;" ></div>';
		}

		$static_rater .= '</div></div>';

		return $static_rater;

	}


	function escapeSpecial($Heading){
		/*
		$Heading = str_replace("&","",$Heading);
		$Heading = str_replace(" ","_",$Heading);
		$Heading = str_replace("(","",$Heading);
		$Heading = str_replace(")","",$Heading);
		$Heading = str_replace("{","",$Heading);
		$Heading = str_replace("}","",$Heading);
		$Heading = str_replace("/","",$Heading);
		$Heading = str_replace("'","",$Heading);
		*/
		$Heading = str_replace(" ","_",$Heading);
		$Heading = preg_replace('/[.,~:>-]/', '_', $Heading);

		return $Heading;
	}

	function getRatingHTML($Points,$TotalPoints){
	
		$total_width = 55;
		
		if($TotalPoints>0)
			$rating = ($Points*100)/$TotalPoints;
		
		if($rating>0)
			$rating_width = round(($total_width/100)*$rating,0);


		$static_rater = '<div class="ratingblock" align=left><div class="whitestar" style="width: '.$total_width.'px;">';

		if($rating>0){
			$static_rater .= '<div class="yellowstar" style="width:'.$rating_width.'px;"></div>';
		}

		$static_rater .= '</div></div>';

		return $static_rater;

	}
	
	function getRatingHTMLBig($Points,$TotalPoints){
	
		$total_width = 95;
		
		if($TotalPoints>0)
			$rating = ($Points*100)/$TotalPoints;
		
		if($rating>0)
			$rating_width = round(($total_width/100)*$rating,0);


		$static_rater = '<div class="ratingblock" align=left><div class="whitestar" style="width: '.$total_width.'px;">';

		if($rating>0){
			$static_rater .= '<div class="orangestar" style="width:'.$rating_width.'px;"></div>';
		}

		$static_rater .= '</div></div>';

		return $static_rater;

	}		
	
	function html2rgb($color){ 
	
		if ($color[0] == '#')        $color = substr($color, 1);    if (strlen($color) == 6)        list($r, $g, $b) = array($color[0].$color[1],                                 $color[2].$color[3],                                 $color[4].$color[5]);    elseif (strlen($color) == 3)        list($r, $g, $b) = array($color[0], $color[1], $color[2]);    else        return false;    $r = hexdec($r); $g = hexdec($g); $b = hexdec($b);    return array($r, $g, $b);


	}

	function imageThumbOld($filename, $imageThumbPath, $width , $height)
   	{
		// Get new dimensions	
		list($width_orig, $height_orig) = getimagesize($filename);
		$width_pass = $width;
		$height_pass = $height;
		if($width_orig >= $width){
			if ($width && ($width_orig < $height_orig)) 
			{
				$width = ($height / $height_orig) * $width_orig;
			} 
			else 
			{
				$height = ($width / $width_orig) * $height_orig;
			}
		}else{
				$width = $width_orig;
				$height = $height_orig;
		}
		
		/*
		if($height_orig > $height_pass){
			$height = $height_pass;
		}*/

		$imageInfo = getimagesize($filename);
		$type = $imageInfo['mime'];		
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imSource = @imagecreatefromjpeg($filename);
		}
		else if ($type == 'image/gif') 
        {
          $imSource = @imagecreatefromgif($filename);
        }
		else if ($type == 'image/png') 
        {
          $imSource = @imagecreatefrompng($filename);
        }
		
		if (function_exists('imagecreatetruecolor')) {
   			$imDestination = imagecreatetruecolor($width, $height);
			} else {
   			$imDestination = imagecreate($width, $height);
		}

		imagecopyresampled($imDestination, $imSource, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
		//$imageCreated = imagejpeg($image_p,$imageThumbPath, 100);
		
		if(($type == 'image/jpg') || ($type == 'image/jpeg')) 
		{
			$imageCreated = imagejpeg($imDestination, $imageThumbPath,75);
		}
		else if ($type == 'image/gif') 
        {
			$imageCreated = imagegif($imDestination, $imageThumbPath,75);
		}	
		else if ($type == 'image/png') 
        {
			$imageCreated = imagepng($imDestination, $imageThumbPath,75);
		}	
		
		imagedestroy($imSource);
		imagedestroy($imDestination);
		
		return true;
   	}







function ReadFloder($dir){
	$fd = @opendir($dir);
	 while (($part = @readdir($fd)) == true) {
		if (!is_dir($part) && ($part != "." && $part != "..")) {
			 return  $Path = $dir.'/'.$part;

				/*
				if(is_file($Path)){
					 //echo $Path.' -------------------- File<br>';
					
				 }	 else{
					 //echo $Path.' --------------------- Dir<br>';
					 ReadFloder($Path);
				 }
				 */

		}
	}

}

function ReadFloderAndMove($dir,$tar){
	$fd = @opendir($dir);
	 while (($part = @readdir($fd)) == true) {
		if (!is_dir($part) && ($part != "." && $part != "..")) {
			  echo $Path = $dir.'/'.$part;
			  echo $part;
			 // copy($Path,$tar);
			/*
				if(is_file($Path)){
					 echo $Path.' -------------------- File<br>';
					
				 }	 else{
					 echo $Path.' --------------------- Dir<br>';
				 }
				*/

		}
	}

}


///////////////////////////////////////
//////////////////////////////////////

function xml2array($contents, $get_attributes=1) { 
    if(!$contents) return array(); 

    if(!function_exists('xml_parser_create')) { 
        //print "'xml_parser_create()' function not found!"; 
        return array(); 
    } 
    //Get the XML parser of PHP - PHP must have this module for the parser to work 
    $parser = xml_parser_create(); 
    xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 ); 
    xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 ); 
    xml_parse_into_struct( $parser, $contents, $xml_values ); 
    xml_parser_free( $parser ); 

    if(!$xml_values) return;//Hmm... 

    //Initializations 
    $xml_array = array(); 
    $parents = array(); 
    $opened_tags = array(); 
    $arr = array(); 

    $current = &$xml_array; 

    //Go through the tags. 
    foreach($xml_values as $data) { 
        unset($attributes,$value);//Remove existing values, or there will be trouble 
        extract($data);//We could use the array by itself, but this cooler. 

        $result = ''; 
        if($get_attributes) {//The second argument of the function decides this. 
            $result = array(); 
            if(isset($value)) $result['value'] = $value; 

            //Set the attributes too. 
            if(isset($attributes)) { 
                foreach($attributes as $attr => $val) { 
                    if($get_attributes == 1) $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr' 
                    /**  :TODO: should we change the key name to '_attr'? Someone may use the tagname 'attr'. Same goes for 'value' too */ 
                } 
            } 
        } elseif(isset($value)) { 
            $result = $value; 
        } 

        //See tag status and do the needed. 
        if($type == "open") {//The starting of the tag '<tag>' 
            $parent[$level-1] = &$current; 

            if(!is_array($current) or (!in_array($tag, array_keys($current)))) { //Insert New tag 
                $current[$tag] = $result; 
                $current = &$current[$tag]; 

            } else { //There was another element with the same tag name 
                if(isset($current[$tag][0])) { 
                    array_push($current[$tag], $result); 
                } else { 
                    $current[$tag] = array($current[$tag],$result); 
                } 
                $last = count($current[$tag]) - 1; 
                $current = &$current[$tag][$last]; 
            } 

        } elseif($type == "complete") { //Tags that ends in 1 line '<tag />' 
            //See if the key is already taken. 
            if(!isset($current[$tag])) { //New Key 
                $current[$tag] = $result; 

            } else { //If taken, put all things inside a list(array) 
                if((is_array($current[$tag]) and $get_attributes == 0)//If it is already an array... 
                        or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1)) { 
                    array_push($current[$tag],$result); // ...push the new element into that array. 
                } else { //If it is not an array... 
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value 
                } 
            } 

        } elseif($type == 'close') { //End of tag '</tag>' 
            $current = &$parent[$level-1]; 
        } 
    } 

    return($xml_array); 
} 

///////////////////////////////////////
//////////////////////////////////////	


function ImportDatabase($db_server,$db_name,$db_username,$db_password,$filename){
		
		// If Timeout errors still occure you may need to adjust the $linepersession setting in this file
		// Change fopen mode to "r" as workaround for Windows issues
		
		/*
		$db_server   = 'localhost';
		$db_name     = 'agrinde_erp_parwez';
		$db_username = 'root';
		$db_password = '';
		$filename           = 'superadmin/sql/agrinde_erp.sql';    
		*/
		
		
		$csv_insert_table   = '';     // Destination table for CSV files
		$csv_preempty_table = false;  // true: delete all entries from table specified in $csv_insert_table before processing
		$ajax               = true;   // AJAX mode: import will be done without refreshing the website
		$linespersession    = 300000;   // Lines to be executed per one import session
		$delaypersession    = 0;      // You can specify a sleep time in milliseconds after each session
									  // Works only if JavaScript is activated. Use to reduce server overrun
		
		// Allowed comment delimiters: lines starting with these strings will be dropped by BigDump
		
		$comment[]='#';                       // Standard comment lines are dropped by default
		$comment[]='-- ';
		// $comment[]='---';                  // Uncomment this line if using proprietary dump created by outdated mysqldump
		// $comment[]='CREATE DATABASE';      // Uncomment this line if your dump contains create database queries in order to ignore them
		$comment[]='/*!';                  // Or add your own string to leave out other proprietary things
		
		
		
		// Connection character set should be the same as the dump file character set (utf8, latin1, cp1251, koi8r etc.)
		// See http://dev.mysql.com/doc/refman/5.0/en/charset-charsets.html for the full list
		
		$db_connection_charset = '';
		
		
		// *******************************************************************************************
		// If not familiar with PHP please don't change anything below this line
		// *******************************************************************************************
		
		if ($ajax)
		  ob_start();
		
		define ('VERSION','0.32b');
		define ('DATA_CHUNK_LENGTH',1638400);  // How many chars are read per time
		define ('MAX_QUERY_LINES',300000);      // How many lines may be considered to be one query (except text lines)
		define ('TESTMODE',false);           // Set to true to process the file without actually accessing the database
		
		header("Expires: Mon, 1 Dec 2003 01:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		@ini_set('auto_detect_line_endings', true);
		@set_time_limit(0);
		
		if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get"))
		  @date_default_timezone_set(@date_default_timezone_get());
		
		// Clean and strip anything we don't want from user's input [0.27b]
		
		foreach ($_REQUEST as $key => $val) 
		{
		  $val = preg_replace("/[^_A-Za-z0-9-\.&= ]/i",'', $val);
		  $_REQUEST[$key] = $val;
		}
		
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
		<title>BigDump ver</title>
		<meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="CONTENT-LANGUAGE" content="EN"/>
		
		<meta http-equiv="Cache-Control" content="no-cache/"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="-1"/>
		
		</head>
		
		<body>
		
		
		<?php
		$error = false;
		$file  = false;
		
		// Get the current directory
		
		if (isset($_SERVER["CGIA"]))
		  $upload_dir=dirname($_SERVER["CGIA"]);
		else if (isset($_SERVER["ORIG_PATH_TRANSLATED"]))
		  $upload_dir=dirname($_SERVER["ORIG_PATH_TRANSLATED"]);
		else if (isset($_SERVER["ORIG_SCRIPT_FILENAME"]))
		  $upload_dir=dirname($_SERVER["ORIG_SCRIPT_FILENAME"]);
		else if (isset($_SERVER["PATH_TRANSLATED"]))
		  $upload_dir=dirname($_SERVER["PATH_TRANSLATED"]);
		else 
		  $upload_dir=dirname($_SERVER["SCRIPT_FILENAME"]);
		
		
		// Connect to the database
		
		if (!$error && !TESTMODE)
		{ $dbconnection = @mysql_connect($db_server,$db_username,$db_password);
		  if ($dbconnection) 
			$db = mysql_select_db($db_name);
		  if (!$dbconnection || !$db) 
		  { echo ("<p>Database connection failed due to ".mysql_error()."</p>\n");
			$error=true;
		  }
		  if (!$error && $db_connection_charset!=='')
			@mysql_query("SET NAMES $db_connection_charset", $dbconnection);
		}
		else
		{ $dbconnection = false;
		}
		
		
		
		// Single file mode
		
		if (!$error && !isset ($_REQUEST["fn"]) && $filename!="")
		{ 
			$_REQUEST["start"]=1;
			$_REQUEST["fn"]=urlencode($filename);
			$_REQUEST["foffset"]=0;
			$_REQUEST["totalqueries"]=0;
			$_REQUEST["start"]=1;
			#echo ("<p><a href=\"".$_SERVER["PHP_SELF"]."?start=1&amp;fn=".urlencode($filename)."&amp;foffset=0&amp;totalqueries=0\">Start Import</a></p>\n");
		}
		
		
		// Open the file
		
		if (!$error && isset($_REQUEST["start"]))
		{ 
		
		// Set current filename ($filename overrides $_REQUEST["fn"] if set)
		
		  if ($filename!="")
			$curfilename=$filename;
		  else if (isset($_REQUEST["fn"]))
			$curfilename=urldecode($_REQUEST["fn"]);
		  else
			$curfilename="";
		
		// Recognize GZip filename
		
		  if (preg_match("/\.gz$/i",$curfilename)) 
			$gzipmode=true;
		  else
			$gzipmode=false;
		
		  if ((!$gzipmode && !$file=@fopen($curfilename,"r")) || ($gzipmode && !$file=@gzopen($curfilename,"r")))
		  { echo ("<p class=\"error\">Can't open ".$curfilename." for import</p>\n");
			echo ("<p>Please, check that your dump file name contains only alphanumerical characters, and rename it accordingly, for example: $curfilename.".
				   "<br>Or, specify \$filename in bigdump.php with the full filename. ".
				   "<br>Or, you have to upload the $curfilename to the server first.</p>\n");
			$error=true;
		  }
		
		// Get the file size (can't do it fast on gzipped files, no idea how)
		
		  else if ((!$gzipmode && @fseek($file, 0, SEEK_END)==0) || ($gzipmode && @gzseek($file, 0)==0))
		  { if (!$gzipmode) $filesize = ftell($file);
			else $filesize = gztell($file);                   // Always zero, ignore
		  }
		  else
		  { echo ("<p class=\"error\">I can't seek into $curfilename</p>\n");
			$error=true;
		  }
		}
		
		// *******************************************************************************************
		// START IMPORT SESSION HERE
		// *******************************************************************************************
		
		if (!$error && isset($_REQUEST["start"]) && isset($_REQUEST["foffset"]) && preg_match("/(\.(sql|gz|csv))$/i",$curfilename))
		{
		
		// Check start and foffset are numeric values
		
		  if (!is_numeric($_REQUEST["start"]) || !is_numeric($_REQUEST["foffset"]))
		  { echo ("<p class=\"error\">UNEXPECTED: Non-numeric values for start and foffset</p>\n");
			$error=true;
		  }
		
		// Empty CSV table if requested
		
		  if (!$error && $_REQUEST["start"]==1 && $csv_insert_table != "" && $csv_preempty_table)
		  { 
			$query = "DELETE FROM $csv_insert_table";
			if (!TESTMODE && !mysql_query(trim($query), $dbconnection))
			{ echo ("<p class=\"error\">Error when deleting entries from $csv_insert_table.</p>\n");
			  echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");
			  echo ("<p>MySQL: ".mysql_error()."</p>\n");
			  $error=true;
			}
		  }
		
		  
		// Print start message
		
		  if (!$error)
		  { $_REQUEST["start"]   = floor($_REQUEST["start"]);
			$_REQUEST["foffset"] = floor($_REQUEST["foffset"]);
			
			/* if (TESTMODE) 
			 echo ("<p class=\"centr\">TEST MODE ENABLED</p>\n");
			echo ("<p class=\"centr\">Processing file: <b>".$curfilename."</b></p>\n");
			echo ("<p class=\"smlcentr\">Starting from line: ".$_REQUEST["start"]."</p>\n");	*/
			
			
		  }
		
		// Check $_REQUEST["foffset"] upon $filesize (can't do it on gzipped files)
		
		  if (!$error && !$gzipmode && $_REQUEST["foffset"]>$filesize)
		  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer behind the end of file</p>\n");
			$error=true;
		  }
		
		// Set file pointer to $_REQUEST["foffset"]
		
		  if (!$error && ((!$gzipmode && fseek($file, $_REQUEST["foffset"])!=0) || ($gzipmode && gzseek($file, $_REQUEST["foffset"])!=0)))
		  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer to offset: ".$_REQUEST["foffset"]."</p>\n");
			$error=true;
		  }
		
		// Start processing queries from $file
		
		  if (!$error)
		  { $query="";
			$queries=0;
			$totalqueries=$_REQUEST["totalqueries"];
			$linenumber=$_REQUEST["start"];
			$querylines=0;
			$inparents=false;
		
		// Stay processing as long as the $linespersession is not reached or the query is still incomplete
		
			while ($linenumber<$_REQUEST["start"]+$linespersession || $query!="")
			{
		
		// Read the whole next line
		
			  $dumpline = "";
			  while (!feof($file) && substr ($dumpline, -1) != "\n" && substr ($dumpline, -1) != "\r")
			  { if (!$gzipmode)
				  $dumpline .= fgets($file, DATA_CHUNK_LENGTH);
				else
				  $dumpline .= gzgets($file, DATA_CHUNK_LENGTH);
			  }
			  if ($dumpline==="") break;
		
		
		// Stop if csv file is used, but $csv_insert_table is not set
			  if (($csv_insert_table == "") && (preg_match("/(\.csv)$/i",$curfilename)))
			  {
				echo ("<p class=\"error\">Stopped at the line $linenumber. </p>");
				echo ('<p>At this place the current query is from csv file, but $csv_insert_table was not set.');
				echo ("You have to tell where you want to send your data.</p>\n");
				$error=true;
				break;
			  }
			 
		// Create an SQL query from CSV line
		
			  if (($csv_insert_table != "") && (preg_match("/(\.csv)$/i",$curfilename)))
				$dumpline = 'INSERT INTO '.$csv_insert_table.' VALUES ('.$dumpline.');';
		
		// Handle DOS and Mac encoded linebreaks (I don't know if it will work on Win32 or Mac Servers)
		
			  $dumpline=str_replace("\r\n", "\n", $dumpline);
			  $dumpline=str_replace("\r", "\n", $dumpline);
					
		// DIAGNOSTIC
		// echo ("<p>Line $linenumber: $dumpline</p>\n");
		
		// Skip comments and blank lines only if NOT in parents
		
			  if (!$inparents)
			  { $skipline=false;
				reset($comment);
				foreach ($comment as $comment_value)
				{ if (!$inparents && (trim($dumpline)=="" || strpos ($dumpline, $comment_value) === 0))
				  { $skipline=true;
					break;
				  }
				}
				if ($skipline)
				{ $linenumber++;
				  continue;
				}
			  }
		
		// Remove double back-slashes from the dumpline prior to count the quotes ('\\' can only be within strings)
			  
			  $dumpline_deslashed = str_replace ("\\\\","",$dumpline);
		
		// Count ' and \' in the dumpline to avoid query break within a text field ending by ;
		// Please don't use double quotes ('"')to surround strings, it wont work
		
			  $parents=substr_count ($dumpline_deslashed, "'")-substr_count ($dumpline_deslashed, "\\'");
			  if ($parents % 2 != 0)
				$inparents=!$inparents;
		
		// Add the line to query
		
			  $query .= $dumpline;
		
		// Don't count the line if in parents (text fields may include unlimited linebreaks)
			  
			  if (!$inparents)
				$querylines++;
			  
		// Stop if query contains more lines as defined by MAX_QUERY_LINES
		
			  if ($querylines>MAX_QUERY_LINES)
			  {
				echo ("<p class=\"error\">Stopped at the line $linenumber. </p>");
				echo ("<p>At this place the current query includes more than ".MAX_QUERY_LINES." dump lines. That can happen if your dump file was ");
				echo ("created by some tool which doesn't place a semicolon followed by a linebreak at the end of each query, or if your dump contains ");
				echo ("extended inserts. Please read the BigDump FAQs for more infos.</p>\n");
				$error=true;
				break;
			  }
		
		// Execute query if end of query detected (; as last character) AND NOT in parents
		
			  if (preg_match("/;$/",trim($dumpline)) && !$inparents)
			  { if (!TESTMODE && !mysql_query(trim($query), $dbconnection))
				{ echo ("<p class=\"error\">Error at the line $linenumber: ". trim($dumpline)."</p>\n");
				  echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");
				  echo ("<p>MySQL: ".mysql_error()."</p>\n");
				  $error=true;
				  break;
				}
				$totalqueries++;
				$queries++;
				$query="";
				$querylines=0;
			  }
			  $linenumber++;
			}
		  }
		
		// Get the current file position
		
		  if (!$error)
		  { if (!$gzipmode) 
			  $foffset = ftell($file);
			else
			  $foffset = gztell($file);
			if (!$foffset)
			{ echo ("<p class=\"error\">UNEXPECTED: Can't read the file pointer offset</p>\n");
			  $error=true;
			}
		  }
		
		// Print statistics
		
		
		
		// echo ("<p class=\"centr\"><b>Statistics</b></p>\n");
		
		  if (!$error)
		  { 
			$lines_this   = $linenumber-$_REQUEST["start"];
			$lines_done   = $linenumber-1;
			$lines_togo   = ' ? ';
			$lines_tota   = ' ? ';
			
			$queries_this = $queries;
			$queries_done = $totalqueries;
			$queries_togo = ' ? ';
			$queries_tota = ' ? ';
		
			$bytes_this   = $foffset-$_REQUEST["foffset"];
			$bytes_done   = $foffset;
			$kbytes_this  = round($bytes_this/1024,2);
			$kbytes_done  = round($bytes_done/1024,2);
			$mbytes_this  = round($kbytes_this/1024,2);
			$mbytes_done  = round($kbytes_done/1024,2);
		   
			if (!$gzipmode)
			{
			  $bytes_togo  = $filesize-$foffset;
			  $bytes_tota  = $filesize;
			  $kbytes_togo = round($bytes_togo/1024,2);
			  $kbytes_tota = round($bytes_tota/1024,2);
			  $mbytes_togo = round($kbytes_togo/1024,2);
			  $mbytes_tota = round($kbytes_tota/1024,2);
			  
			  $pct_this   = ceil($bytes_this/$filesize*100);
			  $pct_done   = ceil($foffset/$filesize*100);
			  $pct_togo   = 100 - $pct_done;
			  $pct_tota   = 100;
		
			  if ($bytes_togo==0) 
			  { $lines_togo   = '0'; 
				$lines_tota   = $linenumber-1; 
				$queries_togo = '0'; 
				$queries_tota = $totalqueries; 
			  }
		
			  $pct_bar    = "<div style=\"height:15px;width:$pct_done%;background-color:#000080;margin:0px;\"></div>";
			}
			else
			{
			  $bytes_togo  = ' ? ';
			  $bytes_tota  = ' ? ';
			  $kbytes_togo = ' ? ';
			  $kbytes_tota = ' ? ';
			  $mbytes_togo = ' ? ';
			  $mbytes_tota = ' ? ';
			  
			  $pct_this    = ' ? ';
			  $pct_done    = ' ? ';
			  $pct_togo    = ' ? ';
			  $pct_tota    = 100;
			  $pct_bar     = str_replace(' ','&nbsp;','<tt>[         Not available for gzipped files          ]</tt>');
			}
			/*
			echo ("
			<center>
			<table width=\"520\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
			<tr><th class=\"bg4\"> </th><th class=\"bg4\">Session</th><th class=\"bg4\">Done</th><th class=\"bg4\">To go</th><th class=\"bg4\">Total</th></tr>
			<tr><th class=\"bg4\">Lines</th><td class=\"bg3\">$lines_this</td><td class=\"bg3\">$lines_done</td><td class=\"bg3\">$lines_togo</td><td class=\"bg3\">$lines_tota</td></tr>
			<tr><th class=\"bg4\">Queries</th><td class=\"bg3\">$queries_this</td><td class=\"bg3\">$queries_done</td><td class=\"bg3\">$queries_togo</td><td class=\"bg3\">$queries_tota</td></tr>
			<tr><th class=\"bg4\">Bytes</th><td class=\"bg3\">$bytes_this</td><td class=\"bg3\">$bytes_done</td><td class=\"bg3\">$bytes_togo</td><td class=\"bg3\">$bytes_tota</td></tr>
			<tr><th class=\"bg4\">KB</th><td class=\"bg3\">$kbytes_this</td><td class=\"bg3\">$kbytes_done</td><td class=\"bg3\">$kbytes_togo</td><td class=\"bg3\">$kbytes_tota</td></tr>
			<tr><th class=\"bg4\">MB</th><td class=\"bg3\">$mbytes_this</td><td class=\"bg3\">$mbytes_done</td><td class=\"bg3\">$mbytes_togo</td><td class=\"bg3\">$mbytes_tota</td></tr>
			<tr><th class=\"bg4\">%</th><td class=\"bg3\">$pct_this</td><td class=\"bg3\">$pct_done</td><td class=\"bg3\">$pct_togo</td><td class=\"bg3\">$pct_tota</td></tr>
			<tr><th class=\"bg4\">% bar</th><td class=\"bgpctbar\" colspan=\"4\">$pct_bar</td></tr>
			</table>
			</center>
			\n");*/
		
			//echo "Import Successfull";	exit;
			return true; exit;
			
		// Finish message and restart the script
		
			if ($linenumber<$_REQUEST["start"]+$linespersession)
			{ 
			  $error=true;
			}
			else
			{ if ($delaypersession!=0)
				echo ("<p class=\"centr\">Now I'm <b>waiting $delaypersession milliseconds</b> before starting next session...</p>\n");
				if (!$ajax) 
				  echo ("<script language=\"JavaScript\" type=\"text/javascript\">window.setTimeout('location.href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&fn=".urlencode($curfilename)."&foffset=$foffset&totalqueries=$totalqueries\";',500+$delaypersession);</script>\n");
				echo ("<noscript>\n");
				echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&amp;fn=".urlencode($curfilename)."&amp;foffset=$foffset&amp;totalqueries=$totalqueries\">Continue from the line $linenumber</a> (Enable JavaScript to do it automatically)</p>\n");
				echo ("</noscript>\n");
		   
			  echo ("<p class=\"centr\">Press <b><a href=\"".$_SERVER["PHP_SELF"]."\">STOP</a></b> to abort the import <b>OR WAIT!</b></p>\n");
			}
		  }
		  else 
			echo ("<p class=\"error\">Stopped on error</p>\n");
		
		
		
		}
		
		if ($error)
		  #echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."\">Start from the beginning</a> (DROP the old tables before restarting)</p>\n");
		
		if ($dbconnection) mysql_close($dbconnection);
		if ($file && !$gzipmode) fclose($file);
		else if ($file && $gzipmode) gzclose($file);

}

 function escape($str)
	{
		return mysql_real_escape_string($str);
	}

?>