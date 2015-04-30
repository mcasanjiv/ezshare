<?php  include ('includes/function.php');
/**************************************************************/
$ThisPageName = 'editmeeting_popup.php'; $EditPage = 1;
/**************************************************************/

ValidateCrmSession();

	require_once("../classes/company.class.php");
	require_once("../classes/admin.class.php");

	require_once("../classes/user.class.php");
	require_once("../classes/configure.class.php");
	require_once("../includes/browser_detection.php");
	
	require_once("../classes/meeting.class.php");
	
	$objConfig=new admin();
	$objCompany=new company();
	$objUser=new user();
	$objMeeting=new Meeting();
				$Config['DbName'] = $_SESSION['CmpDatabase'];
				$objConfig->dbName = $Config['DbName'];
				$objConfig->connect();
               $meeting = $objMeeting->getMeeting();

/*    edit the meetings * ************** */
if (!empty($_GET['edit'])) { 
    $arryMeeting = $objMeeting->GetMeeting($_GET['edit'], '');
    $arryMeetingDetail = $objMeeting->GetMeeting($_GET['edit'], '');
   //print_r($arryMeeting) ; die('JI');
    $meeting_Id = $_REQUEST['edit']; 
    if (empty($arryMeeting[0]['meeting_Id'])) {
        header('location:' . $RedirectURL);
        exit;
    }
     if ($_POST['SubmitButton']) { 
                $createDate  = $_GET['createDate']; 
                $createtime  = $_GET['createtime']; 
                $duration    = $_GET['duration']; 
                $objMeeting->UpdateMeeting($_POST);
               
              //  $_SESSION['mess_lead'] = LEAD_UPDATED;
    } 
    
   
} 
?>

<script type="text/javascript" src="js/jquery.min.js"></script>
<link rel="stylesheet" href="../fancybox/jquery_calender/jquery-ui.css" />

<script type="text/javascript" src="../fancybox/lib/jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="../fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="../fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<link rel="stylesheet" href="../fancybox/jquery_calender/jquery-ui_Backup.css" />

<script src="../fancybox/jquery_calender/jquery-ui.js"></script>
<link rel="stylesheet" href="../fancybox/timepicker/jquery.timepicker.css" />
<script src="../fancybox/timepicker/jquery.timepicker.js"></script>
                                              
                                              

<div style=''>
			<div id='editMeeting'  aria-hidden="false" aria-labelledby="myModalLabel1" role="dialog" tabindex="-1">
				    
					        <form  method="post" id="schedulemeeting-form" name="schedulemeeting-form" class="form-horizontal no-margin" enctype="multipart/form-data">
                               <div class="modal-header">
                               
                                  <div class="title" style="font-size:15px; text-align:center;"> 
									Update Meeting 
									
                                  </div>
                                 
							  </div>	
                            <div class="widget-body cj-widget">
                                          <div class="control-group">
                                             <label class="control-label">
                                            Date of creating  
                                             </label>
                                           <!--    <div class="controls controls-row">
                                                <input class="span4" type="text" name="createdate" placeholder="Please Enter Created Date.." required>
                                             </div>-->
                                             
                                              <div class="controls controls-row">
                                               <? if ($arryMeeting[0]['createDate'] > 0) $MeetingDate = $arryMeeting[0]['createDate']; ?>	
                                               <script type="text/javascript">                   
                                                     $(function() {
	                                                  $("#createDate").datepicker({
                                                        showOn: "both",
                                                        yearRange: '<?= date("Y") - 20 ?>:<?= date("Y") ?>',
                                                        dateFormat: 'yy-mm-dd',
                                                        maxDate: "+0D",
                                                        changeMonth: true,
                                                        changeYear: true
                                                                });
                                                              });
                                                  </script>	
                                
                                                <input  type="text" id="createDate" name="createDate" class="datebox" value="<?= $MeetingDate ?>">
                                             </div>
                                             
                                          </div>
										  
										   
										   <div class="control-group">
                                             <label class="control-label">
                                            Time
                                             </label>
                                             <div class="controls controls-row">
                                                <input class="span4" type="text" name="createtime" id="createtime" value="<?php echo stripslashes($arryMeeting[0]['createtime']); ?>">
                                             </div>
                                          </div>
										   <div class="control-group">
                                             <label class="control-label">
                                            Time Duration
                                             </label>
                                             <div class="controls controls-row">
          <!-- <input class="span4" type="text" name="duration" id="duration" value="<?php echo stripslashes($arryMeeting[0]['duration']); ?>"> -->
                                              <select class="span4" name="duration" id="duration" value="<?php echo stripslashes($arryMeeting[0]['duration']); ?>" style="width:240px">
                                               <option value="<?php echo stripslashes($arryMeeting[0]['duration']); ?>"><?php echo stripslashes($arryMeeting[0]['duration']); ?> min</option>
                                               <option value="20">20 min</option>
                                               <option value="30">30 min</option>
                                               <option value="60">60 min</option>
                                               <option value="120">120 min</option>
                                               <option value="180">180 min</option>
                                               </select>
                                             </div>
                                          </div>
										  
                                    </div>
                                 
                             <div class="modal-footer">
     <? if ($_GET['edit'] > 0) $ButtonTitle = 'Update ';     
          else $ButtonTitle = ' Submit '; ?>
                                <button type="submit" class="btn btn-success remove-margin" value="<?= $ButtonTitle ?>" name="SubmitButton"> Save</button>
                                <input type="hidden" name="meeting_Id" id="meeting_Id" value="<?= $_GET['edit'] ?>" />
                              </div>
							  </form>
                           </div>
						 </div>
                  </div>
				  
                </div>
<style>
<!--
Start popup css
-->

.modal {
	position: fixed;
	top: 10%;
	left: 50%;
	z-index: 1050;
	width: 560px;
	margin-left: -280px;
	background-color: white;
	*border: 1px solid #999999;
	/* IE6-7 */
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-moz-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
	/* FF3.5+ */
	-webkit-box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
	/* Saf3.0+, Chrome */
	box-shadow: 0 3px 7px rgba(0, 0, 0, 0.3);
	/* Opera 10.5, IE9 */
	-webkit-box-sizing: padding-box;
	-moz-box-sizing: padding-box;
	box-sizing: padding-box;
	outline: none;
}
.modal.fade {
	-webkit-transition: top 0.3s ease-out, top 0.3s ease-out;
	-moz-transition: top 0.3s ease-out, top 0.3s ease-out;
	-ms-transition: top 0.3s ease-out, top 0.3s ease-out;
	-o-transition: top 0.3s ease-out, top 0.3s ease-out;
	transition: top 0.3s ease-out, top 0.3s ease-out;
	top: -25%;
}
.modal.fade.in {
	top: 10%;
}

.modal-header {
	padding: 9px 15px;
	border-bottom: 1px solid #eeeeee;
	background: none repeat scroll 0 0 #F4F4F4;
}
.modal-header .close {
	margin-top: 2px;
}
.modal-header h3 {
	margin: 0;
	line-height: 30px;
}

.modal-body {
	position: relative;
	overflow-y: auto;
	max-height: 440px;
	padding: 15px;
}

.modal-form {
	margin-bottom: 0;
}

.modal-footer {
	padding: 11px 15px 11px;
	margin-bottom: 0;
	text-align: center;
	background-color: #f4f4f4;
	border-top: 1px solid #d1d1d1;
	-webkit-border-radius: 0 0 4px 4px;
	-moz-border-radius: 0 0 4px 4px;
	border-radius: 0 0 4px 4px;
	-webkit-box-shadow: 0 1px 0 white inset;
	-moz-box-shadow: 0 1px 0 white inset;
	box-shadow: 0 1px 0 white inset;
	*zoom: 1;
}
.modal-footer:before {
	display: table;
	content: "";
	line-height: 0;
}
.modal-footer:after {
	display: table;
	content: "";
	line-height: 0;
	clear: both;
}
.modal-footer .btn + .btn {
	margin-left: 5px;
	margin-bottom: 0;
}
.modal-footer .btn-group .btn + .btn {
	margin-left: -1px;
}
.modal-footer .btn-block + .btn-block {
	margin-left: 0;
}

.control-group.warning .control-label, .control-group.warning .help-block, .control-group.warning .help-inline, .control-group.warning .checkbox, .control-group.warning .radio, .control-group.warning input, .control-group.warning select, .control-group.warning textarea {
	color: #f3cf59;
}
.control-group.warning input, .control-group.warning select, .control-group.warning textarea {
	border-color: #f3cf59;
}
.control-group.warning input:focus, .control-group.warning select:focus, .control-group.warning textarea:focus {
	border-color: #f0c129;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #f6dd89;
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #f6dd89;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #f6dd89;
}
.control-group.warning .input-prepend .add-on, .control-group.warning .input-append .add-on {
	color: #f3cf59;
	background-color: #faebb8;
	border-color: #f3cf59;
}
.control-group.error .control-label, .control-group.error .help-block, .control-group.error .help-inline, .control-group.error .checkbox, .control-group.error .radio, .control-group.error input, .control-group.error select, .control-group.error textarea {
	color: #e84f4c;
}
.control-group.error input, .control-group.error select, .control-group.error textarea {
	border-color: #e84f4c;
}
.control-group.error input:focus, .control-group.error select:focus, .control-group.error textarea:focus {
	border-color: #e2231f;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #ee7b79;
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #ee7b79;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #ee7b79;
}
.control-group.error .input-prepend .add-on, .control-group.error .input-append .add-on {
	color: #e84f4c;
	background-color: #f4a8a6;
	border-color: #e84f4c;
}
.control-group.success .control-label, .control-group.success .help-block, .control-group.success .help-inline, .control-group.success .checkbox, .control-group.success .radio, .control-group.success input, .control-group.success select, .control-group.success textarea {
	color: #6ac280;
}
.control-group.success input, .control-group.success select, .control-group.success textarea {
	border-color: #6ac280;
}
.control-group.success input:focus, .control-group.success select:focus, .control-group.success textarea:focus {
	border-color: #48b162;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #8ed19f;
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #8ed19f;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #8ed19f;
}
.control-group.success .input-prepend .add-on, .control-group.success .input-append .add-on {
	color: #6ac280;
	background-color: #b2e0be;
	border-color: #6ac280;
}
.control-group.info .control-label, .control-group.info .help-block, .control-group.info .help-inline, .control-group.info .checkbox, .control-group.info .radio, .control-group.info input, .control-group.info select, .control-group.info textarea {
	color: #4a98c9;
}
.control-group.info input, .control-group.info select, .control-group.info textarea {
	border-color: #4a98c9;
}
.control-group.info input:focus, .control-group.info select:focus, .control-group.info textarea:focus {
	border-color: #337ead;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #71aed5;
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #71aed5;
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075) 0 0 6px #71aed5;
}
.control-group.info .input-prepend .add-on, .control-group.info .input-append .add-on {
	color: #4a98c9;
	background-color: #99c5e0;
	border-color: #4a98c9;
}
.controls-row [class*="span"] + [class*="span"] {
		margin-left: 0;
	}
.form-horizontal .control-group {
	margin-bottom: 10px;
	*zoom: 1;
}
.form-horizontal .control-group:before {
	display: table;
	content: "";
	line-height: 0;
}
.form-horizontal .control-group:after {
	display: table;
	content: "";
	line-height: 0;
	clear: both;
}
.form-horizontal .control-label {
	float: left;
	width: 160px;
	padding-top: 5px;
	text-align: right;
}
.form-horizontal .controls {
	*display: inline-block;
	*padding-left: 20px;
	margin-left: 180px;
	*margin-left: 0;
}
.form-horizontal .controls:first-child {
	*padding-left: 180px;
}
.form-horizontal .help-block {
	margin-bottom: 0;
}
.form-horizontal input + .help-block, .form-horizontal select + .help-block, .form-horizontal textarea + .help-block, .form-horizontal .uneditable-input + .help-block, .form-horizontal .input-prepend + .help-block, .form-horizontal .input-append + .help-block {
	margin-top: 10px;
}
.form-horizontal .form-actions {
	padding-left: 180px;
}
	.controls-row [class*="span"] + [class*="span"] {
		margin-left: 0;
	}

/*--- end popup css */
</style>

   
  