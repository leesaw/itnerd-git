<?php
Class Tp_delivery_model extends CI_Model
{

function get_transfer_between($where)
{
  $this->db->select("stot_id, delivery_remark, delivery_status, delivery_dateadd, stot_number, stot_status, stot_has_serial,
  wh1.wh_id as wh_out_id, wh1.wh_name as wh_out_name, wh1.wh_code as wh_out_code, wh2.wh_id as wh_in_id, wh2.wh_name as wh_in_name, wh2.wh_code as wh_in_code, wh2.wh_group_id as wh_in_group,
  stot_datein, user1.firstname as firstname, user1.lastname as lastname, user2.firstname as confirm_firstname, user2.lastname as confirm_lastname");
  $this->db->from('tp_stock_transfer');
  $this->db->join('tp_warehouse wh1', 'wh1.wh_id = stot_warehouse_out_id','inner');
  $this->db->join('tp_warehouse wh2', 'wh2.wh_id = stot_warehouse_in_id','inner');
  $this->db->join('nerd_users user1', 'user1.id = stot_dateadd_by','left');
  $this->db->join('nerd_users user2', 'user2.id = stot_confirm_by','left');
  if ($where != "") $this->db->where($where);
  $query = $this->db->get();
  return $query->result();
}

function get_brand_number($where)
{
   $this->db->select("br_name, SUM(log_stot_qty_final) as qty");
   $this->db->from('log_stock_transfer');
   $this->db->join('tp_item', 'it_id = log_stot_item_id','left');
   $this->db->join('tp_brand', 'br_id = it_brand_id','left');
   if ($where != "") $this->db->where($where);
   $this->db->group_by('br_id');
   $this->db->order_by('br_name');
   $query = $this->db->get();
   return $query->result();
}

function edit_delivery($edit=NULL)
{
    $this->db->where('stot_id', $edit['id']);
    unset($edit['id']);
    $query = $this->db->update('tp_stock_transfer', $edit);
    return $query;
}

}
?>
