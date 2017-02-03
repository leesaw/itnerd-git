<?php
Class Tp_log_model extends CI_Model
{
 function getLogStockBalance($where)
 {
	$this->db->select("stob_number, stob_stock_balance_id, stob_warehouse_id, stob_old_qty, stob_new_qty, stob_status, stob_dateadd, stob_dateadd_by");
	$this->db->from('log_stock_balance');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getLogStockTransfer($where)
 {
	$this->db->select("	log_stot_id, log_stot_transfer_id, log_stot_item_id, log_stot_old_qty, 	log_stot_qty_want, log_stot_qty_final, log_stot_enable");
	$this->db->from('log_stock_transfer');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function addLogStockBalance($insert=NULL)
 {
	$this->db->insert('log_stock_balance', $insert);
	return $this->db->insert_id();
 }

 function addLogStockBalance_serial($insert=NULL)
 {
	$this->db->insert('log_stock_balance_serial', $insert);
	return $this->db->insert_id();
 }

 function addLogStockOut($insert=NULL)
 {
	$this->db->insert('log_stock_out', $insert);
	return $this->db->insert_id();
 }

 function addLogStockOut_serial($insert=NULL)
 {
	$this->db->insert('log_stock_out_serial', $insert);
	return $this->db->insert_id();
 }

 function addLogStockTransfer($insert=NULL)
 {
	$this->db->insert('log_stock_transfer', $insert);
	return $this->db->insert_id();
 }

 function addLogStockTransfer_serial($insert=NULL)
 {
	$this->db->insert('log_stock_transfer_serial', $insert);
	return $this->db->insert_id();
 }

 function delLogStockTransfer_serial($id=NULL)
 {
	$this->db->where('log_stots_id', $id);
	$this->db->delete('log_stock_transfer_serial');
 }

 function editWarehouse_transfer_between($edit=NULL)
 {
	$this->db->where('log_stot_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('log_stock_transfer', $edit);
	return $query;
 }

 function editWarehouse_transfer_between_serial($edit=NULL)
 {
	$this->db->where('log_stots_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('log_stock_transfer_serial', $edit);
	return $query;
 }

}
?>
