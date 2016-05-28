<?php
Class Ngg_gold_model extends CI_Model
{
    
function get_warranty($where)
{
    $this->db->select("ngw_id, ngw_number, ngw_product, ngw_kindgold, ngw_price, ngw_payment, ngw_code, ngw_weight, ngw_jewelry, ngw_datestart, ngw_old, ngw_model, ngw_goldbuy, ngw_goldsell, ngw_customername, ngw_customertelephone, ngw_customeraddress, ngw_saleperson_id, sp_barcode, sp_firstname, sp_lastname, ngw_issuedate, ngw_shop_id, sh_name, sh_telephone, ngw_status, ngw_dateadd, ngw_dateaddby, firstname, lastname, ngw_remark, ngw_enable");
    $this->db->from("ngg_gold_warranty");
    $this->db->join("tp_shop", "sh_id = ngw_shop_id", "left");
    $this->db->join("nerd_users", "id = ngw_dateaddby", "left");
    $this->db->join("tp_sale_person", "sp_id = ngw_saleperson_id", "left");
    $this->db->where("ngw_enable", 1);
    if ($where != "") $this->db->where($where);
    $this->db->order_by("ngw_id", "asc");
    $query = $this->db->get();		
    return $query->result();
}

function get_Maxnumber_warranty($month, $shop_id)
{
    $start = $month." 00:00:00";
    $end = $month." 23:59:59";
    $this->db->select("ngw_id");
    $this->db->from('ngg_gold_warranty');
    $this->db->where("ngw_dateadd >=",$start);
    $this->db->where("ngw_dateadd <=",$end);
    $this->db->where("ngw_shop_id", $shop_id);
    $query = $this->db->get();		
    return $query->num_rows();
}    
    
function add_warranty($insert=NULL)
{		
    $this->db->insert('ngg_gold_warranty', $insert);
    return $this->db->insert_id();			
}
    
function add_log_warranty($insert=NULL)
{		
    $this->db->insert('log_gold_warranty', $insert);
    return $this->db->insert_id();			
}
    
function edit_warranty($edit=NULL)
{
    $this->db->where('ngw_id', $edit['id']);
    unset($edit['id']);
    $query = $this->db->update('ngg_gold_warranty', $edit); 	
    return $query;
}
    
}
?>