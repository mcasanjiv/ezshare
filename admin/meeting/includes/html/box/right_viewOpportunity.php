<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return ValidateSearch();">
 <? require_once("../includes/html/box/right_custom.php"); ?>
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						     		  
                            <select name="sortby" id="sortby" class="textbox">
                                <option value=""> All </option>
                                <option value="o.OpportunityName" <? if($_GET['sortby']=='o.OpportunityName') echo 'selected';?>>Opportunity Name</option>
                                <option value="o.lead_source" <? if($_GET['sortby']=='o.lead_source') echo 'selected';?>>Lead Source</option>
                                <option value="o.SalesStage" <? if($_GET['sortby']=='o.SalesStage') echo 'selected';?>>Sales Stage</option>
                                
                                <option value="o.Status" <? if($_GET['sortby']=='o.Status') echo 'selected';?>>Status</option>
                            </select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>

                       <input type='text' name="key"  id="key"  value="<?=$_GET['key']?>" />
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
            
            
