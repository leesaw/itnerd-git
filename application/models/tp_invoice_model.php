<?php
Class Tp_invoice_model extends CI_Model
{

function get_invoice_detail($where)
{
	$this->db->select("inv_id, inv_issuedate, inv_number, inv_warehouse_id, wh_code, wh_name, inv_warehouse_detail, inv_warehouse_address1, inv_warehouse_address2, inv_warehouse_taxid, inv_warehouse_branch, inv_vender, inv_barcode, inv_stot_number, inv_stot_id, inv_srp_discount, inv_note, inv_day, inv_paydate, inv_remark, inv_dateadd, inv_dateadd_by, firstname, lastname, inv_enable, inv_discount_percent");
	$this->db->from("tp_invoice");
	$this->db->join("tp_warehouse", "wh_id = inv_warehouse_id", "left");
	$this->db->join("nerd_users", "inv_dateadd_by = id", "left");
	if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
}

function get_invoice_detail_sumnetprice_list($where)
{
	$this->db->select("inv_id, inv_issuedate, inv_number, inv_warehouse_id, wh_code, wh_name, inv_warehouse_detail, inv_warehouse_address1, inv_warehouse_address2, inv_warehouse_taxid, inv_warehouse_branch, inv_vender, inv_barcode, inv_stot_number, inv_stot_id, inv_note, inv_day, inv_paydate, inv_remark, inv_dateadd, inv_dateadd_by, firstname, lastname, inv_enable, (SUM(invit_netprice * invit_qty)*(100-inv_discount_percent)/100) as sum_netprice, inv_discount_percent");
	$this->db->from("tp_invoice");
	$this->db->join("tp_invoice_item", "inv_id = invit_invoice_id");
	$this->db->join("tp_warehouse", "wh_id = inv_warehouse_id", "left");
	$this->db->join("nerd_users", "inv_dateadd_by = id", "left");
	if ($where != "") $this->db->where($where);
	$this->db->group_by("invit_invoice_id");
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
	$this->db->order_by("invit_refcode", "asc");
	$query = $this->db->get();		
	return $query->result();
}

function get_max_number($month)
{
	$start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("inv_id");
	$this->db->from('tp_invoice');
    $this->db->where("inv_issuedate >=",$start);
    $this->db->where("inv_issuedate <=",$end);
    $this->db->where("inv_enable", 1);
	$query = $this->db->get();		
	return $query->num_rows();
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
    $this->db->where('inv_id', $edit['id']);
    unset($edit['id']);
    $query = $this->db->update('tp_invoice', $edit); 	
    return $query;
}

function edit_invoice_item($edit=NULL)
{
    $this->db->where('invit_id', $edit['id']);
    unset($edit['id']);
    $query = $this->db->update('tp_invoice_item', $edit); 	
    return $query;
}

}
?>