<?php
Class Tp_rolex_warrantycard_model extends CI_Model
{
 function get_warrantycard($where)
 {
	$this->db->select("rowa_id, rowa_itse_id, it_refcode, it_model, it_remark, it_short_description, rowa_shop_id, rowa_issuedate, rowa_serial_number, rowa_dateadd, rowa_dateadd_by, firstname, lastname, rowa_enable");
	$this->db->from('tp_rolex_warrantycard');
	$this->db->join('tp_item_serial', 'itse_id = rowa_itse_id', 'left');
	$this->db->join('tp_item', 'itse_item_id = it_id','left');
	$this->db->join('nerd_users', 'rowa_dateadd_by = id','left');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by('rowa_issuedate', 'desc');
	$query = $this->db->get();		
	return $query->result();
 }
    
 function add_warrantycard($insert=NULL)
 {		
	$this->db->insert('tp_rolex_warrantycard', $insert);
	return $this->db->insert_id();			
 }

 function edit_warrantycard($edit=NULL)
 {
	$this->db->where('rowa_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_rolex_warrantycard', $edit); 	
	return $query;
 }


}
?>