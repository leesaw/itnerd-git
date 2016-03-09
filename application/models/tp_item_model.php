<?php
Class Tp_item_model extends CI_Model
{
 function getItem($where)
 {
	$this->db->select("it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, itc_name, br_name, br_code, bc_name");
	$this->db->from('tp_item');
	$this->db->join('tp_item_category', 'it_category_id = itc_id','left');		
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');		
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getItemCategory($where)
 {
	$this->db->select("itc_id, itc_name, itc_remark");
	$this->db->from('tp_item_category');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("itc_name", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getBrand($where)
 {
	$this->db->select("br_id, br_name, br_code, br_remark, bc_name");
	$this->db->from('tp_brand');	
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("br_code", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getBrandCategory($where)
 {
	$this->db->select("bc_id, bc_name, bc_remark");
	$this->db->from('tp_brand_category');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("bc_name", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getItem_caseback($where)
 {
	$this->db->select("itse_id, itse_serial_number, it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, itc_name, br_name, br_code, bc_name");
    $this->db->from('tp_item_serial');
	$this->db->join('tp_item', 'itse_item_id = it_id', 'left');
	$this->db->join('tp_item_category', 'it_category_id = itc_id','left');		
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');		
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getCaseback_stock($where)
 {
	$this->db->select("itse_serial_number");
    $this->db->from('tp_stock_balance');
    $this->db->join('tp_item_serial', 'itse_item_id=stob_item_id and itse_warehouse_id=stob_warehouse_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function checkAvailable_caseback($caseback)
 {
    $this->db->select("itse_id");
    $this->db->from("tp_item_serial");
    $this->db->where("itse_serial_number", $caseback);
    $this->db->where("itse_enable", 1);
    $query = $this->db->get();
	return $query->num_rows();
 }
    
 function checkCaseback_warehouse($caseback, $wh_id) {
    $this->db->select("itse_id, itse_item_id");
    $this->db->from("tp_item_serial");
    $this->db->where("itse_serial_number", $caseback);
    $this->db->where("itse_warehouse_id", $wh_id);
    $this->db->where("itse_enable", 1);
    $query = $this->db->get();		
	return $query->result();
 }

 function addItem($insert=NULL)
 {		
	$this->db->insert('tp_item', $insert);
	return $this->db->insert_id();			
 }
    
 function addItem_log($insert=NULL)
 {		
	$this->db->insert('log_item', $insert);
	return $this->db->insert_id();			
 }
    
 function addItemCategory($insert=NULL)
 {		
	$this->db->insert('tp_item_category', $insert);
	return $this->db->insert_id();			
 }
    
 function addBrand($insert=NULL)
 {		
	$this->db->insert('tp_brand', $insert);
	return $this->db->insert_id();			
 }
    
 function addBrandCategory($insert=NULL)
 {		
	$this->db->insert('tp_brand_category', $insert);
	return $this->db->insert_id();			
 }
    
 function addItemCode($insert=NULL)
 {		
	$this->db->insert('tp_item_serial', $insert);
	return $this->db->insert_id();			
 }
 
 function delItem($id=NULL)
 {
	$this->db->where('it_id', $id);
	$this->db->delete('tp_item'); 
 }
    
 function delItemCategory($id=NULL)
 {
	$this->db->where('itc_id', $id);
	$this->db->delete('tp_item_category'); 
 }
    
 function delBrand($id=NULL)
 {
	$this->db->where('br_id', $id);
	$this->db->delete('tp_brand'); 
 }
    
 function delBrandCategory($id=NULL)
 {
	$this->db->where('bc_id', $id);
	$this->db->delete('tp_brand_category'); 
 }
 
 function editItem($edit=NULL)
 {
	$this->db->where('it_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_item', $edit); 	
	return $query;
 }
    
 function editItemCategory($edit=NULL)
 {
	$this->db->where('itc_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_item_category', $edit); 	
	return $query;
 }

 function editBrand($edit=NULL)
 {
	$this->db->where('br_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_brand', $edit); 	
	return $query;
 }
    
 function editBrandCategory($edit=NULL)
 {
	$this->db->where('bc_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_brand_category', $edit); 	
	return $query;
 }
    
 function editItemSerial($edit=NULL)
 {
	$this->db->where('itse_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_item_serial', $edit); 	
	return $query;
 }

}
?>