<?php
Class Jes_salereport_model extends CI_Model
{
    // List All Shop Type
    function getShop_branch()
    {
        $db2 = $this->load->database('db3',TRUE);
        
        $db2->select("SHCode, SHDesc1", FALSE);
        $db2->from("Shop");
        $db2->join("(select PIShop from POSInvoice group by PIShop) tt","tt.PIShop=SHCode","inner",FALSE);
        $db2->order_by("SHDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
    function getSale_watch_lf_between($remark,$start,$end)
    {
        $start = $start. " 00:00:00";
        $end = $end." 23:59:59";
        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("PDProdType, PTDesc1, SUM(PDAmount) as sum1");
        $db2->from("POSInvoiceDetail");
        $db2->join("POSInvoice","PINO = PDPINo","left");
        $db2->join("ProductType","PTCode = PDProdType","left");
        $db2->like("PDProdType", 'W-', 'after');
        $db2->where("POSInvoice.Expired",'F');
        $db2->where("PIStatus",'N');
        $db2->where("PIIssueDate >=", $start);
        $db2->where("PIIssueDate <=", $end);
        $db2->like("PTRemarks",$remark);
        $db2->group_by("PDProdType");
        $query = $db2->get();
        return $query->result();
    }
    
    function getSale_watch_warehouse_between($wh,$remark,$start,$end)
    {
        $start = $start. " 00:00:00";
        $end = $end." 23:59:59";
        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("SHCode, SHDesc1, SUM(PDAmount) as sum1");
        $db2->from("POSInvoiceDetail");
        $db2->join("POSInvoice","PINO = PDPINo","left");
        $db2->join("ProductType","PTCode = PDProdType","left");
        $db2->join("Shop","PIShop = SHCode","left");
        $db2->join("Warehouse","SHFGWH=WHCode","left");
        $db2->like("PDProdType", 'W-', 'after');
        $db2->where("POSInvoice.Expired",'F');
        $db2->where("PIStatus",'N');
        $db2->where("PIIssueDate >=", $start);
        $db2->where("PIIssueDate <=", $end);
        $db2->where("WHType", $wh);
        $db2->like("PTRemarks",$remark);
        $db2->group_by("SHCode");
        $query = $db2->get();
        return $query->result();
    }
    
    function getSaleReport_brand($brand,$start,$end)
    {
        $start = $start. " 00:00:00";
        $end = $end." 23:59:59";
        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("date_format(PIIssueDate,'%d/%m/%Y') as PIIssueDate,date_format(PIIssueDate,'%Y/%m/%d') as date_sort, PDItemCode, PTDesc1, ITRefCode,ITShortDesc1,ITShortDesc2, SHDesc1, PIShop, PDQty, PDUnitPrice, PDDiscPercent, PDAmount", FALSE);
        $db2->from("POSInvoiceDetail");
        $db2->join("POSInvoice","PINO = PDPINo","left");
        $db2->join("ProductType","PTCode = PDProdType","left");
        $db2->join("Shop","PIShop = SHCode","left");
        $db2->join("(select ITCode,ITShortDesc1,ITShortDesc2, ITRefCode, MAX(ITPK) from Item group by ITCode) tt","ITCode=PDItemCode","inner",FALSE);
        $db2->where("PDProdType", $brand);
        $db2->where("POSInvoice.Expired",'F');
        $db2->where("PIStatus",'N');
        $db2->where("PIIssueDate >=", $start);
        $db2->where("PIIssueDate <=", $end);
        $db2->order_by("PIIssueDate");
        $query = $db2->get();
        return $query->result();
    }
    
    function getSaleReport_shop($shop,$remark,$start,$end)
    {
        $start = $start. " 00:00:00";
        $end = $end." 23:59:59";
        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("date_format(PIIssueDate,'%d/%m/%Y') as PIIssueDate,date_format(PIIssueDate,'%Y/%m/%d') as date_sort, PDItemCode, PTDesc1, ITRefCode,ITShortDesc1,ITShortDesc2, SHDesc1, SHCode, PDQty, PDUnitPrice, PDDiscPercent, PDAmount", FALSE);
        $db2->from("POSInvoiceDetail");
        $db2->join("POSInvoice","PINO = PDPINo","left");
        $db2->join("ProductType","PTCode = PDProdType","left");
        $db2->join("Shop","PIShop = SHCode","left");
        $db2->join("Warehouse","SHFGWH=WHCode","left");
        $db2->join("(select ITCode,ITShortDesc1,ITShortDesc2, ITRefCode, MAX(ITPK) from Item group by ITCode) tt","ITCode=PDItemCode","inner",FALSE);
        $db2->like("PDProdType", 'W-', 'after');
        $db2->where("WHType", $shop);
        $db2->where("POSInvoice.Expired",'F');
        $db2->where("PIStatus",'N');
        $db2->where("PIIssueDate >=", $start);
        $db2->where("PIIssueDate <=", $end);
        $db2->like("PTRemarks",$remark);
        $db2->order_by("PIIssueDate");
        $query = $db2->get();
        return $query->result();
    }
    
    function getSaleReport_brand_shop_date($brand,$shop,$start,$end)
    {
        $start = $start. " 00:00:00";
        $end = $end." 23:59:59";
        
        $db2 = $this->load->database('db3',TRUE);
        $db2->select("date_format(PIIssueDate,'%d/%m/%Y') as PIIssueDate,date_format(PIIssueDate,'%Y/%m/%d') as date_sort, PDItemCode, PTDesc1, ITRefCode,ITShortDesc1,ITShortDesc2, SHDesc1, SHCode, PDQty, PDUnitPrice, PDDiscPercent, PDAmount", FALSE);
        $db2->from("POSInvoiceDetail");
        $db2->join("POSInvoice","PINO = PDPINo","left");
        $db2->join("ProductType","PTCode = PDProdType","left");
        $db2->join("Shop","PIShop = SHCode","left");
        $db2->join("Warehouse","SHFGWH=WHCode","left");
        $db2->join("(select ITCode, ITShortDesc1,ITShortDesc2, ITRefCode, MAX(ITPK) from Item group by ITCode) tt","ITCode=PDItemCode","inner",FALSE);
        if ($brand!="0") $db2->where("PDProdType", $brand);
        else $db2->like("PDProdType", 'W-', 'after');
        if ($shop!="0") $db2->where("SHCode", $shop);
        $db2->where("POSInvoice.Expired",'F');
        $db2->where("PIStatus",'N');
        $db2->where("PIIssueDate >=", $start);
        $db2->where("PIIssueDate <=", $end);
        $db2->order_by("PIIssueDate");
        $query = $db2->get();
        return $query->result();
    }

}
?>