<?php
Class Tp_warehouse_transfer_model extends CI_Model
{
 function getWarehouse_transfer($where)
 {
	$this->db->select("stob_id, stob_item_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_short_description, stob_qty, stob_warehouse_id, wh_name, wh_code, stob_lastupdate, stob_lastupdate_by");
	$this->db->from('tp_stock_balance');
	$this->db->join('tp_warehouse', 'wh_id = stob_warehouse_id','left');
    $this->db->join('tp_item', 'it_id = stob_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_transfer_in($where)
 {
	$this->db->select("stob_qty, stoi_number, stoi_status, stoi_has_serial, it_refcode, it_barcode, it_short_description, br_name, it_model, it_uom, it_srp, wh_name, wh_code, SUM(log_stob_qty_update) as qty_update, MIN(log_stob_old_qty) as qty_old, stoi_datein, firstname, lastname, log_stob_item_id, stoi_dateadd, stoi_remark");
	$this->db->from('log_stock_balance');
    $this->db->join('tp_item', 'it_id = log_stob_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
	$this->db->join('tp_stock_in', 'stoi_id = log_stob_transfer_id','left');
    $this->db->join('tp_warehouse', 'wh_id = stoi_warehouse_id','left');
    $this->db->join('nerd_users', 'id = stoi_dateadd_by','left');
    // view current stock available
    $this->db->join('tp_stock_balance', 'stob_warehouse_id = stoi_warehouse_id and stob_item_id = log_stob_item_id', 'left');
    if ($where != "") $this->db->where($where);
    $this->db->group_by("log_stob_item_id");
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_transfer_in_serial($where)
 {
	$this->db->select("log_stob_item_id, itse_serial_number, itse_id");
	$this->db->from('log_stock_balance');
    $this->db->join('log_stock_balance_serial', 'log_stobs_stob_id = log_stob_id','left');
    $this->db->join('tp_item_serial', 'itse_id = log_stobs_item_serial_id','left');
    $this->db->join('tp_stock_in', 'stoi_id = log_stob_transfer_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_transfer_out($where)
 {
	$this->db->select("stoo_number, it_refcode, it_barcode, it_short_description, br_name, it_model, it_uom, it_srp, wh_name, wh_code, SUM(log_stoo_qty_update) as qty_update, MIN(log_stoo_old_qty) as qty_old, stoo_datein, firstname, lastname, log_stoo_item_id, stoo_dateadd, stoo_remark");
	$this->db->from('log_stock_out');
    $this->db->join('tp_item', 'it_id = log_stoo_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
	$this->db->join('tp_stock_out', 'stoo_id = log_stoo_transfer_id','left');
    $this->db->join('tp_warehouse', 'wh_id = stoo_warehouse_id','left');
    $this->db->join('nerd_users', 'id = stoo_dateadd_by','left');
    if ($where != "") $this->db->where($where);
    $this->db->group_by("log_stoo_item_id");
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_transfer_out_serial($where)
 {
	$this->db->select("log_stoo_item_id, itse_serial_number");
	$this->db->from('log_stock_out');
    $this->db->join('log_stock_out_serial', 'log_stoos_stoo_id = log_stoo_id','left');
    $this->db->join('tp_item_serial', 'itse_id = log_stoos_item_serial_id','left');
    $this->db->join('tp_stock_out', 'stoo_id = log_stoo_transfer_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_stockin_list($where)
 {
	$this->db->select("stoi_id, stoi_status, stoi_number, stoi_has_serial, wh_name, wh_code, stoi_datein, firstname, lastname, stoi_remark, stoi_warehouse_id");
	$this->db->from('tp_stock_in');
    $this->db->join('tp_warehouse', 'wh_id = stoi_warehouse_id','inner');
    $this->db->join('nerd_users', 'id = stoi_dateadd_by','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_stockout_list($where)
 {
	$this->db->select("stoo_id, stoo_number, stoo_has_serial, wh_name, wh_code, stoo_datein, firstname, lastname");
	$this->db->from('tp_stock_out');
    $this->db->join('tp_warehouse', 'wh_id = stoo_warehouse_id','inner');
    $this->db->join('nerd_users', 'id = stoo_dateadd_by','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_transfer_list($where)
 {
	$this->db->select("stot_id, stot_number, wh1.wh_name as wh_out_name, wh1.wh_code as wh_out_code, wh2.wh_name as wh_in_name, wh2.wh_code as wh_in_code,  stot_datein, firstname, lastname, stot_status, stot_has_serial");
	$this->db->from('tp_stock_transfer');
    $this->db->join('tp_warehouse wh1', 'wh1.wh_id = stot_warehouse_out_id','inner');
    $this->db->join('tp_warehouse wh2', 'wh2.wh_id = stot_warehouse_in_id','inner');
    $this->db->join('nerd_users', 'id = stot_dateadd_by','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getBrand_transfer_list($where)
 {
    $this->db->select("br_name, SUM(log_stot_qty_final) as qty");
    $this->db->from('log_stock_transfer');
    $this->db->join('tp_item', 'it_id = log_stot_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    if ($where != "") $this->db->where($where);
    $this->db->group_by('br_id');
    $this->db->order_by('br_name');
    $query = $this->db->get();
    return $query->result();
 }

 function getWarehouse_transfer_between($where)
 {
	$this->db->select("stot_number,log_stot_item_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_has_caseback, wh1.wh_id as wh_out_id, wh1.wh_name as wh_out_name, wh1.wh_code as wh_out_code, wh2.wh_id as wh_in_id, wh2.wh_name as wh_in_name, wh2.wh_code as wh_in_code, wh2.wh_group_id as wh_in_group, SUM(log_stot_qty_want) as qty_update, stob_qty as qty_old, SUM(log_stot_qty_final) as qty_final, stot_datein, user1.firstname as firstname, user1.lastname as lastname, user2.firstname as confirm_firstname, user2.lastname as confirm_lastname, stot_status, stot_datein, log_stot_id, br_has_serial, stot_warehouse_out_id, stot_remark, stot_dateadd, stot_confirm_dateadd, br_id, it_short_description");
	$this->db->from('log_stock_transfer');
    $this->db->join('tp_item', 'it_id = log_stot_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
	$this->db->join('tp_stock_transfer', 'stot_id = log_stot_transfer_id','left');
    $this->db->join('tp_warehouse wh1', 'wh1.wh_id = stot_warehouse_out_id','inner');
    $this->db->join('tp_stock_balance', 'wh1.wh_id = stob_warehouse_id and log_stot_item_id = stob_item_id','inner');
    $this->db->join('tp_warehouse wh2', 'wh2.wh_id = stot_warehouse_in_id','inner');
    $this->db->join('nerd_users user1', 'user1.id = stot_dateadd_by','left');
    $this->db->join('nerd_users user2', 'user2.id = stot_confirm_by','left');
    if ($where != "") $this->db->where($where);
    $this->db->group_by("log_stot_item_id");
    $this->db->order_by("it_refcode");
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_transfer_between_serial($where)
 {
	$this->db->select("stot_number, log_stots_item_serial_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, wh1.wh_id as wh_out_id, wh1.wh_name as wh_out_name, wh1.wh_code as wh_out_code, wh2.wh_id as wh_in_id, wh2.wh_name as wh_in_name, wh2.wh_code as wh_in_code, SUM(log_stot_qty_want) as qty_update, MIN(log_stot_old_qty) as qty_old, SUM(log_stot_qty_final) as qty_final, stot_datein, user1.firstname as firstname, user1.lastname as lastname, user2.firstname as confirm_firstname, user2.lastname as confirm_lastname, stot_status, it_id, log_stots_id, stot_remark, stot_dateadd, stot_confirm_dateadd, br_id, it_short_description");
	$this->db->from('log_stock_transfer_serial');
    $this->db->join('log_stock_transfer', 'log_stot_id = log_stots_stot_id','left');
    $this->db->join('tp_item_serial', 'itse_id = log_stots_item_serial_id','left');
    $this->db->join('tp_item', 'it_id = itse_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
	$this->db->join('tp_stock_transfer', 'stot_id = log_stot_transfer_id','left');
    $this->db->join('tp_warehouse wh1', 'wh1.wh_id = stot_warehouse_out_id','inner');
    $this->db->join('tp_warehouse wh2', 'wh2.wh_id = stot_warehouse_in_id','inner');
    $this->db->join('nerd_users user1', 'user1.id = stot_dateadd_by','left');
    $this->db->join('nerd_users user2', 'user2.id = stot_confirm_by','left');
    if ($where != "") $this->db->where($where);
    // $this->db->where('log_stots_enable', 1);
    $this->db->group_by("itse_item_id");
    $this->db->order_by("it_refcode");
	$query = $this->db->get();
	return $query->result();
 }

 function getWarehouse_transfer_between_serial_one($where)
 {
	$this->db->select("log_stots_item_serial_id, itse_serial_number, itse_item_id, itse_sample, log_stots_id, itse_enable, stot_warehouse_out_id");
	$this->db->from('log_stock_transfer_serial');
    $this->db->join('log_stock_transfer', 'log_stot_id = log_stots_stot_id','left');
    $this->db->join('tp_stock_transfer', 'stot_id = log_stot_transfer_id','left');
    $this->db->join('tp_item_serial', 'itse_id = log_stots_item_serial_id','left');
    if ($where != "") $this->db->where($where);
    $this->db->where('log_stots_enable', 1);
	$query = $this->db->get();
	return $query->result();
 }

 function getMaxNumber_transfer_in($month, $rolex)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("stoi_id");
	$this->db->from('tp_stock_in');
    $this->db->where("stoi_dateadd >=",$start);
    $this->db->where("stoi_dateadd <=",$end);
    $this->db->where("stoi_is_rolex", $rolex);
	$query = $this->db->get();
	return $query->num_rows();
 }

 function getMaxNumber_transfer_between($month, $rolex)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("stot_id");
	$this->db->from('tp_stock_transfer');
    $this->db->where("stot_dateadd >=",$start);
    $this->db->where("stot_dateadd <=",$end);
    $this->db->where("stot_is_rolex", $rolex);
	$query = $this->db->get();
	return $query->num_rows();
 }

 function getMaxNumber_transfer_out($month, $rolex)
 {
    $start = $month."-01 00:00:00";
    $end = $month."-31 23:59:59";
    $this->db->select("stoo_id");
	  $this->db->from('tp_stock_out');
    $this->db->where("stoo_dateadd >=",$start);
    $this->db->where("stoo_dateadd <=",$end);
    $this->db->where("stoo_is_rolex", $rolex);
	  $query = $this->db->get();
	  return $query->num_rows();
 }

 function getItem_stock($where)
 {
    $this->db->select("it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, itc_name, br_name, br_code, bc_name, stob_id, stob_qty");
    $this->db->from('tp_stock_balance');
	$this->db->join('tp_item', 'it_id = stob_item_id', 'left');
	$this->db->join('tp_item_category', 'it_category_id = itc_id','left');
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getItem_stock_caseback($where)
 {
	$this->db->select("itse_id, itse_serial_number, itse_sample, it_id, it_refcode, it_barcode, it_model, it_uom, it_short_description, it_long_description, it_srp, it_cost_baht, it_picture, it_min_stock, it_remark, itc_name, br_name, br_code, bc_name, itse_warehouse_id, stob_qty, stob_id, itse_enable, itse_qms");
    $this->db->from('tp_item_serial');
	$this->db->join('tp_item', 'itse_item_id = it_id', 'left');
    $this->db->join('tp_stock_balance', 'stob_warehouse_id=itse_warehouse_id and stob_item_id=it_id', 'left');
	$this->db->join('tp_item_category', 'it_category_id = itc_id','left');
    $this->db->join('tp_brand', 'it_brand_id = br_id','left');
    $this->db->join('tp_brand_category', 'br_category_id = bc_id','left');
    if ($where != "") $this->db->where($where);
	$query = $this->db->get();
	return $query->result();
 }

 function getItem_transfer($where)
 {
    $this->db->select("stot_id, stot_datein, stot_number, it_id, it_refcode, br_name, it_model, it_cost_baht, it_short_description, it_srp, it_uom, log_stot_qty_final, CONCAT(wh1.wh_code,'-',wh1.wh_name) as wh_in, CONCAT(wh2.wh_code,'-',wh2.wh_name ) as wh_out, wh1.wh_id as wh_out_id, wh2.wh_id as wh_in_id", FALSE);
    $this->db->from('log_stock_transfer');
    $this->db->join('tp_stock_transfer', 'log_stot_transfer_id = stot_id','left');
    $this->db->join('tp_item', 'it_id = log_stot_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_warehouse wh1', 'wh1.wh_id = stot_warehouse_out_id','inner');
    $this->db->join('tp_warehouse wh2', 'wh2.wh_id = stot_warehouse_in_id','inner');
    $this->db->where('stot_enable',1);
    $this->db->where('log_stot_qty_final >',0);
    if ($where != "") $this->db->where($where);
    $this->db->order_by("it_refcode", "asc");
	$query = $this->db->get();
	return $query->result();
 }

 function getItem_transfer_in($where)
 {
    $this->db->select("stoi_id, stoi_datein, stoi_number, it_id, it_refcode, br_name, it_model, it_cost_baht, it_short_description, it_srp, it_uom, log_stob_qty_update, CONCAT(wh_code,'-',wh_name) as wh_in, wh_id", FALSE);
    $this->db->from('log_stock_balance');
    $this->db->join('tp_stock_in', 'log_stob_transfer_id = stoi_id','left');
    $this->db->join('tp_item', 'it_id = log_stob_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_warehouse', 'wh_id = log_stob_warehouse_id','left');
    $this->db->where('stoi_enable',1);
    $this->db->where('log_stob_qty_update >',0);
    if ($where != "") $this->db->where($where);
    $query = $this->db->get();
    return $query->result();
 }

 function getItem_transfer_out($where)
 {
    $this->db->select("stoo_id, stoo_datein, stoo_number, it_id, it_refcode, br_name, it_model, it_cost_baht, it_short_description, it_srp, it_uom, log_stoo_qty_update, CONCAT(wh_code,'-',wh_name) as wh_in, wh_id", FALSE);
    $this->db->from('log_stock_out');
    $this->db->join('tp_stock_out', 'log_stoo_transfer_id = stoo_id','left');
    $this->db->join('tp_item', 'it_id = log_stoo_item_id','left');
    $this->db->join('tp_brand', 'br_id = it_brand_id','left');
    $this->db->join('tp_warehouse', 'wh_id = log_stoo_warehouse_id','left');
    $this->db->where('stoo_enable',1);
    $this->db->where('log_stoo_qty_update >',0);
    if ($where != "") $this->db->where($where);
    $query = $this->db->get();
    return $query->result();
 }

 function addWarehouse_transfer($insert=NULL)
 {
	$this->db->insert('tp_stock_balance', $insert);
	return $this->db->insert_id();
 }

 function addWarehouse_transfer_in($insert=NULL)
 {
	$this->db->insert('tp_stock_in', $insert);
	return $this->db->insert_id();
 }

 function addWarehouse_transfer_between($insert=NULL)
 {
	$this->db->insert('tp_stock_transfer', $insert);
	return $this->db->insert_id();
 }

 function addWarehouse_transfer_out($insert=NULL)
 {
	$this->db->insert('tp_stock_out', $insert);
	return $this->db->insert_id();
 }

 function delWarehouse_transfer($id=NULL)
 {
	$this->db->where('stob_id', $id);
	$this->db->delete('tp_stock_balance');
 }

 function delWarehouse_transfer_in($id=NULL)
 {
	$this->db->where('stoi_id', $id);
	$this->db->delete('tp_stock_in');
 }

 function editWarehouse_transfer($edit=NULL)
 {
	$this->db->where('stob_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_stock_balance', $edit);
	return $query;
 }

 function editWarehouse_transfer_in($edit=NULL)
 {
	$this->db->where('stoi_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_stock_in', $edit);
	return $query;
 }

 function editWarehouse_transfer_between($edit=NULL)
 {
	$this->db->where('stot_id', $edit['id']);
	unset($edit['id']);
	$query = $this->db->update('tp_stock_transfer', $edit);
	return $query;
 }

}
?>
