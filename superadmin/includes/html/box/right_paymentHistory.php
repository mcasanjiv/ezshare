<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>
               
				<form class="admin_r_search_form" action="" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">
                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
					<select name="sortby" id="sortby" class="textbox">
						<option value=""> All </option>
						<option value="c.CompanyName" <? if($_GET['sortby']=='c.CompanyName') echo 'selected';?>>Company Name</option>
						<option value="c.CmpID" <? if($_GET['sortby']=='c.CmpID') echo 'selected';?>>Company ID</option>
						<option value="c.DisplayName" <? if($_GET['sortby']=='c.DisplayName') echo 'selected';?>>Display Name</option>					
						<!--option value="c.Status" <? if($_GET['sortby']=='c.Status') echo 'selected';?>>Status</option-->
					</select>
                         </div>
                    </fieldset>
                   
                    
                    <fieldset>
                    	 <label>Keyword:</label>
                        <input type='text' name="key"  id="key" value="<?=$_GET['key']?>" />
                    </fieldset>
                   
                    <fieldset>
                    	 <label>Order By:</label>
                         <div class="sel-wrap">
						   <select name="asc" id="asc"  >
							<option value="Desc" <? if($_GET['asc']=='Desc') echo 'selected';?>>Desc</option>
							<option value="Asc" <? if($_GET['asc']=='Asc') echo 'selected';?>>Asc</option>
						  </select>  
                         </div>
                    </fieldset>
                    <fieldset>
                     
						<input name="search" type="submit" class="button_btn" value="Search"  />
                    </fieldset>
                </form>
            </div>
