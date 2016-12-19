<?php
Class Pos_invoice_model extends CI_Model
{
  function get_invoice($where)
  {
    $this->db->select('pinv_id, pinv_issuedate, pinv_price_net, pinv_price_tax, pinv_price_topup, pinv_price_discount, pinv_status, pinv_remark,
     pinv_dateadd, pinv_dateadd_by, pinv_updatedate, pinv_update_by, pinv_shop_name, pinv_enable, pinv_customer_id, posc_name, posc_address, posc_province, posc_telephone, posc_taxid,
     pinv_saleperson_id, nggu_number, nggu_firstname, nggu_lastname, pinv_shop_id, pinv_small_invoice_number, pinv_invoice_number, pinv_customer_name, pinv_customer_address,
     pinv_customer_taxid, pinv_customer_telephone, pinv_payment_id, pinv_shop_company, pinv_shop_address1, pinv_shop_address2, pinv_shop_telephone,
     pinv_shop_fax, pinv_shop_taxid, pinv_shop_branch_no');
    $this->db->from('pos_invoice');
    $this->db->join('pos_customer', 'posc_id = pinv_customer_id', 'left');
    $this->db->join('ngg_users', 'nggu_id = pinv_saleperson_id', 'left');
    $this->db->join('pos_shop', 'posh_id = pinv_shop_id', 'left');
    if ($where != "") $this->db->where($where);
    $this->db->order_by('pinv_id', 'desc');
    return $this->db->get()->result();
  }

  function get_time_item_invoice($where)
  {
    $this->db->select('pini_id, pini_pinv_id, pini_barcode, pini_item_id, pini_item_name, pini_item_number, pini_item_uom, pini_item_brand, pini_item_description,
     pini_item_srp, pini_item_dc_baht, pini_item_dc_percent, pini_item_net, pini_item_serial, pini_item_qty');
    $this->db->from('pos_invoice_item');
    //$this->db->join('time_item', 'pini_id = tiit_id', 'left');
    if ($where != "") $this->db->where($where);
    $this->db->order_by('pini_id', 'asc');
    return $this->db->get()->result();
  }

  function getMaxNumber_invoice($month, $shop)
  {
     $start = $month."-01 00:00:00";
     $end = $month."-31 23:59:59";
     $this->db->select("pinv_id");
     $this->db->from('pos_invoice');
     $this->db->where("pinv_dateadd >=",$start);
     $this->db->where("pinv_dateadd <=",$end);
     if ($shop != "") $this->db->where("pinv_shop_id", $shop);
     $query = $this->db->get();
     return $query->num_rows();
  }

  function insert_new_invoice($payment)
  {
    $this->db->insert('pos_invoice', $payment);
	  return $this->db->insert_id();
  }

  function insert_log_new_invoice($payment)
  {
    $this->db->insert('log_pos_invoice', $payment);
	  return $this->db->insert_id();
  }

  function insert_new_invoice_item($item)
  {
    $this->db->insert('pos_invoice_item', $item);
	  return $this->db->insert_id();
  }

  function edit_invoice($edit)
  {
    $this->db->where('pinv_id', $edit['id']);
    unset($edit['id']);
    $query = $this->db->update('pos_invoice', $edit);
    return $query;
  }

}
?>
