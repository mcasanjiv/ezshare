<?php
include ("ClassSQLimport.php");
/*
$host = "yourDBHost";
$dbUser = "youuser";
$dbPassword = "yourpass";
$sqlFile = "yourSqlFile.sql";
*/

$host = "localhost";
$dbUser = "root";
$dbPassword = "";
$sqlFile = "SQLTest.sql";

$newImport = new sqlImport ($host, $dbUser, $dbPassword, $sqlFile);
$newImport -> import ();




//------------------ Show Messages !!! ---------------------------
$import = $newImport -> ShowErr ();

if ($import["exito"] == 1)
{
echo "Felicidades !!!. La instalaci�n se ha completado con �xito";
} else {
echo $import ["errorCode"].": ".$import ["errorText"];
}

?> 