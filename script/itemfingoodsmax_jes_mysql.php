<?php

require("inc.php");

$query = mssql_query("select IFItemCode, MAX(IFPK) as MIFPK from ItemFinGoods group by IFItemCode");
$num = mssql_num_rows($query);

mysql_query("DELETE FROM ItemFinGoods",$mysqllink2);
$query2 = "INSERT INTO ItemFinGoodsMax(IFItemCode, MIFPK) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo mysql_real_escape_string($record['WTCode']."-".mysql_real_escape_string($record['WTDesc1']."  /  ";
    if (($i!=$num) && ($i%1000!=0) )
        $query2 .= "('".mysql_real_escape_string($record['IFItemCode']).
        "','".mysql_real_escape_string($record['MIFPK'])."'),";
    else {
        $query2 .= "('".mysql_real_escape_string($record['IFItemCode']).
        "','".mysql_real_escape_string($record['MIFPK'])."')";
        //echo $query2;
        $result = mysql_query($query2,$mysqllink2); 
        
        $query2 = "INSERT INTO ItemFinGoodsMax(IFItemCode, MIFPK) VALUES ";
    } $i++; }
    
    
    //$result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed(itemfingoods_max) "; else echo "error(itemfingoods_max) ";
    //echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>