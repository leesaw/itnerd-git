<?php
Class Tp_repair_model extends CI_Model
{
 function getItem($where)
 {
	$this->db->select("it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, it_category_id, itc_name, it_brand_id, br_name, br_code, bc_name");
	$this->db->from('tp_item');
	$this->db->join('tp_item_category', 'it_category_id = itc_id','left');		
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');		
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function addItem($insert=NULL)
 {		
	$this->db->insert('tp_item', $insert);
	return $this->db->insert_id();			
 }
 
 function delItem($id=NULL)
 {
	$this->db->where('it_id', $id);
	$this->db->delete('tp_item'); 
 }
 
 function editItem($edit=NULL)
 {
	$this->db->where('it_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_item', $edit); 	
	return $query;
 }


}
?>