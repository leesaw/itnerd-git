<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Scriptjes extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		echo ceil(24000/10000);
		//$this->load->view('welcome_message');
	}

	public function warehouse()
	{
		$db2 = $this->load->database('db2',TRUE);
		$db2->select("WHCode,WHOldCode,WHDesc1,WHDesc2,WHType,WHSBU,WHLocation,WHVarianceRpt,LastUpdate,LastUpdatedBy,Expired,ActionLog,WHAccessibleToAllFrom,WHAccessibleToAllTo,WHAccessibleToAllView");
		$db2->from("[JES_NGG].[dbo].[Warehouse]");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
		$result = $query->result();
		
		$db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('Warehouse'); 
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
		$i = 1;
		foreach($result as $loop) {
			$query2 .= "('".mysql_real_escape_string($loop->WHCode).
        "','".mysql_real_escape_string($loop->WHOldCode).
        "','".mysql_real_escape_string($loop->WHDesc1).
        "','".mysql_real_escape_string($loop->WHDesc2).
        "','".mysql_real_escape_string($loop->WHType).
        "','".mysql_real_escape_string($loop->WHSBU).
        "','".mysql_real_escape_string($loop->WHLocation).
        "','".mysql_real_escape_string($loop->WHVarianceRpt).
        "','".mysql_real_escape_string($loop->LastUpdate).
        "','".mysql_real_escape_string($loop->LastUpdatedBy).
        "','".mysql_real_escape_string($loop->Expired).
        "','".mysql_real_escape_string($loop->ActionLog).
        "','".mysql_real_escape_string($loop->WHAccessibleToAllFrom).
        "','".mysql_real_escape_string($loop->WHAccessibleToAllTo).
        "','".mysql_real_escape_string($loop->WHAccessibleToAllView);
			if ($i!=$numrows) {
				$query2 .= "'),";
			}else{
				$query2 .= "')";
			}
			$i++;
		}
		//echo $query2;
		$message = $db1->query($query2);
        
        if ($message) echo "completed(warehouse) "; else echo "error(warehouse) ";
	}
    
    public function item()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('Item'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("ITPK");
		$db2->from("[JES_NGG].[dbo].[Item]");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("ITPK,
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
                            Puregold");
		    $db2->from("[JES_NGG].[dbo].[Item]");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("ITPK");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO Item(ITPK,
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
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->ITPK).
                "','".mysql_real_escape_string($loop->ITMasterITPK).
                "','".mysql_real_escape_string($loop->ITType).
                "','".mysql_real_escape_string($loop->ITCode).
                "','".mysql_real_escape_string($loop->ITRefCode).
                "','".mysql_real_escape_string($loop->ITRevision).
                "','".mysql_real_escape_string($loop->ITVersion).
                "','".mysql_real_escape_string($loop->ITHasBOM).
                "','".mysql_real_escape_string($loop->ITHasLabour).
                "','".mysql_real_escape_string($loop->ITHasAdditional).
                "','".mysql_real_escape_string($loop->ITProdType).
                "','".mysql_real_escape_string($loop->ITDesignNo).
                "','".mysql_real_escape_string($loop->ITAlloy).
                "','".mysql_real_escape_string($loop->ITStoneType).
                "','".mysql_real_escape_string($loop->ITStoneCombine).
                "','".mysql_real_escape_string($loop->ITisMultiStone).
                "','".mysql_real_escape_string($loop->ITRunningNo).
                "','".mysql_real_escape_string($loop->ITShortDesc1).
                "','".mysql_real_escape_string($loop->ITShortDesc2).
                "','".mysql_real_escape_string($loop->ITLongDesc1).
                "','".mysql_real_escape_string($loop->ITLongDesc2).
                "','".mysql_real_escape_string($loop->ITBarCode).
                "','".mysql_real_escape_string($loop->ITLabourCost).
                "','".mysql_real_escape_string($loop->ITTotalAddCost).
                "','".mysql_real_escape_string($loop->ITTotalStoneCost).
                "','".mysql_real_escape_string($loop->ITTotalMetalCost).
                "','".mysql_real_escape_string($loop->ITACost).
                "','".mysql_real_escape_string($loop->ITBCost).
                "','".mysql_real_escape_string($loop->ITCCost).
                "','".mysql_real_escape_string($loop->ITSRP).
                "','".mysql_real_escape_string($loop->ITUOM).
                "','".mysql_real_escape_string($loop->ITUOMRef).
                "','".mysql_real_escape_string($loop->ITMinStock).
                "','".mysql_real_escape_string($loop->ITMaxStock).
                "','".mysql_real_escape_string($loop->ITDateOfCreation).
                "','".mysql_real_escape_string($loop->ITRouting).
                "','".mysql_real_escape_string($loop->ITRemarks).
                "','".mysql_real_escape_string($loop->ITPicture1).
                "','".mysql_real_escape_string($loop->ITPicture2).
                "','".mysql_real_escape_string($loop->ITPicture1Type).
                "','".mysql_real_escape_string($loop->ITPicture2Type).
                "','".mysql_real_escape_string($loop->ITECNRemarks).
                "','".mysql_real_escape_string($loop->ITECNOriginator).
                "','".mysql_real_escape_string($loop->ITECNDate).
                "','".mysql_real_escape_string($loop->ITECNApprovedBy).
                "','".mysql_real_escape_string($loop->ITACostOverride).
                "','".mysql_real_escape_string($loop->ITBCostOverride).
                "','".mysql_real_escape_string($loop->ITCCostOverride).
                "','".mysql_real_escape_string($loop->ITLabourCostDrill).
                "','".mysql_real_escape_string($loop->ITAddCostDrill).
                "','".mysql_real_escape_string($loop->ITDefaultSupplier).
                "','".mysql_real_escape_string($loop->LastUpdate).
                "','".mysql_real_escape_string($loop->LastUpdatedBy).
                "','".mysql_real_escape_string($loop->Expired).
                "','".mysql_real_escape_string($loop->ITExpireReason).
                "','".mysql_real_escape_string($loop->ActionLog).
                "','".mysql_real_escape_string($loop->ITPriceRemark).
                "','".mysql_real_escape_string($loop->ITLUseInPOS).
                "','".mysql_real_escape_string($loop->isRecalSRP).
                "','".mysql_real_escape_string($loop->itCertDescription).
                "','".mysql_real_escape_string($loop->ITCertDescription2).
                "','".mysql_real_escape_string($loop->ITIsConsignmentItem).
                "','".mysql_real_escape_string($loop->ITMaxInvoiceDiscount).
                "','".mysql_real_escape_string($loop->ITDefaultSBU).
                "','".mysql_real_escape_string($loop->ICS_Field1).
                "','".mysql_real_escape_string($loop->ICS_Field2).
                "','".mysql_real_escape_string($loop->ICS_Field3).
                "','".mysql_real_escape_string($loop->ICS_Field4).
                "','".mysql_real_escape_string($loop->ICS_Field5).
                "','".mysql_real_escape_string($loop->ICS_Field6).
                "','".mysql_real_escape_string($loop->ICS_Field7).
                "','".mysql_real_escape_string($loop->ICS_Field8).
                "','".mysql_real_escape_string($loop->ICS_Field9).
                "','".mysql_real_escape_string($loop->ICS_Field10).
                "','".mysql_real_escape_string($loop->Puregold);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        
        if ($message) echo "completed(item) "; else echo "error(item) ";
	}
    
    public function itemfingoods()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('ItemFinGoods'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("IFPK");
		$db2->from("[JES_NGG].[dbo].[ItemFinGoods]");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("IFPK
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
                            ,IFStoneClarity");
		    $db2->from("[JES_NGG].[dbo].[ItemFinGoods]");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("IFPK");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO ItemFinGoods(IFPK
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
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->IFPK).
                "','".mysql_real_escape_string($loop->IFITPK).
                "','".mysql_real_escape_string($loop->IFItemCode).
                "','".mysql_real_escape_string($loop->IFRevision).
                "','".mysql_real_escape_string($loop->IFProdType).
                "','".mysql_real_escape_string($loop->IFDesignNo).
                "','".mysql_real_escape_string($loop->IFRunningNo).
                "','".mysql_real_escape_string($loop->IFAlloy).
                "','".mysql_real_escape_string($loop->IFStoneType).
                "','".mysql_real_escape_string($loop->IFStoneCombination).
                "','".mysql_real_escape_string($loop->IFIsMultiStone).
                "','".mysql_real_escape_string($loop->LastUpdate).
                "','".mysql_real_escape_string($loop->LastUpdatedBy).
                "','".mysql_real_escape_string($loop->ActionLog).
                "','".mysql_real_escape_string($loop->IFPOSGoldProduct).
                "','".mysql_real_escape_string($loop->IFSize).
                "','".mysql_real_escape_string($loop->IFLastDepreciationDate).
                "','".mysql_real_escape_string($loop->IFStoneClarity);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        if ($message) echo "completed(itemfingoods) "; else echo "error(itemfingoods) ";
	}
    
    public function itemwhbal()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('ItemWHBal'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("IHPK");
		$db2->from("[JES_NGG].[dbo].[ItemWHBal]");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("IHPK
                                ,IHWareHouse
                                ,IHBarcode
                                ,IHItemType
                                ,IHItemCode
                                ,IHQtyCal
                                ,IHQtyRef
                                ,LastUpdate
                                ,LastUpdatedBy
                                ,Expired
                                ,ActionLog");
		    $db2->from("[JES_NGG].[dbo].[ItemWHBal]");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("IHPK");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO ItemWHBal(IHPK
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
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->IHPK).
                "','".mysql_real_escape_string($loop->IHWareHouse).
                "','".mysql_real_escape_string($loop->IHBarcode).
                "','".mysql_real_escape_string($loop->IHItemType).
                "','".mysql_real_escape_string($loop->IHItemCode).
                "','".mysql_real_escape_string($loop->IHQtyCal).
                "','".mysql_real_escape_string($loop->IHQtyRef).
                "','".mysql_real_escape_string($loop->LastUpdate).
                "','".mysql_real_escape_string($loop->LastUpdatedBy).
                "','".mysql_real_escape_string($loop->Expired).
                "','".mysql_real_escape_string($loop->ActionLog);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        
        if ($message) echo "completed(itemwhbal) "; else echo "error(itemwhbal) ";
	}
    
    public function producttype()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('ProductType'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("PTCode");
		$db2->from("[JES_NGG].[dbo].[ProductType]");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("PTCode
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
                                  ,IncAmt");
		    $db2->from("[JES_NGG].[dbo].[ProductType]");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("PTCode");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO ProductType(PTCode
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
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->PTCode).
                "','".mysql_real_escape_string($loop->PTDesc1).
                "','".mysql_real_escape_string($loop->PTDesc2).
                "','".mysql_real_escape_string($loop->PTUOM).
                "','".mysql_real_escape_string($loop->PTUOMRef).
                "','".mysql_real_escape_string($loop->PTRemarks).
                "','".mysql_real_escape_string($loop->LastUpdate).
                "','".mysql_real_escape_string($loop->LastUpdatedBy).
                "','".mysql_real_escape_string($loop->Expired).
                "','".mysql_real_escape_string($loop->ActionLog).
                "','".mysql_real_escape_string($loop->PTPersonal).
                "','".mysql_real_escape_string($loop->PTGroup).
                "','".mysql_real_escape_string($loop->PTSpecial).
                "','".mysql_real_escape_string($loop->PTClub).
                "','".mysql_real_escape_string($loop->IncAmt);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }

        if ($message) echo "completed(producttype) "; else echo "error(producttype) ";
	}
    
    public function warehousetype()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('WarehouseType'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("WTCode");
		$db2->from("[JES_NGG].[dbo].[WarehouseType]");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("WTCode
                                    ,WTDesc1
                                    ,WTDesc2
                                    ,WTRemarks
                                    ,LastUpdate
                                    ,LastUpdatedBy
                                    ,ActionLog
                                    ,Expired");
		    $db2->from("[JES_NGG].[dbo].[WarehouseType]");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("WTCode");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO WarehouseType(WTCode
                                    ,WTDesc1
                                    ,WTDesc2
                                    ,WTRemarks
                                    ,LastUpdate
                                    ,LastUpdatedBy
                                    ,ActionLog
                                    ,Expired) VALUES ";
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->WTCode).
                "','".mysql_real_escape_string($loop->WTDesc1).
                "','".mysql_real_escape_string($loop->WTDesc2).
                "','".mysql_real_escape_string($loop->WTRemarks).
                "','".mysql_real_escape_string($loop->LastUpdate).
                "','".mysql_real_escape_string($loop->LastUpdatedBy).
                "','".mysql_real_escape_string($loop->ActionLog).
                "','".mysql_real_escape_string($loop->Expired);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        if ($message) echo "completed(warehousetype) "; else echo "error(warehousetype) ";
	}
    
    public function itemfingoodsmax()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('ItemFinGoodsMax'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("IFItemCode, MAX(IFPK) as MIFPK", FALSE);
		$db2->from("[JES_NGG].[dbo].[ItemFinGoods]");
        $db2->group_by("IFItemCode");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("IFItemCode, MAX(IFPK) as MIFPK", FALSE);
		    $db2->from("[JES_NGG].[dbo].[ItemFinGoods]");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->group_by("IFItemCode");
            $db2->order_by("IFItemCode");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO ItemFinGoodsMax(IFItemCode,MIFPK) VALUES ";
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->IFItemCode).
                "','".mysql_real_escape_string($loop->MIFPK);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        if ($message) echo "completed(itemfingoodsmax) "; else echo "error(itemfingoodsmax) ";
	}
    
    public function itemmax()
	{
        //select MAX(ITPK) as MITPK, ITCode from Item group by ITCode
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('ItemMax'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("MAX(ITPK) as MITPK, ITCode", FALSE);
		$db2->from("[JES_NGG].[dbo].[Item]");
        $db2->group_by("ITCode");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("MAX(ITPK) as MITPK, ITCode", FALSE);
		    $db2->from("[JES_NGG].[dbo].[Item]");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->group_by("ITCode");
            $db2->order_by("ITCode");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO ItemMax(MITPK,ITCode) VALUES ";
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->MITPK).
                "','".mysql_real_escape_string($loop->ITCode);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        if ($message) echo "completed(itemmax) "; else echo "error(itemmax) ";
	}
    
    public function itemmax_old()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('ItemMax'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("MAX(ITPK), ITCode");
		$db2->from("[JES_NGG].[dbo].[Item]");
        $db2->group_by("ITCode");
		$query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("ITPK,
                            ITMasterITPK,
                            ITType,
                            ori.ITCode,
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
                            Puregold");
		    $db2->from("[JES_NGG].[dbo].[Item] ori");
            $db2->join("(select MAX(ITPK) as MITPK, ITCode from Item group by ITCode) ss","ori.ITPK=ss.MITPK","inner",FALSE);
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("ITPK");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO ItemMax(MITPK,
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
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->ITPK).
                "','".mysql_real_escape_string($loop->ITMasterITPK).
                "','".mysql_real_escape_string($loop->ITType).
                "','".mysql_real_escape_string($loop->ITCode).
                "','".mysql_real_escape_string($loop->ITRefCode).
                "','".mysql_real_escape_string($loop->ITRevision).
                "','".mysql_real_escape_string($loop->ITVersion).
                "','".mysql_real_escape_string($loop->ITHasBOM).
                "','".mysql_real_escape_string($loop->ITHasLabour).
                "','".mysql_real_escape_string($loop->ITHasAdditional).
                "','".mysql_real_escape_string($loop->ITProdType).
                "','".mysql_real_escape_string($loop->ITDesignNo).
                "','".mysql_real_escape_string($loop->ITAlloy).
                "','".mysql_real_escape_string($loop->ITStoneType).
                "','".mysql_real_escape_string($loop->ITStoneCombine).
                "','".mysql_real_escape_string($loop->ITisMultiStone).
                "','".mysql_real_escape_string($loop->ITRunningNo).
                "','".mysql_real_escape_string($loop->ITShortDesc1).
                "','".mysql_real_escape_string($loop->ITShortDesc2).
                "','".mysql_real_escape_string($loop->ITLongDesc1).
                "','".mysql_real_escape_string($loop->ITLongDesc2).
                "','".mysql_real_escape_string($loop->ITBarCode).
                "','".mysql_real_escape_string($loop->ITLabourCost).
                "','".mysql_real_escape_string($loop->ITTotalAddCost).
                "','".mysql_real_escape_string($loop->ITTotalStoneCost).
                "','".mysql_real_escape_string($loop->ITTotalMetalCost).
                "','".mysql_real_escape_string($loop->ITACost).
                "','".mysql_real_escape_string($loop->ITBCost).
                "','".mysql_real_escape_string($loop->ITCCost).
                "','".mysql_real_escape_string($loop->ITSRP).
                "','".mysql_real_escape_string($loop->ITUOM).
                "','".mysql_real_escape_string($loop->ITUOMRef).
                "','".mysql_real_escape_string($loop->ITMinStock).
                "','".mysql_real_escape_string($loop->ITMaxStock).
                "','".mysql_real_escape_string($loop->ITDateOfCreation).
                "','".mysql_real_escape_string($loop->ITRouting).
                "','".mysql_real_escape_string($loop->ITRemarks).
                "','".mysql_real_escape_string($loop->ITPicture1).
                "','".mysql_real_escape_string($loop->ITPicture2).
                "','".mysql_real_escape_string($loop->ITPicture1Type).
                "','".mysql_real_escape_string($loop->ITPicture2Type).
                "','".mysql_real_escape_string($loop->ITECNRemarks).
                "','".mysql_real_escape_string($loop->ITECNOriginator).
                "','".mysql_real_escape_string($loop->ITECNDate).
                "','".mysql_real_escape_string($loop->ITECNApprovedBy).
                "','".mysql_real_escape_string($loop->ITACostOverride).
                "','".mysql_real_escape_string($loop->ITBCostOverride).
                "','".mysql_real_escape_string($loop->ITCCostOverride).
                "','".mysql_real_escape_string($loop->ITLabourCostDrill).
                "','".mysql_real_escape_string($loop->ITAddCostDrill).
                "','".mysql_real_escape_string($loop->ITDefaultSupplier).
                "','".mysql_real_escape_string($loop->LastUpdate).
                "','".mysql_real_escape_string($loop->LastUpdatedBy).
                "','".mysql_real_escape_string($loop->Expired).
                "','".mysql_real_escape_string($loop->ITExpireReason).
                "','".mysql_real_escape_string($loop->ActionLog).
                "','".mysql_real_escape_string($loop->ITPriceRemark).
                "','".mysql_real_escape_string($loop->ITLUseInPOS).
                "','".mysql_real_escape_string($loop->isRecalSRP).
                "','".mysql_real_escape_string($loop->itCertDescription).
                "','".mysql_real_escape_string($loop->ITCertDescription2).
                "','".mysql_real_escape_string($loop->ITIsConsignmentItem).
                "','".mysql_real_escape_string($loop->ITMaxInvoiceDiscount).
                "','".mysql_real_escape_string($loop->ITDefaultSBU).
                "','".mysql_real_escape_string($loop->ICS_Field1).
                "','".mysql_real_escape_string($loop->ICS_Field2).
                "','".mysql_real_escape_string($loop->ICS_Field3).
                "','".mysql_real_escape_string($loop->ICS_Field4).
                "','".mysql_real_escape_string($loop->ICS_Field5).
                "','".mysql_real_escape_string($loop->ICS_Field6).
                "','".mysql_real_escape_string($loop->ICS_Field7).
                "','".mysql_real_escape_string($loop->ICS_Field8).
                "','".mysql_real_escape_string($loop->ICS_Field9).
                "','".mysql_real_escape_string($loop->ICS_Field10).
                "','".mysql_real_escape_string($loop->Puregold);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }

	}
    
    public function productlist()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('ProductList'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("IHItemCode, IHBarcode, ori.ITRefCode as ITRefCode, ori.ITShortDesc1 as ITShortDesc1,ori.ITShortDesc2 as ITShortDesc2, ori.ITLongDesc1 as ITLongDesc1, IHQtyCal, WHDesc1, WHCode, ITSRP, IFProdType");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("(select MAX(ITPK) as MITPK, ITCode from [JES_NGG].[dbo].[Item] group by ITCode) ss","wh.IHItemCode=ss.ITCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[Item] ori","ori.ITPK=ss.MITPK","left");
        $db2->join("[JES_NGG].[dbo].[Warehouse] wh2","WHCode=wh.IHWareHouse","left");
        $db2->where("IHQtyCal >",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        
        $query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("IHItemCode, IHBarcode, ori.ITRefCode as ITRefCode, ori.ITShortDesc1 as ITShortDesc1,ori.ITShortDesc2 as ITShortDesc2, ori.ITLongDesc1 as ITLongDesc1, IHQtyCal, WHDesc1, WHCode, ITSRP, IFProdType");
            $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
            $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
            $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
            $db2->join("(select MAX(ITPK) as MITPK, ITCode from [JES_NGG].[dbo].[Item] group by ITCode) ss","wh.IHItemCode=ss.ITCode","inner",FALSE);
            $db2->join("[JES_NGG].[dbo].[Item] ori","ori.ITPK=ss.MITPK","left");
            $db2->join("[JES_NGG].[dbo].[Warehouse] wh2","WHCode=wh.IHWareHouse","left");
            $db2->where("IHQtyCal >",0);
            $db2->where("wh.Expired",'F');
            $db2->where("wh2.Expired",'F');
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("IHItemCode");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO ProductList(IHItemCode, 
                                            IHBarcode, 
                                            ITRefCode,
                                            ITShortDesc1,
                                            ITShortDesc2,
                                            ITLongDesc1,
                                            IHQtyCal,
                                            WHDesc1,
                                            WHCode,
                                            ITSRP,
                                            IFProdType) VALUES ";
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->IHItemCode).
                "','".mysql_real_escape_string($loop->IHBarcode).
                "','".mysql_real_escape_string($loop->ITRefCode).
                "','".mysql_real_escape_string($loop->ITShortDesc1).
                "','".mysql_real_escape_string($loop->ITShortDesc2).
                "','".mysql_real_escape_string($loop->ITLongDesc1).
                "','".mysql_real_escape_string($loop->IHQtyCal).
                "','".mysql_real_escape_string($loop->WHDesc1).
                "','".mysql_real_escape_string($loop->WHCode).
                "','".mysql_real_escape_string($loop->ITSRP).
                "','".mysql_real_escape_string($loop->IFProdType);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        if ($message) echo "completed(productlist) "; else echo "error(productlist) ";
	}
    
    public function numberwatch_warehouse()
	{
        
        $db1 = $this->load->database('db3',TRUE);
		$db1->empty_table('NumberWatchWH'); 
        
		$db2 = $this->load->database('db2',TRUE);
        
		$db2->select("WTCode, WTDesc1, PTRemarks, SUM(IHQtyCal) as sum1");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("[JES_NGG].[dbo].[Warehouse] wh2","WHCode=wh.IHWareHouse","left");
        $db2->join("[JES_NGG].[dbo].[WarehouseType]","WTCode=wh2.WHType","left");
        $db2->join("[JES_NGG].[dbo].[ProductType] pt","PTCode=ori2.IFProdType","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->group_by("WTCode,WTDesc1,PTRemarks");
        
        $query = $db2->get();
		$numrows = $query->num_rows(); 
        $startlimit = 0;
        $end = ceil($numrows / 1000);
        $count = 1;
        while ($count <= $end) {
            $db2->select("WTCode, WTDesc1, PTRemarks, SUM(IHQtyCal) as sum1");
            $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
            $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
            $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
            $db2->join("[JES_NGG].[dbo].[Warehouse] wh2","WHCode=wh.IHWareHouse","left");
            $db2->join("[JES_NGG].[dbo].[WarehouseType]","WTCode=wh2.WHType","left");
            $db2->join("[JES_NGG].[dbo].[ProductType] pt","PTCode=ori2.IFProdType","left");
            $db2->like("ori2.IFProdType", 'W-', 'after');
            $db2->where("IHQtyCal >=",0);
            $db2->where("wh.Expired",'F');
            $db2->where("wh2.Expired",'F');
            $db2->group_by("WTCode,WTDesc1,PTRemarks");
            
            $endlimit = $count * 1000;
            //echo $startlimit." / ".$endlimit."+";
            $db2->order_by("WTCode");
            $db2->limit($startlimit, $endlimit);
		    $query = $db2->get();
            $numrows = $query->num_rows();
            $result = $query->result();
            //if ($result) echo "yes"; else echo "no";
            $i = 1;
            $sql2 = "INSERT INTO NumberWatchWH(WTCode, 
                                            WTDesc1, 
                                            PTRemarks,
                                            IHQtyCalSum) VALUES ";
            $query2 = $sql2;
            
            foreach($result as $loop) {
                $query2 .= "('".mysql_real_escape_string($loop->WTCode).
                "','".mysql_real_escape_string($loop->WTDesc1).
                "','".mysql_real_escape_string($loop->PTRemarks).
                "','".mysql_real_escape_string($loop->sum1);
                if ($i!=$numrows) {
                    $query2 .= "'),";
                }else{
                    $query2 .= "')";
                    //$db1->query($query2);
                    //$query2 = $sql2;
                }
                $i++;
            }
            //echo $query2;
            $message = $db1->query($query2);
            $count++;
            $startlimit = $endlimit + 1;
            //echo $endlimit;
            
        }
        if ($message) echo "completed(NumberWatchWH) "; else echo "error(NumberWatchWH) ";
	}
}