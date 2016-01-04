<?php
require("inc.php");
$query = mssql_query('select * from ItemWHBal');
$num = mssql_num_rows($query);

mysql_query("DELETE FROM ItemWHBal",$mysqllink2);
$query2 = "INSERT INTO ItemWHBal(IHPK
                                ,IHWareHouse
                                ,IHBarcode
                                ,IHItemType
                                ,IHItemCode
                                ,IHQtyCal
                                ,IHQtyRef
                                ,LastUpdate
                                ,LastUpdatedBy
                                ,Expired
                                ,ActionLog) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo mysql_real_escape_string($record['WTCode']."-".mysql_real_escape_string($record['WTDesc1']."  /  ";
    if (($i!=$num) && ($i%1000!=0) )
        $query2 .= "('".mysql_real_escape_string($record['IHPK']).
        "','".mysql_real_escape_string($record['IHWareHouse']).
        "','".mysql_real_escape_string($record['IHBarcode']).
        "','".mysql_real_escape_string($record['IHItemType']).
        "','".mysql_real_escape_string($record['IHItemCode']).
        "','".mysql_real_escape_string($record['IHQtyCal']).
        "','".mysql_real_escape_string($record['IHQtyRef']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['Expired']).
        "','".mysql_real_escape_string($record['ActionLog'])."'),";
    else {
        $query2 .= "('".mysql_real_escape_string($record['IHPK']).
        "','".mysql_real_escape_string($record['IHWareHouse']).
        "','".mysql_real_escape_string($record['IHBarcode']).
        "','".mysql_real_escape_string($record['IHItemType']).
        "','".mysql_real_escape_string($record['IHItemCode']).
        "','".mysql_real_escape_string($record['IHQtyCal']).
        "','".mysql_real_escape_string($record['IHQtyRef']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['Expired']).
        "','".mysql_real_escape_string($record['ActionLog'])."')";
        //echo $query2;
        $result = mysql_query($query2,$mysqllink2); 
        
        $query2 = "INSERT INTO ItemWHBal(IHPK
                                ,IHWareHouse
                                ,IHBarcode
                                ,IHItemType
                                ,IHItemCode
                                ,IHQtyCal
                                ,IHQtyRef
                                ,LastUpdate
                                ,LastUpdatedBy
                                ,Expired
                                ,ActionLog) VALUES ";
    } $i++; }
    
    
    //$result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed(itemwhbal) "; else echo "error(itemwhbal) ";
    //echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>