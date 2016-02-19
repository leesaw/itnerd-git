<?php
Class Tp_warehouse_transfer_model extends CI_Model
{
 function getWarehouse_transfer($where)
 {
	$this->db->select("stob_id, stob_item_id, stob_qty, stob_warehouse_id, wh_name, wh_code, stob_lastupdate, stob_lastupdate_by");
	$this->db->from('tp_stock_balance');
	$this->db->join('tp_warehouse', 'wh_id = stob_warehouse_id','left');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }

 function addWarehouse_transfer($insert=NULL)
 {		
	$this->db->insert('tp_stock_balance', $insert);
	return $this->db->insert_id();			
 }
 
 function delWarehouse_transfer($id=NULL)
 {
	$this->db->where('stob_id', $id);
	$this->db->delete('tp_stock_balance'); 
 }
 
 function editWarehouse_transfer($edit=NULL)
 {
	$this->db->where('stob_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_stock_balance', $edit); 	
	return $query;
 }
    
 function getWarehouse_transfer_in($where)
 {
	$this->db->select("stoi_number, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, wh_name, wh_code, SUM(log_stob_qty_update) as qty_update, MIN(log_stob_old_qty) as qty_old, stoi_number, stoi_datein, firstname, lastname");
	$this->db->from('log_stock_balance');
    $this->db->join('tp_item', 'it_id = log_stob_item_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
	$this->db->join('tp_stock_in', 'stoi_id = log_stob_stock_in_id','left');	
    $this->db->join('tp_warehouse', 'wh_id = log_stob_warehouse_id','left');
    $this->db->join('nerd_users', 'id = stoi_dateadd_by','left');
    if ($where != "") $this->db->where($where);
    $this->db->group_by("log_stob_item_id");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getMaxNumber_transfer_in($month)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("stoi_id");
	$this->db->from('tp_stock_in');
    $this->db->where("stoi_datein >=",$start);
    $this->db->where("stoi_datein <=",$end);
	$query = $this->db->get();		
	return $query->num_rows();
 }

 function addWarehouse_transfer_in($insert=NULL)
 {		
	$this->db->insert('tp_stock_in', $insert);
	return $this->db->insert_id();			
 }
 
 function delWarehouse_transfer_in($id=NULL)
 {
	$this->db->where('stoi_id', $id);
	$this->db->delete('tp_stock_in'); 
 }
 
 function editWarehouse_transfer_in($edit=NULL)
 {
	$this->db->where('stoi_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_stock_in', $edit); 	
	return $query;
 }

}
?>