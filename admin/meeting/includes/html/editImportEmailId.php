
<div ><a href="<?=$RedirectURL?>" class="back">Back</a></div>


<div class="had">
Manage Email Id    <span>&raquo;
	<? 	echo (!empty($_GET['edit']))?("Edit ".$ModuleName) :("Add ".$ModuleName); ?>
		
		</span>
</div>
	<? if (!empty($errMsg)) {?>
    <div align="center"  class="red" ><?php echo $errMsg;?></div>
  <? } ?>
  

  


<script language="JavaScript1.2" type="text/javascript">
function validateContact(frm){

	

	if(     ValidateForSimpleBlank(frm.Name, "Name")
                && ValidateForSimpleBlank(frm.usrname, "User Name")
   
		){
					
			
                       if(!ValidateMandRange(frm.usrname, "User Name",4,10)){
					return false;
				}
                                
                if(ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email)
                && ValidateForSimpleBlank(frm.EmailPassw, "Password")
                && ValidateForSimpleBlank(frm.C_EmailPassw, "Confirm Password")
                 
                ){
            
                      /*
			var Url = "isRecordExists.php?ContactEmail="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("AddID").value+"&Type=Contact";
			SendExistRequest(Url,"Email", "Email Address");

			return false;	*/
                
                        if(frm.EmailPassw.value!= frm.C_EmailPassw.value)
                           {
                              alert('Password & confirm Password do not matched. Please enter confirm password again'); 
                              return false;
                           }
		    if(frm.EmailServer.value=='')
                    {
                         alert('Please Select Email Server'); 
                              return false;
                    }
			ShowHideLoader('1','S');
			return true;
                    } else {
                        
                        return false;
                    }   
				
		}else{
			return false;	
		}	

		
}
function validateContactEdit(frm){

	

	if(     ValidateForSimpleBlank(frm.Name, "Name")
                && ValidateForSimpleBlank(frm.usrname, "User Name")

		){
					
			/*
			var Url = "isRecordExists.php?ContactEmail="+escape(document.getElementById("Email").value)+"&editID="+document.getElementById("AddID").value+"&Type=Contact";
			SendExistRequest(Url,"Email", "Email Address");

			return false;	*/
                      
                      
                      if(!ValidateMandRange(frm.usrname, "User Name",4,10)){
					return false;
				}
                     
                if(ValidateForSimpleBlank(frm.Email, "Email")
		&& isEmail(frm.Email))
                   {
                       if(frm.EmailServer.value=='')
                    {
                         alert('Please Select Email Server'); 
                              return false;
                    }
                       
                       if(frm.EmailPassw.value!='')
                       {
                           
                           if(frm.EmailPassw.value!= frm.C_EmailPassw.value)
                           {
                              alert('Password & confirm Password do not matched. Please enter confirm password again'); 
                              return false;
                           }
                       }
                       
                       if((frm.EmailPassw.value=='') && (frm.C_EmailPassw.value!=''))
                       {
                           
                           alert("Please Leave Empty Confirm Password");
                           return false;
                       }
                       
                       
                           
			ShowHideLoader('1','S');
			return true;
                    } else {
                        
                        return false;
                    }     
				
		}else{
			return false;	
		}	

		
}
</script>

<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" action=""  method="post" onSubmit="<?php if(empty($_GET['edit'])) {?> return validateContact(this);<?php } else {?> return validateContactEdit(this); <?php }?>" enctype="multipart/form-data">


   <tr>
    <td  align="center" valign="top" >
	

<table width="100%" border="0" cellpadding="5" cellspacing="0" class="borderall">
<tr>
	 <td colspan="4" align="left" class="head">Email Id Information</td>
</tr>

            <tr>
              <td align="right"   class="blackbold">Name  :<span class="red">*</span> </td>
              <td  align="left" ><input name="Name" type="text" class="inputbox" id="Name" value="<?php echo stripslashes($arryEmailId[0]['name']); ?>"  maxlength="80" onkeypress="return isCharKey(event);"/>
              </td>

            </tr>
            <tr>
              <td align="right"   class="blackbold">User Name  :<span class="red">*</span> </td>
              <td  align="left" ><input name="usrname" type="text" class="inputbox" id="usrname" value="<?php echo stripslashes($arryEmailId[0]['usrname']); ?>"  maxlength="80" />
              </td>

            </tr>

            <tr>
              <td align="right"   class="blackbold">Email  :<span class="red">*</span> </td>
              <td  align="left" ><input name="Email" type="text" class="inputbox" id="Email" value="<?php echo stripslashes($arryEmailId[0]['EmailId']); ?>"  maxlength="80" />
              </td>

            </tr>
            <tr>
              <td align="right"   class="blackbold">Password  :<span class="red">*</span> </td>
              <td  align="left" ><input name="EmailPassw" type="password" class="inputbox" id="EmailPassw" value=""  maxlength="80" />
                <?php if(!empty($_GET['edit']))
                { ?>
                  <span>(Leave it blank, if do not want to change password.)</span>
                <?php } ?>
              </td>

            </tr>
            <tr>
              <td align="right"   class="blackbold">Confirm Password  :<span class="red">*</span> </td>
              <td  align="left" ><input name="C_EmailPassw" type="password" class="inputbox" id="C_EmailPassw" value=""  maxlength="80" />
              </td>

            </tr>

            <tr>
              <td  align="right"   class="blackbold"> Email Server  : <span class="red">*</span></td>
              <td   align="left" ><select name="EmailServer" class="inputbox" id="EmailServer" >
                  <option value="">--- Select ---</option>
                  
                  
                  <option value="Yahoo" <?php if(($arryEmailId[0]['EmailServer'])=='Yahoo') { echo "selected";}?>>Yahoo</option>
                  <!--option value="Gmail" <?php if(($arryEmailId[0]['EmailServer'])=='Gmail') { echo "selected";}?>>Gmail</option--> 
                </select>
              </td>
            
              
            </tr>


 <tr>
     

        <td  align="right"   class="blackbold" 
		>Status  : </td>
        <td   align="left"  >
          <? 
		  	 $ActiveChecked = ' checked';
			 if($_REQUEST['edit'] > 0){
				 if($arryEmailId[0]['status'] == 1) {$ActiveChecked = ' checked'; $InActiveChecked ='';}
				 if($arryEmailId[0]['status'] == 0) {$ActiveChecked = ''; $InActiveChecked = ' checked';}
			}
		  ?>
          <input type="radio" name="Status" id="Status" value="1" <?=$ActiveChecked?> />
          Active&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="radio" name="Status" id="Status" value="0" <?=$InActiveChecked?> />
          Inactive </td>
      </tr>
 
  
	
</table>	
  
	</td>
   </tr>

 

   <tr>
    <td  align="center">
	
	<div id="SubmitDiv" style="display:none1">
	
	<? if($_GET['edit'] >0) $ButtonTitle = 'Update '; else $ButtonTitle =  ' Submit ';?>
      <input name="Submit" type="submit" class="button" id="SubmitButton" value=" <?=$ButtonTitle?> "  />


<input type="hidden" name="AddID" id="AddID" value="<?=$_GET['edit']?>" />

<input type="hidden" name="AdminID" id="AdminID"  value="<?php echo $_SESSION['AdminID']; ?>" />	
<input type="hidden" name="AdminType" id="AdminType"  value="<?php echo $_SESSION['AdminType']; ?>" />

</div>

</td>
   </tr>
   </form>
</table>

<SCRIPT LANGUAGE=JAVASCRIPT>
	StateListSend();
</SCRIPT>




