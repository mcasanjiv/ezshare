<?

class Cartsettings extends dbClass {

    var $tables;

    // consturctor 
    function Cartsettings() {
        global $configTables;
        $this->tables = $configTables;
        $this->dbClass();
    }

    /*     * ************************FUNCTION STARTED FOR CART SETTINGS******************************************** */

     function getCartsettings()
     {
          $sqlSettings =  "SELECT * FROM e_settings WHERE Visible='Yes'";
         return $this->query($sqlSettings, 1);
     }
    
    function getCartSettingsFields($groupID)
    {
         $sqlSettings =  "SELECT * FROM e_settings WHERE Visible='Yes' ".(trim($groupID)!=""?(" AND GroupID='".$groupID."'"):"")." ORDER BY GroupID, Priority";
         return $this->query($sqlSettings, 1);
    }
    
    function updateCartSettingsFields($arrayFields)
    {
        foreach ($arrayFields as $key=>$value)
	{
           $sqlSettings =  "UPDATE e_settings SET Value='".$value."' WHERE Name LIKE '".trim($key)."'";
           $this->query($sqlSettings, 0);
        }
    }
    
    function checkStoreFiled()
    {
         $sqlSettings =  "SELECT * FROM e_settings WHERE Value='' AND Name LIKE 'StoreName'";
         $arrayRows = $this->query($sqlSettings, 1);  
         $numRow = $this->numRows($sqlSettings);
         return $numRow;
    }
    
    /*     * ************************FUNCTION ENDED FOR CART SETTINGS******************************************** */


    /*     * ************************FUNCTION STARTED FOR SHIPPING******************************************** */

    function addShippingMethod($arryDetails) {

        @extract($arryDetails);
        $method_names = array(
            "weight" => "Weight",
            "flat" => "Flat (per item)",
            "price" => "Price-based"
        );
        $MethodName = $method_names[$MethodId];
        $sqlSettings = "INSERT INTO  e_shipping_selected SET CarrierId='" . $CarrierId . "', CarrierName = '" . $this->escape($CarrierName) . "', MethodId = '" . $MethodId . "', MethodName = '" . $MethodName . "',Priority = '" . $Priority . "',Country='" . $Country . "', State = '" . $all_state_id . "',Status='" . $Status . "',Notes=''";
        $this->query($sqlSettings, 0);
        $lastInsertId = $this->lastInsertId();
        return $lastInsertId;
    }

    function getShipingMethods() {
        $sqlSettings = "SELECT * from e_shipping_selected ORDER BY Ssid DESC";
        return $this->query($sqlSettings, 1);
    }

    function getShippingRatesById($Ssid) {
        $sqlSettings = "SELECT * from e_shipping_custom_rates WHERE  Ssid = '".$Ssid."' ORDER BY Srid DESC";
        return $this->query($sqlSettings, 1);
    }

    function getShippingRateById($Srid) {
        $sqlSettings = "SELECT * from e_shipping_custom_rates WHERE Srid = '".$Srid."'";
        return $this->query($sqlSettings, 1);
    }

    function addShippingRate($arryDetails) {
        @extract($arryDetails);


        $sqlSettings = "INSERT INTO  e_shipping_custom_rates SET Ssid='".$Ssid."', RateMin = '" . $RateMin . "', RateMax = '" . $RateMax . "', Price = '" . $Price . "',PriceType = '" . $PriceType . "'";
        $this->query($sqlSettings, 0);
    }

    function updateShippingRate($arryDetails) {
        @extract($arryDetails);

        $sqlSettings = "UPDATE e_shipping_custom_rates SET Ssid='".$Ssid."', RateMin = '" . $RateMin . "', RateMax = '" . $RateMax . "', Price = '" . $Price . "',PriceType = '" . $PriceType . "' WHERE Srid = '".$Srid."'";
        $this->query($sqlSettings, 0);
    }

    function deleteShippingRate($Srid, $Ssid) {
        $strSQLQuery = "DELETE FROM e_shipping_custom_rates WHERE Srid= '".$Srid."' AND Ssid= '".$Ssid."'";
        $this->query($strSQLQuery, 0);
        return 1;
    }

    function getShippingMethodById($Ssid) {

        $sqlSettings = "SELECT * from e_shipping_selected WHERE Ssid = '".$Ssid."'";
        return $this->query($sqlSettings, 1);
    }

    function updateShippingMethod($arryDetails) {
        @extract($arryDetails);

        $sqlSettings = "UPDATE e_shipping_selected SET CarrierName = '" . $CarrierName . "', Priority = '" . $Priority . "', Status = '" . $Status . "' WHERE Ssid = '" .$Ssid."'";
        $this->query($sqlSettings, 0);
    }

    function changeShippingMethodStatus($ShipId) {
        $sqlSettings = "select * from e_shipping_selected where Ssid= '".$ShipId."'";
        $rs = $this->query($sqlSettings);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 'Yes')
                $Status = 'No';
            else
                $Status = 'Yes';

            $sqlSettings = "update e_shipping_selected set Status='".$Status."' where Ssid= '".$ShipId."'";
            $this->query($sqlSettings, 0);
            return true;
        }
    }

    function deleteShippingMethod($ShipId) {

        $sqlSettings = "delete from e_shipping_selected where Ssid = '".$ShipId."'";
        $rs = $this->query($sqlSettings, 0);
        
        $sqlSettings2 = "delete from e_shipping_custom_rates where Ssid = '".$ShipId."'";
        $rs2 = $this->query($sqlSettings2, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function getShippingMethods($countryId, $stateId) {
        /**
         * Select available shipping methods
         */
        $sqlSettings = "SELECT * FROM e_shipping_selected WHERE Status='Yes' ORDER BY Priority";
        $arrayShippingMethods = $this->query($sqlSettings);

        $available_methods = array();


        foreach ($arrayShippingMethods as $shippingData) {
            $accept_countries = explode(",", $shippingData["Country"]);
            $accept_states = explode(",", $shippingData["State"]);

            /**
             * Check do we ship to selected country
             */
            
         
            if (($shippingData["Country"] == 0 || in_array($countryId, $accept_countries))) {
                
                if ($shippingData["State"] == 0 || in_array($stateId, $accept_states)) {

                    $available_methods[] = $shippingData;
                }
            }
        }

        return $available_methods;
    }

    function getCustomShippingPrice($ssid, $weight, $items, $items_price) {

        $sqlSettings = "SELECT * FROM e_shipping_selected WHERE Ssid='" . $ssid . "'";
        $arrayShippingInfo = $this->query($sqlSettings);
        if (!empty($arrayShippingInfo)) {
            $data = $arrayShippingInfo[0];
        }



        $sqlSettings = "SELECT * FROM e_shipping_custom_rates WHERE Ssid = '" . $data["Ssid"] . "' AND
                                        RateMin <= " . ($data["MethodId"] == "flat" ? $items : ($data["MethodId"] == "price" ? $items_price : $weight)) . " AND 
                                        RateMax >= " . ($data["MethodId"] == "flat" ? $items : ($data["MethodId"] == "price" ? $items_price : $weight)) . " ORDER BY RateMin LIMIT 1";


        $arrayCustomRates = $this->query($sqlSettings);

        if (!empty($arrayCustomRates)) {
            switch ($data["MethodId"]) {

                case "weight" : {
                        return $price = $arrayCustomRates[0]["Price"] * $weight;
                        break;
                    }
                case "flat" : {
                        return $price = $arrayCustomRates[0]["Price"] * $items;
                        break;
                    }
                case "price" : {

                        return $price = $arrayCustomRates[0]["PriceType"] == "amount" ? $arrayCustomRates[0]["Price"] : (($items_price / 100) * $arrayCustomRates[0]["Price"]);
                        break;
                    }
                default : {
                        $error_message = "Incorrect shipping method. Please try again.";
                        return false;
                    }
            }
        } else {
            $error_message = "Can't determinate shipping price. Please try again.";
            return false;
        }
    }

    function getCustomShippingPriceBySsid($ssid, $MethodId, $weight, $items, $items_price) {

        $sqlSettings = "SELECT * FROM e_shipping_custom_rates WHERE Ssid = '" . $ssid . "' AND
                               RateMin <= " . ($MethodId == "flat" ? $items : ($MethodId == "price" ? $items_price : $weight)) . " AND 
                               RateMax >= " . ($MethodId == "flat" ? $items : ($MethodId == "price" ? $items_price : $weight)) . " ORDER BY RateMin";
        // echo "=>".$sqlSettings;exit;
        // $sqlSettings = "SELECT * FROM e_shipping_custom_rates WHERE Ssid = '".$ssid."'";



        return $this->query($sqlSettings, 1);
    }

    /*     * *******************FUNCTION ENDED FOR SHIPPING************************************ */

    /*     * *******************************Functions For Taxes*********************************** */

    function CheckTaxClass($ClassName) {
        $sqlSettings = "SELECT * from e_tax_classes WHERE  LCASE(ClassName) = '".strtolower(trim($ClassName))."'";
        return $this->query($sqlSettings, 1);
    }

    function addTaxClass($arryDetails) {
        @extract($arryDetails);
        $sqlSettings = "INSERT INTO  e_tax_classes SET ClassName='".addslashes($ClassName). "', ClassDescription = '".addslashes($ClassDescription)."',Status='".$Status."'";
        $this->query($sqlSettings, 0);
    }

    function getTaxClasses() {
        $sqlSettings = "SELECT * from e_tax_classes  ORDER BY ClassId DESC ";
        return $this->query($sqlSettings, 1);
    }

    function getClasses() {
        $sqlSettings = "SELECT * from e_tax_classes WHERE Status = 'Yes' ORDER BY ClassId DESC ";
        return $this->query($sqlSettings, 1);
    }

    function getTaxClassById($id) {
        $sqlSettings = "SELECT * from e_tax_classes WHERE ClassId = '".$id."'";
        return $this->query($sqlSettings, 1);
    }

    function updateTaxClass($arryDetails) {
        @extract($arryDetails);
        $sqlSettings = "UPDATE  e_tax_classes SET ClassName='".addslashes($ClassName)."', ClassDescription = '" .addslashes($ClassDescription). "',Status='" . $Status . "' WHERE ClassId = '".$taxclassId."'";
        $this->query($sqlSettings, 0);
    }

    function deleteTaxClass($id) {

        $sqlSettings = "DELETE from e_tax_classes where ClassId = '".$id."'";
        $rs = $this->query($sqlSettings, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function changeTaxClassStatus($id) {
        $sqlSettings = "select * from e_tax_classes where ClassId = '".$id."'";
        $rs = $this->query($sqlSettings);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 'Yes')
                $Status = 'No';
            else
                $Status = 'Yes';

            $sqlSettings = "update e_tax_classes set Status='" . $Status . "' where ClassId = '".$id."'";
            $this->query($sqlSettings, 0);
            return true;
        }
    }

    function addTax($arryDetails) {
        @extract($arryDetails);

        $UserLevel = $arryDetails['user_level'][0] . "," . $arryDetails['user_level'][1];
        $UserLevel = rtrim($UserLevel);

        $sqlSettings = "INSERT INTO e_tax_rates SET ClassId='" . $ClassId . "', Coid = '" . $Coid . "', Stid ='" . $main_state_id . "', TaxRate ='" . $TaxRate . "', UserLevel= '" . $UserLevel . "', RateDescription = '" .addslashes($RateDescription)."', Status='" . $Status . "'";
        $this->query($sqlSettings, 0);
		
    }

    function getTaxes() {
        $sqlSettings = "SELECT * from e_tax_rates ORDER BY RateId DESC";
        return $this->query($sqlSettings, 1);
    }

    function getTaxClassName($classID) {
        $sqlSettings = "select ClassName from e_tax_classes where ClassId = '".$classID."'";
        return $this->query($sqlSettings, 1);
    }

    function getTaxById($id) {
        $sqlSettings = "SELECT * from e_tax_rates WHERE RateId = '".$id."'";
        return $this->query($sqlSettings, 1);
    }

    function updateTax($arryDetails) {
        @extract($arryDetails);

        $UserLevel = $arryDetails['user_level'][0] . "," . $arryDetails['user_level'][1];
        $UserLevel = rtrim($UserLevel);

        $sqlSettings = "UPDATE  e_tax_rates SET ClassId='" . $ClassId . "', Coid = '" . $Coid . "', Stid ='" . $main_state_id . "', TaxRate ='" . $TaxRate . "', UserLevel= '" . $UserLevel . "', RateDescription = '" . $RateDescription . "', Status='" . $Status . "' WHERE RateId= '".$taxId."'";
        $this->query($sqlSettings, 0);
    }

    function deleteTax($id) {

        $sqlSettings = "DELETE from e_tax_rates where RateId = '".$id."'";
        $rs = $this->query($sqlSettings, 0);

        if (sizeof($rs))
            return true;
        else
            return false;
    }

    function changeTaxStatus($id) {
        $sqlSettings = "select * from e_tax_rates where RateId = '".$id."'";
        $rs = $this->query($sqlSettings);
        if (sizeof($rs)) {
            if ($rs[0]['Status'] == 'Yes')
                $Status = 'No';
            else
                $Status = 'Yes';

            $sqlSettings = "update e_tax_rates set Status='" . $Status . "' where RateId = '".$id."'";
            $this->query($sqlSettings, 0);
            return true;
        }
    }

    function getTaxRates($classId, $countryId, $stateId) {

        $sqlSettings = "SELECT * FROM e_tax_rates WHERE ClassId = '" . $classId . "' AND (Coid = '" . $countryId . "' OR Coid = '0') AND  (Stid = '" . $stateId . "' OR Stid = '0') AND Status='Yes'";
        $arrayTaxRates = $this->query($sqlSettings, 1);
        $TotalTaxRate = 0;
        
        if(!empty($_SESSION['GroupID'])){
                    $GroupID = $_SESSION['GroupID'];
                }else{
                    $GroupID = 0;
                }
                
                 $UserLevelID = $arrayTaxRates[0]["UserLevel"];
                 $UserLevelID = explode(",",$UserLevelID);
                 
                    foreach($UserLevelID as $grpID)
                    {
                        $arrayUserLevelID[] = $grpID;
                    }   
                    
                     if(in_array($GroupID,$arrayUserLevelID))
                     {            
                    
                            foreach ($arrayTaxRates as $taxrate) {
                                $TotalTaxRate += $taxrate['TaxRate'];
                                $TaxDescription .= $taxrate['RateDescription'] . "(" . number_format($taxrate['TaxRate'], 2) . "%)" . ",";
                            }

                            $TaxDescription = rtrim($TaxDescription, ",");
                            return $TotalTaxRate . "#" . $TaxDescription;
                      }else{
                          return "NoTaxes";
                      }  
                      
        
    }
		function isTaxClassExists($ClassName,$id=0)
		{

			$strSQLQuery ="select ClassId from e_tax_classes where LCASE(ClassName)='".strtolower(trim($ClassName))."'";
			
			$arryRow = $this->query($strSQLQuery, 1);
			if (!empty($arryRow[0]['ClassId'])) {
			 return true;
			} else {
			 return false;
			}
		}
    /*     * ***************************************************************End Functions For Taxes****************************************************************** */
}

?>
