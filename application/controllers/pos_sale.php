<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_sale extends CI_Controller {

function __construct()
{
     parent::__construct();
     if (!($this->session->userdata('sessusername'))) redirect('login', 'refresh');
     $this->no_rolex = "br_id != 888";
     $this->shop_rolex = "sh_id != 888";
}

function index()
{

}

function form_view_payment_abb()
{
  $this->load->model('tp_item_model','',TRUE);
  $this->load->model('pos_shop_model','',TRUE);

  $sql = "";

  $sql .= $this->no_rolex;
  $query = $this->tp_item_model->getBrand($sql);
  $data['brand_array'] = $query;
  //$sql = "sh_enable = '1'";
  $sql = "";
  $data['shop_array'] = $this->pos_shop_model->get_shop($sql);


  $data['title'] = "Nerd - Search Invoice ABB";
  $this->load->view('TP/pos/form_view_payment_abb',$data);
}

function result_view_payment_abb()
{
  $refcode = $this->input->post("refcode");
  $brand = $this->input->post("brand");
  $shop = $this->input->post("shop");

  if ($refcode == "") $refcode = "NULL";
  $data['refcode'] = $refcode;

  $brand_array = explode("-", $brand);
  $brand_code = $brand_array[0];
  $brand_name = $brand_array[1];
  $data['brand_id'] = $brand_code;
  $data['brand_name'] = $brand_name;

  $shop_array = explode("-", $shop);
  $shop_code = $shop_array[0];
  $shop_name = $shop_array[1];
  $data['shop_id'] = $shop_code;
  $data['shop_name'] = $shop_name;



  $start = $this->input->post("startdate");
  if ($start != "") {
      $start = explode('/', $start);
      $start= $start[2]."-".$start[1]."-".$start[0];
  }else{
      $start = "1970-01-01";
  }
  $end = $this->input->post("enddate");
  if ($end != "") {
      $end = explode('/', $end);
      $end= $end[2]."-".$end[1]."-".$end[0];
  }else{
      $end = date('Y-m-d');
  }

  $data['startdate'] = $start;
  $data['enddate'] = $end;

  $data['user_status'] = $this->session->userdata("sessstatus");

  $data['title'] = "Nerd - Search Invoice ABB";
  $this->load->view('TP/pos/result_view_payment_abb',$data);
}

function ajax_view_payment_abb()
{
  $refcode = $this->uri->segment(3);
  $keyword = explode("%20", $refcode);
  $brand = $this->uri->segment(4);
  $shop = $this->uri->segment(5);
  $startdate = $this->uri->segment(6);
  $enddate = $this->uri->segment(7);

  $sql_item = "";
  $sql_payment = "";
  $sql_item .= $this->no_rolex;

  $sql_payment .= "posp_enable = '1' and posp_issuedate >= '".$startdate."' and posp_issuedate <= '".$enddate."'";


  if (($brand=="0") && ($shop=="0")){
      if ($keyword[0]!="NULL") {
          if (count($keyword) < 2) {
              $sql_item .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_item .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }
  }else {
      if ($keyword[0]!="NULL") {
          $keyword = explode(" ",$refcode);
          if (count($keyword) < 2) {
              $sql_item .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_item .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }else{
          $sql_item .= " and popi_item_number like '%%'";
      }

      if ($brand!="0") $sql_item .= " and br_id = '".$brand."'";
      else $sql_item .= " and br_id != '0'";

      if ($shop!="0") $sql_payment .= " and posh_id = '".$shop."'";
      else $sql_payment .= " and posh_id != '0'";

  }

  $query_item = "(select distinct popi_posp_id as payment_id from pos_payment_item left join tp_brand on br_name = popi_item_brand
		where ".$sql_item.") tt";

  $this->load->library('Datatables');
  $this->datatables
  ->select("posp_small_invoice_number, posp_issuedate, posh_name, CONCAT(nggu_firstname,' ',nggu_lastname) as salename,
  posc_name, posp_price_discount, posp_price_topup, posp_price_tax, posp_price_net, posp_id", FALSE)
  ->from($query_item)
  ->join('pos_payment', 'payment_id=posp_id','left')
  ->join('pos_customer', 'posc_id = posp_customer_id','left')
  ->join('ngg_users', 'nggu_id = posp_saleperson_id', 'left')
  ->join('pos_shop', 'posh_id = posp_shop_id', 'left')
  ->join('tp_shop', 'posh_shop_id = sh_id','left')
  ->where($sql_payment)
  ->edit_column("posp_id",'<a type="button" class="btn btn-xs btn-primary" id="btnView" href="'.site_url("pos_sale/view_payment").'$1'.'"><i class="fa fa-search"></i></a>',"posp_id");
  echo $this->datatables->generate();

}

function view_payment()
{
	$payment_id = $this->uri->segment(3);
	$shop_id = $this->session->userdata('sessshopid');
	$where = "";
	$where .= "posp_id = '".$payment_id."' and posp_shop_id = '".$shop_id."'";

	$this->load->model('pos_payment_model','',TRUE);
	$payment_array = $this->pos_payment_model->get_payment($where);

	if (count($payment_array) < 1) redirect('pos_error', 'refresh');

	$data['payment_array'] = $payment_array;

	$where = "popi_posp_id = '".$payment_id."'";
	$where .= " and popi_enable = 1";
	$data['item_array'] = $this->pos_payment_model->get_time_item_payment($where);

	$where = "paid_payment_id = '".$payment_id."'";
	$where .= " and paid_enable = 1";
	$data['paid_array'] = $this->pos_payment_model->get_paid_payment($where);

	$where = "pinv_payment_id = '".$payment_id."' and pinv_enable = 1";
  $this->load->model('pos_invoice_model','',TRUE);
  $check_payment = $this->pos_invoice_model->get_invoice($where);
  $had_payment = 0;
  foreach($check_payment as $loop) {
    $had_payment = $loop->pinv_id;
  }
	$data['had_payment'] = $had_payment;


	$this->load->model('shop_model','',TRUE);
	$where = "posh_id = '".$shop_id."'";
	$data['shop_array'] = $this->shop_model->get_shop($where);

	$data['title'] = programname.version." - Payment view";
	$data['content_header'] = "นาฬิกา > สั่งขาย > รายละเอียดการขาย";
	$this->load->view('POS/time/main_time_view_payment', $data);
}

}
