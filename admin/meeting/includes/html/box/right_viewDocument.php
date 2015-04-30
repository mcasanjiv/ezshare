<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
						      <td>		  
	<select name="sortby" id="sortby" class="textbox">
		<option value=""> All </option>
		<!--option value="d.documentID" <? if($_GET['sortby']=='d.documentID') echo 'selected';?>>Document ID</option-->
		<option value="d.title" <? if($_GET['sortby']=='d.title') echo 'selected';?>>Title</option>
		
		
		<option value="d.Status" <? if($_GET['sortby']=='d.Status') echo 'selected';?>>Status</option>
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
                      <input name="parent_type" type="hidden"  value="<?=$_GET['parent_type']?>"  />
                      <input name="parentID" type="hidden"  value="<?=$_GET['parentID']?>"  />
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
               
            </div>
            
            
