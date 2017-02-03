<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pos_invoice extends CI_Controller {

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

function view_invoice()
{
  $inv_id = $this->uri->segment(3);
	$where = "";
	$where .= "pinv_id = '".$inv_id."'";

	$this->load->model('pos_invoice_model','',TRUE);
	$data['invoice_array'] = $this->pos_invoice_model->get_invoice($where);

	$where = "pini_pinv_id = '".$inv_id."'";
	$where .= " and pini_enable = 1";
	$data['item_array'] = $this->pos_invoice_model->get_time_item_invoice($where);

  $data['user_status'] = $this->session->userdata("sessstatus");

	$data['title'] = "Nerd - Full Invoice view";
	$this->load->view('TP/pos/view_invoice', $data);
}

function void_invoice()
{
	$invoice_id = $this->uri->segment(3);
	$invoice_temp = array("id" => $invoice_id, "pinv_status" => 'V', "pinv_enable" => 1, "pinv_updatedate" => $datetime_now, "pinv_update_by" => $user_id);

	$this->load->model('pos_invoice_model','',TRUE);
	$this->pos_invoice_model->edit_invoice($invoice_temp);

	$where = "pinv_id = '".$invoice_id."'";
	$result = $this->pos_invoice_model->get_invoice($where);
	$datetime_now = date("Y-m-d H:i:s");
  $user_id = $this->session->userdata('sessid');
	foreach($result as $loop) {
		$temp = array(
			"pinv_id" => $invoice_id,
			"pinv_updatedate" => $datetime_now,
			"pinv_update_by" => $user_id,
			"pinv_issuedate" => $loop->pinv_issuedate,
			"pinv_price_net" => $loop->pinv_price_net,
			"pinv_price_discount" => $loop->pinv_price_discount,
			"pinv_price_topup" => $loop->pinv_price_topup,
			"pinv_price_tax" => $loop->pinv_price_tax,
			"pinv_customer_id" => $loop->pinv_customer_id,
			"pinv_saleperson_id" => $loop->pinv_saleperson_id,
			"pinv_invoice_number" => $loop->pinv_invoice_number,
			"pinv_small_invoice_number" => $loop->pinv_small_invoice_number,
			"pinv_status" => 'V',
			"pinv_remark" => $loop->pinv_remark,
			"pinv_dateadd" => $loop->pinv_dateadd,
			"pinv_dateadd_by" => $loop->pinv_dateadd_by,
			"pinv_shop_id" => $loop->pinv_shop_id,
			"pinv_shop_name" => $loop->pinv_shop_name,
			"pinv_customer_name" => $loop->pinv_customer_name,
			"pinv_customer_address" => $loop->pinv_customer_address,
			"pinv_customer_taxid" => $loop->pinv_customer_taxid,
			"pinv_customer_telephone" => $loop->pinv_customer_telephone,
			"pinv_payment_id" => $loop->pinv_payment_id,
			"pinv_shop_company" => $loop->pinv_shop_company,
			"pinv_shop_address1" => $loop->pinv_shop_address1,
			"pinv_shop_address2" => $loop->pinv_shop_address2,
			"pinv_shop_telephone" => $loop->pinv_shop_telephone,
			"pinv_shop_fax" => $loop->pinv_shop_fax,
			"pinv_shop_taxid" => $loop->pinv_shop_taxid,
			"pinv_shop_branch_no" => $loop->pinv_shop_branch_no,
			"pinv_enable" => 1,
		);
	}
	$log_id = $this->pos_invoice_model->insert_log_new_invoice($temp);

	redirect('pos_invoice/view_invoice/'.$invoice_id, 'refresh');
}

function form_view_full_invoice()
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


  $data['title'] = "Nerd - Search Full Invoice";
  $this->load->view('TP/pos/form_view_full_invoice',$data);
}

function result_view_full_invoice()
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

  $data['title'] = "Nerd - Search Full Invoice";
  $this->load->view('TP/pos/result_view_full_invoice',$data);
}

function ajax_view_full_invoice()
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

  $sql_payment .= "pinv_enable = '1' and pinv_issuedate >= '".$startdate."' and pinv_issuedate <= '".$enddate."'";


  if (($brand=="0") && ($shop=="0")){
      if ($keyword[0]!="NULL") {
          if (count($keyword) < 2) {
              $sql_item .= " and pini_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_item .= " and pini_item_number like '%".$keyword[$i]."%'";
              }
          }
      }
  }else {
      if ($keyword[0]!="NULL") {
          $keyword = explode(" ",$refcode);
          if (count($keyword) < 2) {
              $sql_item .= " and pini_item_number like '%".$refcode."%'";
          }else{
              for($i=0; $i<count($keyword); $i++) {
                  $sql_item .= " and pini_item_number like '%".$keyword[$i]."%'";
              }
          }
      }else{
          $sql_item .= " and pini_item_number like '%%'";
      }

      if ($brand!="0") $sql_item .= " and br_id = '".$brand."'";
      else $sql_item .= " and br_id != '0'";

      if ($shop!="0") $sql_payment .= " and posh_id = '".$shop."'";
      else $sql_payment .= " and posh_id != '0'";

  }

  $query_item = "(select distinct pini_pinv_id as invoice_id from pos_invoice_item left join tp_brand on br_name = pini_item_brand
		where ".$sql_item.") tt";

  $this->load->library('Datatables');
  $this->datatables
  ->select("IF(pinv_status = 'V', CONCAT(pinv_invoice_number,' <button class=btnVoid>ยกเลิก(Void)</button>'), pinv_invoice_number) as number, pinv_issuedate, posh_name, CONCAT(nggu_firstname,' ',nggu_lastname) as salename,
  posc_name, pinv_price_discount, pinv_price_topup, pinv_price_tax, (pinv_price_net - pinv_price_topup) as net, pinv_id", FALSE)
  ->from($query_item)
  ->join('pos_invoice', 'invoice_id = pinv_id','left')
  ->join('pos_customer', 'posc_id = pinv_customer_id','left')
  ->join('ngg_users', 'nggu_id = pinv_saleperson_id', 'left')
  ->join('pos_shop', 'posh_id = pinv_shop_id', 'left')
  ->join('tp_shop', 'posh_shop_id = sh_id','left')
  ->where($sql_payment)
  ->edit_column("pinv_id",'<a type="button" class="btn btn-xs btn-primary" id="btnView" href="'.site_url("pos_invoice/view_invoice").'/$1'.'"><i class="fa fa-search"></i></a>',"pinv_id");
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

function print_invoice()
	{
		$inv_id = $this->uri->segment(3);
		$where = "";
		$where .= "pinv_id = '".$inv_id."' and pinv_enable = 1";

		$this->load->model('pos_invoice_model','',TRUE);
		$invoice_array = $this->pos_invoice_model->get_invoice($where);

		foreach($invoice_array as $loop) {
      $inv_id = $loop->pinv_id;
      $total_net = $loop->pinv_price_net;
      $total_topup = $loop->pinv_price_topup;
      $total_tax = $loop->pinv_price_tax;
      $inv_status = $loop->pinv_status;
      $cus_id = $loop->pinv_customer_id;
      $cus_name = $loop->pinv_customer_name;
      $cus_address = $loop->pinv_customer_address;
      $cus_taxid = $loop->pinv_customer_taxid;
      $cus_telephone = $loop->pinv_customer_telephone;
      $saleperson_number = $loop->nggu_number;
      $saleperson_name = $loop->nggu_firstname." ".$loop->nggu_lastname;
			$small_invoice_number = $loop->pinv_small_invoice_number;
      $invoice_number = $loop->pinv_invoice_number;
			$issuedate = $loop->pinv_issuedate;
			$issue_array = explode('-', $issuedate);
			$issue_array[0] += 543;
			$issuedate = $issue_array[2]."/".$issue_array[1]."/".$issue_array[0];
      $remark = $loop->pinv_remark;
      $shop_name = $loop->pinv_shop_name;
      $shop_company = $loop->pinv_shop_company;
      $shop_address1 = $loop->pinv_shop_address1;
      $shop_address2 = $loop->pinv_shop_address2;
      $shop_telephone = $loop->pinv_shop_telephone;
      $shop_fax = $loop->pinv_shop_fax;
      $shop_taxid = $loop->pinv_shop_taxid;
      $shop_branch_no = $loop->pinv_shop_branch_no;
    }

		$where = "pini_pinv_id = '".$inv_id."'";
		$where .= " and pini_enable = 1";
		$item_array = $this->pos_invoice_model->get_time_item_invoice($where);

		$this->load->library('Pdf');

		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// Add a page
		$pdf->SetFont('thsarabunpsk','', 14);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->AddPage('P', 'A4');
		$html = '
		<html><body><table border="0"><tbody><tr>
<td width="300">'.$shop_company.'<br>
'.$shop_address1.'<br/>
'.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

if ($shop_branch_no == 0) $html .= 'Head Office';
else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

$html .= '<br/>';
if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

		$html .= '</td>
<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">ต้นฉบับ</b></td></tr>
<tr><td></td><td></td></tr>

<tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
</tbody></table>
<br/><br/>
<table border="0">
<thead>
	<tr>
		<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
		<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
		<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
		<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
	</tr>
</thead><tbody>';
		// $pdf->writeHTML($html, true, false, true, false, '');


		$no = 0;
		$max_item = 6;
		$qty = 0;
    $total_page = ceil(count($item_array)/$max_item);
    $current_page = 0;
		foreach ($item_array as $loop) {
			$no++;
			if (($no != 1) && ($no % $max_item == 1)) {
        $current_page++;
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        // sum qty & total price no vat
    		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// vat
    		$html .= '<tr>
    		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// total price vat
    		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';

    		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

        $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
        <tbody>
        <tr style="">
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
        </tr>
        <tbody>
        </table>';
				$html .= '<br pagebreak="true"/>';
				$html .= '
						<html><body><table border="0"><tbody><tr>
        <td width="300">'.$shop_company.'<br>
        '.$shop_address1.'<br/>
        '.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

        if ($shop_branch_no == 0) $html .= 'Head Office';
        else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

        $html .= '<br/>';
        if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
        if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

						$html .= '</td>
				<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">ต้นฉบับ</b></td></tr>
				<tr><td></td><td></td></tr>

        <tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
        </tbody></table>
				<br/><br/>
				<table border="0">
				<thead>
					<tr>
						<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
						<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
						<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
						<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
					</tr>
				</thead><tbody>';
			}
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;">'.$no.'</td><td width="10" style="border-left:1px solid black;"></td><td width="190">'.$loop->pini_barcode.'<br/>'
				.$loop->pini_item_number."-".$loop->pini_item_name;
				if ($loop->pini_item_serial != "")	$html .= "<br>Serial : ".$loop->pini_item_serial; else $html .= "<br>";
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;">'.$loop->pini_item_qty.'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">'.number_format($loop->pini_item_srp, 2,'.',',').'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				if ($loop->pini_item_dc_baht > 0) $html .= number_format($loop->pini_item_dc_baht, 2,'.',',');
				// if ($loop->popi_item_dc_percent > 0) $html .= '<br>( '.number_format($loop->popi_item_dc_percent).'% )';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">'.number_format($loop->pini_item_net, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';



				$qty += $loop->pini_item_qty;
		}

    // discount topup
		if($total_topup > 0) {
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">ส่วนลดท้ายบิล</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">- '.number_format($total_topup, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
		}else{
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"></td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td>
				</tr>';
		}

    if ($no <= ($max_item*$total_page)) {
			for($j=$no; $j<($max_item*$total_page); $j++) {
				$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"><br><br><br></td>
				<td width="40" style="text-align:center;border-left:1px solid black;"></td><td width="85" style="text-align:center;border-left:1px solid black;">
				</td><td width="85" style="text-align:center;border-left:1px solid black;"></td><td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td></tr>';
			}
		}

    if ($total_page > 1) {
      $current_page++;
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
    }

		// sum qty & total price no vat
		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;">'.$qty.'</td>
		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup-$total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// vat
		$html .= '<tr>
		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// total price vat
		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;">&nbsp;&nbsp;('.$this->num2thai($total_net-$total_topup).')</td>
		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';

		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

    $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr style="">
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
</tr>
<tbody>
</table>';

		// COPY
		$html .= '<br pagebreak="true"/>';

		$html .= '<table border="0"><tbody><tr>
<td width="300">'.$shop_company.'<br>
'.$shop_address1.'<br/>
'.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

if ($shop_branch_no == 0) $html .= 'Head Office';
else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

$html .= '<br/>';
if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

		$html .= '</td>
<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">สำเนา</b></td></tr>
<tr><td></td><td></td></tr>

<tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
</tbody></table>
<br/><br/>
<table border="0">
<thead>
	<tr>
		<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
		<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
		<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
		<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
		<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
	</tr>
</thead><tbody>';
		// $pdf->writeHTML($html, true, false, true, false, '');


		$no = 0;
		$max_item = 6;
		$qty = 0;
    $total_page = ceil(count($item_array)/$max_item);
    $current_page = 0;
		foreach ($item_array as $loop) {
			$no++;
			if (($no != 1) && ($no % $max_item == 1)) {
        $current_page++;
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
        // sum qty & total price no vat
    		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// vat
    		$html .= '<tr>
    		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';
    		// total price vat
    		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;"></td>
    		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
    		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">&nbsp;&nbsp;&nbsp;</td>
    		</tr>';

    		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

        $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
        <tbody>
        <tr style="">
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
        <td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
        </tr>
        <tr>
        <td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
        <td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
        </tr>
        <tbody>
        </table>';
				$html .= '<br pagebreak="true"/>';
				$html .= '
						<html><body><table border="0"><tbody><tr>
        <td width="300">'.$shop_company.'<br>
        '.$shop_address1.'<br/>
        '.$shop_address2.'<br>Tax ID : '.$shop_taxid.' ';

        if ($shop_branch_no == 0) $html .= 'Head Office';
        else if ($shop_branch_no > 0) $html .= 'Branch No. '.str_pad($shop_branch_no, 5, '0', STR_PAD_LEFT);

        $html .= '<br/>';
        if ($shop_telephone != "") $html .= "Tel. ".$shop_telephone." ";
        if ($shop_fax != "") $html .= "Fax. ".$shop_fax;

						$html .= '</td>
				<td width="230" style="text-align: right;"><b style="font-size: 20pt">ใบกำกับภาษี /<br/>ใบเสร็จรับเงิน</b><br/><b style="font-size: 16pt">สำเนา</b></td></tr>
				<tr><td></td><td></td></tr>

        <tr><td width="350">นามลูกค้า : '.$cus_name.'<br>ที่อยู่ : '.$cus_address.'<br>เลขประจำตัวผู้เสียภาษี : '.$cus_taxid.'</td><td width="180">เลขที่ : '.$invoice_number.'<br>วันที่ออก : '.$issuedate.'<br>อ้างอิงใบกำกับภาษีอย่างย่อ : '.$small_invoice_number.'</td></tr>
        </tbody></table>
				<br/><br/>
				<table border="0">
				<thead>
					<tr>
						<th width="25" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">No.</th>
						<th width="200" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">รายละเอียดสินค้า</th>
						<th width="40" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวน</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">หน่วยละ</th>
						<th width="85" style="border-top:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">ส่วนลด</th>
						<th width="105" style="border-top:1px solid black;border-right:1px solid black;border-left:1px solid black;border-bottom:1px solid black;text-align:center;">จำนวนเงิน</th>
					</tr>
				</thead><tbody>';
			}
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;">'.$no.'</td><td width="10" style="border-left:1px solid black;"></td><td width="190">'.$loop->pini_barcode.'<br/>'
				.$loop->pini_item_number."-".$loop->pini_item_name;
				if ($loop->pini_item_serial != "")	$html .= "<br>Serial : ".$loop->pini_item_serial; else $html .= "<br>";
				$html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;">'.$loop->pini_item_qty.'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">'.number_format($loop->pini_item_srp, 2,'.',',').'</td>
				<td width="85" style="text-align:center;border-left:1px solid black;">';
				if ($loop->pini_item_dc_baht > 0) $html .= number_format($loop->pini_item_dc_baht, 2,'.',',');
				// if ($loop->popi_item_dc_percent > 0) $html .= '<br>( '.number_format($loop->popi_item_dc_percent).'% )';
				$html .= '</td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">'.number_format($loop->pini_item_net, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';



				$qty += $loop->pini_item_qty;
		}

    // discount topup
		if($total_topup > 0) {
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">ส่วนลดท้ายบิล</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">- '.number_format($total_topup, 2,'.',',').'&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>';
		}else{
			$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"></td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="85" style="text-align:center;border-left:1px solid black;"></td>
				<td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td>
				</tr>';
		}

    if ($no <= ($max_item*$total_page)) {
			for($j=$no; $j<($max_item*$total_page); $j++) {
				$html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190"><br><br><br></td>
				<td width="40" style="text-align:center;border-left:1px solid black;"></td><td width="85" style="text-align:center;border-left:1px solid black;">
				</td><td width="85" style="text-align:center;border-left:1px solid black;"></td><td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;"></td></tr>';
			}
		}

    if ($total_page > 1) {
      $current_page++;
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190">';
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
      $html .= '<tr><td width="25" style="text-align:center;border-left:1px solid black;"></td><td width="10" style="border-left:1px solid black;"></td><td width="190" style="text-align: center;">หน้า '.$current_page.' / '.$total_page;
      $html .= '</td><td width="40" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;"></td>
      <td width="85" style="text-align:center;border-left:1px solid black;">';
      $html .= '</td>
      <td width="105" style="text-align:right;border-left:1px solid black;border-right:1px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</td>
      </tr>';
    }

		// sum qty & total price no vat
		$html .= '<tr><td colspan="3" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จำนวน &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:center;">'.$qty.'</td>
		<td colspan="2" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">ราคาไม่รวมภาษีมูลค่าเพิ่ม &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup-$total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// vat
		$html .= '<tr>
		<td colspan="6" style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">จํานวนภาษีมูลค่าเพิ่ม 7 % &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_tax, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';
		// total price vat
		$html .= '<tr><td colspan="4" style="border-top:1px solid black;border-left:1px solid black;">&nbsp;&nbsp;('.$this->num2thai($total_net-$total_topup).')</td>
		<td colspan="2" style="border-top:1px solid black;border-right:1px solid black;text-align:right;">จํานวนเงินรวมทั้งสิ้น &nbsp;&nbsp;&nbsp;</td>
		<td style="border-top:1px solid black;border-left:1px solid black;border-right:1px solid black;text-align:right;">'.number_format($total_net-$total_topup, 2,'.',',').' &nbsp;&nbsp;&nbsp;</td>
		</tr>';

		$html .= '<tr><td colspan="7" style="border-top:1px solid black;"></td></tr></tbody></table>';

    $html .= '<table style="border-bottom:1px solid black; border-spacing:0px 0px;">
<tbody>
<tr style="">
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;">ได้รับสินค้าตามรายการถูกต้องแล้ว</td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black;"> </td>
<td width="180" align="center" style="border-left:1px solid black; border-top:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td height="30" align="center" style="border-left:1px solid black;">&nbsp;</td><td align="center" style="border-left:1px solid black;"> </td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;"> </td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">......................................</td><td align="center" style="border-left:1px solid black;">......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td><td align="center" style="border-left:1px solid black;">วันที่ / Date......................................</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black;">วันที่ / Date......................................</td>
</tr>
<tr>
<td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้รับของ / Receiver</td><td align="center" style="border-left:1px solid black; border-top:1px solid black;">ผู้ส่งของ / Delivered By</td>
<td align="center" style="border-left:1px solid black; border-right:1px solid black; border-top:1px solid black;">ผู้รับเงิน / Collector</td>
</tr>
<tbody>
</table>';

		$html .= '</body></html>';
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->IncludeJS("print();");
		$pdf->Output('Invoice_'.$invoice_number.'.pdf', 'I');

	}

	function num2thai($number){
		$t1 = array("ศูนย์", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
		$t2 = array("เอ็ด", "ยี่", "สิบ", "ร้อย", "พัน", "หมื่น", "แสน", "ล้าน");
		$zerobahtshow = 0; // ในกรณีที่มีแต่จำนวนสตางค์ เช่น 0.25 หรือ .75 จะให้แสดงคำว่า ศูนย์บาท หรือไม่ 0 = ไม่แสดง, 1 = แสดง
		(string) $number;
		$number = explode(".", $number);
		if(!empty($number[1])){
		if(strlen($number[1]) == 1){
		$number[1] .= "0";
		}else if(strlen($number[1]) > 2){
		if($number[1]{2} < 5){
		$number[1] = substr($number[1], 0, 2);
		}else{
		$number[1] = $number[1]{0}.($number[1]{1}+1);
		}
		}
		}

		for($i=0; $i<count($number); $i++){
		$countnum[$i] = strlen($number[$i]);
		if($countnum[$i] <= 7){
		$var[$i][] = $number[$i];
		}else{
		$loopround = ceil($countnum[$i]/6);
		for($j=1; $j<=$loopround; $j++){
		if($j == 1){
		$slen = 0;
		$elen = $countnum[$i]-(($loopround-1)*6);
		}else{
		$slen = $countnum[$i]-((($loopround+1)-$j)*6);
		$elen = 6;
		}
		$var[$i][] = substr($number[$i], $slen, $elen);
		}
		}

		$nstring[$i] = "";
		for($k=0; $k<count($var[$i]); $k++){
		if($k > 0) $nstring[$i] .= $t2[7];
		$val = $var[$i][$k];
		$tnstring = "";
		$countval = strlen($val);
		for($l=7; $l>=2; $l--){
		if($countval >= $l){
		$v = substr($val, -$l, 1);
		if($v > 0){
		if($l == 2 && $v == 1){
		$tnstring .= $t2[($l)];
		}elseif($l == 2 && $v == 2){
		$tnstring .= $t2[1].$t2[($l)];
		}else{
		$tnstring .= $t1[$v].$t2[($l)];
		}
		}
		}
		}
		if($countval >= 1){
		$v = substr($val, -1, 1);
		if($v > 0){
		if($v == 1 && $countval > 1 && substr($val, -2, 1) > 0){
		$tnstring .= $t2[0];
		}else{
		$tnstring .= $t1[$v];
		}

		}
		}

		$nstring[$i] .= $tnstring;
		}

		}
		$rstring = "";
		if(!empty($nstring[0]) || $zerobahtshow == 1 || empty($nstring[1])){
		if($nstring[0] == "") $nstring[0] = $t1[0];
		$rstring .= $nstring[0]."บาท";
		}
		if(count($number) == 1 || empty($nstring[1])){
		$rstring .= "ถ้วน";
		}else{
		$rstring .= $nstring[1]."สตางค์";
		}
		return $rstring;
	}

}
