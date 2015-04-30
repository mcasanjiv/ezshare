<?php  	
include_once("../includes/settings.php");
require_once($Prefix."classes/lead.class.php");
$objLead=new lead();

/*************************/
$arryLead=$objLead->ListLead('',$_GET['key'],$_GET['sortby'],$_GET['asc']);
$num=$objLead->numRows();

/*$pagerLink=$objPager->getPager($arryLead,$RecordsPerPage,$_GET['curP']);
(count($arryLead)>0)?($arryLead=$objPager->getPageRecords()):("");
/*************************/

$filename = "LeadList_".date('d-m-Y').".xls";
if($num>0){
	header("Expires: Sat, 01 Jan 2000 00:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Cache-Control: public");
	header("Content-Description: File Transfer");

	session_cache_limiter("must-revalidate");
	header("Content-Type: application/vnd.ms-excel");
	header('Content-Disposition: attachment; filename="' . $filename .'"');

	$header = "Lead Name\tCompany\tPhone\tPrimaryEmail\tSales Person\tStatus\tCreated Date";

	$data = '';$Line=0;
	foreach($arryLead as $key=>$values){

	$Line++;
		/* if($values['Status'] ==1){
			  $status = 'Active';
		 }else{
			  $status = 'InActive';
		 }*/
		 //$status=
        //$leadName=stripslashes($values["FirstName"])." ".stripslashes($values["LastName"]);

		$CreatedDate = ($values['UpdatedDate']>0)?(date($Config['DateFormat'], strtotime($values['UpdatedDate']))):(NOT_SPECIFIED);

		$line = stripslashes($values["FirstName"])." ".stripslashes($values["LastName"])."\t".stripslashes($values["company"])."\t".stripslashes($values["LandlineNumber"])."\t".stripslashes($values['primary_email'])."\t".stripslashes($values["AssignTo"])."\t".stripslashes($values["lead_status"])."\t".$CreatedDate."\n";

		$data .= trim($line)."\n";
	}

	$data = str_replace("\r","",$data);

	print "$header\n\n$data"; 

}else{
	echo "No record found.";
}
exit;
?>

