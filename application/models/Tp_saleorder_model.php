<?php
Class Tp_saleorder_model extends CI_Model
{
 function getSaleOrder($where)
 {
	$this->db->select("so_id, so_number, so_issuedate, so_ontop_percent, so_ontop_baht, so_status, so_shop_id, sh_name, sh_code, so_dateadd, so_sale_person_id, so_customer_id, so_payment, so_creditcard_type, so_creditcard_number, so_remark, firstname, lastname");
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
	$this->db->select("soi_id, soi_saleorder_id, soi_item_id, soi_item_refcode, soi_item_name,  soi_item_srp, soi_qty, soi_dc_percent, soi_dc_baht, soi_sale_barcode_id, soi_gp, soi_netprice, soi_remark, it_refcode, it_barcode, br_name, it_model, it_uom, soi_item_srp as it_srp, sb_number, sb_discount_percent, sb_gp");
	$this->db->from('tp_saleorder_item');
	$this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
    $this->db->join('tp_item', 'it_id = soi_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getSaleSerial($where)
 {
	$this->db->select("sos_soi_id,sos_saleorder_id, sos_item_id, sos_item_serial_id, sos_enable, itse_serial_number");
	$this->db->from('tp_saleorder_serial');
    $this->db->join('tp_item_serial', 'itse_id=sos_item_serial_id', 'left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getSaleItemSerial($where)
 {
   $this->db->select("sos_soi_id,sos_saleorder_id, sos_item_id, sos_item_serial_id, sos_enable, itse_serial_number, soi_item_refcode, soi_item_name,  soi_item_srp, soi_qty, soi_dc_percent, soi_dc_baht, soi_sale_barcode_id, soi_gp, soi_netprice, soi_remark, it_refcode, it_barcode, br_name, it_model, it_uom, soi_item_srp as it_srp, sb_number, sb_discount_percent, sb_gp");
 	 $this->db->from('tp_saleorder_serial');
   $this->db->join('tp_saleorder_item', 'soi_id = sos_soi_id', 'left');
   $this->db->join('tp_item_serial', 'itse_id=sos_item_serial_id', 'left');
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

 function getSaleOrder_Item($where)
 {
    $this->db->select("soi_id, soi_saleorder_id, soi_item_id, soi_item_refcode, soi_item_name, it_cost_baht, soi_item_srp, soi_qty, soi_dc_percent, soi_dc_baht, soi_sale_barcode_id, soi_gp, soi_netprice, soi_remark, it_refcode, it_barcode, br_name, it_model, it_uom, it_short_description, it_srp, sb_number, sb_discount_percent, sb_gp, so_issuedate, IF( soi_sale_barcode_id >0, sb_discount_percent, soi_dc_percent ) as dc, IF( soi_sale_barcode_id >0, sb_gp, soi_gp ) as gp, sh_code, sh_name, sh_name_eng, sn_name, sb_number, ( ((soi_item_srp*(100 - ( select dc ))/100) - soi_dc_baht )*(100 - ( select gp ))/100 ) as netprice, itse_serial_number");
	  $this->db->from('tp_saleorder_item');
    $this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
    $this->db->join('tp_saleorder_serial', 'sos_soi_id = soi_id', 'left');
    $this->db->join('tp_item', 'it_id = soi_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_shop', 'so_shop_id = sh_id','left');
    $this->db->join('tp_shop_channel', 'sn_id = sh_channel_id', 'left');
    $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
    $this->db->join('tp_item_serial', 'itse_id=sos_item_serial_id','left');
    if ($where != "") $this->db->where($where);
    $this->db->order_by('so_issuedate', 'asc');
	$query = $this->db->get();
	return $query->result();
 }

 function getSaleOrder_Item_rolex($table_join,$where_temp,$where_vat)
 {
    $this->db->select("solddate, number, it_refcode, it_model, it_short_description, itse_serial_number, it_srp, it_dc, it_netprice, cusname");
	$this->db->from("((SELECT posrot_issuedate as solddate, posrot_number as number, it_refcode, it_model, it_short_description, itse_serial_number, posroit_item_srp as it_srp, posroit_dc_baht as it_dc, posroit_netprice as it_netprice, posrot_customer_name as cusname  FROM (`tp_pos_rolex_temp_item`) LEFT JOIN `tp_pos_rolex_temp` ON `tp_pos_rolex_temp`.`posrot_id` = `tp_pos_rolex_temp_item`.`posroit_pos_rolex_temp_id` LEFT JOIN `tp_item` ON `tp_pos_rolex_temp_item`.`posroit_item_id`=`tp_item`.`it_id` LEFT JOIN `tp_item_serial` ON  `tp_pos_rolex_temp_item`.`posroit_item_serial_number_id`=`tp_item_serial`.`itse_id`".$table_join."WHERE `posrot_status` != 'V' AND `posrot_enable` = 1 AND ".$where_temp.") UNION (SELECT posro_issuedate as solddate, posro_number as number, it_refcode, it_model, it_short_description, itse_serial_number, posroi_item_srp as it_srp, posroi_dc_baht as it_dc, posroi_netprice as it_netprice, posro_customer_name as cusname  FROM (`tp_pos_rolex_item`) LEFT JOIN `tp_pos_rolex` ON `tp_pos_rolex`.`posro_id` = `tp_pos_rolex_item`.`posroi_pos_rolex_id` LEFT JOIN `tp_item` ON `tp_pos_rolex_item`.`posroi_item_id`=`tp_item`.`it_id` LEFT JOIN `tp_item_serial` ON  `tp_pos_rolex_item`.`posroi_item_serial_number_id`=`tp_item_serial`.`itse_id` WHERE `posro_status` != 'V' AND `posro_enable` = 1 AND ".$where_vat.") ) as aa");
    $this->db->order_by("solddate");
	$query = $this->db->get();
	return $query->result();
 }

 function getMaxNumber_saleorder_shop($month, $shop_id)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("so_id");
	$this->db->from('tp_saleorder');
    $this->db->where("so_dateadd >=",$start);
    $this->db->where("so_dateadd <=",$end);
    $this->db->where("so_shop_id", $shop_id);
	$query = $this->db->get();
	return $query->num_rows();
 }

 function getMaxNumber_rolex_shop($month, $shop_id)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("posro_id");
	$this->db->from('tp_pos_rolex');
    $this->db->where("posro_issuedate >=",$start);
    $this->db->where("posro_issuedate <=",$end);
    $this->db->where("posro_shop_id", $shop_id);
	$query = $this->db->get();
	return $query->num_rows();
 }

 function getMaxNumber_rolex_temp_shop($month, $shop_id)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("posrot_id");
	$this->db->from('tp_pos_rolex_temp');
    $this->db->where("posrot_issuedate >=",$start);
    $this->db->where("posrot_issuedate <=",$end);
    $this->db->where("posrot_shop_id", $shop_id);
	$query = $this->db->get();
	return $query->num_rows();
 }

 function getPOS_rolex($where)
 {
	$this->db->select("posro_id, posro_number, posro_issuedate, posro_ontop_percent, posro_ontop_baht, posro_status, posro_shop_id, sh_name, sh_code, posro_dateadd, posro_sale_person_id, posro_customer_name, posro_customer_address, posro_customer_taxid, posro_customer_passport, posro_customer_tel, posro_refund, posro_payment, posro_payment_value, posro_remark, sp_firstname as firstname, sp_lastname as lastname, sp_barcode");
	$this->db->from('tp_pos_rolex');
	//$this->db->join('list_creditcard', 'cdc_id = so_creditcard_type','left');
    $this->db->join('tp_shop', 'sh_id = posro_shop_id', 'left');
    $this->db->join('tp_sale_person', 'sp_id = posro_sale_person_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getPOS_rolex_item($where)
 {
	$this->db->select("posroi_id, posroi_pos_rolex_id, posroi_item_id, posroi_item_serial_number_id, posroi_item_srp, posroi_qty, posroi_dc_percent, posroi_dc_baht, posroi_netprice, it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_remark, it_short_description, posroi_stock_balance_id");
	$this->db->from('tp_pos_rolex_item');
    $this->db->join('tp_item', 'it_id = posroi_item_id','left');
    $this->db->join('tp_item_serial', 'itse_id = posroi_item_serial_number_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getPOS_rolex_temp($where)
 {
	$this->db->select("posrot_id, posrot_number, posrot_issuedate, posrot_ontop_percent, posrot_ontop_baht, posrot_status, posrot_shop_id, sh_name, sh_code, posrot_dateadd, posrot_sale_person_id, posrot_customer_name, posrot_customer_address, posrot_customer_tel, posrot_payment, posrot_payment_value, posrot_remark, sp_firstname as firstname, sp_lastname as lastname, sp_barcode");
	$this->db->from('tp_pos_rolex_temp');
	//$this->db->join('list_creditcard', 'cdc_id = so_creditcard_type','left');
    $this->db->join('tp_shop', 'sh_id = posrot_shop_id', 'left');
    $this->db->join('tp_sale_person', 'sp_id = posrot_sale_person_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getPOS_rolex_temp_item($where)
 {
	$this->db->select("posroit_id, posroit_pos_rolex_temp_id, posroit_item_id, posroit_item_serial_number_id, posroit_item_srp, posroit_qty, posroit_dc_percent, posroit_dc_baht, posroit_netprice, it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_remark, it_short_description, posroit_stock_balance_id");
	$this->db->from('tp_pos_rolex_temp_item');
    $this->db->join('tp_item', 'it_id = posroit_item_id','left');
    $this->db->join('tp_item_serial', 'itse_id = posroit_item_serial_number_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getPOS_rolex_temp_item_borrow($where)
 {
    $this->db->select("posroit_id, posroit_pos_rolex_temp_id, posroit_item_id, posroit_item_serial_number_id, posroit_item_srp, posroit_qty, posroit_dc_percent, posroit_dc_baht, posroit_netprice, it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_remark, it_short_description, posroit_stock_balance_id, posrob_borrower_name");
	$this->db->from('tp_pos_rolex_temp_item');
    $this->db->join('tp_item', 'it_id = posroit_item_id','left');
    $this->db->join('tp_item_serial', 'itse_id = posroit_item_serial_number_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_pos_rolex_borrow_item', 'posrobi_pos_temp_id = posroit_pos_rolex_temp_id', 'left');
    $this->db->join('tp_pos_rolex_borrow', 'posrob_id = posrobi_pos_rolex_borrow_id', 'left');
    $this->db->join('tp_pos_rolex_borrower', 'posbor_name = posrob_borrower_name', 'left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 // view product ranking
 function getTop5_qty_sale_brand($where)
 {
 	$this->db->select("it_id,it_refcode, it_model,br_name,sum(soi_qty) as sum1");
	$this->db->from('tp_saleorder_item');
	$this->db->join('tp_saleorder', 'soi_saleorder_id = so_id','left');
	$this->db->join('tp_item', 'it_id = soi_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
    $this->db->group_by("soi_item_id");
    $this->db->order_by("sum1", "desc");
    $this->db->limit(5);
	$query = $this->db->get();
	return $query->result();
 }

 function getCustomer_temp($where)
 {
    $this->db->select("posrot_customer_name, posrot_customer_address, posrot_customer_tel");
    $this->db->from('tp_pos_rolex_temp');
    if ($where != "") $this->db->where($where);
    $query = $this->db->get();
    return $query->result();
 }

 function getCustomerName_temp($where)
 {
    $this->db->select("posrot_customer_name, posrot_customer_address, posrot_customer_tel");
    $this->db->from('tp_pos_rolex_temp');
    if ($where != "") $this->db->where($where);
    $this->db->group_by("posrot_customer_name");
    $query = $this->db->get();
    return $query->result();
 }

 function getCustomer_invoice($where)
 {
    $this->db->select("posro_customer_name, posro_customer_address, posro_customer_tel, posro_customer_taxid, posro_customer_passport");
    $this->db->from('tp_pos_rolex');
    if ($where != "") $this->db->where($where);
    $query = $this->db->get();
    return $query->result();
 }

 function getCustomerName_invoice($where)
 {
    $this->db->select("posro_customer_name, posro_customer_address, posro_customer_tel, posro_customer_taxid, posro_customer_passport");
    $this->db->from('tp_pos_rolex');
    if ($where != "") $this->db->where($where);
    $this->db->group_by("posro_customer_name");
    $query = $this->db->get();
    return $query->result();
 }

 function getHistory_sale_temp($where)
 {
  	$this->db->select("posrot_customer_name, posrot_customer_tel, posroit_id, posroit_pos_rolex_temp_id, posroit_item_id, posroit_item_serial_number_id, posroit_item_srp, posroit_qty, posroit_dc_percent, posroit_dc_baht, posroit_netprice, it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_srp, it_remark, it_short_description, posroit_stock_balance_id");
  	$this->db->from('tp_pos_rolex_temp_item');
    $this->db->join('tp_pos_rolex_temp', 'posroit_pos_rolex_temp_id = posrot_id', 'left');
    $this->db->join('tp_item', 'it_id = posroit_item_id','left');
    $this->db->join('tp_item_serial', 'itse_id = posroit_item_serial_number_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
  	$query = $this->db->get();
  	return $query->result();
 }

 function getHistory_sale_invoice($where)
 {
    $this->db->select("posro_customer_name, posro_customer_tel, posroi_id, posroi_pos_rolex_id, posroi_item_id, posroi_item_serial_number_id, posroi_item_srp, posroi_qty, posroi_dc_percent, posroi_dc_baht, posroi_netprice, it_refcode, it_barcode, br_name, it_model, it_uom, itse_serial_number, it_srp, it_remark, it_short_description, posroi_stock_balance_id");
  	$this->db->from('tp_pos_rolex_item');
    $this->db->join('tp_pos_rolex', '	posroi_pos_rolex_id = posro_id', 'left');
    $this->db->join('tp_item', 'it_id = posroi_item_id','left');
    $this->db->join('tp_item_serial', 'itse_id = posroi_item_serial_number_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
  	$query = $this->db->get();
  	return $query->result();
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

function addSaleOrder_serial($insert=NULL)
{
    $this->db->insert('tp_saleorder_serial', $insert);
	return $this->db->insert_id();
}

 function addSaleBarcode($insert=NULL)
 {
	$this->db->insert('tp_sale_barcode', $insert);
	return $this->db->insert_id();
 }

 function addPOS_rolex($insert=NULL)
 {
	$this->db->insert('tp_pos_rolex', $insert);
	return $this->db->insert_id();
 }

 function addPOS_rolex_item($insert=NULL)
 {
	$this->db->insert('tp_pos_rolex_item', $insert);
	return $this->db->insert_id();
 }

 function addPOS_rolex_temp($insert=NULL)
 {
	$this->db->insert('tp_pos_rolex_temp', $insert);
	return $this->db->insert_id();
 }

 function addPOS_rolex_item_temp($insert=NULL)
 {
	$this->db->insert('tp_pos_rolex_temp_item', $insert);
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

 function editSaleOrder($edit=NULL)
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

 function editPOS_rolex($edit=NULL)
 {
	$this->db->where('posro_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_pos_rolex', $edit);
	return $query;
 }

 function editPOS_rolex_temp($edit=NULL)
 {
	$this->db->where('posrot_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_pos_rolex_temp', $edit);
	return $query;
 }

 function editPOS_rolex_temp_item($edit=NULL)
 {
	$this->db->where('posroit_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_pos_rolex_temp_item', $edit);
	return $query;
 }

}
?>
