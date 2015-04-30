<?php

function ImportDatabase($db_server,$db_name,$db_username,$db_password,$filename){
		
		// If Timeout errors still occure you may need to adjust the $linepersession setting in this file
		// Change fopen mode to "r" as workaround for Windows issues
		
		/*
		$db_server   = 'localhost';
		$db_name     = 'agrinde_erp_parwez';
		$db_username = 'root';
		$db_password = '';
		$filename           = 'superadmin/sql/agrinde_erp.sql';    
		*/
		
		
		$csv_insert_table   = '';     // Destination table for CSV files
		$csv_preempty_table = false;  // true: delete all entries from table specified in $csv_insert_table before processing
		$ajax               = true;   // AJAX mode: import will be done without refreshing the website
		$linespersession    = 300000;   // Lines to be executed per one import session
		$delaypersession    = 0;      // You can specify a sleep time in milliseconds after each session
									  // Works only if JavaScript is activated. Use to reduce server overrun
		
		// Allowed comment delimiters: lines starting with these strings will be dropped by BigDump
		
		$comment[]='#';                       // Standard comment lines are dropped by default
		$comment[]='-- ';
		// $comment[]='---';                  // Uncomment this line if using proprietary dump created by outdated mysqldump
		// $comment[]='CREATE DATABASE';      // Uncomment this line if your dump contains create database queries in order to ignore them
		$comment[]='/*!';                  // Or add your own string to leave out other proprietary things
		
		
		
		// Connection character set should be the same as the dump file character set (utf8, latin1, cp1251, koi8r etc.)
		// See http://dev.mysql.com/doc/refman/5.0/en/charset-charsets.html for the full list
		
		$db_connection_charset = '';
		
		
		// *******************************************************************************************
		// If not familiar with PHP please don't change anything below this line
		// *******************************************************************************************
		
		if ($ajax)
		  ob_start();
		
		define ('VERSION','0.32b');
		define ('DATA_CHUNK_LENGTH',1638400);  // How many chars are read per time
		define ('MAX_QUERY_LINES',300000);      // How many lines may be considered to be one query (except text lines)
		define ('TESTMODE',false);           // Set to true to process the file without actually accessing the database
		
		header("Expires: Mon, 1 Dec 2003 01:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		@ini_set('auto_detect_line_endings', true);
		@set_time_limit(0);
		
		if (function_exists("date_default_timezone_set") && function_exists("date_default_timezone_get"))
		  @date_default_timezone_set(@date_default_timezone_get());
		
		// Clean and strip anything we don't want from user's input [0.27b]
		
		foreach ($_REQUEST as $key => $val) 
		{
		  $val = preg_replace("/[^_A-Za-z0-9-\.&= ]/i",'', $val);
		  $_REQUEST[$key] = $val;
		}
		
		?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
		<title>BigDump ver</title>
		<meta http-equiv="CONTENT-TYPE" content="text/html; charset=iso-8859-1"/>
		<meta http-equiv="CONTENT-LANGUAGE" content="EN"/>
		
		<meta http-equiv="Cache-Control" content="no-cache/"/>
		<meta http-equiv="Pragma" content="no-cache"/>
		<meta http-equiv="Expires" content="-1"/>
		
		</head>
		
		<body>
		
		
		<?php
		$error = false;
		$file  = false;
		
		// Get the current directory
		
		if (isset($_SERVER["CGIA"]))
		  $upload_dir=dirname($_SERVER["CGIA"]);
		else if (isset($_SERVER["ORIG_PATH_TRANSLATED"]))
		  $upload_dir=dirname($_SERVER["ORIG_PATH_TRANSLATED"]);
		else if (isset($_SERVER["ORIG_SCRIPT_FILENAME"]))
		  $upload_dir=dirname($_SERVER["ORIG_SCRIPT_FILENAME"]);
		else if (isset($_SERVER["PATH_TRANSLATED"]))
		  $upload_dir=dirname($_SERVER["PATH_TRANSLATED"]);
		else 
		  $upload_dir=dirname($_SERVER["SCRIPT_FILENAME"]);
		
		
		// Connect to the database
		
		if (!$error && !TESTMODE)
		{ $dbconnection = @mysql_connect($db_server,$db_username,$db_password);
		  if ($dbconnection) 
			$db = mysql_select_db($db_name);
		  if (!$dbconnection || !$db) 
		  { echo ("<p>Database connection failed due to ".mysql_error()."</p>\n");
			$error=true;
		  }
		  if (!$error && $db_connection_charset!=='')
			@mysql_query("SET NAMES $db_connection_charset", $dbconnection);
		}
		else
		{ $dbconnection = false;
		}
		
		
		
		// Single file mode
		
		if (!$error && !isset ($_REQUEST["fn"]) && $filename!="")
		{ 
			$_REQUEST["start"]=1;
			$_REQUEST["fn"]=urlencode($filename);
			$_REQUEST["foffset"]=0;
			$_REQUEST["totalqueries"]=0;
			$_REQUEST["start"]=1;
			#echo ("<p><a href=\"".$_SERVER["PHP_SELF"]."?start=1&amp;fn=".urlencode($filename)."&amp;foffset=0&amp;totalqueries=0\">Start Import</a></p>\n");
		}
		
		
		// Open the file
		
		if (!$error && isset($_REQUEST["start"]))
		{ 
		
		// Set current filename ($filename overrides $_REQUEST["fn"] if set)
		
		  if ($filename!="")
			$curfilename=$filename;
		  else if (isset($_REQUEST["fn"]))
			$curfilename=urldecode($_REQUEST["fn"]);
		  else
			$curfilename="";
		
		// Recognize GZip filename
		
		  if (preg_match("/\.gz$/i",$curfilename)) 
			$gzipmode=true;
		  else
			$gzipmode=false;
		
		  if ((!$gzipmode && !$file=@fopen($curfilename,"r")) || ($gzipmode && !$file=@gzopen($curfilename,"r")))
		  { echo ("<p class=\"error\">Can't open ".$curfilename." for import</p>\n");
			echo ("<p>Please, check that your dump file name contains only alphanumerical characters, and rename it accordingly, for example: $curfilename.".
				   "<br>Or, specify \$filename in bigdump.php with the full filename. ".
				   "<br>Or, you have to upload the $curfilename to the server first.</p>\n");
			$error=true;
		  }
		
		// Get the file size (can't do it fast on gzipped files, no idea how)
		
		  else if ((!$gzipmode && @fseek($file, 0, SEEK_END)==0) || ($gzipmode && @gzseek($file, 0)==0))
		  { if (!$gzipmode) $filesize = ftell($file);
			else $filesize = gztell($file);                   // Always zero, ignore
		  }
		  else
		  { echo ("<p class=\"error\">I can't seek into $curfilename</p>\n");
			$error=true;
		  }
		}
		
		// *******************************************************************************************
		// START IMPORT SESSION HERE
		// *******************************************************************************************
		
		if (!$error && isset($_REQUEST["start"]) && isset($_REQUEST["foffset"]) && preg_match("/(\.(sql|gz|csv))$/i",$curfilename))
		{
		
		// Check start and foffset are numeric values
		
		  if (!is_numeric($_REQUEST["start"]) || !is_numeric($_REQUEST["foffset"]))
		  { echo ("<p class=\"error\">UNEXPECTED: Non-numeric values for start and foffset</p>\n");
			$error=true;
		  }
		
		// Empty CSV table if requested
		
		  if (!$error && $_REQUEST["start"]==1 && $csv_insert_table != "" && $csv_preempty_table)
		  { 
			$query = "DELETE FROM $csv_insert_table";
			if (!TESTMODE && !mysql_query(trim($query), $dbconnection))
			{ echo ("<p class=\"error\">Error when deleting entries from $csv_insert_table.</p>\n");
			  echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");
			  echo ("<p>MySQL: ".mysql_error()."</p>\n");
			  $error=true;
			}
		  }
		
		  
		// Print start message
		
		  if (!$error)
		  { $_REQUEST["start"]   = floor($_REQUEST["start"]);
			$_REQUEST["foffset"] = floor($_REQUEST["foffset"]);
			
			/* if (TESTMODE) 
			 echo ("<p class=\"centr\">TEST MODE ENABLED</p>\n");
			echo ("<p class=\"centr\">Processing file: <b>".$curfilename."</b></p>\n");
			echo ("<p class=\"smlcentr\">Starting from line: ".$_REQUEST["start"]."</p>\n");	*/
			
			
		  }
		
		// Check $_REQUEST["foffset"] upon $filesize (can't do it on gzipped files)
		
		  if (!$error && !$gzipmode && $_REQUEST["foffset"]>$filesize)
		  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer behind the end of file</p>\n");
			$error=true;
		  }
		
		// Set file pointer to $_REQUEST["foffset"]
		
		  if (!$error && ((!$gzipmode && fseek($file, $_REQUEST["foffset"])!=0) || ($gzipmode && gzseek($file, $_REQUEST["foffset"])!=0)))
		  { echo ("<p class=\"error\">UNEXPECTED: Can't set file pointer to offset: ".$_REQUEST["foffset"]."</p>\n");
			$error=true;
		  }
		
		// Start processing queries from $file
		
		  if (!$error)
		  { $query="";
			$queries=0;
			$totalqueries=$_REQUEST["totalqueries"];
			$linenumber=$_REQUEST["start"];
			$querylines=0;
			$inparents=false;
		
		// Stay processing as long as the $linespersession is not reached or the query is still incomplete
		
			while ($linenumber<$_REQUEST["start"]+$linespersession || $query!="")
			{
		
		// Read the whole next line
		
			  $dumpline = "";
			  while (!feof($file) && substr ($dumpline, -1) != "\n" && substr ($dumpline, -1) != "\r")
			  { if (!$gzipmode)
				  $dumpline .= fgets($file, DATA_CHUNK_LENGTH);
				else
				  $dumpline .= gzgets($file, DATA_CHUNK_LENGTH);
			  }
			  if ($dumpline==="") break;
		
		
		// Stop if csv file is used, but $csv_insert_table is not set
			  if (($csv_insert_table == "") && (preg_match("/(\.csv)$/i",$curfilename)))
			  {
				echo ("<p class=\"error\">Stopped at the line $linenumber. </p>");
				echo ('<p>At this place the current query is from csv file, but $csv_insert_table was not set.');
				echo ("You have to tell where you want to send your data.</p>\n");
				$error=true;
				break;
			  }
			 
		// Create an SQL query from CSV line
		
			  if (($csv_insert_table != "") && (preg_match("/(\.csv)$/i",$curfilename)))
				$dumpline = 'INSERT INTO '.$csv_insert_table.' VALUES ('.$dumpline.');';
		
		// Handle DOS and Mac encoded linebreaks (I don't know if it will work on Win32 or Mac Servers)
		
			  $dumpline=str_replace("\r\n", "\n", $dumpline);
			  $dumpline=str_replace("\r", "\n", $dumpline);
					
		// DIAGNOSTIC
		// echo ("<p>Line $linenumber: $dumpline</p>\n");
		
		// Skip comments and blank lines only if NOT in parents
		
			  if (!$inparents)
			  { $skipline=false;
				reset($comment);
				foreach ($comment as $comment_value)
				{ if (!$inparents && (trim($dumpline)=="" || strpos ($dumpline, $comment_value) === 0))
				  { $skipline=true;
					break;
				  }
				}
				if ($skipline)
				{ $linenumber++;
				  continue;
				}
			  }
		
		// Remove double back-slashes from the dumpline prior to count the quotes ('\\' can only be within strings)
			  
			  $dumpline_deslashed = str_replace ("\\\\","",$dumpline);
		
		// Count ' and \' in the dumpline to avoid query break within a text field ending by ;
		// Please don't use double quotes ('"')to surround strings, it wont work
		
			  $parents=substr_count ($dumpline_deslashed, "'")-substr_count ($dumpline_deslashed, "\\'");
			  if ($parents % 2 != 0)
				$inparents=!$inparents;
		
		// Add the line to query
		
			  $query .= $dumpline;
		
		// Don't count the line if in parents (text fields may include unlimited linebreaks)
			  
			  if (!$inparents)
				$querylines++;
			  
		// Stop if query contains more lines as defined by MAX_QUERY_LINES
		
			  if ($querylines>MAX_QUERY_LINES)
			  {
				echo ("<p class=\"error\">Stopped at the line $linenumber. </p>");
				echo ("<p>At this place the current query includes more than ".MAX_QUERY_LINES." dump lines. That can happen if your dump file was ");
				echo ("created by some tool which doesn't place a semicolon followed by a linebreak at the end of each query, or if your dump contains ");
				echo ("extended inserts. Please read the BigDump FAQs for more infos.</p>\n");
				$error=true;
				break;
			  }
		
		// Execute query if end of query detected (; as last character) AND NOT in parents
		
			  if (preg_match("/;$/",trim($dumpline)) && !$inparents)
			  { if (!TESTMODE && !mysql_query(trim($query), $dbconnection))
				{ echo ("<p class=\"error\">Error at the line $linenumber: ". trim($dumpline)."</p>\n");
				  echo ("<p>Query: ".trim(nl2br(htmlentities($query)))."</p>\n");
				  echo ("<p>MySQL: ".mysql_error()."</p>\n");
				  $error=true;
				  break;
				}
				$totalqueries++;
				$queries++;
				$query="";
				$querylines=0;
			  }
			  $linenumber++;
			}
		  }
		
		// Get the current file position
		
		  if (!$error)
		  { if (!$gzipmode) 
			  $foffset = ftell($file);
			else
			  $foffset = gztell($file);
			if (!$foffset)
			{ echo ("<p class=\"error\">UNEXPECTED: Can't read the file pointer offset</p>\n");
			  $error=true;
			}
		  }
		
		// Print statistics
		
		
		
		// echo ("<p class=\"centr\"><b>Statistics</b></p>\n");
		
		  if (!$error)
		  { 
			$lines_this   = $linenumber-$_REQUEST["start"];
			$lines_done   = $linenumber-1;
			$lines_togo   = ' ? ';
			$lines_tota   = ' ? ';
			
			$queries_this = $queries;
			$queries_done = $totalqueries;
			$queries_togo = ' ? ';
			$queries_tota = ' ? ';
		
			$bytes_this   = $foffset-$_REQUEST["foffset"];
			$bytes_done   = $foffset;
			$kbytes_this  = round($bytes_this/1024,2);
			$kbytes_done  = round($bytes_done/1024,2);
			$mbytes_this  = round($kbytes_this/1024,2);
			$mbytes_done  = round($kbytes_done/1024,2);
		   
			if (!$gzipmode)
			{
			  $bytes_togo  = $filesize-$foffset;
			  $bytes_tota  = $filesize;
			  $kbytes_togo = round($bytes_togo/1024,2);
			  $kbytes_tota = round($bytes_tota/1024,2);
			  $mbytes_togo = round($kbytes_togo/1024,2);
			  $mbytes_tota = round($kbytes_tota/1024,2);
			  
			  $pct_this   = ceil($bytes_this/$filesize*100);
			  $pct_done   = ceil($foffset/$filesize*100);
			  $pct_togo   = 100 - $pct_done;
			  $pct_tota   = 100;
		
			  if ($bytes_togo==0) 
			  { $lines_togo   = '0'; 
				$lines_tota   = $linenumber-1; 
				$queries_togo = '0'; 
				$queries_tota = $totalqueries; 
			  }
		
			  $pct_bar    = "<div style=\"height:15px;width:$pct_done%;background-color:#000080;margin:0px;\"></div>";
			}
			else
			{
			  $bytes_togo  = ' ? ';
			  $bytes_tota  = ' ? ';
			  $kbytes_togo = ' ? ';
			  $kbytes_tota = ' ? ';
			  $mbytes_togo = ' ? ';
			  $mbytes_tota = ' ? ';
			  
			  $pct_this    = ' ? ';
			  $pct_done    = ' ? ';
			  $pct_togo    = ' ? ';
			  $pct_tota    = 100;
			  $pct_bar     = str_replace(' ','&nbsp;','<tt>[         Not available for gzipped files          ]</tt>');
			}
			/*
			echo ("
			<center>
			<table width=\"520\" border=\"0\" cellpadding=\"3\" cellspacing=\"1\">
			<tr><th class=\"bg4\"> </th><th class=\"bg4\">Session</th><th class=\"bg4\">Done</th><th class=\"bg4\">To go</th><th class=\"bg4\">Total</th></tr>
			<tr><th class=\"bg4\">Lines</th><td class=\"bg3\">$lines_this</td><td class=\"bg3\">$lines_done</td><td class=\"bg3\">$lines_togo</td><td class=\"bg3\">$lines_tota</td></tr>
			<tr><th class=\"bg4\">Queries</th><td class=\"bg3\">$queries_this</td><td class=\"bg3\">$queries_done</td><td class=\"bg3\">$queries_togo</td><td class=\"bg3\">$queries_tota</td></tr>
			<tr><th class=\"bg4\">Bytes</th><td class=\"bg3\">$bytes_this</td><td class=\"bg3\">$bytes_done</td><td class=\"bg3\">$bytes_togo</td><td class=\"bg3\">$bytes_tota</td></tr>
			<tr><th class=\"bg4\">KB</th><td class=\"bg3\">$kbytes_this</td><td class=\"bg3\">$kbytes_done</td><td class=\"bg3\">$kbytes_togo</td><td class=\"bg3\">$kbytes_tota</td></tr>
			<tr><th class=\"bg4\">MB</th><td class=\"bg3\">$mbytes_this</td><td class=\"bg3\">$mbytes_done</td><td class=\"bg3\">$mbytes_togo</td><td class=\"bg3\">$mbytes_tota</td></tr>
			<tr><th class=\"bg4\">%</th><td class=\"bg3\">$pct_this</td><td class=\"bg3\">$pct_done</td><td class=\"bg3\">$pct_togo</td><td class=\"bg3\">$pct_tota</td></tr>
			<tr><th class=\"bg4\">% bar</th><td class=\"bgpctbar\" colspan=\"4\">$pct_bar</td></tr>
			</table>
			</center>
			\n");*/
		
			echo "Import Successfull"; exit;
			
		// Finish message and restart the script
		
			if ($linenumber<$_REQUEST["start"]+$linespersession)
			{ 
			  $error=true;
			}
			else
			{ if ($delaypersession!=0)
				echo ("<p class=\"centr\">Now I'm <b>waiting $delaypersession milliseconds</b> before starting next session...</p>\n");
				if (!$ajax) 
				  echo ("<script language=\"JavaScript\" type=\"text/javascript\">window.setTimeout('location.href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&fn=".urlencode($curfilename)."&foffset=$foffset&totalqueries=$totalqueries\";',500+$delaypersession);</script>\n");
				echo ("<noscript>\n");
				echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."?start=$linenumber&amp;fn=".urlencode($curfilename)."&amp;foffset=$foffset&amp;totalqueries=$totalqueries\">Continue from the line $linenumber</a> (Enable JavaScript to do it automatically)</p>\n");
				echo ("</noscript>\n");
		   
			  echo ("<p class=\"centr\">Press <b><a href=\"".$_SERVER["PHP_SELF"]."\">STOP</a></b> to abort the import <b>OR WAIT!</b></p>\n");
			}
		  }
		  else 
			echo ("<p class=\"error\">Stopped on error</p>\n");
		
		
		
		}
		
		if ($error)
		  #echo ("<p class=\"centr\"><a href=\"".$_SERVER["PHP_SELF"]."\">Start from the beginning</a> (DROP the old tables before restarting)</p>\n");
		
		if ($dbconnection) mysql_close($dbconnection);
		if ($file && !$gzipmode) fclose($file);
		else if ($file && $gzipmode) gzclose($file);

}

/******************************/
/******************************/
$db_server   = 'localhost';
$db_name     = 'agrinde_erp_parwez';
$db_username = 'root';
$db_password = '';
$filename           = 'superadmin/sql/agrinde_erp.sql';   
ImportDatabase($db_server,$db_name,$db_username,$db_password,$filename);

?>

