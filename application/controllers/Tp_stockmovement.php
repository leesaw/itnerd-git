<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_stockmovement extends CI_Controller {

function __construct()
{
  parent::__construct();

  if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');

  if ($this->session->userdata('sessrolex') == 0) {
      $this->no_rolex = "br_id != 888";
      $this->shop_rolex = "wh_id != 888";
  }else{
      $this->no_rolex = "br_id = 888";
      $this->shop_rolex = "wh_id = 888";
  }
}

function index()
{

}

function form_stockmovement()
{
  $sql = "br_enable = 1";
  $this->load->model('tp_item_model','',TRUE);
  $data['brand_array'] = $this->tp_item_model->getBrand($sql);

  $sql = "wh_enable = 1";
  $this->load->model('tp_warehouse_model','',TRUE);
  $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

  $data['title'] = "NGG| Nerd - Stock Movement";
  $this->load->view('TP/stockmovement/form_stockmovement',$data);
}

function result_stockmovement()
{
  if ($this->input->post("refcode") != "")
      $data['refcode'] = $this->input->post("refcode");
  else
      $data['refcode'] = "NULL";

  if ($this->input->post("startdate") != "") {
      $data['start'] = $this->input->post("startdate");
      $start = explode('/',$this->input->post("startdate"));
      $data['start_ajax'] = $start[2]."-".$start[1]."-".$start[0];
  } else {
      $data['start'] = "";
      $data['start_ajax'] = "NULL";
  }

  if ($this->input->post("enddate") != "") {
      $data['end'] = $this->input->post("enddate");
      $end = explode('/',$this->input->post("enddate"));
      $data['end_ajax'] = $end[2]."-".$end[1]."-".$end[0];
  } else {
      $data['end'] = "";
      $data['end_ajax'] = "NULL";
  }


  $data['brandid'] = $this->input->post("brandid");
  $data['warehouse'] = $this->input->post("warehouse");

  $sql = "br_enable = 1";
  $this->load->model('tp_item_model','',TRUE);
  $data['brand_array'] = $this->tp_item_model->getBrand($sql);

  $sql = "wh_enable = 1";
  $this->load->model('tp_warehouse_model','',TRUE);
  $data['whname_array'] = $this->tp_warehouse_model->getWarehouse($sql);

  // show cost or not
  if ($this->session->userdata('sessstatus') == 6 || $this->session->userdata('sessstatus') == 1)
    $data['showcost'] = 1;
  else {
    $data['showcost'] = 0;
  }

  $data['title'] = "NGG| Nerd - Stock Movement";
  $this->load->view("TP/stockmovement/result_stockmovement", $data);
}

function ajaxView_stockmovement()
{
  $refcode = $this->uri->segment(3);
  $brandid = $this->uri->segment(4);
  $warehouse = $this->uri->segment(5);
  $startdate = $this->uri->segment(6);
  $enddate = $this->uri->segment(7);
  $showcost = $this->uri->segment(8);

  $where_out = "tp_stock_transfer.stot_enable=1";
  $where_in = "tp_stock_transfer.stot_enable=1";
  $where_stockout = "tp_stock_out.stoo_enable=1";
  $where_recieve = "tp_stock_in.stoi_enable=1";
  $where_sale = "tp_saleorder.so_enable=1";

  if ($this->session->userdata('sessstatus') != '88') {
      $where = $this->no_rolex;
  }else{ $where = "br_id != 888"; }

  if ($refcode != "NULL") {
      $where .= " and tp_item.it_refcode like '".$refcode."'";
  }

  if ($brandid > 0) {
      $where .= " and br_id = '".$brandid."'";
  }
  if ($warehouse > 0) {
      $where .= " and stob_warehouse_id = '".$warehouse."'";
  }

  $where .= " and stob_enable=1";

  if ($startdate != "NULL") {
      $start_date = $startdate." 00:00:00";
      $where_out .= " and tp_stock_transfer.stot_confirm_dateadd >= '".$start_date."'";
      $where_in .= " and tp_stock_transfer.stot_confirm_dateadd >= '".$start_date."'";
      $where_stockout .= " and tp_stock_out.stoo_dateadd >= '".$start_date."'";
      $where_recieve .= " and tp_stock_in.stoi_dateadd >= '".$start_date."'";
      $where_sale .= " and tp_saleorder.so_issuedate >= '".$startdate."'";
  }

  if ($enddate != "NULL") {
      $end_date = $enddate." 23:59:59";
      $where_out .= " and tp_stock_transfer.stot_confirm_dateadd <= '".$end_date."'";
      $where_in .= " and tp_stock_transfer.stot_confirm_dateadd <= '".$end_date."'";
      $where_stockout .= " and tp_stock_out.stoo_dateadd <= '".$end_date."'";
      $where_recieve .= " and tp_stock_in.stoi_dateadd <= '".$end_date."'";
      $where_sale .= " and tp_saleorder.so_issuedate <= '".$enddate."'";
  }else{
      $end_date = date('Y-m-d')." 23:59:59";
      $enddate = date('Y-m-d');
  }

  $nowdate = date('Y-m-d');
  $now_date = $nowdate." 23:59:59";

  $where_now_out = "tp_stock_transfer.stot_enable=1 and tp_stock_transfer.stot_confirm_dateadd > '".$end_date."' and tp_stock_transfer.stot_confirm_dateadd <= '".$now_date."'";
  $where_now_in = "tp_stock_transfer.stot_enable=1 and tp_stock_transfer.stot_confirm_dateadd > '".$end_date."' and tp_stock_transfer.stot_confirm_dateadd <= '".$now_date."'";
  $where_now_stockout = "tp_stock_out.stoo_enable=1 and tp_stock_out.stoo_dateadd > '".$end_date."' and tp_stock_out.stoo_dateadd <= '".$now_date."'";
  $where_now_recieve = "tp_stock_in.stoi_enable=1 and tp_stock_in.stoi_dateadd > '".$end_date."' and tp_stock_in.stoi_dateadd <= '".$now_date."'";
  $where_now_sale = "tp_saleorder.so_enable=1 and tp_saleorder.so_issuedate > '".$enddate."' and tp_saleorder.so_issuedate <= '".$nowdate."'";

  // current stock
  $now_sql = "( SELECT stob_warehouse_id as now_wh_id, stob_item_id as now_item_id, ( stob_qty - ifnull( now_re_sum_qty, 0 ) - ifnull( now_in_sum_qty, 0 ) + ifnull( now_sale_sum_qty, 0 ) + ifnull( now_out_sum_qty, 0 ) + ifnull( now_stockout_sum_qty, 0 ) ) as now_qty";
  $now_sql .= " from tp_stock_balance left join tp_item on it_id=stob_item_id left join tp_warehouse on wh_id=stob_warehouse_id left join tp_brand on tp_item.it_brand_id=tp_brand.br_id";
  // transfer out from warehouse
  $now_sql .= " left join ( select stot_warehouse_out_id as now_out_wh_id,log_stock_transfer.log_stot_item_id as now_out_item_id,sum(log_stock_transfer.log_stot_qty_final) as now_out_sum_qty from log_stock_transfer
  left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $now_sql .= " where ".$where_now_out;
  $now_sql .= " group by stot_warehouse_out_id,log_stot_item_id ) now_aa on it_id=now_out_item_id and stob_warehouse_id=now_out_wh_id";
  // stock out from warehouse
  $now_sql .= " left join ( SELECT log_stoo_warehouse_id as now_stockout_wh_id,log_stoo_item_id as now_stockout_item_id,sum(log_stoo_qty_update) as now_stockout_sum_qty FROM log_stock_out left join tp_stock_out on tp_stock_out.stoo_id=log_stoo_transfer_id";
  $now_sql .= " where ".$where_now_stockout;
  $now_sql .= " group by log_stoo_warehouse_id,log_stoo_item_id ) now_ee on it_id=now_stockout_item_id and stob_warehouse_id=now_stockout_wh_id";
  // transfer in warehouse
  $now_sql .= " left join ( select stot_warehouse_in_id as now_in_wh_id,log_stock_transfer.log_stot_item_id as now_in_item_id,sum(log_stock_transfer.log_stot_qty_final) as now_in_sum_qty from log_stock_transfer
  left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $now_sql .= " where ".$where_now_in;
  $now_sql .= " group by stot_warehouse_in_id,log_stot_item_id ) now_bb on it_id=now_in_item_id and stob_warehouse_id=now_in_wh_id";
  // recieve in warehouse
  $now_sql .= " left join ( SELECT log_stob_warehouse_id as now_re_wh_id,log_stob_item_id as now_re_item_id,sum(log_stob_qty_update) as now_re_sum_qty FROM log_stock_balance left join tp_stock_in on tp_stock_in.stoi_id=log_stob_transfer_id";
  $now_sql .= " where ".$where_now_recieve;
  $now_sql .= " group by log_stob_warehouse_id,log_stob_item_id ) now_cc on it_id=now_re_item_id and stob_warehouse_id=now_re_wh_id";
  // sale order warehouse
  $now_sql .= " left join ( SELECT tp_shop.sh_warehouse_id as now_sale_wh_id,tp_saleorder_item.soi_item_id as now_sale_item_id,sum(tp_saleorder_item.soi_qty) as now_sale_sum_qty FROM tp_saleorder_item left join tp_saleorder on tp_saleorder.so_id=tp_saleorder_item.soi_saleorder_id left join tp_shop on tp_saleorder.so_shop_id=tp_shop.sh_id";
  $now_sql .= " where ".$where_now_sale;
  $now_sql .= " group by tp_shop.sh_warehouse_id, tp_saleorder_item.soi_item_id ) now_dd on it_id=now_sale_item_id and stob_warehouse_id=now_sale_wh_id";
  $now_sql .= " where ".$where." ) now_stock on it_id=now_item_id and stob_warehouse_id=now_wh_id";

//  $sql = "SELECT it_refcode,br_name,it_cost_baht,wh_name,stob_qty,if(sale_sum_qty is null, 0, sale_sum_qty) as sale_qty, if(out_sum_qty is null, 0, out_sum_qty) as out_qty,if(in_sum_qty is null, 0, in_sum_qty) as in_qty, if(re_sum_qty is null, 0, re_sum_qty) as re_qty, stob_qty-re_qty";
  $sql = " tp_stock_balance left join tp_item on it_id=stob_item_id left join tp_warehouse on wh_id=stob_warehouse_id left join tp_brand on tp_item.it_brand_id=tp_brand.br_id";
// transfer out from warehouse
  $sql .= " left join ( select stot_warehouse_out_id as out_wh_id,log_stock_transfer.log_stot_item_id as out_item_id,sum(log_stock_transfer.log_stot_qty_final) as out_sum_qty from log_stock_transfer
left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $sql .= " where ".$where_out;
  $sql .= " group by stot_warehouse_out_id,log_stot_item_id ) aa on it_id=out_item_id and stob_warehouse_id=out_wh_id";
// transfer in warehouse
  $sql .= " left join ( select stot_warehouse_in_id as in_wh_id,log_stock_transfer.log_stot_item_id as in_item_id,sum(log_stock_transfer.log_stot_qty_final) as in_sum_qty from log_stock_transfer
left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $sql .= " where ".$where_in;
  $sql .= " group by stot_warehouse_in_id,log_stot_item_id ) bb on it_id=in_item_id and stob_warehouse_id=in_wh_id";
// stock out warehouse
  $sql .= " left join ( SELECT log_stoo_warehouse_id as stockout_wh_id,log_stoo_item_id as stockout_item_id,sum(log_stoo_qty_update) as stockout_sum_qty FROM log_stock_out left join tp_stock_out on tp_stock_out.stoo_id=log_stoo_transfer_id";
  $sql .= " where ".$where_stockout;
  $sql .= " group by log_stoo_warehouse_id,log_stoo_item_id ) ee on it_id=stockout_item_id and stob_warehouse_id=stockout_wh_id";
// recieve in warehouse
  $sql .= " left join ( SELECT log_stob_warehouse_id as re_wh_id,log_stob_item_id as re_item_id,sum(log_stob_qty_update) as re_sum_qty FROM log_stock_balance left join tp_stock_in on tp_stock_in.stoi_id=log_stob_transfer_id";
  $sql .= " where ".$where_recieve;
  $sql .= " group by log_stob_warehouse_id,log_stob_item_id ) cc on it_id=re_item_id and stob_warehouse_id=re_wh_id";
// sale order warehouse
  $sql .= " left join ( SELECT tp_shop.sh_warehouse_id as sale_wh_id,tp_saleorder_item.soi_item_id as sale_item_id,sum(tp_saleorder_item.soi_qty) as sale_sum_qty FROM tp_saleorder_item left join tp_saleorder on tp_saleorder.so_id=tp_saleorder_item.soi_saleorder_id left join tp_shop on tp_saleorder.so_shop_id=tp_shop.sh_id";
  $sql .= " where ".$where_sale;
  $sql .= " group by tp_shop.sh_warehouse_id, tp_saleorder_item.soi_item_id ) dd on it_id=sale_item_id and stob_warehouse_id=sale_wh_id";
// where for all
  $sql .= " left join ".$now_sql;

  if ($showcost == 1) $showcost_msg = ", it_cost_baht";
  else $showcost_msg = "";
  // view only not zero
  $where .= " and ((now_qty - ifnull(re_sum_qty, 0) - ifnull(in_sum_qty, 0) + ifnull(sale_sum_qty, 0) + ifnull(out_sum_qty, 0) + ifnull(stockout_sum_qty, 0)) > 0 or ifnull(re_sum_qty, 0) > 0 or ifnull(sale_sum_qty, 0) > 0 or ifnull(in_sum_qty, 0) > 0 or ifnull(out_sum_qty, 0) > 0 or ifnull(stockout_sum_qty, 0) > 0 or now_qty > 0)";

  $this->load->library('Datatables');
  $this->datatables
  ->select("it_refcode,br_name,it_srp,wh_name,(now_qty - ifnull(re_sum_qty, 0) - ifnull(in_sum_qty, 0) + ifnull(sale_sum_qty, 0) + ifnull(out_sum_qty, 0) + ifnull(stockout_sum_qty, 0)) as last_qty, ifnull(re_sum_qty, 0) as re_qty, ifnull(sale_sum_qty, 0) as sale_qty, ifnull(in_sum_qty, 0) as in_qty, (ifnull(out_sum_qty, 0) + ifnull(stockout_sum_qty, 0)) as out_qty, now_qty".$showcost_msg, FALSE)
  ->from($sql)
  // ->join('tp_shop sh1', 'rep_shop_id = sh1.sh_id','left')
  // ->join('tp_shop sh2', 'rep_return_shop_id = sh2.sh_id','left')
  // ->join('tp_brand', 'rep_brand_id = br_id','left')
  // ->join('nerd_users', 'rep_dateaddby = id','left')
  ->where($where);
  echo $this->datatables->generate();
}

function exportExcel_stockmovement()
{
  $refcode = $this->input->post("excel_refcode");
  $brandid = $this->input->post("excel_brandid");
  $warehouse = $this->input->post("excel_warehouse");
  $startdate = $this->input->post("excel_startdate");
  $enddate = $this->input->post("excel_enddate");
  $showcost = $this->input->post("excel_showcost");

  if ($showcost == 1) $showcost_msg = ", it_cost_baht";
  else $showcost_msg = "";

  $where_out = "tp_stock_transfer.stot_enable=1";
  $where_in = "tp_stock_transfer.stot_enable=1";
  $where_stockout = "tp_stock_out.stoo_enable=1";
  $where_recieve = "tp_stock_in.stoi_enable=1";
  $where_sale = "tp_saleorder.so_enable=1";

  if ($this->session->userdata('sessstatus') != '88') {
      $where = $this->no_rolex;
  }else{ $where = "br_id != 888"; }

  if ($refcode != "NULL") {
      $where .= " and tp_item.it_refcode like '".$refcode."'";
  }

  if ($brandid > 0) {
      $where .= " and br_id = '".$brandid."'";
  }
  if ($warehouse > 0) {
      $where .= " and stob_warehouse_id = '".$warehouse."'";
  }

  $where .= " and stob_enable=1";

  if ($startdate != "NULL") {
      $start_date = $startdate." 00:00:00";
      $where_out .= " and tp_stock_transfer.stot_confirm_dateadd >= '".$start_date."'";
      $where_in .= " and tp_stock_transfer.stot_confirm_dateadd >= '".$start_date."'";
      $where_stockout .= " and tp_stock_out.stoo_dateadd >= '".$start_date."'";
      $where_recieve .= " and tp_stock_in.stoi_dateadd >= '".$start_date."'";
      $where_sale .= " and tp_saleorder.so_issuedate >= '".$startdate."'";
  }

  if ($enddate != "NULL") {
      $end_date = $enddate." 23:59:59";
      $where_out .= " and tp_stock_transfer.stot_confirm_dateadd <= '".$end_date."'";
      $where_in .= " and tp_stock_transfer.stot_confirm_dateadd <= '".$end_date."'";
      $where_stockout .= " and tp_stock_out.stoo_dateadd <= '".$end_date."'";
      $where_recieve .= " and tp_stock_in.stoi_dateadd <= '".$end_date."'";
      $where_sale .= " and tp_saleorder.so_issuedate <= '".$enddate."'";
  }else{
      $end_date = date('Y-m-d')." 23:59:59";
      $enddate = date('Y-m-d');
  }

  $nowdate = date('Y-m-d');
  $now_date = $nowdate." 23:59:59";

  $where_now_out = "tp_stock_transfer.stot_enable=1 and tp_stock_transfer.stot_confirm_dateadd > '".$end_date."' and tp_stock_transfer.stot_confirm_dateadd <= '".$now_date."'";
  $where_now_in = "tp_stock_transfer.stot_enable=1 and tp_stock_transfer.stot_confirm_dateadd > '".$end_date."' and tp_stock_transfer.stot_confirm_dateadd <= '".$now_date."'";
  $where_now_stockout = "tp_stock_out.stoo_enable=1 and tp_stock_out.stoo_dateadd > '".$end_date."' and tp_stock_out.stoo_dateadd <= '".$now_date."'";
  $where_now_recieve = "tp_stock_in.stoi_enable=1 and tp_stock_in.stoi_dateadd > '".$end_date."' and tp_stock_in.stoi_dateadd <= '".$now_date."'";
  $where_now_sale = "tp_saleorder.so_enable=1 and tp_saleorder.so_issuedate > '".$enddate."' and tp_saleorder.so_issuedate <= '".$nowdate."'";

  // current stock
  $now_sql = "( SELECT stob_warehouse_id as now_wh_id, stob_item_id as now_item_id, ( stob_qty - ifnull( now_re_sum_qty, 0 ) - ifnull( now_in_sum_qty, 0 ) + ifnull( now_sale_sum_qty, 0 ) + ifnull( now_out_sum_qty, 0 ) + ifnull( now_stockout_sum_qty, 0 ) ) as now_qty";
  $now_sql .= " from tp_stock_balance left join tp_item on it_id=stob_item_id left join tp_warehouse on wh_id=stob_warehouse_id left join tp_brand on tp_item.it_brand_id=tp_brand.br_id";
  // transfer out from warehouse
  $now_sql .= " left join ( select stot_warehouse_out_id as now_out_wh_id,log_stock_transfer.log_stot_item_id as now_out_item_id,sum(log_stock_transfer.log_stot_qty_final) as now_out_sum_qty from log_stock_transfer
  left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $now_sql .= " where ".$where_now_out;
  $now_sql .= " group by stot_warehouse_out_id,log_stot_item_id ) now_aa on it_id=now_out_item_id and stob_warehouse_id=now_out_wh_id";
  // transfer in warehouse
  $now_sql .= " left join ( select stot_warehouse_in_id as now_in_wh_id,log_stock_transfer.log_stot_item_id as now_in_item_id,sum(log_stock_transfer.log_stot_qty_final) as now_in_sum_qty from log_stock_transfer
  left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $now_sql .= " where ".$where_now_in;
  $now_sql .= " group by stot_warehouse_in_id,log_stot_item_id ) now_bb on it_id=now_in_item_id and stob_warehouse_id=now_in_wh_id";
  // stock out from warehouse
  $now_sql .= " left join ( SELECT log_stoo_warehouse_id as now_stockout_wh_id,log_stoo_item_id as now_stockout_item_id,sum(log_stoo_qty_update) as now_stockout_sum_qty FROM log_stock_out left join tp_stock_out on tp_stock_out.stoo_id=log_stoo_transfer_id";
  $now_sql .= " where ".$where_now_stockout;
  $now_sql .= " group by log_stoo_warehouse_id,log_stoo_item_id ) now_ee on it_id=now_stockout_item_id and stob_warehouse_id=now_stockout_wh_id";
  // recieve in warehouse
  $now_sql .= " left join ( SELECT log_stob_warehouse_id as now_re_wh_id,log_stob_item_id as now_re_item_id,sum(log_stob_qty_update) as now_re_sum_qty FROM log_stock_balance left join tp_stock_in on tp_stock_in.stoi_id=log_stob_transfer_id";
  $now_sql .= " where ".$where_now_recieve;
  $now_sql .= " group by log_stob_warehouse_id,log_stob_item_id ) now_cc on it_id=now_re_item_id and stob_warehouse_id=now_re_wh_id";
  // sale order warehouse
  $now_sql .= " left join ( SELECT tp_shop.sh_warehouse_id as now_sale_wh_id,tp_saleorder_item.soi_item_id as now_sale_item_id,sum(tp_saleorder_item.soi_qty) as now_sale_sum_qty FROM tp_saleorder_item left join tp_saleorder on tp_saleorder.so_id=tp_saleorder_item.soi_saleorder_id left join tp_shop on tp_saleorder.so_shop_id=tp_shop.sh_id";
  $now_sql .= " where ".$where_now_sale;
  $now_sql .= " group by tp_shop.sh_warehouse_id, tp_saleorder_item.soi_item_id ) now_dd on it_id=now_sale_item_id and stob_warehouse_id=now_sale_wh_id";
  $now_sql .= " where ".$where." ) now_stock on it_id=now_item_id and stob_warehouse_id=now_wh_id";

  $sql = "select it_refcode,br_name,it_srp,wh_name,(now_qty - ifnull(re_sum_qty, 0) - ifnull(in_sum_qty, 0) + ifnull(sale_sum_qty, 0) + ifnull(out_sum_qty, 0) + ifnull(stockout_sum_qty, 0)) as last_qty, ifnull(re_sum_qty, 0) as re_qty, ifnull(sale_sum_qty, 0) as sale_qty, ifnull(in_sum_qty, 0) as in_qty, (ifnull(out_sum_qty, 0) + ifnull(stockout_sum_qty, 0)) as out_qty, now_qty".$showcost_msg;
  $sql .= " from tp_stock_balance left join tp_item on it_id=stob_item_id left join tp_warehouse on wh_id=stob_warehouse_id left join tp_brand on tp_item.it_brand_id=tp_brand.br_id";
// transfer out from warehouse
  $sql .= " left join ( select stot_warehouse_out_id as out_wh_id,log_stock_transfer.log_stot_item_id as out_item_id,sum(log_stock_transfer.log_stot_qty_final) as out_sum_qty from log_stock_transfer
left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $sql .= " where ".$where_out;
  $sql .= " group by stot_warehouse_out_id,log_stot_item_id ) aa on it_id=out_item_id and stob_warehouse_id=out_wh_id";
// transfer in warehouse
  $sql .= " left join ( select stot_warehouse_in_id as in_wh_id,log_stock_transfer.log_stot_item_id as in_item_id,sum(log_stock_transfer.log_stot_qty_final) as in_sum_qty from log_stock_transfer
left join tp_stock_transfer on tp_stock_transfer.stot_id=log_stock_transfer.log_stot_transfer_id";
  $sql .= " where ".$where_in;
  $sql .= " group by stot_warehouse_in_id,log_stot_item_id ) bb on it_id=in_item_id and stob_warehouse_id=in_wh_id";
// stock out warehouse
  $sql .= " left join ( SELECT log_stoo_warehouse_id as stockout_wh_id,log_stoo_item_id as stockout_item_id,sum(log_stoo_qty_update) as stockout_sum_qty FROM log_stock_out left join tp_stock_out on tp_stock_out.stoo_id=log_stoo_transfer_id";
  $sql .= " where ".$where_stockout;
  $sql .= " group by log_stoo_warehouse_id,log_stoo_item_id ) ee on it_id=stockout_item_id and stob_warehouse_id=stockout_wh_id";
// recieve in warehouse
  $sql .= " left join ( SELECT log_stob_warehouse_id as re_wh_id,log_stob_item_id as re_item_id,sum(log_stob_qty_update) as re_sum_qty FROM log_stock_balance left join tp_stock_in on tp_stock_in.stoi_id=log_stob_transfer_id";
  $sql .= " where ".$where_recieve;
  $sql .= " group by log_stob_warehouse_id,log_stob_item_id ) cc on it_id=re_item_id and stob_warehouse_id=re_wh_id";
// sale order warehouse
  $sql .= " left join ( SELECT tp_shop.sh_warehouse_id as sale_wh_id,tp_saleorder_item.soi_item_id as sale_item_id,sum(tp_saleorder_item.soi_qty) as sale_sum_qty FROM tp_saleorder_item left join tp_saleorder on tp_saleorder.so_id=tp_saleorder_item.soi_saleorder_id left join tp_shop on tp_saleorder.so_shop_id=tp_shop.sh_id";
  $sql .= " where ".$where_sale;
  $sql .= " group by tp_shop.sh_warehouse_id, tp_saleorder_item.soi_item_id ) dd on it_id=sale_item_id and stob_warehouse_id=sale_wh_id";
// where for all
// view only not zero
$where .= " and ((now_qty - ifnull(re_sum_qty, 0) - ifnull(in_sum_qty, 0) + ifnull(sale_sum_qty, 0) + ifnull(out_sum_qty, 0) + ifnull(stockout_sum_qty, 0)) > 0 or ifnull(re_sum_qty, 0) > 0 or ifnull(sale_sum_qty, 0) > 0 or ifnull(in_sum_qty, 0) > 0 or ifnull(out_sum_qty, 0) > 0 or ifnull(stockout_sum_qty, 0) > 0 or now_qty > 0)";

  $sql .= " left join ".$now_sql." where ".$where;


  $this->load->model('tp_stockmovement_model','',TRUE);
  $item_array = $this->tp_stockmovement_model->get_stockmovement($sql);

  //load our new PHPExcel library
  $this->load->library('excel');
  //activate worksheet number 1
  $this->excel->setActiveSheetIndex(0);
  //name the worksheet
  $this->excel->getActiveSheet()->setTitle('Stock_Balance');

  $this->excel->getActiveSheet()->setCellValue('A1', 'Ref. Number');
  $this->excel->getActiveSheet()->setCellValue('B1', 'ยี่ห้อ');
  $this->excel->getActiveSheet()->setCellValue('C1', 'ราคาป้าย');
  $this->excel->getActiveSheet()->setCellValue('D1', 'ชื่อคลัง');
  $this->excel->getActiveSheet()->setCellValue('E1', 'ยอดยกมา');
  $this->excel->getActiveSheet()->setCellValue('F1', 'รับเข้า');
  $this->excel->getActiveSheet()->setCellValue('G1', 'ขายออก');
  $this->excel->getActiveSheet()->setCellValue('H1', 'ย้ายเข้า');
  $this->excel->getActiveSheet()->setCellValue('I1', 'ย้ายออก');
  $this->excel->getActiveSheet()->setCellValue('J1', 'ยอดคงเหลือ');
  if ($showcost == 1) $this->excel->getActiveSheet()->setCellValue('K1', 'ราคาทุน');

  $row = 2;
  $count_last_qty = 0;
  $count_re_qty = 0;
  $count_sale_qty = 0;
  $count_in_qty = 0;
  $count_out_qty = 0;
  $count_now_qty = 0;
  foreach($item_array as $loop) {
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->it_refcode);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->br_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_srp);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->wh_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->last_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->re_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->sale_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->in_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->out_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->now_qty);

      if ($showcost == 1) $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $loop->it_cost_baht);

      $row++;
      $count_last_qty += $loop->last_qty;
      $count_re_qty += $loop->re_qty;
      $count_sale_qty += $loop->sale_qty;
      $count_in_qty += $loop->in_qty;
      $count_out_qty += $loop->out_qty;
      $count_now_qty += $loop->now_qty;
  }

  // count all qty
  $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, "ยอดรวม");
  $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $count_last_qty);
  $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $count_re_qty);
  $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $count_sale_qty);
  $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $count_in_qty);
  $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $count_out_qty);
  $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $count_now_qty);

  //--------

  $filename='stock_movement.xlsx'; //save our workbook as this file name
  header('Content-Type: application/vnd.ms-excel'); //mime type
  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
  header('Cache-Control: max-age=0'); //no cache

  //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
  //if you want to save it as .XLSX Excel 2007 format
  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
  //force user to download the Excel file without writing it to server's HD
  $objWriter->save('php://output');
}

}
?>
