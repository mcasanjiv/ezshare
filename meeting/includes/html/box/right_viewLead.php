<div class="right-search">
            	<h3><span class="icon"></span><?=LEAD_SEARCH_FORM_TITLE?></h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

 <? require_once("../includes/html/box/right_custom.php"); ?>
                    <fieldset>
                        <label><?=LBL_SEARCH_BY?>: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby" class="textbox">
		                 <option value=""> All </option>
		                  <!--option value="l.leadID" <? if($_GET['sortby']=='l.leadID') echo 'selected';?>><?=LEAD_ID?></option-->
		                   <option value="l.FirstName" <? if($_GET['sortby']=='l.FirstName') echo 'selected';?>>Lead Name</option>
  <option value="l.company" <? if($_GET['sortby']=='l.company') echo 'selected';?>><?=LEAD_COMPANY?></option>

  <!--option value="l.type" <? if($_GET['sortby']=='l.type') echo 'selected';?>>Lead Type</option-->
  <option value="l.LandlineNumber" <? if($_GET['sortby']=='l.LandlineNumber') echo 'selected';?>>Phone</option>
		                     <option value="l.primary_email" <? if($_GET['sortby']=='l.primary_email') echo 'selected';?>><?=LEAD_PRIMARY_EMAIL?></option>
                             <option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>Sales Person</option>
                           
		                      <option value="l.lead_status" <? if($_GET['sortby']=='l.lead_status') echo 'selected';?>><?=LEADSTATUS?></option>
	                       </select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label><?=LBL_KEYWORD?>:</label>
                       <input type='text' name="key"  id="key"  value="<?=$_GET['key']?>" />
                    </fieldset>
                   
                    <fieldset>
                    	 <label>Order By:</label>
                         <div class="sel-wrap">
						   <select name="asc" id="asc" >
                            <option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>><?=LBL_DESC?></option>
                            <option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>><?=LBL_ASC?></option>
                          </select> 
                         </div>
                    </fieldset>
                    <fieldset>
                      <input name="module" type="hidden"  value="<?=$_GET['module']?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
               
            </div>
            
            
