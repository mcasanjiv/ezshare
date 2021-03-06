<?
//$lati = '28.5479767'; $longi = '77.3216057';

$full_address = 'Laxmi Nagar, New Delhi, South - East, Delhi, India';
$url = "http://maps.google.com/maps/geo";



/*
function get_lat_long($address){
	
   $address = str_replace(" ", "+", $address);

   $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
   $json = json_decode($json);

   $lat = $json->results[0]->geometry->location->lat;
   $long = $json->results[0]->geometry->location->lng;
   return $lat.','.$long;
}
get_lat_long($full_address);
*/


$address = str_replace(" ", "+", $full_address);

$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
$json = json_decode($json);

$lati = $json->results[0]->geometry->location->lat;
$longi = $json->results[0]->geometry->location->lng;



/*
if(empty($lati)){

	$url .= strpos($url, '?')!==false ? '&' : '?';
	$url .= 'q='.urlencode(preg_replace('#\r|\n#', ' ',$full_address))."&output=csv";

	$cinit = curl_init();
	curl_setopt($cinit, CURLOPT_URL, $url);
	curl_setopt($cinit, CURLOPT_HEADER,0);
	curl_setopt($cinit, CURLOPT_USERAGENT, $_SERVER["HTTP_USER_AGENT"]);
	curl_setopt($cinit, CURLOPT_RETURNTRANSFER, 1);
	$response = curl_exec($cinit);
	echo '<pre>';print_r($response);exit;

	$result = explode(',', $response);
	$lati = $result[2];
	$longi = $result[3];

	echo $lati.', '.$longi;
}*/

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title>Google Maps</title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAU1_kUFMV45zBa8T1md3LShSgCYbUgryUBZyaySvu5bSJG3mx7xSaCqyo0OVQrNCKmRDMuPeV8tZOlA" type="text/javascript"></script>
  </head>
  <body onunload="GUnload()">


    <!-- the div where the map will be displayed -->
    <div id="map" style="width: 550px; height: 450px"></div>
    
    <!-- fail nicely if the browser has no Javascript -->
    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>

    <script type="text/javascript">
    //<![CDATA[
	var lati = <?=$lati?>;
	var longi = <?=$longi?>;

    if (GBrowserIsCompatible()) {

      function createMarker(point,html) {
		var MapIcon = new GIcon(G_DEFAULT_ICON, "colour086.png");
       // var marker = new GMarker(point);
        var marker = new GMarker(point,MapIcon);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng(lati,longi), 9);
    


		/*
      var point = new GLatLng( 43.65654,-79.90138);
      var marker = createMarker(point,'Some stuff to display in the<br>First Info Window <br>With a <a href="http://www.econym.demon.co.uk">Link</a> to my home page')
      map.addOverlay(marker);

      var point = new GLatLng(43.91892,-78.89231);
      var marker = createMarker(point,'Some stuff to display in the<br>Second Info Window with an image<br><img src="image.jpg" width=150 height=100>')
      map.addOverlay(marker);

      var point = new GLatLng(43.82589,-79.10040);
      var marker = createMarker(point,'<h3>All the usual html formatting commands work</h3>')
      map.addOverlay(marker);

		*/

      var point = new GLatLng(lati,longi);
      var marker = createMarker(point,'<div style="background-color:#FFFF88; font-family:cursive; border:solid 3px black;" ><?=$full_address?><br>Avoid using width settings<br><a href="#">View Details</a></div>')
      map.addOverlay(marker);


    }

    
    else {
      alert("Sorry, the Google Maps API is not compatible with this browser");
    }

    // This Javascript is based on code provided by the
    // Blackpool Community Church Javascript Team
    // http://www.commchurch.freeserve.co.uk/   
    // http://www.econym.demon.co.uk/googlemaps/

    //]]>
    </script>
  </body>

</html>




