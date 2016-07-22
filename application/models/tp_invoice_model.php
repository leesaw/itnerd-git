<?php
Class Tp_invoice_model extends CI_Model
{

function get_invoice_detail($where)
{
	$this->db->select("inv_id, inv_issuedate, inv_number, inv_shop_id, sh_name, sh_detail, sh_address, sh_number, sh_tax, inv_vender, inv_barcode, inv_day, inv_paydate, inv_remark, inv_dateadd, inv_dateadd_by, inv_enable");
	$this->db->from("tp_invoice");
	$this->db->join("tp_shop", "sh_id = inv_shop_id", "left");
	if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
}

function get_invoice_item($where)
{
	$this->db->select("invit_id, invit_item_id, invit_refcode, invit_brand, invit_qty, invit_srp, invit_discount, invit_netprice, invit_enable, it_refcode, it_model, it_brand_id, br_name, br_code, it_srp");
	$this->db->from("tp_invoice_item");
	$this->db->join("tp_item", "it_id = invit_item_id", "left");
	$this->db->join("tp_brand", "br_id = it_brand_id", "left");
	if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
}

function add_invoice_detail($insert=NULL)
{		
    $this->db->insert('tp_invoice', $insert);
    return $this->db->insert_id();
}

function add_invoice_item($insert=NULL)
{		
    $this->db->insert('tp_invoice_item', $insert);
    return $this->db->insert_id();
}

function edit_invoice_detail($edit=NULL)
{
    $this->db->where('inv_id', $edit['inv_id']);
    unset($edit['inv_id']);
    $query = $this->db->update('tp_invoice', $edit); 	
    return $query;
}

function edit_invoice_item($edit=NULL)
{
    $this->db->where('invit_id', $edit['invit_id']);
    unset($edit['invit_id']);
    $query = $this->db->update('tp_invoice_item', $edit); 	
    return $query;
}

}
?>