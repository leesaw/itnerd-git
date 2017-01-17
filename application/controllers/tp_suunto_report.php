<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_suunto_report extends CI_Controller {
public $brand_suunto = "";

function __construct()
{
  parent::__construct();
  if (!($this->session->userdata('sessusername')) || (($this->session->userdata('sessstatus') != 7) && ($this->session->userdata('sessstatus') != 1))) redirect('login', 'refresh');
  $this->brand_suunto = "br_id = '896'";
}

function index()
{

}

function inventory_now()
{
  $data['currentdate'] = date("d/m/Y");

  $data['title'] = "Nerd | Suunto Inventory Balance";
  $this->load->view('TP/suunto_report/view_inventory_balance',$data);
}

function ajaxView_inventory_now()
{
  $sql = $this->brand_suunto;

  $this->load->library('Datatables');
  $this->datatables
  ->select("wh_code, wh_name, it_refcode, it_short_description, it_remark, date_format(now(), '%b-%y'), stob_qty, it_srp, (stob_qty * it_srp), it_cost_baht", FALSE)
  ->from('tp_stock_balance')
  ->join('tp_warehouse', 'wh_id = stob_warehouse_id','left')
  ->join('tp_item', 'it_id = stob_item_id','left')
  ->join('tp_brand', 'br_id = it_brand_id','left')
  ->where('stob_qty >', 0)
  ->where('it_enable',1)
  ->where($sql);
  echo $this->datatables->generate();
}

function exportExcel_inventory_now()
{
  $sql = $this->brand_suunto;
  $sql .= " and stob_qty >0 and it_enable = 1";

  $now_date = date("d/m/Y");
  $now_month = date("M-y");

  $this->load->model('tp_suunto_model','',TRUE);
  $item_array = $this->tp_suunto_model->get_stock_balance($sql);

  //load our new PHPExcel library
  $this->load->library('excel');
  //activate worksheet number 1
  $this->excel->setActiveSheetIndex(0);
  //name the worksheet
  $this->excel->getActiveSheet()->setTitle('Suunto Inventory');

  $this->excel->getActiveSheet()->setCellValue('A1', 'Suunto Inventory Report');
  $this->excel->getActiveSheet()->setCellValue('C1', 'จำนวนสินค้าคงเหลือ ประจำวันที่');
  $this->excel->getActiveSheet()->setCellValue('D1', $now_date);

  $this->excel->getActiveSheet()->setCellValue('A3', 'WH Code');
  $this->excel->getActiveSheet()->setCellValue('B3', 'WH Name');
  $this->excel->getActiveSheet()->setCellValue('C3', 'Suunto Code');
  $this->excel->getActiveSheet()->setCellValue('D3', 'Description');
  $this->excel->getActiveSheet()->setCellValue('E3', 'SBU');
  $this->excel->getActiveSheet()->setCellValue('F3', 'Month');
  $this->excel->getActiveSheet()->setCellValue('G3', 'Qty');
  $this->excel->getActiveSheet()->setCellValue('H3', 'Unit Price ( Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('I3', 'Total Amount ( Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('J3', 'Landed Cost');

  $row = 4;
  foreach($item_array as $loop) {
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->wh_code);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->wh_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->it_refcode);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->it_short_description);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->it_remark);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $now_month);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->stob_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->it_srp);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, ($loop->it_srp * $loop->stob_qty));
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->it_cost_baht);
      $row++;
  }

  //--------

  $filename='suunto_inventory_'.date("YmdHis").'.xlsx'; //save our workbook as this file name
  header('Content-Type: application/vnd.ms-excel'); //mime type
  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
  header('Cache-Control: max-age=0'); //no cache

  //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
  //if you want to save it as .XLSX Excel 2007 format
  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
  //force user to download the Excel file without writing it to server's HD
  $objWriter->save('php://output');
}

function top_ten()
{
  $datein = $this->input->post("datein");
  if ($datein !="") {
      $month = explode('/',$datein);
      $currentdate = $month[1]."-".$month[0];
  }else{
      $currentdate = date("Y-m");
  }

  $currentdate = explode('-', $currentdate);
  $currentmonth = $currentdate[1]."/".$currentdate[0];

  $data['month'] = $currentmonth;

  $start = $currentdate[0]."-".$currentdate[1]."-01";
  $end = $currentdate[0]."-".$currentdate[1]."-31";

  $sql = $this->brand_suunto;
  $sql .= " and so_enable = 1 and so_issuedate >= '".$start."' and so_issuedate <= '".$end."'";

  $this->load->model('tp_suunto_model','',TRUE);
  $data['top_array'] = $this->tp_suunto_model->get_top_ten_remark($sql);

  $data['all_array'] = $this->tp_suunto_model->get_top_ten_all($sql, 0);

  $data['title'] = "Nerd | Suunto Top 10";
  $this->load->view('TP/suunto_report/view_top_ten',$data);
}

function exportExcel_top_ten()
{
  $datein = $this->input->post("datein");

  if ($datein !="") {
      $month = explode('/',$datein);
      $currentdate = $month[1]."-".$month[0];
  }else{
      $currentdate = date("Y-m");
  }

  $currentdate = explode('-', $currentdate);
  $currentmonth = $currentdate[1]."/".$currentdate[0];

  $start = $currentdate[0]."-".$currentdate[1]."-01";
  $end = $currentdate[0]."-".$currentdate[1]."-31";

  $sql = $this->brand_suunto;
  $sql .= " and so_enable = 1 and so_issuedate >= '".$start."' and so_issuedate <= '".$end."'";

  $this->load->model('tp_suunto_model','',TRUE);
  $top_array = $this->tp_suunto_model->get_top_ten_remark($sql);

  $all_array = $this->tp_suunto_model->get_top_ten_all($sql, 10);

  //load our new PHPExcel library
  $this->load->library('excel');
  //activate worksheet number 1
  $this->excel->setActiveSheetIndex(0);
  //name the worksheet
  $this->excel->getActiveSheet()->setTitle('Suunto Top 10');

  $this->excel->getActiveSheet()->setCellValue('A1', 'Suunto Top 10 Report');
  $this->excel->getActiveSheet()->setCellValue('C1', 'Top 10 ประจำเดือนที่ี่');
  $this->excel->getActiveSheet()->setCellValue('D1', $currentmonth);

  $this->excel->getActiveSheet()->setCellValue('A3', 'No.');
  $this->excel->getActiveSheet()->setCellValue('B3', 'Shop Code');
  $this->excel->getActiveSheet()->setCellValue('C3', 'Shop Name');
  $this->excel->getActiveSheet()->setCellValue('D3', 'SBU');
  $this->excel->getActiveSheet()->setCellValue('E3', 'Total Suunto');
  $this->excel->getActiveSheet()->setCellValue('G3', 'Performance');
  $this->excel->getActiveSheet()->setCellValue('I3', 'Lifestyle');
  $this->excel->getActiveSheet()->setCellValue('K3', 'Outdoor');

  $this->excel->getActiveSheet()->setCellValue('E4', 'Total Amount(Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('F4', 'Qty');
  $this->excel->getActiveSheet()->setCellValue('G4', 'Total Amount(Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('H4', 'Qty');
  $this->excel->getActiveSheet()->setCellValue('I4', 'Total Amount(Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('J4', 'Qty');
  $this->excel->getActiveSheet()->setCellValue('K4', 'Total Amount(Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('L4', 'Qty');

  $row = 5; $no = 1;
  foreach($all_array as $loop) {
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $no);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->sh_code);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->sh_name);

      $top_remark = ""; $top_price=0; $cost_performance = 0; $item_performance = 0;
      $cost_lifestyle = 0; $item_lifestyle = 0; $cost_outdoor = 0; $item_outdoor = 0;
      foreach($top_array as $loop2) {
        if ($loop2->so_shop_id == $loop->so_shop_id) {
          if ($top_price < $loop2->cost_price) {
            $top_remark = $loop2->it_remark;
            $top_price = $loop2->cost_price;
          }
          switch ($loop2->it_remark) {
            case "performance": $cost_performance = $loop2->cost_price; $item_performance = $loop2->count_item; break;
            case "lifestyle": $cost_lifestyle = $loop2->cost_price; $item_lifestyle = $loop2->count_item; break;
            case "outdoor": $cost_outdoor = $loop2->cost_price; $item_outdoor = $loop2->count_item; break;
          }
        }
      }

      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $top_remark);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->cost_price);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->count_item);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $cost_performance);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $item_performance);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $cost_lifestyle);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $item_lifestyle);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $cost_outdoor);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $item_outdoor);

      $row++;
      $no++;
  }

  //--------

  $filename='suunto_top10_'.date("YmdHis").'.xlsx'; //save our workbook as this file name
  header('Content-Type: application/vnd.ms-excel'); //mime type
  header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
  header('Cache-Control: max-age=0'); //no cache

  //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
  //if you want to save it as .XLSX Excel 2007 format
  $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
  //force user to download the Excel file without writing it to server's HD
  $objWriter->save('php://output');
}

function sale_kpi()
{
  $datein = $this->input->post("datein");
  if ($datein !="") {
      $month = explode('/',$datein);
      $currentdate = $month[1]."-".$month[0];
  }else{
      $currentdate = date("Y-m");
  }

  $currentdate = explode('-', $currentdate);
  $currentmonth = $currentdate[1]."/".$currentdate[0];
  $data['ajax_month'] = $currentdate[0]."-".$currentdate[1];
  $data['month'] = $currentmonth;


  $data['title'] = "Nerd | Suunto Sale KPI";
  $this->load->view('TP/suunto_report/view_sale_kpi',$data);
}

function ajaxView_sale_kpi()
{
  $month = $this->uri->segment(3);
  $start = $month."-01";
  $end = $month."-31";

  $sql = $this->brand_suunto;
  $sql .= " and so_enable = 1 and so_issuedate >= '".$start."' and so_issuedate <= '".$end."'";

  $sql_payment = $this->brand_suunto;

  $sql_payment .= " and posp_enable = '1' and posp_status!='V' and posp_issuedate >= '".$start."' and posp_issuedate <= '".$end."'";

  $this->load->library('Datatables');
  $this->datatables
  ->select("sh_code, sh_name, sc_remark,  date_format(so_issuedate, '%d/%m/%y'), it_refcode, it_short_description, it_remark, it_cost_baht, soi_qty, soi_item_srp, (soi_qty*soi_item_srp), date_format(so_issuedate, '%b-%y')", FALSE)
  ->from('(( SELECT sh_code, sh_name, sc_remark, so_issuedate, it_refcode, it_short_description, it_remark, it_cost_baht, soi_qty, soi_item_srp FROM tp_saleorder_item
  LEFT JOIN tp_saleorder ON so_id = soi_saleorder_id LEFT JOIN tp_item ON it_id = soi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN tp_shop ON so_shop_id = sh_id
  LEFT JOIN tp_shop_category ON sh_category_id = sc_id WHERE '.$sql.' ) UNION
  (SELECT sh_code, sh_name, sc_remark, posp_issuedate as so_issuedate, it_refcode, it_short_description, it_remark, it_cost_baht, popi_item_qty as soi_qty, popi_item_srp as soi_item_srp FROM
  pos_payment_item LEFT JOIN pos_payment ON posp_id=popi_posp_id LEFT JOIN tp_item ON it_id = popi_item_id LEFT JOIN tp_brand ON br_id = it_brand_id LEFT JOIN ngg_users ON nggu_id = posp_saleperson_id
  LEFT JOIN pos_shop ON posh_id = posp_shop_id LEFT JOIN tp_shop ON posh_shop_id = sh_id LEFT JOIN tp_shop_category ON sh_category_id = sc_id
  WHERE '.$sql_payment.'
   )) as aa');
  echo $this->datatables->generate();

}

function exportExcel_sale_kpi()
{
  $datein = $this->input->post("datein");

  if ($datein !="") {
      $month = explode('/',$datein);
      $currentdate = $month[1]."-".$month[0];
  }else{
      $currentdate = date("Y-m");
  }

  $currentdate = explode('-', $currentdate);
  $currentmonth = $currentdate[1]."/".$currentdate[0];

  $start = $currentdate[0]."-".$currentdate[1]."-01";
  $end = $currentdate[0]."-".$currentdate[1]."-31";

  $sql = $this->brand_suunto;
  $sql .= " and so_enable = 1 and so_issuedate >= '".$start."' and so_issuedate <= '".$end."'";

  $sql_payment = $this->brand_suunto;

  $sql_payment .= " and posp_enable = '1' and posp_status!='V' and posp_issuedate >= '".$start."' and posp_issuedate <= '".$end."'";

  $this->load->model('tp_suunto_model','',TRUE);
  $sale_array = $this->tp_suunto_model->get_saleorder_item($sql, $sql_payment);

  //load our new PHPExcel library
  $this->load->library('excel');
  //activate worksheet number 1
  $this->excel->setActiveSheetIndex(0);
  //name the worksheet
  $this->excel->getActiveSheet()->setTitle('Suunto Sale KPI');

  $this->excel->getActiveSheet()->setCellValue('A1', 'Suunto Sale Report');
  $this->excel->getActiveSheet()->setCellValue('C1', 'ประจำเดือนที่ี่');
  $this->excel->getActiveSheet()->setCellValue('D1', $currentmonth);

  $this->excel->getActiveSheet()->setCellValue('A3', 'Shop Code');
  $this->excel->getActiveSheet()->setCellValue('B3', 'Shop Name');
  $this->excel->getActiveSheet()->setCellValue('C3', 'Channel');
  $this->excel->getActiveSheet()->setCellValue('D3', 'Issue Date');
  $this->excel->getActiveSheet()->setCellValue('E3', 'Suunto Code');
  $this->excel->getActiveSheet()->setCellValue('F3', 'Description');
  $this->excel->getActiveSheet()->setCellValue('G3', 'SBU');
  $this->excel->getActiveSheet()->setCellValue('H3', 'Landed Cost (Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('I3', 'Qty');
  $this->excel->getActiveSheet()->setCellValue('J3', 'Selling Price (Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('K3', 'Total Amount (Local Currency)');
  $this->excel->getActiveSheet()->setCellValue('L3', 'Month');

  $row = 5;
  foreach($sale_array as $loop) {
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(0, $row, $loop->sh_code);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(1, $row, $loop->sh_name);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(2, $row, $loop->sc_remark);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(3, $row, $loop->issuedate);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(4, $row, $loop->it_refcode);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(5, $row, $loop->it_short_description);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(6, $row, $loop->it_remark);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(7, $row, $loop->it_cost_baht);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(8, $row, $loop->soi_qty);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(9, $row, $loop->soi_item_srp);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(10, $row, $loop->total);
      $this->excel->getActiveSheet()->setCellValueByColumnAndRow(11, $row, $loop->month);
      $row++;
  }

  //--------

  $filename='suunto_saleKPI_'.date("YmdHis").'.xlsx'; //save our workbook as this file name
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
