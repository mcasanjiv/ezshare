<div class="right-search">
            	<h3><span class="icon"></span>Search</h3>


<div class="right_box">
<ul class="rightlink">
<li <?=($_GET['tab']=="todays")?("class='active'"):("");?>><a href="<?=$ViewUrl?>&tab=todays" >Todays Events</a></li>
<li <?=($_GET['tab']=="upcoming")?("class='active'"):("");?>><a href="<?=$ViewUrl?>&tab=upcoming">Upcoming Events</a></li>
</ul>
</div>

<br><br>


<form class="admin_r_search_form" action="<?=$SelfPage?>" method="get" enctype="multipart/form-data" name="form2" onSubmit="return LoaderSearch();">

 <? require_once("../includes/html/box/right_custom.php"); ?>




<!--fieldset>
					<label>From Date: </label>
					<? if($_GET['FromDate']>0) $FromDate = $_GET['FromDate'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#FromDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#FromDate").on("click", function () { 
								 $(this).val("");
							}
						);
					});
					</script>
					<input id="FromDate" name="FromDate" readonly="" value="<?=$FromDate?>"  type="text" maxlength="10" > 
               </fieldset>

				<fieldset>
					<label>To Date: </label>
					<? if($_GET['ToDate']>0) $ToDate = $_GET['ToDate'];  ?>				
					<script type="text/javascript">
					$(function() {
						$('#ToDate').datepicker(
							{
							showOn: "both", dateFormat: 'yy-mm-dd', 
							yearRange: '<?=date("Y")-10?>:<?=date("Y")+10?>', 
							changeMonth: true,
							changeYear: true

							}
						);
						$("#ToDate").on("click", function () { 
								 $(this).val("");
							}
						);

					});
					</script>
					<input id="ToDate" name="ToDate" readonly="" value="<?=$ToDate?>"  type="text" maxlength="10" > 
               </fieldset-->






                    <fieldset>
                        <label>Search By: </label>
                        <div class="sel-wrap">
                     <select name="sortby" id="sortby" class="textbox">
                        <option value=""> All </option>
                        <!--option value="e.activityID" <? if($_GET['sortby']=='e.activityID') echo 'selected';?>> ID</option-->
			 <option value="e.subject" <? if($_GET['sortby']=='e.subject') echo 'selected';?>>Title</option> 
                         <option value="e.activityType" <? if($_GET['sortby']=='e.activityType') echo 'selected';?>>Activity Type</option> 
 <option value="e.priority" <? if($_GET['sortby']=='e.priority') echo 'selected';?>>Priority</option> 

                        <option value="e.status" <? if($_GET['sortby']=='e.status') echo 'selected';?>>Status</option>
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
            
            
