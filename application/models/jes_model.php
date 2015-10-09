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
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("IHWareHouse, WHDesc1, SUM(IHQtyCal) as sum1");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("[JES_NGG].[dbo].[Warehouse]","WHCode=wh.IHWareHouse","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >=",0);
        $db2->where("wh.Expired",'F');
        $db2->group_by("IHWareHouse,WHDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $db2->order_by("IHWareHouse");
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_producttype($pt)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("PTCode, PTDesc1, SUM(IHQtyCal) as sum1");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("[JES_NGG].[dbo].[ProductType]","PTCode=IFProdType","left");
        $db2->where("wh.Expired",'F');
        $db2->where("IHQtyCal >=",0);
        $db2->where("PTCode",$pt);
        $db2->group_by("PTCode, PTDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
    function getProductType_onlyWatch()
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("PTCode, PTDesc1");
        $db2->from("[JES_NGG].[dbo].[ProductType]");
        $db2->like("PTCode", 'W-', 'after');
        $db2->where("Expired",'F');
        $db2->order_by("PTDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_branch_item($branch)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("IHItemCode as itemcode, IHBarcode, ori.ITRefCode as ITRefCode, ori.ITShortDesc1 as ITShortDesc1,ori.ITShortDesc2 as ITShortDesc2, ori.ITLongDesc1 as ITLongDesc1 , IHQtyCal");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("(select MAX(ITPK) as MITPK, ITCode from [JES_NGG].[dbo].[Item] group by ITCode) ss","wh.IHItemCode=ss.ITCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[Item] ori","ori.ITPK=ss.MITPK","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("IHQtyCal >",0);
        $db2->where("IHWareHouse", $branch);
        $db2->where("wh.Expired",'F');
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_product_item($pt)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("IHItemCode as itemcode, IHBarcode, ori.ITRefCode as ITRefCode, ori.ITShortDesc1 as ITShortDesc1,ori.ITShortDesc2 as ITShortDesc2, ori.ITLongDesc1 as ITLongDesc1, IHQtyCal, WHDesc1, WHCode");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("(select MAX(ITPK) as MITPK, ITCode from [JES_NGG].[dbo].[Item] group by ITCode) ss","wh.IHItemCode=ss.ITCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[Item] ori","ori.ITPK=ss.MITPK","left");
        $db2->join("[JES_NGG].[dbo].[Warehouse]","WHCode=wh.IHWareHouse","left");
        $db2->where("ori2.IFProdType", $pt);
        $db2->where("IHQtyCal >",0);
        $db2->where("wh.Expired",'F');
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_branch_item_producttype($branch)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("PTCode, PTDesc1, SUM(IHQtyCal) as sum1");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("[JES_NGG].[dbo].[ProductType]","PTCode=ori2.IFProdType","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("wh.Expired",'F');
        $db2->where("IHWareHouse", $branch);
        $db2->where("IHQtyCal >=",0);
        $db2->group_by("PTCode, PTDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $query = $db2->get();
        return $query->result();
    }
    
    function getInventoryWatch_product_item_branch($pt)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("WHCode, WHDesc1, SUM(IHQtyCal) as sum1");
        $db2->from("[JES_NGG].[dbo].[ItemWHBal] as wh");
        $db2->join("(select IFItemCode, MAX(IFPK) as MIFPK from [JES_NGG].[dbo].[ItemFinGoods] group by IFItemCode) tt","wh.IHItemCode=tt.IFItemCode","inner",FALSE);
        $db2->join("[JES_NGG].[dbo].[ItemFinGoods] ori2","ori2.IFPK=tt.MIFPK","left");
        $db2->join("[JES_NGG].[dbo].[Warehouse]","WHCode=wh.IHWareHouse","left");
        $db2->like("ori2.IFProdType", 'W-', 'after');
        $db2->where("wh.Expired",'F');
        $db2->where("ori2.IFProdType", $pt);
        $db2->where("IHQtyCal >=",0);
        $db2->group_by("WHCode, WHDesc1");
        $db2->having("SUM(IHQtyCal) >",0);
        $query = $db2->get();
        return $query->result();
    }
    
    function getStoreName($wh)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("WHDesc1");
        $db2->from("[JES_NGG].[dbo].[Warehouse]");
        $db2->where("WHCode", $wh);
        $query = $db2->get();
        return $query->result();
    }
    
    function getProductName($pt)
    {
        $db2 = $this->load->database('db2',TRUE);
        $db2->select("PTDesc1");
        $db2->from("[JES_NGG].[dbo].[ProductType]");
        $db2->where("PTCode", $pt);
        $query = $db2->get();
        return $query->result();
    }
}
?>