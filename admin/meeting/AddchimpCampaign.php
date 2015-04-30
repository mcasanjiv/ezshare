<?php
$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
//ini_set('display_errors',1);
require_once(_ROOT."/lib/mailchamp/src/config.php");


$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
$Mailchimp_Lists = new Mailchimp_Lists($MailChimp);
$Mailchimp_Campaigns = new Mailchimp_Campaigns($MailChimp);


//ini_set('display_errors',1);
/* start code for chose template*/
$template_id =  $MailchimSetting[0]['template_foder_id'];
	// $ChimpUserList = $massmail->GetMailchimviewchimpTemplate();
	 
	 $types= array('types'=>'user');
     $filters = array('folder_id'=>$template_id);
     $listtamplate   = $Mailchimp_Templates->getList($types, $filters); 
     //echo '<pre>'; print_r($listtamplate);die;
	 $num = count($listtamplate['user']);
     $pagerLink = $objPager->getPager($listtamplate['user'], $RecordsPerPage, $_GET['curP']);
     (count($listtamplate['user']) > 0) ? ($listtamplate['user'] = $objPager->getPageRecords()) : ("");
     
/*end code for chose tempale*/
/* start code for chose segment*/
$ChimpSegmentList = $massmail->GetchimpSegment();
	 //echo '<pre>';print_r($ChimpSegmentList);die;
	 $num = $massmail->numRows();
     $pagerLink = $objPager->getPager($ChimpSegmentList, $RecordsPerPage, $_GET['curP']);
     (count($ChimpSegmentList) > 0) ? ($ChimpSegmentList = $objPager->getPageRecords()) : ("");
     /*end code for chose segment*/
     
     /*start code for submit code*/
      //print_r($_POST);
     
      if(isset($_POST['Submit'])){
      if(!empty($_POST['subject'])){
      //print_r($_POST);die;
     $subject=$_POST['subject'];
     $femail= $_POST['femail'];
     $frname= $_POST['frname'];
     $tname= $_POST['tname'];
     $Tempn= $_POST['Tempn'];
     $Seg= $_POST['Seg'];  
     
   try {
$options= array('list_id'=>$cmpId,'subject'=>$subject,'from_email'=>$femail,'from_name'=>$frname,'to_name'=>$tname ,'template_id'=>$Tempn,'auto_footer'=>false);
//echo "<pre>";print_r($options);die;
$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => $Seg)));
//$segment  = array('match' => 'all','conditions' => array(array('field' => 'static_segment', 'op' => 'eq', 'value' => array('3165','3157'))));
//echo "<pre>";print_r($segment);die;

$content = array('html'=>'some pretty html content','text' => 'text text text *|UNSUB|*');
$addCampaign = $Mailchimp_Campaigns->create('plaintext', $options, $content, $segment);

if(!empty($addCampaign['id'])){
           $data['subject'] = $_POST['subject'];
	        $data['campaign_id'] = $addCampaign['id'];
	        $data['status']='Unsend';
	        //print_r($data);die;
	         $result = $massmail->AddchimpCampaign($data);
            $_SESSION['message']='<div class="success">Campaign successfully added.</div>';
	          header("location:AddchimpCampaign.php");
             exit;
}

//echo "<pre>";print_r($addCampaign);
   
 }
 catch(Exception $e){
    	//echo "Name Already Exist.";
    	$_SESSION['message']='<div class="success">Please Fill All the Fields</div>';
	header("location:AddchimpCampaign.php");
    exit;
    }  
     }
     else {
     echo 'Please Enter the Subject';    
     }
      }
   
     
     
     /*End code for submit code*/
     
require_once("../includes/footer.php");
?>






