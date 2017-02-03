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

// view sale order at POS
function form_sale_item_view()
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


  $data['title'] = "Nerd - Search POS Sold Item";
  $this->load->view('TP/pos/form_sale_item_view',$data);
}

function result_sale_item_view()
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

  $data['title'] = "Nerd - Search POS Sold Item";
  $this->load->view('TP/pos/result_sale_item_view',$data);
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
  ->select("IF(posp_status = 'V', CONCAT(posp_small_invoice_number,' <button class=btnVoid>ยกเลิก(Void)</button>'), IF(posp_status = 'T', CONCAT(posp_small_invoice_number,' <button class=btnFull>ใบกำกับภาษีแบบเต็ม</button>'),posp_small_invoice_number)) as number, posp_issuedate, posh_name, CONCAT(nggu_firstname,' ',nggu_lastname) as salename,
  posc_name, posp_price_discount, posp_price_topup, posp_price_tax, (posp_price_net - posp_price_topup) as net, posp_id", FALSE)
  ->from($query_item)
  ->join('pos_payment', 'payment_id=posp_id','left')
  ->join('pos_customer', 'posc_id = posp_customer_id','left')
  ->join('ngg_users', 'nggu_id = posp_saleperson_id', 'left')
  ->join('pos_shop', 'posh_id = posp_shop_id', 'left')
  ->join('tp_shop', 'posh_shop_id = sh_id','left')
  ->where($sql_payment)
  ->edit_column("posp_id",'<a type="button" class="btn btn-xs btn-primary" id="btnView" href="'.site_url("pos_sale/view_payment").'/$1'.'"><i class="fa fa-search"></i></a>',"posp_id");
  echo $this->datatables->generate();

}

function exportExcel_view_payment_abb()
{
  $refcode = $this->input->post("refcode");
  $keyword = explode(" ", $refcode);
  $brand = $this->input->post("brand");
  $shop = $this->input->post("shop");
  $startdate = $this->input->post("startdate");
  $enddate = $this->input->post("enddate");
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

  // $query_item = "(select distinct popi_posp_id as payment_id from pos_payment_item left join tp_brand on br_name = popi_item_brand
  //   where ".$sql_item.") tt";

  $this->load->model('pos_payment_model','',TRUE);
  $item_array = $this->pos_payment_model->get_summary_payment_abb($sql_item, $sql_payment);

  //load our new PHPExcel library
  $this->load->library('excel');
  //activate worksheet number 1
  $this->excel->setActiveSheetIndex(0);
  //name the worksheet
  $this->excel->getActiveSheet()->setTitle('Sale Report');

  $this->excel->getActiveSheet()->setCellValue('A1', 'เลขที่ใบกำกับภาษีอย่างย่อ');
  $this->excel->getActiveSheet()->setCellValue('B1', 'สถานะ');
  $this->excel->getActiveSheet()->setCellValue('C1', 'วันที่ออก');
  $this->excel->getActiveSheet()->setCellValue('D1', 'POS');
  $this->excel->getActiveSheet()->setCellValue('E1', 'พนักงานขาย');
  $this->excel->getActiveSheet()->setCellValue('F1', 'ลูกค้า');
  $this->excel->getActiveSheet()->setCellValue('G1', 'รวมส่วนลด');
  $this->excel->getActiveSheet()->setCellValue('H1', 'ส่วนลดท้ายบิล');
  $this->excel->getActiveSheet()->setCellValue('I1', 'ภาษีมูลค่าเพิ่ม');
  $this->excel->getActiveSheet()->setCellValue('J1', 'รวมยอดเงิน (รวมภาษี)');

  $row = 2;
  foreach($item_array as $loop) {
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->posp_small_invoice_number);
      if ($loop->posp_status == 'V') $status="ยกเลิก(Void)"; else if($loop->posp_status == 'T') $status="เปลี่ยนเป็นใบกำกับภาษีแบบเต็มแล้ว"; else $status = "ปกติ";
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $status);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->posp_issuedate);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->posh_name );
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->nggu_firstname." ".$loop->nggu_lastname);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->posc_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->posp_price_discount);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->posp_price_topup);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->posp_price_tax);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->net);
      $row++;
  }


  $filename='pos_invoice_abb_'.date("YmdHi").'.xlsx'; //save our workbook as this file name
  header('Content-Type: application/vnd.ms-excel'); //mime type
  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
  header('Cache-Control: max-age=0'); //no cache

  //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
  //if you want to save it as .XLSX Excel 2007 format
  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
  //force user to download the Excel file without writing it to server's HD
  $objWriter->save('php://output');
}

function print_view_payment_abb()
{
  $refcode = $this->input->post("refcode");
  $keyword = explode(" ", $refcode);
  $brand = $this->input->post("brand");
  $shop = $this->input->post("shop");
  $startdate = $this->input->post("startdate");
  $enddate = $this->input->post("enddate");

  $i = 0;
  $where = "br_id = '".$brand."'";
  $this->load->model('tp_item_model','',TRUE);
  $query = $this->tp_item_model->getBrand($where);
  foreach($query as $loop) { $i = 1; $brandname = $loop->br_name; }
  if ($i < 1) $brandname = "ทั้งหมด";

  $i = 0;
  $where = "posh_id = '".$shop."'";
  $this->load->model('pos_shop_model','',TRUE);
  $query = $this->pos_shop_model->get_shop($where);
  foreach($query as $loop) { $i = 1; $shopname = $loop->posh_name; }
  if ($i < 1) $shopname = "ทั้งหมด";

  $data['search_refcode'] = $refcode;
  $data['search_brandname'] = $brandname;
  $data['search_shopname'] = $shopname;
  $data['search_startdate'] = $startdate;
  $data['search_enddate'] = $enddate;

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

  $this->load->model('pos_payment_model','',TRUE);
  $data['item_array'] = $this->pos_payment_model->get_summary_payment_abb($sql_item, $sql_payment);


    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A4-L','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/pos/print_view_payment_abb", $data, TRUE));
    $mpdf->Output();
}

function ajax_sale_item_view()
{
  $refcode = $this->uri->segment(3);
  $keyword = explode("%20", $refcode);
  $brand = $this->uri->segment(4);
  $shop = $this->uri->segment(5);
  $startdate = $this->uri->segment(6);
  $enddate = $this->uri->segment(7);

  $sql_payment = "";
  $sql_payment .= $this->no_rolex;

  $sql_payment .= " and posp_enable = '1' and posp_status!='V' and posp_issuedate >= '".$startdate."' and posp_issuedate <= '".$enddate."'";


  if (($brand=="0") && ($shop=="0")){
      if ($keyword[0]!="NULL") {
          if (count($keyword) < 2) {
              $sql_payment .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_payment .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }
  }else {
      if ($keyword[0]!="NULL") {
          $keyword = explode(" ",$refcode);
          if (count($keyword) < 2) {
              $sql_payment .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_payment .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }else{
          $sql_payment .= " and popi_item_number like '%%'";
      }

      if ($brand!="0") $sql_payment .= " and it_brand_id = '".$brand."'";
      else $sql_payment .= " and it_brand_id != '0'";

      if ($shop!="0") $sql_payment .= " and posh_id = '".$shop."'";
      else $sql_payment .= " and posh_id != '0'";

  }

  $this->load->library('Datatables');
  if ($this->session->userdata('sessstatus') == '88') {
    $this->datatables
    ->select("posp_issuedate, CONCAT('/', posp_id, '\">', posp_small_invoice_number, '</a>') as number, posh_name, it_refcode, IF( it_refcode=it_model, '', it_model ) as model, popi_item_serial, popi_item_brand, popi_item_qty, popi_item_srp, popi_item_dc_baht, popi_item_net, it_cost_baht", FALSE)
    ->from('pos_payment_item')
    ->join('pos_payment', 'posp_id=popi_posp_id','left')
    ->join('tp_item', 'it_id = popi_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id', 'left')
    ->join('ngg_users', 'nggu_id = posp_saleperson_id', 'left')
    ->join('pos_shop', 'posh_id = posp_shop_id', 'left')
    ->join('tp_shop', 'posh_shop_id = sh_id','left')
    ->where($sql_payment)
    ->edit_column("number",'<a target="_blank"  href="'.site_url("pos_sale/view_payment").'$1',"number");
  }else{
    $this->datatables
    ->select("posp_issuedate, CONCAT('/', posp_id, '\">', posp_small_invoice_number, '</a>') as number, posh_name, it_refcode, IF( it_refcode=it_model, '', it_model ) as model, popi_item_serial, popi_item_brand, popi_item_qty, popi_item_srp, popi_item_dc_baht, popi_item_net", FALSE)
    ->from('pos_payment_item')
    ->join('pos_payment', 'posp_id=popi_posp_id','left')
    ->join('tp_item', 'it_id = popi_item_id','left')
    ->join('tp_brand', 'br_id = it_brand_id', 'left')
    ->join('ngg_users', 'nggu_id = posp_saleperson_id', 'left')
    ->join('pos_shop', 'posh_id = posp_shop_id', 'left')
    ->join('tp_shop', 'posh_shop_id = sh_id','left')
    ->where($sql_payment)
    ->edit_column("number",'<a target="_blank"  href="'.site_url("pos_sale/view_payment").'$1',"number");
  }
  echo $this->datatables->generate();
}

function exportExcel_sale_item()
{
  $refcode = $this->input->post("refcode");
  $keyword = explode(" ", $refcode);
  $brand = $this->input->post("brand");
  $shop = $this->input->post("shop");
  $startdate = $this->input->post("startdate");
  $enddate = $this->input->post("enddate");

  $sql_payment = "";
  $sql_payment .= $this->no_rolex;

  $sql_payment .= " and posp_enable = '1' and posp_status!='V' and posp_issuedate >= '".$startdate."' and posp_issuedate <= '".$enddate."'";


  if (($brand=="0") && ($shop=="0")){
      if ($keyword[0]!="NULL") {
          if (count($keyword) < 2) {
              $sql_payment .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_payment .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }
  }else {
      if ($keyword[0]!="NULL") {
          $keyword = explode(" ",$refcode);
          if (count($keyword) < 2) {
              $sql_payment .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_payment .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }else{
          $sql_payment .= " and popi_item_number like '%%'";
      }

      if ($brand!="0") $sql_payment .= " and it_brand_id = '".$brand."'";
      else $sql_payment .= " and it_brand_id != '0'";

      if ($shop!="0") $sql_payment .= " and posh_id = '".$shop."'";
      else $sql_payment .= " and posh_id != '0'";

  }

  $this->load->model('pos_payment_model','',TRUE);
  $item_array = $this->pos_payment_model->get_payment_item($sql_payment);

  //load our new PHPExcel library
  $this->load->library('excel');
  //activate worksheet number 1
  $this->excel->setActiveSheetIndex(0);
  //name the worksheet
  $this->excel->getActiveSheet()->setTitle('POS Sale Report');

  $this->excel->getActiveSheet()->setCellValue('A1', 'Sold Date');
  $this->excel->getActiveSheet()->setCellValue('B1', 'Month');
  $this->excel->getActiveSheet()->setCellValue('C1', 'Shop Code');
  $this->excel->getActiveSheet()->setCellValue('D1', 'Shop (Thai)');
  $this->excel->getActiveSheet()->setCellValue('E1', 'Shop (English)');
  $this->excel->getActiveSheet()->setCellValue('F1', 'Channel');
  $this->excel->getActiveSheet()->setCellValue('G1', 'Ref. Number');
  $this->excel->getActiveSheet()->setCellValue('H1', 'Family');
  $this->excel->getActiveSheet()->setCellValue('I1', 'Description');
  $this->excel->getActiveSheet()->setCellValue('J1', 'Caseback');
  $this->excel->getActiveSheet()->setCellValue('K1', 'Brand');
  $this->excel->getActiveSheet()->setCellValue('L1', 'Qty (Pcs.)');
  $this->excel->getActiveSheet()->setCellValue('M1', 'SRP');
  $this->excel->getActiveSheet()->setCellValue('N1', 'Discount (บาท)');
  $this->excel->getActiveSheet()->setCellValue('O1', 'Net Price');
  if ($this->session->userdata('sessstatus') == '88') { $this->excel->getActiveSheet()->setCellValue('P1', 'Cost'); }

  $row = 2;
  foreach($item_array as $loop) {
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->posp_issuedate);

      $dateValue = strtotime($loop->posp_issuedate);
      $mon = date("M", $dateValue);
      $yer = date("Y", $dateValue);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $mon."-".$yer);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->sh_code);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->posh_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->sh_name_eng);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->sn_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->it_refcode);
      if($loop->it_refcode!=$loop->it_model) $model = $loop->it_model; else $model = "";
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->it_model);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->it_short_description);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->popi_item_serial);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $loop->popi_item_brand);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $loop->popi_item_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(12, $row, $loop->popi_item_srp);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(13, $row, $loop->popi_item_dc_baht);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(14, $row, $loop->popi_item_net);
      if ($this->session->userdata('sessstatus') == '88') { $this->excel->getActiveSheet()->setCellValueByColumnAndRow(15, $row, $loop->it_cost_baht); }
      $row++;
  }


  $filename='pos_sale_report_'.date("YmdHi").'.xlsx'; //save our workbook as this file name
  header('Content-Type: application/vnd.ms-excel'); //mime type
  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
  header('Cache-Control: max-age=0'); //no cache

  //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
  //if you want to save it as .XLSX Excel 2007 format
  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
  //force user to download the Excel file without writing it to server's HD
  $objWriter->save('php://output');
}

function print_sale_item()
{
  $refcode = $this->input->post("refcode");
  $keyword = explode(" ", $refcode);
  $brand = $this->input->post("brand");
  $shop = $this->input->post("shop");
  $startdate = $this->input->post("startdate");
  $enddate = $this->input->post("enddate");

  $i = 0;
  $where = "br_id = '".$brand."'";
  $this->load->model('tp_item_model','',TRUE);
  $query = $this->tp_item_model->getBrand($where);
  foreach($query as $loop) { $i = 1; $brandname = $loop->br_name; }
  if ($i < 1) $brandname = "ทั้งหมด";

  $i = 0;
  $where = "posh_id = '".$shop."'";
  $this->load->model('pos_shop_model','',TRUE);
  $query = $this->pos_shop_model->get_shop($where);
  foreach($query as $loop) {  $i = 1; $shopname = $loop->posh_name; }
  if ($i < 1) $shopname = "ทั้งหมด";

  $data['search_refcode'] = $refcode;
  $data['search_brandname'] = $brandname;
  $data['search_shopname'] = $shopname;
  $data['search_startdate'] = $startdate;
  $data['search_enddate'] = $enddate;

  $sql_payment = "";
  $sql_payment .= $this->no_rolex;

  $sql_payment .= " and posp_enable = '1' and posp_status!='V' and posp_issuedate >= '".$startdate."' and posp_issuedate <= '".$enddate."'";


  if (($brand=="0") && ($shop=="0")){
      if ($keyword[0]!="NULL") {
          if (count($keyword) < 2) {
              $sql_payment .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_payment .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }
  }else {
      if ($keyword[0]!="NULL") {
          $keyword = explode(" ",$refcode);
          if (count($keyword) < 2) {
              $sql_payment .= " and popi_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_payment .= " and popi_item_number like '%".$keyword[$i]."%'";
              }
          }
      }else{
          $sql_payment .= " and popi_item_number like '%%'";
      }

      if ($brand!="0") $sql_payment .= " and it_brand_id = '".$brand."'";
      else $sql_payment .= " and it_brand_id != '0'";

      if ($shop!="0") $sql_payment .= " and posh_id = '".$shop."'";
      else $sql_payment .= " and posh_id != '0'";

  }

  $this->load->model('pos_payment_model','',TRUE);
  $data['item_array'] = $this->pos_payment_model->get_payment_item($sql_payment);


    $this->load->library('mpdf/mpdf');
    $mpdf= new mPDF('th','A4-L','0', 'thsaraban');
    $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

    //echo $html;
    $mpdf->SetJS('this.print();');
    $mpdf->WriteHTML($stylesheet,1);
    $mpdf->WriteHTML($this->load->view("TP/pos/print_sale_report_filter", $data, TRUE));
    $mpdf->Output();
}

function view_payment()
{
  $data['user_status'] = $this->session->userdata("sessstatus");

	$payment_id = $this->uri->segment(3);
	$where = "";
	$where .= "posp_id = '".$payment_id."'";

	$this->load->model('pos_payment_model','',TRUE);
	$payment_array = $this->pos_payment_model->get_payment($where);

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

	$where = "";
	$data['shop_array'] = $this->pos_payment_model->get_shop($where);

	$data['title'] = "Nerd - Payment view";
	$this->load->view('TP/pos/view_payment', $data);
}

function print_slip_small_invoice()
{
  $payment_id = $this->uri->segment(3);
	$where = "";
	$where .= "posp_id = '".$payment_id."' and posp_enable = 1";

	$this->load->model('pos_payment_model','',TRUE);
	$data['payment_array'] = $this->pos_payment_model->get_payment($where);

	$where = "popi_posp_id = '".$payment_id."'";
	$where .= " and popi_enable = 1";
	$data['item_array'] = $this->pos_payment_model->get_time_item_payment($where);

	$where = "";
	$data['shop_array'] = $this->pos_payment_model->get_shop($where);

	$data['title'] = "Nerd - Payment Printing";
	$this->load->view('TP/pos/slip_small_invoice', $data);
}

function void_payment()
{
	$payment_id = $this->uri->segment(3);
	$remark = $this->input->post("remarkvoid");
	$shop_id = $this->input->post("pos_shop_id");

	$where = "posp_id = '".$payment_id."'";
	$this->load->model('pos_payment_model','',TRUE);
	$result = $this->pos_payment_model->get_payment($where);
	$datetime_now = date("Y-m-d H:i:s");
	$user_id = $this->session->userdata('sessid');

	$payment_temp = array(
		"id" => $payment_id,
		"posp_status" => 'V',
		"posp_enable" => 1,
		"posp_updatedate" => $datetime_now,
		"posp_update_by" => $user_id,
		"posp_remark" => $remark,
	);

	$this->pos_payment_model->edit_payment($payment_temp);

	foreach($result as $loop) {
		$temp = array(
			"posp_id" => $payment_id,
			"posp_updatedate" => $datetime_now,
			"posp_update_by" => $user_id,
			"posp_issuedate" => $loop->posp_issuedate,
			"posp_small_invoice_number" => $loop->posp_small_invoice_number,
			"posp_price_net" => $loop->posp_price_net,
			"posp_price_discount" => $loop->posp_price_discount,
			"posp_price_topup" => $loop->posp_price_topup,
			"posp_price_tax" => $loop->posp_price_tax,
			"posp_customer_id" => $loop->posp_customer_id,
			"posp_saleperson_id" => $loop->posp_saleperson_id,
			"posp_status" => 'V',
			"posp_remark" => $remark,
			"posp_dateadd" => $loop->posp_dateadd,
			"posp_dateadd_by" => $loop->posp_dateadd_by,
			"posp_shop_id" => $loop->posp_shop_id,
			"posp_shop_name" => $loop->posp_shop_name,
			"posp_enable" => 1,
		);
	}
	$log_id = $this->pos_payment_model->insert_log_new_payment($temp);

	// ----
	// Return to stock
	// increase stock warehouse out
	$where = "posh_id = '".$shop_id."'";
	$result = $this->pos_payment_model->get_warehouse_shop($where);
	foreach ($result as $loop) { $warehouse_id = $loop->wh_id; }

	$where = "";
	$where .= "popi_posp_id = '".$payment_id."'";

	$this->load->model('pos_payment_model','',TRUE);
	$payment_array = $this->pos_payment_model->get_time_item_payment($where);
	foreach ($payment_array as $loop) {
		$item_id = $loop->popi_item_id;
		$serial_number = $loop->popi_item_serial;

		$this->load->model('tp_warehouse_transfer_model','',TRUE);
		$sql = "stob_item_id = '".$item_id."' and stob_warehouse_id = '".$warehouse_id."'";
		$query = $this->tp_warehouse_transfer_model->getWarehouse_transfer($sql);

		$qty_update = $loop->popi_item_qty;

		if (!empty($query)) {
				foreach($query as $loop) {
						$qty_new = $loop->stob_qty + $qty_update;
						$stock = array( 'id' => $loop->stob_id,
														'stob_qty' => $qty_new,
														'stob_lastupdate' => $datetime_now,
														'stob_lastupdate_by' => $user_id,
												);
						$query = $this->tp_warehouse_transfer_model->editWarehouse_transfer($stock);
						break;
				}
		}
		// edit serial
		if ($serial_number != "") {
				$where = "itse_serial_number = '".$serial_number."'";
				$this->load->model('tp_item_model','',TRUE);
				$query_serial = $this->tp_item_model->getItem_caseback($where);
				foreach($query_serial as $loop) { $serial_id = $loop->itse_id; }
				$serial_item = array( 'id' => $serial_id,
															'itse_enable' => 1,
															'itse_dateadd' => $datetime_now,
														);
				$query = $this->tp_item_model->editItemSerial($serial_item);
		}
	}






	// ----

	redirect('pos_sale/view_payment/'.$payment_id, 'refresh');
}

function view_invoice_abb_id()
{
	$payment_id = $this->uri->segment(3);
	$where = "pinv_payment_id = '".$payment_id."'";
	$this->load->model('pos_invoice_model','',TRUE);
	$invoice_array = $this->pos_invoice_model->get_invoice($where);
	foreach($invoice_array as $loop) {
		$inv_id = $loop->pinv_id;
	}
	redirect('pos_invoice/view_invoice/'.$inv_id, 'refresh');
}

function print_invoice2()
{
  $inv_id = $this->uri->segment(3);
	$where = "";
	$where .= "pinv_id = '".$inv_id."' and pinv_enable = 1";

	$this->load->model('pos_invoice_model','',TRUE);
	$data['invoice_array'] = $this->pos_invoice_model->get_invoice($where);


	$where = "pini_pinv_id = '".$inv_id."'";
	$where .= " and pini_enable = 1";
	$data['item_array'] = $this->pos_invoice_model->get_time_item_invoice($where);

  $this->load->library('mpdf/mpdf');
  $mpdf= new mPDF('th','A4','0', 'thsaraban');
  $stylesheet = file_get_contents('application/libraries/mpdf/css/style.css');

  //echo $html;
  $mpdf->SetJS('this.print();');
  $mpdf->WriteHTML($stylesheet,1);
  $mpdf->WriteHTML($this->load->view("TP/pos/print_pos_invoice", $data, TRUE));
  $mpdf->Output();
}




}
