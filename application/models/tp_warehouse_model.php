<?php
Class Tp_warehouse_model extends CI_Model
{
 function getWarehouse($where)
 {
	$this->db->select("wh_id, wh_name, wh_code, wh_detail, wh_address1, wh_address2, wh_taxid, wh_branch, wc_category_name, wg_id, wg_name, wg_vender, wg_code, wh_enable");
	$this->db->from('tp_warehouse');
	$this->db->join('tp_warehouse_category', 'wh_category_id = wc_id','left');	
    $this->db->join('tp_warehouse_group', 'wh_group_id = wg_id','left');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("wh_code", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getNumber_balance_groupbyshop($where)
 {
    $this->db->select("SUM(stob_qty) as sum1, stob_warehouse_id, wh_name, wh_code");
	$this->db->from('tp_stock_balance');
	$this->db->join('tp_warehouse', 'wh_id = stob_warehouse_id','left');
    $this->db->join('tp_item', 'it_id = stob_item_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->group_by('stob_warehouse_id');
    if ($where != "") $this->db->where($where);
    $this->db->order_by("wh_code", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getWarehouse_balance($where)
 {
	$this->db->select("stob_id, stob_item_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_short_description, it_remark, stob_qty, stob_warehouse_id, wh_name, wh_code, stob_lastupdate, stob_lastupdate_by, count(itse_serial_number) as has_serial");
	$this->db->from('tp_stock_balance');
	$this->db->join('tp_warehouse', 'wh_id = stob_warehouse_id','left');
    $this->db->join('tp_item', 'it_id = stob_item_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_item_serial', 'itse_item_id=stob_item_id and itse_warehouse_id=stob_warehouse_id','left');
    $this->db->group_by('stob_id');
    if ($where != "") $this->db->where($where);
    $this->db->order_by('br_name, it_refcode');
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getAll_Item_warehouse($where)
 {
	$this->db->select("stob_id, stob_item_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_short_description, it_remark, stob_qty, stob_warehouse_id, wh_name, wh_code, stob_lastupdate, stob_lastupdate_by");
	$this->db->from('tp_stock_balance');
	$this->db->join('tp_warehouse', 'wh_id = stob_warehouse_id','left');
    $this->db->join('tp_item', 'it_id = stob_item_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getAll_Item_warehouse_caseback($where)
 {
	$this->db->select("itse_id, it_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_short_description, it_remark, wh_name, wh_code, itse_serial_number, br_name, itse_enable, stob_qty");
    $this->db->from('tp_item_serial');
	$this->db->join('tp_warehouse', 'itse_warehouse_id = wh_id','left');
    $this->db->join('tp_stock_balance', 'stob_warehouse_id = itse_warehouse_id and stob_item_id=itse_item_id', 'left');
    $this->db->join('tp_item', 'it_id = itse_item_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
 
        
 function getWarehouse_balance_caseback($where)
 {
	$this->db->select("itse_id, it_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_short_description, it_remark, wh_name, wh_code, itse_serial_number, br_name, itse_enable");
    $this->db->from('tp_item_serial');
	$this->db->join('tp_warehouse', 'itse_warehouse_id = wh_id','left');
    $this->db->join('tp_item', 'it_id = itse_item_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
    $this->db->order_by('itse_serial_number', 'asc');
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getWarehouseCategory($where)
 {
	$this->db->select("wc_id, wc_category_name, wc_remark");
	$this->db->from('tp_warehouse_category');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("wc_category_name", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getWarehouseGroup($where)
 {
	$this->db->select("wg_id, wg_name, wg_code, wg_remark");
	$this->db->from('tp_warehouse_group');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("wg_name", "asc");
	$query = $this->db->get();		
	return $query->result();
 }

 function addWarehouse($insert=NULL)
 {		
	$this->db->insert('tp_warehouse', $insert);
	return $this->db->insert_id();			
 }
    
 function addWarehouseCategory($insert=NULL)
 {		
	$this->db->insert('tp_warehouse_category', $insert);
	return $this->db->insert_id();			
 }
    
 function addWarehouseGroup($insert=NULL)
 {		
	$this->db->insert('tp_warehouse_group', $insert);
	return $this->db->insert_id();			
 }
 
 function delWarehouse($id=NULL)
 {
	$this->db->where('wh_id', $id);
	$this->db->delete('tp_warehouse'); 
 }
    
 function delWarehouseCategory($id=NULL)
 {
	$this->db->where('wc_id', $id);
	$this->db->delete('tp_warehouse_category'); 
 }
    
 function delWarehouseGroup($id=NULL)
 {
	$this->db->where('wg_id', $id);
	$this->db->delete('tp_warehouse_group'); 
 }
 
 function editWarehouse($edit=NULL)
 {
	$this->db->where('wh_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_warehouse', $edit); 	
	return $query;
 }

 function editWarehouseCategory($edit=NULL)
 {
	$this->db->where('wc_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_warehouse_category', $edit); 	
	return $query;
 }
    
 function editWarehouseGroup($edit=NULL)
 {
	$this->db->where('wg_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_warehouse_group', $edit); 	
	return $query;
 }

}
?>