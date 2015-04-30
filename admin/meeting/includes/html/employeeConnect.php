
<link href='fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css">

<style>
	.ui-widget-overlay{
		opacity: 0.6 !important;
	}	
	#loading {
		position: absolute;
		top: 5px;
		
		right: 5px;
		}

	#calendar {
		width: 100%;
		margin: 0 auto;
		}
		.fc-event-title{
		 color:#FFFFFF;
		}
		
		.fc-event-inner .fc-event-time{ color:#FFFFFF;}		
		.list > li {
		    border: 1px solid;
		    float: left;
		    margin-bottom: 5px;
		    margin-top: 5px;
		    padding: 10px 0;
		    width: 100%;
		}
		.emp-list.list {
   			 float: left;
		}
		.agen-list.list {
   			 float: right;
		}
		.list {
	  	 	 width: 45%;
		}		
		.list-box {
		    border: 1px solid;
		    float: left;
		    width: 100%;
		}		
		.emp-name {
		    float: left;
		    margin-left: 8px;
		}
		
		.emp-list li .agent-name {
		    float: right;
		    margin-right: 10px;
		}
		.hide{
		display:none;
		}
		.close-box{
			float:right;
			 margin-right: 10px;
		}
		.close-box > a {
  			  font-size: 15px;
		}
</style>


<script type="text/javascript" src="multiSelect/jquery.tokeninput.js"></script>
<link rel="stylesheet" href="multiSelect/token-input.css" type="text/css" />
<link rel="stylesheet" href="multiSelect/token-input-facebook.css" type="text/css" />
<script type="text/javascript">
jQuery(function() {
jQuery( ".agen-list li" ).draggable({  revert: true});
jQuery( ".emp-list li" ).droppable({
	drop: function( event, ui ) {
		if(jQuery(this).find('.agentID').val()==''){	
	var draghtml=	ui.draggable;
	var agentname=	draghtml.find('.agent-name').html();
	console.log(jQuery(ui.draggable).find('.agent-name').html());
	jQuery(this).find('.agent-name').html(jQuery(ui.draggable).find('.agent-name').html());
	jQuery(this).find('.agentID').val(jQuery(ui.draggable).find('.EmpID').val());
	jQuery(this).find('.close-box').html('<a href="javascript:void(0);" onclick="closeempConnect(this)">X</a>');
	
	jQuery( this ).addClass( "ui-state-highlight" )	;

	 //destroy clone
	jQuery(ui.draggable).addClass('hide'); //remove from list
		}else{
				jQuery(this).css('border-color','red');
			}
	}
	});
});


function closeempConnect(obj){
var agentid=jQuery(obj).parents('li').find('.agentID').val();
jQuery('.agen-list li.agentId-'+agentid).removeClass('hide');
jQuery(obj).parents('li').find('.agentID').val('');
jQuery(obj).parents('li').find('.agent-name').html('');
jQuery(obj).parents('li').removeClass('ui-state-highlight');
//jQuery(obj).parents('li').droppable( "option", "disabled", true );;

jQuery(obj).remove();
	
}

function closeempConnectper(obj,agent_id,user_id,server_id){
	var r= confirm('do you want to delete?');
	if(r==true){
		var request=jQuery.ajax({
				type:'post',
				url:'<?php echo _SiteUrl;?>/admin/crm/ajax.php?action=delete_CallEmployee',
				data:{
					server_id:server_id,
					user_id:user_id,
					agent_id:agent_id
					},success:function(data){

							if(data==0){
								alert('There is some technical problem');
							}else{
								closeempConnect(obj);
								}
						}
			});
		}else{

			}
}
</script>
</head>
<body>
<div id="Event" >
<div class="message"><?php if(!empty($_SESSION['mess_phone'])){echo $_SESSION['mess_phone'];unset($_SESSION['mess_phone']);}?></div>
<? if($ModifyLabel==1){?>
 <table <?=$table_bg?>>
	 <tr>
	 	<td class="head1">Connect</td>
	 </tr>
	 <tr>
	 	<td ><form  method="post" action="" id="frmSrch" name="frmSrch">
                 	 Employee Name <span class="red">*</span> <select style="width: 110px;" class="textbox" id="crmEmployee" name="empdata[0][EmpID]">
                 	<option value="">Select Employee</option>
                 	<?php if(!empty($arryEmployee)){                 	
	                 	foreach($arryEmployee as $val){
	                 		if(!in_array($val['EmpID'],$saveemp))
	                 		echo '<option value="'.$val['EmpID'].'">'.$val['UserName'].'</option>';
	                 	
	                 	}
                 	}?>
                 	 </select>&nbsp;&nbsp;
                     Elastix User <span class="red">*</span> <select style="width: 110px;" class="textbox" id="elastixUser" name="empdata[0][agentID]">
                     	<option value="">Select Elatix User</option>
                     	<?php if(!empty($agents)){                 	
			                 	foreach($agents as $val){
			                 		if(!in_array($val[0],$saveagents))
			                 		echo '<option value="'.$val[0].'">'.$val[2].'</option>';	                 	
			                 	}
                 			}?>
                     </select>
                   
               <input type="hidden" value="Search" id="search" name="search">
               <input type="submit" class="search_button" value="Go" name="sbt">
            </form></td>
	 </tr>
	<tr>	
	    <td  align="center" valign="top"  id="searchfbbox">	
	    <table width="100%" align="center" cellspacing="1" cellpadding="3" id="list_table">
   
    <tbody>
    <tr align="left">
                <td width="30%" align="left" class="head1">Employee Name</td>
                <td width="10%" align="center" class="head1">Elastix User</td>
				<td width="10%" align="center" class="head1">Extention</td>
				<td width="10%" align="center" class="head1">Quota</td>		
                <td width="10%" align="center" class="head1">Action</td>
    </tr>  
  
   
  <?php if(is_array($regisData) && count($regisData)>0){
	  	$flag=true;
		$Line=0;
		$invAmnt=0;
  	foreach($regisData as $key=>$values){
		$flag=!$flag;
		$bgcolor=($flag)?("#FAFAFA"):("#FFFFFF");
		$Line++;	
  ?>
	<tr align="left"  bgcolor="<?=$bgcolor?>">       
      <td align="left"><?php echo $allemployeedata[$values->user_id]['UserName'];?></td>
       <td align="center"><?php echo $AnameByAid[$values->agent_id];?></td>
      <td align="center"><?php echo $allagentdata[$values->agent_id][3];?></td>
      <td align="center"></td>   
      <td align="center">        
          <a  href="employeeConnect.php?del_id=<?php echo base64_encode($values->id);?>" onclick="return confirm('Do You to Delete ?');"><img border="0" onmouseout="hideddrivetip()" ;="" onmouseover="ddrivetip('&lt;center&gt;Delete&lt;/center&gt;', 40,'')" src="<?php echo _SiteUrl?>/admin/images/delete.png"></a>
          
                 
      </td>

    </tr>
	

	
        <?php } // foreach end //?>
  
    <?php }else{?>
    <tr align="center" >
      <td  colspan="6" class="no_record"><?=NO_RECORD?> </td>
    </tr>
    <?php } ?>
	
  </table>
	    
	    
	    
	    		
			<!--<? if (!empty($_SESSION['mess_social'])) {?>
			<div><span  align="center"  class="message"  >
				<? if(!empty($_SESSION['mess_social'])) {echo $_SESSION['mess_social']; unset($_SESSION['mess_social']); }?>	
			</span></div>
			<? } ?>
			<form name="form1" action="" id="socialfrom"  method="post"  enctype="multipart/form-data">
				
				<div class="list-box"><ul class="emp-list list">
					<?php if(!empty($arryEmployee)){
					foreach($arryEmployee as $Employee){?>
					<li class="droppable <?php echo ($AgentByEmp[$Employee['EmpID']])?'ui-state-highlight':'';?>">
						<span class="emp-name"><?php echo $Employee['UserName']?></span>
						<span class="close-box">
						<?php if(!empty($AgentByEmp[$Employee['EmpID']])){?>
							<a href="javascript:void(0);" onclick="closeempConnectper(this,'<?php echo $AgentByEmp[$Employee['EmpID']]?>','<?php echo $Employee['EmpID']?>','<?php echo $server_id?>')">X</a>
						<?php }?></span>
						<span class="agent-name"><?php if(!empty($AgentByEmp[$Employee['EmpID']]) AND !empty($AnameByAid[$AgentByEmp[$Employee['EmpID']]])){
							echo $AnameByAid[$AgentByEmp[$Employee['EmpID']]];
						}?></span>						
						<input type="hidden" class="EmpID" name="empdata[<?php echo $Employee['EmpID']?>][EmpID]" value="<?php echo $Employee['EmpID']?>">
						<input type="hidden" class="agentID" name="empdata[<?php echo $Employee['EmpID']?>][agentID]" value="<?php echo ($AgentByEmp[$Employee['EmpID']])?$AgentByEmp[$Employee['EmpID']]:'';?>">
					</li>
					<?php }}?>
				</ul>
				<ul class="agen-list list">
					<?php if(!empty($agents)){
					foreach($agents as $agent){?>
					<li class="agentId-<?php echo $agent[0]?> <?php echo (in_array($agent[0],$saveagents))?'hide':'';?>"  >
						<span class="agent-name"><?php echo $agent[2]?></span>
						<input type="hidden" class="EmpID" value="<?php echo $agent[0]?>">						
					</li>
					<?php }}?>
				</ul>
				</div>
				<div class="form-action"><input type="submit" value="Connect" class="button"></div>
			 </form>-->
		</td>
	  </tr>
</table>
<? }else{?>

<div class="redmsg" align="center">Sorry, you are not authorized to access this section.</div>
<? }?>
</div>
<script>
function SaveSocialData(obj,id,type){
	
	jQuery('.userid-set').val(id);
	jQuery('.action-type').val(type);
	jQuery('#socialfrom').submit();
	
	}


</script>