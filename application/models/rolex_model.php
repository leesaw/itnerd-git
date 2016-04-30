<?php
Class Rolex_model extends CI_Model
{
 function getCollection($where)
 {
	$this->db->select("it_model");
	$this->db->from('tp_item');
    $this->db->group_by('it_model');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }

 function getBracelet($where)
 {
	$this->db->select("it_remark");
	$this->db->from('tp_item');
    $this->db->group_by('it_remark');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getItem($where, $orderby)
 {
	$this->db->select("it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_remark, it_cost_baht, it_picture, it_min_stock, it_category_id, itc_name, it_brand_id, br_name, br_code, bc_name");
	$this->db->from('tp_item');
	$this->db->join('tp_item_category', 'it_category_id = itc_id','left');		
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');		
    if ($where != "") $this->db->where($where);
    if ($orderby != "") $this->db->order_by($orderby);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getAvailable($where)
 {
    $this->db->select("itse_id");
	$this->db->from('tp_item_serial');
    $this->db->join('tp_item', 'itse_item_id = it_id', 'left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getFilter($where, $orderby)
 {
	$this->db->select("itse_id, itse_serial_number, it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, it_category_id, itc_name, it_brand_id, br_name, br_code, bc_name");
    $this->db->from('tp_item_serial');
	$this->db->join('tp_item', 'itse_item_id = it_id', 'left');
	$this->db->join('tp_item_category', 'it_category_id = itc_id','left');		
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');		
    if ($where != "") $this->db->where($where);
    if ($orderby != "") $this->db->order_by($orderby);
    $this->db->group_by('it_id');
	$query = $this->db->get();		
	return $query->result();
 }
    
    
}
?>