<?php
Class Tp_shop_model extends CI_Model
{
 function getShop($where)
 {
	$this->db->select("sh_id, sh_name, sh_code, sc_name, sg_name, sh_warehouse_id, wh_name, wh_code");
	$this->db->from('tp_shop');
	$this->db->join('tp_shop_category', 'sh_category_id = sc_id','left');	
    $this->db->join('tp_shop_group', 'sh_group_id = sg_id','left');	
    $this->db->join('tp_warehouse', 'sh_warehouse_id = wh_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
 
 function getShopCategory($where)
 {
	$this->db->select("sc_id, sc_name, sc_remark");
	$this->db->from('tp_shop_category');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("sc_name", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getShopGroup($where)
 {
	$this->db->select("sg_id, sg_name, sg_remark");
	$this->db->from('tp_shop_group');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("sg_name", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getItem_refcode($where)
 {
    $this->db->select("it_id, it_refcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, br_name, br_id, br_code, stob_id, stob_qty, sh_group_id");
    $this->db->from('tp_stock_balance');
	$this->db->join('tp_shop', "sh_warehouse_id = stob_warehouse_id", "left");
    $this->db->join('tp_item', 'it_id = stob_item_id', 'left');
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getBarcode_shop_group($where)
 {
    $this->db->select("sb_id, sb_number, sb_discount_percent, sb_gp, sb_brand_name");
	$this->db->from('tp_sale_barcode');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("sb_number", "asc");
	$query = $this->db->get();		
	return $query->result();
 }

 function addShop($insert=NULL)
 {		
	$this->db->insert('tp_shop', $insert);
	return $this->db->insert_id();			
 }
    
 function addShopCategory($insert=NULL)
 {		
	$this->db->insert('tp_shop_category', $insert);
	return $this->db->insert_id();			
 }
    
 function addShopGroup($insert=NULL)
 {		
	$this->db->insert('tp_shop_group', $insert);
	return $this->db->insert_id();			
 }
 
 function delShop($id=NULL)
 {
	$this->db->where('sh_id', $id);
	$this->db->delete('tp_shop'); 
 }
    
 function delShopCategory($id=NULL)
 {
	$this->db->where('sc_id', $id);
	$this->db->delete('tp_shop_category'); 
 }
    
 function delShopGroup($id=NULL)
 {
	$this->db->where('sg_id', $id);
	$this->db->delete('tp_shop_group'); 
 }
 
 function editShop($edit=NULL)
 {
	$this->db->where('sh_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_shop', $edit); 	
	return $query;
 }
    
 function editShopCategory($edit=NULL)
 {
	$this->db->where('sc_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_shop_category', $edit); 	
	return $query;
 }
    
 function editShopGroup($edit=NULL)
 {
	$this->db->where('sg_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_shop_group', $edit); 	
	return $query;
 }

}
?>