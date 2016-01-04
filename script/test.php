<?php

$link = mssql_connect("192.168.4.12","sa","JESnggSa");
$objConnect = mssql_select_db('JES_NGG', $link);
$query = mssql_query('select WTCode, WTDesc1 from WarehouseType');
$num = mssql_num_rows($query);

$mysqllink2 = mysql_connect("127.0.0.1","root","root");
$connect2 = mysql_select_db("test",$mysqllink2);
$query2 = "INSERT INTO test_jes(id,name) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo $record['WTCode']."-".$record['WTDesc1']."  /  ";
    if ($i!=$num)
        $query2 .= "('".$record['WTCode']."','".$record['WTDesc1']."'),";
    else
        $query2 .= "('".$record['WTCode']."','".$record['WTDesc1']."')";
    $i++;
}
    echo $query2;
    $result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed"; else echo "error";
    echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>