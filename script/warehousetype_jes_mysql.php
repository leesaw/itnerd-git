<?php
require("inc.php");
$query = mssql_query('select * from WarehouseType');
$num = mssql_num_rows($query);

mysql_query("DELETE FROM WarehouseType",$mysqllink2);
$query2 = "INSERT INTO WarehouseType(WTCode
                                    ,WTDesc1
                                    ,WTDesc2
                                    ,WTRemarks
                                    ,LastUpdate
                                    ,LastUpdatedBy
                                    ,ActionLog
                                    ,Expired) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo mysql_real_escape_string($record['WTCode']."-".mysql_real_escape_string($record['WTDesc1']."  /  ";
    if (($i!=$num) && ($i%1000!=0) )
        $query2 .= "('".mysql_real_escape_string($record['WTCode']).
        "','".mysql_real_escape_string($record['WTDesc1']).
        "','".mysql_real_escape_string($record['WTDesc2']).
        "','".mysql_real_escape_string($record['WTRemarks']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['Expired'])."'),";
    else {
        $query2 .= "('".mysql_real_escape_string($record['WTCode']).
        "','".mysql_real_escape_string($record['WTDesc1']).
        "','".mysql_real_escape_string($record['WTDesc2']).
        "','".mysql_real_escape_string($record['WTRemarks']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['Expired'])."')";
        //echo $query2;
        $result = mysql_query($query2,$mysqllink2); 
        
        $query2 = "INSERT INTO WarehouseType(WTCode
                                    ,WTDesc1
                                    ,WTDesc2
                                    ,WTRemarks
                                    ,LastUpdate
                                    ,LastUpdatedBy
                                    ,ActionLog
                                    ,Expired) VALUES ";
    } $i++; }
    
    
    //$result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed(warehousetype) "; else echo "error(warehousetype) ";
    //echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>