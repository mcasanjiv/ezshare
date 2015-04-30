<?php
session_start();
$output_dir = "upload/emailattachment/";
$output_dir=$output_dir."/".$_SESSION['AdminEmail']."/";

include_once("../includes/settings.php");
$Config['DbName'] = $Config['DbMain'];
$objConfig->dbName = $Config['DbName'];
$objConfig->connect();
	
if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
{
	$fileName =$_POST['name'];

        $fileName=str_replace("[","",$fileName);
        $fileName=str_replace("]","",$fileName);
        $fileName=str_replace('"','',$fileName);
     
	$filePath = $output_dir. $fileName; 

	 if(isset($_POST["type"]) && $_POST["type"] == "Draft"){
        	$select_attach="delete from importemailattachments where FileName='".$fileName."'";
			$attachdatas=mysql_query($select_attach) or die(mysql_error());
			if(!$attachdatas){
				die('null');
			}
       } 
        
	if (file_exists($filePath)) 
	{
          unlink($filePath);
          unset($_SESSION['attcfile'][$fileName]);
        }
        
	echo "Deleted File ".$fileName."<br>";
}

?>
