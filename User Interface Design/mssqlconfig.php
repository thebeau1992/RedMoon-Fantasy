<?

$hostname = "HIDDEN";
$dbuser = "HIDDEN";
$dbpassword = "HIDDEN";
$dbname = "HIDDEN";
     $db_link=mssql_connect($hostname, $dbuser, $dbpassword) 
     or die("Unable to connect to the server!");
     mssql_select_db($dbname)
     or die("Unable to connect to the database");
?>