<script type="text/javascript" src="../FCKeditor/fckeditor.js"></script>
<script type="text/javascript" src="../js/ewp50.js"></script>
<script type="text/javascript">
	var ew_DHTMLEditors = [];
</script>

 <SCRIPT LANGUAGE=JAVASCRIPT>
function ChangePage(){
	ShowHideLoader('1','S');
	var SendUrl = 'email_template.php?cat='+document.getElementById("cat").value;
	location.href = SendUrl;
}
function validate(frm)
{	
ShowHideLoader('1','S');
	/*if (typeof ew_UpdateTextArea == 'function'){
		ew_UpdateTextArea();
	}
	
	if (!ew_ValidateForm(frm,"PageContent","Page Content")){
		return false;
	}*/
	
}
</SCRIPT>

<SCRIPT LANGUAGE=JAVASCRIPT>

function validate(frm){
		if( ValidateForSimpleBlank(frm.subject, "Subject")
		//&& ValidateMandRange(frm.TemplateContent, "Template Content ",1,200)
		
		){
			
			ShowHideLoader('1','S');
			
		}else{
			return false;	
		}
		
}



</SCRIPT>



<div class="had"><?=$MainModuleName?> 
</div>
	<div class="message" align="center"><? if(!empty($_SESSION['mess_template'])) {echo $_SESSION['mess_template']; unset($_SESSION['mess_template']); }?></div>

		    <table width="100%"  border="0" cellpadding="0" cellspacing="0" >
              <form name="form1" action method="post" onSubmit="return validate(this);" enctype="multipart/form-data">
              
                <tr>
                  <td align="center" valign="top" ><table width="100%" border="0" cellpadding="5" cellspacing="1"  class="borderall">
				   <tr>
                      <td width="20%" align="right" valign="top"   class="blackbold">
					   Email Template Category :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<select name="cat"  id="cat" class="inputbox" onchange="Javascript:ChangePage();" >
						<? for($i=0;$i<sizeof($arrayCat);$i++) {?>
						<option value="<?=$arrayCat[$i]['CatID']?>" <?  if($arrayCat[$i]['CatID']==$_GET['cat']){echo "selected";}?>>
						<?=$arrayCat[$i]['Name']?>
						</option>
						<? } ?>
					 </select> 
					    </td>
                    </tr>

					
                    <tr>
                      <td width="20%" align="right" valign="top"   class="blackbold">
					   Subject :<span class="red">*</span> </td>
                      <td align="left" valign="top">
					<input  name="subject" id="subject" value="<?=stripslashes($arrayContents[0]['subject'])?>" type="text" class="textbox"  size="80" maxlength="100" />  
					    </td>
                    </tr>
                    
                 	<tr>
                        <td></td>
                        
                        <td  valign="top">
                            <? 
                            $arr_field = $arrayContents[0]['arr_field'];

                                $column = explode(',', $arr_field);

                                for ($i = 0; $i < sizeof($column); $i++) {

                                    echo '<a class="addTag add_link"  title="' . strtoupper(preg_replace('/\s+/', '', $column[$i])) . '"> ' . strtoupper($column[$i]) . '</a>';
                                }
                                ?>       </td>           </TR>
			<tr >
                      <td align="right" valign="top"  class="blackbold" > Email Template : </td>
                      <td align="left" valign="top">

<textarea name="TemplateContent" id="TemplateContent" ><?=htmlentities(stripslashes($arrayContents[0]['Content']))?></textarea>
<script type="text/javascript">

var editorName = 'TemplateContent';

var editor = new ew_DHTMLEditor(editorName);

editor.create = function() {
	var sBasePath = '../FCKeditor/';
	var oFCKeditor = new FCKeditor(editorName, '100%', 380, 'custom');
	oFCKeditor.BasePath = sBasePath;
	oFCKeditor.ReplaceTextarea();
	this.active = true;
}
ew_DHTMLEditors[ew_DHTMLEditors.length] = editor;

ew_CreateEditor();  // Create DHTML editor(s)


$(".addTag").click(function() {                       
    var txtToAdd = jQuery(this).attr("title");
    var oEditor = FCKeditorAPI.GetInstance('TemplateContent') ;
    oEditor.InsertHtml("["+txtToAdd+"]");
});

//-->
</script>	
					  
					  </td>
                    </tr>


 <tr>
        		<td align="right" valign="top">Note : </td>
                      <td align="left" valign="top">
				[SITENAME] and [FOOTER_MESSAGE] are global parameters.
			 </td>
                    </tr>



                    <tr>
                        <td align="right" valign="top"  class="blackbold">Status : </td>
                        <td align="left" >
                            <table width="151" border="0" cellpadding="0" cellspacing="0" style="margin:0">
                                <tr>
                                    <td width="20" align="left" valign="middle"><input name="Status" type="radio" value="1" <?= ($Status == 1) ? "checked" : "" ?> /></td>
                                    <td width="48" align="left" valign="middle">Active</td>
                                    <td width="20" align="left" valign="middle"><input name="Status" type="radio" <?= ($Status == 0) ? "checked" : "" ?> value="0" /></td>
                                    <td width="63" align="left" valign="middle">Inactive</td>
                                </tr>
                            </table>                                            </td>
                    </tr>



                      </table></td>
                </tr>

		
				
				
				
				 <tr><td align="center">
			  <br>
			  <input name="Submit" type="submit" class="button" value="Update" />
			  <input type="hidden" name="TemplateID" id="TemplateID" value="<?=$arrayContents[0]['TemplateID']?>" />
			   <input type="hidden" name="EmpID" id="EmpID" value="<?=$_GET['EmpID']?>" />
				  
				  </td></tr> 
				
              </form>
          </table>
