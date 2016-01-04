<?php

require("inc.php");

$query = mssql_query('select * from Item');
$num = mssql_num_rows($query);

mysql_query("DELETE FROM Item",$mysqllink2);
$query2 = "INSERT INTO Item(ITPK,
                            ITMasterITPK,
                            ITType,
                            ITCode,
                            ITRefCode,
                            ITRevision,
                            ITVersion,
                            ITHasBOM,
                            ITHasLabour,
                            ITHasAdditional,
                            ITProdType,
                            ITDesignNo,
                            ITAlloy,
                            ITStoneType,
                            ITStoneCombine,
                            ITisMultiStone,
                            ITRunningNo,
                            ITShortDesc1,
                            ITShortDesc2,
                            ITLongDesc1,
                            ITLongDesc2,
                            ITBarCode,
                            ITLabourCost,
                            ITTotalAddCost,
                            ITTotalStoneCost,
                            ITTotalMetalCost,
                            ITACost,
                            ITBCost,
                            ITCCost,
                            ITSRP,
                            ITUOM,
                            ITUOMRef,
                            ITMinStock,
                            ITMaxStock,
                            ITDateOfCreation,
                            ITRouting,
                            ITRemarks,
                            ITPicture1,
                            ITPicture2,
                            ITPicture1Type,
                            ITPicture2Type,
                            ITECNRemarks,
                            ITECNOriginator,
                            ITECNDate,
                            ITECNApprovedBy,
                            ITACostOverride,
                            ITBCostOverride,
                            ITCCostOverride,
                            ITLabourCostDrill,
                            ITAddCostDrill,
                            ITDefaultSupplier,
                            LastUpdate,
                            LastUpdatedBy,
                            Expired,
                            ITExpireReason,
                            ActionLog,
                            ITPriceRemark,
                            ITLUseInPOS,
                            isRecalSRP,
                            itCertDescription,
                            ITCertDescription2,
                            ITIsConsignmentItem,
                            ITMaxInvoiceDiscount,
                            ITDefaultSBU,
                            ICS_Field1,
                            ICS_Field2,
                            ICS_Field3,
                            ICS_Field4,
                            ICS_Field5,
                            ICS_Field6,
                            ICS_Field7,
                            ICS_Field8,
                            ICS_Field9,
                            ICS_Field10,
                            Puregold) VALUES ";


if($query)
{
    $i=1;
while ( $record = mssql_fetch_array($query) )
{
    //echo mysql_real_escape_string($record['WTCode']."-".mysql_real_escape_string($record['WTDesc1']."  /  ";
    //if ((($i>=4000) && ($i<=4500)) || ($i==39941)) {
    if (($i!=$num) && ($i%1000!=0) )
        $query2 .= "('".mysql_real_escape_string($record['ITPK']).
        "','".mysql_real_escape_string($record['ITMasterITPK']).
        "','".mysql_real_escape_string($record['ITType']).
        "','".mysql_real_escape_string($record['ITCode']).
        "','".mysql_real_escape_string($record['ITRefCode']).
        "','".mysql_real_escape_string($record['ITRevision']).
        "','".mysql_real_escape_string($record['ITVersion']).
        "','".mysql_real_escape_string($record['ITHasBOM']).
        "','".mysql_real_escape_string($record['ITHasLabour']).
        "','".mysql_real_escape_string($record['ITHasAdditional']).
        "','".mysql_real_escape_string($record['ITProdType']).
        "','".mysql_real_escape_string($record['ITDesignNo']).
        "','".mysql_real_escape_string($record['ITAlloy']).
        "','".mysql_real_escape_string($record['ITStoneType']).
        "','".mysql_real_escape_string($record['ITStoneCombine']).
        "','".mysql_real_escape_string($record['ITisMultiStone']).
        "','".mysql_real_escape_string($record['ITRunningNo']).
        "','".mysql_real_escape_string($record['ITShortDesc1']).
        "','".mysql_real_escape_string($record['ITShortDesc2']).
        "','".mysql_real_escape_string($record['ITLongDesc1']).
        "','".mysql_real_escape_string($record['ITLongDesc2']).
        "','".mysql_real_escape_string($record['ITBarCode']).
        "','".mysql_real_escape_string($record['ITLabourCost']).
        "','".mysql_real_escape_string($record['ITTotalAddCost']).
        "','".mysql_real_escape_string($record['ITTotalStoneCost']).
        "','".mysql_real_escape_string($record['ITTotalMetalCost']).
        "','".mysql_real_escape_string($record['ITACost']).
        "','".mysql_real_escape_string($record['ITBCost']).
        "','".mysql_real_escape_string($record['ITCCost']).
        "','".mysql_real_escape_string($record['ITSRP']).
        "','".mysql_real_escape_string($record['ITUOM']).
        "','".mysql_real_escape_string($record['ITUOMRef']).
        "','".mysql_real_escape_string($record['ITMinStock']).
        "','".mysql_real_escape_string($record['ITMaxStock']).
        "','".mysql_real_escape_string($record['ITDateOfCreation']).
        "','".mysql_real_escape_string($record['ITRouting']).
        "','".mysql_real_escape_string($record['ITRemarks']).
        "','".mysql_real_escape_string($record['ITPicture1']).
        "','".mysql_real_escape_string($record['ITPicture2']).
        "','".mysql_real_escape_string($record['ITPicture1Type']).
        "','".mysql_real_escape_string($record['ITPicture2Type']).
        "','".mysql_real_escape_string($record['ITECNRemarks']).
        "','".mysql_real_escape_string($record['ITECNOriginator']).
        "','".mysql_real_escape_string($record['ITECNDate']).
        "','".mysql_real_escape_string($record['ITECNApprovedBy']).
        "','".mysql_real_escape_string($record['ITACostOverride']).
        "','".mysql_real_escape_string($record['ITBCostOverride']).
        "','".mysql_real_escape_string($record['ITCCostOverride']).
        "','".mysql_real_escape_string($record['ITLabourCostDrill']).
        "','".mysql_real_escape_string($record['ITAddCostDrill']).
        "','".mysql_real_escape_string($record['ITDefaultSupplier']).
        "','".mysql_real_escape_string($record['LastUpdate']).
        "','".mysql_real_escape_string($record['LastUpdatedBy']).
        "','".mysql_real_escape_string($record['Expired']).
        "','".mysql_real_escape_string($record['ITExpireReason']).
        "','".mysql_real_escape_string($record['ActionLog']).
        "','".mysql_real_escape_string($record['ITPriceRemark']).
        "','".mysql_real_escape_string($record['ITLUseInPOS']).
        "','".mysql_real_escape_string($record['isRecalSRP']).
        "','".mysql_real_escape_string($record['itCertDescription']).
        "','".mysql_real_escape_string($record['ITCertDescription2']).
        "','".mysql_real_escape_string($record['ITIsConsignmentItem']).
        "','".mysql_real_escape_string($record['ITMaxInvoiceDiscount']).
        "','".mysql_real_escape_string($record['ITDefaultSBU']).
        "','".mysql_real_escape_string($record['ICS_Field1']).
        "','".mysql_real_escape_string($record['ICS_Field2']).
        "','".mysql_real_escape_string($record['ICS_Field3']).
        "','".mysql_real_escape_string($record['ICS_Field4']).
        "','".mysql_real_escape_string($record['ICS_Field5']).
        "','".mysql_real_escape_string($record['ICS_Field6']).
        "','".mysql_real_escape_string($record['ICS_Field7']).
        "','".mysql_real_escape_string($record['ICS_Field8']).
        "','".mysql_real_escape_string($record['ICS_Field9']).
        "','".mysql_real_escape_string($record['ICS_Field10']).
        "','".mysql_real_escape_string($record['Puregold'])."'),";
    else {
        $query2 .= "('".mysql_real_escape_string($record['ITPK'])."','".mysql_real_escape_string($record['ITMasterITPK'])."','".mysql_real_escape_string($record['ITType'])."','".mysql_real_escape_string($record['ITCode'])."','".mysql_real_escape_string($record['ITRefCode'])."','".mysql_real_escape_string($record['ITRevision'])."','".mysql_real_escape_string($record['ITVersion'])."','".mysql_real_escape_string($record['ITHasBOM'])."','".mysql_real_escape_string($record['ITHasLabour'])."','".mysql_real_escape_string($record['ITHasAdditional'])."','".mysql_real_escape_string($record['ITProdType'])."','".mysql_real_escape_string($record['ITDesignNo'])."','".mysql_real_escape_string($record['ITAlloy'])."','".mysql_real_escape_string($record['ITStoneType'])."','".mysql_real_escape_string($record['ITStoneCombine'])."','".mysql_real_escape_string($record['ITisMultiStone'])."','".mysql_real_escape_string($record['ITRunningNo'])."','".mysql_real_escape_string($record['ITShortDesc1'])."','".mysql_real_escape_string($record['ITShortDesc2'])."','".mysql_real_escape_string($record['ITLongDesc1'])."','".mysql_real_escape_string($record['ITLongDesc2'])."','".mysql_real_escape_string($record['ITBarCode'])."','".mysql_real_escape_string($record['ITLabourCost'])."','".mysql_real_escape_string($record['ITTotalAddCost'])."','".mysql_real_escape_string($record['ITTotalStoneCost'])."','".mysql_real_escape_string($record['ITTotalMetalCost'])."','".mysql_real_escape_string($record['ITACost'])."','".mysql_real_escape_string($record['ITBCost'])."','".mysql_real_escape_string($record['ITCCost'])."','".mysql_real_escape_string($record['ITSRP'])."','".mysql_real_escape_string($record['ITUOM'])."','".mysql_real_escape_string($record['ITUOMRef'])."','".mysql_real_escape_string($record['ITMinStock'])."','".mysql_real_escape_string($record['ITMaxStock'])."','".mysql_real_escape_string($record['ITDateOfCreation'])."','".mysql_real_escape_string($record['ITRouting'])."','".mysql_real_escape_string($record['ITRemarks'])."','".mysql_real_escape_string($record['ITPicture1'])."','".mysql_real_escape_string($record['ITPicture2'])."','".mysql_real_escape_string($record['ITPicture1Type'])."','".mysql_real_escape_string($record['ITPicture2Type'])."','".mysql_real_escape_string($record['ITECNRemarks'])."','".mysql_real_escape_string($record['ITECNOriginator'])."','".mysql_real_escape_string($record['ITECNDate'])."','".mysql_real_escape_string($record['ITECNApprovedBy'])."','".mysql_real_escape_string($record['ITACostOverride'])."','".mysql_real_escape_string($record['ITBCostOverride'])."','".mysql_real_escape_string($record['ITCCostOverride'])."','".mysql_real_escape_string($record['ITLabourCostDrill'])."','".mysql_real_escape_string($record['ITAddCostDrill'])."','".mysql_real_escape_string($record['ITDefaultSupplier'])."','".mysql_real_escape_string($record['LastUpdate'])."','".mysql_real_escape_string($record['LastUpdatedBy'])."','".mysql_real_escape_string($record['Expired'])."','".mysql_real_escape_string($record['ITExpireReason'])."','".mysql_real_escape_string($record['ActionLog'])."','".mysql_real_escape_string($record['ITPriceRemark'])."','".mysql_real_escape_string($record['ITLUseInPOS'])."','".mysql_real_escape_string($record['isRecalSRP'])."','".mysql_real_escape_string($record['itCertDescription'])."','".mysql_real_escape_string($record['ITCertDescription2'])."','".mysql_real_escape_string($record['ITIsConsignmentItem'])."','".mysql_real_escape_string($record['ITMaxInvoiceDiscount'])."','".mysql_real_escape_string($record['ITDefaultSBU'])."','".mysql_real_escape_string($record['ICS_Field1'])."','".mysql_real_escape_string($record['ICS_Field2'])."','".mysql_real_escape_string($record['ICS_Field3'])."','".mysql_real_escape_string($record['ICS_Field4'])."','".mysql_real_escape_string($record['ICS_Field5'])."','".mysql_real_escape_string($record['ICS_Field6'])."','".mysql_real_escape_string($record['ICS_Field7'])."','".mysql_real_escape_string($record['ICS_Field8'])."','".mysql_real_escape_string($record['ICS_Field9'])."','".mysql_real_escape_string($record['ICS_Field10'])."','".mysql_real_escape_string($record['Puregold'])."')";
    $result = mysql_query($query2,$mysqllink2); $query2 = "INSERT INTO Item(ITPK,
                            ITMasterITPK,
                            ITType,
                            ITCode,
                            ITRefCode,
                            ITRevision,
                            ITVersion,
                            ITHasBOM,
                            ITHasLabour,
                            ITHasAdditional,
                            ITProdType,
                            ITDesignNo,
                            ITAlloy,
                            ITStoneType,
                            ITStoneCombine,
                            ITisMultiStone,
                            ITRunningNo,
                            ITShortDesc1,
                            ITShortDesc2,
                            ITLongDesc1,
                            ITLongDesc2,
                            ITBarCode,
                            ITLabourCost,
                            ITTotalAddCost,
                            ITTotalStoneCost,
                            ITTotalMetalCost,
                            ITACost,
                            ITBCost,
                            ITCCost,
                            ITSRP,
                            ITUOM,
                            ITUOMRef,
                            ITMinStock,
                            ITMaxStock,
                            ITDateOfCreation,
                            ITRouting,
                            ITRemarks,
                            ITPicture1,
                            ITPicture2,
                            ITPicture1Type,
                            ITPicture2Type,
                            ITECNRemarks,
                            ITECNOriginator,
                            ITECNDate,
                            ITECNApprovedBy,
                            ITACostOverride,
                            ITBCostOverride,
                            ITCCostOverride,
                            ITLabourCostDrill,
                            ITAddCostDrill,
                            ITDefaultSupplier,
                            LastUpdate,
                            LastUpdatedBy,
                            Expired,
                            ITExpireReason,
                            ActionLog,
                            ITPriceRemark,
                            ITLUseInPOS,
                            isRecalSRP,
                            itCertDescription,
                            ITCertDescription2,
                            ITIsConsignmentItem,
                            ITMaxInvoiceDiscount,
                            ITDefaultSBU,
                            ICS_Field1,
                            ICS_Field2,
                            ICS_Field3,
                            ICS_Field4,
                            ICS_Field5,
                            ICS_Field6,
                            ICS_Field7,
                            ICS_Field8,
                            ICS_Field9,
                            ICS_Field10,
                            Puregold) VALUES ";
    } $i++; }
    
    //echo $query2;
    //$result = mysql_query($query2,$mysqllink2);
    if ($result) echo "completed(item) "; else echo "error(item) ";
    //echo $num;
}
else
{
echo "Database Connect Failed.";
}

mssql_close($link);
mysql_close($mysqllink2);

?>