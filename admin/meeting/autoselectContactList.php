<?php

include_once("../includes/settings.php");
 $return_arr = array();
 $fetch = "select c.AddId as ContactID,c.FullName as fullname, c.Email as Email from s_address_book c WHERE Email LIKE '%".$_GET['q']."%' AND AdminID='".$_GET['AdminID']."' AND status=1 AND AddType='contact' order by Email LIMIT 10 " ;
 $query=mysql_query($fetch) or mysql_error($fetch);
while ($row = mysql_fetch_array($query)) {
    $row_array['id'] = $row['ContactID'];
    $row_array['name'] =$row['fullname'];
    $row_array['email'] =$row['Email'];
	
    array_push($return_arr,$row_array);
}

foreach ($return_arr as $k => $v) {
  $tArray[$k] = $v['id'];
}
 $max_value = max($tArray);
 
 array_push($return_arr,array('id'=>mt_rand(1000,100000),'email'=>$_GET[q]));

//print_r($return_arr);
 //array_push($return_arr,array('name'=>$_GET[q]));

$json_response= json_encode($return_arr);


if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

echo $json_response;


?>