<?php
Class Tp_shop_model extends CI_Model
{
 function getShop($where)
 {
	$this->db->select("sh_id, sh_name, sh_code, sh_detail, sh_address, sh_number, sc_name, sg_name, sh_warehouse_id, wh_name, wh_code");
	$this->db->from('tp_shop');
	$this->db->join('tp_shop_category', 'sh_category_id = sc_id','left');	
    $this->db->join('tp_shop_group', 'sh_group_id = sg_id','left');	
    $this->db->join('tp_warehouse', 'sh_warehouse_id = wh_id','left');
    if ($where != "") $this->db->where($where);
    $this->db->order_by("sh_code", "asc");
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
    $this->db->select("it_id, it_refcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, br_name, br_id, br_code, stob_id, stob_qty, sh_group_id, it_has_caseback");
    $this->db->from('tp_stock_balance');
	$this->db->join('tp_shop', "sh_warehouse_id = stob_warehouse_id", "left");
    $this->db->join('tp_item', 'it_id = stob_item_id', 'left');
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getItem_serial($where)
 {
    $this->db->select("itse_id, itse_serial_number, it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, it_remark, br_id, br_name, br_code, itse_warehouse_id, stob_qty, stob_id, it_has_caseback, sh_group_id");
    $this->db->from('tp_item_serial');
	$this->db->join('tp_item', 'itse_item_id = it_id', 'left');
    $this->db->join('tp_stock_balance', 'stob_warehouse_id=itse_warehouse_id and stob_item_id=itse_item_id', 'left');
	$this->db->join('tp_shop', "sh_warehouse_id = stob_warehouse_id", "left");
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getItem_borrow_serial($where)
 {
    $this->db->select("itse_id, itse_serial_number, it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, it_remark, br_name, br_code, posrob_borrower_name, posrobi_stock_balance_id, posrobi_id, posrobi_enable, posrob_issuedate, posrobi_pos_rolex_borrow_id, posrobi_id, posrobi_item_serial_number_id, posrobi_pos_temp_id");
    $this->db->from('tp_pos_rolex_borrow_item');
    $this->db->join('tp_pos_rolex_borrow', 'posrob_id = posrobi_pos_rolex_borrow_id', 'left');
    $this->db->join('tp_item_serial', 'itse_id = posrobi_item_serial_number_id', 'left');
	$this->db->join('tp_item', 'itse_item_id = it_id', 'left');
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }

 function getItem_borrower($where)
 {
 	$this->db->select("itse_id, itse_serial_number, it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, it_remark, br_name, br_code, posbor_name");
    $this->db->from('tp_item_serial');
	$this->db->join('tp_item', 'itse_item_id = it_id', 'left');
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');	
    $this->db->join('tp_pos_rolex_borrower', 'posbor_id = itse_rolex_borrower_id', 'left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getBarcode_shop_group($where)
 {
    $this->db->select("sb_id, sb_number, sb_discount_percent, sb_gp, sb_brand_name");
	$this->db->from('tp_sale_barcode');	
    if ($where != "") $this->db->where($where);
    $this->db->order_by("sb_discount_percent", "asc");
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getMaxNumber_rolex_borrow_shop($month, $shop_id)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("posrob_id");
	$this->db->from('tp_pos_rolex_borrow');
    $this->db->where("posrob_issuedate >=",$start);
    $this->db->where("posrob_issuedate <=",$end);
    $this->db->where("posrob_shop_id", $shop_id);
	$query = $this->db->get();		
	return $query->num_rows();
 }
    
 function getPOS_rolex_borrow($where)
 {
	$this->db->select("posrob_id, posrob_number, posrob_issuedate, posrob_status, posrob_shop_id, sh_name, sh_code, posrob_dateadd, posrob_sale_person_id, posrob_borrower_name, posrob_remark, sp_firstname as firstname, sp_lastname as lastname, sp_barcode");
	$this->db->from('tp_pos_rolex_borrow');
	//$this->db->join('list_creditcard', 'cdc_id = so_creditcard_type','left');
    $this->db->join('tp_shop', 'sh_id = posrob_shop_id', 'left');
    $this->db->join('tp_sale_person', 'sp_id = posrob_sale_person_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getPOS_rolex_borrow_item($where)
 {
	$this->db->select("posrobi_id, posrobi_pos_rolex_borrow_id, posrobi_item_id, posrobi_item_serial_number_id, posrobi_qty,  it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_remark, it_srp, it_short_description, posrobi_stock_balance_id");
	$this->db->from('tp_pos_rolex_borrow_item');	
    $this->db->join('tp_item', 'it_id = posrobi_item_id','left');	
    $this->db->join('tp_item_serial', 'itse_id = posrobi_item_serial_number_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 } 
    
 function getPOS_rolex_borrow_return_item($where)
 {
	$this->db->select("posrobi_id, posrobi_pos_rolex_borrow_id, posrobi_item_id, posrobi_item_serial_number_id, posrobi_qty,  it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_remark, it_srp, it_short_description, posbor_name");
	$this->db->from('tp_pos_rolex_borrow_item');
	$this->db->join('tp_rolex_transfer', 'rot_posrob_id = posrobi_pos_rolex_borrow_id and rot_itse_id = posrobi_item_serial_number_id', 'left');
	$this->db->join('tp_pos_rolex_borrower', 'rot_borrower_out_id = posbor_id', 'left');
    $this->db->join('tp_item', 'it_id = posrobi_item_id','left');	
    $this->db->join('tp_item_serial', 'itse_id = posrobi_item_serial_number_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 } 
    
 function getPOS_rolex_sold_tax_item($where)
 {
    $this->db->select('posroi_id, posroi_pos_rolex_id, posroi_item_id, posroi_item_serial_number_id, posroi_item_srp, posroi_dc_baht, posroi_netprice, posro_number, posro_issuedate, posro_shop_id, posro_payment, posro_remark, posro_status, it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_remark, it_srp, it_short_description');
    $this->db->from('tp_pos_rolex_item');
    $this->db->join('tp_pos_rolex', 'posro_id = posroi_pos_rolex_id', 'left');
    $this->db->join('tp_item', 'it_id = posroi_item_id','left');	
    $this->db->join('tp_item_serial', 'itse_id = posroi_item_serial_number_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getPOS_rolex_sold_temp_item($where)
 {
    $this->db->select('posroit_id, posroit_pos_rolex_temp_id, posroit_item_id, posroit_item_serial_number_id, posroit_item_srp, posroit_dc_baht, posroit_netprice, posrot_number, posrot_issuedate, posrot_shop_id, posrot_payment, posrot_remark, posrot_status, it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_remark, it_srp, it_short_description');
    $this->db->from('tp_pos_rolex_temp_item');
    $this->db->join('tp_pos_rolex_temp', 'posrot_id = posroit_pos_rolex_temp_id', 'left');
    $this->db->join('tp_item', 'it_id = posroit_item_id','left');	
    $this->db->join('tp_item_serial', 'itse_id = posroit_item_serial_number_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
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
    
 function addPOS_rolex_borrow($insert=NULL)
 {		
	$this->db->insert('tp_pos_rolex_borrow', $insert);
	return $this->db->insert_id();			
 }
    
 function addPOS_rolex_borrow_item($insert=NULL)
 {		
	$this->db->insert('tp_pos_rolex_borrow_item', $insert);
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
    
 function editPOS_rolex_borrow($edit=NULL)
 {
	$this->db->where('posrob_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_pos_rolex_borrow', $edit); 	
	return $query;
 }
    
 function editPOS_rolex_borrow_item($edit=NULL)
 {
	$this->db->where('posrobi_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_pos_rolex_borrow_item', $edit); 	
	return $query;
 }

}
?>