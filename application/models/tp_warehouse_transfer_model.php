<?php
Class Tp_warehouse_model extends CI_Model
{
 function getWarehouse_transfer($where)
 {
	$this->db->select("wh_id, wh_name, wh_code, wc_category_name, wg_name, wg_code");
	$this->db->from('tp_warehouse');
	$this->db->join('tp_warehouse_category', 'wh_category_id = wc_id','left');	
    $this->db->join('tp_warehouse_group', 'wh_group_id = wg_id','left');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }

 function addWarehouse_transfer($insert=NULL)
 {		
	$this->db->insert('tp_warehouse', $insert);
	return $this->db->insert_id();			
 }
 
 function delWarehouse($id=NULL)
 {
	$this->db->where('wh_id', $id);
	$this->db->delete('tp_warehouse'); 
 }
 
 function editWarehouse($edit=NULL)
 {
	$this->db->where('wh_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_warehouse', $edit); 	
	return $query;
 }

}
?>