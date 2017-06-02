<?php
Class Tp_stock_return_model extends CI_Model
{

function get_saleorder_warehouse($where)
{
  $this->db->select("so_id, so_number, wh_id, wh_code, wh_name");
  $this->db->from('tp_saleorder');
  $this->db->join('tp_shop', 'sh_id = so_shop_id', 'left');
  $this->db->join('tp_warehouse', 'sh_warehouse_id = wh_id','left');
  if ($where != "") $this->db->where($where);
  $query = $this->db->get();
  return $query->result();
}

function getItem_sale_refcode($where)
{
  $this->db->select("soi_id, soi_saleorder_id, soi_item_id, soi_item_refcode, soi_item_name,  soi_item_srp, soi_qty, soi_dc_percent, soi_dc_baht, soi_sale_barcode_id, soi_gp, soi_netprice, soi_remark, it_refcode, it_barcode, br_name, it_model, it_uom, soi_item_srp as it_srp, sb_number, sb_discount_percent, sb_gp");
	$this->db->from('tp_saleorder_item');
	$this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
  $this->db->join('tp_item', 'it_id = soi_item_id','left');
  $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
  if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
}

function get_sale_item_sum($where)
{
  $this->db->select("soi_item_id, SUM(soi_qty) as soi_qty");
  $this->db->from('tp_saleorder_item');
  $this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
  if ($where != "") $this->db->where($where);
  $this->db->group_by("soi_item_id");
  $query = $this->db->get();
  return $query->result();
}

function getItem_sale_caseback($where)
{
  $this->db->select("sos_soi_id,sos_saleorder_id, sos_item_id, itse_id, sos_item_serial_id, sos_enable, itse_serial_number, soi_item_refcode, soi_item_name,  soi_item_srp, soi_qty, soi_dc_percent, soi_dc_baht, soi_sale_barcode_id, soi_gp, soi_netprice, soi_remark, it_refcode, it_barcode, br_name, it_model, it_uom, soi_item_srp as it_srp, sb_number, sb_discount_percent, sb_gp");
  $this->db->from('tp_saleorder_serial');
  $this->db->join('tp_saleorder_item', 'soi_id = sos_soi_id', 'left');
  $this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
  $this->db->join('tp_item_serial', 'itse_id=sos_item_serial_id', 'left');
  $this->db->join('tp_item', 'it_id = soi_item_id','left');
  $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
  if ($where != "") $this->db->where($where);
  $query = $this->db->get();
  return $query->result();
}

function getMaxNumber_return_request($month)
{
  $start = $month."-01 00:00:00";
  $end = $month."-31 23:59:59";
  $this->db->select("stor_id");
  $this->db->from('tp_stock_return');
  $this->db->where("stor_dateadd >=",$start);
  $this->db->where("stor_dateadd <=",$end);
  $query = $this->db->get();
  return $query->num_rows();
}

function get_return_item($where)
{
  $this->db->select("log_stor_id, so_id, so_number, stor_number, stor_status, wh_id, wh_code, wh_name, stor_has_serial, it_refcode, it_barcode, it_short_description, br_name, it_model, it_uom, it_srp, SUM(log_stor_qty_update) as qty_update, SUM(log_stor_qty_final) as qty_final, MAX(log_stor_old_qty) as qty_old, stor_issue, firstname, lastname, log_stor_item_id, stor_dateadd, stor_remark");
  $this->db->from('log_stock_return');
  $this->db->join('tp_stock_return', 'stor_id = log_stor_stor_id','left');
  $this->db->join('tp_item', 'it_id = log_stor_item_id','left');
  $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  $this->db->join('tp_saleorder', 'so_id = stor_so_id','left');
  $this->db->join('tp_shop', 'sh_id = so_shop_id', 'left');
  $this->db->join('tp_warehouse', 'wh_id = sh_warehouse_id', 'left');
  $this->db->join('nerd_users', 'id = stor_dateadd_by','left');
  if ($where != "") $this->db->where($where);
  $this->db->group_by("log_stor_item_id");
  $this->db->order_by("it_refcode", "asc");
  $query = $this->db->get();
  return $query->result();
}

function get_return_serial($where)
{
  $this->db->select("log_stor_item_id, log_stor_stor_id, itse_serial_number, it_refcode, it_barcode, it_short_description, br_name, it_model, it_uom, it_srp, itse_id");
  $this->db->from('log_stock_return');
  $this->db->join('log_stock_return_serial', 'log_stors_stor_id = log_stor_id','left');
  $this->db->join('tp_item_serial', 'itse_id = log_stors_item_serial_id','left');
  $this->db->join('tp_stock_return', 'stor_id = log_stor_stor_id','left');
  $this->db->join('tp_item', 'it_id = log_stor_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  if ($where != "") $this->db->where($where);
  $this->db->order_by("itse_serial_number", "asc");
  $query = $this->db->get();
  return $query->result();
}

function get_return_request($where)
{
  $this->db->select("stor_id, stor_so_id, so_number, stor_number, stor_status, wh1.wh_id as wh_id, wh1.wh_code as wh_code, wh1.wh_name as wh_name, wh2.wh_code as wh_code_in, wh2.wh_name as wh_name_in, stor_has_serial, stor_issue, user1.firstname as firstname, user1.lastname as lastname,
  user2.firstname as firstname_confirm, user2.lastname as lastname_confirm, stor_dateadd, stor_confirm_dateadd, stor_remark, sh_code, sh_name");
  $this->db->from('tp_stock_return');
  $this->db->join('tp_saleorder', 'so_id = stor_so_id','left');
  $this->db->join('tp_shop', 'sh_id = so_shop_id', 'left');
  $this->db->join('tp_warehouse wh1', 'wh1.wh_id = sh_warehouse_id', 'left');
  $this->db->join('tp_warehouse wh2', 'wh2.wh_id = stor_warehouse_id', 'left');
  $this->db->join('nerd_users user1', 'user1.id = stor_dateadd_by','left');
  $this->db->join('nerd_users user2', 'user2.id = stor_confirm_by','left');
  if ($where != "") $this->db->where($where);
  $query = $this->db->get();
  return $query->result();
}

function add_stock_return($insert=NULL)
{
 $this->db->insert('tp_stock_return', $insert);
 return $this->db->insert_id();
}

function add_log_stock_return($insert=NULL)
{
 $this->db->insert('log_stock_return', $insert);
 return $this->db->insert_id();
}

function add_log_serial_stock_return($insert=NULL)
{
 $this->db->insert('log_stock_return_serial', $insert);
 return $this->db->insert_id();
}

function edit_stock_return($edit=NULL)
{
 $this->db->where('stor_id', $edit['id']);
 unset($edit['id']);
 $query = $this->db->update('tp_stock_return', $edit);
 return $query;
}

function edit_log_stock_return($edit=NULL)
{
 $this->db->where('log_stor_id', $edit['id']);
 unset($edit['id']);
 $query = $this->db->update('log_stock_return', $edit);
 return $query;
}

}
?>
