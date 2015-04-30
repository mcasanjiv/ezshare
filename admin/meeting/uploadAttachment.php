<?php
session_start();
$output_dir = "upload/emailattachment/";
if(isset($_FILES["myfile"]))
{
	
        $output_dir=$output_dir."/".$_SESSION['AdminEmail']."/";
        
        
        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0777);
            
        } 
        
        
        $ret = array();

	$error =$_FILES["myfile"]["error"];
	//You need to handle  both cases
	//If Any browser does not support serializing of multiple files using FormData() 
	if(!is_array($_FILES["myfile"]["name"])) //single file
	{
                
 	 	$fileName = $_FILES["myfile"]["name"];
                
                $file_data=pathinfo($fileName);
                $file_data['extension'];
                $file_data['filename']; // since PHP 5.2.0
                
                $fileName=$file_data['filename']."_".time().".".$file_data['extension'];
               
 		if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName))
                {
                   chmod($output_dir.$fileName, 777);
                   $_SESSION['attcfile'][$fileName]=$fileName;
                     
                }
                
    	$ret[]= $fileName;
	}
	else  //Multiple files, file[]
	{
          
          //echo "multtiiii"; exit;
	  $fileCount = count($_FILES["myfile"]["name"]);
	  for($i=0; $i < $fileCount; $i++)
	  {
	  	$fileName = $_FILES["myfile"]["name"][$i];
		move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
	  	$ret[]= $fileName;
	  }
	
	}
     
    //echo $ret; 
     echo json_encode($ret);
 }
 ?>
