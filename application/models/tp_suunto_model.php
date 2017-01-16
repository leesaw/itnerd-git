<?php
Class Tp_suunto_model extends CI_Model
{

function get_stock_balance($where)
{
  $this->db->select("stob_id, stob_item_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_cost_baht, it_short_description, it_remark, stob_qty, stob_warehouse_id, wh_name, wh_code, stob_lastupdate, stob_lastupdate_by");
  $this->db->from('tp_stock_balance');
  $this->db->join('tp_warehouse', 'wh_id = stob_warehouse_id','left');
  $this->db->join('tp_item', 'it_id = stob_item_id','left');
  $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  if ($where != "") $this->db->where($where);
  $this->db->order_by('wh_code');
  $query = $this->db->get();
  return $query->result();
}

function get_top_ten_remark($where)
{
  $this->db->select("so_shop_id,sh_code,sh_name,it_remark, sum(it_cost_baht) as cost_price, count(soi_item_id) as count_item");
  $this->db->from('tp_saleorder_item');
  $this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
  $this->db->join('tp_item', 'it_id = soi_item_id','left');
  $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  $this->db->join('tp_shop', 'so_shop_id = sh_id','left');
  $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
  if ($where != "") $this->db->where($where);
  $this->db->group_by("it_remark,so_shop_id");
  $query = $this->db->get();
  return $query->result();
}

function get_top_ten_all($where)
{
  $this->db->select("so_shop_id,sh_code,sh_name, sum(it_cost_baht) as cost_price, count(soi_item_id) as count_item");
  $this->db->from('tp_saleorder_item');
  $this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
  $this->db->join('tp_item', 'it_id = soi_item_id','left');
  $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  $this->db->join('tp_shop', 'so_shop_id = sh_id','left');
  $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
  if ($where != "") $this->db->where($where);
  $this->db->group_by("so_shop_id");
  $this->db->order_by("cost_price", "desc");
  $this->db->limit(10);
  $query = $this->db->get();
  return $query->result();
}

}
?>
