<?php
require("inc.php");
$query = mssql_query('select * from ProductType');
$num = mssql_num_rows($query);

mysql_query("DELETE FROM ProductType",$mysqllink2);
$query2 = "INSERT INTO ProductType(PTCode
                                  ,PTDesc1
                                  ,PTDesc2
                                  ,PTUOM
                                  ,PTUOMRef
                                  ,PTRemarks
                                  ,LastUpdate
                                  ,LastUpdatedBy
                                  ,Expired
                                  ,ActionLog
                                  ,PTPersonal
                                  ,PTGroup
                                  ,PTSpecial
                                  ,PTClub
                                  ,IncAmt) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo mysql_real_escape_string($record['WTCode']."-".mysql_real_escape_string($record['WTDesc1']."  /  ";
    if (($i!=$num) && ($i%1000!=0) )
        $query2 .= "('".mysql_real_escape_string($record['PTCode']).
        "','".mysql_real_escape_string($record['PTDesc1']).
        "','".mysql_real_escape_string($record['PTDesc2']).
        "','".mysql_real_escape_string($record['PTUOM']).
        "','".mysql_real_escape_string($record['PTUOMRef']).
        "','".mysql_real_escape_string($record['PTRemarks']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['Expired']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['PTPersonal']).
        "','".mysql_real_escape_string($record['PTGroup']).
        "','".mysql_real_escape_string($record['PTSpecial']).
        "','".mysql_real_escape_string($record['PTClub']).
        "','".mysql_real_escape_string($record['IncAmt'])."'),";
    else {
        $query2 .= "('".mysql_real_escape_string($record['PTCode']).
        "','".mysql_real_escape_string($record['PTDesc1']).
        "','".mysql_real_escape_string($record['PTDesc2']).
        "','".mysql_real_escape_string($record['PTUOM']).
        "','".mysql_real_escape_string($record['PTUOMRef']).
        "','".mysql_real_escape_string($record['PTRemarks']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['Expired']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['PTPersonal']).
        "','".mysql_real_escape_string($record['PTGroup']).
        "','".mysql_real_escape_string($record['PTSpecial']).
        "','".mysql_real_escape_string($record['PTClub']).
        "','".mysql_real_escape_string($record['IncAmt'])."')";
        //echo $query2;
        $result = mysql_query($query2,$mysqllink2); 
        
        $query2 = "INSERT INTO ProductType(PTCode
                                  ,PTDesc1
                                  ,PTDesc2
                                  ,PTUOM
                                  ,PTUOMRef
                                  ,PTRemarks
                                  ,LastUpdate
                                  ,LastUpdatedBy
                                  ,Expired
                                  ,ActionLog
                                  ,PTPersonal
                                  ,PTGroup
                                  ,PTSpecial
                                  ,PTClub
                                  ,IncAmt) VALUES ";
    } $i++; }
    
    
    //$result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed(producttype) "; else echo "error(producttype) ";
    //echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>