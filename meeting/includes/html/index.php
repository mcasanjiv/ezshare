<?php //header("Location: ".) ?>
 <SCRIPT LANGUAGE=JAVASCRIPT>

function checkMeetingId(){
	$('.loading-image').show();
       var SendParam = $("#formMeeting").serializeArray();
       $.ajax({
			type: "POST",
			async:false,
			url: GlobalSiteUrl.'admin/ajax.php',
			data: SendParam,
			success: function (responseText) {
				if('Meeting not started Yet!'==$.trim(responseText)){
					$(".error").text(responseText);
           		}else if($.trim(responseText) != 'null' && responseText!=2){ 
					window.location.href = responseText;
				}else if(responseText=='null') {
					$('.loading-image').hide();
				}else{
					$('.loading-image').html('Error! Try again.');
				}

			}
      });
       return false;
}
</SCRIPT>

					
<div style="min-height: 300px;" class="get-quote"><a href="register.php">Start with 30 days Free trial</a>
</div>