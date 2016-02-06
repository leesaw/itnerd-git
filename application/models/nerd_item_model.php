<?php
Class Nerd_item_model extends CI_Model
{
    // List All Shop Type
    function getShop_branch()
    {
        $db = $this->load->database('db4',TRUE);
        
        $db2->select("SHCode, SHDesc1", FALSE);
        $db2->from("Shop");
        $db2->join("(select PIShop from POSInvoice group by PIShop) tt","tt.PIShop=SHCode","inner",FALSE);
        $db2->order_by("SHDesc1");
        $query = $db2->get();
        return $query->result();
    }
    
}
?>