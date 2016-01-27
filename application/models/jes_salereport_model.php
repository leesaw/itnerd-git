<?php
Class Jes_salereport_model extends CI_Model
{
    function getSale_watch_lf_between($remark,$start,$end)
    {
        $start = $start. " 00:00:00";
        $end = $end." 23:59:59";
        
        $column = "(gemstone_stock.datein >='".$start."' and gemstone_stock.datein <='".$end."'";
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
        
        $column = "(gemstone_stock.datein >='".$start."' and gemstone_stock.datein <='".$end."'";
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
}
?>