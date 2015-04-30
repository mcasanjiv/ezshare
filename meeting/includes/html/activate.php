<section id="mainContent">
			<?php //echo $datah['Content'];?>

				<div class="InfoText">

					<div class="wrap clearfix">





						<article id="leftPart">

							<div class="detailedContent">
								<div class="column" id="content">
									<div class="section">
										<a id="main-content"></a>

										<h1 id="page-title" class="title">Account Activation</h1>
									<?php if($_GET['activated']>0){?>	
									<span> Your acount has been activated successfully.</span><br><br>
									<span>Please <a href="user.php"> click here </a> to login</span>
	                               <?php }else {?>
	                              <div class="message"  id="msg_div" ><? if(!empty($_SESSION['mess_act'])) {echo $_SESSION['mess_act']; unset($_SESSION['mess_act']); }?></div> 
	                               	
	                              <?php }?>	
										<div id="banner"></div>
										<div class="region region-content">
											<div class="block block-system" id="block-system-main">


												<div class="content">
													<div class="messages error clientside-error"
														id="clientsidevalidation-user-login-errors"
														style="display: none;">
														<ul></ul>
													</div>
										
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</article>

					</div>

				</div>
			</section>