<?php
Class Tp_saleorder_model extends CI_Model
{
 function getSaleOrder($where)
 {
	$this->db->select("so_id, so_number, so_issuedate, so_ontop_percent, so_ontop_baht, so_status, so_shop_id, sh_name, sh_code, so_dateadd, so_sale_person_id, so_customer_id, so_payment, so_creditcard_type, so_creditcard_number, firstname, lastname");
	$this->db->from('tp_saleorder');
	$this->db->join('list_creditcard', 'cdc_id = so_creditcard_type','left');
    $this->db->join('tp_shop', 'sh_id = so_shop_id', 'left');
    $this->db->join('nerd_users', 'id = so_dateadd_by','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 }
    
 function getSaleItem($where)
 {
	$this->db->select("soi_id, soi_saleorder_id, soi_item_id, soi_item_refcode, soi_item_name,  soi_item_srp, soi_qty, soi_dc_percent, soi_dc_baht, soi_sale_barcode_id, soi_gp, soi_netprice, soi_remark, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, sb_number, sb_discount_percent, sb_gp");
	$this->db->from('tp_saleorder_item');	
    $this->db->join('tp_item', 'it_id = soi_item_id','left');	
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 } 
    
 function getSaleBarcode($where)
 {
	$this->db->select("sb_id, sb_number, sb_item_brand_id, sb_brand_name, sb_discount_percent, sb_gp");
	$this->db->from('tp_sale_barcode');	
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();		
	return $query->result();
 } 
    
 function getMaxNumber_saleorder_shop($month, $shop_id)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("so_id");
	$this->db->from('tp_saleorder');
    $this->db->where("so_issuedate >=",$start);
    $this->db->where("so_issuedate <=",$end);
    $this->db->where("so_shop_id", $shop_id);
	$query = $this->db->get();		
	return $query->num_rows();
 }

 function addSaleOrder($insert=NULL)
 {		
	$this->db->insert('tp_saleorder', $insert);
	return $this->db->insert_id();			
 }
    
 function addSaleItem($insert=NULL)
 {		
	$this->db->insert('tp_saleorder_item', $insert);
	return $this->db->insert_id();			
 }
    
 function addSaleBarcode($insert=NULL)
 {		
	$this->db->insert('tp_sale_barcode', $insert);
	return $this->db->insert_id();			
 }
 
 function delSaleOrder($id=NULL)
 {
	$this->db->where('so_id', $id);
	$this->db->delete('tp_saleorder'); 
 }
    
 function delSaleItem($id=NULL)
 {
	$this->db->where('soi_id', $id);
	$this->db->delete('tp_saleorder_item'); 
 }
    
 function delSaleBarcode($id=NULL)
 {
	$this->db->where('sb_id', $id);
	$this->db->delete('tp_sale_barcode'); 
 }
 
 function editSalePerson($edit=NULL)
 {
	$this->db->where('so_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_saleorder', $edit); 	
	return $query;
 }
    
 function editSaleItem($edit=NULL)
 {
	$this->db->where('soi_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_saleorder_item', $edit); 	
	return $query;
 }
    
 function editSaleBarcode($edit=NULL)
 {
	$this->db->where('sb_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_sale_barcode', $edit); 	
	return $query;
 }

}
?>