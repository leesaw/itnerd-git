<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tp_suunto_report extends CI_Controller {
public $brand_suunto = "";

function __construct()
{
  parent::__construct();
  if (!($this->session->userdata('sessusername')) || ($this->session->userdata('sessstatus') != 7)) redirect('login', 'refresh');
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

  $data['all_array'] = $this->tp_suunto_model->get_top_ten_all($sql);

  $data['title'] = "Nerd | Suunto Top 10";
  $this->load->view('TP/suunto_report/view_top_ten',$data);
}

}
?>
