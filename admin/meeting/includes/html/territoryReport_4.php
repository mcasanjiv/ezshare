
<script language="JavaScript1.2" type="text/javascript">
    function ResetSearch() {
        $("#prv_msg_div").show();
        $("#frmSrch").hide();
        $("#preview_div").hide();
    }
    
    
 $(document).ready(function(){
     
     $("#country").change(function(){
         var country = $("#country").val();
         var current_territory = $("#current_territory").val();
         
         var SendParam = 'country=' + country +'&current_territory='+current_territory+'&action=getTerritory&r='+Math.random();
                        $.ajax({
			type: "GET",
			async:false,
			url: 'ajax.php',
			data: SendParam,
			success: function (responseText) {
				
				$("#TerritoryList").html(responseText);
			}
                        
                      });
                   });
                 
                 
           /******************************************************************************************/
           
                var current_country = $("#current_country").val();
                var current_territory = $("#current_territory").val();
                
                var SendParam = 'country=' + current_country +'&current_territory='+current_territory+'&action=getTerritory&r='+Math.random();
                           $.ajax({
                           type: "GET",
                           async:false,
                           url: 'ajax.php',
                           data: SendParam,
                           success: function (responseText) {
                                   
                                   $("#TerritoryList").html(responseText);
                           }

                         });
           
           /***************************************************************************************/
       });
       
    </script>         


<div class="had"><?= $MainModuleName ?></div>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
              <form onsubmit="return ValidateSearch();" method="get" action="territoryReport.php" name="topForm">	
                <table cellspacing="0" cellpadding="0" border="0" style="margin:0;" id="search_table"> 
              
                <tbody>
                    <tr>

                        <td align="right" class="blackbold">Select Country  :</td>
                        <td>
                        <select name="country" id="country" class="inputbox">
                                        <option value="">---Select Country---</option>
                                        <?php  foreach ($arryCountry as $key => $values) {?>
                                            <option value="<?=$values["country_id"]?>" <?php  if($_GET['country'] == $values["country_id"]){echo "selected";}?>><?=$values["name"]?></option>
                                        <?php }?>

                                    </select>
                        </td>
                        <td>&nbsp;</td> 
                        <td align="right" class="blackbold">Select Territory  :</td>
                        <td>
                            
                        <select name="TerritoryList" id="TerritoryList" class="inputbox">
                                        <option value="">--- Select Territory ---</option>

                                    </select>

                     </td> 


                    <td>
                        <input type="hidden" name="current_territory" id="current_territory" value="<?=$_GET['TerritoryList'];?>">
                         <input type="hidden" name="current_country" id="current_country" value="<?=$_GET['country'];?>">
                         <input type="submit" value="Go" class="search_button" name="s">

                         </td> 
                </tr>

                </tbody>
              
                </table>
                  
                    </form>
            <br>
            
            <table cellspacing="0" cellpadding="0" border="0" style="margin:0; width: 100%;" id="search_table"> 
            <tr>

                <td>
                    <?php
                    function get_lat_long($address){

                       $address = str_replace(" ", "+", $address);

                       $json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&region=$region");
                       $json = json_decode($json);

                       $lat = $json->results[0]->geometry->location->lat;
                       $long = $json->results[0]->geometry->location->lng;
                       return $lat.','.$long;
                    }


                ?>
                    
       <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAPDUET0Qt7p2VcSk6JNU1sBRRwPhutbWBmyj82Go_H6JlE7EvFBSKFFFHFePAwvib9UM0geoA3Pgafw" type="text/javascript"></script>
        <div id="map" style="width: 1100px; height: 450px"></div> 
            <script type="text/javascript">
    //<![CDATA[

    if (GBrowserIsCompatible()) {

      function createMarker(point,html) {
		var MapIcon = new GIcon(G_DEFAULT_ICON, "<?=$googleMarkup;?>");
       // var marker = new GMarker(point);
        var marker = new GMarker(point,MapIcon);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

        <?
            $latlong = get_lat_long($arryCustomer[0]['CityName'], $arryCustomer[0]['StateName'], $arryCustomer[0]['CountryName']);
            $aryLatlng = explode(",",$latlong);
            $lat = $aryLatlng[0];
            $long = $aryLatlng[1];
        ?>

      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
      map.setCenter(new GLatLng('<?=$lat?>','<?=$long?>'), 5);
      
      
    
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'New Delhi, Delhi, India')
      map.addOverlay(marker);


<?
$latlong = get_lat_long('Agra, Uttar Pradesh, India');
$aryLatlng = explode(",",$latlong);
$lat = $aryLatlng[0];
$long = $aryLatlng[1];
?>
	
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'Agra, Uttar Pradesh, India')
      map.addOverlay(marker);
	

<?
$latlong = get_lat_long('Mumbai, India');
$aryLatlng = explode(",",$latlong);
$lat = $aryLatlng[0];
$long = $aryLatlng[1];
?>
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'Mumbai, India')
      map.addOverlay(marker);


<?
$latlong = get_lat_long('Jhansi, India');
$aryLatlng = explode(",",$latlong);
$lat = $aryLatlng[0];
$long = $aryLatlng[1];
?>
      var point = new GLatLng('<?=$lat?>','<?=$long?>');
      var marker = createMarker(point,'Jhansi, India')
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
                  
                </td>
                 </tr>       
            
            </table>
             <br>

           <table <?= $table_bg ?>>
                <tr align="left" >
			    	<td width="12%" height="20"  class="head1">Customer Code</td>
                    <td width="15%" height="20"  class="head1">Customer Name</td>    
                    <td height="20"  class="head1">Email Address</td>  
                    <td width="10%" height="20"  class="head1" >Phone</td>    
                    <td width="10%" height="20"  class="head1" >Country</td> 
                    <td width="10%" height="20"  class="head1" >State</td> 
                    <td width="10%" height="20"  class="head1" >City</td> 
                </tr>
                <?             
               
                if($num > 0) {
                    $flag=true;                   
                    foreach ($arryCustomer as $key => $values) {
                        $flag=!$flag;	                      
                        //$NumInvoice=$objCustomer->CountCustomerOrder($values['CustCode'],'Invoice');
                        ?>
                        <tr align="left">
			 <td><a class="fancybox fancybox.iframe" href="../custInfo.php?view=<?=$values['CustCode']?>" ><?=$values['CustCode']?></a></td>
                            <td><?=stripslashes($values['FullName'])?></td>
                            <td><?=$values['Email']?></td>
                            <td><?=stripslashes($values['Landline'])?></td>
                            <td><?=stripslashes($values['CountryName'])?></td>
                            <td><?=stripslashes($values['StateName'])?></td>
                            <td><?=stripslashes($values['CityName'])?></td>
                            
                          
                        </tr>
                    <?php } // foreach end //?>
                <?php } else { ?>
                    <tr align="center" >
                        <td height="20" colspan="7"  class="no_record"><?=NO_CUSTOMER?></td>
                    </tr>
                <?php } ?>

                <tr>  <td height="20" colspan="7" ></td>
                </tr>
            </table>
        </td>
    </tr>


</table>
