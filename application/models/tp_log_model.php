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

 function addLogStockBalance($insert=NULL)
 {		
	$this->db->insert('log_stock_balance', $insert);
	return $this->db->insert_id();			
 }

}
?>