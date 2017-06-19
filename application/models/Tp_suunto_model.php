<?php
Class Tp_suunto_model extends CI_Model
{

function get_stock_balance($where)
{
  $this->db->select("stob_id, stob_item_id, it_refcode, it_barcode, br_name, it_model, it_uom, it_srp, it_cost_baht, it_short_description, it_remark, stob_qty, stob_warehouse_id, wh_name, wh_name_eng, wh_code, stob_lastupdate, stob_lastupdate_by");
  $this->db->from('tp_stock_balance');
  $this->db->join('tp_warehouse', 'wh_id = stob_warehouse_id','left');
  $this->db->join('tp_item', 'it_id = stob_item_id','left');
  $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  if ($where != "") $this->db->where($where);
  $this->db->order_by('wh_code');
  $query = $this->db->get();
  return $query->result();
}

function get_top_ten_remark($where1, $where2)
{
  // $this->db->select("so_shop_id,sh_code,sh_name,it_remark, sum(it_cost_baht) as cost_price, count(soi_item_id) as count_item");

  $this->db->select("sh_id,sh_code,sh_name, it_remark, sum(cost_price) as cost_price, count(count_item) as count_item");
  $this->db->from('(( SELECT sh_id, sh_code, sh_name, it_remark, it_cost_baht as cost_price, soi_item_id as count_item FROM tp_saleorder_item
  LEFT JOIN tp_saleorder ON so_id = soi_saleorder_id LEFT JOIN tp_item ON it_id = soi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN tp_shop ON so_shop_id = sh_id
  LEFT JOIN tp_shop_category ON sh_category_id = sc_id LEFT JOIN tp_shop_channel ON sh_channel_id = sn_id WHERE '.$where1.' ) UNION ALL
  (SELECT sh_id, sh_code, sh_name, it_remark, it_cost_baht as cost_price, popi_item_qty as count_item FROM
  pos_payment_item LEFT JOIN pos_payment ON posp_id=popi_posp_id LEFT JOIN tp_item ON it_id = popi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN ngg_users ON nggu_id = posp_saleperson_id
  LEFT JOIN pos_shop ON posh_id = posp_shop_id LEFT JOIN tp_shop ON posh_shop_id = sh_id LEFT JOIN tp_shop_category ON sh_category_id = sc_id LEFT JOIN tp_shop_channel ON sh_channel_id = sn_id
  WHERE '.$where2.'
   )) as aa');

  // $this->db->from('tp_saleorder_item');
  // $this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
  // $this->db->join('tp_item', 'it_id = soi_item_id','left');
  // $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  // $this->db->join('tp_shop', 'so_shop_id = sh_id','left');
  // $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');
  // if ($where != "") $this->db->where($where);
  $this->db->group_by("it_remark,sh_id");
  $query = $this->db->get();
  return $query->result();
}

function get_top_ten_all($where1, $where2, $limit)
{
  // $this->db->select("so_shop_id,sh_code,sh_name, sum(it_cost_baht) as cost_price, count(soi_item_id) as count_item");
  // $this->db->from('tp_saleorder_item');
  // $this->db->join('tp_saleorder', 'so_id = soi_saleorder_id','left');
  // $this->db->join('tp_item', 'it_id = soi_item_id','left');
  // $this->db->join('tp_brand', 'br_id = it_brand_id','left');
  // $this->db->join('tp_shop', 'so_shop_id = sh_id','left');
  // $this->db->join('tp_sale_barcode', 'sb_id = soi_sale_barcode_id','left');

  $this->db->select("sh_id,sh_code,sh_name, sum(cost_price) as cost_price, count(count_item) as count_item");
  $this->db->from('(( SELECT sh_id, sh_code, sh_name, it_cost_baht as cost_price, soi_item_id as count_item FROM tp_saleorder_item
  LEFT JOIN tp_saleorder ON so_id = soi_saleorder_id LEFT JOIN tp_item ON it_id = soi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN tp_shop ON so_shop_id = sh_id
  LEFT JOIN tp_shop_category ON sh_category_id = sc_id LEFT JOIN tp_shop_channel ON sh_channel_id = sn_id WHERE '.$where1.' ) UNION ALL
  (SELECT sh_id, sh_code, sh_name, it_cost_baht as cost_price, popi_item_qty as count_item FROM
  pos_payment_item LEFT JOIN pos_payment ON posp_id=popi_posp_id LEFT JOIN tp_item ON it_id = popi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN ngg_users ON nggu_id = posp_saleperson_id
  LEFT JOIN pos_shop ON posh_id = posp_shop_id LEFT JOIN tp_shop ON posh_shop_id = sh_id LEFT JOIN tp_shop_category ON sh_category_id = sc_id LEFT JOIN tp_shop_channel ON sh_channel_id = sn_id
  WHERE '.$where2.'
   )) as aa');
  $this->db->group_by("sh_id");
  $this->db->order_by("cost_price", "desc");
  if ($limit > 0) $this->db->limit($limit);
  $query = $this->db->get();
  return $query->result();
}

function get_saleorder_item($where1, $where2)
{
  $this->db->select("sh_code, sh_name, sh_name_eng, sn_name,  date_format(so_issuedate, '%d/%m/%y') as issuedate, it_refcode, it_short_description, it_remark, it_cost_baht, soi_qty, soi_item_srp, (soi_qty*soi_item_srp) as total, date_format(so_issuedate, '%b-%y') as month", FALSE);
  $this->db->from('(( SELECT sh_code, sh_name, sh_name_eng, sn_name, so_issuedate, it_refcode, it_short_description, it_remark, it_cost_baht, soi_qty, soi_item_srp FROM tp_saleorder_item
  LEFT JOIN tp_saleorder ON so_id = soi_saleorder_id LEFT JOIN tp_item ON it_id = soi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN tp_shop ON so_shop_id = sh_id
  LEFT JOIN tp_shop_category ON sh_category_id = sc_id LEFT JOIN tp_shop_channel ON sh_channel_id = sn_id WHERE '.$where1.' ) UNION ALL
  (SELECT sh_code, sh_name, sh_name_eng, sn_name, posp_issuedate as so_issuedate, it_refcode, it_short_description, it_remark, it_cost_baht, popi_item_qty as soi_qty, popi_item_srp as soi_item_srp FROM
  pos_payment_item LEFT JOIN pos_payment ON posp_id=popi_posp_id LEFT JOIN tp_item ON it_id = popi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN ngg_users ON nggu_id = posp_saleperson_id
  LEFT JOIN pos_shop ON posh_id = posp_shop_id LEFT JOIN tp_shop ON posh_shop_id = sh_id LEFT JOIN tp_shop_category ON sh_category_id = sc_id LEFT JOIN tp_shop_channel ON sh_channel_id = sn_id
  WHERE '.$where2.'
   )) as aa');
  $this->db->order_by('sh_code', 'asc');
  $query = $this->db->get();
  return $query->result();
}

}
?>
