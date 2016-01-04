<?php

require("inc.php");

$query = mssql_query('select * from ItemFinGoods');
$num = mssql_num_rows($query);

mysql_query("DELETE FROM ItemFinGoods",$mysqllink2);
$query2 = "INSERT INTO ItemFinGoods(IFPK
                            ,IFITPK
                            ,IFItemCode
                            ,IFRevision
                            ,IFProdType
                            ,IFDesignNo
                            ,IFRunningNo
                            ,IFAlloy
                            ,IFStoneType
                            ,IFStoneCombination
                            ,IFIsMultiStone
                            ,LastUpdate
                            ,LastUpdatedBy
                            ,ActionLog
                            ,IFPOSGoldProduct
                            ,IFSize
                            ,IFLastDepreciationDate
                            ,IFStoneClarity) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo mysql_real_escape_string($record['WTCode']."-".mysql_real_escape_string($record['WTDesc1']."  /  ";
    if (($i!=$num) && ($i%1000!=0) )
        $query2 .= "('".mysql_real_escape_string($record['IFPK']).
        "','".mysql_real_escape_string($record['IFITPK']).
        "','".mysql_real_escape_string($record['IFItemCode']).
        "','".mysql_real_escape_string($record['IFRevision']).
        "','".mysql_real_escape_string($record['IFProdType']).
        "','".mysql_real_escape_string($record['IFDesignNo']).
        "','".mysql_real_escape_string($record['IFRunningNo']).
        "','".mysql_real_escape_string($record['IFAlloy']).
        "','".mysql_real_escape_string($record['IFStoneType']).
        "','".mysql_real_escape_string($record['IFStoneCombination']).
        "','".mysql_real_escape_string($record['IFIsMultiStone']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['IFPOSGoldProduct']).
        "','".mysql_real_escape_string($record['IFSize']).
        "','".mysql_real_escape_string($record['IFLastDepreciationDate']).
        "','".mysql_real_escape_string($record['IFStoneClarity'])."'),";
    else {
        $query2 .= "('".mysql_real_escape_string($record['IFPK']).
        "','".mysql_real_escape_string($record['IFITPK']).
        "','".mysql_real_escape_string($record['IFItemCode']).
        "','".mysql_real_escape_string($record['IFRevision']).
        "','".mysql_real_escape_string($record['IFProdType']).
        "','".mysql_real_escape_string($record['IFDesignNo']).
        "','".mysql_real_escape_string($record['IFRunningNo']).
        "','".mysql_real_escape_string($record['IFAlloy']).
        "','".mysql_real_escape_string($record['IFStoneType']).
        "','".mysql_real_escape_string($record['IFStoneCombination']).
        "','".mysql_real_escape_string($record['IFIsMultiStone']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['IFPOSGoldProduct']).
        "','".mysql_real_escape_string($record['IFSize']).
        "','".mysql_real_escape_string($record['IFLastDepreciationDate']).
        "','".mysql_real_escape_string($record['IFStoneClarity'])."')";
        //echo $query2;
        $result = mysql_query($query2,$mysqllink2); 
        
        $query2 = "INSERT INTO ItemFinGoods(IFPK
                            ,IFITPK
                            ,IFItemCode
                            ,IFRevision
                            ,IFProdType
                            ,IFDesignNo
                            ,IFRunningNo
                            ,IFAlloy
                            ,IFStoneType
                            ,IFStoneCombination
                            ,IFIsMultiStone
                            ,LastUpdate
                            ,LastUpdatedBy
                            ,ActionLog
                            ,IFPOSGoldProduct
                            ,IFSize
                            ,IFLastDepreciationDate
                            ,IFStoneClarity) VALUES ";
    } $i++; }
    
    
    //$result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed(itemfingoods) "; else echo "error(itemfingoods) ";
    //echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>