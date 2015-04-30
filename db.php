<?

$dbhost = 'localhost';  // Cpanel UserName & Password
$dbuser = 'phptest';
$dbpass = 'pw+xSC@wbh{W';


// Create Database using php
$conn = mysql_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
  die('Could not connect: ' . mysql_error());
}

/*
//echo 'Connected successfully';
$sql = 'CREATE Database phptest_eastessence_test';
$retval = mysql_query( $sql, $conn );
if(! $retval )
{
  die('Could not create database: ' . mysql_error());
}
echo "Database phptest_eastessence_test created successfully\n";
mysql_close($conn);
exit;
*/


// DROP DATABASE
$sql = 'DROP DATABASE phptest_eastessence_test';
if (mysql_query($sql, $conn)) {
    echo "Database phptest_eastessence_test was successfully dropped\n";
} else {
    echo 'Error dropping database: ' . mysql_error() ;
}
exit;


// Connect multiple database using php
$dbname1 = 'phptest_eastessence';
$dbname2 = 'phptest_eastessence_test';
function connecttodb($servername,$dbname,$dbusername,$dbpassword)
{
    $link=mysql_connect ($servername,$dbusername,$dbpassword,TRUE);
    if(!$link){die("Could not connect to MySQL");}
    mysql_select_db("$dbname",$link) or die ("could not open db".mysql_error());
    return $link;
}

$link1 = connecttodb($dbhost,$dbname1,$dbuser,$dbpass);
$link2 = connecttodb($dbhost,$dbname2,$dbuser,$dbpass);

$q=mysql_query("select * from admin ",$link1) or die (mysql_error());
$ar1=mysql_fetch_array($q);
echo "<pre>";
print_r($ar1);

echo "<br><br>";
$q=mysql_query("update employee set FirstName='Parwez' where EmpID=1 ",$link2) or die (mysql_error());

$q=mysql_query("select * from employee ",$link2) or die (mysql_error());
$ar1=mysql_fetch_array($q);
print_r($ar1);
?>