<?php
$FancyBox=1;
$ThisPageName = 'mailchimp.php';
$EditPage = 1;

require_once("../../define.php");
require_once("../includes/header.php");
require_once(_ROOT."/lib/mailchamp/src/config.php");

$Mailchimp_Templates = new Mailchimp_Templates($MailChimp);
//ini_set('display_errors',1);

if($_POST){
    $template_id =  $MailchimSetting[0]['template_foder_id'];
    $name = trim($_POST['name']);
	$html = $_POST['description'];
	try{
	$addtamplate   = $Mailchimp_Templates->add($name, $html, $template_id); 
	$data['name'] =  $name;
	$data['template_id'] =  $addtamplate['template_id'];
	$result = $massmail->insert( 'c_mail_chimp_templates', $data);
    $_SESSION['message']='<div class="success">Template successfully added.</div>';
	header("location:addchimpTemplate.php");
    exit;
	}catch(Exception $e) {	
	$_SESSION['message']='<div class="error">This template already exists.</div>';
	header("location:addchimpTemplate.php");
	exit;
	}
}
require_once("../includes/footer.php"); 
?>






