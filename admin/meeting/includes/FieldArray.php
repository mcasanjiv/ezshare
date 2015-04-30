<?php 
 if ($_GET['type'] == 'lead') {
   
    $column = array
        (        
        array("colum_name" => "First Name", "colum_value" => "FirstName" ),
        array("colum_name" => "Last Name", "colum_value" => "LastName"),
        array("colum_name" => "Company Name", "colum_value" => "company"),
        array("colum_name" => "Primary Email", "colum_value" => "primary_email"),   
        array("colum_name" => "Title", "colum_value" => "designation"),
        array("colum_name" => "Product", "colum_value" => "ProductID"),
        array("colum_name" => "Product Price", "colum_value" => "product_price"),
        array("colum_name" => "Website", "colum_value" => "Website"),
        array("colum_name" => "Industry", "colum_value" => "Industry"),
        array("colum_name" => "Annual Revenue [".$Config['Currency']."]", "colum_value" => "AnnualRevenue"),
        array("colum_name" => "Number of Employees", "colum_value" => "NumEmployee"),
        array("colum_name" => "Lead Source", "colum_value" => "lead_source"),        
        array("colum_name" => "Lead Status", "colum_value" => "lead_status"),
        array("colum_name" => "Address", "colum_value" => "Address"),
        array("colum_name" => "Zip Code", "colum_value" => "ZipCode"),
        array("colum_name" => "Landline Number", "colum_value" => "LandlineNumber"),
        array("colum_name" => "Mobile", "colum_value" => "Mobile"),
        array("colum_name" => "Description", "colum_value" => "description")
    );

  
} 
?>
