<?php
Class Tp_warehouse_model extends CI_Model
{
 function getWarehouse_transfer($where)
 {
	$this->db->select("stob_id, stob_item_id, stob_item_refcode, stob_item_brand_code, stob_qty, stob_warehouse_id, wh_name, wh_code, stob_lastupdate, stob_lastupdate_by");
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

}
?>