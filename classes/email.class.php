<?php
class email extends dbClass
{
		//constructor
		function email()
		{
			$this->dbClass();
		} 
                
                
                function  ListImportEmailId($adminId)
		{
		       
                       
                         
		         $strSQLQuery = "select id,EmailId,DECODE(EmailPassw,'". $Config['EncryptKey']."') as EmailPassw,EmailServer,status,name,usrname,DefalultEmail from importemaillist where AdminId='".$adminId."'";
		         
                         return $this->query($strSQLQuery, 1);		
				
		}
                
                
                function  AddImportEmailId($arryDetails)
		{
		          
		     
                     $sel="select EmailId from importemaillist where EmailId='".$arryDetails['Email']."'";
                     $ddd=$this->query($sel, 1);
                     if(empty($ddd[0]['EmailId']))
                     {
                     $strSQLQuery = "insert into importemaillist(EmailId,EmailPassw,EmailServer,AdminID,AdminType,status,name,usrname) values ('".strtolower($arryDetails['Email'])."',ENCODE('" .$arryDetails['EmailPassw']. "','".$Config['EncryptKey']."'),'".$arryDetails['EmailServer']."','".$arryDetails['AdminID']."','".$arryDetails['AdminType']."','".$arryDetails['Status']."','".$arryDetails['Name']."','".$arryDetails['usrname']."')";  
                     return $this->query($strSQLQuery, 1);
                     }
                     else {
                      return "AlreadyExist";
                     }
				
		}
                
                function  UpdateImportEmailId($arryDetails)
		{
		      
                     
                     
		     $sel="select EmailId from importemaillist where EmailId='".strtolower($arryDetails['Email'])."' and id!='".$arryDetails['AddID']."'";
                     $ddd=$this->query($sel, 1);
                     $cnt=count($ddd); 
                     if($cnt==0)
                     {
                     
                      if(empty($arryDetails['EmailPassw']))
                      {
                       $strSQLQuery = "update importemaillist set EmailId='".strtolower($arryDetails['Email'])."',EmailServer='".$arryDetails['EmailServer']."',AdminID='".$arryDetails['AdminID']."',AdminType='".$arryDetails['AdminType']."',status='".$arryDetails['Status']."',name='".$arryDetails['Name']."',usrname='".$arryDetails['usrname']."' where id='".$arryDetails['AddID']."'";  
                      }
                      else {
                        $strSQLQuery = "update importemaillist set EmailId='".strtolower($arryDetails['Email'])."',EmailPassw=ENCODE('" .$arryDetails['EmailPassw']. "','".$Config['EncryptKey']."'),EmailServer='".$arryDetails['EmailServer']."',AdminID='".$arryDetails['AdminID']."',AdminType='".$arryDetails['AdminType']."',status='".$arryDetails['Status']."',name='".$arryDetails['Name']."',usrname='".$arryDetails['usrname']."' where id='".$arryDetails['AddID']."'";  
                      }
                    
                      return $this->query($strSQLQuery, 1);
                     
                     }
                     else {
                      return "AlreadyExist";
                     }	
				
		}
                
                function GetEmailId($Id)
                {  
                
                         $strSQLQuery = "select id,EmailId,DECODE(EmailPassw,'". $Config['EncryptKey']."') as EmailPassw,EmailServer,status,name,usrname from importemaillist where id='".$Id."'"; 
                         return $this->query($strSQLQuery, 1);	
                
                }
                function RemoveEmailId($delid)
                {
                     $strSQLQuery = "delete from importemaillist where id='".$delid."'";
                     return $this->query($strSQLQuery, 1);
                     
                }
                
                function changeEmailIdStatus($active_id)
                {
                
                  
                 $strSQLQuery = "update importemaillist set status=(status ^ 1) where id='".$active_id."'";
                 return $this->query($strSQLQuery, 1);   
                 
                }
                
                
                function updateDefaultEmailId($defaultEmail_id,$AdminId)
                {
                
                 if(!empty($AdminId) && !empty($defaultEmail_id))
                 { 
                   $strSQLQuery = "update importemaillist set DefalultEmail=0 where AdminID='".$AdminId."'";
                   $data=mysql_query($strSQLQuery);

                   if($data==1)        
                   {
                     $strSQLQuery1 = "update importemaillist set DefalultEmail=1 where AdminID='".$AdminId."' and id='".$defaultEmail_id."'";
                     return $this->query($strSQLQuery1, 1);
                   }
                 }
                 
                }
                
                
                function  ListImportEmails($ownerId)
		{
		       
                        
                         
		         $strSQLQuery = "select * from importedemails where emaillistID='".$ownerId."'";
		         
                         return $this->query($strSQLQuery, 1);	
                        
				
		}
                
                
                function fetchEmailsFromServer($activeEmailid)
                {
                    
                   $strSQLQuery = "select id,EmailId,DECODE(EmailPassw,'". $Config['EncryptKey']."') as EmailPassw,EmailServer,status from importemaillist where id='".$activeEmailid."'"; 
                   $emailData=$this->query($strSQLQuery, 1);

          
                   if($emailData[0][EmailServer]=='Yahoo')
                   {
                      
                       $imapPath ='{imap.gmail.com:993/imap/ssl}INBOX';
                        $imapPath ='{imap.mail.yahoo.com:993/imap/ssl}INBOX';
                        $username = $emailData[0][EmailId];
                        $password = $emailData[0][EmailPassw];

                        // try to connect
                        $inbox = imap_open($imapPath,$username,$password);
                        
                        
                        
                        
                        $emails = imap_search($inbox,'UNSEEN');

                        $output = '';

                        foreach($emails as $mail) {


                        $headerInfo = imap_headerinfo($inbox,$mail);
                        $output .= $headerInfo->subject.'<br/>';
                        $output .= $headerInfo->toaddress.'<br/>';
                        $output .= $headerInfo->date.'<br/>';
                        $output .= $headerInfo->fromaddress.'<br/>';
                        $output .= $headerInfo->reply_toaddress.'<br/>';

                        $strSQLQuery = "insert into importedemails(OwnerEmailId,emaillistID,Subject,ImportedDate) values ('".$emailData[0][EmailId]."','".$activeEmailid."','".mysql_real_escape_string($headerInfo->subject)."','".date('Y-m-d H:i:s')."')";  
                        $this->query($strSQLQuery, 1);
                        
                        $emailStructure = imap_fetchstructure($inbox,$mail);
                        if(!isset($emailStructure->parts)) {
                        $output .= imap_body($inbox, $mail, FT_PEEK);
                        } else {
                            //
                        }
                            $output;
                           $output = '';



                       }

                   
                   
                   
                   
                   
                     

                   }
                   
                         
                }
                
              //send email with attachment(if file attached by user)  
              function sendEmailToUser($arrDetails)
		{
			global $Config;
                        
            
			extract($arrDetails);

			
			  if(!empty($recipients))
                           {
				$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
				
				#$CreatedBy = ($arrySale[0]['AdminType'] == 'admin')? ('Administrator'): ($arrySale[0]['CreatedBy']);


				/**********************/
				
				$contents = ($mailcontent);

					
				$mail = new MyMailer();
				$mail->IsMail();			
				$mail->AddAddress($recipients);
				if(!empty($Cc)) $mail->AddCC($Cc);
                                if(!empty($Bcc)) $mail->AddBCC($Bcc);
				//if(!empty($Attachment)) $mail->AddAttachment(getcwd()."/".$Attachment);
				//if(!empty($AttachDocument)){
				 	//$mail->AddAttachment(getcwd()."/".$AttachDocument);
					
				//}
                                
                                $recipent_arr=explode(',',$recipients);
                                
                               
                                $CC_arr=explode(',',$Cc);
                                $BCC_arr=explode(',',$Bcc);
                                
                                $total_arr=array_merge($recipent_arr,$CC_arr);
                                
                                $total_arr=array_unique(array_merge($total_arr,$BCC_arr));
                                
                                $total_recipient=implode(',',$total_arr);
                                
                                $total_recipient=rtrim($total_recipient,',');
                               
                                
                                if(empty($_SESSION['attcfile']))
                                {
                                   if($draftId) $insert_qry = "update importedemails set MailType='Sent', Status=1 where autoId =$draftId ";
                                  else
                                  $insert_qry="insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD) values('".$_SESSION['AdminEmail']."','".$_SESSION['AdminID']."','".$Subject."','".mysql_real_escape_string($contents)."','".$recipients."','".$Cc."','".$Bcc."','".$_SESSION['AdminEmail']."','".$total_recipient."','Sent','Compose','','".$_SESSION['AdminID']."','".date('Y-m-d H:i:s')."','".$FromDD."')";   
                                  $this->query($insert_qry, 1); 
                                  
                                  
                                  foreach($total_arr as $keyy=>$emailid)
                                   {
                                        
                                      if(!empty($emailid)) { 
                                       $sel_usremail="select * from user_email where Email='".$emailid."'";
                                       $user_data=$this->query($sel_usremail, 1); 
                                       
                                       
                                       
                                       if(($user_data[0]['Email']!=''))
                                       { 
                                          
                                          $insert_qry="insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD) values('".$emailid."','".$user_data[0]['RefID']."','".$Subject."','".mysql_real_escape_string($contents)."','".$recipients."','".$Cc."','".$Bcc."','".$_SESSION['AdminEmail']."','".$total_recipient."','InBox','Compose','','".$user_data[0]['RefID']."','".date('Y-m-d H:i:s')."','".$FromDD."')";   
                                          $this->query($insert_qry, 1); 
                                         
                                          
                                           
                                          
                                           
                                       } 
                                       
                                       
                                    }
                                      
                                      
                                   }
                                  
                                  
                                }
                                else {
                                    if($draftId) $insert_qry = "update importedemails set MailType='Sent', Status=1 where autoId =$draftId ";
                                    else
                                    $insert_qry="insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD) values('".$_SESSION['AdminEmail']."','".$_SESSION['AdminID']."','".$Subject."','".mysql_real_escape_string($contents)."','".$recipients."','".$Cc."','".$Bcc."','".$_SESSION['AdminEmail']."','".$total_recipient."','Sent','Compose','','".$_SESSION['AdminID']."','".date('Y-m-d H:i:s')."','".$FromDD."')";   
                                    $this->query($insert_qry, 1);
                                    $new_iid=mysql_insert_id();
                                    
                                    foreach($_SESSION['attcfile'] as $key=>$value)
                                          {
                                           
                                              $insert_qry="insert into importemailattachments(EmailRefId,FileName) values('".$new_iid."','".$value."')";   
                                              $this->query($insert_qry, 1);
                                              
                                              
                                          }
                                     
                                          
                                    foreach($total_arr as $keyy=>$emailid)
                                   {
                                        
                                      if(!empty($emailid)) { 
                                       $sel_usremail="select * from user_email where Email='".$emailid."'";
                                       $user_data=$this->query($sel_usremail, 1); 
                                       
                                       
                                       
                                       if(($user_data[0]['Email']!=''))
                                       { 
                                          
                                          $insert_qry="insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD) values('".$emailid."','".$user_data[0]['RefID']."','".$Subject."','".mysql_real_escape_string($contents)."','".$recipients."','".$Cc."','".$Bcc."','".$_SESSION['AdminEmail']."','".$total_recipient."','InBox','Compose','','".$user_data[0]['RefID']."','".date('Y-m-d H:i:s')."','".$FromDD."')";   
                                          $this->query($insert_qry, 1); 
                                          $new_id=mysql_insert_id();
                                          foreach($_SESSION['attcfile'] as $key=>$value)
                                          {
                                           
                                              $insert_qry="insert into importemailattachments(EmailRefId,FileName) values('".$new_id."','".$value."')";   
                                              $this->query($insert_qry, 1);
                                              
                                              
                                          }
                                          
                                           
                                          
                                           
                                       } 
                                       
                                       
                                    }
                                      
                                      
                                   }
                                    
                                       
                                }

                                foreach($_SESSION['attcfile'] as $key=>$value)
                                {
                                    
                                   //echo getcwd()."/upload/emailattachment/".$_SESSION['AdminEmail']."/".$value;  
                                   $mail->AddAttachment(getcwd()."/upload/emailattachment/".$_SESSION['AdminEmail']."/".$value);
                                   
                                   
                                   foreach($total_arr as $keyy=>$emailid)
                                   {
                                      
                                      if(!empty($emailid)) { 
                                       $sel_usremail="select Email from user_email where Email='".$emailid."'";
                                       $user_data=$this->query($sel_usremail, 1); 
                                       
                                       
                                       
                                       if(($user_data[0]['Email']!=''))
                                       { 
                                          
                                           $user_folder=getcwd()."/upload/emailattachment/".$emailid."/";
                                           if (!file_exists($user_folder)) {
                                                mkdir($user_folder, 0777);
                                            }
                                            
                                            copy(getcwd()."/upload/emailattachment/".$_SESSION['AdminEmail']."/".$value,getcwd()."/upload/emailattachment/".$emailid."/".$value);
                                           
                                       } 
                                       
                                       
                                    }
                                   }
                                     
                                     unset($_SESSION['attcfile'][$value]);
                                   
                                }
                                
                                
                                
                                $get_fromname="select name from importemaillist where EmailId='".$FromDD."'";        
                                $data_fromname=mysql_fetch_array(mysql_query($get_fromname));  
                               
				$mail->sender($data_fromname[name], $FromDD);   
				$mail->Subject = $Subject;
				$mail->IsHTML(true);
				$mail->Body = $contents;  
				//$recipients.$Cc.$Config['SiteName'].$Config['AdminEmail'].$contents; exit;
				if($Config['Online'] == '1'){
                                        
                                       
					$mail->Send();	
				}
				
			
                           }
			return 1;
		}
                
                function SentItems($AdminEmail,$ItemId)
                {
                  
                  $strQry='';   
                  if(!empty($ItemId))
                  {
                    $strQry=" and autoId='".$ItemId."'";  
                  }  
                  $type = "Sent";
                  if(!empty($_GET['type']) && $_GET['type']=="Draft") $type = "Draft";
                   $select_qry="select * from importedemails where FromEmail='".$AdminEmail."' and MailType='$type'".$strQry." order by ImportedDate desc";  
                   
                  return $this->query($select_qry, 1); 
                }
                
                function GetAttachmentFileName($EmailID)
                {
                    
                   $select_attach="select * from importemailattachments where EmailRefId='".$EmailID."'";
                  
                   return $this->query($select_attach, 1);
                   
                }
            
	# Read/Unread update
		function updateSendMailStatus($id=null){
			$sql = "update importedemails set Status = 0 where autoId=$id ";
			return $this->query($sql, 1);
		}
                
        # 24 march 15 added by shravan #
                function GoToTrashCan($emailAutoID)
                {
                    $update_query="update importedemails set MailType='TrashCan' where autoId='".$emailAutoID."'";
                  
                    return $this->query($update_query, 1);  
                     
                }
                
                function GetTrashEmail($AdminEmail,$ItemId)
                {
                  
                  $strQry='';   
                  if(!empty($ItemId))
                  {
                    $strQry=" and autoId='".$ItemId."'";  
                  }  
                     $select_qry="select * from importedemails where OwnerEmailId='".$AdminEmail."' and MailType='TrashCan'".$strQry." order by ImportedDate desc";  
                   
                  return $this->query($select_qry, 1);
                  
                } 
                
                function DeletePermanentEmail($emailuniqueId)
                {
                    
                      $delete_email_qry="delete from importedemails where autoId='".$emailuniqueId."'";
                      if($this->query($delete_email_qry, 1))
                      {
                      
                            $select_attachment_file="select FileName from importemailattachments where EmailRefId='".$emailuniqueId."'";
                            $attach_val=$this->query($select_attachment_file, 1);
                            if(count($attach_val)> 0)
                            {    
                              foreach($attach_val as $key=>$filename)
                              {
                                   
                                   
                                   unlink(getcwd()."/upload/emailattachment/".$_SESSION['AdminEmail']."/".$filename[FileName]);
                                   $delete_attach_row="delete from importemailattachments where EmailRefId='".$emailuniqueId."'";
                                   $this->query($delete_attach_row, 1);
                              }
                            }

                           
                      }
                }
                
                function ViewEmail($AdminEmail,$ItemId)
                {
                  
                  $strQry='';   
                  if(!empty($ItemId))
                  {
                    $strQry=" and autoId='".$ItemId."'";  
                  }  
                     $select_qry="select * from importedemails where OwnerEmailId='".$AdminEmail."'".$strQry." order by ImportedDate desc";  
                   
                  return $this->query($select_qry, 1);
                  
                }
                # 24 march 15 end #

		 # draft
		function draftItems($AdminEmail,$ItemId)
                {
                  
                  $strQry='';   
                  if(!empty($ItemId))
                  {
                    $strQry=" and autoId='".$ItemId."'";  
                  }  
                    $select_qry="select * from importedemails where FromEmail='".$AdminEmail."' and MailType='Draft'".$strQry." order by ImportedDate desc";  
                   
                  return $this->query($select_qry, 1); 
                }
                
           function saveToDarft($arrDetails)
           {	
           		global $Config;
           		extract($arrDetails);
           		
           		$recipent_arr=explode(',',$recipients);
                $CC_arr=explode(',',$Cc);
                $BCC_arr=explode(',',$Bcc);
                $total_arr=array_merge($recipent_arr,$CC_arr);
                $total_arr=array_unique(array_merge($total_arr,$BCC_arr));
                $total_recipient=implode(',',$total_arr);
                $total_recipient=rtrim($total_recipient,',');
                                
           		$Message = (!empty($Message))? ($Message): (NOT_SPECIFIED);
           		$contents = ($mailcontent);
           		
           		if(isset($draftId) && $draftId>0){
	            	$insert_qry="UPDATE importedemails SET Subject='".$Subject."', EmailContent='".mysql_real_escape_string($contents)."',Recipient='".$recipients."',Cc='".$Cc."',Bcc='".$Bcc."', ImportedDate='".date('Y-m-d H:i:s')."' WHERE autoId='".$draftId."' ";   
	                $this->query($insert_qry, 1);
	                $new_iid=$draftId;
           		}else{
           			$insert_qry="insert into importedemails(OwnerEmailId,emaillistID,Subject,EmailContent,Recipient,Cc,Bcc,FromEmail,TotalRecipient,MailType,Action,ActionMailId,AdminId,ImportedDate,FromDD) values('".$_SESSION['AdminEmail']."','".$_SESSION['AdminID']."','".$Subject."','".mysql_real_escape_string($contents)."','".$recipients."','".$Cc."','".$Bcc."','".$_SESSION['AdminEmail']."','".$total_recipient."','Draft','Compose','','".$_SESSION['AdminID']."','".date('Y-m-d H:i:s')."','".$FromDD."')";   
	                $this->query($insert_qry, 1);
	                $new_iid=mysql_insert_id();
           		}
                       if(!empty($_SESSION['attcfile']))
                       {
	                       foreach($_SESSION['attcfile'] as $key=>$value)
	                       {
	                       		$insert_qry="insert into importemailattachments(EmailRefId,FileName) values('".$new_iid."','".$value."')";   
	                       		$this->query($insert_qry, 1);
	                       		unset($_SESSION['attcfile'][$value]);
	                        }
                       }
               return $new_iid;
           }
           
           function editComposeMail($id){
           		 $select_qry="SELECT * from importedemails WHERE autoId=$id ";   
	             return $this->query($select_qry, 1); 
           }

		

}
?>