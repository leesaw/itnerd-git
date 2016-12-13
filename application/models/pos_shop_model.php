<?php
Class Pos_shop_model extends CI_Model
{
  function get_shop($where)
  {
    $this->db->select('posh_shop_id, posh_id, posh_name, posh_address1, posh_address2, posh_telephone, posh_fax, posh_taxid, posh_company, posh_branch_no, posh_print_tax, posh_enable');
    $this->db->from('pos_shop');
    if ($where != "") $this->db->where($where);
    $this->db->order_by('posh_name', 'asc');
    return $this->db->get()->result();
  }

  function get_warehouse_shop($where)
  {
    $this->db->select('wh_id, wh_name, posh_id, posh_name, sh_id, sh_name');
    $this->db->from('pos_shop');
    $this->db->join('tp_shop', 'sh_id = posh_shop_id');
    $this->db->join('tp_warehouse', 'wh_id = 	sh_warehouse_id');
    if ($where != "") $this->db->where($where);
    return $this->db->get()->result();
  }

}
?>
