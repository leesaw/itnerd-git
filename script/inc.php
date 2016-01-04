<?php 
$link = mssql_connect("192.168.4.12","sa","JESnggSa");
$objConnect = mssql_select_db('JES_NGG', $link);

$mysqllink2 = mysql_connect("127.0.0.1","root","root");
$connect2 = mysql_select_db("test",$mysqllink2);

?>