<?php
require("inc.php");
$query = mssql_query('select * from Warehouse');
$num = mssql_num_rows($query);

mysql_query("DELETE FROM Warehouse",$mysqllink2);
$query2 = "INSERT INTO Warehouse(WHCode
                                ,WHOldCode
                                ,WHDesc1
                                ,WHDesc2
                                ,WHType
                                ,WHSBU
                                ,WHLocation
                                ,WHVarianceRpt
                                ,LastUpdate
                                ,LastUpdatedBy
                                ,Expired
                                ,ActionLog
                                ,WHAccessibleToAllFrom
                                ,WHAccessibleToAllTo
                                ,WHAccessibleToAllView) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo mysql_real_escape_string($record['WTCode']."-".mysql_real_escape_string($record['WTDesc1']."  /  ";
    if (($i!=$num) && ($i%1000!=0) )
        $query2 .= "('".mysql_real_escape_string($record['WHCode']).
        "','".mysql_real_escape_string($record['WHOldCode']).
        "','".mysql_real_escape_string($record['WHDesc1']).
        "','".mysql_real_escape_string($record['WHDesc2']).
        "','".mysql_real_escape_string($record['WHType']).
        "','".mysql_real_escape_string($record['WHSBU']).
        "','".mysql_real_escape_string($record['WHLocation']).
        "','".mysql_real_escape_string($record['WHVarianceRpt']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['Expired']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['WHAccessibleToAllFrom']).
        "','".mysql_real_escape_string($record['WHAccessibleToAllTo']).
        "','".mysql_real_escape_string($record['WHAccessibleToAllView'])."'),";
    else {
        $query2 .= "('".mysql_real_escape_string($record['WHCode']).
        "','".mysql_real_escape_string($record['WHOldCode']).
        "','".mysql_real_escape_string($record['WHDesc1']).
        "','".mysql_real_escape_string($record['WHDesc2']).
        "','".mysql_real_escape_string($record['WHType']).
        "','".mysql_real_escape_string($record['WHSBU']).
        "','".mysql_real_escape_string($record['WHLocation']).
        "','".mysql_real_escape_string($record['WHVarianceRpt']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['Expired']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['WHAccessibleToAllFrom']).
        "','".mysql_real_escape_string($record['WHAccessibleToAllTo']).
        "','".mysql_real_escape_string($record['WHAccessibleToAllView'])."')";
        //echo $query2;
        $result = mysql_query($query2,$mysqllink2); 
        
        $query2 = "INSERT INTO Warehouse(WHCode
                                ,WHOldCode
                                ,WHDesc1
                                ,WHDesc2
                                ,WHType
                                ,WHSBU
                                ,WHLocation
                                ,WHVarianceRpt
                                ,LastUpdate
                                ,LastUpdatedBy
                                ,Expired
                                ,ActionLog
                                ,WHAccessibleToAllFrom
                                ,WHAccessibleToAllTo
                                ,WHAccessibleToAllView) VALUES ";
    } $i++; }
    
    
    //$result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed(warehouse) "; else echo "error(warehouse) ";
    //echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>