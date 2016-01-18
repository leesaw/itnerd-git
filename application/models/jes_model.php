<?php
Class Jes_model extends CI_Model
{
    function getActiveLicense()
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("SID, CONVERT(CHAR(19),LastUpdate) as LastUpdate");
        $db2->from('[JES_NGG].[dbo].[LicenseUsage]');
        $query = $db2->get();
        return $query->result();
    }
    
    function getUser($userid)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("Username, UserFullName");
        $db2->from("[JES_NGG].[dbo].[User]");
        $db2->where("Username",$userid);
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_allBrand()
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("IHWareHouse, WHDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->group_by("IHWareHouse,WHDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $db2->order_by("IHWareHouse");
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_whtype()
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WTCode as IHWareHouse, WTDesc1 as WHDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->join("WarehouseType","WTCode=wh2.WHType","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->group_by("WTCode,WTDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $db2->order_by("IHWareHouse");
        $query = $db2->get();
        return $query->result();
    }
    
    // List All Warehouse Type
    function getAllWHType()
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WTCode, WTDesc1");
        $db2->from("WarehouseType");
        $db2->like("WTRemarks", "#Watches");
        $db2->where("Expired",'F');
        $db2->order_by("WTRemarks desc,WTCode");
        $query = $db2->get();
        return $query->result();
    }
    
    // List All Warehouse from type
    function getAllWHName($whtype)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WHCode, WHDesc1");
        $db2->from("Warehouse");
        $db2->where("WHType", $whtype);
        $db2->where("Expired",'F');
        $query = $db2->get();
        return $query->result();
    }
    
    function getAllWareHouseName()
    {        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WHCode, WHDesc1, WHType");
        $db2->from("Warehouse wh");
        $db2->join("WarehouseType wt","wt.WTCode=wh.WHType","left");
        $db2->like("WTRemarks", "#Watches");
        $db2->where("wh.Expired",'F');
        $db2->order_by("WHDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
    function getOneWareHouseName($wh)
    {        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WHDesc1, WHType");
        $db2->from("Warehouse wh");
        $db2->where("WHCode", $wh);
        $db2->where("wh.Expired",'F');
        $query = $db2->get();
        return $query->result();
    }
    
    function getAllWareHouseName_whtype()
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WTCode, WTDesc1, WHDesc1");
        $db2->from("Warehouse wh");
        $db2->join("WarehouseType wt","wt.WTCode=wh.WHType","left");
        $db2->like("WTRemarks", "#Watches");
        $db2->where("wh.Expired",'F');
        $db2->order_by("WTRemarks desc,WTCode");
        $query = $db2->get();
        return $query->result();
    }
    
    // Number remark from Warehouse Type
    function getNumberWatch_warehouse($wh, $remark)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WTCode, WTDesc1, SUM(IHQtyCalSum) as sum1", FALSE);
        $db2->from("NumberWatchWH");
        $db2->where("WTCode", $wh);
        if ($remark != "") $db2->like("PTRemarks", $remark);
        $query = $db2->get();
        return $query->result();
    }
    
    // Number each branch from department store
    function getNumberWatch_departmentstore($wh, $remark)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("IHWareHouse,pt.PTRemarks, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->join("ProductType pt","PTCode=ori2.IFProdType","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->where("WHCode", $wh);
        if ($remark != "") $db2->like("pt.PTRemarks", $remark);
        $db2->group_by("IHWareHouse,pt.PTRemarks");
        //$db2->order_by("IHWareHouse");
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_producttype($pt)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PTCode, PTDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->join("ProductType","PTCode=IFProdType","left");
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->where("IHQtyCal >=",0);
        $db2->where("PTCode",$pt);
        $db2->group_by("PTCode, PTDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
    function getProductType_onlyWatch()
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PTCode, PTDesc1");
        $db2->from("ProductType");
        $db2->like("PTCode", 'W-', 'after');
        $db2->where("Expired",'F');
        $db2->order_by("PTDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
    function getOneProductType($pt)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PTDesc1");
        $db2->from("ProductType");
        $db2->where("PTCode", $pt);
        $db2->where("Expired",'F');
        $query = $db2->get();
        return $query->result();
    }
    
    function getProductType_onlyWatch_lf($brand)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PTCode, PTDesc1");
        $db2->from("ProductType");
        $db2->like("PTCode", 'W-', 'after');
        $db2->where("Expired",'F');
        $db2->like("PTRemarks",$brand);
        $db2->order_by("PTDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_branch_item($branch, $remark)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("IHItemCode as itemcode, IHBarcode, ori.ITRefCode as ITRefCode, ori.ITShortDesc1 as ITShortDesc1,ori.ITShortDesc2 as ITShortDesc2, ori.ITLongDesc1 as ITLongDesc1 , FLOOR(IHQtyCal) as IHQtyCal, ori.ITSRP", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("ItemMax ss","wh.IHItemCode=ss.ITCode","inner",FALSE);
        $db2->join("Item ori","ori.ITPK=ss.MITPK","left");
        $db2->join("ProductType","PTCode=ori2.IFProdType","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        if ($remark != "") $db2->like("PTRemarks", $remark);
        $db2->where("IHQtyCal >",0);
        $db2->where("IHWareHouse", $branch);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_product_item($pt)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("IHItemCode as itemcode, IHBarcode, ITRefCode, ITShortDesc1,ITShortDesc2 as ITShortDesc2, ITLongDesc1, FLOOR(IHQtyCal) as IHQtyCal, WHDesc1, WHCode, ITSRP", FALSE);
        $db2->from("ProductList");
        /*
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("ItemMax ss","wh.IHItemCode=ss.ITCode","inner",FALSE);
        $db2->join("Item ori","ori.ITPK=ss.MITPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        */
        $db2->where("IFProdType", $pt);
        /*
        $db2->where("IHQtyCal >",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        */
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_branch_item_producttype($branch, $remark)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PTCode, PTDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("ProductType","PTCode=ori2.IFProdType","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        if ($remark != "") $db2->like("PTRemarks", $remark);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->where("IHWareHouse", $branch);
        $db2->where("IHQtyCal >=",0);
        $db2->group_by("PTCode, PTDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_whtype_brand($whtype, $remark)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PTCode, PTDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("ProductType","PTCode=ori2.IFProdType","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        if ($remark != "") $db2->like("PTRemarks", $remark);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->where("IHQtyCal >=",0);
        $db2->where("WHType", $whtype);
        $db2->group_by("PTCode, PTDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_product_item_branch($pt)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WHCode, WHDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->where("ori2.IFProdType", $pt);
        $db2->where("IHQtyCal >=",0);
        $db2->group_by("WHCode, WHDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $query = $db2->get();
        return $query->result();
    }
    
    function getStoreName($wh)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WHDesc1, WHType");
        $db2->from("Warehouse");
        $db2->where("WHCode", $wh);
        $query = $db2->get();
        return $query->result();
    }
    
    function getWarehouseTypeName($wh)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WTDesc1");
        $db2->from("WarehouseType");
        $db2->where("WTCode", $wh);
        $query = $db2->get();
        return $query->result();
    }

    function getWarehouse_branch($wh)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WHCode, WHDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->join("ProductType pt","PTCode=ori2.IFProdType","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->where("WHType", $wh);
        $db2->group_by("WHCode,WHDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $query = $db2->get();
        return $query->result();
    }
    
    function getWarehouse_product($pt)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("WHCode, WHDesc1, FLOOR(SUM(IHQtyCal)) as sum1", FALSE);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->join("ProductType pt","PTCode=ori2.IFProdType","left");
        //$db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        $db2->where("ori2.IFProdType", $pt);
        $db2->group_by("WHCode,WHDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $query = $db2->get();
        return $query->result();
    }
    
    function getProductName($pt)
    {
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PTDesc1");
        $db2->from("ProductType");
        $db2->where("PTCode", $pt);
        $query = $db2->get();
        return $query->result();
    }
    
    function reportStock_store_product($whcode, $producttype)
    {
        $sql = "";
        for ($i=0; $i<count($producttype); $i++) {
            if ($i>0) $sql .= ",";
            $sql .= "SUM(CASE WHEN PTCode = '".$producttype[$i]."' THEN FLOOR(IHQtyCal) ELSE 0 END) as num".$i;
        }
        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select($sql);
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->join("ProductType pt","PTCode=ori2.IFProdType","left");
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->where("WHCode", $whcode);
        $db2->where("wh2.Expired",'F');
        $query = $db2->get();
        return $query->result();
    }
    
    function reportStock_itemlist_store_product($warehouse, $producttype)
    {
        $sql = "";
        for ($i=0; $i<count($producttype); $i++) {
            if ($i==0) { $sql .= "(IFProdType='".$producttype[$i]."'"; }
            $sql .= " OR IFProdType = '".$producttype[$i]."'";
        }
        if (count($producttype)>0) $sql .=")";
        else $sql .= "(IFProdType='qwerty')";
        
        $count =0;
        for ($i=0; $i<count($warehouse); $i++) {
            for ($j=0; $j<count($warehouse[$i]); $j++) {
                if ($warehouse[$i][$j] !="") {
                    if ($count==0) {
                        $sql .= " AND (WHCode='".$warehouse[$i][$j]."'";
                        $count++;
                    }
                    $sql .= " OR WHCode='".$warehouse[$i][$j]."'";
                }
            }
        }
        if ($count>0) $sql .=")";
        else $sql .= " AND (WHCode='qwerty')";

        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("IHItemCode as itemcode, IHBarcode, ITRefCode, ITShortDesc1, ITShortDesc2, ITLongDesc1, FLOOR(IHQtyCal) as IHQtyCal, WHDesc1, WHCode, ITSRP", FALSE);
        $db2->from("ProductList");
        /*
        $db2->from("ItemWHBal as wh");
        $db2->join("ItemFinGoodsMax as tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("ItemFinGoods ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("ItemMax ss","wh.IHItemCode=ss.ITCode","inner",FALSE);
        $db2->join("Item ori","ori.ITPK=ss.MITPK","left");
        $db2->join("Warehouse wh2","WHCode=wh.IHWareHouse","left");
        $db2->where("IHQtyCal >",0);
        $db2->where("wh.Expired",'F');
        $db2->where("wh2.Expired",'F');
        */
        if (($sql !="))") && ($sql !=")") && ($sql !="")) $db2->where($sql);
        else $db2->where();
        $query = $db2->get();
        return $query->result();
    }
    
    function getRefcode($refcode)
    {
        $keyword = explode(" ",$refcode);
        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("IHItemCode as itemcode, IHBarcode, ITRefCode, ITShortDesc1,ITShortDesc2 as ITShortDesc2, ITLongDesc1, FLOOR(IHQtyCal) as IHQtyCal, WHDesc1, WHCode, ITSRP", FALSE);
        $db2->from("ProductList");
        if (count($keyword) < 2) { 
            $db2->like("ITLongDesc1", $refcode);
            $db2->or_like("ITRefCode", $refcode); 
        }else{
            for($i=0; $i<count($keyword); $i++) {
                $db2->like("ITLongDesc1", $keyword[$i]);
            }
        }
        $query = $db2->get();
        return $query->result();
    }
}
?>