<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
 <? require_once("../includes/html/box/right_custom.php"); ?>
              
                  <fieldset style="display:none;">
                    	 <label>From Date: </label>
                       <? if($_GET['FromDate']>0) $FromDate = $_GET['FromDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#FromDate').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="FromDate" name="FromDate" readonly=""  size="10" value="<?=$FromDate?>"  type="text" > 
                    </fieldset>
				
				
				 <fieldset>
                    	 <label>Close Date:</label>
                        <? if($_GET['ToDate']>0) $ToDate = $_GET['ToDate'];  ?>				
<script type="text/javascript">
$(function() {
	$('#closingdate').datepicker(
		{
		dateFormat: 'yy-mm-dd', 
		yearRange: '<?=date("Y")-30?>:<?=date("Y")+30?>', 
		changeMonth: true,
		changeYear: true

		}
	);
});
</script>
<input id="closingdate" name="closingdate" readonly=""  size="10" value="<?=$ToDate?>"  type="text" > 
                    </fieldset>
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						     		  
                            <select name="sortby" id="sortby" class="textbox">
                                <option value=""> All </option>
                                <option value="c.campaignname" <? if($_GET['sortby']=='c.campaignname') echo 'selected';?>>Campaign Name</option>
                                <option value="c.campaigntype" <? if($_GET['sortby']=='c.campaigntype') echo 'selected';?>>Campaign Type</option>
                                <option value="c.campaignstatus" <? if($_GET['sortby']=='c.campaignstatus') echo 'selected';?>>Campaign Status</option>
                                <option value="c.expectedrevenue" <? if($_GET['sortby']=='c.expectedrevenue') echo 'selected';?>>Expected Revenue</option>
                                
                                
                              
                            </select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>

<? if($_GET['search_Status']=='Active'){ $key='';}else{ $key = $_GET['key'];}?>
                       <input type='text' name="key"  id="key"  value="<?=$key?>" />
                    </fieldset>
                   
                    <fieldset>
                    	 <label>Order By:</label>
                         <div class="sel-wrap">
						   <select name="asc" id="asc" >
                            <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
                            <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
                          </select> 
                         </div>
                    </fieldset>
                    <fieldset>
                      <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
               
            </div>
            
            
