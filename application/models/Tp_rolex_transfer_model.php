<?php
Class Tp_rolex_transfer_model extends CI_Model
{
 function get_rolex_transfer($where)
 {
	$this->db->select("rot_id, rot_warehouse_out_id, rot_warehouse_in_id, rot_itse_id, rot_borrower_out_id, rot_borrower_in_id, rot_remark, rot_status");
	$this->db->from('tp_rolex_transfer');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }

 function add_rolex_transfer($insert=NULL)
 {		
	$this->db->insert('tp_rolex_transfer', $insert);
	return $this->db->insert_id();			
 }

 function edit_rolex_transfer($edit=NULL)
 {
	$this->db->where('rot_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_rolex_transfer', $edit); 	
	return $query;
 }
    
    
}
?>