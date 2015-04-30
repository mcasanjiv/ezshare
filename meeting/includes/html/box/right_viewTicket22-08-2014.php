<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

<fieldset>
                        <label>Status: </label>
                        <div class="sel-wrap">
				<select name="search_Status" class="inputbox" id="search_Status" onchange="return filterLead(this.value);"  >

				
                                <option value="All" <? if($_GET['search_Status']=='All'){ echo "selected";}?>> All </option>
				<option value="Active"  <? if($_GET['search_Status']=='Active'){ echo "selected";}?>> Active </option>
			
				</select>
                         </div>
                    </fieldset>
<br /><br />
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						<select name="sortby" id="sortby" class="textbox">
                            <option value=""> All </option>
                            <!--option value="t.TicketID" <? if($_GET['sortby']=='t.TicketID') echo 'selected';?>>Ticket ID</option-->
                            <option value="t.title" <? if($_GET['sortby']=='t.title') echo 'selected';?>>Title</option>
			    <!--option value="e.UserName" <? if($_GET['sortby']=='e.UserName') echo 'selected';?>>Assign To</option-->
			
                            <option value="t.Status" <? if($_GET['sortby']=='t.Status') echo 'selected';?>>Status</option>
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
            
            
